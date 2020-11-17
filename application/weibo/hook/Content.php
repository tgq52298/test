<?php
namespace app\weibo\hook;

use app\weibo\model\Feed;
use app\weibo\model\Content AS ContentModel;

class Content
{
    public function __construct(){        
//         $uid = login_user('uid');
//         $info = ContentModel::getIndexByUid($uid,1);
    }
    
    /**
     * 发表主题
     * @param number $id 主题ID
     * @param array $array 模型名称及POST数据
     */
    public function CmsAddEnd($id=0,$array=[]){
        if(defined('IN_PLUGIN')){
            return ;    //跳转插件
        }
        $array['module'] || $array['module'] = request()->module();
        if($array['module']=='weibo'){
            return ;
        }
        $m = modules_config($array['module']);
        $uid = login_user('uid');
        $data = [
                'uid'=>$uid,
                'create_time'=>time(),
                'sysid'=>$m['id'],
                'aid'=>$id,
                'type'=>'add',
        ];
        $result = Feed::push_add( array_merge($data,['ifread'=>1]) );    //添加到本人动态
        if ($result) {
            fun('sns@push_toFans',$uid,$data);  //添加到粉丝用户那里
        }
    }
    
    /**
     * 贴子回复
     * @param array $data 模型名称及POST数据
     * @param number $id  评论ID,不是贴子主题ID
     */
    public function ReplyAddEnd($data=[],$id=0){
        $module = request()->module();
        $m = modules_config($module);
        $uid = login_user('uid');
        $data = [
                'uid'=>$uid,
                'create_time'=>time(),
                'sysid'=>$m['id'],
                'aid'=>$data['aid'],
                'rid'=>$id,
                'type'=>'reply',
        ];
        $result = Feed::push_add( array_merge($data,['ifread'=>1]) );    //给自己加一条动态
        
        if ($result) {
            fun('sns@push_toFans',$uid,$data);  //给粉丝,及其它关注主题的用户及回复过的用户分别加动态
        }
    }
    
    /**
     * 评论回复
     * @param array $data POST数据
     * @param number $id  评论ID,不是主题ID
     */
    public function CommentAddEnd($data=[],$id=0){
        if($data['sysid']<0){
            return ;    //跳转插件
        }
        $uid = login_user('uid');
        if (empty($uid)) {
            return ;
        }
        $data = [
                'uid'=>$uid,
                'create_time'=>time(),
                'sysid'=>$data['sysid'],
                'aid'=>$data['aid'],
                'rid'=>$id,
                'type'=>'comment',
        ];
        $result = Feed::push_add( array_merge($data,['ifread'=>1]) );   //给自己加一条动态
        if ($result) {
            fun('sns@push_toFans',$uid,$data);
        }
    }
}
