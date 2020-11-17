<?php
namespace app\zhidao\index;
use app\zhidao\model\Content as ContentModel;

//频道主页
class Index extends Content
{
    protected $rows = 10;   //每页显示几条
    public function index($type=''){
// 	    $list = Db::name('rmb_consume')->where([])->paginate();
// 	    print_r($list->render());exit;

// 	    $mid = $this->m_model-> getId();
// 	    $this->assign('mid',$mid);
    
        $array = getArray($this->get_list($type));
	    $this->assign('listdb',$array['data']);
	    //print_r(config('view_replace_str')) ;exit;
	    
	    

	    return $this->fetch();
	}
	
	public function test(){
	    //print_r( request()->dispatch() ) ;exit;
	    $url = urls('content/show','id=96');
	    echo "<a href='$url'>$url</a>";
	}
	
	public function ajax_more($type=''){
	    $array = $this->get_list($type);
	    return $this->ok_js($array,'调用成功',$this->rows);
	}
	
	protected function get_list($type=''){
	    $map = [];
	    $type && $map = ['fid'=>$type];
	    $map['ispic'] = 1;
	    $rows = $this->rows;
	    $order = 'id desc';
	    if($type=='star'){
	        $map = ['status'=>2];
	    }elseif($type=='hot'){
	        $map = [];
	        $order = 'view desc';
	    }elseif($type=='new'){
	        $map = [];
	        $order = 'id desc';
	    }elseif($type=='reply'){
	        $map = [];
	        $order = 'list desc';
	    }
	    $array = ContentModel::getListByMid(1,$map,$order,$rows);
	    return $array;
	}

}
