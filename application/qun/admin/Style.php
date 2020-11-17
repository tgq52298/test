<?php
namespace app\qun\admin;

use app\common\controller\AdminBase;
use app\qun\traits\Content;

class Style extends AdminBase
{
	use Content;
	
    public function index(){
    	$style_listdb = $this->local_style();
    	$this->assign('style_listdb',$style_listdb);
    	return $this->fetch();
    }
    
    //风格参数设置
    public function set(){
    	
		if($this->user['groupid']!=3){
			$this->error('你没权限进行该操作!');
		}
    	if($this->request->isPost()){
    		$data = $this->request->Post();
    		$style_name = $data['style_name'];		//风格名
    		$style_sort = $data['style_sort'];		//风格分类
    		$style_money = $data['style_money'];	//风格价格
    		$file = $data['file']; 					//风格目录名
    		$template_path = $data['template_path'];//风格路径
    		$file_path = $template_path.$file; 		//当前风格路径
    		
    		if(!is_dir($file_path)){
    			$this->error('风格目录不存在,可返回刷新页面后再尝试进行操作！');
    		}
    		
    		$info_path = $file_path.'/info.php'; 	//风格配置文件
    		//配置参数
    		$text = "<?php 
			return [
	    		'name'=>'$style_name',   //风格名称
	    		'sort'=>'$style_sort',   //风格分类
	    		'money'=>$style_money,   //风格价格
    		];";
    		
    		write_file($info_path, $text);
    		write_file($file_path.'/info.php.lock', '');
    		
    		$this->success('设置成功');
    	}
    }
    
    
    /**
     * 删除风格
     * @param string $style_name 风格目录名
     */
    public function del($style_name=''){
    	if($this->user['groupid']!=3){
    		$this->error('你没权限进行该操作!');
    	}
    	if(empty($style_name)){
    		$this->error('参数有误');
    	}
    	$template_path = TEMPLATE_PATH."qun_style/".$style_name;  	//风格存放路径
    	$style_path = PUBLIC_PATH."static/qun_style/".$style_name;     	//风格样式存放路径
    	delete_dir($template_path);										//删除风格模板
    	delete_dir($style_path);										//删除风格样式
    	$this->success('删除成功');
    }

}












