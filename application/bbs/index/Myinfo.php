<?php
namespace app\bbs\index;

use app\common\controller\index\C; 


//内容页与列表页
class Myinfo extends C
{	
	/**
	 * 我的帖子
	 * {@inheritDoc}
	 * @see \app\common\controller\index\C::index()
	 */
	public function index(){
	    return $this->fetch();
	}
	
}