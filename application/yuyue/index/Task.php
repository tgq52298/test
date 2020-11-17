<?php
namespace app\yuyue\index;

use app\common\controller\IndexBase;
use app\yuyue\model\Content AS ContentModel;
use app\yuyue\model\Order AS OrderModel;
use app\yuyue\model\Member AS MemberModel;
use think\Db;

class Task extends IndexBase
{
    /**
     * 后台执行定时任务
     */
    public function run(){
        $this->tuiding();
        $this->tui_paimai();
        $this->miaosha_remind();
    }
    
    /**
     * 竟拍退保证金 
     * @param number $id 商品ID
     * @param number $oid 订单ID
     */
    public static function tui_paimai($id=0,$oid=0){
        $map = [
            'if_finish'=>0,
        ];
        if ($id) {
            $map['id'] = $id;
        }
        $msg = true;
        $listdb = getArray(ContentModel::getListByMid(3,$map,'id desc',1000,[],false));
        foreach($listdb['data'] AS $rs){
            if (!$rs['end_time'] || time()<$rs['end_time']) {
                if ($id) {
                    $msg = '要等活动结束后,才能申请退保证金!';
                }
                continue;
            }
            $no_winArray = [];
            $rs['sell_num'] || $rs['sell_num'] = 1; //销售数量
            $_listdb = OrderModel::where('shopid',$rs['id'])->where('few_ifpay',1)->order('pay_money DESC')->column(true);
            $i = 0;
            $remind_key = 'paimai_remind_pay_'.$rs['id'];
            foreach($_listdb AS $vs){
                if ($i<$rs['sell_num']) {   //中标的用户
                    if($vs['pay_status']==0){  //中拍,未付余款
                        if($rs['limit_day'] && time()>$rs['end_time']+3600*24*$rs['limit_day']){    //超过期限,没收保证金
                            $content = '你参与竟拍的: '.$rs['title'].' ,中签后一直未付,商家没收了你的保证金';
                            $result = OrderModel::where('id',$vs['id'])->update([
                                'few_ifpay'=>0,
                                'status'=>-1,
                            ]);
                            if ($result) {
                                add_rmb($rs['uid'], 0,-$vs['fewmoney'], get_user_name($vs['uid']).'拍卖未付余款,解冻保证金');                                
                                add_rmb($rs['uid'], $vs['fewmoney'], 0,'没收用户:'.get_user_name($vs['uid']).'竟拍保证金');
                                send_wx_msg($vs['uid'], $content);
                                send_msg($vs['uid'],'竟拍保证金被没收',$content);
                                
                                send_wx_msg($rs['uid'], '用户:'.get_user_name($vs['uid']).'中拍,一直没付尾款,系统帮你没收了他的保证金');
                                send_msg($rs['uid'],'没收竟拍保证金', '用户:'.get_user_name($vs['uid']).'中拍,一直没付尾款,系统帮你没收了他的保证金');
                            }
                        }else{
                            if (!cache($remind_key)) {
                                $content = $rs['limit_day'] ? date('Y-m-d H:i:s',$rs['end_time']+3600*24*$rs['limit_day']).'前未支付余款，系统将自动没收你的保证金。' : '拖延太久，商家有权没收你的保证金。' ;
                                $content = '<a href="'.get_url(murl('yuyue/order/index')).'" target="_blank">'.'你参与竟拍的: '.$rs['title'].' ,已中签,请尽快支付余款,'.$content.'</a>';
                                send_wx_msg($vs['uid'], $content);
                                send_msg($vs['uid'],'你已中拍,请抓紧付余款',$content);
                            }
                        }
                    }
                    if ($oid==$vs['id']) {
                        $msg = '你已中拍,不能申请退保证金,请及时支付尾款,否则保证金会被无偿没收!';
                    }
                }else{  //未中拍者
                    $content = '你参与竟拍的: '.$rs['title'].' ,未中签,商家退款给你,取消交易';
                    $result = OrderModel::where('id',$vs['id'])->update([
                        'few_ifpay'=>0,
                        'status'=>-1,
                    ]);
                    if ($result) {
                        add_rmb($vs['uid'], $vs['fewmoney'], 0,$content);                        
                        add_rmb($vs['shop_uid'], 0,-$vs['fewmoney'], get_user_name($vs['uid']).'拍卖未中签,解冻保证金');
                        
                        send_msg($vs['uid'],'竟拍退保证金',$content);
                        send_wx_msg($vs['uid'], $content);
                    }
                    $no_winArray[] = $vs['uid'];
                }
                
                $i++;
            }
            cache($remind_key,1,3600*24);    //24小时通知一次付尾款
            if($rs['limit_day'] && time()>$rs['end_time']+3600*24*$rs['limit_day']){
                ContentModel::updates($rs['id'],['if_finish'=>1]);
            }
            if ($no_winArray) { //只执行一次.并且必须要有失败者
                $win_id = array_values($_listdb)[0]['id'];
                $tag = 'paimai_win_givejifen-'.$win_id;
                if (!cache($tag)) {     //因为发送微信消息会很耗时,同时访问的话,$no_winArray的值不同会出现不止一次
                    $winer = get_user_name(array_values($_listdb)[0]['uid']);
                    $uid_array = getArray(MemberModel::where('order_id',$win_id)->field('uid,count(*) AS num')->group('uid')->select());
                    foreach ($uid_array AS $vs){
                        $title = "帮 {$winer} 竟拍助威,Ta中标了";
                        add_jifen($vs['uid'], $vs['num'], $title);
                        $content = "在 “{$rs['title']}”竟拍活动中，".$title."。系统奖励你 {$vs['num']} 个积分，因为你帮他加油助威了 {$vs['num']} 次";
                        send_wx_msg($vs['uid'], $content);
                        send_msg($vs['uid'],$title,$content);
                    }
                }
                cache($tag,1,3600);                
            }
        }
        return $msg;
    }
    
