<?php
namespace app\hy\index\wxapp;

use app\shop\model\Content AS CModel;
//小程序
class Shop extends Base
{
    /**
     * 把贴子移出圈子,并没有真正删除
     * @param number $id
     * @return \think\response\Json
     */
    public function remove($id=0){
        //$model = new CModel();
         //$cinfo = $model->getInfoByid($id);
       $cinfo = CModel::getInfoByid($id);
       if($this->check_power($cinfo['ext_id'])){
           $data = [
                   'id'=>$id,
                   'ext_id'=>0,
           ];
           if(CModel::editData($cinfo['mid'],$data)){
               return $this->ok_js([],'删除成功');
           }else{
               return $this->err_js('数据执行失败');
           }            
        }else{
            return $this->err_js('你没权限');
        }        
    }

}













