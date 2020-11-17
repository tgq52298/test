<?php
namespace app\exam\model;
use think\Model;

//收藏试卷,不是试题
class Favpaper extends Model
{
	
    // 设置当前模型对应的完整数据表名称
    protected $table;
    
    //以下三项必须在这里先赋值，不然下面的重新定义table会不生效
    protected $autoWriteTimestamp = true;   // 自动写入时间戳
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $resultSetType = 'array';
    
    protected static $base_table;
    protected static $model_key;
    protected static $table_pre;
    
    protected static function scopeInitKey(){}
    protected function initialize()
    {
        parent::initialize();
        preg_match_all('/([_a-z]+)/',get_called_class(),$array);
        self::$model_key = $array[0][1];
        self::$base_table = $array[0][1].'_content';
        self::$table_pre = config('database.prefix');
        //字段表，带数据表前缀如qb_form_field
        $this->table = self::$table_pre.self::$model_key.'_favpaper';
    }
    
    public function label($tag_array=[],$page=0){
        $cfg = unserialize($tag_array['cfg']);
        
        $rows = $cfg['rows']>0 ? $cfg['rows'] : 5;
        $order = $cfg['order'] ?: 'id';
        $by = $cfg['by'] ?: 'desc';
        $map = [];
        
        if($cfg['where']){  //用户自定义的查询语句
            $_array = fun('label@where',$cfg['where'],$cfg);
            if($_array){
                $map = array_merge($map,$_array);
            }
        }
        $data = self::where($map) -> order("$order $by") -> paginate($rows,false,['page'=>$page]);
        
        $data->each(function(&$rs){
            $rs = getArray(Category::where('id',$rs['aid'])->find());
            return $rs;
        });
        return $data;
    }
}