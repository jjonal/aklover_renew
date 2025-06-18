<?
if (! defined ( '_HEROBOARD_' )) exit();

/*
$sql =  ' SELECT * FROM  (SELECT hero_code, hero_depth, hero_idx, hero_use, hero_today, hero_command,hero_depth_idx_old ';
$sql .= ' ,(select case when ifnull(hero_topfix,\'N\') != \'Y\' then \'N\' else \'Y\' end hero_topfix from review where hero_idx = r.hero_depth_idx_old) as hero_topfix ';
$sql .= ' from review r where r.hero_old_idx=\''.$_GET["idx"].'\' ) r ';
$sql .= ' order by hero_topfix desc ,case when hero_topfix = \'Y\' then hero_depth_idx_old end desc ,case when hero_topfix != \'Y\' then hero_depth_idx_old end asc ';
$sql .= ' ,hero_depth asc,hero_today asc '; // hero_depth_idx_old desc,hero_depth asc
*/
$total_reply_sql = " SELECT count(*) cnt FROM global_reply WHERE hero_old_idx = '".$_GET["hero_idx"]."' ";
$total_reply_res = sql($total_reply_sql);
$total_reply_rs = mysql_fetch_assoc($total_reply_res);

$reply_data = $total_reply_rs["cnt"];

$reply_sql  = " SELECT r.hero_code, r.hero_depth, r.hero_idx, r.hero_today, r.hero_command ";
$reply_sql .= " , r.hero_depth_idx_old, r.hero_topfix, m.hero_nick, m.hero_level FROM ";
$reply_sql .= " (SELECT hero_code, hero_depth, hero_idx, hero_today, hero_command, hero_depth_idx_old ";
$reply_sql .= " ,(SELECT CASE WHEN ifnull(hero_topfix,'N') != 'Y' THEN 'N' ELSE 'Y' END hero_topfix ";
$reply_sql .= " FROM global_reply WHERE hero_idx = r.hero_depth_idx_old) as hero_topfix ";
$reply_sql .= " FROM global_reply r ";
$reply_sql .= " WHERE r.hero_old_idx = '".$_GET["hero_idx"]."') r  ";
$reply_sql .= " LEFT JOIN global_member m ON r.hero_code = m.hero_code ";
$reply_sql .= " ORDER BY hero_topfix DESC, CASE WHEN hero_topfix = 'Y' THEN hero_depth_idx_old END DESC ";
$reply_sql .= " , CASE WHEN hero_topfix != 'Y' THEN hero_depth_idx_old END asc ";
$reply_sql .= " , hero_depth ASC, hero_today ASC ";

$reply_res = sql($reply_sql);
?> 

<div id="abcd"></div>
<div class="comment_cnt">
	<strong class="c_orange">댓글 <?=$reply_data?>개</strong>
</div>
<div class="commentbox">
<form id="review_form">
<input type="hidden" name="mode" value="reply_write"> 
<input type="hidden" name="hero_old_idx" value="<?=$view["hero_idx"]?>">
<input type="hidden" name="board" value="<?=$_GET['board']?>">

<?  if($_SESSION["global_admin_yn"] == "9999") {?>
	<p style="margin:0 0 8px 0; text-align:right;"><label for="hero_topFix">상단 고정</label><input type="checkbox" id="hero_topFix" name="hero_topFix" checked value="Y" /></p>
<? } ?>
</form>

