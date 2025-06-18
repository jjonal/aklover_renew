<?php 
if(!defined('_HEROBOARD_'))exit;

//include_once '../combined/admin_user_manager.php';

$search = "";

if($_GET["hero_today_start"]) {
	$search .= " AND date_format(hero_regdate,'%Y-%m-%d') >= '".$_GET["hero_today_start"]."' ";
}

if($_GET["hero_today_end"]) {
	$search .= " AND date_format(hero_regdate,'%Y-%m-%d') <= '".$_GET["hero_today_end"]."' ";
}

if($_GET["hero_table"]){
	$search .= " AND m.hero_table = '".$_GET["hero_table"]."' ";
}

if($_GET["pointType"]){
	if($_GET["pointType"] == 'Plus') $search .=" and hero_order_point > 0 ";
	else if($_GET["pointType"] == 'Minus') $search .=" and hero_order_point < 0 ";
}

if($_GET["kewyword"]){
	$search .= " AND o.".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

// 페이징을 위한 데이타 총 갯수
$total_sql  = " SELECT count(*) AS cnt FROM order_main o ";
$total_sql .= " INNER JOIN mission m ON o.mission_idx = m.hero_idx  WHERE hero_process='DE' ".$search;

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

$sql  = " SELECT o.hero_idx, o.hero_id, o.hero_name, o.hero_nick, o.hero_order_point, o.hero_regdate ";
$sql .= " ,m.hero_title AS  mission_title ";
$sql .= " , (SELECT hero_title FROM hero_group WHERE hero_board = m.hero_table) as menu ";
$sql .= " FROM order_main o ";
$sql .= " LEFT JOIN mission m ON o.mission_idx = m.hero_idx ";
$sql .= " WHERE o.hero_process='DE' ".$search;
$sql .= " ORDER BY o.hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page."";

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
		<th>배송비 기간 검색</th>
		<td>
			<input type="text" name="hero_today_start"  value="<?=$_GET['hero_today_start']?>" class="dateMode"/> ~ 
            <input type="text" name="hero_today_end"  value="<?=$_GET['hero_today_end']?>" class="dateMode"/>
		</td>
	</tr>
	<tr>
		<th>체험단</th>
		<td>
			<select name="hero_table">
				<option value="">선택</option>
				<option value="group_04_05" <?=$_GET["hero_table"]=="group_04_05" ? "selected":"";?>>체험단</option>
				<option value="group_04_06" <?=$_GET["hero_table"]=="group_04_06" ? "selected":"";?>>뷰티클럽</option>
				<option value="group_04_28" <?=$_GET["hero_table"]=="group_04_28" ? "selected":"";?>>라이프클럽</option>
				<option value="group_04_27" <?=$_GET["hero_table"]=="group_04_27" ? "selected":"";?>>유튜버</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>차감/반환</th>
		<td>
			<input type="radio" name="pointType"  id="pointAll" value="All" <?if($_GET['pointType']=="" || $_GET['pointType']=="All" ) echo checked;?>/><label for="pointAll">전체</label> 
			<input type="radio" name="pointType"  id="pointPlus" value="Plus" <?if($_GET['pointType']=="Plus" ) echo checked;?>/><label for="pointPlus">차감</label> 
			<input type="radio" name="pointType"  id="pointMinus" value="Minus" <?if($_GET['pointType']=="Minus" ) echo checked;?>/><label for="pointMinus">반환</label>
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
		    	<option value="hero_id" <?=$_GET['select'] == "hero_id" ? "selected" : ""?>>아이디</option>
				<option value="hero_name" <?=$_GET['select'] == "hero_name" ? "selected" : ""?>>성명</option>
				<option value="hero_nick" <?=$_GET['select'] == "hero_nick" ? "selected" : ""?>>닉네임</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?=$_REQUEST['kewyword'];;?>" class="kewyword">		
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
	<col width="8%" />
	<col width="8%" />
	<col width="8%" />
	<col width="8%" />
	<col width="5%" />
	<col width="*" />
	<col width="5%" />
</colgroup>
<thead>
	<tr>
		<th>적립일</th>
		<th>그룹</th>
		<th>아이디</th>
		<th>성명</th>
		<th>닉네임</th>
		<th>차감/반환</th>
		<th>체험단 명</th>
		<th>포인트</th>
	</tr>
</thead>
<? 
if($total_data > 0) {
while($list = @mysql_fetch_assoc($list_res)){
	$point = $list["hero_order_point"] * -1;
?>
<tr>
	<td><?=$list['hero_regdate']?></td>
	<td><?=$list['menu']?></td>
	<td><?=$list['hero_id']?></td>
	<td><?=name_masking($list['hero_name'])?></td>
	<td><?=$list['hero_nick']?></td>
	<td><?=$list['hero_order_point'] > 0 ? "차감":"반환";?></td>
	<td class="title"><?=strip_tags($list["mission_title"]);?></td>
	<td><?=$point?> P</td>
</tr>
<? }
} else {?>
<tr>
	<td colspan="8">등록된 데이터가 없습니다.</td>
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


    
    