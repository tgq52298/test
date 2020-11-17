<?php
namespace app\exam\index;

use app\common\controller\IndexBase;
use app\exam\model\Favpaper as FavModel;

//收藏试卷,不是试题
class Favpaper extends IndexBase
{
    /**
     * 收藏夹汇总
     * @return mixed|string
     */
    public function index(){
        return $this->fetch();
    }
    
    /**
     * 收藏夹收录接口
     * @param number $id 试卷ID
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function add($id=0){
        $result = $this->check_is_fav($id);
        if ($result!==true) {
            return $this->err_js($result);
        }
        $data = [
                'uid'=>$this->user['uid'],
                'aid'=>$id,
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
    
    public function delete($id=0){
        $result = $this->check_is_fav($id);
        if ($result!==true) {
            return $this->err_js($result);
        }
        $data = [
                'uid'=>$this->user['uid'],
                'aid'=>$id,
        ];
        $result = FavModel::where($data)->delete();
        if ($result) {
            return $this->ok_js('成功移除');
        }else{
            return $this->err_js('移除失败');
        }
    }
    
    /**
     * 收藏夹检查收录与否
     * @param number $id 试卷ID
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function check($id=0){
        $result = $this->check_is_fav($id);
        if ($result!==true) {
            return $this->err_js($result);
        }
        $data = [
                'uid'=>$this->user['uid'],
                'aid'=>$id,
        ];
        $result = FavModel::get($data);
        if ($result) {
            return $this->ok_js('已收藏');
        }else{
            return $this->err_js('还没收藏');
        }
    }
    
    
    protected function check_is_fav($id=0){
        if (empty($this->user)) {
            return '你还没登录';
        }elseif (empty($id)) {
            return 'id不存在';
        }
        return true;
    }

}
