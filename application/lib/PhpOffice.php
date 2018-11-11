<?php  
/**
 * PhpOffice  PhpSpreadsheet
 * https://github.com/PHPOffice/PhpSpreadsheet
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */ 
namespace app\lib;
use app\common\model\Log as M;

class PhpOffice {
	 /**
	  * 读取 csv xls文件
	  * @param  [type] $inputFileType [description]
	  * @param  [type] $inputFileName [description]
	  * @return [type]                [description]
	  */
	 public function read($inputFileType,$inputFileName){
	 	$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
 		$reader->setReadDataOnly(true); 
 		$worksheetData = $reader->listWorksheetInfo($inputFileName); 
		foreach ($worksheetData as $worksheet) {  
		    $each[$worksheet['worksheetName']] =  $worksheet['totalRows']; 
		}   
 		$spreadsheet = $reader->load($inputFileName);
 		$i = 0;
 		foreach($each as $k=>$v){
 			$arr = $spreadsheet->getSheet($i)->toArray();
 			$i++;
 			$data[$k] = $arr;
 		}
 		return $data;
	 }

}