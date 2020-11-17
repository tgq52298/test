<?php 
use app\common\util\Shop AS ShopFun;
use app\yuyue\model\Order AS OrderModel;
use app\yuyue\model\Time AS TimeModel;

if(!function_exists('get_shop_type')){
    /**
     * 取得商品属性 , $key 为 null 的话,商品内容页使用,全部列出给用户选择
     * @param string $type              属性类型,可以是 type1 type2 type3 分别可以为尺寸\颜色\长短
     * @param array $info               商品主表的内容信息
     * @param unknown $key          为null的话,商品详情页使用,所有各项参数展示出来,为数值的话,就是用户选中购买的具体类型
     * @param string $result_type   要取得属性的名称,还是价格,一般都是名称.
     * @return void|array|unknown[]|array[]
     */
    function get_shop_type($type='type1',$info=[],$key=null,$result_type='title'){
        return ShopFun::type_get_title_price($type,$info,$key,$result_type);
    }    

    /**
     * 获取当前团购价 成团后,每增加一个人就会减少一定的金额 或者 先买先优惠的情况
     * @param array $info 商品信息
     * @param number $user_choose_price 不为0的时候,代表是用户选中某个型号的具体价格
     * @return unknown
     */
    function get_now_price($info=[],$user_choose_price=0){
        $user_choose_price>0 || $user_choose_price = $info['price'];
        if($info['price_changetype']==2 && $info['price_grow']!=''){  //早买早优惠
            $info['price_grow'] = str_replace(["\r",'－'], ['','-'], trim($info['price_grow'],"\r\n"));
            $detail = explode("\n",$info['price_grow']);
            foreach($detail AS $value){
                list($nums,$money) = explode('=',$value);
                $money = intval($money);
                if (is_numeric($nums)) {
                    $min = $max = $nums;
                }else{
                    list($min,$max) = explode('-', $nums);
                }
                $n = $info['fewnum']+1;
                if ($n>=$min && $n<=$max) {
                    $real_price = $user_choose_price-$money;
                    return $real_price<0?0:$real_price;
                }
            }
            return $user_choose_price;
        }elseif ($info['price_changetype']==1 && $info['each_money']>0 && $info['fewnum']>$info['min_user']) {  //成团后,每增加一个人就会减少一定的金额
            $price = $user_choose_price-($info['fewnum']-$info['min_user'])*$info['each_money'];
            if ($price<$info['bottom_price']) {
                $price = $info['bottom_price'];
            }
            return $price;
        }else{
            return $user_choose_price;
        }
    }
    
    /**
     * 统计用户订单实际需要支付的余额   成团后,每增加一个人就会减少一定的金额
     * @param array $shop_info 具体某个商品的信息
     * @param array $order_info 某条订单的信息
     * @return number
     */
    function get_order_totalmoney($shop_info=[],$order_info=[]){
        if($shop_info['price_changetype']==1 && $shop_info['each_money']>0){    //设置了随人数的增加,价格不断的减少
            if ($shop_info['stocktype']==2){   //预约模式
                $shop_info['fewnum'] = count_time_num($shop_info['id'],$order_info['order_day'],$order_info['order_tid']);
                $shop_info['max_user'] = get_time_num($order_info['order_tid']) ?: $shop_info['max_user'];
            }
            if ( $shop_info['fewnum']>$shop_info['min_user']) {
                list($shopid,$num,$type1,$type2,$type3) = explode('-',$order_info['shop']);
                $price = ShopFun::get_price($shop_info,$type1-1); //具体某个商品并且选择了某个型号的实际价格
                $price = get_now_price($shop_info,$price);   //当前的拼团价
                $order_info['totalmoney'] = $order_info['pay_money'] = ( $price - $shop_info['fewmoney'] ) * $num;
            }            
        }
        return $order_info;
    }
    
    
    /**
     * 时间校验
     * @param array $info
     * @return string|boolean
     */
    function check_buytime($info=[]){
        if ($info['end_time']&&$info['end_time']<time()){
            return '活动已经结束了';
        }elseif ($info['stocktype']==1){    //按天统计的话,每天的下订人数都不一样
            if ($info['day_begintime'] && str_replace(':', '', $info['day_begintime'])>date('His')) {
                return '订购时间还没开始,请 '.$info['day_begintime'].' 后再来!';
            }elseif ($info['day_endtime'] && str_replace(':', '', $info['day_endtime'])<date('His')) {
                return '今天的订购时间于 '.$info['day_endtime'].' 结束了,请明天再来!';
            }            
        }
        return true;
    }
    
    /**
     * 统计参团人数
     * @param number $id 团长的订单ID
     * @return unknown
     */
    function count_join_num($id=0){
        static $array;
        if (isset($array[$id])) {
            return $array[$id];
        }
        $map = [
            'tun_type'=>intval($id),
            'few_ifpay'=>1,
        ];
        $num = OrderModel::where($map)->count('id');
        $array[$id] = $num;
        return $num;
    }
    
    /**
     * 获取可以预约的日期及时间段
     * @param array $info
     * @return mixed|array|unknown
     */
    function get_order_time($info=[],$is_search=false){
        $is_search=false;
        static $_data = [];
        if($_data[$info['id']]){
            return $_data[$info['id']];
        }
        if (empty($info['uid'])) {
            return [];
        }
        $map = [
            'type'=>intval($info['timesort']),
            'uid'=>$info['uid'],
        ];
        $data = $listdb = [];
        $_listdb = TimeModel::where($map)->column(true);
        //         if (empty($_listdb)) {
        //             return [];
        //         }
        foreach($_listdb AS $rs){
            $listdb[$rs['week']][] = $rs;
        }
        $info['order_timedays'] || $info['order_timedays']=7;
        $time = time() + intval($is_search ? -$info['order_timedays'] : $info['order_beginday'])*3600*24;
        $max = intval($is_search?$info['order_timedays']*2:$info['order_timedays']);
        $stop_array = [];
        if ($info['stop_yuyue_day']!='') {
            $detail = json_decode(str_replace(['-','－'],'',$info['stop_yuyue_day']),true);
            foreach($detail AS $value){
                list($sday,$stime) = explode('|', $value);
                $stime = trim($stime,',');
                $stop_array[$sday] = $stime?explode(',',$stime):[];
            }
        }
        for($i=0;$i<$max;$i++){
            //暂停预约的日期
            if (isset($stop_array[date('Ymd',$time)]) && empty($stop_array[date('Ymd',$time)])) {   //没设置暂停的时间段,就是暂停整天
                $time += 3600*24;
                $max++;
                continue;
            }
            $_array = [];
            if (empty($listdb) || $listdb[date('N',$time)] || $listdb[0]) {
                $_array['day'] = [
                    'title'=>date('m-d',$time).'(周'.get_status(date('w',$time),['日','一','二','三','四','五','六']).')',
                    'key'=>date('Ymd',$time),
                ];
            }
            $listdb[0] || $listdb[0] = [];
            $detail = $listdb[date('N',$time)] ? array_merge($listdb[0],$listdb[date('N',$time)]) : $listdb[0] ;
            foreach($detail AS $rs){
                if($stop_array[date('Ymd',$time)] && in_array($rs['id'], $stop_array[date('Ymd',$time)])){  //暂停了某个时间段
                    continue;
                }
                $_array['time'][] = $rs;
            }
            if ($_listdb && empty($_array['time'])) {
                $time += 3600*24;
                $max++;
                continue;
            }
            $data[] = $_array;
            $time += 3600*24;
        }
        $_data[$info['id']] = $data;
        return $data;
    }
    
    /**
     * 获取订单中预约的具体时间
     * @param array $order
     * @return string
     */
    function format_order_time($order=[]){
        $map = [
                'id'=>$order['order_tid'],
        ];
        $value = TimeModel::where($map)->value('name');
        return preg_replace("/^([0-9]{4})([0-9]{2})([0-9]{2})$/", "\\1-\\2-\\3", $order['order_day']) .' '. $value;
    }
    
    /**
     * 获取当前时间段的库存量
     * @param number $tid
     */
    function get_time_num($tid=0){
        return TimeModel::where('id',$tid)->value('num');
    }
    
    /**
     * 统计当前时间段的售出量
     * @param number $id 商品ID
     * @param number $day 预约日期
     * @param number $tid 时间段ID
     * @param unknown $ifpay 是否统计已付费的
     * @return unknown
     */
    function count_time_num($id=0,$day=0,$tid=0,$ifpay=null){
        return OrderModel::count_time_num($id,$day,$tid,$ifpay);
    }
}