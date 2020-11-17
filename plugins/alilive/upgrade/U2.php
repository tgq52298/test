<?php
namespace plugins\alilive\upgrade;

use think\Db;

class U2{
	public function up(){
	    $id = Db::name('plugin')->where('keywords','alilive')->value('id');
	    $gid = Db::name('config_group')->where('sys_id',-$id)->value('id');
	    into_sql("
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, $gid, '直播流量每元多少分钟', 'live_time_money', '100', 'number', '', 0, '', '消费按每个观看窗口统计', -2, -{$id});
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, $gid, '免费直播的用户组', 'live_free_group', '', 'usergroup2', '', 0, '', '不设置都要收费', -2, -{$id});
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, $gid, '免费体验直播时长(分钟)', 'live_test_time', '', 'number', '', 0, '', '设置为0或留空,则不允许免费体验', -3, -{$id});

",true,0);

	}
}


