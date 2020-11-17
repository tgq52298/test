<?php
namespace app\bespeak\member;

use app\common\controller\member\Order AS _Order;

class Order extends _Order
{
	/**
	 * 查看我的订单列表
	 * @param unknown $type
	 * @return mixed|string
	 */
	public function index($type=null){
	    $map = [
	            'uid'=>$this->user['uid'],                
	    ];
	    if($type=='ispay'){
	        $map['pay_status'] = 1;
	    }elseif($type=='nopay'){
	        $map[ 'pay_status'] = 0;
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
		if ($info['uid']!=$this->user['uid']) {
			$this->error('你没权限');
		}
		$this->assign('info',$info);
		return $this->fetch();
	}

	/**
	 * 取消预约单
	 * @param unknown $id
	 * @return mixed|string
	 */
	public function cancel($id){
		$info = $this->model->getInfo($id);
		if ($info['uid']!=$this->user['uid']) {
			$this->error('你没权限');
		}
		$map = ['id'=>$info['id']];
		$data = ['pay_status'=>3];
		$result = $this->model->updateOrder($map,$data);
		if($result){
			$contentdb = get_one_contents($info['shopid']); //商家服务信息
			$this_model_config = this_model_config();//当前系统配置
			$hy_userdb = get_user($contentdb['uid']);

			$show_url = get_url(murl('kehu_order/show',['id'=>$id]));
			$msg = '有客户取消了在【'.$contentdb['title']."】提交的预约单,预约号为：{$info['order_sn']}，<a href='{$show_url}'>点击查看</a>";

			//客户预约短信通知商家
			if($this_model_config['cancel_order_sms_hy']){
				$phone = $contentdb['telphone'] ? $contentdb['telphone'] : $hy_userdb['mobphone'];
				if($phone){
					$send_result = send_sms($phone,"有客户取消了在【{$contentdb['title']}】提交的预约单，预约号为：{$info['order_sn']}");
				}
			}
			//客户预约站内信通知商家
			if($this_model_config['cancel_order_msg_hy']){
				$send_result = send_msg($hy_userdb['uid'],'用户取消预约通知',$msg);
			}
			//客户预约微信通知商家
			if($this_model_config['cancel_order_wx_hy']){
				if($hy_userdb['weixin_api']){
					$send_result = send_wx_msg($hy_userdb['weixin_api'],$msg);
				}
			}
			//客户预约邮件通知商家
			if($this_model_config['cancel_order_email_hy']){
				if($hy_userdb['email']){
					$send_result = send_mail($hy_userdb['email'],'用户取消预约通知',$msg);
				}
			}


			$this->success('成功取消预约!');
		}else{
			$this->error('操作失败，可尝试刷新页面后再进行操作！');
		}	    
	}


	/**
	 * 删除预约单
	 * @param unknown $id
	 * @return mixed|string
	 */
	public function del($id){
		$info = $this->model->getInfo($id);
		if ($info['uid']!=$this->user['uid']) {
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