<?php
namespace app\shop\upgrade;

use think\Db;

class U1{
	public static function up(){
	    $sysid = modules_config('shop')['id'];
	    $type = Db::name('config_group')->where('sys_id',$sysid)->value('id');
		  into_sql("INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '允许享受VIP价格的用户组', 'group_vip_price', '3,11', 'usergroup2', '', 0, '', '', 0, {$sysid});");
	}
}