<link rel="stylesheet" href="../css/front/supporters.css">
<script type="text/javascript" src="/js/musign/sns_share.js"></script>
<script type="text/javascript" src="/js/musign/suppoters.js"></script>
<?
if (! defined ( '_HEROBOARD_' ))	exit ();

if (! strcmp ( $_SESSION ['temp_level'], '' )) {
	$my_level = '0';
	$my_write = '0';
	$my_view = 0;
	$my_update = '0';
	$my_rev = '0';
} else {
	$my_level = $_SESSION ['temp_level'];
	$my_write = $_SESSION ['temp_write'];
	$my_view = $_SESSION ['temp_view'];
	$my_update = $_SESSION ['temp_update'];
	$my_rev = $_SESSION ['temp_rev'];
}

$group_sql = " SELECT * FROM hero_group WHERE hero_order!='0' AND hero_use='1' AND hero_board ='".$_GET ['board']."' ";
sql($group_sql);
$right_list = @mysql_fetch_assoc ( $out_sql );

$sql  = " SELECT * FROM mission as A ";
$sql .= " , (SELECT count(hero_superpass) as superpass FROM mission_review where hero_old_idx='".$_GET ['idx']."' ";
$sql .= " AND hero_table='" . $_GET ['board'] . "' and hero_superpass ='Y') as B ";
$sql .= " WHERE A.hero_kind!='����ü��' AND hero_table = '" . $_GET ['board'] . "' and hero_idx='" . $_GET ['idx'] . "' ";
if($my_write < 9999) {
	$sql .= " AND A.hero_use = 1 ";
}
sql ($sql,'on');
$out_row = @mysql_fetch_assoc ($out_sql);

$mission_board_type = false; //�ҹ�����, �̼� �����ϱ� Ÿ��
if($out_row["hero_type"] == "2" ||  $out_row["hero_type"] == "10") {
	$mission_board_type = true;
}

$focus_group = false;
if($_GET["board"] == "group_04_06" || $_GET["board"] == "group_04_27" || $_GET["board"] == "group_04_28") {
	$focus_group = true;
}

//�����ڴ� ������ �̼� �� ������ ���� ���� ����
$review_sql = " SELECT count(*) as cnt FROM mission_review WHERE hero_old_idx = '".$_GET ['idx']."' AND hero_code = '".$_SESSION["temp_code"]."' AND lot_01 = 1 ";
$review_res = sql($review_sql);
$review_rs = mysql_fetch_assoc($review_res);
$review_auth = false;
if($review_rs["cnt"] > 0) $review_auth = true;

//�ı���ۼ���
if($review_auth) {
	$board_write_sql = " SELECT count(*) as cnt FROM board WHERE hero_01 = '".$_GET ['idx']."' AND hero_code = '".$_SESSION["temp_code"]."' ";
	$board_write_res = sql($board_write_sql);
	$board_write_rs = mysql_fetch_assoc($board_write_res);
}

$check_day = date ( "Y-m-d", time () );
$today_04_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_04_02'] ) );
$today_01_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_01_02'] ) );
if($review_auth == false) {
	if($focus_group){ //��Ƽ, ��Ʃ��, ������
		if($out_row["hero_type"] == "7") { //�����̼�
			$mission_last_day = $out_row ['hero_today_04_02'];
			if($mission_last_day == "0000-00-00 00:00:00") {
				$last_day = date ( "Y-m-d", strtotime ( $out_row ['hero_today_03_02'] ) );
			} else {
				$last_day = date ( "Y-m-d", strtotime ( $out_row ['hero_today_04_02'] ) );
			}

			if ($my_write < '9999' and $last_day < $check_day){

				$action_href = PATH_HOME . '?' . get ( 'view' );
                //musign ���� - YDH
//              msg(' ������ �̼��Դϴ�.', 'location.href="' . $action_href . '"' );
//				exit ();
			}
		} else if($out_row["hero_type"] == "9") { //����̼�(����)
			$mission_last_day = $out_row ['hero_today_04_02'];
			if($mission_last_day == "0000-00-00 00:00:00") {
				$last_day = date ( "Y-m-d", strtotime ( $out_row ['hero_today_03_02'] ) );
			} else {
				$last_day = date ( "Y-m-d", strtotime ( $out_row ['hero_today_04_02'] ) );
			}

			if ($my_write < '9999' and $last_day < $check_day){

				$action_href = PATH_HOME . '?' . get ( 'view' );
                //musign ���� - YDH
//				msg(' ������ �̼��Դϴ�.', 'location.href="' . $action_href . '"' );
//				exit ();
			}
		} else {
			if ($my_write < '9999' and $today_01_02 < $check_day){

				$action_href = PATH_HOME . '?' . get ( 'view' );
                //musign ���� - YDH
//				msg(' ������ �̼��Դϴ�.', 'location.href="' . $action_href . '"' );
//				exit ();
			}
		}
	} else {
		$mission_last_day = $out_row ['hero_today_04_02'];
		if($mission_last_day == "0000-00-00 00:00:00") {
			$last_day = date ( "Y-m-d", strtotime ( $out_row ['hero_today_03_02'] ) );
		} else {
			$last_day = date ( "Y-m-d", strtotime ( $out_row ['hero_today_04_02'] ) );
		}

		if ($my_write < '9999' and $last_day < $check_day){

			$action_href = PATH_HOME . '?' . get ( 'view' );
            //musign ���� - YDH
//			msg(' ������ �̼��Դϴ�.', 'location.href="' . $action_href . '"' );
//			exit ();
		}
	}
}

