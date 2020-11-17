<?php
namespace app\qun\index\wxapp;

use app\common\controller\index\wxapp\Index AS _Index; 
use app\qun\model\Content AS ContentModel; 
use app\qun\model\Member AS MemberModel;
use app\qun\model\Visit AS VisitModel;
use app\common\model\Msg AS MsgModel;
use think\Db;

class Qun extends _Index
{
    public function index($type='',$rows=20,$page=1){
        $map = [];
        $order = 'id desc';
        if ($type=='good') {
            $map['status'] = ['>',1];
        }else{
            $map['status'] = ['>',0];
        }
        if ($type=='hot') {
            $order = 'view desc';
        }elseif ($type=='list') {
            $order = 'list desc';
        }
        
        $listdb = ContentModel::getAll($map,$order,$rows,[],true);
        $listdb = getArray($listdb);
        foreach ($listdb['data'] AS $key=>$rs){
            unset($rs['sncode']);
            $listdb['data'][$key] = $rs;
        }
        return $this->ok_js($listdb);
    }

    /**
     * 我创建的群
     * @param number $uid
     * @return void|unknown|\think\response\Json|void|\think\response\Json
     */
    public function mycreate($uid=0){
        if (empty($uid)) {
            $uid = $this->user['uid'];
        }
        $listdb = ContentModel::getListByMid(1,['uid'=>$uid],'usernum desc',20,[],true);
        return $this->ok_js($listdb);
    }
    
    /**
     * 我加入的群,其中也有我创建的
     * @param number $uid
     * @return void|unknown|\think\response\Json|void|\think\response\Json
     */
    public function myjoin($uid=0,$rows=20,$page=1){
        if (empty($uid)) {
            $uid = $this->user['uid'];
        }
        if ($page<1) {
            $page = 1;
        }
        $min = ($page-1)*$rows;
        $listdb = MemberModel::where(['uid'=>$uid])->order('id desc')->limit($min,$rows)->column('id,aid');
        $array = [];
        if($listdb){
            foreach($listdb AS $key=>$aid){
                $rs = ContentModel::getInfoByid($aid,true);
                if (empty($rs)||$array[$aid]) {
                    MemberModel::destroy($key);
                    continue;
                }
                unset($rs['sncode']);
                $array[$aid] = $rs;
            }
        }
        return $this->ok_js(array_values($array));
    }
    
    /**
     * 交流最活跃的群
     */
    public function lively($rows=10,$page=1){
        $page>0 || $page=1;
        $min = ($page-1)*$rows;
        $subQuery = MsgModel::where('qun_id','>',0)
        ->field('uid,create_time,id,qun_id')
        ->order('id desc')
        ->limit(8000)
        ->buildSql();
        
        $listdb = Db::table($subQuery.' a')
        ->field('uid,create_time,id,qun_id,count(id) AS msgnum')
        ->group('qun_id')
        ->order('id','desc')
        ->limit($min,$rows)
        ->select();
        
        foreach($listdb AS $key=>$qs){            
            $quninfo = ContentModel::getInfoByid($qs['qun_id']);
            if (empty($quninfo)) {
                MsgModel::where('id',$qs['id'])->delete();
				continue;
            }
            unset($quninfo['sncode']);
            $quninfo['picurl'] = tempdir($quninfo['picurl']);
            $rs = $quninfo;
            $rs['last_time'] = date('Y-m-d H:i',$qs['create_time']);
            $rs['msgnum'] = $qs['msgnum'];
            $listdb[$key] = $rs;
        }
        return $this->ok_js($listdb);
    }
    
    /**
     * 我最近访问的圈子
     * @param number $uid
     * @return void|unknown|\think\response\Json|void|\think\response\Json
     */
    public function myvisit($uid=0,$rows=20,$page=1){
        if (empty($uid)) {
            $uid = $this->user['uid'];
        }
        if ($page<1) {
            $page = 1;
        }
        $min = ($page-1)*$rows;
        $listdb = VisitModel::where(['uid'=>$uid])->order('visittime desc')->limit($min,$rows)->column('id,aid');
        $array = [];
        if($listdb){
            foreach($listdb AS $id=>$aid){
                $rs = ContentModel::getInfoByid($aid,true);
                if(empty($rs)){
                    VisitModel::destroy($id);
                    continue;
                }
                unset($rs['sncode']);
                $array[] = $rs;
            }
        }
        return $this->ok_js($array);
    }
    
    /**
     * 根据一串ID获取圈子信息
     * @param number $id
     * @return void|unknown|\think\response\Json|void|\think\response\Json
     */
    public function getbyids($ids=''){
        $detail = explode(',', $ids);
        $id_array = [];
        foreach($detail AS $id){
            if (empty($id)) {
                continue;
            }
            $info = ContentModel::getInfoByid($id,true);
            unset($info['sncode']);
            $id_array[] = $info;
        }
        if ($id_array) {
            return $this->ok_js($id_array);
        }else{
            return $this->err_js('数据不存在');
        }
    }
    
    /**
     * 根据ID获取圈子信息
     * @param number $id
     * @return void|unknown|\think\response\Json|void|\think\response\Json
     */
    public function getbyid($id=0){

        $info = ContentModel::getInfoByid($id,true);
        unset($info['sncode']);
        if ($info) {
            return $this->ok_js($info);
        }else{
            return $this->err_js('数据不存在');
        }
    }
    
}













