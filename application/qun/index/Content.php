<?php
namespace app\qun\index;

use app\common\controller\index\C; 
use app\qun\model\Member AS QMember;

//内容页与列表页
class Content extends C
{
    //取消每次刷新都更新点击
    protected function updateView($id){
    }
    
    /**
     * 用户级别
     * @param unknown $id
     * @return void|number
     */
    protected function get_user_group($id){
        $user = $this->user;
        if (empty($user)) {
            return ;
        }
        $map = [
                'aid'=>$id,
                'uid'=>$user['uid']
        ];
        $info = getArray(QMember::get($map));
        if(empty($info)){
            return ;
        }
        $data = [];
        if ($info['end_time'] && $info['end_time']<time()) {  //设置了有效期
            $data['type'] = $info['type']>1 ? 1 : 0 ;
            $data['end_time'] = 0;  //要清0,不然上面会反复判断的
        }
        if(time()-$info['update_time']>60 || $data){
            $data['update_time'] = time();
            $data['id'] = $info['id'];
            QMember::update($data);
        }
        if($info['type']==0){
            return -1;
        }else{
            return $info['type'];
        }
    }
	
	/**
	 * 列表页
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::index()
	 */
	public function index($fid=0,$mid=0){
	    return parent::index($fid,$mid);
	}
	
	/**
	 * 升级用户组
	 * @param array $info
	 */
	protected function upgroup($info=[]){
// 	    if ($info['status']>0 && $this->webdb['post_auto_up_group'] && $this->user['uid']==$info['uid']) {
// 	        if ($this->webdb['post_auto_up_group']==3 || $this->webdb['post_auto_up_group']==8 || $this->user['groupid']!=8) {
// 	            return ;
// 	        }
// 	        if($this->user['groupid']==8){
// 	            $array = [
// 	                    'uid'=>$this->user['uid'],
// 	                    'groupid'=>$this->webdb['post_auto_up_group'],
// 	            ];
// 	            edit_user($array);
// 	        }
// 	    }
	}
	
	/**
	 * 内容详情页
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::show()
	 */
	public function show($id=0)
	{
		//获取内容数据
	    $info = $this->getInfoData($id);	    
	    if(empty($info)){
	        $this->error('数据不存在!',404);
	    }	

	    if ( empty($this->user) && in_weixin() && config('webdb.weixin_type')==3  ) {  //在微信端,就强制自动登录!
	        if ($info['style']!='simple') {  //小程序审核专用风格,不要强制登录,影响审核
	            weixin_login();
	        }
	    }	    
	        
	    $this->mid = $info['mid'];
	    
	    $this->get_hook('cms_content_show',$info,$this->user);
	    Hook_listen('cms_content_show',$info,$this->user);
	    
	    $this->view_check($info);   //访问权限检查
	    
	    $this->haibao = 'content/haibao';  //默认海报模板路径

	    $this->set_haibao($info);   //设置海报
	    
	    $this->updateView($id);     //更新浏览量
	    
	    $this->upgroup($info);  //升级用户组

	    $info['field_array'] = $this->get_field_fullurl($info);     //这行必须放在 format_field 的前面,这里要用到原始数据
	    //$info = fun('field@format',$info,'','show');

	    //下面代码主要是避免 format_field 函数里边强行把picurl输出<img 这样的内容,导致无法对图片做个性显示
	    if($info['field_array']['pics']['value']){  //CMS图库特别处理
	        $info['picurls'] = $info['field_array']['pics']['value'];
	        $info['picurl'] = $info['field_array']['pics']['value'][0]['picurl'];
	    }else{
	        $_picurl = $info['field_array']['picurl']['value'];
	        if(is_array($_picurl)){
	            $info['picurl'] = $_picurl[0]['picurl'];
	            $info['picurls'] = $_picurl;
	        }else{
	            $info['picurl'] = $_picurl;
	        }
	    }
	    
	    
	    $GLOBALS['fid'] = $info['fid'];     //标签有时会用到
	    
	    //栏目配置信息
	    $s_info = get_sort($info['fid'],'config');
	    
	    $style = $info['_style']?:$info['style'];  //有可能存在 $info['_style'] 是转义后新增加的变量,为保持原始值 因为 $info['style'] 被转义过了
	    $template = '';
	    if($style){
	        $template = get_style_tpl('show',$style);
	        $this->index_style_layout = $style ? search_style_tpl($style.'/layout') : '';  //设置风格布局
	    }
	    $template || $template = $this->get_tpl('show',$this->mid,$s_info);
	    
	    if (input('my_qid')==$id) {
	        set_cookie('HYID',$id);    //做个标志,比如底部菜单,可以全站调用此圈子的
	    }
	    if (empty(get_cookie('home_qun_id'))) {
	        set_cookie('home_qun_id',$id);     //首次进入的圈子,方便其它页面返回,这个跟上面那个参数有点雷同
	    }
	    set_cookie('last_qun_id',$id); //最后一次访问的圈子,方便其它页面返回,这个跟上面那个参数有点雷同
	    
	    //模板里要用到的变量值
	    $vars = [
	            'info'=>$info,
	            'id'=>$id,
	            'fid'=>$info['fid'],
	            'mid'=>$info['mid'],
	            'listdb'=>$info['picurls'],
	            's_info'=>$s_info,
	    ];
	    return $this->fetch($this->haibaoiframe?:$template,$vars);
	}
	

