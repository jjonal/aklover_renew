<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

$mode = $_POST["mode"];
$success_num = 0;
$fail_num = 0;
if($mode == "adminCheck") {	
	
	for($i=0; $i<count($_POST["mission_url_idx"]); $i++) {
		
		$sql = " UPDATE mission_url SET admin_check = 'Y' WHERE hero_idx = '".$_POST["mission_url_idx"][$i]."' ";
		$result = sql($sql,"on");
	
		if($result) {
			$success_num++;
		} else {
			$fail_num++;
		}
	}

	$data["total"] = count($_POST["mission_url_idx"]);
	$data["success"] = $success_num;
	$data["fail"] = $fail_num;
	
	echo json_encode($data);	
	
} else if($mode == "adminCheckCancel") {
	for($i=0; $i<count($_POST["mission_url_idx"]); $i++) {
		$sql = " UPDATE mission_url SET admin_check = 'N' WHERE hero_idx = '".$_POST["mission_url_idx"][$i]."' ";
		$result = sql($sql,"on");
	
		if($result) {
			$success_num++;
		} else {
			$fail_num++;
		}
	}
	
	$data["total"] = count($_POST["mission_url_idx"]);
	$data["success"] = $success_num;
	$data["fail"] = $fail_num;
	
	echo json_encode($data);
	
} else if($mode == "message") {
	//�޼��� ���� �� ���� ���� �޴��� ���� �ʿ��մϴ�.
	
	$message_title = "";
	$message_type = $_POST["message_type"];
	//TODO �޼��� ���� �ʿ�
	if($message_type == "1") {
		$message_title = "���̵���� ���ؼ�";
		$type = "10007";
$msg = "AK LOVER ������ ".$_SESSION["temp_nick"]."�κ��� ���� ����!
�����Ͻ� ü��� ���̵���� ���ؼ��� ������û�帳�ϴ�.
		
�Ⱓ �� �̼��� �� ���Ƽ�� �ΰ��Ǵ�,
���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���!";
	} else if($message_type == "2") {
		$message_title = "�ı� �̵��";
		$type = "10005";
$msg = "AK LOVER ������ ".$_SESSION["temp_nick"]."�κ��� ���� ����!
��û�Ͻ� ü��� �ı� �̵�� �ȳ��帳�ϴ�.
		
���� ���Ƽ�� ����Ʈ�� �����Ǿ����� �ڼ��� ������ ���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���!";
	}
	
	for($i=0; $i<count($_POST["hero_idx"]); $i++) {
		$misison_review_sql  = " SELECT hero_id, concat(hero_hp_01,hero_hp_02, hero_hp_03) as hero_hp FROM mission_review ";
		$misison_review_sql .= " WHERE hero_idx = '".$_POST["hero_idx"][$i]."' ";
		$mission_review_res = sql($misison_review_sql,"on");
		$mission_review_rs = mysql_fetch_assoc($mission_review_res);
		
		if($mission_review_rs["hero_id"]) {
			$sql  = " INSERT INTO mail (hero_code, hero_table, hero_title, alrimtalk_type, hero_user  ";
			$sql .= " , hero_name, hero_nick, hero_today, hero_command, hero_use ";
			$sql .= " ) VALUES ( ";
			$sql .= " '".$_SESSION["temp_code"]."', 'mail', '".$message_title."', '".$message_type."', '".$mission_review_rs["hero_id"]."' ";
			$sql .= " ,'".$_SESSION["temp_name"]."' ,'".$_SESSION["temp_nick"]."', now(), '".$msg."','1') ";
			$result = sql($sql);
			//�˸���
			if($result) {
				$hero_idx_mail = mysql_insert_id();
				adminSendAlrimTalk($msg,$mission_review_rs["hero_hp"],$type,$hero_idx_mail,$mission_review_rs["hero_id"]);
			}
		}
		if($result) {
			$success_num++;
		} else {
			$fail_num++;
		}
	}
	
	$data["total"] = count($_POST["hero_idx"]);
	$data["success"] = $success_num;
	$data["fail"] = $fail_num;
	
	echo json_encode($data);
}
?>
                        	
                        