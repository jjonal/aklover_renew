<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

$dateType = $_GET["dateType"];
$select_02 = $_REQUEST['select_02'];
$endDateCheck = "none";
if($dateType=="2") $endDateCheck = "inline-block";

if($_REQUEST['select_02']!='' && $_GET["dateType"] == "1"){
	$date = $_REQUEST['startDate'];
	if($date) {
		$today = "'".$date." 00:00:00'";
	} else {
		$today = "'".date('Y-m-d 00:00:00',time())."'";
	}
	
	if($select_02=='request'){
		$search .= " and hero_today_01_01<=".$today." and hero_today_01_02>=".$today;
	}else if($select_02=='release'){
		$search .= " and hero_today_02_01<=".$today." and hero_today_02_02>=".$today." and not (hero_today_01_01<=".$today." and hero_today_01_02>=".$today.")";
	}else if($select_02=='enroll'){
		$search .= " and hero_today_03_01<=".$today." and hero_today_03_02>=".$today." and not (hero_today_01_01<=".$today." and hero_today_01_02>=".$today.") and not (hero_today_02_01<=".$today." and hero_today_02_02>=".$today.")";
	}else if($select_02=='best'){
		$search .= " and hero_today_04_01<=".$today." and hero_today_04_02>=".$today." and not (hero_today_01_01<=".$today." and hero_today_01_02>=".$today.") and not (hero_today_02_01<=".$today." and hero_today_02_02>=".$today.") and not (hero_today_03_01<=".$today." and hero_today_03_02>=".$today.")";
	}else if($select_02=='finished'){
		$search .= " and hero_today_04_02<".$today." and not (hero_today_01_01<=".$today." and hero_today_01_02>=".$today.") and not (hero_today_02_01<=".$today." and hero_today_02_02>=".$today.") and not (hero_today_03_01<=".$today." and hero_today_03_02>=".$today.") and not (hero_today_04_01<=".$today." and hero_today_04_02>=".$today.")";
	}
}

if($_REQUEST['select_02']!='' && $_GET["dateType"] == "2" && $_GET["startDate"] && $_GET["endDate"]){
	if($select_02=='request'){
		$search .= " AND ( (date_format(hero_today_01_01,'%Y-%m-%d') <= '".$_GET["startDate"]."' AND date_format(hero_today_01_02,'%Y-%m-%d')>='".$_GET["startDate"]."' )";
		$search .= " || (date_format(hero_today_01_01,'%Y-%m-%d') <= '".$_GET["endDate"]."' AND date_format(hero_today_01_02,'%Y-%m-%d')>='".$_GET["endDate"]."' )";
		$search .= " || (date_format(hero_today_01_01,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND date_format(hero_today_01_02,'%Y-%m-%d')<='".$_GET["endDate"]."' ))";
	}else if($select_02=='release'){
		$search .= " AND ( (date_format(hero_today_02_01,'%Y-%m-%d') <= '".$_GET["startDate"]."' AND date_format(hero_today_02_02,'%Y-%m-%d')>='".$_GET["startDate"]."' )";
		$search .= " || (date_format(hero_today_02_01,'%Y-%m-%d') <= '".$_GET["endDate"]."' AND date_format(hero_today_02_02,'%Y-%m-%d')>='".$_GET["endDate"]."' )";
		$search .= " || (date_format(hero_today_02_01,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND date_format(hero_today_02_02,'%Y-%m-%d')<='".$_GET["endDate"]."' ))";
	}else if($select_02=='enroll'){
		$search .= " AND ( (date_format(hero_today_03_01,'%Y-%m-%d') <= '".$_GET["startDate"]."' AND date_format(hero_today_03_02,'%Y-%m-%d')>='".$_GET["startDate"]."' )";
		$search .= " || (date_format(hero_today_03_01,'%Y-%m-%d') <= '".$_GET["endDate"]."' AND date_format(hero_today_03_02,'%Y-%m-%d')>='".$_GET["endDate"]."' )";
		$search .= " || (date_format(hero_today_03_01,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND date_format(hero_today_03_02,'%Y-%m-%d')<='".$_GET["endDate"]."' ))";
	}else if($select_02=='best'){
		$search .= " AND ( (date_format(hero_today_04_01,'%Y-%m-%d') <= '".$_GET["startDate"]."' AND date_format(hero_today_04_02,'%Y-%m-%d')>='".$_GET["startDate"]."' )";
		$search .= " || (date_format(hero_today_04_01,'%Y-%m-%d') <= '".$_GET["endDate"]."' AND date_format(hero_today_04_02,'%Y-%m-%d')>='".$_GET["endDate"]."' )";
		$search .= " || (date_format(hero_today_04_01,'%Y-%m-%d') >= '".$_GET["startDate"]."' AND date_format(hero_today_04_02,'%Y-%m-%d')<='".$_GET["endDate"]."' ))";
	}
}

