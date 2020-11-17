<?php
namespace app\yuyue\model;

use app\common\model\Order AS _Order;
use app\common\model\User AS UserModel;
//use app\common\util\Shop AS ShopFun;
use app\yuyue\model\Fx AS FxModel;
use app\yuyue\model\Fxlog AS FxlogModel;

class Order extends _Order
{
    /**
     * 标签取数据
     * @param array $tag_array
     * @return unknown
     */
    public static function get_label($tag_array=[]){
        $map = [];
        $cfg = unserialize($tag_array['cfg']);
        $rows = $cfg['rows']?:10;
        if($cfg['where']){  //用户自定义的查询语句
            $_array = fun('label@where',$cfg['where'],$cfg);
            if($_array){
                $map = array_merge($map,$_array);
            }
        }
        if ($cfg['order']=='totalmoney'&&$cfg['by']=='desc') {
            $order = 'totalmoney desc';
        }elseif ($cfg['order']=='totalmoney') {
            $order = 'fewmoney ASC,pay_money ASC';
        }else{
            $order = 'id desc';
        }
        $data_list = self::where($map)->order($order)->paginate($rows);        
        return $data_list;
    }
    
    /**
     * 获取订单信息
     * {@inheritDoc}
     * @see \app\common\model\Order::getList()
     */
    public function getList($map=[],$rows=20,$getall=false){
        if ($getall) {
            $array = self::where($map)->order('id','desc')->column(true);
            return $array;
        }
        $data_list = self::where($map)->order('id','desc')->paginate($rows,false,['query'=>input('get.')]);
        $data_list->each(function(&$rs,$key){
            $rs['shop_db'] = [];
            if($rs['shop']!=''){
                $rs['shop_db'] = static::getshop($rs['shop']);
            }
            //这里只考虑一个订单只有一个商品的情况
            $rs = get_order_totalmoney($rs['shop_db'][0],$rs);
//             if($rs['shop_db'][0]['each_money']>0 && $rs['shop_db'][0]['fewnum']>$rs['shop_db'][0]['min_user']){    //设置了随人数的增加,价格不断的减少
//                 list($shopid,$num,$type1,$type2,$type3) = explode('-',$rs['shop']);
//                 $price = ShopFun::get_price($rs['shop_db'][0],$type1-1); //具体某个商品并且选择了某个型号的实际价格
//                 $price = get_now_price($rs['shop_db'][0],$price);   //当前的拼团价
//                 $rs['totalmoney'] = $rs['pay_money'] = ( $price - $rs['shop_db'][0]['fewmoney'] ) * $num;
//             }
            
            return $rs;
        });
        return $data_list;
    }
    
    /**
    * 统计当前时间段的售出量
    * @param number $id 商品ID
    * @param number $day 预约日期
    * @param number $tid 时间段ID
    * @param unknown $ifpay 是否统计已付费的
    * @return unknown
    */
    public static function count_time_num($id=0,$day=0,$tid=0,$ifpay=null){
        $map = [
            'shopid'=>$id,
            'order_day'=>$day,
            'order_tid'=>$tid,
        ];
        if ($ifpay!==null) {
            $map['few_ifpay'] = $ifpay;
        }
        return self::where($map)->sum('shopnum');
    }
    
    /**
     * 在线支付余款
     * @param string $ids 订单的话
     * @return boolean
     */
    public static function pay($ids=''){
        return parent::pay($ids);
    }
    
