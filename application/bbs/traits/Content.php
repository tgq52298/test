<?php
namespace app\bbs\traits;

trait Content
{
    /**
     * 删除前的权限检查
     * @param number $id 贴子ID
     * @param array $info 贴子主题
     * @return string|unknown
     */
    protected function delete_check($id=0,$info=[]){
        if ($this->webdb['reply_num_limit_delete']>0 && $info['replynum'] > $this->webdb['reply_num_limit_delete'] && empty($this->admin)) {
            return '回贴量超过 '.$this->webdb['reply_num_limit_delete'].' 的贴子,不能随意删除';
        }
        return parent::delete_check($id,$info);
    }
    /**
     * 同时适用于前台与后台 新增加后做个性拓展
     * @param number $id 内容ID
     * @param number $data 内容数据
     */
//     protected function end_add($id=0,$data=[]){
//     }
    
    /**
     * 同时适用于前台与后台 修改后做个性拓展
     * @param number $id 内容ID
     * @param array $data 内容数据
     */
//     protected function end_edit($id=0,$data=[]){
//     }
    
    /**
     * 同时适用于前台与后台 删除后做个性拓展
     * @param number $id 内容ID
     * @param array $info 内容数据
     */
//     protected function end_delete($id=0,$info=[]){
//     }
}