<?
include_once "head.php";

if(!defined('_HEROBOARD_'))exit;

$error = "TODAY_01";
$group_sql = "SELECT * FROM hero_group WHERE hero_order!='0' AND hero_use='1' AND hero_board ='".$_GET['board']."'"; // desc

$out_group = new_sql( $group_sql,$error );
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}

$right_list = mysql_fetch_assoc ($out_group);

if($_GET["board"] != "group_04_29") {
	error_historyBack("������ ������ �����ϴ�.","/m/main.php");
	exit;
}

//���ٱ��� 
$loyal_auth = false; //�ۼ�����
$loyal_auth_sql  = " SELECT COUNT(*) cnt FROM member_loyal ";
$loyal_auth_sql .= " WHERE hero_code = '".$_SESSION["temp_code"]."' AND date_format(CONCAT(gisu_year, gisu_month,'01'),'%Y%m%d') < '".date("Ym")."01"."' ";
$loyal_auth_sql .= " AND  date_format(date_add(date_format(CONCAT(gisu_year, gisu_month,'01'),'%Y%m%d'), INTERVAL 7 MONTH),'%Y%m%d') > '".date("Ym")."01"."' ";
$loyal_auth_res = sql($loyal_auth_sql);
$loyal_auth_rs = mysql_fetch_assoc($loyal_auth_res);

if($loyal_auth_rs["cnt"] > 0) $loyal_auth = true; //��� ���(�Ⱓ) 6�������� �Խ��� �̿� ����;

if($loyal_auth == 0 && $_SESSION['temp_level'] < 9999) {
	msg('�̴��� Loyal AKLOVER ������ �����ϴ�.','location.href="/m/loyalAkLover.php?board=group_04_29"');exit;
}


$level = $_SESSION['temp_level'];
$code = $_SESSION['temp_code'];

$my_write = $_SESSION ['temp_write'];
$my_view = $_SESSION ['temp_view'];
$my_update = $_SESSION ['temp_update'];
$my_rev = $_SESSION ['temp_rev'];

if($_SESSION['temp_level']<9999)	$hero_use="and b.hero_use=1 "; ##�ӽñ� ���� ����

$board_sql  = " SELECT b.hero_code,b.hero_idx, b.hero_notice_use, b.hero_title, b.gubun, b.hero_command, b.hero_today, b.hero_keywords , m.hero_nick , m.hero_idx as member_idx, l.hero_img_new FROM board b ";
$board_sql .= " LEFT JOIN member m ON b.hero_code = m.hero_code ";
$board_sql .= " LEFT JOIN level l ON m.hero_level = l.hero_level ";
$board_sql .= " WHERE 1=1 ".$hero_use." AND b.hero_idx = '".$_GET["hero_idx"]."' AND (b.hero_table = '".$_GET["board"]."' OR b.hero_table = 'hero') ";

$out_sql = new_sql($board_sql, $error, "on");
$view = mysql_fetch_assoc($out_sql);

$next_command = htmlspecialchars_decode ($view['hero_command'] );
$next_command = str_ireplace ( "<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n", "", $next_command );
$next_command = str_ireplace ( "<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n", "", $next_command );
$next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $next_command );
$next_command = preg_replace ( "/ height=(\"|\')?\d+(\"|\')?/", "", $next_command );
$next_command = preg_replace ( "/height: \d+px;/", "", $next_command );
$next_command = preg_replace ( "/height: \d+px/", "", $next_command );

