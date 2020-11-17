
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO标题', 'mseo_title', '论坛频道', 'text', '', 0, '', '', 100, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化关键字keywords', 'mseo_keyword', '论坛关键字', 'text', '', 0, '', '', 99, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化描述description', 'mseo_description', '论坛描述', 'text', '', 0, '', '', 98, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否开启当前模块', 'is_open_modlue', '1', 'radio', '1|开启\r\n0|关闭', 0, '', '', 97, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '允许发布内容的用户组', 'can_post_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 96, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '发布内容自动通过审核的用户组', 'post_auto_pass_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 95, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '内容被设为精华奖励积分个数', 'com_info_add_money', '', 'text', '', 0, '', '', 94, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否启用微信通知有人评论了', 'reply_send_wxmsg', '1', 'radio', '0|禁用\r\n1|启用', 0, '', '必须要对接认证公众号', 0, 4);

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '超过多少回复用户不能删贴', 'reply_num_limit_delete', '30', 'number', '', 0, '', '', 0, 4);

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '发布附近动态归类哪个栏目', 'near_fid', '18', 'select', 'bbs_sort@id,name', 0, '', '', 0, 2);


DROP TABLE IF EXISTS `qb_bbs_content`;
CREATE TABLE IF NOT EXISTS `qb_bbs_content` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `uid` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='主题索引表' AUTO_INCREMENT=1 ;




