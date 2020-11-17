<?php
namespace app\bbs\index;

//use app\bbs\model\Content as ContentModel;

use app\common\controller\index\Index AS _Index;

//频道主页
class Index extends _Index
{
//     protected $rows = 10;   //每页显示几条
    
    public function index(){
        return parent::index();
    }
	
// 	public function ajax_more($type=''){
// 	    $array = $this->get_list($type);
// 	    return $this->ok_js($array,'调用成功',$this->rows);
// 	}
	
// 	protected function get_list($type=''){
// 	    $map = [];
// 	    $type && $map = ['fid'=>$type];
// 	    $map['ispic'] = 1;
// 	    $rows = $this->rows;
// 	    $order = 'id desc';
// 	    if($type=='star'){
// 	        $map = ['status'=>2];
// 	    }elseif($type=='hot'){
// 	        $map = [];
// 	        $order = 'view desc';
// 	    }elseif($type=='new'){
// 	        $map = [];
// 	        $order = 'id desc';
// 	    }elseif($type=='reply'){
// 	        $map = [];
// 	        $order = 'list desc';
// 	    }
// 	    $array = ContentModel::getListByMid(1,$map,$order,$rows);
// 	    return $array;
// 	}

}
