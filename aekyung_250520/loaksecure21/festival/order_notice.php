<?
if(!defined('_HEROBOARD_'))exit;

$total_sql = " SELECT count(*) as cnt FROM order_notice";
sql($total_sql);
$out_sql = @mysql_fetch_assoc ($out_sql);
$total_data = $out_sql['cnt'];
$i=$total_data;

$list_page = 20;
$page_per_list = 10;

if(!strcmp($_GET['page'], '') || !strcmp($_GET['page'], '1')){
	$page = '1';
}else{
	$page = $_GET['page'];
	$i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql = " SELECT * FROM order_notice ORDER BY hero_idx DESC LIMIT ".$start.", ".$list_page;
$list_res = sql($sql);
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="page" value="<?=$_GET["page"]?>" />
<input type="hidden" name="hero_idx" value="" />
<input type="hidden" name="view" value="" />
</form>
<table class="t_list">
<thead>
<tr>
	<th width="5%">NO</th>
	<th width="60%">제목</th>
	<th width="15%">등록일</th>
</tr>
</thead>
<?
if($total_data > 0){
	while($rs = mysql_fetch_array($list_res)){
?>
<tr onClick="fnView('<?=$rs["hero_idx"]?>')" style="cursor:pointer">
	<td><?=$i?></td>
	<td class="title"><?=$rs["hero_title"]?></td>
	<td><?=substr($rs["hero_regdate"], 0, 10)?></td>
</tr>
<?
	$i--;
	}
}else{
?>
<tr>
	<td colspan="3">등록된 데이터가 없습니다.</td>
</tr>
<?
}
?>
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
		$("input[name='view']").val("order_notice_write");
		$("#searchForm").submit();
	}
	
	fnView = function(hero_idx) {
		$("input[name='hero_idx']").val(hero_idx);
		$("input[name='view']").val("order_notice_write");
		$("#searchForm").submit();
		
	}
})
</script>