    /**
     * 秒杀提醒
     * @return number
     */
    public function miaosha_remind(){
        $map = [
            'begin_time'=>[
                ['>',time()],
                ['<',time()+900],
                'and'
            ],
        ];
        $i=0;
        $listdb = getArray(ContentModel::getListByMid(4,$map,'id desc',1000,[],false));
        foreach ($listdb['data'] AS $rs){
            $key = 'miaosha_remind-'.$rs['id'];
            if (cache($key)) {
                continue ;
            }
            cache($key,1,1800);
            $_map = [
                'aid'=>$rs['id'],
                'type'=>4,
            ];
            $subQuery = MemberModel::where($_map)
            ->field('*')
            ->order('id desc')
            ->buildSql();
            $data_list = Db::table($subQuery.' a')
            ->field('*')
            ->group('order_id')
            ->order('id')
            ->paginate(200);
            $array = getArray($data_list);
            foreach($array['data'] AS $vs){
                $content ='你预约的 '.$rs['title'].' 秒杀即将开始了,<a href="'.get_url(iurl('yuyue/content/show',['id'=>$rs['id']])).'">点击查看详情</a>';
                send_msg($vs['order_id'],'你预约的秒杀即将开始了',$content);
                send_wx_msg($vs['order_id'], $content);
                $i++;
                //echo $vs['order_id'].',';
            }
        }
        return $i;
    }
    
    /**
     * 按天拼团的,超过当天最后截止时间,若未成团,就进行退订处理
     * @return string
     */
    public function tuiding(){
        $map = [
            'stocktype'=>1,
        ];
        $listdb = getArray(ContentModel::getListByMid(1,$map,'id desc',1000,[],false));
        foreach($listdb['data'] AS $rs){
            if ( !$rs['day_endtime'] ) {
                $rs['day_endtime'] = '23:50:00';
            }
            if (str_replace(':', '', $rs['day_endtime'])>date('His')) { //只有当超过当前最后购买时限才做退订处理
                continue ;
            }
            if ($rs['min_user']>0) {  //设置了最低组团人数才处理
                $fewnum = $this->count_fewnum($rs);
                if ($fewnum>0 && $fewnum<$rs['min_user']) {
                    $result = $this->tui_order($rs);
                }
            }
        }
        return $result?'退订成功':'没执行任务';
    }
    
    /**
     * 处理按天拼团的退订
     * @param array $info 商品信息
     * @return number
     */
    private function tui_order($info=[]){
        $user = get_user($info['uid']); //商家信息
        $id = $info['id'];
        $map = [
            'shopid'=>$id,
            'few_ifpay'=>1,
            'create_time'=>fun('time@only','day',1),
        ];
        $num = $fewnum = 0;
        $fail = 0;
        $listdb = OrderModel::where($map)->column(true);
        foreach($listdb AS $rs){            
            if($rs['pay_status']==1){   //已付余款
                $money = $rs['pay_money'] + $rs['fewmoney'];    //如果付了余款的话,订金也已经给了商家.
                if ($user['rmb']>=$money) {                    
                    $result = OrderModel::update([
                        'id'=>$rs['id'],
                        'few_ifpay'=>0,
                        'pay_status'=>0,
                        'status'=>-1,
                    ]);
                    if ($result) {
                        $content = '你购买的:'.$info['title'].',未组成团,商家退款给你,取消交易';
                        add_rmb($rs['uid'], $money, 0,$content);
                        add_rmb($rs['shop_uid'], -abs($money), 0,'给用户:'.get_user_name($rs['uid']).' 退款');
                    }else{
                        $fail++;
                        continue ;
                    }                    
                }else{
                    $fail++;
                    //商家余额不足,退款失败
                    continue ;
                }
            }elseif($rs['pay_status']!=0){
                $fail++;
                continue ;  //有纠纷的订单,比如申请退换货的
            }else{
                $content = '你预定的:'.$info['title'].',未组成团,商家退订金给你,取消交易';
                $result = OrderModel::update([
                    'id'=>$rs['id'],
                    'few_ifpay'=>0,
                    'status'=>-1,
                ]);
                if ($result) {
                    add_rmb($rs['uid'], $rs['fewmoney'], 0,$content);
                }else{
                    $fail++;
                    continue ;
                }
            }            
            
            $content .=',<a href="'.get_url(murl('yuyue/order/show',['id'=>$rs['id']])).'">点击查看详情</a>';
            send_msg($rs['uid'],'很抱歉,你的订单被取消了',$content);
            send_wx_msg($rs['uid'], $content);
            $rs['shopnum'] || $rs['shopnum']=1;
            $fewnum += $rs['shopnum'];
            $num++;
        }
        
        if ($num>0) {
            ContentModel::updates($id,['fewnum'=>$info['fewnum']-$fewnum]);  //下订人数要更新
            return $num;
        }elseif($fail){
            return -$fail;
        }
    }
    
    /**
     * 统计当天已成功下订的人数
     * @param array $info
     * @return unknown
     */
    private function count_fewnum($info=[]){
        $map = [
            'create_time'=>fun('time@only','day',1),
            'shopid'=>$info['id'],
        ];
        if ($info['paytype']==0||$info['paytype']==1) {  //分期付款与一次性在线付款的情况
            $map['few_ifpay'] = 1;
        }
        $num = OrderModel::where($map)->sum('shopnum');
        return $num;
    }
}