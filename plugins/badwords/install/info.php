<?php
return [
	'keywords'=>basename(dirname(__DIR__)),	//关键字,即是目录名也是数据表区分符
	'name'=>'敏感词过滤',	//模块名称
	'author'=>'torylf',	//开发者
	'author_url'=>'',	//开发者网站或者是演示网址
	'type'=>'0',		//当前模块是否可以复制
	'about'=>'敏感词过滤',	//介绍
	'version'=>'1.0',	//版本号
	'icon'=>'fa fa-shower',		//CSS图片
	'ifsys'=>'0',	//是否禁止卸载
	'sql_db' =>['badwords_kw'],
	'config_group' =>['敏感词过滤'],	//参数配置分组
	 
];