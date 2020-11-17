<?php
namespace plugins\kuaidi\install;
use app\common\controller\AdminBase;
use think\Db;
class Uninstall extends AdminBase{
	public function run($id=0){
		$plugins=Db::name('plugin')->where(['id'=>$id])->value('keywords');
		Db::name('hook_plugin')->where('plugin_key',$plugins)->delete();
	} 
}