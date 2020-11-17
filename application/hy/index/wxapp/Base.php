<?php
namespace app\hy\index\wxapp;

use app\common\controller\IndexBase;
use app\hy\model\Content;
use app\hy\model\Member;

//小程序
class Base extends IndexBase
{
    //protected $beforeActionList = ['check_power'];
    
    /**
     * 检查权限
     * @param number $aid
     * @return boolean
     */
    public function check_power($aid=0){
        if(!$aid){
            return false;
        }
        //圈子用户表
        $m_info = Member::get([
                'aid'=>$aid,
                'uid'=>$this->user['uid'],
        ]);
        if ($m_info['type']==2){
            return true; //管理员
        }
        
        $info = Content::getInfoByid($m_info['aid']);   //圈子信息
        
        if($info['uid']!=$this->user['uid']){
            return true;    //创建人
        }
    }

}













