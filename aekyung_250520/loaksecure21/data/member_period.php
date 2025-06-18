<?
if(!defined('_HEROBOARD_'))exit;

//신규회원 년도별 추이
$member_year_sql = " SELECT ifnull(year,0) year, COUNT(*) cnt FROM (SELECT date_format(hero_oldday,'%Y') year FROM member WHERE hero_use = 0) a GROUP BY year ORDER BY year ASC ";
$member_year_res = sql($member_year_sql);
$member_year_list = array();
while($list = mysql_fetch_assoc($member_year_res)) {
	$member_year_list[] = $list;
}

//탈퇴회원 년도별 추이
$withdrawal_year_sql = "  SELECT ifnull(year,0) as year, COUNT(*) cnt FROM (SELECT FROM_UNIXTIME(hero_out_date,'%Y') year FROM member WHERE hero_use = 1) a GROUP BY a.year ORDER BY year ASC ";
$withdrawal_year_res= sql($withdrawal_year_sql);
$withdrawal_year_list = array();
while($list = mysql_fetch_assoc($withdrawal_year_res)) {
	$withdrawal_year_list[] = $list;
}

?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<p class="tit_section mgb10 tit_emphasize">신규회원</p>
<p class="tit_section mgb10">1) 년도별 추이</p>
<div id="member_year" style="height:300px;"></div>

<p class="tit_section mgb10">2) 월별 추이</p>

<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>년도</th>
		<td>
			<select name="member_month_year">
				<option value="">선택</option>
				<? for($i=date("Y"); $i>=2013; $i--) {?>
					<option value="<?=$i?>"><?=$i?></option>
				<? } ?>
			</select> 년
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="drawMemberMonthChart()" class="btnSearch">검색</a>
</div>
<div id="member_month" style="height:300px;"></div>

<p class="tit_section mgb10 tit_emphasize">탈퇴회원</p>
<p class="tit_section mgb10">1) 년도별 추이</p>
<div id="withdrawal_year" style="height:300px;"></div>

<p class="tit_section mgb10">2) 월별 추이</p>

<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>년도</th>
		<td>
			<select name="withdrawal_month_year">
				<option value="">선택</option>
				<? for($i=date("Y"); $i>=2013; $i--) {?>
					<option value="<?=$i?>"><?=$i?></option>
				<? } ?>
			</select> 년
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="drawWithdrawalMonthChart()" class="btnSearch">검색</a>
</div>
<div id="withdrawal_month" style="height:300px;"></div>

<p class="tit_section mgb10 tit_emphasize">일반회원<->휴면회원 전환</p>
<p class="tit_section mgb10">1) 년도별 추이</p>
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>검색</th>
		<td>
			<input type="radio" name="change_type" id="change_type_1" value="1" onClick="drawChangeYearChart()" checked/><label for="change_type_1">일반->휴면회원 전환</label>
			<input type="radio" name="change_type" id="change_type_2" value="2" onClick="drawChangeYearChart()" /><label for="change_type_2">휴면->일반회원 전환</label>
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="drawWithdrawalMonthChart()" class="btnSearch">검색</a>
</div>
<div id="change_year" style="height:300px;"></div>

<p class="tit_section mgb10">2) 월별 추이</p>
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>검색</th>
		<td>
			<input type="radio" name="change_month_type" id="change_month_type_1" value="1" onClick="drawChangeYearChart()" checked/><label for="change_month_type_1">일반->휴면회원 전환</label>
			<input type="radio" name="change_month_type" id="change_month_type_2" value="2" onClick="drawChangeYearChart()" /><label for="change_month_type_2">휴면->일반회원 전환</label>
		</td>
	</tr>
	<tr>
		<th>년도</th>
		<td>
			<select name="change_month_year">
				<option value="">선택</option>
				<? for($i=date("Y"); $i>=2013; $i--) {?>
					<option value="<?=$i?>"><?=$i?></option>
				<? } ?>
			</select> 년
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="drawChangeMonthChart()" class="btnSearch">검색</a>
</div>
<div id="change_month" style="height:300px;"></div>

