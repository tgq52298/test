
DROP TABLE IF EXISTS `qb_qun_claim`;
CREATE TABLE IF NOT EXISTS `qb_qun_claim` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '圈子ID',
  `uid` int(7) NOT NULL COMMENT '申请uid',
  `create_time` int(10) NOT NULL COMMENT '申请时间',
  `linkman` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '联系人',
  `telphone` varchar(25) COLLATE utf8_bin NOT NULL COMMENT '联系电话',
  `email` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '联系邮箱',
  `why` text COLLATE utf8_bin NOT NULL COMMENT '原因说明',
  `status` tinyint(1) NOT NULL COMMENT '状态,1为同意认领,-1为拒绝认领',
  `update_time` int(10) NOT NULL COMMENT '处理时间',
  `owner_uid` int(7) NOT NULL COMMENT '原圈主uid',
  `picurl` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '证件扫描件',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `uid` (`uid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='认领圈子' AUTO_INCREMENT=1 ;