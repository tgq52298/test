INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO标题', 'mseo_title', '', 'text', '', 0, '', '', 100, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化关键字keywords', 'mseo_keyword', '', 'text', '', 0, '', '', 99, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化描述description', 'mseo_description', '', 'text', '', 0, '', '', 98, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否开启当前模块', 'is_open_modlue', '1', 'radio', '1|开启\r\n0|关闭', 0, '', '', 97, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '允许发布内容的用户组', 'can_post_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 96, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '发布内容自动通过审核的用户组', 'post_auto_pass_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 95, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '默认城市ID', 'city_id', '6', 'select', 'plugins\\area\\model\\Area@getTitleList@{"level":2}', 0, '', '列表页会默认显示这个城市下面的区域,不设置将无法显示区域筛选', 0, 12);





--
-- 表的结构 `qb_hbfenlei_content`
--

DROP TABLE IF EXISTS `qb_hbfenlei_content`;
CREATE TABLE IF NOT EXISTS `qb_hbfenlei_content` (
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

--
-- 转存表中的数据 `qb_hbfenlei_content`
--

INSERT INTO `qb_hbfenlei_content` (`id`, `mid`, `uid`) VALUES(2, 2, 1);
INSERT INTO `qb_hbfenlei_content` (`id`, `mid`, `uid`) VALUES(6, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `qb_hbfenlei_content1`
--

DROP TABLE IF EXISTS `qb_hbfenlei_content1`;
CREATE TABLE IF NOT EXISTS `qb_hbfenlei_content1` (
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
  `haibao` varchar(50) NOT NULL COMMENT '海报模板路径',
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章模型模型表' AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `qb_hbfenlei_content1`
--

INSERT INTO `qb_hbfenlei_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `agree`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `ext_sys`, `ext_id`, `infotype`, `paytype`, `telphone`, `haibao`) VALUES(6, 1, 4, '出售皇太子摩托车一辆', 1, 1, 136, 1, 0, 0, 1549881548, 1550318186, 1549881548, 'uploads/images/20190216/1_20190216195617802a2.jpeg,uploads/images/20190216/1_20190216195624a7480.jpeg', '98成新,只骑了一年,现在吐血便宜出价!', 0, 0, 0, 0, 0, 0, 2, '1', '132655488', '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_hbfenlei_content2`
--

DROP TABLE IF EXISTS `qb_hbfenlei_content2`;
CREATE TABLE IF NOT EXISTS `qb_hbfenlei_content2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
  `agree` mediumint(5) NOT NULL DEFAULT '0' COMMENT '点赞',
  `replynum` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `dowhat` text NOT NULL COMMENT '岗位职责',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段,关联的系统',
  `ext_id` mediumint(7) NOT NULL COMMENT '扩展字段,关联的ID',
  `telphone` varchar(18) NOT NULL COMMENT '电话号码',
  `askskill` text NOT NULL COMMENT '任责要求',
  `jobplace` varchar(255) NOT NULL COMMENT '工作地点',
  `jobpay` text NOT NULL COMMENT '薪酬待遇',
  `worktime` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否全职',
  `linkman` varchar(25) NOT NULL COMMENT '联系人',
  `haibao` varchar(50) NOT NULL COMMENT '海报模板路径',
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

--
-- 转存表中的数据 `qb_hbfenlei_content2`
--

INSERT INTO `qb_hbfenlei_content2` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `agree`, `replynum`, `dowhat`, `create_time`, `update_time`, `list`, `province_id`, `city_id`, `zone_id`, `street_id`, `ext_sys`, `ext_id`, `telphone`, `askskill`, `jobplace`, `jobpay`, `worktime`, `linkman`, `haibao`) VALUES(2, 2, 2, '销售代表', 0, 1, 262, 1, 0, 0, '1、定期拜访客户，执行生动化陈列，宣导销售政策，促进客户下单和售后服务等工作；\r\n2、根据区域和时令特点，挖掘销售机会，扩张渠道，提升渠道流通效率；\r\n3、执行线下广告宣传工作，如张贴POP、制作店招、路边广告牌等；\r\n4、执行区域市场活动，提升和维护品牌知名度、美誉度。 　\r\n5、其他与本岗位相关的工作。', 1527824199, 1550373663, 1527824199, 1, 6, 7, 17, 0, 0, '400-889-3333', '1、中专/高中及以上学历；\r\n2、有1-2年以上销售业务经验；饮料、酒水、食品等快消业务代表工作经验者优先；\r\n3、逻辑清晰、条理分明、表达流利，具有较好的应变能力和亲和力；', '广州天河', '五险一金 包住 话补 交通补助 年底双薪 员工旅游 节日福利', 1, '张经理', '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_hbfenlei_field`
--

DROP TABLE IF EXISTS `qb_hbfenlei_field`;
CREATE TABLE IF NOT EXISTS `qb_hbfenlei_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '字段名称',
  `name` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '字段标题',
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
  `script` text NOT NULL COMMENT 'JS脚本',
  `trigger` varchar(255) NOT NULL COMMENT '选择某一项后,联动触发显示其它字段',
  `range_opt` text NOT NULL COMMENT '范围选择,比如价格范围',
  `group_view` varchar(255) NOT NULL COMMENT '允许哪些用户组查看',
  `index_hide` tinyint(1) NOT NULL COMMENT '是否前台不显示并不做转义处理',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文档字段表' AUTO_INCREMENT=68 ;

--
-- 转存表中的数据 `qb_hbfenlei_field`
--

INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(10, 'title', '信息标题', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(11, 'picurl', '相关图片', 'images', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 99, 0, 0, 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(12, 'content', '信息详情', 'textarea', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(19, 'title', '招聘职位', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(21, 'dowhat', '岗位职责', 'textarea', 'text NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', 98, 0, 0, 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(62, 'telphone', '联系电话', 'text', 'varchar(18) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(60, 'infotype', '供需类型', 'radio', 'tinyint(1) NOT NULL', '', '1|求购\r\n2|供应', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 1, 1, 1, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(61, 'paytype', '交易方式', 'radio', 'varchar(32) NOT NULL', '', '1|线下交易\r\n2|线上交易', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 1, 1, 1, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(69, 'linkman', '联系人', 'text', 'varchar(25) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(68, 'worktime', '是否全职', 'radio', 'tinyint(2) NOT NULL DEFAULT ''0''', '1', '1|全职\r\n2|兼职', '', 1, 2, '', '', '', '', '', 2, '', '', '', 99, 1, 0, 1, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(67, 'jobpay', '薪酬待遇', 'textarea', 'text NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 94, 0, 0, 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(66, 'jobplace', '工作地点', 'text', 'varchar(255) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 90, 0, 0, 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(63, 'telphone', '联系电话', 'text', 'varchar(18) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 89, 0, 0, 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(65, 'askskill', '技能要求', 'textarea', 'text NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 96, 0, 0, 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(76, 'haibao', '海报模板', 'text', 'varchar(50) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES(77, 'haibao', '海报模板', 'text', 'varchar(50) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_hbfenlei_module`
--

DROP TABLE IF EXISTS `qb_hbfenlei_module`;
CREATE TABLE IF NOT EXISTS `qb_hbfenlei_module` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='模型表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `qb_hbfenlei_module`
--

INSERT INTO `qb_hbfenlei_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`, `haibao`) VALUES(1, '', '一般信息', '', '', 100, 1515221331, 0, '');
INSERT INTO `qb_hbfenlei_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`, `haibao`) VALUES(2, '', '招聘模型', '', '', 100, 1515236691, 0, 'job/show.htm,base/show.htm');

-- --------------------------------------------------------

--
-- 表的结构 `qb_hbfenlei_sort`
--

DROP TABLE IF EXISTS `qb_hbfenlei_sort`;
CREATE TABLE IF NOT EXISTS `qb_hbfenlei_sort` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='主栏目表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `qb_hbfenlei_sort`
--

INSERT INTO `qb_hbfenlei_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`, `haibao`) VALUES(1, 0, 2, '房产专区', 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`, `haibao`) VALUES(2, 1, 2, '出售房屋', 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`, `haibao`) VALUES(3, 0, 1, '二手市场', 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`, `haibao`) VALUES(4, 3, 1, '母婴用品', 0, '', '', '', '', '', '', '', '');
INSERT INTO `qb_hbfenlei_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`, `haibao`) VALUES(5, 1, 1, '求购房子', 0, '', '', '', '', '', '', '', '');
