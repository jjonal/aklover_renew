<?
include_once "head.php";

if(!defined('_HEROBOARD_'))exit;

if($_GET['board']=='group_04_20'){ //����� Ȯ�� ������ ��α��ν� �α��� �ʼ�
	if (!$_SESSION ['temp_level']){
		error_location("������ �����ϴ�.","/m/main.php?board=login");
		exit;
	}
}

$error = "TODAY_01";
$group_sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'"; // desc
$out_group = new_sql( $group_sql,$error );
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}

$right_list = mysql_fetch_assoc ( $out_group );

if(!$_GET["board"]) {
	error_historyBack("������ ������ �����ϴ�.","/m/main.php");
	exit;
}

if($right_list["hero_view"]>$_SESSION['temp_level'] && $right_list["hero_view"]!=0){
	if($_GET['board'] == "mail") {
		message("�α��� �� �̿��� �ּ���.");
		location("/m/main.php");
	} else {
		error_historyBack("������ ������ �����ϴ�.","/m/main.php");
	}
	exit;
}

if($_GET['type']=='recommand'){
	$recom_rs = recommand();
	if(substr($recom_rs,0,7)=='message'){
		$message = explode($recom_rs,":");
		location(del_get($_SERVER["HTTP_REFERER"],"idx")."&idx=".$_GET['idx']);
	}elseif($recom_rs!=1){
		error_historyBack("");
		exit;
	}elseif($recom_rs==1){
		message("��õ�Ͽ����ϴ�.");
		location(del_get($_SERVER["HTTP_REFERER"],"idx")."&idx=".$_GET['idx']);
	}
	exit;
}

if($_GET['type']=='report'){
	$report_rs = report();
	if(substr($report_rs,0,7)=='message'){
		$message = explode(":",$report_rs);
		message($message[1]);
		location(del_get($_SERVER["HTTP_REFERER"],"idx")."&idx=".$_GET['idx']);
	}elseif($report_rs!=1){
		error_historyBack("");
		exit;
	}elseif($report_rs==1){
		message("�Ű��Ͽ����ϴ�.");
		location(del_get($_SERVER["HTTP_REFERER"],"idx")."&idx=".$_GET['idx']);
	}
	exit;
}

if($_SESSION['temp_level']<9999)	$hero_use="and hero_use=1 "; ##�ӽñ� ���� ����

if($_GET['kewyword']){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}

$gubun = "";
if($_GET["board"] == "group_02_02") { //������ ���
	$gubun_arr = array("1"=>"�ϻ�","2"=>"ü���","3"=>"����");
} else if($_GET["board"] == "group_04_03") { //��������
    $gubun_arr = array("1"=>"�ʵ�","2"=>"�ȳ�","3"=>"�̺�Ʈ");
} else if($_GET["board"] == "group_04_24") { //�����
	$gubun_arr = array("1"=>"�ʵ�","2"=>"��α�","3"=>"�ν�Ÿ","4"=>"��Ʃ��&����");
	$hero_keywords_arr = array("1"=>"����","2"=>"Ȱ��","3"=>"���� TIP","4"=>"��ü TIP");
}

if($_GET['gubun']){
	$search .= " AND gubun = '".$_GET['gubun']."' ";
	$search_next .= "&gubun=".$_GET['gubun'];
}

$today = time(date('Y-m-d'));
$week = date("w");
$week_first = $today-($week*86400); 	//�̹� ���� ù���� �Ͽ���
$week_last = $week_first+(7*86400); 	//�̹� ���� ���������� �����

$week_first = date("Y-m-d",$week_first);
$week_last = date("Y-m-d",$week_last);

if($_GET['board']=='mail'){
	$member_sql = "SELECT hero_oldday FROM member WHERE hero_id ='".$_SESSION['temp_id']."'";
	$member_out_sql = mysql_query($member_sql);
	$member = @mysql_fetch_assoc($member_out_sql);
	$sql = 'select count(*) from mail where  ((hero_user=\'all\' and hero_today > \''.$member['hero_oldday'].'\') or CONCAT(\'||\', hero_user, \'||\') LIKE \'%||'.$_SESSION['temp_id'].'||%\') '.$search.'  order by hero_today desc;';
}else{
	$sql = 'select count(*) from board where hero_notice_use = 0 AND hero_table=\'' . $_REQUEST ['board'] . '\' '.$hero_use.$search.' order by hero_today desc';
}

