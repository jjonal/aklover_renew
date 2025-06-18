<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=회원정보_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$search = "";

if($_GET["hero_point_start"]) {
	$search .= " AND hero_point >= '".$_GET["hero_point_start"]."' ";
}

if($_GET["hero_point_end"]) {
	$search .= " AND hero_point <= '".$_GET["hero_point_start"]."' ";
}

if($_GET["hero_blog"]) {
	if($_GET["hero_blog"] == "1") {
		$search .= " AND  hero_blog_00 is not null  AND  hero_blog_00 != '' ";
	} else if($_GET["hero_blog"] == "2") {
		$search .= " AND  hero_blog_04 is not null  AND  hero_blog_04 != '' ";
	} else if($_GET["hero_blog"] == "3") {
		$search .= " AND  ((hero_blog_00 is not null  AND  hero_blog_00 != '') or (hero_blog_04 is not null  AND  hero_blog_04 != ''))  ";
	} else if($_GET["hero_blog"] == "4") {
		$search .= " AND  hero_blog_00 is not null  AND  hero_blog_00 != '' AND hero_blog_04 is not null  AND  hero_blog_04 != '' ";
	} else if($_GET["hero_blog"] == "5") {
		$search .= " AND  (hero_blog_03 is not null  AND  hero_blog_03 != '' AND hero_blog_06 is not null  AND  hero_blog_06 != ''  AND hero_blog_07 is not null  AND  hero_blog_07 != '' AND hero_blog_08 is not null  AND  hero_blog_08 != '' ) ";
	} else if($_GET["hero_blog"] == "6") {
	    $search .= " AND  hero_naver_influencer is not null  AND  hero_naver_influencer != '' ";
	}
}

if($_GET["hero_memo_01_image"]) {
	$search .= " AND hero_memo_01_image = '".$_GET["hero_memo_01_image"]."' ";
}

if($_GET["hero_memo_01"]) {
	$search .= " AND hero_memo_01 = '".$_GET["hero_memo_01"]."' ";
}

if($_GET["hero_insta_image_grade"]) {
	$search .= " AND hero_insta_image_grade = '".$_GET["hero_insta_image_grade"]."' ";
}

if($_GET["hero_insta_grade"]) {
	$search .= " AND hero_insta_grade = '".$_GET["hero_insta_grade"]."' ";
}

if($_GET["hero_youtube_grade"]) {
	$search .= " AND hero_youtube_grade = '".$_GET["hero_youtube_grade"]."' ";
}

if($_GET["hero_jumin"]) {
	$search .= " AND hero_jumin = '".$_GET["hero_jumin"]."' ";
}

if($_GET["hero_level_start"]) {
	$search .= " AND hero_level >= '".$_GET["hero_level_start"]."' ";
}

if($_GET["hero_level_end"]) {
	$search .= " AND hero_level <= '".$_GET["hero_level_end"]."' ";
}

if($_GET["hero_oldday_start"]) {
	$search .= " AND date_format(hero_oldday,'%Y-%m-%d') >= '".$_GET["hero_oldday_start"]."' ";
}

if($_GET["hero_oldday_end"]) {
	$search .= " AND date_format(hero_oldday,'%Y-%m-%d') <= '".$_GET["hero_oldday_end"]."' ";
}

if(strlen($_GET["hero_sex"]) > 0) {
	$search .= " AND hero_sex = '".$_GET["hero_sex"]."' ";
}

if($_GET["hero_age_start"]) {
	$birthYear = date("Y")-$_GET["hero_age_start"]+1;
	$search .= " AND substr(hero_jumin,1,4) <= '".$birthYear."' ";
}

if($_GET["hero_age_end"]) {
	$birthYear = date("Y")-$_GET["hero_age_end"]+1;
	$search .= " AND substr(hero_jumin,1,4) >= '".$birthYear."' ";
}

if($_GET["hero_chk_phone"]) {
	if($_GET["hero_chk_phone"] == "1") {
		$search .= " AND hero_chk_phone = '1' ";
	} else {
		$search .= " AND hero_chk_phone != '1' ";
	}
}

if($_GET["hero_chk_email"]) {
	if($_GET["hero_chk_email"] == "1") {
		$search .= " AND hero_chk_email = '1' ";
	} else {
		$search .= " AND hero_chk_email != '1' ";
	}
}

if($_GET["kewyword"]) {
	$search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}
