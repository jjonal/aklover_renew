<?
if(!defined('_HEROBOARD_'))exit;

$search = "";
if(strcmp($_GET['kewyword'], '')){
    $search .= " AND ".$_GET['select']." LIKE '%".$_GET['kewyword']."%' ";
}

$total_sql  = " SELECT count(*) cnt FROM admin a ";
$total_sql .= " LEFT JOIN level l ON a.hero_level = l.hero_level ";
$total_sql .= " WHERE a.hero_use = 0 AND a.hero_level<='".$_SESSION['temp_level']."' ".$search;
sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res["cnt"];

$i=$total_data;

$list_page=20;
$page_per_list=10;

if(!strcmp($_GET['page'], '') || !strcmp($_GET['page'], '1')){
	$page = '1';
}else{
	$page = $_GET['page'];
	$i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page||hero_idx");

$sql  = " SELECT a.*, l.hero_name as level_name FROM admin a ";
$sql .= " LEFT JOIN level l ON a.hero_level = l.hero_level ";
$sql .= " WHERE a.hero_use = 0 AND a.hero_level<= '".$_SESSION['temp_level']."' ".$search." ORDER BY a.hero_idx DESC LIMIT ".$start.",".$list_page;

$list_res = sql($sql);
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="page" value="<?=$page?>" />
<input type="hidden" name="view" value="" />
<input type="hidden" name="hero_idx" value="" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
		    	<option value="a.hero_id"<?if(!strcmp($_REQUEST['select'], 'a.hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
				<option value="a.hero_name"<?if(!strcmp($_REQUEST['select'], 'a.hero_name')){echo ' selected';}else{echo '';}?>>성명</option>
				<option value="a.hero_nick"<?if(!strcmp($_REQUEST['select'], 'a.hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
				<option value="a.hero_hp"<?if(!strcmp($_REQUEST['select'], 'a.hero_hp')){echo ' selected';}else{echo '';}?>>연락처</option>
				<option value="a.hero_mail"<?if(!strcmp($_REQUEST['select'], 'a.hero_mail')){echo ' selected';}else{echo '';}?>>이메일</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">
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
<colgroup>
	<col width="15%" />
	<col width="15%" />
	<col width="15%" />
	<col width="15%" />
	<col width="20%" />
	<col width="10%" />
	<col width="10%" />
</colgroup>
<thead>
<tr>
	<th>아이디</th>
	<th>성명</th>
	<th>닉네임</th>
	<th>연락처</th>
	<th>이메일</th>
	<th>등록일</th>
	<th>등급</th>
</tr>
</thead>
<tbody>
<? while($list = @mysql_fetch_assoc($list_res)){ ?>
<tr onClick="fnView('<?=$list["hero_idx"]?>')">
	<td><?=$list['hero_id'];?></td>
    <td><?=$list['hero_name'];?></td>
	<td><?=$list['hero_nick'];?></td>
	<td><?=$list['hero_hp'];?></td>
	<td><?=$list['hero_mail'];?></td>
    <td><?=date( "Y-m-d", strtotime($list['hero_today']));?></td>
    <td><?=$list['level_name'];?></td>
</tr>
<? } ?>
</tbody>
</table>
<div class="btnGroup">
	<div class="r">
		<a href="javascript:;" onClick="fnWrite()" class="btnAdd">등록</a>
	</div>
</div>
<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){
	fnWrite = function(){
		$("input[name='view']").val("01_write");
		$("#searchForm").submit();
	}
	
	fnView = function(hero_idx){
		$("#searchForm input[name='hero_idx']").val(hero_idx);
		$("#searchForm input[name='view']").val("01_view");
		$("#searchForm").submit();
	}
	
	fnSearch = function() {
		$("#searchForm input[name='page']").val("1");
		$("#searchForm").submit();
	}
})
</script>
