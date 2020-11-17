<?php
namespace app\exam\model;
use think\Model;

/**
 * 用户答题记录
 *
 */
class Answer extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table;// = '__FORM_MODULE__';
    
    //以下三项必须在这里先赋值，不然下面的重新定义table会不生效
    protected $autoWriteTimestamp = true;   // 自动写入时间戳
    protected $dateFormat = 'Y-m-d H:i';
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
        $this->table = self::$table_pre.self::$model_key.'_answer';
    }
    
    //
    public static function getInfo($map=[])
    {
        empty(self::$model_key) && self::InitKey();
        $data = self::get($map);
        if(!empty($data)){
            return $data->toArray();
        }
    }
    
    /**
     * 考生考过的下一道题
     * @param number $id 记录ID,不是试题ID
     * @param number $uid
     * @return array|NULL[]|unknown
     */
    public static function get_next($id=0,$uid=0,$map=[]){
        empty(self::$model_key) && self::InitKey();
        $map['uid'] = $uid;
        if ($id) {
            $map['id'] = ['<',$id];
        }
        return getArray(self::where($map)->order('id desc')->limit(1)->find());        
    }
    
    /**
     * 考生考过的上一道题
     * @param number $id 记录ID,不是试题ID
     * @param number $uid
     * @return array|NULL[]|unknown
     */
    public static function get_prev($id=0,$uid=0,$map=[]){
        empty(self::$model_key) && self::InitKey();
        $map['uid'] = $uid;
        if ($id) {
            $map['id'] = ['>',$id];
        }
        return getArray(self::where($map)->order('id asc')->limit(1)->find());
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
            $fav_id = $rs['id'];
            $rs['topic'] = Content::getInfoByid($rs['aid']);
            return $rs;
        });
        return $data;
    }
   
}