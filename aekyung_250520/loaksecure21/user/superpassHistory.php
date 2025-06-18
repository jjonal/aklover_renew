<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["superpass_check"]) {
	$search .= " AND superpass_check = '".$_GET["superpass_check"]."' ";
}

if($_GET["kewyword"]) {
	$search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}

$total_sql  = " SELECT count(*) as cnt  ";
$total_sql .= " FROM superpass_history s INNER JOIN member m ON s.hero_code = m.hero_code ";
$total_sql .= " WHERE 1=1 ".$search;

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

$sql  = " SELECT ";
$sql .= " m.hero_nick, m.hero_id, m.hero_name, s.panelty_check, s.login_a_month_ago_check  ";
$sql .= " , s.blog_check, s.write_check, s.superpass_check, s.hero_today  ";
$sql .= " FROM superpass_history s INNER JOIN member m ON s.hero_code = m.hero_code ";
$sql .= " WHERE 1=1 ".$search;
$sql .= " ORDER BY s.hero_idx DESC LIMIT ".$start.",".$list_page;


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
		<th>지급/미지급</th>
		<td>
			<input type="radio" name="superpass_check" id="superpass_check" <?=!$_GET["superpass_check"] ? "checked":""; ?> value=""><label for="superpass_check">전체</label>
			<input type="radio" name="superpass_check" id="superpass_check_y" <?=$_GET["superpass_check"]=="Y" ? "checked":""; ?> value="Y"><label for="superpass_check_y">지급</label>
			<input type="radio" name="superpass_check" id="superpass_check_n" <?=$_GET["superpass_check"]=="N" ? "checked":""; ?> value="N"><label for="superpass_check_n">미지급</label>
		</td>
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

<div class="view_title_box">
	<p><label>슈퍼패스 조건</label></p>
	<p>
	1. 매달 처음 로그인할 때 지급 가능</br>
	2. 로그인 시점에 3개월 이전에 패널티가 없어야 함</br>
	3. 로그인 시점에 한달 전에 로그인한 기록이 있어야함 </br>
	4. 블로그+영상 url 존재</br>
	5. 한달이전에 등록한 글 또는 댓글 존재</br></br>
	ex) 1번 조건이 성립되지 않으면 히스토리가 없음
	</p>
</div>

<div class="listExplainWrap mgb10">
<label>총 </label> : <strong><?=number_format($total_data)?></strong>건
</div>

<table class="t_list">
<colgroup>
	<col width="4%" />
	<col width="8%" />
	<col width="8%" />
	<col width="8%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="*" />
</colgroup>
<thead>
<tr>
	<th>NO</th>
	<th>이름</th>
	<th>아이디</th>
	<th>닉네임</th>
	<th>패널티</th>
	<th>한달 전 로그인</th>
	<th>블로그/영상</th>
	<th>작성글</th>
	<th>지급유무</th>
	<th>로그인날짜</th>
</tr>
</thead>
<?
if($total_data > 0) {
while($list = mysql_fetch_assoc($list_res)) {
	$superpass_txt = "";
	if($list["superpass_check"] == "Y") {
		$superpass_txt = "지급";
	} else {
		$superpass_txt = "미지급";
	}
?>
<tr>
	<td><?=$i?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["panelty_check"]?></td>
	<td><?=$list["login_a_month_ago_check"]?></td>
	<td><?=$list["blog_check"]?></td>
	<td><?=$list["write_check"]?></td>
	<td><?=$superpass_txt?></td>
	<td><?=$list["hero_today"]?></td>
</tr>
<? 
$i--;
} 
} else {
?>
<tr>
	<td colspan="10">등록된 데이터가 없습니다.</td>
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


