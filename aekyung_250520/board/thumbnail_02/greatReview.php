<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$idx = $_GET["idx"];
$board = $_GET["board"];
$cut_count_name = '6';
$cut_title_name = '10';
$cut_command_name = '50';
$today = date("Y-m-d");

$gisu_type_gubun = array(
		"group_04_06" => array("title"=>"뷰티클럽","column"=>"hero_beauty_gisu","level"=>"9996")
		,"group_04_27" => array("title"=>"Beauty/Life Club 영상팀","column"=>"hero_movie_gisu","level"=>"9995")
		,"group_04_28" => array("title"=>"라이프클럽","column"=>"hero_life_gisu","level"=>"9994")
		,"group_04_31" => array("title"=>"Beauty/Life Club 영상팀","column"=>"hero_movie_gisu","level"=>"9993")
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

// 160928 체험후기 9개 출력, 우수후기 6개출력
$list_page=6;

$page_per_list=10;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];

if($_GET['kewyword']){
	if($_GET['select']=="hero_title" || $_GET['select']=="hero_command")	$search = " and A.".$_GET['select']." like '%".$_GET['kewyword']."%'";
	else																	$search = " and B.".$_GET['select']." like '%".$_GET['kewyword']."%'";
	$search_next = "&select=".$_GET['select']."&kewyword=".$_GET['kewyword'];
}

if($_GET['ak_product']) {
	$search = " and A.hero_01 in (select hero_idx from mission where hero_keywords like '%".$_GET['ak_product']."%' ) ";
	$search_next = "&select=".$_GET['select']."&kewyword=".$_GET['kewyword']."&ak_product=".$_GET['ak_product'];
}

$start = ($page-1)*$list_page;
$next_path="board=".$board."&view=greatReview&idx=".$idx.$search_next;

######################################################################################################################################################
$error = "THUMBNAIL_04_LIST_01";

$sql = " SELECT	
			count(*)
		 FROM board b inner join mission m
		 ON b.hero_01 = m.hero_idx
		 WHERE 
			b.hero_table = '".$board."'  AND m.hero_table = '".$board."' 
			AND b.hero_use = '1' AND m.hero_use = '1'
			AND b.hero_board_three = '1' ".$sqlAddMovie;

$count_res = new_sql($sql,$error,"on");
if((string)$count_res==$error){
	error_historyBack("");
	exit;
}

$total_data = mysql_result($count_res,0,0);

######################################################################################################################################################
$sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$board."'";//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);


?>
<script>
function fnGisu(val) {
	location.href = location.protocol+"//"+location.host+"/main/index.php?board=<?=$board?>&view=missionReview&hero_gisu="+val;
}

//우수후기 선정
function fnBest() {
	$("input[name='mode']",document.form_next).val("best");
	$(document.form_next).submit();
}

