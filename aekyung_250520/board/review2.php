<?
// ####################################################################################################################################################
// HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
// ####################################################################################################################################################
if (! defined ( '_HEROBOARD_' ))	exit ();
	// ####################################################################################################################################################
if (! strcmp ( $_SESSION ['temp_level'], '' )) {
	$my_level = '0';
	$my_write = '0';
	$my_view = '0';
	$my_update = '0';
	$my_rev = '0';
} else {
	$my_level = $_SESSION ['temp_level'];
	$my_write = $_SESSION ['temp_write'];
	$my_view = $_SESSION ['temp_view'];
	$my_update = $_SESSION ['temp_update'];
	$my_rev = $_SESSION ['temp_rev'];
}

if($_GET["idx"] == "361962") { //2021-12-14 임시로 댓글 막음
	exit;
}

function auto_link_text($text) {
    $pattern = '#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#';
    $callback = create_function('$matches',
        '$url = array_shift($matches); return "<a href=\'$url\'>$url</a>";' );
    return preg_replace_callback($pattern, $callback, $text);
}

// ####################################################################################################################################################
$sql =  ' SELECT * FROM  (SELECT hero_code, hero_depth, hero_idx, hero_use, hero_today, hero_command,hero_depth_idx_old ';
$sql .= ' ,(select case when ifnull(hero_topfix,\'N\') != \'Y\' then \'N\' else \'Y\' end hero_topfix from review where hero_idx = r.hero_depth_idx_old) as hero_topfix ';
$sql .= ' from review r where r.hero_old_idx=\''.$_GET["idx"].'\' ) r ';
$sql .= ' order by hero_topfix desc ,case when hero_topfix = \'Y\' then hero_depth_idx_old end desc ,case when hero_topfix != \'Y\' then hero_depth_idx_old end asc ';
//musign S 묻지도 따지지도 않고 뎁스 기준이 아닌 들어온 날짜 순서대로 순차 적용
//$sql .= ' ,hero_depth asc,hero_today asc '; // hero_depth_idx_old desc,hero_depth asc
//musign E
$sql .= ' ,hero_today asc '; // hero_depth_idx_old desc,hero_depth asc

// Echo $sql . '</br>';
sql ( $sql, 'on' );
$review_data = @mysql_num_rows ( $out_sql );
?>

<div id="abcd"></div>
<div class="comment_cnt">
	<p class="fz20 fw700">댓글 <span class="main_c"><?=$review_data?></span></p>
