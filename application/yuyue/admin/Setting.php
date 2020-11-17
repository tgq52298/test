<?php
namespace app\yuyue\admin;

use app\common\controller\admin\Setting AS _Setting;

//频道参数设置
class Setting extends _Setting
{
    protected function getSysId(){
        $array = modules_config(config('system_dirname'));
        return $array['id'];
    }
    
    /**
     * 参数设置
     * {@inheritDoc}
     * @see \app\common\controller\admin\Setting::index()
     */
    public function index($group=null){
        
        $array = [
                [
                        'c_key'=>'allow_fx_group',
                        'title'=>'允许分销的用户组',
                        'c_value'=>'',
                        'form_type'=>'checkbox',
                        'options'=>'app\\common\\model\\Group@getTitleList@[{"id":["<>",2]}]',
                        'ifsys'=>0,
                        'list'=>-1,
                ],
        ];
        if (is_array($this->config)) {
            $this->config = array_merge($this->config,$array);
        }else{
            $this->config = $array;
        }
        return parent::index($group);
    }
}

