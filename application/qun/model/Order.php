<?php

namespace app\qun\model;
use think\Model;

//会员购买课堂时长订单
class Order extends Model
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
        $this->table = self::$table_pre.self::$model_key.'_order';
    }
    
    /**
     * 统计用户在某个圈子里边的可用时长
     * @param number $aid
     * @param number $uid
     * @return number
     */
    public static function limit_time($aid=0,$uid=0){
        $info = self::where('aid',$aid)->where('uid',$uid)->where('(`timelong`-`usetime`)>0')->field('sum(`timelong`-`usetime`) AS num')->find();
        return intval($info['num']);
    }
    
    /**
     * 核算用户的观看时长流量 , 只有圈主设置了收费时长
     * @param number $aid 圈子ID
     * @param number $uid 用户UID
     * @param number $time 观看时间
     */
    public static function consume_time($aid=0,$uid=0,$time=0){
        $info = Content::getInfoByid($aid);
        if ($time>0 && $info['minute_money']){ //只有圈主设置了收费时长,才去核算用户的时长流量
            $rs = self::where('aid',$aid)->where('uid',$uid)->field("SIGN(timelong-usetime) AS num,id")->order('num desc,id asc')->find();
            if ($rs && $rs['num']==1) { //从最早买的先统计.
                self::where('aid',$aid)->where('uid',$uid)->setInc('usetime',abs($time));
            }
        }
    }
	
}