<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '23';
######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}
######################################################################################################################################################
$sql = 'select * from board where hero_table=\''.$_GET['board'].'\''.$search.' order by hero_notice desc, hero_idx desc;';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=8;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
?>
    <div class="contents_area">
        <div class="page_title">
            <h2><img src="<?=str($right_list['hero_right']);?>" alt="<?=$right_list['hero_title'];?>" /></h2>
            <ul class="nav">
                <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
                <li>&gt;</li>
                <li><?=$right_list['hero_top_title'];?></li>
                <li>&gt;</li>
                <li class="current"><?=$right_list['hero_title'];?></li>
            </ul>
        </div>
        <div class="contents">
            <div class="blog_box2" style="margin-top:0px">
                <ul class="blog_article">
<?
$sql = 'select * from board where hero_table=\''.$_GET['board'].'\''.$search.' order by hero_notice desc, hero_idx desc limit '.$start.','.$list_page.';';
sql($sql, 'on');
$data_count = mysql_num_rows($out_sql);
$view_count = '4';
//echo floor($data_count/$view_count);
$i = '1';
$dd = '1';
$total_chack = $data_count;

$cut_title_name = '8';
$cut_command_name = '50';

while($list                             = @mysql_fetch_assoc($out_sql)){
$img_parser_url = @parse_url($list['hero_img_new']);
$img_host = $img_parser_url['host'];
$img_path = $img_parser_url['path'];


    if (strcmp($dd,'4')){
        echo '                    <li>'.PHP_EOL;
    }else if(!strcmp($dd,'4')){
        echo '                    <li class="last">'.PHP_EOL;
        $dd = '0';
    }
    if(!strcmp($list['hero_img_new'],'')){
        $view_img = IMAGE_END.'hero.jpg';
    }else if(!strcmp($img_host,'')){
        $view_img = IMAGE_END.'hero.jpg';
//        $view_img = USER_PHOTO_END.$list['hero_img_new'];

    }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
        $view_img = $list['hero_img_new'];
//        $view_img = USER_PHOTO_END.$list['hero_img_new'];
    }else if(!strcmp(eregi('naver',$img_host),'1')){
        $view_img = IMAGE_END.'hero.jpg';
    }else{
        $view_img = $list['hero_img_new'];
    }
$main_review_sql = 'select * from review where hero_old_idx=\''.$list['hero_idx'].'\'';
$out_main_review_sql = @mysql_query($main_review_sql);
$main_review_data = @mysql_num_rows($out_main_review_sql);
if(strcmp($main_review_data, '0')){
    $re_count_total = "<strong><font color='orange'>[".$main_review_data."]</font></strong>";
}else{
    $re_count_total = "";
}
if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($list['hero_today'])))){
//    $new_img_view = "<img src='".DOMAIN_END."image/main_new_bt.png' width='13px' height='13px' alt='new' /> ";
    $new_img_view = " style='background:url(".DOMAIN_END."image/main_new_bt.png) no-repeat 0 2px;'";
}else{
    $new_img_view = "style='background:url(../image/common/ico_main_dot.gif) no-repeat 0 2px;'";
}
$pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$list['hero_code'].'\'';
$out_pk_sql = mysql_query($pk_sql);
$pk_row                             = @mysql_fetch_assoc($out_pk_sql);

$content = $list['hero_command'];
$content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
$content = str_replace("\r", "", $content);
$content = str_replace("\n", "", $content);
$content = str_replace("&#65279;", "", $content);
$content_01 = cut($content,'50');
        echo '                        <div title="'.$content.'">'.PHP_EOL;
        echo '                        <a href="'.PATH_HOME.'?board='.$_GET['board'].'&page='.$page.'&view=view&idx='.$list['hero_idx'].'">'.PHP_EOL;
        echo '                            <img onerror="this.src=\''.IMAGE_END.'hero.jpg\';" src="'.$view_img.'" alt=""><!--w:175*h:155-->'.PHP_EOL;
        echo '                            <span class="title" '.$new_img_view.'>'.cut($list['hero_title'], '7').$re_count_total.'</span>'.PHP_EOL;
        echo '                            <span class="txt">'.$content_01.'</span>'.PHP_EOL;
//        echo '                            <span class="date"><center>'.date( "Y-m-d H:i", strtotime($list['hero_today']))."<br>".$list['hero_nick'].'</center></span>'.PHP_EOL;
        echo '                            <span class="date"><center><img src="'.str($pk_row[hero_img_new]).'" style="width:20px;height:20px" /> '.$list['hero_nick'].'</center></span>'.PHP_EOL;
        echo '                        </a>'.PHP_EOL;
        echo '                        </div>'.PHP_EOL;
        echo '                    </li>'.PHP_EOL;
$i++;
$dd++;
$total_chack--;
}
?>
                </ul>
            </div>
            <div class="clearfix"></div>
<? include_once BOARD_INC_END.'button.php';?>
        </div>
    </div>
