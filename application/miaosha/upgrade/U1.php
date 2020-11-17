<?php
namespace app\miaosha\upgrade;

use think\Db;

class U1{
	public static function up(){
	    $sysid = modules_config('miaosha')['id'];
	    $type = Db::name('config_group')->where('sys_id',$sysid)->value('id');
		into_sql("

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '客户下单是否短消息通知商家', 'post_order_msg_hy', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, {$sysid});
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '客户下单是否短信通知商家', 'post_order_sms_hy', '0', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, {$sysid});
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '客户下单是否微信通知商家', 'post_order_wx_hy', '0', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, {$sysid});
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '客户付款成功是否短消息通知商家', 'pay_order_msg_hy', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, {$sysid});
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '客户付款成功是否短信通知商家', 'pay_order_sms_hy', '0', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, {$sysid});
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '客户付款成功是否微信通知商家', 'pay_order_wx_hy', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, {$sysid});

ALTER TABLE  `qb_miaosha_content` ADD  `view` MEDIUMINT( 7 ) NOT NULL COMMENT  '浏览量',ADD  `status` TINYINT( 2 ) NOT NULL COMMENT  '状态,-1回收站,0未审,1已审',ADD  `list` INT( 10 ) NOT NULL COMMENT  '排序值',ADD  `ext_id` MEDIUMINT( 7 ) NOT NULL COMMENT  '关联主题ID',ADD  `ext_sys` SMALLINT( 4 ) NOT NULL COMMENT  '关联系统ID';
update `qb_miaosha_content` set `view`=1;

ALTER TABLE  `qb_miaosha_field` ADD  `script` TEXT NOT NULL COMMENT  'JS脚本',ADD  `trigger` VARCHAR( 255 ) NOT NULL COMMENT  '选择某一项后,联动触发显示其它字段';
ALTER TABLE  `qb_miaosha_field` ADD  `range_opt` TEXT NOT NULL COMMENT  '范围选择,比如价格范围',ADD  `group_view` VARCHAR( 255 ) NOT NULL COMMENT  '允许哪些用户组查看',ADD  `index_hide` TINYINT( 1 ) NOT NULL COMMENT  '是否前台不显示并不做转义处理';
ALTER TABLE  `qb_miaosha_field` ADD  `group_post` VARCHAR( 255 ) NOT NULL COMMENT  '允许使用此字段的用户组';
ALTER TABLE  `qb_miaosha_field` CHANGE  `title`  `title` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '' COMMENT  '字段标题';


",true,0);
	}
}