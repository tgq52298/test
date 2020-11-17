<?php
namespace app\zhidao\index;

use app\common\controller\index\C; 
use app\zhidao\traits\Content AS TraitsContent;

//内容页与列表页
class Content extends C
{
	 use TraitsContent;

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
	public function show($id){
	    return parent::show($id);
	}
	
	/**
	 * 新发表主题
	 * @param number $fid
	 * @param number $mid
	 * @return mixed|string
	 */
	public function add($fid=0,$mid=0){

	    if (!$this->user) {
	        $this->error('请先登录!');
	    }
        $this->assign('fid',$fid);
        $this->assign('mid',$mid);
	    return $this->fetch('post');
	}
	
	/**
	 * 修改主题
	 * @param number $id
	 * @return mixed|string
	 */
	public function edit($id=0){
	    if($id){
	        $this->mid = $this->model->getMidById($id);
	        $info = $this->getInfoData($id);
	        // print_r($info);
	        $fid = $info['fid'];
	        $mid = $info['mid'];
	        if (!$info) {
	            $this->error('ID有误,内容不存在');
	        }
	    }
	    $this->assign('id',$id);
	    $this->assign('info',$info);
	    $this->assign('fid',$fid);
	    $this->assign('mid',$mid);
	    return $this->fetch('post');
	}
	
}
