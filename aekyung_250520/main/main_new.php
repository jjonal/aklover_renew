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
//$sql = out($sql); 
sql($sql);
$rollimg_count = @mysql_num_rows($out_sql);
while($roll_list                             = @mysql_fetch_assoc($out_sql)){
?>
            <a href="<?=url($roll_list['hero_href'])?>" class="rollimg" target="_BLANK"><img src="<?=url($roll_list['hero_main'])?>" width="990" height="355"></a><!--990px||355px-->
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
            <a href="<?=url($other_01_list['hero_href'])?>"><img src="<?=url($other_01_list['hero_main'])?>"></a>
        </div>
        <div class="blog_cnt">
            <ul class="blog_type">
                <li class="l1"><a href="#" class="active"><img src="../image/main/btn_mission.gif" alt="" /></a></li>
                <li class="l2"><a href="#"><img src="../image/main/btn_mission.gif" alt="" /></a></li>
                <li class="l3"><a href="#"><img src="../image/main/btn_mission.gif" alt="" /></a></li>
                <li class="l4"><a href="#"><img src="../image/main/btn_mission.gif" alt="" /></a></li>
            </ul>
            <ul class="blog_article">
<?
$sql_00 = 'select * from mission where hero_table=\'mission_3\' order by hero_today desc, hero_idx desc limit 0,4;';
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
        $view_img = USER_PHOTO_END.$list_00['hero_img_new'];
    }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
        $view_img = $list_00['hero_img_new'];
//        $view_img = USER_PHOTO_END.$list['hero_img_new'];
    }else if(!strcmp(eregi('naver',$img_host),'1')){
        $view_img = IMAGE_END.'hero.jpg';
    }else{
        $view_img = $list_00['hero_img_new'];
    }
?>
                <li<?=$class00?>>
                    <a href="<?=PATH_HOME.'?board='.$list_00['hero_table'].'&view=view&idx='.$list_00['hero_idx']?>">
                        <img src="<?=$view_img?>" alt="" /><!--w:178*h:159-->
                        <span class="title"><?=$list_00['hero_title']?></span>
                        <span class="txt"><?=cut(strip_tags(htmlspecialchars_decode($list_00['hero_command'])),'15');?></span>
                        <span class="date"><?=date( "Y.m.d H:i", strtotime($list_00['hero_today']));?></span>
                    </a>
                </li>
<?
$i_00++;
}
?>
            </ul>
            <ul class="blog_article">
<?
$sql_01 = 'select * from board where hero_table=\'mission_4\' and hero_notice=\'0\' order by hero_notice desc, hero_idx desc limit 0,4;';
$out_sql_01 = @mysql_query($sql_01);
$count_01 = @mysql_num_rows($out_sql_01);
$i_01='0';
while($list_01                             = @mysql_fetch_assoc($out_sql_01)){
    if(!strcmp($count_01, $i_01)){
        $class01 = ' class="last"';
    }else{
        $class01 = '';
    }
?>
                <li<?=$class01?>>
                    <a href="<?=PATH_HOME.'?board='.$list_01['hero_table'].'&view=view&idx='.$list_01['hero_idx']?>">
                        <img src="<?=$list_01['hero_img_new']?>" alt="" /><!--w:178*h:159-->
                        <span class="title"><?=$list_01['hero_title']?></span>
                        <span class="txt"><?=cut(strip_tags(htmlspecialchars_decode($list_01['hero_title'])),'15');?></span>
                        <span class="date"><?=date( "Y.m.d H:i", strtotime($list_01['hero_today']));?></span>
                    </a>
                </li>
<?
$i_01++;
}
?>
            </ul>
            <ul class="blog_article">
<?
$sql_02 = 'select * from mission where hero_table=\'activity_1\' order by hero_today desc, hero_idx desc limit 0,4;';
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
        $view_img = USER_PHOTO_END.$list_02['hero_img_new'];
    }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
        $view_img = $list_02['hero_img_new'];
//        $view_img = USER_PHOTO_END.$list['hero_img_new'];
    }else if(!strcmp(eregi('naver',$img_host),'1')){
        $view_img = IMAGE_END.'hero.jpg';
    }else{
        $view_img = $list_02['hero_img_new'];
    }
?>
                <li<?=$class02?>>
                    <a href="<?=PATH_HOME.'?board='.$list_02['hero_table'].'&view=view&idx='.$list_02['hero_idx']?>">
                        <img src="<?=$list_02['hero_img_new']?>" alt="" /><!--w:178*h:159-->
                        <span class="title"><?=$list_02['hero_title']?></span>
                        <span class="txt"><?=cut(strip_tags(htmlspecialchars_decode($list_02['hero_command'])),'15');?></span>
                        <span class="date"><?=date( "Y.m.d H:i", strtotime($list_02['hero_today']));?></span>
                    </a>
                </li>
