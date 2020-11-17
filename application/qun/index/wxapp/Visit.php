<?php
namespace app\qun\index\wxapp;

use app\common\controller\index\wxapp\Index AS _Index; 
use app\qun\model\Content;
use app\qun\model\Visit AS VisitModel;
use app\common\model\Msguser AS MsguserModel;

//小程序
class Visit extends _Index
{
    /**
     * 用户访问处理
     * @param unknown $id
     * @return void|\think\response\Json
     */
    public function check_visit($id){
        $key = 'visit_qun_' . $id . '_' . $this->user['uid'];
        if(time()-get_cookie($key)>3600){     //每小时更新一次
            set_cookie($key, time());
            Content::addView($id);
            $this->updata_visit($id);
            return $this->ok_js();
        }else{
            return $this->err_js();
        }
    }
    
    /**
     * 更新用户访问记录
     * @param number $id
     */
    protected function updata_visit($id=0){
        if(empty($this->user)){
            return ;
        }        
        $map = [
                'aid'=>$id,
                'uid'=>$this->user['uid'],
        ];        
        $rs = VisitModel::get($map);
        $map['visittime'] = time();
        if($rs){
            $map['id'] = $rs['id'];
            VisitModel::update($map);
        }else{
            VisitModel::create($map);
        }
        
        MsguserModel::add($this->user['uid'],-$id);  //把当前圈子加入到信息会话列表
        
//         Content::updates($id,['list'=>time(), ]);
    }
    
}













