<?php
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
/* 170208 추가 캐쉬삭제 */
/* 추후 해당코드 삭제 */

//header("Pragma: no-cache");
//header("Cache-Control: no-store, no-cache, must-revalidate"); 

/////////////////////////////////////
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        '../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';
if (!$_SESSION["temp_code"] && isset($_COOKIE["ak_cookie_01"]) && isset($_COOKIE["ak_cookie_02"])) {
	location("/m/login_check.php");
}
?>
<!DOCTYPE html>
<head>
<meta charset="EUC-KR">
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>-->
<!-- <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" /> -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, viewport-fit=cover">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>애경 서포터즈 AK Lover</title>
<meta property="og:type" content="website" />
<meta property="og:site_name" content="애경 서포터즈 AK Lover" />
<meta property="og:title" content="애경 서포터즈 AK Lover" />
<meta property="og:image" content="http://aklover.co.kr/image2/main/og_logo.png" />
<meta property="og:description" content="애경의 다양한 제품 체험 후 온,오프라인 활동을 통해 애경과 함께 생각하고 소통하는 서포터즈" />
<meta property="og:url" content="http://www.aklover.co.kr" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="애경 서포터즈 AK Lover">
<meta name="twitter:description" content="애경의 다양한 제품 체험 후 온,오프라인 활동을 통해 애경과 함께 생각하고 소통하는 서포터즈">
<meta name="twitter:image" content="http://aklover.co.kr/image2/main/ak_logo.png" />
<meta name="keywords" content="애경 서포터즈, AK Lover, 애경 러버, 제품 체험, 러버퀸" />
<!-- (s)naver 검색2 -->
<meta name="description" content="애경의 다양한 제품 체험 후 온,오프라인 활동을 통해 애경과 함께 생각하고 소통하는 서포터즈" />
<!-- <meta name="naver-site-verification" content="03e7f2508aa20e17b08700d83cff61c3759bfe32"/> -->
<!-- (e)naver 검색2 -->

<link rel="shortcut icon" href="/image2/etc/favicon.ico" type="image/x-icon">
<link rel="icon" href="/image2/etc/favicon.ico" type="image/x-icon">
<link rel="canonical" href="http://www.aklover.co.kr/index.php">


<!-- <link rel="stylesheet" type="text/css" href="css/main.css?version=<?=date("YmdHis")?>" > -->
<!-- <link rel="stylesheet" type="text/css" href="css/sub.css?version=<?=date("YmdHis")?>" > -->
<link rel="stylesheet" type="text/css" href="/css/swiper.min.css" >
<!-- <link rel="stylesheet" type="text/css" href="/m/jquery.mb/css/mbExtruder.css" media="all" >
<link rel="stylesheet" type="text/css" href="/m/css/bootstrap.min.css" media="screen" title="no title" charset="euc-kr"> -->

<!-- musign -->
<!-- <link rel="stylesheet" type="text/css" href="/css/front/responsive.css" /> -->
<link rel="stylesheet" type="text/css" href="/css/front/reset.css" />
<link rel="stylesheet" type="text/css" href="/css/front/musign.css" />
<link rel="stylesheet" type="text/css" href="/css/front/library/swiper-bundle.css" />
<link rel="stylesheet" type="text/css" href="/m/css/musign/layout.css" />
<!-- //musign -->


<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="/js/common.js?version=210923"></script>
<script type="text/javascript" src="/js/head.js?version=007"></script>
<script language="javascript" type="text/javascript" src="/m/js/bootstrap.min.js"></script>
<script src="doubletaptogo.min.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="/m/js/clipboard.min.js"></script>


<script type="text/javascript" src="/m/jquery.mb/inc/jquery.hoverIntent.min.js"></script>
<script type="text/javascript" src="/m/jquery.mb/inc/jquery.mb.flipText.js"></script>
<script type="text/javascript" src="/m/jquery.mb/inc/mbExtruder.js"></script>
<script type="text/javascript" src="/js/jquery.cookie.js" ></script>

<!-- musign -->
 <script type="text/javascript" src="/js/musign/library/gsap.js"></script>
<script type="text/javascript" src="/m/js/musign/musign.js"></script>
<script type="text/javascript" src="/js/musign/library/swiper-bundle.min.js"></script>
<!-- // musign -->

