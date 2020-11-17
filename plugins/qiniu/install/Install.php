<?php
namespace plugins\qiniu\install;
use app\common\controller\AdminBase;
use think\Db;
class Install extends AdminBase{
	public function run($id=0){
		//先检测有没有添加upload_driver行为
		$hook=Db::name('hook')->where(['name'=>'upload_driver'])->find();
		if(!$hook){
			$data=['name'=>'upload_driver','about'=>'云储存','ifopen'=>'1'];
			Db::name('hook')->insert($data);
		}
		//检测upload_driver有没有设置
		$config=Db::name('config')->where(['c_key'=>'upload_driver'])->find();
		if(!$config){
			$options="local|本地\r\n"."qiniu|七牛储存";
			$dataconfig=['type'=>'1','title'=>'上传驱动','c_key'=>'upload_driver','c_value'=>'qiniu','form_type'=>'radio','options'=>$options,'ifsys'=>'1','sys_id'=>'0'];
			Db::name('config')->insert($dataconfig);
		}else{
			$upload_driver=Db::name('config')->where(['c_key'=>'upload_driver'])->find();
			$upload_driver['options'].=PHP_EOL.'qiniu|七牛储存';
			$result=Db::name('config')->where(['c_key'=>'upload_driver'])->update(['options'=>$upload_driver['options'],'c_value'=>'qiniu']);
			 
		}
	}
}