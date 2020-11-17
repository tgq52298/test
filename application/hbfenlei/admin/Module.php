<?php
namespace app\hbfenlei\admin;

use app\common\controller\admin\M;

class Module extends M
{

//     protected function set_config(){
//         parent::set_config();
//         $this->form_items = [
//                 ['text', 'title', '模型名称'],
//                 ['text', 'haibao', '海报模板路径',get_haibao_list().'可留空,多个用逗号隔开,需要补全路径(其中haibao_style不用填):比如:“xxx/show.htm”'],
//         ];        
//     }
    
//     public function edit($id=0){
//         if ($this->request->isPost()) {
//             $data = $this->request->post();
//             if ($data['haibao']) {
//                 $detail = explode(',',$data['haibao']);
//                 foreach($detail AS $value){
//                     if($value!='' && !is_file(TEMPLATE_PATH.'haibao_style/'.$value)){
//                         $this->error('当前文件不存在:'.TEMPLATE_PATH.'haibao_style/'.$value);
//                     }
//                 }                
//             }
//         }
//         return parent::edit($id);
//     }
}
