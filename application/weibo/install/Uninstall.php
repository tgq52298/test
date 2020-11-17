<?php 
namespace app\weibo\install;

use app\common\controller\AdminBase;
use think\Db;

class Uninstall extends AdminBase{
    public function run($id=0){
		//query("DELETE FROM `qb_hook_plugin` WHERE `hook_class` = 'app\\weibo\\hook\\Content'");
		//query("DELETE FROM `qb_hook_plugin` WHERE `hook_class` = 'app\\weibo\\hook\\MsgRemind'");
        Db::name('hook_plugin')->where('hook_class','like',"app\\\\".'weibo'."\\\hook\\\%")->delete();
    }
}