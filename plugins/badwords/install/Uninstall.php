<?php
namespace plugins\badwords\install;
use app\common\controller\AdminBase;
use think\Db;

class Uninstall extends AdminBase{
    public function run($id=0){
        Db::name('hook_plugin')->where('hook_class','like',"plugins\\\\".'badwords'."\\\hook\\\%")->delete();
    }
}