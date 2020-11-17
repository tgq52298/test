DELETE FROM `qb_chatmod` WHERE `keywords`='exam';
INSERT INTO `qb_chatmod` (`id`, `uid`, `aid`, `type`, `name`, `about`, `icon`, `pcwap`, `keywords`, `init_jsfile`, `init_iframe`, `init_jscode`, `status`, `list`, `allowgroup`) VALUES(0, 0, 0, 1, '考试练习', '', 'fa fa-fw fa-building-o', 0, 'exam', '/public/static/libs/bui/pages/exam/init.js', '', '', 1, 0, '');
