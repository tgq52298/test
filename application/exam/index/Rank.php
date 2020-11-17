<?php
namespace app\exam\index;

use app\common\controller\IndexBase;

//排行榜
class Rank extends IndexBase
{
	public function index(){
	    return $this->fetch();
	}

}