$sql  = " SELECT *, (total_point - use_point) AS hero_point FROM ";
$sql .= " (SELECT m.hero_idx, m.hero_code, hero_id, hero_nick, hero_name, hero_jumin, hero_sex ";
$sql .= " , hero_oldday, hero_hp, hero_mail, hero_address_01, hero_address_02";
$sql .= " , hero_address_03, hero_chk_phone, hero_chk_email, area, area_etc_text ";
$sql .= " , m.hero_today, hero_level, hero_point, hero_user_type, hero_user ";
$sql .= " , hero_blog_00, hero_blog_04, hero_blog_03, hero_blog_05, hero_blog_06, hero_blog_07, hero_blog_08 ";
$sql .= " , hero_memo, hero_memo_01_image, hero_memo_01 , hero_insta_cnt, hero_insta_image_grade ";
$sql .= " , hero_insta_grade, hero_youtube_cnt, hero_youtube_grade, hero_youtube_view, hero_kakaoTalk, hero_naver, hero_google, hero_sns_update_date";
$sql .= " , hero_naver_influencer, hero_naver_influencer_name, hero_naver_influencer_category ";
$sql .= " , hero_qs_01, hero_qs_02, hero_qs_03, hero_qs_04, hero_qs_05 ";
$sql .= " , hero_qs_06, hero_qs_07, hero_qs_08 ";
$sql .= " , (SELECT ifnull(sum(hero_point),0) FROM point WHERE hero_code = m.hero_code) AS total_point ";
$sql .= " , (SELECT ifnull(sum(hero_order_point),0) FROM order_main WHERE hero_process != 'C' AND hero_code = m.hero_code) AS use_point ";
$sql .= " FROM member m LEFT JOIN member_question q ON m.hero_code = q.hero_code AND q.hero_pid = 4 ";
$sql .= " WHERE hero_use = 0 ".$search;
$sql .= " ) m ORDER BY m.hero_idx DESC  ";

$list_res = sql($sql,"on");

?>

<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>고유번호</th>
	<th>아이디</th>
	<th>이름</th>
	<th>닉네임</th>
	<th>나이</th>
	<th>성별</th>
	<th>생년월일</th>
	<th>가입일</th>
	<th>휴대폰번호</th>
	<th>이메일</th>
	<th>우편번호</th>
	<th>주소</th>
	<th>가입경로</th>
	<th>문자 수신여부</th>
	<th>이메일 수신여부</th>
	<th>최근 로그인 시간</th>
	<th>레벨</th>
	<th>가용 포인트</th>
	<th>퀄리티 업데이트</th>
	<th>네이버 블로그</th>
	<th>방문자 수</th>
	<th>이미지 퀄리티</th>
	<th>텍스트 퀄리티</th>
	<th>인스타그램</th>
	<th>팔로워 수</th>
	<th>이미지 퀄리티</th>
	<th>텍스트 퀄리티</th>
	<th>유튜브 URL</th>
	<th>구독자 수</th>
	<th>유튜브 조회수</th>
	<th>콘텐츠 등급</th>
	<th>기타 URL</th>
	<th>인플러언서 활동 카테고리</th>
	<th>인플루언서 명</th>
	<th>인플루언서 홈 URL</th>
	<th>네이버 TV</th>
	<th>틱톡</th>
	<th>기타(영상)</th>
	<th>개인 SNS URL 유/무</th>
	<th>결혼 유무</th>
	<th>자녀 유무</th>
	<th>자녀 수/태어난 년도</th>
	<th>AKLOVER에 가입한 이유</th>
	<th>AK LOVER외 활동하는 서포터즈/체험단 카페 또는 홈페이지</th>
	<th>패널티</th>
	<th>연동 계정 네이버</th>
	<th>연동 계정 카카오</th>
	<th>연동 계정 구글</th>
	<th>추천방법</th>
	<th>추천인</th>
