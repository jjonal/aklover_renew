<?php
include_once "head.php";
#####################################################################################################################################################
if($_GET['kewyword']){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.stripslashes($_GET['kewyword']);
}

//이전 group 코드 지우면 안됨
$sql  = " SELECT * FROM board WHERE 1=1 ";
if($_GET['idx'] != "") {
	$best = "";
	$sql .= " AND hero_table = '".$_GET["board"]."' ";
	if($_GET['best']) {
		$best = "AND hero_board_three=1";
	}
	$sql .= " AND hero_01='".$_GET['idx']."' ".$best;
} else {
    $tableType = $_GET['statusSearch'];
    $sql .= " AND hero_table IN ('group_04_05', 'group_04_07', 'group_04_08', 'group_04_09', 'group_04_23' ,'group_04_06','group_04_27','group_04_28') ";
    
    if($tableType) {
        switch ($tableType) {
            case "A": //체험단
                $sql .= " AND hero_table = 'group_04_05' ";
                break;
            case "B": //뷰티클럽
                $sql .= " AND hero_table = 'group_04_06' ";
                break;
            case "C": //라이프클럽
                $sql .= " AND hero_table = 'group_04_28' ";
                break;
            default :
                $sql .= " AND hero_table IN ('group_04_05', 'group_04_07', 'group_04_08', 'group_04_09', 'group_04_23' ,'group_04_06','group_04_27','group_04_28') ";
                break;
        }
    }
}
$sql .= $search;
$sql .= " ORDER BY hero_today DESC ";

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
	
	$missionAuth = false;
	
	if($right_list['hero_view'] <= $my_view){
		$missionAuth = true;
	} else if($_GET["board"] == "group_04_06" && $_SESSION["before_beauty_auth"] == "Y") {
		$missionAuth = true;
	} else if($_GET["board"] == "group_04_27" && ($_SESSION["before_beautymovie_auth"] == "Y" || $_SESSION["before_lifemovie_auth"] == "Y")) {
		$missionAuth = true;
	} else if($_GET["board"] == "group_04_28" && $_SESSION["before_life_auth"] == "Y") {
		$missionAuth = true;
	}
	
	if(!$missionAuth) {
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
<div id="subpage" class="reviewpage">   
    <div class="sub_wrap">
        <div class="sub_title">
            <div class="">
            <? if ( $_GET['board'] == 'group_04_09' ) { ?>
                <h1 class="fz74 main_c fw500 ko">전체 콘텐츠</h1>
                <p class="fz28 fw600">AK Lover의 모든 후기를 만나보세요!</p>   
            <? } else { ?>
                <h1 class="fz74 main_c fw500 ko">후기 확인</h1> 
            <? } ?>                
            </div> 
            <? if ( $_GET['board'] == 'group_04_09' ) { ?>
            <ul class="tab f_cs">                        
                <li><a href="/m/board_02.php?board=group_04_10" class="fz12 fw500">우수 콘텐츠</a></li>
                <li><a href="/m/board_01.php?board=group_04_09" class="fz12 fw500 on">전체 콘텐츠</a></li>     
                <li><a href="/m/meeting_list.php?board=group_04_22" class="fz12 fw500">모임 콘텐츠</a></li>             
            </ul>            
            <? } ?>   
        </div>
    </div>
    <? if ( $_GET['board'] == 'group_04_09' ) { ?>
    <div class="boardTabMenuWrap colorType">
        <span class="missionStatusSearch <?=$_GET['statusSearch']==""?"active":""?>" data-val="">전체</span>
        <span class="missionStatusSearch <?=$_GET['statusSearch']=="A"?"active":""?>" data-val="A">베이직 뷰티&라이프 클럽</span>
        <span class="missionStatusSearch <?=$_GET['statusSearch']=="B"?"active":""?>" data-val="B">프리미어 뷰티 클럽</span>
        <span class="missionStatusSearch <?=$_GET['statusSearch']=="C"?"active":""?>" data-val="C">프리미어 라이프 클럽</span>
    </div>
    <div class="btnTodayWrap today_list" style="padding-top: 15px;">
        <? include_once 'searchBox.php'; ?>
    </div>       
    <? } ?>  
    
       <!-- gallery 시작 -->
        <div id="gallery" class="best_reviewbox">      
            <ul class="review_list grid_3">
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
                
            ?>		
        	  <li <?=$ul_class?>>
                <div class="rel cont_wrap">
                    <img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$view_img?>" class="thum_img">
                    <div class="txt_bx">
                        <!-- [개발]프로필 이미지 임시작업 입니다 -->
                    <span class="nick"><img src="/img/front/mypage/defalt.webp"><?=$pk_row['hero_nick'];?></span>
                    <span class="title ellipsis_3line"><?=$title_01?></span>
                    </div>
                    <div style="display:none;">
                        수정하기
                    </div>
                    <div class="update_bx">
                        <?
                            //수정, 삭제버튼
                            if($_SESSION['temp_level']>=9999 || ($_SESSION['temp_code']==$main_list['hero_code'] && $_SESSION['temp_code'])){
                                $mission_sql = "SELECT A.hero_idx AS board_idx, B.hero_type, B.hero_idx, C.hero_idx as review_idx FROM board A
                                                LEFT JOIN mission B ON A.hero_01 = B.hero_idx
                                                LEFT JOIN mission_review C ON A.hero_code = C.hero_code
                                                WHERE A.hero_idx = '".$_GET['idx']."' AND
                                                    A.hero_01 = C.hero_old_idx
                                                LIMIT 1";

                                $mission_sql_res = mysql_query($mission_sql);
                                $mission_type = mysql_fetch_array($mission_sql_res);

                                if ($mission_type['hero_type'] == 2) {
                                    echo "<a href=\" /m/mission_write.php?board=group_04_05&hero_idx=".$mission_type['review_idx']."&idx=".$_GET["idx"]."&action=update&pre_board=group_04_09 \"><img src=\"/m/img/musign/icon/update_btn.webp\"></a>";
                                } else {
                                    echo "<a href=\" /m/mission_write.php?board=".$main_list['hero_table']."&hero_idx=".$main_list['hero_idx']."&idx=".$_GET["idx"]."&action=update&pre_board=group_04_09 \"><img src=\"/m/img/musign/icon/update_btn.webp\"></a>";
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="sns_btn_group f_c">
                    <?
                    // [개발] 해당 sns 게시글로 바로가기 [완]
                    $url_sql = "select gubun, url from mission_url where board_hero_idx = '".$main_list['hero_idx']."'";
                    $url_res = new_sql($url_sql, $error);

                    while($url_list = mysql_fetch_assoc($url_res)){
                        if($url_list['gubun'] == 'insta') {
                            echo "<a href='".$url_list['url']."' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>";
                        }
                        if($url_list['gubun'] == 'naver') {
                            echo"<a href='".$url_list['url']."' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>";
                        }
                        if($url_list['gubun'] == 'movie') {
                            echo "<a href='".$url_list['url']."' target='_blank' class='btnLink youtube'><span></span><p>유튜브</p></a>";
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
     
     <!-- 후기없을때 s -->
     <? if ( $_GET['board'] == 'group_04_05' || $_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_28' ) { ?>
        <ul class="f_c none_review">
            <li class="fz26 bold t_c">선정된 서포터즈 분들이 제품을 체험하고 있어요.<br>
            솔직하고 행복한 후기 함께 기다려요!</li>
        </ul>         
     <? } ?> 
     <!-- 후기없을때 e -->  

   </div> 
   
    <div id="page_number" class="paging" style="margin-bottom: 0;">            
        <?include_once "page.php"?>
    </div>
      
    <? if($right_list['hero_write']<=$_SESSION['temp_write']){ ?> 
        <div class="btn_write">             
            <a href="<?=DOMAIN_END?>m/write.php?board=<?=$_REQUEST['board']?>&action=write" >글 작성하기</a>
        </div>
    <?}?>
       <!-- gallery 종료 --> 



</div>

<!--컨텐츠 종료-->

<script>
$(document).ready(function(){
	$('body').addClass('dock_page');

    // 서포터즈 상세 - 버튼 dockbar 
    const footerTop = $('#footer').offset().top; 
    const footerHeight = $('#footer').innerHeight(); 
    $(window).scroll(function(){
        const st = $(window).scrollTop();            
        if ( footerTop < st + footerHeight  ) {
            $('.btn_write').addClass('hide');
        } else {             
            $('.btn_write').removeClass('hide');
        }
    });

    $('.missionStatusSearch').click(function(){
		$('.missionStatusSearch').removeClass('on');
		if($(this).attr('class').indexOf('on') != -1) {
			$(this).addClass('on');
		}
		$('#statusSearch').val($(this).attr('data-val'));
		$('#frm').submit();
	})
})
<? if(!strcmp($_REQUEST['download'],"ok")){?>
downMenu();
<? }?>
</script>

<?include_once "tail.php";?>