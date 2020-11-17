<?php
namespace app\hy\index\wxapp;

use app\common\controller\index\wxapp\Index AS _Index; 

//附近的
class Near extends _Index
{

    public function index($point='100,20',$rows=10){
        $map = [];
        $array = getArray( $this->model->getListByMap($this->mid,$map,$point,$rows) );
        foreach($array['data'] AS $key => $rs){
            $rs['create_time'] = date('Y-m-d H:i',$rs['create_time']);
            $array['data'][$key] = $rs;
        }
        
        return $this->ok_js($array); 
    }

}













