<?php
namespace app\exam\index;

//频道主页
class Index extends Content
{
	public function index(){
	    
		if (!table_field('exam_category','begin_time')) {
			into_sql("ALTER TABLE  `qb_exam_category` ADD  `begin_time` INT( 10 ) NOT NULL COMMENT  '考试开始日期',ADD  `end_time` INT( 10 ) NOT NULL COMMENT  '考试结束日期',ADD  `limit_time` SMALLINT( 3 ) NOT NULL COMMENT  '考试时间限制,单位分钟';");
		}
	    if (!table_field('exam_step','uid')) {
	        into_sql("ALTER TABLE  `qb_exam_step` ADD  `uid` INT( 7 ) NOT NULL COMMENT  '老师的uid' AFTER  `pid`;
ALTER TABLE  `qb_exam_step` ADD INDEX (  `uid` );

ALTER TABLE  `qb_exam_kemu` ADD  `uid` INT( 7 ) NOT NULL COMMENT  '老师的uid' AFTER  `pid`;
ALTER TABLE  `qb_exam_kemu` ADD INDEX (  `uid` );

ALTER TABLE  `qb_exam_grade` ADD  `uid` INT( 7 ) NOT NULL COMMENT  '老师的uid' AFTER  `pid`;
ALTER TABLE  `qb_exam_grade` ADD INDEX (  `uid` );

ALTER TABLE  `qb_exam_category` ADD  `uid` INT( 7 ) NOT NULL COMMENT  '老师的uid' AFTER  `pid`;
ALTER TABLE  `qb_exam_category` ADD INDEX (  `uid` );
ALTER TABLE  `qb_exam_putin` ADD  `use_time` INT( 10 ) NOT NULL COMMENT  '考试使用时间';

ALTER TABLE  `qb_exam_content1` ADD  `is_share` TINYINT NOT NULL COMMENT  '是否共享';
ALTER TABLE   `qb_exam_content1` ADD INDEX (  `is_share` );

ALTER TABLE  `qb_exam_content2` ADD  `is_share` TINYINT NOT NULL COMMENT  '是否共享';
ALTER TABLE   `qb_exam_content2` ADD INDEX (  `is_share` );

ALTER TABLE  `qb_exam_content3` ADD  `is_share` TINYINT NOT NULL COMMENT  '是否共享';
ALTER TABLE   `qb_exam_content3` ADD INDEX (  `is_share` );

ALTER TABLE  `qb_exam_content1` ADD  `money` SMALLINT( 4 ) NOT NULL COMMENT  '售价多少积分';
ALTER TABLE  `qb_exam_content2` ADD  `money` SMALLINT( 4 ) NOT NULL COMMENT  '售价多少积分';
ALTER TABLE  `qb_exam_content3` ADD  `money` SMALLINT( 4 ) NOT NULL COMMENT  '售价多少积分';

ALTER TABLE  `qb_exam_category` ADD  `money` SMALLINT( 4 ) NOT NULL COMMENT  '售价多少积分';
ALTER TABLE  `qb_exam_category` ADD  `status` TINYINT( 1 ) NOT NULL COMMENT  '审核状态';
ALTER TABLE  `qb_exam_category` ADD  `is_share` TINYINT( 1 ) NOT NULL DEFAULT  '1' COMMENT  '是否共享给所有人考试';
ALTER TABLE  `qb_exam_category` ADD INDEX (  `status` );
ALTER TABLE  `qb_exam_category` ADD INDEX (  `is_share` );
ALTER TABLE  `qb_exam_content1` ADD  `difficult` TINYINT( 1 ) NOT NULL COMMENT  '试题难度';
ALTER TABLE  `qb_exam_content2` ADD  `difficult` TINYINT( 1 ) NOT NULL COMMENT  '试题难度';
ALTER TABLE  `qb_exam_content3` ADD  `difficult` TINYINT( 1 ) NOT NULL COMMENT  '试题难度';
ALTER TABLE   `qb_exam_content1` ADD INDEX (  `difficult` );
ALTER TABLE   `qb_exam_content2` ADD INDEX (  `difficult` );
ALTER TABLE   `qb_exam_content3` ADD INDEX (  `difficult` );
",true,0);
	    }
	    
	    if (!query('exam_field',['where'=>['name'=>'is_share'],'count'=>'id'])) {
	        into_sql("
ALTER TABLE  `qb_exam_field` CHANGE  `mid`  `mid` MEDIUMINT( 5 ) NOT NULL DEFAULT  '0' COMMENT  '所属模型id';
INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(0, 'grade', '所属年级', 'select', 'smallint(5) NOT NULL', '', 'exam_grade@id,name', '', 0, -3, '', '', '', '', '', 2, '', '', '', 0, 1, 1, 0, '', '', '', '', '', '');
INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(0, 'kemu', '所属科目', 'select', 'smallint(5) NOT NULL', '', 'exam_kemu@id,name', '', 0, -3, '', '', '', '', '', 2, '', '', '', 0, 1, 1, 0, '', '', '', '', '', '');
INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(0, 'step', '所属章节', 'select', 'smallint(5) NOT NULL', '', 'exam_step@id,name', '', 0, -3, '', '', '', '', '', 2, '', '', '', 0, 1, 1, 0, '', '', '', '', '', '');
INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(0, 'begin_time', '允许考试开始日期', 'datetime', 'int(10) NOT NULL', '', '', '', 0, -3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '');
INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(0, 'end_time', '允许考试结束日期', 'datetime', 'int(10) NOT NULL', '', '', '', 0, -3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '');
INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(0, 'limit_time', '考试时间限制', 'number', 'smallint(3) NOT NULL', '', '', '单位分钟', 0, -3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '');
INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES(0, 'is_share', '是否共享给所有人考试', 'radio', 'tinyint(1) NOT NULL', '1', '0|私有\r\n1|共享', '', 0, -3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '', '', '', '', '', '');
");
	    }
	    
	    if (!table_field('exam_category','myfid')) {
	        into_sql("
ALTER TABLE  `qb_exam_field` CHANGE  `about`  `about` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '' COMMENT  '提示说明';

DROP TABLE IF EXISTS `qb_exam_mysort`;
CREATE TABLE IF NOT EXISTS `qb_exam_mysort` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户的UID',
  `name` varchar(80) NOT NULL COMMENT '分类名称',
  `list` int(10) NOT NULL,
  `logo` varchar(50) NOT NULL COMMENT '封面图',
  `ext_sys` smallint(4) NOT NULL COMMENT '扩展字段,关联的系统',
  `ext_id` mediumint(7) NOT NULL COMMENT '扩展字段,关联的系统ID',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `list` (`list`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户自定义分类' AUTO_INCREMENT=4 ;

INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES(0, 'myfid', '我的分类', 'select', 'int(7) NOT NULL DEFAULT ''0''', '', 'exam_mysort@id,name@uid', '<script>if($(\"#atc_myfid\").children().length<1)$(\"#form_group_myfid\").remove();</script>', 0, -3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '');

ALTER TABLE  `qb_exam_category` ADD  `myfid` INT( 7 ) NOT NULL COMMENT  '用户自定义分类';


ALTER TABLE  `qb_exam_content1` ADD  `myfid` INT( 7 ) NOT NULL COMMENT  '用户自定义分类';
ALTER TABLE  `qb_exam_content2` ADD  `myfid` INT( 7 ) NOT NULL COMMENT  '用户自定义分类';
ALTER TABLE  `qb_exam_content3` ADD  `myfid` INT( 7 ) NOT NULL COMMENT  '用户自定义分类';

ALTER TABLE  `qb_exam_content1` ADD INDEX (  `myfid` );
ALTER TABLE  `qb_exam_content2` ADD INDEX (  `myfid` );
ALTER TABLE  `qb_exam_content3` ADD INDEX (  `myfid` );
ALTER TABLE  `qb_exam_category` ADD INDEX (  `myfid` );


INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES(0, 'myfid', '我的分类', 'select', 'int(7) NOT NULL DEFAULT ''0''', '', 'exam_mysort@id,name@uid', '<script>if($(\"#atc_myfid\").children().length<1)$(\"#form_group_myfid\").remove();</script>', 0, 3, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '');
INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES(0, 'myfid', '我的分类', 'select', 'int(7) NOT NULL DEFAULT ''0''', '', 'exam_mysort@id,name@uid', '<script>if($(\"#atc_myfid\").children().length<1)$(\"#form_group_myfid\").remove();</script>', 0, 2, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '');
INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`) VALUES(0, 'myfid', '我的分类', 'select', 'int(7) NOT NULL DEFAULT ''0''', '', 'exam_mysort@id,name@uid', '<script>if($(\"#atc_myfid\").children().length<1)$(\"#form_group_myfid\").remove();</script>', 0, 1, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '');


update qb_exam_field set `about`=' <script>$(function(){ if($(\"#form_group_step input\").length<1){ $(\"#form_group_step\").remove();} if($(\"#form_group_grade input\").length<1){ $(\"#form_group_grade\").remove();} if($(\"#form_group_kemu input\").length<1){ $(\"#form_group_kemu\").remove();} });</script> ' where `name`='title';
");
	    }
	    
	    return $this->fetch();
	}

}
