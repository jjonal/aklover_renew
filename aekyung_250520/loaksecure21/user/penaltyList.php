<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["type"]) {
	$search .= " AND p.type = '".$_GET["type"]."' ";
}

if($_GET["kewyword"]) {
	$search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}

//페이지 넘버링
$total_sql  = " SELECT count(*) as cnt FROM member_penalty p ";
$total_sql .= " LEFT JOIN member m ON p.hero_code = m.hero_code ";
$total_sql .= " WHERE p.hero_use_yn='Y' ".$search;
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

$sql  = " SELECT p.type, p.memo, p.hero_today ";
$sql .= " , m.hero_id, m.hero_name, m.hero_nick, m.hero_sex , m.hero_level ";
$sql .= " , m.hero_jumin, m.hero_use, m.hero_level ";
$sql .= " FROM member_penalty p ";
$sql .= " LEFT JOIN member m ON p.hero_code = m.hero_code ";
$sql .= " WHERE p.hero_use_yn='Y' ".$search;
$sql .= " ORDER BY p.hero_idx DESC LIMIT ".$start.",".$list_page;

$list_res = sql($sql);

$type_arr = array("1"=>"이중아이디","2"=>"가이드라인 미준수","3"=>"후기 미등록","4"=>"오프라인 모임 미참여","5"=>"풍평/설문 미진행","9"=>"기타");
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
		<th>패널티 타입</th>
		<td>
			<select name="type">
				<option value="">선택</option>
				<option value="1" <?=$_GET["type"]=="1" ? "selected":""?>>이중아이디</option>
				<option value="2" <?=$_GET["type"]=="2" ? "selected":""?>>가이드라인 미준수</option>
				<option value="3" <?=$_GET["type"]=="3" ? "selected":""?>>후기 미등록</option>
				<option value="4" <?=$_GET["type"]=="4" ? "selected":""?>>오프라인 모임 미참여</option>
				<option value="5" <?=$_GET["type"]=="5" ? "selected":""?>>품평/설문 미진행</option>
				<option value="9" <?=$_GET["type"]=="9" ? "selected":""?>>기타</option>
			</select>	
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
				<option value="p.memo" <?if(!strcmp($_REQUEST['select'], 'p.memo')){echo ' selected';}else{echo '';}?>>내용</option>
		    	<option value="m.hero_nick" <?if(!strcmp($_REQUEST['select'], 'm.hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
		    	<option value="m.hero_name" <?if(!strcmp($_REQUEST['select'], 'm.hero_name')){echo ' selected';}else{echo '';}?>>이름</option>
		    	<option value="m.hero_id" <?if(!strcmp($_REQUEST['select'], 'm.hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
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
	<col width="7%" />
	<col width="7%" />
	<col width="7%" />
	<col width="5%" />
	<col width="5%" />
	<col width="5%" />
	<col width="5%" />
	<col width="10%" />
	<col width="*" />
	<col width="15%" />
</colgroup>
<thead>
<tr>
	<th>NO</th>
	<th>이름</th>
	<th>아이디</th>
	<th>닉네임</th>
	<th>나이</th>
	<th>성별</th>
	<th>레벨</th>
	<th>회원상태</th>
	<th>패널티 타입</th>
	<th>내용</th>
	<th>등록일</th>
</tr>
</thead>
<?
if($total_data > 0) {
while($list = mysql_fetch_assoc($list_res)) {
	$age = "";
	if($list["hero_jumin"]) {
		$age = (date("Y")-substr($list["hero_jumin"],0,4))+1;
	}
	
	$hero_sex_txt = "";
	if($list["hero_sex"] == 1) {
		$hero_sex_txt = "남";
	} else if(strlen($list["hero_sex"]) > 0 && $list["hero_sex"] == 0) {
		$hero_sex_txt = "여";
	}
	
	$hero_use_txt = "";
	if($list["hero_use"] == 0) {
		$hero_use_txt = "회원";
	} else if($list["hero_use"] == 1) {
		$hero_use_txt = "탈퇴";
	} else if($list["hero_use"] == 2) {
		$hero_use_txt = "휴먼회원";
	}
?>
<tr>
	<td><?=$i?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$age?></td>
	<td><?=$hero_sex_txt?></td>
	<td><?=$list["hero_level"]?></td>
	<td><?=$hero_use_txt?></td>
	<td><?=$type_arr[$list["type"]]?></td>
	<td class="title"><?=$list["memo"]?></td>
	<td><?=substr($list["hero_today"],0,10)?></td>
</tr>
<? 
$i--;
} 
} else {
?>
<tr>
	<td colspan="11">등록된 데이터가 없습니다.</td>
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


