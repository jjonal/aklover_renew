<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["startDate"] && $_GET["endDate"]) {
	$search .= " AND date_format(hero_oldday,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND  date_format(hero_oldday,'%Y-%m-%d') <= '".$_GET["endDate"]."' ";
}

$sql  = " SELECT count(*) cnt, sum(hero_chk_phone) phone , sum(hero_chk_email) email ";
$sql .= " , sum(if(hero_chk_phone = 1  AND hero_chk_email = 1,1,0)) all_chk FROM member WHERE hero_use = 0 ".$search;
$list_res = sql($sql, "on");
?>
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

<table class="t_list">
<colgroup>
	<col width="25%" />
	<col width="25%" />
	<col width="25%" />
	<col width="25%" />
</colgroup>
<thead>
<tr>
	<th>회원 수 </th>
	<th>SMS 수신동의</th>
	<th>이메일 수신동의</th>
	<th>SMS + 수신동의</th>
</tr>
</thead>
<? 
while($list = mysql_fetch_assoc($list_res)) { ?>
<tr>
	<td><?=number_format($list["cnt"])?></td>
	<td><?=number_format($list["phone"])?></td>
	<td><?=number_format($list["email"])?></td>
	<td><?=number_format($list["all_chk"])?></td>
</tr>
<? } ?>
</table>
<script>
$(document).ready(function(){	
	fnSearch = function() {
		$("#searchForm").attr("action","").submit();
	}
})
</script>