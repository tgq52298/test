<?php
namespace app\yuyue\index;

use app\common\controller\index\Order AS _Order;
use app\yuyue\model\Content AS ContentModel;
//use app\yuyue\model\Member;
use app\yuyue\model\Order AS OrderModel;
use app\yuyue\model\Fx AS FxModel;
use app\yuyue\model\Yhlog AS YhlogModel;
use app\yuyue\model\Youhui AS YouhuiModel;

//下单
class Order extends _Order
{
    /**
     * 下订单
     * @param number $id 商品ID
     * @param string $buytype 多人可开团
     * @param number $order_day 按日期预约
     * @param number $order_tid 按时间段预约
     */
    public function add($id=0,$buytype='',$order_day=0,$order_tid=0){
        if (empty($this->user)) {
            $this->error('请先登录!');
        }
        
        $listdb = $this->car_model->getList($this->user['uid'],1,false);        
        
        if($this -> request -> isPost()){
            $data = $this -> request -> post();
            $result = $this->check_post_filed($data);
            if ($result!==true) {
                $this->error($result);
            }
            
            $data = \app\common\field\Post::format_all_field($data,-1); //对一些特殊的字段进行处理,比如多选项,以数组的形式提交的
            unset($data['pay_status'],$data['pay_money'],$data['fewmoney'],$data['few_ifpay'],$data['agree']);
            $order_ids = [];
            $car_ids = [];  //购买车里的数据
            
            if ($order_day) {
                $data['order_day'] = $order_day;
                $data['order_tid'] = $order_tid;                
            }
            
            
            $info = [];     //实际上只有一条订单记录,即只能是一个商家的商品.
            //$total_money = 0;   //需要支付的总金额
            foreach ($listdb AS $uid=>$shop_array){     //实际上只有一条记录 , 多条记录会出问题
                $data['shop_uid'] = $uid;   //店主UID
                $_shop = [];
                $money = 0;  //余款数额
                $duihuan_rmb = 0;
                foreach ($shop_array AS $rs){   //特别要注意,只能一条记录 , 不支持多条记录
                    
                    if ($rs['stocktype']==2){   //预约模式
                        $rs['fewnum'] = count_time_num($rs['id'],$order_day,$order_tid);
                        $rs['max_user'] = get_time_num($order_tid) ?: $rs['max_user'];
                    }
                    
                    $info = $rs;
                    $result = check_buytime($rs);
                    if ($result!==true) {
                        $this->error($result);
                    }elseif( fun('shop@get_num',$rs,$rs['_car_']['type1']-1)!==null ){
                        if(fun('shop@get_num',$rs,$rs['_car_']['type1']-1)-$rs['_car_']['num']<0){
                            return '该类型没库存了';
                        }
                    }elseif($rs['max_user']>0){
                        //$num = $this->order_model->where(['shopid'=>$rs['id'],'few_ifpay'=>1])->count('id');
                        $num = $rs['fewnum'];
                        if($num>=$rs['max_user']){
                            $this->error('已经超过人数上限了!');
                        }
                    }
                    
                    if($rs['onlybuyone']){ //限购几份
                        $_map = [
                            'shopid'=>$rs['id'],
                            'uid'=>$this->user['uid'],
                        ];                        
                        $msg = '本商品设置了一人只能购买 '.$rs['onlybuyone'].' 份,如果你还没有付款,请找到之前的订单进行付款即可';
                        if ($rs['stocktype']==2){   //预约模式
                            $_map['order_day'] = $order_day;
                            $_map['order_tid'] = $order_tid;
                            $msg = '当前时间段,每人只能预约 '.$rs['onlybuyone'].' 份,如果你还没有付款,请找到之前的订单进行付款即可';
                        }elseif ($rs['stocktype']==1){ //按天统计库存
                            $_map['create_time'] = fun('time@only','day',1);
                            $msg = '本商品每天每人只能预约 '.$rs['onlybuyone'].' 份,如果你还没有付款,请找到之前的订单进行付款即可';
                        }
                        if($this->order_model->where($_map)->sum('shopnum')>$rs['onlybuyone']){
                            $this->error($msg);
                        } 
                    }
                    
                    $_shop[] = $rs['_car_']['shopid'] . '-' . $rs['_car_']['num']  . '-' . $rs['_car_']['type1'] . '-' .$rs['_car_']['type2'] . '-' .$rs['_car_']['type3'];
                    $real_price = fun('shop@get_price',$rs,$rs['_car_']['type1']-1);  //实际价格,因为不同尺寸价格可能不一样
                    
                    
                    if ($info['mid']==6) {
                        $data['tun_type'] = $buytype;
                        if ($buytype>0) {
                            $map2 = [
                                'id'=>intval($buytype),
                                'tun_type'=>-2,
                                'few_ifpay'=>1,
                            ];
                            $_qs = $this->order_model->where($map2)->find();
                            if (!$_qs) {
                                $this->error('团长信息有误,可能是还没付款');
                            }elseif(count_join_num($buytype)+1>=$info['min_user']){
                                $this->error('很抱歉,本团满人了!你可以选择重新开团');
                            }
                        }
                        if ($data['tun_type']==-1) {    //单独购买
                            $real_price = $info['market_price'];
                        }
                    }else{
                        $data['tun_type'] = 0;
                    }
                    
                    if ($data['user_jf']>0) {
                        if ($info['limitmoney']<0.01 || $info['money_scale']<1) {
                            $this->error('系统没有设置积分兑换!');
                        }elseif($this->user['money']<$data['user_jf']){
                            $this->error('你的积分只有 '.$this->user['money'].' 个');
                        }elseif($data['user_jf'] > $info['limitmoney'] * $info['money_scale'] * $rs['_car_']['num']){
                            $this->error('你要兑换的积分不能超过 '.($info['limitmoney'] * $info['money_scale'] * $rs['_car_']['num']).' 个');
                        }
                        $duihuan_rmb = sprintf("%.2f",$data['user_jf']/$info['money_scale']);
                    }
                    if ($info['paytype']==1) {          //一次性付费
                        $real_price = get_now_price($info,$real_price);
                        $rs['fewmoney'] = $real_price;             //订金价格就是实际金额
                    }elseif($info['price_changetype']==2){      //先买先优惠的情况
                        $real_price = get_now_price($info,$real_price);
                    }
                    $money += ($real_price-$rs['fewmoney']) * $rs['_car_']['num'];      //余款要减去订金                    
                    $car_ids[] = $rs['_car_']['id'];
                    $data['fewmoney'] = $rs['fewmoney'] * $rs['_car_']['num'];  //需要支付的订金
                    
                    if ($duihuan_rmb>0) {
                        if ($money>$duihuan_rmb) {
                            $money -= $duihuan_rmb;
                        }elseif($data['fewmoney']>=$duihuan_rmb){
                            $data['fewmoney'] -= $duihuan_rmb;
                        }elseif($data['fewmoney']+$money<$duihuan_rmb){
                            $this->error('兑换的积分超过了商品价格');
                        }else{
                            $money = $money - ($duihuan_rmb - $data['fewmoney']);
                            $data['fewmoney'] = 0;
                        }
                    }
                    
                    //商品ID与购买数量都记录了,所以只适合单条记录
                    $data['shopid'] = $rs['_car_']['shopid'];
                    $data['shopnum'] = $rs['_car_']['num'];
                    //把商品的型号写入订单,避免商家修改商品信息到时显示不一致
                    $_rs = fun('shop@car_get_price_type',$rs,['num'=>$rs['_car_']['num'],'type1'=>$rs['_car_']['type1'],'type2'=>$rs['_car_']['type1'],'type3'=>$rs['_car_']['type1']]);
                    $data['shoptitle'] = $_rs['title']."<i> {$_rs['_type1']} {$_rs['_type2']} {$_rs['_type3']}</i>";
                }
                
                $data['shop'] = implode(',', $_shop);
                $data['order_sn'] = 's'.date('ymdHis').rands(3);      //订单号
                
                
                $data['youhui_money'] = 0;
                if ($data['yid']) {
                    $youhui_db = YhlogModel::list_yh($info['id'],$this->user['uid']);  //可用的优惠券
                    if ($youhui_db[0]['id']!=$data['yid']) {
                        $this->error('优惠券不存在!');
                    }elseif($youhui_db[0]['money']>$info['fewmoney'] && $youhui_db[0]['money']>$info['price']){
                        $this->error('优惠券不能大于商品金额!');
                    }elseif($youhui_db[0]['money']>$info['fx1']){
                        $this->error('优惠券不能大于分销金额!');
                    }
                    $data['youhui_money'] = $youhui_db[0]['money'];
                    $data['youhui_id'] = $data['yid'];
                    YhlogModel::where('id',$data['yid'])->update([
                        'ifuse'=>1,
                        'use_time'=>time(),
                    ]);
                    
                    $youhui_info = getArray(YouhuiModel::where('id',$youhui_db[0]['yid'])->find());  //谁创建的优惠券信息
                    
                    $yh_user = get_user($youhui_info['uid']);
                    $data['introducer_1'] = $yh_user['uid'];
                    $data['introducer_2'] = $yh_user['introducer_1'];
                    $data['introducer_3'] = $yh_user['introducer_2'];
                    
                    if ($data['fewmoney']>0&&$info['paytype']!=2) { //需要支付订金(也包括一次性付全款,即订金等于全款),但不是免费预约线下付全款
                        if ($info['paytype']==1) {  //一次性付全款,订金等于全款,余款是为0的
                            $data['fewmoney'] -= $data['youhui_money'];
                        }else{  //实际就是 $info['paytype']=0
                            if ($data['fewmoney']>$data['youhui_money']) {  //订金大于优惠券的时候,就订金直接抵扣
                                $data['fewmoney'] -= $data['youhui_money'];
                            }else{
                                $money -= $data['youhui_money'];
                                if ($money<0.01) {
                                    $money = 0;
                                }
                            }                            
                        }
                    }elseif($info['paytype']==2){   //免费预约线下付全款,订金为0
                        $money -= $data['youhui_money'];
                    }
                    
                }else{
                    $map = [
                        'uid'=>$this->user['uid'],
                        'aid'=>$data['shopid'],
                        'ifbuy'=>0, //避免重复奖励
                    ];
                    $_rs = FxModel::where($map)->order('create_time','desc')->find();
                    if ($_rs) { //最后分享链接的推荐人
                        $data['introducer_1'] = $_rs['introducer_1'];
                        $_user = get_user($_rs['introducer_1']);
                        $data['introducer_2'] = $_user['introducer_1'];
                        $data['introducer_3'] = $_user['introducer_2'];
                    }else{  //注册推荐人
                        $data['introducer_1'] = $this->user['introducer_1'];
                        $data['introducer_2'] = $this->user['introducer_2'];
                        $data['introducer_3'] = $this->user['introducer_3'];
                    }
                }
                
                if ($info['money_type']==1 && $info['qun_money']>0) {
                    if ($this->user['qun_group'][$info['ext_id']]['money']<$info['qun_money']) {
                        $this->error('你的圈币不足 '.$info['qun_money'].' 个');
                    }
                    $data['qun_money'] = $info['qun_money'];                    
                }
                
                $data['totalmoney'] = $data['pay_money'] = $money;   //需要支付的余款
                //$total_money +=$money;
//                 if (!empty($this -> validate)) {// 验证表单
//                     $result = $this -> validate($data, $this -> validate);
//                     if (true !== $result) $this -> error($result);
//                 }
                $data['uid'] = $this -> user['uid'];
                $data['create_time'] = time();                
                
                if ($result = $this->order_model->create($data)) {
                    $order_ids[] = $result->id;
                }
            }
            
            $this->end_add($order_ids,$car_ids);     //扩展使用
            
            if (!empty($order_ids)) {
                if ($duihuan_rmb>0) {
                    add_jifen($this->user['uid'],-$data['user_jf'],'购买'.$info['title']);
                    add_jifen($info['uid'],$data['user_jf'],'销售'.$info['title']);
                }
                if ($info['money_type']==1 && $info['qun_money']>0) {
                    fun('qun@money',$info['ext_id'],$this->user['uid'],-$info['qun_money']*$data['shopnum'],'订购:'.$info['title']);
                }
                $_id = $order_ids[0];
                //if ($data['ifolpay']==1) {     //在线支付
                if ($data['fewmoney']>0&&$info['paytype']!=2) {  //需要支付订金(也包括一次性付全款,即订金等于全款),但不是免费预约线下付全款 2是免费预约线下付全款
                    post_olpay([
                            'money'=>$data['fewmoney'],
                            //'money'=>'0.01',    //调试
                            'return_url'=>url('end_few',['id'=>$_id]),
                            'banktype'=>'',//in_weixin() ? 'weixin' : 'alipay' , //在微信端,就用微信支付,否则就用支付宝支付
                            'numcode'=>$data['order_sn'],
                            'callback_class'=>mymd5('app\\'.config('system_dirname').'\\model\\Order@payfew@'.$_id),
                    ],true);
                }elseif($info['paytype']==2 || $data['fewmoney']==0){   //免费预约线下付全款
                    OrderModel::payfew($_id);
                }
                $this->order_ok($id);
                //$this -> success('订单提交成功', url('index/index'));
            } else {
                $this -> error('订单提交失败');
            }
        }
        
        
        //提交表单前要用到的代码
        $info = [];     //实际上只有一条订单记录,即只能是一个商家的商品.
        foreach ($listdb AS $uid=>$shop_array){     //实际上只有一条记录 , 多条记录会出问题
            foreach ($shop_array AS $rs){   //只有一条记录 , 不支持多条记录
                $info = $rs;
                if ($rs['end_time'] && $rs['end_time']<time()) {
                    $this->error('活动已经结束了!');
                }
                
                if ($rs['stocktype']==2){   //预约模式
                    $rs['fewnum'] = count_time_num($rs['id'],$order_day,$order_tid);
                    $rs['max_user'] = get_time_num($order_tid) ?: $rs['max_user'];
                }
                
                if( fun('shop@get_num',$rs,$rs['_car_']['type1']-1)!==null ){
                    if(fun('shop@get_num',$rs,$rs['_car_']['type1']-1)-$rs['_car_']['num']<0){
                        return '该类型没库存了';
                    }
                }elseif($rs['max_user']>0){
                    //$num = $this->order_model->where(['shopid'=>$rs['id'],'few_ifpay'=>1])->count('id');
                    $num = $rs['fewnum'];
                    if($num>=$rs['max_user']){
                        $this->error('已经超过人数上限了!');
                    }
                }
                
                if($rs['onlybuyone']){ //限购几份
                    $_map = [
                        'shopid'=>$rs['id'],
                        'uid'=>$this->user['uid'],
                    ];
                    $msg = '本商品设置了一人只能购买 '.$rs['onlybuyone'].' 份,如果你还没有付款,请找到之前的订单进行付款即可';
                    if ($rs['stocktype']==2){   //预约模式
                        $_map['order_day'] = $order_day;
                        $_map['order_tid'] = $order_tid;
                        $msg = '当前时间段,每人只能预约 '.$rs['onlybuyone'].' 份,如果你还没有付款,请找到之前的订单进行付款即可';
                    }elseif ($rs['stocktype']==1){ //按天统计库存
                        $_map['create_time'] = fun('time@only','day',1);
                        $msg = '本商品每天每人只能预约 '.$rs['onlybuyone'].' 份,如果你还没有付款,请找到之前的订单进行付款即可';
                    }
                    if($this->order_model->where($_map)->sum('shopnum')>$rs['onlybuyone']){
                        $this->error($msg);
                    }
                }
                
                if ($info['money_type']==1) {
                    if (empty($info['ext_id'])) {
                        $info['ext_id'] = fun('qun@getByuid',$info['uid'])[0]['id'];
                        ContentModel::updates($info['id'],['ext_id'=>$info['ext_id'],'ext_sys'=>modules_config('qun')['id']]);
                    }
                    if($info['limit_qungroup']){
                        $qinfo = fun('qun@get_my_group',$this->user['uid'],$info['ext_id']);
                        if ($info['limit_qungroup']==1 && $qinfo['type']<1) {
                            $this->error('你不是圈内正式成员,不能预定!');
                        }elseif ($info['limit_qungroup']==4 && $qinfo['type']<2) {
                            $this->error('你不是圈内VIP成员,不能预定!');
                        }
                    }
                    if ($info['qun_money']>0 && $this->user['qun_group'][$info['ext_id']]['money']<$info['qun_money']) {
                        $this->error('你的'.fun('qun@moneyname',$info['ext_id']).'不足 '.$info['qun_money'].' 个');
                    }
                }
            }
        }
        
        $youhui_db = YhlogModel::list_yh($info['id'],$this->user['uid']);  //可用的优惠券
        
        $this->assign('info',$info);
        $this->assign('youhui_db',$youhui_db); //可用的优惠券
        $this->assign('f_array',$this->get_order_field($info));
        
        return $this ->fetch();
    }
    
