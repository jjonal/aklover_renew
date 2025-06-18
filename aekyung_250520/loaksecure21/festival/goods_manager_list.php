<?
if(!defined('_HEROBOARD_'))exit;

//$total_sql = " SELECT hero_idx, hero_title,  startdate, enddate, hero_today FROM goods_manager WHERE hero_use = 0 ";
$total_sql = " SELECT count(*) cnt FROM goods_manager WHERE hero_use = 0 ";
sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res["cnt"];

$i = $total_data;

$list_page=10;
$page_per_list=5;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];

$i = $i-($page-1)*$list_page;

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql = " SELECT hero_idx, hero_title,  startdate, enddate, hero_today FROM goods_manager WHERE hero_use = 0 ORDER BY hero_idx DESC limit ".$start.",".$list_page;
$list_res = sql($sql);
?>
<div class="listExplainWrap mgb10">
	<label>총 </label> : <strong><?=$total_data?></strong>건
</div>

<form name="next_form" id="next_form">
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="hero_idx" id="hero_idx" value="" />
    <input type="hidden" name="hero_old_idx" id="hero_old_idx" value="" />
    <input type="hidden" name="type" id="type" value="" />
    <input type="hidden" name="view" id="view" value="" />
    <input type="hidden" name="page" id="page" value="<?=$page?>" />
</form>
<table class="t_list">
	<colgroup>
		<col width="5%" />
		<col width="*" />
		<col width="15%" />
		<col width="10%" />
		<col width="15%" />
	</colgroup>
	<thead>
		<tr>
			<th>No</th>
			<th>상품관리명</th>
			<th>축제 기간</th>
			<th>등록일</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody>
		<? 
		if($total_data > 0 ){
		while ($row = @mysql_fetch_assoc($list_res)){
			$row["startdate"] = date("Y-m-d H:i",$row["startdate"]);
			$row["enddate"] = date("Y-m-d H:i",$row["enddate"]);
			$row["hero_today"] = substr($row["hero_today"],0,10);
		?>
		<tr>
			<td><?=$i;?></td>
			<td class="title"><a href="#" style="color:#333;" onClick="goView('<?=$row["hero_idx"]?>')"><?=$row["hero_title"]?></a></td>
			<td><?=$row["startdate"]?> ~ <?=$row["enddate"]?></td>
			<td><?=$row["hero_today"];?></td>
			<td><a href="#" onClick="goGoods('<?=$row["hero_idx"]?>')" class=btnForm>상품등록</a></td>
		</tr>
		<? 
		$i--;
			}
		} else {?>
		<tr>
			<td colspan="5">등록된 데이터가 없습니다.</td>
		</tr>
		<? }?>
	</tbody>
</table>

<div class="btnGroup">
	<div class="r">
		<a href="<?=PATH_HOME.'?board='.$_GET['board'].'&idx='.$_GET['idx'].'&view=goods_manager_write'?>" class="btnAdd">등록</a>
	</div>
</div>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){
	goView = function(hero_idx) {
		$("#type").val("edit");
		$("#view").val("goods_manager_write");
		$("#hero_idx").val(hero_idx);
		$("#next_form").submit();
	}

	goGoods = function(hero_idx) {
		$("#view").val("goods_info");
		$("#hero_old_idx").val(hero_idx);
		$("#next_form").submit();
	}
})

</script>
                             