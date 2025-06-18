<?
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
<div id="reply" style="margin-bottom:20px;">
	<ul style="width:100%">
		<li style="width:70%; float:left">
		<form id="review_form">
		<input type="hidden" name="mode" value="reply_write"> 
		<input type="hidden" name="hero_old_idx" value="<?=$view['hero_idx']?>">
		<input type="hidden" name="board" value="<?=$_GET['board']?>">
	   	<? if($_SESSION["global_admin_yn"] == "Y") {?>
	   	 	<p><lebal for='hero_topFix'>상단 고정</label> <input type='checkbox' name='hero_topFix' id='hero_topFix' checked value='Y' /></p>
	    <? } ?>
		</form>
	  		<textarea id="hero_command" name="hero_command" onpaste="return false" cols="" rows="" class="reply_box"></textarea>
		</li>
	    <li style="text-align:right;<?=$_SESSION["global_admin_yn"]=='Y' ? 'padding-top:30px':'';?>">
			<input type="button" value="댓글 입력" class='btn-warning today_btn' style='height:70px;width: 26%;' onClick="reply_submit('review_form', 'hero_command', 'pc');" alt="댓글입력">
		</li>
	</ul>
	<div class="clear"></div> 
</div>
<? while($review_row  = @mysql_fetch_assoc($reply_res)){
	if(!strcmp($review_i, '0'))      $last_class = ' last';
	else						     $last_class = '';
	
	$level_icon = "";
	if($review_row["hero_level"] == "9999") {
		$level_icon = "/image/bbs/levAdmin01.png";
	} else {
		$level_icon = "/image/bbs/lev_global.png";
	}
?>
<div class="reply_view">
	<? if(strcmp($review_row['hero_use'], '1')){ ?>
	<div>
		<div class="nickname">
	    	<?if($review_row['hero_depth']>=1){?>
        			<img src="img/review/reply_arrow.png" alt="" style="width:10px;"/>
	        <?}?>
        	<img src="<?=$level_icon?>"/>
	        <?=mb_substr($review_row['hero_nick'],0,5,"EUC-KR")?>
	        <span><?=date( "m-d", strtotime($review_row['hero_today']));?></span>
	   	</div>	
	   	<div class="command"><?=htmlspecialchars($review_row['hero_command'],ENT_COMPAT,"ISO-8859-1")?></div>
	</div>
	<div class="button_area">
		
		<input type='button' value="댓글" onclick="reply_area(<?=$view['hero_idx']?>,'reply_write',<?=$review_row['hero_idx']?>,<?=$review_row['hero_depth_idx_old']?>,this);" class="btn-secondary today_btn"/>
	   	<? if( $my_rev>=9999 or $review_row['hero_code']==$_SESSION['temp_code'] or  $review_row['hero_code']==$_SESSION['global_code']){?>
       				<input type='button' value="수정" onclick="reply_area(<?=$view['hero_idx']?>,'reply_edit',<?=$review_row['hero_idx']?>,<?=$review_row['hero_depth_idx_old']?>,this);" class="btn-info today_btn"/>
       				<input type='button' value="삭제" onclick="check_review_del(<?=$review_row['hero_idx']?>)" class="btn-danger today_btn"/>
		<? } ?>
	</div>
	<? } else { ?>
		<div class="nickname" style="width:100%;text-align:center">삭제된 글 입니다.</div>
	<? } ?>
	<div class="reply_area_top"></div>
	<div class="clear"></div>         	
</div>
<div class="clear"></div>
<? } ?>
<script>
function reply_area(board_idx,mode,depth_idx,depth_idx_old,obj){

	cancle_reply();

	var reply_area_top = $(obj).parent('.button_area').siblings('.reply_area_top');
	var command = '';
	if(mode=="reply_edit"){
		command = trim($(obj).parent('.button_area').parent('.reply_view').find('.command').html());
	}

	console.log(command);
	
	var reply_view ='';
		
	reply_view += "<div>";
	reply_view += "<ul>";
	reply_view += "<li style='width:70%;float:left;'>";
	reply_view += "<form id='review_form_02'>";
	reply_view += "<input type='hidden' name='mode' value='"+mode+"'>";
	reply_view += "<input type='hidden' name='board' value='<?=$_GET['board']?>'>";
	reply_view += "<input type='hidden' name='hero_old_idx' value='"+board_idx+"'>";
	reply_view += "<input type='hidden' name='depth_idx' value='"+depth_idx+"'>";
	reply_view += "<input type='hidden' name='depth_idx_old' value='"+depth_idx_old+"'>";
	reply_view += "<textarea id='hero_command_02' onpaste='return false;' class='reply_box'>"+command+"</textarea>";
	reply_view += "</form>";
	reply_view += "</li>";
	reply_view += "<li style='text-align:right;'>";
	reply_view += "<input type='button' value='입력' class='btn-warning today_btn' style='height:70px; margin-right:10px;' onclick='reply_submit(\"review_form_02\", \"hero_command_02\",\"pc\")' alt='댓글 입력'>";
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
	if(confirm("삭제하시겠습니까?")==true)	reply_del(idx,"pc");		
	else								return false;
}

function reply_submit(review_form, command, device){

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
	console.log("reply_del");
	
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