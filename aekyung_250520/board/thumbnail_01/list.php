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
//리스트 권한체크
$my_view 	=	$_SESSION ['temp_view'] == '' ? '0' : $_SESSION ['temp_view'];
if($my_view != '9999' && $my_view != '10000'){
	if($my_view < $right_list['hero_list']) {
		error_historyBack("죄송합니다. 권한이 없습니다.");
		exit;
	}
}
######################################################################################################################################################
?>

        <div class="contents">
            <img src="../image/common/title_excellent.gif" alt="우수포스팅" />
<?
$power_sql = 'select * from board where hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\', \'group_04_10\') and hero_02=\'1\' order by hero_notice desc, hero_idx desc limit 0,6;';
$out_power_sql = @mysql_query($power_sql);
$power_list                             = @mysql_fetch_assoc($out_power_sql);
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
        $view='step_05';
        $idx=$power_list['hero_01'];
        $text='[발표]';
    }
?>
            <div class="section_blog"><!---블로그 상단-->
                <div class="thimg">
                    <a href="<?=PATH_HOME.'?board='.$power_list['hero_table'].'&page='.$page.'&view='.$view.'&idx='.$idx?>"><img src="<?=$view_img?>" alt="" width="269" height="240"></a><!--w267*h240-->
                    <div class="graybg"></div>
                    <div class="graybox">
                        <img src="../image/common/best.png" alt="icon" /> HOT BLOG
                    </div>
                </div>
                <div class="seclist">
                    <dl>
                        <dt><a href="<?=PATH_HOME.'?board='.$power_list['hero_table'].'&page='.$page.'&view='.$view.'&idx='.$idx?>"><span class="c_orange"><?=$text?></span> <?=cut($power_list['hero_title'], '20')?> <span class="name">[<?=$power_list['hero_nick']?>]</span></a></dt>
<?
$power_sql = 'select * from board where hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\', \'group_04_10\') and hero_02=\'1\' order by hero_notice desc, hero_idx desc limit 0,6;';
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
        $view='step_05';
        $idx=$power_list['hero_01'];
        $text='[발표]';
    }
?>

                        <dd><a href="<?=PATH_HOME.'?board='.$power_list['hero_table'].'&page='.$page.'&view='.$view.'&idx='.$idx?>"><strong><?=$text?></strong> <?=cut($power_list['hero_title'], '20')?> <span class="name">[<?=$power_list['hero_nick']?>]</span></a></dd>
<?}?>
                    </dl>
                </div>
            </div>
            <div class="blog_box2">
                <ul class="blog_article">
<?
$sql = 'select * from board where hero_table=\''.$_GET['board'].'\''.$search.' order by hero_notice desc, hero_idx desc limit '.$start.','.$list_page.';';
sql($sql, 'on');
$data_count = mysql_num_rows($out_sql);
$view_count = '4';
$i = '1';
$dd = '1';
$total_chack = $data_count;

$cut_title_name = '8';
$cut_command_name = '100';
while($list                             = @mysql_fetch_assoc($out_sql)){
$img_parser_url = @parse_url($list['hero_img_new']);
$img_host = $img_parser_url['host'];


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
    }else if(!strcmp(eregi('naver',$img_host),'1')){
        $view_img = IMAGE_END.'hero.jpg';
    }else{
        $view_img = $list['hero_img_new'];
    }
        echo '                        <a href="'.PATH_HOME.'?board='.$_GET['board'].'&page='.$page.'&view=view&idx='.$list['hero_idx'].'">'.PHP_EOL;
        echo '                            <img onerror="this.src=\''.IMAGE_END.'hero.jpg\';" src="'.$view_img.'" alt=""><!--w:175*h:155-->'.PHP_EOL;
        echo '                            <span class="title">'.cut($list['hero_title'], $cut_title_name).'</span>'.PHP_EOL;
        echo '                            <span class="txt">'.cut(strip_tags(htmlspecialchars_decode($list['hero_command'])), $cut_command_name).'</span>'.PHP_EOL;
        echo '                            <span class="date">'.date( "Y-m-d H:i", strtotime($list['hero_today'])).'</span>'.PHP_EOL;
        echo '                        </a>'.PHP_EOL;
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
