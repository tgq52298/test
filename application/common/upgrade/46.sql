UPDATE `qb_config` SET `c_key`='weixin_msg_template_id2',`title`='模版消息多余的字段,可删除' WHERE `c_key`='weixin_msg_template_id';
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, 4, '模版消息之模板ID', 'weixin_msg_template_id', '', 'text', '', 1, '', '挑选模板的时候,模板代码中必须要包含这两个字段 {{first.DATA}} {{remark.DATA}}', -1, -2);
