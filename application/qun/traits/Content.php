<?php
namespace app\qun\traits;

trait Content
{
    /**
     * 同时适用于前台与后台 新增加后做个性拓展
     * @param number $id 内容ID
     * @param number $data 内容数据
     */
//     protected function end_add($id=0,$data=[]){
//     }
    
    /**
     * 同时适用于前台与后台 修改后做个性拓展
     * @param number $id 内容ID
     * @param array $data 内容数据
     */
//     protected function end_edit($id=0,$data=[]){
//     }
    
    /**
     * 同时适用于前台与后台 删除后做个性拓展
     * @param number $id 内容ID
     * @param array $info 内容数据
     */
//     protected function end_delete($id=0,$info=[]){
//     }


	
	/**
	 * 获取本地安装的风格
	 * @param string $type 类型
	 * @param array $return_type 返回的内容，默认所有配置
	 */
	public function local_style($type='',$return_type='all'){

		$template_path = TEMPLATE_PATH."qun_style/";  	//风格存放路径
		$style_path = PUBLIC_PATH."static/qun_style/";     	//风格样式存放路径
		//$file_url = get_url('/template/qun_style/');		//风格url路径
		$style_url = get_url('/public/static/qun_style/');	//风格样式url路径
		
		$dir=opendir($template_path);						//打开风格目录
		
		$listStyle='';
		$i=0;
		$template_config = $sort_arr = array();
		while( $file=readdir($dir)){
			if( is_dir($template_path.$file)&&$file!='.'&&$file!='..'&&$file!='.svn'){
				unset($defulatstyle);
				$defulatstyle = include($template_path.$file."/info.php");//风格配置
				if(!$defulatstyle){
					continue; //配置文件不存在直接跳过
				}
				
				$defulatstyle['sort'] && $sort_arr[] = $defulatstyle['sort'];//风格分类
				
				//根据分类获取风格
				if($type && ($type!=$defulatstyle['sort'])){
						continue;
				}

				$style_money = ($defulatstyle['money']) ? $defulatstyle['money'] : 0; 	//风格年费
				$template_config[$i]['template_path'] = $template_path;					//风格模板路径
				$template_config[$i]['style_path'] = $style_path; 						//风格样式路径
				$template_config[$i]['file'] = $file; 									//风格目录名
				$template_config[$i]['sort'] = $defulatstyle['sort']; 					//风格分类
				$template_config[$i]['name'] = $defulatstyle['name']; 					//风格名称
				$template_config[$i]['money'] = $style_money; 							//风格费用
				$template_config[$i]['styleimg'] = $style_url.$file."/demo_min.jpg";		//风格缩略图
				$template_config[$i]['styleBimg'] = $style_url.$file."/demo.jpg";			//风格展示图

				$i++;
			}
		}
		if($return_type=='all'){
			return $template_config; //返回所有的风格相关信息
		}else{
			$sort_arr = array_unique($sort_arr);//过滤重复分类
			return $sort_arr;		 //返回风格分类
		}
		
	}
	
}