<?php
namespace app\exam\index\wxapp;

use app\common\controller\index\wxapp\Index AS _Index; 


class Index extends _Index
{
    /**
     * 首页列表数据
     * @param number $fid
     * @return \think\response\Json
     */
    public function index($fid=0,$type=''){
        return parent::index($fid,$type);
    }
    
    /**
     * 根据用户UID获取其相应的试题
     * @param number $uid
     * @param number $mid
     * @param number $rows
     * @return void|unknown|\think\response\Json
     */
    public function listbyuid($uid=0,$mid=0,$rows=20,$keyword=''){
        return parent::listbyuid($uid,$mid,$rows,$keyword);
    }
}













