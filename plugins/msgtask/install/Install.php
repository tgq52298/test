<?php 
namespace plugins\msgtask\install;

use app\common\controller\AdminBase;
use think\Db;


class Install extends AdminBase{
    public function run($id=0){
        Db::name('timed_task')->where('class_file','like',"plugins\\\msgtask\\\task\\\Send")->delete();
        Db::name('timed_task')->insert([
            'type'=>'t_minutes',
            'title'=>'群发消息',
            'class_file'=>"plugins\\msgtask\\task\\Send",
            'minutes'=>3,
            'ifopen'=>1,
            'create_time'=>time(),
        ]);
    }
}