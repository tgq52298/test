<?php
namespace plugins\links\admin;

use app\common\controller\AdminBase;
use plugins\links\model\Links AS Model;
use app\common\traits\AddEditList;

class Links extends AdminBase{
    
	use AddEditList;
	protected $model;
	protected $form_items;
	protected $list_items;
	protected $tab_ext;
	
	protected function _initialize(){
		parent::_initialize();
		$this->model = new Model();
		$this->form_items = [
			['text','name','链接名称'],
		    ['text','link','链接网址'],
		    ['radio','type','链接类型','',['1'=>'图片链接','0'=>'文字链接'],'img'],			
			['image','image','LOGO'],
		    ['textarea','image_about','LOGO描述'],
		    ['textarea','name_about','文字描述'],
			['radio','status','状态','',['隐藏','显示'],1],
			['text','sort','排序值'],
		];
		
		//触动显示
		$this->tab_ext['trigger'] = [
		    ['type','1','image,image_about'],
		    ['type','0','name_about'],
		];
	}

	/**
	 * 友情链接首页
	 * @return mixed|string
	 */
	public function index(){
		$this->tab_ext=[
			'page_title'=>'友情链接管理',
		];
		$this->list_items=[
			['name','名称','text'],
		    ['type','是否为图片链接','yesno'],
			['link','链接','text.edit'],
			['sort','排序值','text.edit'],
		];
		$data=$this->model->order('sort','desc')->select();
		return $this->getAdminTable($data);
	}

	/**
	 * 添加友情链接
	 * @return mixed|string
	 */
	public function add(){
		$this->tab_ext['page_title'] = '添加友情链接';
		return $this->addContent();
	}

	/**
	 * 修改友情链接
	 * @param null $id
	 * @return mixed|string
	 */
	public function edit($id=null){
	    $this->tab_ext['page_title']='修改友情链接';
		if(empty($id)){
		    $this->error('缺少参数');
		}
		$info=$this->getInfoData($id);
		return $this->editContent($info,auto_url('index'));
	}

	/**
	 * 删除友情链接
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

 