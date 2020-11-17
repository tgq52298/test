<?php
namespace app\miaosha\index;

//频道主页
class Index extends Content
{
	public function index(){
	    $mid = $this->m_model-> getId();
	    $this->assign('mid',$mid);
	    return $this->fetch();
	}
	
}
