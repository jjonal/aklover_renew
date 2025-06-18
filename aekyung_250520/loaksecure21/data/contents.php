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
<p class="tit_section mgb10">���� ä�κ� ������</p>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>�Ⱓ</th>
		<td>
			<input type="text" name="startDate" class="dateMode" value="<?=$_REQUEST['startDate']?>"> ~ 
			<input type="text" name="endDate" class="dateMode" value="<?=$_REQUEST['endDate']?>">
		</td>
	</tr>
	<tr>
		<th>ü��� ��</th>
		<td>
			<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">	
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div>
</form>

<div class="btnGroupFunction">
	<div class="leftWrap">
		<label>�� </label> : <strong><?=number_format($total_data)?></strong>��
	</div>
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onclick="fnExcel()">������ ����</a>
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
	<th>�Ⱓ</th>
	<th>ü��� ��</th>
	<th>���̹� ��α�</th>
	<th>�ν�Ÿ�׷�</th>
	<th>��Ʃ��</th>
	<th>ī��</th>
	<th>��Ÿ</th>
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
	<td colspan="8">��ϵ� �����Ͱ� �����ϴ�.</td>
</tr>
<?  } ?>
</table>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>

<p class="tit_section mgb10 mgt30">���� Ÿ�Ժ� ������ ����</p>
<form name="formMonthType" id="formMonthType">
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>�⵵</th>
		<td>
			<select name="search_year">
				<option value="">����</option>
				<? for($i=date("Y"); $i>=2013; $i--) {?>
					<option value="<?=$i?>"><?=$i?></option>
				<? } ?>
			</select> ��
		</td>
	</tr>
</table>
</form>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearchMonth()" class="btnSearch">�˻�</a>
</div>
<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onclick="fnExcelMonthType()">���� Ÿ�� �ٿ�ε�</a>
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
		<th>�����</th>
		<th>�Ϲݹ̼�</th>
		<th>ü���</th>
		<th>�̺�Ʈ</th>
		<th>�ҹ�����</th>
		<th>��������</th>
		<th>����Ʈü��</th>
		<th>��ǰǰ��</th>
	</tr>
</thead>
<tbody id="monthList">
	<tr>
		<td colspan="8">�⵵�� ������ �ּ���.</td>
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
			alert("�⵵ �˻��� ������ �ּ���.");
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
						html += "<td>"+d[i].year+"��"+d[i].month+"��</td>";
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
					alert("������ �߻��߽��ϴ�.\n�ٽ� �̿��� �ּ���.");
					return;
				}
			})
	}
	
	fnExcel = function() {
		$("#searchForm").attr("action","/loaksecure21/data/contents_excel.php").submit();
	}

	fnExcelMonthType = function(){

		if(!$("select[name='search_year']").val()) {
			alert("�⵵ �˻��� ������ �ּ���.");
			return;
		}
		
		$("#formMonthType").attr("action","/loaksecure21/data/contents_month_type_excel.php").submit();
	}	
})
</script>