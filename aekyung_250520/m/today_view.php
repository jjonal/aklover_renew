<?
include_once "head.php";

if(!defined('_HEROBOARD_'))exit;

function auto_link_text($text) {
    $pattern = '#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#';
    $callback = create_function('$matches',
        '$url = array_shift($matches); return "<a href=\'$url\'>$url</a>";' );
    return preg_replace_callback($pattern, $callback, $text);
}

$error = "TODAY_01";
$group_sql = "SELECT * FROM hero_group WHERE hero_order!='0' AND hero_use='1' AND hero_board ='".$_GET['board']."'"; // desc

$out_group = new_sql( $group_sql,$error );
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}

$right_list = mysql_fetch_assoc ($out_group);

if(!$_GET["board"]) {
	error_historyBack("페이지 권한이 없습니다.","/m/main.php");
	exit;
}

if($right_list["hero_view"]>$_SESSION['temp_level'] && $right_list["hero_view"]!=0){
	if($_GET['board'] == "mail") {
		message("로그인 후 이용해 주세요.");
		location("/m/main.php");
	} else {
		error_historyBack("페이지 권한이 없습니다.","/m/main.php");
	}
	exit;
}

//if($_COOKIE["cookie_hero_hit"] != "hit_".$_GET['hero_idx'] && $_GET['board'] == "group_04_03") { //2020-11-10 조회수 추가
if($_COOKIE["cookie_hero_hit"] != "hit_".$_REQUEST['idx']) { // 2023-08-25 모든 게시물에 조회수 추가
	$board_hit_sql = " UPDATE board SET hero_hit = hero_hit+1 WHERE hero_idx = '".$_GET['hero_idx']."' ";
	mysql_query($board_hit_sql);
	
	// setcookie("cookie_hero_hit", "hit_".$_GET['hero_idx'], time() + 86400, "/");
}

$level = $_SESSION['temp_level'];
$code = $_SESSION['temp_code'];

$my_write = $_SESSION ['temp_write'];
$my_view = $_SESSION ['temp_view'];
$my_update = $_SESSION ['temp_update'];
$my_rev = $_SESSION ['temp_rev'];

if($_SESSION['temp_level']<9999)	$hero_use="and b.hero_use=1 "; ##임시글 권한 설정

$gubun = "";
if($_GET["board"] == "group_02_02") { //수다통 사용
	$gubun_arr = array("1"=>"일상","2"=>"체험단","3"=>"제안");
} else if($_GET["board"] == "group_04_03") { //공지사항
    $gubun_arr = array("1"=>"필독","2"=>"안내","3"=>"이벤트");
} else if($_GET["board"] == "group_04_24") { //배움통
	$gubun_arr = array("1"=>"필독","2"=>"블로그","3"=>"인스타","4"=>"유튜브&영상");
	$hero_keywords_arr = array("1"=>"리뷰","2"=>"활동","3"=>"리뷰 TIP","4"=>"매체 TIP");
}

$error = "TODAY_01";
if($_GET["board"] == "mail") {
	$member_sql = "SELECT hero_oldday FROM member WHERE hero_id ='".$_SESSION['temp_id']."'";
	$member_out_sql = mysql_query($member_sql);
	$member = @mysql_fetch_assoc($member_out_sql);
	
	$board_sql  = " SELECT b.hero_idx,  b.hero_user, b.hero_title, b.hero_command, b.hero_command2, b.hero_today, b.hero_user_check, m.hero_nick, m.hero_idx as member_idx, l.hero_img_new FROM mail b ";
	$board_sql .= " INNER JOIN member m ON b.hero_code = m.hero_code ";
	$board_sql .= " LEFT JOIN level l ON m.hero_level = l.hero_level ";
	$board_sql .= " WHERE ((b.hero_user='all' and b.hero_today > '".$member['hero_oldday']."') ";
	$board_sql .= " or CONCAT('||', b.hero_user, '||') LIKE '%||".$_SESSION['temp_id']."||%') AND b.hero_idx = '".$_GET["hero_idx"]."' ";
} else {
	$board_sql  = " SELECT b.hero_code,b.hero_idx, b.hero_notice_use, b.hero_title, b.gubun, b.hero_command, b.hero_today, b.hero_keywords, b.hero_table, b.hero_use, b.hero_notice_use, b.hero_review_use ";
	$board_sql .= ", m.hero_nick , m.hero_idx as member_idx, l.hero_img_new FROM board b ";
	$board_sql .= " LEFT JOIN member m ON b.hero_code = m.hero_code ";
	$board_sql .= " LEFT JOIN level l ON m.hero_level = l.hero_level ";
	$board_sql .= " WHERE 1=1 ".$hero_use." AND b.hero_idx = '".$_GET["hero_idx"]."' AND (b.hero_table = '".$_GET["board"]."' OR b.hero_table = 'hero') ";
}

