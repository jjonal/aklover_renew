<?
if(!defined('_HEROBOARD_'))exit;

if(is_numeric($_GET['idx']))	$idx = $_GET['idx'];
else							echo "<script>alert('�߸��� �����Դϴ�');location.href='/main/index.php'</script>";

$today = date( "Y-m-d", time());
if(strcmp($_SESSION['temp_drop'], '')){ //���� üũ
	$temp_drop = $_SESSION['temp_drop'];
	if($temp_drop<=$today){
		$sql = 'UPDATE member SET hero_dropday=null, hero_level=\''.$_SESSION['temp_level'].'\', hero_write=\''.$_SESSION['temp_level'].'\', hero_view=\''.$_SESSION['temp_level'].'\', hero_update=\''.$_SESSION['temp_level'].'\', hero_rev=\''.$_SESSION['temp_level'].'\' WHERE hero_code = \''.$_SESSION['temp_code'].'\';'.PHP_EOL;
		@sql($sql, 'on');
		$_SESSION['temp_write']=$_SESSION['temp_level'];
		$_SESSION['temp_view']=$_SESSION['temp_level'];
		$_SESSION['temp_update']=$_SESSION['temp_level'];
		$_SESSION['temp_rev']=$_SESSION['temp_level'];
		unset($_SESSION['temp_drop']);
	}
}

if(!strcmp($_SESSION['temp_level'], '')){ //��α��ν�
    $_SESSION['temp_level'] = '0';
    $_SESSION['temp_write'] = '0';
    $_SESSION['temp_view'] = '0';
    $_SESSION['temp_update'] = '0';
    $_SESSION['temp_rev'] = '0';
}

//��õ ����
$recom_report_sql = "select * from (select count(*) as recom_count from hero_recommand where hero_recommand_code = '".$_SESSION['temp_code']."' and hero_board_idx = '".$idx."') as A, (select count(*) as report_count from hero_report where hero_report_code = '".$_SESSION['temp_code']."' and hero_board_idx = '".$idx."') as B ";
$recom_report_res = mysql_query($recom_report_sql) or die("<script>alert('�ý��� ������ ��õ�� �����Ͽ����ϴ�. �ٽ� �õ��� �ּ���. �����ڵ� : RECOMMAND_REPORT_01');location.href='/main/index.php'</script>");
$recom_report_rs = mysql_fetch_assoc($recom_report_res);
$recommand_count = $recom_report_rs['recom_count'];
$report_count = $recom_report_rs['report_count'];

if(!strcmp($_GET['type'], 'recommand') && !strcmp($recommand_count, '0')){
	$board_recom_sql = "select hero_code, hero_rec from board where hero_idx = '".$idx."'";
	$board_recom_res = mysql_query($board_recom_sql) or die("<script>alert('�ý��� ������ ��õ�� �����Ͽ����ϴ�. �ٽ� �õ��� �ּ���. �����ڵ� : RECOMMAND_01');location.href='/main/index.php'</script>");
	$board_recom_rs = mysql_fetch_assoc($board_recom_res);

	$member_sql = 'select * from member where hero_code = \''.$board_recom_rs['hero_code'].'\';';
	$out_member_sql = mysql_query($member_sql) or die("<script>alert('�ý��� ������ ��õ�� �����Ͽ����ϴ�. �ٽ� �õ��� �ּ���. �����ڵ� : RECOMMAND_02');location.href='/main/index.php'</script>");
	$member_list = mysql_fetch_assoc($out_member_sql);//mysql_fetch_row

	if(strcmp($_SESSION['temp_code'], '')){

		$hero_url_value = str_ireplace('&type=recommand', '', DOMAIN.URI);

		$sql_one_write = "hero_url, hero_board, hero_board_idx, hero_board_code, hero_board_id, hero_board_nick, hero_board_name, hero_recommand_code, hero_recommand_id, hero_recommand_nick, hero_recommand_name, hero_today";
		$sql_two_write = "'".$hero_url_value."', '".$_REQUEST['board']."', '".$_REQUEST['idx']."', '".$member_list['hero_code']."', '".$member_list['hero_id']."', '".$member_list['hero_nick']."', '".$member_list['hero_name']."', '".$_SESSION['temp_code']."', '".$_SESSION['temp_id']."', '".$_SESSION['temp_nick']."', '".$_SESSION['temp_name']."', '".Ymdhis.'\'';
		$hero_recommand_sql = "INSERT INTO hero_recommand (".$sql_one_write.") VALUES (".$sql_two_write.")";

		$pf = mysql_query($hero_recommand_sql);
		if(!$pf) echo "<script>alert('�ý��� ������ ��õ�� �����Ͽ����ϴ�. �ٽ� �õ��� �ּ���. �����ڵ� : RECOMMAND_03');location.href='/main/index.php'</script>";

		$temp_rec = $board_recom_rs['hero_rec']+1;
		$up_member_sql = 'UPDATE board SET hero_rec=\''.$temp_rec.'\' WHERE hero_idx = \''.$_REQUEST['idx'].'\';';
		$pf = mysql_query($up_member_sql);
		if(!$pf) {

			$fail_select = "select hero_idx from hero_recommand where hero_board_idx='".$_REQUEST['idx']."' and hero_recommand_code = '".$_SESSION['temp_code']."'";
			$fail_res = @mysql_query($fail_select);
			$fail_rs = @mysql_fetch_assoc($fail_res);

			$fail_delete = "delete from hero_recommand where hero_idx='".$fail_rs['hero_idx']."'";
			@mysql_query($fail_delete);

			echo "<script>alert('�ý��� ������ ��õ�� �����Ͽ����ϴ�. �ٽ� �õ��� �ּ���. �����ڵ� : RECOMMAND_04');location.href='/main/index.php'</script>";
		}

		$msg = '��õ �Ͽ����ϴ�.';
		$get_herf = get('type','');
		$action_href = PATH_HOME.'?'.$get_herf;
		msg($msg,'location.href="'.$action_href.'"');
		exit;
	}else{
		echo "<script>alert('�α����� ���� �ʾҽ��ϴ�. �α��� �� �ٽ� �õ��� �ּ���.');location.href='/main/index.php?board=login'</script>";
	}
}

