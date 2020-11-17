<?php

return array(
		'plugin'=>array(
				'title'=>'插件',
				'sons'=>array(
							array(
								'title'=>'收藏夹管理',
								'sons'=>array(
								        array(
								                'title'=>'收藏夹列表',
								                'link'=>'fav/index',
								                'power'=>['delete'],
								        ),
								),
							),
				),
		),
);
