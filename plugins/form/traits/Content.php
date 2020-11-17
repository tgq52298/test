<?php
namespace plugins\form\traits;

trait Content
{
    protected function send_form_msg($id=0,$data=[]){
        if($this->webdb['post_form_kefu_uid']!=''){
            $array = [];
            foreach( explode(',',str_replace('，', ',', $this->webdb['post_form_kefu_uid'])) AS $uid){
                if($uid && $user=get_user($uid)){
                    $array[] = $user;
                }
            }
            
            $title = $this->user['username'].' 提交了一份关于 '.model_config($data['mid'])['title'].' 的表单';
            $content = $title . '，<a href="'.get_url(purl('content/show',['id'=>$id],'index')).'" target="_blank">点击查看详情</a>';
            
            //发短消息
            if ($this->webdb['post_form_msg_send']) {
                foreach ($array AS $rs){
                    send_msg($rs['uid'],$title,$content);
                }
            }
            
            //发手机短信
            if ($this->webdb['post_form_sms_send']) {
                foreach ($array AS $rs){
                    $rs['mobphone'] && send_sms($rs['mobphone'],$title);
                }
            }
            
            //发微信消息
            if ($this->webdb['post_form_wx_send']) {
                foreach ($array AS $rs){
                    $rs['weixin_api'] && send_wx_msg($rs['weixin_api'],$content);
                }
            }
        }
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