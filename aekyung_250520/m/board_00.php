<?
include_once "head.php";
if($_GET['kewyword']){
    $search = ' and hero_title like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}
//기간
if(strcmp($_GET['search_month'], '00') && strcmp($_GET['search_month'], '')){
    if(strcmp($_GET['search_month'], '99')){ //직접입력 아닐때
        $search .= "AND DATE_FORMAT(hero_today,'%Y-%m-%d') between DATE_SUB(DATE_FORMAT(NOW(),'%Y%m%d'), INTERVAL ".$_GET['search_month']." MONTH) and DATE_FORMAT(now(),'%Y%m%d')";
    } else { //직접입력일때
        $search .= "AND DATE_FORMAT(hero_today,'%Y-%m-%d') between DATE_FORMAT('".$_GET['date-from']."','%Y-%m-%d') and DATE_FORMAT('".$_GET['date-to']."','%Y-%m-%d')";
        $search_next .= "&date-from=".$_GET['date-from']."&date-to=".$_GET['date-to'];
    }

    $search_next .= "&search_month=".$_GET['search_month'];
}

$my_view 	=	$_SESSION ['temp_view'] == '' ? '0' : $_SESSION ['temp_view'];
$auth_check = "hero_use = 1 AND ";
if($my_view >= 9999) {
	$auth_check = "";
}

$sql = "select * from board where ".$auth_check." (hero_table='".$_REQUEST['board']."' or hero_03='".$_REQUEST['board']."') and event_notice='' ".$search." order by hero_today desc";

if($_GET['board']=="group_02_10") {
    $sql = "select * from board where ".$auth_check." (hero_table='group_02_03' or hero_03='group_02_03') and event_notice='1' ".$search." order by hero_today desc";
}

sql($sql,"on");
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=20;
if($_GET['board']=="group_02_03") {
	$list_page=10;
}
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;

//https://www.aklover.co.kr/m/board_00.php?board=group_01_01
$next_path=get("page||download");
######################################################################################################################################################
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
//리스트 권한체크
if($my_view != '9999' && $my_view != '10000'){
	if($my_view < $right_list['hero_list']) {
		error_historyBack("죄송합니다. 권한이 없습니다.");
		exit;
	}
}
######################################################################################################################################################
?>
<link href="/m/css/musign/board.css" rel="stylesheet" type="text/css">
<!--  -->

<!--컨텐츠 시작-->
    <div id="subpage">
        <div class="sub_wrap">
            <div class="sub_title">
                <div class="">
                    <h1 class="fz74 main_c fw500 ko">이달의 이벤트</h1> 
                    <p class="fz28 fw600">누구나 참여 가능한 이벤트에 참여해보세요!</p>                   
                </div>
                <ul class="tab f_cs">                        
                    <? if($_GET['board'] == "group_02_03") { //이벤트리스트 ?>                        
                        <li><a href="/m/board_00.php?board=group_02_03" class="fz12 fw500 on">이벤트 리스트</a></li>
                        <li><a href="/m/board_00.php?board=group_02_10" class="fz12 fw500">당첨자 발표</a></li>
                    <? }else if ($_GET['board'] == 'group_02_10') {?>
                        <li><a href="/m/board_00.php?board=group_02_03" class="fz12 fw500">이벤트 리스트</a></li>
                        <li><a href="/m/board_00.php?board=group_02_10" class="fz12 fw500 on">당첨자 발표</a></li>
                    <? } ?>                    
                </ul>
            </div>
            <div class="left">                    
                <? include_once 'searchBox.php';?>
            </div>
        </div>
                
        <!-- gallery 시작 -->
        <div id="gallery" class="guerrilla_event">
        <?         
            $main_sql = $sql.' limit '.$start.','.$list_page.';';

            $out_main = @mysql_query($main_sql);
        ?>

        <? if($_GET['board'] == "group_02_03") { //게릴라 이벤트?>
    
		<?
        
            while($main_list                             = @mysql_fetch_assoc($out_main)){

                if($main_list["hero_thumb"])	    		$view_img = $main_list['hero_thumb'];
                elseif($_GET['board']=='group_02_03')		$view_img = IMAGE_END.'hero.jpg';
                elseif($main_list["hero_img_new"] )  		$view_img = $main_list['hero_img_new'];
                else						  				$view_img = IMAGE_END.'hero.jpg';

                $start_date = str_replace(".", "", $main_list["event_start_date_02"]);
                $icon = "icon_ing";
                $ing = "진행중";


                if(strlen($main_list["event_start_date_02"]) > 13) {
                    $start_date = substr($start_date,0,8);
                    $event_start_date1 = substr($main_list['event_start_date_01'],5,9);
                    $event_start_date2 = substr($main_list['event_start_date_02'],5,9);
                    $event_end_date = substr($main_list['event_end_date'],5,9);

                    if(date('Ymd') > $start_date) {
                        $icon = "icon_end";
                        $ing = "종료";
                    }

                } else {

                    $start_date = substr($start_date,0,4);
                    $event_start_date1 = $main_list['event_start_date_01'];
                    $event_start_date2 = $main_list['event_start_date_02'];
                    $event_end_date = $main_list['event_end_date'];

                    $icon = "icon_end";
                    $ing = "종료";
                }

                if($main_list['event_notice'] == 1) {
                    $icon = "icon_notice";
                    $ing = "당첨자 발표";
                }
            
        ?>
                <div class="event_list">
                    <a href="<?=DOMAIN_END?>m/board_view_01.php?board=<?=$_REQUEST['board']?>&page=<?=$page?>&hero_idx=<?=$main_list['hero_idx']?>">
                        <div class="event_img <?=$icon?> rel">
                            <img src="<?=$view_img?>" />
                        </div>
                        <div class="event_text">
                            <p class="ptitle">
                                <span class="title fz28 fw700 ellipsis_2line"><?=$main_list['hero_title'];?></span>
                            </p>
                            <div>
                                <dl class="f_cs">
                                    <dt class="fz24 fw700">이벤트 기간</dt>
                                    <dd class="fz24 fw700 gray"><?=$event_start_date1?> ~ <?=$event_start_date2?></dd>
                                </dl>
                                <dl class="f_cs">
                                    <dt class="fz24 fw700">당첨자 발표</dt>
                                    <dd class="fz24 fw700 gray"><?=$event_end_date?></dd>
                                </dl>
                            </div>
                        </div>
                    </a>
                </div>

        	<? 
			} 
		}
        else if($_GET['board'] == "group_02_10") { //게릴라 이벤트?>

            <?

            while($main_list                             = @mysql_fetch_assoc($out_main)){

                if($main_list["hero_thumb"])	    		$view_img = $main_list['hero_thumb'];
                elseif($_GET['board']=='group_02_10')		$view_img = IMAGE_END.'hero.jpg';
                elseif($main_list["hero_img_new"] )  		$view_img = $main_list['hero_img_new'];
                else						  				$view_img = IMAGE_END.'hero.jpg';

                $start_date = str_replace(".", "", $main_list["event_start_date_02"]);
                $icon = "icon_ing";
                $ing = "진행중";


                if(strlen($main_list["event_start_date_02"]) > 13) {
                    $start_date = substr($start_date,0,8);
                    $event_start_date1 = substr($main_list['event_start_date_01'],5,9);
                    $event_start_date2 = substr($main_list['event_start_date_02'],5,9);
                    $event_end_date = substr($main_list['event_end_date'],5,9);

                    if(date('Ymd') > $start_date) {
                        $icon = "icon_end";
                        $ing = "종료";
                    }

                } else {

                    $start_date = substr($start_date,0,4);
                    $event_start_date1 = $main_list['event_start_date_01'];
                    $event_start_date2 = $main_list['event_start_date_02'];
                    $event_end_date = $main_list['event_end_date'];

                    $icon = "icon_end";
                    $ing = "종료";
                }

                if($main_list['event_notice'] == 1) {
                    $icon = "icon_notice";
                    $ing = "당첨자 발표";
                }

            ?>
            <div class="event_list">
                <a href="<?=DOMAIN_END?>m/board_view_01.php?board=<?=$_REQUEST['board']?>&page=<?=$page?>&hero_idx=<?=$main_list['hero_idx']?>">
                    <div class="event_img <?=$icon?> rel">
                        <img src="<?=$view_img?>" />
                    </div>
                    <div class="event_text">
                        <p class="ptitle">
                            <span class="title fz28 fw700 ellipsis_2line"><?=$main_list['hero_title'];?></span>
                        </p>
                        <div>
                            <dl class="f_cs">
                                <dt class="fz24 fw700">이벤트 기간</dt>
                                <dd class="fz24 fw700 gray"><?=$event_start_date1?> ~ <?=$event_start_date2?></dd>
                            </dl>
                            <dl class="f_cs">
                                <dt class="fz24 fw700">당첨자 발표</dt>
                                <dd class="fz24 fw700 gray"><?=$event_end_date?></dd>
                            </dl>
                        </div>
                    </div>
                </a>
            </div>

            <?
            }
        }else {
		?>
              <ul>
				<?
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
                        $view_img = $main_list['hero_img_new'];
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
                    $title_01 = cut($title,'35');
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
                ?>
                        <ul class="mobileMissionList">
                            <li <?=$ul_class?>>
                            <a href="<?=DOMAIN_END?>m/board_view_01.php?board=<?=$_REQUEST['board']?>&page=<?=$page?>&hero_idx=<?=$main_list['hero_idx']?>">
                                <div><img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$view_img?>" width="100%"></div>
                                <div class="title"><?=$new_img_view?>&nbsp;<?=$title_01?></div>
                                <div class="date"><img src="<?=str($pk_row['hero_img_new'])?>" height="13px" />&nbsp;<?=$pk_row['hero_nick'];?></div>
                            </a>
                            </li>
                        </ul>
                        
                <?
                $i++;
                }
                ?>
                     </ul>
	    	<?
        }
		?>
        </div>
    
     <div id="page_number" class="paging">
        <?include_once "page.php"?>      
    </div>

    <!-- gallery 종료 --> 
    
 </div>



 <?
    $sql = 'select * from hero_group where hero_board = \''.$_GET['board'].'\'';
    sql($sql, 'on');
    $check_list                             = @mysql_fetch_assoc($out_sql);
    if($check_list['hero_write']<=$_SESSION['temp_write']){
    ?>
            <div class="gallery_btn">
            <a href="<?=DOMAIN_END?>m/write.php?board=<?=$_REQUEST['board']?>&action=write" ><img src="img/general/write_btn.jpg" alt="글쓰기" width="70px"></a>
            </div> 
    <?}?>
 

<!--컨텐츠 종료-->

<script>
<? if(!strcmp($_REQUEST['download'],"ok")){?>
downMenu();
<? }?>

 $(document).ready(function(){    
    // 달력 클릭시 딤 활성화
    $('.mo_cal').click(function(){
        $('.dim').show();
    });
    // 달력 닫기시 딤 비활성화, 달력선택창 비활성화
    $('.mo_call_x').click(function(){
        $('.dim').hide(); 
        $('.datebox').hide();
    });
    // 딤클릭시 모두 비활성화
    $('.dim').click(function(){
        $(this).hide();
        $('.datebox').hide(); 
    });
 });

</script>
<?include_once "tail.php";?>