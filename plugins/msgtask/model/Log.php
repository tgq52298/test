<?php
namespace plugins\msgtask\model;
use think\Model;


class Log extends Model
{
	
    // 设置当前模型对应的完整数据表名称
    protected $table = '__MSGTASK_LOG__';
    protected $autoWriteTimestamp = true;   // 自动写入时间戳
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $resultSetType = 'array';
    
    
}