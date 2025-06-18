<?
if(!defined('_HEROBOARD_'))exit;

$search_year = $_REQUEST["search_year"] ? $_REQUEST["search_year"]:date("Y");
$mode = $_POST["mode"];
 
if($mode == "add") {
	$hero_today = $_POST["hero_today"];
	
	$board_blog = $_POST["board_blog"];
	$board_insta = $_POST["board_insta"];
	$contents_blog = $_POST["contents_blog"];
	$contents_insta = $_POST["contents_insta"];
	
	$view_beauty = $_POST["view_beauty"];
	$keyword_beauty = $_POST["keyword_beauty"];
	
	$view_life = $_POST["view_life"];
	$keyword_life = $_POST["keyword_life"];
	$view_pb_blog = $_POST["view_pb_blog"];
	$view_pb_insta = $_POST["view_pb_insta"];
	
	if(count($hero_today) > 0) {
		for($i=0; $i<count($hero_today); $i++) {
			$sql_check = " SELECT count(*) cnt FROM etc_mission_ea WHERE hero_today = '".$hero_today[$i]."' ";
			$res = sql($sql_check);
			$rs = mysql_fetch_assoc($res);
			
			$check_cnt = $rs["cnt"];
			
			if($check_cnt == 0) {
				
				$sql  = " INSERT INTO etc_mission_ea (hero_today, board_blog, board_insta, contents_blog, contents_insta ";
				$sql .= " ,view_beauty ,keyword_beauty ,view_life ,keyword_life ,view_pb_blog ,view_pb_insta, temp_code) ";
				$sql .= " VALUES ";
				$sql .= " ('".$hero_today[$i]."' ,'".$board_blog[$i]."' ,'".$board_insta[$i]."' ,'".$contents_blog[$i]."' ,'".$contents_insta[$i]."' ";
				$sql .= " ,'".$view_beauty[$i]."' ,'".$keyword_beauty[$i]."','".$view_life[$i]."' ,'".$keyword_life[$i]."' ,'".$view_pb_blog[$i]."' ,'".$view_pb_insta[$i]."' ,'".$_SESSION["temp_code"]."') ";
			} else {
				$sql  = " UPDATE etc_mission_ea SET ";
				$sql .= " board_blog = '".$board_blog[$i]."', board_insta = '".$board_insta[$i]."', contents_blog = '".$contents_blog[$i]."', contents_insta = '".$contents_insta[$i]."' ";
				$sql .= " , view_beauty = '".$view_beauty[$i]."', keyword_beauty = '".$keyword_beauty[$i]."',view_life = '".$view_life[$i]."', keyword_life = '".$keyword_life[$i]."', view_pb_blog = '".$view_pb_blog[$i]."' ";
				$sql .= " , view_pb_insta = '".$view_pb_insta[$i]."',  temp_code = '".$_SESSION["temp_code"]."' ";
				$sql .= " WHERE hero_today = '".$hero_today[$i]."' ";
			}
			$result = sql($sql);
			
		}
	}	
	msg('변경 되었습니다.','location.href="'.ADMIN_DEFAULT.'/index.php?board='.$_POST["board"].'&idx='.$_POST["idx"].'&search_year='.$search_year.'"');
	exit;
} 

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

sql($sql);

?>
<style>
.tb_status input[type='text']{text-align:center;}
</style>
<p class="tit_section mgb10">참여 채널별 콘텐츠</p>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="mode" id="mode" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>년도</th>
		<td>
			<select name="search_year">
				<? for($i=date("Y"); $i>=2013; $i--) {?>
					<option value="<?=$i?>" <?=$search_year==$i ? "selected":"";?>><?=$i?></option>
				<? } ?>
			</select> 년
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div>
<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onclick="fnExcel()">전체 현황</a>
	</div>
</div>
<table class="t_list tb_status">
<colgroup>
	<col width="*" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
	<col width="5.5%" />
</colgroup>
<thead>
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
</thead>
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
	<td><?=substr($list["month2"],0,4)?>년 <?=substr($list["month2"],4,2)?>월
		<input type="hidden" name="hero_today[]" value="<?=$list["month2"]?>" />
	</td>
	<td><?=number_format($list["board_6_cnt"])?></td>
	<td><?=number_format($list["board_28_cnt"])?></td>
	<td><?=number_format($list["board_27_cnt"])?></td>
	<td><input type="text" name="board_blog[]" value="<?=$list["board_pb_blog_cnt"]?>" /></td>
	<td><input type="text" name="board_insta[]" value="<?=$list["board_pb_insta_cnt"]?>" /></td>
	<td><?=number_format($list['contents_6_cnt'])?></td>
	<td><?=number_format($list['contents_28_cnt'])?></td>
	<td><?=number_format($list['contents_27_cnt'])?></td>
	<td><input type="text" name="contents_blog[]" value="<?=$list['contents_pb_blog_cnt']?>" /></td>
	<td><input type="text" name="contents_insta[]" value="<?=$list['contents_pb_insta_cnt']?>" /></td>
	<td><input type="text" name="view_beauty[]" value="<?=$list['view_beauty_cnt']?>"/></td>
	<td><input type="text" name="keyword_beauty[]" value="<?=$list['keyword_beauty_cnt']?>"/></td>
	<td><input type="text" name="view_life[]" value="<?=$list['view_life_cnt']?>"/></td>
	<td><input type="text" name="keyword_life[]" value="<?=$list['keyword_life_cnt']?>"/></td>
	<td><input type="text" name="view_pb_blog[]" value="<?=$list['view_pb_blog_cnt']?>"/></td>
	<td><input type="text" name="view_pb_insta[]" value="<?=$list['view_pb_insta_cnt']?>"/></td>
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
</form>
<div class="btnGroup">
	<a href="javascript:;" onClick="fnAdd();" class="btnAdd">저장</a>
</div>
<script>
$(document).ready(function(){	
	fnSearch = function() {
		$("#searchForm").attr("action","").submit();
	}

	fnAdd = function() {
		$("#mode").val("add");
		$("#searchForm").attr("method","POST").submit();
	}

	fnExcel = function() {
		$("#searchForm").attr("action","/loaksecure21/data/focus_all_status_excel.php").submit();
	}	
})
</script>
