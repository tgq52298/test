<?php

return array(
		'cms'=>array(
				'title'=>'cms',
				'sons'=>array(
							array(
								'title'=>'CMS功能',
								'sons'=>array(
    									array(
    									     	'title'=>'活动管理',
    										    'link'=>'content/index',
    									        'power'=>'can_post_group',
    									),
    									array(
    										    'title'=>'发布活动',
    										    'link'=>'content/postnew',
    									        'power'=>'can_post_group',
    									),
								        array(
								                'title'=>'我报名的活动',
								                'link'=>'order/index',
								        ),
								        array(
								                'title'=>'客户报名的订单',
								                'link'=>'kehu_order/index',
								                'power'=>'can_post_group',
								        ),
								),
							),
				),
		),
);
 