    protected function get_order_field($info=[]){
        if (empty($info)) {
            return ;
        }
        $array = json_decode($info['order_filed'],true);
        if (empty($array)){
            return ;
        }
        $data = [];
        foreach($array AS $key=>$rs){
            if ($rs['type']=='select' || $rs['type']=='checkbox') {
                $detail = explode("\n",$rs['options']);
                $opt = [];
                foreach($detail AS $value){
                    $opt[$value] = $value;
                }
            }else{
                $opt='';
            }
            $data[] = [
                'type'=>$rs['type'],
                'name'=>'order_field_'.$key,
                'title'=>$rs['title'],
                'about'=>'',
                'options'=>$opt,
                'ifmust'=>$rs['must'],
                'customize'=>'customize',
            ];
        }
        return $data;
    }

    /**
     * 支付订金成功后,返回的操作
     * @param number $id 订单ID
     * @param number $ispay 1是支付成功,0是支付失败
     */
    public function end_few($id=0,$ispay=1){
        if ($ispay==0) {
            $this->error('支付失败',urls('content/show',['id'=>$id]),[],3);
        }else{
            $result = OrderModel::payfew($id);
            if ($result!==true){
                $this->error($result);
            }else{                
                //$url = murl('order/index');
                //$this->success('下定成功,请及时交余款',$url);
                $this->order_ok($id);
            }
        }        
    }
    
    /**
     * 成功提交订单
     * @param number $id 订单ID
     */
    private function order_ok($id=0){
        $oinfo = OrderModel::where('id',$id)->find();
        $info = ContentModel::getInfoByid($oinfo['shopid']);
        if ($info['mid']==2) {
            $this->success('下单成功,请现在可以邀请好友砍价了',urls('content/show',['id'=>$info['id'],'oid'=>$id]));
        }elseif ($info['mid']==3) {
            $this->success('报名成功,请现在可以参与竟拍了',urls('content/show',['id'=>$info['id']]));
        }else{
            $this->success('订单已提交',murl('order/index'));
        }
    }

    
    public function endpay($order_id = ''){
        //return parent::endpay($order_id);
    }
}

