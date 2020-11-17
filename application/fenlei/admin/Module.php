<?php
namespace app\fenlei\admin;

use app\common\controller\admin\M;

class Module extends M
{
//     protected function set_config(){
//         parent::set_config();
//         $this->form_items = [
//                 ['text', 'title', '模型名称'],
//                 ['text', 'layout', '模板路径','一般请留空,否则必须放在/template/index_style/目录下,然后补全路径:比如:“qiboxxx/cms/content/list2.htm”'],
//                 ['text', 'haibao', '海报模板路径',fun('haibao@get_haibao_list').'可留空,多个用逗号隔开,需要补全路径(其中haibao_style不用填):比如:“xxx/show.htm”'],
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
