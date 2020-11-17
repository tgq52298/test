<?php
namespace app\bespeak\index;

//频道主页
class Index extends Content
{
	public function index(){
	    $mid = $this->m_model-> getId();
	    $this->assign('mid',$mid);
	    
	    $this->addField();//后续增加字段处理

	    return $this->fetch();
	}
	
	//增加字段
	public function addField(){
		//增加地图经度、纬度和人数限制字段：
		if (empty(table_field('bespeak_content1','map_x'))) {
			query("ALTER TABLE  `qb_bespeak_content1` ADD  `map_x`  double NOT NULL COMMENT  '地图经度'");
		}
		if (empty(table_field('bespeak_content1','map_y'))) {
			query("ALTER TABLE  `qb_bespeak_content1` ADD  `map_y`  double NOT NULL COMMENT  '地图纬度'");
		}
		if (empty(table_field('bespeak_content1','limit_persons'))) {
			query("ALTER TABLE  `qb_bespeak_content1` ADD  `limit_persons`  mediumint(6) NOT NULL COMMENT  '每天预约人数'");
			query("INSERT INTO `qb_bespeak_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES ('0', 'limit_persons', '每天预约人数', 'text', 'mediumint(6) NOT NULL', '', '', '', '1', '1', '', '', '', '', '', '2', '', '', '', '97', '0', '0', '0', '', '', '', '人', '', '')");
		}
	}
	
}
