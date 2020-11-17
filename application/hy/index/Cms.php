<?php
namespace app\hy\index;


class Cms extends Base
{
    public function add($mid=0){
        if(!$mid){
            $mid = 2;
        }
	    return parent::add($mid);
	}
	
	public function index($mid=1){
	    return $this->fetch('index'.$mid);
	}
}
