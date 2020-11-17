INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO标题', 'mseo_title', '', 'text', '', 0, '', '', 100, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化关键字keywords', 'mseo_keyword', '', 'text', '', 0, '', '', 99, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化描述description', 'mseo_description', '', 'text', '', 0, '', '', 98, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否开启当前模块', 'is_open_modlue', '1', 'radio', '1|开启\r\n0|关闭', 0, '', '', 97, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '允许发布内容的用户组', 'can_post_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 96, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '发布内容自动通过审核的用户组', 'post_auto_pass_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 95, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '默认城市ID', 'city_id', '6', 'select', 'plugins\\area\\model\\Area@getTitleList@{"level":2}', 0, '', '列表页会默认显示这个城市下面的区域,不设置将无法显示区域筛选', 0, 12);



DROP TABLE IF EXISTS `qb_fenlei_content`;
CREATE TABLE IF NOT EXISTS `qb_fenlei_content` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) NOT NULL COMMENT '栏目ID',
  `uid` int(8) NOT NULL,
  `view` mediumint(7) NOT NULL COMMENT '浏览量',
  `status` tinyint(2) NOT NULL COMMENT '状态：0未审 1已审 2推荐',
  `list` int(10) NOT NULL COMMENT '可控排序',
  `create_time` int(10) NOT NULL COMMENT '发布日期',
  `ext_id` mediumint(7) NOT NULL COMMENT '关联其它模型的内容ID',
  `ext_sys` smallint(4) NOT NULL COMMENT '关联其它模型的频道ID',
  `map_x` double NOT NULL COMMENT '地图经度坐标',
  `map_y` double NOT NULL COMMENT '地图纬度坐标',
  `title` varchar(255) NOT NULL COMMENT '标题',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ext_id` (`ext_id`,`ext_sys`),
  KEY `map_x` (`map_x`),
  KEY `map_y` (`map_y`),
  KEY `fid` (`fid`),
  KEY `create_time` (`create_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='内容索引表' AUTO_INCREMENT=9 ;



INSERT INTO `qb_fenlei_content` (`id`, `mid`, `uid`) VALUES
(1, 2, 1),
(2, 2, 1),
(3, 1, 1),
(4, 1, 1),
(5, 1, 1);



DROP TABLE IF EXISTS `qb_fenlei_content1`;
CREATE TABLE IF NOT EXISTS `qb_fenlei_content1` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
  `agree` mediumint(5) NOT NULL DEFAULT '0' COMMENT '点赞',
  `replynum` mediumint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '封面图',
  `content` text NOT NULL COMMENT '文章内容',
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段,关联的系统',
  `ext_id` int(7) NOT NULL COMMENT '扩展字段,关联的ID',
  `infotype` tinyint(1) NOT NULL COMMENT '交易类型',
  `paytype` varchar(32) NOT NULL COMMENT '交易方式',
  `telphone` varchar(18) NOT NULL COMMENT '电话号码',
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
  KEY `ext_id_2` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章模型模型表' AUTO_INCREMENT=6 ;



INSERT INTO `qb_fenlei_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `agree`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `ext_sys`, `ext_id`, `infotype`, `paytype`, `telphone`) VALUES
(3, 1, 4, '求购手推车,9成新最好', 0, 1, 16, 1, 0, 0, 1527824513, 1527860899, 1527824513, '', '<p>最好是没坏的.坏的免谈</p>', 0, 0, 0, 0, 0, 0, 1, '1', '400-889-3333'),
(4, 1, 4, '出信儿童自行车,99成新,包邮', 0, 1, 51, 1, 0, 0, 1527824578, 1528095851, 1527824578, '', '<p>同城的话,也可上门交易购买</p>', 1, 6, 8, 0, 0, 0, 2, '2', '18664780111'),
(5, 1, 5, '求购学位房,限中心小学附近地段', 0, 1, 27, 1, 0, 0, 1527824723, 1527860819, 1527824723, '', '<p>总价不超过100万.楼层5楼以下.</p>', 0, 0, 0, 0, 0, 0, 1, '1', '400-889-3333');



DROP TABLE IF EXISTS `qb_fenlei_content2`;
CREATE TABLE IF NOT EXISTS `qb_fenlei_content2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `picurl` text NOT NULL COMMENT '封面图',
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
  `agree` mediumint(5) NOT NULL DEFAULT '0' COMMENT '点赞',
  `replynum` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `content` text NOT NULL COMMENT '内容介绍',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段,关联的系统',
  `ext_id` mediumint(7) NOT NULL COMMENT '扩展字段,关联的ID',
  `rooms_buju` tinyint(2) NOT NULL COMMENT '室内布局',
  `peitao` varchar(32) NOT NULL COMMENT '配套设施',
  `zhuanxiu` tinyint(2) NOT NULL COMMENT '装修情况',
  `telphone` varchar(18) NOT NULL COMMENT '电话号码',
  `maps` varchar(32) NOT NULL COMMENT '地图',
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
  KEY `ext_id_2` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='图片模型模型表' AUTO_INCREMENT=3 ;



