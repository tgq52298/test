INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO标题', 'mseo_title', '', 'text', '', 0, '', '', 100, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化关键字keywords', 'mseo_keyword', '', 'text', '', 0, '', '', 99, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化描述description', 'mseo_description', '', 'text', '', 0, '', '', 98, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否开启当前模块', 'is_open_modlue', '1', 'radio', '1|开启\r\n0|关闭', 0, '', '', 97, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '允许发布内容的用户组', 'can_post_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 96, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '发布内容自动通过审核的用户组', 'post_auto_pass_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 95, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '内容被设为精华奖励积分个数', 'com_info_add_money', '', 'text', '', 0, '', '', 94, 4);


INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '客户下单是否短消息通知商家', 'post_order_msg_hy', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '客户下单是否短信通知商家', 'post_order_sms_hy', '0', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '客户下单是否微信通知商家', 'post_order_wx_hy', '0', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '客户付款成功是否短消息通知商家', 'pay_order_msg_hy', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '客户付款成功是否短信通知商家', 'pay_order_sms_hy', '0', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '客户付款成功是否微信通知商家', 'pay_order_wx_hy', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, 4);



DROP TABLE IF EXISTS `qb_miaosha_car`;
CREATE TABLE IF NOT EXISTS `qb_miaosha_car` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增值',
  `shopid` int(10) NOT NULL COMMENT '商品ID',
  `type1` tinyint(2) NOT NULL COMMENT '商品属性1',
  `type2` tinyint(2) NOT NULL COMMENT '商品属性2',
  `type3` tinyint(2) NOT NULL COMMENT '商品属性3',
  `num` mediumint(5) NOT NULL COMMENT '购买数量',
  `create_time` int(10) NOT NULL COMMENT '时间',
  `update_time` int(10) NOT NULL,
  `ifchoose` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否钩选要购买',
  `uid` mediumint(7) NOT NULL COMMENT '用户的UID',
  PRIMARY KEY (`id`),
  KEY `shopid` (`shopid`,`uid`),
  KEY `uid` (`uid`,`update_time`,`ifchoose`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='购物车' AUTO_INCREMENT=5 ;



INSERT INTO `qb_miaosha_car` (`id`, `shopid`, `type1`, `type2`, `type3`, `num`, `create_time`, `update_time`, `ifchoose`, `uid`) VALUES(1, 3, 2, 2, 0, 1, 1527243313, 1530332725, 1, 1);
INSERT INTO `qb_miaosha_car` (`id`, `shopid`, `type1`, `type2`, `type3`, `num`, `create_time`, `update_time`, `ifchoose`, `uid`) VALUES(3, 3, 3, 2, 0, 1, 1527555593, 1527555593, 1, 3);



DROP TABLE IF EXISTS `qb_miaosha_content`;
CREATE TABLE IF NOT EXISTS `qb_miaosha_content` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `uid` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='内容索引表' AUTO_INCREMENT=7 ;



INSERT INTO `qb_miaosha_content` (`id`, `mid`, `uid`) VALUES(3, 1, 1);
INSERT INTO `qb_miaosha_content` (`id`, `mid`, `uid`) VALUES(2, 1, 1);



DROP TABLE IF EXISTS `qb_miaosha_content1`;
CREATE TABLE IF NOT EXISTS `qb_miaosha_content1` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
  `replynum` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '封面图',
  `content` text NOT NULL COMMENT '文章内容',
  `price` decimal(10,2) unsigned NOT NULL COMMENT '商品价格',
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段,关联的系统',
  `type1` varchar(255) NOT NULL COMMENT '商品属性1',
  `type2` varchar(255) NOT NULL COMMENT '商品属性2',
  `type3` varchar(255) NOT NULL COMMENT '商品属性3',
  `ext_id` int(8) NOT NULL COMMENT '扩展字段,供其它调用',
  `begin_time` int(10) NOT NULL DEFAULT '0' COMMENT '活动开始时间',
  `num` int(5) NOT NULL DEFAULT '0' COMMENT '库存量',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `comment` (`replynum`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `ext_id` (`ext_id`,`ext_sys`),
  KEY `ext_id_2` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品内容表' AUTO_INCREMENT=7 ;



INSERT INTO `qb_miaosha_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `price`, `province_id`, `city_id`, `zone_id`, `street_id`, `ext_sys`, `type1`, `type2`, `type3`, `ext_id`, `begin_time`, `num`) VALUES(3, 1, 2, '魅族蓝牙小音箱', 1, 1, 108, 1, 0, 1517981293, 1530335915, 0, 'uploads/images/20180302/CnQOjVikE4qAYN55AAMAoDa-ghQ407.jpg', '<p><img class="lazy" width="1240" alt="" src="https://openfile.meizu.com/group1/M00/01/1E/CnQOjVij_geANlzXAAJ4JdyIZ7g421.jpg"/><img class="lazy" width="1240" alt="" src="https://openfile.meizu.com/group1/M00/01/1E/Cix_s1ij_giAVoRwAALyOhoZT6k135.jpg"/><img class="lazy" width="1240" alt="" src="https://openfile.meizu.com/group1/M00/01/1E/Cix_s1ij_giAcddhAAIAdrNbQ5I909.jpg"/></p>', '100.22', 0, 0, 0, 0, 0, '["16G|32","32G","64G|45"]', '["红色","白色"]', '[]', 30, 1559664000, 3);
INSERT INTO `qb_miaosha_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `price`, `province_id`, `city_id`, `zone_id`, `street_id`, `ext_sys`, `type1`, `type2`, `type3`, `ext_id`, `begin_time`, `num`) VALUES(2, 1, 1, '魅族手机M9最新款隆重上市了', 1, 1, 300, 1, 0, 1516259334, 1530325704, 0, 'uploads/images/20180302/Cgbj0FnCGy2AQhMOAA5ZxbK1GIo722.jpg', '<p><img class="lazy" width="1240" alt="" src="https://openfile.meizu.com/group1/M00/04/1E/Cgbj0VrcdgOAf_cEAAHV1O1wNn4780.jpg"/><a href="https://detail.meizu.com/item/spx.html" target="_blank"><img class="lazy" width="1240" alt="" src="https://openfile.meizu.com/group1/M00/03/86/Cgbj0FqzftuAFRuEAAFDN8UQ57I852.jpg"/></a><img class="lazy" width="1240" alt="" src="https://openfile.meizu.com/group1/M00/04/10/Cgbj0FrcdgOADH3rAAJvD1XrMDg850.jpg"/><img class="lazy" width="1240" alt="" src="https://openfile.meizu.com/group1/M00/04/1E/Cgbj0VrcdgOAV3G7AAVRP964D3A280.jpg"/><img class="lazy" width="1240" alt="" src="https://openfile.meizu.com/group1/M00/04/10/Cgbj0FrcdgWAbRd5AAFG0cWJKug303.jpg"/><img class="lazy" width="1240" alt="" src="https://openfile.meizu.com/group1/M00/04/10/Cgbj0FrcdgWAZNLyAAHNcu8f9V8672.jpg"/><img class="lazy" width="1240" alt="" src="https://openfile.meizu.com/group1/M00/04/1E/Cgbj0VrcdgWAMuu2AAVk0BJBeg4924.jpg"/><img class="lazy" width="1240" alt="" src="https://openfile.meizu.com/group1/M00/04/1E/Cgbj0VrcdgaAPMMqAAJ5D3ohZpM015.jpg"/></p>', '2020.02', 0, 0, 0, 0, 0, '["大份|10","中份|20","小份|40"]', '["XX","XL","XXXL"]', '["红","黄","蓝"]', 30, 1530043505, 20);



DROP TABLE IF EXISTS `qb_miaosha_field`;
CREATE TABLE IF NOT EXISTS `qb_miaosha_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '字段名称',
  `name` varchar(32) NOT NULL,
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT '字段标题',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT '字段类型',
  `field_type` varchar(128) NOT NULL DEFAULT '' COMMENT '字段定义',
  `value` text COMMENT '默认值',
  `options` text COMMENT '额外选项',
  `about` varchar(256) NOT NULL DEFAULT '' COMMENT '提示说明',
  `show` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `mid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属模型id',
  `ajax_url` varchar(256) NOT NULL DEFAULT '' COMMENT '联动下拉框ajax地址',
  `next_items` varchar(256) NOT NULL DEFAULT '' COMMENT '联动下拉框的下级下拉框名，多个以逗号隔开',
  `param` varchar(32) NOT NULL DEFAULT '' COMMENT '联动下拉框请求参数名',
  `format` varchar(32) NOT NULL DEFAULT '' COMMENT '格式，用于格式文本',
  `table` varchar(32) NOT NULL DEFAULT '' COMMENT '表名，只用于快速联动类型',
  `level` tinyint(2) unsigned NOT NULL DEFAULT '2' COMMENT '联动级别，只用于快速联动类型',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT '键字段，只用于快速联动类型',
  `option` varchar(32) NOT NULL DEFAULT '' COMMENT '值字段，只用于快速联动类型',
  `pid` varchar(32) NOT NULL DEFAULT '' COMMENT '父级id字段，只用于快速联动类型',
  `list` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `listshow` tinyint(1) NOT NULL COMMENT '是否在列表显示',
  `ifsearch` tinyint(1) NOT NULL COMMENT '是否作为搜索字段',
  `ifmust` tinyint(1) NOT NULL COMMENT '是否必填项',
  `nav` varchar(30) NOT NULL COMMENT '分组名称',
  `input_width` varchar(7) NOT NULL COMMENT '输入表单宽度',
  `input_height` varchar(7) NOT NULL COMMENT '输入表单高度',
  `unit` varchar(20) NOT NULL COMMENT '单位名称',
  `match` varchar(150) NOT NULL COMMENT '表单正则匹配',
  `css` varchar(20) NOT NULL COMMENT '表单CSS类名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文档字段表' AUTO_INCREMENT=53 ;



INSERT INTO `qb_miaosha_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(10, 'title', '商品名称', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 200, 1, 1, 1, '', '', '', '', '', '');
INSERT INTO `qb_miaosha_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(11, 'picurl', '商品介绍图', 'images', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 98, 0, 0, 0, '', '', '', '', '', '');
INSERT INTO `qb_miaosha_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(12, 'content', '商品介绍', 'ueditor', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '');
INSERT INTO `qb_miaosha_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(47, 'price', '商品价格', 'money', 'decimal(10, 2 ) UNSIGNED NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 150, 0, 0, 0, '', '', '', '', '', '');
INSERT INTO `qb_miaosha_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(48, 'type1', '型号', 'array', 'varchar(255) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '商品属性', '', '', '', '', '');
INSERT INTO `qb_miaosha_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(49, 'type2', '尺寸', 'array', 'varchar(255) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '商品属性', '', '', '', '', '');
INSERT INTO `qb_miaosha_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(50, 'type3', '颜色', 'array', 'varchar(255) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '商品属性', '', '', '', '', '');
INSERT INTO `qb_miaosha_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(51, 'begin_time', '活动开始时间', 'datetime', 'int(10) NOT NULL DEFAULT ''0''', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 130, 1, 0, 0, '', '', '', '', '', '');
INSERT INTO `qb_miaosha_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(52, 'num', '库存量', 'number', 'int(5) NOT NULL DEFAULT ''0''', '3', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 140, 0, 0, 0, '', '', '', '', '', '');



DROP TABLE IF EXISTS `qb_miaosha_log`;
CREATE TABLE IF NOT EXISTS `qb_miaosha_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增值',
  `shopid` int(10) NOT NULL COMMENT '商品ID',
  `num` mediumint(5) NOT NULL DEFAULT '1' COMMENT '购买数量',
  `create_time` int(10) NOT NULL COMMENT '时间',
  `uid` mediumint(7) NOT NULL COMMENT '用户的UID',
  `order_id` int(11) NOT NULL COMMENT '订单ID',
  PRIMARY KEY (`id`),
  KEY `shopid` (`shopid`,`uid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='秒杀记录' AUTO_INCREMENT=4 ;



DROP TABLE IF EXISTS `qb_miaosha_module`;
CREATE TABLE IF NOT EXISTS `qb_miaosha_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) NOT NULL DEFAULT '' COMMENT '区分符关键字',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模型标题',
  `layout` varchar(50) NOT NULL COMMENT '模板路径',
  `icon` varchar(64) NOT NULL,
  `list` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='模型表' AUTO_INCREMENT=2 ;



INSERT INTO `qb_miaosha_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`) VALUES(1, '', '商品模型', '', '', 100, 1515221331, 0);



DROP TABLE IF EXISTS `qb_miaosha_order`;
CREATE TABLE IF NOT EXISTS `qb_miaosha_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `order_sn` varchar(20) NOT NULL DEFAULT '' COMMENT '订单编号',
  `shop` varchar(255) NOT NULL COMMENT '购买的商品,存放格式如下:shopid-num-type1-type2-type3 商品ID,购买数量,商品属性1、2、3,多个商品用,号隔开',
  `shop_uid` mediumint(7) NOT NULL COMMENT '店主的UID',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '下单客户的uid',
  `totalmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总金额',
  `shipping_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '邮费',
  `pay_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际付款金额',
  `user_rmb` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '使用余额',
  `user_jf` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用积分',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态',
  `pay_name` varchar(120) NOT NULL DEFAULT '' COMMENT '付款方式',
  `linkman` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货地址',
  `telphone` varchar(60) NOT NULL DEFAULT '' COMMENT '手机',
  `shipping_time` int(11) DEFAULT '0' COMMENT '发货时间',
  `receive_time` int(10) DEFAULT '0' COMMENT '收货时间',
  `receive_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '收货状态',
  `shipping_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '发货状态',
  `shipping_name` varchar(120) NOT NULL DEFAULT '' COMMENT '物流名称',
  `shipping_code` varchar(32) NOT NULL DEFAULT '' COMMENT '物流单号',
  `user_note` varchar(255) NOT NULL DEFAULT '' COMMENT '用户备注',
  `admin_note` varchar(255) DEFAULT '' COMMENT '管理员备注',
  PRIMARY KEY (`id`),
  KEY `create_time` (`create_time`),
  KEY `uid` (`uid`),
  KEY `order_sn` (`order_sn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商品订单' AUTO_INCREMENT=7 ;



INSERT INTO `qb_miaosha_order` (`id`, `order_sn`, `shop`, `shop_uid`, `uid`, `totalmoney`, `shipping_price`, `pay_money`, `user_rmb`, `user_jf`, `create_time`, `pay_time`, `pay_status`, `pay_name`, `linkman`, `address`, `telphone`, `shipping_time`, `receive_time`, `receive_status`, `shipping_status`, `shipping_name`, `shipping_code`, `user_note`, `admin_note`) VALUES(1, 'b7b4480be5', '3-1-1-1-0', 1, 1, '32.00', '0.00', '32.00', '0.00', 0, 1527243821, 0, 0, '', '张三', '广州市番禺区桥兴大道403号潮联商务中心409室', '1254784', 0, 0, 0, 0, '', '', '', '');
INSERT INTO `qb_miaosha_order` (`id`, `order_sn`, `shop`, `shop_uid`, `uid`, `totalmoney`, `shipping_price`, `pay_money`, `user_rmb`, `user_jf`, `create_time`, `pay_time`, `pay_status`, `pay_name`, `linkman`, `address`, `telphone`, `shipping_time`, `receive_time`, `receive_status`, `shipping_status`, `shipping_name`, `shipping_code`, `user_note`, `admin_note`) VALUES(3, '97669f1ce4', '3-1-2-1-0', 1, 3, '100.22', '0.00', '100.22', '0.00', 0, 1527554650, 0, 0, '', '张三', '广东省广州市番禺区清河东路319号', '18664545451', 0, 0, 0, 0, '', '', '', '');



DROP TABLE IF EXISTS `qb_miaosha_sort`;
CREATE TABLE IF NOT EXISTS `qb_miaosha_sort` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL,
  `mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `name` varchar(50) NOT NULL,
  `list` int(10) NOT NULL,
  `logo` varchar(50) NOT NULL COMMENT '封面图',
  `template` varchar(255) NOT NULL COMMENT '模板',
  `allowpost` varchar(100) NOT NULL COMMENT '允许发布信息的用户组',
  `allowview` varchar(100) NOT NULL COMMENT '允许浏览内容的用户组',
  `seo_title` varchar(255) NOT NULL COMMENT 'SEO标题',
  `seo_keywords` varchar(255) NOT NULL COMMENT 'SEO关键字',
  `seo_description` varchar(255) NOT NULL COMMENT 'SEO描述',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `pid` (`pid`),
  KEY `list` (`list`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='主栏目表' AUTO_INCREMENT=3 ;



INSERT INTO `qb_miaosha_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(1, 0, 1, '数码产品', 0, '', '', '', '', '', '', '');
INSERT INTO `qb_miaosha_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(2, 0, 1, '家居用品', 0, '', '', '', '', '', '', '');




ALTER TABLE  `qb_miaosha_content` ADD  `view` MEDIUMINT( 7 ) NOT NULL COMMENT  '浏览量',ADD  `status` TINYINT( 2 ) NOT NULL COMMENT  '状态,-1回收站,0未审,1已审',ADD  `list` INT( 10 ) NOT NULL COMMENT  '排序值',ADD  `ext_id` MEDIUMINT( 7 ) NOT NULL COMMENT  '关联主题ID',ADD  `ext_sys` SMALLINT( 4 ) NOT NULL COMMENT  '关联系统ID';
update `qb_miaosha_content` set `view`=1;


ALTER TABLE  `qb_miaosha_field` ADD  `script` TEXT NOT NULL COMMENT  'JS脚本',ADD  `trigger` VARCHAR( 255 ) NOT NULL COMMENT  '选择某一项后,联动触发显示其它字段';
ALTER TABLE  `qb_miaosha_field` ADD  `range_opt` TEXT NOT NULL COMMENT  '范围选择,比如价格范围',ADD  `group_view` VARCHAR( 255 ) NOT NULL COMMENT  '允许哪些用户组查看',ADD  `index_hide` TINYINT( 1 ) NOT NULL COMMENT  '是否前台不显示并不做转义处理';
ALTER TABLE  `qb_miaosha_field` ADD  `group_post` VARCHAR( 255 ) NOT NULL COMMENT  '允许使用此字段的用户组';
ALTER TABLE  `qb_miaosha_field` CHANGE  `title`  `title` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '' COMMENT  '字段标题';