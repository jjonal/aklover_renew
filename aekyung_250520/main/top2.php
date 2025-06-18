<!DOCTYPE html>
<?
if(!defined( '_HEROBOARD_' )) exit ();

if ((! strcmp ( $_GET ['hero'], '' )) and (! strcmp ( $_GET ['path'], '' )) and (! strcmp ( $_GET ['board'], '' )) and (! strcmp ( $_GET ['root'], '' )) and (! strcmp ( $_GET ['admin'], '' ))) {
    $wrap_class = 'main';
} else {
    $wrap_class = 'sub';
}

if ($_REQUEST ["hero_idx"]) {
    $sql = "select A.*, B.hero_title as group_title from board as A right outer join hero_group as B on A.hero_idx='" . $_GET ['hero_idx'] . "' where B.hero_group='home' and B.hero_idx=1;";
} else {
    $sql = "select A.*, B.hero_title as group_title from board as A right outer join hero_group as B on A.hero_idx='" . $_GET ['idx'] . "' where B.hero_group='home' and B.hero_idx=1;";
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

unset($_COOKIE['logging_pw']);
unset($_COOKIE['member_login_event']);
unset($_COOKIE['member_login_event_02']);

$sql = out ( $sql );
sql ( $sql, 'on' );
?>
<html>
<head>
    <title>애경 서포터즈 AK Lover</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?=OLDSET;?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
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
    <meta name="naver-site-verification" content="03e7f2508aa20e17b08700d83cff61c3759bfe32"/>
    <!-- (e)naver 검색2 -->

    <link rel="shortcut icon" href="/image2/etc/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/image2/etc/favicon.ico" type="image/x-icon">
    <link rel="canonical" href="http://www.aklover.co.kr/index.php">

    <!-- musign -->
    <link rel="stylesheet" type="text/css" href="/css/front/reset.css" />
    <link rel="stylesheet" type="text/css" href="/css/front/musign.css" />
    <link rel="stylesheet" type="text/css" href="/css/front/layout.css" />
    <!-- // musign -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/main.css?v=220616" /> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/guide.css" /> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/activity.css" /> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/mission2.css?v=230322" /> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/story.css?v=230504" /> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/member.css?v=210517" /> -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/thumb.css" />
    <link rel="stylesheet" type="text/css" href="/css/main2.css?v=231113" /> -->
    <link rel="stylesheet" href="/css/jquery.cluetip.css" type="text/css" />

    <!--쪽지+개인정보 page load css-->
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/head.js?version=009"></script>

    <!-- musign -->
    <script type="text/javascript" src="/js/musign/musign.js"></script>
    <!-- // musign -->

    <script type="text/javascript" src="/js/common.js?v=210517"></script>
    <script type="text/javascript" src="/js/jquery.cookie.js" ></script>
    <script type="text/javascript" src="https://static.nid.naver.com/js/naverLogin_implicit-1.0.3.js" charset="utf-8"></script>
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
    <? if($_SESSION ["temp_code"] == "20274") {?>
        <script type="text/javascript" src="/js/snsInit_test.js"></script>
    <? } else { ?>
        <script type="text/javascript" src="/js/snsInit.js?v=230427"></script>
    <? } ?>
    <script type="text/javascript" src="/js/authInit.js" ></script>
    <script type="text/javascript" src="/js/clipboard.min.js" ></script>

    <!--쪽지+개인정보 page load js-->
    <script src="/js/jquery.cluetip.min.js" type="text/javascript"></script>
    <!-- mainbanner -->
    <!-- <script type="text/javascript" src="/js/slick.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/slick.css">
    <link rel="stylesheet" type="text/css" href="/css/slick-theme.css">     -->

    <!-- swiper -->
    <link rel="stylesheet" type="text/css" href="/css/front/library/swiper-bundle.css" />
    <script type="text/javascript" src="/js/musign/library/swiper-bundle.min.js"></script>

    <script type="text/javascript" charset="UTF-8" src="//t1.daumcdn.net/adfit/static/kp.js"></script>
    <script type="text/javascript">
        // kakaoPixel('7681562391060134443').pageView('서포터즈신규회원이벤트');
    </script>
    <!-- 브라우저 속도 이슈로 layout.css로 코드이전 -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/front/responsive.css" /> -->
    <!-- 네이버 사이트 소유 인증 코드 -->     
    <meta name="naver-site-verification"content="8761424d2569086826b5af905e6da56ec64ccf69"/>
</head>
<body>
<!-- 커스텀 커서 -->
<div id="cursor" class="pc_version" style="left: 1906px; top: 383px;">
    <span class="fz12 bold">+ MORE</span>
</div>
<div id="wrap">
    <div class="front_header">
        <header id="header" class="top">
            <!-- class="topmn" -->
            <div class="header_wr hd_wrap">
                <div class="logo">
                    <a href="/">
                        <img src="/img/front/main/header_logo.png" alt="aklover">
                    </a>
                </div>
                <div class="mid">
                    <ul>
                        <li class="depth1">
                            <a href="/main/index.php?board=group_04_01">AK Lover 소개</a>
                            <ul class="depth2">
                                <li><a href="/main/index.php?board=group_04_01">AK Lover 란?</a></li>
                                <li class="depth3_tit on">AK Lover 이용백서</li>
                                <div class="depth3 on">
                                    <a href="/main/guide_aklover.php">홈페이지</a>
                                    <a href="/main/beauty_life_aklover.php">서포터즈</a>
                                </div>
                            </ul>
                        </li>
                        <li class="depth1">
                            <a href="/main/index.php?board=group_04_05">서포터즈</a>
                            <ul class="depth2">                                
                                <li class="depth3_tit on">프리미어 서포터즈</li>
                                <div class="depth3 on">
                                    <a href="/main/index.php?board=group_04_06">프리미어 뷰티 클럽</a>
                                    <a href="/main/index.php?board=group_04_28">프리미어 라이프 클럽</a>
                                </div>
                                <li class="depth3_tit on" style="margin-top: 1.5rem;">베이직 서포터즈</li>
                                <div class="depth3 on">
                                    <a href="/main/index.php?board=group_04_05">베이직 뷰티&라이프 클럽</a>
                                </div>
                            </ul>
                        </li>
                        <li class="depth1">
                            <a href="/main/index.php?board=group_04_10">콘텐츠</a>
                            <ul class="depth2">
                                <li><a href="/main/index.php?board=group_04_10">우수 콘텐츠</a></li>
                                <li><a href="/main/index.php?board=group_04_09">전체 콘텐츠</a></li>
                                <li><a href="/main/index.php?board=group_04_22">모임 콘텐츠</a></li>
                            </ul>
                        </li>
                        <li class="depth1">
                            <a href="/main/index.php?board=group_02_03">이벤트</a>
                            <ul class="depth2">
                                <li><a href="/main/index.php?board=group_02_03">이달의 이벤트</a></li>
                                <li><a href="/main/index.php?board=group_04_21">포인트 페스티벌</a></li>
                                <li><a href="/main/index.php?board=group_04_04">출석체크</a></li>
                                <!-- <li><a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487">출석체크</a></li> -->
                            </ul>
                        </li>
                        <li class="depth1">
                            <a href="/main/index.php?board=group_02_02">커뮤니티</a>
                            <ul class="depth2">
                                <li><a href="/main/index.php?board=group_02_02">Lover 톡</a></li>
                                <!-- <li><a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487">Lover 톡</a></li> -->
                                <li><a href="/main/media.php">미디어 소식</a></li>
                            </ul>
                        </li>
                        <li class="depth1">
                            <a href="/main/index.php?board=group_04_03">고객센터</a>
                            <ul class="depth2">
                                <li><a href="/main/index.php?board=group_04_03">공지사항</a></li>
                                <li><a href="/main/index.php?board=group_04_33">FAQ</a></li>
                                <li><a href="/main/index.php?board=group_04_35&view_type=list">1:1문의</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="pan"></div>
                </div>
                <div class="right">
                    <div class="sh">
                        <button type="button" class="searchBtn">
                            <img src="/img/front/main/hd_search_icon.webp" alt="검색버튼" class="sh_white">
                            <img src="/img/front/main/hd_search_active.webp" alt="검색버튼" class="sh_black">
                            <img src="/img/front/main/head_x.webp" alt="검색닫기" class="sh_close">
                        </button>
                    </div>
                    <!-- <a href="/main/index.php?board=group_04_03" class="cs_btn">고객센터</a> -->
                    <? if($_SESSION['temp_code']=='' && !$_SESSION["global_code"]){?>   <!-- 비로그인 -->
                    <? }else{ ?> 
                        <div class="notice_wrap">
                            <!--쪽지개수 뮤자인 추가 시작-->
                            <?
                            //쪽지 검색
                            $mail_sql = 'SELECT A.* FROM mail A 
                                            LEFT JOIN member B ON A.hero_code = B.hero_code 
                                            LEFT JOIN level C ON B.hero_level = C.hero_level
                                            WHERE A.hero_table=\'mail\' 
                                            AND 
                                            ((A.hero_user=\'all\' AND A.hero_today > B.hero_oldday) 
                                            OR CONCAT(\'||\', A.hero_user, \'||\') LIKE \'%||'.$_SESSION['temp_id'].'||%\')
                                            ORDER BY A.hero_today DESC;';
                            sql($mail_sql);
                            //쪽지개수 위한 변수
                            $mail_count = 0;

                            while($list = @mysql_fetch_assoc($out_sql)) {
                                //미확인 쪽지 확인 로직 /board/mail/list.php 참고
                                $view_search_id = "," . $_SESSION['temp_id'] . ",";
                                $view_user_check_id = str_replace("||", ",", $list['hero_user_check']);
                                $view_user_check_id = "," . $view_user_check_id . ",";

                                if (strcmp(eregi($view_search_id, $view_user_check_id), '1')) {
                                    $mail_count++; //미확인 쪽지
                                }
                            }
                            ?>
                            <!--쪽지개수 뮤자인 추가 끝-->
                            <a href="/main/index.php?board=mail" target="_blank" class="alarm_bx ic_alarm fz17 fw600">
                                알림<span class="f_c alarm_count"><?=$mail_count?></span>
                            </a>
                        </div>
                    <? }?>
                    <div class="mem_btn">
                        <? if($_SESSION['temp_code']=='' && !$_SESSION["global_code"]){?>   <!-- 비로그인 -->
                            <a href="/main/index.php?board=login">로그인</a>
                        <? }else{ ?>   <!-- 로그인 -->
                            <div class="family_wrap select_shadow">
                                <div class="select_tit en">
                                    <div class="f_cs">
                                        <div class="alarm_bx">
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
                                            <img src="<?=$hero_profile?>" alt="aklover" class="profile">
                                        </div>
                                        <? if($_SESSION["temp_nick"]) { ?>
                                            <span class="fz17 fw600 nick"><?=$_SESSION['temp_nick']?> 님</span>
                                        <? } else if($_SESSION["global_nick"]) { ?>
                                            <span class="fz17 fw600 nick"><?=$_SESSION['global_nick']?> 님</span>
                                        <? } ?>
                                    </div>
                                </div>
                                <!-- 국문 -->
                                <ol class="select_drop family_box">
                                    <li><a href="/main/index.php?board=mission" target="_blank">마이페이지</a></li>
                                    <li><a href="<?=PATH_END?>out.php">로그아웃</a></li>
                                </ol>
                            </div>
                        <? }?>
                    </div>
                </div>
                <div class="search_wrap topSearchbox"><!-- 검색박스 -->
                    <div class="f_c">
                        <form action="<?=PATH_HOME?>?board=search" method="post">
                            <input class="stext" name='kewyword' type="text" value="<?=stripslashes($_REQUEST['kewyword'])?>" placeholder="검색어를 입력하세요." />
                            <input onMouseDown="eval('try{ _trk_clickTrace( \'EVT\', \'상단 검색\' ); }catch(_e){ }');" class="sbtn" type="image" src="/img/front/main/hd_search_active.webp" />
                        </form>
                        <div class="sh_hash f_cs">
                                <span class="fz14 fw500 tit">추천검색어</span>
                                <ul class="f_cs">
                                    <li>#에이지투</li>
                                    <li>#루나</li>
                                    <li>#에이솔루션</li>
                                    <li>#포인트앤</li>
                                </ul>
                            </div>
                    </div>
                </div>
                <!-- class="gnb" -->
            </div>
        </header>
    </div>
    <!-- header -->
    <div class="top_btn_wrap scroll_btn_wrap f_c show">
        <button class="scroll_btn"></button>
    </div>

<div class="front_container">
        <main id="container">