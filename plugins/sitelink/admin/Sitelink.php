<?php
namespace plugins\sitelink\admin;
use app\common\controller\AdminBase;
use plugins\sitelink\model\Sitelink AS Model;
use app\common\traits\AddEditList;
class Sitelink extends AdminBase{
	use AddEditList;
	protected $model;
	protected $form_items=[];
	protected $list_items;
	protected $tab_ext;
	protected function _initialize(){
		parent::_initialize();
		$this->model=new Model();
		$this->form_items=[
			['text','name','关键词名称'],
			['text','link','关键词连接地址'],
			['text','num','替换次数','','1'],
			['radio','status','状态','',['隐藏','显示'],1],
			['text','sort','排序值'],
		];
	}

	/**
	 * 音乐首页
	 * @return mixed|string
	 */
	public function index(){
		$this->tab_ext=[
			'page_title'=>'关键词内联管理',
		];
		$this->list_items=[
			['name','关键词名称','text.edit'],
			['link','连接地址','text.edit'],
			['num','替换次数','text.edit'],
			['sort','排序值','text.edit'],
		];
		$data=$this->model->order('sort','desc')->select();
		return $this->getAdminTable($data);
	}

	/**
	 * 添加音乐
	 * @return mixed|string
	 */
	public function add(){
		$this->tab_ext=[
			'page_title'=>'添加关键词',
		];
		return $this->addContent();
	}

	/**
	 * 修改音乐
	 * @param null $id
	 * @return mixed|string
	 */
	public function edit($id=null){
		$this->tab_ext=[
			'page_title'=>'修改关键词',
		];
		if(empty($id))
			$this->error('缺少参数');
		$info=$this->getInfoData($id);
		return $this->editContent($info,auto_url('index'));
	}

	/**
	 * 删除音乐
	 * @param $ids
	 */
	public function delete($ids){
		if(empty($ids)){
			$this->error('ID有误');
		}
		$ids=is_array($ids)?$ids:[$ids];
		if($this->model->destroy($ids)){
			$this->success('删除成功','index');
		}
		else{
			$this->error('删除失败');
		}
	}
}

 