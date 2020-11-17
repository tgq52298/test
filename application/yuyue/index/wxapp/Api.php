<?php
namespace app\yuyue\index\wxapp;

use app\common\controller\index\wxapp\Api AS _Api; 
use app\yuyue\model\Time AS TimeModel;

//常用接口
class Api extends _Api
{
    /**
     * 根据具体某一天的日期,获取相应的时间段
     * @param string $day
     * @return void|unknown|\think\response\Json
     */
    public function get_time_byday($day='2020-12-12',$type=0,$uid=0){
        $week = date('N',strtotime($day));
        $array = TimeModel::where('uid',$uid?:$this->user['uid'])->where('type',$type)->where('week','in',[0,$week])->column(true);
        return $this->ok_js(array_values($array));
    }
}













