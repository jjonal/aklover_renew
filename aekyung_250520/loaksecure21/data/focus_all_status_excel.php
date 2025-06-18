<?
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$search_year = $_REQUEST["search_year"] ? $_REQUEST["search_year"]:date("Y");

header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
header( "Content-Disposition: attachment; filename=".$search_year."년_포커스_전체현황_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

$sql  = " SELECT t.month2, m.month ";
$sql .= " ,board_6_cnt ,board_27_cnt ,board_28_cnt ";
$sql .= " , IFNULL((SELECT board_blog FROM etc_mission_ea WHERE hero_today =  t.month2),0) board_pb_blog_cnt ";
$sql .= " , IFNULL((SELECT board_insta FROM etc_mission_ea WHERE hero_today =  t.month2),0) board_pb_insta_cnt ";
$sql .= " ,contents_6_cnt ,contents_27_cnt ,contents_28_cnt ";
$sql .= " , IFNULL((SELECT contents_blog FROM etc_mission_ea WHERE hero_today =  t.month2),0) contents_pb_blog_cnt";
$sql .= " , IFNULL((SELECT contents_insta FROM etc_mission_ea WHERE hero_today =  t.month2),0) contents_pb_insta_cnt";
$sql .= " , IFNULL((SELECT view_beauty FROM etc_mission_ea WHERE hero_today =  t.month2),0) view_beauty_cnt";
$sql .= " , IFNULL((SELECT keyword_beauty FROM etc_mission_ea WHERE hero_today =  t.month2),0) keyword_beauty_cnt";
$sql .= " , IFNULL((SELECT view_life FROM etc_mission_ea WHERE hero_today =  t.month2),0) view_life_cnt";
$sql .= " , IFNULL((SELECT keyword_life FROM etc_mission_ea WHERE hero_today =  t.month2),0) keyword_life_cnt";
$sql .= " , IFNULL((SELECT view_pb_blog FROM etc_mission_ea WHERE hero_today =  t.month2),0) view_pb_blog_cnt";
$sql .= " , IFNULL((SELECT view_pb_insta FROM etc_mission_ea WHERE hero_today =  t.month2),0) view_pb_insta_cnt";
$sql .= " FROM "; 
$sql .= " (SELECT '".$search_year."01' as month2 union SELECT '".$search_year."02'  union SELECT '".$search_year."03'  union SELECT '".$search_year."04' union SELECT '".$search_year."05'  union SELECT '".$search_year."06' "; 
$sql .= "  union SELECT '".$search_year."07'  union SELECT '".$search_year."08'  union SELECT '".$search_year."09'  union SELECT '".$search_year."10'  union SELECT '".$search_year."11' union SELECT '".$search_year."12') t ";
$sql .= " LEFT join ";
$sql .= " (SELECT m.MONTH, m.MONTH2 ";
$sql .= " , SUM(board_6_cnt) board_6_cnt ";
$sql .= " , SUM(board_27_cnt) board_27_cnt ";
$sql .= " , SUM(board_28_cnt) board_28_cnt ";
$sql .= " , SUM(contents_6_cnt) contents_6_cnt ";
$sql .= " , SUM(contents_27_cnt) contents_27_cnt ";
$sql .= " , SUM(contents_28_cnt) contents_28_cnt ";
$sql .= "  from ";
$sql .= " (SELECT ";
$sql .= " MONTH, MONTH2 "; 
$sql .= ",sum(ifnull(if(hero_table='group_04_06','1',0),0)) board_6_cnt ";
$sql .= ",sum(ifnull(if(hero_table='group_04_27','1',0),0)) board_27_cnt ";
$sql .= ",sum(ifnull(if(hero_table='group_04_28','1',0),0)) board_28_cnt ";
$sql .= ", 0 AS contents_6_cnt ";
$sql .= ", 0 AS contents_27_cnt ";
$sql .= ", 0 AS contents_28_cnt ";
$sql .= " FROM (SELECT m.hero_idx, DATE_FORMAT(m.hero_today_01_01,'%m') MONTH, DATE_FORMAT(m.hero_today_01_01,'%Y%m') MONTH2, m.hero_table FROM mission m ";
$sql .= " INNER JOIN board b ";
$sql .= " ON m.hero_idx = b.hero_01 ";
$sql .= " WHERE ";
$sql .= " m.hero_table IN ('group_04_06','group_04_27','group_04_28') ";
$sql .= " AND left(m.hero_today_01_01,4) = '".$search_year."' ";
$sql .= " AND b.hero_table IN ('group_04_06','group_04_27','group_04_28') ";
$sql .= " ) m  GROUP BY month2 ";
$sql .= " UNION all ";
$sql .= " SELECT  ";
$sql .= " MONTH, MONTH2 ";
$sql .= " ,0 board_6_cnt ";
$sql .= " ,0 board_27_cnt ";
$sql .= " ,0 board_28_cnt ";
$sql .= " ,sum(ifnull(if(hero_table='group_04_06','1',0),0)) contents_6_cnt ";
$sql .= " ,sum(ifnull(if(hero_table='group_04_27','1',0),0)) contents_27_cnt ";
$sql .= " ,sum(ifnull(if(hero_table='group_04_28','1',0),0)) contents_28_cnt ";
$sql .= " FROM (SELECT m.hero_idx, DATE_FORMAT(m.hero_today_01_01,'%m') MONTH , DATE_FORMAT(m.hero_today_01_01,'%Y%m') MONTH2, m.hero_table FROM mission m ";
$sql .= " INNER JOIN board b ON m.hero_idx = b.hero_01 ";
$sql .= " LEFT JOIN mission_url u ON b.hero_idx = u.board_hero_idx ";
$sql .= " WHERE ";
$sql .= " m.hero_table IN ('group_04_06','group_04_27','group_04_28') ";
$sql .= " AND left(m.hero_today_01_01,4) = '".$search_year."' ";
$sql .= " AND b.hero_table IN ('group_04_06','group_04_27','group_04_28') ";
$sql .= " ) m  GROUP BY MONTH) m GROUP BY MONTH) m ON t.month2 = m.month2 ORDER BY t.month2 ASC ";

sql($sql,"on");
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<tr>
	<th rowspan=3">진행월</th>
	<th colspan="5">참여 인원수</th>
	<th colspan="5">콘텐츠 수</th>
	<th colspan="6">상위노출 수</th>
</tr>
<tr>
	<th rowspan="2">뷰티클럽</th>
	<th rowspan="2">라이프클럽</th>
	<th rowspan="2">Beauty/Life Club 영상팀</th>
	<th colspan="2">월별파블</th>
	<th rowspan="2">뷰티클럽</th>
	<th rowspan="2">라이프클럽</th>
	<th rowspan="2">Beauty/Life Club 영상팀</th>
	<th colspan="2">월별파블</th>
	<th colspan="2">뷰티클럽</th>
	<th colspan="2">라이프클럽</th>
	<th colspan="2">월별파블</th>
</tr>
<tr>
	<th>블로그</th>
	<th>인스타</th>
	<th>블로그</th>
	<th>인스타</th>
	<th>VIEW</th>
	<th>키워드 챌린지 참여</th>
	<th>VIEW</th>
	<th>키워드 챌린지 참여</th>
	<th>블로그</th>
	<th>인스타</th>
</tr>
<? 	while($list = @mysql_fetch_assoc($out_sql)){
		$tot_board_6_cnt += $list['board_6_cnt'];
		$tot_board_28_cnt += $list['board_28_cnt'];
		$tot_board_27_cnt += $list['board_27_cnt'];
		$tot_board_pb_blog_cnt += $list['board_pb_blog_cnt'];
		$tot_board_pb_insta_cnt += $list['board_pb_insta_cnt'];
		
		$tot_contents_6_cnt += $list['contents_6_cnt'];
		$tot_contents_28_cnt += $list['contents_28_cnt'];
		$tot_contents_27_cnt += $list['contents_27_cnt'];
		$tot_contents_pb_blog_cnt += $list['contents_pb_blog_cnt'];
		$tot_contents_pb_insta_cnt += $list['contents_pb_insta_cnt'];
		
		$tot_view_beauty_cnt += $list['view_beauty_cnt'];
		$tot_keyword_beauty_cnt += $list['keyword_beauty_cnt'];
		$tot_view_life_cnt += $list['view_life_cnt'];
		$tot_keyword_life_cnt += $list['keyword_life_cnt'];
		$tot_view_pb_blog_cnt += $list['view_pb_blog_cnt'];
		$tot_view_pb_insta_cnt += $list['view_pb_insta_cnt'];
?>
<tr>
	<td><?=substr($list["month2"],0,4)?>년 <?=substr($list["month2"],4,2)?>월</td>
	<td><?=number_format($list["board_6_cnt"])?></td>
	<td><?=number_format($list["board_28_cnt"])?></td>
	<td><?=number_format($list["board_27_cnt"])?></td>
	<td><?=number_format($list["board_pb_blog_cnt"])?></td>
	<td><?=number_format($list["board_pb_insta_cnt"])?></td>
	<td><?=number_format($list['contents_6_cnt'])?></td>
	<td><?=number_format($list['contents_28_cnt'])?></td>
	<td><?=number_format($list['contents_27_cnt'])?></td>
	<td><?=number_format($list['contents_pb_blog_cnt'])?></td>
	<td><?=number_format($list['contents_pb_insta_cnt'])?></td>
	<td><?=number_format($list['view_beauty_cnt'])?></td>
	<td><?=number_format($list['keyword_beauty_cnt'])?></td>
	<td><?=number_format($list['view_life_cnt'])?></td>
	<td><?=number_format($list['keyword_life_cnt'])?></td>
	<td><?=number_format($list['view_pb_blog_cnt'])?></td>
	<td><?=number_format($list['view_pb_insta_cnt'])?></td>
</tr>
<? } ?>
<tr>
	<td>합계</td>
	<td><?=number_format($tot_board_6_cnt)?></td>
	<td><?=number_format($tot_board_28_cnt)?></td>
	<td><?=number_format($tot_board_27_cnt)?></td>
	<td><?=number_format($tot_board_pb_blog_cnt)?></td>
	<td><?=number_format($tot_board_pb_insta_cnt)?></td>
	<td><?=number_format($tot_contents_6_cnt)?></td>
	<td><?=number_format($tot_contents_28_cnt)?></td>
	<td><?=number_format($tot_contents_27_cnt)?></td>
	<td><?=number_format($tot_contents_pb_blog_cnt)?></td>
	<td><?=number_format($tot_contents_pb_insta_cnt)?></td>
	<td><?=number_format($tot_view_beauty_cnt)?></td>
	<td><?=number_format($tot_keyword_beauty_cnt)?></td>
	<td><?=number_format($tot_view_life_cnt)?></td>
	<td><?=number_format($tot_keyword_life_cnt)?></td>
	<td><?=number_format($tot_view_pb_blog_cnt)?></td>
	<td><?=number_format($tot_view_pb_insta_cnt)?></td>
</tr>
</table>