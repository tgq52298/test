INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO标题', 'mseo_title', '', 'text', '', 0, '', '', 100, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化关键字keywords', 'mseo_keyword', '', 'text', '', 0, '', '', 99, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化描述description', 'mseo_description', '', 'text', '', 0, '', '', 98, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否开启当前模块', 'is_open_modlue', '1', 'radio', '1|开启\r\n0|关闭', 0, '', '', 97, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '允许发布内容的用户组', 'can_post_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 96, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '发布内容自动通过审核的用户组', 'post_auto_pass_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 95, 4);


INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否允许商家私下核销订单', 'force_hexiao', '1', 'radio', '0|禁止\r\n1|允许', 0, '', '允许的话,未经客户展示核销码也可以强制核销客户的订单', 0, 7);




DROP TABLE IF EXISTS `qb_yuyue_car`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_car` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='购物车' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_content`
--

DROP TABLE IF EXISTS `qb_yuyue_content`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_content` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容索引表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_content1`
--

DROP TABLE IF EXISTS `qb_yuyue_content1`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_content1` (
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
  `fewmoney` decimal(10,2) unsigned NOT NULL COMMENT '预交订金',
  `min_user` int(7) NOT NULL DEFAULT '0' COMMENT '组团最低人数',
  `end_time` int(10) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `max_user` int(7) NOT NULL DEFAULT '0' COMMENT '众筹人数上限',
  `fewnum` mediumint(6) unsigned NOT NULL COMMENT '付订金人数',
  `sncode` text NOT NULL COMMENT '序列号(验证码)',
  `fx1` decimal(10,2) NOT NULL COMMENT '分销获利',
  `market_price` decimal(10,2) NOT NULL COMMENT '市场价格',
  `each_money` decimal(10,2) NOT NULL COMMENT '每增加一人减多少元',
  `bottom_price` decimal(10,2) NOT NULL COMMENT '底价',
  `order_num` mediumint(7) NOT NULL COMMENT '下订数量,不确定是否已付款',
  `paytype` tinyint(1) NOT NULL COMMENT '付款方式,0是分期付款,1是一次性付款,2是预约',
  `onlybuyone` mediumint(6) NOT NULL COMMENT '最多允许购买几份,0则不限',
  `fx2` decimal(10,2) unsigned NOT NULL COMMENT '间接分享获利',
  `fx3` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '3级分享获利',
  `map_x` double NOT NULL COMMENT '坐标经度',
  `map_y` double NOT NULL COMMENT '坐标纬度',
  `map` varchar(32) NOT NULL COMMENT '百度地图xy坐标',
  `order_filed` text NOT NULL COMMENT '报名表单项目',
  `order_filed2` text NOT NULL COMMENT '用户报名表单选项',
  `stocktype` tinyint(2) NOT NULL DEFAULT '0' COMMENT '库存统计模式',
  `day_begintime` varchar(8) NOT NULL COMMENT '每天开始订购时间',
  `day_endtime` varchar(8) NOT NULL COMMENT '每天结束订购时间',
  `begin_time` int(10) NOT NULL DEFAULT '0' COMMENT '活动开始时间',
  `price_changetype` tinyint(1) NOT NULL DEFAULT '0' COMMENT '价格变动方式',
  `price_grow` varchar(256) NOT NULL COMMENT '价格递增规则',
  `money_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '消费币种',
  `qun_money` int(7) NOT NULL DEFAULT '0' COMMENT '所需圈币',
  `limit_qungroup` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否仅限圈内会员',
  `order_timedays` tinyint(3) NOT NULL DEFAULT '0' COMMENT '可预约未来几天',
  `stop_yuyue_day` varchar(256) NOT NULL COMMENT '暂停预约的日期',
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品内容表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_field`
--

DROP TABLE IF EXISTS `qb_yuyue_field`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_field` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文档字段表' AUTO_INCREMENT=206 ;

--
-- 转存表中的数据 `qb_yuyue_field`
--

INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(10, 'title', '项目名称', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 200, 1, 1, 1, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(11, 'picurl', '商品介绍图', 'images', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 98, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(12, 'content', '商品介绍', 'ueditor', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(47, 'price', '价格', 'money', 'decimal(10, 2 ) UNSIGNED NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 180, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(48, 'type1', '型号', 'shop_array', 'varchar(255) NOT NULL', '', '', '不同型号可设置不同的价格,比如“大份|15”,价格用竖线隔开', 0, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '商品属性', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(49, 'type2', '尺寸', 'array', 'varchar(255) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '商品属性', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(50, 'type3', '颜色', 'array', 'varchar(255) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '商品属性', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(51, 'fewmoney', '预交订金', 'money', 'decimal(10,2) unsigned NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 170, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(52, 'min_user', '最低成团人数', 'number', 'int(7) NOT NULL DEFAULT ''0''', '1', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 160, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(204, 'end_time', '项目结束日期', 'datetime', 'int(10) NOT NULL DEFAULT ''0''', '', '', '一般留空', 1, 1, '', '', '', '', '', 2, '', '', '', -2, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(54, 'max_user', '库存量', 'number', 'int(7) NOT NULL DEFAULT ''0''', '', '', '0或留空则不限', 1, 1, '', '', '', '', '', 2, '', '', '', 159, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(55, 'linkman', '联系人', 'text', 'varchar(128) NOT NULL', '', '', '', 1, -1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(56, 'telphone', '联系电话', 'text', 'varchar(128) NOT NULL', '', '', '', 1, -1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '/^(13|15|18|17)[0-9]{9}$/', '', '			<script type="text/javascript">\r\n				$(function(){\r\n					var obj = $("#atc_telphone");\r\n					if(obj.val()==""){\r\n						$.get("/index.php/index/wxapp.index/base.html",function(res){\r\n							if(res.code==0){\r\n								var v = res.data.user.mobphone; //可以把mobphone换成其它用户表的字段名\r\n								if(typeof(v)!=''undefined''){\r\n									obj.val(v);\r\n								}\r\n							}\r\n						});\r\n					}	\r\n				})\r\n			</script>', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(57, 'address', '联系地址', 'text', 'varchar(128) NOT NULL', '', '', '', 1, -1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(58, 'user_note', '用户备注', 'hidden', 'varchar(255) NOT NULL', '', '', '', 1, -1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(59, 'fx1', '直接分享获利', 'hidden', 'decimal(10,2) unsigned NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(60, 'market_price', '市场价格', 'hidden', 'decimal(10,2) unsigned NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 181, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(61, 'each_money', '成团后每增加一人减多少元', 'money', 'decimal(10,2) unsigned NOT NULL', '', '', '成团以后,每增加一人将减少多少钱,刚好成团,就不再减少.', 1, 1, '', '', '', '', '', 2, '', '', '', 141, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(62, 'bottom_price', '保底价', 'money', 'decimal(10,2) unsigned NOT NULL', '', '', '增加人数后,最低不能少于这个价格', 1, 1, '', '', '', '', '', 2, '', '', '', 140, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(63, 'paytype', '付款方式', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '0', '0|分期付款(可线下付尾款)|fewmoney\r\n1|一次性线上付全款\r\n2|预约(线上不付款)', '分期付款必须要在线上支付订金,尾款可线上付,也可线下付', 1, 1, '', '', '', '', '', 2, '', '', '', 199, 0, 0, 0, '', '', '', '', '', '', '<script type="text/javascript">\r\n$(function(){\r\nsetTimeout(function(){\r\nvar v=$("#form_group_paytype input[name=paytype]:checked").val();\r\nif(v!=0){$("#form_group_fewmoney").hide()}\r\n},500)\r\n});\r\n</script>', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(64, 'sncode', '序列号(验证码)', 'textarea', 'text NOT NULL', '', '', '每条序列号换一行,用户付款成功后,自动派发 <a href="http://www.qibosoft.com/get_sn.php" target="_blank">点击获取序列号</a>', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(65, 'onlybuyone', '每人最多可订几份', 'number', 'MEDIUMINT(6) NOT NULL', '1', '', '0则不限量', 1, 1, '', '', '', '', '', 2, '', '', '', 97, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(66, 'fx2', '间接分享获利', 'hidden', 'decimal(10,2) unsigned NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(67, 'fx3', '3级分享获利', 'hidden', 'int(7) NOT NULL DEFAULT ''0''', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(70, 'map', '所在位置', 'bmap', 'varchar(32) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '商品属性', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(71, 'order_filed', '报名表单项目', 'hidden', 'text NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '表单项目', '', '', '', '', '', '', '', '', '', 1, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(77, 'day_begintime', '每天开始订购时间', 'hidden', 'varchar(8) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(78, 'day_endtime', '每天结束订购时间', 'hidden', 'varchar(8) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(76, 'stocktype', '库存统计模式', 'hidden', 'tinyint(2) NOT NULL DEFAULT ''0''', '2', '0|按年算|end_time\r\n1|按天算|day_begintime,day_endtime\r\n2|按时间段统计', '', 1, 1, '', '', '', '', '', 2, '', '', '', 200, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(203, 'begin_time', '项目开始日期', 'datetime', 'int(10) NOT NULL DEFAULT ''0''', '', '', '留空或为0即马上开始活动', 1, 1, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(200, 'limit_qungroup', '是否仅限圈内会员', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '0', '0|不限\r\n1|圈内所有会员(不含未审)\r\n4|圈内VIP以上会员', '', 1, 1, '', '', '', '', '', 2, '', '', '', 198, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(201, 'order_timedays', '可预约未来几天', 'number', 'tinyint(3) NOT NULL DEFAULT ''0''', '7', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 2, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(202, 'stop_yuyue_day', '暂停预约日期', 'daytime', 'varchar(255) NOT NULL', '', '', '多个日期,请点击+多一项,格式为2020-05-09，时间段留空则暂停整天的预约', 1, 1, '', '', '', '', '', 2, '', '', '', 1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(205, 'timesort', '时间段分类', 'radio', 'tinyint(2) NOT NULL DEFAULT ''0''', '0', 'app\\yuyue\\model\\Timesort@getsort', '<span onclick="layer.open({type:2,shade:0.3,area:[''90%'',''80%''],content:''/member.php/yuyue/time/index.html'',});">提示:每天可预约的时间段可以灵活修改,<i style="color:red;">点击修改</i></span>', 1, 1, '', '', '', '', '', 2, '', '', '', 144, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(196, 'price_changetype', '价格变动方式', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '0', '0|统一价格\r\n1|按人数变化|each_money,bottom_price\r\n2|按先后变化|price_grow', '递减即随人数增加而降价,递增即越早买就越优惠', 1, 1, '', '', '', '', '', 2, '', '', '', 143, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(197, 'price_grow', '价格优惠规则', 'textarea', 'varchar(255) NOT NULL', '', '', '格式如下<br>1=20<br>2-5=15<br>即代表第1位购买者可优惠10元，第2位到第5位分别可优惠15元，每条规则换一行', 1, 1, '', '', '', '', '', 2, '', '', '', 142, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(198, 'money_type', '消费币种', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '0', '0|人民币|paytype,market_price,price,fewmoney,min_user,max_user,price_changetype,sncode\r\n1|圈币|qun_money,limit_qungroup', '', 1, 1, '', '', '', '', '', 2, '', '', '', 199, 0, 0, 0, '', '', '', '', '', '', ' <!--这里是隐藏圈币的选择,清空的话,就可以设置选择圈币-->\r\n <script type="text/javascript">$(function(){$(''#form_group_money_type'').hide();});</script>', '', '', '', 1, '');
INSERT INTO `qb_yuyue_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(199, 'qun_money', '所需圈币', 'number', 'int(7) NOT NULL DEFAULT ''0''', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 199, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_fx`
--

DROP TABLE IF EXISTS `qb_yuyue_fx`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_fx` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '商品ID',
  `uid` int(7) NOT NULL COMMENT '当前用户UID',
  `introducer_1` int(7) NOT NULL COMMENT '直接推荐人UID',
  `introducer_2` int(7) NOT NULL COMMENT '间接级推荐，用不到，将要弃用',
  `introducer_3` int(7) NOT NULL COMMENT '间接级推荐，用不到，将要弃用',
  `create_time` int(10) NOT NULL COMMENT '推荐时间',
  `ifbuy` tinyint(1) NOT NULL COMMENT '是否成功购买',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `introducer_1` (`introducer_1`),
  KEY `uid` (`uid`),
  KEY `ifbuy` (`ifbuy`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分销用户' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_fxlog`
--

DROP TABLE IF EXISTS `qb_yuyue_fxlog`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_fxlog` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '商品ID',
  `uid` int(7) NOT NULL COMMENT '当前购买商品用户UID',
  `introducer_uid` int(7) NOT NULL COMMENT '推荐人UID',
  `introducer_step` tinyint(1) NOT NULL DEFAULT '1' COMMENT '几级推荐人',
  `create_time` int(10) NOT NULL COMMENT '推荐时间',
  `money` decimal(10,2) NOT NULL COMMENT '获利金额',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `uid` (`uid`),
  KEY `introducer_uid` (`introducer_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分销收益日志' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_hexiao`
--

DROP TABLE IF EXISTS `qb_yuyue_hexiao`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_hexiao` (
  `id` mediumint(7) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(7) NOT NULL COMMENT '商家UID',
  `hxuid` mediumint(7) NOT NULL COMMENT '核销员UID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='有权限核销拼团订单的用户' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_member`
--

DROP TABLE IF EXISTS `qb_yuyue_member`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_member` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '商品ID',
  `uid` int(7) NOT NULL COMMENT '用户UID',
  `money` decimal(10,2) NOT NULL COMMENT '砍价金额或出价金额',
  `create_time` int(10) NOT NULL COMMENT '时间',
  `order_id` int(8) NOT NULL COMMENT '订单ID,秒杀的时候是用户的UID',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1是砍价,2是助威,3是拍卖,4秒杀',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `uid` (`uid`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='参团成员' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_module`
--

DROP TABLE IF EXISTS `qb_yuyue_module`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) NOT NULL DEFAULT '' COMMENT '区分符关键字',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模型标题',
  `layout` varchar(50) NOT NULL COMMENT '模板路径',
  `icon` varchar(64) NOT NULL,
  `list` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `haibao` varchar(255) NOT NULL COMMENT '海报模板路径,多个用逗号隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='模型表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `qb_yuyue_module`
--

INSERT INTO `qb_yuyue_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`, `haibao`) VALUES(1, '', '预约', '', '', 100, 1515221331, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_order`
--

DROP TABLE IF EXISTS `qb_yuyue_order`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `mid` mediumint(5) NOT NULL DEFAULT '-1' COMMENT '模型ID,只能是负数,避免跟主题相冲突',
  `order_sn` varchar(20) NOT NULL DEFAULT '' COMMENT '订单编号',
  `shop` varchar(255) NOT NULL COMMENT '购买的商品,存放格式如下:shopid-num-type1-type2-type3 商品ID,购买数量,商品属性1、2、3,多个商品用,号隔开',
  `shop_uid` mediumint(7) NOT NULL COMMENT '店主的UID',
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '下单客户的uid',
  `totalmoney` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总金额',
  `shipping_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '邮费',
  `pay_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际付款金额',
  `qun_money` mediumint(7) NOT NULL DEFAULT '0' COMMENT '使用圈币',
  `user_jf` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用积分',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `pay_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1已付全款,-1申请退全款',
  `pay_name` varchar(120) NOT NULL DEFAULT '' COMMENT '付款方式',
  `linkman` varchar(60) NOT NULL DEFAULT '' COMMENT '收货人',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货地址',
  `telphone` varchar(60) NOT NULL DEFAULT '' COMMENT '手机',
  `shipping_time` int(11) DEFAULT '0' COMMENT '发货时间',
  `receive_time` int(10) DEFAULT '0' COMMENT '收货时间',
  `receive_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '收货状态',
  `shipping_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发货状态',
  `shipping_name` varchar(120) NOT NULL DEFAULT '' COMMENT '物流名称',
  `shipping_code` varchar(256) NOT NULL DEFAULT '' COMMENT '物流单号',
  `user_note` varchar(255) NOT NULL DEFAULT '' COMMENT '用户备注',
  `admin_note` varchar(255) DEFAULT '' COMMENT '管理员备注',
  `shopid` int(7) NOT NULL COMMENT '商品ID',
  `shopnum` mediumint(5) NOT NULL COMMENT '购买数量',
  `fewmoney` decimal(8,2) NOT NULL COMMENT '订金',
  `few_ifpay` tinyint(1) NOT NULL COMMENT '1已付订金,-1申请退订金',
  `introducer_1` int(7) NOT NULL COMMENT '推荐人',
  `introducer_2` int(7) NOT NULL COMMENT '间接发展的用户',
  `introducer_3` int(7) NOT NULL COMMENT '间接发展的用户',
  `youhui_id` mediumint(7) NOT NULL COMMENT '优惠券ID',
  `youhui_money` decimal(8,2) NOT NULL COMMENT '优惠多少钱',
  `order_field` text NOT NULL COMMENT '用户自定义字段存放的内容',
  `hexiao_uid` mediumint(7) NOT NULL COMMENT '核销者UID',
  `shoptitle` varchar(255) NOT NULL COMMENT '商品名称型号,避免商家修改后订单也跟着变',
  `status` tinyint(1) NOT NULL COMMENT '订单状态,-1退订关闭交易不能再付款',
  `agree` mediumint(7) NOT NULL COMMENT '点赞数',
  `order_day` int(8) NOT NULL COMMENT '预约日期,格式比如20200908',
  `order_tid` mediumint(7) NOT NULL COMMENT '预约时间段id',
  `hx_uid` int(7) NOT NULL COMMENT '指派核销员',
  PRIMARY KEY (`id`),
  KEY `create_time` (`create_time`),
  KEY `uid` (`uid`),
  KEY `order_sn` (`order_sn`),
  KEY `introducer_1` (`introducer_1`),
  KEY `introducer_2` (`introducer_2`),
  KEY `shop_uid` (`shop_uid`,`hx_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品订单' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_sort`
--

DROP TABLE IF EXISTS `qb_yuyue_sort`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_sort` (
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
  `haibao` varchar(255) NOT NULL COMMENT '海报模板路径,多个用逗号隔开',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `pid` (`pid`),
  KEY `list` (`list`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='主栏目表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_time`
--

DROP TABLE IF EXISTS `qb_yuyue_time`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_time` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `week` tinyint(1) NOT NULL COMMENT '1-7代表周一到周日,0的话代表每天',
  `uid` int(7) NOT NULL COMMENT '用户UID',
  `name` varchar(256) NOT NULL COMMENT '选项名称',
  `num` smallint(5) NOT NULL COMMENT '库存量',
  `price` decimal(10,2) NOT NULL COMMENT '价格',
  `list` int(10) NOT NULL COMMENT '排序值',
  `type` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `week` (`week`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='预约日期' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_timesort`
--

DROP TABLE IF EXISTS `qb_yuyue_timesort`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_timesort` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `uid` int(7) NOT NULL COMMENT '用户UID',
  `name` text NOT NULL COMMENT '分类,存放的是JSON格式,比如["分类一","分类二"]',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='时间段分类管理' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_yhlog`
--

DROP TABLE IF EXISTS `qb_yuyue_yhlog`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_yhlog` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `uid` int(8) NOT NULL COMMENT '分销创建者',
  `aid` int(8) NOT NULL COMMENT '商品ID',
  `yid` int(8) NOT NULL COMMENT '优惠券ID',
  `create_time` int(10) NOT NULL COMMENT '领取日期',
  `money` decimal(8,2) NOT NULL COMMENT '优惠价格',
  `ifuse` tinyint(1) NOT NULL COMMENT '使用与否',
  `end_time` int(10) NOT NULL COMMENT '截止有效日期',
  `use_time` int(10) NOT NULL COMMENT '使用时间',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `uid` (`uid`),
  KEY `yid` (`yid`),
  KEY `end_time` (`end_time`),
  KEY `ifuse` (`ifuse`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户领取的优惠券' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_yuyue_youhui`
--

DROP TABLE IF EXISTS `qb_yuyue_youhui`;
CREATE TABLE IF NOT EXISTS `qb_yuyue_youhui` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `uid` int(8) NOT NULL COMMENT '分销创建者',
  `aid` int(8) NOT NULL COMMENT '商品ID',
  `create_time` int(10) NOT NULL COMMENT '创建日期',
  `money` decimal(8,2) NOT NULL COMMENT '优惠价格',
  `max_num` mediumint(5) NOT NULL COMMENT '总数多少份',
  `end_time` int(10) NOT NULL COMMENT '截止有效日期',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分销用户创建的优惠券' AUTO_INCREMENT=1 ;
