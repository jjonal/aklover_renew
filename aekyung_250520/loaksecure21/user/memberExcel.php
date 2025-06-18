<?php
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include                                '../../freebest/head.php';
include                                '../../freebest/function.php';


header( "Content-type: application/vnd.ms-excel;charset=euc-kr" ); 
header( "Content-Disposition: attachment; filename=회원데이터추출_".date("Ymd",time()).".xls" ); 
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

//검색기능

$mission_gubun = $_REQUEST["mission_gubun"];
$mission_title = $_REQUEST["mission_title"];
$mission_sel_option = $_REQUEST["mission_sel_option"];

if(strcmp($_REQUEST['keyword'], '')){
	$search1 .= ' and '.$_REQUEST['select'].'=\''.$_REQUEST['keyword'].'\' ';
}

if(strcmp($_REQUEST['hero_sex'], '')){
	$search1 .= ' and hero_sex=\''.$_REQUEST['hero_sex'].'\' ';
}

if(strcmp($_REQUEST['hero_blog_00'], '')){
	$search1 .= ' AND (hero_blog_00 is not null  and  length(hero_blog_00) > 0) ';
}

if(strcmp($_REQUEST['hero_blog_04'], '')){
	$search1 .= ' AND (hero_blog_04 is not null  and  length(hero_blog_04) > 0) ';
}

if(strcmp($_REQUEST['hero_chk_phone'], '')){
	if($_REQUEST['hero_chk_phone'] == "1") {
		$search1 .= ' AND hero_chk_phone = 1 ';
	} else if($_REQUEST['hero_chk_phone'] == "0") {
		$search1 .= ' AND hero_chk_phone != 1 ';
	}
	$search_next .= '&hero_chk_phone='.$_REQUEST['hero_chk_phone'];
}

if(strcmp($_REQUEST['hero_chk_email'], '')){
	if($_REQUEST['hero_chk_email'] == "1") {
		$search1 .= ' AND hero_chk_email = 1 ';
	} else if($_REQUEST['hero_chk_email'] == "0") {
		$search1 .= ' AND hero_chk_email != 1 ';
	}
	$search_next .= '&hero_chk_email='.$_REQUEST['hero_chk_email'];
}

if(strcmp($_REQUEST['hero_oldday_start'], '')){
	$search1 .= " AND date_format(hero_oldday,'%Y%m%d') >= ".$_REQUEST['hero_oldday_start'];
	$search_next .= '&hero_oldday_start='.$_REQUEST['hero_oldday_start'];
}

if(strcmp($_REQUEST['hero_oldday_end'], '')){
	$search1 .= " AND date_format(hero_oldday,'%Y%m%d') <= ".$_REQUEST['hero_oldday_end'];
	$search_next .= '&hero_oldday_end='.$_REQUEST['hero_oldday_end'];
}

if(strcmp($_REQUEST['hero_age_start'], '')){
	$search2 .= ' AND hero_age >= '.$_REQUEST['hero_age_start'];
}

if(strcmp($_REQUEST['hero_age_end'], '')){
	$search2 .= ' AND hero_age <= '.$_REQUEST['hero_age_end'];
}

if($mission_sel_option < 3 && $mission_sel_option) {
	$sql_join_search .= " INNER JOIN mission_review r ON m.hero_code = r.hero_code   ";
	$search2 .= " AND r.hero_use = 0 AND r.hero_old_idx = '".$mission_title."' ";
	if($mission_sel_option > 1) $search2 .= " AND r.lot_01 = 1 ";

} else if($mission_sel_option > 2 && $mission_sel_option){ //3부터 후기등록, 우수후기 게시판 확인
	$sql_join_search .= " INNER JOIN board b ON m.hero_code = b.hero_code   ";
	$search2 .= " AND  b.hero_01 = '".$mission_title."' ";

	if($mission_sel_option > 3) $search2 .= " AND b.hero_board_three = 1 ";
}

