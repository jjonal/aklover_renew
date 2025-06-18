<? 

if(!defined('_HEROBOARD_'))exit;
$gisu_sql = " SELECT * FROM mission_gisu ";
$gisu_res = sql($gisu_sql);
$gisu_rs = mysql_fetch_assoc($gisu_res);


$gisu = "";
$hero_board = "";
if($_GET["idx"] == "109") {
	$hero_board = "group_04_06";
} else if($_GET["idx"] == "110") {
	$hero_board = "group_04_28";
} else if($_GET["idx"] == "111") {
	$hero_board = "group_04_27";
} else if($_GET["idx"] == "135") {
	$hero_board = "group_04_31";
}

if(!$gisu) {	
	if($_GET["idx"] == "109") {
		$gisu = $gisu_rs["hero_beauty_gisu"];
	} else if($_GET["idx"] == "110") {
		$gisu = $gisu_rs["hero_life_gisu"];
	} else if($_GET["idx"] == "111") {
		$gisu = $gisu_rs["hero_moviebeauty_gisu"];
	} else if($_GET["idx"] == "135") {
		$gisu = $gisu_rs["hero_movielife_gisu"];
	}
}

$search = "";

if($_GET["gisu"]) {
	$search .= " AND gisu = '".$_GET["gisu"]."' ";
} else {
	$search .= " AND gisu = '$gisu' ";
}

if(strlen($_GET["hero_use"]) > 0 ) {
	$search .= " AND m.hero_use = '".$_GET["hero_use"]."' ";
}

if($_GET["hero_chk_phone"]) {
	if($_GET["hero_chk_phone"] == "1") {
		$search .= " AND m.hero_chk_phone = '".$_GET["hero_chk_phone"]."' ";
	} else if($_GET["hero_chk_phone"] == "2") {
		$search .= " AND m.hero_chk_phone != '1' ";
	}
}

if($_GET["hero_chk_email"]) {
	if($_GET["hero_chk_email"] == "1") {
		$search .= " AND m.hero_chk_email = '".$_GET["hero_chk_email"]."' ";
	} else if($_GET["hero_chk_email"] == "2") {
		$search .= " AND m.hero_chk_email != '1' ";
	}
}

$total_sql =  " SELECT count(*) as cnt FROM member_gisu g ";
$total_sql .= " INNER JOIN member m ON g.hero_code = m.hero_code";
$total_sql .= " WHERE g.hero_board = '".$hero_board."' ".$search;

$total_res = sql($total_sql);
$total_rs = mysql_fetch_assoc($total_res);
$total_data = $total_rs["cnt"];

$i=$total_data;

$list_page=$_REQUEST['list_count']==""?20:$_REQUEST['list_count'];
$page_per_list=10;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];

$i = $i-($page-1)*$list_page;


$start = ($page-1)*$list_page;
$next_path=get("page");

//리스트
$sql  = " SELECT g.gisu, m.hero_id,  m.hero_name, m.hero_nick, m.hero_use ";
$sql .= " , m.hero_level , m.hero_chk_phone, m.hero_chk_email, m.hero_code ";
$sql .= " FROM member_gisu g";
$sql .= " INNER JOIN member m ON g.hero_code = m.hero_code";
$sql .= " WHERE hero_board = '".$hero_board."' ".$search;
$sql .= " ORDER BY g.hero_id DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql);

?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="mode" value="" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>기수</th>
		<td colspan="3">
			<select name="gisu">
				<? for($k=$gisu; $k>0; $k--) {?>
				<option value="<?=$k?>" <?=$k==$_GET["gisu"] ? "selected":"";?>><?=$k?></option>
				<? } ?>
			</select>
		</td>
	</tr>
	<tr>
		<th>회원상태</th>
		<td colspan="3">
			<input type="radio" name="hero_use" id="hero_use_all" value="" <?=!$_GET["hero_use"] ? "checked":""?>/><label for="hero_use_all">전체</label>
			<input type="radio" name="hero_use" id="hero_use_0" value="0" <?=$_GET["hero_use"]=="0" ? "checked":""?>/><label for="hero_use_0">회원</label>
			<input type="radio" name="hero_use" id="hero_use_1" value="1" <?=$_GET["hero_use"]=="1" ? "checked":""?>/><label for="hero_use_1">탈퇴</label>
			<input type="radio" name="hero_use" id="hero_use_2" value="2" <?=$_GET["hero_use"]=="2" ? "checked":""?>/><label for="hero_use_2">휴먼회원</label>
		</td>
	</tr>
	<tr>
		<th>SMS 수신동의</th>
		<td>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_all" value="" <?=!$_GET["hero_chk_phone"] ? "checked":""?>/><label for="hero_chk_phone_all">전체</label>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_1" value="1" <?=$_GET["hero_chk_phone"]=="1" ? "checked":""?>/><label for="hero_chk_phone_1">동의</label>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_2" value="2" <?=$_GET["hero_chk_phone"]=="2" ? "checked":""?>/><label for="hero_chk_phone_2">미동의</label>
		</td>
		<th>이메일 수신동의</th>
		<td>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_all" value="" <?=!$_GET["hero_chk_email"] ? "checked":""?>/><label for="hero_chk_email_all">전체</label>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_1" value="1" <?=$_GET["hero_chk_email"]=="1" ? "checked":""?>/><label for="hero_chk_email_1">동의</label>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_2" value="2" <?=$_GET["hero_chk_email"]=="2" ? "checked":""?>/><label for="hero_chk_email_2">미동의</label>	
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div>