<?
$i_02++;
}
?>
            </ul>
            <ul class="blog_article">
<?
$sql_03 = 'select * from mission where hero_table=\'mission_2\' order by hero_today desc, hero_idx desc limit 0,4;';
$out_sql_03 = @mysql_query($sql_03);
$count_03 = @mysql_num_rows($out_sql_03);
$i_03='0';
while($list_03                             = @mysql_fetch_assoc($out_sql_03)){
    if(!strcmp($count_03, $i_03)){
        $class03 = ' class="last"';
    }else{
        $class03 = '';
    }
$img_parser_url = @parse_url($class03['hero_img_new']);
$img_host = $img_parser_url['host'];
    if(!strcmp($class03['hero_img_new'],'')){
        $view_img = IMAGE_END.'hero.jpg';
    }else if(!strcmp($img_host,'')){
        $view_img = USER_PHOTO_END.$class03['hero_img_new'];
    }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
        $view_img = $class03['hero_img_new'];
//        $view_img = USER_PHOTO_END.$list['hero_img_new'];
    }else if(!strcmp(eregi('naver',$img_host),'1')){
        $view_img = IMAGE_END.'hero.jpg';
    }else{
        $view_img = $class03['hero_img_new'];
    }
?>
                <li<?=$class01?>>
                    <a href="<?=PATH_HOME.'?board='.$list_03['hero_table'].'&view=view&idx='.$list_03['hero_idx']?>">
                        <img src="<?=$list_03['hero_img_new']?>" alt="" /><!--w:178*h:159-->
                        <span class="title"><?=$list_03['hero_title']?></span>
                        <span class="txt"><?=cut(strip_tags(htmlspecialchars_decode($list_03['hero_command'])),'15');?></span>
                        <span class="date"><?=date( "Y.m.d H:i", strtotime($list_03['hero_today']));?></span>
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
//print_R($other_02);
?>
        <a href="<?=url($other_02_list['hero_href'])?>"><img src="<?=url($other_02_list['hero_main'])?>"></a>
        <ul>
            <li class="more"><a href="<?=url($other_02_list['hero_href'])?>"><img src="../image/common/btn_more.gif" alt="more"></a></li>
<?
$sql = 'select * from board where hero_table=\''.$other_02['1'].'\' and hero_notice=\'0\' order by hero_notice desc, hero_idx desc limit 0,6;';
//$sql = out($sql); 
sql($sql);
while($list                             = @mysql_fetch_assoc($out_sql)){
?>
      <li><a href="<?=url('MAIN_HOME||board||'.$list['hero_table'].'&view=view&idx='.$list['hero_idx']);?>"><?=cut($list['hero_title'],'15');?><span><?=date( "[Y.m.d]", strtotime($list['hero_today']));?></span></a></li>
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
        <a href="<?=url($other_03_list['hero_href'])?>"><img src="<?=url($other_03_list['hero_main'])?>"></a>
        <ul>
            <li class="more"><a href="<?=url($other_03_list['hero_href'])?>"><img src="../image/common/btn_more.gif" alt="more"></a></li>
<?
$sql = 'select * from board where hero_table=\''.$other_03['1'].'\' and hero_notice=\'0\' order by hero_notice desc, hero_idx desc limit 0,6;';
//$sql = out($sql); 
sql($sql);
while($list                             = @mysql_fetch_assoc($out_sql)){
?>
      <li><a href="<?=url('MAIN_HOME||board||'.$list['hero_table'].'&view=view&idx='.$list['hero_idx']);?>"><?=cut($list['hero_title'],'15');?><span><?=date( "[Y.m.d]", strtotime($list['hero_today']));?></span></a></li>
<?}?>
        </ul>
    </div>
    <div class="clearfix"></div>
    <div class="banner_article">
        <ul>
<?
$sql = 'select * from hero_group where hero_group=\'banner\' and hero_order!=\'0\' and hero_use=\'1\' order by hero_order asc;';//desc//asc
//$sql = out($sql); 
sql($sql);
while($list                             = @mysql_fetch_assoc($out_sql)){
?>
            <li><a href="<?=url($list['hero_href'])?>" target="_BLANK"><img src="<?=url($list['hero_main'])?>" width="323" height="100"><?=img2($list['hero_main'], '', '', '', '', '', '')?></a></li><!--w323*h100-->
<?}?>
        </ul>
<?
$sql = 'select * from hero_group where hero_group=\'other\' and hero_use=\'1\' and hero_board = \'other_04\';';//desc//asc// limit 0,5
sql($sql);
$other_04_list                             = @mysql_fetch_assoc($out_sql);
?>
        <a href="<?=url($other_04_list['hero_href'])?>" class="img"><img src="<?=url($other_04_list['hero_main'])?>"></a>
    </div>
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
        });
    </script>