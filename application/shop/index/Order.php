<?php
namespace app\shop\index;

use app\common\controller\index\Order AS _Order;
use app\shop\model\Content AS ContentModel;
use app\shop\model\Fx AS FxModel;

//下单
class Order extends _Order
{
    /**
     * 提交提交订单
     * {@inheritDoc}
     * @see \app\common\controller\index\Order::add()
     */
    public function add(){
        $result = $this->check_buy();
        if ($result!==true) { //检查用户是否有库存
            $this->error($result);
        }
        return parent::add();
    }
    
    
    /**
     * 处理推荐人,推荐注册人,并不是终身享益,中间如果有推荐人的话,就暂时中断收益.
     * @param array $data 订单入库信息
     * @param array $shop_array 多个商品信息
     */
    protected function add_shoper_begin(&$data=[],$shop_array=[]){
        parent::add_shoper_begin($data,$shop_array);
        $ids = [];  //某个商家里边的订单可能有多个商品
        foreach ($shop_array AS $rs){
            $ids[] = $rs['id'];
        }
        $map = [
            'uid'=>$this->user['uid'],
            'aid'=>['in',$ids], //只要有一个商品是他推荐的即符合
            'ifbuy'=>0,         //避免重复奖励
        ];
        $_rs = FxModel::where($map)->order('create_time','desc')->find();
        if ($_rs) { //最后分享链接的推荐人
            $data['introducer_1'] = $_rs['introducer_1'];
            $_user = get_user($_rs['introducer_1']);
            $_user['introducer_1'] && $data['introducer_2'] = $_user['introducer_1'];
            $_user['introducer_2'] && $data['introducer_3'] = $_user['introducer_2'];
        }else{  //若不存在最后分享推荐人,就奖励最开始的注册推荐人
            $data['introducer_1'] = $this->user['introducer_1'];
            $data['introducer_2'] = $this->user['introducer_2'];
            $data['introducer_3'] = $this->user['introducer_3'];
        }
    }
    
    /**
     * 付款之后返回的页面
     * @param string $orders_id 订单ID,可能有多个订单
     * @param number $ispay 是否支付成功
     */
    public function endpay($orders_id = '',$ispay=1){
        return parent::endpay($orders_id,$ispay);
    }
    
    /**
     * 下单后执行的
     * {@inheritDoc}
     * @see \app\common\controller\index\Order::end_add()
     */
    protected function end_add($order_ids=[],$car_ids=[],$car_db=[]){
        foreach($car_db AS $rs){
            ContentModel::addField($rs['shopid'],'order_num',true,$rs['num']);  //更新下订数量
        }
        return parent::end_add($order_ids,$car_ids,$car_db);
    }
    
    /**
     * 检查库存是否充足
     * @return string|boolean
     */
    protected function check_buy(){
        $listdb = $this->car_model->getList($this->user['uid'],1);
        foreach ($listdb AS $uid=>$shop_array){
            foreach ($shop_array AS $rs){
                if( $rs['_car_']['type1']>0 && fun('shop@get_num',$rs,$rs['_car_']['type1']-1)!==null ){
                    if(fun('shop@get_num',$rs,$rs['_car_']['type1']-1)-$rs['_car_']['num']<0){
                        return '该类型库存不足!';
                    }
                }elseif ($rs['num']<1) {
                    return $rs['title'] . ' 该商品库存为0,无法购买';
                }elseif ($rs['_car_']['num']>$rs['num']){
                    return $rs['title'] . ' 该商品库存为'.$rs['num'].',你选购的数量不能超过它';
                }
            }
        }
        return true;
    }
    
}

