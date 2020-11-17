<?php
namespace app\hr\model;

use app\common\model\C;
use think\Db;

//模型内容处理
class Content extends C
{

    /**
     * 通过mid获取登陆用户简历数据
     * @param number $mid 简历模型ID
     * @return void|array|\think\db\false|PDOStatement|string|\think\Model
     */
    public static function getVitaInfo($mid=2,$format=FALSE){
        empty(self::$model_key) && self::InitKey();
        // $mid = self::getMidById($id);
        // if (empty($mid)) {
        //     return ;
        // }
        $info = Db::name(self::getTableByMid($mid))->where('mid','=',$mid)->where('uid','=',login_user()['uid'])->find();
        if($info){
            return $format ? self::format_data($info) : $info;
        }
    }
    /**
     * 通过ID获取申请记录信息
     * @return void|array|\think\db\false|PDOStatement|string|\think\Model
     */
    public static function getOneApply($id,$format=FALSE){
        empty(self::$model_key) && self::InitKey();
        $info = Db::name(self::getTableBy('apply'))->where('id','=',$id)->find();
        if($info){
            return $format ? self::format_data($info) : $info;
        }
    }


    /**
     * 通过职位ID获取当前用户该职位的申请数据
     * @param number $aid 职位ID
     * @return void|array|\think\db\false|PDOStatement|string|\think\Model
     */
    public static function getApplyInfo($aid=0,$format=FALSE){
        empty(self::$model_key) && self::InitKey();

        $info = Db::name(self::getTableBy('apply'))->where('aid','=',$aid)->where('uid','=',login_user()['uid'])->find();
        if($info){
            return $format ? self::format_data($info) : $info;
        }
    }

    /**
     * 增加申请职位数据
     * @param number $aid 职位ID
     * @return void|array|\think\db\false|PDOStatement|string|\think\Model
     */
    public function addApply($data=[]){
        empty(self::$model_key) && self::InitKey();
        $insertid = Db::name(self::getTableBy('apply'))->insertGetId($data);
        return $insertid;
    }

    /**
     * 根据职位ID获取该职位的应聘人数
     * @param number $aid 职位ID
     * @return void|array|\think\db\false|PDOStatement|string|\think\Model
     */
    public function delApplyJob($id){
        empty(self::$model_key) && self::InitKey();
        // $applynum = Db::name(self::getTableBy('apply'))->where('aid','=',$id)->count();
        // return $applynum;
        //删除应聘申请
        try {
            $result = Db::name(self::getTableBy('apply'))->where('id',$id)->delete();
        } catch(\Exception $e) {
            return false;
        }
        if($result){
        	return true;
        }

    }

    /**
     * 按职位ID或登录用户获取应聘职位或求职简历
     * @param number $mid 模型ID 1职位模型，2简历模型
     * @param array $map 查询条件,数组
     * @param string $order 排序方式
     * @param number $rows 每页取几条值
     * @param array $pages 
     * @return \think\Paginator
     */    
    public static function getJobVita($mid=0,$map=[],$order='',$rows=0,$pages=[],$format=true)
    {
        self::InitKey();
        $order  = trim($order);
        if(empty($order)){
            $order = 'A.id desc';
        }

        if($mid==2){
	        $data_list = Db::name(self::getTableBy('apply'))->alias('A')->join(self::getTableByMid($mid).' B','A.jid=B.id','LEFT')->where($map)->field("A.id AS cid,A.aid,A.create_time AS apply_time,A.jid,B.*")->order($order)->paginate(
	                empty($rows)?null:$rows,    //每页显示几条记录
	                empty($pages[0])?false:$pages[0],
	                empty($pages[1])?[]:$pages[1]
	                );        	
        }else{
	        $data_list = Db::name(self::getTableBy('apply'))->alias('A')->join(self::getTableByMid($mid).' B','A.aid=B.id','LEFT')->where($map)->field("A.id AS cid,A.create_time AS apply_time,A.jid,B.*")->order($order)->paginate(
	                empty($rows)?null:$rows,    //每页显示几条记录
	                empty($pages[0])?false:$pages[0],
	                empty($pages[1])?[]:$pages[1]
	                );    
        }


        
        if($format){
            $data_list->each(function($rs,$key){
                return static::format_data($rs);
            });
        }
        return $data_list;
    }

    /**
     * 取出的数据进行转义处理
     * @param array $rs 数据库取出的数据
     * @param array $cfg 定义标题长度或内容长度
     * @param string $_dirname 频道所在目录
     * @param array $_sort_array 栏目数据
     * @return unknown
     */
    protected static function format_data($info=[] , $cfg=[] , $_dirname='' , $_sort_array=[]) {
    	 $info = parent::format_data($info , $cfg , $_dirname , $_sort_array);

        if($_dirname){
            $dirname = $_dirname;
        }else{
            $dirname = self::$model_key;
        }
        static $m_or_p = [];
        if( empty($m_or_p[$dirname]) ){
            $m_or_p[$dirname] = modules_config($dirname) ? 'module' : 'plugin';
        }
        if($info['mid']==2){
        	$jobdb = self::getInfoByid($info['aid']);
        	// $job_mid = 1;
        	// $jobdb =  Db::name(self::getTableByMid($job_mid))->where('id','=',$info['aid'])->find(); //获取职位内容
        	$info['app_title'] = $jobdb['title'];
        }
        $info['app_url'] = iurl($dirname.'/content/show',['id'=>$info['aid']],true,false,$m_or_p[$dirname]);
    	return $info;
    }









}