if(strcmp($_GET['kewyword'], '')){
    if($_GET['select']=='hero_all'){
		$search .= ' and ( hero_title like \'%'.$_GET['kewyword'].'%\' or hero_command like \'%'.$_GET['kewyword'].'%\')';
	}else{
		$search .= ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
	}
}

if(strlen($_GET["hero_type"]) > 0) {
	$search .= " AND hero_type = '".$_GET["hero_type"]."' ";
}

$sql="select count(*) from mission where hero_table in ('group_04_05') ".$search." ";

sql($sql);
$total_data = mysql_result($out_sql,0,0);
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


$todayYMDHIS = date('Y-m-d 00:00:00');
$sql =  " SELECT hero_idx, hero_type, hero_title, hero_kind, hero_today, hero_today_01_01 ";
$sql .= " ,hero_today_01_02, hero_today_02_01,  hero_today_02_02, hero_today_03_01, hero_today_03_02 ";
$sql .= " ,hero_today_04_01, hero_today_04_02, hero_use FROM mission WHERE hero_table = 'group_04_05' ".$search." "; //2025-02-13 musign 윤동희 삭제기능 추가
$sql .= "order by CASE WHEN (hero_today_01_01<='".$todayYMDHIS."' and hero_today_01_02>='".$todayYMDHIS."') THEN hero_today_01_02 END desc, ";
$sql .= "CASE WHEN (hero_today_02_01<='".$todayYMDHIS."' and hero_today_02_02>='".$todayYMDHIS."') THEN hero_today_02_02 END desc, ";
$sql .= "CASE WHEN (hero_today_03_01<='".$todayYMDHIS."' and hero_today_03_02>='".$todayYMDHIS."') THEN hero_today_03_02 END desc, ";
$sql .= "CASE WHEN (hero_today_04_01<='".$todayYMDHIS."' and hero_today_04_02>='".$todayYMDHIS."') THEN hero_today_04_02 END desc, ";
$sql .= "CASE WHEN (hero_today_04_02<='".$todayYMDHIS."') THEN hero_today_04_02 END desc ";
$sql .= "limit ".$start.",".$list_page;
sql($sql);

/*
if(!strcmp($_GET['type'], 'drop')){
    $sql = 'DELETE FROM mission WHERE hero_idx = \''.$_GET['hero_idx'].'\';';
    sql($sql);
    msg('삭제 되었습니다.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
    exit;
}
*/
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
		<th>날짜 검색</th>
		<td>
			<select name="select_02">
		    	<option value="">체험단기간 선택</option>
		        <option value="request" <?php echo ($select_02=="request")? "selected='selected'" : ""; ?>>체험단 신청</option>
		        <option value="release" <?php echo ($select_02=="release")? "selected='selected'" : ""; ?>>체험단 발표</option>
		        <option value="enroll" <?php echo ($select_02=="enroll")? "selected='selected'" : ""; ?>>후기 등록</option>
		        <option value="best" <?php echo ($select_02=="best")? "selected='selected'" : ""; ?>>우수후기 발표</option>
		        <option value="finished" <?php echo ($select_02=="finished")? "selected='selected'" : ""; ?>>체험단 마감</option>
		    </select>
		    <input type="radio" name="dateType" id="dateType_1" value="1" <?=($_GET["dateType"]=="1" || !$_GET["dateType"]) ? "checked":""?>/><label for="dateType_1">진행별</label>
			<input type="radio" name="dateType" id="dateType_2" value="2" <?=$_GET["dateType"]=="2" ? "checked":""?>/><label for="dateType_2">기간별</label>
		    <input type="text" name="startDate" class="dateMode" value="<?=$_REQUEST['startDate']?>">
		    <span id="ui_dateType" style="display:<?=$endDateCheck?>">~  <input type="text" name="endDate" class="dateMode" value="<?=$_REQUEST['endDate']?>"></span>
		</td>
	</tr>
	<tr>
		<th>체험단 타입</th>
		<td>
			<select name="hero_type">
		    	<option value="">선택</option>
		    	<? foreach($type_arr as $key=>$val) {?>
		        <option value="<?=$key?>" <?=($key==$_GET["hero_type"] && strlen($_GET["hero_type"]) > 0)? "selected":""?>><?=$val?></option>
		        <? } ?>
		    </select>
		</td>
	</tr>
	<tr>
		<th>검색어</th>
		<td>
			<select name="select">
		    	<option value="hero_title"<?if(!strcmp($_REQUEST['select'], 'hero_title')){echo ' selected';}else{echo '';}?>>제목</option>
		        <option value="hero_command"<?if(!strcmp($_REQUEST['select'], 'hero_command')){echo ' selected';}else{echo '';}?>>내용</option>
		  		<option value="hero_all" <?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>제목+내용</option>
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
	<label>총 </label> : <strong><?=$total_data?></strong>건
</div>
		