    /**
     * 在线支付订金
     * @param string $id 订单ID
     * @return boolean
     */
    public static function payfew($id=0){
        $info = getArray(self::get(['id'=>$id]));     //订单信息
        if (empty($info)) {
            return '资料有误';
        }
        if ($info['few_ifpay']) {   //已经支付过了
            return true;
        }
        
        $user = UserModel::get_info($info['uid']);
        if($info['fewmoney']>0 && $user['rmb']<$info['fewmoney']){    //钱不够扣,终止以下所有操作
            return '余额不足';
        }
        
        
        $shop = Content::getInfoByid($info['shopid']);  //商品信息
        
        //用户扣款 , 订金暂时放在平台,暂不给商家,只给商家一个冻结余款供参考
        if($info['fewmoney']>0){            
            if ($shop['mid']==3) {
                $msg = '交拍卖保证金 ';
            }elseif($shop['pay_money']!=0){
                $msg = '预交订金 ';
            }else{
                $msg = '支付货款 ';
            }
            $msg .= $shop['title'];
            add_rmb($info['uid'],-abs($info['fewmoney']),0,$msg);
            add_rmb($info['shop_uid'],0,abs($info['fewmoney']),$user['username'].$msg.',冻结暂不可用'); //仅供记帐参考
        }
        
        //更新成功下订数量，二次开发务必注意，一个订单如果有多个商品,将不适用!!
        //做个标志,订金已支付
        self::update([
            'id'=>$id,
            'few_ifpay'=>1,
            //'pay_status'=>$shop['pay_money']==0?1:0
        ]);
        
        
        $info['shopnum'] || $info['shopnum']=1;
        $_data = [
            'fewnum'=>$shop['fewnum']+$info['shopnum'],
        ];
        if ($shop['stocktype']==2){   //预约模式
            $shop['fewnum'] = self::count_time_num($shop['id'],$info['order_day'],$info['order_tid']);
        }
        $fewnum = $shop['fewnum']+$info['shopnum'];
        
        list($_shopid,$_num,$_type1) = explode('-',$info['shop']);
        $_type1--;
        if($_type1>=0 && fun('shop@get_num',$shop,$_type1)!==null ){ //属性一设置了库存量的情况
            $_num = fun('shop@get_num',$shop,$_type1)-$_num;
            $_data['type1'] = fun('shop@get_num',$shop,$_type1,$_num);
        }
        Content::updates($info['shopid'],$_data);  //成功下订单的总数量
        
        if ($info['fewmoney']>0) {
            $title = $user['username'].' 订购 '.$shop['title'].' 付'.($info['pay_money']==0?'全款':'订金').'了';
            $content = $user['username']." 订购 {$shop['title']} ，付".($info['pay_money']==0?'全款':'订金')."了，<a href=\"".get_url(murl(self::$model_key.'/kehu_order/show',['id'=>$id]))."\">点击查看详情</a>";
        }else{
            $title = $user['username'].' 订购了 '.$shop['title'];
            $content = $user['username']." 订购了 {$shop['title']} ，<a href=\"".get_url(murl(self::$model_key.'/kehu_order/show',['id'=>$id]))."\">点击查看详情</a>";
        }
        //给商家发信息
        send_msg($info['shop_uid'],$title,$content);
        send_wx_msg($info['shop_uid'], $content);
        
        //给预定者发信息
        if ($info['pay_money']!=0 && $shop['paytype']==0) {     //分期付款,需要另外再付余额 $data['paytype'] 的值 为0即分期付款(可线下付尾款)  1即一次性线上付全款  2即预约(线上不付款)
            $title = '感谢你预定 '.$shop['title'];
            if($shop['mid']==2){
                $content = "成功报名参与砍价 {$shop['title']}，砍价期限是 ".$shop['limit_day']." 天，请及时砍价，过期将不能砍价，若不想购买,订金可随时申请退还。<a target=\"_blank\" href=\"".get_url(iurl(self::$model_key.'/content/show',['id'=>$info['shopid'],'oid'=>$id]))."\">点击查看详情</a>";
            }elseif($shop['mid']==3){
                $content = "成功报名参与竟拍 {$shop['title']}，请及时跟进出价,才有可能中拍。中拍后请及时交尾款，否则保证金会被系统没收。若不中标，保证金会退还。<a target=\"_blank\" href=\"".get_url(iurl(self::$model_key.'/content/show',['id'=>$info['shopid']]))."\">点击查看详情</a>";
            }elseif($info['tun_type']==-1){ //单独购买
                $content = "成功预定 {$shop['title']}，你是单独购买,可以直接支付尾款，你可以进入订单详情，现在交尾款，<a href=\"".get_url(murl(self::$model_key.'/order/show',['id'=>$id]))."\">点击查看详情</a>";
            }else{
                if($fewnum>=$shop['min_user']){     //成功组团
                    $content = "成功预定 {$shop['title']}，本商品已成功组团，订金不可退还，请注意及时交尾款，你可以进入订单详情，现在交尾款，<a href=\"".get_url(murl(self::$model_key.'/order/show',['id'=>$id]))."\">点击查看详情</a>";
                }else{
                    $content = "成功预定 {$shop['title']}，本商品还没有成团暂时不可交尾款，请耐心等候，或者推荐身边人进来组团，若不成团，可申请退还订金，成团后会另行通知，成团后请及时进入订单详情交尾款，<a href=\"".get_url(murl(self::$model_key.'/order/show',['id'=>$id]))."\">点击查看详情</a>";
                }
            }
            send_msg($info['uid'],$title,$content);
            send_wx_msg($info['uid'], $content);
        }else{  //竟拍不会执行这里,竟拍必须要交订金,也不是一次性付款
            $title = '感谢你预定 '.$shop['title'];
            if ($shop['mid']==2) {
                $content = "免费报名成功参与砍价 {$shop['title']}，砍价期限是 ".$shop['limit_day']." 天，请及时砍价，过期将不能砍价。<a target=\"_blank\" href=\"".get_url(iurl(self::$model_key.'/content/show',['id'=>$info['id'],'oid'=>$id]))."\">点击查看详情</a>";
            }else{
                if($info['fewmoney']>0){    //需要网上付款 一次性付款, 不需分期
                    if($info['tun_type']==-1){ //单独购买
                        $content = "恭喜你，单独购买 {$shop['title']} 成功，<a href=\"".get_url(murl(self::$model_key.'/order/show',['id'=>$id]))."\">点击查看详情</a>";
                    }elseif($fewnum>=$shop['min_user']){
                        $content = "恭喜你，成功订购 {$shop['title']}，本商品已成功组团，不可退款，<a href=\"".get_url(murl(self::$model_key.'/order/show',['id'=>$id]))."\">点击查看详情</a>";
                    }else{
                        $content = "感谢你预定 {$shop['title']}，本商品还没有成团，请耐心等候，或者推荐身边人进来组团，若不成团，可申请退全款，成团后会另行通知，成团后不可退款，<a href=\"".get_url(murl(self::$model_key.'/order/show',['id'=>$id]))."\">点击查看详情</a>";
                    }
                }else{  //$info['fewmoney']==0 订金为0 免费预定
                    if($info['tun_type']==-1){ //单独购买
                        $content = "恭喜你，单独购买预定 {$shop['title']} 成功，请及时联系商家，<a href=\"".get_url(murl(self::$model_key.'/order/show',['id'=>$id]))."\">点击查看详情</a>";
                    }elseif($fewnum>=$shop['min_user']){
                        $content = "恭喜你，成功预定 {$shop['title']}，已成功组团，请及时联系商家，<a href=\"".get_url(murl(self::$model_key.'/order/show',['id'=>$id]))."\">点击查看详情</a>";
                    }else{
                        $content = "感谢你预定  {$shop['title']} ，还没有成团，请耐心等候，或者推荐身边人进来组团，若不成团，订单会失效，成团后会另行通知，<a href=\"".get_url(murl(self::$model_key.'/order/show',['id'=>$id]))."\">点击查看详情</a>";
                    }
                }
            }            
            send_msg($info['uid'],$title,$content);
            send_wx_msg($info['uid'], $content);                
        }
        
        if($info['tun_type']==-1){ //单独购买
            if ($info['pay_money']==0){      //不需要付余款的情况 $info['pay_money'] 是由商品价格减订金的结果,因为订金等于商品价格了 免费线上预约订金为0但要付余款的
                self::final_buy($info);
            }
        }elseif (!in_array($shop['mid'], [2,3]) && $fewnum>=$shop['min_user'] ) { //成功组团      
            if( $shop['fewnum']<$shop['min_user'] ){    // 刚好成团 ,群发消息通知
                self::send_all_user($shop);     //给参与预定的用户发送成功组团信息
                
                //下面是给商家发信息 给商家发送成功组团信息
                $title = $shop['title'].' 成功组团了';
                $content = '恭喜你,你发布的 ' . $shop['title'] . " 成功组团了,<a href=\"".get_url(urls(self::$model_key.'/content/show',['id'=>$info['shopid']]))."\" target=\"_blank\">点击查看详情</a>"; 
                send_msg($info['shop_uid'],$title,$content);
                send_wx_msg($info['shop_uid'], $content);
            }else{
                if ($info['pay_money']==0){      //成团以后,不需要付余款的情况 $info['pay_money'] 是由商品价格减订金的结果,因为订金等于商品价格了 免费线上预约订金为0但要付余款的
                    self::final_buy($info);     //必须成团以后才可以处理, 现在成团了
                }
            }
        }
        
        return true;
    }
    