$out_sql = new_sql($board_sql, $error, "on");

if((string)$out_sql==$error){
	error_historyBack("");
	exit;
}
$view = mysql_fetch_assoc($out_sql);

//공지사항, 수다통, 배움통 이전글, 다음글 추가
if(($view["hero_table"] == "group_02_02" || $view["hero_table"] == "group_04_03" || $view["hero_table"] == "group_04_24") && $view["hero_use"] == "1" && !$view["hero_notice_use"]) {
	$board_prev_sql = " SELECT hero_idx, hero_title FROM board WHERE hero_table = '".$view["hero_table"]."' AND hero_use = 1  AND hero_notice_use = 0 AND hero_idx > '".$view["hero_idx"]."' ORDER BY hero_idx ASC LIMIT 0,1 ";
	$board_prev_res = sql($board_prev_sql);
	$board_prev_rs = mysql_fetch_assoc($board_prev_res);
	
	$board_next_sql = " SELECT hero_idx, hero_title FROM board WHERE hero_table = '".$view["hero_table"]."' AND hero_use = 1  AND hero_notice_use = 0 AND hero_idx < '".$view["hero_idx"]."' ORDER BY hero_idx DESC LIMIT 0,1 ";
	$board_next_res = sql($board_next_sql);
	$board_next_rs = mysql_fetch_assoc($board_next_res);
}

if($_GET["board"] == "mail") {
	if(strcmp(eregi($_SESSION['temp_id'],$view['hero_user']),'1') && $view['hero_user'] != 'allUser' && $view['hero_user'] != 'all'){
		error_historyBack("본인의 쪽지만 확인 가능합니다.");
		exit;
	}	
	
	$view_search_id = ",".$_SESSION['temp_id'].",";
	
	$view_user_check_id = str_replace("||",",",$view['hero_user_check']);
	$view_user_check_id = ",".$view_user_check_id.",";
	
	if(strcmp(eregi($view_search_id,$view_user_check_id),'1')){
		if(!strcmp($view['hero_user_check'],'')){
			$new_hero_user_check = $_SESSION['temp_id'];
		}else{
			$new_hero_user_check = $view['hero_user_check'].'||'.$_SESSION['temp_id'];
		}
		$sql = 'UPDATE mail SET hero_user_check=\''.$new_hero_user_check.'\' WHERE hero_idx = \''.$_GET['hero_idx'].'\';'.PHP_EOL;
		mysql_query($sql);
	}
	
	// $next_command = "<pre style='padding:0;margin:0;border:none;color:#666; background:none; font-family:\'맑은 고딕\',\'Malgun Gothic\', \'돋움체\',\'돋움\';'>".$view['hero_command']."</pre>";
	$contents = '';
	if(empty($view['hero_command2'])) {
	    $contents = $view['hero_command'];
	} else {
	    $contents = $view['hero_command2'];
	}
	
	$next_command = htmlspecialchars_decode ($contents);
	$next_command = str_ireplace ( "<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n", "", $next_command );
	$next_command = str_ireplace ( "<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n", "", $next_command );
	$next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $next_command );
	$next_command = preg_replace ( "/ height=(\"|\')?\d+(\"|\')?/", "", $next_command );
	$next_command = preg_replace ( "/height: \d+px;/", "", $next_command );
	$next_command = preg_replace ( "/height: \d+px/", "", $next_command );
} else {
	$next_command = htmlspecialchars_decode ($view['hero_command'] );
	$next_command = str_ireplace ( "<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n", "", $next_command );
	$next_command = str_ireplace ( "<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n", "", $next_command );
	$next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $next_command );
	/* $next_command = preg_replace ( "/ width=(\"|\')?\d+(\"|\')?/", " width='100%'", $next_command ); */
	$next_command = preg_replace ( "/ height=(\"|\')?\d+(\"|\')?/", "", $next_command );
	/* $next_command = preg_replace ( "/width: \d+px/", "width:100%;", $next_command ); */
	$next_command = preg_replace ( "/height: \d+px;/", "", $next_command );
	$next_command = preg_replace ( "/height: \d+px/", "", $next_command );
}
?>
<link href="css/musign/board.css" rel="stylesheet" type="text/css">
<link href="css/musign/cscenter.css" rel="stylesheet" type="text/css">	

