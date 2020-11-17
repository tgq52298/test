<?php
namespace app\exam\model;
use think\Model;

/**
 * 考试成绩记录
 */
class Putin extends Model
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
    
    protected static function scopeInitKey(){}
    protected function initialize()
    {
        parent::initialize();
        preg_match_all('/([_a-z]+)/',get_called_class(),$array);
        self::$model_key = $array[0][1];
        self::$base_table = $array[0][1].'_content';
        self::$table_pre = config('database.prefix');
        //字段表，带数据表前缀如qb_form_field
        $this->table = self::$table_pre.self::$model_key.'_putin';
    }
    
    
    public static function getInfo($map=[])
    {
        empty(self::$model_key) && self::InitKey();
        $data = self::get($map);
        if(!empty($data)){
            return $data->toArray();
        }
    }
    
    public function Label($tag_array=[] , $page=0){
        empty(self::$model_key) && self::InitKey();
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
        $dirname = self::$model_key;
        $array = getArray($data);
        foreach($array['data'] AS $key=>$rs){
            $rs['title'] = $rs['username'] = get_user_name($rs['uid']);
            $rs['picurl'] = get_user_icon($rs['uid']);
            $rs['url'] = get_url('user',$rs['uid']);
            $array['data'][$key] = $rs;
        }
        return $array;
    }
    
    /**
     * 要使用到联表查询的标签,因为要用到数据筛选,所以必须要联表查询
     * @param array $tag_array
     * @param number $page
     * @return array|NULL[]|unknown
     */
    public function LabelJoin($tag_array=[] , $page=0){
        empty(self::$model_key) && self::InitKey();
        $cfg = unserialize($tag_array['cfg']);
        $rows = $cfg['rows']>0 ? $cfg['rows'] : 5;
        $order = $cfg['order'] ?: 'A.id';
        $by = $cfg['by'] ?: 'desc';
        $map = [];
        
        if($cfg['where']){  //用户自定义的查询语句
            $_array = fun('label@where',$cfg['where'],$cfg);
            if($_array){
                $map = array_merge($map,$_array);
            }
        }
        $dirname = self::$model_key;
        $data = self::alias('A') -> join($dirname.'_category B','A.paperid = B.id','LEFT') -> where($map) -> field('A.*,B.name,B.user_num,B.ave_fen') -> order("$order $by") -> paginate($rows,false,['page'=>$page]);   
        $array = getArray($data);
        foreach($array['data'] AS $key=>$rs){
            $rs['title'] = $rs['username'] = get_user_name($rs['uid']);
            $rs['picurl'] = get_user_icon($rs['uid']);
            $rs['url'] = $rs['usr_url'] = get_url('user',$rs['uid']);
            $rs['paper_url'] = urls('info/putinover',['fid'=>$rs['paperid']]);
            $array['data'][$key] = $rs;
        }
        return $array;
    }
   
}