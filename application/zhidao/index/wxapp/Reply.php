<?php
namespace app\zhidao\index\wxapp;

use app\common\controller\index\wxapp\Reply AS _Reply; 

//小程序 评论回复
class Reply extends _Reply
{
    /**
     * 调取显示内容主题
     * @param number $id 内容ID
     * @return \think\response\Json
     */
    public function index($id=0,$orderby='',$rows='',$page=0){
        return parent::index($id,$orderby,$rows,$page);
    }
    
    
    /**
     * 删除回复评论
     * @param number $id 评论ID
     * @return \think\response\Json
     */
    public function delete($id=0){
        return parent::delete($id);
    }
    
    
    
    /**
     * 评论 点赞
     * @param number $id 回复评论ID
     * @return \think\response\Json
     */
    public function agree($id=0){
        return parent::agree($id);
    }
    
    /**
     * 发表评论
     * @param unknown $id 主题ID
     * @param unknown $pid 引用评论ID
     * @return \think\response\Json
     */
    public function add($id=0,$pid=0){
        return parent::add($id,$pid);
    }
    
}













