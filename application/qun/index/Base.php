<?php
namespace app\qun\index;

use app\common\controller\IndexBase;
use app\qun\model\Content;
use app\qun\model\Member;
use think\Request;

class Base extends IndexBase
{
    //protected $beforeActionList = ['base_info'];    //每一个方法必须要执行此行为
    protected $info = [];    //圈子信息
    protected $power; //圈子权限
    protected $id;  //圈子ID
    protected $is_empty = false; //是否为空方法或空控制器
    
    protected function _initialize(){
        parent::_initialize();
        $this->base_info();
    }
    
    /**
     * 获取圈子信息
     */
    public function base_info(){
        $id = input('aid')?:input('id');
        $power = -1;
        $info = Content::getInfoByid($id,true);   //圈子信息
        if (empty($info)) {
            $this->error('ID有误');
        }
        //$info['picurl'] = tempdir($info['picurl']);
        $this->info = $info;
        if ($this->user) {
            if($info['uid']==$this->user['uid'] || $this->admin){
                $power = 3; //超管与创建人
            }else{
                $m_info = Member::get([
                        'aid'=>$id,
                        'uid'=>$this->user['uid'],
                ]);
                if ($m_info['type']==2){
                    $power = 2; //管理员
                }elseif ($m_info && $m_info['type']==0){
                    $power = 0; //待审会员
                }elseif ($m_info){
                    $power = 1; //已审核的普通会员
                }
            }
        }
        $viewlimit = isset($info['_viewlimit']) ? $info['_viewlimit'] : $info['viewlimit'];     //避免后台设置了详情页是否隐藏为不隐藏
        if ($viewlimit && $power==0) {
            $this->error('你加入后,还没通过审核');
        }elseif($viewlimit && $power==-1){
            $this->error('你不是本圈成员,无权访问');
        }
        
        $this->power = $power;
        $this->id = $id;
        $this->assign('power',$power);  //用户在圈子里的权限, 2 是创建人, 1是普通管理员, -1是已审核的普通会员 -2是未认证的会员 0是圈外人
        $this->assign('info',$info);
        $this->assign('aid',$id);
        $this->assign('id',$id);
    }
    
    /**
     * 空方法 ,自适应
     * @param unknown $action
     * @return mixed|string
     */
    public function _empty($action)
    {
        $this->is_empty = true;
        if (!preg_match('/^[\w]+$/i', $action)) {
            $this->error('方法名有误!');
        }
        $this->run_api();
        $template = $this->get_tpl($action);
        $mid = input('mid');
        $mid && $this->assign('mid',$mid);
        return $this->fetch($template);
    }    
    
    /**
     * 每个模块的数据列表页
     * @return mixed|string
     */
    public function index($mid=1){
        $this->run_api();
        $template = $this->get_tpl('index',$mid);
        $this->assign('mid',$mid);
        return $this->fetch($template);
    }
    
    /**
     * 添加内容
     * @param number $mid
     * @return mixed|string
     */
    public function add($mid=1){
        $this->run_api();
        if (!$this->user) {
            $this->error('请先登录!');
        }elseif($this->power==0){
            $this->error('你还不是正式会员,无权发布!',urls('content/show',['id'=>input('aid')?:input('id')]));
        }elseif($this->power==-1){
            $this->error('你不是本'.QUN.'成员,无权发布!',urls('content/show',['id'=>input('aid')?:input('id')]));
        }
        $controller = strtolower($this->request->controller());
        $ext_sys = M('id');
        $id = input('id')?:input('aid');
        $url = murl($controller.'/content/add',['mid'=>$mid,'ext_id'=>$id,'ext_sys'=>$ext_sys]);
        $url .= '?fromurl='.urls('content/show',['id'=>$id]);
        $this->assign('url',$url);
        $this->assign('mid',$mid);
        $this->assign('id',$id);
        $template = $this->get_tpl('add',$mid);
        return $this->fetch($template);
	}
	
