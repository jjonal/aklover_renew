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
    <title>�ְ� �������� AK Lover</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?=OLDSET;?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="�ְ� �������� AK Lover" />
    <meta property="og:title" content="�ְ� �������� AK Lover" />
    <meta property="og:image" content="http://aklover.co.kr/image2/main/og_logo.png" />
    <meta property="og:description" content="�ְ��� �پ��� ��ǰ ü�� �� ��,�������� Ȱ���� ���� �ְ�� �Բ� �����ϰ� �����ϴ� ��������" />
    <meta property="og:url" content="http://www.aklover.co.kr" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:title" content="�ְ� �������� AK Lover">
    <meta name="twitter:description" content="�ְ��� �پ��� ��ǰ ü�� �� ��,�������� Ȱ���� ���� �ְ�� �Բ� �����ϰ� �����ϴ� ��������">
    <meta name="twitter:image" content="http://aklover.co.kr/image2/main/ak_logo.png" />
    <meta name="keywords" content="�ְ� ��������, AK Lover, �ְ� ����, ��ǰ ü��, ������" />
    <!-- (s)naver �˻�2 -->
    <meta name="description" content="�ְ��� �پ��� ��ǰ ü�� �� ��,�������� Ȱ���� ���� �ְ�� �Բ� �����ϰ� �����ϴ� ��������" />
    <meta name="naver-site-verification" content="03e7f2508aa20e17b08700d83cff61c3759bfe32"/>
    <!-- (e)naver �˻�2 -->

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

    <!--����+�������� page load css-->
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

    <!--����+�������� page load js-->
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
        // kakaoPixel('7681562391060134443').pageView('��������ű�ȸ���̺�Ʈ');
    </script>
    <!-- ������ �ӵ� �̽��� layout.css�� �ڵ����� -->
    <!-- <link rel="stylesheet" type="text/css" href="/css/front/responsive.css" /> -->
    <!-- ���̹� ����Ʈ ���� ���� �ڵ� -->     
    <meta name="naver-site-verification"content="8761424d2569086826b5af905e6da56ec64ccf69"/>
