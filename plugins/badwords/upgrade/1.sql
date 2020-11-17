DROP TABLE IF EXISTS `qb_badwords_kw`;
CREATE TABLE `qb_badwords_kw`  (
  `id` int(4) NOT NULL,
  `word_type` tinyint(1) NULL DEFAULT NULL,
  `kwords` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '关键词',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of qb_badwords_kw
-- ----------------------------
INSERT INTO `qb_badwords_kw` VALUES (1, 1, NULL);






