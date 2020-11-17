<?php
namespace app\qun\index\wxapp;

use app\qun\model\Order AS OrderModel;
use app\qun\model\Content AS ContentModel;
use app\qun\model\Member AS MemberModel;

class Viewtime extends Base
{
    /**
     * 统计自己在某个圈子里的可观看时间
     * @param number $aid 圈子ID
     */
    public function count_time($aid=0){
        $gtype = MemberModel::where('aid',$aid)->where('uid',$this->user['uid'])->value('type');
        if ($gtype>1) {
            $time = 9999999;
            $time_type = 2;
        }else{
            $time = OrderModel::limit_time($aid,$this->user['uid']);
            $time_type = 0;
            if (empty($time)) {
                $info = ContentModel::getInfoByid($aid);
                if ($info['free_time']>0 && empty(OrderModel::where('uid',$this->user['uid'])->where('aid',$aid)->find())) {
                    $time = $info['free_time']*60;
                    $data = [
                        'aid'=>$aid,
                        'timelong'=>$time,
                        'uid'=>$this->user['uid'],
                    ];
                    OrderModel::create($data);
                    $time_type = 1;
                }
            }
        }        
        return $this->ok_js([
            'time'=>$time,
            'time_type'=>$time_type,
        ]);
    }
    
    /**
     * 用户购买时长
     * @param number $aid
     * @param number $time
     */
    public function buy_time($aid=0,$time=0){
        $info = ContentModel::getInfoByid($aid);
        if (empty($info)) {
            return $this->err_js('圈子不存在');
        }elseif($info['minute_money']<0.0001){
            return $this->err_js('圈主还没有设置时长单价');
        }elseif($time<1){
            return $this->err_js('购买时长不能小于1分钟');
        }
        
        $money = $time*$info['minute_money'];
        if($money<0.01){
            return $this->err_js('购买时长太短了,还不足1分钱!');
        }
        if ($money>$this->user['rmb']) {
            $data = [
                'money'=>$money-$this->user['rmb'],
                'have_money'=>$this->user['rmb'],
            ];
            $_msg = $this->user['rmb']>0?'你的可用余额仅有 '.$this->user['rmb'].' 元，':'';
            return $this->err_js('你当前购买时长 '.$time.' 分钟，总共需要 '.$money.' 元，'.$_msg.'是否马上充值？',$data,2);
        }
        $timelong = $time*60; //转为单位秒
        $array = [
            'uid'=>$this->user['uid'],
            'timelong'=>$timelong,
            'aid'=>$aid,
        ];
        $reslt = OrderModel::create($array);
        if ($reslt) {
            add_rmb($this->user['uid'],-$money,'','购买直播课堂时长');
            add_rmb($info['uid'],$money,'',$this->user['username'].' 购买直播课堂时长');
            return $this->ok_js('购买成功');
        }else{
            return $this->err_js('购买失败');
        }
    }
}

