<?php
namespace plugins\alilive\index;

use app\common\controller\IndexBase;
use app\common\model\Msg AS MsgModel;
use plugins\alilive\model\Log AS LogModel;
use think\Db;

/**
 * 直播回调网址
 * @author Administrator
 *
 */
class Notify extends IndexBase
{    
    public function index($apikey='',$type=''){        
        if ($this->webdb['live_video_key']!='' && $this->webdb['live_video_key']!=$apikey) {
            $this->error('通信密钥不对!');
        }
        if ($this->webdb['live_video_type']=='qq') {
            $array = $this->tencent_api($type);
        }elseif(empty($this->webdb['live_video_type']) || $this->webdb['live_video_type']=='ali'){
            $array = $this->ali_api();
        }

        if (!is_array($array)) {
            return $this->err_js($array);
        }
        return $this->ok_js($array);
    }
    
    protected function tencent_api($type=''){
        $data = json_decode(file_get_contents("php://input"),true);
        $id = $this->get_id($data['channel_id']);
        if($type=='push1' || $data['event_type']==1){ //开播
            $_cache = cache2('start_zhibo_tag'.$id);            
            if( $_cache && strstr($_cache,$data['sequence']) ){
                //file_put_contents( ROOT_PATH.'/test_zihibo_log.txt' , "又重复的直播开始了\r\n\r\n\r\n\r\n",FILE_APPEND );
                return '重复收到通知';
            }            
            cache2('start_zhibo_tag'.$id, $data['sequence']."\r\n".$_cache ,36000);            
            $this->auto_start($id,'tencent');
        }elseif($type=='push0' || ($data['sign']&&$data['event_type']==0)){    //停播
            
            $this->auto_stop($id,'tencent');
            
        }elseif($type=='video' || $data['event_type']==100){    //视频地址
            
            $url = $this->webdb['qq_live_mvurl'].'/'.preg_replace("/^(https|http):\/\/([^\/]+)\//i", '', $data['video_url']);
            $this->post_mv($id,$url,'tencent');
            
        }elseif($type=='img' || $data['event_type']==200){    //图片地址
            
        }
    }
    
    protected function ali_api(){
        $data = input();
        $id = $this->get_id($data['id']);
        if($data['action']=='publish'){ //开播
            
            preg_match("/&auth_key=([^&]+)&/",$data['usrargs'],$array);
            $sequence = $array[1];
            
            $_cache = cache2('start_zhibo_tag'.$id);
            if( $_cache && strstr($_cache,$sequence) ){
                //file_put_contents( ROOT_PATH.'/test_zihibo_log.txt' , $sequence."又重复的直播开始了\r\n\r\n\r\n\r\n",FILE_APPEND );
                return '重复收到通知';
            }
            cache2('start_zhibo_tag'.$id, $sequence."\r\n".$_cache ,36000);
            $this->auto_start($id,'aliyun');
            
        }elseif($data['action']=='publish_done'){    //停播
            
            $this->auto_stop($id,'aliyun');
            
        }else{
            $data = json_decode(file_get_contents("php://input"),true);
            if($data['uri']!=''){   //视频地址
                $id = $this->get_id($data['stream']);
                $url = $this->webdb['ali_live_mvurl'].'/'.preg_replace("/^(https|http):\/\/([^\/]+)\//i", '', $data['uri']);
                $this->post_mv($id,$url,'aliyun');
            }         
        }
    }
    
    /**
     * 智能判断停播
     * @param number $id
     * @param string $type
     */
    protected function auto_stop($id=0,$type=''){
        if (cache2('zhibo_force_start'.$id)) {  //强制开播的,不要智能处理
            return ;
        }
        $this->stop_zhibo($id,$type);
    }
    
    /**
     * 智能判断开播
     * @param number $id
     * @param string $type
     */
    protected function auto_start($id=0,$type=''){
        if (cache2('zhibo_force_start'.$id)) {  //强制开播的,不要智能处理
            return ;
        }
        $this->start_zhibo($id,$type);
    }
    
    /**
     * 自建直播服务器
     * @param unknown $ifstart 只能传true false 其它0 1 不生效,避免URL传值
     * @param number $id 圈子ID
     * @return string
     */
    public function self_server($ifstart=null,$id=0){
        if($ifstart===true){
            if( cache2('start_zhibo_tag'.$id) ){
                return '重复收到通知';
            }
            cache2('start_zhibo_tag'.$id, 1 ,36000);
            $this->start_zhibo($id,'is_self');
        }elseif($ifstart===false){
            //cache2('start_zhibo_tag'.$id, null);
            $this->stop_zhibo($id,'is_self');
        }
    }
    
    public function self_server_postmv($url='',$id=0){
        $this->post_mv($id,$url,'is_self');
    }
    
