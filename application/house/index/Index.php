<?php
namespace app\house\index;

//频道主页
class Index extends Content
{
	public function index(){

		$mid = $this->m_model-> getId();
		$this->assign('mid',$mid);

		//楼盘、求购、求租、出售、出租增加联系人字段：
		if (empty(table_field('house_content1','linkman'))) {
			query("ALTER TABLE  `qb_house_content1` ADD  `linkman`  varchar(80) NOT NULL COMMENT  '联系人'");
			query("INSERT INTO `qb_house_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES ('0', 'linkman', '联系人', 'text', 'varchar(80) NOT NULL', '', '', '', '1', '1', '', '', '', '', '', '2', '', '', '', '97', '0', '0', '0', '', '', '', '', '', '')");
		}
		if (empty(table_field('house_content2','linkman'))) {
			query("ALTER TABLE  `qb_house_content2` ADD  `linkman`  varchar(80) NOT NULL COMMENT  '联系人'");
			query("INSERT INTO `qb_house_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES ('0', 'linkman', '联系人', 'text', 'varchar(80) NOT NULL', '', '', '', '1', '2', '', '', '', '', '', '2', '', '', '', '97', '0', '0', '0', '', '', '', '', '', '')");
		}
		if (empty(table_field('house_content3','linkman'))) {
			query("ALTER TABLE  `qb_house_content3` ADD  `linkman`  varchar(80) NOT NULL COMMENT  '联系人'");
			query("INSERT INTO `qb_house_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES ('0', 'linkman', '联系人', 'text', 'varchar(80) NOT NULL', '', '', '', '1', '3', '', '', '', '', '', '2', '', '', '', '97', '0', '0', '0', '', '', '', '', '', '')");
		}
		if (empty(table_field('house_content4','linkman'))) {
			query("ALTER TABLE  `qb_house_content4` ADD  `linkman`  varchar(80) NOT NULL COMMENT  '联系人'");
			query("INSERT INTO `qb_house_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES ('0', 'linkman', '联系人', 'text', 'varchar(80) NOT NULL', '', '', '', '1', '4', '', '', '', '', '', '2', '', '', '', '97', '0', '0', '0', '', '', '', '', '', '')");
		}
		if (empty(table_field('house_content5','linkman'))) {
			query("ALTER TABLE  `qb_house_content5` ADD  `linkman`  varchar(80) NOT NULL COMMENT  '联系人'");
			query("INSERT INTO `qb_house_field` (`id`, `name`, `title`, `type`, `field_type`, `value`, `options`, `about`, `show`, `mid`, `ajax_url`, `next_items`, `param`, `format`, `table`, `level`, `key`, `option`, `pid`, `list`, `listshow`, `ifsearch`, `ifmust`, `nav`, `input_width`, `input_height`, `unit`, `match`, `css`) VALUES ('0', 'linkman', '联系人', 'text', 'varchar(80) NOT NULL', '', '', '', '1', '5', '', '', '', '', '', '2', '', '', '', '97', '0', '0', '0', '', '', '', '', '', '')");
		}

		return $this->fetch();
	}
}
