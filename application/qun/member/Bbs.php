<?php
namespace app\qun\member;

use app\common\controller\MemberBase;
use app\qun\model\Content;

class Bbs extends MemberBase
{
    public function index($id=0,$mid=1){
        
        if (empty($id)) {
            $quns = fun('qun@getByuid',$this->user['uid']);
            if (count($quns)>1) {
                $url = url('choose/index').'?url='.urlencode( url('index').'?id=' );
                $this->redirect($url);
            }else{
                $id = $quns[0]['id'];
            }
        }
        
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
