<?php
namespace plugins\fav\admin;

use app\common\controller\AdminBase;

use app\common\traits\AddEditList;

use plugins\fav\model\Fav as FavModel;

class Fav extends AdminBase
{
	
	use AddEditList;	
	protected $validate = '';
	protected $model;
	protected $form_items = [];
	protected $list_items;
	protected $tab_ext = [
			'page_title'=>'收藏夹管理',
	        'top_button'=>[ ['type'=>'delete']],
	        'right_button'=>[ ['type'=>'delete']],
// 	        'hidden_edit'=>true,	
	];
	
	protected function getOrder(){
	    return 'id desc';
	}
	
	protected function _initialize()
    {
		parent::_initialize();
		$this->model = new FavModel();
		$this->list_items = [
				 
				['uid', '用户', 'callback',function($uid){
				    return get_user_name($uid);
				}],
				['create_time', '收录时间', 'text'],
				['sysid', '所属模块', 'callback',function($id){
				    $array = modules_config($id);
				    return $array['name'];
				}],
				['aid', '标题', 'callback',function($id,$rs){
				    $array = FavModel::get_info($rs['aid'],$rs['sysid']);
				    return "<a href='{$array['url']}' target='_blank'>{$array['title']}</a>";
				},'__data__'],			
			];
	}

}
