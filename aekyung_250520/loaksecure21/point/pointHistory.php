<? 
if(!defined('_HEROBOARD_'))exit;

$search = "";
$search_order = "";

if($_GET["hero_today_start"]) {
	$search .= " AND date_format(hero_today,'%Y-%m-%d') >= '".$_GET["hero_today_start"]."' ";
	$search_order .= " AND date_format(hero_today,'%Y-%m-%d') >= '".$_GET["hero_today_start"]."' ";
}

if($_GET["hero_today_end"]) {
	$search .= " AND date_format(hero_today,'%Y-%m-%d') <= '".$_GET["hero_today_end"]."' ";
	$search_order .= " AND date_format(hero_today,'%Y-%m-%d') <= '".$_GET["hero_today_end"]."' ";
}

if($_GET["pointType"]){
	if($_GET["pointType"] == 'Plus') {
		$search .=" AND hero_point > 0 ";
		$search_order .=" AND hero_point < 0 ";
	}
	else if($_GET["pointType"] == 'Minus') {
		$search .=" AND hero_point < 0 ";
		$search_order .=" AND hero_point > 0 ";
	}
}

if($_GET["pointLimit"]) {
	$search .= " AND hero_include_maxpoint = '".$_GET["pointLimit"]."' ";
	$search_order .= " AND hero_include_maxpoint = '".$_GET["pointLimit"]."' ";
}

if($_GET["kewyword"]){
	if($_GET["select"] == "hero_title" || $_GET["select"] == "hero_top_title") {
		$search .= " AND ".$_GET["select"]."  like '%".$_GET["kewyword"]."%' ";
	} else {
		$search .= " AND ".$_GET["select"]." ='".$_GET["kewyword"]."' ";
	}
	
	if($_GET["select"] == "hero_title" || $_GET["select"] == "hero_top_title") {
		$search_order .= "";
		if($_GET["select"] == "hero_title") {
			$search_order .= " AND ".$_GET["select"]."  like '%".$_GET["kewyword"]."%' ";
		}
	} else {
		$search_order .= " AND ".$_GET["select"]." ='".$_GET["kewyword"]."' ";
	}
}

$total_sql = " SELECT SUM(cnt) as cnt, SUM(hero_point) hero_point, SUM(hero_order_point) as hero_order_point FROM (";
$total_sql .= " SELECT count(*) AS cnt, ifnull(sum(hero_point),0) as hero_point, 0 hero_order_point FROM point WHERE 1=1 ".$search;
$total_sql .= " UNION ALL ";
$total_sql .= " SELECT count(*) AS cnt, 0 as hero_point , ifnull(sum(hero_point),0) as hero_order_point from ";
$total_sql .= " ( SELECT hero_id, hero_name, hero_nick, hero_order_point as hero_point, hero_regdate as hero_today ";
$total_sql .= " , case when hero_process = 'DE' then '배송료' when hero_process = 'M' then '포인트소멸' when hero_process = 'O' then '상품구입' ELSE hero_process end AS hero_title ";
$total_sql .= " , 'N' hero_include_maxpoint FROM order_main WHERE hero_process != 'C') a WHERE 1=1 ".$search_order;
$total_sql .= " ) a ";

sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];


$total_point = $out_res['hero_point'];
$total_use_point = $out_res['hero_order_point'];
$total_possible_point = $total_point-$total_use_point;

$i=$total_data;

$list_page=20;
$page_per_list=10;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];

