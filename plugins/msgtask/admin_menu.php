<?php

return array(
		'plugin'=>array(
				'title'=>'插件',
				'sons'=>array(
							array(
								'title'=>'定时群发消息',
								'sons'=>array(
								        array(
								                'title'=>'群发消息',
								                'link'=>'info/add',
								                'power'=>['add'=>'发送消息'],
								        ),
    								    array(
    								        'title'=>'消息任务列表',
    								        'link'=>'task/index',
    								    ),
    								    array(
    								        'title'=>'消息用户列表',
    								        'link'=>'log/index',
    								    ),
								),
							),
				),
		),
);
