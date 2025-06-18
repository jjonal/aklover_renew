<? 
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["hero_country"]) {
	$search .= " AND hero_country = '".$_GET["hero_country"]."' ";
}

if($_GET["hero_age_start"]) {
	$birthYear = date("Y")-$_GET["hero_age_start"]+1;
	$search .= " AND substr(hero_jumin,1,4) <= '".$birthYear."' ";
}

if($_GET["hero_age_end"]) {
	$birthYear = date("Y")-$_GET["hero_age_end"]+1;
	$search .= " AND substr(hero_jumin,1,4) >= '".$birthYear."' ";
}

if($_GET["hero_oldday_start"]) {
	$search .= " AND date_format(hero_oldday,'%Y-%m-%d') >= '".$_GET["hero_oldday_start"]."' ";
}

if($_GET["hero_oldday_end"]) {
	$search .= " AND date_format(hero_oldday,'%Y-%m-%d') <= '".$_GET["hero_oldday_end"]."' ";
}

if($_GET["kewyword"]) {
	$search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}

$total_sql = " SELECT count(*) cnt FROM global_member WHERE hero_use = 0 ".$search;

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

//리스트
$sql  = " SELECT hero_country, hero_id, hero_nick, hero_name, hero_jumin  ";
$sql .= " , hero_code , hero_mail, hero_hp, hero_oldday ";
$sql .= " FROM global_member ";
$sql .= " WHERE hero_use = 0 ".$search;
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
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>국가</th>
		<td colspan="3">
			<input type="radio" name="hero_country" id="hero_country" value="" <?=!$_GET["hero_country"] ? "checked":"";?>/><label for="hero_country">전체</label>
			<input type="radio" name="hero_country" id="hero_country_vn" value="vn" <?=$_GET["hero_country"] == "2" ? "checked":"";?>/><label for="hero_country_vn">베트남</label>
			<input type="radio" name="hero_country" id="hero_country_ru" value="ru" <?=$_GET["hero_country"] == "3" ? "checked":"";?>/><label for="hero_country_ru">러시아</label>
			<input type="radio" name="hero_country" id="hero_country_cn" value="cn" <?=$_GET["hero_country"] == "4" ? "checked":"";?>/><label for="hero_country_cn">중국</label>
		</td>
	</tr>
	<tr>
		<th>연령대</th>
		<td>
			<input type="text" name="hero_age_start" numberOnly value="<?=$_GET["hero_age_start"]?>"/> ~ <input type="text" name="hero_age_end" numberOnly value="<?=$_GET["hero_age_end"]?>"/>
		</td>
		<th>가입일</th>
		<td>
			<input type="text" name="hero_oldday_start" class="dateMode" value="<?=$_GET["hero_oldday_start"]?>"/> ~ <input type="text" name="hero_oldday_end" name="hero_oldday_end" class="dateMode" value="<?=$_GET["hero_oldday_end"]?>"/>
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td colspan="3">
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

<div class="listExplainWrap mgb10">
<label>총 </label> : <strong><?=number_format($total_data)?></strong>건
</div>

<table class="t_list">
<colgroup>
	<col width="6%" />
	<col width="6%" />
	<col width="10%" />
	<col width="10%" />
	<col width="15%" />
	<col width="5%" />
	<col width="20%" />
	<col width="*" />
	<col width="10%" />
</colgroup>
<thead>
<tr>
	<th>No</th>
	<th>국가</th>
	<th>아이디</th>
	<th>닉네임</th>
	<th>이름</th>
	<th>나이</th>
	<th>휴대폰</th>
	<th>이메일</th>
	<th>가입일</th>
</tr>
</thead>
<?
if($total_data > 0) {
	while($list = mysql_fetch_assoc($list_res)) {
		$age = (date("Y")-substr($list["hero_jumin"],0,4))+1;
		$hero_country_txt = "";
		if($list["hero_country"] == "vn") {
			$hero_country_txt = "베트남";
		} else if($list["hero_country"] == "ru") {
			$hero_country_txt = "러시아";
		} else if($list["hero_country"] == "cn") {
			$hero_country_txt = "중국";
		} else if(!$list["hero_country"]) {
			$hero_country_txt = "관리자";
		}
?>
<tr style="cursor:pointer" onClick="fnView('<?=$list["hero_code"]?>')">
	<td><?=number_format($i);?></td>
	<td><?=$hero_country_txt?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=$age?></td>
	<td><?=$list["hero_hp"]?></td>
	<td><?=$list["hero_mail"]?></td>
	<td><?=substr($list["hero_oldday"],0,10)?></td>
</tr>
<? 
	--$i;
	}
} else {?>
<tr>	
	<td colspan="9">등록된 데이터가 없습니다.</td>
</tr>
<? } ?>
</table>
<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){
	fnSearch = function() {
		$("input[name='page']").val(1);
		$("#searchForm").attr("action","").submit();
	}

	fnView = function(hero_code) {
		$("input[name='hero_code']").val(hero_code);
		$("input[name='view']").val("memberView");
		$("#searchForm").attr("action","<?=PATH_HOME?>").submit();
	}
})
</script>