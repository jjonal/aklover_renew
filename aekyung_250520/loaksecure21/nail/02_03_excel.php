<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mission_sql = " SELECT hero_title, hero_question_url_list  FROM mission WHERE hero_idx = ".$_GET['hero_idx'];
$mission_res = sql($mission_sql,"on");
$mission_rs = mysql_fetch_assoc($mission_res);

$filename = htmlspecialchars_decode($mission_rs["hero_title"]);

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=".$filename."_공정위문구확인_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$search = "";
if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

if($_GET["admin_check"]) {
	$search .= " AND  u.admin_check = '".$_GET["admin_check"]."' ";
}

//리스트
$sql  = " SELECT";
$sql .= " m.hero_id, m.hero_name, m.hero_nick, m.hero_jumin, m.hero_hp ";
$sql .= " , b.hero_idx as board_hero_idx , b.hero_today as board_hero_today ";
$sql .= " , u.hero_idx as mission_url_idx, u.gubun, u.url, u.member_check, u.admin_check ";
$sql .= " FROM board b ";
$sql .= " INNER JOIN member m ON b.hero_code = m.hero_code ";
$sql .= " LEFT JOIN mission_url u ON b.hero_idx = u.board_hero_idx ";
$sql .= " WHERE m.hero_use=0 AND b.hero_01='".$_GET['hero_idx']."' ".$search;
$sql .= " ORDER BY b.hero_idx DESC, FIELD(u.gubun,'naver','insta','cafe','etc') DESC, u.hero_idx ASC ";

$list_res = sql($sql);

?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>체험단 명</th>
	<th>아이디</th>
	<th>닉네임</th>
	<th>이름</th>
	<th>휴대폰</th>
	<th>SNS</th>
	<th>후기등록 URL</th>
	<th>사용자 공정위 문구 확인</th>
	<th>관리자 공정위 문구 확인</th>
</tr>
<? while($list = mysql_fetch_assoc($list_res)){ 
	$member_check_txt = "미동의";
	$admin_check_txt = "미동의";
	if($list["member_check"] == "Y") $member_check_txt = "동의";
	if($list["admin_check"] == "Y") $admin_check_txt = "동의";
?>
<tr>
	<td><?=$mission_rs["hero_title"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_hp"]?></td>
	<td><?=$list["gubun"]?></td>
	<td><?=$list["url"]?></td>
	<td><?=$member_check_txt?></td>
	<td><?=$admin_check_txt?></td>
</tr>
<? } ?>
</table>
                        	
                        
                        
                        
                        
                        
                        