ALTER TABLE  `qb_gongdan_order` ADD  `robuid` INT( 7 ) NOT NULL COMMENT  '确认抢单者UID',ADD  `roblist` VARCHAR( 150 ) NOT NULL COMMENT  '抢单者候选列表,多个UID用逗号隔开';
ALTER TABLE  `qb_gongdan_order` ADD INDEX (  `shop_uid` );
ALTER TABLE  `qb_gongdan_order` ADD INDEX (  `robuid` );
ALTER TABLE  `qb_gongdan_order` ADD INDEX (  `shopid` );
ALTER TABLE  `qb_gongdan_order` ADD INDEX (  `status` );

INSERT INTO `qb_gongdan_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`, `group_post`) VALUES(0, 'robtype', '抢单模式', 'radio', 'tinyint(1) NOT NULL DEFAULT ''0''', '', '0|关闭抢单\r\n1|抢单不需确认\r\n2|抢单需客户确认', '推送抢单通知只限于接收新工单提醒的用户组', 1, 1, '', '', '', '', '', 2, '', '', '', 1, 0, 0, 0, '', '', '', '', '', '', '', '', '', '', 1, '');


ALTER TABLE  `qb_gongdan_content1` ADD  `robtype` TINYINT( 1 ) NOT NULL COMMENT  '抢单模式';

INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`, `version`, `version_id`) VALUES(0, 'comment_add_end', '', 'app\\gongdan\\index\\Hook', '工单回复通知', 1, 0, '', '', '', 0);

