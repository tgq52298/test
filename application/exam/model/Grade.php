<?php
namespace app\exam\model;
//use think\Model;


//年级分类
class Grade extends Category
{
    protected function initialize()
    {
        parent::initialize();
        //用到的数据表
        $this->table = self::$table_pre.self::$model_key.'_grade';
    }
    
   
}