    /**
     * 成功组团群发通知
     * @param array $info 商品信息
     */
    private static function send_all_user($info=[]){
        $id = $info['id'];
        $map = [
                'shopid'=>$id,      //二次开发务必注意，一个订单如果有多个商品,将不适用!!
                'few_ifpay'=>1,
        ];
        set_time_limit(0);  //发送微信消息比较耗时
        $listdb = self::where($map)->column(true);
        foreach($listdb AS $rs){
            $title = '你预定的 '.$info['title'] .' 组团成功了';
            $content = "恭喜你，你预定的  {$info['title']}  成功组团了,<a href=\"".get_url(urls(self::$model_key.'/content/show',['id'=>$id]))."\" target=\"_blank\">点击查看详情</a>";
            send_msg($rs['uid'],$title,$content);
            send_wx_msg($rs['uid'], $content);
            
            //不需要付余款的情况 免费线上预约订金为0但要付余款的
            if ($rs['pay_money']<0.01) {
                self::final_buy($rs);
            }
            
        }
    }
    
    /**
     * 成团以后才执行 不需要付余款的情况
     * 交易结束,,因为余款为0 前提条件是pay_money所需支付的余款为0
     * @param array $order_info
     */
    private static function final_buy($order_info=[]){
        
        //因为余款为0所以成团以后付的订金,就当作是交易成功了
        self::update([
                'id'=>$order_info['id'],
                'pay_status'=>1,
                'pay_time'=>time(),
        ]);        
        
        
        $shop = Content::getInfoByid($order_info['shopid']);
        
        //商家入帐 订金转给商家
        if ($order_info['fewmoney']>0) {
            add_rmb($order_info['shop_uid'],0,-$order_info['fewmoney'],'解冻货款订金:'.$shop['title']);
            add_rmb($order_info['shop_uid'],$order_info['fewmoney'],0,'销售'.$shop['title']);
            
            $title = '会员: '.get_user_name($order_info['uid']).' 购买 '.$shop['title'].' 的货款已转入你的帐户.';
            $content = '你发布的 ' . $shop['title'] . " 会员: ".get_user_name($order_info['uid'])." 购买的货款已转入你的帐户,<a href=\"".get_url(murl(self::$model_key.'/kehu_order/show',['id'=>$order_info['id']]))."\">点击查看详情</a>";
            send_msg($order_info['shop_uid'],$title,$content);
            send_wx_msg($order_info['shop_uid'], $content);
            
            self::fx($order_info,$shop);  //分销处理
        }
        
        self::give_sncode($order_info,$shop);   //自动发放订单号
    }
    
    
    /**
     * 线下核销
     * @param array $order_info 订单信息
     */
    public static function he_xiao($order_info=[]){
        if ($order_info['receive_status']!=0) {
            return '已经核销过了!';
        }
        $array = [
            'id'=>$order_info['id'],
            'receive_time'=>time(),
            'receive_status'=>1,    //即是收货的意思
            'hexiao_uid'=>login_user('uid'),    //核销者帐号
        ];
        
        //这里只考虑一个订单只有一个商品的情况
        $_order_info = get_order_totalmoney($order_info['shop_db'][0],$order_info);     //统计成团后随人数增加,价格下降的情况
        if ($_order_info['pay_money'] && $_order_info['pay_money']<$order_info['pay_money']) {
            $array['pay_money'] = $array['totalmoney'] = $_order_info['pay_money'];
            $order_info = $_order_info;
        }
        
        self::update($array);
        
        //$order_info['pay_money']大于0代表需要支付余款的情况,线下付余款,如果 $order_info['pay_money'] 为0的话,就代表不是分期付款,钱已转给商家的了
        //另外这里要判断是否已付订金才可以的. 预约是0首付,线下付余款,就不适合做分销处理了.
        if ($order_info['pay_money']!=0 && $order_info['pay_status']==0 && $order_info['few_ifpay']==1) {
            $shop = Content::getInfoByid($order_info['shopid']);
            //商家入帐 订金转给商家 余款是线下交易的,不作处理
            add_rmb($order_info['shop_uid'],0,-$order_info['fewmoney'],'解冻订金 '.$shop['title']);
            if ($order_info['pay_money']<0) {   //拍卖补差额的情况
                add_rmb($order_info['shop_uid'],$order_info['fewmoney']+$order_info['pay_money'],0,'订金 '.$shop['title']);
                add_rmb($order_info['uid'],-$order_info['pay_money'],0,'退还差额 '.$shop['title']);
                $order_info['fewmoney'] = $order_info['fewmoney']+$order_info['pay_money']; //给分销做判断使用,实际支付补差额后订金要少一点
            }else{
                //因为没有线上付余款.所以只给商家订金.
                add_rmb($order_info['shop_uid'],$order_info['fewmoney'],0,'订金 '.$shop['title']);
            }                        
            $order_info['pay_money'] = 0; //给分销做判断使用,避免分销金额大于订金. 其中 预约是0首付,线下付余款,就不能做分销处理了.
            self::fx($order_info,$shop);  //分销处理            
            self::give_sncode($order_info,$shop);   //自动发放订单号
        }
        return true;
    }
    