$i = $i-($page-1)*$list_page;

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql = " SELECT * FROM  (";
$sql .= " SELECT hero_type, hero_id, hero_top_title, hero_title ";
$sql .= " , hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, edit_hero_code ";
$sql .= " FROM point p ";
$sql .= " WHERE 1=1 ".$search." ";
$sql .= " UNION ALL ";
$sql .= " SELECT hero_type, hero_id, hero_top_title,  hero_title, hero_name ";
$sql .= " , hero_nick, hero_point*-1 as hero_point, hero_today, hero_include_maxpoint, hero_code FROM ( ";
$sql .= " SELECT  '' hero_type, hero_id, '' hero_top_title ";
$sql .= " , case when hero_process = 'DE' then '배송료' when hero_process = 'M' then '포인트소멸' when hero_process = 'O' then '상품구입' ELSE hero_process end AS hero_title ";
$sql .= " , hero_name , hero_nick, hero_order_point as hero_point, hero_regdate as hero_today, 'N' hero_include_maxpoint ";
$sql .= " , hero_code ";
$sql .= "  FROM order_main WHERE hero_process != 'C') a WHERE 1=1 ".$search_order;
$sql .= " ) a ";
$sql .= " ORDER BY hero_today DESC ";
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
		<th>기간</th>
		<td>
			<input type="text" name="hero_today_start"  value="<?=$_GET['hero_today_start']?>" class="dateMode" /> ~ 
			<input type="text" name="hero_today_end"  value="<?=$_GET['hero_today_end']?>" class="dateMode" />
		</td>
	</tr>
	<tr>
		<th>포인트 획득/차감</th>                
		<td><input type="radio" name="pointType"  id="pointAll" value="All"  <?if($_GET['pointType']=="" || $_GET['pointType']=="All" ) echo checked;?>/><label for="pointAll">전체</label> 
		 	<input type="radio" name="pointType"  id="pointPlus" value="Plus"  <?if($_GET['pointType']=="Plus" ) echo checked;?>/><label for="pointPlus">획득</label> 
			<input type="radio" name="pointType"  id="pointMinus" value="Minus"  <?if($_GET['pointType']=="Minus" ) echo checked;?>/><label for="pointMinus">차감</label>
		</td>
	</tr>
	<tr>
		<th>제한된 포인트</th>                
		<td><input type="radio" name="pointLimit"  id="pointLimitAll" value=""  <?if($_GET['pointLimit']=="") echo checked;?>/><label for="pointAll">전체</label> 
		 	<input type="radio" name="pointLimit"  id="pointLimitY" value="Y"  <?if($_GET['pointLimit']=="Y" ) echo checked;?>/><label for="pointLimitY">제한</label> 
			<input type="radio" name="pointLimit"  id="pointLimitN" value="N"  <?if($_GET['pointLimit']=="N" ) echo checked;?>/><label for="pointLimitN">제한없음</label>
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>닉네임</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>아이디</option>
		    	<option value="hero_name" <?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>이름</option>
		    	<option value="hero_top_title" <?if(!strcmp($_REQUEST['select'], 'hero_top_title')){echo ' selected';}else{echo '';}?>>포인트 획득 메뉴</option>
		    	<option value="hero_title" <?if(!strcmp($_REQUEST['select'], 'hero_title')){echo ' selected';}else{echo '';}?>>포인트 내용</option>
		    	<option value="hero_point" <?if(!strcmp($_REQUEST['select'], 'hero_point')){echo ' selected';}else{echo '';}?>>포인트</option>
		    	
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
<label>총 </label> : <strong><?=number_format($total_data)?></strong>건, <label>총 포인트</label> : <strong><?=number_format($total_point)?></strong> P (일일 획득 포인트 제한 20점)
, <label>총 사용한 포인트</label> : <strong><?=number_format($total_use_point)?></strong> P
, <label>총 가용 포인트</label> : <strong><?=number_format($total_possible_point > 0 ? $total_possible_point:0)?></strong> P
</div>
<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">다운로드</a>
	</div>
</div>

<table class="t_list">
<colgroup>
	<col width="10%" />
	<col width="8%" />
	<col width="8%" />
	<col width="8%" />
	<col width="10%" />
	<col width="6%" />
	<col width="10%" />
	<col width="*" />
	<col width="6%" />
</colgroup>
<thead>
<tr>
	<th>적립일</th>
	<th>아이디</th>
	<th>이름</th>
	<th>닉네임</th>
	<th>포인트 제한 구분</th>
	<th>획득/차감</th>
	<th>포인트 획득 메뉴</th>
	<th>내용</th>
	<th>포인트</th>
</tr>
</thead>
<? if($total_data > 0) {
	while($list = mysql_fetch_assoc($list_res)) {	
		$hero_include_maxpoint_txt = "제한없음";
		if($list["hero_include_maxpoint"] == "Y") $hero_include_maxpoint_txt = "제한";
		$point_gubun_txt = "";
		if($list['hero_point']  > 0) {
			$point_gubun_txt = "획득";
		} else if($list['hero_point']  < 0) {
			$point_gubun_txt = "차감";
		}
?>
<tr>
	<td><?=$list['hero_today']?></td>
	<td><?=$list['hero_id']?></td>
	<td><?=name_masking($list['hero_name'])?></td>
	<td><?=$list['hero_nick']?></td>
	<td><?=$hero_include_maxpoint_txt?></td>
	<td><?=$point_gubun_txt?></td>
	<td><?=$list["hero_top_title"]?></td>
	<td class="title"><?=$list["hero_title"]?></td>
	<td><?=$list["hero_point"]?> P</td>
</tr>
<? }
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
		$("#searchForm").attr("action","").submit();
	}	

	fnExcel = function() {
		if(!$("select[name='select']").val()) {
			alert("검색어 항목을 선택해 주세요.\n데이터 양이 많아 검색어 입력 후 해당하는 데이터만 다운로드 가능합니다.");
			$("select[name='select']").focus();
			return;
		}

		if(!$("input[name='kewyword']").val()) {
			alert("검색어을 입력해주세요.\n데이터 양이 많아 검색어 입력 후 해당하는 데이터만 다운로드 가능합니다.");
			$("input[name='kewyword']").focus();
			return;
		}

		$("#searchForm").attr("action","/loaksecure21/point/excel_pointHistory.php").submit();
	}
})
</script>
    