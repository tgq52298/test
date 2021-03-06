<?php
namespace app\weibo\member;

use app\common\controller\member\C;
use app\weibo\traits\C AS Ctraits;
use app\cms\traits\Content AS TraitsContent;

class Content extends C
{	
    use Ctraits,TraitsContent;
    
    public function set(){
        $info = fun('sns@weibo',$this->user['uid']);
        if (empty($info)) {
            $this->success('你还没有创建微博,立即创建一个','postnew');
        }else{
            $this->redirect( urls('edit',['id'=>$info['id']]) );
        }
    }
    
    //创建成功后的操作
    protected function end_add($id=0,$data=[]){
        $this->end_inc_add($id,$data);
    }
    
	public function index($fid=0,$mid=1)
	{
	    $listdb = $this->model->getListByUid($this->user['uid']);
	    $pages = $listdb->render();
	    $this->assign('listdb',$listdb);
	    $this->assign('pages',$pages);
	    return $this->fetch();
	}
	
	/**
	 * 创建圈子前的 相关权限检查
	 * @param number $fid 分类ID
	 * @param number $mid 模型ID
	 * @return boolean
	 */
	public function add_check($mid=1,$fid=0,&$data=[]){
	    $result = $this->add_inc_check($mid,$fid,$data);
	    if ($result!==true) {
	        $this->error($result);
        }
        //这里可以做二次开发
        return parent::add_check($mid,$fid,$data);
	}
	
}
