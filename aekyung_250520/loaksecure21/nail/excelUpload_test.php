<?php
define('_HEROBOARD_', TRUE);
include_once                                '../../freebest/head.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';

header('Content-Type: application/json;');

$mission_idx 	= $_POST["mission_idx"];
$mission_title  = $_POST["mission_title"];
$point	 	 	= $_POST["point"];

$respone = array();
$respone["success"]	= true;
$respone["cnt"]		= 0;

if ($_FILES["upload_excel"]['name'] == ''){
	$respone["success"]	= false;
	$respone["status"]		= "noFile";
}else {
	$UPLOAD_DIR 	=  $_SERVER["DOCUMENT_ROOT"]."/PHPExcel/upload/";
	$filename 		= date('YmdHis').$_FILES["upload_excel"]["name"];
	$uploadFileName = $UPLOAD_DIR.$filename;
	
	if(!is_uploaded_file($_FILES["upload_excel"]["tmp_name"])){
		$respone["success"]	= false;
		$respone["status"]	= "noFile";
	}
	if ( !move_uploaded_file($_FILES["upload_excel"]["tmp_name"], $uploadFileName)){
		$respone["success"]	= false;
		$respone["status"]  = "noFile";
	}

	require_once $_SERVER["DOCUMENT_ROOT"]."/PHPExcel/PHPExcel.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/PHPExcel/PHPExcel/IOFactory.php";
	
	
	$objReader = PHPExcel_IOFactory::createReaderForFile($uploadFileName);
	
	$objReader->setReadDataOnly(false);
	$objExcel = $objReader->load($uploadFileName);
	$objExcel->setActiveSheetIndex(0);
	$objWorksheet = $objExcel->getActiveSheet();
	
	$list = array();
	foreach ($objWorksheet->getRowIterator() as $row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		
		$one = array();
		foreach ($cellIterator as $cell) {
			if(PHPExcel_Shared_Date::isDateTime($cell)) {
				$one[] = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));
			}else{
				$one[] = $cell->getValue();
			}
		}
		
		$list[] = $one;
	}
	
	
	for($i=0; $i< count($list); $i++){
		$one		= $list[$i];
		$excel_nick	= $one[0];
		//$excel_nick = iconv("utf-8", "euc-kr", $excel_nick);
		
		//echo $excel_nick;
		$respone["nick"] = $excel_nick;
		
	}
	
	
}

die(json_encode($respone));
?>