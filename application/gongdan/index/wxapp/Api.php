<?php
namespace app\gongdan\index\wxapp;

use app\common\controller\index\wxapp\Api AS _Api;
use app\gongdan\model\Order AS OrderModel;
use app\gongdan\model\Content AS ContentModel;
use app\qun\model\Member AS MemberModel;

//常用接口
class Api extends _Api
{
    /**
     * 设置工单状态
     * @param number $id 工单ID
     * @param number $type 状态ID
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function status($id=0,$type=0){
        $order_info = OrderModel::where('id',$id)->find();
        if ($order_info['status']==$type) {
            return $this->err_js('请不要重复设置!');
        }
        if (!$order_info) {
            return $this->err_js('ID有误,工单信息不存在');
        }
        $info = ContentModel::getInfoByid($order_info['shopid']);
        if (!$info) {
            return $this->err_js('工单模板不存在');
        }
        $array = status_power($info,$this->user);
        if (!$array[$type]) {
            return $this->err_js('你没权限!');
        }
        $result = OrderModel::where('id',$id)->update([
            'status'=>$type,
        ]);
        if ($result) {
            $notice_group = status_notice($info,$type);
            if ($notice_group) {
                $qun_id = $info['ext_id'];
                if (!$qun_id) {
                    $qun_id = end(fun('qun@getByuid',$info['uid']))['id']; //圈子ID
                }
                $title = "工单被".$array[$type]."了";
                $content = '<a href="'.get_url(murl('kehu_order/show',['id'=>$id])).'" target="_blank">'.$info['title']." 被 ".$this->user['username'].' 《'.$array[$type]."》 了，点击查看详情</a>";
                $listdb = MemberModel::where('aid',$qun_id)->where('type','IN',$notice_group)->column(true);
                foreach($listdb AS $rs){
                    send_msg($rs['uid'],$title,$content);
                    send_wx_msg($rs['uid'], $content);
                }
            }
            $content = '你提交的工单:<a href="'.get_url(murl('order/show',['id'=>$id])).'" target="_blank">'.$info['title']." 被 ".$this->user['username'].' 《'.$array[$type]."》 了，点击查看详情</a>";
            send_msg($order_info['uid'],$title,$content);
            send_wx_msg($order_info['uid'], $content);
            return $this->ok_js(['name'=>$array[$type]]);
        }else{
            return $this->err_js('数据库执行失败!');
        }
    }
}













