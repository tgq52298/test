<?php
namespace app\exam\index;

use app\common\controller\IndexBase;

//最近考试
class Recently extends IndexBase
{
	public function index(){
	    return $this->fetch();
	}

}
