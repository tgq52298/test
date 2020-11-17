<?php
namespace app\house\member;

use app\common\controller\member\C;
use app\house\traits\Content AS TraitsContent;

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
	
	/**
	 * 采集公众号的文章
	 * @param number $fid
	 * @return mixed|string
	 */
	public function copynews($fid=0){
	    $this->assign('fid',$fid);
	    return $this->fetch();
	}
	
}
