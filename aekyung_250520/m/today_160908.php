<?php

######################################################################################################################################################
include_once "head.php";
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//운송장 확인 페이지 비로그인시 로그인 필수
if($_GET['board']=='group_04_20'){
	if (!$_SESSION ['temp_level']){
		error_location("권한이 없습니다.","/m/main.php?board=login");
		exit;
	}
}

if($_GET['board']=='group_02_06' && $_SESSION['temp_level']<9999){
	if(!$_SESSION['temp_level']){
		error_historyBack("죄송합니다. 페이지에 대한 권한이 없습니다.");
		exit;
	}


	$ch_vip_sql = "select hero_vip from member where hero_code='".$_SESSION['temp_code']."'";
	$ch_vip_res = mysql_query($ch_vip_sql);
	if(!$ch_vip_res){
		logging_error($_SESSION['temp_code'], $_GET['board']."-GROUP_02_06_CHECK_01-".$ch_vip_sql,date("Y-m-d H:i:s"));
		error_historyBack("");
		exit;
	}
	$ch_vip_rs = mysql_fetch_assoc($ch_vip_res);
	if($ch_vip_rs['hero_vip']=='N' || $ch_vip_rs['hero_vip']==''){
		error_historyBack("죄송합니다. 페이지에 대한 권한이 없습니다.");
		exit;
	}
}

// #####################################################################################################################################################
$error = "TODAY_01";
$group_sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'"; // desc
//echo $group_sql;
//exit;
$out_group = new_sql( $group_sql,$error );
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}
$right_list = mysql_fetch_assoc ( $out_group );

if($right_list["hero_view"]>$_SESSION['temp_level'] && $right_list["hero_view"]!=0){
	error_historyBack("페이지 권한이 없습니다.");
	exit;
}


if($_GET['type']=='recommand'){
		
		$recom_rs = recommand();
		if(substr($recom_rs,0,7)=='message'){
			$message = explode($recom_rs,":");
			location(del_get($_SERVER["HTTP_REFERER"],"idx")."&idx=".$_GET['idx']);
		}elseif($recom_rs!=1){
			error_historyBack("");
			exit;
		}elseif($recom_rs==1){
			message("추천하였습니다.");
			location(del_get($_SERVER["HTTP_REFERER"],"idx")."&idx=".$_GET['idx']);		
		}
		exit;
		
	}
	
	if($_GET['type']=='report'){
		$report_rs = report();
	
		if(substr($report_rs,0,7)=='message'){
			$message = explode(":",$report_rs);
			message($message[1]);
			location(del_get($_SERVER["HTTP_REFERER"],"idx")."&idx=".$_GET['idx']);
		}elseif($report_rs!=1){
			error_historyBack("");
			exit;
		}elseif($report_rs==1){
			message("신고하였습니다.");
			location(del_get($_SERVER["HTTP_REFERER"],"idx")."&idx=".$_GET['idx']);
		}
		exit;
	}

	
	##임시글 권한 설정
	if($_SESSION['temp_level']<9999)	$hero_use="and hero_use=1 ";

##변수 설정
#####################################################################################################################################################
/*if ($_GET ['board']=="group_02_01") 			$title_view_all = "오늘 하루 일상을 남겨주세요";
else if ($_GET ['board']=="group_04_03") 		$title_view_all = "공지사항 입니다";
else if ($_GET ['board']=="group_03_03" ) 		$title_view_all = "신상품, 구입정보 등 제품에 대한 이슈를 공개해요";
else if ($_GET ['board']=="group_04_11" ) 		$title_view_all = "파워 블로그 팁을 알려드려요";
else if ($_GET ['board']=="group_02_02" ) 		$title_view_all = "연애, 결혼에 대한 고민을 함께 나눠요";
else if ($_GET ['board']=="group_03_04" ) 		$title_view_all = "제품에 대한 아이디어를 남겨주세요";
else if ($_GET ['board']=="group_03_05" ) 		$title_view_all = "제품에 대해 칭찬해주세요";
else if ($_GET ['board']=="group_02_05" ) 		$title_view_all = "지역별, 연령별, 목적별로 게시글을 통해 오프라인으로 만나요";
else if ($_GET ['board']=="group_04_20" ) 		$title_view_all = "제품/선물 발송 관련 소식을 알려드려요";
else if ($_GET ['board']=="mail" ) 				$title_view_all = "쪽지함입니다";*/

