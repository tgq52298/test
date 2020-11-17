<?php
namespace app\exam\model;

use plugins\fav\model\Fav AS FavModel;

//收藏夹
class Fav extends FavModel
{	
	public function label($tag_array=[],$page=0){
	    $cfg = unserialize($tag_array['cfg']);
	    
	    $rows = $cfg['rows']>0 ? $cfg['rows'] : 5;
	    $order = $cfg['order'] ?: 'id';
	    $by = $cfg['by'] ?: 'desc';
	    $map = [
	            'sysid'=>modules_config(config('system_dirname'))['id'],
	    ];
	    
	    if($cfg['where']){  //用户自定义的查询语句
	        $_array = fun('label@where',$cfg['where'],$cfg);
	        if($_array){
	            $map = array_merge($map,$_array);
	        }
	    }
	    $data = FavModel::where($map) -> order("$order $by") -> paginate($rows,false,['page'=>$page]);

	    $data->each(function(&$rs){
	        $fav_id = $rs['id'];
	        $rs = Content::getInfoByid($rs['aid']);
	        $rs['fav_id'] = $fav_id;
	        return $rs;
	    });
	    return $data;
	}

}
