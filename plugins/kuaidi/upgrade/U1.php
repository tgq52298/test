<?php
namespace plugins\kuaidi\upgrade;
use think\Db;
class U1{
	public function up(){
		into_sql("DROP TABLE qb_kuaidi;",true,0);
		 into_sql("DROP TABLE IF EXISTS `qb_kuaidi`;
CREATE TABLE IF NOT EXISTS `qb_kuaidi` (
  `id` mediumint(7) NOT NULL AUTO_INCREMENT,
  `bianhao` varchar(30) NOT NULL DEFAULT '',
  `yibai` varchar(50) NOT NULL,
  `kuaibao` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='快递' AUTO_INCREMENT=16;",true,0);
		into_sql("INSERT INTO `qb_kuaidi` (`id`, `bianhao`, `yibai`, `kuaibao`, `name`) VALUES
(6, 'ZTO', 'zhongtong', 'zt', '中通速递'),
(7, 'YTKD', 'yuntongkuaidi', 'wt', '运通快递'),
(8, 'YD', 'yunda', 'yd', '韵达快递'),
(9, 'YTO', 'yuantong', 'yt', '圆通速递'),
(10, 'SF', 'shunfeng', 'sf', '顺丰快递'),
(11, 'STO', 'shentong', 'sto', '申通快递'),
(12, 'HHTT', 'tiantian', 'tt', '天天快递'),
(13, 'GTO', 'guotongkuaidi', 'gt ', '国通快递'),
(14, 'EMS', 'ems', 'ems', '邮政EMS'),
(15, 'HTKY', 'huitongkuaidi', 'ht', '百世汇通');",true,0);
	}
}