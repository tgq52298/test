<?php

namespace app\hbfenlei\model;
use app\common\model\M;
use think\Db;

//表单模型
class Module extends M
{
    public static function createTable($id,$name)
    {
        parent::createTable($id,$name);
        
        $table = self::$table_pre . self::$base_table.$id;
        
        $sql = "ALTER TABLE  `{$table}` ADD  `haibao` VARCHAR( 50 ) NOT NULL COMMENT  '海报模板路径'";
        
        into_sql($sql);
        $data = [
                'name'        => 'haibao',
                'title'       => '海报模板',
                'field_type'      => 'varchar(50) NOT NULL',
                'type'        => 'text',
                'mid'        => $id,
                'listshow'        => '0',
                'ifsearch'        => '0',
                'ifmust'        => '0',
                'show'        => '0',
                'list'        => '-1',
        ];
        Db::name(self::$model_key.'_field')->insert($data);
        
        return true;
    }
}