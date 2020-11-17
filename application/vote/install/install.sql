INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, 'SEO标题', 'mseo_title', '', 'text', '', 0, '', '', 100, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, 'SEO优化关键字keywords', 'mseo_keyword', '', 'text', '', 0, '', '', 99, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, 'SEO优化描述description', 'mseo_description', '', 'text', '', 0, '', '', 98, 4);





-- --------------------------------------------------------

--
-- 表的结构 `qb_vote_category`
--

DROP TABLE IF EXISTS `qb_vote_category`;
CREATE TABLE IF NOT EXISTS `qb_vote_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `list` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `list` (`list`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='辅栏目' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_vote_content`
--

DROP TABLE IF EXISTS `qb_vote_content`;
CREATE TABLE IF NOT EXISTS `qb_vote_content` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `uid` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='内容索引表' AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `qb_vote_content`
--

-- INSERT INTO `qb_vote_content` VALUES ('20','1','1');
-- INSERT INTO `qb_vote_content` VALUES ('21','1','1');


-- --------------------------------------------------------

--
-- 表的结构 `qb_cms_content1`
--
-- 投票模型内容表
DROP TABLE IF EXISTS `qb_vote_content1`;
CREATE TABLE `qb_vote_content1` (
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
  `mobphone` varchar(12) DEFAULT NULL COMMENT '联系电话',
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
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COMMENT='投票模型模型表';


--
-- 转存表中的数据 `qb_cms_content1`
--

-- INSERT INTO `qb_vote_content1` VALUES ('20','1','1','连锁品牌招牌','1','1','10','1','14','0','1530608032','0','1530608032','uploads/images/20180703/1_20180703165348e12e4.jpeg','<p>连锁品牌招牌<br></p>','0','0','0','0','0','0',NULL);
-- INSERT INTO `qb_vote_content1` VALUES ('21','1','1','城市便捷招牌','1','1','22','1','2','0','1530609565','0','1530609565','uploads/images/20180703/1_20180703171920584dc.jpeg','<p><span style=\"font-size: 16px;\">近5千平花园式厂房，17年发光字、标识牌老厂。通过ISO9001-2015质量管理体系认证；通过ISO1400-2015环境管理体系认证；广东省标识行业协会推荐单位；广东省重合同守信用企业；上市公司源材料产业链，匠心打造近100家知名企业成功案例，我们将以更开放务实的姿态，迎接五湖四海的客户！全国服务热线：4006-255-229&nbsp;</span><br></p>','0','0','0','0','0','0',NULL);


-- --------------------------------------------------------

--
-- 表的结构 `qb_vote_field`
--

DROP TABLE IF EXISTS `qb_vote_field`;
CREATE TABLE `qb_vote_field` (
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
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='文档字段表';


--
-- 转存表中的数据 `qb_vote_field`
--
INSERT INTO `qb_vote_field` VALUES ('10','title','选项名称','text','varchar(256) NOT NULL','','','','0','1','','','','','','2','','','','100','1','1','1','','','','','','');
INSERT INTO `qb_vote_field` VALUES ('11','picurl','封面图','images','text NOT NULL','','','','0','1','','','','','','2','','','','100','0','0','0','','','','','','');
INSERT INTO `qb_vote_field` VALUES ('12','content','选项描述','ueditor','text NOT NULL','','','','0','1','','','','','','2','','','','98','0','0','0','','','','','','');
INSERT INTO `qb_vote_field` VALUES ('52','mobphone','联系电话','text','varchar(12)','','','联系电话，获奖后方便联系','1','1','','','','','','2','','','','99','1','0','0','','','','','','');


-- --------------------------------------------------------

--
-- 表的结构 `qb_vote_info`
--

DROP TABLE IF EXISTS `qb_vote_info`;
CREATE TABLE `qb_vote_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aid` int(11) NOT NULL COMMENT '内容ID',
  `cid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '辅栏目ID',
  `list` int(10) NOT NULL COMMENT '排序值',
  PRIMARY KEY (`id`),
  KEY `mid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容索引表';

-- --------------------------------------------------------

--
-- 表的结构 `qb_vote_module`
--

DROP TABLE IF EXISTS `qb_vote_module`;
CREATE TABLE `qb_vote_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) NOT NULL DEFAULT '' COMMENT '区分符关键字',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模型标题',
  `layout` varchar(50) NOT NULL COMMENT '模板路径',
  `icon` varchar(64) NOT NULL,
  `list` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='模型表';


--
-- 转存表中的数据 `qb_vote_module`
--
INSERT INTO `qb_vote_module` VALUES ('1','','投票模型','','','100','1515221331','0');


-- --------------------------------------------------------

--
-- 表的结构 `qb_vote_sort`
--
DROP TABLE IF EXISTS `qb_vote_sort`;
CREATE TABLE `qb_vote_sort` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL,
  `mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `name` varchar(50) NOT NULL COMMENT '投票项目名称',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '投票选项:0单选,1多选',
  `limittime` int(10) NOT NULL DEFAULT '0' COMMENT '每次投票时间间隔,0不限,单位分钟',
  `limitip` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否限制IP重复投票:0不限,1限制',
  `forbidguestvote` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否禁止游客投票:0不限,1限制',
  `repeatjoinvote` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否禁止重复报名:0不限,1限制',
  `joinbegintime` int(10) NOT NULL DEFAULT '0' COMMENT '报名开始时间',
  `joinendtime` int(10) NOT NULL DEFAULT '0' COMMENT '报名结束时间',
  `begintime` int(10) NOT NULL DEFAULT '0' COMMENT '投票开始时间',
  `endtime` int(10) NOT NULL DEFAULT '0' COMMENT '投票结束时间',
  `description` text NOT NULL COMMENT '投票内容描述',
  `list` int(10) NOT NULL,
  `logo` varchar(50) NOT NULL COMMENT '封面图',
  `template` varchar(255) NOT NULL COMMENT '模板',
  `allowpost` varchar(100) NOT NULL COMMENT '允许发布信息的用户组',
  `allowpostyz` varchar(100) NOT NULL COMMENT '允许报名自动通过审核的用户组',
  `allowview` varchar(100) NOT NULL COMMENT '允许浏览内容的用户组',
  `seo_title` varchar(255) NOT NULL COMMENT 'SEO标题',
  `seo_keywords` varchar(255) NOT NULL COMMENT 'SEO关键字',
  `seo_description` varchar(255) NOT NULL COMMENT 'SEO描述',
  `ips` text NOT NULL COMMENT '已投票的IP',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `pid` (`pid`),
  KEY `list` (`list`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='主栏目表';

-- INSERT INTO `qb_vote_sort` VALUES ('1','0','1','启达广告标识','1','0','0','1','0','1531125912','1531444449','1531015488','1532059033','近5千平花园式厂房，17年发光字、标识牌老厂。通过ISO9001-2015质量管理体系认证；通过ISO1400-2015环境管理体系认证；广东省标识行业协会推荐单位；广东省重合同守信用企业；上市公司源材料产业链，匠心打造近100家知名企业成功案例，我们将以更开放务实的姿态，迎接五湖四海的客户！全国服务热线：4006-255-229 \r\n','0','','','','','','','','127.0.0.10,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1,127.0.0.1');

--
-- 转存表中的数据 `qb_vote_member`
--

DROP TABLE IF EXISTS `qb_vote_member`;
CREATE TABLE `qb_vote_member` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '投票选项ID',
  `fid` int(7) NOT NULL COMMENT '投票项目ID',
  `uid` int(7) NOT NULL COMMENT '投票用户ID',
  `create_time` int(10) NOT NULL COMMENT '投票时间时间',
  `ip` varchar(15) COLLATE utf8_bin NOT NULL COMMENT '投票所在IP',
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '扩展字段,可拓展为1是投票',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `aid` (`aid`),
  KEY `type` (`type`),
  KEY `fid` (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户投票记录';