    /**
     * 余款支付成功,不是订金
     * (重写父方法)
     * @param array $order_info 订单信息,不是商品信息
     */
    protected static function success_pay($order_info=[]){
        
        $shop = Content::getInfoByid($order_info['shopid']);
        
        //扣除购买者的款 $order_info['pay_money'] 是余款,不包含订金
        add_rmb($order_info['uid'],-$order_info['pay_money'],0,($order_info['pay_money']<0?'拍卖退差额:':'购物:').$shop['title']);
        
        //商家入帐 订金一起转给商家
        add_rmb($order_info['shop_uid'],$order_info['pay_money']+$order_info['fewmoney'],0,'销售'.$shop['title']);
        add_rmb($order_info['shop_uid'],0,-$order_info['fewmoney'],'解冻订金:'.$shop['title']);
        
        $title = '会员: '.get_user_name($order_info['uid']).' 购买 '.$shop['title'].' 付余款了';
        $content = '你发布的 ' . $shop['title'] . " 会员: ".get_user_name($order_info['uid'])." 付余款了,<a href=\"".get_url(murl(self::$model_key.'/kehu_order/show',['id'=>$order_info['id']]))."\">点击查看详情</a>";
        send_msg($order_info['shop_uid'],$title,$content);
        send_wx_msg($order_info['shop_uid'], $content);
        
        self::fx($order_info,$shop);  //分销处理
        
        self::give_sncode($order_info,$shop);   //自动发放订单号
    }
    
