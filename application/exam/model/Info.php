<?php

namespace app\exam\model;

use app\common\model\Info AS _Info;


//试卷里的试题
class Info extends _Info
{
    public static function getPravAidByAid($aid=0,$fid=0){
        $map = [
            'cid'=>$fid,
            'aid'=>['<',$aid],
        ];
        $id = self::where($map)->order('id asc')->limit(1)->value('aid');
        return $id;
    }
    
    public static function getAllIdByFid($fid=0){
        $map = [
            'cid'=>$fid,
        ];
        $listdb = self::where($map)->column('id,aid');
        return $listdb;
    }



    public static function create_info($data=[]){
        if ($data) {
            $create_num = self::insertAll($data);
            return $create_num;
        }else{
            return false;
        }
        
    }







}
