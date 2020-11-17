<?php
namespace app\qun\index\wxapp;

class Act extends Base
{
    /**
     * 删除内容
     * @param string $sysname 频道目录名
     * @param number $id 内容ID
     * @return void|unknown|\think\response\Json|void|\think\response\Json
     */
    public function delete($sysname='',$id=0){
       $power = false;
       $model = get_model_class($sysname,'content');
       $info = $model->getInfoById($id);
       if ($this->admin || $info['uid']==$this->user['uid']) {
           $power = true;
       }
//        elseif ($info['ext_sys']!=M('id')) {
//            return $this->err_js('参数不全');
//        }
       elseif($this->check_power($info['ext_id'])){
           $power = true;
       }
       if($power){
           if( $model->deleteData($id,$info['mid']) ){
               hook_listen('cms_delete_end',$info,$sysname);  //钩子扩展
               return $this->ok_js([],'删除成功');
           }else{
               return $this->err_js('数据执行失败');
           }
        }else{
            return $this->err_js('你没权限');
        }
    }
    
    
    /**
     * 置顶相关操作
     * @param string $sysname 频道目录名
     * @param number $id 内容ID
     * @return void|unknown|\think\response\Json|void|\think\response\Json
     */
    public function top($sysname='',$id=0){
        $power = false;
        $model = get_model_class($sysname,'content');
        $info = $model->getInfoById($id);
        if ( $this->admin ) {
            $power = true;
        }
        //        elseif ($info['ext_sys']!=M('id')) {
        //            return $this->err_js('参数不全');
        //        }
        elseif( $this->check_power($info['ext_id']) ){
            $power = true;
        }
        if($power){
            $data = [
                    'id'=>$id,
                    'qun_status'=>$info['qun_status']?0:1,
            ];
            if( $model->editData($info['mid'],$data) ){                	
                hook_listen('cms_edit_end',$data,['result' =>true, 'module' =>$sysname,'info'=>$info]);  //钩子扩展
                return $this->ok_js([],'执行成功');
            }else{
                return $this->err_js('数据执行失败');
            }
        }else{
            return $this->err_js('你没权限');
        }
    }

}













