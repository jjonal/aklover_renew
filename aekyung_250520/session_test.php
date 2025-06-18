<?
define('_HEROBOARD_', TRUE);
@session_start();
include_once $_SERVER['DOCUMENT_ROOT'].'/freebest/head.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/freebest/hero.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/freebest/function.php';



db("aekyung");

$mode = $_GET["mode"];
$code = $_GET["code"];

//echo  "===".$_SESSION["temp_code"];
if($mode == "test1"){
	
	$sql = "select * from member where hero_code='".$code."' AND hero_use = 0 ";
	$sql_res = mysql_query($sql);
	
	$list_top = mysql_fetch_assoc($sql_res);//mysql_fetch_row
	if($list_top) {
		echo "로그인 성공 : ".$list_top['hero_name'];
		$_SESSION['temp_code'] 		=	 $list_top['hero_code'];
		$_SESSION['temp_id'] 		=	 $list_top['hero_id'];
		$_SESSION['temp_name']		=	 $list_top['hero_name'];
		$_SESSION['temp_nick'] 		=	 $list_top['hero_nick'];
		$_SESSION['temp_level'] 	=	 $list_top['hero_level'];
		$_SESSION['temp_write'] 	=	 $list_top['hero_write'];
		$_SESSION['temp_view'] 		=	 $list_top['hero_view'];
		$_SESSION['temp_update'] 	=	 $list_top['hero_update'];
		$_SESSION['temp_rev'] 		=	 $list_top['hero_rev'];
		$_SESSION["temp_loginTime"] = date("YmdHis");
	} else {
		echo "로그인 정보 없음";
	}
		
}

?>