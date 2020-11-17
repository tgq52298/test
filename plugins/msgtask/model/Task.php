<?php
namespace plugins\msgtask\model;
use think\Model;


class Task extends Model
{
	
    // 设置当前模型对应的完整数据表名称
    protected $table = '__MSGTASK_TASK__';
    protected $autoWriteTimestamp = true;   // 自动写入时间戳
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $resultSetType = 'array';
    
    /**
     * 创建发送任务
     * @param string $type 发送类型 0短消息,1微信,2短信,3邮件 ,多个用逗号隔开
     * @param array $touser_array 接收用户的数组,可以是UID,也可以是实际的手机或微信号或邮箱
     * @param number $fromuid 当前发送者UID
     * @param string $content 详细内容
     * @param string $title 标题,手机短信不用标题.
     * @param number $begin_time 定时发送时间
     */
    public static function add_task($type='',$touser_array=[],$fromuid=0,$content='',$title='',$begin_time=0){
        $data = [
            'title'=>$title,
            'content'=>$title,
            'uid'=>$fromuid,
            'begin_time'=>$begin_time,
            'type'=>$type,
        ];
        $result = self::create($data); //创建任务
        if($result){
            $tid = $result->id;
            $data = [
                'title'=>$title,
                'content'=>$title,
                'uid'=>$fromuid,
                'begin_time'=>$begin_time,
                'type'=>$type,
            ];
            $obj = new Log();
            $array= [];
            foreach($touser_array AS $user){
                
                if( is_numeric($user) && $user<99999999){
                    $touid = $user;
                    $touser = '';
                }else{
                    $touid = 0;
                    $touser = $user;
                }
                $array[] = [
                    'touid'=> $touid,
                    'touser'=>$touser,
                    'tid'=>$tid,
                ];
            }
            $result2 = $obj->saveAll($array);
        }
        return $result2;
    }
    
    
}