<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
##변수 설정
######################################################################################################################################################
//검색어
if($_GET['kewyword']){
	if($_GET['select']=="hero_title" || $_GET['select']=="hero_command")	$search = " and A.".$_GET['select']." like '%".$_GET['kewyword']."%'";
	else if($_GET['select']=="hero_all")									$search = " and (A.hero_title like '%".$_GET['kewyword']."%' or A.hero_command like '%".$_GET['kewyword']."%')";
	else																	$search = " and B.".$_GET['select']." like '%".$_GET['kewyword']."%'";
	$search_next = "&select=".$_GET['select']."&kewyword=".stripslashes($_GET['kewyword']);
}
//기간
if(strcmp($_GET['search_month'], '00') && strcmp($_GET['search_month'], '')){
    if(strcmp($_GET['search_month'], '99')){ //직접입력 아닐때
        $search .= "AND DATE_FORMAT(A.hero_today,'%Y-%m-%d') between DATE_SUB(DATE_FORMAT(NOW(),'%Y%m%d'), INTERVAL ".$_GET['search_month']." MONTH) and DATE_FORMAT(now(),'%Y%m%d')";
    } else { //직접입력일때
        $search .= "AND DATE_FORMAT(A.hero_today,'%Y-%m-%d') between DATE_FORMAT('".$_GET['date-from']."','%Y-%m-%d') and DATE_FORMAT('".$_GET['date-to']."','%Y-%m-%d')";
        $search_next .= "&date-from=".$_GET['date-from']."&date-to=".$_GET['date-to'];
    }

    $search_next .= "&search_month=".$_GET['search_month'];
}

$cut_count_name = '8';
$cut_title_name = '50';
$list_page = 15;
if($_GET['board']=="group_02_03") {
	$list_page = 15;
}
$page_per_list = 9;

$page = $_GET['page'];
if(!is_numeric($_GET['page']))	$page = '1';
else							$page = $_GET['page'];
$start = ($page-1)*$list_page;

$board = $_GET['board'];

$next_path="board=".$board.$search_next;

$my_view 	=	$_SESSION ['temp_view'] == '' ? '0' : $_SESSION ['temp_view'];
$auth_check = "A.hero_use = 1 AND ";
if($my_view >= 9999) {
	$auth_check = "";
}
######################################################################################################################################################
$error = "THUMBNAIL_03_LIST_01";
$event_notice = "";
if($board == "group_02_03"){
    $event_notice = "AND A.event_notice = 0";
}else if($board == "group_02_10"){
    $event_notice = "AND A.event_notice = 1";
}

$count_board = "";
if($board == "group_02_10"){
    $count_board = "group_02_03";
}else {
    $count_board = $board;
}
$sql = "select count(*) from board as A, member as B where ".$auth_check." A.hero_code=B.hero_code ".$event_notice." and (A.hero_table='".$count_board."' or A.hero_03='".$count_board."') ".$search;
//echo $sql;
$count_res = new_sql($sql,$error,"on");
if((string)$count_res==$error){
	error_historyBack("");
	exit;
}

$total_data = mysql_result($count_res,0,0);
######################################################################################################################################################
$error = "THUMBNAIL_03_LIST_02";
$sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$board."'";
$right_res = new_sql($sql,$error);
if((string)$right_res==$error){
	error_historyBack("");
	exit;
}
$right_list                             = @mysql_fetch_assoc($right_res);

//리스트 권한체크
if($my_view != '9999' && $my_view != '10000'){
	if($my_view < $right_list['hero_list']) {
        error_historyBack("죄송합니다. 권한이 없습니다.");
		exit;
	}
}

######################################################################################################################################################

