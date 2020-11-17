INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO标题', 'mseo_title', '', 'text', '', 0, '', '', 100, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化关键字keywords', 'mseo_keyword', '', 'text', '', 0, '', '', 99, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化描述description', 'mseo_description', '', 'text', '', 0, '', '', 98, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否开启当前模块', 'is_open_modlue', '0', 'radio', '1|开启\r\n0|关闭', 0, '', '', 97, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '允许创建圈子的用户组', 'can_post_group', '3,12,8,11', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '这里是总开关,全留空,则都有权限,如果这里某个用户组没权限,那么下面的相应用户组创建个数设置会无效', 96, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '每个用户组对应只能创建几个圈子', 'group_create_num', '{"2":"","3":"50","8":"5","11":"5","12":"20"}', 'usergroup', '', 0, '', '模型中设置的话,就以模型中设置的为准', 0, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '圈子是否隐藏商城', 'qun_hide_shop', '1', 'radio', '0|显示\r\n1|隐藏', 0, '', '', 0, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '默认城市ID', 'city_id', '0', 'select', 'plugins\\area\\model\\Area@getTitleList@{"level":2}', 0, '', '列表页会默认显示这个城市下面的区域,不设置将无法显示区域筛选', 0, 6);


INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '发布内容显示选择圈子的频道', 'modules_show_select_qun', 'shop,bbs,cms', 'checkbox', 'app\\qun\\Info@modules@["qun,tongji,search"]', 0, '', '', 0, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '发布内容显示选择专题的频道', 'modules_show_select_topic', 'shop,bbs,cms', 'checkbox', 'app\\qun\\Info@modules@["qun,tongji,search"]', 0, '', '', 0, 6);


INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`, `version`, `version_id`) VALUES(0, 'cms_content_show', '', 'app\\qun\\hook\\Content', '圈子挂接内容显示相关权限钩子', 1, 0, '', '', '', 0);
INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`, `version`, `version_id`) VALUES(0, 'cms_add_end', '', 'app\\qun\\hook\\Content', '圈子挂接处理频道发布的内容', 1, 0, '', '', '', 0);
INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`, `version`, `version_id`) VALUES(0, 'reply_add_end', '', 'app\\qun\\hook\\Content', '圈子挂接论坛回复相关功能', 1, 0, '', '', '', 0);



DROP TABLE IF EXISTS `qb_qun_adset`;
CREATE TABLE IF NOT EXISTS `qb_qun_adset` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(50) NOT NULL COMMENT '关键字,暂时没用到',
  `title` varchar(100) NOT NULL COMMENT '广告位名称',
  `status` tinyint(1) NOT NULL COMMENT '0关闭购买,-1用户购买广告需要审核,1用户购买广告不需审核',
  `price` decimal(10,2) unsigned NOT NULL COMMENT '售价',
  `day` mediumint(5) NOT NULL COMMENT '广告时长',
  `aid` int(7) NOT NULL COMMENT '圈子ID',
  `type` tinyint(1) NOT NULL COMMENT '广告类型0是纯文本广告,暂时没用到',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告位参数设置' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_aduser`
--

