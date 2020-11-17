<?php

namespace plugins\badwords\install;
use app\common\controller\AdminBase;
use think\Db;

class Install extends AdminBase{
    public function run($id=0){
        $ishook = Db::name('hook')->where('name','comment_add_end')->find();
        $ishook2 = Db::name('hook')->where('name','reply_add_end')->find();
        if(!$ishook){
            into_sql("INSERT INTO `qb_hook`(`id`,`name`,`about`,`ifopen`,`list`) VALUES('','comment_add_end','评论回复接口', 1, 0)");
        }
        if(!$ishook2){
            into_sql("INSERT INTO `qb_hook`(`id`,`name`,`about`,`ifopen`,`list`) VALUES('','reply_add_end','论坛回复接口', 1, 0)");
        }
    }
}