<?php

namespace app\weibo\model;

use think\Model;

//用户的访问足迹
class Visit extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table;// = '__FORM_MODULE__';
    
    //以下三项必须在这里先赋值，不然下面的重新定义table会不生效
    protected $autoWriteTimestamp = false;   // 自动写入时间戳
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
        $this->table = self::$table_pre.self::$model_key.'_visit';
    }
    
    /**
     * 圈子里边调取访问过的游客
     * @param array $map
     * @param number $rows
     * @return unknown
     */
    public static function getMeberList($map=[],$rows=10){
        $rows = intval($rows) ?: 5;
        $data_list = self::where($map)->order("visittime desc")->paginate($rows);
        $data_list->each(function($rs,$key){
            $id = $rs['id'];
            $rs['username'] = get_user_name($rs['uid']);
            $rs['icon'] = get_user_icon($rs['uid']);
            if($rs['username']===''){
                self::destroy($id);
            }
            return $rs;
        });
         return $data_list;
    }
    
    /**
     * 会员查看访问过的圈子
     * @param array $map
     * @param number $rows
     * @return unknown
     */
    public static function getGroupList($map=[],$rows=10){
        $rows = intval($rows) ?: 5;
        $data_list = self::where($map)->order("visittime desc")->paginate($rows);
        $data_list->each(function(&$rs,$key){
            $id = $rs['id'];       
            $rs = Content::getInfoByid($rs['aid'],true);
            if(empty($rs)){
                self::destroy($id);
            }
            return $rs;
        });        
        return $data_list;
    }
    
    /**
     * 标签调用,我访问过的圈子
     * @param unknown $tag_array
     * @return unknown
     */
    public static function get_label($tag_array){
        $map = [];
        $cfg = unserialize($tag_array['cfg']);
        if($cfg['uid']){
            $map['uid'] = $cfg['uid'];
            return static::getGroupList($map,$cfg['rows']);
        }elseif($cfg['aid']){
            $map['aid'] = $cfg['aid'];            
        }
        return static::getMeberList($map,$cfg['rows']);
    }
    
}
