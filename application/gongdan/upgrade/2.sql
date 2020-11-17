DELETE FROM `qb_gongdan_content` WHERE id=1;
DELETE FROM `qb_gongdan_content1` WHERE id=1;

INSERT INTO `qb_gongdan_content` (`id`, `mid`, `fid`, `uid`, `view`, `status`, `list`, `create_time`, `ext_id`, `ext_sys`, `title`) VALUES(1, 1, 1, 1, 30, 1, 1603671911, 1603671911, 0, 3, '无聊及广告与非法贴子举报');



INSERT INTO `qb_gongdan_content1` (`id`, `mid`, `fid`, `title`, `ispic`, `uid`, `view`, `status`, `replynum`, `create_time`, `update_time`, `list`, `picurl`, `content`, `province_id`, `city_id`, `zone_id`, `street_id`, `ext_sys`, `ext_id`, `begin_time`, `end_time`, `order_num`, `map_x`, `map_y`, `order_filed`, `onlybuyone`, `status_type`, `notice_group`) VALUES(1, 1, 1, '无聊及广告与非法贴子举报', 1, 1, 30, 1, 0, 1603671911, 1603692669, 1603671911, 'https://x1.f2.qibosoft.com/public/uploads/images/20201026/1_2020102609374159f49.jpg', '<p>欢迎大家如实举报，举报属实有效的，会有积分奖励！</p><p>恶意举报会扣除积分。</p>', 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, '[{"title":"举报性质","type":"radio","options":"广告贴\\n反动言论\\n色情相关\\n无聊贴\\n其它","must":"1","listshow":1},{"title":"内容标题","type":"text","options":"","must":"0","listshow":1},{"title":"举报网址","type":"text","options":"","must":"1","listshow":1},{"title":"内容截图","type":"images","options":"","must":"0","listshow":0},{"title":"举报附注","type":"textarea","options":"","must":"0","listshow":0}]', 0, '["举报属实|3|","举报无效|3,2|","虚假举报|3,2|","转发超管审核|2|3"]', '2');
