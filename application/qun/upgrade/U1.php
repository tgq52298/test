<?php
namespace app\qun\upgrade;
use think\Db;

class U1{
	public function up(){
	    $id = Db::name('module')->where('keywords','qun')->value('id');
	    $gid = Db::name('config_group')->where('sys_id',$id)->value('id');
	    into_sql("INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$gid}, '默认城市ID', 'city_id', '0', 'select', 'plugins\\area\\model\\Area@getTitleList@{\"level\":2}', 0, '', '列表页会默认显示这个城市下面的区域,不设置将无法显示区域筛选', 0, {$id});",true,0);
	}
}