<?php
namespace app\weibo\member;

use app\common\controller\IndexBase;
use app\weibo\model\Content;

class Cms extends IndexBase
{
    public function index($id=0,$mid=2){
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
