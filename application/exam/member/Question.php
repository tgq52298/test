<?php
namespace app\exam\member;

use app\common\controller\member\C;
use app\exam\traits\Content AS TraitsContent;
use think\Db;

class Question extends C
{
    use TraitsContent;
    
    public function index($id=0,$fid=0,$mid=0,$type=0){

    	if(!$id){
    		$this->error('试卷ID参数有误！');
    	}
    	
    	$infodb = $this->categorys($id);

		if(!$infodb){
			$this->error('查询不到该试卷资料，可尝试刷新页面后再进行操作！');
		}
    	$map['uid'] = $this->user['uid'];
    	if(!$mid && !$fid){
    		//没有指定栏目或模型的话， 就显示默认模型的内容
    		$mid = $this->m_model->getId();
//     		$data_list = $this->model->getAll($map); //没选模型即查询所有
    	}elseif($fid){
    		$mid = $this->model->getMidByFid($fid);
    	}
	    $this->mid = $mid;
	    $map = $fid ? ['fid'=>$fid] : ['mid'=>$mid]; 
	    
	    $info_table = config('system_dirname').'_info';//试题表
	    $data_list = Db::name($info_table)->where('cid',$id)->select(); //查询试卷的试题

	    if($data_list){
	    	$already_insertid = [];//试卷里所有试题ID
	    	foreach($data_list AS $v){
	    		$already_insertid[] = $v['aid'];
	    	}
	    }

	    if($type==1){

	    		$template = 'manage';
	    		$vars = [
	    				'categorys'=>$infodb,
	    				'listdb'=>$data_list,
	    				'field_db'=> $this->getEasyIndexItems(),   //列表显示哪些自定义字段
	    				'mid'=>$mid,
	    				'fid'=>$fid,
	    				'id'=>$id,
	    				'model_list' => $this->m_model->getTitleList(),
	    		];	
	    }else{
	    		//获取列表数据
	    		$data_list = $this->getListData($map,'',0,[],true);
		    	$pages = $data_list->render();
		    	
		    	$vars = [
		    			'already_insertid'=>$already_insertid,
		    			'categorys'=>$infodb,
		    			'listdb'=>$data_list,
		    			'field_db'=> $this->getEasyIndexItems(),   //列表显示哪些自定义字段
		    			'pages'=> $data_list->render(),    //分页
		    			'mid'=>$mid,
		    			'fid'=>$fid,
		    			'id'=>$id,
		    			'model_list' => $this->m_model->getTitleList(),
		    	];				
	    }

	    //$data_list = getArray($data_list)['data'];

	    	
    	$this->assign($vars);
  		return $this->fetch($template);

    }

    /**
     * 手工出试卷
     * @return mixed|string
     */
    public function add($aid=0,$cid=0){
    	if(!$aid || !$cid){
    		return false;
    	}
    	$infodb = $this->categorys($cid);
    	if(!$infodb){
    		return false;
    	}
    	$info_table = config('system_dirname').'_info';
    	
    	$map = $data = ['aid'=>$aid,'cid'=>$cid];
    	
    	$check = Db::name($info_table)->where($map)->find();//试卷如有同样的题目则不再增加
//     	print_r($check);
    	if($check){
    		return -1;
    	}
    	
    	$result = Db::name($info_table)->insert($data);
    	
    	return $result;

    }
    
    //获取试卷内容
    protected function categorys($id=0){
    	if(!$id){
    		return false;
    	}
    	$category_table = config('system_dirname').'_category';
    	$infodb=Db::name($category_table)->where(['id'=>$id,'uid'=>$this->user['uid']])->find();
    	return $infodb;
    }
    


   
}
