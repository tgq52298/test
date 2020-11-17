<?php
namespace app\hy\index;

use app\common\controller\IndexBase;
use app\hy\model\Content;

class Member extends IndexBase
{
    public function index($id=0){
        $info = Content::getInfoByid($id,true);
        if(!$info){
            $this->error('ID有误');
        }
        $this->assign('info',$info);
        $this->assign('id',$id);
	    return $this->fetch();
	}

}
