<?php
namespace app\exam\index;

use app\common\controller\IndexBase;

//我的相关
class My extends IndexBase
{
	public function index(){
	    return $this->fetch();
	}

}
