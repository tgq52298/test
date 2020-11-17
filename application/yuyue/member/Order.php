<?php
namespace app\yuyue\member;

use app\common\controller\member\Order AS _Order;
use app\yuyue\model\Content;
use app\yuyue\model\Order AS OrderModel;

class Order extends _Order
{    
    public function show($id){
        $info = $this->model->getInfo($id);        
        if ($info['uid']!=$this->user['uid']) {
            $this->error('你没权限');
        }
        //这里只考虑一个订单只有一个商品的情况
        $info = get_order_totalmoney($info['shop_db'][0],$info);    //统计成团后随人数增加,价格下降的情况
        $code_img = get_qrcode (murl('kehu_order/show',['id'=>$id]).'?pwd='.mymd5($id."\t".time()) );   //核销码
        $this->assign('code_img',$code_img);
        $this->assign('info',$info);
        return $this->fetch();
    }
    
    /**
     * 支付余款
     * 在微信端,就用微信支付,否则就用支付宝支付
     * @param number $id 订单ID
     * @param number $havepay 1代表进入付款界面之后,再跳转回来的, 有可能支付成功,也有可能支付失败或放弃支付
     * @param number $ispay 进入付款界面之后,1是支付成功,0是支付失败或放弃支付
     */
    public function pay($id,$havepay=0,$ispay=0){
        $rs = getArray($this->model->get($id));                       //订单信息
        if (empty($rs)) {
            $this->error('订单不存在');
        }
        $info = Content::getInfoByid($rs['shopid']);    //商品信息

        if ($rs['few_ifpay']!=1) {
            $this->error('请先支付订金,才能付余款');
        }elseif ($rs['pay_status']==1) {
            $this->error('你已经支付过余款了','index');
        }
        
        if ($info['mid']==3){  //拍卖
            if (!$info['end_time'] || time()<$info['end_time']) {
                $this->error('拍卖还没结束,不能付余款!');
            }
            $array = OrderModel::where('shopid',$info['id'])->where('few_ifpay',1)->order('pay_money DESC')->limit($info['sell_num']?:1)->column('id,uid');
            if (!in_array($this->user['uid'], $array)) {
                $this->error('你没有中拍,不能付余款,只能申请退保证金!');
            }
        }
        
        //$info['tun_type']==-1 是单独购买
        if (!in_array($info['mid'], [2,3]) && $info['tun_type']!=-1 && $info['min_user']) {
            if ($info['stocktype']==2){   //预约模式
                $info['fewnum'] = count_time_num($info['id'],$rs['order_day'],$rs['order_tid']);
            }
            if($info['fewnum']<$info['min_user']){
                $this->error('还没组成团,暂时还不能付余款');
            }
            
            //这里只考虑一个订单只有一个商品的情况
            $_order_info = get_order_totalmoney($info,$rs); //处理每增加一个就自动减一定价格的情况
            if ($_order_info['pay_money'] && $_order_info['pay_money']<$rs['pay_money']) {
                $rs['pay_money'] = $_order_info['pay_money'];
                $this->model->update([
                    'id'=>$id,
                    'pay_money'=>$_order_info['pay_money'],
                    'totalmoney'=>$_order_info['pay_money'],
                ]);
            }
        }
        
        

        if ($havepay==1) {
            if($ispay==1){
                if($this->model->pay($id)){
                    $url = urls('show',['id'=>$id]);
                    $this -> success('已付款，订单处理成功', $url);
                }else{
                    $this->error('已付款，订单处理失败', 'index');
                }
            }else{
                $this->error('你并没有付款，订单未作处理', 'index');
            }            
        }
        //直接跳转支付
        post_olpay([
                //'money'=>'0.01',
                'money'=>$rs['pay_money'],
                'return_url'=>url('pay',['id'=>$id,'havepay'=>1]),
                'banktype'=>'',//in_weixin() ? 'weixin' : 'alipay' , //在微信端,就用微信支付,否则就用支付宝支付
                'numcode'=>'YU'.substr($rs['order_sn'], 2),   //订单号不能跟订金的雷同
                'callback_class'=>mymd5('app\\'.config('system_dirname').'\\model\\Order@pay@'.$id),
        ] , true);
    }
    
