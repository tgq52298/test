<?php
namespace app\yuyue\index\wxapp;

use app\common\controller\IndexBase;
use app\yuyue\model\Content AS ContentModel;
use app\yuyue\model\Order AS OrderModel;
use app\yuyue\model\Member AS MemberModel;

class Miaosha extends IndexBase
{
    /**
     * 助力时间
     * @param number $id 商品ID
     * @param number $uid 被帮助的用户UID
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function help($id=0,$uid=0){
        if (empty($this->user)) {
            return $this->err_js('你还没登录!');
        }
        $user = get_user($uid);
        if (empty($user)) {
            return $this->err_js('该用户不存在!');
        }        
        $info = ContentModel::getInfoByid($id);
        if (empty($info)) {
            return $this->err_js('商品不存在!');
        }elseif ($info['mid']!=4) {
            return $this->err_js('此商品不参与助力活动');
        }elseif ($info['end_time'] && time()>$info['end_time']) {
            return $this->err_js('活动已结束,不能再秒杀助力!');
        }elseif($info['begin_time']<time()){
            return $this->err_js('活动已开始,不需要再助力!');
        }
        
        if($info['user_limit']){
            if (($info['user_limit']==1 || $info['user_limit']==3 ) && empty($this->user['mob_yz']) ) {
                return $this->err_js('你还没绑定手机,不能帮Ta助力!');
            }elseif (($info['user_limit']==2 || $info['user_limit']==3 ) && empty($this->user['wx_attention']) ) {
                $result = $this->user['weixin_api']?wx_check_attention($this->user['weixin_api']):false;
                if ($result===true) {
                    edit_user([
                        'uid'=>$this->user['uid'],
                        'wx_attention'=>1,
                    ]);
                }else{
                    return $this->err_js('你还没关注公众号,不能帮Ta助力!');
                }
            }
        }
        
        $info['limittime'] || $info['limittime']=1;
        
        $time = $info['limittime']*60;
        $key = 'miaosha_limittime_'.$id.'-'.$uid.'-'.($this->user['uid']?:$this->guest);
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
            return $this->err_js($msg.",不能重复帮Ta助力!");
        }       
        
        $result = MemberModel::create([
            'order_id'=>$uid,
            'aid'=>$id,
            'uid'=>intval($this->user['uid']),
            'type'=>4,
        ]);
        
        if ($result) {
            cache($key,time(),$time);
            $total_num = MemberModel::where([
                'aid'=>$id,
                'order_id'=>$uid,
                'type'=>4,
            ])->count('id');
            $timei = floor($total_num*$info['each_time']/60);
            $times = floor($total_num*$info['each_time']%60);
            $time = date('Y-m-d H:i:s',$info['begin_time']-$total_num*$info['each_time']);
            
            $name = $this->user['username'] ?: ' 游客';
            $wxcontent = "<a href=\"".get_url(urls('content/show',['id'=>$info['id'],'uid'=>$uid]))."\">你参与的“{$info['title']}”秒杀活动，“{$name}”帮你助力提前了 {$info['each_time']} 秒，你可以比其它人抢先 {$timei} 分 {$times} 秒即提前至 {$time} 参与抢购，点击查看详情</a>";
            send_wx_msg($uid,$wxcontent);
            return $this->ok_js([
                'timei'=>$timei,
                'times'=>$times,
                'time'=>$time,
            ],"感谢你为Ta助力!");
        }else{
            return $this->err_js('数据库操作失败');
        }
    }
}
