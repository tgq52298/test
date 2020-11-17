<?php
namespace app\zhidao\member;

use app\common\controller\member\C;
use app\zhidao\traits\Content AS TraitsContent;

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
     * 修改主题
     * @param number $id
     * @return \think\response\Json
     */
    public function edit($id=0){
        //修改数据检测
        $check_edit = $this->check_edit($id,input());
        if($check_edit){
            $this->error($check_edit);
        }
        return parent::edit($id);
    }
}


