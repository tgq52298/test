<?php
namespace app\yuyue\index\wxapp;

use app\common\controller\IndexBase;
use app\yuyue\model\Content AS ContentModel;
use app\yuyue\model\Order AS OrderModel;
use app\yuyue\model\Member AS MemberModel;

class Yidao extends IndexBase
{
    /**
     * 砍价
     * @param number $id 订单ID
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function help($id=0){
        if (empty($this->user)) {
            return $this->err_js('你还没登录!');
        }
        $oinfo = OrderModel::where('id',$id)->find();
        if (empty($oinfo)) {
            return $this->err_js('订单不存在!');
        }elseif($oinfo['few_ifpay']==1 && $oinfo['pay_status']==1 ){
            return $this->err_js('该订单已支付!不能再砍价');
        }
        $info = ContentModel::getInfoByid($oinfo['shopid']);
        if (empty($info)) {
            return $this->err_js('商品不存在!');
        }elseif ($info['mid']!=2) {
            return $this->err_js('此商品不参与砍价活动');
        }elseif ($info['end_time'] && time()>$info['end_time']) {
            return $this->err_js('活动已结束,不能再砍价');
        }elseif ($info['limit_day'] && time()-strtotime($oinfo['create_time'])>$info['limit_day']*3600*24) {
            return $this->err_js('超过了砍价期限,'.$info['limit_day'].' 天有效期,不能再砍价了');
        }elseif ($oinfo['pay_money']+$oinfo['fewmoney'] <= $info['bottom_price']) {
            return $this->err_js('已经到底价了,不能再砍价');
        }elseif($info['paytype']==0 && $oinfo['few_ifpay']!=1){
            return $this->err_js('该订单还没付订金,还不能砍价');
        }
        
        
        if($info['yidao_limit']){
            if (($info['yidao_limit']==1 || $info['yidao_limit']==3 ) && empty($this->user['mob_yz']) ) {
                return $this->err_js('你还没绑定手机,不能帮Ta砍价!');
            }elseif (($info['yidao_limit']==2 || $info['yidao_limit']==3 ) && empty($this->user['wx_attention']) ) {
                $result = $this->user['weixin_api']?wx_check_attention($this->user['weixin_api']):false;
                if ($result===true) {
                    edit_user([
                        'uid'=>$this->user['uid'],
                        'wx_attention'=>1,
                    ]);
                }else{
                    return $this->err_js('你还没关注公众号,不能帮Ta砍价!');
                }
            }
        }
        
        $info['limittime'] || $info['limittime']=1;
        
        $time = $info['limittime']*60;
        $key = 'dao_limittime_'.$id.'-'.($this->user['uid']?:$this->guest);
        if( (time() - cache($key)) < $time ){
            $msg = $info['limittime'] .'分钟内';
            if($info['limittime']>=60){
                $h = floor($info['limittime']/60);
                $i = $info['limittime']%60;
                if($h>0 && $i>0){
                    $msg = "{$h}小时{$i}分钟内";
                }else{
                    $msg = "{$h}小时内";
                }
            }
            return $this->err_js($msg.",不能重复砍价");
        }
        cache($key,time(),$time);
        $dao_money = rand($info['min_money']*100,$info['max_money']*100)/100;
        $nowprice = $oinfo['pay_money']+$oinfo['fewmoney'] - $dao_money;
        if ($nowprice<=$info['bottom_price']) {
            $nowprice = $info['bottom_price'];
            $dao_money = $oinfo['pay_money']+$oinfo['fewmoney'] - $info['bottom_price'];
            $msg = '你好给力呀,帮Ta砍到底价了!';
        }else{
            $msg = '感谢你帮他砍了'.$dao_money.'元';
        }
        
        $result = MemberModel::create([
            'order_id'=>$id,
            'aid'=>$oinfo['shopid'],
            'uid'=>intval($this->user['uid']),
            'money'=>$dao_money,
            'type'=>1,
        ]);
        if ($result) {
            if ($oinfo['pay_money']>0) {    //分期付款
                $oinfo['pay_money'] -= $dao_money;
            }else{  //一次付款,余额就为0了
                $oinfo['fewmoney'] -= $dao_money;
            }
            
            $result = OrderModel::where('id',$id)->update([
                'pay_money'=>$oinfo['pay_money'],
                'fewmoney'=>$oinfo['fewmoney'],
            ]);
            if ($result) {
                $name = $this->user['username'] ?: ' 游客';
                $wxcontent = "<a href=\"".get_url(urls('content/show',['id'=>$info['id'],'oid'=>$id]))."\">你参与的“{$info['title']}”砍价活动，“{$name}”帮你砍了 {$dao_money} 元，当前价格降至 {$nowprice} 元，点击查看详情</a>";
                send_wx_msg($oinfo['uid'],$wxcontent);
                return $this->ok_js([
                    'yidao_money'=>sprintf("%.2f",$dao_money),
                    'nowprice'=>sprintf("%.2f",$nowprice),
                ],$msg);
            }else{
                return $this->err_js('数据库操作失败');
            }
        }else{
            return $this->err_js('入库失败');
        }
    }
}