	/**
	 * 单独的海报生成页给框架使用
	 * @param unknown $id 圈子ID
	 * @param string $pagetype  home圈子主页 msg群聊页
	 * @param string $imgtype wxapp 小程序码 wap普通二维码
	 * @return mixed|string
	 */
	public function haibaoiframe($id,$pagetype='home',$imgtype='wxapp'){
	    $this->haibaoiframe = 'haibaoiframe';
	    if ($pagetype=='msg') {
	        $url = urls('index/msg/index').'?uid=-'.$id.'&p_uid='.$this->user['uid'];
	    }else{
	        $url = urls('show',['id'=>$id]).'?p_uid='.$this->user['uid'];
	    }	    
	    if($imgtype=='wxapp'){
	        $codeimg = fun('wxapp@wxapp_codeimg',$url,$this->user['uid']);
	    }else{
	        $codeimg = get_qrcode($url);  //普通wap二维码
	    }
	    $this->assign('codeimg',$codeimg);	    
	    return $this->show($id);
	}
	
	/**
	 * 申请加入圈子
	 * @param number $id
	 * @return mixed|string
	 */
	public function apply($id=0){
	    if (empty($this->user)) {
	        $this->error('请先登录!');
	    }
	    $info = $this->getInfoData($id);
	    if (empty($info)) {
	        $this->error('信息不存在,可能ID有误!');
	    }
	    $gid = $this->get_user_group($info['id']);
	    $this->assign('gid', $gid);
	    $this->assign('info', $info);
	    $this->assign('id', $id);
	    return $this->fetch();
	}
	
	/**
	 * 重写方法
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::view_check()
	 */
	protected function view_check(&$info=[]){
	    parent::view_check($info);
	    $gid = $this->get_user_group($info['id']);
	    if ($this->user['uid']==$info['uid'] && empty($gid)) {
	        QMember::add([
	            'aid'=>$info['id'],
	            'uid'=>$info['uid'],
	            'create_time'=>time(),
	            'type'=>3
	        ]);
	    }
	    if($info['viewlimit'] && !$this->admin && $this->user['uid']!=$info['uid']){
	        if ($gid==-1) {
	            $this->error('你还没通过审核,只有正式成员才可以访问!');;
	        }elseif($gid<1){
	            $this->error('你不是本'.QUN.'成员,只有本'.QUN.'正式成员才可以访问!,你可以点击申请成为本'.QUN.'成员',urls('apply',['id'=>$info['id']]),'',3);
	        }
	    }
	    $this->assign('gid', $gid);	    
	}
	
	/**
	 * 创建圈子
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::add()
	 */
	public function add($mid=0,$type='',$fid=0){
	    if(!$this->user){
	        return $this->error('你还没登录');
	    }
	    $array_mid = $array_fid = [];
	    $models = model_config();
	    if ( empty($mid) && empty($fid) ) {
	        if (count($models)>1) {
	            $array_mid = $models;
	        }else{
	            $array_fid = \app\qun\model\Sort::getTreeList(0, 1);
	        }	        
	    }elseif($mid){
	        $this->redirect(murl('add',['mid'=>$mid]));
	    }elseif($fid){
	        $this->redirect(murl('add',['fid'=>$fid]));
	    }
	    $this->assign('array_mid',$array_mid);
	    $this->assign('array_fid',$array_fid);
	    $this->assign('header_title','创建'.QUN);
// 	    $this->assign('mid',$mid);
// 	    $this->assign('fid',$fid);
// 	    $this->assign('type',$type);
	    $tpl='';
// 	    if (empty(in_weixin())||$type!='') {
// 	        $tpl = 'post';
// 	    }else{
// 	        $tpl = 'choose_post';
// 	    }
	    return $this->fetch($tpl);
	}
	
	/**
	 * 我的圈子
	 * @return mixed|string
	 */
	public function my(){
	    if (empty($this->user)) {
	        $this->error('你还没登录!');
	    }
	    $this->assign('uid',$this->user['uid']);
	    return $this->fetch();
	}
	
	/**
	 * 加载显示相应页面
	 * @param number $id
	 * @param string $pagetype
	 * @return mixed|string
	 */
	protected function pagebase($id=0,$pagetype='abouts'){
		//获取内容数据
		$info = $this->getInfoData($id);
		if(empty($info)){
		    $this->error('ID有误!');
		}
		$vars = [
				'info'=>$info,
				'id'=>$id,
				'fid'=>$info['fid'],
				'mid'=>$info['mid'],
		];
		$template = $pagetype;
		return $this->fetch($template,$vars);		
	}
	
	//关于我们
	public function abouts($id=0){
		return $this->pagebase($id,'abouts');
	}
	
	//联系我们
	public function contact($id=0){
		return $this->pagebase($id,'contact');

	}
	
	
}
