<?php
namespace app\weibo\traits;
use app\weibo\model\Content;
use think\Db;
trait C
{
    /**
     * 创建前 检查
     * @param number $mid 模型ID
     * @param number $fid 分类ID
     * @return boolean
     */
    protected function add_inc_check($mid=0,$fid=0,&$data){
        
        if($this->webdb['can_post_group'] && !in_array($this->user['groupid'], $this->webdb['can_post_group'])){
            return '你无权创建微博';
        }elseif (Content::getIndexByUid($this->user['uid'])){
            return '不能重复创建';
        }
        if(!$data['title']){
            $data['title'] = $this->user['username'];
        }
        if(!$data['picurl']){
            $data['picurl'] = $this->user['icon'];
        }
        return true;
    }
    
    /**
     * 创建成功后的操作
     * @param number $id
     * @param array $data
     */
    protected function end_inc_add($id=0,$data=[]){
        if(!$id){
            return ;
        }
        Db::name(Content::$base_table)->where('id',$id)->update(['id'=>$this->user['uid']]);
        Db::name(Content::$base_table.$this->mid)->where('id',$id)->update(['id'=>$this->user['uid']]);
        fun('sns@push_topic',$this->user['uid']);
        fun('sns@push_comment',$this->user['uid']);
        fun('sns@push_reply',$this->user['uid']);
    }
    
    protected function edit_inc_check(){
        return true;
    }
    
    protected function delete_inc_check(){
        return true;
    }
    
}