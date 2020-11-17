<?php
namespace app\hy\index;

use app\common\controller\index\C; 

//附近近
class Near extends C
{
	public function index(){
	    return $this->fetch();
	}	
	
}
