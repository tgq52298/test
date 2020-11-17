<?php
namespace app\qun\index;

//use app\common\controller\IndexBase;
//use app\qun\model\Content;

class Member extends Base
{
    public function index($id=0){
//         $info = Content::getInfoByid($id,true);
//         if(!$info){
//             $this->error('ID有误');
//         }
//         $this->assign('info',$info);
        $this->assign('id',$id);
	    return $this->fetch();
	}

}