?>
<link href="css/today.css??version=<?=date("YmdHis")?>" rel="stylesheet" type="text/css">
<? include_once "boardIntroduce.php"; ?>
<div class="clear"></div>
<form name="searchForm" id="searchForm" method="GET">
<? foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
<input type="hidden" name="idx" value="<?=$view["hero_idx"]?>" />
</form>
<div class="viewWrap">
	<div class="titleBox">
		<p>
			<? if($view["hero_notice_use"] == "1") {?>[����]<? } ?>
			<span class="color_<?=$view['gubun'];?>"><?=$gubun_arr[$view['gubun']]?></span>
			<? if($_GET["board"] == "group_04_24" && $view['hero_keywords']) {?>
			<span class="txt_hero_keywords">[<?=$hero_keywords_arr[$view['hero_keywords']]?>]</span>
			<? } ?>
			<?=$new_img_view?><?=cut($view['hero_title'],48);?>
		</p>
		<p class="txt_nick"><img src="<?=str($view['hero_img_new'])?>"/><a href="javascript:;" onClick="fnProfile('<?=encrypt($view['member_idx']);?>')"><?=$view['hero_nick'];?></a> 
		   <span><?=date( "Y.m.d", strtotime($view['hero_today']));?></span>
		</p>
	</div>
	<div class="contBox"><?=$next_command;?></div>
	<div class="btnGroup mgt20 mgb20">
		<div class="left">
			<a href="<?=DOMAIN_END."m/loyalAkLover.php?".get("hero_idx")?>"><img src="img/review/list_btn.jpg" /></a>
		</div>
		
		<? if($view['hero_code'] == $_SESSION['temp_code']){?>
		<div class="right">
			<a href="javascript:;" onClick="fnEdit()"><img src="img/review/modify_btn.jpg" /></a>
			<a href="/m/action.php?board=<?=$_GET['board']?>&action=delete&idx=<?=$_GET['hero_idx']?>"><img src="img/review/delete_btn.jpg" /></a>
		</div>
		<? } ?>
	</div>
</div>

<? if($_GET["board"] != "mail") { ?>
	<div id="reply" style="margin-bottom:20px;">
		<ul style="width:100%">
			<?
			if($my_rev>='9999' or $right_list['hero_rev']<=$my_rev){
			?>
	       		<li style="width:70%; float:left">
	       			<form id="review_form">
					   	<input type="hidden" name="mode" value="review_write"> 
					   	<input type="hidden" name="board" value="<?=$_GET['board']?>">
					   	<input type="hidden" name="board_idx" value="<?=$view['hero_idx']?>">
					   	<? if($my_rev == "9999") {?>
					    <p><lebal for='hero_topFix'>��� ����</label> <input type='checkbox' name='hero_topFix' id='hero_topFix' checked value='Y' /></p>
					    <? } ?>
					</form>
	       			<textarea id="hero_command" name="hero_command" onpaste="return false" cols="" rows="" class="reply_box"></textarea>
	       		</li>
	       		<li style="text-align:right;<?=$my_rev=='9999' ? 'padding-top:30px':'';?>">
	       			<input type="button" value="��� �Է�" class='btn-warning today_btn' style='height:70px;width: 26%;' onClick="hero_review_submit('review_form', 'hero_command', 'pc');" alt="����Է�">
	       		</li>
			<?
			}
			?>
	    </ul>
	    <div class="clear"></div> 
	</div>

	<?
	$review_sql  = " select * from (select A.hero_code, A.hero_depth, A.hero_idx, A.hero_use, A.hero_today, A.hero_command,A.hero_depth_idx_old ";
	$review_sql .= " ,(select case when ifnull(hero_topfix,'N') != 'Y' then 'N' else 'Y' end hero_topfix FROM review where hero_idx = A.hero_depth_idx_old) as hero_topfix";
	$review_sql .= " ,B.hero_level,B.hero_nick,C.hero_img_new from review as A ";
	$review_sql .= " left outer join member as B on A.hero_code=B.hero_code ";
	$review_sql .= " left outer join level as C on B.hero_level=C.hero_level ";
	$review_sql .= " where hero_old_idx='".$view['hero_idx']."' ) A  ";
	$review_sql .= " order by hero_topfix desc ";
	$review_sql .= " ,case when hero_topfix = 'Y' then hero_depth_idx_old end desc ";
	$review_sql .= " ,case when hero_topfix != 'Y' then hero_depth_idx_old end asc ";
	$review_sql .= " ,hero_depth asc,hero_today asc ";
	
	//echo $review_sql;
	
	
	$review_res = new_sql($review_sql, $error);
	if ((string)$review_res==$error){
		echo 0;
		exit;
	}
	
	$review_data = mysql_num_rows ( $review_res );
	$review_i = $review_data-1;
	
	while($review_row                             = @mysql_fetch_assoc($review_res)){
	    
		if(!strcmp($review_i, '0'))      $last_class = ' last';
	    else						     $last_class = '';
	    
	?>
	
		<div class="reply_view">
			<?
				if(strcmp($review_row['hero_use'], '1')){
			?>
				<div>
					<div class="nickname">
				    	<?if($review_row['hero_depth']>=1){?>
			        			<img src="img/review/reply_arrow.png" alt="" style="width:10px;"/>
				        <?}?>
			        	<img src="<?=str($review_row['hero_img_new'])?>"/>
				        <?=mb_substr($review_row['hero_nick'],0,5,"EUC-KR")?>
				        <span><?=date( "m-d", strtotime($review_row['hero_today']));?></span>
				   	</div>
					
					<div class="command"><?=htmlspecialchars($review_row['hero_command'],ENT_COMPAT,"ISO-8859-1")?></div>
				</div>
					<div class="button_area">
						<?if($level){?>
					        <input type='button' value="���" onclick="reply_area(<?=$view['hero_idx']?>,'review_write',<?=$review_row['hero_idx']?>,<?=$review_row['hero_depth_idx_old']?>,this);" class="btn-secondary today_btn"/>
					   	<?}
					   	if( $my_rev>=9999 or $review_row['hero_code']==$_SESSION['temp_code']){?>
		       				<input type='button' value="����" onclick="reply_area(<?=$view['hero_idx']?>,'review_edit',<?=$review_row['hero_idx']?>,<?=$review_row['hero_depth_idx_old']?>,this);" class="btn-info today_btn"/>
		       				<input type='button' value="����" onclick="check_review_del(<?=$review_row['hero_idx']?>)" class="btn-danger today_btn"/>
			        	<?}?>
					</div>
			<?}else{?>
					<div class="nickname" style="width:100%;text-align:center">������ �� �Դϴ�.</div>
			<?}?>
	
				<div class="reply_area_top">
	        	</div>
	        	
	        <div class="clear"></div> 
		</div>
	<? } ?>
<? } ?>
<div class="clear"></div>
<script>

