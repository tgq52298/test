DROP TABLE IF EXISTS `qb_msgtask_log`;
CREATE TABLE IF NOT EXISTS `qb_msgtask_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `touid` int(7) NOT NULL COMMENT '接收者UID',
  `touser` varchar(50) NOT NULL COMMENT '接收者的邮箱、手机号、微信号等',
  `ifsend` tinyint(1) NOT NULL COMMENT '发送成功与否',
  `tid` int(7) NOT NULL COMMENT '关联的任务ID',
  PRIMARY KEY (`id`),
  KEY `ifsend` (`ifsend`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='发送任务列表' AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- 表的结构 `qb_msgtask_task`
--

DROP TABLE IF EXISTS `qb_msgtask_task`;
CREATE TABLE IF NOT EXISTS `qb_msgtask_task` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '信息标题',
  `content` text NOT NULL COMMENT '信息内容',
  `uid` int(7) NOT NULL COMMENT '发送者UID',
  `create_time` int(10) NOT NULL COMMENT '创建日期',
  `begin_time` int(10) NOT NULL COMMENT '定时开始发送时间',
  `type` varchar(20) NOT NULL DEFAULT '0' COMMENT '0短消息,1微信,2短信,3邮件,多个用逗号隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='群发任务' AUTO_INCREMENT=1;

ALTER TABLE  `qb_msgtask_task` ADD  `sncode` TEXT NOT NULL COMMENT  '序列号/密码分别发放' AFTER  `content`;

ALTER TABLE `qb_msgtask_task` ADD  `ext_id` INT( 10 ) NOT NULL COMMENT  '关联的主题ID',ADD  `ext_sys` MEDIUMINT( 6 ) NOT NULL COMMENT  '关联的模型ID';
ALTER TABLE `qb_msgtask_task` ADD INDEX (  `ext_id` ,  `ext_sys` );

