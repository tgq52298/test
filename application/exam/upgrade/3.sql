INSERT INTO `qb_exam_field` (`name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`) VALUES('just_test', '试卷类型', 'radio', 'tinyint(1) NOT NULL', '0', '0|正式试卷\r\n1|练习试卷', '练习试卷可以边做边看答案,可重复考试,正式试卷不能重复考试,考试期间不能看答案', 0, -3, '', '', '', '', '', 2, '', '', '', 0, 1, 1, 0);
ALTER TABLE  `qb_exam_category` ADD  `just_test` TINYINT( 1 ) NOT NULL COMMENT  '试卷类型';

