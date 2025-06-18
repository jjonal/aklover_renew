<?
if(!defined('_HEROBOARD_'))exit;

$search = "";
$sub_search = "";

if($_GET["startDate"]) {
	$sub_search .= " AND date_format(hero_today,'%Y-%m-%d') >= '".$_GET["startDate"]."' ";
}

if($_GET["endDate"]) {
	$sub_search .= " AND date_format(hero_today,'%Y-%m-%d') <= '".$_GET["endDate"]."' ";
}

if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  m.".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

$total_sql  = " SELECT count(*) cnt from ( ";
$total_sql .= " SELECT m.hero_code FROM member m WHERE m.hero_use = 0 AND m.hero_code != '' ".$search;
$total_sql .= " GROUP BY m.hero_code) m ";

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
$sql  = " SELECT hero_code, hero_id, hero_name, hero_nick, review_cnt, board_cnt, reply_cnt FROM (";
$sql .= " SELECT m.hero_code,  m.hero_id, m.hero_name, m.hero_nick ";
$sql .= " , (SELECT COUNT(*) FROM board WHERE ";
$sql .= " hero_table IN ('group_04_05','group_04_06','group_04_07','group_04_08','group_04_09' ";
$sql .= " ,'group_04_10','group_04_23','group_04_25','group_04_27','group_04_28') AND hero_code = m.hero_code ".$sub_search.") review_cnt ";
$sql .= " , (SELECT COUNT(*) FROM board WHERE ";
$sql .= " hero_table = 'group_02_02' AND hero_code = m.hero_code ".$sub_search.") board_cnt ";
$sql .= " , (SELECT COUNT(*) FROM review WHERE hero_code = m.hero_code ".$sub_search.") reply_cnt ";
$sql .= " FROM member m ";
$sql .= " WHERE m.hero_use = 0 AND m.hero_code != '' ".$search;
$sql .= " GROUP BY m.hero_code " ;
if(!$_GET["order"]) {
	$sql .= " ORDER BY m.hero_code DESC ";
	$sql .= " LIMIT ".$start.",".$list_page;
}
$sql .= " ) m ";
if($_GET["order"]) {
	$sort_arr = explode("_",$_GET["order"]);
	
	if($sort_arr[0] == "up") {
		$sort = " DESC ";
	} else if($sort_arr[0] == "down") {
		$sort = " ASC ";
	} 
	
	$sql .= " ORDER by ".$sort_arr[1]."_cnt ".$sort;
	$sql .= " LIMIT ".$start.",".$list_page;
}
$list_res = sql($sql);
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="order" value="<?=$_GET["order"]?>" />
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
		    	<option value="hero_nick"<?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
		    	<option value="hero_id"<?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
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
	<col width="*" />
	<col width="13%" />
	<col width="13%" />
	<col width="7%" />
	<col width="7%" />
	<col width="7%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
</colgroup>
<thead>
<tr>
	<th>No</th>
	<th>아이디</th>
	<th>닉네임</th>
	<th>성명</th>
	<th>
		<a href="javascript:;" onClick="fnOrder('up_review')">
			<?=$_GET["order"]=="up_review" ?"▲":"△";?>
		</a>
		체험단 후기 수
		<a href="javascript:;" onClick="fnOrder('down_review')">
			<?=$_GET["order"]=="down_review" ?"▼":"▽";?>
		</a>
	</th>
	<th>
		<a href="javascript:;" onClick="fnOrder('up_board')">
			<?=$_GET["order"]=="up_board" ?"▲":"△";?>
		</a>
		작성글  수
		<a href="javascript:;" onClick="fnOrder('down_board')">
			<?=$_GET["order"]=="down_board" ?"▼":"▽";?>	
		</a>
	</th>
	<th>
		<a href="javascript:;" onClick="fnOrder('up_reply')">
			<?=$_GET["order"]=="up_reply" ?"▲":"△";?>
		</a>
		댓글  수
		<a href="javascript:;" onClick="fnOrder('down_reply')">
			<?=$_GET["order"]=="down_reply" ?"▼":"▽";?>	
		</a>
	</th>
	<th>후기 보기</th>
	<th>작성글 보기</th>
	<th>댓글 보기</th>
</tr>
</thead>
<? if($total_data > 0) {
	while($list = mysql_fetch_assoc($list_res)) {
?>
<tr>
	<td><?=$i?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=number_format($list["review_cnt"])?></td>
	<td><?=number_format($list["board_cnt"])?></td>
	<td><?=number_format($list["reply_cnt"])?></td>
	<td><a href="javascript:;" onClick="location.href='<?=PATH_HOME.'?board='.$_GET['board'].'&idx='.$_GET['idx'].'&view=reviewView&hero_code='.$list['hero_code'];?>'" class="btnForm">확인</a></td>
	<td><a href="javascript:;" onClick="location.href='<?=PATH_HOME.'?board='.$_GET['board'].'&idx='.$_GET['idx'].'&view=boardView&hero_code='.$list['hero_code'];?>'" class="btnForm">확인</a></td>
	<td><a href="javascript:;" onClick="location.href='<?=PATH_HOME.'?board='.$_GET['board'].'&idx='.$_GET['idx'].'&view=replyView&hero_code='.$list['hero_code'];?>'" class="btnForm">확인</a></td>
</tr>
<? 
$i--;
}
} else { ?>
<tr>
	<td colspan="10">등록된 데이터가 없습니다.</td>
</tr>
<? } ?>
</table>
<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){
	fnOrder = function(sort) {
		$("#searchForm input[name='order']").val(sort);
		$("#searchForm").attr("action","").submit();
	}
	
	fnSearch = function() {
		$("#searchForm input[name='order']").val("");
		$("#searchForm").attr("action","").submit();
	}
})
</script>