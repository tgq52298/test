<?php
namespace app\bbs\index\wxapp;

use app\common\controller\IndexBase;
use app\bbs\model\Content AS ContentModel;

//访问权限处理
class Viewcheck extends IndexBase
{
    protected $model;                  //内容
    protected $mid;                      //模型ID
    
    protected function _initialize()
    {
        parent::_initialize();
        $this->model = new ContentModel();
        $this->mid = 1;
    }
    
    /**
     * 内容密码查看
     * @param string $pwd 用户输入的密码
     * @param string $md5pwd 加密后的串包含了多种信息
     */
    public function ckpwd($pwd='',$md5str=''){
        //$info = ContentModel::getInfoByid($id);
        list($id,$pass) = explode("\t", mymd5($md5str,'DE'));
        if ($pass && $pwd==$pass) {
            set_cookie(config('system_dirname').'content_password_'.$id,$pass);
            return $this->ok_js();
        }else{
            return $this->err_js();
        }
    }
    
    public function ckmoney($md5str=''){
        list($id,$money) = explode("\t", mymd5($md5str,'DE'));
        if($money<1){
            return $this->err_js('本文不需消费积分');
        }elseif (empty($this->user)) {
            return $this->err_js('你还没登录');
        }elseif ($this->user['money']<$money){
            return $this->err_js('你的积分不足'.$money);
        }
        $info = ContentModel::getInfoByid($id);
        if( !table_field(config('system_dirname')."_content".$info['mid'] , 'buyuser') ){
            into_sql("ALTER TABLE  `qb_".config('system_dirname')."_content{$info['mid']}` ADD  `buyuser` TEXT NOT NULL COMMENT  '消费积分才能浏览的用户'");
        }        
        $buyuser = $this->user['username'].'、'.$info['buyuser'];
        ContentModel::editData($info['mid'],[
                'id'=>$id,
                'buyuser'=>$buyuser
        ]);
        add_jifen($this->user['uid'],-abs($money),'查看 '.$info['title'].' 消费');
        add_jifen($info['uid'],abs($money),$this->user['username'].' 查看 '.$info['title'].' 获得收益');
        return $this->ok_js();
    }

}













