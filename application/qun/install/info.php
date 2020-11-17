<?php
return [
	'keywords'=>basename(dirname(__DIR__)),	//关键字,即是目录名也是数据表区分符
	'name'=>'商圈',	//模块名称
	'author'=>'齐博',	//开发者
	'author_url'=>'http://www.php168.com',	//开发者网站或者是演示网址
	'type'=>'1',		//当前模块是否可以复制
	'about'=>'',	//介绍
	'version'=>'1.0',	//版本号
	'icon'=>'fa fa-fw fa-group',		//CSS图片
	'ifsys'=>'0',	//是否禁止卸载	
	'config_group' =>['基础设置',],	//参数配置分组
	//涉及到的数据表,不要写前缀
	'sql_db' =>['content','content1','field','module','member','sort','groups','visit'],
        //依赖于哪个模块,多个用逗号隔开，最好是以数组的形式
	'bind_modules' => [
	        'bbs'=>'论坛',
	        //'giftshop'=>'积分商城'
	],    
	//'bind_plugins' => ['signin'=>'会员每天签到领积分'],
];