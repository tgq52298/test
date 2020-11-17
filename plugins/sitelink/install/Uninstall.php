<?php
namespace plugins\sitelink\install;
use app\common\controller\AdminBase;
use think\Db;
class Uninstall extends AdminBase{
	public function run($id=0){
		$plugins=Db::name('plugin')->where(['id'=>$id])->value('keywords');
		//卸载钩子动作
		Db::name('hook_plugin')->where('plugin_key',$plugins)->delete();
		return true;
	}
}