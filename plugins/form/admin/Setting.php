<?php
namespace plugins\form\admin;

use app\common\controller\admin\Setting AS _Setting;


class Setting extends _Setting
{    
    /**
     * 参数设置
     * {@inheritDoc}
     * @see \app\common\controller\admin\Setting::index()
     */
    public function index($group=null){
        $this->config = [
                [
                        'c_key'=>'allow_guest_post',
                        'title'=>'是否允许游客发表',
                        'c_value'=>'',
                        'form_type'=>'radio',
                        'options'=>"0|不允许\r\n1|允许",
                        'ifsys'=>0,
                        'list'=>0,
                ],
        ];
        return parent::index($group);
    }
}

