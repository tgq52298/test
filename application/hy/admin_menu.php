<?php

return array(
		'qun'=>array(
				'title'=>'qun',
				'sons'=>array(
							array(
								'title'=>'黄页频道',
								'sons'=>array(
										array(
								                'title'=>'参数设置',
								                'link'=>'setting/index',
										        'power'=>[],
								            ),
								        array(
								                'title'=>'创建黄页',
								                'link'=>'content/postnew',
								            ),
								        array(
								                'title'=>'黄页管理',
								                'link'=>'content/index',
								              ),
    									array(
    										'title'=>'分类管理',
    										'link'=>'sort/index',
    									 ),
    								    array(
    								            'title'=>'模型管理',
    								            'link'=>'module/index',
    								            'power'=>[
    								                    'add'=>'创建模型',
    								                    'edit'=>'修改模型',
    								                    'delete'=>'删除模型',
    								                    'field/index'=>'字段管理',
    								                    'field/add'=>'添加字段',
    								                    'field/edit'=>'修改字段',
    								                    'field/delete'=>'删除字段',
    								            ],
    								        ),
// 										array(
//     										'title'=>'辅栏目管理',
//     										'link'=>'category/index',
//     									 ),
// 								        array(
// 								                'title'=>'辅栏目内容管理',
// 								                'link'=>'info/index',
// 								        ),
								),
							),
				),
		),
);