$error = "TODAY_01";
$out_sql = new_sql( $sql, $error,"on" );

if((string)$out_sql==$error){
	error_historyBack("");
	exit;
}
$total_data = mysql_result ( $out_sql,0,0 );

$list_page = 10;
$page_per_list = 5;

if (! strcmp ( $_GET ['page'], '' )) $page = '1';
else 	$page = $_GET ['page'];

$start = ($page - 1) * $list_page;
$next_path = get ( "page||hero_i_count||idx" );

if($_GET["board"] == "group_02_02" || $_GET["board"] == "group_04_24") { //����/������, �����
	$sql_notice  = " SELECT hero_code, hero_idx, hero_title, gubun, hero_nick, hero_today, hero_03, hero_keywords FROM board ";
	$sql_notice .= " WHERE hero_notice_use = 1 AND hero_table='".$_GET['board']."' ".$hero_use." ORDER BY hero_idx DESC ";
	$sql_notice_res = mysql_query($sql_notice);
}
?>

<link href="css/musign/board.css" rel="stylesheet" type="text/css">
<link href="css/musign/cscenter.css" rel="stylesheet" type="text/css">
<? if($_GET["board"] == "group_04_03" ){ // �������� ?>
	<? include_once "cscenter.php"; ?>
<? } else if($_GET["board"] == "group_02_02"){ //lover_talk?>
	<? include_once "talk_top.php"; ?>
<? } ?>
<div class="btnTodayWrap today_list">
	<? if($_GET["board"] == "mail") {?>
		<div id="subpage" class="mypage mymail">
			<div class="my_top off">
				<div class="sub_title">
					<div class="sub_wrap">
						<div class="btn_back f_cs" onclick="goBack()"><img src="/m/img/musign/main/hd_back.webp" alt="�ڷ� ����"></div>
						<h1 class="fz36">���� �˸���</h1>
					</div>
				</div>
				<? include_once "mypage_top.php";?>
			</div>
		</div>
	<? } ?>
	<? include_once 'searchBox.php';?>
	<? if($_GET["board"] == "group_02_02"){ //������?>
	<div class="boardTabMenuWrap colorType">
		<a href="<?=DOMAIN_END?>m/today.php?board=<?=$_REQUEST['board']?>" <?if(!$_GET["gubun"]) {?>class="on"<?}?>>��ü</a>
		<a href="<?=DOMAIN_END?>m/today.php?board=<?=$_REQUEST['board']?>&gubun=3" <?if($_GET["gubun"] == "3") {?>class="on"<?}?>>����</a>
		<a href="<?=DOMAIN_END?>m/today.php?board=<?=$_REQUEST['board']?>&gubun=2" <?if($_GET["gubun"] == "2") {?>class="on"<?}?>>ü���</a>
		<a href="<?=DOMAIN_END?>m/today.php?board=<?=$_REQUEST['board']?>&gubun=1" <?if($_GET["gubun"] == "1") {?>class="on"<?}?>>�ϻ�</a>
	</div>
	<? } else if($_GET["board"] == "group_04_03"){ ?>
	<div class="boardTabMenuWrap colorType">
		<a href="<?=DOMAIN_END?>m/today.php?board=<?=$_REQUEST['board']?>" <?if(!$_GET["gubun"]) {?>class="on"<?}?>>��ü</a>
		<a href="<?=DOMAIN_END?>m/today.php?board=<?=$_REQUEST['board']?>&gubun=1" <?if($_GET["gubun"] == "1") {?>class="on"<?}?>>�ʵ�</a>
		<a href="<?=DOMAIN_END?>m/today.php?board=<?=$_REQUEST['board']?>&gubun=2" <?if($_GET["gubun"] == "2") {?>class="on"<?}?>>�ȳ�</a>
		<a href="<?=DOMAIN_END?>m/today.php?board=<?=$_REQUEST['board']?>&gubun=3" <?if($_GET["gubun"] == "3") {?>class="on"<?}?>>�̺�Ʈ</a>
	</div>
	<? } else if($_GET["board"] == "group_04_24"){ ?>
	<div class="boardTabMenuWrap colorType">
		<a href="<?=DOMAIN_END?>m/today.php?board=<?=$_REQUEST['board']?>" <?if(!$_GET["gubun"]) {?>class="on"<?}?>>��ü</a>
		<a href="<?=DOMAIN_END?>m/today.php?board=<?=$_REQUEST['board']?>&gubun=1" <?if($_GET["gubun"] == "1") {?>class="on"<?}?>>�ʵ�</a>
		<a href="<?=DOMAIN_END?>m/today.php?board=<?=$_REQUEST['board']?>&gubun=2" <?if($_GET["gubun"] == "2") {?>class="on"<?}?>>��α�</a>
		<a href="<?=DOMAIN_END?>m/today.php?board=<?=$_REQUEST['board']?>&gubun=3" <?if($_GET["gubun"] == "3") {?>class="on"<?}?>>�ν�Ÿ</a>
		<a href="<?=DOMAIN_END?>m/today.php?board=<?=$_REQUEST['board']?>&gubun=4" <?if($_GET["gubun"] == "4") {?>class="on"<?}?>>��Ʃ��&����</a>
	</div>
	<? } ?>
	<? if($_GET["board"] != "mail") {?>
		<span class="gallery_btn">
			<a href="<?=DOMAIN_END?>m/write.php?board=<?=$_REQUEST['board']?>&action=write" class="btn_write">�� �ۼ��ϱ�</a>
		</span>
	<? } ?>
