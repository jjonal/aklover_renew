<?php 
if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION['temp_code']){
	error_historyBack("");
	exit;
}

if(!$_POST['param_r6'] || !$_POST['param_r5']){
	error_historyBack("");
	exit;
}

//���� �ߺ� üũ
######################################################################################################################################################
$error = "AUTHACT_01";
$ch_member_query = "select * from ";
//member�� �����ϴ��� ����
$ch_member_query .= "(select count(*) from member where hero_code='".$_SESSION['temp_code']."' and hero_use=0) as A, ";
//�ٸ� ȸ���� ci, di ���� ����ϴ��� ����
$ch_member_query .= "(select count(*) from member where hero_info_di='".$_POST['param_r5']."' and hero_info_ci='".$_POST['param_r6']."' and hero_use=0) as B";

$ch_member_res = new_sql($ch_member_query,$error,"on");
if((string)$ch_member_res==$error){
	error_historyBack("");
	exit;
}

$ch_code_rs_01 = mysql_result($ch_member_res,0,0);
$ch_cidi_rs_02 = mysql_result($ch_member_res,0,1);

$time 								=	date("Y-m-d H:i:s");
if($ch_code_rs_01==0){
	logging_error($_SESSION['temp_code'], "code does not exist!", $time);
	error_historyBack("");
	exit;
}

if($ch_cidi_rs_02>0){
	error_location("�̹� �ٸ� ���̵�� �����ϼ̽��ϴ�.","/main/index.php");
	exit;
}

## ��������
#########################################################################################################################################
$param_r2_01 = substr($_POST['param_r2'], '0', '4');//��
$param_r2_02 = substr($_POST['param_r2'], '4', '2');//��
$param_r2_03 = substr($_POST['param_r2'], '6', '2');//��

include_once $_SERVER['DOCUMENT_ROOT']."/classGathered/chAgeClass.php";
$chAgeClass = new chAgeClass($param_r2_01,$param_r2_02,$param_r2_03);
$age = $chAgeClass->countUniversalAge();
if((int)$age<15){
	error_location("��14�� �̸��� �����Ͻ� �� �����ϴ�.","/main/index.php");
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

message("���̵� ".$_SESSION['temp_id']."���� ���������� �Ϸ�Ǿ����ϴ�.");
//location("/main/index.php");
//exit;

if($_SESSION["auth_returnUrl"]){
	$referer = $_SESSION["auth_returnUrl"];
	unset($_SESSION["auth_returnUrl"]);
	location($referer);
} else {
	location("/main/index.php");
}
exit;
?>