function fnEdit(){
	$("#searchForm").attr("action","write.php").submit();	
}

function reply_area(board_idx,mode,depth_idx,depth_idx_old,obj){

	cancle_reply();

	var reply_area_top = $(obj).parent('.button_area').siblings('.reply_area_top');
	var command = '';
	if(mode=="review_edit"){
		command = trim($(obj).parent('.button_area').parent('.reply_view').find('.command').html());
	}

	console.log(command);
	
	var reply_view ='';
		
	reply_view += "<div>";
	reply_view += "<ul>";
	reply_view += "<li style='width:70%;float:left;'>";
	reply_view += "<form id='review_form_02'>";
	reply_view += "<input type='hidden' name='mode' value='"+mode+"'>";
	reply_view += "<input type='hidden' name='board' value='<?=$_GET['board']?>'>";
	reply_view += "<input type='hidden' name='board_idx' value='"+board_idx+"'>";
	reply_view += "<input type='hidden' name='depth_idx' value='"+depth_idx+"'>";
	reply_view += "<input type='hidden' name='depth_idx_old' value='"+depth_idx_old+"'>";
	reply_view += "<textarea id='hero_command_02' onpaste='return false;' class='reply_box'>"+command+"</textarea>";
	reply_view += "</form>";
	reply_view += "</li>";
	reply_view += "<li style='text-align:right;'>";
	reply_view += "<input type='button' value='�Է�' class='btn-warning today_btn' style='height:70px; margin-right:10px;' onclick='hero_review_submit(\"review_form_02\", \"hero_command_02\",\"pc\")' alt='��� �Է�'>";
	reply_view += "<input type='button' value='���' class='btn-danger today_btn' style='height:70px;' onclick='cancle_reply();' alt='���'>";
	reply_view += "</li>";
	reply_view += "</ul>";
	reply_view += "<div class='clear'></div>";
	reply_view += "</div>";

	reply_area_top.html(reply_view);
	reply_area_top.slideDown("slow");
}

function cancle_reply(){
	$('.reply_area_top').slideUp('slow');
	$('.reply_area_top').html('');
}

function check_review_del(idx){
	if(confirm("�����Ͻðڽ��ϱ�?")==true)	hero_review_del(idx,"pc");		
	else								return false;
}

//170715 �ӽø�ũ
function temp_link(n) {
	console.log(n);
	var url = "";
	if(n == "1") {
		url = "/m/aklover.php?board=group_04_01";
	} else if(n == "2") {
		url = "/m/aklover.php?board=group_04_12";
	} else if(n == "3"){
		url = "/m/aklover.php?board=group_04_02";
	}
	
	window.open(url,'','');
}

