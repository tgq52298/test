<?php
namespace app\party\index;

use app\common\controller\index\Order AS _Order;
use app\party\model\Content AS ContentModel;
//下单
class Order extends _Order
{
    public function add(){
        $money = $this->car_model->getMoney($this->user['uid']);
        $this->assign('money',$money);  //统计需要支付的金额
        return parent::add();
    }
    
    protected function end_add($order_ids=[],$car_ids=[],$car_db=[]){
        foreach($car_db AS $rs){
            ContentModel::addField($rs['shopid'],'order_num',true,$rs['num']);  //预定数量
        }
        parent::end_add($order_ids,$car_ids,$car_db);
    }
    
    /**
     * 付款之后返回的页面
     * @param string $orders_id 订单ID,可能有多个订单
     * @param number $ispay 是否支付成功
     */
    public function endpay($orders_id = '',$ispay=1){
        return parent::endpay($orders_id,$ispay);
    }
}

