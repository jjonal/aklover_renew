<?
define('_HEROBOARD_', TRUE);//HEROBOARD����

include_once '../freebest/head.php';
include_once                                                        $_SERVER['DOCUMENT_ROOT'].'/freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

$mode = $_POST["mode"];
$result = 0;

if($mode == "pwedit" && $_POST['pastPw'] && $_POST['newPw']) {	
	include_once $_SERVER['DOCUMENT_ROOT']."/classGathered/chPwClass.php";
	if(!$_SESSION['temp_code'])  {
		error_historyBack("�� ���� �����Դϴ�.");
		exit;
	}

	$chAndInputPwClass = new chAndInputPwClass($_POST['pastPw'],$_POST['newPw']);
	$result_chAndInputPw = $chAndInputPwClass->progressChPw();
	
	if($result_chAndInputPw!=1){
		if(mb_substr($result_chAndInputPw,0,7)=="message"){
			error_historyBack(mb_substr($result_chAndInputPw,8));
			exit;
		}elseif($result_chAndInputPw){
			error_historyBack("");
			exit;
		}
	}
	
	$location = "/m/pwedit.php?board=pwedit";
	message("��й�ȣ�� �����Ǿ����ϴ�.");
	location($location);
	exit;
}

?>