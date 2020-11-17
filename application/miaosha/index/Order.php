<?php
namespace app\miaosha\index;

use app\common\controller\index\Order AS _Order;
use app\miaosha\model\Log;
use app\common\util\Shop AS ShopFun;
use app\miaosha\index\Car;
//下单
class Order extends _Order
{
    public function add() {
        if($this -> request -> isPost()){
            $data = $this -> request -> post();
            
            $order_ids = [];
            $listdb = $this->car_model->getList($this->user['uid'],1);
            
            $carObj = new Car();
            
            $total_money = 0;   //需要支付的总金额
            foreach ($listdb AS $uid=>$shop_array){     //取每一个商家的数据生成一个订单,不能同家不能混在同一个订单
                $data['shop_uid'] = $uid;   //店主UID
                $_shop = [];
                $money = 0;
                $logdb = [];    //秒杀记录
                foreach ($shop_array AS $rs){   //某个商家的多个商品
                    $_shop[] = $rs['_car_']['shopid'] . '-' . $rs['_car_']['num']  . '-' . $rs['_car_']['type1'] . '-' .$rs['_car_']['type2'] . '-' .$rs['_car_']['type3'];
                    $money += ShopFun::get_price($rs,$rs['_car_']['type1']-1)*$rs['_car_']['num'];
                   
                    //秒杀记录
                    $res = $carObj->check_can_buy($rs['_car_']['shopid']);
                    if (!is_numeric($res)) {
                        $this->error($res);
                    }elseif($res<$rs['_car_']['num']){
                        $this->error("你最多只能抢购".$res."件".$rs['title']);
                    }
                    $logdb[] = [
                            'car_id'=>$rs['_car_']['id'],
                            'shopid'=>$rs['_car_']['shopid'],
                            'num'=>$rs['_car_']['num'],
                            'uid'=>$this->user['uid'],
                            'create_time'=>time(),
                    ];
                }
                $data['shop'] = implode(',', $_shop);
                $data['order_sn'] = rands(10);      //订单号
                $data['totalmoney'] = $data['pay_money'] = $money;
                $total_money +=$money;
                if (!empty($this -> validate)) {// 验证表单
                    $result = $this -> validate($data, $this -> validate);
                    if (true !== $result) $this -> error($result);
                }
                $data['uid'] = $this -> user['uid'];
                $data['create_time'] = time();
                if ($result = $this->order_model->create($data)) {
                    $order_ids[] = $result->id;
                    //秒杀记录
                    foreach ($logdb as $ar) {
                        $this->car_model->destroy($ar['car_id']);   //删除购物车数据
                        unset($ar['car_id']);
                        $ar['order_id'] = $result->id;
                        Log::create($ar);
                    }
                    $this->send_msg($uid,$result->id,$shop_array);  //发消息通和商家
                }
            }
            
            if (!empty($order_ids)) {
                $url = '/';
                if ($data['ifolpay']==1) {
                    $order_ids = implode(',', $order_ids);
                    $url = post_olpay([
                            'money'=>$total_money,
                            //'money'=>'0.01',    //调试
                            'return_url'=>url('endpay',['orders_id'=>$order_ids]),
                            'banktype'=>'',//in_weixin() ? 'weixin' : 'alipay' , //在微信端,就用微信支付,否则就用支付宝支付
                            'numcode'=>$data['order_sn'],
                            'callback_class'=>mymd5('app\\'.config('system_dirname').'\\model\\Order@pay@'.$order_ids),
                    ]);
                }
                $this -> success('订单提交成功,请半小时内完成支付,否则订单会失效', $url);
            } else {
                $this -> error('订单提交失败');
            }
        }
        return $this ->fetch();
    }
    

}

