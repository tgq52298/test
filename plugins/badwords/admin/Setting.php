<?php
namespace plugins\badwords\admin;
use app\common\controller\admin\Setting AS _Setting;


class Setting extends _Setting
{




    public function index($group=null){

        $this->config = [
            [
                'c_key'=>'word_type',
                'title'=>'词库类型',
                'c_value'=>'0',
                'form_type'=>'radio',
                'options'=>"0|内置\r\n1|自定义",
                'ifsys'=>1,
                'list'=>0,
            ],
            [
                'c_key'=>'word_sign',
                'title'=>'替换符',
                'c_value'=>'0',
                'form_type'=>'radio',
                'options'=>"0|*\r\n1|#\r\n2|⊙\r\n3|★\r\n4|◆",
                'ifsys'=>1,
                'list'=>0,
            ],
            [
                'c_key'=>'commentplus_sw',
                'title'=>'是否过滤博客式评论',
                'c_value'=>'0',
                'form_type'=>'radio',
                'options'=>"0|关\r\n1|开",
                'ifsys'=>0,
                'list'=>99,
            ],
        ];




       return parent::index($group);
    }
}
