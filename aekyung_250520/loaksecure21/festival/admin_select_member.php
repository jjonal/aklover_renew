<?
	$group_num = $_GET["group_num"];
	
	if(!$group_num) {
		$max_group_num_sql = " SELECT max(group_num) max_group_num FROM pointMallTempMember ";
		sql($max_group_num_sql);
		$max_rs = @mysql_fetch_assoc($out_sql);
		
		$group_num = $max_rs["max_group_num"];
	}
	
	$tot_count_sql = " SELECT count(*) cnt FROM pointMallTempMember WHERE group_num = '".$group_num."' ";
	sql($tot_count_sql);
	$total_res = @mysql_fetch_assoc($out_sql);
	$total_data = $total_res["cnt"];

	$group_num_sql = " SELECT group_num FROM pointMallTempMember GROUP BY group_num ORDER BY group_num ASC ";
	sql($group_num_sql); 
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
		<th>그룹번호</th>
		<td>
			<select name="group_num">
			<? while ( $group = @mysql_fetch_assoc ( $out_sql ) ) { ?>
			<option value="<?=$group["group_num"]?>" <?=$group_num == $group["group_num"] ? "selected":""; ?>><?=$group["group_num"]?></option>
			<? } ?>
		</select> 
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div>
</form>
	
<div class="listExplainWrap mgb10">
<label>총 </label> : <strong><?=$total_data?></strong>건
</div>
<table class="t_list">
	<thead>
		<tr>
			<th width="10%">그룹번호</th>
			<th width="30%">회원고유코드</th>
			<th width="30%">이름</th>
			<th width="30%">닉네임</th>
		</tr>
	</thead>
	<tbody>
		<form name="form_next"
			action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post"
			enctype="multipart/form-data"> 
<?
$sql  = ' select p.hero_code, p.group_num, m.hero_name, m.hero_nick from pointMallTempMember p left join member m  ';
$sql .= ' ON p.hero_code = m.hero_code AND m.hero_use = 0 WHERE p.group_num =\''.$group_num.'\' ORDER BY m.hero_name DESC '; // desc//asc
$sql = out ( $sql );
 //echo $sql;
sql ( $sql );
$i = '0';
while ( $roll_list = @mysql_fetch_assoc ( $out_sql ) ) {
	
?>
<tr>
	<td><?=$roll_list["group_num"];?></td>
	<td><?=$roll_list["hero_code"];?></td>
	<td><?=name_masking($roll_list["hero_name"]);?></td>
	<td><?=$roll_list["hero_nick"];?></td>
</tr>
<?
	$i ++;
}
?>
</tbody>
</table>
<script>
$(document).ready(function(){
	fnSearch = function() {
		$("#searchForm").submit();
	}
})
</script>