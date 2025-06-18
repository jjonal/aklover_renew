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
?>
<!doctype html>
<html lang="ko">
<head>
    <meta http-equiv="content-type" content="text/html; charset=<?=OLDSET?>" />
    <title><?=$hero_alt['0'];?></title>
    <meta name="keywords" content="<?=$hero_alt['1'];?>" />
<!--
    <meta http-equiv="X-UA-Compatible" content="IE=8" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
-->
    <link rel="stylesheet" type="text/css" href="<?=CSS_END;?>general.css"/>
    <link rel="stylesheet" type="text/css" href="<?=PATH_END?>css/admin_login.css" />
    <link rel="stylesheet" href="<?=PATH_END?>css/admin.css" type="text/css" />
    <script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
    <script type="text/javascript" src="<?=JS_END;?>head.js"></script>
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
            <h1><a href="<?=PATH_HOME;?>"><img src="<?=PATH_IMAGE_END?>admin_logo.png" class="png24" alt="ADMINISTRATOR" /></a></h1>
            <p><strong><?=$_SESSION['temp_nick'];?></strong>님 환영합니다.</p>
            <ul>
<?if(!strcmp($_SESSION['temp_level'],"100")){?>
                <li class="current"><a href="<?=DOMAIN_END;?>phpMyAdmin" target="_blank">phpMyAdmin</a> <span>l</span> </li>
<?}?>
                <li class="current"><a href="<?=MAIN_HOME;?>" target="_blank">HomePage</a> <span>l</span> </li>
                <li><a href="<?=PATH_END;?>out.php">Logout</a></li>
            </ul>
        </article>
        <nav class="nav">
            <p><?=img('PATH_IMAGE_END||home.gif', '홈', PATH_HOME, 'close', '');?><!--<img src="<?=PATH_IMAGE_END?>home.gif" alt="홈" />--></p>
            <ul>
<?
######################################################################################################################################################
    $data_i = '0';
    $sql = 'select * from '.$hero_table.' where hero_depth = \'0\' and hero_level <= '.$_SESSION['temp_level'].' and hero_use = \'0\';';
    sql($sql, 'on');
    while($top_list = @mysql_fetch_array($out_sql)){
//echo str($top_list['hero_href']);exit;
//        $sql = url('PATH_HOME||board||'.$top_list['hero_board'].'||&path='.$top_list['hero_href'];
        $sql = url('PATH_HOME||board||'.$top_list['hero_board'].'||&idx='.$top_list['hero_idx']);
        if(!strcmp($top_list['hero_board'], $_GET['board'])){$class_top=' class="current"';}else{$class_top='';}
?>
                <li<?=$class_top;?>>
                    <a href="<?=$sql?>"><?=$top_list['hero_alt']?></a>
                </li>
<?
        if(!strcmp($data_i, '0')){$board = $top_list['hero_board'];$idx=$top_list['hero_idx'];}
        $data_i++;
    }
######################################################################################################################################################
?>
            </ul>
        </nav>
    </header>

    <section id="container">
        <div class="container_inner">
            <aside>
<?
    if(!strcmp($_GET['board'], '')){$board = $board;}else{$board = $_GET['board'];}
    if(!strcmp($_GET['idx'], '')){$idx = $idx;}else{$idx = $_GET['idx'];}
    $sql = 'select * from '.$hero_table.' where hero_board = \''.$board.'\' and hero_level <= '.$_SESSION['temp_level'].' and hero_use = \'0\' ORDER BY hero_board, hero_order;';
    sql($sql);
    while($main_list = @mysql_fetch_array($out_sql)){
        if(!strcmp($main_list['hero_depth'], '0')){
            $main_title = $main_list['hero_alt'];
?>
                <h2><?=$main_list['hero_alt'];?></h2>
                <nav class="nav">
                    <ul class="left_menu">
<?
######################################################################################################################################################
        }else{
            $sql = url('PATH_HOME||board||'.$board.'||&idx='.$main_list['hero_idx']);
//            if(!strcmp($main_list['hero_idx'], $_GET['idx'])){$class_link=' class="current"';}else{$class_link='';}
            if(!strcmp($main_list['hero_idx'], $_GET['idx'])){$class_link=' class="current"';}else{$class_link='';}
?>
                        <li<?=$class_link;?>>
                            <a href="<?=$sql?>"><?=$main_list['hero_alt']?></a>
                        </li>
<?
        }
    }
######################################################################################################################################################
?>
                    </ul>
                </nav>
            </aside>
            <section id="content">

