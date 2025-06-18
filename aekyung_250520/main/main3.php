<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_')){echo '<script>location.href="index.php"</script>';exit;}
####################################################################################################################################################
?>
    <div class="banner_mainbig">
        <div class="slider">
<?
$sql = 'select * from hero_group where hero_group=\'rollimg\' and hero_use=\'1\' order by hero_order asc;';//desc//asc
sql($sql);
$rollimg_count = @mysql_num_rows($out_sql);
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
?>
            <a href="<?=url($roll_list['hero_href'])?>" class="rollimg" target="_BLANK"><img src="<?=str($roll_list['hero_main'])?>" width="990" height="355"></a><!--990px||355px-->
<?}?>
            <a href="#" class="rollbtn rbtn1"><img src="../image/main/rollbtn.png" alt="이전"></a>
            <a href="#" class="rollbtn rbtn2"><img src="../image/main/rollbtn.png" alt="다음"></a>
        </div>



    </div>
    <div class="blog_box">
        <div class="blog_img">
<?
$sql = 'select * from hero_group where hero_group=\'other\' and hero_use=\'1\' and hero_board=\'other_01\';';//desc//asc// limit 0,5
sql($sql);
$other_01_list                             = @mysql_fetch_assoc($out_sql);
?>
            <a href="<?=url($other_01_list['hero_href'])?>"><img src="<?=str($other_01_list['hero_main'])?>"></a>
        </div>
        <div class="blog_cnt">
            <ul class="blog_type">
                <li class="l1"><a href="#" class="active"><img src="../image/main/btn_mission.gif" alt="" /></a></li>
                <li class="l2"><a href="#"><img src="../image/main/btn_mission.gif" title="1111" /></a></li>
                <li class="l3"><a href="#"><img src="../image/main/btn_mission.gif" alt="" /></a></li>
                <li class="l4"><a href="#"><img src="../image/main/btn_mission.gif" alt="" /></a></li>
            </ul>
            <ul class="blog_article">
<?
$sql_00 = 'select * from board where hero_table=\'group_01_01\' order by hero_today desc, hero_idx desc limit 0,4;';
$out_sql_00 = @mysql_query($sql_00);
$count_00 = @mysql_num_rows($out_sql_00);
$i_00='0';
while($list_00                             = @mysql_fetch_assoc($out_sql_00)){
    if(!strcmp($count_00, $i_00)){
        $class00 = ' class="last"';
    }else{
        $class00 = '';
    }
$img_parser_url = @parse_url($list_00['hero_img_new']);
$img_host = $img_parser_url['host'];
    if(!strcmp($list_00['hero_img_new'],'')){
        $view_img = IMAGE_END.'hero.jpg';
    }else if(!strcmp($img_host,'')){
        $view_img = IMAGE_END.'hero.jpg';
//        $view_img = USER_PHOTO_END.$list_00['hero_img_new'];
    }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
        $view_img = $list_00['hero_img_new'];
    }else if(!strcmp(eregi('naver',$img_host),'1')){
        $view_img = IMAGE_END.'hero.jpg';
    }else{
        $view_img = $list_00['hero_img_new'];
    }
$content = $list_00['hero_command'];
$content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
$content = str_replace("\r", "", $content);
$content = cut(str_replace("\n", "", $content),'30');
if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($list_00['hero_today'])))){
//    $new_img_view = "<img src='".DOMAIN_END."image/main_new_bt.png' width='13px' height='13px' alt='new' /> ";
    $new_img_view = " style='background:url(".DOMAIN_END."image/main_new_bt.png) no-repeat 0 2px;'";
}else{
    $new_img_view = " style='background:url(../image/common/ico_main_dot.gif) no-repeat 0 2px;'";
}
?>
                <li<?=$class00?>>
                    <a href="<?=PATH_HOME.'?board='.$list_00['hero_table'].'&view=view&idx='.$list_00['hero_idx']?>">
                        <img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$view_img?>" alt="" /><!--w:178*h:159-->
                        <span class="title"<?=$new_img_view?>><?=cut(strip_tags(htmlspecialchars_decode($list_00['hero_title'])),'9');?></span>
                        <span class="txt"><?=$content;?></span>
                        <!--<span class="date"><?=date( "Y.m.d H:i", strtotime($list_00['hero_today']));?></span>-->
                    </a>
                </li>
<?
$i_00++;
}
?>
            </ul>
            <ul class="blog_article">
