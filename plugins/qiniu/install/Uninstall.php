<?php
namespace plugins\qiniu\install;
use app\common\controller\AdminBase;
use think\Db;
class Uninstall extends AdminBase{
	public function run($id=0){
		$plugins=Db::name('plugin')->where(['id'=>$id])->value('keywords');
		//卸载钩子动作
		Db::name('hook_plugin')->where('plugin_key',$plugins)->delete();
		//卸载配置
		$upload_driver=Db::name('config')->where(['c_key'=>'upload_driver'])->find();
		if($upload_driver){
			$options=$this->options_attr($upload_driver['options']);
			if(isset($options['qiniu'])){
				unset($options['qiniu']);
			}
			$options=$this->implode_value($options);
			$result=Db::name('config')->where(['c_key'=>'upload_driver'])->update(['options'=>$options,'c_value'=>'local']);
		}
		return true;
	}

	function implode_value($array=[]){
		$result=[];
		foreach($array as $key=>$value){
			$result[]=$key.'|'.$value;
		}
		return empty($result)?'':implode(PHP_EOL,$result);
	}

	//重置一个 parse_attr 函数 默认的是以: 分割
	function options_attr($value=''){
		$array=preg_split('/[,;\r\n]+/',trim($value,",;\r\n"));
		if(strpos($value,'|')){
			$value=[];
			foreach($array as $val){
				list($k,$v)=explode('|',$val);
				$value[$k]=$v;
			}
		}else{
			$value=$array;
		}
		return $value;
	}
}