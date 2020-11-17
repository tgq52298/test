ALTER TABLE  `qb_bbs_content1` ADD  `qun_status` TINYINT( 1 ) NOT NULL COMMENT  '圈子扩展状态,比如置顶';
ALTER TABLE  `qb_bbs_content1` ADD INDEX (  `qun_status` );