<?
$sql_01 = 'select * from board where hero_table=\'group_01_02\' and hero_notice=\'0\' order by hero_notice desc, hero_idx desc limit 0,4;';
$out_sql_01 = @mysql_query($sql_01);
$count_01 = @mysql_num_rows($out_sql_01);
$i_01='0';
while($list_01                             = @mysql_fetch_assoc($out_sql_01)){
    if(!strcmp($count_01, $i_01)){
        $class01 = ' class="last"';
    }else{
        $class01 = '';
    }
$img_parser_url = @parse_url($list_01['hero_img_new']);
$img_host = $img_parser_url['host'];
    if(!strcmp($list_01['hero_img_new'],'')){
        $view_img = IMAGE_END.'hero.jpg';
    }else if(!strcmp($img_host,'')){
        $view_img = IMAGE_END.'hero.jpg';
//        $view_img = USER_PHOTO_END.$list_00['hero_img_new'];
    }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
        $view_img = $list_01['hero_img_new'];
    }else if(!strcmp(eregi('naver',$img_host),'1')){
        $view_img = IMAGE_END.'hero.jpg';
    }else{
        $view_img = $list_01['hero_img_new'];
    }
$content = $list_01['hero_command'];
$content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
$content = str_replace("\r", "", $content);
$content = cut(str_replace("\n", "", $content),'30');

if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($list_01['hero_today'])))){
//    $new_img_view = "<img src='".DOMAIN_END."image/main_new_bt.png' width='13px' height='13px' alt='new' /> ";
    $new_img_view = " style='background:url(".DOMAIN_END."image/main_new_bt.png) no-repeat 0 2px;'";
}else{
    $new_img_view = " style='background:url(../image/common/ico_main_dot.gif) no-repeat 0 2px;'";
}
?>
                <li<?=$class01?>>
                    <a href="<?=PATH_HOME.'?board='.$list_01['hero_table'].'&view=view&idx='.$list_01['hero_idx']?>">
                        <img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$view_img?>" alt="" /><!--w:178*h:159-->
                        <span class="title"<?=$new_img_view?>><?=cut(strip_tags(htmlspecialchars_decode($list_01['hero_title'])),'9');?></span>
                        <span class="txt"><?=$content;?></span>
                        <!--<span class="date"><?=date( "Y.m.d H:i", strtotime($list_01['hero_today']));?></span>-->
                    </a>
                </li>
<?
$i_01++;
}
?>
            </ul>
            <ul class="blog_article">
<?
$sql_02 = 'select * from board where hero_table=\'group_01_03\' order by hero_today desc, hero_idx desc limit 0,4;';
$out_sql_02 = @mysql_query($sql_02);
$count_02 = @mysql_num_rows($out_sql_02);
$i_02='0';
while($list_02                             = @mysql_fetch_assoc($out_sql_02)){
    if(!strcmp($count_02, $i_02)){
        $class02 = ' class="last"';
    }else{
        $class02 = '';
    }
$img_parser_url = @parse_url($list_02['hero_img_new']);
$img_host = $img_parser_url['host'];
    if(!strcmp($list_02['hero_img_new'],'')){
        $view_img = IMAGE_END.'hero.jpg';
    }else if(!strcmp($img_host,'')){
        $view_img = IMAGE_END.'hero.jpg';
//        $view_img = USER_PHOTO_END.$list_02['hero_img_new'];
    }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
        $view_img = $list_02['hero_img_new'];
    }else if(!strcmp(eregi('naver',$img_host),'1')){
        $view_img = IMAGE_END.'hero.jpg';
    }else{
        $view_img = $list_02['hero_img_new'];
    }
$content = $list_02['hero_command'];
$content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
$content = str_replace("\r", "", $content);
$content = cut(str_replace("\n", "", $content),'30');
if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($list_02['hero_today'])))){
//    $new_img_view = "<img src='".DOMAIN_END."image/main_new_bt.png' width='13px' height='13px' alt='new' /> ";
    $new_img_view = " style='background:url(".DOMAIN_END."image/main_new_bt.png) no-repeat 0 2px;'";
}else{
    $new_img_view = " style='background:url(../image/common/ico_main_dot.gif) no-repeat 0 2px;'";
}
?>
                <li<?=$class02?>>
                    <a href="<?=PATH_HOME.'?board='.$list_02['hero_table'].'&view=view&idx='.$list_02['hero_idx']?>">
                        <img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$view_img?>" alt="" /><!--w:178*h:159-->
                        <span class="title"<?=$new_img_view?>><?=cut(strip_tags(htmlspecialchars_decode($list_02['hero_title'])),'9');?></span>
                        <span class="txt"><?=$content;?></span>
                        <!--<span class="date"><?=date( "Y.m.d H:i", strtotime($list_02['hero_today']));?></span>-->
                    </a>
                </li>
