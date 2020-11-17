<?php
namespace app\exam\admin;

use app\common\controller\AdminBase;
use app\common\traits\AdminSort;


//科目学科分类
class Kemu extends AdminBase
{
    use AdminSort;
    
    protected $validate = '';
    protected $model;
    protected $m_model;
    protected $form_items;
    
    protected $list_items;
    protected $tab_ext;
    
    protected function _initialize()
    {
        parent::_initialize();
        preg_match_all('/([_a-z]+)/',get_called_class(),$array);
        $dirname = $array[0][1];
        $this->model = get_model_class($dirname,'kemu');        
        $this->set_config();
    }
    
    protected function set_config(){
        $this->list_items = [
                ['name', '科目名称', 'text'],
        ];
        
        $this->form_items = [
                ['textarea', 'name', '科目名称','同时添加多个科目的话，每个换一行'],
                ['select', 'pid', '归属上级分类','不选择，则为顶级分类',$this->model->getTreeTitle()],
        ];
        
        $this->tab_ext = [
                'page_title'=>'科目学科管理',
        ];
    }
    
    
    public function edit($id = null)
    {
        if($this->request->isPost()){
            $data = $this -> request -> post();
            $data = \app\common\field\Post::format_all_field($data,-4); //对一些特殊的字段进行处理,比如多选项,以数组的形式提交的
            
            if ($this -> model -> update($data)) {
                $this -> success('修改成功', 'index');
            } else {
                $this -> error('修改失败');
            }
        }
        
        if(empty($id)) $this->error('缺少id');
        
        $this->form_items = [
                ['text', 'name', '科目名称'],
                ['select', 'pid', '归属上级分类','不选择，则为顶级分类',$this->model->getTreeTitle($id)],
                // ['select', 'mid', '所属模型','创建后不能随意修改',$this->m_model->getTitleList()],
        ];
        
        $form_field =  \app\common\field\Form::get_all_field(-4);
        if ($form_field) {  //把用户自定义字段,追加到基础设置那里
            $this->form_items = array_merge($this->form_items,$form_field);
        }
        
        //联动字段,比如点击哪项就隐藏或者显示哪一项
        $this->tab_ext['trigger'] = \app\common\field\Form::getTrigger($this->mid);
        
        $info = $this->getInfoData($id);
        
        return $this->editContent($info);
    }
    
    
    
    
}













