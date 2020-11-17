<?php
namespace app\hr\admin;

use app\common\controller\admin\S;


class Sort extends S
{
    protected function set_config(){
    	parent::set_config();
    	$this_model = $this->m_model->getTitleList();
    	unset($this_model[2]); //把简历模型去掉，不给简历模型创建栏目
        $this->form_items = [                
                ['text', 'name', '栏目名称'],
                ['select', 'pid', '归属上级分类','不选择，则为顶级分类',$this->model->getTreeTitle()],
                ['select', 'mid', '所属模型','创建后不能随意修改',$this_model,1],
        ];
  
    }


}