<?
$i_02++;
}
?>
            </ul>
            <ul class="blog_article">
<?
$sql_03 = 'select * from board where hero_table=\'group_01_04\' order by hero_today desc, hero_idx desc limit 0,4;';
$out_sql_03 = @mysql_query($sql_03);
$count_03 = @mysql_num_rows($out_sql_03);
$i_03='0';
while($list_03                             = @mysql_fetch_assoc($out_sql_03)){
    if(!strcmp($count_03, $i_03)){
        $class03 = ' class="last"';
    }else{
        $class03 = '';
    }
$img_parser_url = @parse_url($list_03['hero_img_new']);
$img_host = $img_parser_url['host'];
    if(!strcmp($list_03['hero_img_new'],'')){
        $view_img = IMAGE_END.'hero.jpg';
    }else if(!strcmp($img_host,'')){
        $view_img = IMAGE_END.'hero.jpg';
//        $view_img = USER_PHOTO_END.$class03['hero_img_new'];
    }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
        $view_img = $list_03['hero_img_new'];
    }else if(!strcmp(eregi('naver',$img_host),'1')){
        $view_img = IMAGE_END.'hero.jpg';
    }else{
        $view_img = $list_03['hero_img_new'];
    }
$content = $list_03['hero_command'];
$content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
$content = str_replace("\r", "", $content);
$content = cut(str_replace("\n", "", $content),'30');
if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($list_03['hero_today'])))){
//    $new_img_view = "<img src='".DOMAIN_END."image/main_new_bt.png' width='13px' height='13px' alt='new' /> ";
    $new_img_view = " style='background:url(".DOMAIN_END."image/main_new_bt.png) no-repeat 0 2px;'";
}else{
    $new_img_view = " style='background:url(../image/common/ico_main_dot.gif) no-repeat 0 2px;'";
}
?>
                <li<?=$class01?>>
                    <a href="<?=PATH_HOME.'?board='.$list_03['hero_table'].'&view=view&idx='.$list_03['hero_idx']?>">
                        <img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$view_img?>" alt="" /><!--w:178*h:159-->
                        <span class="title"<?=$new_img_view?>><?=cut(strip_tags(htmlspecialchars_decode($list_03['hero_title'])),'9');?></span>
                        <span class="txt"><?=$content;?></span>
                        <!--<span class="date"><?=date( "Y.m.d H:i", strtotime($list_03['hero_today']));?></span>-->
                    </a>
                </li>
<?
$i_03++;
}
?>
            </ul>
        </div>
    </div>
    <div class="notice_article">
<?
$sql = 'select * from hero_group where hero_group=\'other\' and hero_use=\'1\' and hero_board = \'other_02\';';//desc//asc// limit 0,5
sql($sql);
$other_02_list                             = @mysql_fetch_assoc($out_sql);
$other_02 = @explode('=',url($other_02_list['hero_href']));
?>
        <a href="<?=url($other_02_list['hero_href'])?>"><img src="<?=str($other_02_list['hero_main'])?>"></a>
        <ul>
            <li class="more"><a href="<?=url($other_02_list['hero_href'])?>"><img src="../image/common/btn_more.gif" alt="more"></a></li>
<?
$sql = 'select * from board where hero_table=\''.$other_02['1'].'\' and hero_notice=\'0\' order by hero_notice desc, hero_idx desc limit 0,6;';
sql($sql);
while($list                             = @mysql_fetch_assoc($out_sql)){
if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($list['hero_today'])))){
    $new_img_view = " <img src='".DOMAIN_END."image/main_new_bt.png' alt='new' />";
}else{
    $new_img_view = "";
}
?>
      <li><a href="<?=url('MAIN_HOME||board||'.$list['hero_table'].'&view=view&idx='.$list['hero_idx']);?>"><?=cut($list['hero_title'],'15').$new_img_view;?><span><?=date( "[Y.m.d]", strtotime($list['hero_today']));?></span></a></li>
<?}?>
        </ul>
    </div>
    <div class="power_article">
<?
$sql = 'select * from hero_group where hero_group=\'other\' and hero_use=\'1\' and hero_board = \'other_03\';';//desc//asc// limit 0,5
sql($sql);
$other_03_list                             = @mysql_fetch_assoc($out_sql);
$other_03 = @explode('=',url($other_03_list['hero_href']));
?>
        <a href="<?=url($other_03_list['hero_href'])?>"><img src="<?=str($other_03_list['hero_main'])?>"></a>
        <ul>
            <li class="more"><a href="<?=url($other_03_list['hero_href'])?>"><img src="../image/common/btn_more.gif" alt="more"></a></li>
