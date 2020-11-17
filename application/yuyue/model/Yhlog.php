<?php

namespace app\yuyue\model;

use think\Model;

/**
 * 用户领取的优惠券
 *
 */
class Yhlog extends Model
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
        $this->table = self::$table_pre.self::$model_key.'_yhlog';
    }
    
    /**
     * 列出某个用户对于某个商品可用的所有优惠券
     * @param number $id 商品ID
     * @param number $uid 用户的UID
     * @return unknown
     */
    public static function list_yh($id=0,$uid=0){
        $map = [
                'aid'=>$id,
                'uid'=>$uid,
                'ifuse'=>0,
                'end_time'=>[['=',0],['>',time()],'or'],
        ];
        $array = self::where($map)->order('money desc')->column(true);
        $listdb = [];
        foreach ($array AS $rs){
            $rs['end_time']>0 ? date('Y-m-d H:i',$rs['end_time']) : '长期有效';
            $listdb[] = $rs;
        }
        return $listdb;
    }
    
    
}