// �����̾� �̼��� �α������� ���Ӱ���
$temp_auth_hero_code = $_SESSION["temp_code"];
if($focus_group){
	$tf = false;
	if($my_view==0){
		error_historyBack("�α����� �ʿ��� �̼��Դϴ�");
		exit;
	}
	//�����ڰ� �ƴϸ�
	elseif($my_view != '9999' && $my_view != '10000'){
		if($_GET['board'] == 'group_04_06'){ //��ƼŬ��
			if($my_view != $right_list['hero_view']){
			    if($out_row["hero_type"] == "7") { //����ü��
					if($_SESSION["before_beauty_auth"] != "Y") {
						error_historyBack("�˼��մϴ�. �ش� �̼��� ��AK Lover �����̾� ��ƼŬ���� �е鿡 �� �� ���� �����մϴ�.");
						exit;
					}
				} else {
					error_historyBack("�˼��մϴ�. �ش� �̼��� ��AK Lover �����̾� ��ƼŬ���� �е鿡 �� �� ���� �����մϴ�.");
					exit;
				}
			}
		} else if($_GET ['board'] == 'group_04_27') {
			if($out_row["hero_movie_group"] == "group_04_27") {
				if($my_view != "9995") {
					if($out_row["hero_type"] == "7") {
						if($_SESSION["before_beautymovie_auth"] != "Y") {
							error_historyBack("�˼��մϴ�. �� �̼��� Beauty Club ������ ����� ������ �� �ֽ��ϴ�.");
							exit;
						}
					} else {
						error_historyBack("�˼��մϴ�. �� �̼��� ����� Beauty Club �������� ������ �� �ֽ��ϴ�.");
						exit;
					}
				}
			} else if($out_row["hero_movie_group"] == "group_04_31") {
				if($my_view != "9993") {
					if($out_row["hero_type"] == "7") {
						if($_SESSION["before_lifemovie_auth"] != "Y") {
							error_historyBack("�˼��մϴ�. �� �̼��� Life Club ������ ����� ������ �� �ֽ��ϴ�.");
							exit;
						}
					} else {
						error_historyBack("�˼��մϴ�. �� �̼��� ����� Life Club �������� ������ �� �ֽ��ϴ�.");
						exit;
					}
				}
			} else {
				error_historyBack("�˼��մϴ�. �����ڿ��� ������ �ּ���. ����׷��� �������� �ʾҽ��ϴ�.");
				exit;
			}
		} else if($_GET ['board'] == 'group_04_28') { //������Ŭ��
			if($my_view != $right_list['hero_view']){
				if($out_row["hero_type"] == "7") { //����ü��
					if($_SESSION["before_life_auth"] != "Y") {
						error_historyBack("�˼��մϴ�. �ش� �̼��� ��AK Lover �����̾� ������Ŭ���� �е鿡 �� �� ���� �����մϴ�.");
						exit;
					}
				} else {
					error_historyBack("�˼��մϴ�. �ش� �̼��� ��AK Lover �����̾� ������Ŭ���� �е鿡 �� �� ���� �����մϴ�.");
					exit;
				}
			}
		}
	}
}else {
	if($my_view < $right_list['hero_view']) {
		error_historyBack("�ְ� �������� ȸ���� �󼼺��Ⱑ �����մϴ�.");
		exit;
	}
}


// ####################################################################################################################################################

$check_day = date ( "Y-m-d", time () );
//if($_SERVER['REMOTE_ADDR'] == '121.167.104.240') $check_day = date("Y-m-d", strtotime("-2 day", time()));
$today_01_01 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_01_01'] ) );
$today_01_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_01_02'] ) );

$today_02_01 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_02_01'] ) );
$today_02_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_02_02'] ) );

$today_03_01 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_03_01'] ) );
$today_03_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_03_02'] ) );

$today_04_01 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_04_01'] ) );
$today_04_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_04_02'] ) );

$date_color_01 = "";
$date_color_02 = "";
$date_color_03 = "";
$date_color_04 = "";
if (($today_01_01 <= $check_day) and ($today_01_02 >= $check_day)) {
	$review_menu = '����� ��û : '; //ü��� ��û (2025-02-18 musign)
	if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){
		$date_color_01 = "orange";
	}else{
		$date_color_01 = "orange";
	}
	$one_day = $out_row ['hero_today_01_01'];
	$two_day = $out_row ['hero_today_01_02'];
	$setup_type = '1';
} else if (($today_02_01 <= $check_day) and ($today_02_02 >= $check_day)) {
	$review_menu = '����� ��ǥ : '; //������ ��ǥ (2025-02-18 musign)
	$date_color_02 = "orange";
	$one_day = $out_row ['hero_today_02_01'];
	$two_day = $out_row ['hero_today_02_02'];
	$setup_type = '2';
} else if (($today_03_01 <= $check_day) and ($today_03_02 >= $check_day)) {
	$review_menu = '���� ��� : '; //������ ��� (2025-02-18 musign)
	$date_color_03 = "orange";
	$one_day = $out_row ['hero_today_03_01'];
	$two_day = $out_row ['hero_today_03_02'];
	$setup_type = '3';
} else if (($today_04_01 <= $check_day) and ($today_04_02 >= $check_day)) {
	$review_menu = '����Ʈ ��ǥ : '; //��������� ��ǥ (2025-02-18 musign)
	$date_color_04 = "orange";
	$one_day = $out_row ['hero_today_04_01'];
	$two_day = $out_row ['hero_today_04_02'];
	$setup_type = '4';
} else {
	$review_menu = '���� �Ⱓ : ';
	$one_day = $out_row ['hero_today_01_01'];
	$two_day = $out_row ['hero_today_04_02'];
	$setup_type = '5';
}

