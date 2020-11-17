<?php
namespace app\common\fun;
use think\Db;
class Kuaidi{
   
    public static function ajax(){
       return Db::name('kuaidi')->column(true);
    }
    
}