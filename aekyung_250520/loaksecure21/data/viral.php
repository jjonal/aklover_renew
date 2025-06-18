<?
if(!defined('_HEROBOARD_'))exit;

if($_GET["startDate"] && $_GET["endDate"]) {

	$startDate = substr($_GET["startDate"],0,7);
	$endDate = substr($_GET["endDate"],0,7); 
	
	$search = " AND date_format(hero_oldday,'%Y-%m') >= '".$startDate."' AND date_format(hero_oldday,'%Y-%m') <= '".$endDate."' ";
	
	$sql  = " SELECT * FROM ";
	$sql .= " ( SELECT month ";
	$sql .= " , count(*) as total_cnt "; 
 	$sql .= " , SUM(if((DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0,1,0)) AS viral_cnt "; 
 	$sql .= " , SUM(if(ifnull(length(hero_blog_00),0) > 0 && (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0 ,1,0)) AS naver "; 
 	$sql .= " , SUM(if(ifnull(length(hero_blog_04),0) > 0 && (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0,1,0)) AS insta ";
 	$sql .= " , SUM(if(ifnull(length(hero_blog_00),0) > 0 && ifnull(length(hero_blog_04),0) > 0 && (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0,1,0)) naver_and_insta "; 
	$sql .= " , SUM(if((ifnull(length(hero_blog_00),0) > 0 || ifnull(length(hero_blog_04),0) > 0) && (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0,1,0)) naver_or_insta ";
	$sql .= " FROM ( ";
	$sql .= " SELECT date_format(hero_oldday,'%Y%m') month, hero_jumin, hero_sex, hero_blog_00, hero_blog_04 ";
	$sql .= " FROM member WHERE hero_use = 0 ".$search;
	$sql .= " ) a GROUP BY month WITH rollup ) a ORDER BY month DESC ";

	$res = sql($sql,"on");
}
?>
<div class="view_title_box">
	<p>* 바이럴 대상자(연령 20~40, 여성)</p>
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
			<input type="text" name="startDate" class="dateMode" value="<?=$startDate?>"> ~ 
			<input type="text" name="endDate" class="dateMode" value="<?=$endDate?>">
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
	<col width="15%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
</colgroup>
<thead>
<tr>
	<th rowspan="2">월별</th>
	<th colspan="4">(신) 바이럴 대상자</th>
	<th rowspan="2">신규 일반회원</th>
	<th rowspan="2">신규 바이럴 대상자</th>
</tr>
<tr>
	<th>네이버 블로그</th>
	<th>인스타</th>
	<th>블로그 && 인스타</th>
	<th>블로그 or 인스타</th>
</tr>
</thead>
<? 
$i = 0;
while($list = mysql_fetch_assoc($res)) {?>
<tr>
	<td>
		<? if($list["month"]) { ?>
		<?=substr($list["month"],0,4)?>년 <?=substr($list["month"],4,2)?>월
		<? } else { ?>
		소계
		<? } ?>
	</td>
	<td><?=number_format($list["naver"])?>명</td>
	<td><?=number_format($list["insta"])?>명</td>
	<td><?=number_format($list["naver_and_insta"])?>명</td>
	<td><?=number_format($list["naver_or_insta"])?>명</td>
	<td><?=number_format($list["total_cnt"])?>명</td>
	<td><?=number_format($list["viral_cnt"])?>명</td>
</tr>
<? $i++;} ?>
<? if($i==0) {?>
<tr>
	<td colspan="7">기간 검색을 진행해 주세요.</td>
</tr>
<? } ?>
</table>

<script>
$(document).ready(function(){
	fnSearch = function() {

		if(!$("input[name='startDate']").val()) {
			alert("시작일을 입력해 주세요.");
			$("input[name='startDate']").focus();
			return;
		}

		if(!$("input[name='endDate']").val()) {
			alert("종료일을 입력해 주세요.");
			$("input[name='endDate']").focus();
			return;
		}
		
		$("#searchForm").attr("action","").submit();
	}

	fnExcel = function() {
		$("#searchForm").attr("action","/loaksecure21/data/excel_viral.php").submit();
	}
})
</script>
