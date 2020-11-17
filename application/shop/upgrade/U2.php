<?php
namespace app\shop\upgrade;

use think\Db;

class U2{
	public static function up(){
	    $sysid = modules_config('shop')['id'];
	    $type = Db::name('config_group')->where('sys_id',$sysid)->value('id');
		  into_sql("
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '客户下单是否短消息通知商家', 'post_order_msg_hy', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, {$sysid});
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '客户下单是否短信通知商家', 'post_order_sms_hy', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, {$sysid});
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '客户下单是否微信通知商家', 'post_order_wx_hy', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, {$sysid});
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '客户付款成功是否短消息通知商家', 'pay_order_msg_hy', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, {$sysid});
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '客户付款成功是否短信通知商家', 'pay_order_sms_hy', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, {$sysid});
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '客户付款成功是否微信通知商家', 'pay_order_wx_hy', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, {$sysid});
		  ");
	}
}