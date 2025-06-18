<?php
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        $_SERVER['DOCUMENT_ROOT'].'/freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

##접근 제한
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

//필수 변수 확인
if(is_numeric($_POST['idx']))	$idx = $_POST['idx'];
else{
	echo "message:잘못된 접근입니다.";
	exit;
}

// IDEA LAP 설정
if($_POST['board']=='group_02_06' && $_SESSION['temp_level']<9999){
	if(!$_SESSION['temp_level']){
		echo "message:페이지에 대한 권한이 없습니다.";
		exit;
	}

	$error="ZIP_TODAY_01";
	$ch_vip_sql = "select hero_vip from member where hero_code='".$_SESSION['temp_code']."'";
	$ch_vip_res = new_sql($ch_vip_sql,$error,"on");

	if((string)$ch_vip_res==$error){
		echo 0;
		exit;
	}
	$hero_vip = mysql_result($ch_vip_res,0,0);
	if($hero_vip=='N'){
		echo "message:페이지에 대한 권한이 없습니다.";
		exit;
	}
}

//관리자에 의한 페이지 권한 설정에 의한 제한 
$error="ZIP_TODAY_02";
$group_sql = "select hero_view,hero_rev from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_POST['board']."'"; // desc
$group_res = new_sql($group_sql,$error,"on");
if((string)$group_res==$error){
	echo 0;
	exit;
}

$group_view = mysql_result($group_res,0,0);
$group_rev = mysql_result($group_res,0,1);
if($group_view > $_SESSION['temp_view'] && $group_view>0){

	if(!$_SESSION['temp_level'])			echo "message:로그인이 필요합니다.";
	else									echo "message:페이지에 대한 권한이 없습니다.";

	exit;
}

##변수 설정
######################################################################################################################################################
$idx = $_POST['idx'];
$board = $_POST['board']; 

$level = $_SESSION['temp_level'];
$code = $_SESSION['temp_code'];

$my_write = $_SESSION ['temp_write'];
$my_view = $_SESSION ['temp_view'];
$my_update = $_SESSION ['temp_update'];
$my_rev = $_SESSION ['temp_rev'];


##메인 쿼리
######################################################################################################################################################
$today = date( "Y-m-d", time());

$error="ZIP_TODAY_03";
if($board=='mail'){
	$board_sql = "select A.*, B.hero_nick from mail as A left outer join member as B on A.hero_code=B.hero_code where A.hero_idx='".$idx."'";
}else{
	$board_sql = "select A.*,B.hero_nick,C.recommand_count,D.report_count from (select * from board where hero_idx='".$idx."') as A left outer join member as B on A.hero_code=B.hero_code, ";
	$board_sql .= "(select count(*) as recommand_count from hero_recommand where hero_recommand_code='".$code."' and hero_board_idx='".$idx."') as C, ";
	$board_sql .= "(select count(*) as report_count from hero_report where hero_report_code='".$code."' and hero_board_idx='".$idx."') as D ";
	$board_sql .= "where A.hero_idx='".$idx."' ";
}
$board_res = new_sql($board_sql,$error);
if((string)$board_res==$error){
	echo 0;
	exit;
}

$board_rs = mysql_fetch_assoc($board_res);

if(!$board_rs["hero_idx"]){
	echo "message:잘못된 접근입니다";
	exit;
}

//2020-11-10 조회수 추가
if($_COOKIE["cookie_hero_hit"] != "hit_".$_POST['idx'] && $_POST['board'] == "group_04_03") {
	$board_hit_sql = " UPDATE board SET hero_hit = hero_hit+1 WHERE hero_idx = '".$_REQUEST['idx']."' ";
	mysql_query($board_hit_sql);
	
	setcookie("cookie_hero_hit", "hit_".$_REQUEST['idx'], time() + 86400, "/");
}
	
