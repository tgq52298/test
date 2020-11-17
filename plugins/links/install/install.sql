DROP TABLE IF EXISTS `qb_links_content`;
CREATE TABLE IF NOT EXISTS `qb_links_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '链接名称',
  `link` varchar(255) DEFAULT '' COMMENT '链接地址',
  `image` varchar(255) DEFAULT '' COMMENT '链接图片',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1 显示  0 隐藏',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `type` varchar(10) NOT NULL COMMENT '链接类型',
  `image_about` varchar(255) NOT NULL COMMENT '文字描述',
  `name_about` varchar(255) NOT NULL COMMENT '文字描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='友情链接表' AUTO_INCREMENT=1 ;