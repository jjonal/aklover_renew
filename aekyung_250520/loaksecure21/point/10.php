<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

$total_sql = "SELECT count(*) as cnt FROM member WHERE (hero_user is not null AND hero_user != '') ".$search."";
sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];

$i=$total_data;

$list_page=$_REQUEST['list_count']==""?20:$_REQUEST['list_count'];
$page_per_list=10;

if(!strcmp($_GET['page'], '')) {
	$page = '1';
} else {
	$page = $_GET['page'];
	$i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql  = " SELECT hero_code, hero_id, hero_name, hero_nick, hero_user_type, hero_user, hero_oldday ";
$sql .= " , (SELECT hero_point FROM point WHERE hero_type = 'member' and hero_recommand = member.hero_code) AS hero_point ";
$sql .= " FROM member ";
$sql .= " WHERE (hero_user is not null AND hero_user != '') ".$search;
$sql .= " ORDER BY hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page;
$list_res = sql($sql);
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="page" value="<?=$page?>" />
<input type="hidden" name="hero_code" value="" />
<input type="hidden" name="view" value="" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>기간</th>
		<td><input type="text" name="hero_point_start" numberOnly value="<?=$_GET["hero_point_start"]?>"/> ~ <input type="text" name="hero_point_end" numberOnly value="<?=$_GET["hero_point_end"]?>"/></td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
		    	<option value="hero_name" <?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>이름</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
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
<label>총 </label> : <strong><?=number_format($total_data)?></strong>건
</div>

<table class="t_list">
<colgroup>
	<col width="6%" />
	<col width="15%" />
	<col width="15%" />
	<col width="15%" />
	<col width="*" />
	<col width="15%" />
	<col width="15%" />
</colgroup>
<thead>
<tr>
	<th>NO</th>
	<th>아이디</th>
	<th>닉네임</th>
	<th>추천방법</th>
	<th>추천인 아이디/닉네임</th>
	<th>포인트</th>
	<th>등록일(포인트 적립일)</th>
</tr>
</thead>
<? if($total_data > 0) {
	while($list = mysql_fetch_assoc($list_res)) {
?>
<tr>
	<td><?=$i?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["hero_user_type"]?></td>
	<td><?=$list["hero_user"]?></td>
	<td><?=$list["hero_point"]?></td>
	<td><?=$list["hero_oldday"]?></td>
</tr>
<? 
	$i--;
	}
} else {?>
<tr>
	<td colspan="7">등록된 데이터가 없습니다.</td>
</tr>
<? }?>
</table>
<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>