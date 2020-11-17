<?php 
namespace app\weibo\install;

use app\common\controller\AdminBase;


class Install extends AdminBase{
    public function run($id=0){
        $res = query('hook',[
			'where'=>['name'=>'reply_add_end'],
			'count'=>'id'
			]);
		if(empty($res)){
			query("INSERT INTO `qb_hook` (`id`, `name`, `about`, `ifopen`, `list`) VALUES(0, 'reply_add_end', '论坛回复接口', 1, 0);");
		}

		$res = query('hook',[
			'where'=>['name'=>'comment_add_end'],
			'count'=>'id'
			]);
		if(empty($res)){
			query("INSERT INTO `qb_hook` (`id`, `name`, `about`, `ifopen`, `list`) VALUES(0, 'comment_add_end', '评论回复接口', 1, 0)");
		}
    }
}