	/**
	 * 运行某个频道或插件里的方法
	 * @param string $action
	 * @return unknown
	 */
	protected function run_api(){
	    if ($this->is_empty!==true) {
	        return ;
	    }
	    $action = $this->request->action();
	    $controller = strtolower($this->request->controller());
	    $this->assign('sys_type',$controller);
	    $this->assign('myfid',input('myfid')?intval(input('myfid')):null); //这里要设置null,避免myfid不存在,报数据库错误
	    $class = (modules_config($controller)?'app':'plugins')."\\{$controller}\\index\\Qun";
	    if (class_exists($class) && method_exists($class, $action)) {
	        $obj = new $class;
	        $array = $obj->$action($this->info);
	        if (is_array($array)){
	            $this->assign($array);
	        }
	    }
	}
	
	/**
	 * 获取对应的模板
	 * @param string $type
	 * @return void|string
	 */
	protected function get_tpl($type='index',$mid=1){
        
	    $this->index_style_layout = $this->info['style'] ? search_style_tpl($this->info['style'].'/layout') : '';  //设置风格布局

	    $template = get_style_tpl($type,$this->info['style'],$mid);         //获取个性模板
	    if (empty($template)) {     //个性模板不存在,则取默认模板
	        $cfg = model_config($this->info['mid']);
	        $template = $this->search_tpl($type.$this->info['mid'].'_'.$mid);
	        if (empty($template) && $cfg['keyword']) {
	            $this->search_tpl($type.'-'.$cfg['keyword'].'_'.$mid);
	        }
	        
	        if (empty($template)) {
	            $template = $this->search_tpl($type.'_'.$mid);
	        }
	        
	        if (empty($template)) {
	            $template = $this->search_tpl($type.$this->info['mid']);
	        }
	        if (empty($template) && $cfg['keyword']) {
	            $this->search_tpl($type.'-'.$cfg['keyword']);
	        }
	        
	        
	        if (empty($template)) {
	            $template = $this->search_tpl($type);
	        }
	    }
	    
	    if (empty($template)) {   //默认模板也不存在,则取common目录的公共模板
	        $controller = strtolower($this->request->controller());
	        if ( empty(modules_config($controller)) && empty(plugins_config($controller)) ) {
	            $this->error('模板所在频道不存在!');
	        }
	        //$this->assign('sys_type',$controller);
	        if($type=='index'){
	            $template = getTemplate('../common/index');
	        }else{
	            die('当前模板不存在'.getTemplate($type,false));
	        }
	    }
	    return $template;
	}
	
	protected function search_tpl($tpl=''){
	    static $controller = null;
	    static $action = null;
	    static $default_dispatch = null;
	    static $if_plugin = null;
	    if($default_dispatch===null){
	        $default_dispatch = Request::instance()->dispatch();
	        $action = $this->request->action();
	        $controller = strtolower($this->request->controller());
	        $if_plugin = modules_config($controller) ? false : true;
	    }
	    $new_dispatch = $default_dispatch;
	    if($if_plugin==true){
	        $new_dispatch['module'][0] = 'index';
	        $new_dispatch['module'][1] = 'plugin';
	        $new_dispatch['module'][2] = 'execute';
	        $this->request->route([
	            'plugin_name'=>$controller,
	            'plugin_controller'=>'qun',
	            'plugin_action'=>$action,
	        ]);
	    }else{
	        $new_dispatch['module'][0] = $controller;
	        $new_dispatch['module'][1] = 'qun';
	        $new_dispatch['module'][2] = $action;
	    }	    
	    Request::instance()->dispatch($new_dispatch);      //设置当前请求的调度信息到某个频道寻找模板
	    $template = getTemplate($tpl);                     //寻找某个频道目录下的圈子接口模板
	    Request::instance()->dispatch($default_dispatch);  //恢复修改过的请求的调度信息
	    if($if_plugin==true){
	        $this->request->route([
	            'plugin_name'=>'',
	            'plugin_controller'=>'',
	            'plugin_action'=>'',
	        ]);
	    }
	    if($template){
	        return $template;
	    }else{	        
	        return getTemplate($tpl);      //兼容旧模板路径
	    }
	}
	
	
}
