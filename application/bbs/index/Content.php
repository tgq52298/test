<?php
namespace app\bbs\index;

use app\common\controller\index\C; 
use app\bbs\model\Reply AS ReplyModel;

//内容页与列表页
class Content extends C
{
	
	/**
	 * 列表页
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::index()
	 */
	public function index($fid=0,$mid=0){	    
	    return parent::index($fid,$mid);
	}
	
	/**
	 * 内容详情页
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::show()
	 */
	public function show($id){
	    $this->haibao = 'content/haibao';  //默认海报模板路径
	    return parent::show($id);
	}
	
	/**
	 * 浏览权限检查
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::view_check()
	 */
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
	                    $content = '<div class="reply_show hide_content  notpower" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:blue;">以下是隐藏的内容需要回复才可见，你回复后，需要刷新网页才可见!</div>************************************</div>';
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
	                if ($this->admin === true || $this->user['uid']==$info['uid'] || $array[1]==get_cookie(config('system_dirname').'content_password_'.$info['id'])) {
	                    $content = '<div class="password_show hide_content" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:red;">以下是隐藏的内容，需要输入密码才能查看，因为你有特权或已输入密码，所以下面的内容可见</div>'.$content.'</div>';
	                }else{
	                    $content = '<div class="password_show hide_content notpower" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:blue;">以下是隐藏的内容，需要输入密码才能查看，<button onclick="view_content_password(\''.mymd5("{$info['id']}\t{$array[1]}").'\')" class="password_butotn">点击输入密码</button></div>************************************</div>';
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
	                    $content = '<div class="password_show hide_content notpower" style="border:5px dashed #ddd;padding:5px;"><div class="reply_title" style="color:blue;">以下是隐藏的内容，需要消费 '.$array[1].' 个积分才能查看。已购买的用户如下:'.$info['buyuser'].'，<button onclick="view_content_paymoney(\''.mymd5("{$info['id']}\t{$array[1]}").'\')" class="paymoney_butotn">我也要购买，立即支付</button></div>************************************</div>';
	                }
	            }
	            return $content;
	        }, $info['content']);
	    
	    parent::view_check($info);
	}
	
	/**
	 * 新发表主题
	 * @param number $fid
	 * @param number $mid
	 * @return mixed|string
	 */
	public function add($fid=0,$mid=0,$ext_sys=0,$ext_id=0){
	    if (!$this->user) {
	        if ( in_weixin() && config('webdb.weixin_type')==3  ) {  //在微信端,就强制自动登录!
	            weixin_login();
	        }else{
	            $this->error('请先登录!');
	        }	        
	    }
	    if ($fid) {
	        $mid = $this->model->getMidByFid($fid);
	    }
	    if (empty($mid)) {
	        $mid = 1;
	    }
	    $fromurl = $ext_id?urlencode(urls(($ext_sys?modules_config($ext_sys)['keywords']:'qun')."/content/show",["id"=>$ext_id])):"";
        $this->assign('fid',$fid);
        $this->assign('mid',$mid);
        $this->assign('ext_sys',$ext_sys);
        $this->assign('ext_id',$ext_id);
        $this->assign('fromurl',$fromurl);
        $template = $this->get_tpl('post',$mid);
	    return $this->fetch($template);
	}
	
	/**
	 * 修改主题
	 * @param number $id
	 * @return mixed|string
	 */
	public function edit($id=0){
	    if($id){
	        $this->mid = $this->model->getMidById($id);
	        $info = $this->getInfoData($id);
	        $fid = $info['fid'];
	        $mid = $info['mid'];
	        if (!$info) {
	            $this->error('ID有误,内容不存在');
	        }elseif($info['uid']!=$this->user['uid'] && empty($this->admin)){
	            $this->error('你没权限');
	        }
	    }else{
	        $this->error('ID不存在');
	    }
	    //$fromurl = $info['ext_id']?urlencode(urls(($info['ext_sys']?modules_config($info['ext_sys'])['keywords']:'qun')."/content/show",["id"=>$info['ext_id']])):"";
	    $fromurl = urls('show',['id'=>$id]);
	    $this->assign('id',$id);
	    $this->assign('info',$info);
	    $this->assign('fid',$fid);
	    $this->assign('mid',$mid);
	    $this->assign('fromurl',$fromurl);
	    $template = $this->get_tpl('post',$mid);
	    return $this->fetch($template);
	}
	
}
