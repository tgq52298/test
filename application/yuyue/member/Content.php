<?php
namespace app\yuyue\member;

use app\common\controller\member\C;
use app\yuyue\traits\Content AS TraitsContent;
use app\yuyue\model\Time AS TimeModel;

class Content extends C
{	
    use TraitsContent;
	public function index($fid=0,$mid=0)
	{
	    $listdb = $this->model->getListByUid($this->user['uid']);
	    $pages = $listdb->render();
	    $this->assign('listdb',$listdb);
	    $this->assign('pages',$pages);
	    return $this->fetch();
	}

	public function fx($fid=0,$mid=0)
	{
	   if ($this->webdb['allow_fx_group'] && empty($this->admin) && !in_array($this->user['groupid'], $this->webdb['allow_fx_group'])) {
	        $this->showerr('你没权限!');
	    }
	    $listdb = $this->model->getListByMid(1 , ['fx1'=>['>',0]] , 'id desc' , 10);
	    $pages = $listdb->render();
	    $this->assign('listdb',$listdb);
	    $this->assign('pages',$pages);
	    return $this->fetch();
	}
	
	public function edit($id)
	{
	    return parent::edit($id);
	}
	
	public function delete($ids)
	{
	    return parent::delete($ids);
	}
	
	protected function end_add($id=0,$data=[]){
	    if (empty(TimeModel::where('uid',$this->user['uid'])->find())) {
	        TimeModel::create([
	            'uid'=>$this->user['uid'],
	            'name'=>'上午8:00-10:00'
	        ]);
	        TimeModel::create([
	            'uid'=>$this->user['uid'],
	            'name'=>'下午3:00-5:00'
	        ]);
	    }
	    return parent::end_add($id,$data);
	}
}
