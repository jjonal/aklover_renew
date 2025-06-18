<?
if(!defined('_HEROBOARD_'))exit;

$sql  = " SELECT *  ";
$sql .=" , (SELECT hero_name FROM level WHERE hero_level = a.hero_level) as level_name ";
$sql .=" FROM admin a WHERE hero_use=0 AND hero_idx=".$_GET['hero_idx'];
sql($sql);
$list = @mysql_fetch_assoc($out_sql);
?>
<form name="searchForm" id="searchForm" method="GET">
<? 
foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>

<?
                        $level_sql = 'select * from level where hero_use=\'0\' and hero_level='.$list['hero_level'].' order by hero_level desc;';//desc<=
                        $out_level_sql = mysql_query($level_sql);
                        $level_list                             = @mysql_fetch_assoc($out_level_sql);
?>
<table class="t_view">
<colgroup>
	<col width="150px">
	<col width="*">
	<col width="150px">
	<col width="*">
</colgroup>                          
<tr>
	<th>운영자 ID</th>
    <td><?=$list['hero_id'];?></td>
    <th>운영자 성명</th>
    <td><?=$list['hero_name'];?></td>
</tr>
<tr>
	<th>운영자 닉네임</th>
	<td colspan="3"><?=$list['hero_nick'];?></td>
</tr>
<tr>
	<th>연락처</th>
	<td><?=$list['hero_hp'];?></td>
	<th>이메일</th>
	<td><?=$list['hero_mail'];?></td>
</tr>
<tr>
	<th>등록일</th>
	<td><?=$list['hero_today'];?></td>
	<th>등급</th>
	<td><?=$list['level_name'];?></td>
</tr>
</table>
<div class="btnGroup">
	<div class="l">
		<a href="#" onClick="fnList();" class="btnList">목록</a>
	</div>
	<div class="r">
		<a href="#" onClick="fnEdit()" class="btnAdd">수정</a>
	</div>
</div>
<script>
$(document).ready(function(){
	fnEdit = function() {
		$("#searchForm input[name='view']").val("01_write");
		$("#searchForm").submit();
	}
	
	fnList = function() {
		$("#searchForm input[name='view']").val("");
		$("#searchForm").submit();
	}
})
</script>
                        