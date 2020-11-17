
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO标题', 'mseo_title', '', 'text', '', 0, '', '', 0, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化关键字keywords', 'mseo_keyword', '', 'text', '', 0, '', '', 0, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化描述description', 'mseo_description', '', 'text', '', 0, '', '', 0, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否开启当前模块', 'is_open_modlue', '', 'radio', '1|开启\r\n0|关闭', 0, '', '', 0, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '允许创建黄页的用户组', 'can_post_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 0, 6);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '每个用户组对应只能创建几个黄页', 'group_create_num', '{"2":"","3":"50","8":"5","11":"5","12":"20"}', 'usergroup', '', 0, '', '不能留空', 0, 6);



DROP TABLE IF EXISTS `qb_hy_content`;
CREATE TABLE IF NOT EXISTS `qb_hy_content` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `uid` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='内容索引表' AUTO_INCREMENT=39 ;



INSERT INTO `qb_hy_content` (`id`, `mid`, `uid`) VALUES
(12, 1, 1),
(13, 1, 1),
(14, 1, 1),
(15, 1, 1),
(16, 1, 1),
(31, 1, 1),
(30, 1, 1);



DROP TABLE IF EXISTS `qb_hy_content1`;
CREATE TABLE IF NOT EXISTS `qb_hy_content1` (
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
  `autoyz` varchar(32) NOT NULL COMMENT '成员加入是否自动通过审核',
  `usernum` mediumint(6) NOT NULL DEFAULT '1' COMMENT '成员数',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文章模型模型表' AUTO_INCREMENT=39 ;


INSERT INTO `qb_hy_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `template`, `map`, `telphone`, `address`, `map_x`, `map_y`, `autoyz`, `usernum`) VALUES
(12, 1, 10, '东诚房产中介', 1, 1, 11, 2, 0, 1517533498, 1527577211, 0, 'uploads/images/20180330/5bac969ebb40e2dc3b179e7995c1b071.jpg', '<p>始创于1979年,中国海外集团房地产业务平台,专注于主流城市打造主流精品物业的全国性地产品牌,中海地产集团有限公司</p>', 0, 0, 0, 0, '', '113.423763,23.127862', '0852-2823-7888', '中山698号', 113.423763, 23.127862, '0', 2),
(13, 1, 12, '连州地税局', 1, 1, 4, 2, 0, 1517533576, 1527577186, 0, 'uploads/images/20180330/d5b712dc8cd476d8eef249df90234713.jpg', '<p>专注于高端物业的开发和管理,涵盖高端住宅/别墅/商业/写字楼等多种物业类型,于香港联交所上市的专业从事住宅及商业地产综合开发的企业,融创中国控股有限公司</p>', 0, 0, 0, 0, '', '113.082263,23.176774', '400-997-1918', '重庆256号', 113.082263, 23.176774, '0', 1),
(14, 1, 12, '星子民政局', 1, 1, 12, 2, 0, 1517533674, 1527577167, 0, 'uploads/images/20180330/06d879b1eddcaac0780ea8ba42ebbf33.jpg', '<p>始于1992年,以商品住宅开发为主,中国保利集团控股的大型国有房地产企业,保利房地产(集团)股份有限公司)</p>', 0, 0, 0, 0, '', '113.088587,23.135838', '400-618-3009', '北京203号', 113.088587, 23.135838, '0', 2),
(15, 1, 10, '新河婚介所', 1, 1, 11, 2, 0, 1517533725, 1527577151, 0, 'uploads/images/20180330/94452daba2f548e0c79e159ed8cae118.jpg', '<p>成立于1992年,在超高层/大型城市综合体/高铁站商务区及产业园开发领域享誉国际,世界500强企业,上市公司,绿地控股集团有限公司</p>', 0, 0, 0, 0, '', '113.166201,23.151789', '021-53188666', '上海1025号', 113.166201, 23.151789, '0', 1),
(16, 1, 11, '星子爱心社', 1, 1, 10, 2, 0, 1517533788, 1527577138, 0, 'uploads/images/20180330/5bac969ebb40e2dc3b179e7995c1b071.jpg', '<p>国内大型房地产开发企业,房地产行业大盘开发模式的倡导者,香港联交所上市公司,碧桂园控股有限公司</p>', 0, 0, 0, 0, '', '113.300731,23.157105', '400-891-9338', '顺德1025号', 113.300731, 23.157105, '0', 1),
(31, 1, 9, '顺碧农家乐', 1, 1, 68, 2, 0, 1517533867, 1527577086, 0, 'uploads/images/20180312/1d988146be839a28964429913a06e336.jpeg', '<p>&nbsp;世界500强企业,上市公司,国内著名精品地产品牌,集民生地产/旅游综合体/体育及文化产业于一体的综合性企业,恒大集团</p>', 0, 0, 0, 0, '', '113.262211,23.179432', '400-889-3333', '广州大道102号', 113.262211, 23.179432, '0', 2),
(30, 1, 12, '新村街道办', 1, 1, 544, 2, 0, 1520845811, 1527577117, 0, 'uploads/images/20180330/a49d3c48120c81db2cff981fc2ac8b09.jpg', '<p>成立于1984年,专注于房地产开发及物业服务的高新技术企业,上市公司,世界500企业,万科企业股份有限公司</p>', 0, 0, 0, 0, '', '113.350605,22.964246', '0755652122', '佛山中山八路103号', 113.350605, 22.964246, '0', 3);



DROP TABLE IF EXISTS `qb_hy_field`;
CREATE TABLE IF NOT EXISTS `qb_hy_field` (
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文档字段表' AUTO_INCREMENT=53 ;



INSERT INTO `qb_hy_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES
(10, 'title', '商家名称', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, ''),
(11, 'picurl', '介绍图片', 'image', 'varchar(60) NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 0, 0, 0, ''),
(12, 'content', '商家介绍', 'ueditor', 'text NOT NULL', '', '', '', 0, 1, '', '', '', '', '', 2, '', '', '', 100, 0, 0, 0, ''),
(50, 'telphone', '商家电话', 'text', 'varchar(128) NOT NULL', '11', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, ''),
(49, 'map', '地图坐标', 'bmap', 'varchar(32) NOT NULL', '50', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, ''),
(51, 'address', '商家地址', 'text', 'varchar(128) NOT NULL', '255', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, ''),
(52, 'autoyz', '成员加入是否自动通过审核', 'hidden', 'varchar(32) NOT NULL', '1', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '');



DROP TABLE IF EXISTS `qb_hy_groups`;
CREATE TABLE IF NOT EXISTS `qb_hy_groups` (
  `id` int(7) NOT NULL AUTO_INCREMENT COMMENT '记录',
  `aid` int(7) NOT NULL COMMENT '圈子ID',
  `type` tinyint(2) NOT NULL COMMENT '圈子用户组ID',
  `name` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '用户组名',
  `cfg` text COLLATE utf8_bin NOT NULL COMMENT '相关权限',
  `list` int(10) NOT NULL COMMENT '排序值',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='圈子用户组及权限' AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS `qb_hy_member`;
CREATE TABLE IF NOT EXISTS `qb_hy_member` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='圈子成员' AUTO_INCREMENT=11 ;


INSERT INTO `qb_hy_member` (`id`, `aid`, `uid`, `create_time`, `type`, `update_time`, `view`) VALUES
(1, 30, 3, 1523328431, 1, 1523328431, 10),
(2, 30, 4, 1523328818, 1, 1523328818, 20),
(4, 14, 1, 1523330436, 0, 1527584348, 0),
(5, 31, 1, 1523681796, 0, 1527577030, 0),
(6, 12, 1, 1523682818, 0, 1527586770, 0);


DROP TABLE IF EXISTS `qb_hy_module`;
CREATE TABLE IF NOT EXISTS `qb_hy_module` (
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


INSERT INTO `qb_hy_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`) VALUES
(1, '', '黄页模型', '', '', 100, 1515221331, 0);


DROP TABLE IF EXISTS `qb_hy_sort`;
CREATE TABLE IF NOT EXISTS `qb_hy_sort` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='主栏目表' AUTO_INCREMENT=18 ;


INSERT INTO `qb_hy_sort` (`id`, `pid`, `mid`, `name`, `list`, `logo`, `template`, `allowpost`, `allowview`, `seo_title`, `seo_keywords`, `seo_description`) VALUES
(9, 0, 1, '餐饮行业', 10, 'fa fa-fw fa-book', '', '', '', '', '', ''),
(10, 0, 1, '服务行业', 9, 'fa fa-fw fa-list-alt', '', '', '', '', '', ''),
(11, 0, 1, '公益机构', 8, 'fa fa-fw fa-video-camera', '', '', '', '', '', ''),
(12, 0, 1, '机关单位', 7, '', '', '', '', '', '', ''),
(1, 0, 1, '实体商铺', 0, '', '', '', '', '', '', '');



DROP TABLE IF EXISTS `qb_hy_visit`;
CREATE TABLE IF NOT EXISTS `qb_hy_visit` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '圈子ID',
  `uid` int(7) NOT NULL COMMENT '用户ID',
  `visittime` int(10) NOT NULL COMMENT '最后访问时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `aid` (`aid`),
  KEY `visittime` (`visittime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户访问过的圈子' AUTO_INCREMENT=1 ;




