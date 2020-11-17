INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否开放申请', 'is_allow_add', '1', 'radio', '1|开启\r\n0|关闭', 0, '', '', 0, 5);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '每个广告位最多申请几天', 'total_day', '0', 'nummber', '', 0, '', '', 0, 5);

DROP TABLE IF EXISTS `qb_myad_info`;
CREATE TABLE IF NOT EXISTS `qb_myad_info` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `fid` int(7) NOT NULL COMMENT '广告位置',
  `type` tinyint(1) NOT NULL COMMENT '广告类型.0文字广告,1单图广告,2幻灯片广告',
  `title` varchar(100) NOT NULL COMMENT '广告标题',
  `picurl` varchar(150) NOT NULL COMMENT '广告单图',
  `picurls` text NOT NULL COMMENT '组图',
  `about` text NOT NULL COMMENT '广告介绍',
  `url` varchar(255) NOT NULL COMMENT '连接网址',
  `uid` int(8) NOT NULL COMMENT '用户ID',
  `status` tinyint(4) NOT NULL COMMENT '审核状态',
  `create_time` int(10) NOT NULL COMMENT '添加时间',
  `begin_time` int(10) NOT NULL COMMENT '投放开始日期',
  `end_time` int(10) NOT NULL COMMENT '投放结束日期',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='广告列表' AUTO_INCREMENT=1 ;