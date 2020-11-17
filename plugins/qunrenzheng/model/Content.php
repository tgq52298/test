<?php
namespace plugins\qunrenzheng\model;

use app\common\model\C;
use think\Db;

//模型内容处理
class Content extends C
{
	/**
	 * 根据qun_id 查找认证数据
	 * @param number $qun_id
	 * @return bool|array
	 */
	public static function getContentByQunid($qun_id=0){
		if (empty($qun_id)) {
			return false;
		}
		return Db::name('qunrenzheng_content1')->where('qun_id',$qun_id)->find();
	}

	/**
	 * 根据qun_id 查找群数据
	 * @param number $qun_id
	 * @return bool|array
	 */
	public static function getQqunInfoByid($qun_id=0){
		if (empty($qun_id)) {
			return false;
		}
		$qun_contents = DB::name('qun_content')->where('id',$qun_id)->find();
		$qun_table = self::getQunTable($qun_id);
		return Db::name($qun_table)->where('id',$qun_id)->find();
	}
	
	/**
	 * 更新圈子及认证数据
	 * @param number $qun_id
	 * @return bool|array
	 */
	public static function updateQunRz($qun_id=0,$data=[],$data2=[]){
		if (empty($qun_id)) {
			return false;
		}
        $qun_table = self::getQunTable($qun_id);
		$qun_result = Db::name($qun_table)->where('id',$qun_id)->update($data);
		Db::name('qunrenzheng_content1')->where('qun_id',$qun_id)->update($data2);
		return $qun_result;
	}

    /**
     * 根据qun_id 查找群数据表
     * @param number $qun_id
     * @return string
     */
	public static function getQunTable($qun_id=0){
        $qun_contents = DB::name('qun_content')->where('id',$qun_id)->find();
        $qun_table = 'qun_content'.$qun_contents['mid'];
        return $qun_table;
    }

    /**
     * 指定用户所创建的所有圈子
     * @param number $uid
     * @param number $time
     * @return array|array|mixed
     */
    public static function getAllQunByUid($uid=0,$time=3600){
        if (!modules_config('qun')) {
            return [];
        }
        if (empty($uid)) {
            $uid = intval(login_user('uid'));
        }
        static $array = [];
        $listdb = $array[$uid];
        if (empty($listdb)) {
            $array = Db::name('qun_content')->where('uid',$uid)->order('id desc')->column('id,mid');
            $listdb = $info = [];
            foreach($array AS $qid=>$mid){
                $qun_table = 'qun_content'.$mid;
                $info = Db::name($qun_table)->where('id','=',$qid)->find();
                $listdb[$info[id]] = $info['title'];
            }
            $array[$uid] = $listdb;
        }
        return $listdb;
    }

}
