INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO标题', 'mseo_title', '', 'text', '', 0, '', '', 100, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化关键字keywords', 'mseo_keyword', '', 'text', '', 0, '', '', 99, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化描述description', 'mseo_description', '', 'text', '', 0, '', '', 98, 4);
-- INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否开启当前模块', 'is_open_modlue', '1', 'radio', '1|开启\r\n0|关闭', 0, '', '', 97, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '允许发布内容的用户组', 'can_post_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 96, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '发布内容自动通过审核的用户组', 'post_auto_pass_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 95, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '默认城市ID', 'city_id', '6', 'select', 'plugins\\area\\model\\Area@getTitleList@{"level":2}', 0, '', '列表页会默认显示这个城市下面的区域,不设置将无法显示区域筛选', 0, 12);


DROP TABLE IF EXISTS `qb_house_content`;
CREATE TABLE IF NOT EXISTS `qb_house_content` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `uid` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='内容索引表' AUTO_INCREMENT=6 ;




DROP TABLE IF EXISTS `qb_house_content1`;
CREATE TABLE `qb_house_content1` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
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
  `linkman` varchar(80) NOT NULL COMMENT '联系人',
  `sortid` tinyint(2) NOT NULL COMMENT '性质',
  `price` decimal(10,2) NOT NULL COMMENT '价格',
  `room_type` tinyint(2) NOT NULL COMMENT '室内布局',
  `peitao` varchar(32) NOT NULL COMMENT '配套设施',
  `acreage` varchar(128) NOT NULL COMMENT '面积',
  `fitment` tinyint(2) NOT NULL COMMENT '装修情况',
  `floor` varchar(128) NOT NULL COMMENT '所在楼层',
  `station` varchar(128) NOT NULL COMMENT '附近公交站',
  `bus` varchar(128) NOT NULL COMMENT '公交路线',
  `maps` varchar(32) NOT NULL COMMENT '地图位置',
  `telphone` varchar(18) NOT NULL COMMENT '联系电话',
  `my_tenancy` tinyint(2) NOT NULL COMMENT '租期',
  `keywords` varchar(128) NOT NULL COMMENT '标签',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `ext_id` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='出租模型表';


DROP TABLE IF EXISTS `qb_house_content2`;
CREATE TABLE `qb_house_content2` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
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
  `linkman` varchar(80) NOT NULL COMMENT '联系人',
  `sortid` tinyint(2) NOT NULL COMMENT '性质',
  `price` decimal(10,2) NOT NULL COMMENT '价格',
  `room_type` tinyint(2) NOT NULL COMMENT '室内布局',
  `peitao` varchar(32) NOT NULL COMMENT '配套设施',
  `acreage` varchar(128) NOT NULL COMMENT '面积',
  `fitment` tinyint(2) NOT NULL COMMENT '装修情况',
  `floor` varchar(128) NOT NULL COMMENT '所在楼层',
  `station` varchar(128) NOT NULL COMMENT '附近公交站',
  `bus` varchar(128) NOT NULL COMMENT '公交路线',
  `maps` varchar(32) NOT NULL COMMENT '地图位置',
  `telphone` varchar(18) NOT NULL COMMENT '联系电话',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `ext_id` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='出售模型表';


DROP TABLE IF EXISTS `qb_house_content3`;
CREATE TABLE `qb_house_content3` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
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
  `linkman` varchar(80) NOT NULL COMMENT '联系人',
  `maps` varchar(32) NOT NULL COMMENT '地图位置',
  `showday` tinyint(2) NOT NULL COMMENT '有限日期',
  `telphone` varchar(18) NOT NULL COMMENT '联系电话',
  `price` decimal(10,2) NOT NULL COMMENT '期望价格',
  `room_type` tinyint(2) NOT NULL COMMENT '期望布局',
  `acreage` varchar(28) NOT NULL COMMENT '期望面积',
  `fitment` tinyint(1) NOT NULL COMMENT '期望装修情况',
  `floor` varchar(28) NOT NULL COMMENT '期望楼层',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `ext_id` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='求租模型表';


