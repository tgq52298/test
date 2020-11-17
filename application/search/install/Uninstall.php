<?php
namespace app\search\install;
use think\Db;
use app\common\controller\AdminBase;
class Uninstall extends AdminBase{
	public function run($id=0){
		Db::name('hook_plugin')->where('hook_class','app\search\hook\Add')->delete();
		Db::name('hook_plugin')->where('hook_class','app\search\hook\Add')->delete();
		Db::name('hook_plugin')->where('hook_class','app\search\hook\Add')->delete();
	}
}