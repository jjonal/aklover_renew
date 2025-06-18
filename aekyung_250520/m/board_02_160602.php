<?php
include_once "head.php";
#####################################################################################################################################################
$sql = 'select * from board where hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\') and (hero_board_three=\'1\' or hero_table=\'group_04_10\') order by hero_02 desc, hero_order asc, hero_today desc';
sql($sql,"on");
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=6;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path=get("page||download");
######################################################################################################################################################
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
######################################################################################################################################################
?>
<link href="css/review.css" rel="stylesheet" type="text/css">

<!--컨텐츠 시작-->
     <div id="title"><p><?=$right_list['hero_title'];?></p></div>
     
     <div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/></div>

<div id="guide">
         <ul style="width:100%">
         <li style="width:13%; margin-left:5%"><img src="img/general/note1.png" alt="" width="45px"/></li>
         <li class="guide_text" style="width:82%"><p>AK LOVER 우수활동자를 소개해요</p></li>
        </ul> 
</div>
             <div class="clear"></div>  

       <!-- gallery 시작 -->
    <div id="gallery">
      <ul>
<?
$main_sql = $sql.' limit '.$start.','.$list_page.';';
$out_main = @mysql_query($main_sql);
$i="0";
while($main_list                             = @mysql_fetch_assoc($out_main)){
    if(!strcmp($i,'0')){
        $ul_class = "gallery_left";
    }else if(!strcmp($i,'1')){
        $ul_class = "gallery_center";
    }else if(!strcmp($i,'2')){
        $ul_class = "gallery_right";
    }else if(!strcmp($i,'3')){
        $ul_class = "gallery_left1";
    }else if(!strcmp($i,'4')){
        $ul_class = "gallery_center1";
    }else if(!strcmp($i,'5')){
        $ul_class = "gallery_right1";
    }

//echo $main_list['hero_img_new'];
    $img_parser_url = @parse_url($main_list['hero_img_new']);
    $img_host = $img_parser_url['host'];
    $img_path = $img_parser_url['path'];
    if(!strcmp($main_list['hero_img_new'],'')){
        $view_img = IMAGE_END.'hero.jpg';
    }else if(!strcmp($img_host,'')){
        $view_img = IMAGE_END.'hero.jpg';
    }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
        $view_img = $list['hero_img_new'];
    }else if(!strcmp(eregi('naver',$img_host),'1')){
        $view_img = IMAGE_END.'hero.jpg';
    }else{
        $view_img = $main_list['hero_img_new'];
    }

    /* $content = $main_list['hero_command'];
    $content = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($content))));
    $content = str_replace("\r", "", $content);
    $content = str_replace("\n", "", $content);
    $content = str_replace("&#65279;", "", $content);
    $content_01 = cut($content,'50');
    if(!strcmp($content_01,"")){
        $content_01 = "&nbsp;";
    } */
    $title = $main_list['hero_title'];
    $title = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($title))));
    $title = str_replace("\r", "", $title);
    $title = str_replace("\n", "", $title);
    $title = str_replace("&#65279;", "", $title);
    $title_01 = cut($title,'50');
    if(!strcmp($title_01,"")){
        $title_01 = "&nbsp;";
    }
    if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($main_list['hero_today'])))){
        $new_img_view = " <img src='".DOMAIN_END."image/main_new_bt.png'  width='13' alt='new' />";
    }else{
        $new_img_view = "";
    }
/*
    if(!strcmp(y."-".m."-".d, date( "y-m-d", strtotime($main_list['hero_today'])))){
        $new_img_view = " <img src='".DOMAIN_END."image/sub_new.jpg' alt='new' />";
    }else{
        $new_img_view = "";
    }
*/
    $pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \''.$main_list['hero_code'].'\'';
    $out_pk_sql = mysql_query($pk_sql);
    $pk_row                             = @mysql_fetch_assoc($out_pk_sql);
    $exploded_blog = explode("http", $main_list["hero_04"]);
?>
        <a href="http<?=$exploded_blog[1]?>" target="_blank">
        <li class="<?=$ul_class?>">
              <ul class="gallery_box" style="width:100%">
                 <li class="thumb" style="width:100%">
                 	<div style="background-image: url(<?=$view_img?>);">
                 	</div>
                 </li>
                 <li class="gallery_title1" ><?=$new_img_view?>&nbsp;<?=$title_01?></li>
                 <!--등록시간<li class="date" style="width:100%">2013-11-13-22:39</li>-->
                 <li class="nickname"><img src="<?=str($pk_row['hero_img_new'])?>" height="13px" />&nbsp;<?=$pk_row['hero_nick'];?></li>
               </ul>
                 <!--<span class="more"><a href="general_viewer"><img src="img/general/more.jpg" alt="더보기"/></a></span>-->
        </li>
        </a>
<?
$i++;
}
?>
     </ul>
   </div>
     
     <div class="clear"></div> 
     
     <div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/></div>    
     
     
     <div id="page_number">
<?include_once "page.php"?>
<?
$sql = 'select * from hero_group where hero_board = \''.$_GET['board'].'\'';
sql($sql, 'on');
$check_list                             = @mysql_fetch_assoc($out_sql);
if($check_list['hero_write']<=$_SESSION['temp_write']){
?>
          <span class="gallery_btn">
          <a href="<?=DOMAIN_END?>m/write.php?board=<?=$_REQUEST['board']?>&action=write"><img src="img/general/write_btn.jpg" alt="글쓰기" width="70px"></a>
          </span> 
<?}?>
      </div>
      
       <!-- gallery 종료 --> 
      
    
<!--컨텐츠 종료-->

<script>
<?if(!strcmp($_REQUEST['download'],"ok")){?>
downMenu();
<?}?>
</script>
<?include_once "tail.php";?>