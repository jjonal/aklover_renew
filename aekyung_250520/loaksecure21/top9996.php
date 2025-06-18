<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$hero_table = 'menu';
$sql = 'select * from hero_group where hero_idx=\'1\';';//desc
sql($sql, 'on');
$list                             = @mysql_fetch_assoc($out_sql);
$hero_alt = explode('||', $list['hero_title']);
######################################################################################################################################################
$board = "global";
$idx = "127";
$main_title = "글로벌클럽";
?>
<html lang="ko">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?=OLDSET?>" />
<title><?=$hero_alt['0'];?></title>
<meta name="keywords" content="<?=$hero_alt['1'];?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" type="text/css" href="/css/general.css"/>
<link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/admin_login.css?v=210517" />
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/admin.css?v=210517" type="text/css" />
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/jquery-ui.css">
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/head.js"></script>
<script type="text/javascript" src="<?=ADMIN_DEFAULT?>/js/admin.js"></script>
<script type="text/javascript" src="<?=ADMIN_DEFAULT?>/js/jquery.form.js"></script>
<script src="<?=ADMIN_DEFAULT?>/js/jquery-ui.js"></script>
<!--[if IE]><script src="js/html5.js"></script><![endif]-->
</head>
<body>
<!-- (s) header -->
<header>
	<article>
		<h1><a href="<?=PATH_HOME;?>"><img src="<?=PATH_IMAGE_END?>logo_admin.png" alt="ADMINISTRATOR" /></a></h1>
		<p><strong><?=$_SESSION['temp_nick'];?></strong>님 환영합니다.</p>
		<ul>
			<li class="current"><a href="<?=MAIN_HOME;?>" target="_blank">HomePage</a> <span>l</span> </li>
			<li class="current"><a href="<?=DOMAIN_END;?>m" target="_blank">MobilePage</a> <span>l</span> </li>
			<li><a href="<?=PATH_END;?>out.php">Logout</a></li>
		</ul>
	</article>
</header>

    <section id="container">
        <div class="container_inner">
            <aside>
                <h2>글로벌클럽</h2>
                <nav class="nav">
                    <ul class="left_menu">
                         <li class="current">
                            <a href="/loaksecure21/index.php?board=global&idx=128">글로벌 1:1문의</a>
                        </li>
                    </ul>
                </nav>
            </aside>
            <section id="content">