<table class="t_list">
<colgroup>
	<col width="50px"/>
	<col width="100px"/>
	<col width="*"/>
	<col width="100px"/>
	<col width="100px"/>
	<col width="100px"/>
	<col width="100px"/>
	<col width="100px"/>
	<col width="100px"/>
	<col width="100px"/>
	<col width="100px"/>
	<col width="100px"/>
	<col width="100px"/>
	<col width="80px"/>
</colgroup>
	<thead>
		<tr>
			<th>no</th>
			<th>체험단 타입</th>
			<th>제목</th>
			<th>진행상태</th>
			<th>리본텍스트</th>
			<th>등록일</th>
			<th>체험단신청</th>
			<th>선정자발표</th>
			<th>후기등록</th>
			<th>우수후기발표</th>
			<th>신청자</th>
			<th>당첨자</th>
			<th>공정위문구 관리</th>
			<th>공개여부</th>
		</tr>
	</thead>
	<tbody>
	<? 
	if($total_data > 0) {
	while($list = @mysql_fetch_assoc($out_sql)){
	   	$check_day = date( "Y-m-d");
	   	
	   
	   	
	    $today_01_01 = substr($list['hero_today_01_01'],0,10);
	    $today_01_02 = substr($list['hero_today_01_02'],0,10);
	                         
	    $today_02_01 = substr($list['hero_today_02_01'],0,10);
	    $today_02_02 = substr($list['hero_today_02_02'],0,10);
	                         
	    $today_03_01 = substr($list['hero_today_03_01'],0,10);
	    $today_03_02 = substr($list['hero_today_03_02'],0,10);
	                         
	    $today_04_01 = substr($list['hero_today_04_01'],0,10);
	    $today_04_02 = substr($list['hero_today_04_02'],0,10);
	                         
		$div_complete='';
	                         
		if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
			$status = "<img src='/image2/etc/mission_request.jpg'>";
	    } else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
			$status = "<img src='/image2/etc/mission_release.jpg'>";
	    } else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
			$status = "<img src='/image2/etc/mission_enroll.jpg'>";
		} else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
			$status = "<img src='/image2/etc/mission_best.jpg'>";
		} else {
			$status = "체험단마감"; //어떤 기간에도 속하지 않을 때 
		}
		
		$hero_use_txt = "비공개";
		if($list["hero_use"] == "1") $hero_use_txt = "공개";
	?>
	<tr>
		<td><?=$i?></td>
		<td><?=$type_arr[$list['hero_type']];?></td>
		<td class="title"><?=$list['hero_title'];?></td>
		<td><?=$status;?></td>
		<td><?=$list['hero_kind'];?></td>
		<td><?=substr($list['hero_today'],0,10);?></td>
		<td><?=$today_01_01;?><br>~<?=$today_01_02;?></td>
		<td><?=$today_02_01;?><br>~<?=$today_02_02?></td>
		<td><?=$today_03_01?><br>~<?=$today_03_02?></td>
		<td><?=$today_04_01?><br>~<?=$today_04_02?></td>
		<td><a href="javascript:location.href='<?=PATH_HOME.'?board='.$_GET['board'].'&idx='.$_GET['idx'].'&view=01_01&hero_idx='.$list['hero_idx'];?>'" class="btnForm">확인</a></td>
		<td><a href="javascript:location.href='<?=PATH_HOME.'?board='.$_GET['board'].'&idx='.$_GET['idx'].'&view=01_02&hero_idx='.$list['hero_idx'];?>'" class="btnForm">확인</a></td>
		<td><a href="javascript:location.href='<?=PATH_HOME.'?board='.$_GET['board'].'&idx='.$_GET['idx'].'&view=01_03&hero_idx='.$list['hero_idx'];?>'" class="btnForm">확인</a></td>
		<td><?=$hero_use_txt?></td>
	</tr>
	<?
	$i--;
	}
	} else {?>
	<tr>
		<td colspan="15">등록된 데이터가 없습니다.</td>
	</tr>
	<? } ?>
	</tbody>
</table>
<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){
	$("input[name='dateType']").on("click",function(){
		if($(this).val()=="1") {
			$("#ui_dateType").hide();
			$("input[name='endDate']").val("");
		} else if($(this).val()=="2") {
			$("#ui_dateType").show();
		}
	})
})
function fnSearch() {
	if($("input[name='startDate']").val() ) {
		if($("input:radio[name='dateType']:checked").val() == "1") {
			if(!$("select[name='select_02']").val()) {
				alert("체험단기간 선택 후 날짜를 입력해 주세요.");
				return;
			}
		}

		if($("input:radio[name='dateType']:checked").val() == "2") {
			if(!$("select[name='select_02']").val()) {
				alert("체험단기간 선택 후 날짜를 입력해 주세요.");
				return;
			}

			if(!$("input[name='endDate']").val()) {
				alert("종료일을 선택해 주세요.");
				$("input[name='endDate']").focus();
				return;
			}
		}
	}
	
	$("#searchForm").submit();
}
</script>
                        