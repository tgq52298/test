<?php
namespace app\bbs\admin;

use app\common\controller\admin\C;
use app\cms\traits\Content AS TraitsContent;

class Content extends C
{
    use TraitsContent;
    protected function deleteOne($id=0,$mid=0){
        hook_listen('bbs_delete_begin',$id);
        $result = parent::deleteOne($id,$mid);
        if($result){
            hook_listen('bbs_delete_end',$id);
        }
        return $result;
    }

}
