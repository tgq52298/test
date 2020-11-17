<?php
namespace plugins\myad\model;
use think\Model;


class Info extends Model
{
	
    // 设置当前模型对应的完整数据表名称
    protected $table = '__MYAD_INFO__';
    protected $autoWriteTimestamp = true;   // 自动写入时间戳
    protected $dateFormat = false;
    

    
}