</div>
<div class="commentbox">
	<?
	$check_review_sql = "select * from hero_group where hero_board='" . $_GET ['board'] . "'";
	$out_check_review_sql = mysql_query ( $check_review_sql );
	$check_review_list = @mysql_fetch_assoc ( $out_check_review_sql );
	$check_review_list ['hero_rev'];

	// 2014-03-26 비회원 로그인시 댓글 작성 불가
	if ($my_view != "0" && $check_review_list['hero_rev']<=$my_rev) { ?>

		<form id="review_form">
		   	<input type="hidden" name="mode" value="review_write">
		   	<input type="hidden" name="board" value="<?=$_GET['board']?>">
		   	<input type="hidden" name="board_idx" value="<?=$_GET['idx']?>">
		   	<?
		   	if($my_rev == "9999") {?>
		   	<p style="margin:0 0 8px 0; text-align:right;" class="dis-no"><label for="hero_topFix">상단 고정</label><input type="checkbox" id="hero_topFix" name="hero_topFix" checked value="Y" /></p>
		   	<? } ?>
		</form>
		<div class="comment_wrap rel textarea_wrap">
			<textarea id="hero_command" name="hero_command" <?if($my_rev != "9999") {?>oncontextmenu="return false" <?}?> class="ment_txt scroll_hide" title="덧글내용"></textarea>
			<button onclick="hero_review_submit('review_form', 'hero_command','pc')" class="btn_ment label_button fz15 fw600">댓글 달기</button>
		</div>


	<?
	} else { ?>

		<div class="comment_wrap rel textarea_wrap non_log">
			<div class="ment_txt scroll_hide" title="덧글내용">댓글을 작성하시려면 <a href="/main/index.php?board=login"><span class="main_c">로그인</span></a> 해주세요.</div>
			<div class="btn_ment label_button fz15 fw600">댓글 달기</div>
		</div>

	<? }



	$review_i = $review_data - 1;
	$p_i = "0";

	while ( $review_row = @mysql_fetch_assoc ( $out_sql ) ) {

		if (! strcmp ( $review_i, '0' )) 	$last_class = 'last';
		else 								$last_class = '';

		$pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \'' . $review_row ['hero_code'] . '\'';
//		echo $pk_sql;
		$out_pk_sql = mysql_query ( $pk_sql );
		$pk_row = @mysql_fetch_assoc ( $out_pk_sql );

		if (! strcmp ( $review_row ['hero_depth'], '0' )) {
			$temp_check_count_i = 0;
			$check_sql = 'select * from review where hero_depth_idx_old= \'' . $review_row ['hero_idx'] . '\'';
//            echo $check_sql;
			$out_check_sql = mysql_query ( $check_sql );
			$check_count = @mysql_num_rows ( $out_check_sql );
		}

		$temp_check_count = $check_count - $temp_check_count_i;



		if(strcmp ( $review_row ['hero_depth'], '0' ))														        $class = "rpment ";

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


	    <div class="<?=$class.$last_class?> clearfix replybx ">
			<div class="txt_id fz16 fw700 rel">
				<?=$pk_row['hero_nick']?>
					<?
					if ($my_rev >= '9999' || ! strcmp ( $review_row ['hero_code'], $_SESSION ['temp_code'] )) {
                    ?>
					<div class="editbox">
						<div class="rel editinner">
							<ul>
								<li onclick="javascript:check_review_edit(<?=$p_i?>);">수정</li>
								<li>
									<a herf="javascript:;" onClick="check_review_del('<?=$review_row['hero_idx']?>')">삭제</a>
								</li>
							</ul>
						</div>
					</div>
						<?
					}
					?>
			</div>
			<div>
				<ul>
					<?
						if (strcmp ( $review_row ['hero_use'], '1' )) {
					?>
						<li class="review_command fz16"
							<?php
							//170405 크롬 영역벗어남 수정
							if(strlen(nl2br($review_row['hero_command'])) != strlen($review_row['hero_command'])){
								echo " style='word-break: break-all; white-space:pre-line; ' ";
							}
							// 160601 white-space:pre 지우면 크롬에서 영역 벗어나는 걸 방지하지만, 인위적인 개행처리가 안됨
							/*if(strlen(nl2br($review_row['hero_command'])) != strlen($review_row['hero_command'])){
								echo " style='word-wrap: break-word; word-break: break-all; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap;' ";
							}else{
							}*/
							?>
                            >
                            <?if($parentName != ''){?>
                                <!-- 대댓글 입력시 원댓글 작성자의 닉네임 노출 영역  -->
                                <b class="bold" style="color: #FF4C05"><?='@'.$parentName?></b>
                                <!-- //대댓글 입력시 원댓글 작성자의 닉네임 노출 영역  -->
                            <?}?>
                            <?=auto_link_text(htmlspecialchars_decode(htmlspecialchars($review_row['hero_command'],ENT_COMPAT,"ISO-8859-1")))?>
						</li>
					<?}else{?>
						삭제된 글 입니다.
					<?}?>
	                <li class="gray">
						<span class="txt_date fz14 fw500 gray"><?=date( "Y.m.d H:i", strtotime($review_row['hero_today']))//.$review_row['hero_depth'];?></span>
						<?
						if ($_SESSION ['temp_view'] != "0" && $check_review_list['hero_rev']<=$my_rev) {
							?>
							<div onclick="javascript:check_review_all(<?=$p_i?>);" class="btngrp">답글</div>
							<?
						}
						?>
					</li>
					<li class="rel">
						<div class="review_area" style="display: none;">
							<form id="review_form_<?=$p_i?>">
								<input type="hidden" class="review_mode" name="mode" value="review_write">
								<input type="hidden" name="board" value="<?=$_GET['board']?>">
								<input type="hidden" name="board_idx" value="<?=$_GET['idx']?>">
								<input type="hidden" name="depth_idx" value="<?=$review_row['hero_idx']?>">
								<input type="hidden" name="depth_idx_old" value="<?=$review_row['hero_depth_idx_old']?>">
								<div class="textarea_wrap rel">
									<textarea id="hero_command_<?=$p_i?>" name="hero_command" <?if($my_rev != "9999") {?>oncontextmenu="return false" <?}?> class="ment_txt scroll_hide" title="덧글내용"></textarea>
									<button type='button' onclick="javascript:hero_review_submit('review_form_<?=$p_i?>','hero_command_<?=$p_i?>','pc')" class="btn_ment label_button fz15 fw600" title="덧글달기">댓글 달기</button>
								</div>
							</form>
						</div>
					</li>
	          	</ul>
			</div>
		</div>

<?
		$class='';
		$temp_check_count_i ++;
		$review_i --;
		$p_i ++;
	}
