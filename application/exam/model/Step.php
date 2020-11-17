<?php
namespace app\exam\model;
//use think\Model;


//章节分类
class Step extends Category
{
    protected function initialize()
    {
        parent::initialize();
        //用到的数据表
        $this->table = self::$table_pre.self::$model_key.'_step';
    }
   
   
}