DROP TABLE IF EXISTS `qb_qun_aduser`;
CREATE TABLE IF NOT EXISTS `qb_qun_aduser` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `uid` int(7) NOT NULL COMMENT '购买用户UID',
  `keyword` int(30) NOT NULL COMMENT '广告位关键字,暂时没用到',
  `aid` int(7) NOT NULL COMMENT '圈子ID',
  `ad_id` int(7) NOT NULL COMMENT '广告位ID,暂时没用到',
  `begin_time` int(10) NOT NULL COMMENT '广告开始时间',
  `end_time` int(10) NOT NULL COMMENT '广告结束时间',
  `money` decimal(10,2) NOT NULL COMMENT '广告费用',
  `create_time` int(10) NOT NULL COMMENT '添加时间',
  `type` tinyint(1) NOT NULL COMMENT '广告类型0是纯文本广告,暂时没用到',
  `title` varchar(100) NOT NULL COMMENT '广告标题',
  `picurl` varchar(255) NOT NULL COMMENT '广告图片',
  `content` text NOT NULL COMMENT '广告内容',
  `url` varchar(255) NOT NULL COMMENT '广告网址',
  `status` tinyint(1) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `ad_id` (`ad_id`),
  KEY `begin_time` (`begin_time`),
  KEY `end_time` (`end_time`),
  KEY `aid` (`aid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户购买的广告列表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_buystyle`
--

DROP TABLE IF EXISTS `qb_qun_buystyle`;
CREATE TABLE IF NOT EXISTS `qb_qun_buystyle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(8) NOT NULL DEFAULT '0' COMMENT '购买用户UID',
  `pageid` int(8) NOT NULL DEFAULT '0' COMMENT '圈子ID',
  `stylename` varchar(50) NOT NULL DEFAULT '' COMMENT '风格目录关键字',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '购买时间',
  `endtime` int(10) NOT NULL DEFAULT '0' COMMENT '风格使用截止时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='风格购买记录表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_claim`
--

DROP TABLE IF EXISTS `qb_qun_claim`;
CREATE TABLE IF NOT EXISTS `qb_qun_claim` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '圈子ID',
  `uid` int(7) NOT NULL COMMENT '申请uid',
  `create_time` int(10) NOT NULL COMMENT '申请时间',
  `linkman` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '联系人',
  `telphone` varchar(25) COLLATE utf8_bin NOT NULL COMMENT '联系电话',
  `email` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '联系邮箱',
  `why` text COLLATE utf8_bin NOT NULL COMMENT '原因说明',
  `status` tinyint(1) NOT NULL COMMENT '状态,1为同意认领,-1为拒绝认领',
  `update_time` int(10) NOT NULL COMMENT '处理时间',
  `owner_uid` int(7) NOT NULL COMMENT '原圈主uid',
  `picurl` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '证件扫描件',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `uid` (`uid`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='认领圈子' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_content`
--

DROP TABLE IF EXISTS `qb_qun_content`;
CREATE TABLE IF NOT EXISTS `qb_qun_content` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `uid` int(8) NOT NULL,
  `view` mediumint(7) NOT NULL COMMENT '浏览量',
  `status` tinyint(2) NOT NULL COMMENT '状态：0未审 1已审 2推荐',
  `list` int(10) NOT NULL COMMENT '可控排序',
  `ext_id` mediumint(7) NOT NULL COMMENT '关联其它模型的内容ID',
  `ext_sys` smallint(4) NOT NULL COMMENT '关联其它模型的频道ID',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ext_id` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='索引表' AUTO_INCREMENT=44 ;

--
-- 转存表中的数据 `qb_qun_content`
--

INSERT INTO `qb_qun_content` (`id`, `mid`, `uid`, `view`, `status`, `list`, `ext_id`, `ext_sys`) VALUES(12, 1, 1, 0, 1, 0, 0, 0);
INSERT INTO `qb_qun_content` (`id`, `mid`, `uid`, `view`, `status`, `list`, `ext_id`, `ext_sys`) VALUES(13, 1, 1, 0, 1, 0, 0, 0);
INSERT INTO `qb_qun_content` (`id`, `mid`, `uid`, `view`, `status`, `list`, `ext_id`, `ext_sys`) VALUES(14, 1, 1, 0, 1, 0, 0, 0);
INSERT INTO `qb_qun_content` (`id`, `mid`, `uid`, `view`, `status`, `list`, `ext_id`, `ext_sys`) VALUES(15, 1, 1, 0, 1, 0, 0, 0);
INSERT INTO `qb_qun_content` (`id`, `mid`, `uid`, `view`, `status`, `list`, `ext_id`, `ext_sys`) VALUES(16, 1, 1, 0, 1, 0, 0, 0);
INSERT INTO `qb_qun_content` (`id`, `mid`, `uid`, `view`, `status`, `list`, `ext_id`, `ext_sys`) VALUES(31, 1, 1, 0, 1, 0, 0, 0);
INSERT INTO `qb_qun_content` (`id`, `mid`, `uid`, `view`, `status`, `list`, `ext_id`, `ext_sys`) VALUES(30, 1, 1, 0, 1, 0, 0, 0);
INSERT INTO `qb_qun_content` (`id`, `mid`, `uid`, `view`, `status`, `list`, `ext_id`, `ext_sys`) VALUES(39, 2, 1, 0, 1, 0, 0, 0);
INSERT INTO `qb_qun_content` (`id`, `mid`, `uid`, `view`, `status`, `list`, `ext_id`, `ext_sys`) VALUES(40, 3, 1, 0, 1, 0, 0, 0);
INSERT INTO `qb_qun_content` (`id`, `mid`, `uid`, `view`, `status`, `list`, `ext_id`, `ext_sys`) VALUES(41, 4, 1, 2, 1, 1552305215, 0, 0);
INSERT INTO `qb_qun_content` (`id`, `mid`, `uid`, `view`, `status`, `list`, `ext_id`, `ext_sys`) VALUES(42, 5, 1, 0, 1, 0, 0, 0);
INSERT INTO `qb_qun_content` (`id`, `mid`, `uid`, `view`, `status`, `list`, `ext_id`, `ext_sys`) VALUES(43, 5, 1, 0, 1, 1552401049, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_content1`
--

DROP TABLE IF EXISTS `qb_qun_content1`;
CREATE TABLE IF NOT EXISTS `qb_qun_content1` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
  `replynum` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '介绍图片',
  `content` text NOT NULL COMMENT '文章内容',
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `template` varchar(255) NOT NULL COMMENT '风格模板',
  `map` varchar(32) NOT NULL COMMENT '地图坐标',
  `telphone` varchar(128) NOT NULL COMMENT '店铺联系电话',
  `address` varchar(128) NOT NULL COMMENT '地址',
  `map_x` double NOT NULL COMMENT '地图经度',
  `map_y` double NOT NULL COMMENT '地图纬度',
  `autoyz` tinyint(1) NOT NULL COMMENT '成员加入是否自动通过审核',
  `usernum` mediumint(6) NOT NULL DEFAULT '1' COMMENT '成员数',
  `viewlimit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '访问权限',
  `banner` varchar(255) NOT NULL COMMENT '圈子横幅',
  `ext_config` text NOT NULL COMMENT '扩展配置',
  `style` varchar(30) NOT NULL COMMENT '个性风格',
  `notice` varchar(255) NOT NULL COMMENT '广告通知',
  `hidetitle` tinyint(1) NOT NULL COMMENT '私密圈是否对外显示标题',
  `sncode` text NOT NULL COMMENT '申请加入需要的授权码',
  `openad` tinyint(4) NOT NULL COMMENT '是否启用广告购买',
  `wxid` varchar(25) NOT NULL COMMENT '微信号',
  `wximgcode` varchar(255) NOT NULL COMMENT '微信二维码',
  `rollpics` text NOT NULL COMMENT '幻灯片组图',
  `haibao` varchar(100) NOT NULL COMMENT '海报模板',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `openad` (`openad`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='模型表' AUTO_INCREMENT=39 ;

--
-- 转存表中的数据 `qb_qun_content1`
--

INSERT INTO `qb_qun_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `template`, `map`, `telphone`, `address`, `map_x`, `map_y`, `autoyz`, `usernum`, `viewlimit`, `banner`, `ext_config`, `style`, `notice`, `hidetitle`, `sncode`, `openad`, `wxid`, `wximgcode`, `rollpics`, `haibao`) VALUES(12, 1, 10, '亲子群', 1, 1, 12, 2, 0, 1517533498, 1552305094, 0, 'uploads/images/20180330/5bac969ebb40e2dc3b179e7995c1b071.jpg', '<p>始创于1979年,中国海外集团房地产业务平台,专注于主流城市打造主流精品物业的全国性地产品牌,中海地产集团有限公司</p>', 0, 0, 0, 0, '', '113.423763,23.127862', '0852-2823-7888', '中山698号', 113.423763, 23.127862, 0, 2, 1, '', '', '', '', 0, '', 0, '', '', '', '');
INSERT INTO `qb_qun_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `template`, `map`, `telphone`, `address`, `map_x`, `map_y`, `autoyz`, `usernum`, `viewlimit`, `banner`, `ext_config`, `style`, `notice`, `hidetitle`, `sncode`, `openad`, `wxid`, `wximgcode`, `rollpics`, `haibao`) VALUES(13, 1, 11, '碧桂园业主群', 1, 1, 4, 2, 0, 1517533576, 1552305054, 0, 'uploads/images/20180330/d5b712dc8cd476d8eef249df90234713.jpg', '<p>专注于高端物业的开发和管理,涵盖高端住宅/别墅/商业/写字楼等多种物业类型,于香港联交所上市的专业从事住宅及商业地产综合开发的企业,融创中国控股有限公司</p>', 1, 6, 8, 0, '', '113.082263,23.176774', '400-997-1918', '重庆256号', 113.082263, 23.176774, 0, 1, 0, '', '', '', '', 0, '', 0, '', '', '', '');
INSERT INTO `qb_qun_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `template`, `map`, `telphone`, `address`, `map_x`, `map_y`, `autoyz`, `usernum`, `viewlimit`, `banner`, `ext_config`, `style`, `notice`, `hidetitle`, `sncode`, `openad`, `wxid`, `wximgcode`, `rollpics`, `haibao`) VALUES(14, 1, 9, '太极达人', 1, 1, 11, 2, 0, 1517533674, 1552305011, 0, 'uploads/images/20180330/06d879b1eddcaac0780ea8ba42ebbf33.jpg', '<p>始于1992年,以商品住宅开发为主,中国保利集团控股的大型国有房地产企业,保利房地产(集团)股份有限公司)</p>', 0, 0, 0, 0, '', '113.088587,23.135838', '400-618-3009', '北京203号', 113.088587, 23.135838, 0, 2, 0, '', '', '', '', 0, '', 0, '', '', '', '');
INSERT INTO `qb_qun_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `template`, `map`, `telphone`, `address`, `map_x`, `map_y`, `autoyz`, `usernum`, `viewlimit`, `banner`, `ext_config`, `style`, `notice`, `hidetitle`, `sncode`, `openad`, `wxid`, `wximgcode`, `rollpics`, `haibao`) VALUES(15, 1, 1, '电子协会', 1, 1, 11, 2, 0, 1517533725, 1552304963, 0, 'uploads/images/20180330/94452daba2f548e0c79e159ed8cae118.jpg', '<p>成立于1992年,在超高层/大型城市综合体/高铁站商务区及产业园开发领域享誉国际,世界500强企业,上市公司,绿地控股集团有限公司</p>', 0, 0, 0, 0, '', '113.166201,23.151789', '021-53188666', '上海1025号', 113.166201, 23.151789, 0, 1, 0, '', '', '', '', 0, '', 0, '', '', '', '');
INSERT INTO `qb_qun_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `template`, `map`, `telphone`, `address`, `map_x`, `map_y`, `autoyz`, `usernum`, `viewlimit`, `banner`, `ext_config`, `style`, `notice`, `hidetitle`, `sncode`, `openad`, `wxid`, `wximgcode`, `rollpics`, `haibao`) VALUES(16, 1, 1, '东莞湖南老乡', 1, 1, 10, 2, 0, 1517533788, 1552304948, 0, 'uploads/images/20180330/5bac969ebb40e2dc3b179e7995c1b071.jpg', '<p>国内大型房地产开发企业,房地产行业大盘开发模式的倡导者,香港联交所上市公司,碧桂园控股有限公司</p>', 0, 0, 0, 0, '', '113.300731,23.157105', '400-891-9338', '顺德1025号', 113.300731, 23.157105, 0, 1, 0, '', '', '', '', 0, '', 0, '', '', '', '');
INSERT INTO `qb_qun_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `template`, `map`, `telphone`, `address`, `map_x`, `map_y`, `autoyz`, `usernum`, `viewlimit`, `banner`, `ext_config`, `style`, `notice`, `hidetitle`, `sncode`, `openad`, `wxid`, `wximgcode`, `rollpics`, `haibao`) VALUES(31, 1, 9, '上洞村', 1, 1, 71, 2, 0, 1517533867, 1530582014, 0, 'uploads/images/20180312/1d988146be839a28964429913a06e336.jpeg', '<p>&nbsp;世界500强企业,上市公司,国内著名精品地产品牌,集民生地产/旅游综合体/体育及文化产业于一体的综合性企业,恒大集团</p>', 0, 0, 0, 0, '', '113.264026,23.167538', '400-889-3333', '广州大道102号', 113.264026, 23.167538, 0, 2, 1, '', '', '', '', 0, '', 0, '', '', '', '');
INSERT INTO `qb_qun_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `template`, `map`, `telphone`, `address`, `map_x`, `map_y`, `autoyz`, `usernum`, `viewlimit`, `banner`, `ext_config`, `style`, `notice`, `hidetitle`, `sncode`, `openad`, `wxid`, `wximgcode`, `rollpics`, `haibao`) VALUES(30, 1, 10, '足球俱乐部', 0, 1, 542, 2, 0, 1520845811, 1552304915, 0, '', '<p>成立于1984年,专注于房地产开发及物业服务的高新技术企业,上市公司,世界500企业,万科企业股份有限公司</p>', 0, 0, 0, 0, '', '113.351234,22.961218', '0755652122', '佛山中山八路103号', 113.351234, 22.961218, 0, 3, 0, '', '', '', '', 0, '', 0, '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_content2`
--

DROP TABLE IF EXISTS `qb_qun_content2`;
CREATE TABLE IF NOT EXISTS `qb_qun_content2` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
  `replynum` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '介绍图片',
  `content` text NOT NULL COMMENT '文章内容',
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `template` varchar(255) NOT NULL COMMENT '风格模板',
  `map` varchar(32) NOT NULL COMMENT '地图坐标',
  `telphone` varchar(128) NOT NULL COMMENT '店铺联系电话',
  `address` varchar(128) NOT NULL COMMENT '地址',
  `map_x` double NOT NULL COMMENT '地图经度',
  `map_y` double NOT NULL COMMENT '地图纬度',
  `autoyz` tinyint(1) NOT NULL COMMENT '成员加入是否自动通过审核',
  `usernum` mediumint(6) NOT NULL DEFAULT '1' COMMENT '成员数',
  `viewlimit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '访问权限',
  `banner` varchar(255) NOT NULL COMMENT '圈子横幅',
  `ext_config` text NOT NULL COMMENT '扩展配置',
  `style` varchar(30) NOT NULL COMMENT '个性风格',
  `notice` varchar(255) NOT NULL COMMENT '广告通知',
  `hidetitle` tinyint(1) NOT NULL COMMENT '私密圈是否对外显示标题',
  `sncode` text NOT NULL COMMENT '申请加入需要的授权码',
  `openad` tinyint(4) NOT NULL COMMENT '是否启用广告购买',
  `wxid` varchar(25) NOT NULL COMMENT '微信号',
  `wximgcode` varchar(255) NOT NULL COMMENT '微信二维码',
  `rollpics` text NOT NULL COMMENT '幻灯片组图',
  `haibao` varchar(100) NOT NULL COMMENT '海报模板',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `openad` (`openad`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商铺黄页内容主表' AUTO_INCREMENT=40 ;

--
-- 转存表中的数据 `qb_qun_content2`
--

INSERT INTO `qb_qun_content2` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `template`, `map`, `telphone`, `address`, `map_x`, `map_y`, `autoyz`, `usernum`, `viewlimit`, `banner`, `ext_config`, `style`, `notice`, `hidetitle`, `sncode`, `openad`, `wxid`, `wximgcode`, `rollpics`, `haibao`) VALUES(39, 2, 12, '阿婆湘菜馆', 0, 1, 1, 1, 0, 1552008053, 1552008763, 1552008053, '', '<p>最正宗的湖南菜</p>', 1, 6, 7, 17, '', '113.282101,22.958436', '02028988545', '广州市番禺区桥兴大道403号潮联商务中心409室', 113.282101, 22.958436, 0, 1, 0, '', '', '', '', 0, '', 0, '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_content3`
--

DROP TABLE IF EXISTS `qb_qun_content3`;
CREATE TABLE IF NOT EXISTS `qb_qun_content3` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
  `replynum` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '介绍图片',
  `content` text NOT NULL COMMENT '文章内容',
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `template` varchar(255) NOT NULL COMMENT '风格模板',
  `map` varchar(32) NOT NULL COMMENT '地图坐标',
  `telphone` varchar(128) NOT NULL COMMENT '店铺联系电话',
  `address` varchar(128) NOT NULL COMMENT '地址',
  `map_x` double NOT NULL COMMENT '地图经度',
  `map_y` double NOT NULL COMMENT '地图纬度',
  `autoyz` tinyint(1) NOT NULL COMMENT '成员加入是否自动通过审核',
  `usernum` mediumint(6) NOT NULL DEFAULT '1' COMMENT '成员数',
  `viewlimit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '访问权限',
  `banner` varchar(255) NOT NULL COMMENT '圈子横幅',
  `ext_config` text NOT NULL COMMENT '扩展配置',
  `style` varchar(30) NOT NULL COMMENT '个性风格',
  `notice` varchar(255) NOT NULL COMMENT '广告通知',
  `hidetitle` tinyint(1) NOT NULL COMMENT '私密圈是否对外显示标题',
  `sncode` text NOT NULL COMMENT '申请加入需要的授权码',
  `openad` tinyint(4) NOT NULL COMMENT '是否启用广告购买',
  `wxid` varchar(25) NOT NULL COMMENT '微信号',
  `wximgcode` varchar(255) NOT NULL COMMENT '微信二维码',
  `rollpics` text NOT NULL COMMENT '幻灯片组图',
  `haibao` varchar(100) NOT NULL COMMENT '海报模板',
  `company` varchar(125) NOT NULL COMMENT '所属企业',
  `job` varchar(50) NOT NULL COMMENT '职位头衔',
  `motto` varchar(50) NOT NULL COMMENT '人生格言',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `openad` (`openad`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='电子名片内容主表' AUTO_INCREMENT=41 ;

--
-- 转存表中的数据 `qb_qun_content3`
--

INSERT INTO `qb_qun_content3` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `template`, `map`, `telphone`, `address`, `map_x`, `map_y`, `autoyz`, `usernum`, `viewlimit`, `banner`, `ext_config`, `style`, `notice`, `hidetitle`, `sncode`, `openad`, `wxid`, `wximgcode`, `rollpics`, `haibao`, `company`, `job`, `motto`) VALUES(40, 3, 18, '黄小生', 0, 1, 1, 1, 0, 1552009519, 1552304856, 1552009519, '', '<p>专业贷款,费率低,无视黑户</p>', 1, 6, 0, 0, '', '110.256437,25.195815', '13565478521', '广州天河区建中路123号5楼', 110.256437, 25.195815, 0, 1, 0, '', '', '', '', 0, '', 0, '1235445544', '', '', '', '广州齐博网络科技有限公司', '业务经理', '诚信为本、信誉为天');

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_content4`
--

DROP TABLE IF EXISTS `qb_qun_content4`;
CREATE TABLE IF NOT EXISTS `qb_qun_content4` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
  `replynum` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '介绍图片',
  `content` text NOT NULL COMMENT '文章内容',
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `template` varchar(255) NOT NULL COMMENT '风格模板',
  `map` varchar(32) NOT NULL COMMENT '地图坐标',
  `telphone` varchar(128) NOT NULL COMMENT '店铺联系电话',
  `address` varchar(128) NOT NULL COMMENT '地址',
  `map_x` double NOT NULL COMMENT '地图经度',
  `map_y` double NOT NULL COMMENT '地图纬度',
  `autoyz` tinyint(1) NOT NULL COMMENT '成员加入是否自动通过审核',
  `usernum` mediumint(6) NOT NULL DEFAULT '1' COMMENT '成员数',
  `viewlimit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '访问权限',
  `banner` varchar(255) NOT NULL COMMENT '圈子横幅',
  `ext_config` text NOT NULL COMMENT '扩展配置',
  `style` varchar(30) NOT NULL COMMENT '个性风格',
  `notice` varchar(255) NOT NULL COMMENT '广告通知',
  `hidetitle` tinyint(1) NOT NULL COMMENT '私密圈是否对外显示标题',
  `sncode` text NOT NULL COMMENT '申请加入需要的授权码',
  `openad` tinyint(4) NOT NULL COMMENT '是否启用广告购买',
  `rollpics` text NOT NULL COMMENT '幻灯片组图',
  `haibao` varchar(100) NOT NULL COMMENT '海报模板',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `openad` (`openad`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='景点村庄内容主表' AUTO_INCREMENT=42 ;

--
-- 转存表中的数据 `qb_qun_content4`
--

INSERT INTO `qb_qun_content4` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `template`, `map`, `telphone`, `address`, `map_x`, `map_y`, `autoyz`, `usernum`, `viewlimit`, `banner`, `ext_config`, `style`, `notice`, `hidetitle`, `sncode`, `openad`, `rollpics`, `haibao`) VALUES(41, 4, 22, '黄山景区', 0, 1, 2, 1, 0, 1552305214, 1552307354, 1552305215, '', '<p>世界文化与自然双重遗产，世界地质公园，国家AAAAA级旅游景区，国家级风景名胜区，全国文明风景旅游区示范点，中华十大名山，天下第一奇山。</p><p>黄山位于安徽省南部黄山市境内，有72峰，主峰莲花峰海拔1864米，与光明顶、天都峰并称三大黄山主峰，为36大峰之一。黄山是安徽旅游的标志，是中国十大风景名胜唯一的山岳风光。</p><p>黄山原名“黟山”，因峰岩青黑，遥望苍黛而名。后因传说轩辕黄帝曾在此炼丹，故改名为“黄山”。黄山代表景观有“四绝三瀑”，四绝：奇松、怪石、云海、温泉；三瀑：人字瀑、百丈泉、九龙瀑。黄山迎客松是安徽人民热情友好的象征，承载着拥抱世界的东方礼仪文化。</p><p>明朝旅行家徐霞客登临黄山时赞叹：“薄海内外之名山，无如徽之黄山。登黄山，天下无山，观止矣！”被后人引申为“五岳归来不看山，黄山归来不看岳”。</p><p><br/></p>', 0, 0, 0, 0, '', '118.194948,30.088963', '400-889-3333', '安徽省黄山市', 118.194948, 30.088963, 0, 1, 0, '', '', '', '', 0, '', 0, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_content5`
--

DROP TABLE IF EXISTS `qb_qun_content5`;
CREATE TABLE IF NOT EXISTS `qb_qun_content5` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
  `replynum` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '介绍图片',
  `content` text NOT NULL COMMENT '文章内容',
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `template` varchar(255) NOT NULL COMMENT '风格模板',
  `map` varchar(32) NOT NULL COMMENT '地图坐标',
  `telphone` varchar(128) NOT NULL COMMENT '店铺联系电话',
  `address` varchar(128) NOT NULL COMMENT '地址',
  `map_x` double NOT NULL COMMENT '地图经度',
  `map_y` double NOT NULL COMMENT '地图纬度',
  `autoyz` tinyint(1) NOT NULL COMMENT '成员加入是否自动通过审核',
  `usernum` mediumint(6) NOT NULL DEFAULT '1' COMMENT '成员数',
  `viewlimit` tinyint(1) NOT NULL DEFAULT '0' COMMENT '访问权限',
  `banner` varchar(255) NOT NULL COMMENT '圈子横幅',
  `ext_config` text NOT NULL COMMENT '扩展配置',
  `style` varchar(30) NOT NULL COMMENT '个性风格',
  `notice` varchar(255) NOT NULL COMMENT '广告通知',
  `hidetitle` tinyint(1) NOT NULL COMMENT '私密圈是否对外显示标题',
  `sncode` text NOT NULL COMMENT '申请加入需要的授权码',
  `openad` tinyint(4) NOT NULL COMMENT '是否启用广告购买',
  `wxid` varchar(25) NOT NULL COMMENT '微信号',
  `wximgcode` varchar(255) NOT NULL COMMENT '微信二维码',
  `rollpics` text NOT NULL COMMENT '幻灯片组图',
  `haibao` varchar(100) NOT NULL COMMENT '海报模板',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `openad` (`openad`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='网店微商内容主表' AUTO_INCREMENT=44 ;

--
-- 转存表中的数据 `qb_qun_content5`
--

INSERT INTO `qb_qun_content5` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `template`, `map`, `telphone`, `address`, `map_x`, `map_y`, `autoyz`, `usernum`, `viewlimit`, `banner`, `ext_config`, `style`, `notice`, `hidetitle`, `sncode`, `openad`, `wxid`, `wximgcode`, `rollpics`, `haibao`) VALUES(42, 5, 27, '雅诗兰黛', 0, 1, 0, 1, 0, 1552400690, 0, 1552400690, '', '<p>别的护肤品，中国的可能赶不上日韩的产品，但是国产面膜真的不比日韩的差，日韩的国土面膜就出不了原料，你要是研发，现在中国的研发比日本的差吧，中国现在的科技研发不能说最强吧，但是早就超过日本和韩国了，大家看看家电，无线支付，高铁等等，那一项不甩韩国几条街，日本技术还是可以的，咱们实话实说，但是韩国的面膜，真的是全靠包装和香料，没什么技术含量，所以我们说国产面膜秒杀日韩真的不是吹，是很多效果确实比日韩的好，只要大家用心对比一下就知道。</p>', 0, 0, 0, 0, '', '50,0', '400-889-3333', '', 50, 0, 0, 1, 0, '', '', '', '', 0, '', 0, '1235445544', '', '', '');
INSERT INTO `qb_qun_content5` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `template`, `map`, `telphone`, `address`, `map_x`, `map_y`, `autoyz`, `usernum`, `viewlimit`, `banner`, `ext_config`, `style`, `notice`, `hidetitle`, `sncode`, `openad`, `wxid`, `wximgcode`, `rollpics`, `haibao`) VALUES(43, 5, 27, '萧县水晶梨', 0, 1, 0, 1, 0, 1552401049, 1552401221, 1552401049, '', '<p>栽培方式采用网架整枝，改善风条件，同时全部实行果实套袋，既保证果实无污染，又能改变果实外观品质，所产水果个大、皮薄、果心小、无石细胞、早熟、具有很强的市场优势，价格可达30元/斤。巨大的经济效益引发了全县发展水晶梨的高潮，广大果农纷纷改接水晶梨。2003年东阁园艺场又引进幸水、黄冠、圆黄、绿宝石等新品种喜获成功，从此改变了萧县梨树栽培砀山酥梨一统天下的时代，到2005年底，全县水晶梨总面积达3万亩，产量达1万亿斤以上，经济效益十分可观</p>', 1, 6, 7, 17, '', '50,0', '400-889-3333', '', 50, 0, 0, 1, 0, '', '', '', '', 0, '', 0, '1235445544', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_field`
--

DROP TABLE IF EXISTS `qb_qun_field`;
CREATE TABLE IF NOT EXISTS `qb_qun_field` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '字段名称',
  `name` varchar(32) NOT NULL,
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '字段标题',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT '字段类型',
  `field_type` varchar(128) NOT NULL DEFAULT '' COMMENT '字段定义',
  `value` text COMMENT '默认值',
  `options` text COMMENT '额外选项',
  `about` varchar(256) NOT NULL DEFAULT '' COMMENT '提示说明',
  `show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `mid` int(8) NOT NULL DEFAULT '0' COMMENT '所属模型id',
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文档字段表' AUTO_INCREMENT=141 ;

--
-- 转存表中的数据 `qb_qun_field`
--

INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(10, 'title', '圈子名称', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(11, 'picurl', '介绍图片', 'image', 'varchar(60) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(12, 'content', '圈子介绍', 'ueditor', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(50, 'telphone', '管理员电话', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(49, 'map', '地图坐标', 'bmap', 'varchar(32) NOT NULL', '50', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(51, 'address', '地址', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(52, 'autoyz', '成员加入是否自动通过审核', 'radio', 'tinyint(1) NOT NULL', '0', '0|需要人工审核\r\n1|自动通过审核\r\n-1|只能通过授权码加入\r\n-2|禁止加入', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(53, 'viewlimit', '访问权限', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '', '0|不限制\r\n1|只有正式会员才能访问', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(54, 'banner', '圈子横幅', 'image', 'varchar(255) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(55, 'style', '个性风格', 'select', 'varchar(30) NOT NULL', '', 'app\\common\\util\\Style@get_style@["qun"]', '<script>$("#form_group_style").hide();/*隐藏起来*/</script>', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(56, 'notice', '广告通知', 'textarea', 'varchar(255) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(57, 'hidetitle', '是否对外隐藏标题', 'radio', 'tinyint(2) NOT NULL DEFAULT ''0''', '', '0|公开标题\r\n1|隐藏标题', '仅针对私密圈才能隐藏,就是不显示在论坛列表的意思', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(58, 'sncode', '成员加入授权码', 'textarea', 'text NOT NULL', '', '', '每个授权码换一行<a href="http://www.qibosoft.com/get_sn.php" target="_blank">批量生成授权码</a>', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(59, 'wxid', '微信号', 'text', 'varchar(25) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(60, 'wximgcode', '微信二维码', 'image', 'varchar(255) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(61, 'rollpics', '幻灯片组图', 'images', 'text NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(64, 'title', '商家名称', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(63, 'haibao', '海报模板', 'text', 'varchar(100) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(65, 'picurl', '介绍图片', 'image', 'varchar(60) NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', 100, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(66, 'content', '商家介绍', 'ueditor', 'text NOT NULL', '', '', '', 0, 2, '', '', '', '', '', 2, '', '', '', 100, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(67, 'telphone', '商家电话', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(68, 'map', '地图坐标', 'bmap', 'varchar(32) NOT NULL', '50', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(69, 'address', '商家地址', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(70, 'autoyz', '客户加入是否自动通过审核', 'radio', 'tinyint(1) NOT NULL', '0', '0|需要人工审核\r\n1|自动通过审核\r\n-1|只能通过授权码加入\r\n-2|禁止加入', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(71, 'viewlimit', '访问权限', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '', '0|不限制\r\n1|只有正式会员才能访问', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(72, 'banner', '横幅图片', 'image', 'varchar(255) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(73, 'style', '个性风格', 'select', 'varchar(30) NOT NULL', '', 'app\\common\\util\\Style@get_style@["qun"]', '<script>$("#form_group_style").hide();/*隐藏起来*/</script>', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(74, 'notice', '广告通知', 'textarea', 'varchar(255) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(75, 'hidetitle', '是否对外隐藏标题', 'radio', 'tinyint(2) NOT NULL DEFAULT ''0''', '', '0|公开标题\r\n1|隐藏标题', '仅针对私密圈才能隐藏,就是不显示在论坛列表的意思', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(76, 'sncode', '客户加入授权码', 'textarea', 'text NOT NULL', '', '', '每个授权码换一行<a href="http://www.qibosoft.com/get_sn.php" target="_blank">批量生成授权码</a>', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(77, 'wxid', '微信号', 'text', 'varchar(25) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(78, 'wximgcode', '微信二维码', 'image', 'varchar(255) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(79, 'rollpics', '幻灯片组图', 'images', 'text NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(80, 'haibao', '海报模板', 'text', 'varchar(100) NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(81, 'title', '姓名称呼', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 3, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(82, 'picurl', '名片头像', 'image', 'varchar(60) NOT NULL', '', '', '', 0, 3, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(83, 'content', '业务介绍', 'ueditor', 'text NOT NULL', '', '', '', 0, 3, '', '', '', '', '', 2, '', '', '', -2, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(84, 'telphone', '联系电话', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(85, 'map', '地图坐标', 'bmap', 'varchar(32) NOT NULL', '50', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(86, 'address', '联系地址', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(87, 'autoyz', '粉丝加入是否自动通过审核', 'radio', 'tinyint(1) NOT NULL', '0', '0|需要人工审核\r\n1|自动通过审核\r\n-1|只能通过授权码加入\r\n-2|禁止加入', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(88, 'viewlimit', '访问权限', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '', '0|不限制\r\n1|只有正式粉丝会员才能访问', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(89, 'banner', '名片横幅图', 'image', 'varchar(255) NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(90, 'style', '个性风格', 'select', 'varchar(30) NOT NULL', '', 'app\\common\\util\\Style@get_style@["qun"]', '<script>$("#form_group_style").hide();/*隐藏起来*/</script>', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(91, 'notice', '公告通知', 'textarea', 'varchar(255) NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(92, 'hidetitle', '是否对外隐藏标题', 'radio', 'tinyint(2) NOT NULL DEFAULT ''0''', '', '0|公开标题\r\n1|隐藏标题', '仅针对私密圈才能隐藏,就是不显示在论坛列表的意思', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(93, 'sncode', '粉丝加入授权码', 'textarea', 'text NOT NULL', '', '', '每个授权码换一行<a href="http://www.qibosoft.com/get_sn.php" target="_blank">批量生成授权码</a>', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(94, 'wxid', '微信号', 'text', 'varchar(25) NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(95, 'wximgcode', '微信二维码', 'image', 'varchar(255) NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(96, 'rollpics', '幻灯片组图', 'images', 'text NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(97, 'haibao', '海报模板', 'text', 'varchar(100) NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', -3, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(98, 'company', '所属企业', 'text', 'varchar(125) NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 99, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(99, 'job', '职位头衔', 'text', 'varchar(50) NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 98, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(100, 'motto', '人生格言', 'text', 'varchar(50) NOT NULL', '诚信为本、顾客至上', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(101, 'title', '地点名称', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 4, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(102, 'picurl', 'LOGO标志', 'image', 'varchar(60) NOT NULL', '', '', '', 0, 4, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(103, 'content', '相关介绍', 'ueditor', 'text NOT NULL', '', '', '', 0, 4, '', '', '', '', '', 2, '', '', '', -2, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(104, 'telphone', '联系电话', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(105, 'map', '地图坐标', 'bmap', 'varchar(32) NOT NULL', '50', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(106, 'address', '联系地址', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(107, 'autoyz', '用户加入是否自动通过审核', 'radio', 'tinyint(1) NOT NULL', '0', '0|需要人工审核\r\n1|自动通过审核\r\n-1|只能通过授权码加入\r\n-2|禁止加入', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(108, 'viewlimit', '访问权限', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '', '0|不限制\r\n1|只有正式粉丝会员才能访问', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(109, 'banner', '横幅图', 'image', 'varchar(255) NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(110, 'style', '个性风格', 'select', 'varchar(30) NOT NULL', '', 'app\\common\\util\\Style@get_style@["qun"]', '<script>$("#form_group_style").hide();/*隐藏起来*/</script>', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(111, 'notice', '公告通知', 'textarea', 'varchar(255) NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(112, 'hidetitle', '是否对外隐藏标题', 'radio', 'tinyint(2) NOT NULL DEFAULT ''0''', '', '0|公开标题\r\n1|隐藏标题', '仅针对私密圈才能隐藏,就是不显示在论坛列表的意思', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(113, 'sncode', '粉丝加入授权码', 'textarea', 'text NOT NULL', '', '', '每个授权码换一行<a href="http://www.qibosoft.com/get_sn.php" target="_blank">批量生成授权码</a>', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(123, 'content', '相关介绍', 'ueditor', 'text NOT NULL', '', '', '', 0, 5, '', '', '', '', '', 2, '', '', '', -2, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(122, 'picurl', 'LOGO标志', 'image', 'varchar(60) NOT NULL', '', '', '', 0, 5, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(116, 'rollpics', '幻灯片组图', 'images', 'text NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(117, 'haibao', '海报模板', 'text', 'varchar(100) NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', -3, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(124, 'telphone', '联系电话', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(121, 'title', '网店名称', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 5, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(125, 'map', '地图坐标', 'bmap', 'varchar(32) NOT NULL', '50', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(126, 'address', '联系地址', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(127, 'autoyz', '粉丝加入是否自动通过审核', 'radio', 'tinyint(1) NOT NULL', '0', '0|需要人工审核\r\n1|自动通过审核\r\n-1|只能通过授权码加入\r\n-2|禁止加入', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(128, 'viewlimit', '访问权限', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '', '0|不限制\r\n1|只有正式粉丝会员才能访问', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(129, 'banner', '横幅图', 'image', 'varchar(255) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(130, 'style', '个性风格', 'select', 'varchar(30) NOT NULL', '', 'app\\common\\util\\Style@get_style@["qun"]', '<script>$("#form_group_style").hide();/*隐藏起来*/</script>', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(131, 'notice', '公告通知', 'textarea', 'varchar(255) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(132, 'hidetitle', '是否对外隐藏标题', 'radio', 'tinyint(2) NOT NULL DEFAULT ''0''', '', '0|公开标题\r\n1|隐藏标题', '仅针对私密圈才能隐藏,就是不显示在论坛列表的意思', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(133, 'sncode', '粉丝加入授权码', 'textarea', 'text NOT NULL', '', '', '每个授权码换一行<a href="http://www.qibosoft.com/get_sn.php" target="_blank">批量生成授权码</a>', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(134, 'wxid', '微信号', 'text', 'varchar(25) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(135, 'wximgcode', '微信二维码', 'image', 'varchar(255) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(136, 'rollpics', '幻灯片组图', 'images', 'text NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(137, 'haibao', '海报模板', 'text', 'varchar(100) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', -3, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_groups`
--

DROP TABLE IF EXISTS `qb_qun_groups`;
CREATE TABLE IF NOT EXISTS `qb_qun_groups` (
  `id` int(7) NOT NULL AUTO_INCREMENT COMMENT '记录',
  `aid` int(7) NOT NULL COMMENT '圈子ID',
  `type` tinyint(2) NOT NULL COMMENT '圈子用户组ID',
  `name` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '用户组名',
  `cfg` text COLLATE utf8_bin NOT NULL COMMENT '相关权限',
  `list` int(10) NOT NULL COMMENT '排序值',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='圈子用户组及权限' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_member`
--

DROP TABLE IF EXISTS `qb_qun_member`;
CREATE TABLE IF NOT EXISTS `qb_qun_member` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '圈子ID',
  `uid` int(7) NOT NULL COMMENT '用户ID',
  `create_time` int(10) NOT NULL COMMENT '加入时间',
  `type` tinyint(1) NOT NULL COMMENT '0是待审核,1是已审核,2是副管理员,3是管理员,4是VIP会员',
  `update_time` int(10) NOT NULL COMMENT '最后访问时间',
  `view` mediumint(7) NOT NULL DEFAULT '1' COMMENT '访问次数',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`,`update_time`,`type`),
  KEY `view` (`view`),
  KEY `uid` (`uid`,`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='圈子成员' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `qb_qun_member`
--

INSERT INTO `qb_qun_member` (`id`, `aid`, `uid`, `create_time`, `type`, `update_time`, `view`) VALUES(1, 39, 1, 1552008053, 3, 1552013521, 1);
INSERT INTO `qb_qun_member` (`id`, `aid`, `uid`, `create_time`, `type`, `update_time`, `view`) VALUES(2, 40, 1, 1552009519, 3, 1552304839, 1);
INSERT INTO `qb_qun_member` (`id`, `aid`, `uid`, `create_time`, `type`, `update_time`, `view`) VALUES(3, 41, 1, 1552305214, 3, 1552308679, 1);
INSERT INTO `qb_qun_member` (`id`, `aid`, `uid`, `create_time`, `type`, `update_time`, `view`) VALUES(4, 42, 1, 1552400690, 3, 1552400690, 1);
INSERT INTO `qb_qun_member` (`id`, `aid`, `uid`, `create_time`, `type`, `update_time`, `view`) VALUES(5, 43, 1, 1552401049, 3, 1552401049, 1);

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_menu`
--

DROP TABLE IF EXISTS `qb_qun_menu`;
CREATE TABLE IF NOT EXISTS `qb_qun_menu` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `pid` mediumint(5) NOT NULL DEFAULT '0' COMMENT '父ID',
  `uid` mediumint(7) NOT NULL COMMENT '用户id',
  `aid` int(7) NOT NULL COMMENT '圈子黄页ID',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1是底部菜单,2是头部菜单',
  `name` varchar(40) NOT NULL DEFAULT '' COMMENT '链接名称',
  `url` varchar(150) NOT NULL DEFAULT '' COMMENT '链接地址',
  `target` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0本窗口打开,1新窗口打开',
  `ifshow` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1显示,0隐藏',
  `list` smallint(4) NOT NULL DEFAULT '0' COMMENT '排序值',
  `style` varchar(30) NOT NULL DEFAULT '' COMMENT 'CSS类名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户定义的导航菜单' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_module`
--

DROP TABLE IF EXISTS `qb_qun_module`;
CREATE TABLE IF NOT EXISTS `qb_qun_module` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='模型表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `qb_qun_module`
--

INSERT INTO `qb_qun_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`, `haibao`) VALUES(1, '', '圈子社群', '', '', 100, 1515221331, 0, '');
INSERT INTO `qb_qun_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`, `haibao`) VALUES(2, '', '商铺黄页', '', '', 100, 1552006179, 0, '');
INSERT INTO `qb_qun_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`, `haibao`) VALUES(3, '', '电子名片', '', '', 100, 1552006424, 0, '');
INSERT INTO `qb_qun_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`, `haibao`) VALUES(4, '', '景点村庄', '', '', 100, 1552304554, 0, '');
INSERT INTO `qb_qun_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`, `haibao`) VALUES(5, '', '网店微商', '', '', 100, 1552399564, 0, '');


DROP TABLE IF EXISTS `qb_qun_sort`;
CREATE TABLE IF NOT EXISTS `qb_qun_sort` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='主栏目表' AUTO_INCREMENT=31 ;

--
-- 转存表中的数据 `qb_qun_sort`
--

INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(9, 2, 1, '技能达人', 10, 'fa fa-fw fa-users', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(10, 2, 1, '兴趣部落', 9, 'fa fa-fw fa-bicycle', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(11, 2, 1, '小区社群', 8, 'fa fa-fw fa-tachometer', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(1, 2, 1, '协会商会', 0, 'fa fa-fw fa-credit-card', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(2, 0, 1, '圈子社群', 0, 'fa fa-fw fa-life-ring', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(3, 0, 2, '商家黄页', 0, 'fa fa-fw fa-institution', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(4, 0, 3, '电子名片', 0, '', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(12, 3, 2, '餐饮美食', 0, 'fa fa-fw fa-cutlery', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(13, 3, 2, '娱乐休闲', 0, 'fa fa-fw fa-twitter', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(14, 3, 2, '教育培训', 0, 'fa fa-fw fa-gavel', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(15, 3, 2, '生活服务', 0, 'fa fa-fw fa-user-md', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(16, 4, 3, '维修保洁', 0, 'fa fa-fw fa-gear', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(17, 4, 3, '拉货回收', 0, 'fa fa-fw fa-taxi', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(18, 4, 3, '保险贷款', 0, 'fa fa-fw fa-ruble', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(19, 4, 3, '中介代理', 0, 'fa fa-fw fa-thumbs-up', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(5, 0, 4, '景点村落', 0, 'glyphicon glyphicon-certificate', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(22, 5, 4, '景点古迹', 0, 'fa fa-fw fa-github-square', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(23, 5, 4, '乡村小区', 0, 'fa fa-fw fa-university', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(24, 5, 4, '中小学校', 0, 'fa fa-fw fa-graduation-cap', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(25, 5, 4, '风俗特产', 0, 'fa fa-fw fa-ravelry', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(26, 0, 5, '网店微商', 0, 'fa fa-fw fa-vimeo-square', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(27, 26, 5, '生鲜特产', 0, 'glyphicon glyphicon-apple', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(28, 26, 5, '保健美容', 0, 'fa fa-fw fa-bed', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(29, 26, 5, '衣帽服饰', 0, 'fa fa-fw fa-user-secret', '', '', '', '', '', '');
INSERT INTO `qb_qun_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES(30, 26, 5, '数码电器', 0, 'fa fa-fw fa-laptop', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `qb_qun_visit`
--

DROP TABLE IF EXISTS `qb_qun_visit`;
CREATE TABLE IF NOT EXISTS `qb_qun_visit` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '圈子ID',
  `uid` int(7) NOT NULL COMMENT '用户ID',
  `visittime` int(10) NOT NULL COMMENT '最后访问时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `aid` (`aid`),
  KEY `visittime` (`visittime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户访问过的圈子' AUTO_INCREMENT=4 ;

UPDATE  `qb_qun_field` SET  `value` =  '' WHERE  `name` =  'map';

ALTER TABLE  `qb_qun_menu` ADD INDEX (  `aid` ,  `type` ,  `ifshow` ,  `list` );





INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`, `version`, `version_id`) VALUES(0, 'user_leave', '', 'app\\qun\\hook\\Content', '直播课堂观看时间统计', 1, 0, '', '', '', 0);

DROP TABLE IF EXISTS `qb_qun_order`;
CREATE TABLE IF NOT EXISTS `qb_qun_order` (
  `id` mediumint(7) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(7) NOT NULL COMMENT '购买者UID',
  `aid` mediumint(7) NOT NULL COMMENT '使用的圈子ID',
  `timelong` mediumint(7) NOT NULL COMMENT '购买总时长(秒)',
  `usetime` mediumint(7) NOT NULL COMMENT '已使用时间(秒)',
  `create_time` int(10) NOT NULL COMMENT '购买时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='会员课堂(直播)时长购买订单' AUTO_INCREMENT=1 ;


INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'minute_money', '课堂时长收费', 'money', 'decimal(6,2) unsigned NOT NULL', '', '', '每分钟,单位(元)，VIP会员免费观看，不设置所有用户都免费收看', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'free_time', '课堂试看时长', 'number', 'mediumint(7) NOT NULL DEFAULT ''0''', '10', '', '单位分钟,为0或者不设置的话,即代表不给试看', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 1);
ALTER TABLE  `qb_qun_content1` ADD  `minute_money` DECIMAL( 6, 2 ) NOT NULL COMMENT  '课堂时长收费',ADD  `free_time` MEDIUMINT( 7 ) NOT NULL COMMENT  '课堂试看时长';

INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'minute_money', '课堂时长收费', 'money', 'decimal(6,2) unsigned NOT NULL', '', '', '每分钟,单位(元)，VIP会员免费观看，不设置所有用户都免费收看', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'free_time', '课堂试看时长', 'number', 'mediumint(7) NOT NULL DEFAULT ''0''', '10', '', '单位分钟,为0或者不设置的话,即代表不给试看', 1, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 1);
ALTER TABLE  `qb_qun_content2` ADD  `minute_money` DECIMAL( 6, 2 ) NOT NULL COMMENT  '课堂时长收费',ADD  `free_time` MEDIUMINT( 7 ) NOT NULL COMMENT  '课堂试看时长';

INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'minute_money', '课堂时长收费', 'money', 'decimal(6,2) unsigned NOT NULL', '', '', '每分钟,单位(元)，VIP会员免费观看，不设置所有用户都免费收看', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'free_time', '课堂试看时长', 'number', 'mediumint(7) NOT NULL DEFAULT ''0''', '10', '', '单位分钟,为0或者不设置的话,即代表不给试看', 1, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 1);
ALTER TABLE  `qb_qun_content3` ADD  `minute_money` DECIMAL( 6, 2 ) NOT NULL COMMENT  '课堂时长收费',ADD  `free_time` MEDIUMINT( 7 ) NOT NULL COMMENT  '课堂试看时长';

INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'minute_money', '课堂时长收费', 'money', 'decimal(6,2) unsigned NOT NULL', '', '', '每分钟,单位(元)，VIP会员免费观看，不设置所有用户都免费收看', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'free_time', '课堂试看时长', 'number', 'mediumint(7) NOT NULL DEFAULT ''0''', '10', '', '单位分钟,为0或者不设置的话,即代表不给试看', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 1);
ALTER TABLE  `qb_qun_content4` ADD  `minute_money` DECIMAL( 6, 2 ) NOT NULL COMMENT  '课堂时长收费',ADD  `free_time` MEDIUMINT( 7 ) NOT NULL COMMENT  '课堂试看时长';

INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'minute_money', '课堂时长收费', 'money', 'decimal(6,2) unsigned NOT NULL', '', '', '每分钟,单位(元)，VIP会员免费观看，不设置所有用户都免费收看', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'free_time', '课堂试看时长', 'number', 'mediumint(7) NOT NULL DEFAULT ''0''', '10', '', '单位分钟,为0或者不设置的话,即代表不给试看', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置', '', '', '', '', '', '', '', '', '', 1);
ALTER TABLE  `qb_qun_content5` ADD  `minute_money` DECIMAL( 6, 2 ) NOT NULL COMMENT  '课堂时长收费',ADD  `free_time` MEDIUMINT( 7 ) NOT NULL COMMENT  '课堂试看时长';




INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'live_api_url', '直播接口', 'textarea', 'text NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '更多设置', '', '', '', '', '', '<script type="text/javascript">\r\nvar str = `\r\n<input placeholder="推流地址" type="text" class="layui-input liveApiUrl" data-type="push_url"><br>\r\n<input placeholder="m3u8播流地址" type="text" class="layui-input liveApiUrl" data-type="m3u8_url"><br>\r\n<input placeholder="rtmp播流地址" type="text" class="layui-input liveApiUrl" data-type="rtmp_url"><br>\r\n<input placeholder="flv播流地址" type="text" class="layui-input liveApiUrl" data-type="flv_url"><br>\r\n`;\r\n$(function(){\r\n	$("#atc_live_api_url").after(str);\r\n	$("#atc_live_api_url").hide();\r\n	var vl = {};\r\n	try{\r\n		vl = JSON.parse( $("#atc_live_api_url").val() );\r\n	}catch(e){}\r\n	$(".liveApiUrl").each(function(){\r\n		var type = $(this).data(''type'');\r\n		if(vl[type]!=undefined){\r\n			$(this).val(vl[type])\r\n		}\r\n	});\r\n	$(".liveApiUrl").blur(function(){\r\n		var ar = {};\r\n		$(".liveApiUrl").each(function(){\r\n			var type = $(this).data(''type'');\r\n			if($(this).val()!='''')ar[type] = $(this).val();\r\n		});\r\n		var str = JSON.stringify(ar);\r\n		$("#atc_live_api_url").val( str==''{}''?'''':str );\r\n	});\r\n});\r\n</script>', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'live_api_url', '直播接口', 'textarea', 'text NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '更多设置', '', '', '', '', '', '<script type="text/javascript">\r\nvar str = `\r\n<input placeholder="推流地址" type="text" class="layui-input liveApiUrl" data-type="push_url"><br>\r\n<input placeholder="m3u8播流地址" type="text" class="layui-input liveApiUrl" data-type="m3u8_url"><br>\r\n<input placeholder="rtmp播流地址" type="text" class="layui-input liveApiUrl" data-type="rtmp_url"><br>\r\n<input placeholder="flv播流地址" type="text" class="layui-input liveApiUrl" data-type="flv_url"><br>\r\n`;\r\n$(function(){\r\n	$("#atc_live_api_url").after(str);\r\n	$("#atc_live_api_url").hide();\r\n	var vl = {};\r\n	try{\r\n		vl = JSON.parse( $("#atc_live_api_url").val() );\r\n	}catch(e){}\r\n	$(".liveApiUrl").each(function(){\r\n		var type = $(this).data(''type'');\r\n		if(vl[type]!=undefined){\r\n			$(this).val(vl[type])\r\n		}\r\n	});\r\n	$(".liveApiUrl").blur(function(){\r\n		var ar = {};\r\n		$(".liveApiUrl").each(function(){\r\n			var type = $(this).data(''type'');\r\n			if($(this).val()!='''')ar[type] = $(this).val();\r\n		});\r\n		var str = JSON.stringify(ar);\r\n		$("#atc_live_api_url").val( str==''{}''?'''':str );\r\n	});\r\n});\r\n</script>', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'live_api_url', '直播接口', 'textarea', 'text NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '更多设置', '', '', '', '', '', '<script type="text/javascript">\r\nvar str = `\r\n<input placeholder="推流地址" type="text" class="layui-input liveApiUrl" data-type="push_url"><br>\r\n<input placeholder="m3u8播流地址" type="text" class="layui-input liveApiUrl" data-type="m3u8_url"><br>\r\n<input placeholder="rtmp播流地址" type="text" class="layui-input liveApiUrl" data-type="rtmp_url"><br>\r\n<input placeholder="flv播流地址" type="text" class="layui-input liveApiUrl" data-type="flv_url"><br>\r\n`;\r\n$(function(){\r\n	$("#atc_live_api_url").after(str);\r\n	$("#atc_live_api_url").hide();\r\n	var vl = {};\r\n	try{\r\n		vl = JSON.parse( $("#atc_live_api_url").val() );\r\n	}catch(e){}\r\n	$(".liveApiUrl").each(function(){\r\n		var type = $(this).data(''type'');\r\n		if(vl[type]!=undefined){\r\n			$(this).val(vl[type])\r\n		}\r\n	});\r\n	$(".liveApiUrl").blur(function(){\r\n		var ar = {};\r\n		$(".liveApiUrl").each(function(){\r\n			var type = $(this).data(''type'');\r\n			if($(this).val()!='''')ar[type] = $(this).val();\r\n		});\r\n		var str = JSON.stringify(ar);\r\n		$("#atc_live_api_url").val( str==''{}''?'''':str );\r\n	});\r\n});\r\n</script>', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'live_api_url', '直播接口', 'textarea', 'text NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '更多设置', '', '', '', '', '', '<script type="text/javascript">\r\nvar str = `\r\n<input placeholder="推流地址" type="text" class="layui-input liveApiUrl" data-type="push_url"><br>\r\n<input placeholder="m3u8播流地址" type="text" class="layui-input liveApiUrl" data-type="m3u8_url"><br>\r\n<input placeholder="rtmp播流地址" type="text" class="layui-input liveApiUrl" data-type="rtmp_url"><br>\r\n<input placeholder="flv播流地址" type="text" class="layui-input liveApiUrl" data-type="flv_url"><br>\r\n`;\r\n$(function(){\r\n	$("#atc_live_api_url").after(str);\r\n	$("#atc_live_api_url").hide();\r\n	var vl = {};\r\n	try{\r\n		vl = JSON.parse( $("#atc_live_api_url").val() );\r\n	}catch(e){}\r\n	$(".liveApiUrl").each(function(){\r\n		var type = $(this).data(''type'');\r\n		if(vl[type]!=undefined){\r\n			$(this).val(vl[type])\r\n		}\r\n	});\r\n	$(".liveApiUrl").blur(function(){\r\n		var ar = {};\r\n		$(".liveApiUrl").each(function(){\r\n			var type = $(this).data(''type'');\r\n			if($(this).val()!='''')ar[type] = $(this).val();\r\n		});\r\n		var str = JSON.stringify(ar);\r\n		$("#atc_live_api_url").val( str==''{}''?'''':str );\r\n	});\r\n});\r\n</script>', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'live_api_url', '直播接口', 'textarea', 'text NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '更多设置', '', '', '', '', '', '<script type="text/javascript">\r\nvar str = `\r\n<input placeholder="推流地址" type="text" class="layui-input liveApiUrl" data-type="push_url"><br>\r\n<input placeholder="m3u8播流地址" type="text" class="layui-input liveApiUrl" data-type="m3u8_url"><br>\r\n<input placeholder="rtmp播流地址" type="text" class="layui-input liveApiUrl" data-type="rtmp_url"><br>\r\n<input placeholder="flv播流地址" type="text" class="layui-input liveApiUrl" data-type="flv_url"><br>\r\n`;\r\n$(function(){\r\n	$("#atc_live_api_url").after(str);\r\n	$("#atc_live_api_url").hide();\r\n	var vl = {};\r\n	try{\r\n		vl = JSON.parse( $("#atc_live_api_url").val() );\r\n	}catch(e){}\r\n	$(".liveApiUrl").each(function(){\r\n		var type = $(this).data(''type'');\r\n		if(vl[type]!=undefined){\r\n			$(this).val(vl[type])\r\n		}\r\n	});\r\n	$(".liveApiUrl").blur(function(){\r\n		var ar = {};\r\n		$(".liveApiUrl").each(function(){\r\n			var type = $(this).data(''type'');\r\n			if($(this).val()!='''')ar[type] = $(this).val();\r\n		});\r\n		var str = JSON.stringify(ar);\r\n		$("#atc_live_api_url").val( str==''{}''?'''':str );\r\n	});\r\n});\r\n</script>', '', '', '', 1);

ALTER TABLE  `qb_qun_content1` ADD  `live_api_url` TEXT NOT NULL COMMENT  '直播接口';
ALTER TABLE  `qb_qun_content2` ADD  `live_api_url` TEXT NOT NULL COMMENT  '直播接口';
ALTER TABLE  `qb_qun_content3` ADD  `live_api_url` TEXT NOT NULL COMMENT  '直播接口';
ALTER TABLE  `qb_qun_content4` ADD  `live_api_url` TEXT NOT NULL COMMENT  '直播接口';
ALTER TABLE  `qb_qun_content5` ADD  `live_api_url` TEXT NOT NULL COMMENT  '直播接口';

