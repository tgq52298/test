<?php
namespace app\shop\member;

use app\common\controller\member\C;
use app\shop\traits\Content AS TraitsContent;
use app\shop\model\Content AS ContentModel;

class Content extends C
{	
    use TraitsContent;
    
    /**
     * 我发布的内容
     * {@inheritDoc}
     * @see \app\common\controller\member\C::index()
     */
	public function index($fid=0,$mid=0)
	{
	    define('SHOW_RUBBISH',true);  //显示回收站的内容
	    $this->tab_ext['right_button'] = [
	        [
	            'type'=>'delete',
	            'title'=>'下架',
	            'icon'=>'fa fa-download',
	        ],
	        ['type'=>'edit'],
	        [
	            'url'=>iurl('show','id=__id__'),
	            'icon'=>'glyphicon glyphicon-eye-open',
	            'title'=>'浏览',
	            'target'=>'_blank',
	        ],
	    ];
	    
	    if(count(model_config())>1&&!$mid&&!$fid){
	        return parent::listall();
	    }else{
	        return parent::index($fid,$mid);
	    }	    
	}
	
	public function recover($id=0){
	    define('SHOW_RUBBISH',true);  //显示回收站的内容
	    $info = ContentModel::getInfoByid($id);
	    if (!$info) {
	        $this->error("内容不存在!");
	    }elseif ($info['uid']!=$this->user['uid']) {
	        $this->error("不是你发布的,无权操作!");
	    }elseif ($info['status']!=-1) {
	        $this->error("不是回收站内容,无权操作!");
	    }
	    $status = 0;
	    if (empty($this->webdb['post_auto_pass_group']) || in_array($this->user['groupid'], $this->webdb['post_auto_pass_group'])) {
	        $status = 1;
	    }
	    ContentModel::updates($id,['status'=>$status]);
	    $this->success("成功上架!");
	}
	
	/**
	 * 可以分销的商品
	 * @param number $fid
	 * @param number $mid
	 * @return mixed|string
	 */
	public function fx($fid=0,$mid=0)
	{
	    if ($this->webdb['allow_fx_group'] && empty($this->admin) && !in_array($this->user['groupid'], $this->webdb['allow_fx_group'])) {
	        $this->showerr('你没权限!');
	    }
	    $listdb = $this->model->getListByMid(1 , ['fx1'=>['>',0],'status'=>['>',0]] , 'id desc' , 10);
	    $pages = $listdb->render();
	    $this->assign('listdb',$listdb);
	    $this->assign('pages',$pages);
	    return $this->fetch();
	}
	
	/**
	 * 发布信息
	 * {@inheritDoc}
	 * @see \app\common\controller\member\C::add()
	 */
	public function add($fid=0,$mid=0){
	    return parent::add($fid,$mid);
	}
	
	/**
	 * 修改信息
	 * {@inheritDoc}
	 * @see \app\common\controller\member\C::edit()
	 */
	public function edit($id){
	    return parent::edit($id);
	}
	
	/**
	 * 删除信息
	 * {@inheritDoc}
	 * @see \app\common\controller\member\C::delete()
	 */
	public function delete($ids)
	{
	    define('SHOW_RUBBISH',true);  //显示回收站的内容
	    define('IN_ADMIN',true);
	    return parent::delete($ids);
	}
	
}
