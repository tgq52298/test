<?php
namespace app\qun\upgrade;

use think\Db;

class U5{
	public static function up(){
	    $sysid = modules_config('qun')['id'];
	    $type = Db::name('config_group')->where('sys_id',$sysid)->value('id');
	    Db::name('config')->where('options','appqunInfo@modules@["qun,tongji"]')->delete();
	    
	    Db::name('config')->where('c_key','post_auto_up_group')->delete();
	    
	    $num = Db::name('config')->where('c_key','modules_show_select_qun')->count('id');
	    if($num<1){
	        into_sql("
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '发布内容显示选择圈子的频道', 'modules_show_select_qun', 'shop,bbs,cms', 'checkbox', 'app\\\qun\\\Info@modules@[\"qun,tongji,search\"]', 0, '', '', 0, {$sysid});
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, {$type}, '发布内容显示选择专题的频道', 'modules_show_select_topic', 'shop,bbs,cms', 'checkbox', 'app\\\qun\\\Info@modules@[\"qun,tongji,search\"]', 0, '', '', 0, {$sysid});
	            ");
	    }
		  
		  @rename(APP_PATH.'qun/index/Voicehb.php',APP_PATH.'qun/index/bak---Voicehb.php');
		  @rename(APP_PATH.'qun/index/Cms.php',APP_PATH.'qun/index/bak---Cms.php');
		  @rename(APP_PATH.'qun/index/Shop.php',APP_PATH.'qun/index/bak---Shop.php');
		  @rename(APP_PATH.'qun/index/Bbs.php',APP_PATH.'qun/index/bak---Bbs.php');
		  @rename(APP_PATH.'qun/index/Hongbao.php',APP_PATH.'qun/index/bak---Hongbao.php');
		  
		  //避免上面改名备份不成功
		  @unlink(APP_PATH.'qun/index/Voicehb.php');
		  @unlink(APP_PATH.'qun/index/Cms.php');
		  @unlink(APP_PATH.'qun/index/Shop.php');
		  @unlink(APP_PATH.'qun/index/Bbs.php');
		  @unlink(APP_PATH.'qun/index/Hongbao.php');
		  
		  @rename(TEMPLATE_PATH.'index_style/default/qun/cms',TEMPLATE_PATH.'index_style/default/qun/cms___bak');
		  @rename(TEMPLATE_PATH.'index_style/default/qun/bbs',TEMPLATE_PATH.'index_style/default/qun/bbs___bak');
		  @rename(TEMPLATE_PATH.'index_style/default/qun/shop',TEMPLATE_PATH.'index_style/default/qun/shop___bak');
		  @rename(TEMPLATE_PATH.'index_style/default/qun/hongbao',TEMPLATE_PATH.'index_style/default/qun/hongbao___bak');
		  @rename(TEMPLATE_PATH.'index_style/default/qun/voicehb',TEMPLATE_PATH.'index_style/default/qun/voicehb___bak');
		  
		  if (!table_field('qun_field','input_width')) {
		      query("ALTER TABLE  `qb_qun_field` ADD  `input_width` VARCHAR( 7 ) NOT NULL COMMENT  '输入表单宽度',ADD  `input_height` VARCHAR( 7 ) NOT NULL COMMENT  '输入表单高度',ADD  `unit` VARCHAR( 20 ) NOT NULL COMMENT  '单位名称',ADD  `match` VARCHAR( 150 ) NOT NULL COMMENT  '表单正则匹配',ADD  `css` VARCHAR( 20 ) NOT NULL COMMENT  '表单CSS类名';");
		  }
		  if (!table_field('qun_field','script')) {
		      query("ALTER TABLE  `qb_qun_field` ADD  `script` TEXT NOT NULL COMMENT  'JS脚本',ADD  `trigger` VARCHAR( 255 ) NOT NULL COMMENT  '选择某一项后,联动触发显示其它字段';");
		  }
		  if ( !table_field('qun_field','range_opt') ) {
		      query("ALTER TABLE  `qb_qun_field` ADD  `range_opt` TEXT NOT NULL COMMENT  '范围选择,比如价格范围',ADD  `group_view` VARCHAR( 255 ) NOT NULL COMMENT  '允许哪些用户组查看',ADD  `index_hide` TINYINT( 1 ) NOT NULL COMMENT  '是否前台不显示并不做转义处理';");
		  }
		  
		  Db::name('qun_field')->where('name','viewlimit')->update(['index_hide'=>1]);
		  Db::name('qun_field')->where('name','autoyz')->update(['index_hide'=>1]);
		  Db::name('qun_field')->where('name','hidetitle')->update(['index_hide'=>1]);
		  
		  if (table_field('qun_module','upgroup_id')) {
		      query("ALTER TABLE `qb_qun_module` DROP `upgroup_id`;");
		  }
		  
		  Db::name('config')->where('c_key','can_post_group')->where('sys_id',$sysid)->update(['c_descrip'=>'这里是总开关,全留空,则都有权限,如果这里某个用户组没权限,那么下面的相应用户组创建个数设置会无效']);
		  Db::name('config')->where('c_key','group_create_num')->where('sys_id',$sysid)->update(['c_descrip'=>'模型中设置的话,就以模型中设置的为准']);
		  
		  query("ALTER TABLE  `qb_qun_topic` CHANGE  `status`  `status` SMALLINT( 4 ) NOT NULL DEFAULT  '1' COMMENT  '状态'");
	
	}
}


