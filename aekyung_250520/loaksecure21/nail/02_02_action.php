<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

$mode = $_POST["mode"];
$success_num = 0;
$fail_num = 0;
if($mode == "best") {	
	$point = $_POST["point"];
	
	for($i=0; $i<count($_POST["hero_idx"]); $i++) {
		$result = false;
		$board_sql  = " SELECT b.hero_idx, b.hero_code, b.hero_01, b.hero_name ,b.hero_board_three ";
		$board_sql .= " , m.hero_id, m.hero_nick "; 
		$board_sql .= "	, (SELECT hero_title FROM mission WHERE hero_idx = b.hero_01) as mission_title ";
		$board_sql .= "	FROM board b ";
		$board_sql .= " INNER JOIN mission_url u ON b.hero_idx = u.board_hero_idx ";
		$board_sql .= " INNER JOIN member m ON b.hero_code = m.hero_code ";
		$board_sql .= " WHERE  b.hero_idx = '".$_POST["hero_idx"][$i]."' "; //�ıⰡ ����� �Ǿ� �־�� ��
		$board_res = sql($board_sql,"on");
		$board_rs = mysql_fetch_assoc($board_res);
		
		if($board_rs["hero_idx"] && ($board_rs["hero_board_three"] == "" || $board_rs["hero_board_three"] == "0")) {
			$sql = " UPDATE board SET hero_board_three = 1 WHERE hero_idx = '".$board_rs["hero_idx"]."' ";
			$result = sql($sql);
			
			//����Ʈ ����
			adminPoint($board_rs["hero_code"], '', 'adminGreatPost', '', $board_rs["hero_01"], '', $board_rs["hero_id"], $board_rs["mission_title"].' ����ı� ����', $board_rs["hero_name"], $board_rs["hero_nick"], $point, "N", '');
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
	
} else if($mode == "bestCancel") {
	$point = $_POST["point"];
	for($i=0; $i<count($_POST["hero_idx"]); $i++) {
		$result = false;
		$board_sql  = " SELECT b.hero_idx, b.hero_code, b.hero_01, b.hero_name, b.hero_board_three ";
		$board_sql .= " , m.hero_id, m.hero_nick ";
		$board_sql .= " , (SELECT hero_title FROM mission WHERE hero_idx = b.hero_01) as mission_title ";
		$board_sql .= " FROM board b ";
		$board_sql .= " INNER JOIN mission_url u ON b.hero_idx = u.board_hero_idx ";
		$board_sql .= " INNER JOIN member m ON b.hero_code = m.hero_code ";
		$board_sql .= " WHERE  b.hero_idx = '".$_POST["hero_idx"][$i]."' "; //�ıⰡ ����� �Ǿ� �־�� ��
		$board_res = sql($board_sql,"on");
		$board_rs = mysql_fetch_assoc($board_res);
		
		if($board_rs["hero_idx"] && $board_rs["hero_board_three"] == "1") {
			$sql = " UPDATE board SET hero_board_three = 0 WHERE hero_idx = '".$board_rs["hero_idx"]."' ";
			$result = sql($sql);
			
			//����Ʈ ����
			adminPoint($board_rs["hero_code"], '', 'adminGreatPostCancel', '', $board_rs["hero_01"], '', $board_rs["hero_id"], $board_rs["mission_title"].' ����ı� ���� ���', $board_rs["hero_name"], $board_rs["hero_nick"], $point, "N", 'minus');
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
	
} else if($mode == "thanks") {
	$point = $_POST["point"];
	
	for($i=0; $i<count($_POST["hero_idx"]); $i++) {
		$result = false;
		$sql  = " SELECT m.hero_id, m.hero_nick, m.hero_name, m.hero_code ";
		$sql .= " ,b.hero_idx, b.hero_01,  b.hero_board_three ";
		$sql .= " ,(SELECT hero_title FROM mission WHERE hero_idx = b.hero_01) as mission_title "; 
		$sql .= " FROM board b ";
		$sql .= " INNER JOIN member m ON b.hero_code = m.hero_code ";
		$sql .= " WHERE b.hero_idx = '".$_POST["hero_idx"][$i]."' "; //�ıⰡ ����� �Ǿ� �־�� ��
		$board_res = sql($sql,"on");
		$board_rs = mysql_fetch_assoc($board_res);
		
		if($board_rs["hero_idx"] && ($board_rs["hero_board_three"] == "" || $board_rs["hero_board_three"] == "0")) {
			$sql = " UPDATE board SET hero_board_three = 2 WHERE hero_idx = '".$board_rs["hero_idx"]."' ";
			$result = sql($sql);
			
			//����Ʈ  ����
			adminPoint($board_rs["hero_code"], '', 'adminThanksPoint', '', $board_rs["hero_01"], '', $board_rs["hero_id"], $board_rs["mission_title"].' ��������Ʈ', $board_rs["hero_name"], $board_rs["hero_nick"], $point, "N", '');
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
} else if($mode == "thanksCancel") {
	$point = $_POST["point"];
	
	for($i=0; $i<count($_POST["hero_idx"]); $i++) {
		$result = false;
		$sql  = " SELECT m.hero_id, m.hero_nick, m.hero_name, m.hero_code ";
		$sql .= " ,b.hero_idx, b.hero_01,  b.hero_board_three ";
		$sql .= " , (SELECT hero_title FROM mission WHERE hero_idx = b.hero_01) as mission_title ";
		$sql .= " FROM board b ";
		$sql .= " INNER JOIN member m ON b.hero_code = m.hero_code ";
		$sql .= " WHERE b.hero_idx = '".$_POST["hero_idx"][$i]."' "; //�ıⰡ ����� �Ǿ� �־�� ��
		$board_res = sql($sql,"on");
		$board_rs = mysql_fetch_assoc($board_res);
	
		if($board_rs["hero_idx"] && $board_rs["hero_board_three"] == "2") {
			$sql = " UPDATE board SET hero_board_three = 0 WHERE hero_idx = '".$board_rs["hero_idx"]."' ";
			$result = sql($sql);
				
			//����Ʈ
			adminPoint($board_rs["hero_code"], '', 'adminThanksPointCancel', '', $board_rs["hero_01"], '', $board_rs["hero_id"],$board_rs["mission_title"].' ��������Ʈ ���', $board_rs["hero_name"], $board_rs["hero_nick"], $point, "N", 'minus');
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
} else if($mode == "message") {
	//�޼��� ���� �� ���� ���� �޴��� ���� �ʿ��մϴ�.
	$mission_sql = " SELECT hero_title FROM mission WHERE hero_idx = '".$_POST["hero_mission_idx"]."' ";
	$mission_res = sql($mission_sql,"on");
	$mission_rs = mysql_fetch_assoc($mission_res);
	
	$mission_title = $mission_rs["hero_title"];
	
	$message_title = "";
	$alrimtalk_type = $_POST["alrimtalk_type"];
	
if($alrimtalk_type == "11") {
		$message_title = "���̵���� ���ؼ�";
		$type = "10014";
$msg = "ü��� �� : ".$mission_title."

AK LOVER ������ ".$_SESSION["temp_nick"]."�κ��� ���� ����!
�����Ͻ� ü��� ���̵���� ���ؼ��� ������û�帳�ϴ�.

�Ⱓ �� �̼��� �� ���Ƽ�� �ΰ��Ǵ�,
���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���!";

$alrimMsg = $msg;

	} else if($alrimtalk_type == "12") {
		$message_title = $mission_title." �ı� �̵�� �ȳ��帳�ϴ�.";
		$type = "10021";
$msg = "�ȳ��ϼ���.
AK LOVER �������Դϴ�.

".$mission_title." �ı� �̵������ 
���Ƽ�� �ΰ��Ǿ����� �˷��帳�ϴ�.

���� ���Ƽ�� ����Ʈ�� �����Ǿ�����,
���Ƽ ���� ���ǻ����� 1:1 �����͸� ���� ���� ��Ź�帳�ϴ�.

������ �帲.";

$alrimMsg = "AK LOVER ������  ".$_SESSION["temp_nick"]."�κ��� ���� ����!
".$mission_title." �ı� �̵�� �ȳ��帳�ϴ�.

���� ���Ƽ�� ����Ʈ�� �����Ǿ�����,
�ڼ��� ������ ���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���!";
	} else if($alrimtalk_type == "13") {
		$message_title = "�������� ���� ������";
		$type = "10015";
$msg = "ü��� �� : ".$mission_title."

AK LOVER ������ ".$_SESSION["temp_nick"]."�κ��� ���� ����!
��û�Ͻ� �������� ���� ������ �ȳ��帳�ϴ�.

���� ���Ƽ�� ����Ʈ�� �����Ǿ����� �ڼ��� ������
���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���!";

$alrimMsg = $msg;

	} else if($alrimtalk_type == "14") {	
		$message_title = "ǰ��/���� ������";
		$type = "10016";
$msg = "ü��� �� : ".$mission_title."

AK LOVER ������ ".$_SESSION["temp_nick"]."�κ��� ���� ����!
��û�Ͻ� ǰ��/���� ������ �ȳ��帳�ϴ�.

���� ���Ƽ�� ����Ʈ�� �����Ǿ����� �ڼ��� ������
���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���!";

$alrimMsg = $msg;

	} else if($alrimtalk_type == "15") {
		$message_title = $mission_title." ��� �ı� ������ ���ϵ帳�ϴ�!";
		$type = "10019";

$msg = "�ȳ��ϼ���.
AK LOVER �������Դϴ�.

".$mission_title."�� �������ּż� ����帮��,
����ı�� �����ǽ� ���� ���ϵ帳�ϴ�:)

����ı� ����Ʈ�� ���� ���޵Ǿ�����, Ȯ�� ��Ź�帳�ϴ�.

�����մϴ�:D";

$alrimMsg = "AK LOVER ������ ".$_SESSION["temp_nick"]."�κ��� ���� ����!
".$mission_title."�� ����ı�� �����ǽ� ���� ���ϵ帳�ϴ� :)

���������� �ı� �׻� ����帮��,
�ڼ��� ������ ���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���!
";
	} else if($alrimtalk_type == "16") {
		$message_title = $mission_title." ��������Ʈ �����ص�Ƚ��ϴ�!";
		$type = "10020";
		$thanksPoint = "500";
		
$msg = "�ȳ��ϼ���.
AK LOVER �������Դϴ�.

".$mission_title."�� ������ �ּż� �����մϴ�!

���̵���ε� �ʹ� �� �ؼ��� �ֽð�,
�ı⸦ �ʹ� �� �ۼ��� �ּż� ����Ʈ ".$thanksPoint."�� �����ص�Ƚ��ϴ�.

�׻� AK LOVER���� ü��ܿ� ������ ������ �ֽð�
�̷��� ���������� �ı� �����ּż� ����帳�ϴ�.

���� �Ϸ� ��������^^*";

$alrimMsg = "AK LOVER ������ ".$_SESSION["temp_nick"]."�κ��� ���� ����!
".$mission_title."�� ���� ��������Ʈ�� ���޵Ǿ����ϴ�.

���������� �ı� �׻� ����帮��,
�ڼ��� ������ ���� �ٷ� AK LOVER Ȩ������ �� �������� Ȯ�����ּ���!";
	}
	
	for($i=0; $i<count($_POST["hero_idx"]); $i++) {
		$board_sql  = " SELECT m.hero_id, m.hero_hp FROM board b";
		$board_sql .= " INNER JOIN member m ON b.hero_code = m.hero_code AND m.hero_use = 0 ";
		$board_sql .= " WHERE b.hero_idx = '".$_POST["hero_idx"][$i]."' ";
		$board_res = sql($board_sql,"on");
		$board_rs = mysql_fetch_assoc($board_res);
		
		if($board_rs["hero_id"]) {
			$sql  = " INSERT INTO mail (hero_code, hero_table, hero_title, alrimtalk_type, hero_user  ";
			$sql .= " , hero_name, hero_nick, hero_today, hero_command, hero_use ";
			$sql .= " ) VALUES ( ";
			$sql .= " '".$_SESSION["temp_code"]."', 'mail', '".$message_title."', '".$alrimtalk_type."', '".$board_rs["hero_id"]."' ";
			$sql .= " ,'".$_SESSION["temp_name"]."' ,'".$_SESSION["temp_nick"]."', now(), '".$msg."','1') ";
			$result = sql($sql);
			//�˸���
			if($result) {
				$hero_idx_mail = mysql_insert_id();
				adminSendAlrimTalk($alrimMsg,$board_rs["hero_hp"],$type,$hero_idx_mail,$board_rs["hero_id"]);
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
                        	
                        