<?php
namespace plugins\form\upgrade;

use think\Db;

class U1{
	public static function up(){
	    
	    if (!table_field('form_field','input_width')) {
	        query("ALTER TABLE  `qb_form_field` ADD  `input_width` VARCHAR( 7 ) NOT NULL COMMENT  '输入表单宽度',ADD  `input_height` VARCHAR( 7 ) NOT NULL COMMENT  '输入表单高度',ADD  `unit` VARCHAR( 20 ) NOT NULL COMMENT  '单位名称',ADD  `match` VARCHAR( 150 ) NOT NULL COMMENT  '表单正则匹配',ADD  `css` VARCHAR( 20 ) NOT NULL COMMENT  '表单CSS类名';");
	    }
	    if (!table_field('form_field','script')) {
	        query("ALTER TABLE  `qb_form_field` ADD  `script` TEXT NOT NULL COMMENT  'JS脚本',ADD  `trigger` VARCHAR( 255 ) NOT NULL COMMENT  '选择某一项后,联动触发显示其它字段';");
	    }
	    if ( !table_field('form_field','range_opt') ) {
	        query("ALTER TABLE  `qb_form_field` ADD  `range_opt` TEXT NOT NULL COMMENT  '范围选择,比如价格范围',ADD  `group_view` VARCHAR( 255 ) NOT NULL COMMENT  '允许哪些用户组查看',ADD  `index_hide` TINYINT( 1 ) NOT NULL COMMENT  '是否前台不显示并不做转义处理';");
	    }
	    
	    $sysid = plugins_config('form')['id'];
	    $type = Db::name('config_group')->where('sys_id',-$sysid)->value('id');
	    
	    into_sql("
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '接收消息的客服UID', 'post_form_kefu_uid', '1,2', 'text', '', 0, '', '若有多个UID用半角英文逗号隔开', 0, '-{$sysid}');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '用户提交表单是否短消息通知管理员', 'post_form_msg_send', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, '-{$sysid}');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '用户提交表单是否手机短信通知管理员', 'post_form_sms_send', '0', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, '-{$sysid}');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '用户提交表单是否微信通知管理员', 'post_form_wx_send', '0', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, '-{$sysid}');        


        ");
		  
	}
}


