<?php
namespace app\qun\index;

use app\common\controller\IndexBase;

class Api extends IndexBase
{
    /**
     * 返回到具体某个圈子页
     * @param string $type
     */
    public function gethome($type='first'){
        if ($type=='last') {
            $id = get_cookie('last_qun_id');
        }else{
            $id = get_cookie('home_qun_id');
        }
        if ($id) {
           $url = urls('content/show',['id'=>$id]);
        }else{
            $url = urls('index/index');
        }
        $this->redirect($url);
    }
}
