INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'live_api_url', '直播接口', 'textarea', 'text NOT NULL', '', '', '', 1, 1, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '更多设置', '', '', '', '', '', '<script type="text/javascript">\r\nvar str = `\r\n<input placeholder="推流地址" type="text" class="layui-input liveApiUrl" data-type="push_url"><br>\r\n<input placeholder="m3u8播流地址" type="text" class="layui-input liveApiUrl" data-type="m3u8_url"><br>\r\n<input placeholder="rtmp播流地址" type="text" class="layui-input liveApiUrl" data-type="rtmp_url"><br>\r\n<input placeholder="flv播流地址" type="text" class="layui-input liveApiUrl" data-type="flv_url"><br>\r\n`;\r\n$(function(){\r\n	$("#atc_live_api_url").after(str);\r\n	$("#atc_live_api_url").hide();\r\n	var vl = {};\r\n	try{\r\n		vl = JSON.parse( $("#atc_live_api_url").val() );\r\n	}catch(e){}\r\n	$(".liveApiUrl").each(function(){\r\n		var type = $(this).data(''type'');\r\n		if(vl[type]!=undefined){\r\n			$(this).val(vl[type])\r\n		}\r\n	});\r\n	$(".liveApiUrl").blur(function(){\r\n		var ar = {};\r\n		$(".liveApiUrl").each(function(){\r\n			var type = $(this).data(''type'');\r\n			if($(this).val()!='''')ar[type] = $(this).val();\r\n		});\r\n		var str = JSON.stringify(ar);\r\n		$("#atc_live_api_url").val( str==''{}''?'''':str );\r\n	});\r\n});\r\n</script>', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'live_api_url', '直播接口', 'textarea', 'text NOT NULL', '', '', '', 1, 2, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '更多设置', '', '', '', '', '', '<script type="text/javascript">\r\nvar str = `\r\n<input placeholder="推流地址" type="text" class="layui-input liveApiUrl" data-type="push_url"><br>\r\n<input placeholder="m3u8播流地址" type="text" class="layui-input liveApiUrl" data-type="m3u8_url"><br>\r\n<input placeholder="rtmp播流地址" type="text" class="layui-input liveApiUrl" data-type="rtmp_url"><br>\r\n<input placeholder="flv播流地址" type="text" class="layui-input liveApiUrl" data-type="flv_url"><br>\r\n`;\r\n$(function(){\r\n	$("#atc_live_api_url").after(str);\r\n	$("#atc_live_api_url").hide();\r\n	var vl = {};\r\n	try{\r\n		vl = JSON.parse( $("#atc_live_api_url").val() );\r\n	}catch(e){}\r\n	$(".liveApiUrl").each(function(){\r\n		var type = $(this).data(''type'');\r\n		if(vl[type]!=undefined){\r\n			$(this).val(vl[type])\r\n		}\r\n	});\r\n	$(".liveApiUrl").blur(function(){\r\n		var ar = {};\r\n		$(".liveApiUrl").each(function(){\r\n			var type = $(this).data(''type'');\r\n			if($(this).val()!='''')ar[type] = $(this).val();\r\n		});\r\n		var str = JSON.stringify(ar);\r\n		$("#atc_live_api_url").val( str==''{}''?'''':str );\r\n	});\r\n});\r\n</script>', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'live_api_url', '直播接口', 'textarea', 'text NOT NULL', '', '', '', 1, 3, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '更多设置', '', '', '', '', '', '<script type="text/javascript">\r\nvar str = `\r\n<input placeholder="推流地址" type="text" class="layui-input liveApiUrl" data-type="push_url"><br>\r\n<input placeholder="m3u8播流地址" type="text" class="layui-input liveApiUrl" data-type="m3u8_url"><br>\r\n<input placeholder="rtmp播流地址" type="text" class="layui-input liveApiUrl" data-type="rtmp_url"><br>\r\n<input placeholder="flv播流地址" type="text" class="layui-input liveApiUrl" data-type="flv_url"><br>\r\n`;\r\n$(function(){\r\n	$("#atc_live_api_url").after(str);\r\n	$("#atc_live_api_url").hide();\r\n	var vl = {};\r\n	try{\r\n		vl = JSON.parse( $("#atc_live_api_url").val() );\r\n	}catch(e){}\r\n	$(".liveApiUrl").each(function(){\r\n		var type = $(this).data(''type'');\r\n		if(vl[type]!=undefined){\r\n			$(this).val(vl[type])\r\n		}\r\n	});\r\n	$(".liveApiUrl").blur(function(){\r\n		var ar = {};\r\n		$(".liveApiUrl").each(function(){\r\n			var type = $(this).data(''type'');\r\n			if($(this).val()!='''')ar[type] = $(this).val();\r\n		});\r\n		var str = JSON.stringify(ar);\r\n		$("#atc_live_api_url").val( str==''{}''?'''':str );\r\n	});\r\n});\r\n</script>', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'live_api_url', '直播接口', 'textarea', 'text NOT NULL', '', '', '', 1, 4, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '更多设置', '', '', '', '', '', '<script type="text/javascript">\r\nvar str = `\r\n<input placeholder="推流地址" type="text" class="layui-input liveApiUrl" data-type="push_url"><br>\r\n<input placeholder="m3u8播流地址" type="text" class="layui-input liveApiUrl" data-type="m3u8_url"><br>\r\n<input placeholder="rtmp播流地址" type="text" class="layui-input liveApiUrl" data-type="rtmp_url"><br>\r\n<input placeholder="flv播流地址" type="text" class="layui-input liveApiUrl" data-type="flv_url"><br>\r\n`;\r\n$(function(){\r\n	$("#atc_live_api_url").after(str);\r\n	$("#atc_live_api_url").hide();\r\n	var vl = {};\r\n	try{\r\n		vl = JSON.parse( $("#atc_live_api_url").val() );\r\n	}catch(e){}\r\n	$(".liveApiUrl").each(function(){\r\n		var type = $(this).data(''type'');\r\n		if(vl[type]!=undefined){\r\n			$(this).val(vl[type])\r\n		}\r\n	});\r\n	$(".liveApiUrl").blur(function(){\r\n		var ar = {};\r\n		$(".liveApiUrl").each(function(){\r\n			var type = $(this).data(''type'');\r\n			if($(this).val()!='''')ar[type] = $(this).val();\r\n		});\r\n		var str = JSON.stringify(ar);\r\n		$("#atc_live_api_url").val( str==''{}''?'''':str );\r\n	});\r\n});\r\n</script>', '', '', '', 1);
INSERT INTO `qb_qun_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`, `script`, `trigger`, `range_opt`, `group_view`, `index_hide`) VALUES(0, 'live_api_url', '直播接口', 'textarea', 'text NOT NULL', '', '', '', 1, 5, '', '', '', '', '', 2, '', '', '', -1, 0, 0, 0, '更多设置', '', '', '', '', '', '<script type="text/javascript">\r\nvar str = `\r\n<input placeholder="推流地址" type="text" class="layui-input liveApiUrl" data-type="push_url"><br>\r\n<input placeholder="m3u8播流地址" type="text" class="layui-input liveApiUrl" data-type="m3u8_url"><br>\r\n<input placeholder="rtmp播流地址" type="text" class="layui-input liveApiUrl" data-type="rtmp_url"><br>\r\n<input placeholder="flv播流地址" type="text" class="layui-input liveApiUrl" data-type="flv_url"><br>\r\n`;\r\n$(function(){\r\n	$("#atc_live_api_url").after(str);\r\n	$("#atc_live_api_url").hide();\r\n	var vl = {};\r\n	try{\r\n		vl = JSON.parse( $("#atc_live_api_url").val() );\r\n	}catch(e){}\r\n	$(".liveApiUrl").each(function(){\r\n		var type = $(this).data(''type'');\r\n		if(vl[type]!=undefined){\r\n			$(this).val(vl[type])\r\n		}\r\n	});\r\n	$(".liveApiUrl").blur(function(){\r\n		var ar = {};\r\n		$(".liveApiUrl").each(function(){\r\n			var type = $(this).data(''type'');\r\n			if($(this).val()!='''')ar[type] = $(this).val();\r\n		});\r\n		var str = JSON.stringify(ar);\r\n		$("#atc_live_api_url").val( str==''{}''?'''':str );\r\n	});\r\n});\r\n</script>', '', '', '', 1);

ALTER TABLE  `qb_qun_content1` ADD  `live_api_url` TEXT NOT NULL COMMENT  '直播接口';
ALTER TABLE  `qb_qun_content2` ADD  `live_api_url` TEXT NOT NULL COMMENT  '直播接口';
ALTER TABLE  `qb_qun_content3` ADD  `live_api_url` TEXT NOT NULL COMMENT  '直播接口';
ALTER TABLE  `qb_qun_content4` ADD  `live_api_url` TEXT NOT NULL COMMENT  '直播接口';
ALTER TABLE  `qb_qun_content5` ADD  `live_api_url` TEXT NOT NULL COMMENT  '直播接口';