</div>
<div class="clear"></div>
<div id="today_list">
<?if($_GET["board"] == "group_02_02" || $_GET["board"] == "group_04_24") { //��������  ������, �����
	while($hero_notice_list = mysql_fetch_assoc($sql_notice_res)){
	$sub_res = null;
		$error = "TODAY_NOTICE_04";
		$sub_sql = "select A.hero_nick, B.hero_img_new, C.count from member as A, level as B, (select count(*) as count from review where hero_old_idx='".$hero_notice_list['hero_idx']."') as C where B.hero_level = A.hero_level and A.hero_code = '".$hero_notice_list['hero_code']."'";

		$sub_res = new_sql($sub_sql,$error);
		if((string)$sub_res==$error){
			error_historyBack("");
			exit;
		}
		$data_sub_res = mysql_fetch_array($sub_res);
		$hero_nick = $data_sub_res["hero_nick"];
		$hero_img_new = $data_sub_res["hero_img_new"];
		$hero_rev_count = $data_sub_res["count"];

		$title = $hero_notice_list['hero_title'];
		$title = TRIM ( str_ireplace ( '&nbsp;', '', strip_tags ( htmlspecialchars_decode ( $title ) ) ) );
		$title = str_replace ( "\r", "", $title );
		$title = str_replace ( "\n", "", $title );
		$title_01 = str_replace ( "&#65279;", "", $title );

		if($title_01=='') $title_01 = "&nbsp;";

		if (date("Y-m-d")==substr($hero_notice_list['hero_today'],0,10)) 	$new_img_view = " <img src='" . DOMAIN_END . "image/main_new_bt.png' alt='new' />&nbsp;";
		else 														$new_img_view = "";

		if($hero_rev_count>0)										$rev_count = "<font color='orange'>&nbsp;[".$hero_rev_count."]</font>";
		else														$rev_count = "";

		if($hero_notice_list['hero_rec']>0 && $i<4 && (!$_GET['page'] || $_GET['page']==1) && $_REQUEST ['board']!="group_04_03")		$recommand_img = "<img src='/image/bbs/bbs_view_recom.gif' alt='��õ'>&nbsp;&nbsp;";
		else																			$recommand_img = '';

		if($hero_notice_list['hero_table']!="hero") {
		    $notice_icon = "";
		    $li_first = $hero_nick;
		} else {
		    $notice_icon = "<img src='../image/bbs/icon_notice.gif' alt='����' />&nbsp;";
		    $li_first = "";
		}
	?>
		<div class="tabbtn">
			<a href="javascript:;" onClick="fnView('<?=$hero_notice_list['hero_idx'];?>')">
				<div class="title_left">
					<ul>
						<li class="tabbtn_title">
							<span class="color_<?=$hero_notice_list['gubun'];?>"><?=$gubun_arr[$hero_notice_list['gubun']]?></span>
							<? if($_GET["board"] == "group_04_24" && $hero_notice_list['hero_keywords']) {?>
								<span class="txt_hero_keywords">[<?=$hero_keywords_arr[$hero_notice_list['hero_keywords']]?>]</span>
							<? } ?>
							<div class="fz26 fw500 ellipsis_100">
								<?=$title_01?>
								<?=$rev_count?>
							</div>
						</li>
						<li class="tabbtn_top f_cs op05">
							<?=$li_first?>
							<span class="date mu_bar"><?=date( "Y.m.d", strtotime($hero_notice_list['hero_today']));?></span>
						</li>
					</ul>
				</div>
			</a>
		</div>
		<div class='tabcon tabcon_<?=$hero_notice_list["hero_idx"]?> tabcon_hide'></div>
<? }
}?>
<?
	$error = "TODAY_03";
	$main_sql = "";
	if($_GET['board']=='mail'){
		$main_sql .= "select * from mail where ((hero_user='all' and hero_today > '".$member['hero_oldday']."') or CONCAT('||', hero_user, '||') LIKE '%||".$_SESSION['temp_id']."||%') ".$search." order by hero_today desc limit ".$start.",".$list_page;

	}else{
		if ($_REQUEST ['board']=="group_04_03" and ($_GET["page"]==1 or $_GET["page"]==0)) { //���������� ���
			$main_sql .= "SELECT A.* from (select * from board where hero_table='hero' and hero_order ='0' ".$hero_use." order by hero_today desc) A ";
			$main_sql .= "union ";
		}
		$main_sql .= " SELECT C.* from (SELECT * FROM board WHERE hero_notice_use = 0 AND hero_table='".$_GET['board']."' ".$hero_use." ".$search." order by hero_today desc limit ".$start.",".$list_page.") C ";
	}

	$out_main = new_sql($main_sql,$error );
	if((string)$out_main==$error){
		error_historyBack("");
		exit;
	}

	$i = 1;
	while($board_rs = mysql_fetch_assoc($out_main )){
		$sub_res = null;
		$error = "TODAY_04";
		$sub_sql = "select A.hero_nick, B.hero_img_new, C.count from member as A, level as B, (select count(*) as count from review where hero_old_idx='".$board_rs['hero_idx']."') as C where B.hero_level = A.hero_level and A.hero_code = '".$board_rs['hero_code']."'";

		$sub_res = new_sql($sub_sql,$error);
		if((string)$sub_res==$error){
			error_historyBack("");
			exit;
		}
		$data_sub_res = mysql_fetch_array($sub_res);
		$hero_nick = $data_sub_res["hero_nick"];
		$hero_img_new = $data_sub_res["hero_img_new"];
		$hero_rev_count = $data_sub_res["count"];

		$title = $board_rs ['hero_title'];
		$title = TRIM ( str_ireplace ( '&nbsp;', '', strip_tags ( htmlspecialchars_decode ( $title ) ) ) );
		$title = str_replace ( "\r", "", $title );
		$title = str_replace ( "\n", "", $title );
		$title_01 = str_replace ( "&#65279;", "", $title );

		if ($title_01=='') 											$title_01 = "&nbsp;";

		$fontColor = "";
		if($_GET['board']=='mail'){
			$open_check = true;
			$view_search_id = ",".$_SESSION['temp_id'].",";
			$view_user_check_id = str_replace("||",",",$board_rs['hero_user_check']);
			$view_user_check_id = ",".$view_user_check_id.",";

			if(strcmp(eregi($view_search_id,$view_user_check_id),'1')){
				$open_check = false;
				$new_img_view = "";
				$fontColor = "";
			}else{
				$new_img_view = "";
				$fontColor = "";
			}

			$icon_msg = "";
			if($board_rs["hero_user"] == "all") {
				if($open_check) {
					$icon_msg = "<img src='/m/img/icon_msg_group_open.jpg' />";
				} else {
					//��ü ������ ��� �� 7�� ���Ŀ��� �������� ó��.
					$today = date("Ymd");
					$mail_today = date("Ymd",strtotime("+7 days", strtotime(substr($board_rs["hero_today"],0,10))));
					if($mail_today <= $today) $open_check = true;

					if($open_check) {
						$icon_msg = "<img src='/m/img/icon_msg_group_open.jpg' />";
					} else {
						$icon_msg = "<img src='/m/img/icon_msg_group.jpg' />";
					}
				}
			} else {
				if($open_check) {
					$icon_msg = "<img src='/m/img/icon_msg_individual_open.jpg' />";
				} else {
					$icon_msg = "<img src='/m/img/icon_msg_individual.jpg' />";
				}
			}

		}else{
			if (date("Y-m-d")==substr($board_rs ['hero_today'],0,10)) 	$new_img_view = " <img src='" . DOMAIN_END . "image/main_new_bt.png' alt='new' />&nbsp;";
			else 														$new_img_view = "";

			if($hero_rev_count>0)										$rev_count = "<font color='orange'>&nbsp;[".$hero_rev_count."]</font>";
			else														$rev_count = "";

			if($board_rs['hero_rec']>0 && $i<4 && (!$_GET['page'] || $_GET['page']==1) && $_REQUEST ['board']!="group_04_03")		$recommand_img = "<img src='/image/bbs/bbs_view_recom.gif' alt='��õ'>&nbsp;&nbsp;";
			else																			$recommand_img = '';
		}

		if($board_rs['hero_table']!="hero")	{
		    $notice_icon = "";
		    $li_first = $hero_nick;
		} else {
		    $notice_icon = "<img src='../image/bbs/icon_notice.gif' alt='����' />&nbsp;";
		    $li_first = "";
		}
?>
	<div class="tabbtn">
		<a href="javascript:;" onClick="fnView('<?=$board_rs['hero_idx'];?>')">
			<div class="title_left">
				<ul>
					<li class="tabbtn_title rel">
						<? if($_GET['board']=='mail'){ ?>
							<div class="open_state">
								<? if($open_check){?>
									<span class="open"><img src="/img/front/mypage/confirm.png" alt="Ȯ��"></span>
								<? } else {?>
									<span class="noneOpen"><img src="/img/front/mypage/nonfirm.png" alt="��Ȯ��"></span>
								<? } ?>
							</div>
						<? } ?>
						<span class="color_<?=$board_rs['gubun'];?> <? if($_GET["board"] == "group_04_03") {?> on <? } ?>"><?=$gubun_arr[$board_rs['gubun']]?></span>
						<? if($_GET["board"] == "group_04_24" && $board_rs['hero_keywords']) {?>
							<span class="txt_hero_keywords">[<?=$hero_keywords_arr[$board_rs['hero_keywords']]?>]</span>
						<? } ?>
						<div class="fz26 fw500 ellipsis_100">
							<?=$title_01?>
							<?=$rev_count?>
						</div>
					</li>
					<li class="tabbtn_top f_cs op05">
						<?=$hero_nick?>
						<span class="date mu_bar fz24"><?=date( "Y.m.d", strtotime($board_rs['hero_today']));?></span>
					</li>
				</ul>
			</div>
		</a>
	</div>
	<div class='tabcon tabcon_<?=$board_rs["hero_idx"]?> tabcon_hide'></div>
	<?
		$i ++;
		}
	?>
	<div id="page_number" class="paging">
	<? include_once "page.php"?>
	<?
		$sql = 'select * from hero_group where hero_board = \'' . $_GET ['board'] . '\'';
		sql ( $sql, 'on' );
		$check_list = @mysql_fetch_assoc ( $out_sql );
		if ($check_list ['hero_write'] <= $_SESSION ['temp_write'] && $_REQUEST['board'] != "group_04_03" && $_REQUEST['board'] != "mail" ) {?>
		<?}?>
    </div>
	<script>
	function fnView(hero_idx) {
		$("#frm input[name='hero_idx']").val(hero_idx);
		$("#frm").attr("action","today_view.php").submit();
	}

	//pc URL ����� �ּ� ��������
	$(document).on('click', '.hero_command a', function(){
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
</div>
<? include_once "btnTop.php";?>
<? include_once "tail.php";?>