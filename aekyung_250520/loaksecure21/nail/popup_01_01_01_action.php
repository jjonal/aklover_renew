<?php
define('_HEROBOARD_', TRUE);

include_once                                '../../freebest/head.php';
include                                    '../popupSessionCheck.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';

header('Content-Type: application/json;');

db();

$hero_old_idx 	= $_POST["hero_old_idx"];
$successCount = 0;

$data = array();

if ($_FILES["upload_excel"]['name'] == ''){
	$respone["success"]	= false;
	$respone["status"]		= "noFile";
}else {
	$UPLOAD_DIR 	=  $_SERVER["DOCUMENT_ROOT"]."/PHPExcel/upload/".date("Ymd")."/";
	
	if(!is_dir($UPLOAD_DIR)) mkdir($UPLOAD_DIR);
	
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

	for($i=1; $i< count($list); $i++){
		$hero_id = $list[$i][0];
		$hero_nick = $list[$i][1];
		
		$update_sql  = " UPDATE  mission_review SET lot_01 = 1 ";
		$update_sql .= " WHERE hero_old_idx='".$hero_old_idx."' AND hero_id = '".$hero_id."' ";
		
		sql($update_sql);
		
		if(mysql_affected_rows()) {
			$successCount++;
		}
	}

	$data["totalCount"] = count($list)-1;
	$data["successCount"] = $successCount;	
}  

die(json_encode($data));

?>