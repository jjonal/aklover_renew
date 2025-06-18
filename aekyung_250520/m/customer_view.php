<?
include_once "head.php";

if(!defined('_HEROBOARD_'))exit;

$group_sql = "SELECT * FROM hero_group WHERE hero_order!='0' AND hero_use='1' AND hero_board ='".$_GET['board']."'"; // desc
$out_group = new_sql($group_sql,$error);
$right_list = mysql_fetch_assoc ($out_group);

if(!$_GET["board"]) {
	error_historyBack("페이지 권한이 없습니다.","/m/main.php");
	exit;
}

if($right_list["hero_view"]>$_SESSION['temp_level'] && $right_list["hero_view"]!=0){
	if($_GET['board'] == "mail") {
		message("로그인 후 이용해 주세요.");
		location("/m/main.php");
	} else {
		error_historyBack("페이지 권한이 없습니다.","/m/main.php");
	}
	exit;
}

$sql  = " SELECT b.hero_idx, b.hero_title, b.hero_today, b.hero_command, b.hero_04, b.hero_code ";
$sql .= " , b.hero_10, b.hero_board_one, b.hero_board_two ,m.hero_nick , l.hero_img_new FROM board b";
$sql .= " LEFT JOIN member m ON b.hero_code=m.hero_code ";
$sql .= " LEFT JOIN level  l ON m.hero_level=l.hero_level ";
$sql .= " WHERE b.hero_code = '".$_SESSION["temp_code"]."' AND b.hero_table = '".$_GET["board"]."' AND b.hero_idx = '".$_GET["hero_idx"]."' ";

$view_res = sql($sql);
$view = mysql_fetch_assoc($view_res);

$next_command = htmlspecialchars_decode($view['hero_command']);
$next_command = str_ireplace ( "<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n", "", $next_command );
$next_command = str_ireplace ( "<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n", "", $next_command );
$next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $next_command );
$next_command = preg_replace ( "/ width=(\"|\')?\d+(\"|\')?/", " width='100%'", $next_command );
$next_command = preg_replace ( "/ height=(\"|\')?\d+(\"|\')?/", "", $next_command );
$next_command = preg_replace ( "/width: \d+px/", "", $next_command );
$temp_hero_04 = href ( nl2br ( $view ['hero_04'] ) );
$temp_hero_04 = str_ireplace ( '<A', '<A target="_blank"', $temp_hero_04 );

?>
<?include_once "cscenter.php"?>
<form name="searchForm" id="searchForm" method="GET">
<? foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
<input type="hidden" name="idx" value="<?=$view["hero_idx"]?>" />
</form>
<div class="inquiry">
	<div class="viewbox">
		<!-- 제목 -->
		<div class="t_l fz34 fw600 tit ellipsis_2line">
			<?=cut($view['hero_title'],48);?>
		</div>
		<div class="f_b writer">
			<div class="f_cs">
				<!--!!!!!!!! [개발요청] 질문자 프로필 이미지 노출!!!!!!!!  -->
				<img src="/img/front/main/profile.webp" alt="aklover" class="profile">
				<a href="javascript:;" onClick="fnProfile('<?=encrypt($view['member_idx']);?>')"><span class="fz28 gray07"><?=$view['hero_nick'];?></span></a> 
			</div>
			<div class="op05 fz28"><?=date( "Y.m.d h:i:s", strtotime($view['hero_today']));?></div>
		</div>

		
		<!-- 내용 -->
		<div class="cont">
			<div class="cont_inner textstyle">
				<?=$next_command;?>  
			</div>
			<!-- 첨부파일 -->                 
			<? if($view['hero_board_two']) {?>
			<div class="contFileBox">
			<div class="file f_cs">
				<span class="fz18 fw500">파일</span>
				<a href="<?=FREEBEST_END?>download.php?hero=<?=$view['hero_board_one']?>&download=<?=$view['hero_board_two']?>" ><?=$view['hero_board_two'];?></a>
			</div>
			<? } ?>
		</div>
		<!-- 답변 -->
		<? if($view['hero_10']) {?>
			<div class="replybox">                                                
				<div class="cont_tit">
					<!--!!!!!!!! [개발요청] 답변 제목 노출!!!!!!!!  -->
					<div class="t_l fz30 fw600 tit"><!--<?=$out_row['hero_title']?>-->
						Re:"문의하신 내용에 대한 답변드립니다."
					</div>
					<div class="f_b writer">
						<div class="f_cs">
							<!--!!!!!!!! [개발요청] 답변자 프로필 이미지 노출!!!!!!!!  -->
							<img src="/img/front/main/답변자프사.webp" alt="aklover" class="profile">
							<!--!!!!!!!! [개발요청] 답변자 닉네임 노출!!!!!!!!  -->
							<span class="fz26 gray07 nick">답변자</span>
							<span class="fz26 gray07"><?=nl2br($view["hero_10"])?></span>                                                
					</div>
						<!--!!!!!!!! [개발요청] 답변 시간 노출!!!!!!!!  -->
						<div class="op05 fz26">답변시간</div>
					</div>
				</div>
				<div class="textstyle"><?=nl2br($view["hero_10"])?></div>
				<? if($view['hero_code'] == $_SESSION['temp_code']){?>
					<div class="flex">
					<a href="javascript:;" onClick="fnEdit()" class="btn_modify">수정</a>
					<? if(!$view['hero_10']) {?>
						<a href="javascript:;" onClick="fnDel()" class="btn_del">삭제</a>
					<? } ?>
					</div>
				<? } ?>
			</div>
		<?}?>
		<div class="btnGroup mgt20 mgb20">
			<div class="left">
				<a href="javascript:;" onClick="fnList();" class="btn_list">목록으로</a>
			</div>			
		</div>
	</div>
</div>
<link href="css/musign/board.css" rel="stylesheet" type="text/css">
<link href="css/musign/cscenter.css" rel="stylesheet" type="text/css">	
<? include_once "btnTop.php";?>
<? include_once "tail.php";?>
<script>
$(document).ready(function(){
	fnDel = function() {
		if(confirm("삭제하시겠습니까?")) {
			location = "/m/action.php?board=<?=$_GET['board']?>&action=delete&idx=<?=$_GET['hero_idx']?>";
		}
	}
	
	fnList = function() {
		$("#searchForm").attr("action","customer.php").submit();
	}

	fnEdit = function() {
		$("#searchForm input[name='hero_idx']").val("");
		$("#searchForm").attr("action","write.php").submit();
	}
})
</script>