    /**
     * 支付订金
     * @param number $id
     */
    public function pay_few($id=0){
        $info = $this->model->get($id); //订单信息
        $shop = Content::getInfoByid($info['shopid']); //商品信息
        
        if ($shop['mid']!=5 && $shop['end_time'] && $shop['end_time']<time()) {
            $this->error('活动已经结束了!');
        }elseif($shop['stocktype']==1){ //按天统计库存
            if ( ($shop['day_endtime']&&str_replace(':', '', $shop['day_endtime'])<date('His')) || date('d')!=date('d',$shop['create_time'])) {
                $this->error('订单已过期了,请重新下订!');
            }
        }elseif($shop['status']==-1){
            $this->error('当前订单已退订,不能再支付!');
        }
        list($_shopid,$_num,$_type1) = explode('-',$info['shop']);
        $_type1--;
        if( fun('shop@get_num',$shop,$_type1)!==null ){
            if(fun('shop@get_num',$shop,$_type1)-$_num<0){
                return '该类型没库存了';
            }
        }elseif($shop['max_user']>0){
            $num = $this->model->where(['shopid'=>$shop['id'],'few_ifpay'=>1])->sum('shopnum');
            if($num>=$shop['max_user']){
                $this->error('很抱歉,你迟迟未付款,库存已售空了!');
            }
        }
        post_olpay([
                'money'=>$info['fewmoney'],
                //'money'=>'0.01',    //调试
                'return_url'=>url('end_few',['id'=>$id]),
                'banktype'=>'',//in_weixin() ? 'weixin' : 'alipay' , //在微信端,就用微信支付,否则就用支付宝支付
                'numcode'=>$info['order_sn'],
                'callback_class'=>mymd5('app\\'.config('system_dirname').'\\model\\Order@payfew@'.$id),
        ],true);
    }
    
    /**
     * 退订金
     * @param number $id
     */
    public function tui_ding($id=0){
        $info = $this->model->get($id);
        if ($info['uid']!=$this->user['uid']) {
            $this->error('你没权限!');
        }elseif ($info['status']==-1) {
            $this->error('交易已关闭!');
        }elseif ($info['few_ifpay']==-1) {
            $this->error('订金还在退还当中,请耐心等待!');
        }elseif ($info['few_ifpay']!=1) {
            $this->error('你还没付订金!');
        }elseif ( $info['pay_status']!=0 ) {
            $this->error('请申请退全款,不能只申请退部分订金!');
        }
        $shop = Content::getInfoByid($info['shopid']);
        
        if ($shop['mid']==3) {
            $result = \app\yuyue\index\Task::tui_paimai($shop['id'],$id);
            if ($result===true) {
                $this->success('你的竟拍保证金已退还到你的余额,请注意查收!');
            }else{
                $this->error($result);
            }
        }
        
        $content = '你发布的 ' . $shop['title'] . ', 会员:' . $this->user['username'] . " 申请退订了,<a href=\"".get_url(murl('kehu_order/show',['id'=>$info['id']]))."\">点击查看详情</a>";
        
        $allow_tudin = false;
        if ($info['tun_type']==1) { //单独购买的话. 订金是直接退掉.解决用户误下单直接退订
            $allow_tudin = true;
        }elseif( ($info['tun_type']==-2 || $info['tun_type']>0) && count_join_num($info['tun_type']==-2?$info['id']:$info['tun_type'])+1<$shop['min_user']){
            $allow_tudin = true;
        }
        
        
        if($shop['mid']!=2 && ($allow_tudin||(!$info['tun_type'] && $shop['fewnum']>=$shop['min_user'])) ){ //砍价的话,可以随时申请退订金 , 这里只针对拼团,成团后,还要申请退订的情况,需要商家同意才退.不能自动退,未成团才可以自动退
            $this->model->update([
                    'id'=>$id,
                    'few_ifpay'=>-1,
            ]);
            send_msg($info['shop_uid'],$this->user['username'].' 申请退订了',$content);
            send_wx_msg($info['shop_uid'], $content);
            $this->error('退订申请已提交,需要商家同意才能把订金退还到你帐户余额,友情提醒:已经成功组团的商品,商家有权拒绝退订的.');
        }else{
            $this->model->update([
                    'id'=>$id,
                    'few_ifpay'=>0,
            ]);
            
            $info['shopnum']>0 || $info['shopnum']=1;
            Content::updates($info['shopid'],[
                    'fewnum'=>$shop['fewnum']-$info['shopnum'],
            ]);
            add_rmb($info['uid'], $info['fewmoney'], 0,'退订金:'.$shop['title']);
            add_rmb($shop['uid'],0, -$info['fewmoney'], $this->user['username'].'退订金:'.$shop['title']);
           
            send_msg($info['shop_uid'],'有人申请退订了',$content);
            send_wx_msg($info['shop_uid'], $content);
            $this->success('成功退订,订金已转到你的帐户余额');
        }
    }
    
    /**
     * 订金支付完毕
     * @param number $id
     */
    public function end_few($id=0){
        $result = $this->model->payfew($id);
        if ($result!==true){
            $this->error($result);
        }else{
            $this->success('下定成功,请及时交余款','index');
        }
    }
}