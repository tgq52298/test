<?php
namespace app\bespeak\admin;
use app\common\controller\admin\Order AS _Order;

class Order extends _Order
{
	/**
	 * 列表页
	 * @return unknown|mixed|string
	 */
	public function index() {
	    if ($this->request->isPost()) {
	        //修改排序
	        return $this->edit_order();
	    }
	    
	    //列表定义显示的字段
	    $list_field = \app\common\field\Table::get_list_field(-1);
	    $array = [
	    	 ['shopid', '服务名称', 'callback',function($shopid){ $shop_url = iurl('content/show',['id'=>$shopid]);$shop_name = get_one_contents($shopid)['title'];return "<a href='{$shop_url}' target='_blank'>{$shop_name}</a>";}],
	            ['order_sn', '预约号', 'text'],
	            ['order_bespeak_time', '预约时间', 'datetime'],

	            ['pay_status', '预约状态', 'callback',function($pay_status){if($pay_status==1){return '预约成功';}else if($pay_status==2){return '预约失败';}else if($pay_status==3){return '用户已取消预约';}else{return '待审核';}}],
	
	            ['uid', '预约帐号', 'username'],
	            ['create_time', '提交时间', 'text'],
	    ];
	    $this->list_items = $list_field ? array_merge($array,$list_field) : $array;
	    
	    //搜索字段
	    $search = \app\common\field\Table::get_search_field(-1);
	    $this -> tab_ext['search'] = array_merge(['uid'=>'用户uid'],$search);
	    
	    //筛选字段
	    $this->tab_ext['filter_search'] = \app\common\field\Table::get_filtrate_field(-1);
	    
	    //右边菜单
	    $this -> tab_ext['right_button'] = [
	            ['type'=>'delete'],
	            ['type'=>'edit'],
	            [
	                    'icon'=>'fa fa-file-o',
	                    'title'=>'详情',
	                    'url'=>auto_url('show','id=__id__'),
	            ],
	    ];
	    
	    $listdb = self::getListData($map = [], $order = []);
	    return $this -> getAdminTable($listdb);
	}


	/**
	 * 查看详情
	 * @param number $id
	 * @return \app\common\traits\unknown
	 */
	public function show($id=0){
	    
	    $form_items = \app\common\field\Form::get_all_field(-1);    //自定义字段
	    $this->form_items = array_merge(
	            [
	                    ['text','order_sn', '预约号'],
	                    ['datetime','order_bespeak_time','预约时间'],
	                    ['radio','pay_status','预约状态','',['待审核','预约成功','预约失败','用户已取消预约']],
	                    ['datetime','create_time', '提交时间'],
	            ],
	            $form_items
	     );
	    $info = getArray( $this->getInfoData($id) );
	    $info = fun('field@format',$info,'','show','',$this->form_items);  //数据转义
	    return $this->getAdminShow($info) ;
	}


	/**
	 * 修改页
	 * @param unknown $id
	 * @return mixed|string
	 */
	public function edit($id = null) {
		if (empty($id)) $this -> error('缺少参数');
		if ($this->request->isPost()) {
		    $data = $this->request->post();
		    $data = \app\common\field\Post::format_all_field($data,-1); //对一些特殊的自定义字段进行处理,比如多选项,以数组的形式提交的;
		    $this->request->post($data);
		}else{
		    $this->form_items = \app\common\field\Form::get_all_field(-1);  //自定义字段
		    $info = $this -> getInfoData($id);
		}        
		return $this -> editContent($info);
	}




}