if(!strcmp($_GET['type'], 'report') && !strcmp($report_count, '0')){ //�Ű� ����
	$board_recom_sql = "select hero_code, hero_rec from board where hero_idx = '".$idx."'";
	$board_recom_res = mysql_query($board_recom_sql) or die("<script>alert('�ý��� ������ �Ű� �����Ͽ����ϴ�. �ٽ� �õ��� �ּ���. �����ڵ� : REPORT_01');location.href='/main/index.php'</script>");
	$board_recom_rs = mysql_fetch_assoc($board_recom_res);

	$member_sql = "select * from member where hero_code = '".$board_recom_rs['hero_code']."'";
	$out_member_sql = mysql_query($member_sql) or die("<script>alert('�ý��� ������ ��õ�� �����Ͽ����ϴ�. �ٽ� �õ��� �ּ���. �����ڵ� : REPORT_02');location.href='/main/index.php'</script>");
	$member_list = mysql_fetch_assoc($out_member_sql);//mysql_fetch_row

	if(strcmp($_SESSION['temp_code'], '')){
		$hero_url_value = str_ireplace('&type=report', '', DOMAIN.URI);
		$sql_one_write = 'hero_url, hero_board, hero_board_idx, hero_board_code, hero_board_id, hero_board_nick, hero_board_name, hero_report_code, hero_report_id, hero_report_nick, hero_report_name, hero_today';
		$sql_two_write = '\''.$hero_url_value.'\', \''.$_REQUEST['board'].'\', \''.$_REQUEST['idx'].'\', \''.$member_list['hero_code'].'\', \''.$member_list['hero_id'].'\', \''.$member_list['hero_nick'].'\', \''.$member_list['hero_name'].'\', \''.$_SESSION['temp_code'].'\', \''.$_SESSION['temp_id'].'\', \''.$_SESSION['temp_nick'].'\', \''.$_SESSION['temp_name'].'\', \''.Ymdhis.'\'';
		$hero_report_sql = 'INSERT INTO hero_report ('.$sql_one_write.') VALUES ('.$sql_two_write.');';
		@mysql_query($hero_report_sql);
	}

	$msg = '�Ű� �Ͽ����ϴ�.';
	$get_herf = get('type','');
	$action_href = PATH_HOME.'?'.$get_herf;
	msg($msg,'location.href="'.$action_href.'"');
	exit;
}

$board_sql = "select A.*, B.hero_view as group_view, B.hero_title as group_title, B.hero_view_point as group_view_point, B.hero_right as group_right, B.hero_top_title as group_top_title ";
$board_sql .= "from board A, hero_group B where A.hero_idx = '".$_REQUEST['idx']."' and B.hero_board='".$_GET['board']."'";