<textarea id="hero_command" name="hero_command" oncontextmenu="return false" cols="30" rows="5" class="ment_txt nonCtrl" title="덧글내용"></textarea>
<input type="image"	src="../image/bbs/btn_comment.gif" onclick="reply_submit('review_form', 'hero_command','pc')" class="btn_ment" title="덧글달기">
<?
	$review_i = $reply_data - 1;
	$p_i = "0";

	while($review_row = @mysql_fetch_assoc($reply_res) ) {
		
		if (! strcmp ( $review_i, '0' )) 	$last_class = 'last';
		else 								$last_class = '';
		
		if (! strcmp ( $review_row ['hero_depth'], '0' )) {
			$temp_check_count_i = 0;
			$check_sql = 'select * from global_reply where hero_depth_idx_old= \'' . $review_row ['hero_idx'] . '\'';
			$out_check_sql = mysql_query ( $check_sql );
			$check_count = @mysql_num_rows ( $out_check_sql );
		}
		
		$level_icon = "";
		if($review_row["hero_level"] == "9999") {
			$level_icon = "/image/bbs/levAdmin01.png";
		} else {
			$level_icon = "/image/bbs/lev_global.png";
		}
		
		$temp_check_count = $check_count - $temp_check_count_i;

		if(strcmp ( $review_row ['hero_depth'], '0' ))														$class = "rpment ";
		
		if(!strcmp ( $review_row ['hero_depth'], '1' ) and !strcmp ( $temp_check_count, '1' ))	 			$class .= "last ";
		
		if(!strcmp($review_row['hero_depth'], '0') and strcmp($check_count, '1') )							$class .= "rp ";
	
	?>
	
	
	    <dl class="<?=$class.$last_class?> clearfix">
	
			<dt>
				<img src="<?=$level_icon?>" /><?=$review_row['hero_nick']?>						
			</dt>
			<dd>
				<ul>
					<?
						if (strcmp ( $review_row ['hero_use'], '1' )) {
					?>
	                <li class="gray">
						<?=date( "Y-m-d", strtotime($review_row['hero_today']))//.$review_row['hero_depth'];?>                                
						<span class="btngrp">
							<?
							if ($_SESSION ['temp_view'] != "0" && $check_review_list['hero_rev']<=$my_rev) {
								?>
								<a href="#"	onclick="javascript:check_review_all(<?=$p_i?>);">
								<img src="../image/bbs/btn_mentreply.png" height='16px;' alt="답글달기" /></a>
								<?
							}
		
							if ($my_rev >= '9999' || ! strcmp ( $review_row ['hero_code'], $_SESSION ['temp_code'] ) || ! strcmp ( $review_row ['hero_code'], $_SESSION ['global_code'] )) {
								?>
								<a href="#"	onclick="javascript:check_review_edit(<?=$p_i?>);">
									<img src="../image/bbs/btn_mentmod.png" height='16px;' alt="수정" />
								</a> 
								<a herf="javascript:;" onClick="check_review_del('<?=$review_row['hero_idx']?>')">
									<img src="../image/bbs/btn_mentdel.png" height='16px;' alt="삭제" />
								</a>
								<?
							}
							?>
	                    </span>
					</li>
					<li class="review_command"
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
					<?=htmlspecialchars($review_row['hero_command'],ENT_COMPAT,"ISO-8859-1")?>
					</li>
						
						<?}else{?>
						
						삭제된 글 입니다.
						
						<?}?>
	          	</ul>
			</dd>
		</dl>
	
		<div class="review_area" style="display: none; height: 60px">
			<div>
				<form id="review_form_<?=$p_i?>">
					<input type="hidden" class="review_mode" name="mode" value="reply_write"> 
			   		<input type="hidden" name="hero_old_idx" value="<?=$_GET['hero_idx']?>">
			   		<input type="hidden" name="depth_idx" value="<?=$review_row['hero_idx']?>">
			   		<input type="hidden" name="depth_idx_old" value="<?=$review_row['hero_depth_idx_old']?>">
					
					<textarea id="hero_command_<?=$p_i?>" name="hero_command" oncontextmenu="return false" cols="30" rows="5" class="ment_txt nonCtrl" title="덧글내용"></textarea>
				</form>
				<input type="image" src="../image/bbs/btn_comment.gif"	onclick="javascript:reply_submit('review_form_<?=$p_i?>','hero_command_<?=$p_i?>','pc')" class="btn_ment" title="덧글달기">
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
function check_review_all(no){

	$(".review_mode").eq(no).val("reply_write");
    $(".review_area").each(function(idx) {
    	$(".review_area").eq(idx).hide('fast');
    });
    $(".review_area").eq(no).toggle();
    
    return false;
}

function check_review_edit(no){
	$("#hero_command_"+no).val($.trim($(".review_command").eq(no).html()));

	$(".review_mode").eq(no).val("reply_edit");
		
	$(".review_area").each(function(idx) {
    	$(".review_area").eq(idx).hide('fast');
    });
    $(".review_area").eq(no).toggle();
    
	return false;
}

function check_review_del(idx, idx_old){

	if(confirm("삭제하시겠습니까?")==true)	reply_del(idx,"pc");		
	else								return false;
	
}

function reply_submit(review_form, command, device){
	console.log("reply_submit");

	var url = "/main/globalReplyAction.php";
	var queryString = $("#"+review_form).serialize();
	
	if(command!=''){
		var input = encodeURIComponent(document.getElementById(command).value);
		var text = document.getElementById(command).value.trim().replace(/\n/g,"");
		
		if(input=="" || input==null){
			alert("댓글을 입력해 주세요.");
			return false;
		}
		
		if(text.length < 5) {
			alert("5글자 미만의 글을 작성 불가합니다.");
			return false;
		}
		
		queryString += "&command="+input;
	}

	console.log(queryString);

	//$("#review_form").attr("method","POST").attr("action",url).submit();
	$.ajax({      
	    type:"POST",  
	    url:url,      
	    data:queryString,
	    async : 'false',
	    dataType : "json",
	    success:function(args){
	    	if(!args.result) {
	    		alert("죄송합니다. 시스템 에러입니다. 다시 시도해주세요. 같은 현상이 반복될 경우 고객센터에 문의해주세요.");
	 		}
		    
	    	if(device=='pc'){
	    		location.reload();
	    	}else{
	    		var thisNo = location.href.split("#tabbtn_")[1];
	    		var tabcon = $(".tabcon_"+thisNo);
	    		tabcon.addClass("tabcon_hide");
	    		today_openLayer(thisNo);
	    	}
	    	return false;
			
	    }
	});
}

function reply_del(idx,device){
	var url = "/main/globalReplyAction.php";
	var queryString = "mode=reply_drop&depth_idx="+idx;
	$.ajax({      
	    type:"POST",  
	    url:url,
	    data:queryString,
	    async : 'false',
	    dataType : "json",
	    success:function(args){
	    	if(!args.result){
	    		alert("죄송합니다. 시스템 에러입니다. 다시 시도해주세요. 같은 현상이 반복될 경우 고객센터에 문의해주세요.");
	    	}
	    	
	    	if(device=='pc'){
	    		location.reload();
	    	}else{
	    		var thisNo = location.href.split("#tabbtn_")[1];
	    		var tabcon = $(".tabcon_"+thisNo);
	    		tabcon.addClass("tabcon_hide");
	    		today_openLayer(thisNo);
	    	}
	    }
	});
}
</script>