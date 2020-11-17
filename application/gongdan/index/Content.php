<?php
namespace app\gongdan\index;

use app\common\controller\index\C; 


//列表页与内容页
class Content extends C
{
    protected $is_iframe = false;  //框架调用表单页
	/**
	 * 列表页
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::index()
	 */
	public function index($fid=0,$mid=0){
	    return parent::index($fid,$mid);
	}
	
	/**
	 * 内容详情页
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::show()
	 */
	public function show($id,$iframe=0){
	    if ($iframe) {
	        $this->is_iframe = true;
	    }
	    return parent::show($id);
	}
	
	protected function get_tpl($type='show',$mid=0,$sort=[],$info=[]){
	    if ($this->is_iframe) {
	        return 'iframe';
	    }
	    return parent::get_tpl($type,$mid,$sort,$info);
	}
	
	protected function view_check(&$info=[]){
	    parent::view_check($info);	    
	    $info = array_merge(get_post(),$info);
	    $this->assign('f_array',fun('field@order_field_post',$info['order_filed'])); //用户自定义表单字段,
	}
}
