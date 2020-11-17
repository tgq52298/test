<?php
namespace app\miaosha\index;

use app\common\controller\index\Car AS _Car;
use app\miaosha\model\Log AS LogModel;
use app\miaosha\model\Order AS OrderModel;

//购物车
class Car extends _Car
{
    public function index(){
        return parent::index();
    }
    
    /**
     * 检查是否可以抢购,成功则返回还可以抢购的数量
     * @param number $shopid
     * @return string|number
     */
    public function check_can_buy($shopid=0){
        if (!$this->user) {
            return '请先登录';
        }
        $info = $this->topic_model->getInfoById($shopid);
        if (empty($info)) {
            return '商品不存在';
        }elseif ($info['begin_time']>time()){
            return '活动还没开始';
        }elseif ($info['num']<1){
            return '库存为0';
        }
        
        $haveBuyNum = $this->get_stock_num($shopid);
        
        if (empty($haveBuyNum)){
            return '已经被抢光了!';
        }
        return $haveBuyNum;
    }
    
    /**
     * 统计可以购买的数量 返回数量,包括0
     * @param number $shopid
     * @return number
     */
    protected function get_stock_num($shopid=0){
        $info = $this->topic_model->getInfoById($shopid);
        if ($info['num']<1) {
            return 0;
        }
        $haveBuyNum = 0; //已抢购的数量
        $listdb = LogModel::where('shopid',$shopid)->order('id desc')->column(true);
        foreach ($listdb AS $rs){
            if ( (time()-$rs['create_time'])<1800 ) {   //半小时内的不判断是否支付.都算已抢成功
                $haveBuyNum += $rs['num'];
            }else{  //超过半小时的,如果还没支付,就把订单删除
                $ifpay = OrderModel::where('id',$rs['order_id'])->value('pay_status');
                if (empty($ifpay)) {
                    OrderModel::destroy($rs['order_id']);
                    LogModel::destroy($rs['id']);
                }else{
                    $haveBuyNum += $rs['num'];
                }
            }
        }
        if ($haveBuyNum>=$info['num']){
            return 0;
        }
        return $info['num'] - $haveBuyNum;
    }
    
    /**
     * 前台页面显示可购买的数量
     * @param number $shopid
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function check_num($shopid=0){
        $result = $this->get_stock_num($shopid);
        return $this->ok_js($result);
    }
    
    //使之失效
    public function act($shopid=0,$type=''){        
    }
    
    /**
     * 新增加商品到购物车
     * {@inheritDoc}
     * @see \app\common\controller\index\Car::add()
     */
    public function add($shopid=0,$num=1,$type1='',$type2='',$type3=''){
        $result = $this->check_can_buy($shopid);
        if (!is_numeric($result)) {
            return $this->err_js($result);
        }
        if ($num>1) {
            return $this->err_js('限购一件');
        }
        return parent::add($shopid,$num,$type1,$type2,$type3);
    }
    
    /**
     * 更改购买车里的商品数量
     * {@inheritDoc}
     * @see \app\common\controller\index\Car::change_num()
     */
    public function change_num($shopid=0,$num=1){
        if ($num>1) {
            return $this->err_js('限购一件');
        }
        return parent::change_num($shopid,$num);
    }
}