     /**
     * 分销处理
     * 注意免费预约是0首付,线下付余款,就不能做分销处理的.
     * 首付金额必须要大于分销金额,否则会出问题
     * @param array $order_info 订单信息
     * @param array $shop 商品信息
     */
    protected static function fx($order_info=[],$shop=[]){
        self::fx_user($order_info,$shop,$step=1);
        self::fx_user($order_info,$shop,$step=2);
        self::fx_user($order_info,$shop,$step=3);
    }
    
    /**
     * 分销处理用户奖励
     * @param array $order_info 订单信息
     * @param array $shop 商品信息
     * @param number $step 第几级推荐人
     */
    protected static function fx_user($order_info=[],$shop=[],$step=1){
        if (empty($order_info['introducer_'.$step]) || empty($shop['fx'.$step])) {
            return ;
        }
        if ($shop['fx'.$step]<0) {  //分销金额不能是负数
            return ;
        }
        $shop['fx'.$step] = abs($shop['fx'.$step]);
        //分销金额,不能大于商品价格
        if( $shop['fx'.$step] > ($order_info['pay_money']+$order_info['fewmoney']) ) {
            send_msg($shop['uid'],'分销失败','分销金额不能大于订金与余款之和,线下付款的话,不能大于订金');
            return ;
        }elseif( ($shop['fx1']+$shop['fx2']+$shop['fx3']) > ($order_info['pay_money']+$order_info['fewmoney']) ) {
            send_msg($shop['uid'],'分销失败','各级分销的总金额不能大于订金与余款之和,线下付款的话,不能大于订金');
            return ;
        }
        $webdb = config('webdb.M__' . self::$model_key);        
        if ($webdb['allow_fx_group']) {
            $_user = get_user( $order_info['introducer_'.$step] ); 
            if (!in_array($_user['groupid'], $webdb['allow_fx_group'])) {
                send_msg($shop['uid'],'无效分销',$_user['username'].'所在用户组不享受分销奖励');
                return ;    //该用户组不享受分销权限。不做奖励
            }
        }
        $shoper = get_user( $order_info['shop_uid'] );
        if ($shoper['rmb']<$shop['fx'.$step]) { //商家余额不足以支付分销款
            send_msg($shop['uid'],'分销失败','你的余额不足以抵扣分销金额:'.$shop['fx'.$step].'元');
            return ;
        }
        
        if ($step==1 && $order_info['youhui_money']>0) {
            add_rmb($order_info['shop_uid'],$order_info['youhui_money'],0,'优惠券补贴: ' . $shop['title']);  //对商家的优惠券补贴，实质最后也会抵消掉，这里只是方便做个日志
        }
        
        $buy_username = get_user_name($order_info['uid']);
        add_rmb($order_info['shop_uid'],-$shop['fx'.$step],0,'分销扣款: ' . $shop['title']);      //对商家扣款
        add_rmb($order_info['introducer_'.$step],$shop['fx'.$step],0,'分销给 ' . $buy_username . ' 获利 ' . $shop['title']);     //对分销者奖励
        send_msg($shop['uid'],'商品分销成功', get_user_name($order_info['introducer_'.$step]) . ' 成功分享你的商品 '.$shop['title'].' 给 '.$buy_username.' 购买,因此扣除你的分销款 '.$shop['fx'.$step].' 元(本次属于 '.$step.' 级推荐)' );
        
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
        
        $give_money = $shop['fx'.$step];
        
        $msg = '';
        if($step==1 && $order_info['youhui_money']>0){
            add_rmb($order_info['introducer_'.$step],-$order_info['youhui_money'],0,'优惠券扣除: ' . $shop['title']);
            $msg = ",但因为使用了你的优惠券而扣除了 {$order_info['youhui_money']} 元分销提成";
            $shop['fx'.$step] -= $order_info['youhui_money']; //日志那里也要减去
            $give_money -= $order_info['youhui_money'];
        }
        
        $data = [
            'uid'=>$order_info['uid'],
            'introducer_uid'=>$order_info['introducer_'.$step],
            'aid'=>$shop['id'],
            'money'=>$shop['fx'.$step],
            'introducer_step'=>$step,
        ];
        FxlogModel::create($data);
        
        $title = $content = '你分享 ' . $shop['title'] . '给 ' . $buy_username . '获得了 '.$step.' 级分销利润 ' . $shop['fx'.$step] . ' 元'.$msg;
        send_msg($order_info['introducer_'.$step],$title,$content);
        send_wx_msg($order_info['introducer_'.$step], $content);
        
        //分销直接提现
        if($give_money>=0.3 && $webdb['fxmoney_givetype']==1){
            $fx_user = get_user($order_info['introducer_'.$step]);
            if ($fx_user['weixin_api']!='') {
                $array = [
                    'money'=>$give_money,
                    'title'=>'分销提成',
                    'id'=>$fx_user['weixin_api'],
                ];
                $res = \app\common\util\Weixin::gave_moeny($array);
                if($res===true){
                    add_rmb($fx_user['uid'],-$give_money,0,'分销提现');
                }
            }
        }
    }
    
