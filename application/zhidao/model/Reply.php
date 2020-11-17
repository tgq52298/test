<?php
namespace app\zhidao\model;

use app\common\model\Reply AS _Reply;


//内容回复
class Reply extends _Reply
{
    public static function add($data=[],$id=0,$pid=0){
        $result = parent::add($data,$id,$pid);
        if($result){
            Infomsg::updata_info(false,$data);
        }
        return $result;
    }
    
    public static function get_label($config){
        $cfg = unserialize($config['cfg']);
        $rows = intval($cfg['rows']) ?: 5;
        $uid = intval($cfg['uid']);
        $map = [];
        $uid && $map['uid'] = $uid;
        $data_list = self::where($map)->order('id desc')->paginate($rows);
        $data_list->each(function($rs,$key){
            $rs['username'] = get_user_name($rs['uid']);
            $rs['icon'] = get_user_icon($rs['uid']);
            return $rs;
        });
        return $data_list;
    }
}