<script type="text/javascript" src="https://static.nid.naver.com/js/naverLogin_implicit-1.0.3.js" charset="utf-8"></script>
<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<script type="text/javascript" src="/m/js/mobile_snsInit.js?v=230427"></script>


<script type="text/javascript" charset="UTF-8" src="//t1.daumcdn.net/adfit/static/kp.js"></script>
<script type="text/javascript">
	kakaoPixel('7681562391060134443').pageView('서포터즈신규회원이벤트');
</script>
</head>
<body>
<?
/* Left Menu Query (s) */

//이전에 사용하던 쿼리$sql = 'select * from hero_group where hero_menu=\'0\' and hero_use=\'1\' and hero_group!=hero_board order by hero_point,hero_group, hero_order';//desc//asc

$sql = "SELECT A.* , B.hero_table, B.hero_03 FROM hero_group AS A LEFT OUTER JOIN (SELECT hero_table, hero_03 FROM board WHERE LEFT(hero_today, 10 ) = '".date("Y-m-d")."' and hero_use=1 GROUP BY hero_03 ORDER BY hero_03) AS B ON A.hero_board = B.hero_03 ";
$sql .= "where hero_menu='0' and hero_use='1' order by A.hero_group,A.hero_order,A.hero_point";
sql($sql,"on");

$total_data = @mysql_num_rows($out_sql);
$group = '';
$count_i = '0';
$i = 0;
$total_i = $total_data-1;
$ii=0;



$menu_top = array("두드리다(체험단/이벤트)","나누다(공지/커뮤니티)","물들다(후기/활동)","만나다(소개/문의)");

$links = array("group_01_01"=>"board_00.php",
				"group_01_02"=>"board_00.php",
				"group_01_03"=>"board_00.php",
				"group_01_04"=>"board_00.php",
				"group_04_11"=>"today.php",

				"group_02_01"=>"today.php",
				"group_02_02"=>"today.php",
				"group_03_04"=>"today.php",
				"group_03_05"=>"today.php",
				"group_02_05"=>"today.php",
				"group_02_06"=>"today.php",
				"group_04_24"=>"today.php",

				"group_04_01"=>"aklover.php",
				"group_04_02"=>"aklover.php",
				"group_05_01"=>"ranking.php",
				"group_03_01"=>"aklover.php",
				"group_03_03"=>"today.php",

				"group_04_03"=>"today.php",
				"group_04_04"=>"check.php",
				"group_02_03"=>"board_00.php",
				"group_04_05"=>"mission.php",
				"group_04_06"=>"mission.php",
				"group_04_07"=>"mission.php",
				"group_04_08"=>"mission.php",
				"group_04_09"=>"board_01.php",
				"group_04_10"=>"board_02.php",
				"group_04_13"=>"truly.php",
				"group_04_14"=>"experienceType.php",
				"group_04_15"=>"aklover.php",
				"group_04_16"=>"history.php",
				"group_04_20"=>"today.php",
				"group_04_21"=>"order.php",
				"group_04_22"=>"meeting_list.php",
				"group_04_23"=>"mission.php",
				"group_04_25"=>"mission.php",
				"group_04_26"=>"today.php",
				"group_04_27"=>"mission.php",
				"group_04_28"=>"mission.php",
				"cus_2"=>"faq.php",
				"cus_3"=>"customer.php",
				"group_04_29"=>"loyalAkLover.php",
                "group_04_32"=>"use_guide.php"


			);
