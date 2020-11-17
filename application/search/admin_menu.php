<?php
return [
	'search' => [
		'title' => 'search',
		'sons'  => [
			[
				'title' => '功能设置',
				'sons'  => [
					[
						'title' => '参数设置',
						'link'  => 'setting/index',
					],
					[
						'title' => '热搜词管理',
						'link'  => 'content/index',
					],
					[
						'title' => '原数据导入',
						'link'  => 'gongju/index',
						'power' => [ 'index' => '选择模块','moxing' => '选择模型','neirong' => '转换内容' ],
					],
				],
			],
		],
	],
];
