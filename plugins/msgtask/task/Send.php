<?php
namespace plugins\msgtask\task;

use plugins\msgtask\model\Log AS LogModel;
use plugins\msgtask\model\Task AS TaskModel;

class Send
{
    /**
     * 定时任务执行入口
     */
    public static function run(){
        $min = 0;
        $rows = 10; //每次取10个用户来发送,太大的话,执行时间太长,避免第二个任务重新读取数据,造成重复发送.        
        $task_array = [];
        do{
            $ck = false;
            $listdb = LogModel::where('ifsend',0)->order('id','asc')->limit($min,$rows)->column('id,touid,touser,tid');
            foreach($listdb AS $rs){
                if (empty($task_array[$rs['tid']])) {
                    $task_array[$rs['tid']] = TaskModel::get($rs['tid']);
                }
                $ck = true;
                $sncode = $task_array[$rs['tid']]['sncode'];
                $result = self::sendmsg($rs,$task_array[$rs['tid']]);
                if ($result==true) {
                    LogModel::update([
                        'id'=>$rs['id'],
                        'ifsend'=>1,
                    ]);
                    if($sncode!=''){
                        TaskModel::update(
                            [
                                'id'=>$rs['tid'],
                                'sncode'=>$task_array[$rs['tid']]['sncode'],
                            ]);
                    }
                    sleep(1);   //暂停1秒,让服务器缓解一下压力
                }                
            }
            $min += $rows;
        }while($ck==true);        
    }
    
    /**
     * 一条一条的发送消息
     * @param array $log
     * @param array $task
     */
    private static function sendmsg($log=[],&$task=[]){
        if ($task['begin_time'] > time() ) {
            return false;   //还没到发送时间
        }
        $sncode = '';
        if($task['sncode']!=''){    //存在序列号或消费码
            $detail = str_array($task['sncode'],"\n");
            $sncode = $detail[0];
            unset($detail[0]);
            $task['sncode'] = implode("\r\n", $detail);
        }
        $content = $task['content'];
        if ($sncode!='') {
            $content .= '，你的消费码是:'.$sncode;
        }
        $detail = explode(',', $task['type']);
        $user = $log['touser'] ? json_decode($log['touser'],true) : [];
        $user || $user = get_user($log['touid']);
        foreach($detail AS $type)
        {
            if ($type==0)
            {
                send_msg($log['touid'],$task['title'],$content,$task['uid']);
            }
            elseif($type==1)
            {
                $user['weixin_api'] && send_wx_msg($user['weixin_api'], $content);
            }
            elseif($type==2)
            {
                $user['mobphone'] && send_sms($user['mobphone'],$content);
            }
            elseif($type==3)
            {
                $user['email'] && send_mail($user['email'],$task['title'],$content);
            }
        }
        return true;        
    }
}