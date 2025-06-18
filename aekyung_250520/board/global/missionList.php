<?
if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION["global_code"]) {
	location("/main/index.php?board=group_04_30&view=noticeList");
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

$list_page=9;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next;

$sql  = " SELECT hero_idx, hero_thumb, hero_title, hero_title_02, hero_start_date, hero_end_date ";
$sql .= " ,case when (hero_start_date <= DATE_FORMAT(NOW(),'%Y-%m-%d') && hero_end_date >= DATE_FORMAT(NOW(),'%Y-%m-%d')) then 'ing' ELSE 'end' END status ";
$sql .= " FROM global_mission WHERE hero_use_yn = 'Y' ".$temp_search." ".$search;
$sql .= " ORDER BY hero_idx DESC ";
$list_res = sql($sql);

?>
<div class="contents_area">
	<div class="page_title">
		<div>�������� �̼�</div>
		<ul class="nav">
			<li><img src="/image/common/icon_nav_home.gif" alt="home" /></li>
			<li>&gt;</li>
			<li>�۷ι� Ŭ��</li>
			<li>&gt;</li>
			<li class="current">�������� �̼�</li>
		</ul>
	</div>
	<form name="searchForm" id="searchForm">
	<input type="hidden" name="hero_idx" value=""/>
	<input type="hidden" name="board" value="<?=$_GET["board"]?>"/>
	<input type="hidden" name="view" value="<?=$_GET["view"]?>"/>
	<input type="hidden" name="hero_country" value="<?=$_GET["hero_country"]?>"/>
	<div class="contents">
		<div class="listHeadTitle">
			<div class="headImg "><img src="/image2/lev_global.png"></div>
	    	<div class="headText" style="margin-top:0;">�ְ��� ��Ȱ ��ǰ�� ���� ü���ϰ� �پ��� �ҽ��� ���ϴ� Global Club ȸ�� �����и��� ���� �����Դϴ�.</div>
		</div>
		<div style="clear:both;"></div>
		
		<? if($_SESSION["global_admin_yn"] == "Y") {?>
		<div class="boardTabMenuWrap colorType">
			<a href="javascript:;" onClick="fnCountry('')" <?if(!$_GET["hero_country"]) {?>class="on"<?}?>>��ü</a>
			<a href="javascript:;" onClick="fnCountry('vn')" <?if($_GET["hero_country"] == "vn") {?>class="on"<?}?>>��Ʈ��</a>
			<a href="javascript:;" onClick="fnCountry('ru')" <?if($_GET["hero_country"] == "ru") {?>class="on"<?}?>>���þ�</a>
			<a href="javascript:;" onClick="fnCountry('cn')" <?if($_GET["hero_country"] == "cn") {?>class="on"<?}?>>�߱�</a>
		</div>
		<? } ?>
		
		<div class="blog_box2 mgt20">
			<ul class="blog_article">
				<? if($total_data > 0){ 
					while($list = mysql_fetch_assoc($list_res)) {
						$start_date = substr($list["hero_start_date"],5,2)."��".substr($list["hero_start_date"],8,2)."��";
						$end_date = substr($list["hero_end_date"],5,2)."��".substr($list["hero_end_date"],8,2)."��";
						
						$status_txt = "";
						$status_num = "";
						if($list["status"] == "ing") {
							$status_txt = "������";
							$status_num = "1";
						} else if($list["status"] == "end") {
							$status_txt = "����";
							$status_num = "2";
						}
						
						$period_day =  (intval(strtotime($list['hero_end_date'])-strtotime(date("Ymd")))/86400);
				?>
				<li>
					<a href="javascript:;" onClick="fnView('<?=$list["hero_idx"]?>')">
						<div class="thumb">
							<img class="mission_image" onerror="this.src='/image/hero.jpg'" src="<?=$list["hero_thumb"]?>" alt="">
						</div>
						<span class="status color_<?=$status_num?>"><?=$status_txt?></span>
						
						<? if($list["status"] == "ing") {?>
							<? if($period_day) {?>
							<span class="period">
								D-<?=$period_day?>
							</span>
							<? } else if($period_day == 0 && strlen($period_day) > 0) { ?>
								<span class="period">
									D-day
								</span>
							<? } ?>
						<? } ?>
						<span class="date_02"><?=$start_date?>-<?=$end_date?></span>
						<span class="title_02"><?=$list["hero_title"]?></span>
						<span class="txt_02"><?=$list["hero_title_02"]?></span>
					</a>
				</li> 
				<? }
				} 
				?>
			</ul>
			<? if($total_data == 0) {?>
				<p style="font-size:14px; text-align:center; padding:30px 0 30px 0;">��ϵ� �����Ͱ� �����ϴ�.</p>
			<? } ?>
		</div>
			
		<div style="clear:both;"></div>
		<? if($_SESSION["global_admin_yn"] == "Y") {?>	
		<div class="btngroup">
			<div class="btn_r">
				<a href="javascript:;" onClick="fnWritePage()" class="a_btn">�̼� �ۼ��ϱ�</a>
			</div>
		</div>
		<? } ?>
		
		<div class="paging">
			<? include_once BOARD_INC_END.'page.php'; ?>
		</div>
		
		<div class="searchbox">
			<select name="select" style="padding:6px 6px;width:100px;font-size:14px;">
    			<option value="hero_title" <?=$_GET["select"]=="hero_title" ? "selected":"";?>>����</option>
			</select>
			<input name="kewyword" type="text" value="<?=$_GET["kewyword"]?>" class="kewyword" placeholder="�˻�� �Է����ּ���">
			<input type="button" onClick="fnSearch()" class="search_btn" value="�˻�">
		</div>		
	</div>
	</form>
</div>
<script>
$(document).ready(function(){
	fnWritePage = function() {
		$("#searchForm input[name='view']").val("missionManageWrite");
		$("#searchForm").submit();
	}

	fnView = function(hero_idx) {
		$("#searchForm input[name='hero_idx']").val(hero_idx);
		$("#searchForm input[name='view']").val("missionView");
		$("#searchForm").submit();
	}

	fnCountry = function(country) {
		$("#searchForm input[name='hero_country']").val(country);
		$("#searchForm").submit();
	}

	fnSearch = function() {
		$("#searchForm").submit();
	}
})
</script>