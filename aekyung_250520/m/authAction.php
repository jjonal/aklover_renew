<? 
include_once "head.php";

if(!$_SESSION['temp_code']){
	error_historyBack("");
	exit;
}

if(!$_POST['param_r6'] || !$_POST['param_r5']){
	error_historyBack("");
	exit;
}

$ch_member_query = "select * from ";
$ch_member_query .= "(select count(*) from member where hero_code='".$_SESSION['temp_code']."' and hero_use=0) as A, ";
$ch_member_query .= "(select count(*) from member where hero_info_di='".$_POST['param_r5']."' and hero_info_ci='".$_POST['param_r6']."' and hero_use=0) as B";

$ch_member_res = new_sql($ch_member_query,$error,"on");

$ch_code_rs_01 = mysql_result($ch_member_res,0,0);
$ch_cidi_rs_02 = mysql_result($ch_member_res,0,1);

$time =	date("Y-m-d H:i:s");

if($ch_code_rs_01==0){
	logging_error($_SESSION['temp_code'], "가입된 정보가 존재하지 않습니다.", $time);
	error_historyBack("");
	exit;
}

if($ch_cidi_rs_02>0){
	error_location("이미 다른 아이디로 가입하셨습니다.","/m/main.php");
	exit;
}

$param_r2_01 = substr($_POST['param_r2'], '0', '4');//년
$param_r2_02 = substr($_POST['param_r2'], '4', '2');//월
$param_r2_03 = substr($_POST['param_r2'], '6', '2');//일

include_once $_SERVER['DOCUMENT_ROOT']."/classGathered/chAgeClass.php";
$chAgeClass = new chAgeClass($param_r2_01,$param_r2_02,$param_r2_03);
$age = $chAgeClass->countUniversalAge();
if((int)$age<15){
	error_location("만14세 미만은 가입하실 수 없습니다.","/m/main.php");
	exit;
}

$update_01 = array("hero_jumin","hero_sex","hero_login_ip","hero_info_type","hero_info_di","hero_info_ci","hero_name" );
$update_02 = array($_POST['param_r2'],$_POST['param_r3'],$_SERVER['REMOTE_ADDR'],$_POST['param_r4'],$_POST['param_r5'],$_POST['param_r6'],$_POST['param_r1']);

$update_set = "";

for ($i=0;$i<count($update_01);$i++){
	if($i==0)	$update_set .= $update_01[$i]."='".$update_02[$i]."'";
	else		$update_set .= ",".$update_01[$i]."='".$update_02[$i]."'";
}

$error = "AUTHACT_02";
$update_sql = "update member set ".$update_set." where hero_code='".$_SESSION['temp_code']."'";
$update_res = new_sql($update_sql,$error);

if((string)$update_res==$error){
	error_historyBack("");
	exit;
}

message("아이디 ".$_SESSION['temp_id']."님의 본인인증이 완료되었습니다.");

if($_SESSION["auth_returnUrl"]){
	$referer = $_SESSION["auth_returnUrl"];
	unset($_SESSION["auth_returnUrl"]);
	location($referer);
} else {
	location("/m/main.php");
}
exit;
?>