<?php
namespace app\weibo\index;

use app\common\controller\index\Index AS _Index;

//频道主页
class Index extends _Index
{
    public function index(){
        if (!table_field('weibo_feed','ifread')) {
            into_sql("
ALTER TABLE  `qb_weibo_feed` ADD  `ifread` TINYINT( 1 ) NOT NULL COMMENT  '1代表已阅';
ALTER TABLE  `qb_weibo_feed` ADD INDEX (  `ifread` );
ALTER TABLE  `qb_weibo_visit` CHANGE  `aid`  `aid` INT( 7 ) NOT NULL COMMENT  '被访问者ID';
");
        }
        return parent::index();
    }
    
}