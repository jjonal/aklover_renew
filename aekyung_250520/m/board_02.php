<?php
include_once "head.php";
#####################################################################################################################################################
if($_GET['kewyword']){
	
	if($_GET['select'] == "hero_id") {
		$search = " and m.".$_GET['select']." = '".$_GET['kewyword']."' ";
	} else {
    	$search = ' and b.'.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
	}
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}
$sql = 'select b.hero_idx, b.hero_title, b.hero_thumb, b.hero_today, m.hero_nick, m.hero_level, m.hero_code from board b LEFT JOIN member m ON b.hero_code = m.hero_code where b.hero_table in (\'group_04_05\', \'group_04_06\', \'group_04_07\', \'group_04_08\', \'group_04_09\', \'group_04_23\', \'group_04_27\', \'group_04_28\') and (b.hero_board_three=\'1\' or b.hero_table=\'group_04_10\') '.$search.' order by b.hero_today desc';
sql($sql,"on");
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=20;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path=get("page||download");
######################################################################################################################################################
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
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
//검색
if($_GET['kewyword']){
    if($_GET['select']=="hero_title" || $_GET['select']=="hero_command") {
        $search = " and A.".$_GET['select']." like '%".$_GET['kewyword']."%'";
    } else if($_GET['select']=="hero_id") {
        $search = " and B.hero_id = '".$_GET['kewyword']."' ";
    } else {
        $search = " and B.".$_GET['select']." like '%".$_GET['kewyword']."%'";
    }
    $search_next = "&select=".$_GET['select']."&kewyword=".$_GET['kewyword'];
}
######################################################################################################################################################
//우수후기 이달의 AK Lover
$loyal_period_sql = " SELECT if(startdate <= date_format(now(),'%Y-%m-%d') AND enddate >= date_format(now(),'%Y-%m-%d'),1,0) as status, hero_month FROM member_loyal_period ";
$loyal_period_res = sql($loyal_period_sql);
$loyal_period_rs = mysql_fetch_assoc($loyal_period_res);

$startDateOfMonth = date("Y-m")."-01";
$timestamp = strtotime($startDateOfMonth)-1;
$gisu_date = date("Ym", $timestamp);
$gisu_year = substr($gisu_date,0,4);
$gisu_month = substr($gisu_date,4,2);

$hero_month = "";
if($loyal_period_rs["hero_month"] > 0) {
    $hero_month = $loyal_period_rs["hero_month"]."월 ";
}

$review_member_sql =  " SELECT m.hero_nick FROM member_loyal l INNER JOIN member m ON l.hero_code = m.hero_code ";
$review_member_sql .= " WHERE gisu_year = '".$gisu_year."' AND gisu_month = '".$gisu_month."' ORDER BY l.hero_idx ASC ";
$review_member_res = sql($review_member_sql);
$review_member = "''";
$i = 0;

