INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '接口网址', 'wnsms_url', '', 'text', '', 0, '', '比如:http://xxx.com/?id=帐号&pwd=密码&to=$mob&content=$content&time=', 7, 0);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES(0, -1, '成功发送短信返回代码', 'wnsms_okcode', '', 'text', '', 0, '', '填写部分特定唯一有区别于发送不成功的代码即可', 8, 0);


UPDATE `qb_config` SET  `c_value`='wnsms' WHERE  `c_key` =  'sms_type';