<?php
namespace app\gongdan\member\wxapp;

use app\common\controller\member\wxapp\Order AS _Order;
use app\gongdan\model\Content AS ContentModel;

class Order extends _Order
{
    /**
     * 满意度评分
     * @param number $id
     * @param number $num
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function pingfen($id=0,$num=0){
        $info = $this->model->where('id',$id)->find();
        if (!$info) {
            return $this->err_js('工单不存在!');
        }elseif($info['uid']!=$this->user['uid']){
            return $this->err_js('不是你的工单!');
        }elseif($info['pingfen']){
            return $this->err_js('请不要重复评分!');
        }elseif($num<1){
            return $this->err_js('请至少选择一颗星!');
        }elseif($num>5){
            return $this->err_js('不能大于5颗星!');
        }
        $result = $this->model->where('id',$id)->update(['pingfen'=>$num]);
        if ($result) {
            $title = '客户给你打分了';
            $shop = ContentModel::getInfoByid($info['shopid']);
            $content = "客户:".$this->user['username'].' 给你承接的工单: '.$shop['title'].'，评价了 '.$num.' 颗星,<a href="'.get_url(urls('kehu_order/show',['id'=>$id])).'" target="_blank">点击查看详情</a>';
            send_msg($info['robuid']?:$info['shop_uid'],$title,$content);
            send_wx_msg($info['robuid']?:$info['shop_uid'], $content);
            return $this->ok_js();
        }else{
            return $this->err_js('数据库执行失败');
        }
    }
}