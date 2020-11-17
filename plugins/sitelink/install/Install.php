<?php
namespace plugins\sitelink\install;
use app\common\controller\AdminBase;
use think\Db;
class Install extends AdminBase{
	public function run($id=0){
		$hook=Db::name('hook')->where(['name'=>'cms_content_show'])->find();
		if(!$hook){
			$data=['name'=>'cms_content_show','about'=>'内容展示页接口','ifopen'=>'1'];
			Db::name('hook')->insert($data);
		}
	}
}