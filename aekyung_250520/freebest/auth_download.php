<?
define('_HEROBOARD_', TRUE);//HEROBOARD오픈

include_once './head.php';
include_once FREEBEST_INC_END.'function.php';

$authCheck = false;
$hero_level = $_SESSION["temp_level"];
$hero_idx = $_GET["hero_idx"];
$type = $_GET["type"];
$column = $_GET["column"];
$download = $_GET['download'];
$db_column = "";
$filename= "";


//group_04_06,  group_04_27, group_04_28 나중에 문자열로 찾기 위해서 작성
if($type == "mission") {

	if($column == "guide1") {
		$db_column = "guide_file";
	} else if($column == "guide2") {
		$db_column = "guide_file2";
	} else if($column == "guide3") {
	    $db_column = "guide_file3";
	}

	$sql = " SELECT ".$db_column.", hero_table, hero_type FROM mission WHERE hero_idx = '".$hero_idx."' ";
	$res = sql($sql, "on");
	$rs = mysql_fetch_assoc($res);
	$filename = $rs[$db_column];

	if($rs["hero_table"] == "group_04_05" || $rs["hero_type"] == "7") {
		if($filename) {
			$auth_sql = " SELECT lot_01 FROM mission_review WHERE hero_old_idx =  '".$hero_idx."' AND hero_code = '".$_SESSION["temp_code"]."' ";
			$auth_res = sql($auth_sql);
			$auth_rs = mysql_fetch_assoc($auth_res);

			if($auth_rs["lot_01"] == "1" || $rs["hero_type"] == "2") $authCheck = true; //25.02.25 체험단타임이 소문내기 일 경우 조건 추가
			
		}
	} else { //포커스 그룹
		if($rs["hero_table"] == "group_04_06") {
			if($hero_level == "9996") $authCheck = true;
		} else if($rs["hero_table"] == "group_04_28") {
			if($hero_level == "9994") $authCheck = true;
		} else if($rs["hero_table"] == "group_04_27") {
			if($hero_level == "9995") $authCheck = true;
			if($hero_level == "9993") $authCheck = true;
		}
	}
} else if($type == "globalMission") {

	if($column == "guide1") {
		$db_column = "guide_file1";
	} else if($column == "guide2") {
		$db_column = "guide_file2";
	} else if($column == "guide3") {
	    $db_column = "guide_file3";
	}

	$sql = " SELECT ".$db_column." , hero_country FROM global_mission WHERE hero_idx = '".$hero_idx."' AND hero_use_yn = 'Y' ";
	$res = sql($sql, "on");
	$rs = mysql_fetch_assoc($res);
	$filename = $rs[$db_column];

	$member_sql = " SELECT hero_country , hero_admin_yn FROM global_member WHERE hero_use = 0 AND hero_code = '".$_SESSION["global_code"]."' ";
	$member_res = sql($member_sql);
	$member_rs = mysql_fetch_assoc($member_res);

	if($member_rs["hero_admin_yn"] == "Y") {
		$authCheck = true;
	} else if($member_rs["hero_country"] == $rs["hero_country"]) {
		$authCheck = true;
	}
}

if($hero_level == "9999" or $authCheck) {
	$folder = "../user/file/";

	if($type == "mission") {
		if($hero_idx == "2187" || $hero_idx == "2186" || $hero_idx == "2185") {
			$folder = "../user/guide/";
		}

		if($hero_idx == "2190" || $hero_idx == "2199") {
			$folder = "../user/guide/";
		}

		if($hero_idx == "2201" || $hero_idx == "2176") {
			$folder = "../user/guide/";
		}

		if($hero_idx == "1151" || $hero_idx == "1055") {
			$folder = "../user/guide/";
		}

	}

	ob_start();
	$filesize = 1024*1024*2;

	if(eregi("(MSIE 5.0|MSIE 5.1|MSIE 5.5|MSIE 6.0|MSIE 7|MSIE 8|MSIE 9|MSIE 10|Trident/7.0)",$_SERVER["HTTP_USER_AGENT"])){

		//$filenames = iconv("UTF-8","CP949", $filename);
		$file_all = $folder.$filename;
		if (!is_file($file_all)) {
			die('File download error.'.$filename);
		}


		$mime = array('application/octet-stream');
		header('Content-Type: '.$mime);
		header("Content-Disposition: attachment; filename=".$download);
		header('Content-Transfer-Encoding: binary');
		header("Content-Length: ".filesize($filesize));
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header("Content-Description: File Transfer");
		header('Expires: 0');

	}else{

		$file_all = $folder.$filename;

		if (!is_file($file_all)) {
			die('File download error.'.$filename);
		}

		header("Content-Type: doesn/matter");
		header("Content-Disposition: attachment; filename=".$download);
		header("Content-Length: ".filesize($file_all));
		header("Content-Description: PHP3 Generated Data");
		header("Cache-Control: cache, must-revalidate");

		header("Content-Description: File Transfer");
		header("Pragma: no-cache");
		header("Expires: 0");
	}

	$fp = fopen($file_all, 'rb');
	while(!feof($fp)) {
		echo fread($fp, 100*1024);
		flush();
	}
	fclose ($fp);

} else {
	echo "올바른 경로를 이용해 주세요.";
}
?>
