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
$sql = 'select * from mission where hero_table=\''.$_GET['board'].'\''.$search.' order by hero_today desc;';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=6;
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
<?
if(!strcmp($total_data,"0")){
?>
            <div class="blog_box2" style="margin-top:30px;">
                <ul>
                    <li>
                        <div>
                            <img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=DOMAIN_END?>img/no_mission.jpg" width="175px" height="155px" alt=""><!--w:175*h:155-->
                        </div>
                    </li>
                </ul>
            </div>
<?}else{?>
            <div class="blog_box2" style="margin-top:30px;">
                <ul class="blog_article">
<?
$sql = 'select * from mission where hero_table=\''.$_GET['board'].'\''.$search.' order by hero_today desc limit '.$start.','.$list_page.';';
						//echo $sql;
sql($sql, 'on');
$data_count = mysql_num_rows($out_sql);
$view_count = '4';
//echo floor($data_count/$view_count);
$i = '1';
$dd = '1';
$total_chack = $data_count;

$cut_title_name = '13';
$cut_command_name = '100';
while($list = @mysql_fetch_assoc($out_sql)){
$img_parser_url = @parse_url($list['hero_img_new']);
$img_host = $img_parser_url['host'];


    if (strcmp($dd,'3')){
        echo '                    <li>'.PHP_EOL;
    }else if(!strcmp($dd,'3')){
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
	if($list["hero_thumb"]) $view_img = $list['hero_thumb'];

$check_day = date( "Y-m-d", time());
$today_01_01 = date( "Y-m-d", strtotime($list['hero_today_01_01']));
$today_01_02 = date( "Y-m-d", strtotime($list['hero_today_01_02']));

$today_02_01 = date( "Y-m-d", strtotime($list['hero_today_02_01']));
$today_02_02 = date( "Y-m-d", strtotime($list['hero_today_02_02']));

$today_03_01 = date( "Y-m-d", strtotime($list['hero_today_03_01']));
$today_03_02 = date( "Y-m-d", strtotime($list['hero_today_03_02']));

$today_04_01 = date( "Y-m-d", strtotime($list['hero_today_04_01']));
$today_04_02 = date( "Y-m-d", strtotime($list['hero_today_04_02']));

if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
    $review_menu = "<img src='/image2/etc/mission_request.jpg'>";
	$div_complete ='';
    $one_day = date( "m월d일", strtotime($list['hero_today_01_01']));
    $two_day = date( "m월d일", strtotime($list['hero_today_01_02']));
}else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
    $review_menu = "<img src='/image2/etc/mission_release.jpg'>";
	$div_complete ='';
    $one_day = date( "m월d일", strtotime($list['hero_today_02_01']));
    $two_day = date( "m월d일", strtotime($list['hero_today_02_02']));
}else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
    $review_menu = "<img src='/image2/etc/mission_enroll.jpg'>";
	$div_complete ='';
    $one_day = date( "m월d일", strtotime($list['hero_today_03_01']));
    $two_day = date( "m월d일", strtotime($list['hero_today_03_02']));
}else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
    $review_menu = "<img src='/image2/etc/mission_best.jpg'>";
	$div_complete ='';
    $one_day = date( "m월d일", strtotime($list['hero_today_04_01']));
    $two_day = date( "m월d일", strtotime($list['hero_today_04_02']));
}else if($today_04_02<$check_day){ 
    $review_menu = "미션마감";
	$div_complete = "<div class='mission_com'><img src='/image2/etc/mission_complete.png'></div>";
    $one_day = date( "m월d일", strtotime($list['hero_today_01_01']));
    $two_day = date( "m월d일", strtotime($list['hero_today_04_02']));
}

$ribbon_text = "<div class='mission_ribbon'> <img src='/image2/etc/mission_ribbon.png'><span>".$list['hero_kind']."</span></div>";
$content = $list['hero_command'];
$content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
$content = str_replace("\r", "", $content);
$content = str_replace("\n", "", $content);
$content = str_replace("&#65279;", "", $content);
$content_01 = cut($content,'50');

if(!strcmp($review_menu,'')){
    $new_content="제목:".$list['hero_title']."\n\n".$one_day.'-'.$two_day;
}else{
    $new_content="제목:".$list['hero_title']."\n\n".$review_menu."\n\n".$one_day.'-'.$two_day;
}
        echo '                        <div align=\'center\' title="'.$new_content.'">'.PHP_EOL;
        echo '                        <a href="'.PATH_HOME.'?board='.$_GET['board'].'&page='.$page.'&view=view&idx='.$list['hero_idx'].'">'.PHP_EOL;
        echo '                            <img class=\'mission_image\' onerror="this.src=\''.IMAGE_END.'hero.jpg\';" src="'.$view_img.'" alt=""><!--w:175*h:155-->'.PHP_EOL;
        echo '                            <span class="date_02" style="text-align:left">'.$review_menu.'&nbsp;&nbsp;'.$one_day.'-'.$two_day.'</span>'.PHP_EOL;
		echo '                            <span class="title_02">'.cut($list['hero_title'], $cut_title_name).'</span>'.PHP_EOL;
        echo '                            <span class="txt_02">'.mb_substr($list['hero_title_02'], 0, 18, 'EUC-KR').'</span>'.PHP_EOL;
        echo 							$ribbon_text.$div_complete.PHP_EOL;
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
<?}?>
            <div class="clearfix"></div>
            <div class="btngroup">
                <div class="btn_l">
