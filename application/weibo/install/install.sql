
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO标题', 'mseo_title', '', 'text', '', 0, '', '', 0, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化关键字keywords', 'mseo_keyword', '', 'text', '', 0, '', '', 0, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化描述description', 'mseo_description', '', 'text', '', 0, '', '', 0, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否开启当前模块', 'is_open_modlue', '', 'radio', '1|开启\r\n0|关闭', 0, '', '', 0, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '允许创建微博的用户组', 'can_post_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 0, 6);

INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`, `version`, `version_id`) VALUES(0, 'cms_add_end', '', 'app\\weibo\\hook\\Content', '微博关联发布主题动态', 1, 0, '齐博', '', '', 0);
INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`, `version`, `version_id`) VALUES(0, 'reply_add_end', '', 'app\\weibo\\hook\\Content', '微博关联发布回复动态', 1, 0, '齐博', '', '', 0);
INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`, `version`, `version_id`) VALUES(0, 'comment_add_end', '', 'app\\weibo\\hook\\Content', '微博关联发表评论动态', 1, 0, '齐博', '', '', 0);

INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`, `version`, `version_id`) VALUES(0, 'layout_body_foot', '', 'app\\weibo\\hook\\MsgRemind', '有新的微博动态消息,就弹层提醒', 1, 0, '齐博', 'http://www.php168.com', '', 0);



--
-- 表的结构 `qb_weibo_content`
--

DROP TABLE IF EXISTS `qb_weibo_content`;
CREATE TABLE IF NOT EXISTS `qb_weibo_content` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `uid` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='索引表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_weibo_content1`
--

DROP TABLE IF EXISTS `qb_weibo_content1`;
CREATE TABLE IF NOT EXISTS `qb_weibo_content1` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(32) NOT NULL COMMENT '微博名称',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
  `replynum` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` varchar(32) NOT NULL COMMENT '头像',
  `content` text NOT NULL COMMENT '文章内容',
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `template` varchar(255) NOT NULL COMMENT '风格模板',
  `map` varchar(32) NOT NULL COMMENT '地图坐标',
  `telphone` varchar(18) NOT NULL COMMENT '联系电话',
  `address` varchar(128) NOT NULL COMMENT '地址',
  `map_x` double NOT NULL COMMENT '地图经度',
  `map_y` double NOT NULL COMMENT '地图纬度',
  `usernum` mediumint(6) NOT NULL DEFAULT '1' COMMENT '成员数',
  `keywords` varchar(128) NOT NULL COMMENT '标签',
  `msgnum` smallint(4) NOT NULL COMMENT '新动态信息',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_weibo_fav`
--

DROP TABLE IF EXISTS `qb_weibo_fav`;
CREATE TABLE IF NOT EXISTS `qb_weibo_fav` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(7) NOT NULL COMMENT '用户UID',
  `create_time` int(10) NOT NULL COMMENT '添加时间',
  `sysid` mediumint(5) NOT NULL COMMENT '频道ID若负数就是插件',
  `aid` int(10) NOT NULL COMMENT '信息内容ID',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`create_time`),
  KEY `sysid` (`sysid`,`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户感兴趣的话题' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_weibo_feed`
--

DROP TABLE IF EXISTS `qb_weibo_feed`;
CREATE TABLE IF NOT EXISTS `qb_weibo_feed` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(7) NOT NULL COMMENT '用户UID',
  `create_time` int(10) NOT NULL COMMENT '添加时间',
  `sysid` mediumint(5) NOT NULL COMMENT '频道ID若负数就是插件',
  `aid` int(10) NOT NULL COMMENT '信息内容ID',
  `rid` int(10) NOT NULL COMMENT '回复或评论ID',
  `type` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '操作类型',
  `about` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '事件说明',
  `ifread` tinyint(1) NOT NULL COMMENT '1代表已阅',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`create_time`),
  KEY `ifread` (`ifread`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户动态' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_weibo_field`
--

DROP TABLE IF EXISTS `qb_weibo_field`;
CREATE TABLE IF NOT EXISTS `qb_weibo_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '字段名称',
  `name` varchar(32) NOT NULL,
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '字段标题',
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文档字段表' AUTO_INCREMENT=54 ;

--
-- 转存表中的数据 `qb_weibo_field`
--

INSERT INTO `qb_weibo_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(10, 'title', '微博名称', 'hidden', 'varchar(32) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, '', '', '', '', '', '');
INSERT INTO `qb_weibo_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(11, 'picurl', '头像', 'hidden', 'varchar(32) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 0, 0, 0, '', '', '', '', '', '');
INSERT INTO `qb_weibo_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(12, 'content', '自我介绍', 'textarea', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 0, 0, 0, '', '', '', '', '', '');
INSERT INTO `qb_weibo_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(50, 'telphone', '联系电话', 'text', 'varchar(18) NOT NULL', '11', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '');
INSERT INTO `qb_weibo_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(49, 'map', '地图坐标', 'hidden', 'varchar(32) NOT NULL', '50', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '');
INSERT INTO `qb_weibo_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(51, 'address', '地区', 'text', 'varchar(128) NOT NULL', '255', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '');
INSERT INTO `qb_weibo_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(53, 'keywords', '标签', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '');


--
-- 表的结构 `qb_weibo_member`
--

DROP TABLE IF EXISTS `qb_weibo_member`;
CREATE TABLE IF NOT EXISTS `qb_weibo_member` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '被关注用户的UID',
  `uid` int(7) NOT NULL COMMENT '登录用户的ID',
  `create_time` int(10) NOT NULL COMMENT '关注时间',
  `type` tinyint(1) NOT NULL COMMENT '0是粉丝,1是双向好友',
  `update_time` int(10) NOT NULL COMMENT '最后访问时间',
  `view` mediumint(7) NOT NULL DEFAULT '1' COMMENT '访问次数',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`,`update_time`,`type`),
  KEY `view` (`view`),
  KEY `uid` (`uid`,`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='粉丝好友' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_weibo_module`
--

DROP TABLE IF EXISTS `qb_weibo_module`;
CREATE TABLE IF NOT EXISTS `qb_weibo_module` (
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

--
-- 转存表中的数据 `qb_weibo_module`
--

INSERT INTO `qb_weibo_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`) VALUES(1, '', '微博动态模型', '', '', 100, 1515221331, 0);

-- --------------------------------------------------------

--
-- 表的结构 `qb_weibo_sort`
--

DROP TABLE IF EXISTS `qb_weibo_sort`;
CREATE TABLE IF NOT EXISTS `qb_weibo_sort` (
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

--
-- 转存表中的数据 `qb_weibo_sort`
--

INSERT INTO `qb_weibo_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(1, 0, 1, '开发者', 0, '', '', '', '', '', '', '');
INSERT INTO `qb_weibo_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(2, 0, 1, '站长', 0, '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_weibo_visit`
--

DROP TABLE IF EXISTS `qb_weibo_visit`;
CREATE TABLE IF NOT EXISTS `qb_weibo_visit` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '被访问者ID',
  `uid` int(7) NOT NULL COMMENT '登录用户的ID',
  `visittime` int(10) NOT NULL COMMENT '最后访问时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `aid` (`aid`),
  KEY `visittime` (`visittime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户访问过的微博' AUTO_INCREMENT=1 ;
