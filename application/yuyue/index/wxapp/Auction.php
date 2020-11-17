<?php
namespace app\yuyue\index\wxapp;

use app\common\controller\IndexBase;
use app\yuyue\model\Content AS ContentModel;
use app\yuyue\model\Order AS OrderModel;
use app\yuyue\model\Member AS MemberModel;

class Auction extends IndexBase
{
    /**
     * 观众给予的点赞加油助威
     * @param number $id 订单ID
     */
    public function come_on($id=0){
        if (empty($this->user)) {
            return $this->err_js('你还没登录!');
        }
        
        $key = 'comeon_limittime_'.$id.'-'.$this->user['uid'];
        $time = 3600*24;
        if( (time() - cache($key)) < $time ){            
            return $this->err_js("24小时内不要重复加油助威!");
        }
        
        
        $oinfo = OrderModel::where('id',$id)->find();
        $info = ContentModel::getInfoByid($oinfo['shopid']);
        if (empty($info)) {
            return $this->err_js('商品不存在!');
        }
        
        if (empty($oinfo)) {
            return $this->err_js('资料不存在!');
        }elseif ($info['end_time'] && time()>$info['end_time']) {
            return $this->err_js('活动已结束');
        }elseif($oinfo['few_ifpay']!=1){
            return $this->err_js('Ta报名后还没交保证金!');
        }
        
        cache($key,time(),$time);
        
        $result = MemberModel::create([
            'order_id'=>$oinfo['id'],
            'aid'=>$oinfo['shopid'],
            'type'=>2,
            'uid'=>intval($this->user['uid']),
        ]);
        OrderModel::where('id',$id)->update([
            'agree'=>$oinfo['agree']+1,
        ]);
        
        $name = $this->user['username'] ;
        
        add_jifen($oinfo['uid'],1,"{$name} 给你竟拍加油助威!");
        
        $wxcontent = "<a href=\"".get_url(urls('content/show',['id'=>$oinfo['shopid']]))."\">你参与的“{$info['title']}”竟拍活动，“{$name}”给你点赞呐喊助威了,系统给你奖励1个积分！点击查看详情</a>";
        send_wx_msg($oinfo['uid'],$wxcontent);
        send_msg($oinfo['uid'],'有人给你助威了',$wxcontent);
        
        if ($info['ext_id']) {
            $_data = [
                'qun_id'=>$info['ext_id'],
                'uid'=>$info['uid'],
                'ext_sys'=>M('id'),
                'ext_id'=>$info['id'],
                'content'=>"<div class=\"paimai_comon\"><div>拍卖实时播报：".$this->user['username']." 向 ".get_user_name($oinfo['uid'])." 喊加油!</div>[face13]</div>",
                ];
            \app\common\model\Msg::add($_data,false,true);
        }
        
        return $this->ok_js([
            'agree'=>$oinfo['agree']+1
        ],'感谢你加油助威,Ta获得了1个积分奖励');
    }
    
    /**
     * 拍卖出价
     * @param number $id 商品ID 
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function give($id=0,$money=0){
        if (empty($this->user)) {
            return $this->err_js('你还没登录!');
        }
        $info = ContentModel::getInfoByid($id);
        if (empty($info)) {
            return $this->err_js('商品不存在!');
        }
        
        $oinfo = OrderModel::where('shopid',$id)->where('uid',$this->user['uid'])->order('id desc')->find();
        if (empty($oinfo)) {
            return $this->err_js('资料有误!');
        }elseif ($info['end_time'] && time()>$info['end_time']+$info['extend_totaltime']) {
            return $this->err_js('活动已结束,不能再竟拍');
        }elseif($oinfo['few_ifpay']!=1){
            return $this->err_js('你报名后还没交保证金!');
        }elseif ($info['mid']!=3) {
            return $this->err_js('此商品不参与竟拍活动');
        }elseif($info['min_money']>0 && $money-$info['price']<$info['min_money']){
            return $this->err_js('出价增浮金额不能小于 '.$info['min_money'].' 元,出价必须大于 '.($info['price']+$info['min_money']).' 元,小于 '.($info['price']+$info['max_money']).' 元');
        }elseif($info['max_money']>0 && $money-$info['price']>$info['max_money']){
            return $this->err_js('出价增浮金额不能大于 '.$info['max_money'].' 元,出价必须大于 '.($info['price']+$info['min_money']).' 元,小于 '.($info['price']+$info['max_money']).' 元');
        }
        
        
        $result = MemberModel::create([
            'order_id'=>$oinfo['id'],
            'aid'=>$id,
            'type'=>3,
            'uid'=>intval($this->user['uid']),
            'money'=>$money,
        ]);
        if ($result) {
            if ($info['extend_time'] && $info['end_time'] && time()-$info['end_time']<600) {    //10分钟内出价,自动延时
                $info['extend_totaltime'] += $info['extend_time'];
            }
            $result = ContentModel::updates($id,[
                'price'=>$money,
                'extend_totaltime'=>$info['extend_totaltime'],
            ]);
            if ($result) {
                OrderModel::where('id',$oinfo['id'])->update([
                    'pay_money'=>$money-$oinfo['fewmoney'],
                    'totalmoney'=>$money,
                ]);                
                
                $listdb = OrderModel::where('shopid',$id)->column('id,uid');
                foreach ($listdb AS $uid){
                    if ($uid!=$this->user['uid']) {
                        $name = $this->user['username'] ;
                        $wxcontent = "<a href=\"".get_url(urls('content/show',['id'=>$id]))."\">你参与的“{$info['title']}”竟拍活动，“{$name}”出价到 {$money} 元，你若不跟拍的话，有可能会出局哦！点击查看详情</a>";
                        send_wx_msg($uid,$wxcontent);
                        send_msg($uid,'竟拍有人出更高价了',$wxcontent);
                    }
                }
                if ($info['ext_id']) {
                    $_data = [
                        'qun_id'=>$info['ext_id'],
                        'uid'=>$info['uid'],
                        'content'=>"<div class=\"paimai\"><div>拍卖实时播报：".$this->user['username']." 参与“{$info['title']}”竟拍活动，出价到 {$money} 元，好给力！！</div>[face17]</div>",
                    ];
                    \app\common\model\Msg::add($_data,false,true);
                }
                return $this->ok_js();
            }else{
                return $this->err_js('数据库操作失败');
            }
        }else{
            return $this->err_js('入库失败');
        }
    }
}
