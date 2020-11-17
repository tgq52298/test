<?php
namespace app\hy\index\wxapp;

use app\common\controller\index\wxapp\Post AS _Post;
use app\hy\traits\C AS Ctraits;

//小程序 发表内容处理
class Post extends _Post
{
    use Ctraits;
    
    /**
     * 创建圈子前的 相关权限检查
     * @param number $fid
     * @param number $mid
     * @return boolean
     */
    public function add_check($mid=1,$fid=0,&$data=[]){
        $result = $this->add_inc_check($mid,$fid,$data);
        if ($result!==true) {
            return $result;
        }
        
        //这里可以做二次开发
        return parent::add_check($mid,$fid,$data);
    }
    
    //创建成功后的操作
    protected function end_add($id=0,$data=[]){
        $this->end_inc_add($id,$data);
    }
    
    /**
     * 上传文件,图片或视频
     */
    public function postFile(){
        return parent::postFile();
    }
    
    /**
     * 删除主题
     * @param number $id 主题ID
     * @return \think\response\Json
     */
    public function delete($id=0){
        return parent::delete($id);
    }
    
    /**
     * 修改主题
     * @param number $id
     * @return \think\response\Json
     */
    public function edit($id=0){
        return parent::edit($id);
    }
    
    /**
     * 新发表主题
     * @return \think\response\Json
     */
    public function add($mid=1){
        return parent::add($mid);
    }
    
    /**
     * 获取栏目数据
     * @return \think\response\Json
     */
    public function get_sort(){
        return parent::get_sort();
    }
    
    /**
     * 主题点赞
     * @param number $id 主题ID
     * @return \think\response\Json
     */
    public function agree($id=0){
        return parent::agree($id);
    }
    
}













