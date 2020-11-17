<?php
namespace app\qun\hook;
use app\qun\model\Content AS ContentModel;
use app\qun\model\Member;
use app\qun\model\Topic AS TopicModel;
use app\qun\model\Order AS OrderModel;
use app\qun\model\Keyword AS KeywordModel;

class Content
{
    /**
     * 用户离开群聊的处理
     * @param array $data
     */
    public function UserLeave($data=[]){
        if($data['type']=='leave_qun' && $data['valid_time'] && $data['aid']){  //直播观看时长统计
            OrderModel::consume_time($data['aid'],$data['uid'],$data['valid_time']);
        }elseif($data['type']=='msg'){  //自动回复关键词
            /*
            $content = KeywordModel::get_answer($data['aid'],$data['content']);
            if ($content) {
                $info = ContentModel::getInfoByid($data['aid']);
                $user = get_user($info['uid']);
                $array = [
                    'id'=>time(),
                    'content'=>$content,
                    'touid'=>0,
                    'uid'=>$user['uid'],
                    'title'=>'',
                    'create_time'=>date('Y-m-d H:i:s'),
                    'qun_id'=>$data['aid'],
                    'from_username'=>$user['username'],
                    'from_icon'=>tempdir($user['icon']),
                ];
                echo json_encode($array);
            }
            */
        }
    }
    
    /**
     * 用户群聊发信息的处理 自动回复关键词
     * @param array $data
     * @param array $info
     */
    public function AddMsgEnd($data=[],$info=[]){
        if ($data['qun_id']<1) {
            return ;
        }
        $content = KeywordModel::get_answer($data['qun_id'],$data['content']);
        if ($content) {
            $info = ContentModel::getInfoByid($data['qun_id']);
            $user = get_user($info['uid']);
            $array = [
                'id'=>time(),
                'content'=>$content,
                'touid'=>0,
                'uid'=>$user['uid'],
                'title'=>'',
                'create_time'=>date('Y-m-d H:i:s'),
                'qun_id'=>$data['qun_id'],
                'from_username'=>$user['username'],
                'from_icon'=>tempdir($user['icon']),
            ];
            fun('Gatewayclient@send_to_user',$data['uid'],[
                'type'=>'qun_sync_msg',
                'data'=>[$array],
            ]);
        }
    }
    
    
    /**
     * 频道内容显示处理
     * @param array $info
     */
    public function CmsContentShow(&$info=[]){
        if (empty($info['ext_id'])  || defined('IN_PLUGIN') ) {
            return ;
        }
        $allow = false;
        $user = login_user();
        if($user['groupid']==3 || $user['uid']==$info['uid']){
            $allow = true;
        }
        
        $sysname = basename(dirname(__DIR__));  //圈子目录名,没有写死qun是方便复制频道时兼容
        if ( empty($info['ext_sys']) || modules_config($info['ext_sys'])['keywords']==$sysname ) {
            //$obj = get_model_class($sysname,'content');
            //$qun = $obj->getInfoById($info['ext_id']);  //圈子资料
            $qun = ContentModel::getInfoByid($info['ext_id']); //圈子资料
            if (empty($qun)) {
                return ;
            }
            if($qun['viewlimit']){  //圈子设置了访问权限
                if (!empty($user)) { //已登录
                    $m_info = Member::get([
                            'aid'=>$info['ext_id'],
                            'uid'=>$user['uid'],
                    ]);
                    if($m_info && $m_info['type']!=0){  //为0是非验证会员
                        $allow = true;                        
                        $info['hook_check'] = 1;
                    }
                }
                if($allow!=true && $info['status']!=0){     //实际上已经审核过的贴子
                    showerr('本主题,只有圈子正式成员,才能访问',urls('qun/content/apply',['id'=>$info['ext_id']]) );
                }
            }
            $qun['picurl'] = tempdir($qun['picurl']);
            $qun['content'] = del_html($qun['full_content']=$qun['content']);
            
            $info['qun'] = $qun;    //把圈子的信息追加到内容数据里边,方便模板使用
            $info['content'] = $this->hide_content($info,$qun,$user);
        }
    }
    
