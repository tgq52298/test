INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','SEO标题','mseo_title','','text','','0','','','100','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','SEO优化关键字keywords','mseo_keyword','','text','','0','','','99','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','SEO优化描述description','mseo_description','','text','','0','','','98','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','是否开启当前模块','is_open_modlue','1','radio','1|开启\n0|关闭','0','','','97','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','允许发布商家信息的用户组','can_post_group','','checkbox','app\\common\\model\\Group@getTitleList@[{\"id\":[\"<>\",2]}]','0','','','96','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','发布商家信息自动通过审核的用户组','post_auto_pass_group','','checkbox','app\\common\\model\\Group@getTitleList@[{\"id\":[\"<>\",2]}]','0','','','95','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','客户预约是否短消息通知商家','post_order_msg_hy','1','radio','1|通知\n0|不通知','0','','','93','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','客户预约是否短信通知商家','post_order_sms_hy','0','radio','1|通知\n0|不通知','0','','','92','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','客户预约是否微信通知商家','post_order_wx_hy','0','radio','1|通知\r\n0|不通知','0','','','91','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','客户取消预约是否微信通知商家','cancel_order_wx_hy','0','radio','1|通知\r\n0|不通知','0','','','88','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','客户取消预约是否短消息通知商家','cancel_order_msg_hy','1','radio','1|通知\r\n0|不通知','0','','','90','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','客户取消预约是否短信通知商家','cancel_order_sms_hy','0','radio','1|通知\r\n0|不通知','0','','','89','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','商家确认预约是否短消息通知用户','affirm_order_msg_hy','1','radio','1|通知\r\n0|不通知','0','','','0','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','商家确认预约是否短信通知用户','affirm_order_sms_hy','0','radio','1|通知\r\n0|不通知','0','','','0','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','商家确认预约是否微信通知用户','affirm_order_wx_hy','0','radio','1|通知\r\n0|不通知','0','','','0','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','客户预约是否邮件通知商家','post_order_email_hy','0','radio','1|通知\r\n0|不通知','0','','','91','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','客户取消预约是否邮件通知商家','cancel_order_email_hy','0','radio','1|通知\r\n0|不通知','0','','','88','18');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('','-1','商家确认预约是否邮件通知用户','affirm_order_email_hy','0','radio','1|通知\r\n0|不通知','0','','','0','18');



DROP TABLE IF EXISTS `qb_bespeak_car`;
CREATE TABLE `qb_bespeak_car` (
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='购物车';


-- --------------------------------------------------------

--
-- 表的结构 `qb_bespeak_content`
--

DROP TABLE IF EXISTS `qb_bespeak_content`;
CREATE TABLE `qb_bespeak_content` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `uid` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='内容索引表';


-- --------------------------------------------------------

--
-- 表的结构 `qb_bespeak_content1`
--

DROP TABLE IF EXISTS `qb_bespeak_content1`;
CREATE TABLE `qb_bespeak_content1` (
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
  `price` varchar(255) NOT NULL COMMENT '收费标准',
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段,关联的系统',
  `linkman` varchar(255) NOT NULL COMMENT '联系人',
  `telphone` varchar(12) NOT NULL COMMENT '联系电话',
  `service_time` varchar(55) NOT NULL COMMENT '服务时间',
  `limit_persons` mediumint(6) NOT NULL COMMENT '每天预约人数,0或空则不限制',
  `ext_id` int(8) NOT NULL COMMENT '扩展字段,供其它调用',
  `map` varchar(32) NOT NULL COMMENT '地图位置',
  `map_x` double NOT NULL COMMENT '地图经度',
  `map_y` double NOT NULL COMMENT '地图纬度',
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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='商品内容表';


-- --------------------------------------------------------

--
-- 表的结构 `qb_bespeak_field`
--

DROP TABLE IF EXISTS `qb_bespeak_field`;
CREATE TABLE `qb_bespeak_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '字段名称',
  `name` varchar(32) NOT NULL,
  `title` varchar(60) NOT NULL DEFAULT '' COMMENT '字段标题',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT '字段类型',
  `field_type` varchar(128) NOT NULL DEFAULT '' COMMENT '字段定义',
  `value` text COMMENT '默认值',
  `options` text COMMENT '额外选项',
  `about` varchar(256) NOT NULL DEFAULT '' COMMENT '提示说明',
  `show` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `mid` mediumint(5) NOT NULL DEFAULT '0' COMMENT '所属模型id',
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
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COMMENT='文档字段表';

--
-- 转存表中的数据 `qb_bespeak_field`
--
INSERT INTO `qb_bespeak_field` VALUES ('10','title','服务名称','text','varchar(256) NOT NULL','','','','0','1','','','','','','2','','','','100','1','1','1','','','','','','');
INSERT INTO `qb_bespeak_field` VALUES ('11','picurl','介绍图','image','text NOT NULL','','','','0','1','','','','','','2','','','','98','0','0','0','','','','','','');
INSERT INTO `qb_bespeak_field` VALUES ('12','content','商家介绍','ueditor','text NOT NULL','','','','0','1','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_bespeak_field` VALUES ('46','price','收费标准','text','varchar(255) NOT NULL','','','','0','1','','','','','','2','','','','99','0','0','0','','','','','','');
INSERT INTO `qb_bespeak_field` VALUES ('47','linkman','联系人','text','varchar(255) NOT NULL','','','','0','1','','','','','','2','','','','97','0','0','0','','','','','','');
INSERT INTO `qb_bespeak_field` VALUES ('48','telphone','联系电话','text','varchar(12) NOT NULL','','','','0','1','','','','','','2','','','','96','0','0','0','','','','','','');
INSERT INTO `qb_bespeak_field` VALUES ('49','limit_persons','每天预约人数','text','mediumint(6) NOT NULL','','','','0','1','','','','','','2','','','','96','0','0','0','','','','','','');

INSERT INTO `qb_bespeak_field` VALUES ('50','service_time','服务时间','text','varchar(55) NOT NULL','','','','0','1','','','','','','2','','','','95','0','0','0','','','','','','');
INSERT INTO `qb_bespeak_field` VALUES ('51','order_linkman','联系人','text','varchar(60) NOT NULL','','','','1','-1','','','','','','2','','','','10','1','1','1','','','','','','');
INSERT INTO `qb_bespeak_field` VALUES ('52','order_telphone','联系电话','text','varchar(60) NOT NULL','','','','1','-1','','','','','','2','','','','8','1','1','1','','','','','','');
INSERT INTO `qb_bespeak_field` VALUES ('53','order_address','服务地址','text','varchar(256) NOT NULL','','','','1','-1','','','','','','2','','','','8','0','0','1','','','','','','');
INSERT INTO `qb_bespeak_field` VALUES ('54','order_user_note','更多需求','text','text NOT NULL','','','','1','-1','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_bespeak_field` VALUES ('56','order_bespeak_time','预约时间','datetime','int(10) NOT NULL','','','','1','-1','','','','','','2','','','','9','0','0','1','','','','','','');
INSERT INTO `qb_bespeak_field` VALUES ('55','map','地图位置','bmap','varchar(32) NOT NULL','','','','1','1','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_bespeak_field` VALUES ('57','ico','栏目图片','image','varchar(128) NOT NULL','','','','1','-2','','','','','','2','','','','0','0','0','0','','','','','','');


-- --------------------------------------------------------

--
-- 表的结构 `qb_bespeak_module`
--

DROP TABLE IF EXISTS `qb_bespeak_module`;
CREATE TABLE `qb_bespeak_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) NOT NULL DEFAULT '' COMMENT '区分符关键字',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模型标题',
  `layout` varchar(50) NOT NULL COMMENT '模板路径',
  `icon` varchar(64) NOT NULL,
  `list` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='模型表';

--
-- 转存表中的数据 `qb_bespeak_module`
--

INSERT INTO `qb_bespeak_module` VALUES ('1','','商家模型','','','100','1515221331','0');
-- --------------------------------------------------------

--
-- 表的结构 `qb_bespeak_order`
--

DROP TABLE IF EXISTS `qb_bespeak_order`;
CREATE TABLE `qb_bespeak_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `mid` tinyint(1) NOT NULL DEFAULT '-1',
  `order_sn` varchar(20) NOT NULL DEFAULT '' COMMENT '订单编号',
  `shop` varchar(255) NOT NULL COMMENT '购买的商品,存放格式如下:shopid-num-type1-type2-type3 商品ID,购买数量,商品属性1、2、3,多个商品用,号隔开',
  `shop_uid` mediumint(7) NOT NULL COMMENT '店主的UID',
  `shopid` mediumint(7) NOT NULL COMMENT '商品ID,扩展使用',
  `shopnum` mediumint(7) NOT NULL COMMENT '购买数量,扩展使用',
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
  `order_linkman` varchar(60) NOT NULL COMMENT '联系人',
  `order_address` varchar(256) NOT NULL COMMENT '服务地址',
  `order_telphone` varchar(60) NOT NULL COMMENT '联系电话',
  `shipping_time` int(11) DEFAULT '0' COMMENT '发货时间',
  `receive_time` int(10) DEFAULT '0' COMMENT '收货时间',
  `receive_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '收货状态',
  `shipping_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '发货状态',
  `shipping_name` varchar(120) NOT NULL DEFAULT '' COMMENT '物流名称',
  `shipping_code` varchar(32) NOT NULL DEFAULT '' COMMENT '物流单号',
  `order_user_note` text NOT NULL COMMENT '更多需求',
  `admin_note` varchar(255) DEFAULT '' COMMENT '管理员备注',
  `order_bespeak_time` int(10) NOT NULL COMMENT '预约时间',
  PRIMARY KEY (`id`),
  KEY `create_time` (`create_time`),
  KEY `uid` (`uid`),
  KEY `order_sn` (`order_sn`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='商品订单';


-- --------------------------------------------------------

--
-- 表的结构 `qb_bespeak_sort`
--

DROP TABLE IF EXISTS `qb_bespeak_sort`;
CREATE TABLE `qb_bespeak_sort` (
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
  `ico` varchar(128) NOT NULL COMMENT '栏目图片',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `pid` (`pid`),
  KEY `list` (`list`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='主栏目表';

--
-- 转存表中的数据 `qb_bespeak_sort`
--

INSERT INTO `qb_bespeak_sort` VALUES ('1','0','1','开锁换锁','0','','','','','','','','static/bespeak/default/demo/sort/1_20180803173446504bc.png');
INSERT INTO `qb_bespeak_sort` VALUES ('2','0','1','保洁服务','0','','','','','','','','static/bespeak/default/demo/sort/1_201808031736555d78d.png');
INSERT INTO `qb_bespeak_sort` VALUES ('3','0','1','家电维修','0','','','','','','','','static/bespeak/default/demo/sort/1_20180803173731fa901.png');
INSERT INTO `qb_bespeak_sort` VALUES ('4','0','1','地板打蜡','0','','','','','','','','static/bespeak/default/demo/sort/1_2018080317391928ab9.png');
INSERT INTO `qb_bespeak_sort` VALUES ('5','0','1','空调移机','0','','','','','','','','static/bespeak/default/demo/sort/1_20180803173943160b5.png');
INSERT INTO `qb_bespeak_sort` VALUES ('6','0','1','上门洗车','0','','','','','','','','static/bespeak/default/demo/sort/1_2018080317400671079.png');
INSERT INTO `qb_bespeak_sort` VALUES ('7','0','1','沙发保养','0','','','','','','','','static/bespeak/default/demo/sort/1_20180803174034a9834.png');
INSERT INTO `qb_bespeak_sort` VALUES ('8','0','1','手机维修','0','','','','','','','','static/bespeak/default/demo/sort/1_2018080317405518bc1.png');
INSERT INTO `qb_bespeak_sort` VALUES ('9','0','1','厨卫保洁','0','','','','','','','','static/bespeak/default/demo/sort/1_20180803174119732f0.png');
INSERT INTO `qb_bespeak_sort` VALUES ('10','0','1','马桶疏通','0','','','','','','','','static/bespeak/default/demo/sort/1_20180803174140a0617.png');
