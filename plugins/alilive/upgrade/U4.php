<?php
namespace plugins\alilive\upgrade;

use think\Db;

class U4{
	public function up(){
	    $id = Db::name('plugin')->where('keywords','alilive')->value('id');
	    $gid = Db::name('config_group')->where('sys_id',-$id)->value('id');
	    into_sql("

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, $gid, '直播录制视频推送到哪个CMS栏目', 'cms_sortid', '', 'select', 'cms_sort@id,name@mid=3', 0, '', '针对没有进会员中心发布预告的情况', -1, '-{$id}');

",true,0);

	}
}


