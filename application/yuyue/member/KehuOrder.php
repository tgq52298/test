<?php
namespace app\yuyue\member;

use app\common\controller\member\KehuOrder AS _Order;
use app\yuyue\model\Content AS ContentModel;
use app\yuyue\model\Hexiao AS MemberModel;

class KehuOrder extends _Order
{
    /**
     * 权限检查
     * @param array $info 订单信息
     * @param string $pwd
     */
    protected function check_power($info=[],$pwd=''){
        if ($info['shop_uid']!=$this->user['uid'] && empty(MemberModel::where('uid',$info['shop_uid'])->where('hxuid',$this->user['uid'])->find())) {
            $shop_info = ContentModel::getInfoByid($info['shopid']);
            if ($this->user['qun_group'][$shop_info['ext_id']]['type']!=2) {
                $this->error('你没权限');
            }            
        }
        //if (!$this->webdb['force_hexiao']) {
        if ($pwd) {
            list($_id,$time) = explode("\t", mymd5($pwd,'DE'));
            if ($_id!=$info['id']) {
                $this->error('ID有误'.$_id);
            }elseif (time()-$time>3600) {
                $this->error('已经超时了,60分钟有效,请重新扫码');
            }
            $this->assign('show_code',1);
            $this->assign('pwd',$pwd);
        }
    }
    
    /**
     * 修改备注
     * @param number $id
     * @param string $content
     */
    public function edit_note($id=0,$content=''){
        $info = $this->model->getInfo($id); //订单信息
        $this->check_power($info);
        $result = $this->model->where('id',$id)->update([
            'admin_note'=>$content,
        ]);
        if ($result) {
            $this->success('设置成功');
        }else{
            $this->error('设置失败');
        }
    }
    
    
    /**
     * 指派负责人
     * @param number $id
     * @param number $uid
     */
    public function set_hexiao_uid($id=0,$uid=0){
        $info = $this->model->getInfo($id); //订单信息
        $this->check_power($info);
        $result = $this->model->where('id',$id)->update([
            'hx_uid'=>$uid,
        ]);
        if ($result) {
            $shop_info = ContentModel::getInfoByid($info['shopid']);
            $content ='你好，圈主：“'.$this->user['username'].'” 将 “'.$info['linkman'].'” 预订的订单 '.$shop_info['title'].' 委托你处理，<a href="'.get_url(urls('show',['id'=>$id])).'" target="_blank">点击查看详情</a>';
            send_msg($uid,'订单委托',$content);
            send_wx_msg($uid, $content);
            
            $this->success('设置成功');
        }else{
            $this->error('设置失败');
        }
    }
    
    /**
     * 查看用户订单
     * {@inheritDoc}
     * @see \app\common\controller\member\KehuOrder::show()
     */
    public function show($id=0,$pwd=''){
        $info = $this->model->getInfo($id);
        $this->check_power($info,$pwd);
        
        //这里只考虑一个订单只有一个商品的情况
        $info = get_order_totalmoney($info['shop_db'][0],$info);    //统计成团后随人数增加,价格下降的情况
        
        $this->assign('info',$info);
        $this->assign('id',$id);
        return $this->fetch();
    }
    
    /**
     * 核销订单, 也即商家帮客户确认收货!
     * @param number $id
     * @param string $pwd
     */
    public function receive($id=0,$pwd=''){
        $info = $this->model->getInfo($id);
        if (empty($info)) {
            $this->error('数据不存在!!');
        }
        $this->check_power($info,$pwd);
        if ($info['receive_status']!=0) {
            $this->error('已经核销过了!');
        }
        
        if($info['pay_money']>0 && $info['fewmoney']>0 && $info['few_ifpay']==0){
            $this->error('当前订单是分期付款,需要线上先支付订金才能核销!');
        }
//         $array = [
//                 'id'=>$id,
//                 'receive_status'=>1,    //也即商家帮客户确认收货!
//                 'receive_time'=>time(),
//         ];
        $result = $this->model->he_xiao($info);
        if($result===true){
            $this->success('核销成功!');
        }else{
            $this->error('处理失败');
        }
    }
    