$today = time(date('Y-m-d'));
$week = date("w");
$week_first = $today-($week*86400); 	//이번 주의 첫날인 일요일
$week_last = $week_first+(7*86400); 	//이번 주의 마지막날인 토요일

$week_first = date("Y-m-d",$week_first);
$week_last = date("Y-m-d",$week_last);

if($_GET['board']=='mail'){
	$sql = "select count(*) from mail where hero_user like '%". $_SESSION ['temp_id']."%' or hero_user='all' order by hero_today desc";
}else{
	$sql = 'select count(*) from board where hero_table=\'' . $_REQUEST ['board'] . '\' order by hero_today desc';
}

$error = "TODAY_01";
$out_sql = new_sql( $sql, $error,"on" );

if((string)$out_sql==$error){
	error_historyBack("");
	exit;
}
$total_data = mysql_result ( $out_sql,0,0 );
#####################################################################################################################################################
$list_page = 5;
$page_per_list = 5;

if (! strcmp ( $_GET ['page'], '' )) $page = '1';
else 	$page = $_GET ['page'];

$start = ($page - 1) * $list_page;
$next_path = get ( "page||hero_i_count||idx" );

// #####################################################################################################################################################
?>

	<link href="css/today.css" rel="stylesheet" type="text/css">

	<!--컨텐츠 시작-->
	<div id="title">
		<p><?=$right_list['hero_title'];?></p>
	</div>

	<div>
		<img src="img/shadow1.jpg" alt="" width="100%" height="2px" />
	</div>
		
	<!--<div id="guide">
		<div id="guide_left" style="float: left; width: 70%">
			<ul style="width: 100%">
				<li style="width: 20%; margin-left: 5%"><img src="img/today/note3.png" alt="" width="42px" /></li>
				<li class="guide_text" style="width: 75%"><p><?=$title_view_all?></p></li>
			</ul>
		</div>
	</div>-->
    <? include_once "boardIntroduce.php"; ?>
	<div class="clear"></div>
		
	<div id="today_list">
		<?
