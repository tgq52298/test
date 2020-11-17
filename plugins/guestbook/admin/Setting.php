<?php
namespace plugins\guestbook\admin;

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
                        'title'=>'是否允许游客留言',
                        'c_value'=>'',
                        'form_type'=>'radio',
                        'options'=>"0|不允许\r\n1|允许",
                        'ifsys'=>0,
                        'list'=>0,
                ],
            [
            'c_key'=>'post_auto_pass_group',
            'title'=>'哪些用户组留言自动通过审核',
            'c_value'=>'',
            'c_descrip'=>'不设置,则默认全通过审核（管理员默认通过审核）',
            'form_type'=>'checkbox',
            'options'=>'app\common\model\Group@getTitleList@[{"id":["<>",0]}]',
            'ifsys'=>0,
            'list'=>0,
            ],
        ];
        return parent::index($group);
    }
}