    /**
     * 客户的订单列表
     * @param unknown $type 搜索条件参数
     * @param number $aid 商品ID
     * @param string $ktype 搜索的字段
     * @param string $keyword 搜索的内容
     * @param number $excel 是否导出EXCEL表格
     * @param number $order_day 按预约日期搜索
     * @param number $order_tid 按预约日期的时间段搜索
     * @param number $qid 圈子的ID,副圈主查看订单 
     */
    public function index($type=null,$aid=0,$ktype='',$keyword='',$excel=0,$order_day=0,$order_tid=0,$qid=0){
        $shop_uid = 0;
        $map = [];
        if ($qid) {
            $qun = fun('qun@getbyid',$qid);
            if(!$qun){
                $this->error('圈子不存在!');
            }elseif($qun['uid']!=$this->user['uid'] && $this->user['qun_group'][$qid]['type']!=2){
                $this->error('你没权限!');
            }
            if ($qun['uid']!=$this->user['uid']) {
                $map['hx_uid'] = ['in',[0,$this->user['uid']]]; 
            }
            $shop_uid = $qun['uid'];
        }
        $map['shop_uid'] = $shop_uid?:$this->user['uid'];
        if ($aid) {
            $map['shopid'] = $aid;
        }
        if ($ktype&&$keyword!='' && in_array($ktype, ['uid','order_sn','shopid','linkman'])) {
            if ($ktype=='linkman') {
                $map[$ktype] = [
                    'like',
                    "%{$keyword}%"
                ];
            }else{
                $map[$ktype] = $keyword;
            }            
        }
        
        if($type=='ispay'){ //付全款
            $map['pay_status'] = 1;
        }elseif($type=='nopay'){ //没付余款,也有可能订金都还没付
            $map['pay_status'] = 0;
        }elseif($type=='isfew'){ //已付订金
            $map['few_ifpay'] = 1;
        }elseif($type=='nofew'){ //没付订金
            $map['few_ifpay'] = 0;
        }elseif($type=='tui'){  //申请退订
            $map['few_ifpay'] = -1;
        }elseif($type=='nopayall'){ //仅付了订金,没付余款
            $map['few_ifpay'] = 1;
            $map['pay_status'] = 0;
        }elseif($type=='ishexiao'){  //已核销
            $map['receive_status'] = 1;
        }elseif($type=='nohexiao'){  //未核销
            $map['receive_status'] = 0;
        }
        if ($order_day) {
            $map['order_day'] = $order_day;
        }
        if ($order_tid) {
            $map['order_tid'] = $order_tid;
        }
        $list_data = $this->model->getList($map,10,$excel);
        if ($excel==1) {
            $this->excel($list_data);
        }
        
        $shopdb = ContentModel::getIndexByUid($shop_uid?:$this->user['uid']);
        
        $shop_info = [];
        if( $aid>0 || count($shopdb)==1){
            $shop_info = ContentModel::getInfoByid($aid?:current($shopdb)['id']);
        }        

        $this->assign([
            'shopdb'=>$shopdb,
            'shop_info'=>$shop_info,
            'aid'=>$aid,
            'listdb'=>getArray($list_data)['data'],
            'pages'=>$list_data->render(),
            'type'=>$type,
            'shop_uid'=>$shop_uid?:$this->user['uid'],
            'qid'=>$qid,
            'ktype'=>$ktype,
            'keyword'=>$keyword,
            'order_day'=>$order_day,
            'order_tid'=>$order_tid,
        ]);
        
//         $this->assign('listdb',getArray($list_data)['data']);
//         $this->assign('pages',$list_data->render());
//         $this->assign('type',$type);
//         $this->assign('shop_uid',$shop_uid?:$this->user['uid']);
//         $this->assign('qid',$qid);
//         $this->assign('ktype',$ktype);
//         $this->assign('keyword',$keyword);
//         $this->assign('order_day',$order_day);
//         $this->assign('order_tid',$order_tid);
        return $this->fetch();
    }
    