INSERT INTO `qb_fenlei_content2` (`id`, `mid`, `fid`, `title`, `ispic`, `picurl`, `uid`, `view`, `status`, `agree`, `replynum`, `content`, `create_time`, `update_time`, `list`, `province_id`, `city_id`, `zone_id`, `street_id`, `ext_sys`, `ext_id`, `rooms_buju`, `peitao`, `zhuanxiu`, `telphone`, `maps`) VALUES
(1, 2, 2, '广州新市小两房出手了', 1, 'uploads/images/20180601/15278242487146.jpeg', 1, 12, 1, 0, 0, '<p>便宜到没朋友.不要错过了</p>', 1527824044, 1528093482, 1527824044, 0, 0, 0, 0, 0, 0, 1, ',3,5,7,', 3, '13710841240', '113.264541,23.131537'),
(2, 2, 2, '中山路笋盘仅售70万元,包过户', 1, 'uploads/images/20180601/15278240754832.jpeg', 1, 84, 1, 0, 0, '<p>刚性需求的,就快快下手吧</p>', 1527824199, 1528093499, 1527824199, 0, 0, 0, 0, 0, 0, 4, ',1,4,5,7,', 2, '400-889-3333', '113.279956,23.127648');



DROP TABLE IF EXISTS `qb_fenlei_field`;
CREATE TABLE IF NOT EXISTS `qb_fenlei_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '字段名称',
  `name` varchar(32) NOT NULL,
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT '字段标题',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT '字段类型',
  `field_type` varchar(128) NOT NULL DEFAULT '' COMMENT '字段定义',
  `value` text COMMENT '默认值',
  `options` text COMMENT '额外选项',
  `about` varchar(256) NOT NULL DEFAULT '' COMMENT '提示说明',
  `show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文档字段表' AUTO_INCREMENT=65 ;



INSERT INTO `qb_fenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES
(10, 'title', '标题', 'text', 'varchar(256) NOT NULL', NULL, NULL, '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, ''),
(11, 'picurl', '组图', 'images', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 99, 0, 0, 0, ''),
(12, 'content', '详情', 'ueditor', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, ''),
(19, 'title', '信息标题', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, ''),
(20, 'picurl', '封面图', 'images', 'text NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', 98, 0, 0, 0, ''),
(21, 'content', '详情', 'ueditor', 'text NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, ''),
(62, 'telphone', '电话号码', 'text', 'varchar(18) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, ''),
(60, 'infotype', '交易类型', 'radio', 'tinyint(1) NOT NULL', '', '1|求购\r\n2|出售', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 1, 1, 1, ''),
(61, 'paytype', '交易方式', 'radio', 'varchar(32) NOT NULL', '', '1|当面交易\r\n2|淘宝交易', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 1, 1, 1, ''),
(59, 'zhuanxiu', '装修情况', 'radio', 'tinyint(2) NOT NULL', '', '1|普通装修\r\n2|精装修\r\n3|豪华装修\r\n4|毛坯房', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 1, 1, 1, ''),
(57, 'rooms_buju', '室内布局', 'select', 'tinyint(2) NOT NULL', '0', '1|两室一厅\r\n2|两室两厅\r\n3|三室一厅\r\n4|三室两厅\r\n5|一室一厅\r\n6|一居室\r\n7|三室以上\r\n8|别墅', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 1, 1, 1, ''),
(58, 'peitao', '配套设施', 'checkbox', 'varchar(32) NOT NULL', '', '1|水\r\n2|电\r\n3|电话\r\n4|宽带\r\n5|管道煤气\r\n6|电梯\r\n7|家具', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 1, 1, 1, ''),
(63, 'telphone', '电话号码', 'text', 'varchar(18) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, ''),
(64, 'maps', '地图', 'bmap', 'varchar(32) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '');


DROP TABLE IF EXISTS `qb_fenlei_module`;
CREATE TABLE IF NOT EXISTS `qb_fenlei_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) NOT NULL DEFAULT '' COMMENT '区分符关键字',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模型标题',
  `layout` varchar(50) NOT NULL COMMENT '模板路径',
  `icon` varchar(64) NOT NULL,
  `list` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='模型表' AUTO_INCREMENT=3 ;



INSERT INTO `qb_fenlei_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`) VALUES
(1, '', '一般信息', '', '', 100, 1515221331, 0),
(2, '', '房产模型', '', '', 100, 1515236691, 0);



DROP TABLE IF EXISTS `qb_fenlei_sort`;
CREATE TABLE IF NOT EXISTS `qb_fenlei_sort` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='主栏目表' AUTO_INCREMENT=6 ;



INSERT INTO `qb_fenlei_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES
(1, 0, 2, '房产专区', 0, '', '', '', '', '', '', ''),
(2, 1, 2, '出售房屋', 0, '', '', '', '', '', '', ''),
(3, 0, 1, '二手市场', 0, '', '', '', '', '', '', ''),
(4, 3, 1, '母婴用品', 0, '', '', '', '', '', '', ''),
(5, 1, 1, '求购房子', 0, '', '', '', '', '', '', '');

ALTER TABLE  `qb_fenlei_module` ADD  `haibao` VARCHAR( 255 ) NOT NULL COMMENT  '海报模板路径,多个用逗号隔开';
ALTER TABLE  `qb_fenlei_sort` ADD  `haibao` VARCHAR( 255 ) NOT NULL COMMENT  '海报模板路径,多个用逗号隔开';
