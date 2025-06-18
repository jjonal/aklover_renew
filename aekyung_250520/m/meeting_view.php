<?php
include_once "head.php";
#####################################################################################################################################################
#####################################################################################################################################################
$idx = $_GET["idx"];
$board = $_GET["board"];
$list_page=6;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;

$next_path=get("page");
######################################################################################################################################################
$error = "THUMBNAIL_04_LIST_01";
if($board=="group_04_22"){
	$mission_after = "select hero_old_idx from mission_after where hero_idx=".$idx."";
	$mission_after_res = new_sql($mission_after,$error);
	if($mission_after_res==$error){
		error_historyBack("");
		exit;
	}
	$hero_old_idx = mysql_result($mission_after_res,0,"hero_old_idx");
	$where = "and A.hero_idx in (".$hero_old_idx.") ";
	
}
$sql = "select count(*) from board as A, member as B where A.hero_code=B.hero_code ".$where." and A.hero_use='1' ";
$count_res = new_sql($sql,$error,"on");
if((string)$count_res==$error){
	error_historyBack("");
	exit;
}

$total_data = mysql_result($count_res,0,0);

######################################################################################################################################################
$group_sql = 'select hero_title from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//desc
//echo $group_sql;
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
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
    <!-- gallery 시작 -->
    <div id="gallery" class="best_reviewbox">   
		<ul class="review_list grid_3">
		<?
			$error = "THUMBNAIL_04_LIST_02";
			$sql =  "select * ";
			$sql .= "from (select A.hero_idx, A.hero_code, A.hero_table, A.hero_command, A.hero_thumb, A.hero_img_new, A.hero_today, A.hero_title,A.hero_04, B.hero_level, B.hero_nick from board as A, member as B where A.hero_code=B.hero_code ".$where." and A.hero_use=1 order by A.hero_today desc limit ".$start.",".$list_page.") as A ";
			$sql .= ",(select hero_img_new as level_img, hero_level from level) as C where A.hero_level=C.hero_level order by A.hero_today desc";

			$res = new_sql($sql, $error);
			if((string)$res==$error){
				error_historyBack("");
				exit;
			}
			$view_count = '4';
				
			$unblocked_site = array("naver", "daum", "tistory");
			$unblocked_site_name = array("네이버", "다음", "티스토리");
								
			//echo $sql;
			$out_main = @mysql_query($sql);
			$i=0;

			while($list                             = @mysql_fetch_assoc($out_main)){
				$ul_class = "";
				if($i%2 == 0) {
					$ul_class = "";
				}					
			if($list['hero_04'])				$link="<a href='http://aklover.co.kr/main/index.php?board=".$list['hero_table']."&page=".$page."&view=view2&idx=".$list['hero_idx']."' target='_blank'>";	
			else								$link="<a href=".PATH_HOME."?board=".$_GET['board']."&page=".$page."&view=view&idx=".$list['hero_idx'].">";
			
			if($list["hero_thumb"])	    			$view_img = $list['hero_thumb'];
			elseif($list["hero_img_new"]) 	 		$view_img = $list['hero_img_new'];
			else			    		            $view_img = IMAGE_END.'hero.jpg';
			$li_first = "<img src='".str($list["level_img"])."'/>".$list['hero_nick'];
		?>
        <li <?=$ul_class?>>
			<div class="rel cont_wrap">
				<img onerror="this.src='<?=IMAGE_END?>hero.jpg';" src="<?=$view_img?>" class="thum_img">
				<div class="txt_bx">
					<span class="nick"><img src="/img/front/mypage/defalt.webp"><?=$pk_row['hero_nick'];?></span>
					<span class="title ellipsis_3line"><?=cut($list['hero_title'],45)?></span>
				</div>
			</div>

            <?
            $total_html = '';
            $url_sql = "select gubun, url from mission_url where board_hero_idx = '".$list['hero_idx']."'";
            $url_res = new_sql($url_sql, $error);

            while($url_list = mysql_fetch_assoc($url_res)){
                if($url_list['gubun'] == 'insta') {
                    $total_html .= "<a href='".$url_list['url']."' target='_blank' class='btnLink insta'><span></span><p>인스타그램</p></a>";
                }
                if($url_list['gubun'] == 'naver') {
                    $total_html .= "<a href='".$url_list['url']."' target='_blank' class='btnLink blog'><span></span><p>블로그</p></a>";
                }
                if($url_list['gubun'] == 'movie') {
                    $total_html .= "<a href='".$url_list['url']."' target='_blank' class='btnLink youtube'><span></span><p>유튜브</p></a>";
                }
                if($url_list['gubun'] == 'etc') {
                    $total_html .= "<a href='".$url_list['url']."' target='_blank' class='btnLink etc'><span></span><p>기타</p></a>";
                }
            }
            ?>

			<div class="sns_btn_group f_c">
				<!-- / [개발] 해당 sns 게시글로 바로가기 pc 와 동일 -->
                <?=$total_html?>
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