DROP TABLE IF EXISTS `qb_house_content4`;
CREATE TABLE `qb_house_content4` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
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
  `maps` varchar(32) NOT NULL COMMENT '地图位置',
  `showday` tinyint(2) NOT NULL COMMENT '有效日期',
  `linkman` varchar(80) NOT NULL COMMENT '联系人',
  `telphone` varchar(18) NOT NULL COMMENT '联系电话',
  `price` decimal(10,2) NOT NULL COMMENT '期望价格',
  `room_type` tinyint(2) NOT NULL COMMENT '期望布局',
  `acreage` varchar(28) NOT NULL COMMENT '期望面积',
  `fitment` tinyint(2) NOT NULL COMMENT '装修情况',
  `floor` varchar(28) NOT NULL COMMENT '期望楼层',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `ext_id` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='求购模型表';


DROP TABLE IF EXISTS `qb_house_content5`;
CREATE TABLE `qb_house_content5` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
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
  `showday` tinyint(2) NOT NULL COMMENT '有效日期',
  `linkman` varchar(80) NOT NULL COMMENT '联系人',
  `telphone` varchar(18) NOT NULL COMMENT '联系电话',
  `seller` varchar(128) NOT NULL COMMENT '开发商',
  `address` varchar(128) NOT NULL COMMENT '地址',
  `star_sell` int(11) unsigned NOT NULL COMMENT '开盘时间',
  `price` decimal(10,2) NOT NULL COMMENT '楼盘均价',
  `bus` varchar(128) NOT NULL COMMENT '周边交通',
  `out_peitao` varchar(32) NOT NULL COMMENT '周边配套',
  `in_peitao` text NOT NULL COMMENT '小区配套',
  `videourl` varchar(128) NOT NULL COMMENT '楼盘视频',
  `house_num` varchar(128) NOT NULL COMMENT '楼盘形态与栋数',
  `total_area` varchar(28) NOT NULL COMMENT '总占地面积',
  `room_area` varchar(28) NOT NULL COMMENT '总建筑面积',
  `roomtype` varchar(32) NOT NULL COMMENT '楼盘类型',
  `fitment` tinyint(1) NOT NULL COMMENT '装修情况',
  `property_company` varchar(128) NOT NULL COMMENT '物业公司',
  `property_management_fee` decimal(10,2) NOT NULL COMMENT '物业管理费',
  `green_rate` varchar(28) NOT NULL COMMENT '绿化率',
  `parking_space_amount` mediumint(5) NOT NULL COMMENT '车位数',
  `sales_telephone` varchar(18) NOT NULL COMMENT '售楼电话',
  `sell_address` varchar(128) NOT NULL COMMENT '售楼处地址',
  `sales_status` tinyint(2) NOT NULL COMMENT '销售状态',
  `maps` varchar(32) NOT NULL COMMENT '地图位置',
  `keywords` varchar(255) NOT NULL COMMENT '标签',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `ext_id` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='楼盘模型表';


DROP TABLE IF EXISTS `qb_house_content6`;
CREATE TABLE `qb_house_content6` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '姓名',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
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
  `showday` varchar(32) NOT NULL COMMENT '有效日期',
  `telphone` varchar(18) NOT NULL COMMENT '联系电话',
  `fuwu_zone` varchar(32) NOT NULL COMMENT '服务区域',
  `store` tinyint(2) NOT NULL COMMENT '所属面店',
  `imgs` varchar(128) NOT NULL COMMENT '相关图片',
  `working_experience` tinyint(32) NOT NULL COMMENT '从业经验',
  `keywords` varchar(255) NOT NULL COMMENT '标签',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `ext_id` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='中介模型表';