<?
if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
    $my_write = '0';
    $my_view = '0';
    $my_update = '0';
    $my_rev = '0';
}else{
    $my_level = $_SESSION['temp_level'];
    $my_write = $_SESSION['temp_write'];
    $my_view = $_SESSION['temp_view'];
    $my_update = $_SESSION['temp_update'];
    $my_rev = $_SESSION['temp_rev'];
}
$sql = 'select * from hero_group where hero_board = \''.$_GET['board'].'\'';
sql($sql, 'on');
$check_list                             = @mysql_fetch_assoc($out_sql);
if(!strcmp($_GET['view'], '')){
    if($check_list['hero_write']<=$my_write){
?>
                <a href="index.php?board=<?=$_GET['board']?>&view=step_write&action=write"><img src="../image/bbs/btn_write.gif" alt="글쓰기" /></a>
<?
    }
}
?>
                </div>
                <div class="paging">
<? 
echo page($total_data,$list_page,$page_per_list,$_GET[page],$next_path);
?>
                </div>
                <div class="btn_r">
                </div>
            </div>
            <img src="../image/common/title_excellent.gif" alt="우수포스팅" style="margin-top:55px;" />
<?
$power_sql = 'select * from board where hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') and hero_board_three=\'1\' or hero_table=\'group_04_10\' order by hero_02 desc, hero_order asc, hero_today desc limit 0,6;';//, hero_order desc
$out_power_sql = @mysql_query($power_sql);
$power_data = @mysql_num_rows($out_power_sql);
$power_list = @mysql_fetch_assoc($out_power_sql);
$img_parser_url = @parse_url($power_list['hero_img_new']);
$img_host = $img_parser_url['host'];
    if(!strcmp($power_list['hero_img_new'],'')){
        $view_img = IMAGE_END.'hero.jpg';
    }else if(!strcmp($img_host,'')){
        $view_img = IMAGE_END.'hero.jpg';
    }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
        $view_img = $power_list['hero_img_new'];
    }else if(!strcmp(eregi('naver',$img_host),'1')){
        $view_img = IMAGE_END.'hero.jpg';
    }else{
        $view_img = $power_list['hero_img_new'];
    }

	if($power_list["hero_thumb"]) $view_img = $power_list['hero_thumb'];

    if(!strcmp($power_list['hero_table'],'group_04_10')){
        $page=$page;
        $view='view';
        $idx=$power_list['hero_idx'];
        $text='[블로그]';
    }else if(!strcmp($power_list['hero_table'],'group_04_09')){
        $page=$page;
        $view='view';
        $idx=$power_list['hero_idx'];
        $text='[블로그]';
    }else{
        $page='1';
        $view='step_06&hero_idx='.$power_list['hero_idx'];
        $idx=$power_list['hero_01'];
        $text='[발표]';
    }
$content = $power_list['hero_command'];
$content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
$content = str_replace("\r", "", $content);
$content = str_replace("\n", "", $content);
$content = str_replace("&#65279;", "", $content);
$content_01 = cut($content,'50');
$new_content="제목:".$power_list['hero_title']."\n\n작성일:".date( "Y-m-d", strtotime($power_list['hero_today']))."\n\n작성자:".$power_list['hero_nick'];
?>
            <div class="section_blog"><!---블로그 상단-->
                <div class="thimg" title="<?=$content?>">
                    <a href="<?=PATH_HOME.'?board='.$power_list['hero_table'].'&page='.$page.'&view='.$view.'&idx='.$idx?>"><img src="<?=$view_img?>" alt="" width="269" height="240"></a><!--w267*h240-->
                    <div class="graybg"></div>
                    <div class="graybox">
                        <img src="../image/common/best.png" alt="icon" /> HOT BLOG
                    </div>
                </div>
                <div class="seclist">
                    <dl>
<?
if(strcmp($power_data,'0')){
?>
                        <dt title="<?=$new_content?>"><a href="<?=PATH_HOME.'?board='.$power_list['hero_table'].'&page='.$page.'&view='.$view.'&idx='.$idx?>"><span class="c_orange"><?=$text?></span> <?=cut($power_list['hero_title'], '20')?> <span class="name">[<?=$power_list['hero_nick']?>]</span></a></dt>
<?
}
$power_sql = 'select * from board where hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') and hero_board_three=\'1\' or hero_table=\'group_04_10\' order by hero_02 desc, hero_order asc, hero_today desc limit 0,6;';
$out_power_sql = @mysql_query($power_sql);
while($power_list                             = @mysql_fetch_assoc($out_power_sql)){
    if(!strcmp($power_list['hero_table'],'group_04_10')){
        $page=$page;
        $view='view';
        $idx=$power_list['hero_idx'];
        $text='';
    }else if(!strcmp($power_list['hero_table'],'group_04_09')){
        $page=$page;
        $view='view';
        $idx=$power_list['hero_idx'];
        $text='';
    }else{
        $page='1';
        $view='step_06&hero_idx='.$power_list['hero_idx'];
        $idx=$power_list['hero_01'];
        $text='[발표]';
    }
$content = $power_list['hero_command'];
$content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
$content = str_replace("\r", "", $content);
$content = str_replace("\n", "", $content);
$content = str_replace("&#65279;", "", $content);
$content_01 = cut($content,'50');
$new_content="제목:".$power_list['hero_title']."\n\n작성일:".date( "Y-m-d", strtotime($power_list['hero_today']))."\n\n작성자:".$power_list['hero_nick'];
?>

                        <dd title="<?=$new_content?>"><a href="<?=PATH_HOME.'?board='.$power_list['hero_table'].'&page='.$page.'&view='.$view.'&idx='.$idx?>"><strong><?=$text?></strong> <?=cut($power_list['hero_title'], '20')?> <span class="name">[<?=$power_list['hero_nick']?>]</span></a></dd>
<?}?>
                    </dl>
                </div>
            </div>




        </div>
    </div>