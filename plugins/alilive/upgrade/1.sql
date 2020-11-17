ALTER TABLE  `qb_alilive_log` ADD  `end_time` INT( 10 ) NOT NULL COMMENT  '直播结束时间';
ALTER TABLE  `qb_alilive_log` ADD INDEX (  `ext_id` ,  `ext_sys` );
ALTER TABLE  `qb_alilive_log` ADD INDEX (  `uid` );
ALTER TABLE  `qb_alilive_log` ADD  `timelong` MEDIUMINT NOT NULL COMMENT  '直播时间总长度(秒)';

ALTER TABLE  `qb_alilive_log` ADD INDEX (  `create_time` ,  `end_time` );
