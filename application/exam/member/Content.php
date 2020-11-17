<?php
namespace app\exam\member;

use app\common\controller\member\C;
use app\exam\traits\Content AS TraitsContent;


class Content extends C
{
    use TraitsContent;
    
    public function index($fid=0,$mid=0){
    	$this->check_power();
        return parent::index($fid,$mid);
    }
    
    public function postnew(){
    	$this->check_power();
    	return parent::postnew();
    }
    

    
    //判断用户是否有权增加试卷
    protected function check_power(){
    	if($this->webdb['can_add_title_group'] && !in_array($this->user['groupid'],$this->webdb['can_add_title_group'])){
    		$this->error('你所在用户组没权限进行试题相关操作');
    	}
    }
    
}
