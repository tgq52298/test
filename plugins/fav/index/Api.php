<?php
namespace plugins\fav\index;

use app\common\controller\IndexBase;
use plugins\fav\model\Fav as FavModel;

class Api extends IndexBase
{
    /**
     * 收藏夹收录接口
     * @param number $id 信息ID
     * @param string $type 频道ID或目录名
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function add($id=0,$type=''){
        $result = $this->check_is_fav($id,$type);
        if ($result!==true) {
            return $this->err_js($result);
        }
        $array = modules_config($type);
        $data = [
                'uid'=>$this->user['uid'],
                'aid'=>$id,
                'sysid'=>$array['id'],
        ];
        $result = FavModel::get($data);
        if ($result) {
            return $this->err_js('请不要重复收藏');
        }
        if(FavModel::create($data)){
            return $this->ok_js('收藏成功');
        }else{
            return $this->err_js('数据库插入失败');
        }
    }
    
    /**
     * 收藏夹检查收录与否
     * @param number $id 信息ID
     * @param string $type 频道ID或目录名
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function check($id=0,$type=''){
        $result = $this->check_is_fav($id,$type);
        if ($result!==true) {
            return $this->err_js($result);
        }
        $array = modules_config($type);
        $data = [
                'uid'=>$this->user['uid'],
                'aid'=>$id,
                'sysid'=>$array['id'],
        ];
        $result = FavModel::get($data);
        if ($result) {
            return $this->ok_js('已收藏');
        }else{
            return $this->err_js('还没收藏');
        }
    }
    
    
    protected function check_is_fav($id=0,$type=''){
        if (empty($this->user)) {
            return '你还没登录';
        }elseif (empty($type)) {
            return '频道类型不存在';
        }elseif (empty($id)) {
            return 'id不存在';
        }
        $array = modules_config($type);
        if (empty($array)) {
            return '频道有误';
        }elseif (!query($array['keywords'].'_content',['where'=>['id'=>$id],'value'=>'id'])) {
            return '收藏的内容并不存在';
        }
        return true;
    }

}
