<?php
namespace app\bespeak\member;

use app\common\controller\member\KehuOrder AS _Order;


class KehuOrder extends _Order
{
	/**
	* 查看我的客户订单列表
	* @param unknown $type
	* @return mixed|string
	*/
	public function index($type=null){
		$map = [
		        'shop_uid'=>$this->user['uid'],                
		];

		if($type=='ispay'){
		    $map['pay_status'] = 1;
		}elseif($type=='nopay'){
		    $map['pay_status'] = 0;
		}
		$list_data = $this->model->getList($map,10);
		$this->assign('listdb',getArray($list_data)['data']);
		$this->assign('pages',$list_data->render());
		$this->assign('type',$type);
		return $this->fetch();
	}


	/**
	 * 预约单详情
	 * @param unknown $id
	 * @return mixed|string
	 */
	public function show($id){
		$info = $this->model->getInfo($id);
		if ($info['shop_uid']!=$this->user['uid']) {
			$this->error('你没权限');
		}
		$this->assign('info',$info);
		return $this->fetch();
	}


	/**
	 * 修改预约单信息
	 * @param number $id 预约单ID
	 * @param string $act 预约单操作类型,affirm通过审核,cancel取消审核
	 */
	public function edit($id,$act='affirm'){
	    $info = $this->model->getInfo($id);
	    if ($info['shop_uid']!=$this->user['uid']) {
	        $this->error('你没权限');
	    }
	    $map = ['id'=>$id,'shop_uid'=>$this->user['uid']];
	    if($act=='affirm'){
	    	$array = ['pay_status'=>1,'pay_time'=>time()];
	    	$tip = '该预约已通过审核';
	    }else if($act=='cancel'){
	    	$array = ['pay_status'=>2,'pay_time'=>time()];
	    	$tip = '已取消审核该预约！';
	    }
	    $result = $this->model->where($map)->update($array);

	    if($result){

		$contentdb = get_one_contents($info['shopid']); //商家服务信息
		$this_model_config = this_model_config();//当前系统配置
		$order_userdb = $info['uid'] ? get_user($info['uid']) : ''; //下单预约用户资料，游客则不存在账号资料
		$show_url = get_url(murl('order/show',['id'=>$id]));

		if($act=='affirm'){ //预约成功通知用户
			$msg = '你在【'.$contentdb['title']."】提交的预约单已通过审核预约成功,预约号为：{$info['order_sn']}，<a href='{$show_url}'>点击查看</a>";

			//通过审核预约成功短信通知用户
			if($this_model_config['cancel_order_sms_hy']){
				$phone = $info['order_telphone'] ? $info['order_telphone'] : $order_userdb['mobphone'];
				if($phone){
					$send_result = send_sms($phone,"你在【{$contentdb['title']}】提交的预约单已通过审核预约成功，预约号为：{$info['order_sn']}");
				}
			}
			//通过审核预约成功站内信通知用户
			if($this_model_config['cancel_order_msg_hy']){
				$order_userdb['uid'] && $send_result = send_msg($order_userdb['uid'],'预约成功通知',$msg);
			}
			//通过审核预约成功微信通知用户
			if($this_model_config['cancel_order_wx_hy']){
				if($order_userdb['weixin_api']){
					$send_result = send_wx_msg($order_userdb['weixin_api'],$msg);
				}
			}
			//通过审核预约成功邮件通知用户
			if($this_model_config['cancel_order_email_hy']){
				if($order_userdb['email']){
					$send_result = send_mail($order_userdb['email'],'预约成功通知',$msg);
				}
			}
		}else if($act=='cancel'){ //预约失败通知用户
			$msg = '你在【'.$contentdb['title']."】提交的预约单没通过审核预约失败,预约号为：{$info['order_sn']}，<a href='{$show_url}'>点击查看</a>";

			//通过审核预约成功短信通知用户
			if($this_model_config['cancel_order_sms_hy']){
				$phone = $info['order_telphone'] ? $info['order_telphone'] : $order_userdb['mobphone'];
				if($phone){
					$send_result = send_sms($phone,"你在【{$contentdb['title']}】提交的预约单没通过审核预约失败，预约号为：{$info['order_sn']}");
				}
			}
			//通过审核预约成功站内信通知用户
			if($this_model_config['cancel_order_msg_hy']){
				$order_userdb['uid'] && $send_result = send_msg($order_userdb['uid'],'预约失败通知',$msg);
			}
			//通过审核预约成功微信通知用户
			if($this_model_config['cancel_order_wx_hy']){
				if($order_userdb['weixin_api']){
					$send_result = send_wx_msg($order_userdb['weixin_api'],$msg);
				}
			}
			//通过审核预约成功邮件通知用户
			if($this_model_config['cancel_order_email_hy']){
				if($order_userdb['email']){
					$send_result = send_mail($order_userdb['email'],'预约失败通知',$msg);
				}
			}
		}

	    	$this->success($tip);
	    }else{
	    	$this->error($tip);
	    }
	}






	/**
	 * 删除预约单
	 * @param unknown $id
	 * @return mixed|string
	 */
	public function del($id){
		$info = $this->model->getInfo($id);
		if ($info['shop_uid']!=$this->user['uid']) {
			$this->error('你没权限');
		}
		if($info['pay_status']<2){
			$this->error('已取消预约或预约失败的预约单才可以进行删除操作！');
		}
		$map = ['id'=>$info['id']];
		$result = $this->model->deleteOrder($map);
		if($result){
			$this->success('已删除!');
		}else{
			$this->error('操作失败，可尝试刷新页面后再进行操作！');
		}	    
	}






}