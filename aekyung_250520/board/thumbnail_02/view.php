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
$sql .= " WHERE A.hero_kind!='구매체험' AND hero_table = '" . $_GET ['board'] . "' and hero_idx='" . $_GET ['idx'] . "' ";
if($my_write < 9999) {
	$sql .= " AND A.hero_use = 1 ";
}
sql ($sql,'on');
$out_row = @mysql_fetch_assoc ($out_sql);

$mission_board_type = false; //소문내기, 미션 인증하기 타입
if($out_row["hero_type"] == "2" ||  $out_row["hero_type"] == "10") {
	$mission_board_type = true;
}

$focus_group = false;
if($_GET["board"] == "group_04_06" || $_GET["board"] == "group_04_27" || $_GET["board"] == "group_04_28") {
	$focus_group = true;
}

//선정자는 마감된 미션 상세 페이지 접근 권한 있음
$review_sql = " SELECT count(*) as cnt FROM mission_review WHERE hero_old_idx = '".$_GET ['idx']."' AND hero_code = '".$_SESSION["temp_code"]."' AND lot_01 = 1 ";
$review_res = sql($review_sql);
$review_rs = mysql_fetch_assoc($review_res);
$review_auth = false;
if($review_rs["cnt"] > 0) $review_auth = true;

//후기미작성자
if($review_auth) {
	$board_write_sql = " SELECT count(*) as cnt FROM board WHERE hero_01 = '".$_GET ['idx']."' AND hero_code = '".$_SESSION["temp_code"]."' ";
	$board_write_res = sql($board_write_sql);
	$board_write_rs = mysql_fetch_assoc($board_write_res);
}