<? if($_GET["board"] == "group_04_03" || $_GET["board"] == "cus_2" || $_GET["board"] == "cus_3"  ) { ?>
	<?include_once "cscenter.php"?>
<? } else if($_GET["board"] == "group_02_02"){ //lover_talk?>
	<? include_once "talk_top.php"; ?>
<? } ?>

<form name="searchForm" id="searchForm" method="GET">
<? foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
<input type="hidden" name="idx" value="<?=$view["hero_idx"]?>" />
</form>
<div class="view_cont cs_view">
	<div class="title rel">
		<!-- 제목 -->
		<span class="fz44 fw700"><?=$new_img_view?><?=cut($view['hero_title'],100);?></span>
	</div>
	<div class="writer f_b">
		<a href="javascript:;" class="gray fz24 fw500 f_cs nick_cate" onClick="fnProfile('<?=encrypt($view['member_idx']);?>')">
			<span class=""><?=$view['hero_nick'];?></span>
			<!-- <? if($view["hero_notice_use"] == "1") {?>[공지]<? } ?> -->
			<? if($view['gubun'] > 0 && $view['gubun'] < 4) {?>
				<span class="color_<?=$view['gubun'];?> mu_bar"><?=$gubun_arr[$view['gubun']]?></span>	
			<? } ?>			
			<? if($_GET["board"] == "group_04_24" && $view['hero_keywords']) {?>
				<span class="txt_hero_keywords mu_bar">[<?=$hero_keywords_arr[$view['hero_keywords']]?>]</span>
			<? } ?>
		</a>
		<span class="gray fz24 fw500"><?=date( "Y.m.d", strtotime($view['hero_today']));?></span>
	</div>
	<div class="contBox cont"><?=$next_command;?></div>
