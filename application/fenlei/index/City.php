<?php
namespace app\fenlei\index;
use app\common\controller\IndexBase;
//城市选择页
class City extends IndexBase
{
	public function index(){
	    return $this->fetch();
	}
}
