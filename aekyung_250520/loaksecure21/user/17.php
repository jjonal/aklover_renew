<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["url"]) {
	$search .= " AND ".$_GET["hero_blog"]." like '%".$_GET["url"]."%' ";
}

if($_GET["kewyword"]) {
	$search .= " AND ".$_GET["select"]." = '".$_GET["kewyword"]."' ";
}

//페이지 넘버링
$total_sql = " SELECT count(*) as cnt FROM member WHERE hero_use=0 ".$search;
sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];

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
$next_path=get("page");

$sql  = " SELECT hero_name, hero_hp , hero_id, hero_nick, hero_blog_00 ";
$sql .= " , hero_blog_01, hero_blog_02, hero_blog_03 ";
$sql .= " , hero_blog_04, hero_blog_05, hero_blog_06, hero_blog_07, hero_blog_08  ";
$sql .= " FROM member where hero_use=0 ".$search;
$sql .= " ORDER BY hero_oldday DESC LIMIT ".$start.",".$list_page;

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
		<th>SNS URL</th>
		<td>
			<select name="hero_blog">
				<option value="hero_blog_00" <?=$_GET["hero_blog"]=="hero_blog_00" ? "selected":""?>>네이버 블로그</option>
				<option value="hero_blog_04" <?=$_GET["hero_blog"]=="hero_blog_04" ? "selected":""?>>인스타그램</option>
				<option value="hero_blog_05" <?=$_GET["hero_blog"]=="hero_blog_05" ? "selected":""?>>그 외 SNS URL</option>
				<option value="hero_blog_03" <?=$_GET["hero_blog"]=="hero_blog_03" ? "selected":""?>>유튜브</option>
				<option value="hero_blog_06" <?=$_GET["hero_blog"]=="hero_blog_06" ? "selected":""?>>네이버TV</option>
				<option value="hero_blog_07" <?=$_GET["hero_blog"]=="hero_blog_07" ? "selected":""?>>틱톡</option>
				<option value="hero_blog_08" <?=$_GET["hero_blog"]=="hero_blog_08" ? "selected":""?>>기타(영상)</option>
			</select>
			<input type="text" name="url" value="<?=$_REQUEST["url"];?>" class="kewyword">		
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
		    	<option value="hero_name" <?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>이름</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
		    	<option value="hero_hp" <?if(!strcmp($_REQUEST['select'], 'hero_hp')){echo ' selected';}else{echo '';}?>>휴대폰번호</option>
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
	<col width="4%" />
	<col width="5%" />
	<col width="5%" />
	<col width="5%" />
	<col width="8%" />
	<col width="11%" />
	<col width="11%" />
	<col width="11%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
</colgroup>
<thead>
<tr>
	<th>NO</th>
	<th>이름</th>
	<th>아이디</th>
	<th>닉네임</th>
	<th>휴대폰번호</th>
	<th>네이버 블로그</th>
	<th>인스타그램</th>
	<th>그 외 SNS 주소</th>
	<th>유튜브</th>
	<th>네이버TV</th>
	<th>틱톡</th>
	<th>기타(영상)</th>
</tr>
</thead>
<?
if($total_data > 0) {
while($list = mysql_fetch_assoc($list_res)) {?>
<tr>
	<td><?=$i?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["hero_hp"]?></td>
	<td class="title"><?=$list["hero_blog_00"]?></td>
	<td class="title"><?=$list["hero_blog_04"]?></td>
	<td class="title"><?=$list["hero_blog_05"]?></td>
	<td class="title"><?=$list["hero_blog_03"]?></td>
	<td class="title"><?=$list["hero_blog_06"]?></td>
	<td class="title"><?=$list["hero_blog_07"]?></td>
	<td class="title"><?=$list["hero_blog_08"]?></td>
</tr>
<? 
$i--;
} 
} else {
?>
<tr>
	<td colspan="12">등록된 데이터가 없습니다.</td>
</tr>
<?}?>
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


