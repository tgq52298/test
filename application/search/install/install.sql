INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, 'SEO标题', 'mseo_title', '', 'text', '', 0, '', '', 100, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, 'SEO优化关键字keywords', 'mseo_keyword', '', 'text', '', 0, '', '', 99, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, 'SEO优化描述description', 'mseo_description', '', 'text', '', 0, '', '', 98, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '是否开启当前模块', 'is_open_modlue', '1', 'radio', '1|开启\r\n0|关闭', 0, '', '', 97, 4);

INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`) VALUES
('', 'cms_add_end', '', 'app\\search\\hook\\Add', '', 1, 0, 'suifeng', 'http://www.qibo168.com');
INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`) VALUES
('', 'cms_edit_end', '', 'app\\search\\hook\\Add', '', 1, 0, 'suifeng', 'http://www.qibo168.com');
INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`) VALUES
('', 'cms_delete_end', '', 'app\\search\\hook\\Add', '', 1, 0, 'suifeng', 'http://www.qibo168.com');


DROP TABLE IF EXISTS `qb_search_content`;
CREATE TABLE IF NOT EXISTS `qb_search_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户uid',
  `aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '信息id',
  `module` varchar(30) NOT NULL COMMENT '模型',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `data` text NOT NULL COMMENT '数据',
  PRIMARY KEY (`id`),
  KEY `modelid` (`module`),
  KEY `uid` (`uid`),
  KEY `create_time` (`create_time`),
  KEY `aid` (`aid`),
  FULLTEXT KEY `data` (`data`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='全站搜索数据表' AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `qb_search_keyword`;
CREATE TABLE `qb_search_keyword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` char(30) NOT NULL COMMENT '关键字',
  `searchnums` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '搜索次数',
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyword` (`keyword`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='搜索关键字表' AUTO_INCREMENT=1 ;