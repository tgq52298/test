<?php
namespace plugins\alilive\index;

use app\common\controller\IndexBase;
use plugins\alilive\model\Order AS OrderModel;
use think\Db;

class Api extends IndexBase
{
    /**
     * 获取推流与播流地址
     * @param number $id 圈子ID
     * @param string $get_array 为true的时候,是后台调用
     * @return void|\think\response\Json|\plugins\alilive\index\string[]|void|unknown|\think\response\Json
     */
    public function url($id=0,$get_array=false){        
        
        if ($get_array===true) {    //后台调用
            $id = str_replace('-', '_', $id);   //阿里云不支持横杠线
        }else{
            $id = abs(intval($id));
            $quninfo = fun('qun@getByid',$id);
            if (empty($quninfo)) {
                return $this->err_js("当前".QUN."不存在");
            }elseif ($quninfo['uid']!=$this->user['uid']){
                return $this->err_js("你不是当前".QUN."的圈主，不能在本圈直播！");
            }
            if (!in_array($this->user['groupid'], $this->webdb['live_free_group'])) {   //指定的用户组,就不限流量
                $limit_time = 0;    //可用流量时长
                $info = OrderModel::where('aid',$id)->where('(`timelong`-`usetime`)>0')->field('sum(`timelong`-`usetime`) AS num ')->find();
                if ($info['num']>0) {
                    $limit_time = $info['num'];
                }elseif ( empty(OrderModel::where('aid',$id)->find()) ) {  
                    if ( $this->webdb['live_test_time']>0 ) {  //新用户有免费体验时长
                        $limit_time = $this->webdb['live_test_time']*60;
                        $result = OrderModel::create([
                            'uid'=>$this->user['uid'],
                            'aid'=>$id,
                            'timelong'=>$limit_time,
                        ]);
                        if (empty($result)) {
                            return $this->err_js("入库失败");
                        }
                    }else{
                        $msg = '提示：需要购买直播观众流量才能进行直播，<br>';
                    }
                }else{
                    $msg = '提示：你的直播观众流量用完了，需要购买直播观众流量才能进行直播，<br>';
                }
                if($limit_time<1){
                    $array = [
                        'url'=>purl('log/add',['aid'=>$id],'member'),  //购买流量的地址
                        'moneytime'=>$this->webdb['live_time_money'],
                    ];
                    $msg .= '每'.$this->webdb['live_time_money'].'分钟只需要1元，分钟时长所有观众共享使用。';
                    return $this->err_js($msg,$array,2);
                }
            }else{
                $limit_time = 'forever';    //永久有效
            }
        }

        
        $stream = 'id'.$id;
        if ($this->webdb['live_video_type']=='qq') {    //腾迅云直播接口
            $array = $this->tencent_api($stream);
        }elseif(empty($this->webdb['live_video_type']) || $this->webdb['live_video_type']=='ali'){
            $array = $this->ali_api($stream);
        }
        $_array = $this->self_server($id);  //自建服务器
        if ($_array) {
            $array = $_array;
        }
        $_array = $this->qun_self_api($quninfo);  //圈子个性API
        if ($_array) {
            $array = $_array;
        }
        if ($get_array===true) {    //方便后台调用qun_self_api($info=[])
            return $array;
        }
        if (!is_array($array)) {
            return $this->err_js($array);
        }
        
        //生成缓存给直播推流端使用 ,这里还没有入库处理的,要等直播真正发起后,才入库 plugins\alilive\index\Notify::start_zhibo
//         $live_array = cache('live_qun')?:[];
//         $live_array['service-'.$id] = [
//             'flv_url'=>$array['flv_url'],
//             'm3u8_url'=>$array['m3u8_url'],
//             'rtmp_url'=>$array['rtmp_url'],
//             'push_url'=>$array['push_url'],
//             'time'=>time(),
//         ];
//         cache('live_qun',$live_array,36000);
        $data = $this->request->post();
        if ($data['zhibo_status'] && get_field(3,'cms')['zhibo_status']) {           
            if ($data['zhibo_status']==1) { //预告
                if (strtotime($data['start_time'])<time()-30) {
                    return $this->err_js('预告时间必须大于当前时间');
                }
            }elseif($data['zhibo_status']==2){  //直播中
            }elseif($data['zhibo_status']==3){  //停播
            }
            $info = Db::name('cms_content3')->where('uid',$quninfo['uid'])->where('zhibo_status','in',[1,2])->where('status','>',0)->order('id desc')->find();
            if($data['zhibo_status']==3 && empty($info)) {  //停播
                
                return $this->err_js('你并没有开播数据!');
                
            }elseif ($info && ($data['zhibo_status']==1||$data['force_start']==1)) { //重新修改预告或者是正式强制开播才可以修改之前的预告内容,体验开播不能修改
               
                $_id = $info['id'];
                Db::name('cms_content3')->where('id',$info['id'])->update([
                    'title'=>$data['title'],
                    'content'=>$data['about'],
                    'start_time'=>strtotime($data['start_time']),
                    'zhibo_status'=>$data['zhibo_status'],
                ]);
                
            }elseif($data['zhibo_status']!=3){ //非停播
                
                $test_info = [];
                if(empty($data['force_start']) && $data['zhibo_status']==2 ){ //体验直播
                    $map  = [
                        'uid'=>$quninfo['uid'],
                        'create_time'=>['>',time()-3600],
                        'status'=>0,
                    ];
                    //体验直播的话,往10分钟内发过的非正式视频重新加数据.
                    $test_info = Db::name('cms_content3')->where($map)->order('id desc')->find();
                }
                if (empty($test_info) || $data['force_start']==1) {
                    if($data['force_start']==1 || $data['zhibo_status']==1){
                        $status = 1;
                    }else{
                        $status = 0;    //体验直播标志为非正式直播
                    }
                    $_data = [
                        'uid'=>$quninfo['uid'],
                        'mid'=>3,
                        'fid'=>intval($this->webdb['P__alilive']['cms_sortid']),
                        'status'=>$status,
                        'ext_id'=>$id,
                        'create_time'=>time(),
                        'ext_sys'=>modules_config('qun')['id'],
                        'title'=>$data['title'],
                        'content'=>$data['about'],
                        'start_time'=>$data['start_time'] ? strtotime($data['start_time']) : time(),
                        'zhibo_status'=>$data['force_start'] ? 2 : 1, //体验直播的话,必须要有推流才算真正的开的播
                    ];
                    $_id = Db::name('cms_content')->insertGetId($_data);
                    $_data['id'] = $_id;
                    Db::name('cms_content3')->insert($_data);
                }
                
            }
            
            if ($_id) {
                cache2('cms_video_zhibo'.$id,$_id,3600*24);  //视频入库使用
            }
        }
        
        
        if ($data['zhibo_status']==3) { //停播
            $this->selfserver_notify($id,'stop');
            cache2('zhibo_force_start'.$id,null);
            return $this->ok_js();
        }
        
        
        $array = [
            'flv_url'=>$array['flv_url'],
            'm3u8_url'=>$array['m3u8_url'],
            'rtmp_url'=>$array['rtmp_url'],
            'push_url'=>$array['push_url'],
            'limit_time'=>$limit_time,          //还有可用流量时间
            'time'=>time(),
            'self_server_api'=>$array['api_url']?:'',
            'api_type'=>$array['api_type']?:'',
            'title'=>$data['title'],
            'about'=>$data['about'],
            'id'=>$_id,
        ];

        fun('Qun@live',$id,'service_video',$array); //做缓存日志,后面直播要用到
        
        $array['push_img'] = get_qrcode($array['push_url']);
        
        //钩子接口
        $this->get_hook('zhibo_geturl',$data,$array,['id'=>$id,'cms_id'=>$_id]);
        $data['id'] = $id;
        hook_listen('zhibo_geturl',$data,$array);
        
        if($data['force_start']==1){    //强制正式开播
            $this->selfserver_notify($id,'start');
            cache2('zhibo_force_start'.$id,$_id?:'CMS_ID不存在',3600*12);
        }
        
        return $this->ok_js($array);
    }
    
