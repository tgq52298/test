<?php
namespace app\vote\model;

use app\common\model\C;
use think\Db;

//模型内容处理
class Content extends C
{

    /**
     * 根据MID 设置条件查找计算某列数据总数
     * @param number $mid
     * @param array $map
     * @return number|number|string
     */
    public static function getColumnByMid($mid=0,$map=[],$cname='view'){
        self::InitKey();
        if (empty($mid)) {
            return 0;
        }
        return Db::name(self::getTableByMid($mid))->where($map)->sum($cname);
    }


    /**
     * 查询累计投票，及访问量
     * @param number $mid
     * @param array $map
     * @return number|number|string
     */
    public static function getVoteList($mid=0,$map=[],$cname='view'){
        self::InitKey();
        if (empty($mid)) {
            return 0;
        }
        return Db::name(self::getTableByMid($mid))->where($map)->sum($cname);
    }

    /**
     * 通过mid获取模型里的某个分类内容数据
     * @param number $mid 模型ID
     * @return void|array|\think\db\false|PDOStatement|string|\think\Model
     */
    public static function getInfoBymid($mid=1,$format=FALSE){
        empty(self::$model_key) && self::InitKey();
        if (empty($mid)) {
            return ;
        }
         $info = Db::name(self::getTableBy('sort'))->where('mid',$mid)->find();
        if($info){
            return $format ? self::format_data($info) : $info;
        }
    }


    /**
     * 通过ID获取某条内容数据
     * @param number $id 内容ID
     * @return void|array|\think\db\false|PDOStatement|string|\think\Model
     */
    public static function getInfoByid($id=0,$format=FALSE){
        empty(self::$model_key) && self::InitKey();
        $mid = self::getMidById($id);
        if (empty($mid)) {
            return ;
        }
         $info = Db::name(self::getTableByMid($mid))->where('id',$id)->find();

        if($info){
            return $format ? self::format_data($info) : $info;
        }
    }

    /**
     * 通过MID、UID获取某条内容数据
     * @param number $uid 内容ID
     * @return void|array|\think\db\false|PDOStatement|string|\think\Model
     */
    public static function getInfoByuid($mid=1,$format=FALSE){
        empty(self::$model_key) && self::InitKey();
        // $mid = self::getMidById($id);
        if (empty($mid)) {
            return ;
        }
        $uid=login_user()['uid'];
         $info = Db::name(self::getTableByMid($mid))->where('uid',$uid)->find();

        if($info){
            return $format ? self::format_data($info) : $info;
        }
    }


    /**
     * 投票
     * @param number $id 投票选项ID
     * @param array $data 需记录的相关信息
     * @param string $ips 投票的IP字符串
     * @return boolean
     */
    public static function addVote($id=0,$data,$ips){
        empty(self::$model_key) && self::InitKey();
        $mid = self::getMidById($id);
        if (empty($mid)) {
            return false;
        }
        $add_result = Db::name(self::getTableByMid($mid))->where('id',$id)->setInc('agree',1);//增加投票数
         Db::name(self::getTableBy('sort'))->where('id',$data['fid'])->update(['ips'=>$ips]); //更新投票IP
         Db::name(self::getTableBy('member'))->insert($data); //记录用户投票信息
         return $add_result;
    }






}