$error = "TODAY_03";
		if($_GET['board']=='mail'){
			$main_sql = "select * from mail where hero_user like '%". $_SESSION ['temp_id']."%' or hero_user='all' order by hero_today desc limit ".$start.",".$list_page;
		}else{
			//공지사항일 경우
			if ($_REQUEST ['board']=="group_04_03" and ($_GET["page"]==1 or $_GET["page"]==0)) {
				$main_sql .= "select A.* from (select * from board where hero_table='hero' and hero_order ='0' ".$hero_use." order by hero_order asc) A ";
				$main_sql .= "union ";
			//공지사항이 아닐 경우 (추천글)
			}elseif($_GET["page"]==1 or $_GET["page"]==0){
				$main_sql .= "select B.* from (select * from board where hero_rec>'0' /* and hero_rec_manage!=1 */ and hero_table='".$_GET['board']."' and (LEFT(hero_today,10) between '".$week_first."' and '".$week_last."') order by hero_rec desc limit 0,3) B ";
				$main_sql .= "union ";
			}
		
 			$main_sql .= "select C.* from (select * from board where hero_table='".$_GET['board']."' ".$hero_use." ".$search." order by hero_today desc limit ".$start.",".$list_page.") C ";
		}
		//echo "<script>console.log(\"".$main_sql."\");</script>";
		//exit();
		$out_main = new_sql($main_sql,$error );
		if((string)$out_main==$error){
			error_historyBack("");
			exit;  
		}
		
			
		$i = 1;
		while ( $board_rs = mysql_fetch_assoc ( $out_main ) ) {
			$error = "TODAY_04";
			$sub_sql = "select A.hero_nick, B.hero_img_new, C.count from member as A, level as B, (select count(*) as count from review where hero_old_idx='".$board_rs['hero_idx']."') as C where B.hero_level = A.hero_level and A.hero_code = '".$board_rs['hero_code']."'";
			//echo $sub_sql;
			//exit;
			$sub_res = new_sql($sub_sql,$error);
			if((string)$sub_res==$error){
				error_historyBack("");
				exit;
			}
			
			$hero_nick = mysql_result($sub_res,0,0);
			$hero_img_new = mysql_result($sub_res,0,1);
			$hero_rev_count = mysql_result($sub_res,0,2);
			
			$title = $board_rs ['hero_title'];
			$title = TRIM ( str_ireplace ( '&nbsp;', '', strip_tags ( htmlspecialchars_decode ( $title ) ) ) );
			$title = str_replace ( "\r", "", $title );
			$title = str_replace ( "\n", "", $title );
			$title_01 = str_replace ( "&#65279;", "", $title );
			
			if ($title_01=='') 											$title_01 = "&nbsp;";
			
			if($_GET['board']=='mail'){
				if ($board_rs ['hero_user_check']=='' or !strstr($board_rs ['hero_user_check'], $_SESSION['temp_id'])) {
										$new_img_view = " <img src='" . DOMAIN_END . "image/main_new_bt.png' alt='new' />&nbsp;";
				} else 					$new_img_view = "";
			}else{
				if (date("Y-m-d")==substr($board_rs ['hero_today'],0,10)) 	$new_img_view = " <img src='" . DOMAIN_END . "image/main_new_bt.png' alt='new' />&nbsp;";	
				else 														$new_img_view = "";

				if($hero_rev_count>0)										$rev_count = "<font color='orange'>&nbsp;[".$hero_rev_count."]</font>";
				else														$rev_count = "";
				
				if($board_rs['hero_rec']>0 && $i<4 && (!$_GET['page'] || $_GET['page']==1) && $_REQUEST ['board']!="group_04_03")		$recommand_img = "<img src='/image/bbs/bbs_view_recom.gif' alt='추천'>&nbsp;&nbsp;";
				else																			$recommand_img = '';
			}
			
			if($board_rs['hero_table']!="hero")								$li_first = "<img src='".str($hero_img_new)."'/>".$hero_nick;
			else															$li_first = "<img src='img/today/notice_btn.jpg' alt='전체공지' />";
			
			
			?>
		
				<div id="tabbtn_<?=$board_rs["hero_idx"]?>" class="tabbtn" onClick="today_openLayer('<?=$board_rs["hero_idx"]?>');">
					<div class="title_left">
						<ul>
							<li class="tabbtn_top"><?=$recommand_img?><?=$li_first?></li>
							<li class="tabbtn_title"><?=$new_img_view.$title_01.$rev_count?></li>
							<li class="tabbtn_date">작성일 <?=date( "Y.m.d", strtotime($board_rs['hero_today']));?></li>
						</ul>
					</div>
		
					<div class="title_right" style="float: right; margin-right: 3%;">
						<img src="img/today/list_arrow1.png" alt=""	width="24" />
					</div>
				</div>
				<div class='tabcon tabcon_<?=$board_rs["hero_idx"]?> tabcon_hide'></div>

			<?
			$i ++;
		}

?>
<div id="page_number">
<?include_once "page.php"?>
<?

$sql = 'select * from hero_group where hero_board = \'' . $_GET ['board'] . '\'';
sql ( $sql, 'on' );
$check_list = @mysql_fetch_assoc ( $out_sql );
if ($check_list ['hero_write'] <= $_SESSION ['temp_write'] && $_REQUEST['board'] != "group_04_03") {
	?>
        <span class="gallery_btn"> 
          	<a href="<?=DOMAIN_END?>m/write.php?board=<?=$_REQUEST['board']?>&action=write">
				<img src="img/general/write_btn.jpg" alt="글쓰기" width="70px">
			</a>
		</span> 
<?}?>
      </div>
