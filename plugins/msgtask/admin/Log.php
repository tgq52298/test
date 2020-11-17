<?php
namespace plugins\msgtask\admin;

use app\common\controller\AdminBase;
use app\common\traits\AddEditList;
use plugins\msgtask\model\Task AS TaskModel;
use plugins\msgtask\model\Log AS LogModel;
//use think\Db;

class Log extends AdminBase
{
	use AddEditList;	
	protected $validate = '';
	protected $model;
	protected $form_items = [];
	protected $list_items;
	protected $tab_ext = [];
	
	protected function _initialize(){
	    parent::_initialize();
	    $this->model = new LogModel();
	}
	
	public function index($tid=0){
	    $this->tab_ext['top_button'] = [
	        [
	            'type'=>'delete',
	            'title'=>'批量删除'
	        ],
	        [
	            'title'=>'返回',
	            'icon'=>'fa fa-share',
	            'url'=>purl('task/index'),
	        ],
	    ];
	    $this->tab_ext['right_button'] = [
	        ['type'=>'delete'],
	    ];
	    $this->tab_ext['page_title'] = '消息任务用户列表';
	    $this->list_items = [
	        ['touid','接收者','username'],
	        ['tid','发送者','callback',function($key,$rs){
	            $uid = TaskModel::where('id',$key)->value('uid');
	            return get_user($uid)['username'];
	        }],
	        ['tid','标题','callback',function($key,$rs){
	            $title = TaskModel::where('id',$key)->value('title');
	            return $title;
	        }],	        
	        ['ifsend','发送与否','yesno'],
	    ];
	    $map = [];
	    if ($tid>0) {
	        $map['tid'] = $tid;
	    }
	    $listdb = $this->getListData($map, $order = '');
	    return $this -> getAdminTable($listdb);
	}
	
	
	
}
