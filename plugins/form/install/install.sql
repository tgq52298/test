
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '开放或关闭', 'is_open_modlue', '0', 'radio', '0|开放\r\n1|关闭', 0, '', '', 0, -3);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '接收消息的客服UID', 'post_form_kefu_uid', '1,2', 'text', '', 0, '', '若有多个UID用半角英文逗号隔开', 0, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '用户提交表单是否短消息通知客服', 'post_form_msg_send', '1', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '用户提交表单是否手机短信通知客服', 'post_form_sms_send', '0', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '用户提交表单是否微信通知客服', 'post_form_wx_send', '0', 'radio', '1|通知\r\n0|不通知', 0, '', '', 0, 4);



DROP TABLE IF EXISTS `qb_form_content`;
CREATE TABLE IF NOT EXISTS `qb_form_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) NOT NULL COMMENT '栏目ID',
  `view` mediumint(7) NOT NULL COMMENT '浏览量',
  `status` tinyint(2) NOT NULL COMMENT '状态：-1回收站 0未审 1已审 2推荐',
  `list` int(10) NOT NULL COMMENT '可控排序',
  `create_time` int(10) NOT NULL COMMENT '发布日期',
  `ext_id` mediumint(7) NOT NULL COMMENT '关联其它模型的内容ID',
  `ext_sys` smallint(4) NOT NULL COMMENT '关联其它模型的频道ID',
  `title` varchar(255) NOT NULL COMMENT '标题',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ext_id` (`ext_id`,`ext_sys`),
  KEY `fid` (`fid`),
  KEY `create_time` (`create_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容索引表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_form_content1`
--

DROP TABLE IF EXISTS `qb_form_content1`;
CREATE TABLE IF NOT EXISTS `qb_form_content1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否有组图',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `template` varchar(256) NOT NULL DEFAULT '' COMMENT '列表页内容页的风格模板',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：比如审核与否',
  `comment` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `content` text NOT NULL COMMENT '内容介绍',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `linkman` varchar(18) NOT NULL COMMENT '联系人',
  `telphone` varchar(18) NOT NULL COMMENT '联系电话',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `ispic` (`ispic`),
  KEY `comment` (`comment`),
  KEY `status` (`status`),
  KEY `list` (`list`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='申请预约模型表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_form_content2`
--

DROP TABLE IF EXISTS `qb_form_content2`;
CREATE TABLE IF NOT EXISTS `qb_form_content2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `picurl` text NOT NULL COMMENT '组图',
  `ispic` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否有组图',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `template` varchar(256) NOT NULL DEFAULT '' COMMENT '列表页内容页的风格模板',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：比如审核与否',
  `comment` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `content` text NOT NULL COMMENT '内容介绍',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `linkman` varchar(128) NOT NULL COMMENT '联系人',
  `tel` varchar(18) NOT NULL COMMENT '联系电话',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `ispic` (`ispic`),
  KEY `comment` (`comment`),
  KEY `status` (`status`),
  KEY `list` (`list`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='问题反馈模型表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_form_field`
--

DROP TABLE IF EXISTS `qb_form_field`;
CREATE TABLE IF NOT EXISTS `qb_form_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '字段名称',
  `name` varchar(256) NOT NULL,
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '字段标题',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT '字段类型',
  `field_type` varchar(128) NOT NULL DEFAULT '' COMMENT '字段定义',
  `value` text COMMENT '默认值',
  `options` text COMMENT '额外选项',
  `about` varchar(256) NOT NULL DEFAULT '' COMMENT '提示说明',
  `show` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `mid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '所属文档模型id',
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
  `ifsearch` tinyint(1) NOT NULL COMMENT '是否为搜索字段',
  `ifmust` tinyint(1) NOT NULL COMMENT '是否必填',
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文档字段表' AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `qb_form_field`
--

INSERT INTO `qb_form_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(1, 'title', '预约项目说明', 'text', 'varchar(256) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 100, 1, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_form_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(9, 'linkman', '联系人', 'text', 'varchar(18) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 1, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_form_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(3, 'content', '附注说明', 'textarea', 'text NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_form_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(4, 'title', '问题简述', 'text', 'varchar(256) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 100, 1, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_form_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(5, 'picurl', '截图描述', 'images', 'text NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 99, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_form_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(6, 'content', '更多说明', 'textarea', 'text NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_form_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(7, 'linkman', '联系人', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 1, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_form_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(8, 'tel', '联系电话', 'text', 'varchar(18) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');
INSERT INTO `qb_form_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(10, 'telphone', '联系电话', 'text', 'varchar(18) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_form_module`
--

DROP TABLE IF EXISTS `qb_form_module`;
CREATE TABLE IF NOT EXISTS `qb_form_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) NOT NULL DEFAULT '' COMMENT '模型区分符关键字',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模型标题',
  `icon` varchar(64) NOT NULL,
  `list` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `posttime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='表单模型' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `qb_form_module`
--

INSERT INTO `qb_form_module` (`id`, `keyword`, `title`, `icon`, `list`, `posttime`, `status`) VALUES(1, '', '申请预约', '', 100, 1520410674, 0);
INSERT INTO `qb_form_module` (`id`, `keyword`, `title`, `icon`, `list`, `posttime`, `status`) VALUES(2, '', '问题反馈', '', 100, 1520410706, 0);

-- --------------------------------------------------------

--
-- 表的结构 `qb_form_sort`
--

DROP TABLE IF EXISTS `qb_form_sort`;
CREATE TABLE IF NOT EXISTS `qb_form_sort` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL,
  `mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `name` varchar(50) NOT NULL,
  `list` int(10) NOT NULL,
  `logo` varchar(50) NOT NULL COMMENT '封面图',
  `template` varchar(255) NOT NULL COMMENT '模板',
  `allowpost` varchar(100) NOT NULL COMMENT '允许发布信息的用户组',
  `allowview` varchar(100) NOT NULL COMMENT '允许浏览内容的用户组',
  `seo_title` int(100) NOT NULL COMMENT 'SEO标题',
  `seo_keywords` int(100) NOT NULL COMMENT 'SEO关键字',
  `seo_description` int(150) NOT NULL COMMENT 'SEO描述',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `pid` (`pid`),
  KEY `list` (`list`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='主栏目表' AUTO_INCREMENT=1 ;