$sql_res = mysql_query($board_sql) or die("<script>alert('�ý��� �����Դϴ�. �ٽ� �õ��� �ּ���. �����ڵ� : VIEW_01');location.href='/main/index.php'</script>");
$board_list = mysql_fetch_assoc($sql_res);

//if($_COOKIE["cookie_hero_hit"] != "hit_".$_REQUEST['idx'] && $_GET['board'] == "group_04_03") { //2020-11-10 ��ȸ�� �߰�
if($_COOKIE["cookie_hero_hit"] != "hit_".$_REQUEST['idx']) { // 2023-08-25 ��� �Խù��� ��ȸ�� �߰�
	$board_hit_sql = " UPDATE board SET hero_hit = hero_hit+1 WHERE hero_idx = '".$_REQUEST['idx']."' ";
	mysql_query($board_hit_sql);

	setcookie("cookie_hero_hit", "hit_".$_REQUEST['idx'], time() + 86400, "/");
}

if(!strcmp($board_list['hero_table'],'hero'))    	$group_table_name = $board_list['hero_03'];
else    											        $group_table_name = $board_list['hero_table'];

if($board_list['group_view'] > $_SESSION['temp_view']){ //����
	if(!strcmp($_SESSION['temp_level'], '0'))		$action_href = PATH_HOME.'?board=login';
	else											        $action_href = PATH_HOME.'?'.get('view');

	msg('������ �����ϴ�.','location.href="'.$action_href.'"');
	exit;
}

if($_SESSION['temp_level'] < 9999 && $board_list["hero_use"] == "0") {
	msg('����� �Խñ� �Դϴ�.','location.href="/main/index.php?board=group_02_03"');
	exit;
}

$pk_sql = "select A.hero_level, A.hero_nick, A.hero_idx, B.hero_img_new, A.hero_profile from member as A, level as B where B.hero_level = A.hero_level and A.hero_code = '".$board_list['hero_code']."'";
$out_pk_sql = mysql_query($pk_sql) or die("<script>alert('�ý��� �����Դϴ�. �ٽ� �õ����ּ���. �����ڵ� : VIEW_02');location.href='/main/index.php'</script>");

$pk_row                             = mysql_fetch_assoc($out_pk_sql);

if(empty($pk_row['hero_profile'])){
    $hero_profile = "/img/front/mypage/defalt.webp";
}else {
    $hero_profile = $pk_row['hero_profile'];
}

$point_total_point = $pk_row['hero_point'];				//���� ȹ�� ������ ����Ʈ
$today_user_total = $pk_row['today_user_total'];		//���� ȹ�� ����Ʈ
$board_user_count = $pk_row['point_count'];				//�ش� ���������� ���� ���� ����Ʈ
$group_view_point = $board_list['group_view_point'];	//�б� ����Ʈ

if(strcmp($board_list['hero_table'],'hero')){ //�������� �������� ������ ��� view ������
    if(!strcmp($_REQUEST['board'],"group_04_09")){ //ü���ı�
        $sql = "select A.hero_idx as prev_idx, A.hero_title as prev_title, B.hero_idx as next_idx, B.hero_title as next_title from (select hero_idx, hero_title from board where hero_table in ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08', 'group_04_09' , 'group_04_27' , 'group_04_28') and hero_idx > '".$idx."' order by hero_idx asc limit 0,1) A right outer join ";
        $sql .= "(select hero_idx, hero_title from board where hero_table in ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08', 'group_04_09' , 'group_04_27' , 'group_04_28') and hero_idx < '".$idx."' order by hero_idx desc limit 0,1) B on 1=1";

        $out_sql 	=	 @mysql_query($sql);
        $prevNext	=	 @mysql_fetch_assoc($out_sql);
    }else if(!strcmp($_REQUEST['board'],"group_04_10")){ //����ı�
        $sql = "select A.hero_idx as prev_idx, A.hero_title as prev_title, B.hero_idx as next_idx, B.hero_title as next_title from (select hero_idx, hero_title from board where hero_table in ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08', 'group_04_09' , 'group_04_27' , 'group_04_28') and hero_board_three='1' or  hero_table='group_04_10' and hero_idx > '".$idx."' order by hero_idx asc limit 0,1) A right outer join ";
        $sql .= "(select hero_idx, hero_title from board where hero_table in ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08', 'group_04_09', 'group_04_27' , 'group_04_28') and hero_board_three='1' or  hero_table='group_04_10' and hero_idx < '".$idx."' order by hero_idx desc limit 0,1) B on 1=1";

        $out_sql 	=	 @mysql_query($sql);
        $prevNext	=	 @mysql_fetch_assoc($out_sql);
    }else{
    	if($board_list['hero_notice_use'] != "1") {

    		if($_SESSION['temp_level']<9999)	$hero_use = " AND hero_use=1 "; ##�ӽñ� ���� ����

    		$prev_sql = " SELECT  hero_idx, hero_title FROM board where hero_table = '".$group_table_name."' and hero_idx > '".$idx."' AND hero_notice_use != '1' ".$hero_use." ORDER BY hero_idx ASC limit 0,1 ";

    		$prev_res = sql($prev_sql);
    		$prev_rs = mysql_fetch_assoc($prev_res);

    		$next_sql = " SELECT  hero_idx, hero_title FROM board where hero_table = '".$group_table_name."' and hero_idx < '".$idx."' AND hero_notice_use != '1' ".$hero_use." ORDER BY hero_idx DESC limit 0,1 ";

    		$next_res = sql($next_sql);
    		$next_rs = mysql_fetch_assoc($next_res);

    	}

   		$prevNext["prev_idx"] = $prev_rs["hero_idx"];
   		$prevNext["prev_title"] = $prev_rs["hero_title"];

   		$prevNext["next_idx"] = $next_rs["hero_idx"];
   		$prevNext["next_title"] = $next_rs["hero_title"];
    }


}

