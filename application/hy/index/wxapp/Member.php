<?php
namespace app\hy\index\wxapp;

use app\common\controller\IndexBase;
use app\hy\model\Member AS MemberModel;
use app\hy\model\Content;

class Member extends IndexBase
{
    /**
     * 加入圈子
     * @param number $id 圈子ID
     * @return \think\response\Json
     */
    public function join($id=0){
        if(!$this->user){
            return $this->err_js('你还没有登录!');
        }
        $info = Content::getInfoByid($id);
        if(!$info){
            return $this->err_js('ID有误!');
        }
        $where = [
                'aid'=>$id,
                'uid'=>$this->user['uid'],
        ];
        $rs = MemberModel::get($where);
        if($rs){
            return $this->err_js('你已经加入过了,请不要重复加入!');
        }
        
        $data = [
                'aid'=>$id,
                'uid'=>$this->user['uid'],
                'create_time'=>time(),
                'type'=>$info['autoyz'],
        ];
        $result = MemberModel::add($data);
        if($result){
            $data['id'] = $result->id;
            return $this->ok_js($data,$info['autoyz']?'加入成功':'你的申请信息已提交,请等待圈主审核!');
        }else{
            return $this->err_js('数据插入失败!');
        }
    }
    
    /**
     * 退出圈子
     * @param number $id
     */
    public function quit($id=0){
        $map = [
                'aid' => $id,
                'uid' => $this->user['uid']
        ];
        $info = MemberModel::get($map);
        if(!$info){
            return $this->err_js('你并没有加入该圈子');
        }elseif ($info['type']==3){
            return $this->err_js('你是管理员,不能退出圈子');
        }
        $result = MemberModel::destroy($info['id']);
        if($result){
            Content::addField($info['id'],'usernum',false);
            return $this->ok_js([],'成功退出');
        }else{
            return $this->err_js('数据库执行失败!');
        }
    }
    
    /**
     * 管理员操作
     * @param number $id ID索引
     * @param string $type 操作类型
     * @return \think\response\Json
     */
    public function act($id=0,$type=''){
        $info = MemberModel::get($id);
        $base_info = Content::getInfoByid($info['aid']);
        $rs = MemberModel::get([
                'uid'=>$this->user['uid'],
                'aid'=>$info['aid'],
        ]);
        if($rs['type']!=2&&$base_info['uid']!=$this->user['uid']){
            return $this->err_js('你不是管理员,无权操作!');
        }
        if($type=='del'){
            $reulst = MemberModel::destroy($id);
        }elseif(in_array($type, ['yz','up','down'])){
            if($type=='yz'){
                $data['type'] = 1;
            }elseif($type=='up'){
                $data['type'] = 2;
            }elseif($type=='down'){
                $data['type'] = 1;
            }
            $reulst = MemberModel::where('id',$id)->update($data);
        }
        if($reulst){
            return $this->ok_js([],'操作成功!');
        }else{
            return $this->err_js('数据库执行失败!');
        }        
    }
    
    /**
     * 签到增加浏览量
     * @param number $id
     */
    public function addview($id=0){
        Content::addView($id);
        return $this->ok_js([],'签到成功');
    }
    
    /**
     * 调用圈子成员列表
     * @param number $id
     * @param number $rows
     * @return \think\response\Json
     */
    public function get_member($id=0,$rows=10,$order='',$by=''){
        $data_list = MemberModel::getList($id,$rows,$order,$by,$map=[]);
         return $this->ok_js($data_list,'调用成功');
    }
    
    public function my_group($uid=0){
        $listdb = MemberModel::my_group($uid);
        if ($listdb){
            return $this->ok_js($listdb);
        }else{
            return $this->err_js('你还没有加入任何圈子');
        }
    }
    
}













