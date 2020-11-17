<?php
namespace app\gongdan\model;

use app\common\model\C;

//模型内容处理
class Content extends C
{
    /**
     * 删除单条内容
     * @param number $id 内容ID
     * @param number $mid 模型ID,可为空
     * @return boolean
     */
    public static function deleteData($id=0,$mid=0){
        $result = parent::deleteData($id,$mid);
        
        //删除订单
        Order::where('shop','like',$id.'-%')->delete();
        
        return $result;
    }
}