<div id="columnchart_values"></div>


<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawMemberYearChart);
google.charts.setOnLoadCallback(drawWithdrawalYearChart);
google.charts.setOnLoadCallback(drawChangeYearChart);

function drawMemberYearChart() {	
	var data = new google.visualization.DataTable();
	
	data.addColumn('string', 'Year');
	data.addColumn('number', '명');

	//alert(currentYear-first_year);
	data.addRows(<?=count($member_year_list)?>);
	var k = 0;
	<? foreach($member_year_list as $rs) {?>
		data.setCell(k, 0, '<?=$rs["year"]?>년');
	  	data.setCell(k, 1, <?=$rs["cnt"]?>);
		k++;
	<? } ?>

	var view = new google.visualization.DataView(data);
	    view.setColumns([0,1,{
	    	 calc: "stringify",
             sourceColumn: 1,
             type: "string",
             role: "annotation"}]);

	var options = {allowHtml: true, showRowNumber: true}

	var chart = new google.visualization.ColumnChart(document.getElementById('member_year'));

	chart.draw(view, options);
}

function drawMemberMonthChart() {
	if(!$("select[name='member_month_year']").val()) {
		alert("년도 검색을 선택해 주세요.");
		return;
	}
	$.ajax({
			url:"<?=ADMIN_DEFAULT?>/data/member_period_ajax.php"
			,type:"GET"
			,data:"mode=member_month&search_year="+$("select[name='member_month_year']").val()
			,dataType:"json"
			,success:function(d){
				if(d.length > 0) {
					var data = new google.visualization.DataTable();
					
					data.addColumn('string', 'Month');
					data.addColumn('number', '명');
					data.addRows(d.length);
					for(var i=0; i<d.length; i++) {
						data.setCell(i, 0, d[i].month+'월');
					  	data.setCell(i, 1, d[i].cnt);
					}

					var view = new google.visualization.DataView(data);
				    view.setColumns([0,1,{
				    	 calc: "stringify",
			             sourceColumn: 1,
			             type: "string",
			             role: "annotation"}]);
					
	
					var options = {};
	
					var chart = new google.visualization.ColumnChart(document.getElementById('member_month'));
	
					chart.draw(view, options);
				} else {
					$("#withdrawal_month").html("<div style='font-size:20px; text-align:center'>검색된 데이터가 없습니다.</div>");
				}
			},error:function(e){
				console.log(e);
				alert("오류가 발생했습니다.\n다시 이용해 주세요.");
				return;
			}
		})


}

function drawWithdrawalYearChart() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Year', { calc: "stringify",
        sourceColumn: 1,
        type: "string",
        role: "annotation" });
	data.addColumn('number', '명');

	data.addRows(<?=count($withdrawal_year_list)?>);
	var k = 0;
	<? foreach($withdrawal_year_list as $rs) {?>
		data.setCell(k, 0, '<?=$rs["year"]?>년');
	  	data.setCell(k, 1, <?=$rs["cnt"]?>);
		k++;
	<? } ?>

	var view = new google.visualization.DataView(data);
    view.setColumns([0,1,{
    	 calc: "stringify",
         sourceColumn: 1,
         type: "string",
         role: "annotation"}]);

	var options = {};

	var chart = new google.visualization.ColumnChart(document.getElementById('withdrawal_year'));

	chart.draw(view, options);
}

