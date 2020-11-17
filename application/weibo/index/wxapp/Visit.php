<?php
namespace app\weibo\index\wxapp;

use app\common\controller\index\wxapp\Index AS _Index; 
use app\weibo\model\Content;
use app\weibo\model\Visit AS VisitModel;

//用户访问
class Visit extends _Index
{
    /**
     * 用户访问处理
     * @param unknown $id
     * @return void|\think\response\Json
     */
    public function check_visit($id){
        $key = 'visit_weibo_' . $id . '_' . $this->user['uid'];
        if(time()-get_cookie($key)>3600){     //每小时更新一次
            set_cookie($key, time());
            Content::addView($id);
            if (empty($this->user)) {
                return $this->err_js('游客访问');
            }
            $this->updata_visit($id);
            if($this->user['uid']!=$id){    //自己访问就不要做记录了 否则跟下面的函数 $touid != $login_id 也不对应
                fun('sns@add_msg',$id,'访问了你的空间','visit');
            }            
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
    }
    
}













