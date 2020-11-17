<?php
namespace app\vote\model;

use think\Model;

//投票用户
class Member extends Model
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
        $this->table = self::$table_pre.self::$model_key.'_member';
    }
    
    public static function getList($aid=0,$rows=10,$order='',$by='',$map=[]){
        $_map = $aid?['aid'=>$aid]:[];
        $order = in_array($order, ['id','type','view','update_time']) ? $order : 'id';
        $by = $by=='asc' ? 'asc' : 'desc';
        $rows = intval($rows) ?: 10;
        $data_list = self::where($_map)->where($map)->group($aid?'':'uid')->order($order,$by)->paginate($rows);
        $data_list->each(function($rs,$key){
            $rs['username'] = get_user_name($rs['uid']);
            $rs['icon'] = get_user_icon($rs['uid']);
            return $rs;
        });
         return $data_list;
    }
    
    
    /**
     * 给标签调用.显示某个投票选项里最新10个支持用户
     * @param unknown $tag_array
     * @return unknown
     */
    public static function get_label($tag_array){
        $map = [];
        $cfg = unserialize($tag_array['cfg']);
        if($cfg['type']=='yz'){
            $map['type'] = ['>',0];
        }elseif($cfg['type']=='noyz'){
            $map['type'] = 0;
        }

        return static::getList($cfg['aid'],$cfg['rows'],$cfg['order'],$cfg['by'],$map);        
    }
  
    
}
