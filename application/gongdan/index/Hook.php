<?php
namespace app\gongdan\index;

use app\gongdan\model\Order AS OrderModel;
use app\gongdan\model\Content AS ContentModel;

class Hook
{
    public function CommentAddEnd($data=[]){
        if(modules_config($data['sysid'])['keywords']!=basename(dirname(__DIR__))){
            return ;
        }
        define('HOOK_SEND_MSG', true); //避免重复发消息
        $id = $data['aid'];
        $oinfo = OrderModel::where('id',$id)->find();
        $login_uid = login_user('uid');
        $shop = ContentModel::getInfoByid($oinfo['shopid']);
        $title = '你有工单回复消息';
        if ($login_uid!=$oinfo['uid']) {            
            $content = '你提交的工单:'.$shop['title'].'，'.login_user('username').'给你回复消息了，<a href="'.get_url(murl('gongdan/order/show',['id'=>$id])).'" target="_blank">点击查看详情</a>';
            send_msg($oinfo['uid'],$title,$content);
            send_wx_msg($oinfo['uid'], $content);
        }else{
            $content = '你'.($oinfo['robuid']?'承接':'发布').'的工单:'.$shop['title'].'，客户:'.login_user('username').'给你回复消息了，<a href="'.get_url(murl('gongdan/kehu_order/show',['id'=>$id])).'" target="_blank">点击查看详情</a>';
            send_msg($oinfo['robuid']?:$oinfo['shop_uid'],$title,$content);
            send_wx_msg($oinfo['robuid']?:$oinfo['shop_uid'], $content);
        }
	}
}
