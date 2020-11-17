<?php
namespace app\common\fun;
require ROOT_PATH.'plugins/phpexcel/phpexcel/PHPExcel.php';
use PHPExcel_IOFactory;
use PHPExcel;
class Export{
	/**
	 * 通用数据导出类
	 * @param $expTitle 导出的文件标题
	 * @param $expCellName 导出的表头文件
	 * @param $expTableData 导出的数据
	 */
	public static function exportExcel($expTitle,$expCellName,$expTableData){
		$xlsTitle=iconv('utf-8','gb2312',$expTitle);
		$fileName=$expTitle.date('_Ymd');
		$cellNum=count($expCellName);
		$dataNum=count($expTableData);
		$objPHPExcel=new PHPExcel();
		$cellName=[
			'A',
			'B',
			'C',
			'D',
			'E',
			'F',
			'G',
			'H',
			'I',
			'J',
			'K',
			'L',
			'M',
			'N',
			'O',
			'P',
			'Q',
			'R',
			'S',
			'T',
			'U',
			'V',
			'W',
			'X',
			'Y',
			'Z'
		];
		for($i=0;$i<$cellNum;$i++){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'1',$expCellName[$i][1]);
		}
		for($i=0;$i<$dataNum;$i++){
			for($j=0;$j<$cellNum;$j++){
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+2),$expTableData[$i][$expCellName[$j][0]]);
			}
		}
		ob_end_clean();
		header('pragma:public');
		header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
		header("Content-Disposition:attachment;filename=$fileName.xls");
		$objWriter=\PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		$objWriter->save('php://output');
		exit;
	}
	/**
	 * 通用导入类
	 * @param $file
	 * @return array|void
	 */
	public static function read_excel($file){
		if(!is_file($file)&&!preg_match("/\.xls$/",$file)){
			die('xls文件不存在!');
		}
		$objPHPExcel=\PHPExcel_IOFactory::load($file);//读取上传的文件
		$array=$objPHPExcel->getSheet(0)->toArray();//获取其中的数据
		return $array;
	}
}