<?php
######################################################################################################################################################
include_once "head.php";
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

function auto_link_text($text) {
    $pattern = '#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#';
    $callback = create_function('$matches',
        '$url = array_shift($matches); return "<a href=\'$url\' style=\'color:black;\'>$url</a>";' );
    return preg_replace_callback($pattern, $callback, $text);
}

$error = "TODAY_01";
$board = $_GET['board'];

//일반미션, 프리미엄미션, 애경박스 생생후기
if($board=="group_04_05" || $board=="group_04_06" || $board=="group_04_07" || $board=="group_04_23" || $board=="group_04_27" || $board=="group_04_28"){
	$board = "group_04_09";
}
$group_sql = " SELECT * FROM hero_group WHERE hero_order!='0' AND hero_use='1' AND hero_board ='".$board."'"; // desc

$out_group = new_sql($group_sql,$error,"on");
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}
$right_list = mysql_fetch_assoc ( $out_group );

if($right_list["hero_view"]>$_SESSION['temp_level'] && $right_list["hero_view"]!=0){
	error_historyBack("페이지 권한이 없습니다.");
	exit;
}

######################################################################################################################################################
$today = date( "Y-m-d", time());

$idx = $_GET['hero_idx'];


$level = $_SESSION['temp_level'];
$code = $_SESSION['temp_code'];

$my_write = $_SESSION ['temp_write'];
$my_view = $_SESSION ['temp_view'];
$my_update = $_SESSION ['temp_update'];
$my_rev = $_SESSION ['temp_rev'];

######################################################################################################################################################
$error = "TODAY_01";
$board_sql  = " SELECT A.*,B.hero_nick, B.hero_idx as member_idx, C.hero_img_new FROM ";
$board_sql .= "(select * from board where hero_idx='".$idx."') as A left outer join member as B on A.hero_code=B.hero_code ";
$board_sql .= "left outer join level as C on B.hero_level=C.hero_level ";
$board_sql .= "where A.hero_idx='".$idx."' ";

$out_sql = new_sql( $board_sql, $error);

if((string)$out_sql==$error){
	error_historyBack("");
	exit;
}

######################################################################################################################################################
$board_list = mysql_fetch_assoc( $out_sql);

if($_SESSION['temp_level'] < 9999 && $board_list["hero_use"] == "0") {
	msg('비공개 게시글 입니다.','location.href="/m/board_00.php?board=group_02_03"');
	exit;
}

######################################################################################################################################################
if(date("Y-m-d")==substr($board_list['hero_today'],0,10))    	$new_img_view = "<img src='".DOMAIN_END."image/main_new_bt.png'  width='14' alt='new' /> ";
else													    	$new_img_view = "";
$sns_title = $board_list['hero_title'];
$link = DOMAIN.URI_PATH.'?'.get();
$sns_image= DOMAIN_END.'image/logo2.gif';

$mission_url_sql = " SELECT gubun, url FROM mission_url WHERE board_hero_idx = '".$_GET['hero_idx']."' ORDER BY field(gubun, 'naver', 'insta', 'movie', 'cafe', 'etc') ASC, hero_idx ASC ";
$mission_res = sql($mission_url_sql);
?>
<script src="/js/musign/sns_share.js"></script>
<link href="/m/css/musign/board.css" rel="stylesheet" type="text/css">
<script src="https://t1.kakaocdn.net/kakao_js_sdk/2.7.2/kakao.min.js" integrity="sha384-TiCUE00h649CAMonG018J2ujOgDKW/kVWlChEuu4jK2vxfAAD0eZxzCKakxg55G4" crossorigin="anonymous"></script>
<script>
	// 카카오 aklover JavaScript 키
	Kakao.init('86b5b004678408418bea38987129ee5a');
</script>

<!--컨텐츠 시작-->

