<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["startDate"] && $_GET["endDate"]) {
	$search .= " AND ( (date_format(hero_today_01_01,'%Y-%m-%d') <= '".$_GET["startDate"]."' AND date_format(hero_today_04_02,'%Y-%m-%d')>='".$_GET["startDate"]."' )";
	$search .= " || (date_format(hero_today_01_01,'%Y-%m-%d') <= '".$_GET["endDate"]."' AND date_format(hero_today_04_02,'%Y-%m-%d')>='".$_GET["endDate"]."' )";
	$search .= " || (date_format(hero_today_01_01,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND date_format(hero_today_04_02,'%Y-%m-%d')<='".$_GET["endDate"]."' ))";
}

if($_GET["kewyword"]) {
	$search .= " AND m.hero_title LIKE '%".$_GET["kewyword"]."%' ";
}

$sql  = " SELECT count(*) cnt ";
$sql .= " FROM mission m ";
$sql .= " WHERE m.hero_table = 'group_04_05' ".$search;

sql($sql);
$rs = mysql_fetch_assoc($out_sql);
$total_data = $rs["cnt"];

$i=$total_data;

$list_page=10;
$page_per_list=5;

if(!strcmp($_GET['page'], '') || !strcmp($_GET['page'], '1')){
	$page = '1';
}else{
	$page = $_GET['page'];
	$i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql  = " SELECT m.hero_idx, m.hero_title, m.hero_today_01_01, m.hero_today_04_02 ";
$sql .= " , sum(ifnull(if(u.gubun='naver',1,0),0)) naver_cnt ";
$sql .= " , sum(ifnull(if(u.gubun='insta',1,0),0)) insta_cnt ";
$sql .= " , sum(ifnull(if(u.gubun='youtube',1,0),0)) youtube_cnt ";
$sql .= " , sum(ifnull(if(u.gubun='cafe',1,0),0)) cafe_cnt ";
$sql .= " , sum(ifnull(if(u.gubun='etc',1,0),0)) etc_cnt ";
$sql .= " FROM mission m LEFT JOIN (SELECT hero_idx, hero_01 FROM board WHERE hero_table = 'group_04_05') AS b ON m.hero_idx = b.hero_01 ";
$sql .= " LEFT JOIN mission_url u ON b.hero_idx = u.board_hero_idx ";
$sql .= " WHERE m.hero_table = 'group_04_05' ".$search;
$sql .= " GROUP BY m.hero_idx ";
$sql .= " ORDER BY m.hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

sql($sql);

?>
<p class="tit_section mgb10">참여 채널별 콘텐츠</p>
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
			<input type="text" name="startDate" class="dateMode" value="<?=$_REQUEST['startDate']?>"> ~ 
			<input type="text" name="endDate" class="dateMode" value="<?=$_REQUEST['endDate']?>">
		</td>
	</tr>
	<tr>
		<th>체험단 명</th>
		<td>
			<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">	
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div>
</form>

<div class="btnGroupFunction">
	<div class="leftWrap">
		<label>총 </label> : <strong><?=number_format($total_data)?></strong>건
	</div>
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onclick="fnExcel()">콘텐츠 수량</a>
	</div>
</div>
<table class="t_list">
<colgroup>
	<col width="7%" />
	<col width="15%" />
	<col width="*" />
	<col width="7%" />
	<col width="7%" />
	<col width="7%" />
	<col width="7%" />
	<col width="7%" />
</colgroup>
<thead>
<tr>
	<th>No</th>
	<th>기간</th>
	<th>체험단 명</th>
	<th>네이버 블로그</th>
	<th>인스타그램</th>
	<th>유튜브</th>
	<th>카페</th>
	<th>기타</th>
</tr>
</thead>
<? 
	if($total_data > 0) {
	while($list = @mysql_fetch_assoc($out_sql)){
?>
<tr>
	<td><?=$i?></td>
	<td><?=substr($list['hero_today_01_01'],0,10);?> ~ <?=substr($list['hero_today_04_02'],0,10);?></td>
	<td class="title"><?=$list['hero_title'];?></td>
	<td><?=number_format($list['naver_cnt'])?></td>
	<td><?=number_format($list['insta_cnt'])?></td>
	<td><?=number_format($list['youtube_cnt'])?></td>
	<td><?=number_format($list['cafe_cnt'])?></td>
	<td><?=number_format($list['etc_cnt'])?></td>
</tr>
<? 
	$i--;
	}
} else {?>
<tr>
	<td colspan="8">등록된 데이터가 없습니다.</td>
</tr>
<?  } ?>
</table>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>

<p class="tit_section mgb10 mgt30">월별 타입별 콘텐츠 수량</p>
<form name="formMonthType" id="formMonthType">
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>년도</th>
		<td>
			<select name="search_year">
				<option value="">선택</option>
				<? for($i=date("Y"); $i>=2013; $i--) {?>
					<option value="<?=$i?>"><?=$i?></option>
				<? } ?>
			</select> 년
		</td>
	</tr>
</table>
</form>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearchMonth()" class="btnSearch">검색</a>
</div>
<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onclick="fnExcelMonthType()">월별 타입 다운로드</a>
	</div>
</div>
<table class="t_list" style="margin-bottom:100px;">
<colgroup>
	<col width="*" />
	<col width="12%" />
	<col width="12%" />
	<col width="12%" />
	<col width="12%" />
	<col width="12%" />
	<col width="12%" />
	<col width="12%" />
</colgroup>
<thead>
	<tr>
		<th>진행월</th>
		<th>일반미션</th>
		<th>체험단</th>
		<th>이벤트</th>
		<th>소문내기</th>
		<th>설문조사</th>
		<th>포인트체험</th>
		<th>제품품평</th>
	</tr>
</thead>
<tbody id="monthList">
	<tr>
		<td colspan="8">년도를 선택해 주세요.</td>
	</tr>
</tbody>
</table>

</br/></br/></br/></br/></br/></br/>

<script>
$(document).ready(function(){	
	fnSearch = function() {
		$("#searchForm").attr("action","").submit();
	}

	fnSearchMonth = function() {

		if(!$("select[name='search_year']").val()) {
			alert("년도 검색을 선택해 주세요.");
			return;
		}
		
		$.ajax({
				url:"<?=ADMIN_DEFAULT?>/data/contents_ajax.php"
				,type:"GET"
				,data:"mode=month&search_year="+$("select[name='search_year']").val()
				,dataType:"json"
				,success:function(d) {
					console.log(d[0]);
					html = "";
					for(var i=0; i<d.length; i++) {
						html += "<tr>";
						html += "<td>"+d[i].year+"년"+d[i].month+"월</td>";
						html += "<td>"+d[i].type_0+"</td>";
						html += "<td>"+d[i].type_10+"</td>";
						html += "<td>"+d[i].type_1+"</td>";
						html += "<td>"+d[i].type_2+"</td>";
						html += "<td>"+d[i].type_3+"</td>";
						html += "<td>"+d[i].type_5+"</td>";
						html += "<td>"+d[i].type_8+"</td>";
						html += "</tr>";
					}

					$("#monthList").html(html);
				},error:function(e){
					console.log(e);
					alert("오류가 발생했습니다.\n다시 이용해 주세요.");
					return;
				}
			})
	}
	
	fnExcel = function() {
		$("#searchForm").attr("action","/loaksecure21/data/contents_excel.php").submit();
	}

	fnExcelMonthType = function(){

		if(!$("select[name='search_year']").val()) {
			alert("년도 검색을 선택해 주세요.");
			return;
		}
		
		$("#formMonthType").attr("action","/loaksecure21/data/contents_month_type_excel.php").submit();
	}	
})
</script>