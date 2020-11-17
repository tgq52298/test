INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO标题', 'mseo_title', '', 'text', '', 0, '', '', 100, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化关键字keywords', 'mseo_keyword', '', 'text', '', 0, '', '', 99, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化描述description', 'mseo_description', '', 'text', '', 0, '', '', 98, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '允许发布内容的用户组', 'can_post_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 96, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '发布内容自动通过审核的用户组', 'post_auto_pass_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 95, 4);


DROP TABLE IF EXISTS `qb_hr_content`;
CREATE TABLE `qb_hr_content` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `uid` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='内容索引表';



DROP TABLE IF EXISTS `qb_hr_content1`;
CREATE TABLE `qb_hr_content1` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
  `replynum` mediumint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  -- `picurl` text NOT NULL COMMENT '封面图',
  `content` text NOT NULL COMMENT '文章内容',
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段,关联的系统',
  `ext_id` int(7) NOT NULL COMMENT '扩展字段,关联的ID',
  `nums` int(7) NOT NULL DEFAULT '0' COMMENT '招聘人数',
  `wageyear` tinyint(2) NOT NULL COMMENT '工作经验要求',
  `asksex` tinyint(2) NOT NULL COMMENT '性别要求',
  `schoo_age` varchar(128) NOT NULL COMMENT '学历要求',
  `wage` tinyint(2) NOT NULL COMMENT '薪水待遇',
  `workplace` varchar(100) NOT NULL COMMENT '工作城市',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `ext_id` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='职位模型表';


