<?php

return array(
		'cms'=>array(
				'title'=>'cms',
				'sons'=>array(
							array(
								'title'=>'黄页频道',
								'sons'=>array(
									array(
										'title'=>'我创建的黄页',
										'link'=>'content/index',
									        'power'=>'can_post_group',
									),
									array(
										'title'=>'创建黄页',
										'link'=>'content/postnew',
									        'power'=>'can_post_group',
									),
								),
							),
				),
		),
);
 