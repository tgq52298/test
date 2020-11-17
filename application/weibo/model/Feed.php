<?php

namespace app\weibo\model;

use think\Model;

//SNS信息
class Feed extends Model
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
        $this->table = self::$table_pre.self::$model_key.'_feed';
    }
    
    /**
     * 批量加入用户动态
     * @param array $data
     * @return array|\think\false
     */
    public function push_all($data=[]){
        self::InitKey();
        return $this->saveAll($data);
    }
    
    /**
     * 添加动态
     * @param array $data
     * @return boolean
     */
    public static function push_add($data=[]){
        self::InitKey();
        $result = self::create($data);
        if($result){
            return true;
        }
    }
    
    /**
     * 标签获取动态数据
     * @param array $config
     * @return unknown
     */
    public static function getList($config=[]){
        $cfg = unserialize($config['cfg']);
        $uid = $cfg['uid'];
        $rows = $cfg['rows'];
        $rows>0 || $rows=10;
        $map = [];
        $uid && $map['uid'] = $uid;
        if ($uid) {
            $listdb = self::where($map)->order('create_time','desc')->paginate($rows);
        }else{
            $listdb = self::where($map)->group('create_time')->order('create_time','desc')->paginate($rows);
        }        
//         $listdb->each(function(&$rs){
//             $rs['bloguid'] = $rs['uid'];    //博主UID在汇总页会用到,因为这个UID后面被占用了
//             if($rs['sysid']&&$rs['aid']){
//                 list($info,$reply) = fun('sns@get',$rs);    //主题 与 评论
//                 if (empty($info)) {     //主题已经不存在了
//                     //self::destroy($rs['id']);
//                     return ;
//                 }
//                 $rs['title'] = $info['title'];
//                 $rs['url'] = $info['url'];
//                 $rs['topic'] = $info;
//                 if($reply){                             //评论
//                     self::get_info($rs,$reply);
//                     $rs['reply'] = $reply;                    
//                     $rs['ctype'] = 2;
//                 }elseif($rs['type']=='fav'){        //被收录
//                     list($rs['uid'],$rs['about']) = explode("\t",$rs['about']);
//                     self::get_info($rs,[
//                             'uid'=>$rs['uid'],
//                             'create_time'=>$rs['create_time'],
//                     ]);
//                     $rs['ctype'] = 3;
//                 }else{                                   //发表的主题
//                     self::get_info($rs,$info);
//                     $rs['ctype'] = 1;
//                 }
//             }else{
//                 list($rs['uid'],$rs['about']) = explode("\t",$rs['about']);
//                 self::get_info($rs,[
//                         'uid'=>$rs['uid'],
//                         'create_time'=>$rs['create_time'],                                
//                 ]);
//             }
//         });
//         return $listdb;
        $aid = 0;
       $data = getArray($listdb);
       foreach ($data['data'] AS $key=>$rs){
           $rs['bloguid'] = $rs['uid'];    //博主UID在汇总页会用到,因为这个UID后面被占用了
           if($rs['sysid']&&$rs['aid']){
               list($info,$reply) = fun('sns@get',$rs);    //主题 与 评论
               if (empty($info)) {     //主题已经不存在了
                   self::destroy($rs['id']);
                   unset($data['data'][$key]);
                   continue;
               }
               if($info['status']==0){  //未审核的主题,也包括圈子私密主题
                   unset($data['data'][$key]);
                   continue;
               }
               if($aid == $rs['aid']){  //不要连续出现两条相同的主题
                   unset($data['data'][$key]);
                   continue;
               }
               $aid = $rs['aid'];
               $rs['title'] = $info['title'];
               $rs['url'] = $info['url'];
               $rs['topic'] = $info;
               if($reply){                             //评论
                   self::get_info($rs,$reply);
                   $rs['reply'] = $reply;
                   $rs['ctype'] = 2;
               }elseif($rs['type']=='fav'){        //被收录
                   list($rs['uid'],$rs['about']) = explode("\t",$rs['about']);
                   self::get_info($rs,[
                           'uid'=>$rs['uid'],
                           'create_time'=>$rs['create_time'],
                   ]);
                   $rs['ctype'] = 3;
               }else{                                   //发表的主题
                   self::get_info($rs,$info);
                   $rs['ctype'] = 1;
               }
           }else{
               list($rs['uid'],$rs['about']) = explode("\t",$rs['about']);
               self::get_info($rs,[
                       'uid'=>$rs['uid'],
                       'create_time'=>$rs['create_time'],
               ]);
           }
           $data['data'][$key] = $rs;
        }
        return $data;        
    }
    
    protected static function get_info(&$rs,$info){
        $rs['username'] = get_user_name($info['uid']);
        $rs['user_icon'] = get_user_icon($info['uid']);
        $rs['user_url'] = get_url('user',$info['uid']);
        $rs['time'] = format_time($info['create_time'],true);
        $rs['content'] = $info['content'];
        $rs['uid'] = $info['uid'];
    }
}
