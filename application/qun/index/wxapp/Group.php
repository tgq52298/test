<?php
namespace app\qun\index\wxapp;

use app\common\controller\IndexBase;
use app\qun\model\Content AS ContentModel;

class Group extends IndexBase
{
    /**
     * 获取某个圈子的用户组列表
     * @param number $id
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function index($id=0){
        if (!$this->user) {
            return $this->err_js('你还没登录!');
        }
        if ($id) {
            $info = ContentModel::getInfoByid($id);
            if (empty($info)) {
                return $this->err_js('ID有误');
            }
        }else{
            $array = fun('qun@getByuid',$this->user['uid']);
            if (empty($array)) {
                return $this->err_js('你还没创建'.QUN);
            }
            $info = end($array);
        }
        $data = fun('qun@get_group',null,$info);
        return $this->ok_js(array_values($data));
    }
}