##본문처리
$next_command = htmlspecialchars_decode ( $board_rs ['hero_command'] );
$next_command = str_ireplace ( "<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n", "", $next_command );
$next_command = str_ireplace ( "<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n", "", $next_command );
$next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $next_command );
/* $next_command = preg_replace ( "/ width=(\"|\')?\d+(\"|\')?/", " width='100%'", $next_command ); */
$next_command = preg_replace ( "/ height=(\"|\')?\d+(\"|\')?/", "", $next_command );
/* $next_command = preg_replace ( "/width: \d+px/", "width:100%;", $next_command ); */
$next_command = preg_replace ( "/height: \d+px;/", "", $next_command );
$next_command = preg_replace ( "/height: \d+px/", "", $next_command );

$blog_urls = remove_kr($board_rs['hero_04']);

$result = "";
//$result .= "<div>";
//$result .= "<img src='img/shadow1.jpg' alt='' width='100%' height='2px' />";
//$result .= "</div>";
$result .= "<div class='hero_command' style='padding-top: 15px; padding-left: 5%; padding-right: 5%; line-height: 18px'>".$next_command."</div>";


//쪽지 일 경우 좋아요, 댓글은 없어도 된다.
if($board!='mail'){
	$result .= "<div class='btn_recommand_report'>";
	$result .= "<a onclick=\"today_openLayer(".$board_rs['hero_idx'].")\"><img src='/m/img/btn_mtab_close_190419.gif'></a>";
	$result .= "</div>";
	
	if($_SESSION['temp_level']>=9999 or $board_rs['hero_code']==$_SESSION['temp_code']){
		$result .= "<div class='list_btn' style='width: 90%; margin: auto; margin-top: 20px; margin-bottom: 20px'>";
		$result .= "<ul style='width: 100%'>";
		$result .="<li style='width: 60%; float: right; text-align: right'>";
		$result .="<a href='/m/write.php?board=".$board."&idx=".$idx."'>";
		$result .="<img src='img/review/modify_btn.jpg' alt='수정' width='70px'/>";
		$result .="</a>&nbsp;";
		$result .="<a href='/m/action.php?board=".$board."&action=delete&idx=".$idx."'>";
		$result .="<img src='img/review/delete_btn.jpg' alt='삭제' width='70px'/>";
		$result .="</a>";
		$result .="</li>";
		$result .= "</ul>";
		$result .= "<div class='clear'></div>";
		$result .= "</div>";
	}
	
	$error="ZIP_TODAY_04"; 
	$review_sql  = " select * from (select A.hero_code, A.hero_depth, A.hero_idx, A.hero_use, A.hero_today, A.hero_command,A.hero_depth_idx_old ";
	$review_sql .= " ,(select case when ifnull(hero_topfix,'N') != 'Y' then 'N' else 'Y' end hero_topfix FROM review where hero_idx = A.hero_depth_idx_old) as hero_topfix";
	$review_sql .= " ,B.hero_level,B.hero_nick,C.hero_img_new from review as A ";
	$review_sql .= " left outer join member as B on A.hero_code=B.hero_code ";
	$review_sql .= " left outer join level as C on B.hero_level=C.hero_level ";
	$review_sql .= " where hero_old_idx='".$board_rs['hero_idx']."' ) A  ";
	$review_sql .= " order by hero_topfix desc ";
	$review_sql .= " ,case when hero_topfix = 'Y' then hero_depth_idx_old end desc ";
	$review_sql .= " ,case when hero_topfix != 'Y' then hero_depth_idx_old end asc ";
	$review_sql .= " ,hero_depth asc,hero_today asc ";

	//exit;
	$review_res = new_sql($review_sql, $error);
	if ((string)$review_res==$error){
		echo 0;
		exit;
	}
	
	$result .= "<div id='reply'>";
	$result .= "<div class='clear'></div>";
	if($my_rev>='9999' or $group_rev<=$my_rev){
		$result .= "<ul>";
		$result .= "<li style='float:left;width:80%;'>";
		$result .= "<form id='review_form'>";
		$result .= "<input type='hidden' name='mode' value='review_write'>";
		$result .= "<input type='hidden' name='board' value='".$board."'>";
		$result .= "<input type='hidden' name='board_idx' value='".$board_rs['hero_idx']."'>";
		if($my_rev == "9999") {
			$result .= "<p><lebal for='hero_topFix'>상단 고정</label> <input type='checkbox' name='hero_topFix' id='hero_topFix' checked value='Y' /></p>";
		}
		$result .= "<textarea class='reply_box' id='top_command' onpaste='return false;' ></textarea>";
		$result .= "<form/>";
		$result .= "</li>";
		if($my_rev == "9999") {
			$result .= "<li style='text-align:right; padding-top:30px;'>";
		} else {
			$result .= "<li style='text-align:right;'>";
		}
		
		$result .= "<input type='button' value='등록' onclick='hero_review_submit(\"review_form\", \"top_command\",\"mobile\")' class='btn-warning today_btn' style='height:70px;width: 16%;'/>";
		$result .= "</li>";
		$result .= "</ul>";
	}
	$result .= "</div>";
	
	
	$review_data = mysql_num_rows ( $review_res );
	$review_i = $review_data - 1;
	
	while ( $review_rs = mysql_fetch_assoc ($review_res) ) {
		
		if ($review_i==0)		$last_class = ' last';
		else					$last_class = '';
		
		$result .= "<div class='reply_view'>";
		if(strcmp($review_rs['hero_use'], '1')){
			$result .= "<div>";
			$result .= "<div class='nickname'>";
			if($review_rs['hero_depth']>=1){
				$result .= "<img src='img/review/reply_arrow.png' alt=''/>";
			}
			$result .= "<img src='".str($review_rs['hero_img_new'])."'/>";
			//$result .= mb_substr($review_rs['hero_nick'],0,5,"EUC-KR");
			$result .= "<span>".$review_rs['hero_nick']."</span>";
			$result .= "<span class='date'>".date( 'Y-m-d', strtotime($review_rs['hero_today']))."</span>";
			$result .= "</div>";
			$result .= "<div";
			if(strlen(nl2br($review_rs['hero_command'])) != strlen($review_rs['hero_command'])){
				$result .=" class='command_pre'";
			}else{
				$result .=" class='command'";
			}
			$result .= ">";				
			$result .= htmlspecialchars($review_rs['hero_command'],ENT_COMPAT,"ISO-8859-1");
			$result .= "</div>";
			$result .= "</div>";
			$result .= "<div class='button_area'>";
			
			if($level){
				$result .= "<input type='button' value='댓글' onclick='reply_area(".$board_rs['hero_idx'].",\"review_write\",".$review_rs['hero_idx'].",".$review_rs['hero_depth_idx_old'].",this)' class='btn-warning today_btn'/>";
			}
			if( $my_rev>=9999 or $review_rs['hero_code']==$code){
				$result .= "<input type='button' value='수정' onclick='reply_area(".$board_rs['hero_idx'].",\"review_edit\",".$review_rs['hero_idx'].",".$review_rs['hero_depth_idx_old'].",this)' class='btn-info today_btn'/>";
				$result .= "<input type='button' value='삭제' onclick='check_review_del(".$review_rs['hero_idx'].")' class='btn-danger today_btn'/>";
	       	}
			$result .= "</div>";
		}else{
			$result .= "<div class='nickname'>삭제된 글 입니다.</div>";
		}
		$result .= "<div class='reply_area_top'>";
		$result .= "</div>";
		$result .= "<div class='clear'></div> ";
		$result .= "</div>";
	}
}//end 쪽지 일 경우 좋아요, 댓글은 없어도 된다.
	
//$result .= "<div style='border-bottom: 1px solid #c8c8c8'>";
//$result .= "<img src='img/shadow1.jpg' alt='' width='100%' height='2px' />";
$result .= "</div>";
$result .= "<div class='clear'></div>";
$result .= "</div>";

//메일을 확인한 경우 update
if($board=='mail' && ($board_rs ['hero_user_check']=='' || !strstr($board_rs ['hero_user_check'], $_SESSION['temp_id']))){
	if($board_rs['hero_user_check']=='')		$new_hero_user_check = $_SESSION['temp_id'];
	else										$new_hero_user_check = $board_rs['hero_user_check'].'||'.$_SESSION['temp_id'];

	$update_mail_sql = "UPDATE mail SET hero_user_check='".$new_hero_user_check."' WHERE hero_idx = '".$idx."'";
	@mysql_query($update_mail_sql);
}

//echo $result; //로컬
echo  iconv("CP949","UTF-8",$result); //운영
exit;
?>