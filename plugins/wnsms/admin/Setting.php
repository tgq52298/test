<?php
namespace plugins\wnsms\admin;

use app\common\controller\admin\Setting AS _Setting;


class Setting extends _Setting
{    
    /**
     * 参数设置
     * {@inheritDoc}
     * @see \app\common\controller\admin\Setting::index()
     */
    public function index($group=null){
        $this->tab_ext['help_msg'] = '<a href="https://x1.php168.com/appstore/content/show/id/348.html" target="_blank">点击查看详细设置教程</a>';
        return parent::index($group);
    }
}

