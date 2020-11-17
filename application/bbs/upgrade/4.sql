ALTER TABLE  `qb_bbs_content1` ADD  `map_x` DOUBLE NOT NULL COMMENT  '坐标经度',ADD  `map_y` DOUBLE NOT NULL COMMENT  '坐标纬度',ADD  `map` VARCHAR( 32 ) NOT NULL COMMENT  '百度地图xy坐标';
ALTER TABLE  `qb_bbs_content1` ADD INDEX (  `map_x` );
ALTER TABLE  `qb_bbs_content1` ADD INDEX (  `map_y` );
INSERT INTO `qb_bbs_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES(0, 'map', '所在位置', 'bmap', 'varchar(32) NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '附加属性');
