<?php
include_once "head.php";
#####################################################################################################################################################

$board = $_GET["board"];

$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);

$gisu_type_gubun = array(
		"group_04_06" => array("title"=>"Beauty Club","column"=>"hero_beauty_gisu","level"=>"9996")
		,"group_04_27" => array("title"=>"Beauty/Life Club ������","column"=>"hero_movie_gisu","level"=>"9995")
		,"group_04_28" => array("title"=>"Life Club","column"=>"hero_life_gisu","level"=>"9994")
		,"group_04_31" => array("title"=>"Beauty/Life Club ������","column"=>"hero_movie_gisu","level"=>"9993")
		,"group_youtube" => array("title"=>"Youtuber","column"=>"hero_youtube_gisu","level"=>"9995")
);

$gisu_column = $gisu_type_gubun[$board]["column"];
$gisu_level = $gisu_type_gubun[$board]["level"];

$sqlAddMovie = "";
if($board == "group_04_27") {
	$hero_movie_group = $_GET["hero_movie_group"];
	
	if(!$hero_movie_group) {
		//$hero_movie_group = "group_04_27";
		$gisu_column = "";
	}
	
	
	$gisu_level = $gisu_type_gubun[$hero_movie_group]["level"];
	if($hero_movie_group == "group_youtube") {
		$sqlAddMovie = " AND hero_youtube_gisu <= 4 ";
	} else if($hero_movie_group == "group_04_27") {
		$sqlAddMovie = " AND hero_movie_group = '".$hero_movie_group."' AND hero_movie_gisu > 4 ";
	} else if($hero_movie_group == "group_04_31") {
		$sqlAddMovie = " AND hero_movie_group = '".$hero_movie_group."' ";
	}
}

//������ �����̼��� ���� (hero_type �����̼�  : 7)
$gisu_sql  = " SELECT distinct(ifnull(".$gisu_column.",1)) as ".$gisu_column." FROM mission WHERE hero_table = '".$board."' AND hero_type != '7' ";
$gisu_sql .= " AND hero_use = 1 ".$sqlAddMovie;
$gisu_sql .= " order by ".$gisu_column." desc ";

$res = new_sql($gisu_sql, $error);

$res_gisu_list = array();
while($list = mysql_fetch_assoc($res)){
	$res_gisu_list[] = $list;
}

$hero_gisu = "";
$hero_gisu = $_GET["hero_gisu"];
$sql_gisu = "";
if($hero_gisu) {
	$sql_gisu = " AND m.".$gisu_type_gubun[$board]["column"]." = '".$hero_gisu."' ";
}




$sql  = " SELECT count(*) FROM board b inner join mission m ON b.hero_01 = m.hero_idx ";
$sql .= " WHERE b.hero_table = '".$board."'  AND m.hero_table = '".$board."' "; 
$sql .= " AND b.hero_use = '1' AND m.hero_use = '1' ";
//$sql .= " AND m.".$gisu_column." = '".$hero_gisu."' ".$sqlAddMovie;
$sql .= $sql_gisu.$sqlAddMovie;

$count_res = new_sql($sql,$error,"on");
$total_data = mysql_result($count_res,0,0);
######################################################################################################################################################
$list_page=20;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path=get("page||download");

?>
<link href="css/review.css" rel="stylesheet" type="text/css">
<!--������ ����-->
     <!--<div id="title"><p><?=$right_list['hero_title'];?></p></div>-->
     
    

	<? include_once "boardIntroduce.php"; ?>
    <div class="clear"></div>
    
    <div class="gisuWrap">
        		<? if($board == "group_04_27") {?>
					<span class="titBox">	
					<? if($hero_movie_group) {?>
	    				�� <?=$gisu_type_gubun[$hero_movie_group]["title"]?>
	    			<? } else { ?>
	    				�� Beauty/Life Club ������	
	    			<? } ?>  
        			<? if($hero_gisu){?><?=$hero_gisu;?>��<? } ?>
        			</span>
	        		<div class="btnGisuWrap" style="position:relative; text-align:right">
	        			<select name="hero_movie_group" onChange="fnMovieGroup(this.value)" style="right:135px;">
	        				<option value="">������ ����</option>
		        			<option value="group_04_27" <?=$hero_movie_group == "group_04_27" ? "selected":"";?>>Beauty Club</option>
							<option value="group_04_31" <?=$hero_movie_group == "group_04_31" ? "selected":"";?>>Life Club</option>
							<option value="group_youtube" <?=$hero_movie_group == "group_youtube" ? "selected":"";?>>Youtuber</option>
		        		</select>
		        		<select name="hero_movie_gisu" id="hero_movie_gisu">
		        			<option value="">��� ����</option>
		        			<? foreach($res_gisu_list as $rs_gisu) { ?>
		        				<option value="<?=$rs_gisu[$gisu_column]?>" <?=$rs_gisu[$gisu_column]==$hero_gisu ? "selected":"";?>><?=$rs_gisu[$gisu_column]?>��</option>
		        			<? } ?>
		        		</select>
		        		<a href="javascript:;" onClick="fnMovieGisu()">�̵�</a>
        			</div>
        		<? } else { ?>
        		<span class="titBox">�� <?=$gisu_type_gubun[$board]["title"]?>
        			<? if($hero_gisu){?><?=$hero_gisu;?>��<? } ?>
				</span>
        		<div class="btnGisuWrap">
        			
	        		<select name="hero_gisu" id="hero_gisu" style="width:180px;">
	        			<option value=""><?=$gisu_type_gubun[$board]["title"]?> ��� ����</option>
	        			<? foreach($res_gisu_list as $rs_gisu) { ?>
	        				<option value="<?=$rs_gisu[$gisu_column]?>" <?=$rs_gisu[$gisu_column]==$hero_gisu ? "selected":"";?>><?=$gisu_type_gubun[$board]["title"]?> <?=$rs_gisu[$gisu_column]?>��</option>
	        			<? } ?>
	        		</select>
	        		<a href="javascript:;" onClick="fnGisu()">�̵�</a>
        		</div>
        		<? } ?>
        	</div> 

       <!-- gallery ���� -->
    <div id="gallery">
      <ul>