</tr>
<? while($list = mysql_fetch_assoc($list_res)){
	$age = (date("Y")-substr($list["hero_jumin"],0,4))+1;
	$hero_sex_txt = "";
	if($list["hero_sex"] == 0) {
		$hero_sex_txt = "여";
	} else if($list["hero_sex"] == 1) {
		$hero_sex_txt = "남";
	}
	
	$hero_chk_phone_txt = $list["hero_chk_phone"] == "1" ? "수신":"미수신";
	$hero_chk_email_txt = $list["hero_chk_email"] == "1" ? "수신":"미수신";
	
	$hero_qs_01_txt = $list["hero_qs_01"] == "Y" ? "있음":"없음";
	$hero_qs_02_txt = $list["hero_qs_02"] == "Y" ? "기혼":"미혼";
	$hero_qs_03_txt = $list["hero_qs_03"] == "Y" ? "있음":"없음";
	$hero_qs_07_txt = $list["hero_qs_07"] == "Y" ? "있음":"없음";
	
	$hero_kakaoTalk_txt = $list["hero_kakaoTalk"] ? "연동":"";
	$hero_naver_txt = $list["hero_naver"] ? "연동":"";
	$hero_google_txt = $list["hero_google"] ? "연동":"";
	
	$hero_user_type_txt = "";
	if($list["hero_user_type"] == "hero_id") {
		$hero_user_type_txt = "아이디";
	} else if($list["hero_user_type"] == "hero_nick") {
		$hero_user_type_txt = "닉네임";
	}
	
	
	$penalty_sql = "SELECT memo FROM member_penalty WHERE hero_use_yn = 'Y' AND hero_code = '".$list["hero_code"]."' ";
	$penalty_res = sql($penalty_sql);
?>
<tr>
	<td><?=$list["hero_code"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$age?></td>
	<td><?=$hero_sex_txt?></td>
	<td><?=$list["hero_jumin"]?></td>
	<td><?=$list["hero_oldday"]?></td>
	<td><?=$list["hero_hp"]?></td>
	<td><?=$list["hero_mail"]?></td>
	<td><?=$list["hero_address_01"]?></td>
	<td><?=$list["hero_address_02"]?> <?=$list["hero_address_03"]?></td>
	<td><?=$list["area"]?>
		<?if($list["area"]=="기타") {?>
		(<?=$list["area_etc_text"]?>)
		<? } ?>
	</td>
	<td><?=$hero_chk_phone_txt?></td>
	<td><?=$hero_chk_email_txt?></td>
	<td><?=$list["hero_today"]?></td>
	<td><?=$list["hero_level"]?></td>
	<td><?=$list["hero_point"]?></td>
	<td><?=$list["hero_sns_update_date"]?></td>
	<td><?=$list["hero_blog_00"]?></td>
	<td><?=$list["hero_memo"]?></td>
	<td><?=$list["hero_memo_01_image"]?></td>
	<td><?=$list["hero_memo_01"]?></td>
	<td><?=$list["hero_blog_04"]?></td>
	<td><?=$list["hero_insta_cnt"]?></td>
	<td><?=$list["hero_insta_image_grade"]?></td>
	<td><?=$list["hero_insta_grade"]?></td>
	<td><?=$list["hero_blog_03"]?></td>
	<td><?=$list["hero_youtube_cnt"]?></td>
	<td><?=$list["hero_youtube_view"]?></td>
	<td><?=$list["hero_youtube_grade"]?></td>
	<td><?=$list["hero_blog_05"]?></td>
	
	<td><?=$list["hero_naver_influencer_category"]?></td>
	<td><?=$list["hero_naver_influencer_name"]?></td>
	<td><?=$list["hero_naver_influencer"]?></td>
	
	<td><?=$list["hero_blog_06"]?></td>
	<td><?=$list["hero_blog_07"]?></td>
	<td><?=$list["hero_blog_08"]?></td>
	<td><?=$hero_qs_01_txt?></td>
	<td><?=$hero_qs_02_txt?></td>
	<td><?=$hero_qs_03_txt?></td>
	<td>
		<? if($list["hero_qs_04"]) {
			$hero_qs_05_arr = explode(",",$list["hero_qs_05"]);
			$hero_qs_05_txt = "";
			foreach($hero_qs_05_arr as $val) {
				if($hero_qs_05_txt) $hero_qs_05_txt .= ", ";
				$hero_qs_05_txt .= $val;
			}
			
		?>
			<?=$list["hero_qs_04"]?>명/<?=$hero_qs_05_txt?>
		<? } ?>
	</td>
	<td><?=$list["hero_qs_06"]?></td>
	<td><?=$hero_qs_07_txt?>
		<? if($list["hero_qs_07"] == "Y") {?>
			(<?=$list["hero_qs_08"]?>)
		<? } ?>
	</td>
	<td>
		<? 
		  $penalty_num = 0; 
		  while($penalty_list = mysql_fetch_assoc($penalty_res)) {
		  	$penalty_num++;
		?>
			<?=$penalty_num?>) <?=$penalty_list["memo"]?><br style="mso-data-placement:same-cell;">
		<? } ?>
	</td>
	<td><?=$hero_naver_txt?></td>
	<td><?=$hero_kakaoTalk_txt?></td>
	<td><?=$hero_google_txt?></td>
	<td><?=$hero_user_type_txt?></td>
	<td><?=$list["hero_user"]?></td>
</tr>
<? } ?>
</table>

	