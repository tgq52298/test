<?php
namespace app\qun;

class Info{
	public static $keyword;    //关键字，也是目录名
	
	/**
	 * 有哪些可用的模块,供接口使用
	 * @param string $filtrate 过滤的 比如 qun,tongji
	 */
	public static function modules($filtrate=''){
	    $array = [];
	    $detail = explode(',',$filtrate);
	    foreach(modules_config() AS $rs){
	        if(!in_array($rs['keywords'], $detail)){
	            $array[$rs['keywords']] = $rs['name'];
	        }
	    }
	    return $array;
	}
	
}