<?php 
namespace app\qun\install;

use app\common\controller\AdminBase;
use think\Db;

class Uninstall extends AdminBase{
    public function run($id=0){
        //query("DELETE FROM `qb_hook_plugin` WHERE `hook_class` = 'app\\qun\\hook\\Content'");
        Db::name('hook_plugin')->where('hook_class','like',"app\\\\".'qun'."\\\hook\\\%")->delete();
    }
}