if($_GET['board'] == "group_02_02") { //������ ���
	$gubun_arr = array("1"=>"�ϻ�","2"=>"ü���","3"=>"����");
} else if($_GET['board'] == "group_04_03") { //��������
    $gubun_arr = array("1"=>"�ʵ�","2"=>"�ȳ�","3"=>"�̺�Ʈ");
} else if($_GET['board'] == "group_04_24") { // �����
	$gubun_arr = array("1"=>"�ʵ�","2"=>"��α�","3"=>"�ν�Ÿ","4"=>"��Ʃ��&����");
	$hero_keywords_arr = array("1"=>"����","2"=>"Ȱ��","3"=>"���� TIP","4"=>"��ü TIP");
}
?>

<script src="https://t1.kakaocdn.net/kakao_js_sdk/2.7.2/kakao.min.js" integrity="sha384-TiCUE00h649CAMonG018J2ujOgDKW/kVWlChEuu4jK2vxfAAD0eZxzCKakxg55G4" crossorigin="anonymous"></script>
<script>
		// īī�� aklover JavaScript Ű
	Kakao.init('86b5b004678408418bea38987129ee5a');
</script>
<script>
$(document).ready(function(){
	$(".regist").cluetip({width:'450px',activation: 'click',dropShadow: false, sticky: true, ajaxCache: false, arrows: true, closePosition: 'title', arrows: true,closeText: '<span id="close_info">X</span>'});
});

function confirm_writing(type, location){
	if(type=='report') {
		if(confirm("�Ű� �Ͻðڽ��ϱ�?") == true){//Ȯ��
			document.location.href=location;
		}
	}else{
		document.location.href=location;
	}
}

function pop_3_5() {
	var popup_3_5 = window.open('/popup/term3_5.html','popup_3_5','width=550, height=400');
		popup_3_5.focus();
}

