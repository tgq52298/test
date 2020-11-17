<?php
namespace app\zhidao\model;

use app\common\model\C;
use think\Db;

//模型内容处理
class Content extends C
{
    /**
     * 内容格式化,对父方法的增强
     * @param array $rs
     * @param array $cfg
     * @param string $_dirname
     * @param array $_sort_array
     * @return \app\common\model\unknown
     */
    protected static function format_data($rs=[] , $cfg=[] , $_dirname='' , $_sort_array=[]) {
        $rs = parent::format_data($rs , $cfg , $_dirname , $_sort_array);
//         $rs['username'] = get_user_name($rs['uid']);
//         $rs['user_icon'] = get_user_icon($rs['uid']);
//         $rs['user_url'] = get_url('user',$rs['uid']);
        return $rs;
    }
    
    /**
     * 获取主题内容表
     * @return string
     */
    public static function getContentsTable(){
        empty(self::$model_key) && self::InitKey();
        return self::$base_table.'s';
    }
    
    /**
     * 获取回复表
     * @return string
     */
    public static function getReplyTable(){
        empty(self::$model_key) && self::InitKey();
        return self::$model_key.'_reply';
    }
    
    /**
     * 点赞
     * @param number $id
     * @return boolean
     */
    public static function addAgree($id=0){
//         empty(self::$model_key) && self::InitKey();
//         $table = self::getTableById($id);
//         if($table){
//             if( Db::name($table)->where('id','=',$id)->setInc('agree',1) ){
//                 return true;
//             }
//         }
        return parent::addAgree($id);
    }
/*更新排序
@param number $rid
@param array $data
@return boolean|unknown
*/
    public function updateReplyList($rid,$data=[]){
         // Db::name(self::getReplyTable())->where('id',$rid)->update($data);   
        try {
            $_result = Db::name(self::getReplyTable())->update($data);
            return $_result;
        } catch(\Exception $e) {
            return false;
        }

    }
    /**
     * 发布内容
     * @param number $mid
     * @param array $data
     * @return boolean|unknown
     */
    public static function addData($mid=0,$data=[]){
        $id = parent::addData($mid,$data);        
        if(is_numeric($id)){
            Infomsg::updata_info(true,$data);
            Db::name(self::getContentsTable())->insert($data);            
        }
		return $id;
    }
    
    /**
     * 更新单条内容信息
     * @param number $mid 模型ID可以为空
     * @param array $data 要更新的数据,id是必须的
     * @return boolean
     */
    public static function editData($mid=0,$data=[]){
        $result = parent::editData($mid,$data);
        try {
            $_result = Db::name(self::getContentsTable())->update($data);
        } catch(\Exception $e) {
            return false;
        }
        return ( $result || $_result );
    }
    
    /**
     * 删除单条内容
     * @param number $id 内容ID
     * @param number $mid 模型ID,可为空
     * @return boolean
     */
    public static function deleteData($id=0,$mid=0){
        $result = parent::deleteData($id,$mid);
        
        //删除评论
        $result = Db::name(self::getReplyTable())->where('aid',$id)->delete();
        
        //删除内容表
        $result = Db::name(self::getContentsTable())->where('id',$id)->delete();
        
        return $result;
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
        $info = Db::name(self::getTableByMid($mid))->alias('A')->join(self::getContentsTable().' B','A.id=B.id','LEFT')->where('A.id','=',$id)->find();
        //最佳答复
        if($info[best_rid]>0){
            $best_reply= Db::name(self::getReplyTable())->where('id',$info[best_rid])->find();
            $info['best_content']=$best_reply['content'];
            $info['best_create_time']=$best_reply['create_time'];
        }
        if($info){
            return $format ? self::format_data($info) : $info;
        }
    }
}
