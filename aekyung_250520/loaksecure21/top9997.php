<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$hero_table = 'menu';
$sql = 'select * from hero_group where hero_idx=\'1\';';//desc
sql($sql, 'on');
$list                             = @mysql_fetch_assoc($out_sql);
$hero_alt = explode('||', $list['hero_title']);
######################################################################################################################################################
?>
<!doctype html>
<html lang="ko">
<head>
    <meta http-equiv="content-type" content="text/html; charset=<?=OLDSET?>" />
    <title><?=$hero_alt['0'];?></title>
    <meta name="keywords" content="<?=$hero_alt['1'];?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="/css/general.css"/>
    <link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/admin_login.css" />
    <link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/admin.css" type="text/css" />
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
    <script type="text/javascript" src="/js/head.js"></script>
    <style>
        .png24{
           tmp:expression(setPng24(this));
        }
    </style>
    <script language="javascript">
        function setPng24(obj) {
            obj.width=obj.height=1;
            obj.className=obj.className.replace(/\bpng24\b/i,'');
            obj.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+ obj.src +"',sizingMethod='image');"
            obj.src='';
            return '';
        }
        try{document.execCommand("BackgroundImageCache",false,true);}catch(e){}//catch(err) {}
    </script>
    <!--[if IE]><script src="js/html5.js"></script><![endif]-->
</head>
<body>
    <header>
        <article>
            <h1><a href="<?=PATH_HOME;?>"><img src="<?=PATH_IMAGE_END?>admin_logo_sub.png" class="png24" alt="ADMINISTRATOR" /></a></h1>
            <p><strong><?=$_SESSION['temp_nick'];?></strong>�� ȯ���մϴ�.</p>
            <ul>
<?if(!strcmp($_SESSION['temp_level'],"100")){?>
                <li class="current"><a href="http://aklover.co.kr/phpMyAdmin/index.php?lang=ko-euc-kr&pma_username=<?=USER_DEFAULT?>" target="_blank">phpMyAdmin</a> <span>l</span> </li>
<?}?>
                <li class="current"><a href="<?=MAIN_HOME;?>" target="_blank">HomePage</a> <span>l</span> </li>
                <li class="current"><a href="<?=DOMAIN_END;?>m" target="_blank">MobilePage</a> <span>l</span> </li>
                <li><a href="<?=PATH_END;?>out.php">Logout</a></li>
            </ul>
        </article>
        <nav class="nav">
            <p><?=img('PATH_IMAGE_END||home.gif', 'Ȩ', PATH_HOME, 'close', '');?><!--<img src="<?=PATH_IMAGE_END?>home.gif" alt="Ȩ" />--> <span id="breadcrumbs" style="color:#003970;"></span></p>
            <ul>

            </ul>
        </nav>
    </header>

    <section id="container">
        <div class="container_inner">
            <aside>
                <h2>ȸ������</h2>
                <nav class="nav">
                    <ul class="left_menu">
                         <li class=" ">
                            <a href="/loaksecure21/index.php??board=user&idx=93">SNS�ּ�Ȯ��</a>
                        </li>
                    </ul>
                </nav>
            </aside>
            <section id="content">

