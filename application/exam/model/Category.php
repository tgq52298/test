<?php

namespace app\exam\model;

use app\common\model\Category AS _Category;


//试卷
class Category extends _Category
{
    public function Label($tag_array=[] , $page=0){
        empty(self::$model_key) && self::InitKey();
        $cfg = unserialize($tag_array['cfg']);        
        $rows = $cfg['rows']>0 ? $cfg['rows'] : 5;
        $order = $cfg['order'] ?: 'id';
        $by = $cfg['by'] ?: 'desc';
        $map = [];
        
        if($cfg['where']){  //用户自定义的查询语句
            $_array = fun('label@where',$cfg['where'],$cfg);
            if($_array){
                $map = array_merge($map,$_array);
            }
        }
        if(strstr($order,'rand()')){
            $data = self::where($map) -> orderRaw('rand()') -> paginate($rows,false,['page'=>$page]);
        }else{
            $data = self::where($map) -> order("$order $by") -> paginate($rows,false,['page'=>$page]);
        }
        $dirname = self::$model_key;
        $array = getArray($data);
        foreach($array['data'] AS $key=>$rs){
            $rs['title'] = $rs['name'];
            $rs['url'] = iurl($dirname.'/category/index',['fid'=>$rs['id']],true,false,'module');
            $array['data'][$key] = $rs;
        }
        return $array;
    }
}
