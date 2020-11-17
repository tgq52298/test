<?php
namespace app\weibo\model;

use think\Model;

//收藏夹
class Fav extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table;// = '__FORM_MODULE__';
    
    //以下三项必须在这里先赋值，不然下面的重新定义table会不生效
    protected $autoWriteTimestamp = true;   // 自动写入时间戳
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $resultSetType = 'array';
    
    protected static $base_table;
    protected static $model_key;
    protected static $table_pre;
    
    //为了调用initialize初始化,生成数据表前缀$model_key
    protected static function scopeInitKey(){}
    protected function initialize()
    {
        parent::initialize();
        preg_match_all('/([_a-z]+)/',get_called_class(),$array);
        self::$model_key = $array[0][1];
        self::$base_table = $array[0][1].'_content';
        self::$table_pre = config('database.prefix');
        //字段表，带数据表前缀如qb_form_field
        $this->table = self::$table_pre.self::$model_key.'_fav';
    }
    
    /**
     * 获取信息内容
     * @param number $aid 信息内容ID,
     * @param string $sysid 频道id
     * @return void|unknown
     */
    public static function get_info($aid=0,$sysid=''){
        static $mods = [];
        if (empty($mods)) {
            $mods = modules_config();
        }
        $dirname = $mods[$sysid]['keywords'];
        if (empty($dirname)) {
            return ;
        }
        $class = "app\\$dirname\\model\\Content";
        if(class_exists($class) && method_exists($class,'getInfoByid')){
            $obj = new $class;
            $info = $obj->getInfoByid($aid,true);
            if(empty($info)){
                return ;
            }
            $info['module_dir'] = $mods[$sysid]['keywords'];    //频道目录,生成频道网址要用到
            $info['module_name'] = $mods[$sysid]['name'];     //频道名称
            return $info;
        }
    }
    
}