    /**
     * 获取是否有直播预告数据
     * @return void|unknown|\think\response\Json|void|\think\response\Json
     */
    public function get_cms_video_info($uid=0,$aid=0){
        if ($aid) {
            $map = [
                'ext_id'=>$aid,
                'zhibo_status'=>1,
            ];
        }else{
            $map = [
                'uid'=>$uid?:$this->user['uid'],
                'zhibo_status'=>1,
            ];
        }
        
        $info = Db::name('cms_content3')->where($map)->order('id desc')->find();
        if ($info['start_time']-time()>0 || time()-$info['start_time']<600) {  //存在预告直播信息, 还没到直播时间, 或者是直播前10分钟
            $info['start_time'] = date('Y-m-d H:i:s',$info['_start_time']=$info['start_time']);
            return $this->ok_js($info);
        }else{
            return $this->err_js('没数据');
        }
    }
    
    /**
     * 被动通知是否开播
     * @param unknown $id 圈子ID
     * @param string $type
     */
    public function selfserver_notify($id,$type='',$url=''){
        $obj = new Notify();
        if ($type=='start') {
            $obj->self_server(true,$id);
        }elseif($type=='stop'){
            $obj->self_server(false,$id);
        }elseif($type=='mv'){
            $obj->self_server_postmv($url,$id);
        }
        return 'ok';
    }
    
