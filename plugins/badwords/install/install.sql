
INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`) VALUES
('', 'cms_content_show', 'badwords', 'plugins\\badwords\\hook\\Index', '敏感词过滤', 1, 0, 'torylf', '');
INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`) VALUES
('', 'comment_add_end', 'badwords', 'plugins\\badwords\\hook\\Index', '评论过滤', 1, 0, 'torylf', '');
INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`) VALUES
('', 'reply_add_end', 'badwords', 'plugins\\badwords\\hook\\Index', '论坛回复过滤', 1, 0, 'torylf', '');

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES (0, -1, '需要开启的模块', 'open_mo', 'cms,bbs', 'text', '', 0, '', '模块之间用逗号隔开', 150, -1);

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES (0, -1, '词库类型', 'word_type', '0', 'radio', '0|内置\r\n1|自定义\r\n2|内置+自定义', 0, '', '内置：插件自带词库，自定义：后台自己添加', 90, -1);

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES (0, -1, '替换符', 'word_sign', '0', 'radio', '0|*\r\n1|#\r\n2|⊙\r\n3|★\r\n4|◆', 0, '', '非法词汇替换符', 80, -1);

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES (0, -1, '是否过滤评论', 'commentsw', '0', 'radio', '0|关\r\n1|开', 0, '', '评论过滤开关（注意：评论属于永久过滤）', 100, -1);

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES (0, -1, '是否过滤论坛回复', 'replysw', '0', 'radio', '0|关\r\n1|开', 0, '', '论坛回复过滤开关（注意：属于永久过滤）', 99, -1);

DROP TABLE IF EXISTS `qb_badwords_kw`;
CREATE TABLE `qb_badwords_kw`  (
  `id` int(4) NOT NULL,
  `word_type` tinyint(1) NULL DEFAULT NULL,
  `kwords` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '关键词',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of qb_badwords_kw
-- ----------------------------
INSERT INTO `qb_badwords_kw` VALUES (1, 1, NULL);






