<?
include_once "head.php";

if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION["global_code"]) {
	location("globalNoticeList?board=group_04_30");
	exit;
}

$search = "";
$temp_search = "";
if($_SESSION["global_admin_yn"] != "Y") {
	$temp_search .= " AND hero_start_date <= DATE_FORMAT(NOW(),'%Y-%m-%d') ";
	$temp_search .= " AND hero_country = '".$_SESSION["global_country"]."' ";
}

$sql  = " SELECT hero_idx, hero_thumb , hero_title, hero_title_02, hero_product  ";
$sql .= " , hero_start_date, hero_end_date, hero_command, hero_media, hero_required ";
$sql .= " , hero_tag , hero_tag_sub, hero_guide, hero_help, guide_ori_file1 ";
$sql .= " , guide_file1, guide_ori_file2, guide_file2 ";
$sql .= " FROM global_mission ";
$sql .= " WHERE hero_use_yn = 'Y' AND hero_idx ='".$_GET["hero_idx"]."' ".$temp_search;
$res = sql($sql, "on");
$view = mysql_fetch_assoc($res);

$start_date = substr($view["hero_start_date"],5,2)."월".substr($view["hero_start_date"],8,2)."일";
$end_date = substr($view["hero_end_date"],5,2)."월".substr($view["hero_end_date"],8,2)."일";

if($view['hero_command'] == "&lt;br /&gt;") {
	$command = "";
} else {
	//공지 상세
	$command = htmlspecialchars_decode($view['hero_command']);
	$command = str_replace("&#160;","",$command);

	//20170512 체험단신청(체험단만 존재)
	$hero_media = htmlspecialchars_decode($view['hero_media']);
	$hero_media = str_replace("&#160;","",$hero_media);
}
?>
<link href="css/general_viewer.css?v=1" rel="stylesheet" type="text/css">
<div class="introTxtWrap">
	<div class="title">|&nbsp;&nbsp;진행중인 미션</div> 
    <div class="content" style="width:calc(100% - 100px)">애경의 생활 제품을 직접 체험하고 다양한 소식을 전하는 Global Club 회원 여러분만을 위한 공간입니다.</div>
</div>
<div class="clear"></div>
<form name="searchForm" id="searchForm" method="GET">
<? foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>
<div class="mission_wrap">
	<div class="mission_view_img">
		<img src="<?=$view["hero_thumb"]?>">
	</div>
	
	<div class="mission_view_title">
		<p class="top_title"><?=$view['hero_title']?></p>
		<p class="top_title2"><?=$view['hero_title_02']?></p>
		<table>
		<tbody>
		<tr>
			<th>미션기간</th>
			<td><?=$start_date?> ~ <?=$end_date?></td>
		</tr>
		<tr>
			<th>미션제품</th>
			<td><?=$view['hero_product']?></td>
		</tr>
		</tbody>
		</table>
	</div>
	
	<ul class="tabArea">
		<li><a href="#" class="on" style="text-align:center;">제품소개</a></li>
		<li><a href="#" style="text-align:center;">안내/참여 방법</a></li>
		<li><a href="#" style="text-align:center;">미션 가이드</a></li>
	</ul>
	
	<div class="m_content_guide">
		<table style="width:100%;">
		<tbody>
			<? if($view['guide_ori_file1'] || $view['guide_ori_file2']){ ?>
			<tr class="tabBtnArea3">
				<th>미션 가이드라인</th>
			</tr>
			<tr class="tabBtnArea3">
				<td>
				<? if($view['guide_ori_file1'] ) { ?>
                <a href="/freebest/auth_download.php?hero_idx=<?=$view["hero_idx"]?>&type=globalMission&column=guide1&download=<?=$view['guide_ori_file1']?>" class="download_btn">
					가이드라인(1) 다운로드 ▼
                </a>
		      	<? } ?>
		        <? if($view['guide_ori_file2']) { ?>
				<a href="/freebest/auth_download.php?hero_idx=<?=$view["hero_idx"]?>&type=globalMission&column=guide2&download=<?=$view['guide_ori_file2']?>" class="download_btn">
					가이드라인(2) 다운로드 ▼
				</a>
				<? } ?>
				</td>
			</tr>
			<? } ?>
			<? if($view["hero_required"]) {?>
				<tr class="tabBtnArea3">
					<th>필수 미션</th>
				</tr>
				<tr class="tabBtnArea3">
           			<td><?=nl2br($view["hero_required"])?></td>
      			</tr>
			<? } ?>
			<? if($view['hero_help']){ ?>
      			<tr class="tabBtnArea3">
		            <th>콘텐츠 가이드</th>
		        </tr>
		        <tr class="tabBtnArea3">
          	  		<td><?=str_replace("\n","<br>",$view['hero_help']);?></td>
       			</tr>
			<? } ?>
			<? if($view['hero_tag']){ ?>
      			<tr class="tabBtnArea3">
		            <th>필수 키워드</th>
		        </tr>
		        <tr class="tabBtnArea3">
		            <td><?=$view['hero_tag']?></td>
	        	</tr>
	        <? } ?>
	        <? if($view['hero_tag_sub']){ ?>
      			<tr class="tabBtnArea3">
		            <th>선택 키워드</th>
		        </tr>
		        <tr class="tabBtnArea3">
		            <td><?=$view['hero_tag_sub']?></td>
	        </tr>
	        <? } ?>
			<tr class="tabBtnArea2">
				<th>미션 안내</th>
			</tr>
			<tr class="tabBtnArea2">
				<td><?=htmlspecialchars_decode($view['hero_guide'])?></td>
			</tr>
			<tr class="tabBtnArea2">
				<th>미션 참여방법</th>
			</tr>
			<tr class="tabBtnArea2">
				<td><?=$hero_media;?></td>  
	        </tr>
			<tr class="tabBtnArea1">
				<th>제품소개</th>
			</tr>
		</tbody>
		</table>
		
		<div class="spm_img notice_bottom tabBtnArea1">
			<?=htmlspecialchars_decode($command);?>
		</div>
	</div>
</div>
<div class="mission_view_btn">
	<a href="javascript:;" onClick="fnList();" class="m_content_btn">목록</a>
</div>
<div class="img-loading"></div>
<!--컨텐츠 종료-->
<? include_once "btnTop.php";?>
<? include_once "tail.php";?>
<script>
$(document).ready(function(){
	$(".tabArea li a").on("click",function(){
		var tabNum = $(this).parent("li").index()+1;
		console.log(tabNum);
		$(".tabArea li a").removeClass("on");
		$(this).addClass("on");
		
		$(".m_content_guide table tr").hide();
		$(".m_content_guide .tabBtnArea1").hide();

		$(".m_content_guide .tabBtnArea"+tabNum).show();
	})

	fnList = function(){
		$("#searchForm").attr("action","globalMissionList.php").submit();	
	}
})
</script>