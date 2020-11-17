<?php
namespace app\bbs\upgrade;
use think\Db;

class U2{
	public function up(){
	    $id = Db::name('module')->where('keywords','bbs')->value('id');
	    $gid = Db::name('config_group')->where('sys_id',$id)->value('id');
	    into_sql("INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$gid}, '发布附近动态归类哪个栏目', 'near_fid', '18', 'select', 'bbs_sort@id,name', 0, '', '', 0, {$id});",true,0);
	}
}

