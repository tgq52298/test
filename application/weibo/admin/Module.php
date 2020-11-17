<?php
namespace app\weibo\admin;

use app\common\controller\admin\M;

class Module extends M
{
    public function index(){
        $this->tab_ext['top_button'] = [];  //把创建模型的按钮去除
        return parent::index();
    }
}
