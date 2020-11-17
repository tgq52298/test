<?php
namespace plugins\alilive\upgrade;

use think\Db;

class U1{
	public function up(){
	    $id = Db::name('plugin')->where('keywords','alilive')->value('id');
	    $gid = Db::name('config_group')->where('sys_id',-$id)->value('id');
	    into_sql("INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$gid}, '阿里录制点播域名网址', 'ali_live_mvurl', '', 'text', '', 0, '', '阿里云OSS对象云存储域名网址,要加http://', 0, '-{$id}');",true,0);
		into_sql("INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$gid}, '腾迅录制点播域名网址', 'qq_live_mvurl', '', 'text', '', 0, '', '腾迅云点播域名网址,要加http://', 0, '-{$id}');",true,0);
		into_sql("INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$gid}, '录制视频回调网址通信密钥', 'live_video_key', '', 'text', '', 0, '', '任意字符串即可,这用于给阿里或腾迅视频录制回调通知使用,非正式上线可为空.<br>回调地址统一使用:“你的域名网址/index.php/p/alilive-notify-index/apikey/通信密钥.html”', 0, '-{$id}');",true,0);

		Db::name('config')->where('c_key','live_video_type')->update([
			'options'=>"ali|阿里云|ali_live_push_url,ali_live_pull_url,ali_live_push_key,ali_live_pull_key,ali_live_time,ali_live_mvurl\r\nqq|腾迅云|qq_live_push_url,qq_live_pull_url,qq_live_push_key,qq_live_pull_key,qq_live_time,qq_live_mvurl",
		]);
	}
}


