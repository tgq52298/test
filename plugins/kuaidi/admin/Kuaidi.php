<?php
namespace plugins\kuaidi\admin;
use app\common\controller\AdminBase;
use plugins\kuaidi\model\Kuaidi AS Model;
use app\common\traits\AddEditList;
class Kuaidi extends AdminBase{
	use AddEditList;
	protected $model;
	protected $form_items=[];
	protected $list_items;
	protected $tab_ext;
	protected function _initialize(){
		parent::_initialize();
		$this->model=new Model();
		$this->form_items=[
			['text','name','快递公司'],
			['text','bianhao','快递鸟编号'],
			['text','yibai','快递100编码'],
			['text','kuaibao','快宝编码'],
		];
	}
	public function index(){
		$this->tab_ext=[
			'page_title'=>'快递公司管理',
		];
		$this->list_items=[
			['name','快递公司','text.edit'],
			['bianhao','快递鸟编码','text'],
			['yibai','快递100编码','text'],
			['kuaibao','快宝编码','text'],
		];
		$data=$this->model->order('id','desc')->select();
		$this->tab_ext=['help_msg'=>'每家的快递都不一致，大小写敏感 注意大小写'];
		return $this->getAdminTable($data);
	}
	public function add(){
		$this->tab_ext=[
			'page_title'=>'添加快递公司',
		];
		$xiazaiurl=request()->domain().'/plugins/kuaidi/index/code.xls';
		$this->tab_ext=['help_msg'=>'您可以使用我们整理的常用快递综合<a href="'.$xiazaiurl.'" target="_blank" style="color: #ed2822">点此下载整理后快递码</a><br>您也可以单独下载下面的进行自己设置<br><a href="http://www.kdniao.com/file/%E5%BF%AB%E9%80%92%E9%B8%9F%E6%8E%A5%E5%8F%A3%E6%94%AF%E6%8C%81%E5%BF%AB%E9%80%92%E5%85%AC%E5%8F%B8%E7%BC%96%E7%A0%81.xlsx" target="_blank" style="color: #ed2822">点此下载快递鸟编码</a><br><a href="http://software.kuaidihelp.com/platform/company_code.xls" target="_blank" style="color: #ed2822">点此下载快宝编码</a><br><a href="https://cdn.kuaidi100.com/download/chaxun(20140729).doc" target="_blank" style="color: #ed2822">点此下载快递100编码</a>'];
		return $this->addContent();
	}
	public function edit($id=null){
		$this->tab_ext=[
			'page_title'=>'修改快递公司',
		];
		if(empty($id)){
			$this->error('缺少参数');
		}
		$xiazaiurl=request()->domain().'/plugins/kuaidi/index/code.xls';
		$this->tab_ext=['help_msg'=>'您可以使用我们整理的常用快递综合<a href="'.$xiazaiurl.'" target="_blank" style="color: #ed2822">点此下载整理后快递码</a><br>您也可以单独下载下面的进行自己设置<br><a href="http://www.kdniao.com/file/%E5%BF%AB%E9%80%92%E9%B8%9F%E6%8E%A5%E5%8F%A3%E6%94%AF%E6%8C%81%E5%BF%AB%E9%80%92%E5%85%AC%E5%8F%B8%E7%BC%96%E7%A0%81.xlsx" target="_blank" style="color: #ed2822">点此下载快递鸟编码</a><br><a href="http://software.kuaidihelp.com/platform/company_code.xls" target="_blank" style="color: #ed2822">点此下载快宝编码</a><br><a href="https://cdn.kuaidi100.com/download/chaxun(20140729).doc" target="_blank" style="color: #ed2822">点此下载快递100编码</a>'];
		$info=$this->getInfoData($id);
		return $this->editContent($info,auto_url('index'));
	}
	public function delete($ids){
		if(empty($ids)){
			$this->error('ID有误');
		}
		$ids=is_array($ids)?$ids:[$ids];
		if($this->model->destroy($ids)){
			$this->success('删除成功','index');
		}else{
			$this->error('删除失败');
		}
	}
}

 