</div>
<div class="reply_wrap">
<? if($_GET["board"] != "mail" && $view['hero_review_use'] == 1) { // $_GET["hero_idx"] != "361962" 2021-12-14 임시로 댓글 막음?>
	<div id="reply">
		<div class="comment_cnt">
			<p class="fz28 fw700">댓글 <span class="main_c"><?=$review_data?></span></p>
		</div>
		<ul style="width:100%">
			<?
			if($my_rev>='9999' or $right_list['hero_rev']<=$my_rev){
			?>
	       		<li>
	       			<form id="review_form">
					   	<input type="hidden" name="mode" value="review_write"> 
					   	<input type="hidden" name="board" value="<?=$_GET['board']?>">
					   	<input type="hidden" name="board_idx" value="<?=$view['hero_idx']?>">
					   	<? if($my_rev == "9999") {?>
					    <!-- <p><lebal for='hero_topFix'>상단 고정</label> <input type='checkbox' name='hero_topFix' id='hero_topFix' checked value='Y' /></p> -->
					    <? } ?>
					</form>
	       			<div class="reply_bx">
						<div class="rel">
							<textarea id="hero_command" name="hero_command" <?if($my_rev != "9999") {?>onpaste="return false" <?}?> cols="" rows="" class="reply_txt_box"></textarea>
							<input type="button" class='btn-warning today_btn btn_reply' onClick="hero_review_submit('review_form', 'hero_command', 'pc');" alt="댓글입력">
						</div>
					</div>		
				</li>
			<? }else{ ?>   <!-- 비로그인 -->
			<li class="reply_bx">
				<div class="rel non_reply">
					<div class="non_reply_txt reply_txt_box fz26">댓글을 작성하시려면 <span class="main_c">로그인</span> 해주세요.</div>
					<div class='btn_reply'></div>
				</div>
			</li>
			<?
			}
			?>
	    </ul>
	</div>

	<?
	$review_sql  = " select * from (select A.hero_code, A.hero_depth, A.hero_idx, A.hero_use, A.hero_today, A.hero_command,A.hero_depth_idx_old ";
	$review_sql .= " ,(select case when ifnull(hero_topfix,'N') != 'Y' then 'N' else 'Y' end hero_topfix FROM review where hero_idx = A.hero_depth_idx_old) as hero_topfix";
	$review_sql .= " ,B.hero_level,B.hero_nick,C.hero_img_new from review as A ";
	$review_sql .= " left outer join member as B on A.hero_code=B.hero_code ";
	$review_sql .= " left outer join level as C on B.hero_level=C.hero_level ";
	$review_sql .= " where hero_old_idx='".$view['hero_idx']."' ) A  ";
	$review_sql .= " order by hero_topfix desc ";
	$review_sql .= " ,case when hero_topfix = 'Y' then hero_depth_idx_old end desc ";
	$review_sql .= " ,case when hero_topfix != 'Y' then hero_depth_idx_old end asc ";
	$review_sql .= " ,hero_depth asc,hero_today asc ";
	
	//echo $review_sql;
	
	
	$review_res = new_sql($review_sql, $error);
	if ((string)$review_res==$error){
		echo 0;
		exit;
	}
	
	$review_data = mysql_num_rows ( $review_res );
	$review_i = $review_data-1;
	
	while($review_row                             = @mysql_fetch_assoc($review_res)){

		if (! strcmp ( $review_i, '0' )) 	$last_class = 'last';
			else 								$last_class = '';

			$pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \'' . $review_row ['hero_code'] . '\'';
			//echo $pk_sql;
			$out_pk_sql = mysql_query ( $pk_sql );
			$pk_row = @mysql_fetch_assoc ( $out_pk_sql );

			if (! strcmp ( $review_row ['hero_depth'], '0' )) {
				$temp_check_count_i = 0;
				$check_sql = 'select * from review where hero_depth_idx_old= \'' . $review_row ['hero_idx'] . '\'';
				$out_check_sql = mysql_query ( $check_sql );
				$check_count = @mysql_num_rows ( $out_check_sql );
			}

			$temp_check_count = $check_count - $temp_check_count_i;
	    
		if(strcmp ( $review_row ['hero_depth'], '0' ))														$class = "rpment ";

		if(strcmp ( $review_row ['hero_depth'], '0' ) && !strcmp (  $temp_check_count, '1' )) 				$class .= "depth2_last ";

		if(!strcmp ( $review_row ['hero_depth'], '1' ) and !strcmp ( $temp_check_count, '1' ))	 			$class .= "last ";

		if(!strcmp($review_row['hero_depth'], '0') and strcmp($check_count, '1') )							$class .= "rp ";

        $commandArray = explode('SS$$SS', $review_row['hero_command']);
        if($commandArray[1]) {
            $parentName = $commandArray[1];
            $review_row['hero_command'] = $commandArray[2];
        }
        else{
            $parentName = '';
            $review_row['hero_command'] = $commandArray[0];
        }
	?>
	
	<div class="<?=$class.$last_class?> replybx">
			<?
				if(strcmp($review_row['hero_use'], '1')){
			?>
				<div class="txt_id fz16 fw700 rel">
					<?if( $my_rev>=9999 or $review_row['hero_code']==$_SESSION['temp_code']){?>
						<div class="editbox">
							<div class="rel editinner">
								<ul>
									<li class="btn-info today_btn">
										<input type='button' class="fz24 fw500" value="수정" onclick="reply_area(<?=$view['hero_idx']?>,'review_edit',<?=$review_row['hero_idx']?>,<?=$review_row['hero_depth_idx_old']?>,this);" class="btn-info today_btn"/>
									</li>
									<li>
										<a herf="javascript:;" onclick="check_review_del(<?=$review_row['hero_idx']?>)" class="fz24 fw500 btn-danger today_btn">삭제</a>
									</li>
								</ul>
							</div>
						</div>
					<?}?>
				</div>
				<div>
					<div class="nickname">
						<span class="fz26 bold">
							<?=mb_substr($review_row['hero_nick'],0,5,"EUC-KR")?>
						</span>
					</div>
					<div class="command">
                        <?if($parentName != ''){?>
                            <!-- 대댓글 입력시 원댓글 작성자의 닉네임 노출 영역  -->
                            <b class="bold" style="color: #FF4C05"><?='@'.$parentName?></b>
                            <!-- //대댓글 입력시 원댓글 작성자의 닉네임 노출 영역  -->
                        <?}?>
						<!-- 대댓글 입력시 원댓글 작성자의 닉네임 노출 영역  -->
						<b class="bold"></b> <?=auto_link_text(htmlspecialchars($review_row['hero_command'],ENT_COMPAT,"ISO-8859-1"))?>
					</div>
					<span class="ft_date fz24 fw500 gray"><?=date( "Y.m.d H:i", strtotime($review_row['hero_today']));?></span>
				</div>
					<div class="button_area">
						<?if($level){?>
							<input type='button' value="답글" onclick="reply_area(<?=$view['hero_idx']?>,'review_write',<?=$review_row['hero_idx']?>,<?=$review_row['hero_depth_idx_old']?>,this);" class="btn-secondary today_btn btngrp"/>
						<?}?>
					</div>
			<?}else{?>
					<div class="nickname" style="width:100%;text-align:center">삭제된 글 입니다.</div>
			<?}?>

				<div class="reply_area_top">
				</div>

			<div class="clear"></div>
		</div>
		<?

				$class='';
				$temp_check_count_i ++;
				$review_i --;
				// $p_i ++;

			}
			}
		?>	
		<div class="btn_wrap view_list">
			<div class="left">
				<a href="<?=DOMAIN_END."m/today.php?".get("hero_idx")?>" class="btn_list">목록으로</a>
			</div>		
			<? if($board_prev_rs["hero_idx"]) {?>
			<ul id="list_previous">
				<li>
					<a href="<?=PATH_END;?>today_view.php?<?=get("hero_idx","hero_idx=".$board_prev_rs['hero_idx'])?>">					
					<p class="tit fz24 fw500">이전글</p>
					<p class="fz28 fw500"><?=cut($board_prev_rs['hero_title'],23);?></p>
					</a>
				</li>
			</dl>			
			<? } ?>
			<ul id="curent_page">
				<li class="curent">
					<a href="<?=PATH_END;?>board_view_01.php?<?=get("hero_idx","hero_idx=".$board_list['hero_idx'])?>">
						<p class="tit fz24 fw500 main_c">현재글</p>
						<p class="fz28 fw500"><?=cut($view['hero_title'],26);?></p>
					</a>
				</li>
			</ul>
			<? if($board_next_rs["hero_idx"]) {?>
			<ul id="list_next">
				<li class="next">
					<a href="<?=PATH_END;?>today_view.php?<?=get("hero_idx","hero_idx=".$board_next_rs['hero_idx'])?>">
						<p class="tit tit fz24 fw500">다음글</p>
						<p class="fz28 fw500"><?=cut($board_next_rs['hero_title'],26);?></p>
					</a>
				</li>
			</ul>
			<? } ?>	
			<? if($view['hero_code'] == $_SESSION['temp_code']){?>
				<div class="right">
					<a href="javascript:;" onClick="fnEdit()">수정</a>
					<a href="/m/action.php?board=<?=$_GET['board']?>&action=delete&idx=<?=$_GET['hero_idx']?>">삭제</a>
				</div>
			<? } ?>
		</div>
