
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO标题', 'mseo_title', '问答系统', 'text', '', 0, '', '', 100, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化关键字keywords', 'mseo_keyword', '问答关键字', 'text', '', 0, '', '', 99, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, 'SEO优化描述description', 'mseo_description', '问答描述', 'text', '', 0, '', '', 98, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否开启当前模块', 'is_open_modlue', '1', 'radio', '1|开启\r\n0|关闭', 0, '', '', 97, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '允许发布内容的用户组', 'can_post_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 96, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '发布内容自动通过审核的用户组', 'post_auto_pass_group', '', 'checkbox', 'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]', 0, '', '', 95, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '内容被设为精华奖励积分个数', 'com_info_add_money', '', 'text', '', 0, '', '', 94, 4);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '是否启用微信通知有人答复了', 'reply_send_wxmsg', '1', 'radio', '0|禁用\r\n1|启用', 0, '', '必须要对接认证公众号', 0, 4);



DROP TABLE IF EXISTS `qb_zhidao_content`;
CREATE TABLE `qb_zhidao_content` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `mid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `uid` int(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mid` (`mid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='主题索引表';


DROP TABLE IF EXISTS `qb_zhidao_content1`;
CREATE TABLE `qb_zhidao_content1` (
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
  `money` int(7) NOT NULL DEFAULT '0' COMMENT '最佳答复奖励积分',
  `best_rid` int(8) NOT NULL DEFAULT '0' COMMENT '最佳回答ID',
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
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='问题标题主表';


DROP TABLE IF EXISTS `qb_zhidao_contents`;
CREATE TABLE `qb_zhidao_contents` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL COMMENT '文章内容',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='问题内容表';


DROP TABLE IF EXISTS `qb_zhidao_field`;
CREATE TABLE `qb_zhidao_field` (
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='文档字段表';

INSERT INTO `qb_zhidao_field` VALUES ('10','title','问题','text','varchar(256) NOT NULL','','','','0','1','','','','','','2','','','','100','1','1','1','','','','','','');
INSERT INTO `qb_zhidao_field` VALUES ('11','picurl','组图','images','text NOT NULL','','','','0','1','','','','','','2','','','','98','0','0','0','','','','','','');
INSERT INTO `qb_zhidao_field` VALUES ('12','content','问题描述','ueditor','text NOT NULL','','','','0','1','','','','','','2','','','','97','0','0','0','','','','','','');
INSERT INTO `qb_zhidao_field` VALUES ('13','money','悬赏积分','text','int(7) NOT NULL DEFAULT \'0\'','','','填写奖励积分数值，该积分会从你账户扣取，当你采纳了用户的答案时会把该积分奖励给被采纳答案的回答用户','1','1','','','','','','2','','','','100','1','0','0','','','','','','');

DROP TABLE IF EXISTS `qb_zhidao_infomsg`;
CREATE TABLE `qb_zhidao_infomsg` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `ext_id` int(7) NOT NULL COMMENT '扩展ID,比如可以给圈子统计',
  `ext_sys` smallint(4) NOT NULL COMMENT '扩展字段,关联的系统',
  `posttime` int(10) NOT NULL COMMENT '提问更新时间',
  `today_post` mediumint(5) NOT NULL COMMENT '今日提问量',
  `yesterday_post` mediumint(5) NOT NULL COMMENT '昨晚提问量',
  `total_post` mediumint(7) NOT NULL COMMENT '总提问量',
  `total_topic` mediumint(6) NOT NULL COMMENT '主题总数',
  `day_top_post` int(11) NOT NULL COMMENT '最高日提问量',
  PRIMARY KEY (`id`),
  KEY `ext_id` (`ext_id`,`ext_sys`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='问题的一些辅助信息,比如今日多少问';
INSERT INTO `qb_zhidao_infomsg` (`id`, `ext_id`, `ext_sys`, `posttime`, `today_post`, `yesterday_post`, `total_post`, `total_topic`, `day_top_post`) VALUES
(1, 0, 0, 0, 0, 0, 0, 0, 0);

DROP TABLE IF EXISTS `qb_zhidao_member`;
CREATE TABLE `qb_zhidao_member` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `aid` int(7) NOT NULL COMMENT '问题ID',
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='问题关联的会员信息';


DROP TABLE IF EXISTS `qb_zhidao_module`;
CREATE TABLE `qb_zhidao_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `keyword` varchar(32) NOT NULL DEFAULT '' COMMENT '区分符关键字',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '模型标题',
  `layout` varchar(50) NOT NULL COMMENT '模板路径',
  `icon` varchar(64) NOT NULL,
  `list` int(10) NOT NULL DEFAULT '100' COMMENT '排序',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='模型表';

INSERT INTO `qb_zhidao_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`) VALUES
(1, '', '知道模型', '', '', 100, 1515221331, 0);


DROP TABLE IF EXISTS `qb_zhidao_reply`;
CREATE TABLE `qb_zhidao_reply` (
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
  KEY `aid` (`aid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='问题回复内容表';


DROP TABLE IF EXISTS `qb_zhidao_sort`;
CREATE TABLE `qb_zhidao_sort` (
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='主栏目表';


INSERT INTO `qb_zhidao_sort` VALUES ('16','0','1','健康生活','0','','','','','','','');
INSERT INTO `qb_zhidao_sort` VALUES ('17','0','1','社会民生','0','','','','','','','');
INSERT INTO `qb_zhidao_sort` VALUES ('18','0','1','电脑网络','0','','','','','','','');
INSERT INTO `qb_zhidao_sort` VALUES ('19','0','1','娱乐休闲','0','','','','','这是标题','这是关键字','这是描述');

