ALTER TABLE  `qb_form_field` ADD  `ifsearch` TINYINT( 1 ) NOT NULL COMMENT  '是否为搜索字段' AFTER  `listshow` ,ADD  `ifmust` TINYINT( 1 ) NOT NULL COMMENT  '是否必填' AFTER  `ifsearch`;
