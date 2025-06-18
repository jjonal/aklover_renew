<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mission_sql = " SELECT hero_title, hero_question_url_list, hero_question_url_yn  FROM mission WHERE hero_idx = ".$_GET['hero_idx'];
$mission_res = sql($mission_sql,"on");
$mission_rs = mysql_fetch_assoc($mission_res);

$filename = htmlspecialchars_decode($mission_rs["hero_title"]);
$hero_question_url_list =  $mission_rs["hero_question_url_list"];
$question_url_arr = explode("/////",$hero_question_url_list);

$sns_naver_url_check = "";
$sns_insta_url_check = "";
$sns_movie_url_check = "";
$sns_url_num = 0;
foreach($question_url_arr as $val) {
	if($val == "블로그") {
		$sns_naver_url_check = $sns_url_num;
	} else if($val == "인스타그램") {
		$sns_insta_url_check = $sns_url_num;
	} else if($val == "영상 채널") {
		$sns_movie_url_check = $sns_url_num;
	}
	$sns_url_num++;
}

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=\"".$filename."_신청자목록_".date("Ymd",time()).".xls\"" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$search = "";
if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

if(strlen($_GET["lot_01"]) > 0) {
	$search .= " AND  r.lot_01 = '".$_GET["lot_01"]."' ";
}

if($_GET["delivery_point"]) {
	if($_GET["delivery_point"]=="Y") {
		$search .= " AND  delivery_point > 0 ";
	} else if($_GET["delivery_point"]=="N") {
		$search .= " AND  (delivery_point = 0 || delivery_point is null) ";
	}
}
$sql  = " SELECT r.* FROM ";
$sql .= " (SELECT r.hero_idx, r.hero_new_name, r.hero_hp_01, r.hero_hp_02, r.hero_hp_03 ";
$sql .= " , r.lot_01, r.delivery_point_yn, r.hero_superpass, r.hero_today ";
$sql .= " , r.hero_address_01, r.hero_address_02 ";
$sql .= " , r.hero_address_03, r.hero_agree, r.hero_01 ";
$sql .= " , m.hero_id, m.hero_name, m.hero_nick, m.hero_jumin, m.hero_sex ";
$sql .= " , m.hero_level, m.hero_oldday, m.hero_mail ";
$sql .= " , m.hero_sns_update_date , m.hero_memo, m.hero_memo_01, m.hero_memo_01_image ";
$sql .= " , m.hero_insta_cnt, m.hero_insta_grade, m.hero_insta_image_grade ";
$sql .= " , m.hero_youtube_cnt, m.hero_youtube_view, m.hero_youtube_grade, m.hero_code ";
$sql .= " , (SELECT ifnull(sum(hero_order_point),0) FROM order_main WHERE hero_code=r.hero_code  AND hero_process = 'DE' AND mission_idx = r.hero_old_idx) AS delivery_point ";
$sql .= " FROM mission_review r ";
$sql .= " INNER JOIN member m ON r.hero_code = m.hero_code ";
$sql .= " WHERE m.hero_use=0 AND r.hero_old_idx='".$_GET['hero_idx']."') r WHERE 1=1 ".$search;
$sql .= " ORDER BY r.hero_idx DESC ";

$list_res = sql($sql);

//설문조사
$survey_cnt = 0;
$mission_survey_check_sql = " SELECT count(*) cnt FROM mission_survey WHERE mission_idx = '".$_GET['hero_idx']."' ";
$mission_survey_check_res = sql($mission_survey_check_sql);
$mission_survey_check_rs = mysql_fetch_assoc($mission_survey_check_res);
$survey_cnt = $mission_survey_check_rs["cnt"];

if($survey_cnt > 0) {
	$mission_survey_sql  = " SELECT questionType, title, necessary FROM mission_survey ";
	$mission_survey_sql .= " WHERE mission_idx = '".$_GET['hero_idx']."' ORDER BY order_num ASC ";
	$mission_survey_res = sql($mission_survey_sql);
}
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>번호</th>
	<th>카테고리</th>
	<th>제목</th>
	<th>이름</th>
	<th>받는이름</th>
	<th>아이디</th>
	<th>닉네임</th>
	<th>성별</th>
	<th>나이</th>
	<th>레벨</th>
	<th>가입일</th>
	<th>이메일</th>
	<th>받는 휴대폰번호</th>
	<th>받는 우편번호</th>
	<th>받는 주소</th>
	<th>퀄리티 업데이트 날짜</th>
	<th>블로그 URL</th>
	<th>블로그 방문자 수</th>
	<th>이미지 퀄리티</th>
	<th>텍스트 퀄리티</th>
	<th>인스타 URL</th>
	<th>인스타 팔로워 수</th>
	<th>이미지 퀄리티</th>
	<th>텍스트 퀄리티</th>
	<th>영상 채널 URL</th>
	<th>유튜브 구독자 수</th>
	<th>조회수</th>
	<th>콘텐츠 등급</th>

	
	<th>슈퍼패스</th>
	<th>배송비차감여부</th>
	<th>배송비</th>
	<th>콘텐츠 동의</th>
	<th>당첨여부</th>
	<th>패널티</th>
	<? 
	if($survey_cnt > 0) {
	while($mission_survey_list = mysql_fetch_assoc($mission_survey_res)) {
		$questionType_arr = array("1"=>"주관식","2"=>"단일 객관식","3"=>"복수 객관식");
		
	?>
		<th><? if($mission_survey_list["necessary"]=="Y") {?>
			(필수)
			<? } ?>
			<?=$mission_survey_list["title"]?>/<?=$questionType_arr[$mission_survey_list["questionType"]]?>
		</th>
	<? }
	}?>
	<th>등록일</th>
