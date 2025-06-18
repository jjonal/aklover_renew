<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

$focus_type_arr = array("0"=>"����̼�","1"=>"�̺�Ʈ","2"=>"�ҹ�����","3"=>"��������","5"=>"��ǰǰ��","7"=>"�����̼�","8"=>"����Ʈü��","9"=>"����̼�(����)","10"=>"ü���");

$search = "";
$hero_table = $_GET["hero_table"];

$hero_table_txt = "";
if($hero_table == "group_04_06") {
	$hero_table_txt = "��ƼŬ��";
} else if($hero_table == "group_04_27") {
	$hero_table_txt = "Beauty/Life Club ������";
} else if($hero_table == "group_04_28") {
	$hero_table_txt = "������Ŭ��";
}

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=".$hero_table_txt."_������_����_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

if($_GET["startDate"] && $_GET["endDate"]) {
	$search .= " AND ( (date_format(hero_today_01_01,'%Y-%m-%d') <= '".$_GET["startDate"]."' AND date_format(hero_today_01_02,'%Y-%m-%d')>='".$_GET["startDate"]."' )";
	$search .= " || (date_format(hero_today_01_01,'%Y-%m-%d') <= '".$_GET["endDate"]."' AND date_format(hero_today_01_02,'%Y-%m-%d')>='".$_GET["endDate"]."' )";
	$search .= " || (date_format(hero_today_01_01,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND date_format(hero_today_01_02,'%Y-%m-%d')<='".$_GET["endDate"]."' ))";
}

if($_GET["kewyword"]) {
	$search .= " AND m.hero_title LIKE '%".$_GET["kewyword"]."%' ";
}
$sql  = " SELECT m.* ";
$sql .= " , sum(ifnull(if(m.gubun='naver',1,0),0)) naver_cnt ";
$sql .= " , sum(ifnull(if(m.gubun='insta',1,0),0)) insta_cnt ";
$sql .= " , sum(ifnull(if(m.gubun='movie',1,0),0)) movie_cnt ";
$sql .= " , sum(ifnull(if(m.gubun='cafe',1,0),0)) cafe_cnt ";
$sql .= " , sum(ifnull(if(m.gubun='etc',1,0),0)) etc_cnt ";
$sql .= " , ( SELECT count(*) FROM mission_review WHERE hero_old_idx = m.hero_idx) as join_cnt ";
$sql .= " , sum(ifnull(if(m.gubun!='',1,0),0)) tot_board_cnt ";
$sql .= " FROM (";
$sql .= " SELECT m.hero_idx, m.hero_title, m.hero_table, m.hero_type ";
$sql .= " , CASE WHEN m.hero_table = 'group_04_06' THEN m.hero_beauty_gisu WHEN m.hero_table = 'group_04_27' THEN m.hero_youtube_gisu ";
$sql .= " WHEN m.hero_table = 'group_04_28' THEN m.hero_life_gisu END hero_gisu";
$sql .= ", m.hero_today_01_01 ";
$sql .= " , case when m.hero_type = 0 then m.hero_today_01_02 else m.hero_today_04_02 end hero_today_01_02 ";
$sql .= " , u.gubun ";
$sql .= " FROM mission m LEFT JOIN (SELECT hero_idx, hero_01 FROM board WHERE hero_table = '".$hero_table."') AS b ON m.hero_idx = b.hero_01 ";
$sql .= " LEFT JOIN mission_url u ON b.hero_idx = u.board_hero_idx ";
$sql .= " WHERE m.hero_table = '".$hero_table."' ) m WHERE 1=1 ".$search;
$sql .= " GROUP BY m.hero_idx ";
$sql .= " ORDER BY m.hero_idx DESC ";

sql($sql,"on");
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>No</th>
	<th>�Ⱓ</th>
	<th>ü��� Ÿ��</th>
	<th>���</th>
	<th>ü��� ��</th>
	<th>������</th>
	<th>������ ��</th>
	<th>���̹� ��α�</th>
	<th>�ν�Ÿ�׷�</th>
	<th>�ı�(����)</th>
	<th>ī��</th>
	<th>��Ÿ</th>
</tr>
<? 
	$i=1;
	while($list = @mysql_fetch_assoc($out_sql)){
		$tot_naver_cnt += $list['naver_cnt'];
		$tot_insta_cnt += $list['insta_cnt'];
		$tot_movie_cnt += $list['movie_cnt'];
		$tot_cafe_cnt += $list['cafe_cnt'];
		$tot_etc_cnt += $list['etc_cnt'];
		$tot_join_cnt += $list['join_cnt'];
		$sum_tot_board_cnt += $list['tot_board_cnt'];
?>
<tr>
	<td><?=$i?></td>
	<td><?=substr($list['hero_today_01_01'],0,10);?> ~ <?=substr($list['hero_today_01_02'],0,10);?></td>
	<td><?=$focus_type_arr[$list["hero_type"]]?></td>
	<td><?=$list["hero_gisu"]?></td>
	<td class="title"><?=$list['hero_title'];?></td>
	<td><?=number_format($list["join_cnt"])?></td>
	<td><?=number_format($list["tot_board_cnt"])?></td>
	<td><?=number_format($list['naver_cnt'])?></td>
	<td><?=number_format($list['insta_cnt'])?></td>
	<td><?=number_format($list['movie_cnt'])?></td>
	<td><?=number_format($list['cafe_cnt'])?></td>
	<td><?=number_format($list['etc_cnt'])?></td>
</tr>
<? 
	$i++;
	}
?>
<tr>
	<td colspan="5">�հ�</td>
	<td><?=number_format($tot_join_cnt)?></td>
	<td><?=number_format($sum_tot_board_cnt)?></td>
	<td><?=number_format($tot_naver_cnt)?></td>
	<td><?=number_format($tot_insta_cnt)?></td>
	<td><?=number_format($tot_movie_cnt)?></td>
	<td><?=number_format($tot_cafe_cnt)?></td>
	<td><?=number_format($tot_etc_cnt)?></td>
</tr>
</table>