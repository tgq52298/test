<?php
namespace plugins\alilive\admin;

use app\common\controller\AdminBase;
use app\common\traits\AddEditList;
use plugins\alilive\model\Log as LogModel;
use plugins\alilive\index\Api;

class Log extends AdminBase
{
	use AddEditList;	
	protected $validate = '';
	protected $model;
	protected $form_items = [];
	protected $list_items;
	protected $tab_ext = [
			'page_title'=>'日志',	        
	        'right_button'=>[ ['type'=>'delete']],
// 	        'hidden_edit'=>true,	
	];
	
	protected function getOrder(){
	    return 'id desc';
	}
	
	protected function _initialize()
    {
		parent::_initialize();
		$this->model = new LogModel();


		$this->list_items = [
		        ['create_time', '创建时间', 'datetime'],
				['uid', '用户', 'username'],
				['ext_id', '所属圈子', 'callback',function($id,$rs){
				    if (empty($id)) {
				        return ;
				    }
				    $qun = fun('qun@getByid',$id);
				    $url = iurl('qun/content/show',['id'=>$id]);
				    return "<a href='$url' target='_blank'>{$qun['title']}</a>";
				},'__data__'],
				['timelong', '时长(秒)', 'text'],
				['id', '接口地址', 'callback',function($id,$rs){
				    $str = '推流地址：<input type="text" style="width:300px;" value="'.$rs['push_url'].'">';
				    $str .= '<br>播流flv地址：<input type="text" style="width:300px;" value="'.$rs['flv_url'].'">';
				    $str .= '<br>播流m3u8地址：<input type="text" style="width:300px;" value="'.$rs['m3u8_url'].'">';
				    $str .= '<br>播流rtmp地址：<input type="text" style="width:300px;" value="'.$rs['rtmp_url'].'">';
				    return $str;
				},'__data__'],
			];
	}
	
	public function add(){
	    
	    if ($this -> request -> isPost()) {
	        $data = $this->request->post();	        
	        if (empty($data['keyword'])) {
	            $this->error('关键字不能为空!');
	        }
	        $api = new Api();
	        $array = $api->url($data['keyword'],true);
	        if (!is_array($array)) {
	            $this->error($array);
            }
            $result = LogModel::add($this->user['uid'],0,0,$array);
            if ($result) {
                $this->success('操作成功','index');
            }else{
                $this->error('生成失败!');
            }	        
	        
	    }
	    $this->tab_ext['page_title'] = '创建推流与播流';
	    $this->form_items = [
	        //['money','rmb','充值卡面额'],
	        //['text','path1','一级目录','只能英文或数字','live'],
	        ['text','keyword','唯一关键字','只能英文或数字',rands(5)],
	    ];
	    return $this->addContent();
	}

}