</tr>
<? 
$num = 1;
while($list = mysql_fetch_assoc($list_res)){
	$hero_sex_txt = $list["hero_sex"] == "1" ? "남":"여";
	$age = date("Y")-substr($list["hero_jumin"],0,4)+1;
	$hero_phone = $list["hero_hp_01"]."-".$list["hero_hp_02"]."-".$list["hero_hp_03"];
	$hero_superpass = "미사용";
	if($list["hero_superpass"]=="Y") $hero_superpass = "사용";
	
	$hero_question_url_yn_txt = "미사용";
	if($mission_rs["hero_question_url_yn"]=="Y") $hero_question_url_yn_txt = "사용";
	
	$hero_01_arr = explode(",",$list["hero_01"]); //url
	
	$lot_01_txt = "미당첨";
	
	if($list["lot_01"] == "1") $lot_01_txt = "당첨";
	
	//패널티
	$penalty_sql = " SELECT memo FROM member_penalty WHERE hero_use_yn = 'Y' AND hero_code = '".$list["hero_code"]."' ";
	$penalty_res = sql($penalty_sql);
	
	//설문조사
	if($survey_cnt > 0) {
		$mission_survey_answer_sql = " SELECT a.answer FROM mission_survey_answer a, mission_survey b WHERE a.mission_review_idx = '".$list["hero_idx"]."' AND a.survey_idx = b.hero_idx ORDER BY b.order_num ASC ";
		$mission_survey_answer_res = sql($mission_survey_answer_sql);
	}
?>
<tr>
	<td><?=$num?></td>
	<td>일반체험단</td>
	<td><?=$mission_rs["hero_title"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_new_name"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$hero_sex_txt?></td>
	<td><?=$age?></td>
	<td><?=$list["hero_level"]?></td>
	<td><?=substr($list["hero_oldday"],0,10)?></td>
	<td><?=$list["hero_mail"]?></td>
	<td><?=$hero_phone?></td>
	<td><?=$list["hero_address_01"]?></td>
	<td><?=$list["hero_address_02"]?> <?=$list["hero_address_03"]?></td>
	<td><?=$list["hero_sns_update_date"]?></td>
	<td>
		<? if(strlen($sns_naver_url_check) > 0) { ?>
			<?=$hero_01_arr[$sns_naver_url_check]?>
		<? } else { ?>
			미션 URL 선택 없음
		<? } ?>
	</td>
	<td><?=$list["hero_memo"]?></td>
	<td><?=$list["hero_memo_01_image"]?></td>
	<td><?=$list["hero_memo_01"]?></td>
	<td>
		<? if(strlen($sns_insta_url_check) > 0) { ?>
			<?=$hero_01_arr[$sns_insta_url_check]?>
		<? } else { ?>
			미션 URL 선택 없음
		<? } ?>
	</td>
	<td><?=$list["hero_insta_cnt"]?></td>
	<td><?=$list["hero_insta_image_grade"]?></td>
	<td><?=$list["hero_insta_grade"]?></td>
	<td>
		<? if(strlen($sns_movie_url_check) > 0) { ?>
			<?=$hero_01_arr[$sns_movie_url_check]?>
		<? } else { ?>
			미션 URL 선택 없음
		<? } ?>
	</td>
	<td><?=$list["hero_youtube_cnt"]?></td>
	<td><?=$list["hero_youtube_view"]?></td>
	<td><?=$list["hero_youtube_grade"]?></td>
	<td><?=$hero_superpass?></td>
	<td><?=$list["delivery_point_yn"]=="Y" ?"차감":"미차감"?></td>
	<td><?=$list["delivery_point"]?></td>
	<td><?=$list["hero_agree"]?></td>
	<td><?=$lot_01_txt?></td>
	<td>
		<? 
			$k = 0;
			while($penalty_list = mysql_fetch_assoc($penalty_res)) {
				$k++;
			?>
			<? if($k > 1) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$k?>) <?=$penalty_list["memo"]?>
		<? } ?>
	</td>
	<?
	if($survey_cnt > 0) {
		while($answer_list = mysql_fetch_assoc($mission_survey_answer_res)) {
	?>
		<td><?=$answer_list["answer"]?></td>	
	<? }
	}?>
	<td><?=substr($list["hero_today"],0,10)?></td>
</tr>
<? 
$num++;
} 
?>
</table>
                        	
                        
                        
                        
                        
                        