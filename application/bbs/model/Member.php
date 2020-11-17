<?php

namespace app\bbs\model;

use think\Model;


//贴子关联的会员信息,比如每个贴子里的打赏用户有哪些
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
    
    public static function getList($aid=0,$rid=0,$rows=4,$order='',$by='',$map=[]){
        $_map = $aid ? ['aid'=>$aid] : [];
        $_map['rid'] = intval($rid);
        $order = in_array($order, ['id','money']) ? $order : 'id';
        $by = $by=='asc' ? 'asc' : 'desc';
        $rows = intval($rows) ?: 5;
        $data_list = self::where($_map)->where($map)->order($order,$by)->paginate($rows);
        $data_list->each(function($rs,$key){
            $rs['username'] = get_user_name($rs['uid']);
            $rs['icon'] = get_user_icon($rs['uid']);
            return $rs;
        });
         return $data_list;
    }
    
    /**
     * 打赏
     * @param array $data
     */
    public static function reward($data=[]){
        $result = self::create($data);
        if($result){
            add_rmb($data['uid'], -$data['money'], 0,'打赏他人');
            if(!$data['rid']){
                Content::addField($data['aid'],'reward');
            }            
            return $result;
        }
    }
    
    /**
     * 给标签调用的.显示某个圈子里的所有成员
     * @param unknown $tag_array
     * @return unknown
     */
    public static function get_label($tag_array){
        $map = [];
        $cfg = unserialize($tag_array['cfg']);
        if($cfg['type']){
            $map['type'] =$cfg['type'];
        }
        return static::getList($cfg['aid'],$cfg['rid'],$cfg['rows'],$cfg['order'],$cfg['by'],$map);        
    }
    
    
}