DROP TABLE IF EXISTS `qb_house_field`;
CREATE TABLE `qb_house_field` (
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
  `input_width` varchar(7) NOT NULL COMMENT '输入表单宽度',
  `input_height` varchar(7) NOT NULL COMMENT '输入表单高度',
  `unit` varchar(20) NOT NULL COMMENT '单位名称',
  `match` varchar(150) NOT NULL COMMENT '表单正则匹配',
  `css` varchar(20) NOT NULL COMMENT '表单CSS类名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=155 DEFAULT CHARSET=utf8 COMMENT='文档字段表';

INSERT INTO `qb_house_field` VALUES ('93','telphone','联系电话','text','varchar(18) NOT NULL','','','','1','2','','','','','','2','','','','97','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('92','maps','地图位置','bmap','varchar(32) NOT NULL','','','','1','2','','','','','','2','','','','98','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('90','station','附近公交站','text','varchar(128) NOT NULL','','','','1','2','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('89','floor','所在楼层','text','varchar(128) NOT NULL','','','','1','2','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('87','acreage','面积','text','varchar(128) NOT NULL','0','','','1','2','','','','','','2','','','','0','0','0','0','','','','平方米','','');
INSERT INTO `qb_house_field` VALUES ('88','fitment','装修情况','radio','tinyint(2) NOT NULL','1','1|普通装修\r\n2|精装修\r\n3|豪华装修\r\n4|毛坯房','','1','2','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('91','bus','公交路线','text','varchar(128) NOT NULL','','','','1','2','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('86','peitao','配套设施','checkbox','varchar(32) NOT NULL','0','1|水\r\n2|电\r\n3|电话\r\n4|宽带\r\n5|管道煤气\r\n6|电梯\r\n7|家具','','1','2','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('84','price','价格','text','decimal(10,2) NOT NULL','0.00','','','1','2','','','','','','2','','','','0','0','0','0','','','','万元','','');
INSERT INTO `qb_house_field` VALUES ('85','room_type','室内布局','select','tinyint(32) NOT NULL','0','1|两室一厅\r\n2|两室两厅\r\n3|三室一厅\r\n4|三室两厅\r\n5|一室一厅\r\n6|一居室\r\n7|三室以上\r\n8|别墅','','1','2','','','','','','2','','','','0','0','1','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('83','sortid','性质','radio','tinyint(2) NOT NULL','0','1|中介\r\n2|个人','','1','2','','','','','','2','','','','0','1','1','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('65','title','信息标题','text','varchar(256) NOT NULL','','','','1','1','','','','','','2','','','','100','1','1','1','','','','','','');
INSERT INTO `qb_house_field` VALUES ('66','picurl','介绍图片','images','text NOT NULL','','','','1','1','','','','','','2','','','','99','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('67','content','详情','ueditor','text NOT NULL','','','','1','1','','','','','','2','','','','-1','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('68','sortid','性质','radio','tinyint(2) NOT NULL','0','1|中介\r\n2|个人','','1','1','','','','','','2','','','','0','1','1','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('69','price','价格','text','decimal(10,2) NOT NULL','0.00','','','1','1','','','','','','2','','','','0','0','0','0','','','','元/月','','');
INSERT INTO `qb_house_field` VALUES ('70','room_type','室内布局','select','tinyint(2) NOT NULL','0','1|两室一厅\r\n2|两室两厅\r\n3|三室一厅\r\n4|三室两厅\r\n5|一室一厅\r\n6|一居室\r\n7|三室以上\r\n8|别墅','','1','1','','','','','','2','','','','0','0','1','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('71','peitao','配套设施','checkbox','varchar(32) NOT NULL','0','1|水\r\n2|电\r\n3|电话\r\n4|宽带\r\n5|管道煤气\r\n6|电梯\r\n7|家具','','1','1','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('72','acreage','面积','text','varchar(128) NOT NULL','0','','','1','1','','','','','','2','','','','0','0','0','0','','','','平方米','','');
INSERT INTO `qb_house_field` VALUES ('73','fitment','装修情况','radio','tinyint(2) NOT NULL','1','1|普通装修\r\n2|精装修\r\n3|豪华装修\r\n4|毛坯房','','1','1','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('74','floor','所在楼层','text','varchar(128) NOT NULL','','','','1','1','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('75','station','附近公交站','text','varchar(128) NOT NULL','','','','1','1','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('76','bus','公交路线','text','varchar(128) NOT NULL','','','','1','1','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('77','maps','地图位置','bmap','varchar(32) NOT NULL','','','','1','1','','','','','','2','','','','98','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('78','telphone','联系电话','text','varchar(18) NOT NULL','','','','1','1','','','','','','2','','','','97','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('79','my_tenancy','租期','radio','tinyint(2) NOT NULL','2','1|3个月\r\n2|6个月\r\n3|16个月','','1','1','','','','','','2','','','','0','0','1','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('80','title','信息标题','text','varchar(256) NOT NULL','','','','1','2','','','','','','2','','','','100','1','1','1','','','','','','');
INSERT INTO `qb_house_field` VALUES ('81','picurl','组图','images','text NOT NULL',NULL,NULL,'','1','2','','','','','','2','','','','99','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('82','content','详情','ueditor','text NOT NULL','','','','1','2','','','','','','2','','','','-1','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('95','title','信息标题','text','varchar(256) NOT NULL','','','','1','3','','','','','','2','','','','100','1','1','1','','','','','','');
INSERT INTO `qb_house_field` VALUES ('96','picurl','介绍图片','images','text NOT NULL','','','','1','3','','','','','','2','','','','99','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('97','content','要求简述','ueditor','text NOT NULL','','','如对小区、楼层、位置、总价、租金、装修、朝向等方面的要求','1','3','','','','','','2','','','','-1','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('98','maps','地图位置','bmap','varchar(32) NOT NULL','','','','1','3','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('99','showday','有效日期','select','tinyint(2) NOT NULL','','1|90天\r\n2|60天\r\n3|30天','','1','3','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('100','telphone','联系电话','text','varchar(18) NOT NULL','','','','1','3','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('101','price','期望价格','text','decimal(10,2) NOT NULL','','','','1','3','','','','','','2','','','','0','0','0','0','','','','元/月','','');
INSERT INTO `qb_house_field` VALUES ('102','room_type','期望布局','select','tinyint(2) NOT NULL','','1|两室一厅\r\n2|两室两厅\r\n3|三室一厅\r\n4|三室两厅\r\n5|一室一厅\r\n6|一居室\r\n7|三室以上\r\n8|别墅','','1','3','','','','','','2','','','','0','0','1','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('103','acreage','期望面积','text','varchar(28) NOT NULL','','','','1','3','','','','','','2','','','','0','0','0','0','','','','平方米','','');
INSERT INTO `qb_house_field` VALUES ('104','fitment','期望装修情况','radio','tinyint(1) NOT NULL','','1|普通装修\r\n2|精装修\r\n3|豪华装修','','1','3','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('105','floor','期望楼层','text','varchar(28) NOT NULL','','','','1','3','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('106','title','信息标题','text','varchar(256) NOT NULL','','','','1','4','','','','','','2','','','','100','1','1','1','','','','','','');
INSERT INTO `qb_house_field` VALUES ('107','picurl','介绍图片','images','text NOT NULL','','','','1','4','','','','','','2','','','','99','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('108','content','要求简述','ueditor','text NOT NULL','','','','1','4','','','','','','2','','','','-1','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('109','maps','地图位置','bmap','varchar(32) NOT NULL','','','','1','4','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('110','showday','有效日期','select','tinyint(2) NOT NULL','','1|90天\r\n2|60天\r\n3|30天','','1','4','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('111','telphone','联系电话','text','varchar(18) NOT NULL','','','','1','4','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('112','price','期望价格','text','decimal(10,2) NOT NULL','','','','1','4','','','','','','2','','','','0','0','0','0','','','','万元','','');
INSERT INTO `qb_house_field` VALUES ('113','room_type','期望布局','select','tinyint(2) NOT NULL','','1|两室一厅\r\n2|两室两厅\r\n3|三室一厅\r\n4|三室两厅\r\n5|一室一厅\r\n6|一居室\r\n7|三室以上\r\n8|别墅','','1','4','','','','','','2','','','','0','0','1','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('114','acreage','期望面积','text','varchar(28) NOT NULL','','','','1','4','','','','','','2','','','','0','0','0','0','','','','平方米','','');
INSERT INTO `qb_house_field` VALUES ('115','fitment','期望装修情况','radio','tinyint(2) NOT NULL','1','1|普通装修\r\n2|精装修\r\n3|豪华装修\r\n4|毛坯房','','1','4','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('116','floor','期望楼层','text','varchar(28) NOT NULL','','','','1','4','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('117','title','信息标题','text','varchar(256) NOT NULL','','','','1','5','','','','','','2','','','','100','1','1','1','','','','','','');
INSERT INTO `qb_house_field` VALUES ('118','picurl','介绍图片','images','text NOT NULL','','','','1','5','','','','','','2','','','','99','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('119','content','楼盘介绍','ueditor','text NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('120','showday','有效日期','select','tinyint(2) NOT NULL','','1|90\r\n2|60\r\n3|30','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('121','telphone','联系电话','text','varchar(18) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('122','seller','开发商','text','varchar(128) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('123','address','地址','text','varchar(128) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('124','star_sell','开盘时间','date','int(11) UNSIGNED NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('125','price','楼盘均价','text','decimal(10,2) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','元/平方米','','');
INSERT INTO `qb_house_field` VALUES ('126','bus','周边交通','text','varchar(128) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('127','out_peitao','周边配套','checkbox','varchar(32) NOT NULL','','1|学校   \r\n2|购物   \r\n3|医院   \r\n4|银行   \r\n5|餐饮   \r\n6|其它','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('128','in_peitao','小区配套','textarea','text NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('129','videourl','楼盘视频','text','varchar(128) NOT NULL','','','请填写通用代码的播放网址','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('130','house_num','楼盘形态与栋数','text','varchar(128) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('131','total_area','总占地面积','text','varchar(28) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','平方米','','');
INSERT INTO `qb_house_field` VALUES ('132','room_area','总建筑面积','text','varchar(28) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','平方米','','');
INSERT INTO `qb_house_field` VALUES ('133','roomtype','楼盘类型','checkbox','varchar(32) NOT NULL','','1|洋房\r\n2|公寓\r\n3|别墅','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('134','fitment','装修情况','radio','tinyint(1) NOT NULL','','1|毛坯\r\n2|简装\r\n3|豪装','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('135','property_company','物业公司','text','varchar(128) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('136','property_management_fee','物业管理费','text','decimal(10,2) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('137','green_rate','绿化率','text','varchar(28) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('138','parking_space_amount','车位数','text','mediumint(5) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('139','sales_telephone','售楼电话','text','varchar(18) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('140','sell_address','售楼处地址','text','varchar(128) NOT NULL','','','','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('141','sales_status','销售状态','select','tinyint(2) NOT NULL','1','1|在售\r\n2|待售\r\n3|售罄','','1','5','','','','','','2','','','','0','0','1','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('142','maps','地图位置','bmap','varchar(32) NOT NULL','','','','1','5','','','','','','2','','','','98','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('143','title','姓名','text','varchar(256) NOT NULL','','','','1','6','','','','','','2','','','','100','1','1','1','','','','','','');
INSERT INTO `qb_house_field` VALUES ('144','picurl','头像','image','text NOT NULL','','','','1','6','','','','','','2','','','','99','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('145','content','个人介绍','ueditor','text NOT NULL','','','','1','6','','','','','','2','','','','-1','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('146','showday','有效日期','select','varchar(32) NOT NULL','1','1|不限\r\n2|90天\r\n3|60天\r\n4|30天','','1','6','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('147','telphone','联系电话','text','varchar(18) NOT NULL','','','','1','6','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('148','fuwu_zone','服务区域','checkbox','varchar(32) NOT NULL','','1|市中心\r\n2|城郊\r\n3|所有街道','','1','6','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('149','store','所属面店','select','tinyint(2) NOT NULL','','1|满堂红\r\n2|美之居\r\n3|中原地产\r\n4|我爱我家\r\n5|其它','','1','6','','','','','','2','','','','0','0','1','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('150','imgs','相关图片','images','varchar(128) NOT NULL','','','','1','6','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('151','working_experience','从业经验','radio','tinyint(32) NOT NULL','','1|一年\r\n2|两年\r\n3|三年\r\n4|四年以上','','1','6','','','','','','2','','','','0','0','1','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('152','keywords','标签','text','varchar(128) NOT NULL','','','多个用空格隔开','1','1','','','','','','2','','','','96','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('153','keywords','标签','text','varchar(255) NOT NULL','','','多个用空格隔开','1','5','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('154','keywords','标签','text','varchar(255) NOT NULL','','','多个用空格隔开','1','6','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_house_field` VALUES ('155', 'linkman', '联系人', 'text', 'varchar(80) NOT NULL', '', '', '', '1', '1', '', '', '', '', '', '2', '', '', '', '97', '0', '0', '0', '', '', '', '', '', '');
INSERT INTO `qb_house_field` VALUES ('156', 'linkman', '联系人', 'text', 'varchar(80) NOT NULL', '', '', '', '1', '2', '', '', '', '', '', '2', '', '', '', '97', '0', '0', '0', '', '', '', '', '', '');
INSERT INTO `qb_house_field` VALUES ('157', 'linkman', '联系人', 'text', 'varchar(80) NOT NULL', '', '', '', '1', '3', '', '', '', '', '', '2', '', '', '', '97', '0', '0', '0', '', '', '', '', '', '');
INSERT INTO `qb_house_field` VALUES ('158', 'linkman', '联系人', 'text', 'varchar(80) NOT NULL', '', '', '', '1', '4', '', '', '', '', '', '2', '', '', '', '97', '0', '0', '0', '', '', '', '', '', '');
INSERT INTO `qb_house_field` VALUES ('159', 'linkman', '联系人', 'text', 'varchar(80) NOT NULL', '', '', '', '1', '5', '', '', '', '', '', '2', '', '', '', '97', '0', '0', '0', '', '', '', '', '', '');

DROP TABLE IF EXISTS `qb_house_module`;
CREATE TABLE `qb_house_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) NOT NULL DEFAULT '' COMMENT '区分符关键字',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模型标题',
  `layout` varchar(50) NOT NULL COMMENT '模板路径',
  `icon` varchar(64) NOT NULL,
  `list` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='模型表';


INSERT INTO `qb_house_module` VALUES ('4','','求购','','','100','1528356853','0');
INSERT INTO `qb_house_module` VALUES ('3','','求租','','','100','1528353527','0');
INSERT INTO `qb_house_module` VALUES ('1','','出租','','','100','1528187470','0');
INSERT INTO `qb_house_module` VALUES ('2','','出售','','','100','1528343499','0');
INSERT INTO `qb_house_module` VALUES ('5','','楼盘','','','100','1528357844','0');
INSERT INTO `qb_house_module` VALUES ('6','','中介','','','100','1528362109','0');


DROP TABLE IF EXISTS `qb_house_sort`;
CREATE TABLE `qb_house_sort` (
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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='主栏目表';

INSERT INTO `qb_house_sort` VALUES ('8','0','3','求租','4','','','','','','','');
INSERT INTO `qb_house_sort` VALUES ('7','0','2','出售','5','','','','','','','');
INSERT INTO `qb_house_sort` VALUES ('10','0','5','楼盘','2','','','','','','','');
INSERT INTO `qb_house_sort` VALUES ('9','0','4','求购','3','','','','','','','');
INSERT INTO `qb_house_sort` VALUES ('6','0','1','出租','6','','','','','','','');
INSERT INTO `qb_house_sort` VALUES ('11','0','6','中介','0','','','','','','','');


