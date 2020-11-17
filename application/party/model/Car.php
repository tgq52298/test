<?php
namespace app\party\model;
use app\common\model\Car AS _Car;
use app\common\util\Shop AS ShopFun;

class Car extends _Car
{
    
    /**
     * 获取用户的购物车数据 , 商家UID是一维数组下标,购物车及商品在二维数组那里
     * @param number $uid 购买者的UID
     * @param unknown $choose_type 是否只获取选中要购买的商品
     * @param string $format 是否对商品数据进行显示转义
     * @return array
     */
    public static function getList($uid=0,$choose_type=null,$format=true){
        empty(self::$model_key) && self::InitKey();
        $map = [
                'uid'=>$uid,
        ];
        if($choose_type!==null){    //获取购物车中 选中或者是全部 商品
            $map['ifchoose'] = intval($choose_type);
        }
        
        $list_data = self::where($map)->order('update_time','desc')->column(true);  //用户的购物车数据
        //$field = [];
        foreach ($list_data AS $rs){
            $shop = self::$content_model->getInfoByid($rs['shopid'],$format);    //取得商品的详细数据
            if(empty($shop)){
                self::destroy($rs['id']);   //若不存在,就把购物车记录删除
                continue ;
            }elseif($shop['end_time']){
                if (!is_numeric($shop['end_time'])) {
                    $shop['end_time'] = strtotime($shop['end_time']);
                }
                if ($shop['end_time']<time()) {
                    self::destroy($rs['id']);   //已过期,就把购物车记录删除
                    continue ;
                }
            }elseif($shop['begin_time']){
                if (!is_numeric($shop['begin_time'])) {
                    $shop['begin_time'] = strtotime($shop['begin_time']);
                }
                if ($shop['begin_time']>time()) {
                    self::destroy($rs['id']);   //还没开始,就把购物车记录删除
                    continue ;
                }
            }
            
            unset($shop['content'],$shop['full_content']);
            $shop['picurl'] && $shop['picurl'] = tempdir($shop['picurl']);
            
            ShopFun::car_get_price_type($shop,$rs);     //对价格与商品属性进行处理,得到实际商品属性的价格
            
            //为了后续方便扩展多商家店铺,把商家的UID做为一维数组下标
            $listdb[$shop['uid']][$rs['id']] = array_merge($shop,['_car_'=>$rs]);
        }
        return $listdb;
    }
}