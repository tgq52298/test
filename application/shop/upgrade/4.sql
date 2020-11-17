INSERT INTO `qb_shop_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES(0, 'sncode', '消费密码', 'textarea', 'text NOT NULL', '', '', '每个消费密码换一行,用户付款成功后,自动派发 <a href="http://www.qibosoft.com/get_sn.php" target="_blank">点击批量生成</a>', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '商品属性');
ALTER TABLE  `qb_shop_content1` ADD  `sncode` TEXT NOT NULL COMMENT  '消费密码';
ALTER TABLE  `qb_shop_order` CHANGE  `shipping_code`  `shipping_code` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '' COMMENT  '物流单号或消费密码';
UPDATE `qb_shop_field` SET index_hide=1 WHERE `name`='sncode';