/* Left Menu Query (e) */
?>

	<!-- Left menu (s) -->
    <div id="sideMenu">
    	<div class="side_inner">
			<div class="m_sideMenu_close">
				<a href="#" class="sideMenu_close"><img src="/m/img/musign/main/ham_close.webp" width="100%" /></a>
			</div>
			<? if($_SESSION['temp_code']=='' && !$_SESSION["global_code"]){?>   <!-- 비로그인 -->
               <a href="/m/login.php" class="login_btn"><img src="/m/img/musign/main/logo_wh.webp" alt="로그인 버튼" class="profile">로그인이 필요합니다.</a>
          	<? }else{ ?>   <!-- 로그인 -->
				<?
					$user_total_sql = 'select SUM(hero_point) as today_user_total from point where hero_code=\''.$_SESSION['temp_code'].'\';';
					$out_user_total_sql = @mysql_query($user_total_sql);
					$today_total_list   = @mysql_fetch_assoc($out_user_total_sql);
					$today_total = $today_total_list['today_user_total'];//당일 획득 포인트

					$member_sql = 'select * from member where hero_id=\''.$_SESSION['temp_id'].'\';';
					$out_member_sql = mysql_query($member_sql);
					$member_list = @mysql_fetch_assoc($out_member_sql);

					$level_sql = 'select * from level where hero_level=\''.$member_list['hero_level'].'\';';
					$out_level_sql = mysql_query($level_sql);
					$level_list  = @mysql_fetch_assoc($out_level_sql);

					$attendance_rs = 0;
					if($_SESSION ["temp_code"]){
						$attendance_sql = "select count(*) from point where hero_table='group_04_04' and left(hero_today,10)='" . date ( "Y-m-d" ) . "' and hero_code='" . $_SESSION ["temp_code"] . "'";
						$attendance_res = sql($attendance_sql);
						$attendance_rs = mysql_result ($attendance_res, 0, 0);
					}
				?>
				<div class="my_info">
					<div class="profile_top rel">
						<div class="f_cs">
                            <?
                            $profile_sql = "select hero_profile from member where hero_code = '".$_SESSION['temp_code'] ."'";
                            $out_profile_sql = mysql_query($profile_sql) or die("<script>alert('시스템 에러입니다. 다시 시도해주세요. 에러코드 : VIEW_02');location.href='/main/index.php'</script>");

                            $profile_row                             = mysql_fetch_assoc($out_profile_sql);

                            if(empty($profile_row['hero_profile'])){
                                $hero_profile = "/img/front/mypage/defalt.webp";
                            }else {
                                $hero_profile = $profile_row['hero_profile'];
                            }
                            ?>
							<a href="/m/mypage.php"><img src="<?=$hero_profile?>" alt="프로필 이미지" class="profile"></a>
							<div>
                                <?
                                #회원긍급
                                #뷰티
                                $beauty_sql = "select count(*) from member_gisu where hero_board = 'group_04_06' and hero_code = '".$_SESSION['temp_code']."' and gisu = (select max(gisu) from member_gisu where hero_board = 'group_04_06')";
                                $count_beauty = sql($beauty_sql);
                                $total_beauty = mysql_result($count_beauty,0,0);

                                #라이프
                                $list_sql   = "select count(*) from member_gisu where hero_board = 'group_04_28' and hero_code = '".$_SESSION['temp_code']."' and gisu = (select max(gisu) from member_gisu where hero_board = 'group_04_28')";
                                $count_list   = sql($list_sql);
                                $total_list   = mysql_result($count_list,0,0);

                                $hero_level = "";
                                $hero_icon = "";
//                                if ($total_beauty > 0){
//                                    $hero_level = "뷰티 프리미어";
//                                    $hero_icon = '<img src="/img/front/icon/my_icon_beauty.png" style="width: 1.3rem;" alt="프리미어 뷰티 등급">';
//                                }else if ($total_list > 0){
//                                    $hero_level = "라이프 프리미어";
//                                    $hero_icon = '<img src="/img/front/icon/my_icon_life.png" style="width: 1.3rem;" alt="프리미어 라이프 등급">';
//                                }else {
//                                    $hero_level = "베이직";
//                                    $hero_icon = '<img src="/img/front/icon/my_icon.png" style="width: 2.5rem;" alt="베이직 등급">';
//                                }
								//250318 기존 member level 노출로 변경
								if ($member_list['hero_level'] == 9996){
									$hero_level = "프리미어 뷰티";
									$hero_icon = '<img src="/img/front/icon/my_icon_beauty.png" style="width: 1.3rem;" alt="프리미어 뷰티 등급">';
								}else if ($member_list['hero_level'] == 9994){
									$hero_level = "프리미어 라이프";
									$hero_icon = '<img src="/img/front/icon/my_icon_life.png" style="width: 1.3rem;" alt="프리미어 라이프 등급">';
								}else {
									$hero_level = "베이직 서포터즈 ";
									$hero_icon = '<img src="/img/front/icon/my_icon.png" style="width: 2.5rem;" alt="베이직 등급">';
								}
                                ?>
<!--								<p class="grade">--><?php //=$level_list['hero_name']?><!-- 등급</p>-->
								<p class="grade"><?=$hero_level?></p>
								<p>
									<? if($_SESSION["temp_nick"]) { ?>
										<span class="fz17 fw600 nick"><?=$_SESSION['temp_nick']?> 님, 반가워요!</span>
									<? } else if($_SESSION["global_nick"]) { ?>
										<span class="fz17 fw600 nick"><?=$_SESSION['global_nick']?> 님, 반가워요!</span>
									<? } ?>
								</p>
							</div>
						</div>
						<a href="<?=PATH_END?>out.php" class="logout">로그아웃</a>
					</div>
					<div class="profile_desc">
						<?
						// myponint 호출
						$user_total_sql = "select total_user_point, total_use_point, C.superpass_use, D.superpass_sum from ";
						$user_total_sql .= "(select hero_code, sum(hero_point) as total_user_point from point where hero_code='".$_SESSION['temp_code']."') as A, ";
						$user_total_sql .= "(select SUM(hero_order_point) as total_use_point from order_main where hero_code='".$_SESSION['temp_code']."' and hero_process!='".$_PROCESS_CANCEL."') as B, ";
						$user_total_sql .= "(select count(*) as superpass_use from mission_review where hero_superpass='Y' and hero_code='".$_SESSION['temp_code']."' and hero_today <= '".date("Y-m-t")."' and hero_today >= '".date("Y-m-01")."') as C, ";
						$user_total_sql .= "(select count(*) as superpass_sum from superpass where hero_code='".$_SESSION['temp_code']."' and hero_use_yn = 'N' and hero_endday > date_format(now(),'%Y-%m-%d 00:00:00')) as D"; //12월7일 시행
						//echo $user_total_sql;

						$out_user_total_sql = @mysql_query($user_total_sql);
						$today_total_list = @mysql_fetch_assoc($out_user_total_sql);

						// 유효 point 변수 추가
						if($today_total=='') $today_total = 0;
						$today_use_total = $today_total_list['total_user_point']-$today_total_list['total_use_point'];

						$superpass_ea = $today_total_list['superpass_sum'];
						?>
						<ul class="flex">
							<li>
								<div class="tit"><img src="/m/img/musign/main/point.webp" alt="포인트 아이콘">포인트</div>
								<div class="fz32 fw600 num_bx"><?=number_format($today_use_total)?><span class="min_txt">P</span></div>
							</li>
							<li>
								<div class="tit"><img src="/m/img/musign/main/pass.webp" alt="슈퍼패스 아이콘">슈퍼패스</div>
								<div class="fz32 fw600 num_bx">
									<? if($superpass_ea>0){ ?>
										<strong>사용가능</strong>
									<? }else{?>
										<strong>사용불가</strong>
									<? }?></div>
							</li>
						</ul>
					</div>
				</div>
			<? }?>
			<div>
				<ul class="menu_bx">
					<li class="depth1">
						<span>AK Lover 소개</span>
						<ul class="depth2">
							<li><a href="/m/guide_1.php">AK Lover 란?</a></li>
							<li><a href="/m/guide_aklover.php">AK Lover 이용백서</a></li>
							<li class="depth3"><a href="/m/guide_aklover.php">홈페이지</a></li>
							<li class="depth3"><a href="/m/beauty_life_aklover.php">서포터즈</a></li>
						</ul>
					</li>
					<li class="depth1">
						<span>서포터즈</span>
						<ul class="depth2">
							<li><a href="/m/mission.php?board=group_04_06">프리미어 서포터즈</a></li>
							<li class="depth3"><a href="/m/mission.php?board=group_04_06">프리미어 뷰티 서포터즈</a></li>
							<li class="depth3"><a href="/m/mission.php?board=group_04_28">프리미어 라이프 서포터즈</a></li>
							<li><a href="/m/mission.php?board=group_04_05">베이직 서포터즈</a></li>
							<li class="depth3"><a href="/m/mission.php?board=group_04_05">베이직 뷰티&라이프 서포터즈</a></li>
						</ul>
					</li>
					<li class="depth1">
						<span>콘텐츠</span>
						<ul class="depth2">
							<li><a href="/m/board_02.php?board=group_04_10">우수 콘텐츠</a></li>
							<li><a href="/m/board_01.php?board=group_04_09">전체 콘텐츠</a></li>
							<li><a href="/m/meeting_list.php?board=group_04_22">모임 콘텐츠</a></li>
						</ul>
					</li>
					<li class="depth1">
						<span>이벤트</span>
						<ul class="depth2">
							<li><a href="/m/board_00.php?board=group_02_03">이달의 이벤트</a></li>
							<li><a href="/m/order.php?board=group_04_21">포인트 페스티벌</a></li>
							<li><a href="/m/check.php?board=group_04_04">출석체크</a></li>
						</ul>
					</li>
					<li class="depth1">
						<span>커뮤니티</span>
						<ul class="depth2">
							<li><a href="/m/today.php?board=group_02_02">Lover 톡</a></li>
							<!-- <li><a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29">Lover 톡</a></li> -->
							<li><a href="/m/media.php">미디어 소식</a></li>
						</ul>
					</li>
					<!-- 250314 햄버거 메뉴 변경 -->
					<li class="depth1">
						<span>고객센터</span>
						<ul class="depth2">
							<li><a href="/m/today.php?board=group_04_03">공지사항</a></li>
							<li><a href="/m/faq.php?board=cus_2">FAQ</a></li>
							<li><a href="/m/customer.php?board=cus_3&view_type=list">1대1문의</a></li>
						</ul>
					</li>
					<!-- <li>
						<a href="/m/mypage.php" class="depth1"><span>마이페이지</span></a>
					</li> -->
				</ul>
			</div>
			<div class="add_info">
				<!-- <a href="/m/today.php?board=group_04_03" class="cscenter">고객센터</a> -->
				<a href="/m/mypage.php" class="cscenter">마이페이지</a>
				<div class="snsWrap">
					<a href="https://www.instagram.com/aekyunglover/" target="_blank"><img src="/m/img/musign/main/insta.webp" alt="인스타 바로가기" style="width: 14px;"/></a>
					<a href="https://pf.kakao.com/_Yxmxhxnj" target="_blank"><img src="/m/img/musign/main/kakao.webp" alt="카카오 바로가기" style="width: 14px;"/></a>
					<a href="https://www.youtube.com/channel/UCF6gntNnqRLnr-EIrOUZvVg" target="_blank"><img src="/m/img/musign/main/youtube.webp" alt="유튜브 바로가기" style="width: 17px;" /></a>
				</div>
			</div>
		</div>
    </div>
    <div class="open_white_bg"></div>
    <!-- Left Menu (e) -->

    <!-- Content (s) -->
    <div id="left_wrap">
        <div id="m_header">
			<div class="hd_inner f_b">
				<div class="logo">
					<a href="/m/main.php"><img src="/img/front/main/header_logo.png" alt="AKLOVER 로고"/></a>
				</div>
				<div class="f_c">
					<div class="search">
						<img src="/m/img/musign/main/search.webp" alt="검색열기" class="sh_open sub"/>
						<img src="/m/img/musign/main/search_wh.webp" alt="검색열기" class="sh_open dis-no main">
						<img src="/img/front/main/head_x.webp" alt="검색닫기" class="dis-no sh_close">
					</div>
					<div class="m_menu">
						<img src="/m/img/musign/main/hamberger.webp" alt="메뉴열기" class="sub" />
						<img src="/m/img/musign/main/hamberger_wh.webp" alt="메뉴열기" class="dis-no main"/>
					</div>
				</div>
			</div>
			<div class="search_wrap topSearchbox"><!-- 검색박스 -->
				<div class="f_c">
					<form action="/m/search_list.php?board=search_result" method="post">
						<input class="stext" name='kewyword' type="text" value='<?=stripslashes($_POST['kewyword'])?>' placeholder="검색어를 입력하세요." />
						<input onMouseDown="eval('try{ _trk_clickTrace( \'EVT\', \'상단 검색\' ); }catch(_e){ }');" class="sbtn" type="image" src="/m/img/musign/main/search.webp" />
					</form>
					<div class="sh_hash f_cs">
							<span class="fz24 fw500 tit">추천검색어</span>
							<ul class="f_cs">
								<li>#AK Lover</li>
								<li>#루나</li>
								<li>#에이솔루션</li>
								<li>#포인트앤</li>
							</ul>
						</div>
				</div>
			</div>
        </div>
		<div id="wrap">

		<div class="dim" style="display: none;"></div>