?>

</div>

<script>
//답글
function check_review_all(no){
	$(".review_mode").eq(no).val("review_write");
    // musign 주석 S - 답글 클릭시 textarea가 알맞게 생성되지 않아서 수정 240909 ydh
	// console.log( $(this) );
    // $(".review_area").each(function(idx) {
    // 	$(".review_area").hide();
	// 	$(".review_area").eq(idx).show();
    // });
    //musign 주석 E
    $("#hero_command_"+no).val('');
    $(".review_area").eq(no).toggle();
    return false;
}
//댓글 수정
function check_review_edit(no){
    let review_command = $.trim($(".review_command").eq(no).html());
    // 대댓글일때 닉네임 생략
    if(review_command.indexOf('대댓글 입력시 원댓글 작성자의 닉네임 노출 영역') == 5){
        review_command = review_command.substring(244)
    }
    //특수문자 엔티티 처리
    review_command = unescapeHtml(review_command);

    $("#hero_command_"+no).val(review_command);

	$(".review_mode").eq(no).val("review_edit");

	$(".review_area").each(function(idx) {
    	$(".review_area").eq(idx).hide('fast');
    });
    $(".review_area").eq(no).toggle();

	return false;
}

function check_review_del(idx, idx_old){

	if(confirm("삭제하시겠습니까?")==true)	hero_review_del(idx,"pc");
	else								return false;

}
//musign S HTML 문자열 이스케이프 처리
// 역매핑을 위한 엔티티 맵
var reverseEntityMap = {
    '&amp;': '&',
    '&lt;': '<',
    '&gt;': '>',
    '&quot;': '"',
    '&#39;': "'",
    '&#x2F;': '/',
    '&#x60;': '`',
    '&#x3D;': '='
};
// 이스케이프된 HTML을 원래 문자열로 되돌리는 함수
function unescapeHtml(string) {
    // 정규식을 사용하여 모든 엔티티를 찾아 역매핑
    return String(string).replace(/&amp;|&lt;|&gt;|&quot;|&#39;|&#x2F;|&#x60;|&#x3D;/g, function (s) {
        return reverseEntityMap[s];
    });
}
//musign E HTML 문자열 이스케이프 처리
$(document).ready(function(){
	const editbtn = $('.editbox');
	$.each(editbtn, function(){
		$(this).click(function(){
			$(this).find('.editinner').toggleClass('on');
		});
	});
});
</script>