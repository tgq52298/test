<?php

namespace plugins\alilive\model;
use think\Model;

//用户流量购买订单
class Order extends Model
{
	
    // 设置当前模型对应的完整数据表名称alilive_log
    protected $table = '__ALILIVE_ORDER__';
    // 自动写入时间戳
    protected $autoWriteTimestamp = true;
	//主键不是ID,要单独指定
	protected $pk = 'id';


	
}