//페이지 리스트
$sql  = " SELECT m.hero_code, m.hero_id, m.hero_nick, m.hero_name, m.hero_hp, m.hero_oldday ";
$sql .= " , m.hero_chk_phone , m.hero_chk_email, m.hero_sex, m.hero_age ";
$sql .= " , m.hero_blog_00 , m.hero_blog_01 , m.hero_blog_02 , m.hero_blog_03 , m.hero_blog_04 , m.hero_blog_05, m.hero_blog_05_name ";
$sql .= " , m.hero_facebook, m.hero_kakaoTalk, m.hero_naver, m.hero_jumin, m.hero_mail, m.hero_address_01, m.hero_address_02, m.hero_address_03 ";
$sql .= " , m.hero_today, m.hero_vip, m.hero_level, m.hero_point, m.hero_insta_cnt, m.hero_memo, m.hero_memo_01, m.hero_memo_02 , m.hero_memo_03";
$sql .= " , m.hero_memo_04, m.hero_user, m.hero_superpass, m.area, m.area_etc_text, m.hero_chk_email_update, m.hero_terms_05";
$sql .= " , m.hero_pid, m.hero_qs_01, m.hero_qs_02, m.hero_qs_03, m.hero_qs_04, m.hero_qs_05, m.hero_qs_06, m.hero_qs_07, m.hero_qs_08";
$sql .= " , m.hero_qs_09, m.hero_qs_10, m.hero_qs_11, m.hero_qs_12, m.hero_gift_point, m.hero_today as qs_hero_today, m.hero_modi_today, m.hero_give_point_today ";
$sql .= " FROM ";
$sql .= " (SELECT m.hero_code, m.hero_id, m.hero_nick, m.hero_name, m.hero_hp , m.hero_oldday ";
$sql .= " , m.hero_blog_00 , m.hero_blog_01 , m.hero_blog_02 , m.hero_blog_03 , m.hero_blog_04 , m.hero_blog_05, m.hero_blog_05_name ";
$sql .= " , if(m.hero_facebook,'존재','미존재') as hero_facebook,  if(m.hero_kakaoTalk,'존재','미존재') as hero_kakaoTalk ,  if(m.hero_naver,'존재','미존재') as hero_naver ";
$sql .= " , m.hero_jumin ,m.hero_mail, m.hero_address_01, m.hero_address_02, m.hero_address_03 ";
$sql .= " , (case when m.hero_chk_phone = 1 then '수신' else '미수신' end) hero_chk_phone ";
$sql .= " , (case when m.hero_chk_email = 1 then '수신' else '미수신' end) hero_chk_email ";
$sql .= " , (case when m.hero_sex = 0 then '여성' else '남성' end) hero_sex ";
$sql .= " , (date_format(now(),'%Y') - left(m.hero_jumin,4) + 1) hero_age ";
$sql .= " , m.hero_today, if(m.hero_vip = 'Y','vip회원','') as hero_vip, m.hero_level, m.hero_point, m.hero_insta_cnt, m.hero_memo, m.hero_memo_01, m.hero_memo_02 , m.hero_memo_03 ";
$sql .= " , m.hero_memo_04, m.hero_user, m.hero_superpass, m.area, m.area_etc_text, m.hero_chk_email_update, m.hero_terms_05 ";
$sql .= " , q.hero_pid, q.hero_qs_01, q.hero_qs_02, q.hero_qs_03, q.hero_qs_04, q.hero_qs_05, q.hero_qs_06, q.hero_qs_07, q.hero_qs_08";
$sql .= " , q.hero_qs_09, q.hero_qs_10, q.hero_qs_11, q.hero_qs_12, q.hero_gift_point, q.hero_today as qs_hero_today, q.hero_modi_today, hero_give_point_today ";
$sql .= " FROM member m LEFT JOIN member_question q ON m.hero_code = q.hero_code AND q.hero_pid = '3' where m.hero_use=0 ".$search1.") m ";
$sql .= $sql_join_search;
$sql .= " WHERE 1=1 ".$search2. " order by hero_oldday desc ";

sql($sql,"on");

//이력남기기
$histroy_sql = " INSERT INTO member_excel_history (hero_id, hero_oldday) values ('".$_SESSION["temp_id"]."',now()) ";
mysql_query($histroy_sql);

