DROP TABLE IF EXISTS `qb_fav`;
CREATE TABLE IF NOT EXISTS `qb_fav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sysid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '插件或模块ID',
  `aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模块的内容页ID',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  PRIMARY KEY (`id`),
  KEY `list` (`list`),
  KEY `sysid` (`sysid`),
  KEY `aid` (`aid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='收藏夹' AUTO_INCREMENT=1 ;