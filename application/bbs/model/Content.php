<?php
namespace app\bbs\model;

use app\common\model\C;
use think\Db;

//模型内容处理
class Content extends C
{
    protected static $content_array = [];
    /**
     * 重写标签调用数据 ,为了添加内容数据
     * @param array $tag_array
     * @param number $page
     */
    public static function labelGetList($tag_array=[] , $page=0){
        $array = parent::labelGetList($tag_array,$page);
        $id_array = [];
        foreach($array['data'] AS $key=>$rs){
            $id_array[] = $rs['id'];
        }
        $cfg = unserialize($tag_array['cfg']);
        $ar = Db::name(self::getContentsTable())->where('id','in',$id_array)->column('content','id');
        
        foreach($array['data'] AS $key=>$rs){
            if ($ar[$rs['id']]) {
                self::$model_key=='bbs' && \app\common\fun\Bbs::content_cache($rs['id'],$ar[$rs['id']]);   //为旧模板设置缓存,提高效率
                $rs['full_content'] = $ar[$rs['id']];
                $rs['content'] = del_html($rs['full_content']);
                $cfg['cleng'] && $rs['content'] = get_word($rs['content'], $cfg['cleng']);
            }
            $array['data'][$key] = $rs;
        }
        return $array;
    }
    
    /**
     * 重写父方法,为了添加内容数据
     * @param number $mid
     * @param array $map
     * @param string $order
     * @param number $rows
     * @param array $pages
     * @param string $format
     */
    public static function getListByMid($mid=0,$map=[],$order='',$rows=0,$pages=[],$format=true)
    {
        $data_list = parent::getListByMid($mid,$map,$order,$rows,$pages,$format);
        $_ar = getArray($data_list);
        $id_array = [];
        foreach($_ar['data'] AS $key=>$rs){
            $id_array[] = $rs['id'];
        }
        static::$content_array = [
            'data' => Db::name(self::getContentsTable())->where('id','in',$id_array)->column('content','id'),
            'format' => $format,
        ];
        $data_list->each(function($rs,$key){
            $array = static::$content_array;
            $content = $array['data'][$rs['id']];
            self::$model_key=='bbs' && \app\common\fun\Bbs::content_cache($rs['id'],$content);   //为旧模板设置缓存,提高效率
            if ($array['format']) {
                $rs['full_content'] = $content;
                $rs['content'] = del_html($content);
            }else{
                $rs['content'] = $content;
            }
            return $rs;
        });
        return $data_list;
    }
    
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
            $_result = Db::name(self::getContentsTable())->where('id',$data['id'])->update($data);
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
        
        if($result===true){ //必须绝对等于,因为1的时候是软删除
            //删除评论
            Db::name(self::getReplyTable())->where('aid',$id)->delete();
            
            //删除内容表
            Db::name(self::getContentsTable())->where('id',$id)->delete();
        }
        
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
        $info = Db::name(self::getTableByMid($mid))->alias('A')->join(self::getContentsTable().' B','A.id=B.id','LEFT')->where(static::map([],'A.'))->where('A.id','=',$id)->find();
        if($info){
            return $format ? self::format_data($info) : $info;
        }
    }
    
    public static function get_reply_label($tag_array=[]){
        //empty(self::$model_key) && self::InitKey();
        static::check_model();
        $cfg = unserialize($tag_array['cfg']);
        $map = [];        
        $uid = $cfg['uid'];
        $map['uid'] = $uid;
        $rows = $cfg['rows']?:10;
        if($cfg['where']){  //用户自定义的查询语句
            $_array = fun('label@where',$cfg['where'],$cfg);
            if($_array){
                $map = array_merge($map,$_array);
            }
        }
        $data_list = Db::name(self::$model_key.'_reply')->where($map)->group('aid')->order('id','desc')->paginate($rows);
        $data_list->each(function(&$rs,$key){
            $rs = self::getInfoByid($rs['aid'],true);
            return $rs;
        });
            return $data_list;
    }
}