//��û�� �ο� musign �߰�
$sql_01 = 'select * from mission_review where hero_old_idx=\''.$_GET['idx'].'\' order by hero_today desc';
$out_sql_01 = @mysql_query($sql_01);
$count_01 = @mysql_num_rows($out_sql_01);
?>

	<div id="content_wrap" class="suppoters_view">
		<div class="sub_wrap f_sc rel">
			<div class="left">
			<?php if($_GET['board']!='group_04_07'){
				$title_02 = str_replace("\r\n","<br/>",$out_row['hero_title_02']);
				$type_check = "";
				if($_GET ['board'] == 'group_04_05' || $_GET ['board'] == 'group_04_06' || $_GET ['board'] == 'group_04_28') {
					if($out_row["hero_question_url_check"] == "1") {
						$type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='���̹� ��α�'>";
					} else if($out_row["hero_question_url_check"] == "2") {
						$type_check = "<img src='/img/front/main/ic_insta.webp' alt='�ν�Ÿ�׷�'>";
					} else if($out_row["hero_question_url_check"] == "3") {
						$type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='��α�'><img src='/img/front/main/ic_insta.webp' alt='�ν�Ÿ�׷�'>";
					} else if($out_row["hero_question_url_check"] == "4") {
						$type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='��α�'><img src='/img/front/main/ic_insta.webp' alt='�ν�Ÿ�׷�'>";
					} else if($out_row["hero_question_url_check"] == "5") {
						$type_check = "<img src='/img/front/main/ic_youtube.webp' alt='��Ʃ��'>";
					} else if($out_row["hero_question_url_check"] == "6") {
						$type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='��α�'><img src='/img/front/main/ic_insta.webp' alt='�ν�Ÿ�׷�'><img src='/img/front/main/ic_youtube.webp' alt='��Ʃ��'>";
					} else {
						// if($out_row["hero_type"] == "1") {
						// 	$type_check = "�̺�Ʈ";
						// } else if($out_row["hero_type"] == "2") {
						// 	$type_check = "�ҹ�����";
						// } else if($out_row["hero_type"] == "3") {
						// 	$type_check = "��������";
						// } else if($out_row["hero_type"] == "5") {
						// 	$type_check = "ǰ������";
						// } else if($out_row["hero_type"] == "8") {
						// 	$type_check = "����Ʈü��";
						// } else {
						// 	$type_check = "ü���";
						// }
					}
				}
			?>
			<!-- ------------------------ ��� Ÿ��Ʋ ������ ��� (s) ---------------------------------->
			<? include_once("missionInfo.php") ?>
			<!-- ------------------------ ��� Ÿ��Ʋ ������ ��� (e) ---------------------------------->
			<!-- ------------------------ �󼼳��� ������ ��� (s) ---------------------------------->
			<? include_once("missionContent.php") ?>
			<!-- ------------------------ �󼼳��� ������ ��� (e) ---------------------------------->
			</div>
			<? }
			//�ְ�ڽ� (s)
			else{

			$command = htmlspecialchars_decode($out_row['hero_command']);
			$command = str_replace("&#160;","",$command);
			$week = array("��", "��", "ȭ", "��", "��", "��", "��");

			?>
			<!--div class="spm_img" style="padding:0;"><?=$command;?></div-->
		</head>

		<body>
			<div class="boxWrap">
				<div class="topWrap">
					<p class="thumbBig"><img src="/user/upload/<?=$out_row['hero_img_old']?>" width="300" border="0" alt="��ǰ"></p>
					<div class="topTit">
						<h1><img src="/image/mission/aekyungBoxTit.png" width="250" height="166" border="0" alt="������ ��ſ� �ְ�ڽ� ���ø� �̼�"></h1>
						<p class="txt fs18" style="width:270px; padding:0 0 0 50px;"><?=$out_row['hero_char']?></p>
						<p class="txt bold fs20"><?=$out_row['hero_title']?></p>
					</div>
				</div>
				<ul class="contentWrap">
					<li class="m05">
						<dl>
							<dt>|&nbsp;&nbsp;AK LOVER <span class="fc_or fs20">�ְ�ڽ���?</span></dt>
							<dd class="ml15 "><img src="/image/mission/img_gift.jpg" width="105" height="102" border="0" alt="����"></dd>
							<dd class="ml35" style="width:425px;">���(��)�� ����(��)�� �������� �̿��� �����ϰ� ������ �ִ� ������ ��õ�ϴ� �ְ�!<br/>�ְ��� �濵 ���ε�ó�� �ְ� �������� AK LOVER �е鿡�Ե� ������ �ູ�� �帮�� �ͽ��ϴ�.<br/>�ְ�ڽ��� ���� ������ ������ �̿�, ����, �����鿡�� ����� ������ ���ϰ� ������ �ູ�� ����������.</dd>
						</dl>
					</li>

					<li class="m02">
						<dl>
							<dt>|&nbsp;&nbsp;�̴��� <span class="fc_or fs20">�ְ�ڽ� ��ǰ</span></dt>
							<dd class="ml15"><img src="/user/upload/<?=$out_row['hero_img_old']?>" width="154" border="0" alt="��ǰ"></dd>
							<dd style="width:365px; padding-left:30px; padding-bottom:15px; max-height:95px; overflow:hidden; "><?=$out_row['hero_help']?></dd>
							<dd style="width:365px; padding-left:30px; margin-top:10px; " class="bold2">�����ο� : �� <?=$out_row['hero_select_count']?>��</dd>
						</dl>
					</li>

					<li class="m01">
						<dl>
							<dt>|&nbsp;&nbsp;�ְ�ڽ� <span class="fc_or fs20">���� �ȳ�</span></dt>
							<dd class="ml15"><img src="/image/mission/img_calendar.jpg" width="131" height="109" border="0" alt="Ķ����"></dd>
							<dd style="margin-top:14px; ">
								<ul class="periodTit bold ml35 fl">
									<li>�ְ�ڽ� ��û</li>
									<li>������ ��ǥ</li>
									<li>������ ���</li>
									<li>��� ������ ��ǥ</li>
								</ul>
								<ul class="periodTxt fl">
									<li> : <?=date("Y.m.d",strtotime($out_row['hero_today_01_01']))?>(<?=$week[date("w",strtotime($out_row['hero_today_01_01']))]?>) ~ <?=date("Y.m.d",strtotime($out_row['hero_today_01_02']))?>(<?=$week[date("w",strtotime($out_row['hero_today_01_02']))]?>)</li>
									<li> : <?=date("Y.m.d",strtotime($out_row['hero_today_02_01']))?>(<?=$week[date("w",strtotime($out_row['hero_today_02_01']))]?>) </li>
									<li> : <?=date("Y.m.d",strtotime($out_row['hero_today_03_01']))?>(<?=$week[date("w",strtotime($out_row['hero_today_03_01']))]?>) ~ <?=date("Y.m.d",strtotime($out_row['hero_today_03_02']))?>(<?=$week[date("w",strtotime($out_row['hero_today_03_02']))]?>)</li>
									<li> : <?=date("Y.m.d",strtotime($out_row['hero_today_04_01']))?>(<?=$week[date("w",strtotime($out_row['hero_today_04_01']))]?>)</li>
								</ul>
							</dd>
						</dl>
					</li>

					<li class="m06">
						<dl>
							<dt>|&nbsp;&nbsp;�ְ�ڽ� <span class="fc_or fs20">���� ���</span></dt>
							<dd style="float:none; text-align:center; "><img src="/image/mission/img_mission.jpg" width="580" height="208" border="0" alt="�������"></dd>
						</dl>
					</li>

					<li class="m07">
						<dl>
							<dt>|&nbsp;&nbsp;�ְ�ڽ� <span class="fc_or fs20">��������</span></dt>
							<dd>
								<ul class="bold ml15 fl fc_or li_notice">
									<li class="li_t">01</li>
									<li class="li_c"><span class="bold">�ְ�ڽ� ��û�� ���� ������ ���� ��ȹ</span>�� �����ּ���.</li>
									<li class="li_t">02</li>
									<li class="li_c"><span class="bold">��α� ������ 1��, ���� SNS �Ǵ� Ŀ�´�Ƽ 1�� �� 2�ǿ� �ı⸦ ���</span>�Ͽ��� �մϴ�.</li>
									<li class="li_t">03</li>
									<li class="li_c"><span class="bold">���� �������� 3�� �̻� </span>�ø��ž� �մϴ�.</li>
									<li class="li_t">04</li>
									<li class="li_c" style="letter-spacing:-1.2px;">�������� ��ǰ �� ��ǰ�� ��û�� ������ ����ϸ� <span class="bold">ü����� 100% ����</span>���ּž� �մϴ�. </li>
									<li class="li_t">05</li>
									<li class="li_c"><span class="bold">�ı� �̵�� �� 100����Ʈ ����</span>�Ǹ� 3���� �� ü��� �������� ���ܵ˴ϴ�.</li>
									<li class="li_t">06</li>
									<li class="li_c"><span class="bold">�ְ�ڽ� ��ǰ �߼� ����� ���� �ְ濡�� ����</span>�մϴ�.</li>
								</ul>
								<!--
								<ul class="fl" style="margin-left:10px; ">
									<li><span class="bold">�ְ�ڽ� ��û�� ���� ������ ���� ��ȹ</span>�� �����ּ���.</li>
									<li><span class="bold">��α� ������ 1��, ���� SNS �Ǵ� Ŀ�´�Ƽ 1�� �� 2�ǿ� �ı⸦ ���</span>�Ͽ��� �մϴ�.</li>
									<li><span class="bold">���� �������� 3�� �̻� </span>�ø��ž� �մϴ�.</li>
									<li>���� ���� <span class="bold">������ 70% �̻��� �� ����</span>���ּž� �մϴ�. </li>
									<li><span class="bold">�ı� �̵�� �� 100����Ʈ ����</span>�Ǹ� 3���� �� ü��� ������ �������� ���ܵ˴ϴ�.</li>
									<li><span class="bold">�ְ�ڽ� ��ǰ �߼� ����� ���� �ְ濡�� ����</span>�մϴ�.</li>
								</ul>
								-->
							</dd>
						</dl>
						<!--p class="fc_or fl mt15 bold" style="font-size:13px; ">* ������ �ܻ��ڿ� ����� ��ǰ���� �߼� �� �����̿��� ���� �ٶ��ϴ�.</p-->
					</li>

					<? if($out_row['hero_banner']){ ?>
						<li class="m08">
							<dl>
								<dt>|&nbsp;&nbsp;�ְ�ڽ� <span class="fc_or fs20">��ʻ���</span></dt>
								<dd>
									<?=$out_row['hero_banner']?>
									<p style="width: 500px;height: 50px;word-break: break-all;"><?=htmlspecialchars(trim($out_row['hero_banner']))?></p>
									<p style="width: 470px;font-weight:bold;word-break: break-all;">�� ��� �ڵ带 �����Ͽ� ������ �ϴܿ� �ٿ��ֱ� ���ּ���.</p>
								</dd>
							</dl>
						</li>
					<? } ?>

					<li class="m04">
						<dl>
							<dt>|&nbsp;&nbsp;�ְ�ڽ� ���� �ı� <span class="fc_or fs20">���� ��</span></dt>
							<dd style="float:none; text-align:center; ">
							<?=$out_row['hero_media']?>
							</dd>
						</dl>
					</li>

					<li class="m03">
						<dl>
							<dt>|&nbsp;&nbsp;�ְ�ڽ� <span class="fc_or fs20">��ǰ �ȳ�</span></dt>
							<dd style="float:none; ">
							<?=$command?>
							</dd>
						</dl>
					</li>




					</ul>
				</div>

			<? }//�ְ�ڽ� (e) ?>
			</div>
			<div class="right">
				<div class="fix_box">
					<!-- ------------------------ ���� ������ ��� (s) ---------------------------------->
					<? include_once("missionDate.php") ?>
					<!-- ------------------------ ���� ������ ��� (e) ---------------------------------->
					<!-- ��ư (s) -->
					<?
						$sql = "select * from mission_review where hero_table = '" . $_GET ['board'] . "' and hero_code='" . $_SESSION ['temp_code'] . "' and hero_old_idx='" . $_GET ['idx'] . "'";
						$view_sql = mysql_query ( $sql );
						$data_count = mysql_num_rows ( $view_sql );

						if(!strcmp($setup_type, '1')){ //ü��� ��û�Ⱓ (2025-02-18 musign)
							if(!strcmp($data_count,'0')){ //ü��� ��û ��������
								//��ƼŬ��, ��Ʃ��, ������Ŭ�� �ٷ� ���� ���
								if($_GET['board'] == 'group_04_06' || $_GET['board']=='group_04_27' || $_GET['board']=='group_04_28'){ ?>

									<? if($out_row["hero_type"] == "7") { //���� �̼� ?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME_HTTPS?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>" class="content_btn">ü��� ��û�ϱ�</a>
										</div>
									<? } else if($out_row["hero_type"] == "9") { //����̼�(����) ?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME_HTTPS?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>" class="content_btn">ü��� ��û�ϱ�</a>
										</div>
									<? } else { //�� �� ?>
										<?
										$sql = 'select hero_code from board where hero_table = \'' . $_GET ['board'] . '\' and hero_code=\'' . $_SESSION ['temp_code'] . '\' and hero_01=\'' . $_GET ['idx'] . '\'';
										$view_sql = @mysql_query ( $sql );
										$data_count = @mysql_num_rows ( $view_sql );
										if ($data_count == 0) { //����� �ıⰡ ������ ?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=write2&action=write&page=1&idx=<?=$_GET['idx']?>" class="content_btn">������ ����ϱ�</a>
										</div>
										<!-- ���̵� �ٿ� ��ư (s) -->
										<div class="guide_btn_bx">
											<? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
												<a href="/" class="download_btn content_btn test">���̵���� Ȯ���ϱ�</a>
											<? } ?>
										</div>
										<!-- ���̵� �ٿ� ��ư (e) -->
										<? } else { //����� �ıⰡ ������ ?>
											<div class="content_btn_div">
												<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&page=1&idx=<?=$_GET['idx']?>" class="content_btn">������ Ȯ���ϱ�</a>
											</div>
										<? } ?>
									<? } ?>
								<? } else { //������ ü��� ?>
									<? if($out_row['hero_type'] == 2) { //�ҹ����� ?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME_HTTPS?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>" class="content_btn">�ҹ����� �����ϱ�</a>
										</div>
                                        <div class="guide_btn_bx">
                                            <!--�����ڴ� 2�� ����Ǽ� �Ϲ�ȸ���� ����-->
                                            <? if(($out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) && ($_SESSION['temp_level'] < "9999")) { ?>
                                                <a href="/" class="download_btn content_btn test">���̵���� Ȯ���ϱ�</a>
                                            <? } ?>
                                        </div>
									<? } else if($out_row['hero_type'] == 10) { //ü���?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME_HTTPS?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>" class="content_btn">�̼� �����ϱ�</a>
										</div>
									<? }else if($out_row['hero_type'] == 1 ) { //�̺�Ʈ ?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME_HTTPS?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>" class="content_btn">�̺�Ʈ ��û�ϱ�</a>
										</div>
									<? }else if($out_row['hero_type'] == 3) { //�������� ?>
										<div class="content_btn_div">
											<a href="#" class="content_btn" style="visibility: hidden;">�������� ��û�ϱ�</a>
										</div>
									<? }else { //�� �� ?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME_HTTPS?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>" class="content_btn">ü��� ��û�ϱ�</a>
										</div>
									<? } ?>
								<? }
							}else{ //ü��� ��û ������
								if(strcmp($_SESSION['temp_id'], '')){
							?>
									<div class="content_btn_div">
                                        <a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_muDelete&idx=<?=$out_row['hero_idx']?>" class="content_btn">ü��� ��û ����ϱ�</a>
                                        <? if($_SERVER['REMOTE_ADDR'] == '121.167.104.240'){?>
                                            <a onclick="muDelete('<?=$_GET['board']?>','<?=$out_row['hero_idx']?>', '')" class="content_btn">(��)ü��� ��û ����ϱ�</a>
                                        <?}?>
									</div>
								<? }else{?>
									<div class="content_btn_div">
										<a href="Javascript:alert('�α����� �ϼž� ���������մϴ�');window.location.href='https://www.aklover.co.kr/main/index.php?board=login';" class="content_btn">ü��� ��û�ϱ�</a>
									</div>
								<? }?>
                                <div class="guide_btn_bx">
                                    <!--�����ڴ� 2�� ����Ǽ� �Ϲ�ȸ���� ����-->
                                    <? if(($out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) && ($_SESSION['temp_level'] < "9999")) { ?>
                                        <a href="/" class="download_btn content_btn test">���̵���� Ȯ���ϱ�</a>
                                    <? } ?>
                                </div>
					<?

							}
						} else if (! strcmp ( $setup_type, '2' )) { //������ ��ǥ�Ⱓ (2025-02-18 musign)
							if($_GET['board'] != 'group_04_06' && $_GET['board'] != 'group_04_27' && $_GET['board'] != 'group_04_28'){ //��Ƽ, ������ �����̾�					?>
								<div class="content_btn_div2">
									<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" class="content_btn pick_support">������ Ȯ���ϱ�</div>
									<? if($my_level > 9998) {?>
										<!-- <a	href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_02&idx=<?=$out_row['hero_idx']?>" class="content_btn">��û�� Ȯ��</a> -->
									<? } ?>
								</div>
							<? } else { //������ ?>
								<? if($out_row['hero_type'] == "7") { //�ҹ������ε� ���������� ���� 2�� ���µ� ?>
									<div class="content_btn_div2">
										<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" class="content_btn pick_support">������ Ȯ���ϱ�</div>
										<? if($my_level > 9998) { //������?>
											<!-- <a	href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_02&idx=<?=$out_row['hero_idx']?>" class="content_btn">��û�� Ȯ��</a> -->
										<? } ?>
									</div>
								<? } else if($out_row['hero_type'] == "9") { //����̼� (����)�ε� ��� �������� ���� ?>
									<div class="content_btn_div2">
										<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>"  class="content_btn pick_support">������ Ȯ���ϱ�</div>
										<? if($my_level > 9998) {?>
											<!-- <a	href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_02&idx=<?=$out_row['hero_idx']?>" class="content_btn">��û�� Ȯ��</a> -->
										<? } ?>
									</div>
								<? } ?>
							<? } ?>
					<? }else if (! strcmp ( $setup_type, '3' )) { //������ ��ϱⰣ (2025-02-18 musign)
							$sql = 'select * from mission_review where hero_table = \'' . $_GET ['board'] . '\' and lot_01=\'1\' and hero_code=\'' . $_SESSION ['temp_code'] . '\' and hero_old_idx=\'' . $_GET ['idx'] . '\'';
							$view_sql = @mysql_query ( $sql );
							$data_count = @mysql_num_rows ( $view_sql );

							if (! strcmp ( $data_count, '0' )) { //ü��� ����X
					?>
								<div class="content_btn_div2">
									<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" class="content_btn pick_support">������ Ȯ���ϱ�</div>
									<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&page=1&idx=<?=$_GET['idx']?>" class="content_btn">������ Ȯ���ϱ�</a>
								</div>				
							<? }else { //ü��� ����O
									$new_sql = 'select * from board where hero_table = \'' . $_GET ['board'] . '\' and hero_code=\'' . $_SESSION ['temp_code'] . '\' and hero_01=\'' . $_GET ['idx'] . '\'';
									$view_new_sql = mysql_query ( $new_sql );
									$new_count = mysql_num_rows ( $view_new_sql );
									if (! strcmp ( $new_count, '0' )) { //�ı� ��� X
							?>
										<div class="content_btn_div2">
											<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" class="content_btn pick_support">������ Ȯ���ϱ�</div>
											<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=write2&action=write&page=1&idx=<?=$_GET['idx']?>" class="content_btn">������ ����ϱ�</a>
										</div>
                                        <!-- ���̵� �ٿ� ��ư (s) -->
                                        <div class="guide_btn_bx">
                                            <? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
                                                <a href="/" class="download_btn content_btn test">���̵���� Ȯ���ϱ�</a>
                                            <? } ?>
                                        </div>
										<!-- ���̵� �ٿ� ��ư (e) -->
								<? }else{ //�ı��� O ?>
										<div class="content_btn_div2">
											<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" class="content_btn pick_support">������ Ȯ���ϱ�</div>
											<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&page=1&idx=<?=$_GET['idx']?>" class="content_btn">������ Ȯ���ϱ�</a>
										</div>
                                        <!-- ���̵� �ٿ� ��ư (s) -->
                                        <div class="guide_btn_bx">
                                            <? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
                                                <a href="/" class="download_btn content_btn test">���̵���� Ȯ���ϱ�</a>
                                            <? } ?>
                                        </div>
								<?
									}
								}
								?>


					<?
						}else if (! strcmp ( $setup_type, '4' )) { //��������� ��ǥ�Ⱓ (2025-02-18 musign)
					?>
							<div class="content_btn_div2">
								<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" class="content_btn pick_support">������ Ȯ���ϱ�</div>
								<? if($board_write_rs["cnt"] == 0 && $today_03_02 < $check_day && $review_auth) {//�ı� ���ۼ� �� ��ư ����?>
									<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=write2&action=write&page=1&idx=<?=$_GET['idx']?>" class="content_btn">������ ����ϱ�</a>
								<? } else if($board_write_rs["cnt"] > 0) { ?>
									<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&page=1&idx=<?=$_GET['idx']?>" class="content_btn">������ Ȯ���ϱ�</a>
								<? } ?>
								<a href="<?=PATH_HOME?>?board=group_04_10" class="content_btn">��� ������ Ȯ���ϱ�</a>
							</div>		
							<? if($board_write_rs["cnt"] == 0 && $today_03_02 < $check_day && $review_auth) {//�ı� ���ۼ� �� ��ư ����?>					
							<!-- ���̵� �ٿ� ��ư (s) -->
							<div class="guide_btn_bx">
								<? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { //��ϵ� ���̵���� ���� �� ?>
									<a href="/" class="download_btn content_btn test">���̵���� Ȯ���ϱ�</a>
								<? } ?>
							</div>
							<!-- ���̵� �ٿ� ��ư (e) -->
							<? } ?>
					<?
						} else if (! strcmp ( $setup_type, '5' )) {
					?>
							<div class="content_btn_div2">
								<p class="content_btn end">ü��� ��û�ϱ� (����)</p>
                                <a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&page=1&idx=<?=$_GET['idx']?>" class="content_btn">������ Ȯ���ϱ�</a>
							</div>
					<?
						}
					?>
					<!-- ��ư (e) -->
					<? if ($my_write == "9999") { //������
					?>
						<!-- ���̵� �ٿ� ��ư (s) -->
						<div class="guide_btn_bx">
							<? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
								<a href="/" class="download_btn content_btn test">���̵���� Ȯ���ϱ�</a>
							<? } ?>
						</div>
						<!-- ���̵� �ٿ� ��ư (e) -->
						<div class="button_area" style="margin-top:3rem">
							<a
								href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&page=<?=$_GET['page']?>&view=step_write&action=update&idx=<?=$_GET['idx']?>"><span style='margin: 10px'
								class="bg1">����</span>
							</a>
                            <a
                                class="pop_btn" style="cursor: pointer;"><span
                                class="bg1" style='margin: 10px; letter-spacing:-1px;'>ü��� ��û Ȯ��</span>
							</a>
							<a
								href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&idx=<?=$_GET['idx']?>"><span
								class="bg1" style='margin: 10px'>������ ��� Ȯ��</span>
							</a>
                            <!--2025-02-13 musign YDH ü��� ���� ��� �߰�-->
                            <? if($out_row['hero_use'] != '2'){?>
                                <a
                                    href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_mission&type=view&idx=<?=$_GET['idx']?>&page=<?=$_GET['page']?>&hero_use=2"><span
                                    class="bg1 fc_main" style='margin: 10px; letter-spacing:-1px;'>ü��� ����</span>
                                </a>
                            <?} else {?>
                                <a
                                    href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_mission&type=view&idx=<?=$_GET['idx']?>&page=<?=$_GET['page']?>&hero_use=0"><span
                                    class="bg1 fc_main" style='margin: 10px; letter-spacing:-1px;'>ü��� ���� ���</span>
                                </a>
                            <?}?>
						</div>
					<?}?>
				</div>
			</div>
		</div>
	</div> <!-- content wrap -->

