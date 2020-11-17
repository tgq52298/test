<?php 
namespace plugins\msgtask\install;

use app\common\controller\AdminBase;
use think\Db;

class Uninstall extends AdminBase{
    public function run($id=0){
        Db::name('timed_task')->where('class_file','like',"plugins\\\msgtask\\\task\\\Send")->delete();
    }
}