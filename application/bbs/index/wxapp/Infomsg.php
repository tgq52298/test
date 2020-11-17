<?php
namespace app\bbs\index\wxapp;

use app\common\controller\IndexBase;
use app\bbs\model\Infomsg AS InfomsgModel;

//获取辅助信息
class Infomsg extends IndexBase
{
    public function index($type=0){
        $info = getArray( InfomsgModel::get(['ext_id'=>$type]) );
        if($info){
            return $this->ok_js($info);
        }else{
            return $this->err_js('内容为空');   
        }        
    }

}