<script>
	<?php 
		if($_GET["idx"]){
	?>
			$(document).ready(function(){

				today_openLayer(<?=$_GET["idx"]?>);
				
			});
	<?php 
}
	?>

	function reply_area(board_idx,mode,depth_idx,depth_idx_old,obj){

		cancle_reply();

		var reply_area_top = $(obj).parent('.button_area').siblings('.reply_area_top');
		var command = '';
		if(mode=="review_edit"){
			command = $(obj).parent('.button_area').parent('.reply_view').find('.command').html();
		}
		
		var reply_view ='';
			
		reply_view += "<div>";
		reply_view += "<ul>";
		reply_view += "<li style='width:70%;float:left;'>";
		reply_view += "<form id='review_form_02'>";
		reply_view += "<input type='hidden' name='mode' value='"+mode+"'>";
		reply_view += "<input type='hidden' name='board' value='<?=$_GET['board']?>'>";
		reply_view += "<input type='hidden' name='board_idx' value='"+board_idx+"'>";
		reply_view += "<input type='hidden' name='depth_idx' value='"+depth_idx+"'>";
		reply_view += "<input type='hidden' name='depth_idx_old' value='"+depth_idx_old+"'>";
		reply_view += "<textarea id='hero_command' class='reply_box'>"+command+"</textarea>";
		reply_view += "</form>";
		reply_view += "</li>";
		reply_view += "<li style='text-align:right;'>";
		reply_view += "<input type='button' value='확인' class='btn-warning today_btn' style='height:70px;' onclick='hero_review_submit(\"review_form_02\", \"hero_command\",\"mobile\")' alt='댓글 입력'>";
		reply_view += "<input type='button' value='취소' class='btn-danger today_btn' style='height:70px;' onclick='cancle_reply();' alt='취소'>";
		reply_view += "</li>";
		reply_view += "</ul>";
		reply_view += "<div class='clear'></div>";
		reply_view += "</div>";

		reply_area_top.html(reply_view);
		reply_area_top.slideDown("slow");
	}

	function cancle_reply(){
		$('.reply_area_top').slideUp('slow');
		$('.reply_area_top').html('');
	}

	function check_review_del(idx){

		if(confirm("삭제하시겠습니까?")==true)	hero_review_del(idx,"mobile");		
		else								return false;
		
	}

    function today_openLayer(no){

    	var tabcon = $(".tabcon_"+no);

    	if(tabcon.hasClass("tabcon_hide")){
    	 	var url="/main/zip_today.php";  
    	 	var params="board=<?=$_GET["board"]?>&idx="+no;  
    	  
    	    $.ajax({      
    	        type:"POST",  
    	        url:url,      
    	        data:params,
    	        async : 'false',      
    	        success:function(args){
        	        //console.log(args);  
        	        $(".tabcon").html("");
        	        $(".tabcon").slideUp("fast"); 
    	            tabcon.html(args);
    	            tabcon.removeClass("tabcon_hide");      
    	        	tabcon.slideDown("slow");
		            
    	        },beforeSend:function(){
		            $('.img-loading').css('display','block');
		        }
		        ,complete:function(){
    	        	setTimeout(function(){ 
        	        	location.href="#tabbtn_"+no;
        	        	$('.img-loading').css('display','none'); 
        	        }, 500);  
		            
		        },
    	        error:function(e){  
    	            alert(e.responseText);  
    	        }
    	    });  
    	}else{
    		<?php
            	if($_GET['board']=='mail'){
            ?>
            		tabcon.siblings(".tabbtn").find(".tabbtn_title").children("img").slideUp("");
            <?php 
            	}
            ?>
       			tabcon.slideUp("");
       			tabcon.addClass("tabcon_hide");
       			tabcon.html("");  
        }
    }
</script>
<div class="img-loading">
    	<div><img src="/image2/etc/loading1.gif" /></div>
	</div>
      

	<!--컨텐츠 종료-->
<?
include_once "tail.php";?>