?>
<style>
table td{mso-number-format:'\@'}
</style>
<table border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>고유코드</th>
	<th>아이디</th>
	<th>이름</th>
	<th>닉네임</th>
	<th>나이</th>
	<th>성별</th>
	<th>가입일</th>
    <th>휴대폰번호</th>
    <th>이메일</th>
    <th>블로그주소</th>
    
    <th>페이스북주소</th>
    <th>트위터주소</th>
    <th>카카오스토리 주소</th>
    <th>인스타주소</th>
    <th>그 외 SNS 이름</th>
    <th>그 외 SNS URL</th>
    <th>문자수신여부</th>
    <th>이메일수신여부</th>
    <th>로그인 페이스북 계정</th>
    <th>로그인 카카오 계정</th>
    
    <th>로그인 네이버 계정</th>
    <th>생년월일</th>
    <th>우편번호</th>
    <th>주소1</th>
    <th>상세주소</th>
    <th>최근 로그인 시간</th>
    <th>vip</th>
    <th>레빌</th>
    <th>포인트</th>
    <th>인스타팔로워수</th>
    
    <th>블로그 방문자 수</th>
    <th>블로그 콘텐츠 등급</th>
    <th>패널티 내용1</th>
    <th>패널티 내용2</th>
    <th>패널티 내용3</th>
    <th>추천인</th>
    <th>알게된 경로</th>
    <th>알게된 경로 기타</th>
    <th>이메일 수신 거부한 날짜</th>
    
    <th>추가 입력 포인트 지급</th>
    <th>추가 입력 회차</th>
    <th>일주일에 컨텐츠를 평균 몇 개 업로드 하시나요?</th>
    <th>운영 중인 블로그의 평균 일 방문자는 몇 명인가요?</th>
    <th>블로그 타입(※ 중복 선택 가능) </th>
    <th>결혼 유무</th>
    <th>자녀 유무</th>
    <th>자녀수 입력</th>
    <th>자녀 연령대 (, 구분)</th>
    <th>AK에 가입한 이유</th>
    
    <th>애경 외 활동하는 서포터즈 유무</th>
    <th>애경 외 활동하는 서포터즈 상세</th>
    <th>개인 URL 유무</th>
    <th>운영중인 블로그 유무</th>
    <th>설문 후 증정 포인트</th>
    <th>설문 입력일</th>
    <th>설문 수정일</th>
    <th>선물 포인트 지급일</th>
</tr>
<? while($list = @mysql_fetch_assoc($out_sql)){?>
<tr>
	<td><?=$list['hero_code'];?></td>
	<td><?=$list['hero_id'];?></td>
	<td><?=$list['hero_name'];?></td>
	<td><?=$list['hero_nick'];?></td>
	<td><?=$list['hero_age'];?></td>
	<td><?=$list['hero_sex'];?></td>
	<td><?=$list['hero_oldday'];?></td>
	<td><?=$list['hero_hp'];?></td>
	<td><?=$list['hero_mail'];?></td>
	<td><?=$list['hero_blog_00'];?></td>
	
	<td><?=$list['hero_blog_01'];?></td>
	<td><?=$list['hero_blog_02'];?></td>
	<td><?=$list['hero_blog_03'];?></td>
	<td><?=$list['hero_blog_04'];?></td>
	<td><?=$list['hero_blog_05_name'];?></td>
	<td><?=$list['hero_blog_05'];?></td>
	<td><?=$list['hero_chk_phone'];?></td>
	<td><?=$list['hero_chk_email'];?></td>
	<td><?=$list['hero_facebook'];?></td>
	<td><?=$list['hero_kakaoTalk'];?></td>
	
	<td><?=$list['hero_naver'];?></td>
	<td><?=$list['hero_jumin'];?></td>
	<td><?=$list['hero_address_01'];?></td>
	<td><?=$list['hero_address_02'];?></td>
	<td><?=$list['hero_address_03'];?></td>
	<td><?=$list['hero_today'];?></td>
	<td><?=$list['hero_vip'];?></td>
	<td><?=$list['hero_level'];?></td>
	<td><?=$list['hero_point'];?></td>
	<td><?=$list['hero_insta_cnt'];?></td>
	
	<td><?=$list['hero_memo'];?></td>
	<td><?=$list['hero_memo_01'];?></td>
	<td><?=$list['hero_memo_02'];?></td>
	<td><?=$list['hero_memo_03'];?></td>
	<td><?=$list['hero_memo_04'];?></td>
	<td><?=$list['hero_user'];?></td>
	<td><?=$list['area'];?></td>
	<td><?=$list['area_etc_text'];?></td>
	<td><?=$list['hero_chk_email_update'];?></td>
	
	<td><?=$list['hero_terms_05'];?></td>
	<td><?=$list['hero_pid'];?></td>
	<td><?=$list['hero_qs_01'];?></td>
	<td><?=$list['hero_qs_02'];?></td>
	<td><?=$list['hero_qs_03'];?></td>
	<td><?=$list['hero_qs_04'];?></td>
	<td><?=$list['hero_qs_05'];?></td>
	<td><?=$list['hero_qs_11'];?></td>
	<td><?=$list['hero_qs_12'];?></td>
	<td><?=$list['hero_qs_06'];?></td>
	
	<td><?=$list['hero_qs_07'];?></td>
	<td><?=$list['hero_qs_08'];?></td>
	<td><?=$list['hero_qs_09'];?></td>
	<td><?=$list['hero_qs_10'];?></td>
	<td><?=$list['hero_gift_point'];?></td>
	<td><?=$list['qs_hero_today'];?></td>
	<td><?=$list['hero_modi_today'];?></td>
	<td><?=$list['hero_give_point_today'];?></td>
</tr>
<? } ?>
</table>
