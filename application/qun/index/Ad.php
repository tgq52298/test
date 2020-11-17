<?php
namespace app\qun\index;

use app\common\controller\IndexBase;

class Ad extends IndexBase
{
    public function index(){
        return $this->fetch();
    }    
}
