<?php
namespace app\hy\traits;

use app\hy\model\Member;

trait C
{
    /**
     * 圈子的创建前 检查
     * @param number $mid 模型ID
     * @param number $fid 分类ID
     * @return boolean
     */
    protected function add_inc_check($mid=0,$fid=0){
        $result = $this->check_info_num($mid);
        if ($result!==true) {
            return $result;
        }
        
        $result = $this->check_field($mid);
        if ($result!==true) {
            return $result;
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
        //模型那里创建过了
//         $array = [
//                 'aid'=>$id,
//                 'uid'=>$this->user['uid'],
//                 'type'=>3,
//                 'create_time'=>time(),
//         ];
//         Member::create($array);
    }
    
    protected function edit_inc_check(){
        return true;
    }
    
    protected function delete_inc_check(){
        return true;
    }
    
    /**
     * 字段的检查
     * @return string|boolean
     */
    protected function check_field(){
        if (IS_POST) {
            $data = get_post('post');
            if(!$data['fid']){
                return '你没有选择分类!';
            }elseif(!$data['title']){
                return '圈子名称不能为空!';
            }            
        }
        return true;
    }
    
    
    /**
     * 检查发布权限
     * @return string|boolean
     */
    protected function check_info_num($mid=1){
        if($this->admin){
            return true;
        }
        $group_array = json_decode($this->webdb['group_create_num'],true);
        $groupid = $this->user['groupid'];
        if($group_array[$groupid]<1){
            return '你无权创建';
        }        
        $num = $this->model->user_info_num($this->user['uid'],$mid);        
        
        if($num>=$group_array[$groupid]){
            return '你创建的个数不能超过'. $group_array[$groupid] .'个';
        }        
        return true;
    }
    
    
    
}