DROP TABLE IF EXISTS `qb_hr_content2`;
CREATE TABLE `qb_hr_content2` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(4) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` varchar(256) NOT NULL DEFAULT '' COMMENT '标题',
  `ispic` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否带组图',
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` mediumint(7) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：0未审 1已审 2推荐',
  `replynum` mediumint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `picurl` text NOT NULL COMMENT '照片',
  `content` text NOT NULL COMMENT '文章内容',
  `province_id` mediumint(5) NOT NULL COMMENT '省会ID',
  `city_id` mediumint(5) NOT NULL COMMENT '城市ID',
  `zone_id` mediumint(5) NOT NULL COMMENT '县级市或所在区ID',
  `street_id` mediumint(5) NOT NULL COMMENT '乡镇或区域街道ID',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段,关联的系统',
  `ext_id` int(7) NOT NULL COMMENT '扩展字段,关联的ID',
  `qq` int(7) NOT NULL DEFAULT '0' COMMENT 'QQ号码',
  `wage` tinyint(2) NOT NULL DEFAULT '0' COMMENT '期望待遇',
  `school_age` tinyint(32) NOT NULL COMMENT '学历',
  `graduate_time` varchar(100) NOT NULL COMMENT '毕业年份',
  `height` varchar(10) NOT NULL COMMENT '身高',
  `alma_mater` varchar(155) NOT NULL COMMENT '毕业学校',
  `age` int(7) NOT NULL DEFAULT '0' COMMENT '年龄',
  `sex` tinyint(2) NOT NULL DEFAULT '1' COMMENT '性别',
  `speciality` varchar(128) NOT NULL COMMENT '专业',
  `truename` varchar(32) NOT NULL COMMENT '姓名',
  `mobphone` varchar(18) NOT NULL COMMENT '手机号码',
  `email` varchar(55) NOT NULL COMMENT '常用邮箱  ',
  `lifeplace` varchar(255) NOT NULL COMMENT '期望工作城市',
  `worktime` varchar(255) NOT NULL COMMENT '到岗日期',
  `education` varchar(255) NOT NULL COMMENT '教育背景 ',
  `work` text NOT NULL COMMENT '工作经验',
  `skill` text NOT NULL COMMENT '技能特长',
  `interest` text NOT NULL COMMENT '体育爱好',
  `workyear` tinyint(2) NOT NULL DEFAULT '0' COMMENT '工作年限  ',
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `fid` (`fid`),
  KEY `view` (`view`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ispic` (`ispic`),
  KEY `province_id` (`province_id`),
  KEY `city_id` (`city_id`),
  KEY `ext_id` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='简历模型表';


DROP TABLE IF EXISTS `qb_hr_field`;
CREATE TABLE `qb_hr_field` (
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
) ENGINE=MyISAM AUTO_INCREMENT=164 DEFAULT CHARSET=utf8 COMMENT='文档字段表';

INSERT INTO `qb_hr_field` VALUES ('93','mobphone','手机号码','text','varchar(18) NOT NULL','','','','1','2','','','','','','2','','','','92','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('92','truename','姓名','text','varchar(32) NOT NULL','','','','1','2','','','','','','2','','','','98','1','0','1','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('90','sex','性别','radio','tinyint(2) NOT NULL DEFAULT \'1\'','','1|男\r\n2|女','','1','2','','','','','','2','','','','97','0','1','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('89','age','年龄','text','int(7) NOT NULL DEFAULT \'0\'','','','','1','2','','','','','','2','','','','97','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('87','height','身高','text','varchar(10) NOT NULL','','','','1','2','','','','','','2','','','','97','0','0','0','','','','厘米','','');
INSERT INTO `qb_hr_field` VALUES ('88','alma_mater','毕业学校','text','varchar(155) NOT NULL','','1|普通装修\r\n2|精装修\r\n3|豪华装修\r\n4|毛坯房','','1','2','','','','','','2','','','','95','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('91','speciality','专业','text','varchar(128) NOT NULL','','','','1','2','','','','','','2','','','','96','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('86','graduate_time','毕业年份','text','varchar(100) NOT NULL','','1|水\r\n2|电\r\n3|电话\r\n4|宽带\r\n5|管道煤气\r\n6|电梯\r\n7|家具','','1','2','','','','','','2','','','','94','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('84','wage','期望待遇','select','tinyint(2) NOT NULL DEFAULT \'0\'','','1|面议\r\n2|800~1500元\r\n3|1500~2500元\r\n4|2500~3500元\r\n5|3500元以上','','1','2','','','','','','2','','','','93','0','0','0','','','','万元','','');
INSERT INTO `qb_hr_field` VALUES ('85','school_age','学历','select','tinyint(32) NOT NULL','0','1|小学\r\n2|初中\r\n3|高中\r\n4|中专\r\n5|大专\r\n6|本科\r\n7|研究生\r\n9|博士','','1','2','','','','','','2','','','','97','0','1','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('83','qq','QQ号码','text','int(7) NOT NULL DEFAULT \'0\'','','1|中介\r\n2|个人','','1','2','','','','','','2','','','','91','1','1','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('65','title','职位名称','text','varchar(256) NOT NULL','','','','1','1','','','','','','2','','','','100','1','1','1','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('67','content','详情','ueditor','text NOT NULL','','','','1','1','','','','','','2','','','','-1','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('68','nums','招聘人数','text','int(7) NOT NULL DEFAULT \'0\'','1','1|中介\r\n2|个人','','1','1','','','','','','2','','','','0','1','1','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('156','email','常用邮箱 ','text','varchar(55) NOT NULL','','','','1','2','','','','','','2','','','','90','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('70','wageyear','工作经验要求','select','tinyint(2) NOT NULL','0','1|一年以上\r\n2|两年以上\r\n3|三年以上','','1','1','','','','','','2','','','','0','0','1','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('73','asksex','性别要求','radio','tinyint(2) NOT NULL','1','1|男性\r\n2|女性','','1','1','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('74','schoo_age','学历要求','select','varchar(128) NOT NULL','','1|小学以上\r\n2|中学以上\r\n3|中专以上\r\n4|高中以上\r\n5|大专以上\r\n6|本科以上\r\n7|硕士以上\r\n8|博士以上','','1','1','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('155','workplace','工作城市','text','varchar(100) NOT NULL','','','','1','1','','','','','','2','','','','100','0','0','1','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('79','wage','薪水待遇','select','tinyint(2) NOT NULL','1','1|面议\r\n2|1500~2500元\r\n3|2500~3500元\r\n4|3500~5000元\r\n5|5000~7000元','','1','1','','','','','','2','','','','0','0','1','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('80','title','期望职位','text','varchar(256) NOT NULL','','','','1','2','','','','','','2','','','','100','1','1','1','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('81','picurl','相片','image','text NOT NULL','','','','1','2','','','','','','2','','','','99','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('82','content','自我评价','textarea','text NOT NULL','','','','1','2','','','','','','2','','','','84','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('163','workyear','工作年限  ','select','tinyint(2) NOT NULL DEFAULT \'0\'','','1|应届毕业生\r\n2|一年\r\n3|两年\r\n4|三年以上','','1','2','','','','','','2','','','','88','0','1','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('159','education','教育背景 ','textarea','varchar(255) NOT NULL','','','','1','2','','','','','','2','','','','86','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('160','work','工作经验','textarea','text NOT NULL','','','','1','2','','','','','','2','','','','85','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('161','skill','技能特长','textarea','text NOT NULL','','','','1','2','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('162','interest','体育爱好','textarea','text NOT NULL','','','','1','2','','','','','','2','','','','0','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('157','lifeplace','期望工作城市','text','varchar(255) NOT NULL','','','','1','2','','','','','','2','','','','89','0','0','0','','','','','','');
INSERT INTO `qb_hr_field` VALUES ('158','worktime','到岗日期','text','varchar(255) NOT NULL','','','','1','2','','','','','','2','','','','87','0','0','0','','','','','','');


DROP TABLE IF EXISTS `qb_hr_module`;
CREATE TABLE `qb_hr_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) NOT NULL DEFAULT '' COMMENT '区分符关键字',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模型标题',
  `layout` varchar(50) NOT NULL COMMENT '模板路径',
  `icon` varchar(64) NOT NULL,
  `list` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='模型表';