</div>
<script>
function fnEdit(){
	$("#searchForm").attr("action","write.php").submit();	
}

function reply_area(board_idx,mode,depth_idx,depth_idx_old,obj){

	cancle_reply();

	var reply_area_top = $(obj).parents('.replybx').find('.reply_area_top');
	var command = '';
	if(mode=="review_edit"){
		command = trim($(obj).parents('.replybx').find('.command').html());
        if(command.indexOf('//대댓글 입력시 원댓글 작성자의 닉네임 노출 영역') == 148){
            // 대댓글일때 닉네임 생략
            command = command.substring(276);
        }else {
            command = command.substring(64);
        }
	}

	var reply_view ='';
		
	reply_view += "<div class='reply_bx'>";
	reply_view += "<ul class='rel'>";
	reply_view += "<li>";
	reply_view += "<form id='review_form_02'>";
	reply_view += "<input type='hidden' name='mode' value='"+mode+"'>";
	reply_view += "<input type='hidden' name='board' value='<?=$_GET['board']?>'>";
	reply_view += "<input type='hidden' name='board_idx' value='"+board_idx+"'>";
	reply_view += "<input type='hidden' name='depth_idx' value='"+depth_idx+"'>";
	reply_view += "<input type='hidden' name='depth_idx_old' value='"+depth_idx_old+"'>";
	reply_view += "<textarea id='hero_command_02' class='reply_txt_box' <?if($my_rev != "9999") {?>onpaste='return false;'<?}?> class='reply_box'>"+command+"</textarea>";
	reply_view += "</form>";
	reply_view += "</li>";
	reply_view += "<li style='text-align:right;'>";
	reply_view += "<input type='button' class='btn-warning today_btn btn_reply' class='btn-warning today_btn' onclick='hero_review_submit(\"review_form_02\", \"hero_command_02\",\"pc\")' alt='댓글 입력'>";
	//reply_view += "<input type='button' value='취소' class='btn-danger today_btn' style='height:70px;' onclick='cancle_reply();' alt='취소'>";
	reply_view += "</li>";
	reply_view += "</ul>";
	reply_view += "<div class='clear'></div>";
	reply_view += "</div>";

	reply_area_top.html(reply_view);
	reply_area_top.show();
}

