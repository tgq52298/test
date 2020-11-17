<?php
namespace app\bespeak\index;

use app\common\controller\index\Order AS _Order;


//下单
class Order extends _Order
{
	public function add(){
		if(!$this->user){
			$this->error('登陆后才可进行预约');
		}		
		if($this -> request -> isPost()){
			$data = $this -> request -> post();

			$result = $this->check_post_filed($data);
			if ($result!==true) {
				$this->error($result);
			}
			
			$data = \app\common\field\Post::format_all_field($data,-1); //对一些特殊的自定义字段进行处理,比如多选项,以数组的形式提交的

			$contentdb = get_one_contents($data['fuwu_id']); //商家服务信息

			if(!$contentdb){
				$this->error('查询不到该服务商家信息，无法进行预约操作，可返回页面刷新后再尝试操作！');
			}
			if($contentdb['status']<1){
				$this->error('该服务商家信息还没通过审核，无法进行预约操作！');
			}

			if($data['order_bespeak_time']<=time()){
				$this->error('预约时间不能晚于当前时间！');
			}
			
			//如设置了每天预约人数限制
			if($contentdb['limit_persons']>0){
				//查询预约当天已报名人数
				$order_bespeak_time = format_time($data['order_bespeak_time'],'Y-m-d');//预约时间
				$start_time = strtotime($order_bespeak_time);
				$limit_time = $start_time+24*60*60;
				$limit_personsdb = $this->order_model->where('shopid',$contentdb['id'])->whereTime('order_bespeak_time', 'between', [$start_time,$limit_time])->count();
				if($limit_personsdb>=$contentdb['limit_persons']){
					$this->error('预约时间当天预约人数已满，请选择其它时间预约！');
				}
			}
			

			
			
			$data['shopid'] = $data['fuwu_id']; //商家信息服务ID
			$data['order_sn'] = 'FW'.time();    //订单号
			$data['uid'] = $this->user ? $this->user['uid'] : 0;    //预约用户
			$data['shop_uid'] =$contentdb['uid']; //发布商家信息的UID

			$result = $this->order_model->create($data); //预约单入库
			$order_id = $result->id;
			// $this->end_add($order_id,$car_ids);     //扩展使用
		            
			if (!empty($order_id)) {

				$this_model_config = this_model_config();//当前系统配置
				$hy_userdb = get_user($contentdb['uid']);

				//$show_url = murl('kehu_order/show',['id'=>$order_id]);
				$show_url = get_url(murl('kehu_order/show',['id'=>$order_id]));
				$msg = '有客户在【'.$contentdb['title']."】提交预约单了,预约号为：{$data['order_sn']}，<a href='{$show_url}'>点击查看</a>";

				//客户预约短信通知商家
				if($this_model_config['post_order_sms_hy']){
					$phone = $contentdb['telphone'] ? $contentdb['telphone'] : $hy_userdb['mobphone'];
					if($phone){
						$send_result = send_sms($phone,"有客户在【{$contentdb['title']}】提交了预约单，预约号为：{$data['order_sn']}");
					}
				}
				//客户预约站内信通知商家
				if($this_model_config['post_order_msg_hy']){
					$send_result = send_msg($hy_userdb['uid'],'用户预约通知',$msg);
				}
				//客户预约微信通知商家
				if($this_model_config['post_order_wx_hy']){
					if($hy_userdb['weixin_api']){
						$send_result = send_wx_msg($hy_userdb['weixin_api'],$msg);
					}
				}
				//客户预约邮件通知商家
				if($this_model_config['post_order_email_hy']){
					if($hy_userdb['email']){
						$send_result = send_mail($hy_userdb['email'],'用户预约通知',$msg);
					}
				}
				$url = $this->user ? murl('order/index') : urls('content/show',['id'=>$data['fuwu_id']]);
				$this -> success('预约单提交成功', $url);
			} else {
				$this -> error('预约单提交失败');
			}
		}
		return $this ->fetch();
	}


	// public function send_ordertip($order_id=0){

	// }

}

