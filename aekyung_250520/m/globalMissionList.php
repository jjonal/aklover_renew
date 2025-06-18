<?
include_once "head.php";

if(!$_SESSION["global_code"]) {
	location("/m/globalNoticeList.php?board=group_04_30");
	exit;
}

$search = "";
$temp_search = "";
if($_SESSION["global_admin_yn"] != "Y") {
	$temp_search .= " AND hero_start_date <= DATE_FORMAT(NOW(),'%Y-%m-%d') ";
	$temp_search .= " AND hero_country = '".$_SESSION["global_country"]."' ";
}

if($_GET["hero_country"]) {
	$search .= " AND hero_country = '".$_GET["hero_country"]."' ";
}

if($_GET["kewyword"]) {
	$search .= " AND ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

$total_sql = " SELECT count(*) cnt FROM global_mission WHERE hero_use_yn = 'Y' ".$temp_search." ".$search;

sql($total_sql,"on");
$total_rs = mysql_fetch_assoc($out_sql);
$total_data = $total_rs["cnt"];

$list_page=20;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next;

$sql  = " SELECT hero_idx, hero_thumb, hero_title, hero_title_02, hero_start_date, hero_end_date ";
$sql .= " ,case when (hero_start_date <= DATE_FORMAT(NOW(),'%Y-%m-%d') && hero_end_date >= DATE_FORMAT(NOW(),'%Y-%m-%d')) then 'ing' ELSE 'end' END status ";
$sql .= " FROM global_mission WHERE hero_use_yn = 'Y' ".$temp_search." ".$search;
$sql .= " ORDER BY hero_idx DESC ";
$list_res = sql($sql);
?>
<link href="css/general.css?ver=210518" rel="stylesheet" type="text/css">
<div class="introTxtWrap">
	<div class="title">|&nbsp;&nbsp;진행중인 미션</div> 
    <div class="content" style="width:calc(100% - 100px)">애경의 생활 제품을 직접 체험하고 다양한 소식을 전하는 Global Club 회원 여러분만을 위한 공간입니다.</div>
</div>
<div id="gallery">
	<? if($_SESSION["global_admin_yn"] == "Y") {?>
	<ul id="missionStatus">
		<li class="missionStatusSearch <?=$_GET['hero_country']==""?"on":""?>" onClick="fnCountry('')">전체</li>
		<li class="missionStatusSearch <?=$_GET['hero_country']=="vn"?"on":""?>" onClick="fnCountry('vn')">베트남</li>
		<li class="missionStatusSearch <?=$_GET['hero_country']=="ru"?"on":""?>" onClick="fnCountry('ru')">러시아</li>
		<li class="missionStatusSearch <?=$_GET['hero_country']=="cn"?"on":""?>" onClick="fnCountry('cn')">중국</li>
	</ul>
	<? } ?>
	<ul class="mobileMissionList">
		<? if($total_data > 0){
			while($list = mysql_fetch_assoc($list_res)) {
				$start_date = substr($list["hero_start_date"],5,2)."월".substr($list["hero_start_date"],8,2)."일";
				$end_date = substr($list["hero_end_date"],5,2)."월".substr($list["hero_end_date"],8,2)."일";
				
				$status_txt = "";
				$status_num = "";
				if($list["status"] == "ing") {
					$status_txt = "진행중";
					$status_num = "1";
				} else if($list["status"] == "end") {
					$status_txt = "마감";
					$status_num = "2";
				}
				
				$period_day =  (intval(strtotime($list['hero_end_date'])-strtotime(date("Ymd")))/86400);
		?>
		<li>
			<a href="javascript:;" onClick="fnView('<?=$list["hero_idx"]?>')">
				<div class="thumb"><img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$list["hero_thumb"]?>"></div>
				<span class="status color_<?=$status_num?>"><?=$status_txt?></span>
				<? if($list["status"] == "ing") {?>
					<? if($period_day) {?>
						<span class="period">D-<?=$period_day?></span>
					<? } else if($period_day == 0 && strlen($period_day) > 0) { ?>
						<span class="period">
							D-day
						</span>
					<? } ?>
				<? } ?>
				<div class="date">
					<?=$start_date?> - <?=$end_date?>
				</div>
				<div class="title"><?=cut($list["hero_title"],'35')?></div>
			</a>
		</li>
	<? }
	}
	?>
    </ul>
    <? if($total_data == 0) {?>
    <div id="blankList">
        	검색결과가 없습니다.
	</div>
	<? } ?>
     <div class="clear"></div> 
</div>
<div id="page_number"><?include_once "page.php"?></div>
<!--  (s)search box  -->
<div id="searchBox">
	<form method="GET" id="frm">
	<input type="hidden" name="hero_idx" value="">
	<input type="hidden" name="board" value="<?=$_GET["board"]?>">
	<input type="hidden" name="hero_country" value="<?=$_GET["hero_country"]?>"/>
		<select name="select">
			<option value="hero_title">제목</option>
		</select>
		<input name="kewyword" type="text" value="<?=$_GET["kewyword"]?>" class="kewyword">
		<a href="javascript:$('#frm').submit();">검색</a>
	</form>
</div>
<!--  (e)search box -->
<!-- gallery 종료 --> 
<?include_once "tail.php";?>
<script>
$(document).ready(function(){
	fnView = function(hero_idx) {
		$("#frm input[name='hero_idx']").val(hero_idx);
		$("#frm").attr("action","globalMissionView.php").submit();
	}

	fnCountry = function(country) {
		$("#frm input[name='hero_country']").val(country);
		$("#frm").submit();
	}

	fnSearch = function() {
		$("#searchForm").submit();
	}
})
</script>