    protected function excel($array=[]){
        
        if(!$array){
            $this->error('没有数据可导出!');
        }        
        
        $outstr="<table width=\"100%\" border=\"1\" align=\"center\" cellpadding=\"5\"><tr>";
        
        $fieldDB = [
            'id'=>'序号',
            'order_sn'=>'订单号',
            'uid'=>'客户UID',
            'username'=>'客户帐号',
            'shoptitle'=>'商品信息',
            'shopnum'=>'订购数量',
            'fewmoney'=>'订金',
            'pay_money'=>'尾款',
            'few_ifpay'=>'付订金与否',
            'pay_status'=>'付尾款与否',
            'receive_status'=>'消费(发货)与否',
            'shipping_code'=>'消费码(快递号)',
            'create_time'=>'下单日期',
            'linkman'=>'联系人',
            'address'=>'联系地址',
            'telphone'=>'联系电话',
        ];
        
        foreach($fieldDB AS $title){
            $outstr.="<th bgcolor=\"#A5A0DE\">$title</th>";
        }
        $outstr.="</tr>";
        foreach($array  AS $rs){
            $outstr.="<tr>";
            $info = ContentModel::getInfoByid($rs['shopid']);
            foreach($fieldDB AS $k=>$v){
                $value = $rs[$k];
                if ($k=='username') {
                    $value = get_user_name($rs['uid']);
                }elseif(in_array($k, ['few_ifpay','pay_status'])){
                    $value = $value?'已支付':'未支付';
                }elseif($k=='receive_status'){
                    $value = $value?'已消费(发货)':'未消费(发货)';
                }elseif($k=='create_time'){
                    $value = format_time($value);
                }elseif($k=='shoptitle' && !$value){
                    $value = $info['title'];
                }elseif($k=='ordertime' && $info['stocktype']==2){
                    $value = format_order_time($rs);
                }
                if (is_numeric($value)&&$value>1000000) {
                    $value .= "&nbsp;"; //避免数字变成有字母的情况
                }
                $outstr.="<td align=\"center\">{$value}</td>";
            }
            $outstr.="</tr>";
        }
        $outstr.="</table>";
        ob_end_clean();
        header('Last-Modified: '.gmdate('D, d M Y H:i:s',time()).' GMT');
        header('Pragma: no-cache');
        header('Content-Encoding: none');
        header('Content-Disposition: attachment; filename=MicrosoftExce.xls');
        header('Content-type: text/csv');
        echo "<!doctype html>
        <html lang='en'>
        <head>
        <meta charset='UTF-8'>
        <title></title>
        </head>
        <body>
        $outstr
        </body>
        </html>";
        exit;
    }
    
    /**
     * 没收用户订金
     * @param number $id
     */
    public function rob_ding($id=0){
        $info = getArray($this->model->get($id));
        if(!preg_match('/^([\d]+)$/', $info['create_time'])){
            $info['create_time'] = strtotime($info['create_time']);             
        }
        $shop = ContentModel::getInfoByid($info['shopid']);
        
        if ($info['shop_uid']!=$this->user['uid']) {
            $this->error('你没权限!');
        }elseif ($info['pay_status']!=0) {
            $this->error('用户已付余款,不能没收订金!');
        }elseif ($info['few_ifpay']!=1) {
            $this->error('用户还没有付订金,或者处于其它状态!');
        }elseif ($shop['fewnum']<$shop['min_user']) {
            $this->error('没有组成团,不可以没收用户的订金');
        }elseif (time()-$info['create_time']<3600*24*30 ) {
            $this->error('用户下单一个月后,才可以没收用户订金');
        }
        $this->model->update([
                'id'=>$id,
                'few_ifpay'=>0,
        ]);
        add_rmb($info['shop_uid'], 0, -$info['fewmoney'],'解冻,没收用户订金:'.get_user_name($info['id']));
        add_rmb($info['shop_uid'], $info['fewmoney'], 0,'没收用户订金:'.get_user_name($info['id']));
        $content ='你订购的:'.$shop['title'].',已组成团,但你一直没付款,订金被商家没收.<a href="'.get_url(urls('order/show',['id'=>$id])).'" target="_blank">点击查看详情</a>';
        send_msg($info['uid'],'你的订金被没收了',$content);
        send_wx_msg($info['uid'], $content);
        $this->success('成功没收订金');
    }
    
