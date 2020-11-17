<?php
namespace plugins\msgtask\admin;

use app\common\controller\AdminBase;
use app\common\traits\AddEditList;
use plugins\msgtask\model\Task AS TaskModel;
use plugins\msgtask\model\Log AS LogModel;
//use think\Db;

class Task extends AdminBase
{
	use AddEditList;	
	protected $validate = '';
	protected $model;
	protected $form_items = [];
	protected $list_items;
	protected $tab_ext = [
			'page_title'=>'消息任务列表',
	];
	
	protected function _initialize(){
	    parent::_initialize();
	    $this->model = new TaskModel();
	}
	
	public function index(){
	    $this->list_items = [
	        ['title','标题','text'],
	        ['type','发送渠道','callback',function($key,$rs){
	            $names = ['短消息','微信','短信','邮件'];
	            $array = [];
	            $detail = explode(',',$key);
	            foreach($detail AS $v){
	                $array[] = $names[$v];
	            }
	            return implode(',', $array);
	        }],
	        ['uid','发送者','username'],
	        ['id','接收用户数','callback',function($key,$rs){
	            return LogModel::where('tid',$key)->count('id');
	        }],
	        ['create_time','创建日期','datetime'],
	        ['begin_time','定时发送','datetime'],
	        ['content','内容','text'],
	    ];
	    $this->tab_ext['top_button'] = [
	        [
	            'type'=>'add',
	            'title'=>'群发消息',
	            'url'=>purl('info/add'),
	        ],
	        [
	            'type'=>'delete',
	            'title'=>'批量删除'
	        ],
	    ];
	    $this->tab_ext['right_button'] = [	        
	        [
	            'title'=>'用户列表',
	            'url'=>purl('log/index',['tid'=>'__id__']),
	        ],
	        ['type'=>'delete'],
	    ];
	    $this->tab_ext['help_msg'] = '注意：只有选择定时任务方式群发的消息才有记录。';
	    $listdb = $this->getListData($map = [], $order = '');
	    return $this -> getAdminTable($listdb);
	}
	
	/**
	 * 删除任务,会把用户列表一起删除
	 * @param unknown $ids
	 */
	public function delete($ids = null){
	    $ids = is_array($ids)?:[$ids];
	    foreach ($ids AS $id){
	        LogModel::where('tid',$id)->delete();
	    }
	    if ($this -> deleteContent($ids)) {
	        $this -> success('删除成功');
	    } else {
	        $this -> error('删除失败');
	    }
	}
	
	
}
