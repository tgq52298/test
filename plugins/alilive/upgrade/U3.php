<?php
namespace plugins\alilive\upgrade;

use think\Db;

class U3{
	public function up(){
	    $id = Db::name('plugin')->where('keywords','alilive')->value('id');
	    $gid = Db::name('config_group')->where('sys_id',-$id)->value('id');
	    into_sql("

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, $gid, '自建直播服务器', 'self_zhibo_server', '1', 'radio', '0|关闭\r\n1|启用|self_zhibo_server_url,self_zhibo_server_group', 0, '', '没有自建直播服务器,就不要选择启用。自建服务器的目的是测试体验使用', -5, '-{$id}');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, $gid, '域名网址', 'self_zhibo_server_url', 'https://testrtmp.qibosoft.net:8082', 'text', '', 0, '', 'http或https开头,比如“https://xxx.com:8082”结尾不要加斜杠', -5, '-{$id}');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, $gid, '哪些用户组使用自建直播服务器', 'self_zhibo_server_group', '3', 'usergroup2', '', 0, '', '', -5, '-{$id}');

",true,0);

	}
}