DROP TABLE IF EXISTS `qb_bbs_content1`;
CREATE TABLE IF NOT EXISTS `qb_bbs_content1` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(5) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：比如审核与否',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '封面图',
  `mvurl` varchar(255) NOT NULL,
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `agree` mediumint(5) NOT NULL COMMENT '点赞',
  `replynum` mediumint(5) NOT NULL COMMENT '评论数',
  `reward` smallint(5) NOT NULL COMMENT '打赏用户数',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段,关联的系统',
  `ext_id` int(8) NOT NULL COMMENT '扩展字段,供其它调用',
  `replyuser` varchar(50) NOT NULL COMMENT '最后评论者',
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
  KEY `replynum` (`replynum`),
  KEY `agree` (`agree`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='论坛标题主表' AUTO_INCREMENT=1 ;




DROP TABLE IF EXISTS `qb_bbs_contents`;
CREATE TABLE IF NOT EXISTS `qb_bbs_contents` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL COMMENT '文章内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='主题内容表' AUTO_INCREMENT=1 ;




DROP TABLE IF EXISTS `qb_bbs_field`;
CREATE TABLE IF NOT EXISTS `qb_bbs_field` (
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
  `script` text NOT NULL COMMENT 'JS脚本',
  `trigger` varchar(255) NOT NULL COMMENT '选择某一项后,联动触发显示其它字段',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文档字段表' AUTO_INCREMENT=13 ;



INSERT INTO `qb_bbs_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES
(10, 'title', '标题', 'text', 'varchar(256) NOT NULL', NULL, NULL, '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, ''),
(11, 'picurl', '组图', 'images', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 0, 0, 0, ''),
(12, 'content', '内容', 'ueditor', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 0, 0, 0, '');




DROP TABLE IF EXISTS `qb_bbs_infomsg`;
CREATE TABLE IF NOT EXISTS `qb_bbs_infomsg` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `ext_id` int(7) NOT NULL COMMENT '扩展ID,比如可以给圈子统计',
  `ext_sys` smallint(4) NOT NULL COMMENT '扩展字段,关联的系统',
  `posttime` int(10) NOT NULL COMMENT '发贴更新时间',
  `today_post` mediumint(5) NOT NULL COMMENT '今日发贴量',
  `yesterday_post` mediumint(5) NOT NULL COMMENT '昨晚发贴量',
  `total_post` mediumint(7) NOT NULL COMMENT '总发贴量',
  `total_topic` mediumint(6) NOT NULL COMMENT '主题总数',
  `day_top_post` int(11) NOT NULL COMMENT '最高日发贴量',
  PRIMARY KEY (`id`),
  KEY `ext_id` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='论坛的一些辅助信息,比如今日多少贴' AUTO_INCREMENT=2 ;



INSERT INTO `qb_bbs_infomsg` (`id`, `ext_id`, `ext_sys`, `posttime`, `today_post`, `yesterday_post`, `total_post`, `total_topic`, `day_top_post`) VALUES
(1, 0, 0, 1525920084, 13, 18, 220, 23, 1);




DROP TABLE IF EXISTS `qb_bbs_member`;
CREATE TABLE IF NOT EXISTS `qb_bbs_member` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '贴子ID',
  `rid` int(7) NOT NULL,
  `uid` int(7) NOT NULL COMMENT '用户ID',
  `create_time` int(10) NOT NULL COMMENT '添加时间',
  `money` decimal(7,2) NOT NULL COMMENT '打赏金额',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '扩展字段,可拓展为1是点赞',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `aid` (`aid`),
  KEY `type` (`type`),
  KEY `money` (`money`),
  KEY `rid` (`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='贴子关联的会员信息' AUTO_INCREMENT=1 ;




DROP TABLE IF EXISTS `qb_bbs_module`;
CREATE TABLE IF NOT EXISTS `qb_bbs_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) NOT NULL DEFAULT '' COMMENT '区分符关键字',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模型标题',
  `layout` varchar(50) NOT NULL COMMENT '模板路径',
  `icon` varchar(64) NOT NULL,
  `list` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='模型表' AUTO_INCREMENT=4 ;




INSERT INTO `qb_bbs_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`) VALUES
(1, '', '论坛模型', '', '', 100, 1515221331, 0);




DROP TABLE IF EXISTS `qb_bbs_reply`;
CREATE TABLE IF NOT EXISTS `qb_bbs_reply` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL COMMENT '引用回复上级ID',
  `sysid` int(10) unsigned NOT NULL COMMENT '插件或模块ID',
  `aid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模块的内容页ID',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `agree` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '支持',
  `disagree` mediumint(7) NOT NULL COMMENT '反对',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：比如审核与否',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '封面图',
  `mvurl` varchar(255) NOT NULL,
  `content` text NOT NULL COMMENT '文章内容',
  `reply` mediumint(4) NOT NULL COMMENT '回复数',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `sysid` (`sysid`),
  KEY `agree` (`agree`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='回复内容表' AUTO_INCREMENT=1 ;




DROP TABLE IF EXISTS `qb_bbs_sort`;
CREATE TABLE IF NOT EXISTS `qb_bbs_sort` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='主栏目表' AUTO_INCREMENT=22 ;




INSERT INTO `qb_bbs_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES
(16, 0, 1, '村人村事', 0, '', '', '2,8', '', '', '', ''),
(17, 0, 1, '家乡特产', 0, '', '', '', '', '', '', ''),
(18, 0, 1, '务工话题', 0, '', '', '', '', '', '', ''),
(19, 0, 1, '家乡图片', 0, '', '', '', '', '这是标题', '这是关键字', '这是描述');


ALTER TABLE  `qb_bbs_reply` ADD INDEX  `uid` (  `uid` );
ALTER TABLE `qb_bbs_content1` ADD INDEX  `uid` (  `uid` );

ALTER TABLE  `qb_bbs_content1` ADD  `phone_type` VARCHAR( 50 ) NOT NULL COMMENT  '发表来自什么手机';
ALTER TABLE  `qb_bbs_reply` ADD  `phone_type` VARCHAR( 50 ) NOT NULL COMMENT  '发表来自什么手机';

ALTER TABLE  `qb_bbs_content1` ADD  `qun_status` TINYINT( 1 ) NOT NULL COMMENT  '圈子扩展状态,比如置顶';
ALTER TABLE  `qb_bbs_content1` ADD INDEX (  `qun_status` );

ALTER TABLE  `qb_bbs_contents` CHANGE  `content`  `content` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '文章内容';

ALTER TABLE  `qb_bbs_content1` ADD  `font_color` VARCHAR( 7 ) NOT NULL COMMENT  '标题字体颜色',ADD  `font_type` TINYINT( 1 ) NOT NULL COMMENT  '标题字体加粗或其它';


INSERT INTO `qb_bbs_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`) VALUES(2, '', '评论模型', '', '', 100, 1552526770);
INSERT INTO `qb_bbs_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`) VALUES(3, '', '咨询模型', '', '', 100, 1552620271);



INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('title', '评论内容', 'ueditor', 'text NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('picurl', '组图', 'images', 'text NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', 100, 0, 0, 0);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('content', '附注', 'hidden', 'text NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('star', '点评', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '1', '-1|差评\r\n0|中评\r\n1|好评', '', 1, 2, '', '', '', '', '', 2, '', '', '', 101, 0, 0, 0);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('title', '咨询内容', 'textarea', 'text NOT NULL', '', '', '', 0, 3, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('picurl', '组图', 'hidden', 'text NOT NULL', '', '', '', 0, 3, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('content', '附注', 'hidden', 'text NOT NULL', '', '', '', 0, 3, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('telphone', '联系电话', 'text', 'varchar(25) NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0);
INSERT INTO `qb_bbs_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('wxid', '联系微信号', 'text', 'varchar(25) NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0);


DROP TABLE IF EXISTS `qb_bbs_content2`;
CREATE TABLE IF NOT EXISTS `qb_bbs_content2` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` text NOT NULL COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(5) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：比如审核与否',
  `lock` tinyint(1) NOT NULL COMMENT '是否锁定不给修改,删除,回复',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '封面图',
  `mvurl` varchar(255) NOT NULL,
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `agree` mediumint(5) NOT NULL COMMENT '点赞',
  `replynum` mediumint(5) NOT NULL COMMENT '评论数',
  `reward` smallint(5) NOT NULL COMMENT '打赏用户数',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段,关联的系统',
  `ext_id` int(8) NOT NULL COMMENT '扩展字段,供其它调用',
  `replyuser` varchar(50) NOT NULL COMMENT '最后评论者',
  `phone_type` varchar(50) NOT NULL COMMENT '发表来自什么手机',
  `qun_status` tinyint(1) NOT NULL COMMENT '圈子扩展状态,比如置顶',
  `font_type` tinyint(1) NOT NULL COMMENT '标题字体加粗或其它',
  `font_color` varchar(7) NOT NULL COMMENT '标题字体颜色',
  `star` tinyint(1) NOT NULL DEFAULT '0' COMMENT '打分',
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
  KEY `replynum` (`replynum`),
  KEY `agree` (`agree`),
  KEY `uid` (`uid`),
  KEY `qun_status` (`qun_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='评论模型内容主表' AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS `qb_bbs_content3`;
CREATE TABLE IF NOT EXISTS `qb_bbs_content3` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` text NOT NULL COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(5) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：比如审核与否',
  `lock` tinyint(1) NOT NULL COMMENT '是否锁定不给修改,删除,回复',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '封面图',
  `mvurl` varchar(255) NOT NULL,
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `agree` mediumint(5) NOT NULL COMMENT '点赞',
  `replynum` mediumint(5) NOT NULL COMMENT '评论数',
  `reward` smallint(5) NOT NULL COMMENT '打赏用户数',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段,关联的系统',
  `ext_id` int(8) NOT NULL COMMENT '扩展字段,供其它调用',
  `replyuser` varchar(50) NOT NULL COMMENT '最后评论者',
  `phone_type` varchar(50) NOT NULL COMMENT '发表来自什么手机',
  `qun_status` tinyint(1) NOT NULL COMMENT '圈子扩展状态,比如置顶',
  `font_type` tinyint(1) NOT NULL COMMENT '标题字体加粗或其它',
  `font_color` varchar(7) NOT NULL COMMENT '标题字体颜色',
  `telphone` varchar(25) NOT NULL COMMENT '联系电话',
  `wxid` varchar(25) NOT NULL COMMENT '联系微信号',
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
  KEY `replynum` (`replynum`),
  KEY `agree` (`agree`),
  KEY `uid` (`uid`),
  KEY `qun_status` (`qun_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='咨询模型内容主表' AUTO_INCREMENT=1 ;


ALTER TABLE  `qb_bbs_content1` ADD  `map_x` DOUBLE NOT NULL COMMENT  '坐标经度',ADD  `map_y` DOUBLE NOT NULL COMMENT  '坐标纬度',ADD  `map` VARCHAR( 32 ) NOT NULL COMMENT  '百度地图xy坐标';
ALTER TABLE  `qb_bbs_content1` ADD INDEX (  `map_x` );
ALTER TABLE  `qb_bbs_content1` ADD INDEX (  `map_y` );
INSERT INTO `qb_bbs_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES(0, 'map', '所在位置', 'bmap', 'varchar(32) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '附加属性');

