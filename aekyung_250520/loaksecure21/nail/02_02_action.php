<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

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
		$board_sql .= " WHERE  b.hero_idx = '".$_POST["hero_idx"][$i]."' "; //후기가 등록이 되어 있어야 함
		$board_res = sql($board_sql,"on");
		$board_rs = mysql_fetch_assoc($board_res);
		
		if($board_rs["hero_idx"] && ($board_rs["hero_board_three"] == "" || $board_rs["hero_board_three"] == "0")) {
			$sql = " UPDATE board SET hero_board_three = 1 WHERE hero_idx = '".$board_rs["hero_idx"]."' ";
			$result = sql($sql);
			
			//포인트 지급
			adminPoint($board_rs["hero_code"], '', 'adminGreatPost', '', $board_rs["hero_01"], '', $board_rs["hero_id"], $board_rs["mission_title"].' 우수후기 혜택', $board_rs["hero_name"], $board_rs["hero_nick"], $point, "N", '');
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
		$board_sql .= " WHERE  b.hero_idx = '".$_POST["hero_idx"][$i]."' "; //후기가 등록이 되어 있어야 함
		$board_res = sql($board_sql,"on");
		$board_rs = mysql_fetch_assoc($board_res);
		
		if($board_rs["hero_idx"] && $board_rs["hero_board_three"] == "1") {
			$sql = " UPDATE board SET hero_board_three = 0 WHERE hero_idx = '".$board_rs["hero_idx"]."' ";
			$result = sql($sql);
			
			//포인트 차감
			adminPoint($board_rs["hero_code"], '', 'adminGreatPostCancel', '', $board_rs["hero_01"], '', $board_rs["hero_id"], $board_rs["mission_title"].' 우수후기 혜택 취소', $board_rs["hero_name"], $board_rs["hero_nick"], $point, "N", 'minus');
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
		$sql .= " WHERE b.hero_idx = '".$_POST["hero_idx"][$i]."' "; //후기가 등록이 되어 있어야 함
		$board_res = sql($sql,"on");
		$board_rs = mysql_fetch_assoc($board_res);
		
		if($board_rs["hero_idx"] && ($board_rs["hero_board_three"] == "" || $board_rs["hero_board_three"] == "0")) {
			$sql = " UPDATE board SET hero_board_three = 2 WHERE hero_idx = '".$board_rs["hero_idx"]."' ";
			$result = sql($sql);
			
			//포인트  지급
			adminPoint($board_rs["hero_code"], '', 'adminThanksPoint', '', $board_rs["hero_01"], '', $board_rs["hero_id"], $board_rs["mission_title"].' 감사포인트', $board_rs["hero_name"], $board_rs["hero_nick"], $point, "N", '');
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
		$sql .= " WHERE b.hero_idx = '".$_POST["hero_idx"][$i]."' "; //후기가 등록이 되어 있어야 함
		$board_res = sql($sql,"on");
		$board_rs = mysql_fetch_assoc($board_res);
	
		if($board_rs["hero_idx"] && $board_rs["hero_board_three"] == "2") {
			$sql = " UPDATE board SET hero_board_three = 0 WHERE hero_idx = '".$board_rs["hero_idx"]."' ";
			$result = sql($sql);
				
			//포인트
			adminPoint($board_rs["hero_code"], '', 'adminThanksPointCancel', '', $board_rs["hero_01"], '', $board_rs["hero_id"],$board_rs["mission_title"].' 감사포인트 취소', $board_rs["hero_name"], $board_rs["hero_nick"], $point, "N", 'minus');
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
	//메세지 수정 시 쪽지 관리 메뉴도 수정 필요합니다.
	$mission_sql = " SELECT hero_title FROM mission WHERE hero_idx = '".$_POST["hero_mission_idx"]."' ";
	$mission_res = sql($mission_sql,"on");
	$mission_rs = mysql_fetch_assoc($mission_res);
	
	$mission_title = $mission_rs["hero_title"];
	
	$message_title = "";
	$alrimtalk_type = $_POST["alrimtalk_type"];
	
if($alrimtalk_type == "11") {
		$message_title = "가이드라인 미준수";
		$type = "10014";
$msg = "체험단 명 : ".$mission_title."

AK LOVER 관리자 ".$_SESSION["temp_nick"]."로부터 쪽지 도착!
참여하신 체험단 가이드라인 미준수로 수정요청드립니다.

기간 내 미수정 시 페널티가 부과되니,
지금 바로 AK LOVER 홈페이지 내 쪽지함을 확인해주세요!";

$alrimMsg = $msg;

	} else if($alrimtalk_type == "12") {
		$message_title = $mission_title." 후기 미등록 안내드립니다.";
		$type = "10021";
$msg = "안녕하세요.
AK LOVER 관리자입니다.

".$mission_title." 후기 미등록으로 
페널티가 부과되었음을 알려드립니다.

금일 페널티로 포인트가 차감되었으며,
페널티 관련 문의사항은 1:1 고객센터를 통해 문의 부탁드립니다.

관리자 드림.";

$alrimMsg = "AK LOVER 관리자  ".$_SESSION["temp_nick"]."로부터 쪽지 도착!
".$mission_title." 후기 미등록 안내드립니다.

금일 페널티로 포인트가 차감되었으며,
자세한 내용은 지금 바로 AK LOVER 홈페이지 내 쪽지함을 확인해주세요!";
	} else if($alrimtalk_type == "13") {
		$message_title = "오프라인 모임 미참여";
		$type = "10015";
$msg = "체험단 명 : ".$mission_title."

AK LOVER 관리자 ".$_SESSION["temp_nick"]."로부터 쪽지 도착!
신청하신 오프라인 모임 미참여 안내드립니다.

금일 페널티로 포인트가 차감되었으며 자세한 내용은
지금 바로 AK LOVER 홈페이지 내 쪽지함을 확인해주세요!";

$alrimMsg = $msg;

	} else if($alrimtalk_type == "14") {	
		$message_title = "품평/설문 미진행";
		$type = "10016";
$msg = "체험단 명 : ".$mission_title."

AK LOVER 관리자 ".$_SESSION["temp_nick"]."로부터 쪽지 도착!
신청하신 품평/설문 미진행 안내드립니다.

금일 페널티로 포인트가 차감되었으며 자세한 내용은
지금 바로 AK LOVER 홈페이지 내 쪽지함을 확인해주세요!";

$alrimMsg = $msg;

	} else if($alrimtalk_type == "15") {
		$message_title = $mission_title." 우수 후기 선정을 축하드립니다!";
		$type = "10019";

$msg = "안녕하세요.
AK LOVER 관리자입니다.

".$mission_title."을 진행해주셔서 감사드리며,
우수후기로 선정되신 것을 축하드립니다:)

우수후기 포인트가 금일 지급되었으니, 확인 부탁드립니다.

감사합니다:D";

$alrimMsg = "AK LOVER 관리자 ".$_SESSION["temp_nick"]."로부터 쪽지 도착!
".$mission_title."에 우수후기로 선정되신 것을 축하드립니다 :)

정성스러운 후기 항상 감사드리며,
자세한 내용은 지금 바로 AK LOVER 홈페이지 내 쪽지함을 확인해주세요!
";
	} else if($alrimtalk_type == "16") {
		$message_title = $mission_title." 감사포인트 지급해드렸습니다!";
		$type = "10020";
		$thanksPoint = "500";
		
$msg = "안녕하세요.
AK LOVER 관리자입니다.

".$mission_title."에 참여해 주셔서 감사합니다!

가이드라인도 너무 잘 준수해 주시고,
후기를 너무 잘 작성해 주셔서 포인트 ".$thanksPoint."점 지급해드렸습니다.

항상 AK LOVER에서 체험단에 열심히 참여해 주시고
이렇게 정성스러운 후기 남겨주셔서 감사드립니다.

좋은 하루 보내세요^^*";

$alrimMsg = "AK LOVER 관리자 ".$_SESSION["temp_nick"]."로부터 쪽지 도착!
".$mission_title."에 대한 감사포인트가 지급되었습니다.

정성스러운 후기 항상 감사드리며,
자세한 내용은 지금 바로 AK LOVER 홈페이지 내 쪽지함을 확인해주세요!";
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
			//알림톡
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
                        	
                        