<?
$main_sql = " 
								SELECT hero_idx, hero_title, hero_nick, hero_thumb, hero_img_new, hero_04
									  , blog_url, cafe_url, sns_url, etc_url, hero_board_three
									  , (SELECT count(*) FROM mission_url WHERE board_hero_idx = a.hero_idx) as url_cnt 	
									  , (SELECT hero_img_new as level_img from level where hero_level=a.hero_level) level_img
									  , hero_table, hero_movie_group, hero_movie_gisu
									FROM
									(SELECT
									b.hero_idx, b.hero_title, b.hero_nick, b.hero_thumb, b.hero_img_new, b.hero_04
									, b.blog_url,b.cafe_url,b.sns_url,b.etc_url,b.hero_board_three, b.hero_code
									, mem.hero_level
									, m.hero_table, m.hero_movie_group, m.hero_movie_gisu
									FROM board b inner join mission m
									on b.hero_01 = m.hero_idx
									LEFT JOIN member mem on b.hero_code = mem.hero_code
									WHERE
									b.hero_table = '".$board."'  AND m.hero_table = '".$board."'
									AND b.hero_use = '1' AND m.hero_use = '1'
									".$sql_gisu.$sqlAddMovie." ORDER BY b.hero_today DESC LIMIT ".$start.",".$list_page ." ) a ";

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
        	
            <a href="<?=DOMAIN_END?>m/missionReview_view_01.php?<?=get("hero_idx||hero_life_gisu||statusSearch||hero_gisu")?>&hero_idx=<?=$main_list['hero_idx']?>&hero_gisu=<?=$hero_gisu?>">
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
      
<!--������ ����-->

<!-- (s) 20170630 �ȳ����� �߰� -->
<? if($_REQUEST['board']=="group_04_10") { //����ı�?>
<div class="explainWrap1">
    <div class="cont1">
        <p class="tit">�س��� ��� �ı⿡ ä�õǷ���?</p>
        
        <p class="subTit">1. ������Ƽ�� ������</p>
        <p class="txt">- ������ �ִ� ��<br/>
                       - ���ϰ� �������� ��ǰ ������ ���� ���� �ڼ��� ������ <br/>
                       - ������ �̹��� ���(��ȭ��, ����, ��� ��)<br/>
                       - �پ��� ��ǰ Ȱ�� �� ���(��Ÿ�ϸ� ��, ��� ���� ��, Before/After �� ��)<br/>
                       - ����&GIF ���� ��Ȯ�� Ÿ�ֿ̹� �����ϰ� ���
        
        </p>
        
        <p class="subTit">2. ������ �ִ� ������</p>
        
        <p class="txt">- ��ǰ�� ���� �Ẹ�� ������ ���� �����ϰ� �ۼ��� ������<br/>
                       - ������ �̾߱⸦ ���� ���丮�ڸ��� ���Ͽ� �д��̿��� ������ �ִ� ������<br/>
                       - ��Ȯ�� ���� �������� �д��̿��� ������ �ִ� ������
        
        </p>   
        <a href="/m/aklover.php?board=group_04_01" class="btn lo1">AK LOVER��?</a>
   		<a href="/m/truly.php?board=group_04_13" class="btn lo2">AK LOVER�� ������</a>
    </div>
    
    
</div>
<? } ?>
<!-- (e) 20170630 �ȳ����� �߰� -->

<script>
function fnMovieGroup(val) {
	location.href = "/m/missionReview.php?board=<?=$board?>&hero_movie_group="+val;
}

function fnMovieGisu() {
	location.href = "/m/missionReview.php?board=<?=$board?>&hero_movie_group=<?=$hero_movie_group?>&hero_gisu="+$("select[name='hero_movie_gisu']").val();
}

function fnGisu(){
	var val = $("#hero_gisu").val();
	location.href = "/m/missionReview.php?board=<?=$board?>&hero_gisu="+val; 
}

<? if(!strcmp($_REQUEST['download'],"ok")){?>
downMenu();
<? }?>
</script>
<?include_once "tail.php";?>
