<?php
namespace app\shop\index;

use app\common\controller\index\Car AS _Car;
use app\shop\model\Content AS ContentMode;

//购物车
class Car extends _Car
{
    /**
     * 购物车主页
     * {@inheritDoc}
     * @see \app\common\controller\index\Car::index()
     */
    public function index(){
        return parent::index();
    }
    
    public function act($shopid=0,$type=''){
        return parent::act($shopid,$type);
    }
    
    
    protected function check_status($shopid=0,$num=1,$type1=0,$type2=0,$type3=0){
        $info = ContentMode::getInfoByid($shopid);
        if(empty($info)){
            return '商品不存在!';
        }
        if( $type1>0 && fun('shop@get_num',$info,$type1-1)!==null ){
            if(fun('shop@get_num',$info,$type1-1)-$num<0){
                return '该类型没库存了';
            }
        }elseif ($info['num']<1) {
            return '很抱歉,库存为0,无法购买!';
        }elseif ($num>$info['num']) {
            return '购买数量,不能超过库存量!';
        }
        return parent::check_status($shopid,$num,$type1,$type2,$type3);
    }
}

