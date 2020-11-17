<?php

use think\Db;

//
if (!function_exists('get_answer')) {
    function get_answer($answer,$mid)
    {
        $array = ['','A','B','C','D'];
        if($mid==1){	//单选
            return $array[$answer];
        }elseif($mid==3){  //判断
            $array = ['','正确','错误'];
            return $array[$answer];
        }elseif($mid==2){ //多选
            $detail = explode(',',$answer);
            foreach($detail AS $value){
                $_array[] = $array[$value];
            }
            return implode('、',$_array);
        }else{ //填空或其它
            return $answer;
        }
    }
 }


  if (!function_exists('check_math')) {
     function check_math($content='')
     {
         $content = str_replace(['（','）'], ['(',')'], $content);
         $content = preg_replace_callback("/\([\d]+\/[\d]+\)/i", function($array){
             list($min,$max) = explode('/',str_replace(['(',')'], '', $array[0]));
             return "</div><div class='block'><div class='block_min'>$min</div><div class='block_max'>$max</div></div><div class='block'>";
         }, $content);
         return "<div class='block'>$content</div><div class='wap_block'></div>";
     }
 }

 if (!function_exists('format_math')) {
     function format_math($content='')
     {
         $content = preg_replace_callback("/<p>(.*?)<\/p>/is",function($array){
			return "<div class='pbr'>\r\n".check_math($array[1])."\r\n</div>\r\n\r\n" ;
		},$content);
         return $content;
     }
 }

 
 if (!function_exists('get_contentlist_bymid')) {
 	/**
 	 * 根据模型ID获取数据
 	 * @param number $mid 模型ID
 	 * @return number 所有内容
 	 */
 	function get_contentlist_bymid($mid=1,$map=[]){
 		$table=config('system_dirname').'_content'.$mid;
 		$map['status']=['>',0];
 		$this_contentdb = Db::name($table)->where($map)->field('id')->select();
 		return $this_contentdb;
 	}
 }
 
 
 if (!function_exists('get_contents_byid')) {
 	/**
 	 * 根据ID获取数据
 	 * @param number $id 内容ID
 	 * @return array 内容数据
 	 */
 	function get_contents_byid($id=0){
 		$table = config('system_dirname').'_content'; //索引表
 		$mid = Db::name($table)->where('id',$id)->value('mid'); //根据索引表获取模型ID
 		$order_table=config('system_dirname').'_content'.$mid; //模型内容表
 		$this_info = Db::name($order_table)->where('id',$id)->find();
 		return $this_info;
 	}
 }
 


if (!function_exists('read_excel')) {
	function read_excel($file){
		if(PHP_VERSION<'5.2'){
			die('PHP版本小于5.2不可以使用本功能,请升级一下你的PHP运行环境再使用本功能吧!');
		}elseif(!function_exists('zip_open')){
			die('服务器不支持zip功能,请修改php配置文件,把extension=php_zip.dll前面的“;”号删除掉');
		}
		if(!is_file($file)&&!preg_match("/\.xls$/",$file)){
			die('xls文件不存在!');
		}
		require_once(APP_PATH.'exam/excel/PHPExcel/IOFactory.php');
		$objPHPExcel = PHPExcel_IOFactory::load($file);
		//多少行
		$vertical_num = $objPHPExcel->getSheet(0)->getHighestRow();
		//多少列
		$horizontal_num = ord($objPHPExcel->getSheet(0)->getHighestColumn())-64;
	
		if($vertical_num<1){
			return ;
		}
	
		for($j=1;$j<=$vertical_num;$j++){
			unset($rs);
			for($i=0;$i<$horizontal_num ;$i++ ){
			
				$cell = $objPHPExcel->getSheet(0)->getCellByColumnAndRow($i,$j);
				//$value = $cell->getValue();
				$value = $cell->getCalculatedValue();
				if($value instanceof PHPExcel_RichText){    //富文本转换字符串 这里非常的重要				    
				    $value = $value -> __toString();
				}
				
				//解决日期格式的问题/
				if($cell->getDataType()==PHPExcel_Cell_DataType::TYPE_NUMERIC){  
				   $cellstyleformat = $cell->getParent()->getStyle( $cell->getCoordinate() )->getNumberFormat();  
				   $formatcode = $cellstyleformat->getFormatCode();  
				   if (preg_match('/^([$[A-Z]*-[0-9A-F]*])*[hmsdy]/i', $formatcode)) {  
						 $value=gmdate("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($value));
				   }else{  
						 $value=PHPExcel_Style_NumberFormat::toFormattedString($value,$formatcode);  
				   }
				}
	
				// if(WEB_LANG!='utf-8'){
				// 	$value = utf82gbk($value);
				// }
				// if(WEB_LANG=='big5'){
				// 	require_once(ROOT_PATH."inc/class.chinese.php");
				// 	$cnvert = new Chinese("GB2312","BIG5",$value,ROOT_PATH."./inc/gbkcode/");
				// 	$value = $cnvert->ConvertIT();
				// }
				$rs[$i] = $value;
			}
			$array[]=$rs;
		}
		return $array;
	}
}
 

 