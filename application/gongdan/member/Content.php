<?php
namespace app\gongdan\member;

use app\common\controller\member\C;
use app\gongdan\traits\Content AS TraitsContent;
use app\gongdan\model\Content AS ContentModel;

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
	
	public function add($fid=0,$mid=0,$aid=0){
	    if (!$this->request->isPost()) {
	        $order_filed = '';
	        if ($aid) {
	            $info = ContentModel::getInfoByid($aid);
	            $order_filed = $info['order_filed'];
	            $status_type = $info['status_type'];
	        }
	        if (!$order_filed && $fid) {
	            $order_filed = get_sort($fid,'order_filed');
	            $status_type = get_sort($fid,'status_type');
	        }
	        
	        if ($order_filed) {
	            $this->request->post([
	                'order_filed'=>$order_filed,
	                'status_type'=>$status_type,
	            ]);
	        }
	    }	    
	    return parent::add($fid,$mid);
	}
	
	public function edit($id)
	{
	    return parent::edit($id);
	}
	
	public function delete($ids)
	{
	    return parent::delete($ids);
	}
}