function drawWithdrawalMonthChart() {
	if(!$("select[name='withdrawal_month_year']").val()) {
		alert("년도 검색을 선택해 주세요.");
		return;
	}
	$.ajax({
			url:"<?=ADMIN_DEFAULT?>/data/member_period_ajax.php"
			,type:"GET"
			,data:"mode=withdrawal_month&search_year="+$("select[name='withdrawal_month_year']").val()
			,dataType:"json"
			,success:function(d){
				if(d.length > 0) {
					var data = new google.visualization.DataTable();
					
					data.addColumn('string', 'Month');
					data.addColumn('number', '명');
					data.addRows(d.length);
					for(var i=0; i<d.length; i++) {
						data.setCell(i, 0, d[i].month+'월');
					  	data.setCell(i, 1, d[i].cnt);
					}

					var view = new google.visualization.DataView(data);
				    view.setColumns([0,1,{
				    	 calc: "stringify",
			             sourceColumn: 1,
			             type: "string",
			             role: "annotation"}]);
					
	
					var options = {'sliceVisibilityThreshoId':0};
	
					var chart = new google.visualization.ColumnChart(document.getElementById('withdrawal_month'));
	
					chart.draw(view, options);
				} else {
					$("#withdrawal_month").html("<div style='font-size:20px; text-align:center'>검색된 데이터가 없습니다.</div>");
				}
			},error:function(e){
				console.log(e);
				alert("오류가 발생했습니다.\n다시 이용해 주세요.");
				return;
			}
		})
}

function drawChangeYearChart() {

	$.ajax({
		url:"<?=ADMIN_DEFAULT?>/data/member_period_ajax.php"
		,type:"GET"
		,data:"mode=change_year&search_change_type="+$(":radio[name='change_type']:checked").val()
		,dataType:"json"
		,success:function(d){
			if(d.length > 0) {
				var data = new google.visualization.DataTable();
				
				data.addColumn('string', 'Year');
				data.addColumn('number', '명');
				data.addRows(d.length);
				for(var i=0; i<d.length; i++) {
					data.setCell(i, 0, d[i].year+'년');
				  	data.setCell(i, 1, d[i].cnt);
				}

				var view = new google.visualization.DataView(data);
			    view.setColumns([0,1,{
			    	 calc: "stringify",
		             sourceColumn: 1,
		             type: "string",
		             role: "annotation"}]);
				

				var options = {'sliceVisibilityThreshoId':0};

				var chart = new google.visualization.ColumnChart(document.getElementById('change_year'));
				chart.draw(view, options);
				
			} else {
				$("#change_year").html("<div style='font-size:20px; text-align:center'>검색된 데이터가 없습니다.</div>");
			}
		},error:function(e){
			console.log(e);
			alert("오류가 발생했습니다.\n다시 이용해 주세요.");
			return;
		}
	})
}

function drawChangeMonthChart() {
	$.ajax({
		url:"<?=ADMIN_DEFAULT?>/data/member_period_ajax.php"
		,type:"GET"
		,data:"mode=change_month&search_change_type="+$(":radio[name='change_month_type']:checked").val()+"&search_year="+$("select[name='change_month_year']").val()
		,dataType:"json"
		,success:function(d){
			if(d.length > 0) {
				var data = new google.visualization.DataTable();
				
				data.addColumn('string', 'Month');
				data.addColumn('number', '명');
				data.addRows(d.length);
				for(var i=0; i<d.length; i++) {
					data.setCell(i, 0, d[i].month+'월');
				  	data.setCell(i, 1, d[i].cnt);
				}

				var view = new google.visualization.DataView(data);
			    view.setColumns([0,1,{
			    	 calc: "stringify",
		             sourceColumn: 1,
		             type: "string",
		             role: "annotation"}]);
						
				var options = {};

				var chart = new google.visualization.ColumnChart(document.getElementById('change_month'))
				chart.draw(view, options);
				
			} else {
				$("#change_month").html("<div style='font-size:20px; text-align:center'>검색된 데이터가 없습니다.</div>");
			}
		},error:function(e){
			console.log(e);
			alert("오류가 발생했습니다.\n다시 이용해 주세요.");
			return;
		}
	})
}
</script>