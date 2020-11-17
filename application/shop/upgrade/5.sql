
DROP TABLE IF EXISTS `qb_shop_fx`;
CREATE TABLE IF NOT EXISTS `qb_shop_fx` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '商品ID',
  `uid` int(7) NOT NULL COMMENT '新进来的访问UID',
  `introducer_1` int(7) NOT NULL COMMENT '分享者,即介绍人的UID',
  `create_time` int(10) NOT NULL COMMENT '推荐时间',
  `ifbuy` tinyint(1) NOT NULL COMMENT '是否付款成功购买',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `introducer_1` (`introducer_1`),
  KEY `uid` (`uid`),
  KEY `ifbuy` (`ifbuy`),
  KEY `create_time` (`create_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户分享商品的记录' AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `qb_shop_fxlog`;
CREATE TABLE IF NOT EXISTS `qb_shop_fxlog` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '商品ID',
  `uid` int(7) NOT NULL COMMENT '当前购买商品用户UID',
  `introducer_uid` int(7) NOT NULL COMMENT '推荐人UID',
  `introducer_step` tinyint(1) NOT NULL DEFAULT '1' COMMENT '属于第几级推荐人',
  `create_time` int(10) NOT NULL COMMENT '交易成功时间',
  `money` decimal(10,2) NOT NULL COMMENT '分销获利金额',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `uid` (`uid`),
  KEY `introducer_uid` (`introducer_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='付款交易成功后的分销收益日志' AUTO_INCREMENT=1 ;


ALTER TABLE  `qb_shop_order` ADD  `introducer_1` INT( 7 ) NOT NULL COMMENT  '直接推荐人',ADD  `introducer_2` INT( 7 ) NOT NULL COMMENT  '间接推荐人',ADD  `introducer_3` INT( 7 ) NOT NULL COMMENT  '第三级推荐人';

ALTER TABLE  `qb_shop_order` ADD INDEX (  `shop_uid` );
ALTER TABLE  `qb_shop_order` ADD INDEX (  `pay_status` );
ALTER TABLE  `qb_shop_order` ADD INDEX (  `shopid` );
ALTER TABLE  `qb_shop_order` CHANGE  `receive_status`  `receive_status` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '收货状态';
ALTER TABLE  `qb_shop_order` CHANGE  `shipping_status`  `shipping_status` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '发货状态';
ALTER TABLE  `qb_shop_order` CHANGE  `pay_status`  `pay_status` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT  '支付状态';
ALTER TABLE  `qb_shop_order` ADD INDEX (  `introducer_1` );


INSERT INTO `qb_shop_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES(0, 'fx1', '直接推荐人收益', 'money', 'decimal(10,2) unsigned NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '分销设置');
INSERT INTO `qb_shop_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES(0, 'fx2', '间接推荐人收益', 'money', 'decimal(10,2) unsigned NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '分销设置');
INSERT INTO `qb_shop_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES(0, 'fx3', '三级推荐人收益', 'money', 'decimal(10,2) unsigned NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '分销设置');

ALTER TABLE  `qb_shop_content1` ADD  `fx1` DECIMAL( 10, 2 ) NOT NULL COMMENT  '直接推荐人收益';
ALTER TABLE  `qb_shop_content1` ADD  `fx2` DECIMAL( 10, 2 ) NOT NULL COMMENT  '间接推荐人收益';
ALTER TABLE  `qb_shop_content1` ADD  `fx3` DECIMAL( 10, 2 ) NOT NULL COMMENT  '三级推荐人收益';
