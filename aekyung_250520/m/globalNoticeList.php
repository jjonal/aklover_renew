<?
include_once "head.php";

if(!defined('_HEROBOARD_'))exit;

$noAuthPage = true;

if(!$_SESSION["global_code"]) {
	$noAuthPage = false;
}

$temp_search = "";
$search = "";
if($_SESSION["global_admin_yn"] != "Y") { //�ӽ� ��
	$temp_search .= " AND b.hero_temp != '1' ";
}

if($_GET['kewyword']){
   $search .= " AND ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

if(!$_GET['page'])			$page = '1';
else						$page = $_GET['page'];

$list_page = 10;
$page_per_list = 5;
$start = ($page-1)*$list_page;

$notice_sql  = " SELECT b.hero_idx, b.hero_code, b.hero_title, b.hero_today, b.hero_temp ";
$notice_sql .= " , m.hero_nick, m.hero_level, m.hero_admin_yn ";
$notice_sql .= " ,(SELECT count(*) FROM global_reply WHERE hero_old_idx = b.hero_idx) reply_count ";
$notice_sql .= " FROM global_board b ";
$notice_sql .= " LEFT JOIN global_member m ON b.hero_code = m.hero_code ";
$notice_sql .= " WHERE b.hero_use_yn = 'Y'  AND b.hero_notice = '1' AND b.hero_table = '".$_GET["board"]."' ";
$notice_sql .= " AND b.board_code= 'notice' ".$temp_search;
$notice_sql .= " ORDER BY b.hero_idx DESC ";

$notice_res = sql($notice_sql, "on");

$total_sql  = " SELECT count(*) cnt FROM global_board b ";
$total_sql .= " WHERE b.hero_use_yn = 'Y' AND b.hero_notice != '1' AND b.hero_table = '".$_GET["board"]."' ";
$total_sql .= " AND b.board_code= 'notice' ".$temp_search." ".$search;
$total_res = sql($total_sql);
$total_rs = mysql_fetch_assoc($total_res);
$total_data = $total_rs["cnt"];

$sql  = " SELECT b.hero_idx, b.hero_code, b.hero_title, b.hero_today, b.hero_temp ";
$sql .= ", m.hero_nick, m.hero_level, m.hero_admin_yn ";
$sql .= " ,(SELECT count(*) FROM global_reply WHERE hero_old_idx = b.hero_idx) reply_count ";
$sql .= " FROM global_board b ";
$sql .= " LEFT JOIN global_member m ON b.hero_code = m.hero_code ";
$sql .= " WHERE b.hero_use_yn = 'Y'  AND b.hero_notice != '1' AND b.hero_table = '".$_GET["board"]."' ";
$sql .= " AND b.board_code= 'notice' ".$temp_search." ".$search;
$sql .= " ORDER BY b.hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$res = sql($sql);

$num = $total_data - $start;
$next_path = get("page");
?>
<link href="css/today.css?ver=20210202_v2" rel="stylesheet" type="text/css">
<div class="introTxtWrap">
	<div class="title">|&nbsp;&nbsp;��������</div> 
    <div class="content" style="width:calc(100% - 70px)">�ְ��� ��Ȱ ��ǰ�� ���� ü���ϰ� �پ��� �ҽ��� ���ϴ� Global Club ȸ�� �����и��� ���� �����Դϴ�.</div>
</div>

<? if(!$noAuthPage) {?>
<div class="authPage">  
	<div class="noAuthPage">  	
		<div class="img_product"><img src="img/focus_main_global.jpg" alt=""></div>
		<div class="bg_explain">
			<dl class="box_explain">
				<dt><span>���</span></dt>
				<dd>�۷ι� ������  SNS  ���</dd>
				<dt><span>�������</span></dt>
				<dd>���� ���� �Ⱓ�� ����</dd>
				<dt><span>�ֿ�Ȱ��</span></dt>
				<dd>�̼��� ���� �ı� �ۼ� ��</dd>
				<dt><span>����</span></dt>
				<dd>���� ����</dd>	
			</dl>
		</div>
	</div>
</div>
<? } else { ?>
	<? if($_SESSION["global_admin_yn"] == "Y") {?>
	<span class="gallery_btn"> 
		<a href="<?=DOMAIN_END?>m/globalNoticeWrite.php?board=<?=$_GET['board']?>" class="btn">�۾���</a>
	</span>
	<? } ?>
	<div class="clear"></div>
	<div id="today_list">
	<? while($notice_list = mysql_fetch_assoc($notice_res)){
		$level_icon = "";
		if($notice_list["hero_admin_yn"] == "Y") {
			$level_icon = "/image/bbs/levAdmin01.png";
		} else {
			$level_icon = "/image/bbs/lev_global.png";
		}
		
		$new_img_view = "";
		if(substr($notice_list["hero_today"],0,10) == date("Y-m-d")) {
			$new_img_view = "<img src='".DOMAIN_END."image/main_new_bt.png' alt='new' />";
		}
	?>
		<div class="tabbtn">
			<a href="javascript:;" onClick="fnView('<?=$notice_list['hero_idx'];?>')">
				<div class="title_left">
					<ul>
						<li class="tabbtn_title">
							<span>[����]</span>
							<?if($notice_list["hero_temp"]=="1"){?>[�ӽñ�]<?}?>
							<?=cut($notice_list["hero_title"],32)?>
							<? if($notice_list["reply_count"] > 0 ) {?>
	        					<font color='orange'>[<?=$notice_list["reply_count"]?>]</font>
	        				<? } ?>
	        				<?=$new_img_view?>
						</li>
						<li class="tabbtn_top">
							<img src="<?=$level_icon?>" /><?=$notice_list['hero_nick']?>
							<span class="date"><?=date( "Y.m.d", strtotime($notice_list['hero_today']));?></span>
						</li>
					</ul>
				</div>
				<div class="title_right" style="float:right; margin-right:3%;">
					<img src="img/today/list_arrow1_190419.png" alt=""	width="24" />
				</div>
			</a>
		</div>
		<div class='tabcon tabcon_<?=$hero_notice_list["hero_idx"]?> tabcon_hide'></div>
	<? } ?>  
	<? 
	if($total_data > 0) {
		while($list = mysql_fetch_assoc($res)){
			$level_icon = "";
			if($list["hero_admin_yn"] == "Y") {
				$level_icon = "/image/bbs/levAdmin01.png";
			} else {
				$level_icon = "/image/bbs/lev_global.png";
			}
			
			$new_img_view = "";
			if(substr($list["hero_today"],0,10) == date("Y-m-d")) {
				$new_img_view = "<img src='".DOMAIN_END."image/main_new_bt.png' alt='new' />";
			}
	?>
		<div class="tabbtn">
			<a href="javascript:;" onClick="fnView('<?=$list['hero_idx'];?>')">
				<div class="title_left">
					<ul>
						<li class="tabbtn_title">
							<?if($list["hero_temp"]=="1"){?>[�ӽñ�]<?}?>
							<?=cut($list["hero_title"],32)?>
							<? if($list["reply_count"] > 0 ) {?>
		        				<font color='orange'>[<?=$list["reply_count"]?>]</font>
		        			<? } ?>
		        			<?=$new_img_view?>
						</li>
						<li class="tabbtn_top">
							<img src="<?=$level_icon?>" /><?=$list['hero_nick']?>
							<span class="date"><?=date( "Y.m.d", strtotime($list['hero_today']));?></span>
						</li>
					</ul>
				</div>
				<div class="title_right" style="float:right; margin-right:3%;">
					<img src="img/today/list_arrow1_190419.png" alt=""	width="24" />
				</div>
			</a>
		</div>
		<div class="tabcon tabcon_<?=$board_rs["hero_idx"]?> tabcon_hide"></div>
		<?
			}
		} else {
		?>
		<div class="tabbtn" style="text-align:center; padding:20px 0 0 0;">
			��ϵ� �����Ͱ� �����ϴ�.
		</div>
		<? } ?>
		<div id="page_number">
		<? include_once "page.php"?>
	    </div>
		<div class="img-loading"></div>
		<!--  (s)search box  -->
		<div id="searchBox">
		<form method="GET" id="frm">
		<input type="hidden" name="board" value="<?=$_GET["board"]?>">
		<input type="hidden" name="hero_idx" value="">
		<input type="hidden" name="page" value="">
			<select name="select">
				<option value="hero_title">����</option>
			</select>
			<input name="kewyword" type="text" value="<?=$_GET["kewyword"]?>" class="kewyword">
			<a href="javascript:$('#frm').submit();">�˻�</a>
		</form>
		</div>
		<!--  (e)search box -->
<? } ?>
	<!--������ ����-->
	<? include_once "btnTop.php";?>
	<? include_once "tail.php";?>
<script>
function fnView(hero_idx) {
	$("#frm input[name='hero_idx']").val(hero_idx);
	$("#frm").attr("action","globalNoticeView.php").submit();
}
</script>