?>

    <div id="subpage">
        <div class="sub_title">
            <div class="sub_wrap">
                <div class="f_b">
                    <div>
                        <h1 class="fz68 main_c fw500 ko">이달의 이벤트</h1>
                        <p class="fz18 fw600">누구나 참여 가능한 이벤트에 참여해보세요!</p>
                    </div>
                    <ul class="tab f_c">
                        <? if($_GET['board'] == "group_02_03") { //이벤트리스트 ?>
                            <li><a href="http://aklover.co.kr/main/index.php?board=group_02_03" class="fz18 fw600 on">이벤트 리스트</a></li>
                            <li><a href="http://aklover.co.kr/main/index.php?board=group_02_10" class="fz18 fw600">당첨자 발표</a></li>
                        <? }else if ($_GET['board'] == 'group_02_10') {?>
                            <li><a href="http://aklover.co.kr/main/index.php?board=group_02_03" class="fz18 fw600">이벤트 리스트</a></li>
                            <li><a href="http://aklover.co.kr/main/index.php?board=group_02_10" class="fz18 fw600 on">당첨자 발표</a></li>
                        <? } ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="sub_cont">
            <div class="sub_wrap board_wrap f_sb">
                <div class="left">
                    <? include_once BOARD_INC_END.'search.php';?>
                </div>
                <div class="contents right">

                    <!-- <? include_once("{$_SERVER[DOCUMENT_ROOT]}/include/listHeadTitle.php") ?> -->
                    <?
                        $error = "THUMBNAIL_03_LIST_03";
                        $sql = "select * ";
                        $sql .= "from (select A.hero_idx, A.hero_code, A.hero_table, A.hero_command, A.hero_thumb, A.hero_img_new, A.hero_today ";
                        $sql .= ", A.hero_title,A.hero_04, B.hero_level, B.hero_nick, A.event_start_date_01,A.event_start_date_02,A.event_end_date,A.event_small_title,A.event_notice from board as A, member as B where ".$auth_check." A.event_notice = 0 and A.hero_code=B.hero_code and (A.hero_table='".$board."' or A.hero_03='".$board."') ".$search." order by A.hero_today desc limit ".$start.",".$list_page.") as A ";
                        //$sql .= ", A.hero_title,A.hero_04, B.hero_level, B.hero_nick, A.event_start_date_01,A.event_start_date_02,A.event_end_date,A.event_small_title from board as A, member as B where ".$auth_check." A.hero_code=B.hero_code and (A.hero_table='".$board."' or A.hero_03='".$board."') ".$search." order by A.hero_today desc limit ".$start.",".$list_page.") as A ";
                        $sql .= ",(select hero_img_new as level_img, hero_level from level) as C where C.hero_level=A.hero_level order by A.hero_today desc";

                        $main_res = new_sql($sql,$error);
                        if((string)$main_res==$error){
                            error_historyBack("");
                            exit;
                        }

                        $data_count = mysql_num_rows($main_res);
                    ?>

                    <? if($_GET['board'] == "group_02_03") { //이달의 이벤트?>
                        <!-- 이벤트 리스트 -->
                        <div class="guerrilla_event grid_3 on">
                        <?
                        while($list = mysql_fetch_assoc($main_res)){

                            if($list["hero_thumb"])	    			$view_img = $list['hero_thumb'];
                            elseif($_GET['board']=='group_02_03')	$view_img = IMAGE_END.'hero.jpg';
                            elseif($list["hero_img_new"] )  		$view_img = $list['hero_img_new'];
                            else						  			$view_img = IMAGE_END.'hero.jpg';

                            $url = PATH_HOME."?board=".$board."&page=".$page."&view=view&idx=".$list['hero_idx'];

                            $start_date = str_replace(".", "", $list["event_start_date_02"]);
                            $icon = "icon_ing";
                            $ing = "진행중";
                            if(strlen($list["event_start_date_02"]) > 13) {
                                $start_date = substr($start_date,0,8);
                                $event_start_date1 = substr($list['event_start_date_01'],5,9);
                                $event_start_date2 = substr($list['event_start_date_02'],5,9);
                                $event_end_date = substr($list['event_end_date'],5,9);

                                if(date('Ymd') > $start_date) {
                                    $icon = "icon_end";
                                    $ing = "종료";
                                }
                            } else {
                                $start_date = substr($start_date,0,4);
                                $event_start_date1 = $list['event_start_date_01'];
                                $event_start_date2 = $list['event_start_date_02'];
                                $event_end_date = $list['event_end_date'];

                                $icon = "icon_end";
                                $ing = "종료";
                            }
                            if($list['event_notice'] == 1) {
                                $icon = "icon_notice";
                                $ing = "당첨자 발표";
                                continue;
                            }
                        ?>
                                <div class="event_list">
                                    <a href="<?=$url?>">
                                        <div class="event_img <?=$icon?> rel">
                                            <img src="<?=$view_img?>" />
                                        </div>
                                        <div class="event_text">
                                            <p class="ptitle">
                                                <span class="title ellipsis_2line fz18 fw600"><?=cut($list['hero_title'], '40')?></span>
                                            </p>
                                            <div>
                                                <dl class="f_cs">
                                                    <dt class="fz15 fw600">이벤트 기간</dt>
                                                    <dd class="fz15 fw600 gray"><?=$event_start_date1?> ~ <?=$event_start_date2?></dd>
                                                </dl>
                                                <dl class="f_cs">
                                                    <dt class="fz15 fw600">당첨자 발표</dt>
                                                    <dd class="fz15 fw600 gray"><?=$event_end_date?></dd>
                                                </dl>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                        <? } ?>
                        </div>
                        <div class="admin_btn">
                            <? include BOARD_INC_END.'button.php';?>

                        </div>
                    <? }else if ($_GET['board'] == 'group_02_10') {?>
                        <!-- 당첨자 발표 -->
                        <div class="guerrilla_event grid_3">
                            <?
//                            $total_data  = '1000';
                            $error = "THUMBNAIL_03_LIST_03";
                            $sql = "select * ";
                            $sql .= "from (select A.hero_idx, A.hero_code, A.hero_table, A.hero_command, A.hero_thumb, A.hero_img_new, A.hero_today ";
                            $sql .= ", A.hero_title,A.hero_04, B.hero_level, B.hero_nick, A.event_start_date_01,A.event_start_date_02,A.event_end_date,A.event_small_title,A.event_notice from board as A, member as B where ".$auth_check." A.event_notice = 1 and A.hero_code=B.hero_code and (A.hero_table='group_02_03' or A.hero_03='group_02_03') ".$search." order by A.hero_today desc limit ".$start.",".$list_page.") as A ";
                            //$sql .= ", A.hero_title,A.hero_04, B.hero_level, B.hero_nick, A.event_start_date_01,A.event_start_date_02,A.event_end_date,A.event_small_title from board as A, member as B where ".$auth_check." A.hero_code=B.hero_code and (A.hero_table='".$board."' or A.hero_03='".$board."') ".$search." order by A.hero_today desc limit ".$start.",".$list_page.") as A ";
                            $sql .= ",(select hero_img_new as level_img, hero_level from level) as C where C.hero_level=A.hero_level order by A.hero_today desc";

                            $main_res = new_sql($sql,$error);

                            while($list = mysql_fetch_assoc($main_res)){

                                if($list["hero_thumb"])	    			$view_img = $list['hero_thumb'];
                                elseif($_GET['board']=='group_02_10')	$view_img = IMAGE_END.'hero.jpg';
                                elseif($list["hero_img_new"] )  		$view_img = $list['hero_img_new'];
                                else						  			$view_img = IMAGE_END.'hero.jpg';

                                $url = PATH_HOME."?board=".$board."&page=".$page."&view=view&idx=".$list['hero_idx'];

                                if($list['event_notice'] == 1) {
                                    $icon = "icon_notice";
                                    $ing = "당첨자 발표";


                                ?>
                                    <div class="event_list">
                                        <a href="<?=$url?>">
                                            <div class="event_img <?=$icon?> rel">
                                                <img src="<?=$view_img?>" />
                                            </div>
                                            <div class="event_text">
                                                <p class="ptitle">
                                                    <span class="title ellipsis_2line fz18 fw600"><?=cut($list['hero_title'], '40')?></span>
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                <? } ?>
                            <? } ?>
                        </div>
                        <div class="admin_btn">
                            <? include BOARD_INC_END.'button.php';?>
                        </div>
                    <? }else { //기자단 활동 ?>
                    <div class="blog_box2" style="margin-top:30px">
                        <ul class="blog_article">
                        <?
                        $i = 1;
                        $dd = 1;
                        $total_html = "";
                        while($list = mysql_fetch_assoc($main_res)){

                            if($list["hero_thumb"])	    			$view_img = $list['hero_thumb'];
                            elseif($_GET['board']=='group_02_03')	$view_img = IMAGE_END.'hero.jpg';
                            elseif($list["hero_img_new"] )  		$view_img = $list['hero_img_new'];
                            else						  			$view_img = IMAGE_END.'hero.jpg';

                            $error = "THUMBNAIL_03_LIST_04";
                            $review_sql = "select count(*) from review where hero_old_idx='".$list['hero_idx']."'";
                            $review_res = new_sql($review_sql,$error);

                            if((string)$review_res==$error){
                                error_historyBack("");
                                exit;
                            }

                            $review_data = mysql_result($review_res,0,0);

                            if($review_data>0)				$re_count_total = "<strong><font color='orange'>[".$review_data."]</font></strong>";
                            else							$re_count_total = "";

                            if (strcmp($dd,'3'))		$total_html .= "<li>";
                            else if(!strcmp($dd,'3')){
                                $total_html .= "<li class='last'>";
                                $dd = '0';
                            }

                            $total_html .= "<div align='center' title='제목:".$list['hero_title']."\n\n작성일:".date( "Y-m-d", strtotime($list['hero_today']))."\n\n작성자:".$list['hero_nick']."'>";
                            $total_html .= "<a href='".PATH_HOME."?board=".$board."&page=".$page."&view=view&idx=".$list['hero_idx']."'>";
                            $total_html .= "<img src='".$view_img."' >";
                            $total_html .= "<span class='title'>".cut($list['hero_title'], '30').$re_count_total."</span>";
                            if($list["hero_level"] > 0) {
                                $total_html .= "<span class='date'><center>";
                                $total_html .= "<img src='".str($list["level_img"])."' style='width:20px;height:20px' /> ";
                                $total_html .= 	$list['hero_nick']."</center></span>";
                            }
                            $total_html .= "</a>";
                            $total_html .= "</div>";
                            $total_html .= "</li>";

                            $i++;
                            $dd++;
                        }
                            echo $total_html;
                        ?>
                            </ul>
                        </div>
                    <? } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            //이벤트리스트 탭
            // const tabTitle = $('.sub_wrap .tab a');
            // const tabCont = $('.guerrilla_event');
            // $.each(tabTitle, function(idx, item){
            //     $(this).click(function(e){
                    // e.preventDefault();
                    // tabTitle.removeClass('on');
                    // $(this).addClass('on');
                    // tabCont.removeClass('on');
                    // tabCont.eq(idx).addClass('on');
            //     });
            // });
        });
    </script>