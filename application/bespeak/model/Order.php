<?php
namespace app\bespeak\model;

use app\common\model\Order AS _Order;


class Order extends _Order
{

	//预约列表,带分页
	public  function getList($map=[],$rows=20){
	    $data_list = self::where($map)->order('id','desc')->paginate($rows);
	    $data_list->each(function($rs,$key){
	        $rs['fuwu_db'] = [];
	        $rs['fuwu_db'] = self::$content_model->getInfoByid($rs[shopid],true);
	        $rs['fuwu_name'] = $rs['fuwu_db']['title'];
	        return $rs;
	    });
	    return $data_list;
	}


	/**
	 * 只获取一条预约信息,一般用在查看详情使用
	 * @param unknown $id
	 * @return void[]|array[]|\think\db\false[]|\app\common\model\PDOStatement[]|string[]|\think\Model[]
	 */
	public function getInfo($id){
	    $info = getArray( $this->find($id) );
	    if ($info){
	        $info['fuwu_db'] = self::$content_model->getInfoByid($info[shopid],true);
	        return $info;
	    }
	}

	//预约表的更新
	public  function updateOrder($map=[],$data=[]){
		$result = self::where($map)->update($data);
		return $result;
	}

	//预约表的更新
	public  function deleteOrder($map=[]){
		$result = self::where($map)->delete();
		return $result;
	}


}