<?php
return [
	'keywords'=>basename(dirname(__DIR__)),	//关键字,即是目录名也是数据表区分符
	'name'=>'万能通用短信接口',	//插件名称
	'author'=>'齐博',	//开发者
	'author_url'=>'http://www.php168.com',	//开发者网站或者是演示网址
	'type'=>'0',		//当前模块是否可以复制
	'about'=>'通用接口',	//介绍
	'version'=>'1.0',	//版本号
	'icon'=>'si si-envelope-letter',		//CSS图片
     'ifsys'=>'0',	//是否系统全局变量
	'ifshow'=>'1',	//在核心设置那里显示快捷菜单
	'config_group' =>['通用短信接口'],	//参数配置分组
	//涉及到的数据表,不要写前缀
	'sql_db' =>[],
];