<div id="subpage">
	<div class="sub_wrap">
		<div class="sub_title">
			<div class="f_b">
				<h1 class="fz74 main_c fw500 ko">이달의 이벤트</h1>
			</div>
			<p class="fz28 fw600">누구나 참여 가능한 이벤트에 참여해보세요!</p>
        </div>
		<!-- 2018-12-14 체험단 후기 삭제 때문에 생성 -->
		<form name="form0" id="form0" method="POST">
			<input type="hidden" name="hero_table" value="<?=$_GET["board"]?>" />
		</form>
		<div class="view_cont">
			<div class="title rel">
				<!-- 제목 -->
				<span class="fz44 fw700 ellipsis_2line"><?=cut($board_list['hero_title'],48);?></span>
				<!-- sns 공유 -->
				<div class="snsbox abs">
					<div class="rel">
						<div class="btn_share dim_on"><img src="/m/img/musign/board/share.webp" alt="aklover-share"></div>
					</div>
				</div>
				<div class="share_inner">
					<div class="rel">
						<div class="btn_close abs dim_off"><img src="/m/img/musign/board/share_close.webp" alt="aklover-close"></div>
						<p class="title fz34 fw700">공유하기</p>
						<ul>
							<li>
								<a id="kakaotalk-sharing-btn-event" href="javascript:;">
									<img src="/m/img/musign/board/share_kakao.webp" alt="카카오톡 공유하기">
								</a>
								<p class="fz24 t_c">카카오톡</p>
							</li>
							<li id="copyLinkBtn">
								<img src="/m/img/musign/board/share_link.webp" alt="링크복사">
								<p class="fz24 t_c">링크복사</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="writer">
				<span class="nickname dis-no"><img src="<?=str($board_list['hero_img_new'])?>"/><a href="javascript:;" onClick="fnProfile('<?=encrypt($board_list['member_idx']);?>')"><?=$board_list['hero_nick'];?></a></span>
				<span class="gray fz24 fw500"><?=date( "Y.m.d", strtotime($board_list['hero_today']));?></span>
			</div>
			<?
			$next_command = htmlspecialchars_decode($board_list['hero_command']);
			$next_command = str_ireplace("<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n","",$next_command);
			$next_command = str_ireplace("<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n","",$next_command);
			$next_command = str_ireplace('<img', '<img onerror="this.src=\''.IMAGE_END.'hero.jpg\';" ', $next_command);
			$next_command = preg_replace("/ width=(\"|\')?\d+(\"|\')?/"," width='100%'",$next_command);
			$next_command = preg_replace("/ height=(\"|\')?\d+(\"|\')?/","",$next_command);
			$next_command = preg_replace("/width: \d+px/","width:100%;",$next_command);
			$next_command = preg_replace("/height: \d+px;/","",$next_command);
			$next_command = preg_replace("/height: \d+px/","",$next_command);
			$next_command = preg_replace("/margin-left: \d+pt/","",$next_command);

			if($board_list['hero_04']) {
				$blog_urls = remove_kr($board_list['hero_04']);
			}else {
				$blog_urls = remove_kr($board_list['youtube_url']).remove_kr($board_list['blog_url']).remove_kr($board_list['cafe_url']).remove_kr($board_list['sns_url']).remove_kr($board_list['etc_url']);
			}

			$blog_urls = str_ireplace("http:","http:",$blog_urls);
			$blog_urls = str_ireplace("https:","https:",$blog_urls);

			$blog_urls = check_blog($blog_urls);

			$unblocked_site_name = array("navercafe", "naverblog", "daumcafe", "daumblog", "tistory");
			$blocked_site_name = array("facebook", "twitter", "instagram");

			?>
			<?php if($_GET['board']=='group_04_09' || $_GET['board']=='group_04_05' || $_GET['board']=='group_04_06' || $_GET['board']=='group_04_07' || $_GET['board']=='group_04_23' || $_GET['board']=='group_04_27' || $_GET['board']=='group_04_28'){?>
				<div class="board_view_01">
					<img src="<?=$board_list['hero_thumb']?>" alt=""><br/>

					<dl class="snsURLShareWrap">
						<?
						$gubun_arr = array("naver"=>"네이버 블로그","insta"=>"인스타그램","movie"=>"영상(후기)","cafe"=>"까페","etc"=>"기타");
						while($list = mysql_fetch_assoc($mission_res)) {?>
						<dt><?=$gubun_arr[$list["gubun"]]?></dt>
						<dd><a href="<?=$list["url"]?>" target="_blank" class="btnLink">바로가기</a></dd>
						<? } ?>
					</dl>
				</div>
			<?php
			}else{
			?>
				<div class="hero_command cont"><?=$next_command;?></div><!--id="list_content"-->
			<?php
			}

				if($_GET['board'] != 'group_02_03' && $_GET['board'] != 'group_04_03') {
			?>
				<div class='btn_recommand_report'>

				</div>
			<? } ?>

			<!-- 첨부파일 -->
			<?if(strcmp($board_list['hero_board_two'], '')){
				if($idx == '136705'){  // 160315 수정함 특정 게시물 파일 로그인 회원만 다운로드 되게 하려고
					if(strcmp($_SESSION['temp_code'], '')){ ?>
					<div class="file f_cs">
						<span class="fz26 fw600">첨부파일</span>
						<a href="http://aklover.co.kr/user/file/16day.zip" class="label_button fz22 fw500">16day.zip</a>
					</div>
					<?}
				}else{
				?>
				<div class="f_cs file">
					<span class="fz26 fw600">첨부파일</span>
					<a href="http://aklover.co.kr/freebest/download.php?hero=<?=$board_list['hero_board_one']?>&download=<?=$board_list['hero_board_two']?>" class="label_button fz22 fw500"><?=$board_list['hero_board_two'];?></a>
				</div>
				<?
				}// end else
			}?>
		</div>

		

		<?
		## review
		########################################################################################################################################################################
		if($_GET["board"] != "group_04_09" && $board_list['hero_review_use'] == 1) {
		?>

		<?
		$review_sql  = " select * from (select A.hero_code, A.hero_depth, A.hero_idx, A.hero_use, A.hero_today, A.hero_command,A.hero_depth_idx_old ";
		$review_sql .= " ,(select case when ifnull(hero_topfix,'N') != 'Y' then 'N' else 'Y' end hero_topfix FROM review where hero_idx = A.hero_depth_idx_old) as hero_topfix";
		$review_sql .= " ,B.hero_level,B.hero_nick,C.hero_img_new from review as A ";
		$review_sql .= " left outer join member as B on A.hero_code=B.hero_code ";
		$review_sql .= " left outer join level as C on B.hero_level=C.hero_level ";
		$review_sql .= " where hero_old_idx='".$board_list['hero_idx']."' ) A  ";
		$review_sql .= " order by hero_topfix desc ";
		$review_sql .= " ,case when hero_topfix = 'Y' then hero_depth_idx_old end desc ";
		$review_sql .= " ,case when hero_topfix != 'Y' then hero_depth_idx_old end asc ";
        $review_sql .= " ,hero_today asc ";
		$review_sql .= " ,hero_depth asc,hero_today asc ";

		//echo $review_sql;


		$review_res = new_sql($review_sql, $error);
		if ((string)$review_res==$error){
			echo 0;
			exit;
		}

		$review_data = mysql_num_rows ( $review_res );
		$review_i = $review_data - 1;
		$p_i = "0";
		
		?>

		<div id="reply">
			<div class="comment_cnt">
				<p class="fz28 fw700">댓글 <span class="main_c"><?=$review_data?></span></p>
			</div>
			<ul style="width:100%">
				<?
				if($my_rev>='9999' or $right_list['hero_rev']<=$my_rev){
				?>
					<form id="review_form">
						<input type="hidden" name="mode" value="review_write">
						<input type="hidden" name="board" value="<?=$_GET['board']?>">
						<input type="hidden" name="board_idx" value="<?=$board_list['hero_idx']?>">
						<? if($my_rev == "9999") {?>
						<!-- <p><lebal for='hero_topFix'>상단 고정</label> <input type='checkbox' name='hero_topFix' id='hero_topFix' checked value='Y' /></p> -->
						<? } ?>
					</form>
					<div class="reply_bx">
						<div class="rel">
							<textarea id="hero_command" name="hero_command" <?if($my_rev != "9999") {?>onpaste="return false" <?}?> cols="" rows="" class="reply_txt_box" placeholder="댓글을 작성해주세요."></textarea>
							<input type="button" class='btn-warning today_btn btn_reply' onClick="hero_review_submit('review_form', 'hero_command', 'pc');" alt="댓글입력">
						</div>
					</div>
                 <? }else{ ?>   <!-- 비로그인 -->
					<div class="reply_bx">
						<div class="rel non_reply">
							<div class="non_reply_txt reply_txt_box fz26">댓글을 작성하시려면 <span class="main_c">로그인</span> 해주세요.</div>
							<div class='btn_reply'></div>
						</div>
					</div>
				<?
				}
				?>
			</ul>
			<div class="clear"></div>
		</div>

		<?
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
											<input type='button' class="fz24 fw500" value="수정"  onclick="reply_area(<?=$board_list['hero_idx']?>,'review_edit',<?=$review_row['hero_idx']?>,<?=$review_row['hero_depth_idx_old']?>,this);" />
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
							<!-- 대댓글 입력시 원댓글 작성자의 닉네임 노출 영역  -->
                            <?if($parentName != ''){?>
                                <!-- 대댓글 입력시 원댓글 작성자의 닉네임 노출 영역  -->
                                <b class="bold" style="color: #FF4C05"><?='@'.$parentName?></b>
                                <!-- //대댓글 입력시 원댓글 작성자의 닉네임 노출 영역  -->
                            <?}?>
							<b class="bold"></b> <?=auto_link_text(htmlspecialchars($review_row['hero_command'],ENT_COMPAT,"ISO-8859-1"))?>
						</div>
						<span class="ft_date fz24 fw500 gray"><?=date( "Y.m.d H:i", strtotime($review_row['hero_today']));?></span>
					</div>
						<div class="button_area">
							<?if($level){?>
								<input type='button' value="답글" onclick="reply_area(<?=$board_list['hero_idx']?>,'review_write',<?=$review_row['hero_idx']?>,<?=$review_row['hero_depth_idx_old']?>,this);" class="btn-secondary today_btn btngrp"/>
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
				$p_i ++;

			}

			}
			?>

		<div class="btn_wrap view_list">
			<? if($_GET['board'] == "group_02_03") {?>
				<a href="<?=DOMAIN_END."m/board_00.php?".get("hero_idx")?>" class="btn_list">목록으로</a>
			<? } else { ?>
				<a href="<?=DOMAIN_END."m/board_01.php?".get("hero_idx")?>" class="btn_list">목록으로</a>
			<? } ?>
			<?php
				//수정 : 체험단 등록 후 미션에 속한 후기글만 노출
				$mission_where = "";
				if($_GET['board'] != "group_04_09") {
					if($_GET['board'] == "group_02_03") {
						$mission_where_prev = " hero_table = '".$_GET['board']."' and hero_idx > ".$_GET['hero_idx'];
						$mission_where_next = " hero_table = '".$_GET['board']."' and hero_idx < ".$_GET['hero_idx'];
					} else {
						$mission_where_prev = " hero_table = '".$_GET['board']."' AND hero_01 = '".$_GET["idx"]."' and hero_idx > ".$_GET['hero_idx'];
						$mission_where_next = " hero_table = '".$_GET['board']."' AND hero_01 = '".$_GET["idx"]."' and hero_idx < ".$_GET['hero_idx'];
					}
				} else {
					$mission_where_prev = " hero_table in ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08', 'group_04_09', 'group_04_27', 'group_04_28') and hero_idx > ".$_GET['hero_idx'];
					$mission_where_next = " hero_table in ('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08', 'group_04_09', 'group_04_27', 'group_04_28') and hero_idx < ".$_GET['hero_idx'];
				}


				$sql = 'select * from board where '.$mission_where_prev.'  order by hero_idx asc limit 0,1;';
				$out_sql = @mysql_query($sql);
				$Prev = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
				$Prev['hero_idx'];

				$sql = 'select * from board where '.$mission_where_next.' order by hero_idx desc limit 0,1;';
				$out_sql = @mysql_query($sql);
				$Next = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
				$Next['hero_idx'];

				if(strcmp($Prev['hero_idx'], '')){
				?>
				<ul id="list_previous">
					<li>
						<a href="<?=PATH_END;?>board_view_01.php?<?=get("hero_idx","hero_idx=".$Prev['hero_idx'])?>">
							<p class="tit fz24 fw500">이전글</p>
							<p class="fz28 fw500"><?=cut($Prev['hero_title'],16);?></p>
						</a>
					</li>
				</ul>
				<?
				}?>
				<ul id="curent_page">
					<li class="curent">
						<a href="<?=PATH_END;?>board_view_01.php?<?=get("hero_idx","hero_idx=".$board_list['hero_idx'])?>">
							<p class="tit fz24 fw500 main_c">현재글</p>
							<p class="fz28 fw500 ellipsis_500"><?=cut($board_list['hero_title'],48);?></p>
						</a>
					</li>
				</ul>
				<?if(strcmp($Next['hero_idx'], '')){
				?>
				<ul id="list_next">
					<li class="next">
						<a href="<?=PATH_END;?>board_view_01.php?<?=get("hero_idx","hero_idx=".$Next['hero_idx'])?>">
							<p class="tit tit fz24 fw500">다음글</p>
							<p class="fz28 fw500"><?=cut($Next['hero_title'],16);?></p>
						</a>
					</li>
				</ul>
				<?
				}
				?>
		</div>

		<div id="list_btn" style="width:90%; margin:auto; margin-top:20px; margin-bottom:20px">
			<ul style="width:100%">
				<li style="width:60%; float:right; text-align:right">
				<? if(($_SESSION['temp_level']>='9999') or (!strcmp($board_list['hero_code'],$_SESSION['temp_code']))){ ?>

					<? if($_GET['board'] == "group_04_05" || $_GET['board'] == "group_04_06" || $_GET['board'] == "group_04_07" || $_GET['board'] == "group_04_09" || $_GET['board'] == "group_04_10" || $_GET['board'] == "group_04_23" || $_GET['board'] == "group_04_27" || $_GET['board'] == "group_04_28") {?>
						<a href="/m/mission_write.php?board=<?=$_GET['board']?>&hero_idx=<?=$_GET['hero_idx']?>&idx=<?=$_GET["idx"]?>&action=update">
							<img src="img/review/modify_btn.jpg" alt="수정" width="70px"/>
						</a>
						<a href="javascript:;" onClick="delPostscript()">
							<img src="img/review/delete_btn.jpg" alt="삭제" width="70px"/>
						</a>
					<? } else {?>
						<a href="/m/write.php?board=<?=$_GET['board']?>&idx=<?=$_GET['hero_idx']?>&page=<?=$_GET['page']?>">
							<img src="img/review/modify_btn.jpg" alt="수정" width="70px"/>
						</a>
						<a href="/m/action.php?board=<?=$_GET['board']?>&action=delete&idx=<?=$_GET['hero_idx']?>">
							<img src="img/review/delete_btn.jpg" alt="삭제" width="70px"/>
						</a>
					<? } ?>
				&nbsp;
				<?}?>
				</li>
			</ul>
		</div>

		<script>
		function delPostscript() {
			var f = document.form0;
			f.action = "/m/mission_write_proc.php?board=<?=$_GET['board']?>&action=delete&idx=<?=$_GET["idx"];?>&hero_idx=<?=$_GET['hero_idx']?>";
			f.submit();
		}
		function reply_area(board_idx,mode,depth_idx,depth_idx_old,obj){

			cancle_reply();

			var reply_area_top = $(obj).parents('.replybx').find('.reply_area_top');
			var command = '';
			if(mode=="review_edit"){
				command = trim($(obj).parents('.replybx').find('.command').html());
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
			reply_view += "<input type='button' class='btn-warning today_btn btn_reply' onclick='hero_review_submit(\"review_form_02\", \"hero_command_02\",\"pc\")' alt='댓글 입력'>";
			// reply_view += "<input type='button' value='취소' class='btn-danger today_btn' style='height:70px;' onclick='cancle_reply();' alt='취소'>";
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

		function open0(link){
			var link1 = encodeURIComponent(link);
			window.open('http://www.facebook.com/sharer/sharer.php?u='+link1,'','width=520 height=400 scrollbars=yes');
		}
		function open1(sub, link){
			var sub1 = encodeURIComponent(sub);
			var link1 = encodeURIComponent(link);
			window.open('http://twitter.com/home?status='+sub1+' '+link1,'','width=520 height=200 scrollbars=yes');
		}
		function open2(sub, link){
			var sub1 = encodeURIComponent(sub);
			var link1 = encodeURIComponent(link);
			window.open('http://plugin.me2day.net/v1/me2post/create_post_form.nhn?body='+sub1+' '+link1,'','width=520 height=400 scrollbars=yes');
		}

		$(document).ready(function(){
			const editbtn = $('.editbox');
			$.each(editbtn, function(){
				$(this).click(function(){
					$(this).find('.editinner').toggleClass('on');
				});
			});
		});

		</script>
	</div>
</div>

<!--컨텐츠 종료-->
<?
include_once "tail.php";
?>

<script>
	const currentUrl = window.location.href;

	// 게시글 내부에서 첫번째 이미지 가져오기
	const pTag = document.querySelector(".cont").childNodes;
	let imageUrl = "";

	for(let i = 0; i < pTag.length; i++) {
		const childNodes = pTag[i].childNodes;
		for(let s = 0; s < childNodes.length; s++) {
			if (childNodes[s].tagName === 'IMG') {
				imageUrl = childNodes[s].src;
				break;
			}
		}
		if (imageUrl) break;
	}

	Kakao.Share.createDefaultButton({
        container: '#kakaotalk-sharing-btn-event',
        objectType: 'feed',
        content: {
            title: '<?=cut($board_list['hero_title'],48);?>',
            description: 'AK Lover 이벤트에 참여해 보세요!',
            imageUrl: imageUrl,
            link: {
                mobileWebUrl: currentUrl,
                webUrl: currentUrl,
            },
        },
        buttons: [
        {
            title: '웹으로 보기',
            link: {
                mobileWebUrl: currentUrl,
                webUrl: currentUrl,
            },
        },
        ],
    }); 
</script>