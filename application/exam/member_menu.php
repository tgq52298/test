<?php
return [
        'cms' => [
                'title' => 'cms',
                'sons' => [
                        [
                                'title' => 'CMS功能',
                                'sons' => [
                                        [
                                                'title' => '我的考卷',
                                                'link' => 'putin/index'
                                        ],
                                        
                                        [
                                                'title' => '手工录入试题',
                                                'link' => 'content/postnew'
                                        ],
                                        [
                                                'title' => '批量导入试题(试卷)',
                                                'link' => 'content/batchadd'
                                        ],
                                        [
                                                'title' => '试题管理',
                                                'link' => 'content/index'
                                        ],
                                        [
                                                'title' => '手工出卷',
                                                'link' => 'paper/add'
                                        ],
                                        [
                                                'title' => '批量随机生成试卷',
                                                'link' => 'paper/batchadd'
                                        ],
                                        [
                                                'title' => '试卷管理',
                                                'link' => 'paper/index'
                                        ],
										[
								                'title'=>'我的分类管理',
								                'link'=>'mysort/index',
								        ],
                                ]
                        ]
                ]
        ]
];
 