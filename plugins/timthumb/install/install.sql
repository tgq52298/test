INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '最大图片宽度', 'MAX_WIDTH', '1000', 'text', '', 1, '', '只能输入整数', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '最大图片高度', 'MAX_HEIGHT', '1000', 'text', '', 1, '', '只能输入整数', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '缓存路径', 'FILE_CACHE_DIRECTORY', './thumbs', 'text', '', 1, '', '缓存路径（建议设置根目录某文件夹）', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '错误时的图片', 'ERROR_IMAGE', '', 'text', '', 1, '', '输入图片的url', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '未找到时图片', 'NOT_FOUND_IMAGE', '', 'text', '', 1, '', '输入图片的url', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '缩略图质量', 'DEFAULT_Q', '90', 'text', '', 1, '', '', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '允许的外部图片域', 'ALLOWED_SITES', '', 'text', '', 1, '', '格式：xxx.com;aaa.com <br/>！！只有授权域名下的图片才可以被缩略到本地！！', 99, -1);

INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '内存最大限制', 'MEMORY_LIMIT', '1024', 'text', '', 1, '', '[整形，单位M]', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '开启图片防盗链', 'BLOCK_EXTERNAL_LEECHERS', 'false', 'text', '', 1, '', '[true,false]', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '文件缓存更新时间', 'FILE_CACHE_TIME_BETWEEN_CLEANS', '300000', 'text', '', 1, '', '[秒]', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '缓存文件生存时间', 'FILE_CACHE_MAX_FILE_AGE', '300000', 'text', '', 1, '', '[秒]', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '最大处理图片', 'MAX_FILE_SIZE', '10485760', 'text', '', 1, '', '[限制此脚本最大处理多大体积的图片，默认10485760（10M）]', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '抓取远程图片的超时限制', 'CURL_TIMEOUT', '60', 'text', '', 1, '', '秒', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '浏览器对图片的缓存时间', 'BROWSER_CACHE_MAX_AGE', '3600', 'text', '', 1, '', '秒', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '默认裁剪格式', 'DEFAULT_ZC', '1', 'text', '', 1, '', '0：根据传入的值进行缩放（不裁剪）1：以最合适的比例裁剪和调整大小（裁剪）2：按比例调整大小，并添加边框（裁剪）', 99, -1);
INSERT INTO `qb_config` (`id`, `type`, `title`, `c_key`, `c_value`, `form_type`, `options`, `ifsys`, `htmlcode`, `c_descrip`, `list`, `sys_id`) VALUES('', -1, '是否进行图片锐化', 'DEFAULT_S', '0', 'text', '', 1, '', '0或者1', 99, -1);