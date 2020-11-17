<?php
namespace plugins\timthumb\admin;
use app\common\controller\admin\Setting AS _Setting;
class Timthumb extends _Setting{
	public function index($group=null){
		if($this->request->isPost()){
			$data=$this->request->post();
			if($this->model->save_group_data($data,$data['group']?$data['group']:$group)){
				$tpl=file_get_contents(ROOT_PATH.'plugins/timthumb/timthumb.tpl');
				$data['ALLOWED_SITES']=var_export(explode(";",$data['ALLOWED_SITES']),true);
				unset($data['group']);
				foreach($data as $key=>$value){
					$findarr[]='_'.$key;
				};
				$tpl=str_replace($findarr,$data,$tpl);
				file_put_contents(ROOT_PATH."_tim.php",$tpl);
				$this->success('修改成功');
			}
		}
		return parent::index($group);
	}
}