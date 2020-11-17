<?php
namespace app\shop\model;

use app\common\model\Order AS _Order;
use app\shop\model\Fx AS FxModel;
use app\shop\model\Fxlog AS FxlogModel;


class Order extends _Order
{    
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
            self::send_snscode($order_info,$shopid,$num);
            
            $shop_info = Content::getInfoByid($shopid); //商品信息
            
            $_type1--;
            if($_type1>=0 && fun('shop@get_num',$shop_info,$_type1)!==null ){ //属性一设置了库存量的情况
                $_num = fun('shop@get_num',$shop_info,$_type1)-$num;
                Content::updates($shopid,[
                    'type1'=>fun('shop@get_num',$shop_info,$_type1,$_num)
                ]);  //成功下订单的总数量
            }
            
            
            if ($shop_info['num']<1) {  //库存为0,下架处理
                Content::editData($shop_info['mid'],[
                    'id'=>$shopid,
                    'status'=>0,
                ]);
            }
            
            self::fx($order_info,$shop_info,$num);               //处理分销
            if ($shop_info['qmoney']>0) {   //存在赠送圈币
                $allow = false;
                if ($shop_info['ext_id'] && fun('qun@getByid',$shop_info['ext_id'])['uid']==$shop_info['uid']) {    //必须是商家自己的圈子
                    $allow = true;
                }
                if (!$allow) {
                    $_array = fun('qun@getByuid',$shop_info['uid']);    //商家创建的所有圈子, 没指定的话,就默认第一个
                    if ($_array[0]['id']) {
                        $shop_info['ext_id'] = $_array[0]['id'];
                        $allow = true;
                    }
                }
                if ($allow) {
                    self::give_qmoney($shop_info['ext_id'],$order_info['uid'],$shop_info['qmoney'],$shop_info['title']);
                }
            }
        }
    }
    
    
    /**
     * 赠送圈币
     * @param number $aid
     * @param number $uid
     * @param number $money
     * @param string $title
     */
    protected static function give_qmoney($aid=0,$uid=0,$money=0,$title=''){
        $user = get_user($uid);
        if(!$user['qun_group'][$aid]){
            $obj = new \app\qun\index\wxapp\Member;            
            $obj->join($aid);
        }
        fun('qun@money',$aid,$uid,$money,"购买{$title}赠送");
    }
    
    
    /**
     * 分销处理
     * @param array $order_info 订单信息
     * @param array $shop 商品信息
     * @param number $num 每个商品购买数量
     */
    protected static function fx($order_info=[],$shop=[],$num=1){
        self::fx_user($order_info,$shop,$step=1,$num);  //直接推荐,一级分销奖励
        self::fx_user($order_info,$shop,$step=2,$num);  //间接推荐,二级分销奖励
        self::fx_user($order_info,$shop,$step=3,$num);  //三级分销奖励
    }
    
    /**
     * 各级分销处理 奖励
     * @param array $order_info 订单信息
     * @param array $shop 商品信息
     * @param number $step 第几级推荐人
     * @param number $num 每个商品购买数量
     */
    protected static function fx_user($order_info=[],$shop=[],$step=1,$num=1){
        $money = $shop['fx'.$step] * $num;  //分销金额,同一个商品如果有多份,就要翻倍处理
        $fx_uid = $order_info['introducer_'.$step]; //分销者

        if ($money<0.01) {  //分销金额不存在
            return ;
        }elseif( empty($fx_uid) ){ //分销者不存
            return ;
        }
        
        //分销金额,不能大于订金金额
        if( $money > $order_info['pay_money'] ) {
            send_msg($shop['uid'],'分销失败','分销金额不能大于订单金额');
            return ;
        }elseif( ($shop['fx1']+$shop['fx2']+$shop['fx3'])*$num > $order_info['pay_money'] ) {
            send_msg($shop['uid'],'分销失败','各级分销的总金额不能大于订单金额');
            return ;
        }
        
        $webdb = config('webdb.M__' . self::$model_key);
        if ($webdb['allow_fx_group']) {         //做了分销用户组权限设置
            $_user = get_user( $fx_uid );        //分销者的信息,判断是否享受分销权限
            if (!in_array($_user['groupid'], $webdb['allow_fx_group'])) {
                send_msg($shop['uid'],'无效分销',$_user['username'].'所在用户组不享受分销奖励');
                return ;    //该用户组不享受分销权限。不做奖励
            }
        }
        
        $shoper = get_user( $shop['uid'] );
        if ($shoper['rmb']<$money) { //商家余额不足以支付分销款
            send_msg($shop['uid'],'分销失败','你的余额不足以抵扣分销金额:'.$money.'元');
            return ;
        }
        
        $buy_username = get_user_name($order_info['uid']);  //购买者的信息
        
        add_rmb($shop['uid'],-$money,0,'分销扣款: ' . $shop['title']);      //对商家扣款
        add_rmb($fx_uid,$money,0,'分销给 ' . $buy_username . ' 获利 ,商品是:' . $shop['title']);     //对分销者奖励
        
        //给商家发信息
        $content = get_user_name($fx_uid) . ' 成功分享你的商品 '.$shop['title'].' 给 '.$buy_username.' 购买,因此扣除你的分销款 '.$money.' 元(本次属于 '.$step.' 级推荐)';
        send_msg($shop['uid'],'商品分销成功', $content );
        send_wx_msg($shop['uid'], $content);
        
        if ($step==1) { //对最后推荐人做个标志,下次不再重复奖励,只奖励再次推荐的人,也可以是上次的推荐人,或推荐注册的人
            $map = [
                'uid'=>$order_info['uid'],
                'aid'=>$shop['id'],
                'ifbuy'=>0,
            ];
            $_rs = FxModel::where($map)->order('create_time','desc')->find();
            if ($_rs) {
                FxModel::where('id',$_rs['id'])->update(['ifbuy'=>1]);
            }
        }
        
        $data = [
            'uid'=>$order_info['uid'],  //购买者UID
            'introducer_uid'=>$fx_uid, //推荐者UID,可以是一二三级推荐人
            'aid'=>$shop['id'],
            'money'=>$money,
            'introducer_step'=>$step,
        ];
        FxlogModel::create($data);
        
        //给分享者发信息
        $title = $content = '你分享 ' . $shop['title'] . '给 ' . $buy_username . '成功购买,获得了 '.$step.' 级分销利润 ' . $money . ' 元';
        send_msg($fx_uid,$title,$content);
        send_wx_msg($fx_uid, $content);
    }

    /**
     * 发放消费密码
     * @param array $order_info 订单信息
     * @param number $shopid 商品ID
     * @param number $num 购买数量
     */
    protected static function send_snscode(&$order_info=[],$shopid=0,$num=1){
        $info = Content::getInfoByid($shopid);
        if ($info['sncode']) {
            $info['sncode'] = str_replace("\r", '', trim($info['sncode'], " \r\n") );
            $array = [];
            $i = 0;
            $detail = explode("\n",$info['sncode']);
            foreach($detail AS $key=>$value){                
                if ($i<$num) {
                    $array[] = "“{$value}”";
                    unset($detail[$key]);
                }
                $i++;
            }
            Content::editData($info['mid'],[
                'id'=>$shopid,
                'mid'=>$info['mid'],
                'sncode'=>implode("\r\n", $detail),
            ]);
            $order_info['shipping_code'] = ($order_info['shipping_code']?"{$order_info['shipping_code']}\r\n":'').implode("\r\n", $array);
            Order::update([
                'id'=>$order_info['id'],
                'shipping_code'=>$order_info['shipping_code'],
            ]);
            $title = "你购买 {$info['title']} 的消费密码如下:";
            $content = implode("\r\n", $array) . "\r\n请注意保密,别泄露出去!";
            send_msg(
                $order_info['uid'],
                $title,
                str_replace("\r\n", '<br>', $title."<br>".$content)
            );
            send_wx_msg($order_info['uid'], $title."\r\n".$content);
        }
    }
}