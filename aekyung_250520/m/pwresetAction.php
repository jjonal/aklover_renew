<?
define('_HEROBOARD_', TRUE);//HEROBOARD����

include_once '../freebest/head.php';
include_once                                                        $_SERVER['DOCUMENT_ROOT'].'/freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

$mode = $_POST["mode"];
$result = 0;
$id = $_POST["id"];
$auth = $_POST["auth"];
$result = 0;

if($mode == "pwreset" && $_POST['newPw'] && $_POST['chNewPw']) {	
	
	if($_POST['newPw'] != $_POST['chNewPw']) {
		error_historyBack("��й�ȣ�� ��й�ȣ Ȯ���� ��ġ���� �ʽ��ϴ�.");
		exit;
	}
	
	$sql = " SELECT hero_idx, hero_id, target_idx FROM reset_pw WHERE hero_id='".$id."' and  auth_code='".$auth."' and DATEDIFF(hero_date, now()) > -3 ";
	$res = sql($sql,"on");
	$rs  = mysql_fetch_assoc($res);
	
	if(!$rs["hero_idx"]) {
		error_historyBack("��ȿ�� ��й�ȣ ã�� ��û�� �ƴմϴ�.");
		exit;
	}
	
	//ȸ��Ȯ��
	$member_sql = " SELECT count(*) as cnt FROM member WHERE hero_idx = '".$rs["target_idx"]."' AND hero_use = 0 ";
	$member_res = sql($member_sql);
	$member_rs = mysql_fetch_assoc($member_res);
	
	if($member_rs["cnt"] == 0) {
		error_historyBack("ȸ�������� �������� �ʽ��ϴ�.");
		exit;
	}
	
	//��й�ȣ ����
	$pw_new = $_POST['chNewPw'];
	$pw_md5 = md5($pw_new);
	$temp = $pw_md5.$id;
	$pw_sha3_256 = sha3_hash('sha3-256', $temp);
	
	$update_sql = " UPDATE member SET hero_pw = '".$pw_sha3_256."' WHERE hero_idx = '".$rs["target_idx"]."' ";
	$result = sql($update_sql);
	
	//��й�ȣ ���� ��û ó��
	if($result) {
		$reset_update_sql = " UPDATE reset_pw set auth_code=NULL, reset_ip='".$_SERVER["REMOTE_ADDR"]."', reset_date=now() WHERE hero_idx=".$rs["hero_idx"];
		$result = sql($reset_update_sql);
	}
	
	if(!$result) {
		error_historyBack("��й�ȣ ���� �����߽��ϴ�.");
		exit;
	}
	message("��й�ȣ ����Ǿ����ϴ�.\\n�α��� �� �̿��� �ּ���.");
	location("/m/main.php");
	exit;
}

?>