<?php

return array(
		'cms'=>array(
				'title'=>'cms',
				'sons'=>array(
							array(
								'title'=>'功能设置',
								'sons'=>array(
										array(
								                'title'=>'参数设置',
								                'link'=>'setting/index',
										        'power'=>[],
								            ),
								        array(
								                'title'=>'创建工单模板',
								                'link'=>'content/postnew',
								            ),
								        array(
								                'title'=>'工单模板管理',
								                'link'=>'content/index',
    								            'power'=>[
    								                'add'=>'发布内容',
    								                'edit'=>'修改内容',
    								                'delete'=>'删除内容',
    								                'index_fid'=>'更改栏目',
    								                'index_view'=>'更改浏览量',
    								                'index_list'=>'更改排序值',
    								                'index_status'=>'更改状态',
    								            ],
								              ),
    									array(
    										'title'=>'栏目管理',
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
								        array(
								                'title'=>'管理用户的工单',
								                'link'=>'order/index',
								                'power'=>['edit','delete'],
								        ),
// 								        array(
// 								                'title'=>'用户订单字段管理',
// 								                'link'=>['order_field/index',['mid'=>-1]],
// 								                //'power'=>['edit','delete'],
// 								        ),
										//array(
    									//	'title'=>'辅栏目管理',
    									//	'link'=>'category/index',
    									// ),
								        //array(
								        //        'title'=>'辅栏目内容管理',
								        //        'link'=>'info/index',
								        //),
								),
							),
				),
		),
);
