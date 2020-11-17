<?php
namespace app\search\admin;
use app\common\controller\AdminBase;
use think\Db;
use think\Cookie;
use app\common\traits\AddEditList;
class Gongju extends AdminBase{
	use AddEditList;
	protected $form_items=[];
	protected $list_items;
	protected $tab_ext;
	protected function _initialize(){
		parent::_initialize();
	}
	public function index(){
		if($this->request->isPost()){
			$data=$this->request->post();
			if(!$data['module']){
				$this->error('必须选择模块');
			}
			Cookie::set('modulename',$data['module'],86400);
			$this->success('下一步，请选择导入的模型','moxing');
		}
		$this->tab_ext=['page_title'=>'第一步选择模块（测试版 部分模块可能不支持）'];
		$module=Db::name('module')->where('ifopen',1)->select();
		foreach($module as $k=>$rs){
			if($rs['keywords']=='search'){
				continue;
			}
			$result[$k]['keywords']=$rs['keywords'];
			$result[$k]['name']=$rs['name'];
		}
		$result=array_column($result,'name','keywords');
		$this->form_items=[['radio','module','选择模块后点提交进入下一步','',$result]];
		return $this->addContent();
	}
	public function moxing(){
		if(Cookie::has('modulename')){
			if($this->request->isPost()){
				$data=$this->request->post();
				if(!$data['moduleid']){
					$this->error('必须选择模型');
				}
				Cookie::set('moduleid',$data['moduleid'],86400);
				$this->success('开始导入内容，您可以歇会了。','neirong');
			}
			$modulename=Cookie::get('modulename');
			$mikuai=Db::name('module')->where('keywords',$modulename)->value('name');
			if($modulename=='mall'){
				$this->redirect('neirong');
			}
			$result=array_column(Db::name($modulename.'_module')->where('status',0)->select(),'title','id');
			$this->tab_ext=['page_title'=>'第二步选择导入《'.$mikuai.'》的模型'];
			$this->form_items=[['radio','moduleid','选择模型后点提交进入下一步','如果是论坛 随便选择一个即可 只能导入论坛的内容 其他模型都不支持',$result]];
			return $this->addContent();
		}else{
			$this->success('模块不存在 请先选择模块','index');
		}
	}
	public function neirong($page=1){
		if(Cookie::has('modulename')){
			$modulename=Cookie::get('modulename');
			$moduleid=Cookie::get('moduleid');
			if($modulename=='bbs'){
				$prefix=config('database.prefix');
				$list=Db::table($prefix.'bbs_content1')->alias('a')->join($prefix.'bbs_contents w','a.id = w.id')->field('a.title,a.id,a.uid,a.create_time,w.content')->limit(100)->page($page)->select();
			}elseif($modulename=='mall'){
				$prefix=config('database.prefix');
				$list=Db::name($modulename.'_content')->where('status',1)->where('shangjia',0)->limit(100)->page($page)->select();
			}else{
				$list=Db::name($modulename.'_content'.$moduleid)->where('status',1)->limit(100)->page($page)->select();
			}
			foreach($list as $key=>$rs){
				$rs['content']=get_word($rs['title'].'####'.str_replace([
						"\r\n",
						"\t",
						'&ldquo;',
						'&rdquo;',
						'&nbsp;',
					],'',strip_tags($rs['content'])),300);
				$datas=[
					'aid'=>$rs[id],
					'uid'=>$rs[uid],
					'create_time'=>$rs[create_time],
					'module'=>$modulename,
					'data'=>$rs[content],
				];
				Db::name('search_content')->insert($datas);
			}
			if(!empty($list)){
				$page++;
				$pa=$page-1;
				$this->success("内容正在转换中，你可以去喝杯茶歇会... 第 {$pa} 页",url("neirong",['page'=>$page]),'',1);
				exit;
			}else{
				$this->success('数据转换完成',"index");
			}
		}
	}
}
