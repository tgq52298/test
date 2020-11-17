<?php
namespace app\yuyue\index\wxapp;

use app\common\controller\IndexBase;
//use app\yuyue\model\Content AS ContentModel;
use app\yuyue\model\Yhlog AS YhlogModel;

class Youhui extends IndexBase
{
    /**
     * 取优惠券的信息并进行权限判断
     * @param number $yid
     * @return string|array|NULL[]|unknown
     */
    private function get_youhui_info($yid=0){
        $info = getArray(YhlogModel::get($yid));
        if(empty($info)){
            return '优惠券不存在';
        }elseif($info['uid']!=$this->user['uid']){
            return '不是你的优惠券';
        }elseif($info['end_time']&&$info['end_time']<time()){
            return '优惠券已失效过期了';
        }
        return $info;
    }
    
    /**
     * 列出所有可用的优惠券
     * @param number $id
     */
    public function list_youhui($id=0){
        $listdb = YhlogModel::list_yh($id,$this->user['uid']);
        if ($listdb) {
            return $this->ok_js($listdb);
        }else{
            return $this->err_js('没有可用的优惠券');
        }
    }
    
    /**
     * 获取某条优惠券的信息
     * @param number $yid
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function get_youhui($yid=0,$id=0){
        $info = $this->get_youhui_info($yid);
        if(is_string($info)){
            return $this->err_js($info);
        }elseif($info['aid']!=$id){
            return $this->err_js('该优惠券不能在当前商品使用！');
        }else{
            $info['end_time'] = $info['end_time']>0 ? date('Y-m-d H:i',$info['end_time']) : '长期有效';
            return $this->ok_js($info);
        }
    }
   

}
