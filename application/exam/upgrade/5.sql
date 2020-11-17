ALTER TABLE  `qb_exam_content1` CHANGE  `title`  `title` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '' COMMENT  '试题名称';
ALTER TABLE  `qb_exam_content1` CHANGE  `answer_a`  `answer_a` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '选项A';
ALTER TABLE  `qb_exam_content1` CHANGE  `answer_b`  `answer_b` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '选项B';
ALTER TABLE  `qb_exam_content1` CHANGE  `answer_c`  `answer_c` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '选项C';
ALTER TABLE  `qb_exam_content1` CHANGE  `answer_d`  `answer_d` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '选项D';

ALTER TABLE  `qb_exam_content2` CHANGE  `title`  `title` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '' COMMENT  '试题名称';
ALTER TABLE  `qb_exam_content2` CHANGE  `answer_a`  `answer_a` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '选项A';
ALTER TABLE  `qb_exam_content2` CHANGE  `answer_b`  `answer_b` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '选项B';
ALTER TABLE  `qb_exam_content2` CHANGE  `answer_c`  `answer_c` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '选项C';
ALTER TABLE  `qb_exam_content2` CHANGE  `answer_d`  `answer_d` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '选项D';

ALTER TABLE  `qb_exam_content3` CHANGE  `title`  `title` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '' COMMENT  '试题名称';



UPDATE `qb_exam_field` SET type='ueditor',field_type='text NOT NULL' WHERE name IN ('title','answer_a','answer_b','answer_c','answer_d','content') AND mid IN (1,2,3);


ALTER TABLE  `qb_exam_field` ADD  `input_width` VARCHAR( 7 ) NOT NULL COMMENT  '输入表单宽度',ADD  `input_height` VARCHAR( 7 ) NOT NULL COMMENT  '输入表单高度',ADD  `unit` VARCHAR( 20 ) NOT NULL COMMENT  '单位名称',ADD  `match` VARCHAR( 150 ) NOT NULL COMMENT  '表单正则匹配',ADD  `css` VARCHAR( 20 ) NOT NULL COMMENT  '表单CSS类名';
ALTER TABLE  `qb_exam_field` ADD  `script` TEXT NOT NULL COMMENT  'JS脚本',ADD  `trigger` VARCHAR( 255 ) NOT NULL COMMENT  '选择某一项后,联动触发显示其它字段';
ALTER TABLE  `qb_exam_field` ADD  `range_opt` TEXT NOT NULL COMMENT  '范围选择,比如价格范围',ADD  `group_view` VARCHAR( 255 ) NOT NULL COMMENT  '允许哪些用户组查看',ADD  `index_hide` TINYINT( 1 ) NOT NULL COMMENT  '是否前台不显示并不做转义处理';
ALTER TABLE  `qb_exam_field` CHANGE  `title`  `title` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '' COMMENT  '字段标题';

ALTER TABLE  `qb_exam_field` ADD  `group_post` VARCHAR( 255 ) NOT NULL COMMENT  '允许使用此字段的用户组';





#######下面填空题新加的字段


DROP TABLE IF EXISTS `qb_exam_content4`;
CREATE TABLE IF NOT EXISTS `qb_exam_content4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模型ID',
  `fid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `title` text NOT NULL COMMENT '题目',
  `ispic` tinyint(4) NOT NULL COMMENT '是否带组图',
  `picurl` varchar(80) NOT NULL DEFAULT '' COMMENT '封面图',
  `uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态：比如审核与否',
  `replynum` mediumint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数',
  `content` text NOT NULL COMMENT '内容介绍',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '发布者的IP',
  `list` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序值',
  `answer` varchar(256) NOT NULL COMMENT '答案',
  `ext_sys` smallint(5) NOT NULL COMMENT '扩展字段关联系统',
  `ext_id` mediumint(7) NOT NULL COMMENT '扩展字段关联ID',
  `grade` varchar(50) NOT NULL COMMENT '所属年级',
  `kemu` varchar(50) NOT NULL COMMENT '所属科目',
  `step` varchar(50) NOT NULL COMMENT '所属章节',
  `difficult` tinyint(1) NOT NULL COMMENT '试题难度',
  `is_share` tinyint(4) NOT NULL COMMENT '是否共享',
  `money` smallint(4) NOT NULL COMMENT '售价多少积分',
  `myfid` mediumint(7) NOT NULL COMMENT '用户自定义分类',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `list` (`list`),
  KEY `ext_id` (`ext_id`,`ext_sys`),
  KEY `grade` (`grade`),
  KEY `kemu` (`kemu`),
  KEY `step` (`step`),
  KEY `difficult` (`difficult`),
  KEY `is_share` (`is_share`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='填空题内容主表' AUTO_INCREMENT=1 ;


INSERT INTO `qb_exam_module` (`id`, `keyword`, `title`, `layout`, `icon`, `list`, `create_time`, `status`) VALUES(4, '', '填空题', '', '', 100, 1590735732, 0);

DELETE FROM `qb_exam_field` WHERE `mid`=4;

INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'title', '题目', 'ueditor', 'text NOT NULL', '', '', ' <script>$(function(){ if($("#form_group_step input").length<1){ $("#form_group_step").remove();} if($("#form_group_grade input").length<1){ $("#form_group_grade").remove();} if($("#form_group_kemu input").length<1){ $("#form_group_kemu").remove();} });</script> ', 0, 4, '', '', '', '', '', 2, '', '', '', 100, 1, 1, 1, '0', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'picurl', '图片', 'jcrop', 'varchar(80) NOT NULL', '', '', '', 0, 4, '', '', '', '', '', 2, '', '', '', 80, 0, 0, 0, '0', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'content', '答案详细分析', 'ueditor', 'text NOT NULL', '', '', '', 0, 4, '', '', '', '', '', 2, '', '', '', 0, 0, 0, 0, '0', '', '', '', '', '', '', '', '', '', 0);
INSERT INTO `qb_exam_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'answer', '答案', 'text', 'varchar(256) NOT NULL', '', '', '多个用竖线隔开比如“10|10个|十”', 0, 4, '', '', '', '', '', 2, '', '', '', 90, 0, 0, 0, '0', '', '', '', '', '', '', '', '', '', 0);



###########上面是填空题新加的字段



ALTER TABLE  `qb_exam_conten` ADD  `view` MEDIUMINT( 7 ) NOT NULL COMMENT  '浏览量',ADD  `status` TINYINT( 2 ) NOT NULL COMMENT  '状态,-1回收站,0未审,1已审',ADD  `list` INT( 10 ) NOT NULL COMMENT  '排序值',ADD  `ext_id` MEDIUMINT( 7 ) NOT NULL COMMENT  '关联主题ID',ADD  `ext_sys` SMALLINT( 4 ) NOT NULL COMMENT  '关联系统ID';
update `qb_exam_conten` set `view`=1;