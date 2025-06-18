<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["startDate"]) {
	$search .= " AND date_format(b.hero_today,'%Y-%m-%d') >= '".$_GET["startDate"]."' ";
}

if($_GET["endDate"]) {
	$search .= " AND date_format(b.hero_today,'%Y-%m-%d') <= '".$_GET["endDate"]."' ";
}

if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

$total_sql  = " SELECT count(*) cnt FROM review r  ";
$total_sql .= " LEFT JOIN board b ON r.hero_old_idx = b.hero_idx ";
$total_sql .= " LEFT JOIN hero_group g ON r.hero_table = g.hero_board ";
$total_sql .= " WHERE ";
$total_sql .= "	r.hero_code = '".$_GET["hero_code"]."' ".$search;

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
$sql  = " SELECT r.hero_command, r.hero_today, b.hero_title, m.hero_nick, g.hero_title as hero_menu FROM review r  ";
$sql .= " LEFT JOIN board b ON r.hero_old_idx = b.hero_idx ";
$sql .= " LEFT JOIN member m ON r.hero_code = m.hero_code ";
$sql .= " LEFT JOIN hero_group g ON r.hero_table = g.hero_board ";
$sql .= " WHERE ";
$sql .= " r.hero_code = '".$_GET["hero_code"]."' ".$search;
$sql .= " ORDER BY r.hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql);
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="hero_code" value="<?=$_GET["hero_code"]?>" />
<input type="hidden" name="view" value="<?=$_GET["view"]?>" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>등록일</th>
		<td>
			<input type="text" name="startDate" class="dateMode" value="<?=$_REQUEST['startDate']?>"> ~ 
			<input type="text" name="endDate" class="dateMode" value="<?=$_REQUEST['endDate']?>">
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
				<option value="r.hero_command"<?if(!strcmp($_REQUEST['select'], 'r.hero_command')){echo ' selected';}else{echo '';}?>>댓글</option>
		    	<option value="g.hero_title"<?if(!strcmp($_REQUEST['select'], 'g.hero_title')){echo ' selected';}else{echo '';}?>>메뉴명</option>
		    	<option value="b.hero_title"<?if(!strcmp($_REQUEST['select'], 'b.hero_title')){echo ' selected';}else{echo '';}?>>제목</option>
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
	<col width="6%" />
	<col width="10%" />
	<col width="*" />
	<col width="30%" />
	<col width="10%" />
	<col width="15%" />
</colgroup>
<thead>
<tr>
	<th>No</th>
	<th>메뉴명</th>
	<th>게시판 제목</th>
	<th>댓글</th>
	<th>닉네임</th>
	<th>등록일</th>
</tr>
</thead>
<? if($total_data > 0) {
	while($list = mysql_fetch_assoc($list_res)) {
?>
<tr>
	<td><?=$i?></td>
	<td><?=$list["hero_menu"]?></td>
	<td class="title"><?=$list["hero_title"]?></td>
	<td class="title"><?=nl2br($list["hero_command"])?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["hero_today"]?></td>
</tr>
<? 
$i--;
}
} else { ?>
<tr>
	<td colspan="6">등록된 데이터가 없습니다.</td>
</tr>
<? } ?>
</table>

<div class="btnGroupL">
	<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&page=<?=$_GET['page']?>&idx=<?=$_GET["idx"]?>" class="btnList">목록</a>
</div>

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