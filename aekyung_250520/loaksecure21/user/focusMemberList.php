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

//����Ʈ
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
		<th>���</th>
		<td colspan="3">
			<select name="gisu">
				<? for($k=$gisu; $k>0; $k--) {?>
				<option value="<?=$k?>" <?=$k==$_GET["gisu"] ? "selected":"";?>><?=$k?></option>
				<? } ?>
			</select>
		</td>
	</tr>
	<tr>
		<th>ȸ������</th>
		<td colspan="3">
			<input type="radio" name="hero_use" id="hero_use_all" value="" <?=!$_GET["hero_use"] ? "checked":""?>/><label for="hero_use_all">��ü</label>
			<input type="radio" name="hero_use" id="hero_use_0" value="0" <?=$_GET["hero_use"]=="0" ? "checked":""?>/><label for="hero_use_0">ȸ��</label>
			<input type="radio" name="hero_use" id="hero_use_1" value="1" <?=$_GET["hero_use"]=="1" ? "checked":""?>/><label for="hero_use_1">Ż��</label>
			<input type="radio" name="hero_use" id="hero_use_2" value="2" <?=$_GET["hero_use"]=="2" ? "checked":""?>/><label for="hero_use_2">�޸�ȸ��</label>
		</td>
	</tr>
	<tr>
		<th>SMS ���ŵ���</th>
		<td>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_all" value="" <?=!$_GET["hero_chk_phone"] ? "checked":""?>/><label for="hero_chk_phone_all">��ü</label>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_1" value="1" <?=$_GET["hero_chk_phone"]=="1" ? "checked":""?>/><label for="hero_chk_phone_1">����</label>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_2" value="2" <?=$_GET["hero_chk_phone"]=="2" ? "checked":""?>/><label for="hero_chk_phone_2">�̵���</label>
		</td>
		<th>�̸��� ���ŵ���</th>
		<td>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_all" value="" <?=!$_GET["hero_chk_email"] ? "checked":""?>/><label for="hero_chk_email_all">��ü</label>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_1" value="1" <?=$_GET["hero_chk_email"]=="1" ? "checked":""?>/><label for="hero_chk_email_1">����</label>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_2" value="2" <?=$_GET["hero_chk_email"]=="2" ? "checked":""?>/><label for="hero_chk_email_2">�̵���</label>	
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div>

<div class="listExplainWrap">
	<label>�� </label> : <strong><?=$total_data?></strong>��
</div>

<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">�����ٿ�ε�</a>
		<a href="javascript:;" class="btnFormExcel" onClick="fnAllGisuExcel();">���� ��ü���</a>
		<select name="list_count" onchange="fnListCount()">
        	<option value="">��� ��</option>
            <option value="20"<?if(!strcmp($_REQUEST['list_count'], '20')){echo ' selected';}else{echo '';}?>>20��</option>
        	<option value="30"<?if(!strcmp($_REQUEST['list_count'], '30')){echo ' selected';}else{echo '';}?>>30��</option>
	        <option value="50"<?if(!strcmp($_REQUEST['list_count'], '50')){echo ' selected';}else{echo '';}?>>50��</option>
            <option value="100"<?if(!strcmp($_REQUEST['list_count'], '100')){echo ' selected';}else{echo '';}?>>100��</option>
            <option value="250"<?if(!strcmp($_REQUEST['list_count'], '250')){echo ' selected';}else{echo '';}?>>250��</option>
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
	<th>��ȣ</th>
	<th>������ȣ</th>
	<th>���̵�</th>
	<th>�̸�</th>
	<th>�г���</th>
	<th>����</th>
	<th>���</th>
	<th>ȸ������</th>
	<th>SMS���ŵ���</th>
	<th>�̸��ϼ��ŵ���</th>
</tr>
</thead>
<? if($total_data > 0) { 
	$member_status = array("0"=>"ȸ��","1"=>"Ż��","2"=>"�޸�ȸ��");
	while($list = mysql_fetch_assoc($list_res)) {
	$hero_chk_phone_txt = "�̵���";
	if($list["hero_chk_phone"]=="1") $hero_chk_phone_txt = "����";
	
	$hero_chk_email_txt = "�̵���";
	if($list["hero_chk_email"]=="1") $hero_chk_email_txt = "����";
	
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
	<td colspan="10">��ϵ� �����Ͱ� �����ϴ�.</td>
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