    /**
     * 处理用户申请退订
     * @param string $id 订单ID,不是商品ID
     * @param string $type
     */
    public function tui_ding($id=0,$type=''){
        $info = getArray($this->model->get($id));
        
        if ($info['shop_uid']!=$this->user['uid']) {
            $this->error('你没权限!');
        }elseif ($info['pay_status']!=0) {
            $this->error('用户已付余款,不能只选择退订金!');
        }elseif ($info['few_ifpay']!=-1) {
            $this->error('用户还没有付订金,或者处于其它状态!');
        }
        
        $shop = ContentModel::getInfoByid($info['shopid']);
        
        if ($type=='agree') {
            $this->model->update([
                'id'=>$id,
                'few_ifpay'=>0,
                'status'=>-1,
            ]);
            add_rmb($info['shop_uid'], 0,-$info['fewmoney'],'解冻,退订:'.$shop['title']);
            add_rmb($info['uid'], $info['fewmoney'], 0,'退订:'.$shop['title']);
            $content ='你申请退订:'.$shop['title'].',已得到商家的同意,订金已退到你的帐户余额.<a href="'.get_url(urls('order/show',['id'=>$id])).'" target="_blank">点击查看详情</a>';
            send_msg($info['uid'],'你的退订申请,已通过批准',$content);
            send_wx_msg($info['uid'], $content);
            $this->success('成功退订');
        }else{
            $this->model->update([
                    'id'=>$id,
                    'few_ifpay'=>1,
            ]);
            $content ='你申请退订:'.$shop['title'].',被商家拒绝了.<a href="'.get_url(urls('order/show',['id'=>$id])).'" target="_blank">点击查看详情</a>';
            send_msg($info['uid'],'很抱歉,你的退订申请,被商家拒绝了',$content);
            send_wx_msg($info['uid'], $content);
            $this->success('拒绝退订已提交');
        }        
    }
    
    /**
     * 给所有用户群发付款通知
     * @param number $id 商品ID
     */
    public function msg_all($id=0,$type=1){
        $info = ContentModel::getInfoByid($id);
        if ($info['uid']!=$this->user['uid']) {
            $this->error('你没权限!');
        }elseif ($type==1 && $info['fewnum']<$info['min_user']){
            $this->error('人数还没达到,不能群发付款通知!');
        }
        
        if ($type==1||$type==2) {
            $map = [
                'few_ifpay'=>1,
                'pay_status'=>0,
            ];
        }elseif($type==3){
            $map = [
                'pay_status'=>1,
            ];
        }elseif($type==4){
            $map = [
                'few_ifpay'=>1,
            ];
        }elseif($type==5){
            $map = [
                'few_ifpay'=>0
            ];
        }
        $map['shopid'] = $id;
        
        $listdb = $this->model->where($map)->column('uid');
        $num = count($listdb);
        $title = $content = '来自 '.$info['title'].' 的群发消息,';
        if ($type==1) {
            $content .= '你参与的 '.$info['title'].' 已成功组团,请尽快支付余款';
        }else{
            $content .= $this->request->post('content');
        }
        $content .=',<a target="_blank" href="'.get_url(urls('order/index')).'">点击查看详情</a>';
//         $num = 0;
//         $listdb = $this->model->where($map)->column(true);
//         foreach($listdb AS $rs){
//             $title = '重要提醒,你购买的 '.$info['title'].' 已经成功组成团,请尽快去付余款';
//             $content =',<a href="'.urls('order/show',['id'=>$rs['id']]).'">点击查看详情</a>';
//             send_msg($rs['uid'],$title,$title.$content);
//             send_wx_msg($rs['uid'], $title.$content);
//             $num++;
//         }
//         if ($num>0) {
//             $this->success('本次成功通知 '.$num.' 位会员');        
//         }else{
//             $this->error('没有会员可以通知!');
//         }
        if ($num>0) {
            $array = [
                'ext_id'=>$id,
                'ext_sys'=>M('id'),
                'msgtype'=>'msg,wxmsg', //同时发站内消息与微信消息
            ];
            $result = fun("msg@send",$listdb,$title,$content,$array);
            if ($result===true) {
                $this->success('需要通知 '.$num.' 位会员,已放入消息队列');
            }else{
                $this->error($result);
            }
        }else{
            $this->error('没有会员可以通知!');
        }
    }
    
