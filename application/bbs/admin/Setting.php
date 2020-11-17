<?php
namespace app\bbs\admin;

use app\common\controller\admin\Setting AS _Setting;


class Setting extends _Setting
{    
//    protected $config = [];
    
    /**
     * 参数设置
     * {@inheritDoc}
     * @see \app\common\controller\admin\Setting::index()
     */
    public function index($group=null){
        
        $array = [
                [
                        'c_key'=>'reward_gave_wx',
                        'title'=>'打赏金额是否直接转到微信钱包',
                        'c_value'=>'0',
                        'options'=>"0|存入到帐户余额\r\n1|直接转到微信钱包(必须开通微信支付才行)",
                        'c_descrip'=>'',
                        'form_type'=>'radio',
                        'ifsys'=>0,
                        'list'=>0,
                ],
                [
                        'c_key'=>'show_pay_money',
                        'title'=>'内容页是否显示用户的消费金额',
                        'c_value'=>'0',
                        'options'=>"0|不显示\r\n1|显示",
                        'c_descrip'=>'',
                        'form_type'=>'radio',
                        'ifsys'=>0,
                        'list'=>0,
                ],
                [
                        'c_key'=>'group_reply_money',
                        'title'=>'发表评论回复对应用户组奖励虚拟币',
                        'c_descrip'=>'0或留空则不做处理',
                        'form_type'=>'usergroup',
                        'ifsys'=>0,
                        'list'=>-1,
                ],
                [
                        'c_key'=>'group_reply_jftype',
                        'title'=>'发表评论回复奖励哪种虚拟币',
//                         'c_descrip'=>'选择第一项积分无效,积分跟上面的会有重复,只以上面的为标准',
                        'c_value'=>'0',
                        'form_type'=>'jftype',
                        'ifsys'=>0,
                        'list'=>-1,
                ],
//                 [
//                         'c_key'=>'group_reply_jftype_money',
//                         'title'=>'发表评论回复额外奖励相应的虚拟币值',
//                         'c_descrip'=>'0或留空则不做处理',
//                         'form_type'=>'usergroup',
//                         'ifsys'=>0,
//                         'list'=>-3,
//                 ],
        ];
        
        //联动显示
//         $this->tab_ext['trigger'] = [
//                 ['group_reply_jftype', substr(implode(',',array_flip(jf_name())), 2), 'group_reply_jftype_money'],
//         ];
        
        if (is_array($this->config)) {
            $this->config = array_merge($this->config,$array);
        }else{
            $this->config = $array;
        }
        
        return parent::index($group);
    }
}

