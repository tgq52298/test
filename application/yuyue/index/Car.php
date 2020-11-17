<?php
namespace app\yuyue\index;

use app\common\controller\index\Car AS _Car;
use app\yuyue\model\Content AS ContentModel;
use app\yuyue\model\Order AS OrderModel;
use app\yuyue\model\Member AS MemberModel;

//购物车
class Car extends _Car
{
    public function index(){
        return parent::index();
    }
    
    public function act($shopid=0,$type=''){
        return parent::act($shopid,$type);
    }
    
    protected function check_status($shopid=0,$num=1,$type1='',$type2='',$type3=''){
        if (!$shopid) {
            return '商品id不存在';
        }
        if (!$this->user) {
            return '你还没登录';
        }
        $shop = $this->topic_model->getInfoByid($shopid);
        if($shop['end_time']){
            if (!is_numeric($shop['end_time'])) {
                $shop['end_time'] = strtotime($shop['end_time']);
            }
            if ($shop['end_time']<time()) {
                return '已经过期了!';
            }
        }
        
        if ($shop['stocktype']==2){
            $shop['fewnum'] = count_time_num($shopid,input('order_day'),input('order_tid'));
            $shop['max_user'] = get_time_num(input('order_tid')) ?: $shop['max_user'];
        }
        
        if( fun('shop@get_num',$shop,$type1-1)!==null ){  //设置了商品属性库存量的情况,以这个为标准
            if(fun('shop@get_num',$shop,$type1-1)-$num<0){
                return '该类型没库存了';
            }
        }elseif ($shop['max_user']>0 && $shop['fewnum']+$num>$shop['max_user'] ) {
            $limit_num = $shop['max_user']-$shop['fewnum'];
            return $limit_num<1 ? '没库存了!' : '库存不足,仅剩 '.$limit_num.' 份';
        }
        
        if($shop['begin_time']){
            if (!is_numeric($shop['begin_time'])) {
                $shop['begin_time'] = strtotime($shop['begin_time']);
            }
            if ($shop['mid']==4) {
                $total_num = MemberModel::where([
                    'aid'=>$shopid,
                    'order_id'=>$this->user['uid'],
                    'type'=>4,
                ])->count('id');
                if ($total_num) {
                    $shop['begin_time'] = $shop['begin_time']-$total_num*$shop['each_time'];
                    if ($shop['begin_time']>time()) {
                        return '需要到 '.date('Y-m-d H:i:s',$shop['begin_time']).' 才能抢购，你可以继续找人助力把秒杀时间再提前！';
                    }
                }else{
                    if ($shop['begin_time']>time()) {
                        return '秒杀时间还没到，但你可以找人助力抢先秒杀！';
                    }                    
                }
            }else{
                if ($shop['begin_time']>time()) {
                    return '活动还没有开始!';
                }
            }
        }
        $info = ContentModel::getInfoByid($shopid);
        if ($info['onlybuyone']) {
            if ($num>$info['onlybuyone']) {
                return '每人最多只可购买 '.$info['onlybuyone'].' 份';
            }
            $map = [
                'uid'=>$this->user['uid'],
                'shopid'=>$shopid,
            ];
            if ($info['stocktype']==1) {    //按天统计库存
                $map['create_time'] = fun('time@only','day',1);
            }elseif ($shop['stocktype']==2){
                $map['order_day'] = input('order_day');
                $map['order_tid'] = input('order_tid');
            }
            $buynum = OrderModel::where($map)->sum('shopnum');
            if (($buynum+$num)>$info['onlybuyone']) {
                return '每人最多只可购买 '.$info['onlybuyone'].' 份，你的订单中已经有 '.$buynum.' 份了，如果还没付款的话，请到订单那里付款即可';
            }
        }
        return true;
    }
}

