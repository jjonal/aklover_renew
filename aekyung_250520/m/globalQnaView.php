<?
include_once "head.php";

if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION["global_code"]) {
	location("globalNoticeList?board=group_04_30");
	exit;
}

$temp_search = "";
if($_SESSION["global_admin_yn"] != "Y") { //임시 글
	$temp_search = " AND b.hero_temp != '1' ";
}

$sql  = " SELECT b.hero_idx, b.hero_title, b.hero_code, b.hero_command, b.hero_table ";
$sql .= " , b.hero_today, b.hero_answer, b.hero_file, b.hero_ori_file, b.hero_pcMobile, m.hero_nick, m.hero_level, m.hero_admin_yn ";
$sql .= " FROM global_board b ";
$sql .= " LEFT JOIN global_member m ON b.hero_code = m.hero_code ";
$sql .= " WHERE b.hero_use_yn = 'Y' AND b.hero_idx = '".$_GET["hero_idx"]."' ".$temp_search;
$res = sql($sql, "on");
$view = mysql_fetch_assoc($res);

$temp_command = htmlspecialchars_decode($view['hero_command']);
$next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $temp_command );

$level_icon = "";
if($view["hero_level"] == "9999") {
	$level_icon = "/image/bbs/levAdmin01.png";
} else {
	$level_icon = "/image/bbs/lev_global.png";
}

//권한 자신이 작성한 글만 볼 수 있음
if(($view["hero_code"] != $_SESSION["global_code"]) && $_SESSION["global_admin_yn"] != "Y") {
	error_historyBack("본인이 작성한 글만 접근 가능합니다.");
	exit;
}

$next_command = htmlspecialchars_decode ($view['hero_command'] );
$next_command = str_ireplace ( "<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n", "", $next_command );
$next_command = str_ireplace ( "<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n", "", $next_command );
$next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $next_command );
/* $next_command = preg_replace ( "/ width=(\"|\')?\d+(\"|\')?/", " width='100%'", $next_command ); */
$next_command = preg_replace ( "/ height=(\"|\')?\d+(\"|\')?/", "", $next_command );
/* $next_command = preg_replace ( "/width: \d+px/", "width:100%;", $next_command ); */
$next_command = preg_replace ( "/height: \d+px;/", "", $next_command );
$next_command = preg_replace ( "/height: \d+px/", "", $next_command );
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
<link href="css/today.css??version=<?=date("YmdHis")?>" rel="stylesheet" type="text/css">
<div class="introTxtWrap">
	<div class="title ">|&nbsp;&nbsp;1:1 문의</div> 
    <div class="content" style="width:calc(100% - 70px)">애경의 생활 제품을 직접 체험하고 다양한 소식을 전하는 Global Club 회원 여러분만을 위한 공간입니다.</div>
</div>
<div class="clear"></div>
<form name="searchForm" id="searchForm" method="GET">
<? foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>

<form name="frm" id="frm" method="POST" action="globalQnaAction.php?board=<?=$_GET["board"]?>&action=drop">
<input type="hidden" name="hero_idx" value="<?=$view["hero_idx"]?>" />
<input type="hidden" name="hero_table" value="<?=$view["hero_table"]?>" />
<input type="hidden" name="board_code" value="review" />
</form>
<div class="viewWrap">
	<div class="titleBox">
		<p>
			<?=$new_img_view?><?=cut($view['hero_title'],48);?>
		</p>
		<p class="txt_nick"><img src="<?=$level_icon?>"/><?=$view['hero_nick'];?> 
		   <span><?=date( "Y.m.d", strtotime($view['hero_today']));?></span>
		</p>
	</div>
	<div class="contBox"><?=$next_command;?></div>
	
	<? if($view['hero_file']) {?>
		<div class="contFileBox">
			<label>파일</label> <a href="<?=FREEBEST_END?>download.php?hero=<?=$view['hero_file']?>&download=<?=$view['hero_ori_file']?>"><?=$view["hero_ori_file"]?></a>
		</div>
	<? } ?>
	
	<? if($view["hero_answer"]) {?>
		<div class="contAnswoerBox">
			<p class="tit_answer">답변<p>
			<p><?=nl2br($view["hero_answer"])?></p>
		</div>
	<? } ?>

	<div class="btnGroup mgt20 mgb20">
		<div class="left">
			<a href="javascript:;" onClick="fnList()"><img src="img/review/list_btn.jpg" /></a>
		</div>
		<div class="right">
			<? if($view["hero_code"] == $_SESSION["global_code"]) {?>
				<a href="javascript:;" onClick="fnEdit()"><img src="img/review/modify_btn.jpg" /></a>
			<? } ?>
			<? if($view["hero_code"] == $_SESSION["global_code"] && !$view["hero_answer"]) {?>
				<a href="javascript:;" onClick="fnDelete()"><img src="img/review/delete_btn.jpg" /></a>
			<? } ?>
		</div>
	</div>
</div>
<script>
function fnList() {
	$("#searchForm").attr("action","globalQnaList.php").submit();	
}

function fnEdit(){
	$("#searchForm").attr("action","globalQnaWrite.php").submit();	
}

fnDelete = function() {
	if(confirm("삭제하시겠습니까?")) {
		$("#frm").submit();
	}
}
</script>
<div class="img-loading"></div>
<!--컨텐츠 종료-->
<? include_once "btnTop.php";?>
<? include_once "tail.php";?>