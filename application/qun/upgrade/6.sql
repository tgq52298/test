
DROP TABLE IF EXISTS `qb_qun_adset`;
CREATE TABLE IF NOT EXISTS `qb_qun_adset` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(50) NOT NULL COMMENT '关键字,暂时没用到',
  `title` varchar(100) NOT NULL COMMENT '广告位名称',
  `status` tinyint(1) NOT NULL COMMENT '0关闭购买,-1用户购买广告需要审核,1用户购买广告不需审核',
  `price` decimal(10,2) unsigned NOT NULL COMMENT '售价',
  `day` mediumint(5) NOT NULL COMMENT '广告时长',
  `aid` int(7) NOT NULL COMMENT '圈子ID',
  `type` tinyint(1) NOT NULL COMMENT '广告类型0是纯文本广告,暂时没用到',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='广告位参数设置' AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `qb_qun_aduser`;
CREATE TABLE IF NOT EXISTS `qb_qun_aduser` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `uid` int(7) NOT NULL COMMENT '购买用户UID',
  `keyword` int(30) NOT NULL COMMENT '广告位关键字,暂时没用到',
  `aid` int(7) NOT NULL COMMENT '圈子ID',
  `ad_id` int(7) NOT NULL COMMENT '广告位ID,暂时没用到',
  `begin_time` int(10) NOT NULL COMMENT '广告开始时间',
  `end_time` int(10) NOT NULL COMMENT '广告结束时间',
  `money` decimal(10,2) NOT NULL COMMENT '广告费用',
  `create_time` int(10) NOT NULL COMMENT '添加时间',
  `type` tinyint(1) NOT NULL COMMENT '广告类型0是纯文本广告,暂时没用到',
  `title` varchar(100) NOT NULL COMMENT '广告标题',
  `picurl` varchar(255) NOT NULL COMMENT '广告图片',
  `content` text NOT NULL COMMENT '广告内容',
  `url` varchar(255) NOT NULL COMMENT '广告网址',
  `status` tinyint(1) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `ad_id` (`ad_id`),
  KEY `begin_time` (`begin_time`),
  KEY `end_time` (`end_time`),
  KEY `aid` (`aid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户购买的广告列表' AUTO_INCREMENT=1 ;

ALTER TABLE  `qb_qun_content1` ADD  `openad` TINYINT NOT NULL COMMENT  '是否启用广告购买';
ALTER TABLE  `qb_qun_content1` ADD INDEX (  `openad` );