    /**
     * 圈子内的隐藏内容
     * @param array $info
     * @param array $qun
     * @param array $user
     * @return mixed
     */
    private function hide_content($info=[],$qun=[],$user=[]){
        return preg_replace_callback("/\[hide\](.*?)\[\/hide\]/is",function($array)use($info,$qun,$user) {
            if(empty($array[1])){
                return ;
            }
            if($info['uid']==$user['uid'] || $user['uid']==$qun['uid']||$user['groupid']==3){    //管理员\本人\圈主可见
                return "<div class='qun-hide'><div class='tmsg'>***********以下是隐藏内容,你有特权可以查看*********</div>{$array[1]}</div>";
            }else{
                $m_info = Member::get([
                        'aid'=>$qun['id'],
                        'uid'=>$user['uid'],
                ]);
                if($m_info && $m_info['type']!=0){  //为0是非验证会员
                    return "<div class='qun-hide'><div class='tmsg'>***********以下是隐藏内容,你有特权可以查看*********</div>{$array[1]}</div>";
                }elseif($m_info){
                    return "<div class='qun-hide-not-power'>***********你还不是正式会员,不能查看隐藏内容*********</div>";
                }else{
                    $url = urls('qun/content/apply',['id'=>$qun['id']]);
                    return "<div class='qun-hide-not-power'><div class='tmsg'>***********非圈内成员,不能查看隐藏内容*********</div><div class='btn'><a href='$url' target='_blank'>点击申请加入</a></div></div>";
                }
            }
        },$info['content']);
    }
    

    
    /**
     * 频道内容发布处理 , 
     * @param number $id
     * @param array $array
     */
    public function CmsAddEnd($id=0,$array=[]){
        $data = $array['data'];        
        $m_name = $array['module']?:request()->module();
        $this->add_topic($id,$data,$m_name);
        if (empty($data['ext_id']) || defined('IN_PLUGIN')) {   //插件中就不要执行下面的
            return ;
        }
        cookie('choose_qun_id',$data['ext_id'],3600*24*30); //方便下次不要再选择圈子
        $sysname = basename(dirname(__DIR__));  //圈子目录名,没有写死qun是方便复制频道时兼容
        if ( empty($data['ext_sys']) || modules_config($data['ext_sys'])['keywords']==$sysname ) {
            $qun = ContentModel::getInfoByid($data['ext_id']); //圈子资料
            if($qun['viewlimit'] && $qun['hidetitle']){         //私密圈设置了隐藏标题
                $obj = get_model_class($m_name,'content');
                $obj->editData($data['mid'],['id'=>$id,'status'=>0]);   //把私密圈的主题变成未审核,这样前台就不会显示出来了
            }
            //ContentModel::addField($data['ext_id'],'replynum'); //圈子主题加1 多个频道的相加,所以并不是太精准 删除没做统计
            ContentModel::editData($qun['mid'],[
                    'id'=>$data['ext_id'],
                    'replynum'=>($qun['replynum']+1),
                    'list'=>time(),
            ]);
            $this->callMember($id,$qun,$data['title']);
        }        
    }
    
    /**
     * 主题加入专题
     * @param number $id
     * @param array $data
     */
    protected function add_topic($id=0,$data=[],$sys_name=''){
        if($data['topic_aid'] && class_exists('TopicModel')){
            $qun = ContentModel::getInfoByid($data['topic_aid']);
            if($qun['uid']!=$data['uid']){
                return ;    //没权限
            }
            TopicModel::add($data['topic_aid'],$id,$sys_name);
        }        
    }
    
