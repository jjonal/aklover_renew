<?php
include_once "head.php";
#####################################################################################################################################################

if($_GET['kewyword']){
    $search = ' and hero_title like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&kewyword='.$_GET['kewyword'];
}

$sql = "select hero_idx, hero_thumb, hero_title, hero_period_01, hero_period_02 from mission_after where 1=1 ".$search;//hero_today_04_22 desc
sql($sql,"on");
$total_data = @mysql_num_rows($out_sql);


######################################################################################################################################################

$list_page=20;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;

//https://aklover.co.kr:11486/m/board_00.php?board=group_01_01
$next_path=get("page");
######################################################################################################################################################
$group_sql = 'select hero_title from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\'';//desc
//echo $group_sql;
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
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

<link rel="stylesheet" type="text/css" href="/m/css/musign/board.css" />
<link rel="stylesheet" type="text/css" href="/m/css/musign/cscenter.css" />
<link rel="stylesheet" type="text/css" href="/m/css/musign/review.css" />
<!--컨텐츠 시작-->

<div id="subpage" class="reviewpage moim_review">  
    <div class="sub_wrap">
        <div class="sub_title">
            <div class="">
                <h1 class="fz74 main_c fw500 ko">모임 콘텐츠</h1> 
                <p class="fz28 fw600">AK Lover의 즐거운 모임 현장을 느껴보세요!</p>                   
            </div>
            <ul class="tab f_cs">                        
                <li><a href="/m/board_02.php?board=group_04_10" class="fz12 fw500">우수 콘텐츠</a></li>
                <li><a href="/m/board_01.php?board=group_04_09" class="fz12 fw500">전체 콘텐츠</a></li>     
                <li><a href="/m/meeting_list.php?board=group_04_22" class="fz12 fw500 on">모임 콘텐츠</a></li>             
            </ul>
        </div>
    </div>
    <div class="btnTodayWrap today_list" style="padding-top: 15px;">
        <? include_once 'searchBox.php';?>
    </div>

    <!-- gallery 시작 -->
    <div id="gallery" class="moim">      
        <ul class="grid_3">
            <?
            $main_sql = $sql. "order by hero_period_01 desc limit ".$start.",".$list_page.";";
            $out_main = @mysql_query($main_sql);
            $i=0;
            while($main_list                             = @mysql_fetch_assoc($out_main)){
                $ul_class = "";
                if($i%2 == 0) {
                    $ul_class = "";
                }
                if($main_list['hero_thumb']){
                    $view_img = $main_list['hero_thumb'];
                }
                $title = $main_list['hero_title'];
                $title = TRIM(str_ireplace('&nbsp;', '', strip_tags(htmlspecialchars_decode($title))));
                $title = str_replace("\r", "", $title);
                $title = str_replace("\n", "", $title);
                $title = str_replace("&#65279;", "", $title);
                $title_01 = $title;//cut($title,'50');
                if(!strcmp($title_01,"")){
                    $title_01 = "&nbsp;";
                }                
            ?>
        	<li <?=$ul_class?>>
            <a href="<?=DOMAIN_END?>m/meeting_view.php?board=<?=$_REQUEST['board']?>&idx=<?=$main_list["hero_idx"]?>">
            	<div><img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$view_img?>" width="100%" height="150px"></div>
                <div class="event_text"><p class="ptitle"><span class="title ellipsis_2line fz28 fw600"><?=cut($title_01,90)?></span></p></div>
                <!-- <div class="date">
                    기간 : <?=date("y년 m월 d일",strtotime($main_list["hero_period_01"]))."(".yoil($main_list["hero_period_01"]).")"?> ~<br/><?=date("y년 m월 d일",strtotime($main_list["hero_period_02"]))."(".yoil($main_list["hero_period_02"]).")"?>
                </div> -->
            </a>
            </li>
            <?
            $i++;
            }
            ?>
     </ul>
      </div>
	       
      <div id="page_number" class="paging" style="margin-bottom: 0;"> 
        <?include_once "page.php"?>
      </div>

       <!-- gallery 종료 -->       
</div>    
<!--컨텐츠 종료-->

<script>
<? if(!strcmp($_REQUEST['download'],"ok")){?>
downMenu();
<? }?>
</script>
<?include_once "tail.php";?>