function cancle_reply(){
	$('.reply_area_top').hide();
	$('.reply_area_top').html('');
}

function check_review_del(idx){
	if(confirm("삭제하시겠습니까?")==true)	hero_review_del(idx,"pc");		
	else								return false;
}

//170715 임시링크
function temp_link(n) {
	console.log(n);
	var url = "";
	if(n == "1") {
		url = "/m/aklover.php?board=group_04_01";
	} else if(n == "2") {
		url = "/m/aklover.php?board=group_04_12";
	} else if(n == "3"){
		url = "/m/aklover.php?board=group_04_02";
	}
	
	window.open(url,'','');
}

$(document).ready(function(){
			const editbtn = $('.editbox');
			$.each(editbtn, function(){
				$(this).click(function(){
					$(this).find('.editinner').toggleClass('on');
				});
			});
		});

//pc URL 모바일 주소 가져오기
$(document).on('click', '.contBox a', function(){
	event.preventDefault();
	var url = $(this).attr("href");
	var target = $(this).attr("target");
	var host = "<?=$_SERVER["HTTP_HOST"];?>";
	var http = "<?=$_SERVER["HTTPS"];?>";
	var domain  = "";
	var board = param("board",url);
	var view = param("view",url);
	var idx = param("idx",url);

	if(http == "on") {
		domain = "https://"+host+"/";
	} else {
		domain = "http://"+host+"/";
	}

	if(url.indexOf("http:") > -1 || url.indexOf("https:") > -1) {
		if(url.indexOf("http://www.aklover.co.kr") < 0 && url.indexOf("https://www.aklover.co.kr") < 0 
				&& url.indexOf("http://aklover.co.kr") < 0 
				&& url.indexOf("https://aklover.co.kr") < 0) {

			if(target) {
				if(target.toLowerCase() == "_blank") {
					window.open(url,'','');
				} else {
					location.href = url;
				}
			} else {
				location.href = url;
			}

			return;
		}
	}
	
	var link = "";
	if(board == "group_04_03" || board == "group_02_02" || board == "group_03_03" || board == "group_04_24" || board == "group_04_26") { //나누다(공지사항, 수다통, 정보통, 배움통)
		if(idx) {
				link = "m/today.php?board="+board+"&idx="+idx+"#tabbtn_"+idx;	
		} else {
			link = "m/today.php?board="+board;
		}
	} else if(board == "group_04_04") { //나누다(출석체크)
		link = "m/check.php?board="+board;
	} else if(board == "group_04_05" || board == "group_04_06" || board == "group_04_25" || board == "group_04_23" || board == "group_04_08" || board == "group_04_27" || board == "group_04_28") { //두드리다(체험단, 뷰티스타, 뷰티홀릭, 휘슬클럽, 기자단)
		if(idx) {
				link = "m/mission_view.php?board="+board+"&mission_idx="+idx;
		} else {
			link = "m/mission.php?board="+board;
		}
	} else if(board == "group_04_07") { //두드리다(애경박스)
		if(idx) {
				link = "m/mission_view_02.php?board="+board+"&mission_idx="+idx;
		} else {
			link = "m/mission.php?board="+board;
		}
	} else if(board == "group_02_03") { //두드리다(게릴라 이벤트)
		if(idx) {
				link = "m/board_view_01.php?board="+board+"&hero_idx="+idx;
		} else {
			link = "m/board_00.php?board="+board;
		}
	} else if(board == "group_04_21") { //두드리다(포인트 축제) 일단 리스트 페이지만
		link = "m/order.php?board="+board;
	} else if(board == "group_04_09") { //물들다(체험후기)
		if(idx) {
				link = "m/board_view_01.php?board="+board+"&hero_idx="+idx;
		} else {
			link = "m/board_01.php?board="+board;
		}
	} else if(board == "group_04_10") { //물들다(우수후기) 리스트만 존재
		link = "m/board_02.php?board="+board;
	} else if(board == "group_04_22") { //물들다(모임후기)
		if(idx) {
				link = "m/meeting_view.php?board="+board+"&idx="+idx;
		} else {
			link = "m/meeting.php?board="+board;
		}
	} else if(board == "group_04_01" || board == "group_04_12" || board == "group_04_02" || board == "group_03_01") { //만나다(aklover란, 체험단 참여방법, 포인트/등급, 애경소개)
		link = "m/aklover.php?board="+board;
	} else if(board == "group_04_13") { //만나다(진정성)
		link = "m/truly.php?board="+board;
	} else if(board == "cus_3") { //만나다(고객센터)
		link = "m/customer.php?board="+board;
	} else {
		link = url;
	}

	var editUrl = domain+link;
	
	if(target) {
		if(target.toLowerCase() == "_blank") {
			window.open(editUrl,'','');
		} else {
			location.href = editUrl;
		}
	} else {
		location.href = editUrl;
	}
});

param = function(name,url) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(url);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
</script>
<div class="img-loading"></div>
<!--컨텐츠 종료-->
<? include_once "btnTop.php";?>
<? include_once "tail.php";?>