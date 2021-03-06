<?php

return array(
		'exam'=>array(
				'title'=>'exam',
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
								                'title'=>'添加新的试题',
								                'link'=>'content/postnew',
								            ),
								        array(
								                'title'=>'批量导入试题(试卷)',
								                'link'=>'content/batchadd',
								            ),
								        array(
								                'title'=>'添加新的试卷',
								                'link'=>'category/add',
								        ),
										array(
												'title'=>'快速随机出卷',
												'link'=>'category/randomadd',
										),
								        array(
								                'title'=>'试题库管理',
								                'link'=>'content/index',
								              ),
//     									array(
//     										'title'=>'试题分类',
//     										'link'=>'sort/index',
//     									),
								        array(
								                'title'=>'年级分类',
								                'link'=>'grade/index',
								        ),								        
								        array(
								                'title'=>'科目分类',
								                'link'=>'kemu/index',
								        ),
								        array(
								                'title'=>'章节分类',
								                'link'=>'step/index',
								        ),    								    
										array(
                                                'title'=>'试卷管理',
                                                'link'=>'category/index',
										        'power'=>[
										                'add'=>'创建试卷',
										                'edit'=>'修改试卷',
										                'delete'=>'删除试卷',
										                'info/index'=>'试题管理',
										                'info/add'=>'添加试题',
										                'info/edit'=>'修改试题',
										                'info/delete'=>'删除试题',
										        ],
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
								                'title'=>'试卷字段管理',
								                'link'=>['sort_field/index',['mid'=>-3]],
								                //'power'=>['edit','delete'],
								        ),
								        //array(
								        //        'title'=>'辅栏目内容管理',
								        //        'link'=>'info/index',
								        //),
								),
							),
				),
		),
);