    /**
     * 检查服务器是否开播  主动检测
     * @param number $id
     * @return void|unknown|\think\response\Json
     */
    public function server_status($id=0){
        $array = fun('Qun@live',$id,'service_video');
        if($array['self_server_api']!=''){
            $postStr = http_curl($array['self_server_api']);
            if ($postStr=='') {
                return $this->ok_js([],'获取服务器数据失败');
            }
            $obj = new Notify();
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $jsonStr = json_encode($postObj);
            $jsonArray = json_decode($jsonStr,true);
            $array_obj = $jsonArray['server']['application'][1]['live']['stream'];
            if(empty($jsonArray['server'])){
                return $this->ok_js([],'XML数据有误,解释失败');
            }elseif($array_obj[0]){     //存在多个直播
                foreach($array_obj AS $rs){
                    if($rs['name']=='selfserver'.$id && isset($rs['publishing']) ){
                        $obj->self_server(true,$id);
                        return $this->ok_js([],'开播了');
                    }
                }
            }elseif($array_obj['name']=='selfserver'.$id && isset($array_obj['publishing']) ){   //只有一个直播
                $obj->self_server(true,$id);
                return $this->ok_js([],'开播了');
            }
        }else{
            return $this->ok_js([],'没有直播的数据');
        }
    }
    
    /**
     * 钩子接口,处理停播自建服务器的直播 主动检测
     * @param array $data
     */
    public function UserLeave($data=[]){
        if($data['type']=='leave_qun' && $data['aid']){
            $id = $data['aid'];
            if (empty(fun('Qun@live',$id,'live_video'))) {
                return ; //没有在直播,就不必处理
            }
            $array = fun('Qun@live',$id,'service_video');
            if($array['self_server_api']!=''){  //用了自建服务器
                $postStr = http_curl($array['self_server_api']);
                if ($postStr=='') {
                    return ;    //没获取到数据,不做处理
                }
                $obj = new Notify();
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $jsonStr = json_encode($postObj);
                $jsonArray = json_decode($jsonStr,true);
                $array_obj = $jsonArray['server']['application'][1]['live']['stream'];
                if(empty($jsonArray['server'])){
                    return ;    //XML数据有误,解释失败,不做处理
                }elseif($array_obj[0]){ //存在多个直播
                    foreach($array_obj AS $rs){
                        if($rs['name']=='selfserver'.$id && isset($rs['publishing'])){                            
                            return ;    //还在直播中
                        }
                    }
                    $obj->self_server(false,$id);
                }elseif($array_obj['name']!='selfserver'.$id || !isset($array_obj['publishing']) ){  //只有一个直播
                    $obj->self_server(false,$id);
                }
            }
        }
    }
    
    /**
     * 自建直播服务器
     * @param number $id
     * @return void|string[]|unknown[]
     */
    private function self_server($id=0){
        if (!is_numeric($id) || empty($this->webdb['self_zhibo_server']) || empty($this->webdb['self_zhibo_server_group'])) {
            return ;
        }
        $quninfo = fun('qun@getByid',$id);
        $user = get_user($quninfo['uid']);
        if (!in_array($user['groupid'], $this->webdb['self_zhibo_server_group'])){
            return ;
        }
        $domain = preg_replace("/(https|http):\/\/([^\/:]+)(.*)/i", "\\2", $this->webdb['self_zhibo_server_url']);
        $rmp = 'rtmp://'.$domain.'/hls/selfserver'.$id;
        return [
            'flv_url'=>$rmp,
            'm3u8_url'=>$this->webdb['self_zhibo_server_url'].'/hls/selfserver'.$id.'/index.m3u8',
            'rtmp_url'=>$rmp,
            'push_url'=>$rmp,
            'api_url'=>$this->webdb['self_zhibo_server_url'].'/stat',
        ];
    }
    
    /**
     * 圈子自定义推流与播流地址
     * @param array $info
     * @return string|mixed
     */
    private function qun_self_api($info=[]){
        if ($info['live_api_url']!='') {
            $array = json_decode($info['live_api_url'],true);
            if ($array['push_url'] && ($array['m3u8_url']||$array['rtmp_url']||$array['flv_url'])) {
                $array['api_type'] = 'qun_self';
                return $array;
            }
        }
    }
    
