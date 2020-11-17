<?php

return array(
		'cms'=>array(
				'title'=>'cms',
				'sons'=>array(
							array(
								'title'=>'CMS功能',
								'sons'=>array(
    									array(
    									     	'title'=>'工单模板管理',
    										    'link'=>'content/index',
    									        'power'=>'can_post_group',
    									),
    									array(
    										    'title'=>'创建工单模板',
    										    'link'=>'content/postnew',
    									        'power'=>'can_post_group',
    									),
								        array(
								                'title'=>'我提交的工单',
								                'link'=>'order/index',
								        ),
								        array(
								                'title'=>'客户的工单',
								                'link'=>'kehu_order/index',
								                'power'=>'can_post_group',
								        ),
								),
							),
				),
		),
);
 