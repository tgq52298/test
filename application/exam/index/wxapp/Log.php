<?php
namespace app\exam\index\wxapp;

use app\common\controller\IndexBase;
use app\exam\model\Answer AS Model;

class Log extends IndexBase
{
    /**
     * 把错题移出来
     * @param number $id
     * @return void|unknown|\think\response\Json
     */
    public function remove($id=0){
        $map = [
            'uid'=>$this->user['uid'],
            'id'=>$id,
        ];
        if ( Model::where($map)->update(['is_true'=>0]) ) {
            return $this->ok_js();
        }else{
            return $this->err_js();
        }
    }
}













