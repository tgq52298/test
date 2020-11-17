ALTER TABLE `qb_msgtask_task` ADD  `ext_id` INT( 10 ) NOT NULL COMMENT  '关联的主题ID',ADD  `ext_sys` MEDIUMINT( 6 ) NOT NULL COMMENT  '关联的模型ID';
ALTER TABLE `qb_msgtask_task` ADD INDEX (  `ext_id` ,  `ext_sys` );