    /**
     * 直播开始了
     * @param number $id 圈子ID
     * @param number $type 哪个服务商
     */
    protected function start_zhibo($id=0,$type=''){		
// 		$live_array = cache('live_qun');
//         $data = $live_array['service-'.$id];
        
//         $live_array['qun-'.$id] = $data;    //生成这个变量给群聊使用,通知他直播开始了
//         cache('live_qun',$live_array,36000);

        $data = fun('Qun@live',$id,'service_video');
        $log_id = fun('alilive@add',$this->get_uid($id),$id,'qun',$data); //直播记录入库,跟CMS无关
        
        unset($data['push_url']);
        fun('Qun@live',$id,'live_video',$data); //生成这个缓存给群聊使用,通知他直播开始了
        
        //file_put_contents( ROOT_PATH.'/test_zihibo_log.txt' , var_export($data,true)."={$id}- 直播开始了\r\n\r\n\r\n\r\n",FILE_APPEND );
        
        
        $uid = $this->get_uid($id);
        $_data = [
            'qun_id'=>$id,
            'uid'=>$uid,
            'content'=>'<div class="start-zhibo">直播开始了!(推流通知)</div>',
        ];
        MsgModel::add($_data,false,true);
        
        $msg_array = [
            'type'=>'zhibo_server_start',
            'data'=>$data,
        ];
        fun("Gatewayclient@send_to_group",$uid,-$id,$msg_array);
        
        //修改CMS的视频为正在直播中
        $_id = cache2('cms_video_zhibo'.$id);
        if ($_id) {
            Db::name('cms_content3')->where('id',$_id)->update([
                'zhibo_status'=>2,
            ]);
        }
        
        //钩子扩展
        $array = [
            'type'=>$type,
            'id'=>$id,
            'urls'=>$data,
            'log'=>['id'=>$log_id],
        ];
        $this->get_hook('zhibo_start',$array);
        hook_listen('zhibo_start',$array);
    }
    
    /**
     * 直播结束了
     * @param number $id 圈子ID
     * @param number $type 哪个服务商
     */
    protected function stop_zhibo($id=0,$type=''){
        //file_put_contents( ROOT_PATH.'/test_zihibo_log.txt' , "结束直播\r\n\r\n\r\n\r\n",FILE_APPEND );
        
        //结束直播,就把播放地址也清掉,好通知群聊那里的用户,直播已经停止了
//         $live_array = cache('live_qun');
//         unset($live_array['qun-'.$id]);     //清除这个值,告诉群聊,直播结束了        
//         cache('live_qun',$live_array,36000);
        
        cache2('start_zhibo_tag'.$id, null);    //清除开播标志
        
        fun('Qun@live',$id,'live_video','');    //清除这个值,告诉群聊,直播结束了    
        
        $info = $this->get_log($id);
        $start_time = strtotime($info['create_time']);
        LogModel::where('id',$info['id'])->update([
            'end_time'=>time(),
            'timelong'=>time()-$start_time,
        ]);
        
        
        //有可能结束视频还早于结束标志, 阿里不会,只是腾讯录制视频很快 也即腾讯有可能先接收到最后那个视频URL,最后才收到直播结束标志
        //$time_array = cache2('cache_url_time_db');
//         if(time()-$time_array[$id]<30){
//             $this->post_mv($id);
//         }
        
        $msg_array = [
            'type'=>'zhibo_server_stop',
        ];
        fun("Gatewayclient@send_to_group",$info['uid'],-$id,$msg_array);
        
        $_id = cache2('cms_video_zhibo'.$id);
        if ($_id) {
            Db::name('cms_content3')->where('id',$_id)->update([
                'zhibo_status'=>3,
                'stop_time'=>time(),
            ]);
            //POST视频地址过来,阿里的是滞后,自建服务器也是滞后的,腾迅的却可能提前
            //cache2('cms_video_zhibo'.$id,$_id,3600*24);
            
            //把直播期间的聊天记录归为当前主题
            Db::name('msg')->where('qun_id',$id)->where('create_time','>',$start_time)->update([
                'ext_id'=>$_id,
                'ext_sys'=>intval(modules_config('cms')['id']),
            ]);
            
            $this->post_mv($id);    //视频入库,可能最后一个视频还没传过来
            
            cache2('cms_video_zhibo'.$id,$_id,60);  //视频入库最后一个传来的视频会延时,所以不能马上清除这个值
        }
        
        
        //钩子扩展
        $array = [
            'type'=>$type,
            'id'=>$id,  //圈子ID
            'log'=>$info, //直播日志,不是CMS
        ];
        $this->get_hook('zhibo_stop',$array);
        hook_listen('zhibo_stop',$array);
    }
    
    /**
     * 获取当前直播的信息
     * @param number $id 圈子ID
     * @return array|NULL[]|unknown
     */
    protected function get_log($id=0){
        $map = [
            'ext_id'=>$id,
        ];
        return getArray(LogModel::where($map)->order('id desc')->limit(1)->find());
    }
    
