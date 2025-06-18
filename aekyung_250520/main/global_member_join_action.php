<!Doctype html>
<?
define('_HEROBOARD_', TRUE);

include_once                                                        '../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] != "9999") {
	message("이용 권한이 없습니다..","");
	exit;
}


require_once $_SERVER["DOCUMENT_ROOT"]."/PHPExcel/PHPExcel.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/PHPExcel/PHPExcel/IOFactory.php";

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

db();

$result = false;

$hero_country = "ru";
$hero_level = "1";
$hero_use = 0;
$hero_admin_yn = "N";

for($i=0; $i< count($list); $i++){
	$hero_nick = $list[$i][0];
	$hero_id = $list[$i][1];
	$hero_pw = $list[$i][2];
	$hero_name = $list[$i][3];
	$hero_jumin = str_replace("-","",$list[$i][4]);
	$hero_mail = $list[$i][5];
	$hero_hp = $list[$i][6];
	$hero_motive = $list[$i][7];
	$hero_insta = $list[$i][8];
	$hero_insta_cnt = $list[$i][9];
	$hero_youtube = out($list[$i][10]);
	$hero_vk = out($list[$i][11]);
	$hero_etc = out($list[$i][12]);
	$hero_remark = $list[$i][13];
	
	$sql = " SELECT count(*) cnt FROM global_member WHERE hero_id = '".$hero_id."' ";
	$res = sql($sql);
	$rs = mysql_fetch_assoc($res);
	$cnt = $rs["cnt"];
	
	if($cnt == 0) {
	    $pw_md5 = md5($hero_pw);
	    $temp = $pw_md5.$hero_id;
	    $pw_sha3_256 = sha3_hash('sha3-256', $temp);
	    
		$insert_sql  = " INSERT INTO global_member (hero_country, hero_level, hero_id, hero_pw, hero_name  ";
		$insert_sql .= " , hero_nick, hero_jumin, hero_mail, hero_hp, hero_motive ";
		$insert_sql .= " , hero_insta, hero_insta_cnt, hero_youtube, hero_vk, hero_etc ";
		$insert_sql .= " , hero_remark, hero_oldday, hero_use ";
		$insert_sql .= " , hero_admin_yn) VALUES ";
		$insert_sql .= " ('".$hero_country."','".$hero_level."','".$hero_id."','".$pw_sha3_256."', '".$hero_name."' ";
		$insert_sql .= " ,'".$hero_nick."','".$hero_jumin."','".$hero_mail."','".$hero_hp."', '".$hero_motive."' ";
		$insert_sql .= " ,'".$hero_insta."','".$hero_insta_cnt."', '".$hero_youtube."', '".$hero_vk."', '".$hero_etc."' ";
		$insert_sql .= " ,'".$hero_remark."',now(), '".$hero_use."' ";
		$insert_sql .= " ,'".$hero_admin_yn."') ";
	

		$result = sql(out($insert_sql));
		
		if($result) {
			$successCount++;
		} else {
			echo out($insert_sql)."<Br/>";
		}
		
	}

}

echo "총=".count($list);
echo "성공=".$successCount."<br/>";
?>