//우수후기 해제
function fnBestCancel() {
	$("input[name='mode']",document.form_next).val("bestCancel");
	$(document.form_next).submit();
}
</script>

        <div class="contents">
        	<? include_once("{$_SERVER[DOCUMENT_ROOT]}/include/listHeadTitle.php") ?>

            <div class="blog_box2" style="margin-top:30px">
	            <form name="form_next" action="<?=PATH_HOME.'?'.get('','type=drop');?>" method="post" enctype="multipart/form-data">
	           <input type="hidden" name="mode" />
		        	
		        	<? if($total_data == 0) { ?>
					<div style='width:100%; border:2px solid #eee; padding:30px 0; text-align:center; font-size:16px; font-weight:bold;'>체험 후기가 존재하지 않습니다.</div>
				    <?	} ?>
				    
                
	                <ul class="blog_article">
						<?
						$error = "THUMBNAIL_04_LIST_02";
						
						//우수후기 선정
						if($_POST["mode"] == "best") {
							for($z=0; $z<count($_POST["hero_idx"]); $z++) {
								$sql_best = " UPDATE board SET hero_board_three = '1' WHERE hero_idx = '".$_POST["hero_idx"][$z]."' ";
								@mysql_query($sql_best);
							}
							$get_herf = get('type','','');
							$action_href = PATH_HOME.'?'.$get_herf;
							msg("우수후기 선정되었습니다.",'location.href="'.$action_href.'"');
						}
						
						//우수후기 해제
						if($_POST["mode"] == "bestCancel") {
							for($z=0; $z<count($_POST["hero_idx"]); $z++) {
								$sql_best_cancel = " UPDATE board SET hero_board_three = '0' WHERE hero_idx = '".$_POST["hero_idx"][$z]."' ";
								@mysql_query($sql_best_cancel);
							}
							$get_herf = get('type','','');
							$action_href = PATH_HOME.'?'.$get_herf;
							msg("우수후기 해제되었습니다.",'location.href="'.$action_href.'"');
						}
						
						//, (SELECT hero_img_new as level_img from level where hero_level='".$gisu_level."') level_img
						$sql = " SELECT	
									b.hero_idx, b.hero_title, b.hero_nick, b.hero_thumb, b.hero_img_new, b.hero_04
									, b.blog_url,b.cafe_url,b.sns_url,b.etc_url,b.hero_board_three
									, (SELECT hero_img_new as level_img from level where hero_level='".$gisu_level."') level_img
									, (SELECT count(*) FROM mission_url WHERE board_hero_idx = b.hero_idx) as url_cnt 
									, m.hero_table, m.hero_movie_group, m.hero_movie_gisu
									FROM board b inner join mission m
									on b.hero_01 = m.hero_idx
									WHERE 
									b.hero_table = '".$board."'  AND m.hero_table = '".$board."' 
									AND b.hero_use = '1' AND m.hero_use = '1'
									AND b.hero_board_three = '1' ".$sqlAddMovie."
									ORDER BY b.hero_today DESC LIMIT ".$start.",".$list_page;

						$res = new_sql($sql, $error);
						if((string)$res==$error){
							error_historyBack("");
							exit;
						}
						$view_count = '4';
						$dd = '1';
							
						$unblocked_site = array("naver", "daum", "tistory");
						$unblocked_site_name = array("네이버", "다음", "티스토리");
						$total_html = "";
						
						while($list = mysql_fetch_assoc($res)){
					
					    	if($list['hero_04']) {
								$link="<a href='http://".$_SERVER["HTTP_HOST"]."/main/index.php?board=".$list['hero_table']."&page=".$page."&view=view2&idx=".$list['hero_idx']."' target='_blank'>";	
							}else if($list['blog_url'] || $list['cafe_url'] || $list['sns_url'] || $list['etc_url']) {
								$link="<a href='http://".$_SERVER["HTTP_HOST"]."/main/index.php?board=".$list['hero_table']."&page=".$page."&view=view2&idx=".$list['hero_idx']."' target='_blank'>";
							} else if($list["url_cnt"] > 0) {
								$link="<a href='http://".$_SERVER["HTTP_HOST"]."/main/index.php?board=".$list['hero_table']."&page=".$page."&view=view2&idx=".$list['hero_idx']."' target='_blank'>";
							}else {
								$link="<a href=".PATH_HOME."?board=".$_GET['board']."&page=".$page."&view=view&idx=".$list['hero_idx'].">";
							}
					    	
						    if($list["hero_thumb"])	    			$view_img = $list['hero_thumb'];
						    elseif($list["hero_img_new"]) 	 		$view_img = $list['hero_img_new'];
						    else						    										$view_img = IMAGE_END.'hero.jpg';
					    
							$main_review_sql = "select count(*) from review where hero_old_idx='".$list['hero_idx']."'";
							$out_main_review_sql = @mysql_query($main_review_sql);
							$main_review_data = @mysql_result($out_main_review_sql,0,0);
						
							if($main_review_data>0)			$re_count_total = "<strong><font color='orange'>[".$main_review_data."]</font></strong>";
							else							$re_count_total = "";
							
							if($today == substr($list['hero_today'],0,10))		$new_img_view = " style='background:url(".DOMAIN_END."image/main_new_bt.png) no-repeat 0 2px;'";
						
							if (strcmp($dd,'3')){
								$total_html .= "<li>";
							} else if(!strcmp($dd,'3')){
								$total_html .= "<li class='last'>";
								$dd = '0';
							}
							
							if($_SESSION["temp_level"] == "9999") {
								if($list["hero_board_three"] == "1") {
									$total_html .= "<span class='best'><input type='checkbox' name='hero_idx[]' value='".$list['hero_idx']."' checked /></span>";
								} else {
									$total_html .= "<span class='best'><input type='checkbox' name='hero_idx[]' value='".$list['hero_idx']."' /></span>";
								}
							}
							
							$level_img = str($list["level_img"]);
							if($list["hero_table"] == "group_04_06") {
								$level_img = "/image/bbs/lev_BeautyHolic.png";
							} else if($list["hero_table"] == "group_04_28") {
								$level_img = "/image/bbs/lev_life.png";
							} else if($list["hero_table"] == "group_04_27") {
								if($list["hero_movie_group"] == "group_04_27") {
									if($list["hero_movie_gisu"] > 4) {
										$level_img = "/image/bbs/lev_BeautyHolic.png";
									} else {
										$level_img = "/image/bbs/lev_youtuber.png";
									}
								} else if($list["hero_movie_group"] == "group_04_31") {
									$level_img = "/image/bbs/lev_life.png";
								}
							}
							
							$new_content = "제목:".$list['hero_title']."\n\n작성일:".date( "Y-m-d", strtotime($list['hero_today']))."\n\n작성자:".$list['hero_nick'];
						    $total_html .= "<div align='center' title='".$new_content."'>";
						    $total_html .= $link;
						    $total_html .= "<div class='imgReviewBox'><img src='".$view_img."' onError='this.src=\"/image/hero_empty.jpg\"'/></div>";
						    $total_html .= "<span class='title'>".cut($list['hero_title'], '30').$re_count_total."</span>";
						    $total_html .= "<span class='date'><center>";
							
						    $total_html .= "<img src='".$level_img."' style='width:20px;height:20px' /> ".$list['hero_nick']."</center></span>";
						    $total_html .= "</a>";
						    $total_html .= "</div>";
						    $total_html .= "</li>";
						    $dd++;
						}//while
						echo $total_html;
						?>
	                </ul>
	            </div>
			</form>
        	<div class="clearfix"></div>
        	
        	<? if($_SESSION["temp_level"] == "9999") {?>
        	<div class="btngroup">
	        	<div class="btn_r">
	        		<a href="javascript:;" onClick="fnBestCancel()" class="a_btn" style="background:#888;">우수후기 해제</a>
	        		<a href="javascript:;" onClick="fnBest()" class="a_btn">우수후기 선정</a>
	        	</div>
	        </div>
        	<? } ?>
            
			<? include_once BOARD_INC_END.'button.php';?>
           
    	</div>
	</div>

