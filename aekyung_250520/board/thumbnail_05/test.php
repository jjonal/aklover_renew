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
$sql = 'select * from board where hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') and hero_board_three=\'1\' or  hero_table=\'group_04_10\' '.$search;
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

if(!strcmp($_GET['type'], 'drop')){
    $post_count = @count($_POST['hero_drop']);
    for($i=0;$i<$post_count;$i++){
        $review_sql = 'select * from review WHERE hero_old_idx = \''.$_POST['hero_drop'][$i].'\';';
        $out_review = @mysql_query($review_sql);
        while($review_list                             = @mysql_fetch_assoc($out_review)){
            $point_sql = 'DELETE FROM point WHERE hero_review_idx = \''.$review_list['hero_idx'].'\';';
            @mysql_query($point_sql);
            $member_total_sql = 'select SUM(hero_point) as member_total from point WHERE hero_code=\''.$review_list['hero_code'].'\';';
            $out_member_total_sql = @mysql_query($member_total_sql);
            $member_total_list                             = @mysql_fetch_assoc($out_member_total_sql);
            $member_total_point = $member_total_list['member_total'];
            $sql = 'UPDATE member SET hero_point=\''.$member_total_point.'\' WHERE hero_code = \''.$review_list['hero_code'].'\';'.PHP_EOL;
            @mysql_query($sql);
        }
        $review_drop_sql = 'DELETE FROM review WHERE hero_old_idx = \''.$_POST['hero_drop'][$i].'\';';
        @mysql_query($review_drop_sql);
        $board_select_sql = 'select * from board WHERE hero_idx=\''.$_POST['hero_drop'][$i].'\';';
        $out_board_select = @mysql_query($board_select_sql);
        $board_select_list                             = @mysql_fetch_assoc($out_board_select);
        @unlink(USER_FILE_INC_END.$board_select_list['hero_board_one']);

        $drop_action_img = $board_select_list['hero_command'];
        $code_main_value = "&lt;img.*src=&quot;(.*)&quot;.*&gt;";
        preg_match_all("`$code_main_value`iU", $drop_action_img, $code_main);
        while(list($code_key, $code_val) = @each($code_main[1])){
            if(!strcmp(eregi(USER_PHOTO_END,$code_val),'1')){
                $check_file = @str_ireplace(USER_PHOTO_END, USER_PHOTO_INC_END, $code_val);
                @unlink($check_file);
            }else{
                continue;
            }
        }
        $board_drop_sql = 'DELETE FROM board WHERE hero_idx = \''.$_POST['hero_drop'][$i].'\';';
        @mysql_query($board_drop_sql);
    }
    $msg = '삭제 되었습니다.';
    $get_herf = get('next_board||view||action||idx||page||type','','');
    $action_href = PATH_HOME.'?'.$get_herf;
    msg($msg,'location.href="'.$action_href.'"');
}
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
            <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=drop');?>" method="post" enctype="multipart/form-data">
                <ul class="blog_article">
<?
$sql = 'select * from board where hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') and hero_board_three=\'1\' or hero_table=\'group_04_10\' '.$search.' order by hero_order asc, hero_today desc limit '.$start.','.$list_page.';';//, hero_order desc
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
    }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
        $view_img = $list['hero_img_new'];
    }else if(!strcmp(eregi('naver',$img_host),'1')){
        $view_img = IMAGE_END.'hero.jpg';
    }else{
        $view_img = $list['hero_img_new'];
    }
    if(!strcmp($list['hero_table'],'group_04_10')){
        $page=$page;
        $view='view';
        $idx=$list['hero_idx'];
    }else if(!strcmp($list['hero_table'],'group_04_09')){
        $page=$page;
        $view='view';
        $idx=$list['hero_idx'];
    }else{
        $page='1';
        $view='step_06&hero_idx='.$list['hero_idx'];
        $idx=$list['hero_01'];
    }

$content = $list['hero_command'];
$content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
$content = str_replace("\r", "", $content);
$content = cut(str_replace("\n", "", $content),'100');

if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($list['hero_today'])))){
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

$new_content="제목:".$list['hero_title']."\n\n작성일:".date( "Y-m-d", strtotime($list['hero_today']))."\n\n작성자:".$list['hero_nick'];
        echo '                        <div title="'.$new_content.'">'.PHP_EOL;
        echo '                        <a href="'.PATH_HOME.'?board='.$list['hero_table'].'&page='.$page.'&view='.$view.'&idx='.$idx.'">'.PHP_EOL;
        echo '                            <img onerror="this.src=\''.IMAGE_END.'hero.jpg\';" src="'.$view_img.'" alt=""><!--w:175*h:155-->'.PHP_EOL;
        echo '                            <span class="title" '.$new_img_view.'> '.cut($list['hero_title'], $cut_title_name).'</span>'.PHP_EOL;
        echo '                            <span class="txt">'.$content_01.'</span>'.PHP_EOL;
        echo '                            <span class="date"><center>'.date( "Y-m-d H:i", strtotime($list['hero_today'])).'<br>';
if($_SESSION['temp_level']>='99'){
?>
                    <input type="checkbox" name="hero_drop[]" value="<?=$list['hero_idx']?>">
<?
}
        echo '                              <img src="'.str($pk_row[hero_img_new]).'" style="width:20px;height:20px" /> '.$list['hero_nick'].'</center></span>'.PHP_EOL;
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
<?
if($_SESSION['temp_level']>='99'){
?>
            <div style="border:1px solid #b4b4b4;text-align:center">
                        <a href="javascript:form_next.submit();"><img src="../image/bbs/btn_del.gif" alt="삭제" /></a>
            </div>
<?}?>
            </form>
            <div class="clearfix"></div>
<? include_once BOARD_INC_END.'button.php';?>
        </div>
    </div>
