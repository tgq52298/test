<?php

return array(
		'cms'=>array(
				'title'=>'cms',
				'sons'=>array(
							array(
								'title'=>'CMS功能',
								'sons'=>array(
									array(
										    'title'=>'我发布的信息',
										    'link'=>'content/index',
									        'power'=>'can_post_group',
									),
									array(
										    'title'=>'发布信息',
										    'link'=>'content/postnew',
									        'power'=>'can_post_group',
									),
								),
							),
				),
		),
);
 