function pop_3_4() {
	var popup_3_4 = window.open('/popup/term3_4.html','popup_3_4','width=550, height=400');
		popup_3_4.focus();
}
</script>
	<script type="text/javascript" src="/js/musign/sns_share.js" ></script>
	<div id="subpage">
		<div class="sub_title">
            <div class="sub_wrap">
				<? if($_GET['board']=="group_02_03"){?>
					<div class="f_b">
						<div>
							<h1 class="fz68 main_c fw500 ko">�̴��� �̺�Ʈ</h1>
							<p class="fz18 fw600">������ ���� ������ �̺�Ʈ�� �����غ�����!</p>
						</div>
					</div>
				<?
				}else if ($_GET['board']=="group_02_02"){
				?>
					<div class="f_b">
						<h1 class="fz86 main_c en">Lover <span class="fz68 fw500">��</span></h1>
					</div>
					<p class="fz18 fw600">AK Lover�� �ϻ��� �����غ�����!</p>
				<?
				}else if ($_GET['board']=="group_04_03"){
				?>
					<div class="f_b">
						<h1 class="fz68 fw600 main_c">������</h1>
					</div>
				<? } ?>
            </div>
        </div>
		<div class="sub_cont">
            <div class="sub_wrap board_wrap f_sb <?=$group_table_name;?>">
				<!-- <div class="left view_list"> -->
                <div class="left view_list">
					<div class="<?php if($_GET ['board'] === 'group_02_02'){?>fixed_item<? } ?>">
						<a class="btn_list f_cs" href="<?=MAIN_HOME;?>?board=<?=$group_table_name;?>&page=<?=$_GET['page'];?>&gubun=<?=$_GET['gubun'];?>" class="a_btn2">
							<img src="/img/front/board/list_back.webp" alt="back">
							<span class="fz19 fw700">�������</span>
						</a>
						<ul>
							<? if(strcmp ($prevNext ['prev_idx'],'')) { ?>
							<li>
								<a href="<?=PATH_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>&view=view&idx=<?=$prevNext['prev_idx'];?>">
									<p class="tit fz13 fw600 op05">������</p>
									<p  class="fz15 fw600 ellipsis_500"><?=cut($prevNext['prev_title'],26);?></p>
								</a>
							</li>
							<?}?>
							<li class="current">
								<p class="tit fz13 fw600 main_c">�����</p>
								<p class="fz15 fw600 ellipsis_500"><?=cut($board_list['hero_title'],48);?></p>
							</li>
							<?if(strcmp ($prevNext ['next_idx'],'')) {?>
							<li class="next">
								<a href="<?=PATH_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>&view=view&idx=<?=$prevNext['next_idx'];?>">
								<p class="tit fz13 fw600 op05">������</p>
								<p class="fz15 fw600 ellipsis_500"><?=cut($prevNext['next_title'],26);?></p>
								</a>
							</li>
							<?}?>
						</ul>
					</div>
                </div>
				<div class="contents right view_cont">
					<div class="title rel">
						<? if($board == "group_04_24" && $board_list['hero_keywords']){?>
							<span class="txt_hero_keywords">[<?=$hero_keywords_arr[$board_list['hero_keywords']]?>]</span>
						<? } ?>
						<!-- ���� -->
						<span class="noti_tit fz34 fw700 ellipsis_2line"><?=cut($board_list['hero_title'],100);?></span>
						<!-- sns ���� -->
						<div class="snsbox abs">
							<div class="rel">
							    <div class="btn_share"><img src="/img/front/board/share.webp" alt="aklover-share"></div>
								<div class="share_inner abs">
									<div class="rel">
										<div class="btn_close abs"><img src="/img/front/board/share_x.webp" alt="aklover-close"></div>
										<p class="title fz18 fw600">�����ϱ�</p>
										<ul>
											<li>
												<a id="kakaotalk-sharing-btn-event" href="javascript:;">
													<img src="/img/front/board/share_kakao.webp" alt="īī�� �����ϱ�">
												</a>
												<p class="fz14">īī����</p>
											</li>
											<li id="copyLinkBtn">
												<img src="/img/front/board/share_link.webp" alt="��ũ����">
												<p class="fz14">��ũ����</p>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="writer f_b">
						<!-- [����] �۾��� [��]-->
						<div class="f_cs nick_cate">
							<img src="<?=$hero_profile?>" alt="aklover" class="profile">
							<span class="fz16 fw500"><?=cut($pk_row['hero_nick'], $cut_count_name);?></span>
							<span class="fz16 fw500 mu_bar"><?=$gubun_arr[$board_list['gubun']]?></span>
						</div>
						<!-- ��¥ -->
						<span class="gray fz16 fw500"><?=$board_list['hero_today']?></span>
					</div>
					<div class="cont">
						<!-- ���� -->
						<?
							$temp_command = htmlspecialchars_decode ( $board_list ['hero_command'] );
							$next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $temp_command );
							$temp_hero_04 = href ( nl2br ( $board_list ['hero_04'] ) );
							$temp_hero_04 = str_ireplace ( '<A', '<A target="_blank"', $temp_hero_04 );
						?>
							<?=$next_command;?>
							<div><?=$temp_hero_04;?></div>
					</div>
					<!-- ÷������ -->
					<?if(strcmp($board_list['hero_board_two'], '')){
						if($idx == '136705'){  // 160315 ������ Ư�� �Խù� ���� �α��� ȸ���� �ٿ�ε� �ǰ� �Ϸ���
							if(strcmp($_SESSION['temp_code'], '')){ ?>
							<div class="file f_cs">
								<span class="fz18 fw500">÷������</span>
								<a href="http://aklover.co.kr/user/file/16day.zip" class="label_button">16day.zip</a>
							</div>
							<?}
						}else{
						?>
						<div class="f_cs file">
							<span class="fz18 fw500">÷������</span>
							<a href="https://aklover.co.kr/freebest/download.php?hero=<?=$board_list['hero_board_one']?>&download=<?=$board_list['hero_board_two']?>" class="label_button"><?=$board_list['hero_board_two'];?></a>
						</div>
						<?
						}// end else
					}?>
					<!-- url -->
					<?if((! strcmp ( $_REQUEST ['board'], 'group_04_05' )) or (! strcmp ( $_REQUEST ['board'], 'group_04_06' )) or (! strcmp ( $_REQUEST ['board'], 'group_04_07' )) or (! strcmp ( $_REQUEST ['board'], 'group_04_08' )) or (! strcmp ( $_REQUEST ['board'], 'group_04_09' )) or (! strcmp ( $_REQUEST ['board'], 'group_04_27' )) or (! strcmp ( $_REQUEST ['board'], 'group_04_28' )) ) {?>
						<div>
							<span>URL</span>
							<p><?=$temp_hero_04;?></p>
						</div>
					<?}?>
					<?
					include_once BOARD_INC_END . 'button3.php';

					$check_review_sql = 'select * from hero_group where hero_board=\'' . $_GET ['board'] . '\';';
					$out_check_review_sql = mysql_query ( $check_review_sql );
					$check_review_list = @mysql_fetch_assoc ( $out_check_review_sql );
					$check_review_list ['hero_rev'];

					if($board_list['hero_review_use'] == 1) { //2021-12-14 �ӽ÷� ��� ����
						include_once BOARD_INC_END . 'review2.php';
					}
					?>
				</div>
			</div>
		</div>
	</div>
