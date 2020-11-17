<?php
namespace app\weibo\index;
use app\weibo\model\Fav;
use app\weibo\model\Feed;

class Api extends Content
{
    /**
     * 收录主题
     * @param string $sys 系统分类
     * @param number $id 信息主题
     * @param number $uid 信息作者
     * @return void|unknown
     */
    public function fav_interest_topic($sys='',$id=0,$uid=0){
        if (empty($this->user)) {
            return ;
        }
        $m = modules_config($sys);
        $map = [
                'aid'=>$id,
                'sysid'=>$m['id'],
                'uid'=>$this->user['uid'],
        ];
        $info = Fav::get($map);
        if (empty($info)) {
            $map['create_time'] = time();
            if (Fav::create($map)) {
                $data = [
                        'aid'=>$id,
                        'sysid'=>$m['id'],
                        'uid'=>$uid,
                        'create_time'=>time(),
                        'type'=>'fav',
                        'about'=>$this->user['uid']."\t收录主题",
                ];
                fun('sns@add_msg',$data);
//                 Feed::push_add($data);  //推送到主题发布者的动态那里
//                 fun('sns@add_newmsgnum',$uid);  //给作者增加一条信息数目
                return $this->ok_js('收录成功');
            }else{
                return $this->err_js('数据插入失败');
            }
        }else{
            return $this->err_js('你已经收录过了');
        }
    }
    
    /**
     * 查看某个人的微博
     * @param number $uid
     * @return mixed|string
     */
    public function weibo($uid=0){
        if (empty($uid)) {
            $uid = $this->user['uid'];
        }
        $id = $uid;
        $this->mid = 1;
        $info = $this->getInfoData($id);
        $this->assign('info',$info);
        $this->assign('uid',$uid);
        $this->assign('id',$uid);
        
        if($uid == $this->user['uid']){
            if(empty($info)){
                $this->success('你还没有微博,点击创建一个',murl('content/postnew'));
            }else{
                fun('sns@clear_msg',$this->user['uid']);    //把新消息清0
            }            
        }elseif ( empty($info) ){
            $this->success('当前用户还没有创建微博,点击下一步,进入他的会员主页',murl('member/user/index',['uid'=>$uid]));
        }
        
	    return $this->fetch();
	}

}