    /**
     * 给某个订单退全款
     * @param number $id 订单ID
     */
    public function tui_order($id=0){
        $info = $this->model->get($id);
        if (!$info) {
            $this->error('资料不存在!');
        }
        $this->check_power($info);
        
        if ($info['status']==-1) {
            $this->error('交易已关闭!');
        }elseif ($info['few_ifpay']==-1) {
            $this->error('订金还在退还当中,请耐心等待!');
        }elseif ($info['few_ifpay']!=1) {
            $this->error('还没付订金!');
        }elseif ( $info['pay_status']!=1 ) {
            $this->error('还没付全款!');
        }
        
        $shop_info = ContentModel::getInfoByid($info['shopid']);
        $content = '你订购的:'.$shop_info['title'].',商家退款给你,取消交易';
        
        $money = $info['pay_money'] + $info['fewmoney'];
        
        if ($money>0 && $this->user['rmb']<$money) {
            $this->error('商家余款不足,无法抵扣退款!');
        }
        
        $result = $this->model->update([
            'id'=>$id,
            'few_ifpay'=>0,
            'pay_status'=>0,
            'status'=>-1,
        ]);
        
        if (!$result) {
            $this->error('数据库操作失败!');
        }
        
        if ($money>0) {
            add_rmb($info['uid'], $money, 0,$content);
            add_rmb($info['shop_uid'], -abs($money), 0,'给用户:'.get_user_name($info['uid']).' 退款');
        }elseif($info['qun_money']>0){
            fun('qun@money',$shop_info['ext_id'],$info['uid'],$info['qun_money'],'退订:'.$shop_info['title']);
        }
        ContentModel::updates($shop_info['id'],['fewnum'=>$shop_info['fewnum']-$info['shopnum']]);  //下订人数要更新
        
        $content .=',<a href="'.get_url(urls('order/show',['id'=>$id])).'">点击查看详情</a>';
        send_msg($info['uid'],'很抱歉,你的订单被取消了',$content);
        send_wx_msg($info['uid'], $content);
        
        $this->success('退款成功!');
    }
    
    /**
     * 给所有用户退款
     * 注意:按天统计的话,只退当天
     * @param number $id 商品ID
     */
    public function tui_all($id=0){
        $info = ContentModel::getInfoByid($id);
        if ($info['uid']!=$this->user['uid']) {
            $this->error('你没权限!');;
        }
        $map = [
                'shopid'=>$id,
                'few_ifpay'=>1,
        ];
        $num = $fewnum = 0;
        $fail = false;
        if ($info['stocktype']==1){    //按天统计的话,每天的下订人数都不一样
            $map['create_time'] = fun('time@only','day',1);
        }
        $listdb = $this->model->where($map)->column(true);
        foreach($listdb AS $rs){
            if($rs['pay_status']==1){ //已付尾款
                $money = $rs['pay_money'] + $rs['fewmoney'];    //如果付了余款的话,订金也已经给了商家.
                if ($this->user['rmb']>=$money) {
                    $content = '你购买的:'.$info['title'].',商家退款给你,取消交易';
                    add_rmb($rs['uid'], $money, 0,$content);
                    add_rmb($rs['shop_uid'], -abs($money), 0,'给用户:'.get_user_name($rs['uid']).' 退款');
                }else{
                    $fail = true;
                    //商家余额不足,退款失败
                    continue ;
                }
            }elseif($rs['pay_status']!=0){
                continue ;  //有纠纷的订单,比如申请退换货的
            }else{
                $content = '你预定的:'.$info['title'].',商家退订金给你,取消交易';
                add_rmb($rs['uid'], $rs['fewmoney'], 0,$content);
            }
            $this->model->update([
                'id'=>$rs['id'],
                'few_ifpay'=>0,
                'pay_status'=>0,
                'status'=>-1,
            ]);
            
            $content .=',<a href="'.urls('order/show',['id'=>$rs['id']]).'">点击查看详情</a>'; 
            send_msg($rs['uid'],'很抱歉,你的订单被取消了',$content);
            send_wx_msg($rs['uid'], $content);
            $rs['shopnum'] || $rs['shopnum']=1;
            $fewnum += $rs['shopnum'];
            $num++;
        }
        
        if ($num>0) {
            ContentModel::updates($id,['fewnum'=>$info['fewnum']-$fewnum]);  //下订人数要更新
            $this->success('本次成功退订 '.$num.' 条');
        }elseif($fail){
            $this->error('你的余额不足,退款失败!');
        }else{
            $this->error('没有订单可以退!');
        }
    }
}