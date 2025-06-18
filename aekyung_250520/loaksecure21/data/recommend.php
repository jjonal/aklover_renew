<? 
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["startDate"]) {
	$search .= " AND date_format(hero_today,'%Y-%m-%d') >= '".$_GET["startDate"]."' ";
}

if($_GET["endDate"]) {
	$search .= " AND date_format(hero_today,'%Y-%m-%d') <= '".$_GET["endDate"]."' ";
}

if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

$total_sql  = " SELECT count(*) cnt FROM (";
$total_sql .= " SELECT hero_id, hero_nick FROM point ";
$total_sql .= " WHERE hero_type='member' and hero_title='추천인포인트' ".$search." GROUP by hero_code) a ";

sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];

$i=$total_data;

$list_page=20;
$page_per_list=10;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];

$i = $i-($page-1)*$list_page;


$start = ($page-1)*$list_page;
$next_path=get("page");

//리스트
$sql  = " SELECT * FROM (";
$sql .= " SELECT hero_id, hero_nick, count(*) total FROM point ";
$sql .= " WHERE hero_type='member' and hero_title='추천인포인트' ".$search." GROUP by hero_code) a ";
$sql .= " ORDER BY total DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql);
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
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
				<option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>추천받은 닉네임</option>
		    	<option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>추천받은 아이디</option>
		  		<option value="hero_all" <?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>닉네임+아이디</option>
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
	<label>총 </label> : <strong><?=number_format($total_data)?></strong>건</span>
</div>

<table class="t_list">
<colgroup>
	<col width="10%" />
	<col width="30%" />
	<col width="30%" />
	<col width="30%" />
</colgroup>
<thead>
<tr>
	<th>No</th>
	<th>추천받은 사람 ID</th>
	<th>추천받은  사람 닉네임</th>
	<th>추천 수 합계</th>
</tr>
</thead>
<? if($total_data > 0) {
	while($list = mysql_fetch_assoc($list_res)) {
?>
<tr>
	<td><?=$i;?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=number_format($list["total"])?></td>
</tr>
<? 
$i--;
}
} else { ?>
<tr>
	<td colspan="4">등록된 데이터가 없습니다.</td>
</tr>
<? } ?>
</table>
<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){
	fnSearch = function() {
		$("#searchForm").attr("action","").submit();
	}
})
</script>