<script>
$(document).ready(function(){
	$("#view_contents img").each(function(i){
		if($(this).width() > 680) {
			$(this).css("width","100%");
		}
	})
})

function temp_link(n) { //170715 �ӽø�ũ
	var url = "";
	if(n == "1") {
		url = "/main/index.php?board=group_04_01";
	} else if(n == "2") {
		url = "/main/index.php?board=group_04_12";
	} else if(n == "3"){
		url = "/main/index.php?board=group_04_02";
	}
	window.open(url,'','');
}
</script>

<script>
	const currentUrl = window.location.href;

	// �Խñ� ���ο��� ù��° �̹��� ��������
	const pTag = document.querySelector(".cont").childNodes;
	let imageUrl = "";

	for(let i = 0; i < pTag.length; i++) {
		const childNodes = pTag[i].childNodes;
		for(let s = 0; s < childNodes.length; s++) {
			if (childNodes[s].tagName === 'IMG') {
				imageUrl = childNodes[s].src;
				break;
			}
		}
		if (imageUrl) break;
	}

	Kakao.Share.createDefaultButton({
        container: '#kakaotalk-sharing-btn-event',
        objectType: 'feed',
        content: {
            title: '<?=cut($board_list['hero_title'],48);?>',
            description: 'AK Lover �̺�Ʈ�� ������ ������!',
            imageUrl: imageUrl,
            link: {
                mobileWebUrl: currentUrl,
                webUrl: currentUrl,
            },
        },
        buttons: [
        {
            title: '������ ����',
            link: {
                mobileWebUrl: currentUrl,
                webUrl: currentUrl,
            },
        },
        ],
    }); 

	// view ������ ��ũ�� �� ���� ��� �� fixed
	const fixedItem = document.querySelector(".fixed_item");
	const offsetTop = document.querySelector(".sub_cont").offsetTop;
	let scrollNotFixed = 0;

	setTimeout(() => { //Dom ������ �� ����� ���� ���ϱ�
		const bottomClear = document.querySelector(".board_wrap .right");
		const bcRect = bottomClear.getBoundingClientRect().height;
		scrollNotFixed = bcRect;
	}, 100);

	window.addEventListener("scroll", () => {
		if (window.scrollY >= offsetTop) {
			fixedItem.classList.add("fixed");
			requestAnimationFrame(() => {
				fixedItem.style.top = "100px";
			});

			// if(scrollNotFixed - 100 > window.scrollY){
			// 	requestAnimationFrame(() => {
			// 		fixedItem.style.top = "100px";
			// 	});
			// } else {
			// 	requestAnimationFrame(() => {
			// 		fixedItem.style.top = "80px";
			// 	});
			// }
		} else {
			fixedItem.classList.remove("fixed");
			requestAnimationFrame(() => {
				fixedItem.style.top = "0px";
			});
		}
	});

</script>