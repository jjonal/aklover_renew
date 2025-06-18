<?php
include_once "head.php";
#####################################################################################################################################################

$board = $_GET["board"];

$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);

$gisu_type_gubun = array(
		"group_04_06" => array("title"=>"ºäÆ¼Å¬·´","column"=>"hero_beauty_gisu","level"=>"9996")
		,"group_04_27" => array("title"=>"Beauty/Life Club ¿µ»óÆÀ","column"=>"hero_movie_gisu","level"=>"9995")
		,"group_04_28" => array("title"=>"¶óÀÌÇÁÅ¬·´","column"=>"hero_life_gisu","level"=>"9994")
		,"group_04_31" => array("title"=>"Beauty/Life Club ¿µ»óÆÀ","column"=>"hero_movie_gisu","level"=>"9993")
		,"group_youtube" => array("title"=>"Youtuber","column"=>"hero_youtube_gisu","level"=>"9995")
);

$gisu_level = $gisu_type_gubun[$board]["level"];

$sqlAddMovie = "";

if($board == "group_04_27") {
	$hero_movie_group = $_GET["hero_movie_group"];
	if(!$hero_movie_group) {
		$hero_movie_group = "group_04_27";
	}
	$gisu_level = $gisu_type_gubun[$hero_movie_group]["level"];
	
	$sqlAddMovie = " and m.hero_movie_group in ('group_04_27','group_04_31') ";
}

if($_GET['kewyword']){
    $search = ' and b.'.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}

$sql = " SELECT	
			b.hero_idx, b.hero_title, b.hero_nick, b.hero_thumb, b.hero_img_new, b.hero_04
			, b.blog_url,b.cafe_url,b.sns_url,b.etc_url
			, (SELECT hero_img_new as level_img from level where hero_level='".$gisu_level."') level_img
			, m.hero_table, m.hero_movie_group, m.hero_movie_gisu
		 FROM board b inner join mission m
		 ON b.hero_01 = m.hero_idx
		 WHERE 
			b.hero_table = '".$board."'  AND m.hero_table = '".$board."' 
			AND b.hero_use = '1' AND m.hero_use = '1'
			AND b.hero_board_three = '1' ".$sqlAddMovie." ".$search." order by b.hero_today desc ";
		

sql($sql,"on");
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=20;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path=get("page||download");

?>
<link href="css/review.css" rel="stylesheet" type="text/css">

<!--ÄÁÅÙÃ÷ ½ÃÀÛ-->
     <!--<div id="title"><p><?=$right_list['hero_title'];?></p></div>-->
     
    

	<? include_once "boardIntroduce.php"; ?>
    <div class="clear"></div>
    
       <!-- gallery ½ÃÀÛ -->
    <div id="gallery">
      <ul>
<?
$main_sql = $sql.' limit '.$start.','.$list_page.';';
$out_main = @mysql_query($main_sql);
$i=0;
while($main_list                             = @mysql_fetch_assoc($out_main)){
	$ul_class = "";
	if($i%2 == 0) {
		$ul_class = "class='left'";
	}

//echo $main_list['hero_img_new'];
    $img_parser_url = $main_list['hero_img_new'];
    $img_host = $img_parser_url['host'];
    $img_path = $img_parser_url['path'];
    if($main_list['hero_thumb']){
    	$view_img = $main_list['hero_thumb'];
    }else if(!strcmp($main_list['hero_img_new'],'')){
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
    
    $level_img = str($main_list['level_img']);
    if($main_list["hero_table"] == "group_04_06") {
    	$level_img = "/image/bbs/lev_BeautyHolic.png";
    } else if($main_list["hero_table"] == "group_04_28") {
    	$level_img = "/image/bbs/lev_life.png";
    } else if($main_list["hero_table"] == "group_04_27") {
    	if($main_list["hero_movie_group"] == "group_04_27") {
    		if($main_list["hero_movie_gisu"] > 4) {
    			$level_img = "/image/bbs/lev_BeautyHolic.png";
    		} else {
    			$level_img = "/image/bbs/lev_youtuber.png";
    		}
    	} else if($main_list["hero_movie_group"] == "group_04_31") {
    		$level_img = "/image/bbs/lev_life.png";
    	}
    }
    
?>

		<ul class="mobileMissionList">
        	<li <?=$ul_class?>>
            <a href="<?=DOMAIN_END?>m/greatReview_view_01.php?board=<?=$_REQUEST['board']?>&page=<?=$page?>&hero_idx=<?=$main_list['hero_idx']?>&idx=<?=$_GET['idx']?>&hero_beauty_gisu=<?=$hero_beauty_gisu?>">
            	<div><img onerror="this.src='<?=IMAGE_END?>hero_empty.jpg';" src="<?=$view_img?>" width="100%"></div>
                <div class="title"><?=$new_img_view?>&nbsp;<?=$title_01?></div>
                <div class="date"><img src="<?=$level_img?>" height="13px" />&nbsp;<?=$main_list['hero_nick'];?></div>
            </a>
            </li>
        </ul>
        
<?
$i++;
}
?>
     </ul>
   </div>
     
     <div class="clear"></div> 
     
     <!--<div><img src="img/shadow1.jpg" alt="" width="100%" height="2px"/></div>-->
     
     
     <div id="page_number">
	 <?include_once "page.php"?>
	 </div>
      
       <!-- gallery Á¾·á --> 
<!--ÄÁÅÙÃ÷ Á¾·á-->

<!-- (e) 20170630 ¾È³»¹®±¸ Ãß°¡ -->

<script>
<? if(!strcmp($_REQUEST['download'],"ok")){?>
downMenu();
<? }?>
</script>
<?include_once "tail.php";?>