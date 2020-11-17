<?php
namespace app\search\admin;
use app\common\controller\AdminBase;
use app\search\model\Keyword AS Model;
use app\common\traits\AddEditList;
class Content extends AdminBase{
	use AddEditList;
	protected $model;
	protected $form_items=[];
	protected $list_items;
	protected $tab_ext;
	protected function _initialize(){
		parent::_initialize();
		$this->model=new Model();
		$this->form_items=[['text','keyword','关键词'],['text','searchnums','搜索次数'],];
	}
	/**
	 * tags 首页
	 * @return mixed|string
	 */
	public function index(){
		$this->tab_ext=['page_title'=>'热搜管理',];
		$this->list_items=[['keyword','关键词名称','text.edit'],['searchnums','搜索次数','text.edit'],];
		$data=$this->model->order('searchnums','desc')->paginate(20);
		return $this->getAdminTable($data);
	}
	/**
	 * 添加
	 * @return mixed|string
	 */
	public function add(){
		$this->tab_ext=['page_title'=>'添加热搜词',];
		return $this->addContent();
	}
	/**
	 * 修改
	 * @param null $id
	 * @return mixed|string
	 */
	public function edit($id=null){
		$this->tab_ext=['page_title'=>'修改热搜词',];
		if(empty($id)){
			$this->error('缺少参数');
		}
		$info=$this->getInfoData($id);
		return $this->editContent($info,auto_url('index'));
	}
	/**
	 * 删除
	 * @param $ids
	 */
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
