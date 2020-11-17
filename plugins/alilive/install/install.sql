INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '使用哪家的接口', 'live_video_type', 'ali', 'radio', 'ali|阿里云|ali_live_push_url,ali_live_pull_url,ali_live_push_key,ali_live_pull_key,ali_live_time,ali_live_mvurl\r\nqq|腾迅云|qq_live_push_url,qq_live_pull_url,qq_live_push_key,qq_live_pull_key,qq_live_time,qq_live_mvurl', 0, '', '', 50, 0);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '阿里推流域名', 'ali_live_push_url', '', 'text', '', 0, '', '不要加http,只写二级域名', 20, 0);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '阿里播流域名', 'ali_live_pull_url', '', 'text', '', 0, '', 'http或https开头', 19, 0);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '阿里推流URL鉴权-主KEY', 'ali_live_push_key', '', 'text', '', 0, '', '', 18, 0);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '阿里播流URL鉴权-主KEY', 'ali_live_pull_key', '', 'text', '', 0, '', '', 17, 0);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '阿里鉴权加密地址有效时长', 'ali_live_time', '30', 'text', '', 0, '', '单位是分钟,阿里云默认是30分钟,要修改的话,推流与播流要一致,建议60分钟以上,避免用户使用过程中,突然中断', 16, 0);

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '阿里录制点播域名网址', 'ali_live_mvurl', '', 'text', '', 0, '', '阿里云OSS对象云存储域名网址,要加http://', 0, 0);

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '腾迅推流域名', 'qq_live_push_url', '', 'text', '', 0, '', '不要加http,只写二级域名', 10, 0);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '腾迅播流域名', 'qq_live_pull_url', '', 'text', '', 0, '', 'http或https开头', 9, 0);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '腾迅推流URL鉴权-主KEY', 'qq_live_push_key', '', 'text', '', 0, '', '', 8, 0);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '腾迅播流URL鉴权-主KEY', 'qq_live_pull_key', '', 'text', '', 0, '', '', 7, 0);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '腾迅鉴权加密地址有效时长', 'qq_live_time', '', 'text', '', 0, '', '单位是秒,腾迅云默认没设置,建议设置7200以上,即2小时以上', 6, 0);

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '腾迅录制点播域名网址', 'qq_live_mvurl', '', 'text', '', 0, '', '腾迅云点播域名网址,要加http://开头', 0, 0);



INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '打赏主播方式', 'wxgive_qun_rmb', '', 'radio', '0|金额存到主播帐户余额\r\n1|金额直接到他微信钱包', 0, '', '转钱包,需要往微信商户平台存够钱才行', -1, 0);

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '录制视频回调网址通信密钥', 'live_video_key', '', 'text', '', 0, '', '任意字符串即可,这用于给阿里或腾迅视频录制回调通知使用,非正式上线可为空.<br>回调地址统一使用:“你的域名网址/index.php/p/alilive-notify-index/apikey/通信密钥.html”', 0, 0);


INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '直播流量每元多少分钟', 'live_time_money', '100', 'number', '', 0, '', '消费按每个观看窗口统计', -2, -36);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '免费直播的用户组', 'live_free_group', '', 'usergroup2', '', 0, '', '不设置都要收费', -2, -36);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '免费体验直播时长(分钟)', 'live_test_time', '', 'number', '', 0, '', '设置为0或留空,则不允许免费体验', -3, -36);


INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '自建直播服务器', 'self_zhibo_server', '1', 'radio', '0|关闭\r\n1|启用|self_zhibo_server_url,self_zhibo_server_group', 0, '', '没有自建直播服务器,就不要选择启用。自建服务器的目的是测试体验使用', -5, -36);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '域名网址', 'self_zhibo_server_url', 'https://testrtmp.qibosoft.net:8082', 'text', '', 0, '', 'http或https开头,比如“https://xxx.com:8082”结尾不要加斜杠', -5, -36);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '哪些用户组使用自建直播服务器', 'self_zhibo_server_group', '3', 'usergroup2', '', 0, '', '', -5, -36);

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '直播录制视频推送到哪个CMS栏目', 'cms_sortid', '', 'select', 'cms_sort@id,name@mid=3', 0, '', '针对没有进会员中心发布预告的情况', -1, -36);


