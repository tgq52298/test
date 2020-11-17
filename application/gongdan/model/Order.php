<?php
namespace app\gongdan\model;

use app\common\model\Order AS _Order;


class Order extends _Order
{
    
    /**
     * 订单列表
     * @param array $map
     * @param number $rows
     * @param number $getall
     * @param number $mapOR 或者查询条件
     * @return unknown
     */
    public function getList($map=[],$rows=20,$getall=0,$mapOR=[]){
        if(empty($mapOR)){
            return parent::getList($map,$rows,$getall);
        }
        if ($getall) { //主要是导出时使用
            $array = self::where($map)->where(function($q) use($mapOR){
                $q->whereOr($mapOR);
            })->order('id','desc')->column(true);
            return $array;
        }
        $data_list = self::where($map)->where(function($q) use($mapOR){
            $q->whereOr($mapOR);
        })->order('id','desc')->paginate($rows,false,['query'=>input('get.')]);
        $data_list->each(function($rs,$key){
            $rs['shop_db'] = [];
            if($rs['shop']!=''){
                $rs['shop_db'] = static::getshop($rs['shop']);
            }
            return $rs;
        });
        return $data_list;
    }
    
    /**
     * 支付成功,资金变动 , 也可以增加消息通知
     * @param array $order_info 订单信息,不是商品信息
     */
    protected static function success_pay($order_info=[]){
        parent::success_pay($order_info);
        
        //下面做更新库存处理  避免用户恶意下单减少库存,所以只有付款后,才减少库存
        $detail = explode(',',$order_info['shop']);
        foreach($detail AS $value){
            list($shopid,$num,$_type1) = explode('-',$value);
            $num || $num=1;
            Content::addField($shopid,'num',false,$num);    //更新库存
            
            $shop_info = Content::getInfoByid($shopid); //商品信息
            
            $_type1--;
            if($_type1>=0 && fun('shop@get_num',$shop_info,$_type1)!==null ){ //属性一设置了库存量的情况
                $_num = fun('shop@get_num',$shop_info,$_type1)-$num;
                Content::updates($shopid,[
                    'type1'=>fun('shop@get_num',$shop_info,$_type1,$_num)
                ]);  //成功下订单的总数量
            }          
        }
    }
    
    protected static function send_msg($order_info=[]){        
    }
}