INSERT INTO `qb_hr_module` VALUES ('1','','职位模型','','','100','1528187470','0');
INSERT INTO `qb_hr_module` VALUES ('2','','简历模型','','','100','1528343499','0');

DROP TABLE IF EXISTS `qb_hr_sort`;
CREATE TABLE `qb_hr_sort` (
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
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='主栏目表';

INSERT INTO `qb_hr_sort` VALUES ('1','0','1','计算机/互联网/通信/电子','0','','','','','','','');
INSERT INTO `qb_hr_sort` VALUES ('2','0','1','销售/客服/技术支持','0','','','','','','','');
INSERT INTO `qb_hr_sort` VALUES ('3','0','1','人事/行政/高级管理','0','','','','','','','');
INSERT INTO `qb_hr_sort` VALUES ('4','1','1','计算机硬件','0','','','','','','','');
INSERT INTO `qb_hr_sort` VALUES ('5','1','1','计算机软件','0','','','','','','','');
INSERT INTO `qb_hr_sort` VALUES ('6','1','1','互联网开发及应用','0','','','','','','','');
INSERT INTO `qb_hr_sort` VALUES ('7','2','1','销售人员','0','','','','','','','');
INSERT INTO `qb_hr_sort` VALUES ('8','2','1','客服及技术支持','0','','','','','','','');
INSERT INTO `qb_hr_sort` VALUES ('9','3','1','人力资源','0','','','','','','','');
INSERT INTO `qb_hr_sort` VALUES ('10','3','1','高级管理','0','','','','','','','');
INSERT INTO `qb_hr_sort` VALUES ('11','3','1','行政/后勤','0','','','','','','','');



DROP TABLE IF EXISTS `qb_hr_apply`;
CREATE TABLE IF NOT EXISTS `qb_hr_apply` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '职位ID',
  `jid` int(7) NOT NULL COMMENT '用户简历ID',
  `uid` int(7) NOT NULL COMMENT '求职用户ID',
  `cuid` int(7) NOT NULL COMMENT '发布用户ID',
  `create_time` int(10) NOT NULL COMMENT '申请时间',
  `type` tinyint(1) NOT NULL COMMENT '后续扩展使用',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`,`type`),
  KEY `uid` (`uid`,`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='求职申请' AUTO_INCREMENT=0 ;
