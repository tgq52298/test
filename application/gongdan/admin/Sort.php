<?php
namespace app\gongdan\admin;

use app\common\controller\admin\S;


class Sort extends S
{
    protected function set_field_form($id=0){
        $this -> tab_ext['help_msg'] = '1、注意默认流程状态的第二、三项最好不要设置默认值，因为不同的圈子的用户组可能不一样。<br>2、默认字段即用户创建工单模板的时候,会默认使用,但他们也可以再添加、删除、修改.<script type="text/javascript">setTimeout(function(){ $(".layui-tab-title li").eq(3).trigger("click"); },500);</script>';
        $array = parent::set_field_form($id);
        return array_merge($array,[
            '默认表单字段'=>[
                ['textarea','order_filed','默认表单字段'],
                ['qun_group_array2','status_type','默认流程状态','第一项是流程状态,比如一审、二审、同意、拒绝等等，第二项是有权限设置该状态的用户组，第三项设置该状态后要通知哪些用户组。注意默认流程状态的第二、三项最好不要设置默认值，因为不同的圈子的用户组可能不一样。'],
            ],
        ]);
    }
}













