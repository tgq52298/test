<?php
namespace app\yuyue\model;

use app\common\model\C;

//模型内容处理
class Content extends C
{
    /**
     * 通过ID获取某条内容数据
     * 这里主要是为了重新处理下订人数
     * @param number $id 内容ID
     * @param string $format 是否转义,比如修改内容就不要转义
     * @return void|\app\common\model\unknown|array|\think\db\false|PDOStatement|string|\think\Model
     */
    public static function getInfoByid($id=0,$format=FALSE){
        $info = parent::getInfoByid($id,$format);
        $info['fewnum'] = self::count_fewnew($info); //统计当前下订人数, 如果按天统计的话,每天的下订人数都不一样
        return $info;
    }
    
    /**
     * 统计当前下订人数, 如果按天统计的话,每天的下订人数都不一样
     * @param array $info
     * @return unknown
     */
    private static function count_fewnew($info=[]){
        if ($info['stocktype']==1) {    //按天统计库存
            $map = [
                'create_time'=>fun('time@only','day',1),
                'shopid'=>$info['id'],
            ];
            if ($info['paytype']==0||$info['paytype']==1) {
                $map['few_ifpay'] = 1;
            }
            $num = Order::where($map)->sum('shopnum');
            return $num;
        }else{
            return $info['fewnum'];
        }
    }
}
