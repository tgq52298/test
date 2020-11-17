<?php
namespace app\fenlei\admin;

use app\common\controller\admin\S;


class Sort extends S
{
//     protected function set_field_form($id=0){
//         $array = parent::set_field_form($id);
//         $array['基础设置'][] = ['text', 'haibao', '海报模板路径',fun('haibao@get_haibao_list').'可留空,多个用逗号隔开,需要补全路径(其中haibao_style不用填):比如:“xxx/show.htm”'];
//         return $array;
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













