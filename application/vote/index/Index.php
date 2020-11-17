<?php
namespace app\vote\index;

//频道主页
class Index extends Content
{
	public function index(){

	    $mid = $this->m_model-> getId();
	    $this_sortdb = $this->model->getInfoBymid($mid);
	    $fid = $this_sortdb ? $this_sortdb['id'] : 1;
	    $this->redirect('Content/index', ['fid' => $fid]); //重定向到投票项目
	
	    $this->assign('mid',$mid);
	    return $this->fetch();
	}

}
