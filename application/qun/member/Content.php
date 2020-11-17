<?php
namespace app\qun\member;

use app\common\controller\member\C;
use app\qun\traits\C AS Ctraits;
//use app\cms\traits\Content AS TraitsContent;

class Content extends C
{	
    //use Ctraits,TraitsContent;
    use Ctraits;
    
    //创建成功后的操作
    protected function end_add($id=0,$data=[]){
        $this->end_inc_add($id,$data);
    }
    
    
    public function edit($id=0){
        if (empty($id)) {
            $quns = fun('qun@getByuid',$this->user['uid']);
            if (count($quns)>1) {
                $url = url('choose/index').'?url='.urlencode( url('edit').'?id=' );
                $this->redirect($url);
            }else{
                $id = $quns[0]['id'];
                $this->request->get(['id'=>$id]);   //POST表单那里要用到
            }
        }
        return parent::edit($id);
    }
    
    public function add($fid=0,$mid=0)
    {
        $this->tab_ext['page_title'] = '新建'.QUN;
        if ($mid) {
            $this->tab_ext['page_title'] = '新建'.str_replace('模型', '', model_config($mid)['title']);
        }
        return parent::add($fid,$mid);
    }
    
	public function index($fid=0,$mid=1)
	{
	    $listdb = $this->model->getListByUid($this->user['uid']);
	    $pages = $listdb->render();
	    $this->assign('listdb',$listdb);
	    $this->assign('pages',$pages);
	    return $this->fetch();
	}
	
	public function myjoin(){
	    $this->assign('uid',$this->user['uid']);
	    return $this->fetch();
	}
	
	public function myvisit(){
	    $this->assign('uid',$this->user['uid']);
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
