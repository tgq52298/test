<?php
namespace app\qun\model;

use app\common\model\C;

//模型内容处理
class Content extends C
{
    /**
     * 获取用户创建的圈子
     * @param number $mid 模型ID,也可以是模型关键字
     * @return \think\Paginator[]
     */
    public static function get_user_qun($mid=1){
        $uid = login_user('uid');
        if ($mid && !is_numeric($mid)) {
            $mid = fun('qun@getid_bykey',$mid);
        }
        $listdb = self::getListByMid($mid?:1,['uid'=>$uid],'list',100,[],false);
        $data = [];
        foreach($listdb AS $rs){
            $data[$rs['id']] = $rs['title'];
        }
        return $data;
    }
    
    /**
     * 删除圈子
     * @param number $id
     * @param number $mid
     */
    public static function deleteData($id=0,$mid=0){
        $result = parent::deleteData($id,$mid);
        if($result === true){ //必须绝对等于,因为1的时候是软删除
            $map = ['aid'=>$id];
            Member::where($map)->delete();  // 删除成员
            Visit::where($map)->delete();  //删除访问记录
            Groups::where($map)->delete();   //删除用户组
            Claim::where($map)->delete();   //删除认领资料
            Adset::where($map)->delete();  // 删除广告位
            Aduser::where($map)->delete();  // 删除广告购买记录
            Style::where('pageid',$id)->delete();   //删除购买过的风格日志
            Topic::where($map)->delete();  //删除专题
        }
        return $result;
    }
    
    /**
     * 创建圈子
     * @param number $mid
     * @param array $data
     * @return unknown
     */
    public static function addData($mid=0,$data=[]){
        $id = parent::addData($mid,$data);
        if(is_numeric($id)){
            //把创建者添加到用户列表
            $data = [
                    'aid'=>$id,
                    'uid'=>login_user('uid'),
                    'type'=>3,
            ];
            Member::create($data);
        }
        return $id;
    }
    
    public static function editData($mid=0,$data=[]){
        cache('qunById'.$data['id'],null);
        return parent::editData($mid,$data);
    }
    
    public static function updates($id=0,$data=[]){
        cache('qunById'.$id,null);
        return parent::updates($id,$data);
    }
}









