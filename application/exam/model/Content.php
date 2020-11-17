<?php
namespace app\exam\model;

use app\common\model\C;

//模型内容处理
class Content extends C
{
    public static function getInfoByid($id=0,$format=FALSE){
        $info = parent::getInfoByid($id,$format);

        if(ENTRANCE==='index'&&request()->dispatch()['module'][0]!='search'){
            $info['title'] = format_math($info['title']);
            $info['answer_a'] = format_math($info['answer_a']);
            $info['answer_b'] = format_math($info['answer_b']);
            $info['answer_c'] = format_math($info['answer_c']);
            $info['answer_d'] = format_math($info['answer_d']);
        }        
        return $info;
    }
}
