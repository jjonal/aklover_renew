<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mission_sql = " SELECT hero_title, hero_question_url_list, hero_table  FROM mission WHERE hero_idx = ".$_GET['hero_idx'];
$mission_res = sql($mission_sql,"on");
$mission_rs = mysql_fetch_assoc($mission_res);

$category = "";
if($mission_rs["hero_table"]=="group_04_06") {
	$category = "뷰티클럽";
} else if($mission_rs["hero_table"]=="group_04_27") {
	$category = "뷰티/라이프 클럽 영상팀";
} else if($mission_rs["hero_table"]=="group_04_28") {
	$category = "라이프클럽";
}

$filename = htmlspecialchars_decode($mission_rs["hero_title"]);

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=".$filename."_후기등록_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$search = "";

if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

//리스트
$sql  = " SELECT * FROM ( ";
$sql .= " SELECT b.hero_idx ,b.hero_today, b.hero_agree ";
$sql .= " , b.hero_board_three, b.akbeauty_id, b.hero_code, b.hero_product_review ";
$sql .= " , m.hero_hp , m.hero_address_01, m.hero_address_02, m.hero_address_03 ";
$sql .= " , m.hero_id, m.hero_name, m.hero_nick, m.hero_jumin, m.hero_mail ";
$sql .= " , m.hero_sns_update_date, m.hero_memo, m.hero_memo_01, m.hero_memo_01_image ";
$sql .= " , m.hero_insta_cnt, m.hero_insta_grade, m.hero_insta_image_grade ";
$sql .= " , m.hero_youtube_cnt, m.hero_youtube_grade, m.hero_youtube_view ";
$sql .= " , m.hero_sex, m.hero_level, m.hero_oldday, m.hero_blog_00, m.hero_blog_03 ";
$sql .= " , m.hero_blog_04";
$sql .= " , sum(if(u.url is not null || u.url != 0,'1','0')) as url_cnt ";
$sql .= " FROM board b ";
$sql .= " INNER JOIN member m ON b.hero_code = m.hero_code ";
$sql .= " LEFT JOIN mission_url u ON b.hero_idx = u.board_hero_idx ";
$sql .= " WHERE m.hero_use=0 AND b.hero_01='".$_GET['hero_idx']."' ";
$sql .= " GROUP BY b.hero_code ORDER BY b.hero_today DESC ) b WHERE 1=1 ".$search;
$list_res = sql($sql);

?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>번호</th>
	<th>후기등록</th>
	<th>카테고리</th>
	<th>체험단명</th>
	<th>이름</th>
	<th>아이디</th>
	<th>닉네임</th>
	<th>성별</th>
	<th>나이</th>
	<th>레벨</th>
	<th>가입일</th>
	<th>이메일</th>
	<th>휴대폰번호</th>
	<th>우편번호</th>
	<th>주소</th>
	<th>네이버 블로그 URL</th>
	<th>인스타그램 URL</th>
	<th>후기(영상) URL</th>
	<th>카페 URL</th>
	<th>기타 URL</th>
	<th>후기등록일</th>
</tr>
<? 
$num = 1;
while($list = mysql_fetch_assoc($list_res)){
	$age = date("Y")-substr($list["hero_jumin"],0,4)+1;	
	$hero_sex_txt = $list["hero_sex"] == "1" ? "남":"여";
	
	$hero_today_txt = substr($list["hero_today"],0,10);
	
	$hero_review_check = "";
	if($list["url_cnt"] == 0) {
		$hero_review_check = "후기미등록";
	}
	
	if($list["hero_idx"]) {
		$naver_url_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["hero_idx"]."' AND gubun = 'naver' ";
		$naver_url_res = sql($naver_url_sql);
		
		$insta_url_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["hero_idx"]."' AND gubun = 'insta' ";
		$insta_url_res = sql($insta_url_sql);
		
		$movie_url_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["hero_idx"]."' AND gubun = 'movie' ";
		$movie_url_res = sql($movie_url_sql);
		
		$cafe_url_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["hero_idx"]."' AND gubun = 'cafe' ";
		$cafe_url_res = sql($cafe_url_sql);
		
		$etc_url_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["hero_idx"]."' AND gubun = 'etc' ";
		$etc_url_res = sql($etc_url_sql);
	}
?>
<tr>
	<td><?=$num?></td>
	<td><?=$hero_review_check;?></td>
	<td><?=$category;?></td>
	<td><?=$mission_rs["hero_title"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$hero_sex_txt?></td>
	<td><?=$age?></td>
	<td><?=$list["hero_level"]?></td>
	<td><?=$list["hero_oldday"]?></td>
	<td><?=$list["hero_mail"]?></td>
	<td><?=$list["hero_hp"]?></td>
	<td><?=$list["hero_address_01"]?></td>
	<td><?=$list["hero_address_02"]?> <?=$list["hero_address_03"]?></td>
	<td>
		<? 
		  $br_num = 0;
		  while($list = mysql_fetch_assoc($naver_url_res)) {?>
		  	<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$list["url"]?>
		<? 
			$br_num++;
		  } 
		?>
	</td>
	<td>
		<? 
		$br_num = 0;
		while($list = mysql_fetch_assoc($insta_url_res)) {?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$list["url"]?>
		<? 
			$br_num++;
		  } 
		?>
	</td>
	<td>
		<? 
		$br_num = 0;
		while($list = mysql_fetch_assoc($movie_url_res)) { ?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$list["url"]?>
		<? } ?>
	</td>
	<td>
		<? 
		$br_num = 0;
		while($list = mysql_fetch_assoc($cafe_url_res)) { ?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$list["url"]?>
		<? 
			$br_num++;
		  } 
		?>
	</td>
	<td>
		<? 
		$br_num = 0;
		while($list = mysql_fetch_assoc($etc_url_res)) { ?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$list["url"]?>
		<? 
			$br_num++;
		  } 
		?>
	</td>
	<td><?=$hero_today_txt?></td>
</tr>
<? 
$num++;
} 
?>
</table>
                        	
                        
                        
                        
                        
                        
                        