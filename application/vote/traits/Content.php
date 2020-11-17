<?php
namespace app\vote\traits;
use app\common\controller\member\C;
use app\vote\model\Content AS _Content;

trait Content
{
    /**
     * 同时适用于前台与后台 新增或修改时检测
     * @param array $data 提交的数据
     * @param number $type 0新增，1修改
     * @param number $data 内容数据
     */
    protected function post_check($data=[],$type=0){
        if(!$data['fid']){
            return '投票项参数有误!';
        }elseif(!$data['title']){
            return '选项标题不能为空!';
        }
        $this_sort = $this->sortInfo($data['fid']); //投票项目设置参数
        $this_time=time();
        if($this_sort['joinbegintime']>0 && $this_sort['joinbegintime'] > $this_time){
                return '报名时间还没开始，禁止报名！';
        }
        if($this_sort['joinendtime']>0&&$this_sort['joinendtime']<$this_time){
            return '报名时间已结束，禁止报名或修改内容！';
        }
        // 禁止重复报名
        if($this_sort['repeatjoinvote'] && $type==0){
           $ck_content = _Content::getInfoByuid($this_sort['mid']);
            if($ck_content){
                return '已报过名，不能重复报名！';
            }
        }

    }

    //所在用户组报名是否自动通过审核
    protected function reform_data($data=[]){
         $this_sort = $this->sortInfo($data['fid']); //投票项目设置参数

         if($this_sort['allowpostyz']){
            $this_allowyz=explode(',',$this_sort['allowpostyz']);
            if(in_array($this->user['groupid'], $this_allowyz)){
                $data['status'] = 1;
            }else{
                $data['status'] = 0;
            }
         }else{
            $data['status'] = 1;
         }
         return $data;
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