<!-- ��û�� �˾� -->
<div class="contents guide_popup popup applicant_popup" style="display:none;">
    <div class="spm_step3 inner rel">
		<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
		<div class="inner_contents scroll">
			<div class="article_img"> <img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$out_row['hero_thumb']?>" width='126' height='126'/> </div>
			<div class="description_box">
				<div class="article_txt">
					<h2 class="fw600 fz24"><?=$out_row['hero_title']?></h2>
					<ul>
						<li class="f_b">
							<!--<img src="../image/mission/spm_date.gif" alt="" />-->
							<div class="fw600"><img src="/img/front/icon/twinkle.webp" alt="�� ������" class="star_ic"/> ���� �Ⱓ</div>
							<div class="fw500">
								<?=date( "y�� m�� d��", strtotime($out_row['hero_today_01_01']));?> ~ <?=date( "y�� m�� d��", strtotime($out_row['hero_today_04_02']));?>
							</div>
						</li>
						<?php if($my_view>98){?>
							<li class="f_b">
								<!--<img src="../image/mission/spm_cnt.gif" alt="" />-->
								<div class="fw600"><img src="/img/front/icon/twinkle.webp" alt="�� ������" class="star_ic"/> ��û�� �ο�</div>
								<span class="c_orange bold"><?=$count_01?> ��</span>
							</li>
						<?php }?>
					</ul>
				</div>
				<h3 class="fw600 fz18">
					ü��� ��û��
				</h3>
				<div class="applicant_list">
					<ul class="txt">
						<li class="fz14">- ü��ܿ� �����ǽ� �в��� �޴��� ���ڸ� ���� �ȳ��� �帳�ϴ�.</li>
						<li class="fz14">- �߰� ���ǻ����� ������ 1:1���Ƿ� ���ּ���.</li>
					</ul>
					<ul class="spm_wrap grid_3">
						<?
						$check_day = date( "Y-m-d", time());
						$today_01_01 = date( "Y-m-d", strtotime($out_row['hero_today_01_01']));
						$today_01_02 = date( "Y-m-d", strtotime($out_row['hero_today_01_02']));

						while($list_01                             = @mysql_fetch_assoc($out_sql_01)){
							$pk_m_sql = 'select * from member where hero_code = \''.$list_01['hero_code'].'\'';
							$out_pk_m_sql = mysql_query($pk_m_sql);
							$out_pk_m_row                             = @mysql_fetch_assoc($out_pk_m_sql);

							if($out_pk_m_row['hero_code']==$_SESSION['temp_code'] || $my_level>=9999){
								$pk_p_sql = 'select * from level where hero_level = \''.$out_pk_m_row['hero_level'].'\'';
								$out_pk_p_sql = mysql_query($pk_p_sql);
								$pk_p_row                             = @mysql_fetch_assoc($out_pk_p_sql);

								if($check_day>="2013-11-21")    $hero_mt5_view = $list_01['hero_03'];
								else						    $hero_mt5_view = $list_01['hero_02'];

								$hero_mt5_view = str_replace("/////","<br/>",$hero_mt5_view);

								?>

								<li class="f_cs">
									<span class="img_wrap <?php if(str($pk_p_row['hero_img_new']) === "https://www.aklover.co.kr/image/bbs/lev1.png?v=3"){?> position_img <? } ?>">
										<img src="<?=str($pk_p_row['hero_img_new'])?>" alt="level1" />
									</span>
									<span class="fz14">
										<?=$list_01['hero_nick']?>
									</span>
									<?if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){?>
                                        <a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_muDelete&idx=<?=$out_row['hero_idx']?>&hero_code=<?=$list_01['hero_code']?>">[����]</a>
                                        <? if($_SERVER['REMOTE_ADDR'] == '121.167.104.240'){?>
                                            <a onclick="muDelete('<?=$_GET['board']?>','<?=$out_row['hero_idx']?>', '<?=$list_01['hero_code']?>')" class="content_btn">(��)ü��� ��û ����ϱ�</a>
                                        <?}?>
									<?}?>
								</li>
						<?}}?>
					</ul>
				</div>
			</div>
		</div>
        <!-- <div class="spm_01"> <img src="../image/mission/spm_bg4.gif" alt="top" /> </div>
        <div class="btngroup tr">
            <a href="<?=PATH_HOME.'?'.get('view||idx')?>"><img src="../image/bbs/btn_list.gif" alt="���" /></a>
        </div> -->
    </div>
</div>


	<!-- ������ �˾� -->
	<!-- <div id="pick_popup" class="guide_popup" style="display:none">
		<div class="inner rel">
			<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
			<iframe id="popup-iframe" src="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" frameborder="0"></iframe>
		</div>
	</div>  -->
</div>

<script> 
	$(document).ready(function(){
		$('.pick_support').click(function(){
			let data_url = $(this).attr('data-url');        
            window.open(data_url, "popup01", "width=1600, height=800, left=100, top=100");
		});

		// ��û�� Ȯ�� �˾�
		$('.pop_btn').click(function(){
			$(".popup").show();
		});

		$('.btn_x').click(function(){
			$(".popup").hide();
		});
	});

    function muDelete(board, idx, hero_code){
        if(confirm('ü����� ����Ͻðڽ��ϱ�?')){
            location.href='<?=PATH_HOME?>?board='+board+'&view=step_muDelete&idx='+idx+'&hero_code='+hero_code
        }
    }
</script>
