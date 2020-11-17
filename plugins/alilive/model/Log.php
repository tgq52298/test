<?php

namespace plugins\alilive\model;
use think\Model;

//日志
class Log extends Model
{
	
    // 设置当前模型对应的完整数据表名称alilive_log
    protected $table = '__ALILIVE_LOG__';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
	//主键不是ID,要单独指定
	protected $pk = 'id';

	public static function add($uid=0,$ext_id=0,$ext_sys='',$data=[]){
	    $array = [
	        'uid'=>$uid,
	        'ext_id'=>abs($ext_id),
	        'ext_sys'=>empty($ext_sys)?'':modules_config($ext_sys)['id'],
	        'push_url'=>$data['push_url'],
	        'flv_url'=>$data['flv_url'],
	        'm3u8_url'=>$data['m3u8_url'],
	        'rtmp_url'=>$data['rtmp_url'],
	        //'create_time'=>time(),
	    ];
	    
	    $result = self::create($array);
	    return $result;
	}
	
}