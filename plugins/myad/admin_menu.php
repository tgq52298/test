<?php

return array(
		'plugin'=>array(
				'title'=>'插件',
				'sons'=>array(
							array(
								'title'=>'广告管理',
								'sons'=>array(
								    array(
								        'title'=>'参数设置',
								        'link'=>'setting/index',
								        'power'=>[],
								    ),
								    array(
								        'title'=>'广告申请表管理',
								        'link'=>'info/index',
								        'power'=>['add','edit','delete'],
								    ),
								        
								),
							),
				),
		),
);