    /**
     * 发送注册码
     * 这里一个订单只发一个注册码,如果多个商品的话,需要另外特别处理发送多个注册码 要注意修改 shipping_code 字段的长度
     * @param array $order_info 订单信息,不是商品信息
     * @param array $info 商品信息
     */
    protected static function give_sncode($order_info=[],$info=[]){
        if ($info['sncode']) {
            $array = explode("\n",$info['sncode']);
            $code_array = [];
            foreach ($array AS $key=>$value){
                $value = trim($value,"　    \r");
                if (empty($value)) {
                    continue;
                }
                $code_array[] = $value;
                unset($array[$key]);
                if (count($code_array)>=$order_info['shopnum']) {
                    break;
                }
            }
            if (empty($code_array)) {
                return ;
            }
            $code = implode("、", $code_array);
            //更新订单信息
            self::update([
                'id'=>$order_info['id'],
                'shipping_status'=>1,
                'shipping_code'=>$code,
            ]);
            $str = implode("\r\n", $array);
            Content::updates($order_info['shopid'],['sncode'=>$str]);
            
            $title = $info['title'].' 消费码已发放，请注意查收';
            $url = get_url(murl(self::$model_key.'/order/show',['id'=>$order_info['id']]));
            $content = '你购买的 ' . $info['title'] . ' 共计 '. count($code_array) ." 份，消费码如下:{$code}，请注意保密，不要泄露出去，<a href=\"$url\">点击查看详情获取消费二维码</a>";
            send_msg($order_info['uid'],$title,$content);
            send_wx_msg($order_info['uid'], $content);
        }
         
    }
    
    
}