INSERT INTO `qb_hook` (`id`, `name`, `about`, `ifopen`, `list`) VALUES(0, 'zhibo_start', '开始视频直播', 1, 0);
INSERT INTO `qb_hook` (`id`, `name`, `about`, `ifopen`, `list`) VALUES(0, 'zhibo_stop', '视频直播结束', 1, 0);
INSERT INTO `qb_hook` (`id`, `name`, `about`, `ifopen`, `list`) VALUES(0, 'zhibo_postmv', '视频直播发来录制视频数据', 1, 0);



DROP TABLE IF EXISTS `qb_alilive_log`;
CREATE TABLE IF NOT EXISTS `qb_alilive_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(7) NOT NULL COMMENT '用户UID',
  `ext_id` int(7) NOT NULL COMMENT '频道主题ID',
  `ext_sys` smallint(5) NOT NULL COMMENT '频道ID',
  `push_url` varchar(150) NOT NULL COMMENT '推流地址',
  `flv_url` varchar(150) NOT NULL COMMENT '拉流地址',
  `m3u8_url` varchar(150) NOT NULL COMMENT '拉流地址',
  `rtmp_url` varchar(150) NOT NULL COMMENT '拉流地址',
  `create_time` int(10) NOT NULL COMMENT '创建日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='直播日志' AUTO_INCREMENT=1;


ALTER TABLE  `qb_alilive_log` ADD  `end_time` INT( 10 ) NOT NULL COMMENT  '直播结束时间';
ALTER TABLE  `qb_alilive_log` ADD INDEX (  `ext_id` ,  `ext_sys` );
ALTER TABLE  `qb_alilive_log` ADD INDEX (  `uid` );
ALTER TABLE  `qb_alilive_log` ADD  `timelong` MEDIUMINT NOT NULL COMMENT  '直播时间总长度(秒)';
ALTER TABLE  `qb_alilive_log` ADD INDEX (  `create_time` ,  `end_time` );






DROP TABLE IF EXISTS `qb_alilive_order`;
CREATE TABLE IF NOT EXISTS `qb_alilive_order` (
  `id` mediumint(7) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(7) NOT NULL COMMENT '购买者UID',
  `aid` mediumint(7) NOT NULL COMMENT '使用的圈子ID',
  `timelong` mediumint(7) NOT NULL COMMENT '直播总时长(秒)',
  `usetime` mediumint(7) NOT NULL COMMENT '已使用时间(秒)',
  `create_time` int(10) NOT NULL COMMENT '购买时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='直播流量购买订单' AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS `qb_alilive_viewlog`;
CREATE TABLE IF NOT EXISTS `qb_alilive_viewlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(7) NOT NULL COMMENT '访问者ID',
  `ip` varchar(15) NOT NULL COMMENT '访问者IP',
  `aid` mediumint(7) NOT NULL COMMENT '圈子ID',
  `create_time` int(10) NOT NULL COMMENT '访问时间',
  `view_time` mediumint(7) NOT NULL COMMENT '访问时长(秒)',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户访问日志' AUTO_INCREMENT=1 ;


INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`, `version`, `version_id`) VALUES(0, 'user_leave', 'alilive', 'plugins\\alilive\\index\\Api', '自建服务器处理圈子停播', 1, 0, '', '', '', 0);

ALTER TABLE  `qb_alilive_log` ADD  `title` VARCHAR( 256 ) NOT NULL COMMENT  '标题简介',ADD  `about` TEXT NOT NULL COMMENT  '内容介绍',ADD  `picurl` VARCHAR( 150 ) NOT NULL COMMENT  '缩略图';
