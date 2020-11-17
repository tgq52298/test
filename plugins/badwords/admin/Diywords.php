<?php
namespace plugins\badwords\admin;
use app\common\controller\AdminBase;
use app\common\traits\AddEditList;
use think\db;
class Diywords extends AdminBase
{
    use AddEditList;
    protected $tab_ext;
    protected $form_items;



    protected function _initialize()
    {
        parent::_initialize();
        $rs = Db::name('badwords_kw')->where('id',1)->find();
        $this -> tab_ext = [
            'page_title'=>'添加自定义关键词',
        ];
        $this->form_items = [
            ['textarea', 'kwords', '关键词<br /><span style="color:red;font-size:0.8rem;">(需要在参数设置中把词库类型设置为自定义才有效)</span>','自行编辑关键词库,英文半角逗号隔开',$rs['kwords']],
        ];

    }

    public function  add_words(){
        if($this->request->isPost()) {
            $data = $this->request->post();
            $rs = Db::name('badwords_kw')->where('id',1)->update($data);
            if($rs){
              $this->success('更新成功');
            }else{
                $this->error('未更新');
            }
        }
        if(empty($template)){
            $template = $this->get_template('admin@common/wn_form');
        }
        $this->assign('tab_ext',$this->tab_ext);
        $this->assign('f_array',$this -> form_items);
        return $this->fetch($template);
    }
}