$check_day = date ( "Y-m-d", time () );
$today_04_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_04_02'] ) );
$today_01_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_01_02'] ) );
if($review_auth == false) {
	if($focus_group){ //뷰티, 유튜버, 라이프
		if($out_row["hero_type"] == "7") { //자율미션
			$mission_last_day = $out_row ['hero_today_04_02'];
			if($mission_last_day == "0000-00-00 00:00:00") {
				$last_day = date ( "Y-m-d", strtotime ( $out_row ['hero_today_03_02'] ) );
			} else {
				$last_day = date ( "Y-m-d", strtotime ( $out_row ['hero_today_04_02'] ) );
			}

			if ($my_write < '9999' and $last_day < $check_day){

				$action_href = PATH_HOME . '?' . get ( 'view' );
                //musign 제거 - YDH
//              msg(' 마감된 미션입니다.', 'location.href="' . $action_href . '"' );
//				exit ();
			}
		} else if($out_row["hero_type"] == "9") { //정기미션(선택)
			$mission_last_day = $out_row ['hero_today_04_02'];
			if($mission_last_day == "0000-00-00 00:00:00") {
				$last_day = date ( "Y-m-d", strtotime ( $out_row ['hero_today_03_02'] ) );
			} else {
				$last_day = date ( "Y-m-d", strtotime ( $out_row ['hero_today_04_02'] ) );
			}

			if ($my_write < '9999' and $last_day < $check_day){

				$action_href = PATH_HOME . '?' . get ( 'view' );
                //musign 제거 - YDH
//				msg(' 마감된 미션입니다.', 'location.href="' . $action_href . '"' );
//				exit ();
			}
		} else {
			if ($my_write < '9999' and $today_01_02 < $check_day){

				$action_href = PATH_HOME . '?' . get ( 'view' );
                //musign 제거 - YDH
//				msg(' 마감된 미션입니다.', 'location.href="' . $action_href . '"' );
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
            //musign 제거 - YDH
//			msg(' 마감된 미션입니다.', 'location.href="' . $action_href . '"' );
//			exit ();
		}
	}
}

// 프리미엄 미션은 로그인이후 접속가능
$temp_auth_hero_code = $_SESSION["temp_code"];
if($focus_group){
	$tf = false;
	if($my_view==0){
		error_historyBack("로그인이 필요한 미션입니다");
		exit;
	}
	//관리자가 아니면
	elseif($my_view != '9999' && $my_view != '10000'){
		if($_GET['board'] == 'group_04_06'){ //뷰티클럽
			if($my_view != $right_list['hero_view']){
			    if($out_row["hero_type"] == "7") { //자율체험
					if($_SESSION["before_beauty_auth"] != "Y") {
						error_historyBack("죄송합니다. 해당 미션은 ‘AK Lover 프리미어 뷰티클럽’ 분들에 한 해 참여 가능합니다.");
						exit;
					}
				} else {
					error_historyBack("죄송합니다. 해당 미션은 ‘AK Lover 프리미어 뷰티클럽’ 분들에 한 해 참여 가능합니다.");
					exit;
				}
			}
		} else if($_GET ['board'] == 'group_04_27') {
			if($out_row["hero_movie_group"] == "group_04_27") {
				if($my_view != "9995") {
					if($out_row["hero_type"] == "7") {
						if($_SESSION["before_beautymovie_auth"] != "Y") {
							error_historyBack("죄송합니다. 이 미션은 Beauty Club 영상팀 기수만 참여할 수 있습니다.");
							exit;
						}
					} else {
						error_historyBack("죄송합니다. 이 미션은 현기수 Beauty Club 영상팀만 참여할 수 있습니다.");
						exit;
					}
				}
			} else if($out_row["hero_movie_group"] == "group_04_31") {
				if($my_view != "9993") {
					if($out_row["hero_type"] == "7") {
						if($_SESSION["before_lifemovie_auth"] != "Y") {
							error_historyBack("죄송합니다. 이 미션은 Life Club 영상팀 기수만 참여할 수 있습니다.");
							exit;
						}
					} else {
						error_historyBack("죄송합니다. 이 미션은 현기수 Life Club 영상팀만 참여할 수 있습니다.");
						exit;
					}
				}
			} else {
				error_historyBack("죄송합니다. 관리자에게 문의해 주세요. 영상그룹이 설정되지 않았습니다.");
				exit;
			}
		} else if($_GET ['board'] == 'group_04_28') { //라이프클럽
			if($my_view != $right_list['hero_view']){
				if($out_row["hero_type"] == "7") { //자율체험
					if($_SESSION["before_life_auth"] != "Y") {
						error_historyBack("죄송합니다. 해당 미션은 ‘AK Lover 프리미어 라이프클럽’ 분들에 한 해 참여 가능합니다.");
						exit;
					}
				} else {
					error_historyBack("죄송합니다. 해당 미션은 ‘AK Lover 프리미어 라이프클럽’ 분들에 한 해 참여 가능합니다.");
					exit;
				}
			}
		}
	}
}else {
	if($my_view < $right_list['hero_view']) {
		error_historyBack("애경 서포터즈 회원만 상세보기가 가능합니다.");
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
	$review_menu = '리뷰어 신청 : '; //체험단 신청 (2025-02-18 musign)
	if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){
		$date_color_01 = "orange";
	}else{
		$date_color_01 = "orange";
	}
	$one_day = $out_row ['hero_today_01_01'];
	$two_day = $out_row ['hero_today_01_02'];
	$setup_type = '1';
} else if (($today_02_01 <= $check_day) and ($today_02_02 >= $check_day)) {
	$review_menu = '리뷰어 발표 : '; //선정자 발표 (2025-02-18 musign)
	$date_color_02 = "orange";
	$one_day = $out_row ['hero_today_02_01'];
	$two_day = $out_row ['hero_today_02_02'];
	$setup_type = '2';
} else if (($today_03_01 <= $check_day) and ($today_03_02 >= $check_day)) {
	$review_menu = '리뷰 등록 : '; //콘텐츠 등록 (2025-02-18 musign)
	$date_color_03 = "orange";
	$one_day = $out_row ['hero_today_03_01'];
	$two_day = $out_row ['hero_today_03_02'];
	$setup_type = '3';
} else if (($today_04_01 <= $check_day) and ($today_04_02 >= $check_day)) {
	$review_menu = '베스트 발표 : '; //우수콘텐츠 발표 (2025-02-18 musign)
	$date_color_04 = "orange";
	$one_day = $out_row ['hero_today_04_01'];
	$two_day = $out_row ['hero_today_04_02'];
	$setup_type = '4';
} else {
	$review_menu = '참여 기간 : ';
	$one_day = $out_row ['hero_today_01_01'];
	$two_day = $out_row ['hero_today_04_02'];
	$setup_type = '5';
}

//신청자 인원 musign 추가
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
						$type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='네이버 블로그'>";
					} else if($out_row["hero_question_url_check"] == "2") {
						$type_check = "<img src='/img/front/main/ic_insta.webp' alt='인스타그램'>";
					} else if($out_row["hero_question_url_check"] == "3") {
						$type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='블로그'><img src='/img/front/main/ic_insta.webp' alt='인스타그램'>";
					} else if($out_row["hero_question_url_check"] == "4") {
						$type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='블로그'><img src='/img/front/main/ic_insta.webp' alt='인스타그램'>";
					} else if($out_row["hero_question_url_check"] == "5") {
						$type_check = "<img src='/img/front/main/ic_youtube.webp' alt='유튜브'>";
					} else if($out_row["hero_question_url_check"] == "6") {
						$type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='블로그'><img src='/img/front/main/ic_insta.webp' alt='인스타그램'><img src='/img/front/main/ic_youtube.webp' alt='유튜브'>";
					} else {
						// if($out_row["hero_type"] == "1") {
						// 	$type_check = "이벤트";
						// } else if($out_row["hero_type"] == "2") {
						// 	$type_check = "소문내기";
						// } else if($out_row["hero_type"] == "3") {
						// 	$type_check = "설문참여";
						// } else if($out_row["hero_type"] == "5") {
						// 	$type_check = "품평참여";
						// } else if($out_row["hero_type"] == "8") {
						// 	$type_check = "포인트체험";
						// } else {
						// 	$type_check = "체험단";
						// }
					}
				}
			?>
			<!-- ------------------------ 상단 타이틀 데이터 출력 (s) ---------------------------------->
			<? include_once("missionInfo.php") ?>
			<!-- ------------------------ 상단 타이틀 데이터 출력 (e) ---------------------------------->
			<!-- ------------------------ 상세내용 데이터 출력 (s) ---------------------------------->
			<? include_once("missionContent.php") ?>
			<!-- ------------------------ 상세내용 데이터 출력 (e) ---------------------------------->
			</div>
			<? }
			//애경박스 (s)
			else{

			$command = htmlspecialchars_decode($out_row['hero_command']);
			$command = str_replace("&#160;","",$command);
			$week = array("일", "월", "화", "수", "목", "금", "토");

			?>
			<!--div class="spm_img" style="padding:0;"><?=$command;?></div-->
		</head>

		<body>
			<div class="boxWrap">
				<div class="topWrap">
					<p class="thumbBig"><img src="/user/upload/<?=$out_row['hero_img_old']?>" width="300" border="0" alt="제품"></p>
					<div class="topTit">
						<h1><img src="/image/mission/aekyungBoxTit.png" width="250" height="166" border="0" alt="나눔의 즐거움 애경박스 샘플링 미션"></h1>
						<p class="txt fs18" style="width:270px; padding:0 0 0 50px;"><?=$out_row['hero_char']?></p>
						<p class="txt bold fs20"><?=$out_row['hero_title']?></p>
					</div>
				</div>
				<ul class="contentWrap">
					<li class="m05">
						<dl>
							<dt>|&nbsp;&nbsp;AK LOVER <span class="fc_or fs20">애경박스란?</span></dt>
							<dd class="ml15 "><img src="/image/mission/img_gift.jpg" width="105" height="102" border="0" alt="선물"></dd>
							<dd class="ml35" style="width:425px;">사랑(愛)과 존경(敬)의 마음으로 이웃과 소통하고 진정성 있는 나눔을 실천하는 애경!<br/>애경의 경영 마인드처럼 애경 서포터즈 AK LOVER 분들에게도 나눔의 행복을 드리고 싶습니다.<br/>애경박스를 통해 주위의 소중한 이웃, 지인, 가족들에게 사랑과 존경을 전하고 나눔의 행복을 느껴보세요.</dd>
						</dl>
					</li>

					<li class="m02">
						<dl>
							<dt>|&nbsp;&nbsp;이달의 <span class="fc_or fs20">애경박스 제품</span></dt>
							<dd class="ml15"><img src="/user/upload/<?=$out_row['hero_img_old']?>" width="154" border="0" alt="제품"></dd>
							<dd style="width:365px; padding-left:30px; padding-bottom:15px; max-height:95px; overflow:hidden; "><?=$out_row['hero_help']?></dd>
							<dd style="width:365px; padding-left:30px; margin-top:10px; " class="bold2">선정인원 : 총 <?=$out_row['hero_select_count']?>명</dd>
						</dl>
					</li>

					<li class="m01">
						<dl>
							<dt>|&nbsp;&nbsp;애경박스 <span class="fc_or fs20">일정 안내</span></dt>
							<dd class="ml15"><img src="/image/mission/img_calendar.jpg" width="131" height="109" border="0" alt="캘린더"></dd>
							<dd style="margin-top:14px; ">
								<ul class="periodTit bold ml35 fl">
									<li>애경박스 신청</li>
									<li>선정자 발표</li>
									<li>콘텐츠 등록</li>
									<li>우수 콘텐츠 발표</li>
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
							<dt>|&nbsp;&nbsp;애경박스 <span class="fc_or fs20">참여 방법</span></dt>
							<dd style="float:none; text-align:center; "><img src="/image/mission/img_mission.jpg" width="580" height="208" border="0" alt="참여방법"></dd>
						</dl>
					</li>

					<li class="m07">
						<dl>
							<dt>|&nbsp;&nbsp;애경박스 <span class="fc_or fs20">공지사항</span></dt>
							<dd>
								<ul class="bold ml15 fl fc_or li_notice">
									<li class="li_t">01</li>
									<li class="li_c"><span class="bold">애경박스 신청시 참여 이유와 나눔 계획</span>을 적어주세요.</li>
									<li class="li_t">02</li>
									<li class="li_c"><span class="bold">블로그 포스팅 1건, 개인 SNS 또는 커뮤니티 1건 총 2건에 후기를 등록</span>하여야 합니다.</li>
									<li class="li_t">03</li>
									<li class="li_c"><span class="bold">나눔 인증샷은 3건 이상 </span>올리셔야 합니다.</li>
									<li class="li_t">04</li>
									<li class="li_c" style="letter-spacing:-1.2px;">제공받은 제품 중 본품은 신청자 본인이 사용하며 <span class="bold">체험분은 100% 나눔</span>해주셔야 합니다. </li>
									<li class="li_t">05</li>
									<li class="li_c"><span class="bold">후기 미등록 시 100포인트 차감</span>되며 3개월 간 체험단 선정에서 제외됩니다.</li>
									<li class="li_t">06</li>
									<li class="li_c"><span class="bold">애경박스 제품 발송 비용은 전액 애경에서 지원</span>합니다.</li>
								</ul>
								<!--
								<ul class="fl" style="margin-left:10px; ">
									<li><span class="bold">애경박스 신청시 참여 이유와 나눔 계획</span>을 적어주세요.</li>
									<li><span class="bold">블로그 포스팅 1건, 개인 SNS 또는 커뮤니티 1건 총 2건에 후기를 등록</span>하여야 합니다.</li>
									<li><span class="bold">나눔 인증샷은 3건 이상 </span>올리셔야 합니다.</li>
									<li>제공 받은 <span class="bold">샘플의 70% 이상은 꼭 나눔</span>해주셔야 합니다. </li>
									<li><span class="bold">후기 미등록 시 100포인트 차감</span>되며 3개월 간 체험단 선정자 선정에서 제외됩니다.</li>
									<li><span class="bold">애경박스 제품 발송 비용은 전액 애경에서 지원</span>합니다.</li>
								</ul>
								-->
							</dd>
						</dl>
						<!--p class="fc_or fl mt15 bold" style="font-size:13px; ">* 샘플은 단상자에 담겨진 제품으로 발송 될 예정이오니 참고 바랍니다.</p-->
					</li>

					<? if($out_row['hero_banner']){ ?>
						<li class="m08">
							<dl>
								<dt>|&nbsp;&nbsp;애경박스 <span class="fc_or fs20">배너삽입</span></dt>
								<dd>
									<?=$out_row['hero_banner']?>
									<p style="width: 500px;height: 50px;word-break: break-all;"><?=htmlspecialchars(trim($out_row['hero_banner']))?></p>
									<p style="width: 470px;font-weight:bold;word-break: break-all;">위 배너 코드를 복사하여 컨텐츠 하단에 붙여넣기 해주세요.</p>
								</dd>
							</dl>
						</li>
					<? } ?>

					<li class="m04">
						<dl>
							<dt>|&nbsp;&nbsp;애경박스 나눔 후기 <span class="fc_or fs20">좋은 예</span></dt>
							<dd style="float:none; text-align:center; ">
							<?=$out_row['hero_media']?>
							</dd>
						</dl>
					</li>

					<li class="m03">
						<dl>
							<dt>|&nbsp;&nbsp;애경박스 <span class="fc_or fs20">제품 안내</span></dt>
							<dd style="float:none; ">
							<?=$command?>
							</dd>
						</dl>
					</li>




					</ul>
				</div>

			<? }//애경박스 (e) ?>
			</div>
			<div class="right">
				<div class="fix_box">
					<!-- ------------------------ 일정 데이터 출력 (s) ---------------------------------->
					<? include_once("missionDate.php") ?>
					<!-- ------------------------ 일정 데이터 출력 (e) ---------------------------------->
					<!-- 버튼 (s) -->
					<?
						$sql = "select * from mission_review where hero_table = '" . $_GET ['board'] . "' and hero_code='" . $_SESSION ['temp_code'] . "' and hero_old_idx='" . $_GET ['idx'] . "'";
						$view_sql = mysql_query ( $sql );
						$data_count = mysql_num_rows ( $view_sql );

						if(!strcmp($setup_type, '1')){ //체험단 신청기간 (2025-02-18 musign)
							if(!strcmp($data_count,'0')){ //체험단 신청 안했을때
								//뷰티클럽, 유튜버, 라이프클럽 바로 리뷰 등록
								if($_GET['board'] == 'group_04_06' || $_GET['board']=='group_04_27' || $_GET['board']=='group_04_28'){ ?>

									<? if($out_row["hero_type"] == "7") { //자율 미션 ?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME_HTTPS?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>" class="content_btn">체험단 신청하기</a>
										</div>
									<? } else if($out_row["hero_type"] == "9") { //정기미션(선택) ?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME_HTTPS?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>" class="content_btn">체험단 신청하기</a>
										</div>
									<? } else { //그 외 ?>
										<?
										$sql = 'select hero_code from board where hero_table = \'' . $_GET ['board'] . '\' and hero_code=\'' . $_SESSION ['temp_code'] . '\' and hero_01=\'' . $_GET ['idx'] . '\'';
										$view_sql = @mysql_query ( $sql );
										$data_count = @mysql_num_rows ( $view_sql );
										if ($data_count == 0) { //등록한 후기가 없을때 ?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=write2&action=write&page=1&idx=<?=$_GET['idx']?>" class="content_btn">콘텐츠 등록하기</a>
										</div>
										<!-- 가이드 다운 버튼 (s) -->
										<div class="guide_btn_bx">
											<? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
												<a href="/" class="download_btn content_btn test">가이드라인 확인하기</a>
											<? } ?>
										</div>
										<!-- 가이드 다운 버튼 (e) -->
										<? } else { //등록한 후기가 있을때 ?>
											<div class="content_btn_div">
												<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&page=1&idx=<?=$_GET['idx']?>" class="content_btn">콘텐츠 확인하기</a>
											</div>
										<? } ?>
									<? } ?>
								<? } else { //베이직 체험단 ?>
									<? if($out_row['hero_type'] == 2) { //소문내기 ?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME_HTTPS?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>" class="content_btn">소문내기 인증하기</a>
										</div>
                                        <div class="guide_btn_bx">
                                            <!--관리자는 2번 노출되서 일반회원만 노출-->
                                            <? if(($out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) && ($_SESSION['temp_level'] < "9999")) { ?>
                                                <a href="/" class="download_btn content_btn test">가이드라인 확인하기</a>
                                            <? } ?>
                                        </div>
									<? } else if($out_row['hero_type'] == 10) { //체험단?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME_HTTPS?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>" class="content_btn">미션 인증하기</a>
										</div>
									<? }else if($out_row['hero_type'] == 1 ) { //이벤트 ?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME_HTTPS?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>" class="content_btn">이벤트 신청하기</a>
										</div>
									<? }else if($out_row['hero_type'] == 3) { //설문조사 ?>
										<div class="content_btn_div">
											<a href="#" class="content_btn" style="visibility: hidden;">서포터즈 신청하기</a>
										</div>
									<? }else { //그 외 ?>
										<div class="content_btn_div">
											<a href="<?=PATH_HOME_HTTPS?>?board=<?=$_GET['board']?>&view=step_01&idx=<?=$out_row['hero_idx']?>" class="content_btn">체험단 신청하기</a>
										</div>
									<? } ?>
								<? }
							}else{ //체험단 신청 했을때
								if(strcmp($_SESSION['temp_id'], '')){
							?>
									<div class="content_btn_div">
                                        <a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_muDelete&idx=<?=$out_row['hero_idx']?>" class="content_btn">체험단 신청 취소하기</a>
                                        <? if($_SERVER['REMOTE_ADDR'] == '121.167.104.240'){?>
                                            <a onclick="muDelete('<?=$_GET['board']?>','<?=$out_row['hero_idx']?>', '')" class="content_btn">(뮤)체험단 신청 취소하기</a>
                                        <?}?>
									</div>
								<? }else{?>
									<div class="content_btn_div">
										<a href="Javascript:alert('로그인을 하셔야 참여가능합니다');window.location.href='https://www.aklover.co.kr/main/index.php?board=login';" class="content_btn">체험단 신청하기</a>
									</div>
								<? }?>
                                <div class="guide_btn_bx">
                                    <!--관리자는 2번 노출되서 일반회원만 노출-->
                                    <? if(($out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) && ($_SESSION['temp_level'] < "9999")) { ?>
                                        <a href="/" class="download_btn content_btn test">가이드라인 확인하기</a>
                                    <? } ?>
                                </div>
					<?

							}
						} else if (! strcmp ( $setup_type, '2' )) { //선정자 발표기간 (2025-02-18 musign)
							if($_GET['board'] != 'group_04_06' && $_GET['board'] != 'group_04_27' && $_GET['board'] != 'group_04_28'){ //뷰티, 라이프 프리미어					?>
								<div class="content_btn_div2">
									<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" class="content_btn pick_support">선정자 확인하기</div>
									<? if($my_level > 9998) {?>
										<!-- <a	href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_02&idx=<?=$out_row['hero_idx']?>" class="content_btn">신청자 확인</a> -->
									<? } ?>
								</div>
							<? } else { //베이직 ?>
								<? if($out_row['hero_type'] == "7") { //소문내기인데 베이직에는 벨류 2로 쓰는데 ?>
									<div class="content_btn_div2">
										<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" class="content_btn pick_support">선정자 확인하기</div>
										<? if($my_level > 9998) { //관리자?>
											<!-- <a	href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_02&idx=<?=$out_row['hero_idx']?>" class="content_btn">신청자 확인</a> -->
										<? } ?>
									</div>
								<? } else if($out_row['hero_type'] == "9") { //정기미션 (선택)인데 얘는 베이직에 없음 ?>
									<div class="content_btn_div2">
										<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>"  class="content_btn pick_support">선정자 확인하기</div>
										<? if($my_level > 9998) {?>
											<!-- <a	href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_02&idx=<?=$out_row['hero_idx']?>" class="content_btn">신청자 확인</a> -->
										<? } ?>
									</div>
								<? } ?>
							<? } ?>
					<? }else if (! strcmp ( $setup_type, '3' )) { //콘텐츠 등록기간 (2025-02-18 musign)
							$sql = 'select * from mission_review where hero_table = \'' . $_GET ['board'] . '\' and lot_01=\'1\' and hero_code=\'' . $_SESSION ['temp_code'] . '\' and hero_old_idx=\'' . $_GET ['idx'] . '\'';
							$view_sql = @mysql_query ( $sql );
							$data_count = @mysql_num_rows ( $view_sql );

							if (! strcmp ( $data_count, '0' )) { //체험단 선정X
					?>
								<div class="content_btn_div2">
									<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" class="content_btn pick_support">선정자 확인하기</div>
									<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&page=1&idx=<?=$_GET['idx']?>" class="content_btn">콘텐츠 확인하기</a>
								</div>				
							<? }else { //체험단 선정O
									$new_sql = 'select * from board where hero_table = \'' . $_GET ['board'] . '\' and hero_code=\'' . $_SESSION ['temp_code'] . '\' and hero_01=\'' . $_GET ['idx'] . '\'';
									$view_new_sql = mysql_query ( $new_sql );
									$new_count = mysql_num_rows ( $view_new_sql );
									if (! strcmp ( $new_count, '0' )) { //후기 등록 X
							?>
										<div class="content_btn_div2">
											<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" class="content_btn pick_support">선정자 확인하기</div>
											<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=write2&action=write&page=1&idx=<?=$_GET['idx']?>" class="content_btn">콘텐츠 등록하기</a>
										</div>
                                        <!-- 가이드 다운 버튼 (s) -->
                                        <div class="guide_btn_bx">
                                            <? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
                                                <a href="/" class="download_btn content_btn test">가이드라인 확인하기</a>
                                            <? } ?>
                                        </div>
										<!-- 가이드 다운 버튼 (e) -->
								<? }else{ //후기등록 O ?>
										<div class="content_btn_div2">
											<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" class="content_btn pick_support">선정자 확인하기</div>
											<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&page=1&idx=<?=$_GET['idx']?>" class="content_btn">콘텐츠 확인하기</a>
										</div>
                                        <!-- 가이드 다운 버튼 (s) -->
                                        <div class="guide_btn_bx">
                                            <? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
                                                <a href="/" class="download_btn content_btn test">가이드라인 확인하기</a>
                                            <? } ?>
                                        </div>
								<?
									}
								}
								?>


					<?
						}else if (! strcmp ( $setup_type, '4' )) { //우수콘텐츠 발표기간 (2025-02-18 musign)
					?>
							<div class="content_btn_div2">
								<div data-url="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_03&idx=<?=$out_row['hero_idx']?>" class="content_btn pick_support">선정자 확인하기</div>
								<? if($board_write_rs["cnt"] == 0 && $today_03_02 < $check_day && $review_auth) {//후기 미작성 시 버튼 노출?>
									<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=write2&action=write&page=1&idx=<?=$_GET['idx']?>" class="content_btn">콘텐츠 등록하기</a>
								<? } else if($board_write_rs["cnt"] > 0) { ?>
									<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&page=1&idx=<?=$_GET['idx']?>" class="content_btn">콘텐츠 확인하기</a>
								<? } ?>
								<a href="<?=PATH_HOME?>?board=group_04_10" class="content_btn">우수 콘텐츠 확인하기</a>
							</div>		
							<? if($board_write_rs["cnt"] == 0 && $today_03_02 < $check_day && $review_auth) {//후기 미작성 시 버튼 노출?>					
							<!-- 가이드 다운 버튼 (s) -->
							<div class="guide_btn_bx">
								<? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { //등록된 가이드라인 있을 때 ?>
									<a href="/" class="download_btn content_btn test">가이드라인 확인하기</a>
								<? } ?>
							</div>
							<!-- 가이드 다운 버튼 (e) -->
							<? } ?>
					<?
						} else if (! strcmp ( $setup_type, '5' )) {
					?>
							<div class="content_btn_div2">
								<p class="content_btn end">체험단 신청하기 (마감)</p>
                                <a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&page=1&idx=<?=$_GET['idx']?>" class="content_btn">콘텐츠 확인하기</a>
							</div>
					<?
						}
					?>
					<!-- 버튼 (e) -->
					<? if ($my_write == "9999") { //관리자
					?>
						<!-- 가이드 다운 버튼 (s) -->
						<div class="guide_btn_bx">
							<? if( $out_row['guide_ori_file'] || $out_row['guide_ori_file2'] || $out_row['guide_ori_file3']) { ?>
								<a href="/" class="download_btn content_btn test">가이드라인 확인하기</a>
							<? } ?>
						</div>
						<!-- 가이드 다운 버튼 (e) -->
						<div class="button_area" style="margin-top:3rem">
							<a
								href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&page=<?=$_GET['page']?>&view=step_write&action=update&idx=<?=$_GET['idx']?>"><span style='margin: 10px'
								class="bg1">수정</span>
							</a>
                            <a
                                class="pop_btn" style="cursor: pointer;"><span
                                class="bg1" style='margin: 10px; letter-spacing:-1px;'>체험단 신청 확인</span>
							</a>
							<a
								href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_05&idx=<?=$_GET['idx']?>"><span
								class="bg1" style='margin: 10px'>콘텐츠 등록 확인</span>
							</a>
                            <!--2025-02-13 musign YDH 체험단 삭제 기능 추가-->
                            <? if($out_row['hero_use'] != '2'){?>
                                <a
                                    href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_mission&type=view&idx=<?=$_GET['idx']?>&page=<?=$_GET['page']?>&hero_use=2"><span
                                    class="bg1 fc_main" style='margin: 10px; letter-spacing:-1px;'>체험단 삭제</span>
                                </a>
                            <?} else {?>
                                <a
                                    href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_mission&type=view&idx=<?=$_GET['idx']?>&page=<?=$_GET['page']?>&hero_use=0"><span
                                    class="bg1 fc_main" style='margin: 10px; letter-spacing:-1px;'>체험단 삭제 취소</span>
                                </a>
                            <?}?>
						</div>
					<?}?>
				</div>
			</div>
		</div>
	</div> <!-- content wrap -->

