<?php
namespace app\exam\index\wxapp;

use app\common\controller\IndexBase;
use app\exam\model\Category AS Model;
use app\exam\model\Putin;

class Paper extends IndexBase
{
    /**
     * 列出某人老师出的试卷
     * @param number $uid
     * @param number $rows
     * @return void|unknown|\think\response\Json
     */
    public function index($uid=0,$rows=10){
        if (empty($uid)) {
            $uid = $this->user['uid'];
        }
        $listdb = Model::where('uid',$uid)->order('id desc')->paginate($rows);
        return $this->ok_js($listdb);
    }
    
    
    /**
     * 设置或取消在线答题
     * @param number $aid
     * @param number $id
     * @param string $type
     * @return void|\think\response\Json|void|unknown|\think\response\Json
     */
    public function setlive($aid=0,$id=0,$type='add'){
        $qun = fun("qun@getByid",$aid);
        if (!$qun) {
            return $this->err_js(QUN.'不存在');
        }elseif(empty($this->admin) && $qun['uid']!=$this->user['uid']){
            return $this->err_js('你不是圈主');
        }
        $info = getArray(Model::where('id',$id)->find());
        if (empty($info)) {
            return $this->err_js('试卷不存在');
        }
        if ($type=='delete') {
            fun('Qun@live',$aid,'exam','');
            return $this->ok_js([],'成功下架');
        }else{
            fun('Qun@live',$aid,'exam',$info);
        }        
        return $this->ok_js($info);
    }
    
    /**
     * 获取自己的答题成绩
     * @param number $id
     */
    public function get_mark($id=0){
        $map = [
            'uid'=>$this->user['uid'],
            'paperid'=>$id,
        ];
        $info = getArray(Putin::where($map)->find());
        if ($info) {
            return $this->ok_js($info);
        }else{
            return $this->err_js('没记录');
        }
    }
    
}