<?
//$sql = 'select * from board where hero_table=\'group_04_10\' and hero_notice=\'0\' order by hero_notice desc, hero_idx desc limit 0,6;';
$sql = 'select * from board where hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') order by hero_today desc limit 0,6;';
//url($other_03_list['hero_href'])
sql($sql);
while($list                             = @mysql_fetch_assoc($out_sql)){
    if(!strcmp($list['hero_table'],'group_04_09')){
        $page=$page;
        $view='view';
        $idx=$list['hero_idx'];
    }else{
        $page='1';
        $view='step_06&hero_idx='.$list['hero_idx'];
//        $view='step_05';
        $idx=$list['hero_01'];
    }
if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($list['hero_today'])))){
    $new_img_view = " <img src='".DOMAIN_END."image/main_new_bt.png' alt='new' />";
}else{
    $new_img_view = "";
}
?>
      <li><a href="<?=url('MAIN_HOME||board||'.$list['hero_table'].'&view='.$view.'&idx='.$idx)?>"><?=cut($list['hero_title'],'15').$new_img_view;?><span><?=date( "[Y.m.d]", strtotime($list['hero_today']));?></span></a></li>
<?}?>
        </ul>
    </div>
    <div class="clearfix"></div>
    <div class="banner_article">
        <div id="slide">
<?
$sql = 'select * from hero_group where hero_group=\'banner\' and hero_order!=\'0\' and hero_use=\'1\' order by hero_order asc;';//desc//asc
sql($sql);
$count_test = @mysql_num_rows($out_sql);
$temp_count_test = $count_test;
$test_i = '1';
$test_d = '1';
while($list                             = @mysql_fetch_assoc($out_sql)){
//배너
$temp_end_count = $temp_count_test-$test_i;
//echo $test_d;
if(!strcmp($test_d, "1")){
    echo "        <ul>";
}
?>
            <li><a href="<?=url($list['hero_href'])?>" target="_BLANK"><img src="<?=str($list['hero_main'])?>" width="323" height="100"><?=img2($list['hero_main'], '', '', '', '', '', '')?></a></li><!--w323*h100-->
<?
if( (!strcmp($test_d, "4")) or (!strcmp($temp_end_count, "0")) ){
    echo "        </ul>";
    $test_d="0";
}
    $test_d++;
    $test_i++;
}
?>
        </div>
<?
$sql = 'select * from hero_group where hero_group=\'other\' and hero_use=\'1\' and hero_board = \'other_04\';';//desc//asc// limit 0,5
sql($sql);
$other_04_list                             = @mysql_fetch_assoc($out_sql);
?>
        <a href="<?=url($other_04_list['hero_href'])?>" class="img"><img src="<?=str($other_04_list['hero_main'])?>"></a>
    </div>
<!--
<div class="banner2">
    <a href="http://aklover.co.kr/main/index.php?board=group_04_08"><img src="../image/main/b1.jpg" /></a>
    <a href="http://aklover.co.kr/main/index.php?board=group_04_07"><img src="../image/main/b2.jpg" /></a>
    </div>
-->
<?
$popup_sql = 'select hero_idx,hero_width_point,hero_height_point,hero_width,hero_height,hero_order,hero_use from popup where hero_use=\'1\'';//desc<=
$out_popup_sql = mysql_query($popup_sql);
?>
    <script type="text/javascript">
    var tmpidx=0;
        var nowidx=0;
        var t=1;
        var cnt=<?=$rollimg_count?>;
        var times;
        var times2;
        var $cut;
        var $des;
        $(document).ready(function(e) {
            $('.rollimg').eq(0).css({'z-index':'30'});
            $(".rbtn1").click(function(e) {
                pre()
            });
            $(".rbtn2").click(function(e) {
                action()
            });
            $('.bnext').click(nextp);
            $('.bprev').click(prevp);
            tm();
            tm2();
            if("<?=$temp_count_test?>" > 4){
                $('#slide').slidesjs({
                  width:698,
                  height: 408,
                  navigation: false,
                  play: { auto: true, restartDelay: 1500}
                });
            }
        });
<?
while($popup_list                             = @mysql_fetch_assoc($out_popup_sql)){
?>
        var hero_width="200";
		popup('<?=$popup_list[hero_idx]?>', '/popup/pop02.php?hero_idx=<?=$popup_list[hero_idx]?>', hero_width, <?=$popup_list[hero_height]?>, <?=$popup_list[hero_width_point]?>, <?=$popup_list[hero_height_point]?>,'yes');//폭/높이/좌측/우측/스크롤
<?}?>
    </script>
    <script type="text/javascript" src="/js/jquery.slides.min.js"></script>