<div class="listExplainWrap">
	<label>총 </label> : <strong><?=$total_data?></strong>건
</div>

<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">엑셀다운로드</a>
		<a href="javascript:;" class="btnFormExcel" onClick="fnAllGisuExcel();">엑셀 전체기수</a>
		<select name="list_count" onchange="fnListCount()">
        	<option value="">출력 수</option>
            <option value="20"<?if(!strcmp($_REQUEST['list_count'], '20')){echo ' selected';}else{echo '';}?>>20개</option>
        	<option value="30"<?if(!strcmp($_REQUEST['list_count'], '30')){echo ' selected';}else{echo '';}?>>30개</option>
	        <option value="50"<?if(!strcmp($_REQUEST['list_count'], '50')){echo ' selected';}else{echo '';}?>>50개</option>
            <option value="100"<?if(!strcmp($_REQUEST['list_count'], '100')){echo ' selected';}else{echo '';}?>>100개</option>
            <option value="250"<?if(!strcmp($_REQUEST['list_count'], '250')){echo ' selected';}else{echo '';}?>>250개</option>
		</select>
	</div>
</div>
</form>

<table class="t_list">
<colgroup>
	<col width="6%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="*" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
</colgroup>
<thead>
<tr>
	<th>번호</th>
	<th>고유번호</th>
	<th>아이디</th>
	<th>이름</th>
	<th>닉네임</th>
	<th>레벨</th>
	<th>기수</th>
	<th>회원상태</th>
	<th>SMS수신동의</th>
	<th>이메일수신동의</th>
</tr>
</thead>
<? if($total_data > 0) { 
	$member_status = array("0"=>"회원","1"=>"탈퇴","2"=>"휴먼회원");
	while($list = mysql_fetch_assoc($list_res)) {
	$hero_chk_phone_txt = "미동의";
	if($list["hero_chk_phone"]=="1") $hero_chk_phone_txt = "동의";
	
	$hero_chk_email_txt = "미동의";
	if($list["hero_chk_email"]=="1") $hero_chk_email_txt = "동의";
	
	$all_gisu_sql = " SELECT gisu FROM member_gisu WHERE hero_board = '".$hero_board."' AND hero_code = '".$list["hero_code"]."' ORDER BY gisu DESC ";
	$all_gisu_res = sql($all_gisu_sql);

	$gisu_txt = "";
	while($all_gisu_list = mysql_fetch_assoc($all_gisu_res)) {
		if($gisu_txt) $gisu_txt .=", ";
		$gisu_txt .= $all_gisu_list["gisu"];
	}
?>
<tr>
	<td><?=$i?></td>
	<td><?=$list["hero_code"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["hero_level"]?></td>
	<td><?=$gisu_txt?></td>
	<td><?=$member_status[$list["hero_use"]]?></td>
	<td><?=$hero_chk_phone_txt?></td>
	<td><?=$hero_chk_email_txt?></td>
</tr>
<? $i--;}
} else {?>
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
	fnExcel = function() {
		$("#searchForm input[name='mode']").val("excel");
		$('#searchForm').attr('action','user/focusMemberExcel.php').submit();
	}

	fnAllGisuExcel = function() {
		$("#searchForm input[name='mode']").val("allGisuExcel");
		$("#searchForm").attr('action','user/focusAllMemberExcel.php').submit();
	}
	
	fnListCount = function() {
		$("#searchForm").attr("action","").submit();
	}
	
	fnSearch = function() {
		$("#searchForm").attr("action","").submit();
	}
});
</script>