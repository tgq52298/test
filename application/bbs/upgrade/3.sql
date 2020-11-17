INSERT INTO `qb_bbs_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`) VALUES(2, '', '评论模型', '', '', 100, 1552526770);
INSERT INTO `qb_bbs_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`) VALUES(3, '', '咨询模型', '', '', 100, 1552620271);



INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('title', '评论内容', 'ueditor', 'text NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('picurl', '组图', 'images', 'text NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', 100, 0, 0, 0);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('content', '附注', 'hidden', 'text NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('star', '点评', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '1', '-1|差评\r\n0|中评\r\n1|好评', '', 1, 2, '', '', '', '', '', 2, '', '', '', 101, 0, 0, 0);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('title', '咨询内容', 'textarea', 'text NOT NULL', '', '', '', 0, 3, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('picurl', '组图', 'hidden', 'text NOT NULL', '', '', '', 0, 3, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('content', '附注', 'hidden', 'text NOT NULL', '', '', '', 0, 3, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('telphone', '联系电话', 'text', 'varchar(25) NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('wxid', '联系微信号', 'text', 'varchar(25) NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0);


CREATE TABLE IF NOT EXISTS `qb_bbs_content2` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` text NOT NULL COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(5) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：比如审核与否',
  `lock` tinyint(1) NOT NULL COMMENT '是否锁定不给修改,删除,回复',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '封面图',
  `mvurl` varchar(255) NOT NULL,
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `agree` mediumint(5) NOT NULL COMMENT '点赞',
  `replynum` mediumint(5) NOT NULL COMMENT '评论数',
  `reward` smallint(5) NOT NULL COMMENT '打赏用户数',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段,关联的系统',
  `ext_id` int(8) NOT NULL COMMENT '扩展字段,供其它调用',
  `replyuser` varchar(50) NOT NULL COMMENT '最后评论者',
  `phone_type` varchar(50) NOT NULL COMMENT '发表来自什么手机',
  `qun_status` tinyint(1) NOT NULL COMMENT '圈子扩展状态,比如置顶',
  `font_type` tinyint(1) NOT NULL COMMENT '标题字体加粗或其它',
  `font_color` varchar(7) NOT NULL COMMENT '标题字体颜色',
  `star` tinyint(1) NOT NULL DEFAULT '0' COMMENT '打分',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `ext_id` (`ext_id`,`ext_sys`),
  KEY `replynum` (`replynum`),
  KEY `agree` (`agree`),
  KEY `uid` (`uid`),
  KEY `qun_status` (`qun_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='评论模型内容主表' AUTO_INCREMENT=1 ;




CREATE TABLE IF NOT EXISTS `qb_bbs_content3` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` text NOT NULL COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(5) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：比如审核与否',
  `lock` tinyint(1) NOT NULL COMMENT '是否锁定不给修改,删除,回复',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '封面图',
  `mvurl` varchar(255) NOT NULL,
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `agree` mediumint(5) NOT NULL COMMENT '点赞',
  `replynum` mediumint(5) NOT NULL COMMENT '评论数',
  `reward` smallint(5) NOT NULL COMMENT '打赏用户数',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段,关联的系统',
  `ext_id` int(8) NOT NULL COMMENT '扩展字段,供其它调用',
  `replyuser` varchar(50) NOT NULL COMMENT '最后评论者',
  `phone_type` varchar(50) NOT NULL COMMENT '发表来自什么手机',
  `qun_status` tinyint(1) NOT NULL COMMENT '圈子扩展状态,比如置顶',
  `font_type` tinyint(1) NOT NULL COMMENT '标题字体加粗或其它',
  `font_color` varchar(7) NOT NULL COMMENT '标题字体颜色',
  `telphone` varchar(25) NOT NULL COMMENT '联系电话',
  `wxid` varchar(25) NOT NULL COMMENT '联系微信号',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `ext_id` (`ext_id`,`ext_sys`),
  KEY `replynum` (`replynum`),
  KEY `agree` (`agree`),
  KEY `uid` (`uid`),
  KEY `qun_status` (`qun_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='咨询模型内容主表' AUTO_INCREMENT=1 ;
