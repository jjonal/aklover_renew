<!DOCTYPE html>
<?
if(!defined('_HEROBOARD_'))exit;
$hero_table = 'menu';
$sql = 'select * from hero_group where hero_idx=\'1\';';//desc
sql($sql, 'on');
$list = @mysql_fetch_assoc($out_sql);
$hero_alt = explode('||', $list['hero_title']);

//���뺯��
$type_arr = array("0"=>"�Ϲݹ̼�","1"=>"�̺�Ʈ","2"=>"�ҹ�����","3"=>"��������","5"=>"��ǰǰ��","8"=>"����Ʈü��","10"=>"ü���");

$focus_type_arr = array("0"=>"����̼�","1"=>"�̺�Ʈ","2"=>"�ҹ�����","3"=>"��������","5"=>"��ǰǰ��","7"=>"�����̼�","8"=>"����Ʈü��","9"=>"����̼�(����)","10"=>"ü���");
?>
<html lang="ko">
<head>
    <meta http-equiv="content-type" content="text/html; charset=<?=OLDSET?>" />
    <title><?=$hero_alt['0'];?></title>
    <meta name="keywords" content="<?=$hero_alt['1'];?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="/css/general.css"/>
    <link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/admin_login.css?v=210517" />
    <link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/admin.css?v=231212" type="text/css" />
    <link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/layout.css?v=250617" type="text/css" />
    <link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/common.css?v=250617" type="text/css" />
    <link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/jquery-ui.css">
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
    <script type="text/javascript" src="/js/head.js"></script>
    <script type="text/javascript" src="<?=ADMIN_DEFAULT?>/js/admin.js"></script>
    <script type="text/javascript" src="<?=ADMIN_DEFAULT?>/js/common.js"></script>
    <script type="text/javascript" src="<?=ADMIN_DEFAULT?>/js/jquery.form.js"></script>
    <script src="<?=ADMIN_DEFAULT?>/js/jquery-ui.js"></script>
    <!--[if IE]><script src="js/html5.js"></script><![endif]-->
</head>
<body>


<section id="container">
    <div class="container_inner">
        <!--
        <a href="javascript:;" id="btn_left_manage" class="btn_left_manage">����Ʈ �޴� ����/�ݱ�</a>
        -->

        <!-- (s) aside -->
        <aside class="container_left">
            <h1><a href="<?=PATH_HOME;?>"><img src="<?=PATH_IMAGE_END?>common/logo.svg" alt="�ΰ�" /></a></h1>
            <?
            if(!strcmp($_GET['board'], '')){
                $board = $board;
            }
            else{
                $board = $_GET['board'];
            }
            if(!strcmp($_GET['idx'], '')){
                $idx = $idx;
            }
            else {
                $idx = $_GET['idx'];
            }
            var_dump($board);
            //���� ����
            $sql = 'select *, datediff("'.date('Y-m-d').'", from_unixtime(hero_today)) as hero_today_diff from '.$hero_table.' where hero_board = \''.$board.'\' and hero_level <= '.$_SESSION['temp_level'].' and hero_use = \'0\' ORDER BY hero_depth,hero_board, hero_order;';
            sql($sql);
            while($main_list = @mysql_fetch_array($out_sql)){
            $style_class = "";
            if($main_list['hero_depth_idx'] == 0 ) $style_class = "admin_menu_sub_title";
            if(!strcmp($main_list['hero_depth'], '0')){
            $main_title = $main_list['hero_alt'];
            ?>
            <nav class="nav">
                <h2 class="user"><?=$main_list['hero_alt'];?></h2>
                <ul class="left_menu">
                    <? } else {
                        $menu_sql = url('PATH_HOME||board||'.$board.'||&idx='.$main_list['hero_idx']); // ���⸦ ����
                        if(!strcmp($main_list['hero_idx'], $_GET['idx'])){$class_link='current"';}else{$class_link='';}
                        ?>
                        <li class="<?=$class_link;?> <?=$style_class?>"><a href="<?=$main_list["hero_depth_idx"] > 0 ? $menu_sql:"javascript:;"?>"><?=$main_list['hero_alt']?></a></li>
                        <?
                    }
                    }
                    ?>
                </ul>
            </nav>
        </aside>
        <!-- (e) aside -->

        <!-- (s) content -->
        <div class="container_right">
            <!-- (s) header -->
            <header>
                <div class="header_inner">
                    <nav class="nav">
                        <ul>
                            <?
                            $data_i = '0';
                            $sql = 'select * from '.$hero_table.' where hero_depth = \'0\' and hero_level <= '.$_SESSION['temp_level'].' and hero_use = \'0\' ORDER BY hero_point;';
                            sql($sql, 'on');
                            while($top_list = @mysql_fetch_array($out_sql)){
                                $sql = url('PATH_HOME||board||'.$top_list['hero_board'].'||&idx='.$top_list['hero_idx']);
                                if(!strcmp($top_list['hero_board'], $_GET['board'])){$class_top=' class="current"';}else{$class_top='';}
                                ?>
                                <li<?=$class_top;?>><a href="<?=$sql?>"><?=$top_list['hero_alt']?></a></li>
                                <?
//                                if(!strcmp($data_i, '0')){
//                                    $board = $top_list['hero_board'];
//                                    $idx=$top_list['hero_idx'];
//                                }
                                if(!strcmp($data_i, '0')){
                                    // 250618 board/idx ���� ���� ���� ���� musign
                                    // URL �Ķ���Ͱ� �ִ� ��쿡�� ���� ���� �����ϰ�, ���� ��쿡�� top_list�� ���� ���
                                    if(!isset($_GET['board']) || $_GET['board'] === ''){
                                        $board = $top_list['hero_board'];
                                    }
                                    if(!isset($_GET['idx']) || $_GET['idx'] === ''){
                                        $idx = $top_list['hero_idx'];
                                    }
                                }
                                $data_i++;
                            }
                            ?>
                        </ul>
                    </nav>
                    <article>
                        <!-- <h1><a href="<?=PATH_HOME;?>"><img src="<?=PATH_IMAGE_END?>logo_admin.png" alt="ADMINISTRATOR" /></a></h1> -->
                        <p><span class="profile"><img src="" alt=" " /></span><strong><?=$_SESSION['temp_nick'];?></strong>�� ȯ���մϴ�.</p>
                        <ul>
                            <li class="current"><a href="<?=MAIN_HOME;?>" target="_blank">HomePage</a></li>
                            <li class="current"><a href="<?=DOMAIN_END;?>m" target="_blank">MobilePage</a></li>
                            <li class="current"><a href="<?=PATH_END;?>out.php">Logout</a></li>
                        </ul>
                    </article>
                </div>
            </header>
            <!-- (e) header -->
            <section id="content">