</head>
<body>
<!-- Ŀ���� Ŀ�� -->
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
                            <a href="/main/index.php?board=group_04_01">AK Lover �Ұ�</a>
                            <ul class="depth2">
                                <li><a href="/main/index.php?board=group_04_01">AK Lover ��?</a></li>
                                <li class="depth3_tit on">AK Lover �̿�鼭</li>
                                <div class="depth3 on">
                                    <a href="/main/guide_aklover.php">Ȩ������</a>
                                    <a href="/main/beauty_life_aklover.php">��������</a>
                                </div>
                            </ul>
                        </li>
                        <li class="depth1">
                            <a href="/main/index.php?board=group_04_05">��������</a>
                            <ul class="depth2">                                
                                <li class="depth3_tit on">�����̾� ��������</li>
                                <div class="depth3 on">
                                    <a href="/main/index.php?board=group_04_06">�����̾� ��Ƽ Ŭ��</a>
                                    <a href="/main/index.php?board=group_04_28">�����̾� ������ Ŭ��</a>
                                </div>
                                <li class="depth3_tit on" style="margin-top: 1.5rem;">������ ��������</li>
                                <div class="depth3 on">
                                    <a href="/main/index.php?board=group_04_05">������ ��Ƽ&������ Ŭ��</a>
                                </div>
                            </ul>
                        </li>
                        <li class="depth1">
                            <a href="/main/index.php?board=group_04_10">������</a>
                            <ul class="depth2">
                                <li><a href="/main/index.php?board=group_04_10">��� ������</a></li>
                                <li><a href="/main/index.php?board=group_04_09">��ü ������</a></li>
                                <li><a href="/main/index.php?board=group_04_22">���� ������</a></li>
                            </ul>
                        </li>
                        <li class="depth1">
                            <a href="/main/index.php?board=group_02_03">�̺�Ʈ</a>
                            <ul class="depth2">
                                <li><a href="/main/index.php?board=group_02_03">�̴��� �̺�Ʈ</a></li>
                                <li><a href="/main/index.php?board=group_04_21">����Ʈ �佺Ƽ��</a></li>
                                <li><a href="/main/index.php?board=group_04_04">�⼮üũ</a></li>
                                <!-- <li><a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487">�⼮üũ</a></li> -->
                            </ul>
                        </li>
                        <li class="depth1">
                            <a href="/main/index.php?board=group_02_02">Ŀ�´�Ƽ</a>
                            <ul class="depth2">
                                <li><a href="/main/index.php?board=group_02_02">Lover ��</a></li>
                                <!-- <li><a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487">Lover ��</a></li> -->
                                <li><a href="/main/media.php">�̵�� �ҽ�</a></li>
                            </ul>
                        </li>
                        <li class="depth1">
                            <a href="/main/index.php?board=group_04_03">������</a>
                            <ul class="depth2">
                                <li><a href="/main/index.php?board=group_04_03">��������</a></li>
                                <li><a href="/main/index.php?board=group_04_33">FAQ</a></li>
                                <li><a href="/main/index.php?board=group_04_35&view_type=list">1:1����</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="pan"></div>
                </div>
                <div class="right">
                    <div class="sh">
                        <button type="button" class="searchBtn">
                            <img src="/img/front/main/hd_search_icon.webp" alt="�˻���ư" class="sh_white">
                            <img src="/img/front/main/hd_search_active.webp" alt="�˻���ư" class="sh_black">
                            <img src="/img/front/main/head_x.webp" alt="�˻��ݱ�" class="sh_close">
                        </button>
                    </div>
                    <!-- <a href="/main/index.php?board=group_04_03" class="cs_btn">������</a> -->
                    <? if($_SESSION['temp_code']=='' && !$_SESSION["global_code"]){?>   <!-- ��α��� -->
                    <? }else{ ?> 
                        <div class="notice_wrap">
                            <!--�������� ������ �߰� ����-->
                            <?
                            //���� �˻�
                            $mail_sql = 'SELECT A.* FROM mail A 
                                            LEFT JOIN member B ON A.hero_code = B.hero_code 
                                            LEFT JOIN level C ON B.hero_level = C.hero_level
                                            WHERE A.hero_table=\'mail\' 
                                            AND 
                                            ((A.hero_user=\'all\' AND A.hero_today > B.hero_oldday) 
                                            OR CONCAT(\'||\', A.hero_user, \'||\') LIKE \'%||'.$_SESSION['temp_id'].'||%\')
                                            ORDER BY A.hero_today DESC;';
                            sql($mail_sql);
                            //�������� ���� ����
                            $mail_count = 0;

                            while($list = @mysql_fetch_assoc($out_sql)) {
                                //��Ȯ�� ���� Ȯ�� ���� /board/mail/list.php ����
                                $view_search_id = "," . $_SESSION['temp_id'] . ",";
                                $view_user_check_id = str_replace("||", ",", $list['hero_user_check']);
                                $view_user_check_id = "," . $view_user_check_id . ",";

                                if (strcmp(eregi($view_search_id, $view_user_check_id), '1')) {
                                    $mail_count++; //��Ȯ�� ����
                                }
                            }
                            ?>
                            <!--�������� ������ �߰� ��-->
                            <a href="/main/index.php?board=mail" target="_blank" class="alarm_bx ic_alarm fz17 fw600">
                                �˸�<span class="f_c alarm_count"><?=$mail_count?></span>
                            </a>
                        </div>
                    <? }?>
                    <div class="mem_btn">
                        <? if($_SESSION['temp_code']=='' && !$_SESSION["global_code"]){?>   <!-- ��α��� -->
                            <a href="/main/index.php?board=login">�α���</a>
                        <? }else{ ?>   <!-- �α��� -->
                            <div class="family_wrap select_shadow">
                                <div class="select_tit en">
                                    <div class="f_cs">
                                        <div class="alarm_bx">
                                            <?
                                            $profile_sql = "select hero_profile from member where hero_code = '".$_SESSION['temp_code'] ."'";
                                            $out_profile_sql = mysql_query($profile_sql) or die("<script>alert('�ý��� �����Դϴ�. �ٽ� �õ����ּ���. �����ڵ� : VIEW_02');location.href='/main/index.php'</script>");

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
                                            <span class="fz17 fw600 nick"><?=$_SESSION['temp_nick']?> ��</span>
                                        <? } else if($_SESSION["global_nick"]) { ?>
                                            <span class="fz17 fw600 nick"><?=$_SESSION['global_nick']?> ��</span>
                                        <? } ?>
                                    </div>
                                </div>
                                <!-- ���� -->
                                <ol class="select_drop family_box">
                                    <li><a href="/main/index.php?board=mission" target="_blank">����������</a></li>
                                    <li><a href="<?=PATH_END?>out.php">�α׾ƿ�</a></li>
                                </ol>
                            </div>
                        <? }?>
                    </div>
                </div>
                <div class="search_wrap topSearchbox"><!-- �˻��ڽ� -->
                    <div class="f_c">
                        <form action="<?=PATH_HOME?>?board=search" method="post">
                            <input class="stext" name='kewyword' type="text" value="<?=stripslashes($_REQUEST['kewyword'])?>" placeholder="�˻�� �Է��ϼ���." />
                            <input onMouseDown="eval('try{ _trk_clickTrace( \'EVT\', \'��� �˻�\' ); }catch(_e){ }');" class="sbtn" type="image" src="/img/front/main/hd_search_active.webp" />
                        </form>
                        <div class="sh_hash f_cs">
                                <span class="fz14 fw500 tit">��õ�˻���</span>
                                <ul class="f_cs">
                                    <li>#��������</li>
                                    <li>#�糪</li>
                                    <li>#���ַ̼��</li>
                                    <li>#����Ʈ��</li>
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