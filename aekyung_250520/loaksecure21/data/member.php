<?
if(!defined('_HEROBOARD_'))exit;

$search = "";
$search_dormancy = "";
$search_leave = "";

if($_GET["startDate"] && $_GET["endDate"]) {
	$search .= " AND date_format(hero_oldday,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND  date_format(hero_oldday,'%Y-%m-%d') <= '".$_GET["endDate"]."' ";
	$search_dormancy .= " AND date_format(hero_out_date,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND  date_format(hero_out_date,'%Y-%m-%d') <= '".$_GET["endDate"]."' ";
	$search_leave .= " AND FROM_UNIXTIME(hero_out_date,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND  FROM_UNIXTIME(hero_out_date,'%Y-%m-%d') <= '".$_GET["endDate"]."' ";
}

if($_GET["startDate"] && $_GET["endDate"]) {
	$sql  = " SELECT hero_month, sum(woman) AS woman, sum(man) AS man,  sum(total) AS total ";
	$sql .= " , sum(dormancy_woman) dormancy_woman, sum(dormancy_man) dormancy_man, sum(dormancy_total) dormancy_total ";
	$sql .= " , sum(leave_member) leave_member, sum(leave_admin) leave_admin,  sum(leave_total) leave_total ";
	$sql .= " from ";
	$sql .= " ( SELECT hero_month, ifnull(sum(if(hero_sex = 0,1,0)),0) woman , ifnull(sum(if(hero_sex = 1,1,0)),0) man, COUNT(*) total ";
	$sql .= " , '0' as dormancy_woman, '0' as dormancy_man, '0' as dormancy_total ";
	$sql .= " , '0' as leave_member, '0' as leave_admin, '0' as leave_total ";
	$sql .= "  FROM ";
	$sql .= " ( SELECT  date_format(hero_oldday,'%Y%m') hero_month , hero_sex  FROM member WHERE hero_use = 0 ".$search." ) "; 
	$sql .= "  a GROUP BY hero_month ";
	$sql .= " UNION ALL ";
	$sql .= " SELECT hero_month, 0 as woman, 0 as mam, 0 as total ";
	$sql .= " , ifnull(sum(if(hero_sex = 0,1,0)),0) dormancy_woman , ifnull(sum(if(hero_sex = 1,1,0)),0) dormancy_man, COUNT(*) dormancy_total ";
	$sql .= " , '0' as leave_member, '0' as leave_admin, '0' as leave_total ";
	$sql .= " FROM ";
	$sql .= " (SELECT DATE_FORMAT(hero_out_date,'%Y%m') hero_month, (SELECT hero_sex FROM member_backup WHERE hero_code = m.hero_code LIMIT 1) hero_sex FROM member m WHERE hero_use = 2 ".$search_dormancy.") ";
	$sql .= " a GROUP BY hero_month ";
	$sql .= " UNION ALL ";
	$sql .= " SELECT hero_month , 0 as woman, 0 as mam, 0 as total ";
	$sql .= " , '0' as dormancy_woman, '0' as dormancy_man, '0' as dormancy_total ";
	$sql .= " , ifnull(sum(if(hero_out_reason = 1,1,0)),0) AS leave_member , ifnull(sum(if(hero_out_reason = 2,1,0)),0) AS leave_admin , COUNT(*) leave_admin ";
	$sql .= " FROM ";
	$sql .= " (SELECT FROM_UNIXTIME(hero_out_date,'%Y%m') hero_month ";
	$sql .= " ,case when (hero_out = '휴면회원3년이상 자동파기') then 2 when hero_out_reason = 8 then 2 ELSE 1 END hero_out_reason ";
	$sql .= " FROM member WHERE hero_use = 1 ".$search_leave." ) a GROUP BY hero_month ) a GROUP BY hero_month with rollup ";
	$list_res = sql($sql);
}
?>
<div class="view_title_box">
	<p>※ 자동파기 : 휴먼회원 3년 이상</p>
</div>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>기간</th>
		<td>
			<input type="text" name="startDate" class="dateMode" value="<?=$_REQUEST['startDate']?>"> ~ 
			<input type="text" name="endDate" class="dateMode" value="<?=$_REQUEST['endDate']?>">
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div>
</form>

<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">다운로드</a>
	</div>
</div>


<table class="t_list">
<colgroup>
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
</colgroup>
<thead>
<tr>
	<th rowspan="2">기간</th>
	<th colspan="3">일반회원</th>
	<th colspan="3">휴면회원</th>
	<th colspan="3">이탈회원</th>
</tr>
<tr>
	<th>여성</th>
	<th>남성</th>
	<th>소계</th>
	<th>여성</th>
	<th>남성</th>
	<th>소계</th>
	<th>사용자/관리자 탈퇴</th>
	<th>자동파기</th>
	<th>소계</th>
</tr>
</thead>
<? 
$no = 0;
while($list = mysql_fetch_assoc($list_res)) { ?>
<tr>
	<td>
		<? if($list["hero_month"]) {?>
		<?=substr($list["hero_month"],0,4)?>년 <?=substr($list["hero_month"],4,2)?>월
		<? } else { ?>
		소계
		<? } ?>
	</td>
	<td><?=number_format($list["woman"])?></td>
	<td><?=number_format($list["man"])?></td>
	<td><?=number_format($list["total"])?></td>
	<td><?=number_format($list["dormancy_woman"])?></td>
	<td><?=number_format($list["dormancy_man"])?></td>
	<td><?=number_format($list["dormancy_total"])?></td>
	<td><?=number_format($list["leave_member"])?></td>
	<td><?=number_format($list["leave_admin"])?></td>
	<td><?=number_format($list["leave_total"])?></td>
</tr>
<?
$no++;
} 
?>
<? if($no == 0) {?>
<tr>
	<td colspan="10">기간 검색 후 이용해 주세요.</td>
</tr>
<? } ?>
</table>
<script>
$(document).ready(function(){	
	fnSearch = function() {
		$("#searchForm").attr("action","").submit();
	}

	fnExcel = function() {
		$("#searchForm").attr("action","/loaksecure21/data/excel_member.php").submit();
	}
})
</script>