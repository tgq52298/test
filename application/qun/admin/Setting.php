<?php
namespace app\qun\admin;

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
//                 [
//                         'c_key'=>'qun_hide_shop',
//                         'title'=>'圈子是否隐藏商城',
//                         'c_value'=>'',
//                         'form_type'=>'radio',
//                         'options'=>"0|显示\r\n1|隐藏",
//                         'ifsys'=>0,
//                         'list'=>-1,
//                 ],
                [
                        'c_key'=>'qun_user_show_claim',
                        'title'=>'哪些用户创建的'.QUN.'显示认领标志',
                        'c_value'=>'1,2,3',
                        'c_descrip'=>'多个用英文逗号隔开,比如1,2,3 认证或推荐的就不显示认领',
                        'form_type'=>'text',
                        'options'=>"",
                        'ifsys'=>0,
                        'list'=>-1,
                ],
                [
                        'c_key'=>'post_auto_pass_group',
                        'title'=>'哪些用户创建的'.QUN.'自动通过审核',
                        'c_value'=>'',
                        'c_descrip'=>'不设置,则默认全通过审核',
                        'form_type'=>'checkbox',
                        'options'=>'app\common\model\Group@getTitleList@[{"id":["<>",2]}]',
                        'ifsys'=>0,
                        'list'=>0,
                ],
                [
                        'c_key'=>'post_auto_up_group',
                        'title'=>'普通用户创建'.QUN.'通过审核后归属哪个用户组',
                        'c_value'=>'',
                        'c_descrip'=>'只针对普通用户而言的,不设置则不做用户组升级处理',
                        'form_type'=>'radio',
                        'options'=>'app\common\model\Group@getTitleList@[{"id":["not in",[3,8,2]]}]',
                        'ifsys'=>0,
                        'list'=>0,
                ],
        ];
        return parent::index($group);
    }
}