while($list = mysql_fetch_assoc($review_member_res)){
//    if($i==0)	$comma = '';
//    else		$comma = ',';

    $comma = ',';

    $review_member .= $comma.'\''.$list['hero_nick'].'\'';
    $i++;
}
######################################################################################################################################################
?>
<link rel="stylesheet" type="text/css" href="/m/css/musign/board.css" />
<link rel="stylesheet" type="text/css" href="/m/css/musign/cscenter.css" />
<link rel="stylesheet" type="text/css" href="/m/css/musign/review.css" />
<script type="text/javascript" src="/js/musign/board.js"></script>
<div id="subpage" class="reviewpage">
    <? if($_REQUEST['board']=="group_04_10") { //우수후기?>
    <div class="sub_wrap">
        <div class="sub_title">
            <div class="">
                <h1 class="fz74 main_c fw500 ko">우수 콘텐츠</h1> 
                <p class="fz28 fw600">AK Lover의 우수한 콘텐츠를 확인해보세요!.</p>                   
            </div>
            <ul class="tab f_cs">                        
                <li><a href="/m/board_02.php?board=group_04_10" class="fz12 fw500 on">우수 콘텐츠</a></li>
                <li><a href="/m/board_01.php?board=group_04_09" class="fz12 fw500">전체 콘텐츠</a></li>     
                <li><a href="/m/meeting_list.php?board=group_04_22" class="fz12 fw500">모임 콘텐츠</a></li>             
            </ul>
        </div>
    </div>
    <div class="slide_top cont_top">
        <div class="caution">
            <h3 class="fz28 fw600 conttop_tit">우수 콘텐츠에 채택 되려면?</h3>
            <div class="caution_cont">
                <div>
                    <div class="f_fs">
                        <img src="/img/front/icon/check.png" alt="우수후기 체택">
                        <p class="fz26 fw500">고퀄리티의 컨텐츠</p>
                    </div>
                    <span class="info fz24">
                        - 가독성 있는 글<br />
                        - 상세하고 디테일한 제품 설명을 위한 보다 자세한 컨텐츠<br />
                        - 양질의 이미지 사용(고화질, 구도, 밝기 등)<br />
                        - 다양한 제품 활용 컷 사용(스타일링 컷, 사용 과정 컷, <br />
                        &nbsp&nbsp&nbsp Before/After 컷 등)<br />
                        - 영상&GIF 등을 정확한 타이밍에 적절하게 사용
                    </span>
                </div>
                <div>
                    <div class="f_fs">
                        <img src="/img/front/icon/check.png" alt="우수후기 체택">
                        <p class="fz14 fw500">진정성 있는 컨텐츠</p>
                    </div>
                    <span class="info fz24">
                    - 제품을 직접 써보고 진심을 다해 솔직하게 작성한 컨텐츠<br />
                    - 본인의 이야기를 담은 스토리텔링을 통하여 읽는이에게 <br />
                    &nbsp&nbsp&nbsp 공감을 주는 컨텐츠<br />
                    - 정확한 정보 제공으로 읽는이에게 도움을 주는 컨텐츠
                    </span>
                </div>
            </div>
        </div>
    </div>    
    <div class="best_review review_list">
        <div class="titbx">
            <p class="tit f_cs"><img src="/img/front/icon/best.png" alt="이달의 ak lover"><span class="fz38 bold">이달의 AK Lover</span></p>
            <div class="desc fz26 fw500 rel">
                 <span>
                     <?php
                     $intro_sql = 'select * from hero_group where hero_idx=\'281\';';//desc

                     sql($intro_sql);
                     $list = @mysql_fetch_assoc($out_sql);
                     $data = explode('||', $list['hero_title']);
                     ?>
                         <?=nl2br(htmlspecialchars($data[0]))?><br><br> <!--이달의 AK Lover 소개-->
                         <b class="fz24"><?=nl2br(htmlspecialchars($data[1]))?></b><br> <!--이달의 AK Lover 선정 기준 및 혜택-->
                </span>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
        <div class="swiper-container best_review_slide">
            <div class="swiper-wrapper">
                <?
                $month_hero_old_idx_sql  = " SELECT hero_idx FROM monthak_manager ";
                $month_hero_old_idx_sql .= " WHERE hero_use = '0' ";
                $month_hero_old_idx_sql .= " AND now() BETWEEN startdate AND enddate ";

                sql($month_hero_old_idx_sql);
                $month_hero_old_idx_list = @mysql_fetch_assoc($out_sql);

                $month_hero_old_idx = $month_hero_old_idx_list['hero_idx'];

                $month_sql  = " SELECT a.board_hero_idx, b.hero_title, b.hero_code, b.hero_nick, b.hero_thumb, c.hero_profile ";
                $month_sql .= " FROM monthak a ";
                $month_sql .= " LEFT JOIN board b ON a.board_hero_idx = b.hero_idx ";
                $month_sql .= " LEFT JOIN member c ON b.hero_code = c.hero_code ";
                $month_sql .= " WHERE a.hero_use = '0' ";
                $month_sql .= " AND a.hero_old_idx = '{$month_hero_old_idx}' ";

                sql($month_sql);
                while($month_list = @mysql_fetch_assoc($out_sql)){
                    if($month_list['hero_profile'] == ''){
                        $profile = "/img/front/mypage/defalt.webp";
                    }else {
                        $profile = $month_list['hero_profile'];
                    }
                    ?>

                    <div class="swiper-slide">
                        <div class="rel cont_wrap">
                            <img src="<?=$month_list['hero_thumb']?>" class="thum_img">
                            <div class="txt_bx">
                                <span class="nick"><img src="<?=$profile?>"><?=$month_list['hero_nick']?></span>
                                <span class="title ellipsis_3line"><?=$month_list['hero_title']?></span>
                            </div>
                        </div>
                        <div class='sns_btn_group f_c'>
                            <?
                            $month_url_sql = "select gubun, url from mission_url where board_hero_idx = '".$month_list['board_hero_idx']."'";
                            $month_url_res = new_sql($month_url_sql, $error);

                            while($month_url_list = mysql_fetch_assoc($month_url_res)){
                                if($month_url_list['gubun'] == 'insta') {?>
                                    <a href='<?=$month_url_list['url']?>' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>
                                <?}
                                if($month_url_list['gubun'] == 'naver') {?>
                                    <a href='<?=$month_url_list['url']?>' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>
                                <?}
                                if($month_url_list['gubun'] == 'movie') {?>
                                    <a href='<?=$month_url_list['url']?>' target='_blank' class='btnLink youtube'><span></span><p>유튜브</p></a>
                                <?}
                                if($month_url_list['gubun'] == 'etc') {?>
                                    <a href='<?=$month_url_list['url']?>' target='_blank' class='btnLink etc'><span></span><p>기타</p></a>
                                <?}
                            }?>
                        </div>
                    </div>
                <?}?>
            </div>
        </div>

    </div>
    <div class="page_tit">
        <p class="fz44 fw600">전체 우수콘텐츠</p>
    </div>
    <div class="btnTodayWrap today_list">
        <? include_once 'searchBox.php';?>
    </div>
    <? } ?>
       <!-- gallery 시작 -->
        <div id="gallery" class="best_reviewbox">            
            <ul class="review_list grid_3">
            <?
            $main_sql = $sql.' limit '.$start.','.$list_page.';';
            $out_main = @mysql_query($main_sql);
            $i="0";
            while($main_list                             = @mysql_fetch_assoc($out_main)){
                $ul_class = "";
                if($i%2 == 0) {
                    $ul_class = "";
                }            
                $img_parser_url = @parse_url($main_list['hero_img_new']);
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

                $pk_sql  = 'select a.hero_level,a.hero_nick,b.hero_img_new ';
                $pk_sql .= ' from member as a, level as b';
                $pk_sql .= ' where b.hero_level = a.hero_level and a.hero_code = \''.$main_list['hero_code'].'\'';
                $out_pk_sql = mysql_query($pk_sql);
                $pk_row                             = @mysql_fetch_assoc($out_pk_sql);
                $link = "";
                if($main_list["hero_04"]) {
                    $exploded_blog = explode("http", $main_list["hero_04"]);
                    $link = $exploded_blog[1];
                }else {
                    $link = "/m/board_view_02.php?board=".$_GET["board"]."&page=".$_GET["page"]."&hero_idx=".$main_list["hero_idx"];
                }
            ?>
                <li <?=$ul_class?>>
                    <div class="rel cont_wrap">
                        <img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$view_img?>" class="thum_img">
                        <div class="txt_bx">
                         <!-- [개발]프로필 이미지 임시작업 입니다 -->
                        <span class="nick"><img src="/img/front/mypage/defalt.webp"><?=$pk_row['hero_nick'];?></span>
                        <span class="title ellipsis_3line"><?=$title_01?></span>
                        </div>
                        <div class="update_bx">
                            <?
                                //수정, 삭제버튼
                                if($_SESSION['temp_level']>=9999 || ($_SESSION['temp_code']==$list['hero_code'] && $_SESSION['temp_code'])){
                                    $mission_sql = "SELECT A.hero_idx AS board_idx, B.hero_type, B.hero_idx, C.hero_idx as review_idx FROM board A
                                                LEFT JOIN mission B ON A.hero_01 = B.hero_idx
                                                LEFT JOIN mission_review C ON A.hero_code = C.hero_code
                                                WHERE A.hero_idx = '".$_GET['idx']."' AND
                                                      A.hero_01 = C.hero_old_idx
                                                LIMIT 1";

                                    $mission_sql_res = mysql_query($mission_sql);
                                    $mission_type = mysql_fetch_array($mission_sql_res);

                                    if($mission_type['hero_type'] == 2) {
                                        echo "<a href=\"".MAIN_HOME."?board=group_04_05&idx=".$mission_type['hero_idx']."&view=step_02_01&hero_idx=".$mission_type['review_idx']."&somun=Y&board_idx=".$mission_type['board_idx']."\"><img src=\"/m/img/musign/icon/update_btn.webp\"></a>";
                                        // echo "<a href=\"javascript:;\" onclick=\"confirmAction('삭제하시겠습니까?', '".MAIN_HOME."?board=group_04_05&view=step_02&idx=".$mission_type['hero_idx']."&&type=drop&hero_idx=".$mission_type['review_idx']."', parent)\"><img src=\"/image2/etc/blog_link_del.gif\"></a>";
                                    }else{
                                        echo "<a href=\"".MAIN_HOME."?board=".$list['hero_table']."&view=write2&action=update&page=".$_GET['page']."&hero_idx=".$list['hero_idx']."\"><img src=\"/m/img/musign/icon/update_btn.webp\"></a>";
                                        // echo "<a href=\"javascript:;\" onclick=\"confirmAction('삭제하시겠습니까?', '".MAIN_HOME."?board=".$list['hero_table']."&view=action_delete&action=delete&idx=".$list['hero_idx']."&page=".$_GET['page']."', parent)\"><img src=\"/image2/etc/blog_link_del.gif\"></a>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div class="sns_btn_group f_c">
                        <!-- / [개발] 해당 sns 게시글로 바로가기 pc 와 동일 -->
                        <?
                        $url_sql = "select gubun, url from mission_url where board_hero_idx = '".$main_list['hero_idx']."'";
                        $url_res = new_sql($url_sql, $error);
                        // echo $url_sql;
                        while($url_list = mysql_fetch_assoc($url_res)){
                            if($url_list['gubun'] == 'insta') {
                                echo "<a href='".$url_list['url']."' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>";
                            }
                            if($url_list['gubun'] == 'naver') {
                                echo "<a href='".$url_list['url']."' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>";
                            }
                            if($url_list['gubun'] == 'movie') {
                                echo "<a href='".$url_list['url']."' target='_blank' class='btnLink etc'><span></span><p>유튜브</p></a>";
                            }
                            if($url_list['gubun'] == 'etc') {
                                echo "<a href='".$url_list['url']."' target='_blank' class='btnLink etc'><span></span><p>기타</p></a>";
                            }
                        }
                        ?>
                    </div>
                </li>
            <?
            $i++;
            }
            ?>
            </ul>
        </div>
   
        <div id="page_number" class="paging" style="margin-bottom: 0;">
            <?include_once "page.php"?>
            <?
            $sql = 'select * from hero_group where hero_board = \''.$_GET['board'].'\'';
            sql($sql, 'on');
            $check_list                             = @mysql_fetch_assoc($out_sql);
            ?>
        </div>
       <!-- gallery 종료 --> 
      
<!--컨텐츠 종료-->


</div>

<script>
<? if(!strcmp($_REQUEST['download'],"ok")){?>
downMenu();
<? }?>
</script>
<?include_once "tail.php";?>