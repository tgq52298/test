DROP TABLE IF EXISTS `qb_sitelink_content`;
CREATE TABLE `qb_sitelink_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '关键词名称',
  `link` varchar(255) DEFAULT '' COMMENT '链接地址',
 `num` INT( 10 ) NOT NULL COMMENT  '替换次数',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 显示  0 隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='关键词内联表' AUTO_INCREMENT=1 ;

 
 


INSERT INTO `qb_hook_plugin` (`id`, `hook_key`, `plugin_key`, `hook_class`, `about`, `ifopen`, `list`, `author`, `author_url`) VALUES
('', 'cms_content_show', 'sitelink', 'plugins\\sitelink\\index\\Link', '', 1, 0, '', '');
 