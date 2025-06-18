<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=우수후기_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");


$search = "";
$search_category = "";
if(strcmp($_GET['kewyword'], '')){
    if($_GET['select']=='hero_all'){
		$search = ' and ( m.hero_id like \'%'.$_GET['kewyword'].'%\' or s.hero_title like \'%'.$_GET['kewyword'].'%\' or b.hero_command like \'%'.$_GET['kewyword'].'%\')';
	}else{
		$search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
	}
}

if($_REQUEST['category_select']) {
	$search_category = "in('".$_REQUEST['category_select']."')";
}else {
	$search_category = "in('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08', 'group_04_23')";
}

$sql  = " SELECT b.hero_idx, b.hero_title, b.hero_today, b.hero_order , g.hero_title as menu ";
$sql .= " , m.hero_id, m.hero_name , m.hero_nick, m.hero_hp ";
$sql .= " , s.hero_title as mission_title ";
$sql .= " FROM board b ";
$sql .= " LEFT JOIN hero_group g ON b.hero_table = g.hero_board ";
$sql .= " LEFT JOIN member m ON b.hero_code = m.hero_code ";
$sql .= " LEFT JOIN mission s ON b.hero_01 = s.hero_idx ";
$sql .= " WHERE b.hero_table ".$search_category." AND (hero_board_three='1' or b.hero_table='group_04_10') ".$search;
$sql .= " ORDER BY hero_idx DESC ";

$list_res = sql($sql,"on");

?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>번호</th>
	<th>카테고리</th>
	<th>체험단명</th>
	<th>아이디</th>
	<th>닉네임</th>
	<th>이름</th>
	<th>회원정보 연락처</th>
	<th>후기 URL</th>
	<th>우수후기 등록일</th>
</tr>
<? 
$num = 1;
while($list = mysql_fetch_assoc($list_res)){
	$naver_url_sql = " SELECT url FROM mission_url WHERE board_hero_idx = '".$list["hero_idx"]."' ORDER BY hero_idx ASC ";
	$naver_url_res = sql($naver_url_sql);
?>
<tr>
	<td><?=$num?></td>
	<td><?=$list["menu"]?></td>
	<td><?=$list["mission_title"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_hp"]?></td>
	<td>
		<? 
		$br_num = 0;
		while($urlList = mysql_fetch_assoc($naver_url_res)) {?>
			<? if($br_num > 0) {?><br style="mso-data-placement:same-cell;"><? } ?>
			<?=$urlList["url"]?>
		<? 
		$br_num++;
		} 
		?>
	</td>
	<td><?=$list["hero_today"]?></td>
</tr>
<? 
$num++;
} 
?>
</table>
                        	
                        
                        
                        
                        
                        