    /**
     * 阿里云接口
     * @param string $StreamName
     * @param string $AppName
     * @return string[]
     */
    private function ali_api($StreamName='id',$AppName='qun'){
        if($this->webdb['ali_live_time']<1){
            return '有效时间不能小于1分钟';
        }elseif(!$this->webdb['ali_live_push_url']
            || !$this->webdb['ali_live_pull_url']
            || !$this->webdb['ali_live_push_key']
            || !$this->webdb['ali_live_pull_key'] ){
                return '参数不完整!';
        }
        //$StreamName = 'id'.$StreamName;
        $time = time() + $this->webdb['ali_live_time']*60;
        
        $key = $this->webdb['ali_live_push_key'];
        $strpush = "/$AppName/$StreamName-$time-0-0-$key";
        $pushurl = "rtmp://".$this->webdb['ali_live_push_url']."/$AppName/$StreamName?auth_key=$time-0-0-".md5($strpush);
        
        $key = $this->webdb['ali_live_pull_key'];
        $strviewrtmp = "/$AppName/$StreamName-$time-0-0-$key";
        $strviewflv = "/$AppName/$StreamName.flv-$time-0-0-$key";
        $strviewm3u8 = "/$AppName/$StreamName.m3u8-$time-0-0-$key";
        
        if(strstr($this->webdb['ali_live_pull_url'],'://')){
            preg_match("/(http|https):\/\/([^\/]+)/i",$this->webdb['ali_live_pull_url'],$array);
            $prev = $array[1];
            $domain = $array[2];
        }else{
            $prev = 'http';
            $domain = $this->webdb['ali_live_pull_url'];
        }
        
        $rtmpurl = "rtmp://".$domain."/$AppName/$StreamName?auth_key=$time-0-0-".md5($strviewrtmp);
        $flvurl = $prev."://".$domain."/$AppName/$StreamName.flv?auth_key=$time-0-0-".md5($strviewflv);
        $m3u8url = $prev."://".$domain."/$AppName/$StreamName.m3u8?auth_key=$time-0-0-".md5($strviewm3u8);
        return [            
            'push_url'=>$pushurl,
            
            'rtmp_url'=>$rtmpurl,
            'flv_url'=>$flvurl,
            'm3u8_url'=>$m3u8url,
        ];
    }
    
    /**
     * 腾迅云接口
     * 播放地址过期时间为当前设置时间戳加上播放鉴权设置的有效时间，
     * 推流地址过期时间即设置的未来时间
     * @param string $StreamName
     * @param string $AppName
     * @return string|array
     */
    private function tencent_api($StreamName='id',$AppName='live'){
        if($this->webdb['qq_live_time']<60){
            return '有效时间不能小于60秒钟';
        }elseif(!$this->webdb['qq_live_push_url']
            || !$this->webdb['qq_live_pull_url']
            || !$this->webdb['qq_live_push_key']
            || !$this->webdb['qq_live_pull_key'] ){
                return '参数不完整!';
        }
        return array_merge(
                $this->tencent_getPullUrl($StreamName,$AppName),
                [
                    'push_url'=>$this->tencent_getPushUrl($StreamName,$AppName),
                ]
            );
    }
    
    /**
     * 拉流地址
     * @param string $streamName
     * @param string $AppName
     * @return string[]
     */
    private function tencent_getPullUrl($streamName='id',$AppName='live'){
        $key = $this->webdb['qq_live_pull_key'];
        $time = time(); //当前时间,并未指定过期时间
        
        $txTime = strtoupper(base_convert($time,10,16));
        //txSecret = MD5( KEY + streamName + txTime )
        $txSecret = md5($key.$streamName.$txTime);
        $ext_str = "?".http_build_query(array(
            "txSecret"=> $txSecret,
            "txTime"=> $txTime
        ));
        if(strstr($this->webdb['qq_live_pull_url'],'://')){
            preg_match("/(http|https):\/\/([^\/]+)/i",$this->webdb['qq_live_pull_url'],$array);
            $prev = $array[1];
            $domain = $array[2];
        }else{
            $prev = 'http';
            $domain = $this->webdb['qq_live_pull_url'];
        }
        $url = $domain."/".$AppName."/".$streamName;
        return [            
            'rtmp_url'=>'rtmp://'.$url . $ext_str,
            'flv_url'=>$prev.'://'.$url . '.flv'. $ext_str,
            'm3u8_url'=>$prev.'://'.$url . '.m3u8'. $ext_str,
        ];        
    }
    
    /**
     * 推流地址
     * @param string $streamName
     * @param string $AppName
     * @return string
     */
    private function tencent_getPushUrl($streamName='id',$AppName='live'){
        $key = $this->webdb['qq_live_push_key'];
        $time = time() + $this->webdb['qq_live_time'];  //指定过期时间
        if($key && $time){
            $txTime = strtoupper(base_convert($time,10,16));
            //txSecret = MD5( KEY + streamName + txTime )
            $txSecret = md5($key.$streamName.$txTime);
            $ext_str = "?".http_build_query(array(
                "txSecret"=> $txSecret,
                "txTime"=> $txTime
            ));
        }
        return "rtmp://".$this->webdb['qq_live_push_url']."/".$AppName."/".$streamName . (isset($ext_str) ? $ext_str : "");
    }    
}