    /**
     * 获取圈子ID
     * @param number $id 圈子ID
     * @return number
     */
    protected function get_id($id=0){
        return preg_replace("/[a-z_-]*/i", '', $id);
    }
    
    /**
     * 获取圈主的UID
     * @param number $id 圈子ID
     * @return number
     */
    protected function get_uid($id=0){
        $quninfo = fun('qun@getByid',$id);
        return intval($quninfo['uid']);
    }
    
    /**
     * 群聊信息表发布视频
     * @param number $id 圈子ID
     * @param string $url
     * @param number $type 哪个服务商
     */
    protected function post_mv($id=0,$url='',$type=''){
        //file_put_contents( ROOT_PATH.'/test_zihibo_log.txt' , "发布视频\r\n\r\n\r\n\r\n",FILE_APPEND );
        $info = $this->get_log($id);
        $url_array = cache2('cache_url_db')?:[];
        $array = $url_array[$id]?:[];
        $url && $array[] = $url;
        
        if ($info['end_time']){    //直播已结束才入库
            
            $this->post_data($id,$array);
            unset($url_array[$id]);
            cache2('cache_url_db',$url_array);
            
        }else{  //直播还没结束,就没必要提前入库      
            
            $url_array[$id] = $array;
            cache2('cache_url_db',$url_array);
            
            //时间做个标注,有可能先收到结束前的视频,最后才收到结束标志 阿里不会,只是腾讯录制视频很快
            $time_array = cache2('cache_url_time_db')?:[];
            $time_array[$id] = time();
            cache2('cache_url_time_db',$time_array);
        }
        
        //钩子扩展
        $array = [
            'type'=>$type,
            'id'=>$id,
            'log'=>$info,
        ];
        $this->get_hook('zhibo_postmv',$array);
        hook_listen('zhibo_postmv',$array);
    }
    
    /**
     * 入库处理
     * @param number $id 圈子ID
     * @param array $url_array 可能是多个网址,视频切片
     */
    protected function post_data($id=0,$url_array=[]){
        if(empty($url_array)){
            return ;
        }
        $uid = $this->get_uid($id);
        $content = '';
        foreach($url_array AS $url){
            $content .= '<div class="zhibo_video"><video src="'.$url.'" controls="controls" style="width:100%;" class="video_player">您的浏览器不支持播放该视频！</video></div>';
        }
        $data = [
            'qun_id'=>$id,
            'uid'=>$uid,
            'content'=>$content,
        ];
        
        $_id = cache2('cms_video_zhibo'.$id);
        if(!$_id){  //隔天从第三方OBS推流的情况,并没有从聊天窗口那里启用
//             if(empty(get_field(3,'cms')['zhibo_status']) || count($url_array)==1){
//                 MsgModel::add($data,false,true);
//             }
            $_id = Db::name('cms_content3')->where('uid',$uid)->order('id desc')->value('id');  //如果有多集的话,就追加到最新的那条视频主题
            if (empty($_id)) {  //没有发布过CMS视频内容
                MsgModel::add($data,false,true);
            }
            
            //处理隔天突然启动OBS的情况
            $_info = $this->get_log($id);
            $start_time = strtotime($_info['create_time']);
            //把直播期间的聊天记录归为当前主题
            Db::name('msg')->where('qun_id',$id)->where('create_time','>',$start_time)->update([
                'ext_id'=>$_id,
                'ext_sys'=>intval(modules_config('cms')['id']),
            ]);
        }
        
        if ($_id) {
            $info = Db::name('cms_content3')->where('id',$_id)->find();
            $urldb = $info['mv_url']?json_decode($info['mv_url'],true):[];
            foreach($url_array AS $url){
                $urldb[] = [
                    'url'=>$url,
                ];
            }
            Db::name('cms_content3')->where('id',$_id)->update([
                'zhibo_status'=>3,
                'stop_time'=>time(),
                'mv_url'=>json_encode($urldb),
                'picurl'=>$info['picurl']?:str_replace('.mp4', '.jpg', $urldb[0]['url']),
            ]);
            $obj = new \app\cms\index\Vod;
            $obj->post_vod($_id,$id,true);  //直播结束后启动点播窗口
            
            $msg_array = [
                'type'=>'give_vod_mv_state',    //JS根据WS传来这个标志做处理
                'data'=>[
                    'play_index'=>0,
                    'play_time'=>0,
                    'play_urls'=>$urldb,
                    'title'=>$info['title'],
                    'about'=>$info['content'],
                    'size_type'=>$info['size_type'],
                ],
            ];
            fun("Gatewayclient@send_to_group",$uid,-$id,$msg_array);    //WS群发给所有圈子会员
        }
        
        //钩子扩展
        $array = [
            'type'=>$type,
            'id'=>$id,
            'log'=>$info,
        ];
        $this->get_hook('zhibo_stop',$array,$url_array);
        hook_listen('zhibo_stop',$array,$url_array);
        
    }
    
    
    
    
}