<!-- 신청자 팝업 -->
<div class="contents guide_popup popup applicant_popup" style="display:none;">
    <div class="spm_step3 inner rel">
		<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
		<div class="inner_contents scroll">
			<div class="article_img"> <img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$out_row['hero_thumb']?>" width='126' height='126'/> </div>
			<div class="description_box">
				<div class="article_txt">
					<h2 class="fw600 fz24"><?=$out_row['hero_title']?></h2>
					<ul>
						<li class="f_b">
							<!--<img src="../image/mission/spm_date.gif" alt="" />-->
							<div class="fw600"><img src="/img/front/icon/twinkle.webp" alt="별 아이콘" class="star_ic"/> 진행 기간</div>
							<div class="fw500">
								<?=date( "y년 m월 d일", strtotime($out_row['hero_today_01_01']));?> ~ <?=date( "y년 m월 d일", strtotime($out_row['hero_today_04_02']));?>
							</div>
						</li>
						<?php if($my_view>98){?>
							<li class="f_b">
								<!--<img src="../image/mission/spm_cnt.gif" alt="" />-->
								<div class="fw600"><img src="/img/front/icon/twinkle.webp" alt="별 아이콘" class="star_ic"/> 신청자 인원</div>
								<span class="c_orange bold"><?=$count_01?> 명</span>
							</li>
						<?php }?>
					</ul>
				</div>
				<h3 class="fw600 fz18">
					체험단 신청자
				</h3>
				<div class="applicant_list">
					<ul class="txt">
						<li class="fz14">- 체험단에 선정되신 분께는 휴대폰 문자를 통해 안내해 드립니다.</li>
						<li class="fz14">- 추가 문의사항은 고객센터 1:1문의로 해주세요.</li>
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
                                        <a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&view=step_muDelete&idx=<?=$out_row['hero_idx']?>&hero_code=<?=$list_01['hero_code']?>">[삭제]</a>
                                        <? if($_SERVER['REMOTE_ADDR'] == '121.167.104.240'){?>
                                            <a onclick="muDelete('<?=$_GET['board']?>','<?=$out_row['hero_idx']?>', '<?=$list_01['hero_code']?>')" class="content_btn">(뮤)체험단 신청 취소하기</a>
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
            <a href="<?=PATH_HOME.'?'.get('view||idx')?>"><img src="../image/bbs/btn_list.gif" alt="목록" /></a>
        </div> -->
    </div>
</div>


	<!-- 선정자 팝업 -->
	<!-- <div id="pick_popup" class="guide_popup" style="display:none">
		<div class="inner rel">
			<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
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

		// 신청자 확인 팝업
		$('.pop_btn').click(function(){
			$(".popup").show();
		});

		$('.btn_x').click(function(){
			$(".popup").hide();
		});
	});

    function muDelete(board, idx, hero_code){
        if(confirm('체험단을 취소하시겠습니까?')){
            location.href='<?=PATH_HOME?>?board='+board+'&view=step_muDelete&idx='+idx+'&hero_code='+hero_code
        }
    }
</script>
