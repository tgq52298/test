<?php
namespace app\exam\admin;

use app\common\controller\admin\Setting AS _Setting;


class Setting extends _Setting
{
    protected $config = [
            [
                    'c_key'=>'each_title_dou',
                    'title'=>'每答对一道题奖励多少金豆',
                    'c_value'=>'1',
                    'c_descrip'=>'',
                    'form_type'=>'number',
                    'ifsys'=>0,
                    'list'=>0,
            ],
            [
                    'c_key'=>'paper_fen_dou',
                    'title'=>'试卷达到多少分就对应奖励多少金豆',
                    'c_value'=>'10/100,8/95,5/90',
                    'c_descrip'=>'格式如下:10/100,8/95,5/90以此类推,即100分奖励10个95分以上奖励8个,90分以上奖励5个',
                    'form_type'=>'text',
                    'ifsys'=>0,
                    'list'=>0,
            ],
            [
                    'c_key'=>'mseo_title',
                    'title'=>'SEO标题',
                    'c_value'=>'考试系统',
                    'c_descrip'=>'',
                    'form_type'=>'text',
                    'ifsys'=>0,
                    'list'=>10,
            ],
            [
                    'c_key'=>'mseo_keyword',
                    'title'=>'SEO优化关键字keywords',
                    'c_value'=>'',
                    'c_descrip'=>'',
                    'form_type'=>'text',
                    'ifsys'=>0,
                    'list'=>9,
            ],
            [
                    'c_key'=>'mseo_description',
                    'title'=>'SEO优化描述description',
                    'c_value'=>'',
                    'c_descrip'=>'',
                    'form_type'=>'text',
                    'ifsys'=>0,
                    'list'=>8,
            ],
            
            [
                    'c_key'=>'prize_about',
                    'title'=>'证书评语',
                    'c_value'=>"90|在XXX考试当中,成绩突出,被评为以下称号|三好学生\r\n60|在XXX考试当中,成绩过关,被评为以下称号|良好学生\r\n0|在XXX考试当中,成绩不合格被评为以下称号|学渣",
                    'c_descrip'=>'分数、评语、称号用竖|线隔开,不同阶段分数的评语换一行，比如:90|在XXX考试当中,成绩突出,被评为以下称号|三好学生',
                    'form_type'=>'textarea',
                    'ifsys'=>0,
                    'list'=>3,
            ],
            [
                    'c_key'=>'prize_cop',
                    'title'=>'证书颁发机构署名',
                    'c_value'=>'',
                    'c_descrip'=>'比如:某某平台、某某公司单位',
                    'form_type'=>'text',
                    'ifsys'=>0,
                    'list'=>2,
            ],
            [
                    'c_key'=>'is_prize_open',
                    'title'=>'是否启用证书功能',
                    'c_value'=>'',
                    'c_descrip'=>'考试结束后颁发证书',
                    'form_type'=>'radio',
                    'options'=>"0|禁用\r\n1|启用",
                    'ifsys'=>0,
                    'list'=>4,
            ],
    ];
    
    protected function getSysId(){
        $array = modules_config(config('system_dirname'));
        return $array['id'];
    }
}

