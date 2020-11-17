INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, 'SEO标题', 'mseo_title', '', 'text', '', 0, '', '', 100, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, 'SEO优化关键字keywords', 'mseo_keyword', '', 'text', '', 0, '', '', 99, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, 'SEO优化描述description', 'mseo_description', '', 'text', '', 0, '', '', 98, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '是否开启当前模块', 'is_open_modlue', '1', 'radio', '1|开启\r\n0|关闭', 0, '', '', 97, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '允许创建工单模板的用户组', 'can_post_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 96, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '创建工单板自动通过审核的用户组', 'post_auto_pass_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 95, 4);

INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`, `version`, `version_id`) VALUES(0, 'comment_add_end', '', 'app\\gongdan\\index\\Hook', '工单回复通知', 1, 0, '', '', '', 0);


DROP TABLE IF EXISTS `qb_gongdan_car`;
CREATE TABLE IF NOT EXISTS `qb_gongdan_car` (
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
) ENGINE=MEMORY  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='购物车' AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_gongdan_cnt`
--

DROP TABLE IF EXISTS `qb_gongdan_cnt`;
CREATE TABLE IF NOT EXISTS `qb_gongdan_cnt` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '内容ID',
  `orderid` int(7) NOT NULL COMMENT '订单ID',
  `name` varchar(40) NOT NULL COMMENT '字段名',
  `about` varchar(40) NOT NULL COMMENT '仅存放select,radio,checkbox字段的内容',
  `content` text NOT NULL COMMENT '存放select,radio,checkbox之外的内容',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `name` (`name`),
  KEY `orderid` (`orderid`),
  KEY `about` (`about`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='供搜索使用的' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_gongdan_content`
--

DROP TABLE IF EXISTS `qb_gongdan_content`;
CREATE TABLE IF NOT EXISTS `qb_gongdan_content` (
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
  `title` varchar(255) NOT NULL COMMENT '标题',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ext_id` (`ext_id`,`ext_sys`),
  KEY `fid` (`fid`),
  KEY `create_time` (`create_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容索引表' AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_gongdan_content1`
--

DROP TABLE IF EXISTS `qb_gongdan_content1`;
CREATE TABLE IF NOT EXISTS `qb_gongdan_content1` (
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
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段,关联的系统',
  `ext_id` int(8) NOT NULL COMMENT '扩展字段,供其它调用',
  `begin_time` int(10) NOT NULL DEFAULT '0' COMMENT '报名开始时间',
  `end_time` int(10) NOT NULL DEFAULT '0' COMMENT '报名结束时间',
  `order_num` mediumint(6) NOT NULL COMMENT '预订数量,不一定付款',
  `map_x` double NOT NULL COMMENT '坐标经度',
  `map_y` double NOT NULL COMMENT '坐标纬度',
  `order_filed` text NOT NULL COMMENT '用户报名表单选项',
  `onlybuyone` tinyint(3) NOT NULL DEFAULT '0' COMMENT '允许提交几份',
  `status_type` varchar(255) NOT NULL COMMENT '工单流程状态',
  `notice_group` varchar(255) NOT NULL COMMENT '接收新工单提醒的用户组',
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
  KEY `map_x` (`map_x`),
  KEY `map_y` (`map_y`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_gongdan_field`
--

DROP TABLE IF EXISTS `qb_gongdan_field`;
CREATE TABLE IF NOT EXISTS `qb_gongdan_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '字段名称',
  `name` varchar(32) NOT NULL,
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '字段标题',
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
  `script` text NOT NULL COMMENT 'JS脚本',
  `trigger` varchar(255) NOT NULL COMMENT '选择某一项后,联动触发显示其它字段',
  `range_opt` text NOT NULL COMMENT '范围选择,比如价格范围',
  `group_view` varchar(255) NOT NULL COMMENT '允许哪些用户组查看',
  `index_hide` tinyint(1) NOT NULL COMMENT '是否前台不显示并不做转义处理',
  `group_post` varchar(255) NOT NULL COMMENT '允许使用此字段的用户组',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文档字段表' AUTO_INCREMENT=68 ;

--
-- 转存表中的数据 `qb_gongdan_field`
--

INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(10, 'title', '工单模板名称', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 300, 1, 1, 1, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(11, 'picurl', '封面图', 'images', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 198, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(12, 'content', '注意事项', 'ueditor', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(67, 'notice_group', '接收新工单提醒的用户组', 'qun_group_array', 'varchar(255) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');
INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(51, 'linkman', '联系人', 'text', 'varchar(128) NOT NULL', '', '', '', 1, -1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(52, 'telphone', '联系电话', 'text', 'varchar(128) NOT NULL', '', '', '', 1, -1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 1, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(53, 'address', '联系地址', 'text', 'varchar(128) NOT NULL', '', '', '', 1, -1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(54, 'user_note', '用户备注', 'text', 'varchar(255) NOT NULL', '', '', '', 1, -1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(55, 'begin_time', '开始时间', 'hidden', 'int(10) NOT NULL DEFAULT ''0''', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 190, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');
INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(56, 'end_time', '结束时间', 'datetime', 'int(10) NOT NULL DEFAULT ''0''', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 180, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(59, 'order_filed', '用户填写表单字段', 'textarea', 'text NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 199, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');
INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(66, 'status_type', '工单流程状态', 'qun_group_array2', 'varchar(255) NOT NULL', '', '', '第一项是流程状态,比如一审、二审、同意、拒绝等等，第二项是有权限设置该状态的用户组，第三项设置该状态后要通知哪些用户组', 1, 1, '', '', '', '', '', 2, '', '', '', 200, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');
INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(65, 'onlybuyone', '允许提交几份', 'number', 'tinyint(3) NOT NULL DEFAULT ''0''', '0', '', '0的话,即不限制', 1, 1, '', '', '', '', '', 2, '', '', '', 100, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_gongdan_module`
--

DROP TABLE IF EXISTS `qb_gongdan_module`;
CREATE TABLE IF NOT EXISTS `qb_gongdan_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) NOT NULL DEFAULT '' COMMENT '区分符关键字',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模型标题',
  `layout` varchar(50) NOT NULL COMMENT '模板路径',
  `icon` varchar(64) NOT NULL,
  `list` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `haibao` varchar(255) NOT NULL COMMENT '海报模板',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='模型表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `qb_gongdan_module`
--

INSERT INTO `qb_gongdan_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`, `haibao`) VALUES(1, '', '通用工单', '', '', 100, 1515221331, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_gongdan_order`
--

DROP TABLE IF EXISTS `qb_gongdan_order`;
CREATE TABLE IF NOT EXISTS `qb_gongdan_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `mid` mediumint(5) NOT NULL DEFAULT '-1' COMMENT '模型ID,只能是负数,避免跟主题相冲突',
  `order_sn` varchar(20) NOT NULL DEFAULT '' COMMENT '订单编号',
  `shop` varchar(255) NOT NULL COMMENT '购买的商品,存放格式如下:shopid-num-type1-type2-type3 商品ID,购买数量,商品属性1、2、3,多个商品用,号隔开',
  `shopid` int(7) NOT NULL COMMENT '购买单个的商品ID',
  `shopnum` mediumint(5) NOT NULL COMMENT '购买单个的商品数量',
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
  `shipping_time` int(11) DEFAULT '0' COMMENT '发货时间',
  `receive_time` int(10) DEFAULT '0' COMMENT '收货时间',
  `receive_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '收货状态',
  `shipping_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '发货状态',
  `shipping_name` varchar(120) NOT NULL DEFAULT '' COMMENT '物流名称',
  `shipping_code` varchar(32) NOT NULL DEFAULT '' COMMENT '物流单号',
  `admin_note` varchar(255) DEFAULT '' COMMENT '管理员备注',
  `linkman` varchar(60) NOT NULL DEFAULT '' COMMENT '联系人',
  `telphone` varchar(60) NOT NULL DEFAULT '' COMMENT '手机',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货地址',
  `user_note` varchar(255) NOT NULL COMMENT '用户备注',
  `order_field` text NOT NULL COMMENT '用户自定义字段存放的内容',
  `status` tinyint(2) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `create_time` (`create_time`),
  KEY `uid` (`uid`),
  KEY `order_sn` (`order_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品订单' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_gongdan_sort`
--

DROP TABLE IF EXISTS `qb_gongdan_sort`;
CREATE TABLE IF NOT EXISTS `qb_gongdan_sort` (
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
  `allow_viewtitle` varchar(255) NOT NULL COMMENT '允许查看标题的用户组',
  `order_filed` text NOT NULL COMMENT '默认表单字段',
  `status_type` varchar(256) NOT NULL COMMENT '工单流程状态',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `pid` (`pid`),
  KEY `list` (`list`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='主栏目表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `qb_gongdan_sort`
--

INSERT INTO `qb_gongdan_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`, `allow_viewtitle`, `order_filed`, `status_type`) VALUES(1, 0, 1, '问题反馈', 0, '', '', '', '', '', '', '', '', '[{"title":"问题级别","type":"radio","options":"一般\\n紧急","must":"1","listshow":1},{"title":"问题描述","type":"textarea","options":"","must":"1","listshow":0},{"title":"你的电话","type":"text","options":"","must":"0","listshow":1}]', '["上报高层处理||","已处理||","无法处理||"]');
INSERT INTO `qb_gongdan_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`, `allow_viewtitle`, `order_filed`, `status_type`) VALUES(2, 0, 1, '员工资料', 0, '', '', '', '', '', '', '', '', '[{"title":"姓名","type":"text","options":"","must":"0","listshow":1},{"title":"性别","type":"radio","options":"男\\n女","must":"1","listshow":1},{"title":"年龄","type":"text","options":"","must":"0","listshow":1},{"title":"学历","type":"text","options":"","must":"0","listshow":1},{"title":"电话","type":"number","options":"","must":"0","listshow":1}]', '["已归档||","无效||"]');
INSERT INTO `qb_gongdan_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`, `allow_viewtitle`, `order_filed`, `status_type`) VALUES(3, 0, 1, '请假申请', 0, '', '', '', '', '', '', '', '', '[{"title":"是抵扣年假","type":"radio","options":"抵扣\\n不抵扣","must":"0","listshow":1},{"title":"请假开始日期","type":"date","options":"","must":"1","listshow":1},{"title":"请假结束日期","type":"date","options":"","must":"1","listshow":1}]', '["组长同意||","厂长同意||","老板同意||","拒绝||"]');



INSERT INTO `qb_gongdan_content` (`id`, `mid`, `fid`, `uid`, `view`, `status`, `list`, `create_time`, `ext_id`, `ext_sys`, `title`) VALUES(1, 1, 1, 1, 30, 1, 1603671911, 1603671911, 0, 3, '无聊及广告与非法贴子举报');



INSERT INTO `qb_gongdan_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `ext_sys`, `ext_id`, `begin_time`, `end_time`, `order_num`, `map_x`, `map_y`, `order_filed`, `onlybuyone`, `status_type`, `notice_group`) VALUES(1, 1, 1, '无聊及广告与非法贴子举报', 1, 1, 30, 1, 0, 1603671911, 1603692669, 1603671911, 'https://x1.f2.qibosoft.com/public/uploads/images/20201026/1_2020102609374159f49.jpg', '<p>欢迎大家如实举报，举报属实有效的，会有积分奖励！</p><p>恶意举报会扣除积分。</p>', 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, '[{"title":"举报性质","type":"radio","options":"广告贴\\n反动言论\\n色情相关\\n无聊贴\\n其它","must":"1","listshow":1},{"title":"内容标题","type":"text","options":"","must":"0","listshow":1},{"title":"举报网址","type":"text","options":"","must":"1","listshow":1},{"title":"内容截图","type":"images","options":"","must":"0","listshow":0},{"title":"举报附注","type":"textarea","options":"","must":"0","listshow":0}]', 0, '["举报属实|3|","举报无效|3,2|","虚假举报|3,2|","转发超管审核|2|3"]', '2');

ALTER TABLE  `qb_gongdan_order` ADD  `pingfen` INT( 2 ) NOT NULL COMMENT  '满意度评分';

ALTER TABLE  `qb_gongdan_order` ADD  `robuid` INT( 7 ) NOT NULL COMMENT  '确认抢单者UID',ADD  `roblist` VARCHAR( 150 ) NOT NULL COMMENT  '抢单者候选列表,多个UID用逗号隔开';
ALTER TABLE  `qb_gongdan_order` ADD INDEX (  `shop_uid` );
ALTER TABLE  `qb_gongdan_order` ADD INDEX (  `robuid` );
ALTER TABLE  `qb_gongdan_order` ADD INDEX (  `shopid` );
ALTER TABLE  `qb_gongdan_order` ADD INDEX (  `status` );

INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(0, 'robtype', '抢单模式', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '', '0|关闭抢单\r\n1|抢单不需确认\r\n2|抢单需客户确认', '推送抢单通知只限于接收新工单提醒的用户组', 1, 1, '', '', '', '', '', 2, '', '', '', 1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');


ALTER TABLE  `qb_gongdan_content1` ADD  `robtype` TINYINT( 1 ) NOT NULL COMMENT  '抢单模式';
