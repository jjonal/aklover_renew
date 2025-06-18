<link rel="stylesheet" href="/css/front/main.css">
<script type="text/javascript" src="/js/musign/main.js"></script>
<script type="text/javascript" src="/js/musign/library/gsap.js"></script>
<script src="/js/musign/popup_close_period.js"></script>

<?
if(!defined('_HEROBOARD_')){echo '<script>location.href="index.php"</script>';exit;}

$loyal_period_sql = " SELECT if(startdate <= date_format(now(),'%Y-%m-%d') AND enddate >= date_format(now(),'%Y-%m-%d'),1,0) as status, hero_month FROM member_loyal_period ";
$loyal_period_res = sql($loyal_period_sql);
$loyal_period_rs = mysql_fetch_assoc($loyal_period_res);

if($loyal_period_rs["status"] == "1") { //공개

    $startDateOfMonth = date("Y-m")."-01";
    $timestamp = strtotime($startDateOfMonth)-1;
    $gisu_date = date("Ym", $timestamp);
    $gisu_year = substr($gisu_date,0,4);
    $gisu_month = substr($gisu_date,4,2);

    $hero_month = "";
    if($loyal_period_rs["hero_month"] > 0) {
        $hero_month = $loyal_period_rs["hero_month"]."월 ";
    }

    //이달의 Loyal 회원
    $review_member_sql =  " SELECT m.hero_nick FROM member_loyal l INNER JOIN member m ON l.hero_code = m.hero_code ";
    $review_member_sql .= " WHERE gisu_year = '".$gisu_year."' AND gisu_month = '".$gisu_month."' ORDER BY l.hero_idx ASC ";
    $review_member_res = sql($review_member_sql);
}

?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>


