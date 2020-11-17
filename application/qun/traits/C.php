<?php
namespace app\qun\traits;
use think\Db;
//use app\qun\model\Member;

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
                return QUN.'名称不能为空!';
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
            return '你无权创建'.QUN;
        }        
        $num = $this->model->user_info_num($this->user['uid'],$mid);        
        
        if($num>=$group_array[$groupid]){
            return '你创建的'.QUN.'不能超过'. $group_array[$groupid] .'个';
        }        
        return true;
    }
    
    /**
     * 圈子转让更新相关表的UID
     * @param number $id 圈子ID
     * @param number $uid 领取用户UID
     * @return string|boolean
     */
    protected function transfer_update($id=0,$uid=0){
    	$contentdb = Db::name('qun_content')->where('id',$id)->find();		//查询索引表记录
    	if(!$contentdb || !$uid){
    		return false;
    	}
    	$map = ['id'=>$id];
    	$data = ['uid'=>$uid];																	
    	$content_res = $this->update_table('qun_content',$map,$data); 		//更新索引表
    	if(empty($content_res)){
    		return false;
    	}
    	$ys_uid = $contentdb['uid'];
    	$data2 = ['uid'=>$ys_uid];				
    	$content1_res = $this->update_table('qun_content'. $contentdb['mid'],$map,$data); 	//更新内容表
    	if(empty($content1_res)){
    		$content_res = $this->update_table('qun_content',$map,$data2);   //还原索引表
    		return false;
    	}
    	$map2 = ['aid'=>$id,'uid'=>$ys_uid];
    	$member_res = $this->update_table('qun_member',$map2,$data); 		//更新成员表管理员身份
    	/* 为兼容旧数据该次不做判断
    	if(empty($member_res)){
    		$content_res = $this->update_table('qun_content',$map,$data2); 	//还原索引表
    		$content_res = $this->update_table('qun_content1',$map,$data2); //还原内容表
    		return false;
    	}
    	 */
    	$map3 = ['pageid'=>$id];
    	$buystyle_res = $this->update_table('qun_buystyle',$map3,$data); 	//更新风格购买表
    	return true;
    }
    
    /**
     * 更新数据
     * @param string $table 表名
     * @param array $map 条件数组
     * @param array $data 需更新的数据
     * @return string|boolean
     */
    protected function update_table($table='',$map=[],$data=[]){
    	if(!$table || !$map || !$data){
    		return false;
    	}
    	$result = Db::name($table)->where($map)->update($data);
    	return $result;
    }
    
}