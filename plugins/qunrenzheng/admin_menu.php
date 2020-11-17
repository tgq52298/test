<?php

return array(
		'plugin'=>array(
				'title'=>'插件',
				'sons'=>array(
							array(
								'title'=>QUN.'认证',
								'sons'=>array(
								        array(
								                'title'=>'参数设置',
								                'link'=>'setting/index',
								                'power'=>[],
								        ),
// 								        array(
// 								                'title'=>'发布信息',
// 								                'link'=>'content/postnew',
// 								            ),
								        array(
								                'title'=>'认证信息管理',
								                'link'=>'content/index',
								        		'power'=>['rzact'=>'认证及取消认证操作'],
								              ),
    									//array(
    									//	'title'=>'栏目管理',
    									//	'link'=>'sort/index',
    									 //),
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
								),
							),
				),
		),
);
