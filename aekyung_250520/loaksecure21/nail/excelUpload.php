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
	
	$cnt = 0;
	$sql  = " SELECT hero_title  FROM mission ";
	$sql .= " WHERE hero_idx = '".$mission_idx."' ";
	sql($sql,"on");
	$mission_rs = mysql_fetch_assoc($out_sql);
	
	$mission_title = $mission_rs["hero_title"];
	
	for($i=0; $i< count($list); $i++){
		$one		= $list[$i];
		$excel_nick	= $one[0];	
		$excel_nick = iconv("utf-8", "euc-kr", $excel_nick);
		
		$sql = "SELECT hero_code, hero_nick, hero_name, hero_id FROM member WHERE hero_nick = '".$excel_nick."' ";
		$out_sql    = mysql_query($sql);
		$rs  = mysql_fetch_assoc($out_sql);
		
		$hero_id = $rs["hero_id"];
		$hero_name = $rs["hero_name"];
		$hero_nick = $rs["hero_nick"];
		$hero_top_title = "개인지급메뉴";
				
		if( !empty($rs) ) {

			if( !empty($mission_rs) ) {
				
				$sql  = " INSERT INTO point (hero_code, hero_table, hero_type, hero_old_idx, hero_mission_idx, hero_review_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, hero_use, point_change_chk, hero_ori_today) ";
				$sql .= " VALUES ";
				$sql .= " ('{$rs["hero_code"]}', 'user', 'excel', 0, {$mission_idx}, 0, '".$hero_id."', '".$hero_top_title."', '".addslashes($mission_title)."', '".$hero_name."', '".$hero_nick."', '{$point}',now(), 'N', 0, 'Y', now()) ";
				
				$result = mysql_query($sql);
				
				if( !$result ) {
					$respone["success"]	= false;
					$respone["status"]  = "insertError";
				}else {
					$cnt++;
					$respone["cnt"]		= $cnt;
				}
			} //end if mission_rs
				
		}//end if rs
	}//end for
	
}

die(json_encode($respone));
?>