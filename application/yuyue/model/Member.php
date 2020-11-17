<?php

namespace app\yuyue\model;

use think\Model;
use think\Db;

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
    
    
    public static function getList($map=[],$rows=10,$order='',$by=''){
        $order = in_array($order, ['id','money','totalnum']) ? $order : 'id';
        $by = $by=='asc' ? 'asc' : 'desc';
        $rows = intval($rows) ?: 10;
        
        $subQuery = self::where($map)
        ->field('*')
        ->order('id desc')
        ->buildSql();
        
        if (in_array($map['type'][1], [1,2,3])) { //1是砍价,2是拍卖加油助威,3是拍卖出价,4秒杀
            $data_list = Db::table($subQuery.' a')
            ->field($map['type'][1]==3?'*':'*,sum(money) AS totalmoney')
            ->group($map['order_id']?'uid':'order_id')
            ->order('id','desc')
            ->paginate($rows);
        }elseif ($map['type'][1]==4) { //秒杀
            $data_list = Db::table($subQuery.' a')
            ->field('*,count(id) AS totalnum')
            ->group($order=='totalnum'?'order_id':'uid')
            ->order($order=='totalnum'?'totalnum':'id',$by)
            ->paginate($rows);
        }else{
            $data_list = self::where($map)->order($order,$by)->paginate($rows);
        }
        $data_list = getArray($data_list);
        foreach($data_list['data'] AS $key=>$rs){
            if (in_array($map['type'][1], [1,2,3]) && !$map['order_id']) { //1是砍价,2是拍卖加油助威,3是拍卖出价
                $vs = Db('yuyue_order')->alias('a')->join('booking_content'.($map['type'][1]==1?2:3).' b','a.shopid = b.id','LEFT')->field('a.*,b.title,b.price,b.bottom_price,b.begin_time,b.end_time,b.limit_day')->where('a.id',$rs['order_id'])->find();
                if ($vs) {
                    $rs = array_merge($rs,$vs);
                }
            }
            //$rs['create_time'] = format_time($rs['create_time']);
            $rs['username'] = get_user_name($rs['uid']);
            $rs['url'] = get_url('user',$rs['uid']);
            $rs['icon'] = get_user_icon($rs['uid']);
            $data_list['data'][$key] = $rs;
        }
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
        if($cfg['type']){
            $map['type'] = $cfg['type'];
        }else{
            $map['type'] = 1;
        }
        if($cfg['where']){  //用户自定义的查询语句
            $_array = fun('label@where',$cfg['where'],$cfg);
            if($_array){
                $map = array_merge($map,$_array);
            }
        }
        return static::getList($map,$cfg['rows'],$cfg['order'],$cfg['by']);
    }
    
}
