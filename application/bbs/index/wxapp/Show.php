<?php
namespace app\bbs\index\wxapp;

use app\common\controller\IndexBase;
use app\bbs\model\Content AS ContentModel;
use app\bbs\model\Reply AS ReplyModel;

//小程序 显示内容
class Show extends IndexBase
{
    /**
     * 调取显示内容主题
     * @param number $id 内容ID
     * @return \think\response\Json
     */
    public function index($id=0){
        $info = ContentModel::getInfoByid($id,true);        
        if(empty($info)){
            return $this->err_js('内容不存在');
        }
        $info['content'] = $info['full_content'];
        $info['full_content'] = '';
        $this->get_hook('cms_content_show',$info,$this->user);
        Hook_listen('cms_content_show',$info,$this->user);
        
        $this->view_check($info);
		$info['content'] = str_replace('src="/index.php/p/weixin-mpimg-get.html', 'src="'.$this->request->domain().'/index.php/p/weixin-mpimg-get.html', $info['content']);
        
        $info['time'] = format_time($info['time'],true);
        $info['mvurl'] = tempdir($info['mvurl']);
        
        ContentModel::addView($id); //更新浏览量
        
        return $this->ok_js($info);
    }
    
    
    protected function view_check(&$info=[]){
        //回复才能查看
        $info['content'] = preg_replace_callback('/\[reply\](.*?)\[\/reply\]/is',function($array=[])use($info){
            $content = $array[1];
            if ($content) {
                if ($this->admin === true||$this->user['uid']==$info['uid']) {
                    $content = '<div class="reply_show hide_content" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:red;">以下是隐藏的内容需要回复才可见，因为你有特权，所以下面的内容可见</div>'.$content.'</div>';
                }else{
                    $num = 0;
                    if ($this->user) {
                        $num = ReplyModel::where('uid',$this->user['uid'])->where('aid',$info['id'])->count('id');
                    }
                    if ($num>0) {
                        $content = '<div class="reply_show hide_content" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:red;">以下是隐藏的内容需要回复才可见，因为回复过了，所以下面的内容可见</div>'.$content.'</div>';
                    }else{
                        $content = '<div class="reply_show hide_content  notpower" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title need_reply_view" style="color:blue;">以下是隐藏的内容需要回复才可见，你回复后，需要刷新网页才可见!</div>************************************</div>';
                    }
                }
            }
            return $content;
        }, $info['content']);
            
        //指定用户组才能查看
        $info['content'] = preg_replace_callback('/\[group=([\d,]+)\](.*?)\[\/group\]/is',function($array=[])use($info){
                $content = $array[2];
                if ($content) {
                    $groupname = '';
                    $groupdb = getGroupByid();
                    $view_group = explode(',', $array[1]);
                    foreach ($view_group AS $value){
                        $groupname .= $groupdb[$value]."、";
                    }
                    if ($this->admin === true||$this->user['uid']==$info['uid']||in_array($this->user['groupid'],$view_group)) {
                        $content = '<div class="group_show hide_content" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:red;">以下是隐藏的内容，需要以下用户组才有权限查看:“'.$groupname.'”，因为你有特权，所以下面的内容可见</div>'.$content.'</div>';
                    }else{
                        $content = '<div class="group_show hide_content notpower" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:blue;">以下是隐藏的内容，需要以下用户组才有权限查看:“'.$groupname.'”</div>************************************</div>';
                    }
                }
                return $content;
            }, $info['content']);
                
        //输入密码才能查看
        $info['content'] = preg_replace_callback('/\[password=([^\]]+)\](.*?)\[\/password\]/is',function($array=[])use($info){
                    $content = $array[2];
                    if ($content) {
                        if ($this->admin === true || $this->user['uid']==$info['uid'] || $array[1]==cache(config('system_dirname').'content_password_'.$this->user['uid'].'_'.$info['id'])) {
                            $content = '<div class="password_show hide_content" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:red;">以下是隐藏的内容，需要输入密码才能查看，因为你有特权或已输入密码，所以下面的内容可见</div>'.$content.'</div>';
                        }else{
                            $content = '<div class="password_show hide_content notpower" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:blue;">以下是隐藏的内容，需要输入密码才能查看，<button data-s="'.mymd5("{$info['id']}\t{$array[1]}").'" class="password_butotn">点击输入密码</button></div>************************************</div>';
                        }
                    }
                    return $content;
                }, $info['content']);
        //消费积分才能查看
        $info['content'] = preg_replace_callback('/\[paymoney=([\d]+)\](.*?)\[\/paymoney\]/is',function($array=[])use($info){
                        $content = $array[2];
                        if ($content) {
                            if ($this->admin === true || $this->user['uid']==$info['uid'] || ($this->user&&in_array($this->user['username'], explode('、',$info['buyuser'])))) {
                                $content = '<div class="password_show hide_content" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:red;">以下是隐藏的内容，需要消费 '.$array[1].' 个积分才能查看，因为你有特权或已支付，所以下面的内容可见。已购买的用户如下:'.$info['buyuser'].'</div>'.$content.'</div>';
                            }else{
                                $content = '<div class="password_show hide_content notpower" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:blue;">以下是隐藏的内容，需要消费 '.$array[1].' 个积分才能查看。已购买的用户如下:'.$info['buyuser'].'，<button data-s="'.mymd5("{$info['id']}\t{$array[1]}").'" class="paymoney_butotn">我也要购买，立即支付</button></div>************************************</div>';
                            }
                        }
                        return $content;
                    }, $info['content']);
                        
        //权限圈内成员可见
        $info['content'] = preg_replace_callback('/\[qun\](.*?)\[\/qun\]/is',function($array=[])use($info){
                            $content = $array[1];
                            if ($content) {
                                if ($this->admin === true||$this->user['uid']==$info['uid']) {
                                    $content = '<div class="reply_show hide_content" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:red;">以下是隐藏的内容仅限圈内成员可见，因为你有特权，所以下面的内容可见</div>'.$content.'</div>';
                                }else{
                                    $ck = 0;
                                    if ($this->user && $info['ext_id'] && modules_config('qun')) {
                                        $ck = fun('qun@get_user_group',$info['ext_id'],$this->user['uid']);
                                    }
                                    if ($ck>0) {
                                        $content = '<div class="reply_show hide_content" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:red;">以下是隐藏的内容仅限圈内成员可见，你是圈内正式成员，所以下面的内容可见</div>'.$content.'</div>';
                                    }else{
                                        $content = '<div class="reply_show hide_content  notpower" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:blue;">以下是隐藏的内容仅限圈内成员可见！<button class="qunview_button">点击加入本圈</button></div>************************************</div>';
                                    }
                                }
                            }
                            return $content;
                        }, $info['content']);
         //$info['full_content']=$info['content'];
    }
    
}













