<link rel="stylesheet" type="text/css" href="/css/front/board.css" />
<link rel="stylesheet" type="text/css" href="/css/front/review.css" />
<?
######################################################################################################################################################
## 2015년 3월 김태준 개발
######################################################################################################################################################
## 접근 제한
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
if(!$_GET['board']){
	error_historyBack("잘못된 접근입니다.");
	exit;
}
//검색 키워드
if($_GET['kewyword']){
    $search = " and hero_title like '%".$_GET['kewyword']."%'";
    $search_next = "&select=".$_GET['select']."&kewyword=".stripslashes($_GET['kewyword']);
}
//기간
if(strcmp($_GET['search_month'], '00') && strcmp($_GET['search_month'], '')){
    if(strcmp($_GET['search_month'], '99')){ //직접입력 아닐때
        $search .= " AND DATE_FORMAT(hero_today,'%Y-%m-%d') between DATE_SUB(DATE_FORMAT(NOW(),'%Y%m%d'), INTERVAL ".$_GET['search_month']." MONTH) and DATE_FORMAT(now(),'%Y%m%d') ";
    } else { //직접입력일때
        $search .= " AND DATE_FORMAT(hero_today,'%Y-%m-%d') between DATE_FORMAT('".$_GET['date-from']."','%Y-%m-%d') and DATE_FORMAT('".$_GET['date-to']."','%Y-%m-%d') ";
        $search_next .= "&date-from=".$_GET['date-from']."&date-to=".$_GET['date-to'];
    }

    $search_next .= "&search_month=".$_GET['search_month'];
}
$full_today = date("Y-m-d H:i:s");

$error = "thumbnail_07_list_01";
$right_sql = "select * from hero_group where hero_board='".$_GET['board']."' and hero_order!='0' and hero_use='1'";

$right_res = new_sql($right_sql,$error,"on");

if($right_res == $error){
	error_historyBack("");
	exit;
}

if($_SESSION['temp_view'])		$myview	= 	 $_SESSION['temp_level'];
else							$myview	= 	 0;


$right_rs = mysql_fetch_assoc($right_res);
if($right_rs['hero_view'] && $right_rs['hero_view']>$myview){
	error_historyBack("이 페이지는 ".$right_rs['hero_view']."레벨부터 볼 수 있습니다.");
	exit;
}


## 변수 설정
######################################################################################################################################################
$board				=	 $_GET['board'];
if($_GET['page'])		$page =	$_GET['page'];
else					$page =	1;

$myid				=	 $_SESSION['temp_id'];
$mycode				=	 $_SESSION['temp_code'];
$mynick				=	 $_SESSION['temp_nick'];
$mylevel			= 	 $_SESSION['temp_level'];

$list_page=9;
$page_per_list=10;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];

$start = ($page-1)*$list_page;

## 데이터 수 및 페이징 처리
######################################################################################################################################################

$sql = " select count(*) from mission_after where 1=1 ".$search;

$count_res = new_sql($sql,$error,"on");
if((string)$count_res==$error){
	error_historyBack("");
	exit;
}

$total_data = mysql_result($count_res,0,0);

$error = "thumbnail_07_list_02";
$main_sql = "select * from mission_after where 1=1 ".$search. "order by hero_period_01 desc limit ".$start.",".$list_page."";
$main_res = new_sql($main_sql,$error);

if($main_res==$error){
	error_historyBack("");
	exit;
}

$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next;


?>
	<!-- <script type="text/javascript" src="/m/js/masonry.pkgd.min.js"></script>
	<script type="text/javascript" src="/m/js/imagesloaded.pkgd.js"></script> -->
	<script>
	//  $(document).ready(function() {		
	//      var $container_02 = $('#thumbnail_07_list_div');
	//      imagesLoaded($container_02,function() {
	//     	  $container_02.masonry({
	// 	          	itemSelector: '.thumbnail_07_list_item',
	// 	          	isAnimated: false
	// 		   	});
	//     });
	//  });
    </script>
	<div id="subpage" class="moim_review">
		<div class="sub_title">
			<div class="sub_wrap">
				<div class="f_b">
					<div>
						<h1 class="fz68 main_c fw500 ko">모임 콘텐츠</h1>
						<p class="fz18 fw600">AK Lover의 즐거운 모임 현장을 느껴보세요!</p>
					</div>
					<ul class="tab f_c">
						<li><a href="/main/index.php?board=group_04_10" class="fz18 fw600">우수 콘텐츠</a></li>
						<li><a href="/main/index.php?board=group_04_09" class="fz18 fw600">전체 콘텐츠</a></li>
						<li><a href="/main/index.php?board=group_04_22" class="fz18 fw600 on">모임 콘텐츠</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="sub_cont">
			<div class="sub_wrap board_wrap f_sb">
				<div class="left">			
					<? include_once BOARD_INC_END.'search.php';?>
				</div>
				<div class="contents right rel">
					<div class="moim">
						<ul class="grid_3">
							<?
							$z = 1;
							while($main_rs = mysql_fetch_assoc($main_res)){
							?>
							<li>
								<div>
									<a href="/main/index.php?board=<?=$_GET["board"]?>&idx=<?=$main_rs["hero_idx"]?>">
										<img src="<?=$main_rs["hero_thumb"]?>" class="event_img">
									</a>
									<div class="event_text">
										<a href="/main/index.php?board=<?=$_GET["board"]?>&idx=<?=$main_rs["hero_idx"]?>">
											<p class="ptitle"><span class="title ellipsis_2line fz18 fw600"><?=$main_rs["hero_title"]?></span></p>
										</a>
											<? if($mylevel>=9999){?>
											<div>
												<p class="btn_edit" onclick="location.href='/main/index.php?board=<?=$board?>&view=step_write&action=write&idx=<?=$main_rs["hero_idx"]?>'">수정</p>
											</div>
										<? } ?>
									</div>
								</div>
							</li>
							<?
								$z++;
								}
							?>
						</ul>
					</div>					
					<div class="btngroup">
						<div class="btn_r">
							<?
								if($_SESSION['temp_write'])		$mywrite	= 	 $_SESSION['temp_write'];
								else							$mywrite	= 	 0;
								if($right_rs['hero_write']<=$myview){
									?>
										<a href="index.php?board=<?=$board?>&view=step_write&action=write" class="btn_submit small btn_main_c">글 작성하기</a>
									<?
								}
							?>
						</div>
					</div>	
					<?
					if(!strcmp($_GET['view'], '')){ ?>
					<div class="paging">
					<? include_once BOARD_INC_END.'page.php'; ?>
					</div>
					<? } ?>
				</div>
			</div>
		</div>
	</div>