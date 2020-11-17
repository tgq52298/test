<?php
namespace app\hy\index;

use app\common\controller\IndexBase;
use app\hy\model\Content;
use app\hy\model\Member;

class Base extends IndexBase
{
    protected $beforeActionList = ['base_info'];
    protected $info = [];    //圈子信息
    protected $power; //圈子权限
    protected $id;  //圈子ID
    
    public function base_info(){
        $aid = input('aid');
        $admin = 0;
        $info = Content::getInfoByid($aid,false);   //圈子信息
        $this->info = $info;
        if ($this->user) {
            if($info['uid']==$this->user['uid']){
                $admin = 2;
            }else{
                $m_info = Member::get([
                        'aid'=>$aid,
                        'uid'=>$this->user['uid'],
                ]);
                if ($m_info['type']==2){
                    $admin = 1;
                }
            }
        }
        $this->power = $admin;
        $this->id = $aid;
        $this->assign('power',$admin);
        $this->assign('info',$info);
        $this->assign('aid',$aid);
    }
    
    public function index(){        
        return $this->fetch();
    }
    
    public function add($mid=1){
        if (!$this->user) {
            $this->error('请先登录!');
        }
        $this->assign('mid',$mid);
	    return $this->fetch('post');
	}
	
	public function edit($id=0,$mid=1){
	    if (!$this->user) {
	        $this->error('请先登录!');
	    }
	    $this->assign('mid',$mid);
	    return $this->fetch('post');
	}
}
