<?php
namespace app\yuyue\traits;

trait Content
{
    /**
     * 新添加前的处理
     * @param number $mid
     * @param number $fid
     * @param array $data
     * @return unknown
     */
    protected function add_check($mid=0,$fid=0,&$data=[]){
        $this->change_money($data);
        return parent::add_check($mid,$fid,$data);
    }
    
    /**
     * 针对付款类型不同的,订金的特殊处理
     * @param array $data
     */
    protected function change_money(&$data=[]){
        if ($data['paytype']==1) {  //一次性线上付全款 订金就等于促销价
            $data['fewmoney'] = $data['price'];
        }elseif ($data['paytype']==2) { //预约(线上不付款) 那么订金就为0
            $data['fewmoney'] = 0;
        }
    }
    
    /**
     * 修改前的处理
     * @param number $id
     * @param array $info
     * @param array $data
     * @return unknown
     */
    protected function edit_check($id=0,$info=[],&$data=[]){
        $this->change_money($data);
        return parent::edit_check($id,$info,$data);
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
     * @param array $data POST内容数据
     */
//     protected function end_edit($id=0,$data=[],$info=[]){
//     }
    
    /**
     * 同时适用于前台与后台 删除后做个性拓展
     * @param number $id 内容ID
     * @param array $info 内容数据
     */
//     protected function end_delete($id=0,$info=[]){
//     }
}