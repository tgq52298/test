<?php

return array(
		'bbs'=>array(
				'title'=>'cms',
				'sons'=>array(
							array(
								'title'=>'CMS功能',
								'sons'=>array(
									array(
										    'title'=>'我发布的内容',
										    'link'=>'content/index',
									        'power'=>'can_post_group',
									),
									array(
										    'title'=>'发布内容',
										    'link'=>'content/postnew',
									        'power'=>'can_post_group',
									),
								),
							),
				),
		),
);
 