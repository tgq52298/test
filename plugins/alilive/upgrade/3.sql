
DROP TABLE IF EXISTS `qb_alilive_order`;
CREATE TABLE IF NOT EXISTS `qb_alilive_order` (
  `id` mediumint(7) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(7) NOT NULL COMMENT '购买者UID',
  `aid` mediumint(7) NOT NULL COMMENT '使用的圈子ID',
  `timelong` mediumint(7) NOT NULL COMMENT '直播总时长(秒)',
  `usetime` mediumint(7) NOT NULL COMMENT '已使用时间(秒)',
  `create_time` int(10) NOT NULL COMMENT '购买时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='直播流量购买订单' AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS `qb_alilive_viewlog`;
CREATE TABLE IF NOT EXISTS `qb_alilive_viewlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(7) NOT NULL COMMENT '访问者ID',
  `ip` varchar(15) NOT NULL COMMENT '访问者IP',
  `aid` mediumint(7) NOT NULL COMMENT '圈子ID',
  `create_time` int(10) NOT NULL COMMENT '访问时间',
  `view_time` mediumint(7) NOT NULL COMMENT '访问时长(秒)',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户访问日志' AUTO_INCREMENT=1 ;


