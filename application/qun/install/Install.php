<?php 
namespace app\qun\install;

use app\common\controller\AdminBase;


class Install extends AdminBase{
    public function run($id=0){
        //论坛的数据表需要补字段,才能按置顶排序
        if ( !table_field('bbs_content1','qun_status') ) {
            into_sql("ALTER TABLE  `qb_bbs_content1` ADD  `qun_status` TINYINT( 1 ) NOT NULL COMMENT  '圈子扩展状态,比如置顶';
ALTER TABLE  `qb_bbs_content1` ADD INDEX (  `qun_status` );",true,0);
        }
    }
}