<?php

namespace app\zhidao\model;

use think\Model;


//问答的一些辅助信息
class Infomsg extends Model
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
        $this->table = self::$table_pre.self::$model_key.'_infomsg';
    }
    
    /**
     * 更新发贴量信息
     * @param string $if_topic 是否为主题
     * @param array $data
     */
    public static function updata_info($if_topic=false,$data=[]){
        //$info = getArray( self::get(['ext_id'=>intval($data['ext_id'])]) );
        $info = getArray( self::get(['ext_id'=>0]) );
        if(empty($info)){
            //$topic_num = Content::getNumByMid($data['mid']?:1,['ext_id'=>intval($data['ext_id'])]);
            $topic_num = Content::getNumByMid(1);
            $reply_num = Reply::where([])->count('id');
            $array = [
                    'posttime'=>time(),
                    'today_post'=>1,
                    'total_post'=>(intval($reply_num)+intval($topic_num)),
                    'total_topic'=>$topic_num,
                    'day_top_post'=>1,
            ];
            self::create($array);
        }else{
            if($if_topic){
                $info['total_topic']++;     //主题总量
            }
            $info['total_post']++;     //主题与回复的总量
            if(date('Ymd',$info['posttime'])==date('Ymd')){
                $info['today_post']++;      //今日发贴量,包括主题                
            }else{
                $info['yesterday_post'] = $info['today_post'];
                $info['today_post'] = 1;
            }
            $array = [
                    'id'=>$info['id'],
                    'posttime'=>time(),
                    'today_post'=>$info['today_post'],
                    'yesterday_post'=>$info['yesterday_post'],
                    'total_post'=>$info['total_post'],
                    'total_topic'=>$info['total_topic'],
                    'day_top_post'=>$info['day_top_post'],                    
            ];
            self::update($array);
        }
    }
    
    
}
