<?php
namespace app\zhidao\admin;

use app\common\controller\admin\C;
use app\zhidao\traits\Content AS TraitsContent;

class Content extends C
{
    use TraitsContent;
    protected function deleteOne($id=0,$mid=0){
        hook_listen('zhidao_delete_begin',$id);
        $result = parent::deleteOne($id,$mid);
        if($result){
            hook_listen('zhidao_delete_end',$id);
        }
        return $result;
    }

}
