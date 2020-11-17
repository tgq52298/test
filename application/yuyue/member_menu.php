<?php

return array(
		'cms'=>array(
				'title'=>'cms',
				'sons'=>array(
							array(
								'title'=>'CMS功能',
								'sons'=>array(
    									array(
    										   'title'=>'预约项目管理',
    										    'link'=>'content/index',
    									        'power'=>'can_post_group',
    									),

    									array(
    									        'title'=>'新增预约项目',
    										    'link'=>'content/postnew',
    									        'power'=>'can_post_group',
    									),
								        array(
								                'title'=>'我预约的项目',
								                'link'=>'order/index',
								        ),
								        array(
								                'title'=>'客户的预约',
								                'link'=>'kehu_order/index',
								                'power'=>'can_post_group',
								        ),

								        array(
								                'title'=>'预约时间管理',
								                'link'=>'time/index',
								                'power'=>'can_post_group',
								        ),
								),
							),
				),
		),
);
 