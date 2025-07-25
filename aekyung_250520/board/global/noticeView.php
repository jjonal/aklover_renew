<?
if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION["global_code"]) {
	location("/main/index.php?board=group_04_30&view=noticeList");
	exit;
}

$temp_search = "";
if($_SESSION["global_admin_yn"] != "Y") { //임시 글
	$temp_search = " AND b.hero_temp != '1' ";
}

$sql  = " SELECT b.hero_idx, b.hero_title, b.hero_code, b.hero_command, b.hero_table ";
$sql .= " , b.hero_today, b.hero_file, b.hero_ori_file, b.hero_pcMobile, m.hero_nick, m.hero_admin_yn ";
$sql .= " FROM global_board b ";
$sql .= " LEFT JOIN global_member m ON b.hero_code = m.hero_code ";
$sql .= " WHERE b.hero_use_yn = 'Y' AND b.hero_idx = '".$_GET["hero_idx"]."' ".$temp_search;

$res = sql($sql, "on");
$view = mysql_fetch_assoc($res);

$temp_command = htmlspecialchars_decode($view['hero_command']);
$next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $temp_command );

if($view["hero_pcMobile"] == "M") {
	$next_command = nl2br($next_command);
}

$level_icon = "";
if($view["hero_admin_yn"] == "Y") {
	$level_icon = "/image/bbs/levAdmin01.png";
} else {
	$level_icon = "/image/bbs/lev_global.png";
}
?>
<form name="searchForm" id="searchForm" method="GET">
<? foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>
<div class="contents_area">
	<div class="page_title">
		<div>공지사항</div>
		<ul class="nav">
			<li><img src="/image/common/icon_nav_home.gif" alt="home" /></li>
			<li>&gt;</li>
			<li>글로벌 클럽</li>
			<li>&gt;</li>
			<li class="current">공지사항</li>
		</ul>
	</div>
	<form name="frm" id="frm" method="POST" action="<?=MAIN_HOME;?>?board=<?=$_GET["board"]?>&view=noticeAction&action=drop">
		<input type="hidden" name="hero_idx" value="<?=$view["hero_idx"]?>" />
		<input type="hidden" name="hero_table" value="<?=$view["hero_table"]?>" />
		<input type="hidden" name="board_code" value="notice" />
	</form>
	<div class="contents">
		<table border="0" cellpadding="0" cellspacing="0" class="bbs_view">
		<colgroup>
			<col width="90px" />
			<col width="400px" />
			<col width="100px" />
			<col width="105px" />
		</colgroup>
		<tbody>
		<tr class="bbshead print_area">
			<th><img src="../image/bbs/tit_subject.gif" alt="제목"></th>
			<td colspan="3"><?=$view["hero_title"]?></td>
		</tr>
		<tr class="print_area">
			<th><img src="../image/bbs/tit_writer_2.gif" alt="작성자"></th>
			<td><img src="<?=$level_icon?>" /><?=$view['hero_nick']?></td>
			<th><img src="../image/bbs/tit_date.gif" alt="날짜"></th>
			<td><?=date( "y-m-d H:i", strtotime($view['hero_today']));?></td>
		</tr>
		<tr class="print_area">
			<td colspan="4" valign="top" width="705px" class="bbs_view" style="padding: 25px; word-break: break-all; color:#000;">
				  <?=$next_command?>  	
			</td>
		</tr>
		<? if($view['hero_file']) {?>
		<tr>
			<th><img src="../image/bbs/tit_file.gif" alt="파일" /></th>
			<td colspan="3"><a href="<?=FREEBEST_END?>download.php?hero=<?=$view['hero_file']?>&download=<?=$view['hero_ori_file']?>" ><?=$view['hero_ori_file'];?></td><!--677-->
		</tr>
		<? } ?>
		</tbody>
		</table>
		<div class="btngroup">
		 	<div class="btn_l" style="float:left; width:50%">
		 		<a href="javascript:;" onClick="fnList();" class="a_btn2">목록</a>
		 		<? if($_SESSION["global_admin_yn"] == "Y") {?>
		 			<a href="javascript:;" onClick="fnDelete()" class="a_btn">삭제</a>
		 		<? } ?>
		 	</div>
	 	 	<div class="btn_r" style="float:right; width:50%; text-align:right;">
	 	 		<? if($_SESSION["global_admin_yn"] == "Y") {?>
	 	 			<a href="javascript:;" onclick="fnEdit()" class="a_btn">수정</a>
	 	 		<? } ?>
	 	 	</div>
		</div>
		<div style="clear:both;"></div>
		<? include_once 'globalReply.php';?>
		 
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	fnList = function() {
		$("#searchForm input[name='view']").val("noticeList");
		$("#searchForm").submit();
	}

	fnEdit = function() {
		$("#searchForm input[name='view']").val("noticeWrite");
		$("#searchForm").submit();
	}

	fnDelete = function() {
		if(confirm("삭제하시겠습니까?")) {
			$("#frm").submit();
		}
	}
})
</script>
