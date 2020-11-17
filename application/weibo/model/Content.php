<?php
namespace app\weibo\model;

use app\common\model\C;

//模型内容处理
class Content extends C
{
    /**
     * 删除 
     * @param number $id
     * @param number $mid
     */
    public static function deleteData($id=0,$mid=0){
        $result = parent::deleteData($id,$mid);
        if($result){
            $map = ['aid'=>$id];
            Member::destroy($map);  // 删除粉丝
            Visit::destroy($map);   //删除访问记录
            //Groups::destroy($map);   //删除用户组
            Feed::destroy(['uid'=>$id]);    //删除动态
        }
        return $result;
    }
    
    /**
     * 创建
     * @param number $mid
     * @param array $data
     * @return unknown
     */
    public static function addData($mid=0,$data=[]){
        $data['id'] = login_user('uid');
        $id = parent::addData($mid,$data);
        if(is_numeric($id)){
            //把创建者添加到用户列表
//             $data = [
//                     'aid'=>$id,
//                     'uid'=>login_user('uid'),
//                     'type'=>3,
//             ];
//             Member::create($data);
        }
        return $id;
    }
}
