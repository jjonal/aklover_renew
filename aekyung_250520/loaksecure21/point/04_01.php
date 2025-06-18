<?
if(!defined('_HEROBOARD_'))exit;

$hero_old_idx = $_GET["hero_idx"];

$sql =  " SELECT hero_id, hero_title, hero_name, hero_nick, hero_point, hero_today FROM point  ";
$sql .= " WHERE hero_old_idx = '".$hero_old_idx."' AND hero_type='mission_excel' "; 
$sql .= " ORDER BY hero_idx ASC ";
$list_res = sql($sql);	
?>
<form name="searchForm" id="searchForm" method="GET">
<? 
unset($_GET["view"]);
foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>
<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">다운로드</a>
	</div>	
</div>

<table class="t_list">
<colgroup>
	<col width="15%" />
	<col width="*" />
	<col width="15%" />
	<col width="15%" />
	<col width="15%" />
	<col width="15%" />
</colgroup>
<thead>
<tr>
	<th>지급일</th>
	<th>체험단 명</th>
	<th>아이디</th>
	<th>이름</th>
	<th>닉네임</th>
	<th>포인트</th>
</tr>
</thead>
<? while($list = @mysql_fetch_assoc($list_res)){ ?>
<tr>
	<td><?=$list["hero_today"];?></td>
	<td class="title"><?=$list["hero_title"];?></td>
	<td><?=$list["hero_id"];?></td>
	<td><?=$list["hero_name"];?></td>
	<td><?=$list["hero_nick"];?></td>
	<td><?=$list["hero_point"];?>P</td>
</tr>
<? } ?>
</table>

<div class="btnGroupL">
	<a href="<?=ADMIN_DEFAULT?>/index.php?board=point&idx=91" class="btnList">목록</a>
</div>

<script>
$(document).ready(function(){
	fnExcel = function() {
		$('#searchForm').attr('action','/loaksecure21/point/excel_04_01.php').submit();
	}
})
</script>
	

                        