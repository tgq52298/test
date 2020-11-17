<?php
namespace app\hy\admin;

use app\common\controller\admin\Setting AS _Setting;


class Setting extends _Setting
{
    protected $config = [
            [
                    'title'=>'每个用户组对应只能创建的黄页数量',
                    'c_key'=>'group_create_num',
                    'c_value'=>'',
                    'form_type'=>'usergroup',
                    'options'=>'',
                    'c_descrip'=>'不能留空',
                    'ifsys'=>'0',
            ],
    ];
    /**
     * 参数设置
     * {@inheritDoc}
     * @see \app\common\controller\admin\Setting::index()
     */
    public function index($group=null){
        return parent::index($group);
    }
}

