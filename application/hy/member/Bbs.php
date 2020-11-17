<?php
namespace app\hy\member;

use app\common\controller\IndexBase;
use app\hy\model\Content;

class Bbs extends IndexBase
{
    public function index($id=0,$mid=1){
        $info = Content::getInfoByid($id,true);
        if(!$info){
            $this->error('ID有误');
        }
        $this->assign('info',$info);
        $this->assign('id',$id);
        $this->assign('mid',$mid);
	    return $this->fetch();
	}

}
