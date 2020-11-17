<?php
namespace app\yuyue\index\wxapp;

use app\common\controller\index\wxapp\Car AS _Car; 
use app\yuyue\model\Content AS ContentModel;

//小程序购物车
class Car extends _Car
{
    public function count($id=0,$order_day=0,$order_tid=0,$type1=0){
        $shop = ContentModel::getInfoByid($id);
        if ($shop['stocktype']==2){  //按未来的时间段统计
            $shop['fewnum'] = count_time_num($id,input('order_day'),input('order_tid'));
            $shop['max_user'] = get_time_num(input('order_tid')) ?: $shop['max_user'];
        }
        return $this->ok_js([
            'sellnum'=>$shop['fewnum'],
            'totalnum'=>$shop['max_user'],
        ]);
    }
}