    /**
     * 内容发布前的处理
     * @param number $id
     * @param array $array
     */
    public function CmsAddBegin($data=[]){
        $data || $data = get_post();
        $m_name = request()->module();
        if (empty($data['ext_id']) || defined('IN_PLUGIN')) {               //插件中就不要执行下面的
            return ;
        }
        $sysname = basename(dirname(__DIR__));                          //圈子目录名,没有写死qun是方便复制频道时兼容
        if ( empty($data['ext_sys']) || modules_config($data['ext_sys'])['keywords']==$sysname ) {
            $user = login_user();                                                       //当前登录用户
            $qun = ContentModel::getInfoByid($data['ext_id']);          //圈子资料
            if (empty($qun)) {
                return ;
            }elseif($user['uid']==$qun['uid'] || $user['groupid']==3){      //圈主或者是网站管理员
                return ;
            }else{
                $m_info = Member::get([
                        'aid'=>$data['ext_id'],
                        'uid'=>intval($user['uid']),
                ]);
                if (empty($m_info)) {
                    showerr('你不是本'.QUN.'成员,无权限发表');
                }elseif ($m_info['type']==0){
                    showerr('你还不是本'.QUN.'正式成员,无权限发表');
                }
            }
        }
    }
    
    /**
     * 圈主群发消息
     * @param number $id
     * @param array $qun
     * @param string $content
     */
    private function callMember($id=0,$qun=[],$content=''){
        preg_match("/^@([^ ]+)( |&nbsp;|　)/is" , del_html($content) , $array);
        if (empty($array[1])) {
            return ;
        }
        $user = login_user();
        $to = $array[1];
        
        $m_name = request()->module();
        $marray = modules_config($m_name);  
        $content = "，<a target=\"_blank\" href=\"".urls("{$marray['keywords']}/content/show",['id'=>$id])."\">点击查看详情</a>";
        if ($to=='所有人') {
            if ($user['uid']!=$qun['uid']) {
                return ;
            }
            $title = "你好，来自 {$qun['title']} ".QUN."的管理员:{$user['username']} 在 {$marray['name']} 主题中呼叫你";
            $listdb = Member::where('aid',$qun['id'])->column('uid');
            foreach($listdb AS $uid){
                if($uid==$user['uid']){
                    //continue ; //圈主就不要发给自己了
                }
                send_msg($uid , $title , $title.$content);
                //send_wx_msg($uid , $title.$content);  //用户如果太多话,发送微信消息非常耗时
            }
        }else{
//             $other = get_user($to,'username');
//             if (empty($other)) {
//                 return ;
//             }elseif( empty( Member::where(['aid'=>$qun['id'],'uid'=>$other['uid']])->find() ) ){
//                 return ;
//             }
//             $title = "你好，来自 {$qun['title']} 圈子的成员:{$user['username']} 在 {$marray['name']} 主题中呼叫你";
//             send_msg($other['uid'] , $title , $title.$content);
//             if ($other['weixin_api']) {
//                 send_wx_msg($other['weixin_api'] , $title.$content);
//             }
        }
        
    }
    
    /**
     * 贴子回复
     * @param array $data POST数据
     * @param number $id  评论ID,不是贴子主题ID
     */
    public function ReplyAddEnd($data=[],$id=0){
        $module = request()->module();
        $obj = get_model_class($module,'content');
        $topic = $obj->getInfoByid($data['aid'],false);
        if (empty($topic['ext_id'])) {  //圈子ID不存在的时候,直接跳出
            return ;
        }
        $sysname = basename(dirname(__DIR__));  //圈子目录名,没有写死qun是方便复制频道时兼容
        if ( empty($topic['ext_sys']) || modules_config($topic['ext_sys'])['keywords']==$sysname ) {
            $qun = ContentModel::getInfoByid($topic['ext_id']); //圈子资料
            ContentModel::editData($qun['mid'],[
                    'id'=>$topic['ext_id'],
                    'replynum'=>($qun['replynum']+1),
                    'list'=>time(),
            ]);
        }
    }
}
