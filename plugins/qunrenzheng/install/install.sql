
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('', -1, '提交申请是否自动通过审核', 'automatic_yz', '0', 'radio', '0|不通过\r\n1|通过', '0', '', '', '0', '-28');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('', -1, '认证金额', 'rz_rmb', '11', 'text', '', '0', '', '余额支付，为空或0则不需要支付认证金额', '0', '-28');
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES ('', -1, '开放或关闭', 'is_open_modlue', '0', 'radio', '0|开放\r\n1|关闭', '0', '', '', '0', '-28');



DROP TABLE IF EXISTS `qb_qunrenzheng_content`;
CREATE TABLE IF NOT EXISTS `qb_qunrenzheng_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='内容索引表' AUTO_INCREMENT=1;


-- --------------------------------------------------------

--
-- 表的结构 `qb_qunrenzheng_content1`
--
DROP TABLE IF EXISTS `qb_qunrenzheng_content1`;
CREATE TABLE `qb_qunrenzheng_content1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
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
  `address` varchar(255) NOT NULL COMMENT '联系地址',
  `credentials_type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '证件类型',
  `picurl` varchar(255) NOT NULL COMMENT '证件扫描件',
  `credentials_number` varchar(35) NOT NULL COMMENT '证件号码',
  `qun_id` int(7) NOT NULL DEFAULT '0' COMMENT '认证圈子',
  `rz_rmb` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '需支付的认证金额',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `ispic` (`ispic`),
  KEY `comment` (`comment`),
  KEY `status` (`status`),
  KEY `list` (`list`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='圈子认证模型表';


-- --------------------------------------------------------

--
-- 表的结构 `qb_qunrenzheng_field`
--

DROP TABLE IF EXISTS `qb_qunrenzheng_field`;
CREATE TABLE `qb_qunrenzheng_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '字段名称',
  `name` varchar(32) NOT NULL,
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '字段标题',
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
  `nav` varchar(30) NOT NULL COMMENT '分组名称',
  `input_width` varchar(7) NOT NULL COMMENT '输入表单宽度',
  `input_height` varchar(7) NOT NULL COMMENT '输入表单高度',
  `unit` varchar(20) NOT NULL COMMENT '单位名称',
  `match` varchar(150) NOT NULL COMMENT '表单正则匹配',
  `css` varchar(20) NOT NULL COMMENT '表单CSS类名',
  `script` text NOT NULL COMMENT 'JS脚本',
  `trigger` varchar(255) NOT NULL COMMENT '选择某一项后,联动触发显示其它字段',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='文档字段表' ;

--
-- 转存表中的数据 `qb_qunrenzheng_field`
--
INSERT INTO `qb_qunrenzheng_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES ('3', 'content', '附注说明', 'textarea', 'text NOT NULL', '', '', '', '1', '1', '', '', '', '', '', '2', '', '', '', '-1', '0', '', '', '', '', '', '', '', '');
INSERT INTO `qb_qunrenzheng_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES ('4', 'title', '问题简述', 'text', 'varchar(256) NOT NULL', '', '', '', '1', '2', '', '', '', '', '', '2', '', '', '', '100', '1', '', '', '', '', '', '', '', '');
INSERT INTO `qb_qunrenzheng_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES ('5', 'picurl', '截图描述', 'images', 'text NOT NULL', '', '', '', '1', '2', '', '', '', '', '', '2', '', '', '', '99', '0', '', '', '', '', '', '', '', '');
INSERT INTO `qb_qunrenzheng_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES ('6', 'content', '更多说明', 'textarea', 'text NOT NULL', '', '', '', '1', '2', '', '', '', '', '', '2', '', '', '', '-1', '0', '', '', '', '', '', '', '', '');
INSERT INTO `qb_qunrenzheng_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES ('7', 'linkman', '联系人', 'text', 'varchar(128) NOT NULL', '', '', '', '1', '2', '', '', '', '', '', '2', '', '', '', '0', '1', '', '', '', '', '', '', '', '');
INSERT INTO `qb_qunrenzheng_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES ('8', 'tel', '联系电话', 'text', 'varchar(18) NOT NULL', '', '', '', '1', '2', '', '', '', '', '', '2', '', '', '', '0', '0', '', '', '', '', '', '', '', '');
INSERT INTO `qb_qunrenzheng_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES ('9', 'linkman', '联系人', 'text', 'varchar(18) NOT NULL', 'user.truename', '', '', '1', '1', '', '', '', '', '', '2', '', '', '', '0', '1', '', '', '', '', '', '', '', '');
INSERT INTO `qb_qunrenzheng_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES ('10', 'telphone', '联系电话', 'text', 'varchar(18) NOT NULL', 'user.mobphone', '', '', '1', '1', '', '', '', '', '', '2', '', '', '', '0', '0', '', '', '', '', '', '', '', '');
INSERT INTO `qb_qunrenzheng_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES ('11', 'address', '联系地址', 'text', 'varchar(255) NOT NULL', 'user.address', '', '', '1', '1', '', '', '', '', '', '2', '', '', '', '0', '0', '', '', '', '', '', '', '', '');
INSERT INTO `qb_qunrenzheng_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES ('12', 'credentials_type', '证件类型', 'radio', 'tinyint(2) NOT NULL DEFAULT \'0\'', '1', '1|身份证\r\n2|营业执照', '', '1', '1', '', '', '', '', '', '2', '', '', '', '0', '0', '', '', '', '', '', '', '', '');
INSERT INTO `qb_qunrenzheng_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES ('13', 'picurl', '证件扫描件', 'image', 'varchar(255) NOT NULL', '', '', '', '1', '1', '', '', '', '', '', '2', '', '', '', '0', '0', '', '', '', '', '', '', '', '');
INSERT INTO `qb_qunrenzheng_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES ('14', 'credentials_number', '证件号码', 'text', 'varchar(35) NOT NULL', '', '', '', '1', '1', '', '', '', '', '', '2', '', '', '', '0', '0', '', '', '', '', '', '', '', '');
INSERT INTO `qb_qunrenzheng_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`) VALUES ('15', 'qun_id', '认证圈子', 'select', 'int(7) NOT NULL DEFAULT \'0\'', '', 'plugins\\qunrenzheng\\model\\Content@getAllQunByUid', '', '1', '1', '', '', '', '', '', '2', '', '', '', '0', '0', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_qunrenzheng_module`
--

DROP TABLE IF EXISTS `qb_qunrenzheng_module`;
CREATE TABLE `qb_qunrenzheng_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) NOT NULL DEFAULT '' COMMENT '模型区分符关键字',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模型标题',
  `icon` varchar(64) NOT NULL,
  `list` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `posttime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='表单模型';
--
-- 转存表中的数据 `qb_qunrenzheng_module`
--

INSERT INTO `qb_qunrenzheng_module` (`id`, `keyword`, `title`, `icon`, `list`, `posttime`, `status`) VALUES (1, '', '圈子认证', '', '100', '1520410674', '0');

-- --------------------------------------------------------

--
-- 表的结构 `qb_qunrenzheng_sort`
--

DROP TABLE IF EXISTS `qb_qunrenzheng_sort`;
CREATE TABLE IF NOT EXISTS `qb_qunrenzheng_sort` (
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

