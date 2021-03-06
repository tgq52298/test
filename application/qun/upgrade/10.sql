
INSERT INTO `qb_qun_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status` ) VALUES(4, '', '景点村庄', '', '', 100, 1552304554, 0);
INSERT INTO `qb_qun_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`) VALUES(5, '', '网店微商', '', '', 100, 1552399564, 0);


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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='景点村庄内容主表' AUTO_INCREMENT=1 ;




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



DELETE FROM  `qb_qun_field` WHERE mid =4 OR mid =5;

INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('title', '地点名称', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 4, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('picurl', 'LOGO标志', 'image', 'varchar(60) NOT NULL', '', '', '', 0, 4, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('content', '相关介绍', 'ueditor', 'text NOT NULL', '', '', '', 0, 4, '', '', '', '', '', 2, '', '', '', -2, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('telphone', '联系电话', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('map', '地图坐标', 'bmap', 'varchar(32) NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('address', '联系地址', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('autoyz', '用户加入是否自动通过审核', 'radio', 'tinyint(1) NOT NULL', '0', '0|需要人工审核\r\n1|自动通过审核\r\n-1|只能通过授权码加入\r\n-2|禁止加入', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('viewlimit', '访问权限', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '', '0|不限制\r\n1|只有正式粉丝会员才能访问', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('banner', '横幅图', 'image', 'varchar(255) NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('style', '个性风格', 'select', 'varchar(30) NOT NULL', '', 'app\\common\\util\\Style@get_style@["qun"]', '<script>$("#form_group_style").hide();/*隐藏起来*/</script>', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('notice', '公告通知', 'textarea', 'varchar(255) NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('hidetitle', '是否对外隐藏标题', 'radio', 'tinyint(2) NOT NULL DEFAULT ''0''', '', '0|公开标题\r\n1|隐藏标题', '仅针对私密圈才能隐藏,就是不显示在论坛列表的意思', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('sncode', '粉丝加入授权码', 'textarea', 'text NOT NULL', '', '', '每个授权码换一行<a href="http://www.qibosoft.com/get_sn.php" target="_blank">批量生成授权码</a>', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('content', '相关介绍', 'ueditor', 'text NOT NULL', '', '', '', 0, 5, '', '', '', '', '', 2, '', '', '', -2, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('picurl', 'LOGO标志', 'image', 'varchar(60) NOT NULL', '', '', '', 0, 5, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('rollpics', '幻灯片组图', 'images', 'text NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('haibao', '海报模板', 'text', 'varchar(100) NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', -3, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('telphone', '联系电话', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('title', '网店名称', 'text', 'varchar(256) NOT NULL', '', '', '', 0, 5, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('map', '地图坐标', 'bmap', 'varchar(32) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('address', '联系地址', 'text', 'varchar(128) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('autoyz', '粉丝加入是否自动通过审核', 'radio', 'tinyint(1) NOT NULL', '0', '0|需要人工审核\r\n1|自动通过审核\r\n-1|只能通过授权码加入\r\n-2|禁止加入', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('viewlimit', '访问权限', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '', '0|不限制\r\n1|只有正式粉丝会员才能访问', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('banner', '横幅图', 'image', 'varchar(255) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('style', '个性风格', 'select', 'varchar(30) NOT NULL', '', 'app\\common\\util\\Style@get_style@["qun"]', '<script>$("#form_group_style").hide();/*隐藏起来*/</script>', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('notice', '公告通知', 'textarea', 'varchar(255) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('hidetitle', '是否对外隐藏标题', 'radio', 'tinyint(2) NOT NULL DEFAULT ''0''', '', '0|公开标题\r\n1|隐藏标题', '仅针对私密圈才能隐藏,就是不显示在论坛列表的意思', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('sncode', '粉丝加入授权码', 'textarea', 'text NOT NULL', '', '', '每个授权码换一行<a href="http://www.qibosoft.com/get_sn.php" target="_blank">批量生成授权码</a>', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '权限设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('wxid', '微信号', 'text', 'varchar(25) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('wximgcode', '微信二维码', 'image', 'varchar(255) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('rollpics', '幻灯片组图', 'images', 'text NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '更多设置');
INSERT INTO `qb_qun_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES('haibao', '海报模板', 'text', 'varchar(100) NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', -3, 0, 0, 0, '');


UPDATE  `qb_qun_field` SET  `value` =  '' WHERE  `name` =  'map';