<!-- main -->
<div class="content_wrapper main_index main_01">    
    <!-- visuall banner -->
    <?
    $sql = "select hero_type,hero_period,hero_title, hero_subtitle, hero_main, hero_href, hero_box_title, hero_box_content, hero_box_background, hero_box_color, hero_box_use from banner where hero_use='1' ";
    $sql .= " and ('".date("Y-m-d H:i:s")."' between hero_today_01 and hero_today_02) order by hero_order asc";
    sql($sql);

    $rollimg_count = @mysql_num_rows($out_sql);
    ?>
    <section class="sec01 main_slide buttonsd">
        <div class="swiper01">
            <div class="swiper-container slider">
                <div class="swiper-wrapper">
                <?
                while($roll_list = @mysql_fetch_assoc($out_sql)){
                    if($roll_list['hero_box_background'] != "") $backColor = "style='background:".$roll_list['hero_box_background']."';";
                    else $backColor = "style='background:#f68427'";

                    if($roll_list['hero_box_color']) $color = "style='color:".$roll_list['hero_box_color']."';";
                    else $color = "style='color:#fff'";

                    echo "<div class='swiper-slide'>";
                    ?>
                    <a onMouseDown="eval('try{ _trk_clickTrace( \'EVT\', \'메인배너\' ); }catch(_e){ }');" href="<?=$roll_list['hero_href']?>" data-hero_period="<?=$roll_list['hero_period']?>" data-hero_title="<?=$roll_list['hero_title']?>" data-hero_subtitle="<?=$roll_list['hero_subtitle']?>">
                        <img src="/aklover/photo/<?=$roll_list["hero_main"];?>" alt="메인배너" class="img-banner" />
                    </a>
                    <?
                    echo "</div>";
                }
                ?>
                </div>
            </div>
            <div class="swbtn_wrap rel f_c">
                <div class="swiper-pagination"></div>  
                <div class="play_btn swiper-button-pause"><img src="/img/front/icon/stop.png" alt="pause" style="width: 7px;"></div>
                <div class="play_btn swiper-button-play"><img src="/img/front/icon/play.png" alt="play" style="width: 6px;"></div>
            </div> 
            <div class="swiper-button">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </section>
    <!--// visuall banner -->
    <!-- supporters -->
    <section class="section2 sec_suppoter main_display">
        <div class="full_wr">
            <div class="section_tit">            
                <span class="fz20 fw600 tit">참여해요, 서포터즈</span>
                <h1 class="fz86 main_c en">With Supporters</h1>
            </div>
            <div class="section_cont f_cs">
                <div class="tabtit">
                    <ul>
                        <li class="">
                            <p class="tit depth1_c">Premier</p>
                            <div class="hash_box" style="display: none;">
                                <div>
                                    <span class="depth1 depth1_cs">Premier Beauty</span>
                                    <span class="depth1">Premier Life</span>
                                </div>
                            </div>
                        </li>
                        <li class="on">
                            <p class="tit depth1 act">Basic</p>
                            <div class="hash_box act" style="display: block;">
                                <div>
                                    <span class="depth1_s">Basic Beauty & life</span>
                                </div>
                            </div>
                        </li>
                    </ul>                    
                    <div class="tit_bg">
                        <?
                        $sql = "SELECT * FROM with_supporters_mo order by hero_idx;";
                        sql($sql);

                        while ($supporters_list = @mysql_fetch_assoc($out_sql)){
                            if($supporters_list['hero_cate'] == 'Beauty')   $style = 'style="display: inline"';
                            else                                            $style = 'style="display: none;"';
                            ?>
                            <img src="/aklover/photo/<?=$supporters_list['hero_main']?>" alt="<?=$supporters_list['hero_cate']?>" <?=$style?>>
                            <?
                        }
                        ?>
                    </div>
                </div>
                <div class="tabcont">
                    <div class="tabbox">
                        <ul class="f_fs cursor_cont">
                            <!--뷰티-->
                            <?
                            $list_sql = "SELECT * FROM mission WHERE hero_kind != '구매체험' AND hero_table = 'group_04_06' ";
                            if($_SESSION['temp_level'] < 9999 ){
                                $list_sql .=" AND hero_use = 1 AND ((hero_today_05_01 is null or hero_today_05_01='') or (hero_today_05_01 is not null and hero_today_05_01 != '' AND '".date("Y-m-d H:i")."' >= hero_today_05_01)) ";
                                $list_sql .=" AND ((hero_today_05_02 is null or hero_today_05_02 ='') OR (hero_today_05_02 is not null and hero_today_05_02 != '' AND '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
                            }
                            $list_sql .=" ORDER BY hero_priority DESC,
								CASE WHEN (hero_today_01_01<='".date('Y-m-d 00:00:00')."' and hero_today_01_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_01_01 END DESC,
								CASE WHEN (hero_today_02_01<='".date('Y-m-d 00:00:00')."' and hero_today_02_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_02_01 END DESC,
								CASE WHEN (hero_today_03_01<='".date('Y-m-d 00:00:00')."' and hero_today_03_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_03_01 END DESC,
								CASE WHEN (hero_today_04_01<='".date('Y-m-d 00:00:00')."' and hero_today_04_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END DESC,
								CASE WHEN (hero_today_04_02<='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END desc ";
                            $list_sql .= " , hero_today_01_01 DESC ";
                            $list_sql .= "LIMIT 0,3";

                            sql($list_sql, 'on');

                            while($list = @mysql_fetch_assoc($out_sql)){
                                $check_day = date( "Y-m-d", time());
                                $today_01_01 = date( "Y-m-d", strtotime($list['hero_today_01_01']));
                                $today_01_02 = date( "Y-m-d", strtotime($list['hero_today_01_02']));
                                $today_02_01 = date( "Y-m-d", strtotime($list['hero_today_02_01']));
                                $today_02_02 = date( "Y-m-d", strtotime($list['hero_today_02_02']));
                                $today_03_01 = date( "Y-m-d", strtotime($list['hero_today_03_01']));
                                $today_03_02 = date( "Y-m-d", strtotime($list['hero_today_03_02']));
                                $today_04_01 = date( "Y-m-d", strtotime($list['hero_today_04_01']));
                                $today_04_02 = date( "Y-m-d", strtotime($list['hero_today_04_02']));
                                $today_05_01 = date( "Y-m-d", strtotime($list['hero_today_05_01']));
                                $today_05_02 = date( "Y-m-d", strtotime($list['hero_today_05_02']));

                                $status_txt = "";
                                $status = "";
                                $period_day = "";
                                $ribbon_text = "";
                                $type_check = "";

                                $ribbon_text = $list['hero_kind'];
                                if($list['hero_type'] == "4" || $list['hero_type'] == "7") {
                                    $ribbon_text = $list['hero_kind'];
                                }

                                if($list['hero_type'] == "7" || $list['hero_type'] == "9") { //자율미션, 정기미션(선택)
                                    if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                        $status_txt = "체험단 신청";
                                        $status = "1";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                        $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                        $status_txt = "선정자 발표";
                                        $status = "2";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
                                        $period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                        $status_txt = "후기등록";
                                        $status = "3";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
                                        $period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
                                        $status_txt = "우수후기발표";
                                        $status = "4";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                        $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                                    }else if($today_04_02<$check_day){
                                        $status_txt = "체험단 마감";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }else if($today_05_01>$check_day){
                                        $status_txt = "체험단 노출예정";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }
                                } else {
                                    if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                        $status_txt = "후기등록";
                                        $status = "3";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                        $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                    }else if($today_01_02<$check_day){
                                        $status_txt = "체험단 마감";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                    }else if($today_05_01>$check_day){
                                        $status_txt = "체험단 노출예정";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                    }
                                }
                                ?>
                                <li>
                                    <a href="<?=PATH_HOME?>?board=group_04_06&page=1&view=view&idx=<?=$list['hero_idx']?>">
                                        <div class="img_bx">
                                            <div class="status_wrap">
                                                <span class="status status_txt"><?=$ribbon_text?></span>
                                            </div>
                                            <img src="<?=$list['hero_thumb']?>" alt="aklover">
                                            <div class="ico_bx">
                                                <?
                                                if($list["hero_question_url_check"] == "1") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>네이버</span>";
                                                } else if($list["hero_question_url_check"] == "2") {
                                                    $type_check = "<span class='ic_sns ic_insta screen_out'>인스타그램</span>";
                                                } else if($list["hero_question_url_check"] == "3") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>네이버</span><span class='ic_sns ic_insta screen_out'>인스타그램</span>";
                                                } else if($list["hero_question_url_check"] == "4") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>네이버</span><span class='ic_sns ic_insta screen_out'>인스타그램</span>";
                                                } else if($list["hero_question_url_check"] == "5") {
                                                    $type_check = "<span class='ic_sns ic_youtube screen_out'>유투브</span>";
                                                } else if($list["hero_question_url_check"] == "6") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>네이버</span><span class='ic_sns ic_insta screen_out'>인스타그램</span><span class='ic_sns ic_youtube screen_out'>유투브</span>";
                                                }
                                                ?>
                                                <?=$type_check?>
                                            </div>
                                        </div>
                                        <p class="tit fz20 fw600 ellipsis_100"><?=$list['hero_title']?></p>
                                        <div class="f_c">
                                            <? if($period_day) {?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    D-<?=$period_day?>
                                                </span>
                                            <? } else if($period_day == 0 && strlen($period_day) > 0) { ?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    D-DAY
                                                </span>
                                            <? } ?>
                                            <? if($status == 5) {?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    END
                                                </span>
                                            <? } ?>
                                            <p class="fz15 fw600 op05"><?=$one_day?> - <?=$two_day?></p>
                                        </div>
                                    </a>
                                </li>
                                <?
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="tabbox">
                        <ul class="f_fs cursor_cont">
                            <!--라이프-->
                            <?
                            $list_sql = "SELECT * FROM mission WHERE hero_kind != '구매체험' AND hero_table = 'group_04_28' ";
                            if($_SESSION['temp_level'] < 9999 ){
                                $list_sql .=" AND hero_use = 1 AND ((hero_today_05_01 is null or hero_today_05_01='') or (hero_today_05_01 is not null and hero_today_05_01 != '' AND '".date("Y-m-d H:i")."' >= hero_today_05_01)) ";
                                $list_sql .=" AND ((hero_today_05_02 is null or hero_today_05_02 ='') OR (hero_today_05_02 is not null and hero_today_05_02 != '' AND '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
                            }
                            $list_sql .=" ORDER BY hero_priority DESC,
								CASE WHEN (hero_today_01_01<='".date('Y-m-d 00:00:00')."' and hero_today_01_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_01_01 END DESC,
								CASE WHEN (hero_today_02_01<='".date('Y-m-d 00:00:00')."' and hero_today_02_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_02_01 END DESC,
								CASE WHEN (hero_today_03_01<='".date('Y-m-d 00:00:00')."' and hero_today_03_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_03_01 END DESC,
								CASE WHEN (hero_today_04_01<='".date('Y-m-d 00:00:00')."' and hero_today_04_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END DESC,
								CASE WHEN (hero_today_04_02<='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END desc ";
                            $list_sql .= " , hero_today_01_01 DESC ";
                            $list_sql .= "LIMIT 0,3";

                            sql($list_sql, 'on');

                            while($list = @mysql_fetch_assoc($out_sql)){
                                $check_day = date( "Y-m-d", time());
                                $today_01_01 = date( "Y-m-d", strtotime($list['hero_today_01_01']));
                                $today_01_02 = date( "Y-m-d", strtotime($list['hero_today_01_02']));
                                $today_02_01 = date( "Y-m-d", strtotime($list['hero_today_02_01']));
                                $today_02_02 = date( "Y-m-d", strtotime($list['hero_today_02_02']));
                                $today_03_01 = date( "Y-m-d", strtotime($list['hero_today_03_01']));
                                $today_03_02 = date( "Y-m-d", strtotime($list['hero_today_03_02']));
                                $today_04_01 = date( "Y-m-d", strtotime($list['hero_today_04_01']));
                                $today_04_02 = date( "Y-m-d", strtotime($list['hero_today_04_02']));
                                $today_05_01 = date( "Y-m-d", strtotime($list['hero_today_05_01']));
                                $today_05_02 = date( "Y-m-d", strtotime($list['hero_today_05_02']));

                                $status_txt = "";
                                $status = "";
                                $period_day = "";
                                $ribbon_text = "";
                                $type_check = "";

                                $ribbon_text = $list['hero_kind'];
                                if($list['hero_type'] == "4" || $list['hero_type'] == "7") {
                                    $ribbon_text = $list['hero_kind'];
                                }

                                if($list['hero_type'] == "7" || $list['hero_type'] == "9") { //자율미션, 정기미션(선택)
                                    if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                        $status_txt = "체험단 신청";
                                        $status = "1";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                        $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                        $status_txt = "선정자 발표";
                                        $status = "2";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
                                        $period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                        $status_txt = "후기등록";
                                        $status = "3";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
                                        $period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
                                        $status_txt = "우수후기발표";
                                        $status = "4";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                        $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                                    }else if($today_04_02<$check_day){
                                        $status_txt = "체험단 마감";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }else if($today_05_01>$check_day){
                                        $status_txt = "체험단 노출예정";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }
                                } else {
                                    if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                        $status_txt = "후기등록";
                                        $status = "3";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                        $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                    }else if($today_01_02<$check_day){
                                        $status_txt = "체험단 마감";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                    }else if($today_05_01>$check_day){
                                        $status_txt = "체험단 노출예정";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                    }
                                }
                                ?>
                                <li>
                                    <a href="<?=PATH_HOME?>?board=group_04_28&page=1&view=view&idx=<?=$list['hero_idx']?>">
                                        <div class="img_bx">
                                            <div class="status_wrap">
                                                <span class="status status_txt"><?=$ribbon_text?></span>
                                            </div>
                                            <img src="<?=$list['hero_thumb']?>" alt="aklover">
                                            <div class="ico_bx">
                                                <?
                                                if($list["hero_question_url_check"] == "1") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>네이버</span>";
                                                } else if($list["hero_question_url_check"] == "2") {
                                                    $type_check = "<span class='ic_sns ic_insta screen_out'>인스타그램</span>";
                                                } else if($list["hero_question_url_check"] == "3") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>네이버</span><span class='ic_sns ic_insta screen_out'>인스타그램</span>";
                                                } else if($list["hero_question_url_check"] == "4") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>네이버</span><span class='ic_sns ic_insta screen_out'>인스타그램</span>";
                                                } else if($list["hero_question_url_check"] == "5") {
                                                    $type_check = "<span class='ic_sns ic_youtube screen_out'>유투브</span>";
                                                } else if($list["hero_question_url_check"] == "6") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>네이버</span><span class='ic_sns ic_insta screen_out'>인스타그램</span><span class='ic_sns ic_youtube screen_out'>유투브</span>";
                                                }
                                                ?>
                                                <?=$type_check?>
                                            </div>
                                        </div>
                                        <p class="tit fz20 fw600 ellipsis_100"><?=$list['hero_title']?></p>
                                        <div class="f_c">
                                            <? if($period_day) {?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    D-<?=$period_day?>
                                                </span>
                                            <? } else if($period_day == 0 && strlen($period_day) > 0) { ?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    D-DAY
                                                </span>
                                            <? } ?>
                                            <? if($status == 5) {?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    END
                                                </span>
                                            <? } ?>
                                            <p class="fz15 fw600 op05"><?=$one_day?> - <?=$two_day?></p>
                                        </div>
                                    </a>
                                </li>
                                <?
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="tabbox on">
                        <ul class="f_fs cursor_cont">
                            <!--베이직-->
                            <?
                            $list_sql = "SELECT * FROM mission WHERE hero_kind != '구매체험' AND hero_table = 'group_04_05' ";
                            if($_SESSION['temp_level'] < 9999 ){
                                $list_sql .=" AND hero_use = 1 AND ((hero_today_05_01 is null or hero_today_05_01='') or (hero_today_05_01 is not null and hero_today_05_01 != '' AND '".date("Y-m-d H:i")."' >= hero_today_05_01)) ";
                                $list_sql .=" AND ((hero_today_05_02 is null or hero_today_05_02 ='') OR (hero_today_05_02 is not null and hero_today_05_02 != '' AND '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
                            }
                            $list_sql .=" ORDER BY hero_priority DESC,
								CASE WHEN (hero_today_01_01<='".date('Y-m-d 00:00:00')."' and hero_today_01_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_01_01 END DESC,
								CASE WHEN (hero_today_02_01<='".date('Y-m-d 00:00:00')."' and hero_today_02_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_02_01 END DESC,
								CASE WHEN (hero_today_03_01<='".date('Y-m-d 00:00:00')."' and hero_today_03_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_03_01 END DESC,
								CASE WHEN (hero_today_04_01<='".date('Y-m-d 00:00:00')."' and hero_today_04_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END DESC,
								CASE WHEN (hero_today_04_02<='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END desc ";
                            $list_sql .= " , hero_today_01_01 DESC ";
                            $list_sql .= "LIMIT 0,3";

                            sql($list_sql, 'on');

                            while($list = @mysql_fetch_assoc($out_sql)){
                                $check_day = date( "Y-m-d", time());
                                $today_01_01 = date( "Y-m-d", strtotime($list['hero_today_01_01']));
                                $today_01_02 = date( "Y-m-d", strtotime($list['hero_today_01_02']));
                                $today_02_01 = date( "Y-m-d", strtotime($list['hero_today_02_01']));
                                $today_02_02 = date( "Y-m-d", strtotime($list['hero_today_02_02']));
                                $today_03_01 = date( "Y-m-d", strtotime($list['hero_today_03_01']));
                                $today_03_02 = date( "Y-m-d", strtotime($list['hero_today_03_02']));
                                $today_04_01 = date( "Y-m-d", strtotime($list['hero_today_04_01']));
                                $today_04_02 = date( "Y-m-d", strtotime($list['hero_today_04_02']));
                                $today_05_01 = date( "Y-m-d", strtotime($list['hero_today_05_01']));
                                $today_05_02 = date( "Y-m-d", strtotime($list['hero_today_05_02']));

                                $status_txt = "";
                                $status = "";
                                $period_day = "";
                                $ribbon_text = "";
                                $type_check = "";

                                $ribbon_text = $list['hero_kind'];
                                if($list['hero_type'] == "4" || $list['hero_type'] == "7") {
                                    $ribbon_text = $list['hero_kind'];
                                }

                                if($mission_board_type) {
                                    $txt1 = "";
                                    $txt2 = "";
                                    if($list["hero_type"] == "2") {
                                        $txt1 = "소문내기 ";
                                        $txt2 = "소문내기 신청";
                                    } else if($list["hero_type"] == "10") {
                                        $txt1 = "체험단";
                                        $txt2 = "체험단 참여";
                                    }

                                    if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                        $status_txt = $txt2;
                                        $status = "1";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                        $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                    }else if(($today_02_02 == $today_03_02) and ($today_02_02 == $today_04_02) and ($today_03_02 == $today_04_02) and ($today_02_02 >= $check_day)){
                                        $status_txt = "당첨자 발표";
                                        $status = "2";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                        $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                                    }else if(($today_04_02 < $check_day)){
                                        $status_txt = $txt1." 마감";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }
                                } else {
                                    if(($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                        //20180831 임시로 추가
                                        if($list['hero_idx'] == "1288") {
                                            $status_txt = "이벤트 신청";
                                        } else {
                                            $status_txt = "체험단 신청";
                                        }
                                        $status = "1";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                        $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                        $status_txt = "선정자 발표";
                                        $status = "2";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
                                        $period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                                    }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                        $status_txt = "후기등록";
                                        $status = "3";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
                                        $period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                                    }else if(($today_04_01<=$check_day) and ($today_04_02>=$check_day)){
                                        $status_txt = "우수후기발표";
                                        $status = "4";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                        $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                                    }else if($today_04_02<$check_day){
                                        $status_txt = "체험단 마감";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }else if($today_05_01>$check_day){
                                        $status_txt = "체험단 노출예정";
                                        $status = "5";
                                        $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                        $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                    }
                                }

                                // if($list['hero_type'] == "7" || $list['hero_type'] == "9") { //자율미션, 정기미션(선택)
                                //     if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                //         $status_txt = "체험단 신청";
                                //         $status = "1";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                //         $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                //     }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                //         $status_txt = "선정자 발표";
                                //         $status = "2";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
                                //         $period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                                //     }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                //         $status_txt = "후기등록";
                                //         $status = "3";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
                                //         $period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                                //     }else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
                                //         $status_txt = "우수후기발표";
                                //         $status = "4";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                //         $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                                //     }else if($today_04_02<$check_day){
                                //         $status_txt = "체험단 마감";
                                //         $status = "5";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                //     }else if($today_05_01>$check_day){
                                //         $status_txt = "체험단 노출예정";
                                //         $status = "5";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                //     }
                                // } else {
                                //     if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                //         $status_txt = "후기등록";
                                //         $status = "3";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                //         $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                                //     }else if($today_01_02<$check_day){
                                //         $status_txt = "체험단 마감";
                                //         $status = "5";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                //     }else if($today_05_01>$check_day){
                                //         $status_txt = "체험단 노출예정";
                                //         $status = "5";
                                //         $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                //         $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                //     }
                                // }
                                ?>
                                <li>
                                    <a href="<?=PATH_HOME?>?board=group_04_05&page=1&view=view&idx=<?=$list['hero_idx']?>">
                                        <div class="img_bx">
                                            <div class="status_wrap">
                                                <span class="status status_txt"><?=$ribbon_text?></span>
                                            </div>
                                            <img src="<?=$list['hero_thumb']?>" alt="aklover">
                                            <div class="ico_bx">
                                                <?
                                                if($list["hero_question_url_check"] == "1") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>네이버</span>";
                                                } else if($list["hero_question_url_check"] == "2") {
                                                    $type_check = "<span class='ic_sns ic_insta screen_out'>인스타그램</span>";
                                                } else if($list["hero_question_url_check"] == "3") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>네이버</span><span class='ic_sns ic_insta screen_out'>인스타그램</span>";
                                                } else if($list["hero_question_url_check"] == "4") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>네이버</span><span class='ic_sns ic_insta screen_out'>인스타그램</span>";
                                                } else if($list["hero_question_url_check"] == "5") {
                                                    $type_check = "<span class='ic_sns ic_youtube screen_out'>유투브</span>";
                                                } else if($list["hero_question_url_check"] == "6") {
                                                    $type_check = "<span class='ic_sns ic_naver screen_out'>네이버</span><span class='ic_sns ic_insta screen_out'>인스타그램</span><span class='ic_sns ic_youtube screen_out'>유투브</span>";
                                                }
                                                ?>
                                                <?=$type_check?>
                                            </div>
                                        </div>
                                        <p class="tit fz20 fw600 ellipsis_100"><?=$list['hero_title']?></p>
                                        <div class="f_c">
                                            <? if($period_day) {?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    D-<?=$period_day?>
                                                </span>
                                                <? } else if($period_day == 0 && strlen($period_day) > 0) { ?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    D-DAY
                                                </span>
                                            <? } ?>
                                            <? if($status == 5) {?>
                                                <span class="status"><?=$status_txt?></span>
                                                <span class="period fz14">
                                                    END
                                                </span>
                                            <? } ?>
                                            <p class="fz15 fw600 op05"><?=$one_day?> - <?=$two_day?></p>
                                        </div>
                                    </a>
                                </li>
                                <?
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>    
    <!-- // supporters -->
    <!-- about ak lover -->
    <section class="section3 sec_about">
        <div class="cont_wr">
            <div class="section_tit">            
                <span class="fz20 fw600">알아가요, AK Lover</span>
                <h1 class="fz86 main_c en">About AK Lover</h1>
            </div>
            <div class="section_cont">
                <ul class="grid_4 cursor_cont">
                    <?
                    $sql = "select * from about order by replace(hero_order,0,999) asc;";
                    sql($sql);

                    while ($about_list = @mysql_fetch_assoc($out_sql)){
                        ?>
                        <li>
                            <a href="<?=$about_list['hero_href']?>"><img src="/aklover/photo/<?=$about_list['hero_main']?>" alt="aklover"></a>
                            <a href="<?=$about_list['hero_href']?>"><span class="fz20 fw600 link_tit"><?=$about_list['hero_title']?></span></a>
                        </li>
                        <?
                    }
                    ?>
                </ul>
            </div>
        </div>
    </section>    
    <!-- // about ak lover -->
    <!-- best Review -->
    <section class="section3 sec_reivew main_display">
        <div class="section_cont f_cs">
            <div class="tabtit">
                <span class="fz20 fw600">축하해요, 우수후기</span>
                <h1 class="fz86 en">Best Review</h1>
                <ul>
                    <li class="on">
                        <p class="tit depth1_c">Premier</p>
                        <div class="hash_box">
                            <div>
                                <span class="depth1 depth1_cs act">Premier Beauty</span>
                                <span class="depth1">Premier Life</span>
                            </div>
                        </div>
                    </li>
                    <li class="">
                        <p class="tit depth1">Basic</p>
                        <div class="hash_box">
                            <div>
                                <span class="depth1_s">Basic Beauty & life</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="tabcont">
                <!--뷰티-->
                <div class="swiper-container tabbox on">
                    <ul class="f_fs swiper-wrapper">
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont01.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz18 fw500">또또치♡</span>
                                    </div>
                                    <div class="fz16 fw300 txtbox ellipsis_3line">
                                        안녕하세요:) 에이지투웨니스 선 에센스 팩트가 이번에 새롭게 리뉴얼되어 돌아왔다고 해요 기존의 선쿠션도 진짜 좋았는데 이번에 리뉴얼되면서 더 좋아졌다고 하니 믿고 사용할 수밖에 없는거아닌가요
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C3zE3hfLpJv/?igsh=cXN1eXJ3Y2JidDk%3D' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>                                            
                                        <a href='https://blog.naver.com/hhu1004/223365360688' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont02.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz18 fw500">어텀</span>
                                    </div>
                                    <div class="fz16 fw300 txtbox ellipsis_3line">
                                        여러분은 아이 메이크업 한 팔레트로 끝내실 수 있나요? 저같은 경우는 많이 써도 세 컬러? 정도 쓰고 다른 팔레트로 옮기는 편인데요
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C2XYADzy8l8/?igsh=MXN5aGNvc2lkeXRrMQ%3D%3D' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>                                            
                                        <a href='https://blog.naver.com/one09060/223329494096' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont03.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz18 fw500">블로거니나</span>
                                    </div>
                                    <div class="fz16 fw300 txtbox ellipsis_3line">
                                        안뇽하세요 니나입니닷- 여전히 추운날씨에 피부가 건조하다 못해 푸석푸석한 요즘 피부만이라도 탱글탱글 촉촉한 물광피부 표현을 하고 싶더라구요?
                                    </div>
                                    <div class='sns_btn_group f_c'>                                             
                                        <a href='https://blog.naver.com/khc_0710/223361044757' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont03_1.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz18 fw500">임수민</span>
                                    </div>
                                    <div class="fz16 fw300 txtbox ellipsis_3line">
                                        안녕하세요! 오늘은 미끌거림 없이 깔끔하게! 저자극으로 순하게 세정 가능한 포인트앤 딥 클린 립앤아이 리무버 롱패드 & 딥 클린 휩 클렌징폼 사용해보았습니다.
                                    </div>
                                    <div class='sns_btn_group f_c'>                           
                                        <a href='https://www.instagram.com/p/C7sVD89S6y0/?igsh=MXd5cnlhbzc3ZDdnMA==' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>                      
                                        <a href='https://blog.naver.com/lsm991227/223466238178' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!--라이프-->
                <div class="swiper-container tabbox">
                <ul class="f_fs swiper-wrapper">
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont04.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz18 fw500">강빙빙</span>
                                    </div>
                                    <div class="fz16 fw300 txtbox ellipsis_3line">
                                     안녕하세요 :) 비오는날 빨래에서 냄새 상쾌하게 해결할 수 있는 실내건조 캡슐세제 리큐세트 소개해 드릴게요!
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C8R-UoxPW9-/?igsh=MTNmaHFscWF6OW9sNw==' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>                                            
                                        <a href='https://blog.naver.com/trian78/223481470258' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont05.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz18 fw500">슈쿤맘</span>
                                    </div>
                                    <div class="fz16 fw300 txtbox ellipsis_3line">
                                    명절 때에는 가족들이 함께 있다보니 화장실 청소가 어려운 것 같아요. 아이들까지 집에 있다보니 집정리는 물론 화장실 청소하기가 참 힘들었는데요. 
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C3P4jTuLgnL/?igsh=MWpybWFqY3E4Znc3dg==' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>                                            
                                        <a href='https://blog.naver.com/lyw5559/223353489178' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont06.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz18 fw500">다다꽃</span>
                                    </div>
                                    <div class="fz16 fw300 txtbox ellipsis_3line">
                                        요즘은 해가 너무 좋으니 빨래하고 나면 건조기를 사용하는 것 보다 널어 말리는게 더 기분 좋더라구요.
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C6eAs8DRvaZ/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>                                            
                                        <a href='https://blog.naver.com/forminji0406/223434627497' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont06_1.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz18 fw500">림e</span>
                                    </div>
                                    <div class="fz16 fw300 txtbox ellipsis_3line">
                                    본격적인 여름철이 되면 더 심해질 텐데 얼른 관리를 해줘야겠다 하고 홈백신 배수구샷을 사용해 주었습니다.
                                    배수구 쾨쾨한 냄새를 깨끗이 씻어내고 원인부터 잡아주는 홈백신 배수구샷
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C7-aMF1PnPK/?igsh=Zmw5b3VibXZleXl6' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>                                            
                                        <a href='https://blog.naver.com/limlim805/223473202890' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <!--베이직-->
                <div class="swiper-container tabbox">
                <ul class="f_fs swiper-wrapper">
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont07.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz18 fw500">여븐e</span>
                                    </div>
                                    <div class="fz16 fw300 txtbox ellipsis_3line">
                                        날씨가 더워져서 그런지 메이크업을 하면 금세 무너지고 커버가 잘 안 돼서 고민이 되더라고요.
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C63ZgOsrAwr/?igsh=MzRlODBiNWFlZA==' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>                                            
                                        <a href='https://blog.naver.com/aldi9382/223444449870' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont08.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz18 fw500">사유</span>
                                    </div>
                                    <div class="fz16 fw300 txtbox ellipsis_3line">
                                        열분 안뇽하세요~! 오늘 진짜 대박 바디워시, 바디 스크럽 발견해서 바로 본론부터 들어갈게요.
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C4YQudtvxsP/?igsh=N256cWlwbG9rdXR6' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>                                            
                                        <a href='https://blog.naver.com/sayunov/223380422662' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont09.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz18 fw500">푸른하늘</span>
                                    </div>
                                    <div class="fz16 fw300 txtbox ellipsis_3line">
                                        점점 무더워지는 날씨에 곧 다가오는 장마철까지!!! 장마철이 되면 각종 옷이며, 땀에 젖은 운동복, 매일매일 덮는 이불까지~~ 
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C79lvJSva4i/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>                                            
                                        <a href='https://blog.naver.com/jyjj0201/223473800757' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="swiper-slide">
                            <div>
                                <img src="/img/front/main/tabcont09_1.jpg" alt="aklover">
                                <div class="content">
                                    <div class="f_cs">                                        
                                        <img src="/img/front/main/profile.webp" alt="aklover" class="profile">
                                        <span class="fz18 fw500">하나언니</span>
                                    </div>
                                    <div class="fz16 fw300 txtbox ellipsis_3line">
                                        필수 가전 3대 이모님 중 하나인 식기세척기
                                        식기세척기 알차게 활용하려면 세제 선택도 중요한 거 아시죠?
                                        그런데 세제 종류가 얼마나 많은지 따져보고 선택하는 것도 쉽지 않더라고요.
                                    </div>
                                    <div class='sns_btn_group f_c'>                                        
                                        <a href='https://www.instagram.com/p/C1XD6arv2QB/?igsh=MWtxODAwM2s3N3Jxcw==' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>                                            
                                        <a href='https://blog.naver.com/duna0912/223305083687' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- // best Review -->
    <!-- // news -->
    <section class="section4 sec_news">
    	<div class="section_tit f_cl sub_wrap">
            <?
            $sql = "SELECT * FROM bot_content WHERE hero_idx = '1' and exists (select 1 from bot_content where hero_idx = 2 and hero_use = '1')";
            sql($sql);

            $bot_main = @mysql_fetch_assoc($out_sql);
            ?>
            <div class="section_tit">
                <span class="fz20 fw600"><?=$bot_main['hero_title']?></span>
                <h1 class="fz86 main_c en"><?=$bot_main['hero_sub_title']?></h1>
            </div>
            <?
            $sql = "SELECT * FROM bot_content WHERE hero_idx != '1' and hero_use = '1' order by replace(hero_order,0,999)";
            sql($sql);

            while ($list = @mysql_fetch_assoc($out_sql)){
                ?>
                <div class="section_cont f_b">
                    <div class="cont_txt">
                        <div class="cont_tit">
                            <a href="<?=$list['hero_pc_href']?>" class="cont_lnk">
                                <div class="lnk-wrap">
                                    <strong class="tit_txt fz28 fw600 f_cs"><?=$list['hero_title']?></strong>
                                </div>
                                <p class="fz20 sub_txt ellipsis_2line">
                                    <?=nl2br($list['hero_sub_title'])?>
                                </p>
                            </a>
                        </div>
                    </div>
                    <div class="cont_img">
                        <a href="<?=$list['hero_pc_href']?>"><img src="/aklover/photo/<?=$list['hero_main']?>" alt="이모지 QUIZ"></a>
                    </div>
                </div>
                <?
            }
            ?>

    	</div>
    </section>    
    <!-- // news -->
    <!-- // rolling banner -->
    <section class="section5 sec_rollbanner">
    	<h2 class="text_hidden">제휴회사 리스트</h2>                                    
        <div class="roll_wrap">
            <ul class="list">
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=38"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/AGE20'S.png" alt="AGE20'S"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=36"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/LUNA.png" alt="LUNA"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=37"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/asolution.png" alt="asolution"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=39"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/pointand.png" alt="pointand"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=35"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/sneaky.png" alt="sneaky"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=17"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/kerasys.png" alt="kerasys"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=46"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/Blackforet.png" alt="Blackforet"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=43"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/alpist.png" alt="alpist"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=45"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/shower.png" alt="shower"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=49"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/LUVSCENT.png" alt="LUVSCENT"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=48"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/chiuub.png" alt="chiuub"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=72"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/lechatelard.png" alt="lechatelard"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=68"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/liq.png" alt="liq"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=75"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/bravo.png" alt="bravo"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=65"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/savorr.png" alt="savorr"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=59"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/soonsam.png" alt="soonsam"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=70"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/spark.png" alt="spark"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=74"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/mom.png" alt="mom"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=62&brand_idx=53"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/airfresh.png" alt="airfresh"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=71"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/wool.png" alt="wool"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=67"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/trio.png" alt="trio"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=73"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/herbmary.png" alt="herbmary"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=60&brand_idx=55"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/home.png" alt="home"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=61&brand_idx=54"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/whistle.png" alt="whistle"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=76"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/SWAY.png" alt="SWAY"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=69"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/zet.png" alt="zet"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=61"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/2080.png" alt="2080"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=50"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/2080kiz.png" alt="2080kiz"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=34"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/bycolor.png" alt="bycolor"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=63"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/salarium.png" alt="salarium"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=30&brand_idx=66"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/labccin.png" alt="labccin"></a></li>
            </ul>
            <ul class="list">
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=38"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/AGE20'S.png" alt="AGE20'S"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=36"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/LUNA.png" alt="LUNA"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=37"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/asolution.png" alt="asolution"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=39"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/pointand.png" alt="pointand"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=35"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/sneaky.png" alt="sneaky"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=17"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/kerasys.png" alt="kerasys"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=46"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/Blackforet.png" alt="Blackforet"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=43"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/alpist.png" alt="alpist"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=45"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/shower.png" alt="shower"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=49"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/LUVSCENT.png" alt="LUVSCENT"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=48"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/chiuub.png" alt="chiuub"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=72"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/lechatelard.png" alt="lechatelard"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=68"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/liq.png" alt="liq"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=75"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/bravo.png" alt="bravo"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=65"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/savorr.png" alt="savorr"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=59"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/soonsam.png" alt="soonsam"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=70"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/spark.png" alt="spark"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=74"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/mom.png" alt="mom"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=62&brand_idx=53"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/airfresh.png" alt="airfresh"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=71"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/wool.png" alt="wool"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=67"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/trio.png" alt="trio"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=73"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/herbmary.png" alt="herbmary"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=60&brand_idx=55"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/home.png" alt="home"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=61&brand_idx=54"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/whistle.png" alt="whistle"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=76"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/SWAY.png" alt="SWAY"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=69"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/zet.png" alt="zet"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=61"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/2080.png" alt="2080"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=50"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/2080kiz.png" alt="2080kiz"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=34"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/bycolor.png" alt="bycolor"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=63"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/salarium.png" alt="salarium"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=30&brand_idx=66"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/labccin.png" alt="labccin"></a></li>
            </ul>
            <ul class="list">
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=38"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/AGE20'S.png" alt="AGE20'S"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=36"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/LUNA.png" alt="LUNA"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=37"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/asolution.png" alt="asolution"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=39"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/pointand.png" alt="pointand"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=1&brandhall_idx=31&brand_idx=35"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/sneaky.png" alt="sneaky"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=17"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/kerasys.png" alt="kerasys"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=46"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/Blackforet.png" alt="Blackforet"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=26&brand_idx=43"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/alpist.png" alt="alpist"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=45"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/shower.png" alt="shower"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=49"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/LUVSCENT.png" alt="LUVSCENT"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=27&brand_idx=48"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/chiuub.png" alt="chiuub"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=72"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/lechatelard.png" alt="lechatelard"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=68"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/liq.png" alt="liq"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=75"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/bravo.png" alt="bravo"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=65"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/savorr.png" alt="savorr"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=59"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/soonsam.png" alt="soonsam"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=70"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/spark.png" alt="spark"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=74"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/mom.png" alt="mom"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=62&brand_idx=53"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/airfresh.png" alt="airfresh"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=71"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/wool.png" alt="wool"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=59&brand_idx=67"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/trio.png" alt="trio"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=70&brand_idx=73"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/herbmary.png" alt="herbmary"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=60&brand_idx=55"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/home.png" alt="home"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=3&brandhall_idx=61&brand_idx=54"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/whistle.png" alt="whistle"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=76"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/SWAY.png" alt="SWAY"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=69"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/zet.png" alt="zet"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=61"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/2080.png" alt="2080"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=50"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/2080kiz.png" alt="2080kiz"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=34"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/bycolor.png" alt="bycolor"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=28&brand_idx=63"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/salarium.png" alt="salarium"></a></li>
                <li class=""><a href="https://www.aekyung.co.kr/brand_detail?main_brand_idx=2&brandhall_idx=30&brand_idx=66"  target="_blank" class="roll_lnk"><img src="/img/front/main/roll_logo/labccin.png" alt="labccin"></a></li>
            </ul>
        </div>
    </section>    
    <!-- // rolling banner -->
    
    <!-- 뮤자인 메인 팝업(s) -->
    <?
    $sql = "SELECT * FROM main_popup WHERE hero_use='1' ";
    $sql .= " and ('".date("Y-m-d H:i:s")."' between hero_today_01 and hero_today_02) order by replace(hero_order,0,999) asc";
    sql($sql);
    $i = 1;

    while($list = @mysql_fetch_assoc($out_sql)){ ?>

    <div class="mainpopup overlay" id="mainpopup<?=$i?>">
        <div class="popup_inner">
            <a href="<?=$list['hero_pc_href']?>" class="fz26 bold">
                <img src="/aklover/photo/<?=$list['hero_main']?>" alt="임시">
            </a>
            <br>
            <button class="btnx fz26 bold">닫기</button>
            <div class="close_txt">
                <a class="btn_today_close_alram">오늘 하루 이 창을 열지 않음</a>
            </div>
        </div>
    </div>

    <script>
        // 임시 하루동안 팝업창 보지않기 구현
        $('#mainpopup<?=$i?> .btnx').click(function(){
            cookieSetting.setCookie("today", "yes", 1);
            $('#mainpopup<?=$i?>').hide();
        });

        $("#mainpopup<?=$i?> .btn_today_close_alram").on("click", function () {
            cookieSetting.setCookie("today", "yes", 1);
            $('#mainpopup<?=$i?>').hide();
        });

        if (cookieSetting.getCookie("today") == "yes") {
            $('#mainpopup<?=$i?>').hide();
        } else {
            $('#mainpopup<?=$i?>').show();
        }
    </script>
    <? $i++;} ?>
    <!-- 뮤자인 메인 팝업(e) -->

    <?php
    //############ 휴면계정 동의 창 시작 #################
    if($_REQUEST["dormancy"] == "yes"){
        $dormancy_code = $_REQUEST["hero_code"];
        $dormancy_name = $_REQUEST["hero_name"];
        $dormancy_out_date = $_REQUEST["hero_out_date"];
        $dormancy_id = $_REQUEST["hero_id"];

        ?>
        <style type='text/css'>
            .dimmed {	position: fixed;	top: 0;	right: 0;	bottom: 0;	left: 0;	z-index: 998;	display: block;	width:100%;	height: 100%;	background-color:#A8A8A8;	content: '';	opacity:0.7;}
            *{font-family:'나눔고딕',Nanum Gothic; font-size:14px; color:#4c4c4c; margin:0; padding:0;}
            /*
            .sleepbox {
                position: absolute;
                width:440px;
                height:366px;

                z-index:1000;
                left:0px;
                top:0px;
                background: #fff;
                -webkit-box-shadow: 3px 3px 15px #afafaf;
                    -moz-box-shadow: 3px 3px 15px #afafaf;
                    box-shadow: 3px 3px 15px #afafaf;

            }
            */
        </style>
        <script type='text/javascript'>
            $(function(){
                $(window).scrollTop(0);
                document.body.style.overflow = 'hidden';
                $('body').append('<div class=dimmed></div>');
                // $('#sleepbox').css({'left': ( ($(window).width() - $('#sleepbox').width())/2 )+ 'px', 'top' : ( ($(window).height() - $('#sleepbox').height())/2 + $(window).scrollTop() )+ 'px'}).show();
            });
            function goSubmit(){
                if(confirm("회원정보를 활성화 하시겠습니까?")){
                    return true;
                }else{
                    return false;
                }
            }
        </script>
        <div id='sleepbox' class='sleepbox' style=''>
            <!--휴면계정시작-->
            <form name="dormancy" method="post" action="/combined/activate.act.php" onsubmit="return goSubmit();">
                <input type="hidden" name="hero_code" value="<?=$dormancy_code?>"/>
                <input type="hidden" name="mobilepc" value="pc"/>

                <h3 class="fz26 fw600">계정복구</h3>
                <div class="sb_container">
                    <div class="sb_des fz16">
                        <strong class="fw600"><?=$dormancy_name?>(<?=$dormancy_id?>)</strong> 회원님은<br />
                        장기간 사이트를 이용하지 않아 아이디가 휴면상태입니다. <br />
                        휴면상태인 아이디를 재 이용하기 위해서는 아래 &quot;동의함&quot; <br />
                        인증 절차를 통해 회원제 서비스 이용이 가능하게 됩니다. <br />
                        &quot;동의하지 않음'을 선택 시 아이디는 휴면상태가 유지됩니다.
                    </div>
                    <div class="sb_qus">
                        <p class="fz17 fw600 main_c">계정활성화 동의</p>
                        <p class="fz15"><span class="bold">아이디(<?=$dormancy_id?>)</span> 휴면상태를 해지하는데 동의하십니까?</p>

                        <div class="sb_btn f_c">
                            <input type="submit" class="submit_btn fw600 fz16" value="동의함" />
                            <a href="/" class="submit_btn fw600 fz16 blank">동의하지 않음</a>
                        </div>
                    </div>
                </div>
            </form>
            <!--휴면계정끝-->
        </div>
        <?php
//############ 휴면계정 동의 창 끝 #################
    }
    ?>
