<?  if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["gubun"]) {
	if($_GET["gubun"] == "sum") {
		$search .= " AND (l.gubun is null or l.gubun = '')  ";
	} else {
		$search .= " AND l.gubun = '".$_GET["gubun"]."' ";
	}
}

if($_GET["gisu_year"]) {
	$search .= " AND l.gisu_year = '".$_GET["gisu_year"]."' ";
}

if($_GET["gisu_month"]) {
	$search .= " AND l.gisu_month = '".$_GET["gisu_month"]."' ";
}

if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

$total_sql  = " SELECT count(*) cnt FROM member_loyal l ";
$total_sql .= " LEFT JOIN member m ON l.hero_code = m.hero_code ";
$total_sql .= " WHERE 1=1 ".$search;

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
$sql  = " SELECT l.hero_idx, l.gisu_year, l.gisu_month, l.hero_today, l.gubun ";
$sql .= " , m.hero_name, m.hero_nick, m.hero_id ";
$sql .= " FROM member_loyal l ";
$sql .= " LEFT JOIN member m ON l.hero_code = m.hero_code ";
$sql .= " WHERE 1=1 ".$search;
$sql .= " ORDER BY l.gisu_year DESC, l.gisu_month DESC, l.hero_today DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql);

//메인 노출 기간
$period_sql  = " SELECT startdate, enddate ";
$period_sql .= " , if(startdate <= date_format(now(),'%Y-%m-%d') AND enddate >= date_format(now(),'%Y-%m-%d'),1,0) as status FROM member_loyal_period ";
$period_res = sql($period_sql);
$period_rs = mysql_fetch_assoc($period_res);
?>
<div class="view_title_box">
	<p>메인 노출기간 : <strong>(<?=$period_rs["status"]==1 ? "공개":"비공개"?>)</strong> <?=$period_rs["startdate"]?> ~ <?=$period_rs["enddate"]?></p>
	<p>기수 : 전 월 우수자 선정(ex : 현재 6월이라고 가정하면 5월 우수자를 선정, 2021년5월 기수는 6월부터 로얄 권한이 부여됩니다.)</p>
</div>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="page" value="<?=$_GET["page"]?>" />
<input type="hidden" name="hero_idx" value="" />
<input type="hidden" name="view" value="" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>구분</th>
		<td>
			<input type="radio" name="gubun" id="gubun_all" value="" <?=strlen($_GET["gubun"])==0 ? "checked":""?> /><label for="gubun_all">전체</label>
			<input type="radio" name="gubun" id="gubun_sum" value="sum" <?=$_GET["gubun"]=="sum" ? "checked":""?>/><label for="gubun_sum">Loyal AK LOVER(통합)</label>
			<input type="radio" name="gubun" id="gubun_r" value="r" <?=$_GET["gubun"]=="r" ? "checked":""?>/><label for="gubun_r">리뷰 Loyal AK LOVER</label>
			<input type="radio" name="gubun" id="gubun_j" value="j" <?=$_GET["gubun"]=="j" ? "checked":""?>/><label for="gubun_j">참여 Loyal AK LOVER</label>
		</td>
	</tr>
	<tr>
		<th>기수(년, 월)</th>
		<td>
			<select name="gisu_year">
				<option value="">년도</option>
				<? for($z = date("Y")+1; $z > 1921; $z--) { ?>
					<option value="<?=$z;?>" <?=$z==$_GET["gisu_year"] ? "selected":""?>><?=$z;?></option>
				<? } ?>
			</select>
			<select name="gisu_month">
				<option value="">월별</option>
				<? for($z = 1; $z <= 12; $z++) { ?>	
					<option value="<?=sprintf("%02d", $z);?>" <?=sprintf("%02d", $z)==$_GET["gisu_month"] ? "selected":""?>><?=sprintf("%02d", $z);?></option>
				<? } ?>
			</select>
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
				<option value="m.hero_nick" <?if(!strcmp($_REQUEST['select'], 'm.hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
		    	<option value="m.hero_id" <?if(!strcmp($_REQUEST['select'], 'm.hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
		    	<option value="m.hero_name" <?if(!strcmp($_REQUEST['select'], 'm.hero_name')){echo ' selected';}else{echo '';}?>>이름</option>	    	
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">		
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div>
</form>

<div class="listExplainWrap">
	<label>총 </label> : <strong><?=$total_data?></strong>건</span>
</div>

<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">다운로드</a>
		<a href="javascript:;" class="btnFunc" onClick="fnPopPeriod()">메인 노출 기간 설정</a>
	</div>
</div>

<table class="t_list">
<colgroup>
	<col width="5%" />
	<col width="10%" />
	<col width="*" />
	<col width="20%" />
	<col width="20%" />
	<col width="20%" />
	<col width="15%" />
</colgroup>
<thead>
	<tr>
		<th>no</th>
		<th>구분</th>
		<th>기수</th>
		<th>아이디</th>
		<th>닉네임</th>
		<th>성함</th>
		<th>등록일</th>
	</tr>
</thead>
<? if($total_data > 0) {
	while($list = mysql_fetch_assoc($list_res)) {	
		$gubun_txt= "";
		if($list["gubun"]=="r") {
			$gubun_txt = "리뷰";
		} else if($list["gubun"]=="j") {
			$gubun_txt = "참여";
		} else {
			$gubun_txt = "통합";
		}
?>
<tr onClick="fnView('<?=$list["hero_idx"]?>')" style="cursor:pointer">
	<td><?=$i?></td>
	<td><?=$gubun_txt?></td>
	<td><?=$list["gisu_year"]?>년 <?=$list["gisu_month"]?>월</td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=substr($list["hero_today"],0,10)?></td>
</tr>
<? 
	$i--;
	}
} else {?>
<tr>
	<td colspan="7">등록된 데이터가 없습니다.</td>
</tr>
<? } ?>
</table>

<div class="btnGroup">
	<div class="r">
		<a href="javascript:;" onClick="fnWrite()" class="btnAdd">등록</a>
	</div>
</div>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){
	fnWrite = function(){
		$("input[name='view']").val("loyalWrite");
		$("#searchForm").attr("action","").submit();
	}
	
	fnView = function(hero_idx) {
		$("input[name='hero_idx']").val(hero_idx);
		$("input[name='view']").val("loyalWrite");
		$("#searchForm").attr("action","").submit();
	}

	fnExcel = function(){
		$("#searchForm").attr("action","<?=ADMIN_DEFAULT?>/user/loyalExcel.php").submit();
	}

	fnSearch = function() {
		$("input[name='page']").val("1");
		$("#searchForm").attr("action","").submit();
	}

	fnPopPeriod = function(){
		var popPeriod = window.open("<?=ADMIN_DEFAULT?>/user/popLoyalMainPeriod.php","popPoint","width=660, height=500");
		popPeriod.focus();
	}
})
</script>