//pc URL ����� �ּ� ��������
$(document).on('click', '.contBox a', function(){
	event.preventDefault();
	var url = $(this).attr("href");
	var target = $(this).attr("target");
	var host = "<?=$_SERVER["HTTP_HOST"];?>";
	var http = "<?=$_SERVER["HTTPS"];?>";
	var domain  = "";
	var board = param("board",url);
	var view = param("view",url);
	var idx = param("idx",url);

	if(http == "on") {
		domain = "https://"+host+"/";
	} else {
		domain = "http://"+host+"/";
	}

	if(url.indexOf("http:") > -1 || url.indexOf("https:") > -1) {
		if(url.indexOf("http://www.aklover.co.kr") < 0 && url.indexOf("https://www.aklover.co.kr") < 0 
				&& url.indexOf("http://aklover.co.kr") < 0 
				&& url.indexOf("https://aklover.co.kr") < 0) {

			if(target) {
				if(target.toLowerCase() == "_blank") {
					window.open(url,'','');
				} else {
					location.href = url;
				}
			} else {
				location.href = url;
			}

			return;
		}
	}
	
	var link = "";
	if(board == "group_04_03" || board == "group_02_02" || board == "group_03_03" || board == "group_04_24" || board == "group_04_26") { //������(��������, ������, ������, �����)
		if(idx) {
				link = "m/today.php?board="+board+"&idx="+idx+"#tabbtn_"+idx;	
		} else {
			link = "m/today.php?board="+board;
		}
	} else if(board == "group_04_04") { //������(�⼮üũ)
		link = "m/check.php?board="+board;
	} else if(board == "group_04_05" || board == "group_04_06" || board == "group_04_25" || board == "group_04_23" || board == "group_04_08" || board == "group_04_27" || board == "group_04_28") { //�ε帮��(ü���, ��Ƽ��Ÿ, ��ƼȦ��, �ֽ�Ŭ��, ���ڴ�)
		if(idx) {
				link = "m/mission_view.php?board="+board+"&mission_idx="+idx;
		} else {
			link = "m/mission.php?board="+board;
		}
	} else if(board == "group_04_07") { //�ε帮��(�ְ�ڽ�)
		if(idx) {
				link = "m/mission_view_02.php?board="+board+"&mission_idx="+idx;
		} else {
			link = "m/mission.php?board="+board;
		}
	} else if(board == "group_02_03") { //�ε帮��(�Ը��� �̺�Ʈ)
		if(idx) {
				link = "m/board_view_01.php?board="+board+"&hero_idx="+idx;
		} else {
			link = "m/board_00.php?board="+board;
		}
	} else if(board == "group_04_21") { //�ε帮��(����Ʈ ����) �ϴ� ����Ʈ ��������
		link = "m/order.php?board="+board;
	} else if(board == "group_04_09") { //�����(ü���ı�)
		if(idx) {
				link = "m/board_view_01.php?board="+board+"&hero_idx="+idx;
		} else {
			link = "m/board_01.php?board="+board;
		}
	} else if(board == "group_04_10") { //�����(����ı�) ����Ʈ�� ����
		link = "m/board_02.php?board="+board;
	} else if(board == "group_04_22") { //�����(�����ı�)
		if(idx) {
				link = "m/meeting_view.php?board="+board+"&idx="+idx;
		} else {
			link = "m/meeting.php?board="+board;
		}
	} else if(board == "group_04_01" || board == "group_04_12" || board == "group_04_02" || board == "group_03_01") { //������(aklover��, ü��� �������, ����Ʈ/���, �ְ�Ұ�)
		link = "m/aklover.php?board="+board;
	} else if(board == "group_04_13") { //������(������)
		link = "m/truly.php?board="+board;
	} else if(board == "cus_3") { //������(������)
		link = "m/customer.php?board="+board;
	} else {
		link = url;
	}

	var editUrl = domain+link;
	
	if(target) {
		if(target.toLowerCase() == "_blank") {
			window.open(editUrl,'','');
		} else {
			location.href = editUrl;
		}
	} else {
		location.href = editUrl;
	}
});

param = function(name,url) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(url);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
</script>
<div class="img-loading"></div>
<!--������ ����-->
<? include_once "btnTop.php";?>
<? include_once "tail.php";?>