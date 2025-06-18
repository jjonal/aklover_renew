<?php
######################################################################################################################################################
include_once "head.php";
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

$error = "TODAY_01";
$group_sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."'"; // desc
//echo $group_sql;
//exit;
$out_group = new_sql( $group_sql,$error,"on" );
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

######################################################################################################################################################
$today = date( "Y-m-d", time());

$idx = $_GET['hero_idx'];
$board = $_GET['board'];

$level = $_SESSION['temp_level'];
$code = $_SESSION['temp_code'];

$my_write = $_SESSION ['temp_write'];
$my_view = $_SESSION ['temp_view'];
$my_update = $_SESSION ['temp_update'];
$my_rev = $_SESSION ['temp_rev'];

######################################################################################################################################################
$error = "TODAY_01";
$board_sql = "select A.*,B.hero_nick, C.hero_img_new, D.recommand_count, E.report_count from ";
$board_sql .= "(select * from board where hero_idx='".$idx."') as A left outer join member as B on A.hero_code=B.hero_code ";
$board_sql .= "left outer join level as C on B.hero_level=C.hero_level, ";
$board_sql .= "(select count(*) as recommand_count from hero_recommand where hero_recommand_code='".$code."' and hero_board_idx='".$idx."') as D, ";
$board_sql .= "(select count(*) as report_count from hero_report where hero_report_code='".$code."' and hero_board_idx='".$idx."') as E ";
$board_sql .= "where A.hero_idx='".$idx."' ";
//echo $board_sql;
//exit;
$out_sql = new_sql( $board_sql, $error);

if((string)$out_sql==$error){
	error_historyBack("");
	exit;
}

######################################################################################################################################################
$board_list = mysql_fetch_assoc( $out_sql);

######################################################################################################################################################
if(date("Y-m-d")==substr($board_list['hero_today'],0,10))    	$new_img_view = "<img src='".DOMAIN_END."image/main_new_bt.png'  width='14' alt='new' /> ";
else													    	$new_img_view = "";
$sns_title = $board_list['hero_title'];
$link = DOMAIN.URI_PATH.'?'.get();
$sns_image= DOMAIN_END.'image/logo2.gif';
?>

<script type="text/javascript" src="<?=JS_END;?>head.js"></script>
<link href="css/review_viewer.css?version=003" rel="stylesheet" type="text/css">

<!--컨텐츠 시작-->
<!--
<div id="title"><p><?=$right_list['hero_title'];?></p></div>
-->
<? include_once "boardIntroduce.php"; ?>
     
     

<div id="list_title">
    <div class="title_left">
        <ul style="width:100%">
        	<li class="top"><?=$new_img_view?><?=cut($board_list['hero_title'],48);?></li>
        	<li class="date">작성일: <?=date( "Y.m.d", strtotime($board_list['hero_today']));?></li>
        	<li class="nickname"><img src="<?=str($board_list['hero_img_new'])?>"/><?=$board_list['hero_nick'];?></li>
        </ul>
    </div>   
    
    <div class="title_right">
        <a href="javascript:open0('<?=$link?>');"><img src="img/review/facebook_icon.jpg" alt="페이스북" width="23px"></a>
        <a href="javascript:open1('<?=$sns_title?>','<?=$link?>');"><img src="img/review/tweeter_icon.jpg" alt="트위터" width="23px"></a>
        <iframe name="face" src="https://developers.facebook.com/tools/debug/og/object?q=<?=$link?>" width="0" height="0"></iframe>
    </div>
</div>
<?
$next_command = htmlspecialchars_decode($board_list['hero_command']);
$next_command = str_ireplace("<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n","",$next_command);
$next_command = str_ireplace("<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n","",$next_command);
$next_command = str_ireplace('<img', '<img onerror="this.src=\''.IMAGE_END.'hero.jpg\';" ', $next_command);
$next_command = preg_replace("/ width=(\"|\')?\d+(\"|\')?/"," ",$next_command);
$next_command = preg_replace("/ height=(\"|\')?\d+(\"|\')?/"," ",$next_command);
$next_command = preg_replace("/width: \d+px/","",$next_command);
$next_command = preg_replace("/height: \d+px;/","",$next_command);
$next_command = preg_replace("/margin-left: \d+pt/","",$next_command);

if($board_list['hero_04']) {
		$blog_options = remove_kr($board_list['hero_04']);
}else {
	$blog_options = remove_kr($board_list['youtube_url']).remove_kr($board_list['blog_url']).remove_kr($board_list['cafe_url']).remove_kr($board_list['sns_url']).remove_kr($board_list['etc_url']);
}

$blog_options = str_ireplace("http:","http:",$blog_options);
$blog_options = str_ireplace("https:","https:",$blog_options);

##주소값 배열 처리
$blog_options = check_blog($blog_options);

/* 2023.01.25.WED 수정*/
$mission_url_sql = " SELECT gubun, url FROM mission_url WHERE board_hero_idx = '".$_GET['hero_idx']."' ORDER BY field(gubun, 'naver', 'insta', 'movie', 'cafe', 'etc') ASC, hero_idx ASC ";
$mission_res = sql($mission_url_sql);

?>

	<div style="padding-top:5px;padding-left:5%;padding-right:5%;line-height:normal;text-align:center;"> 
	 	
	 	<? if($board_list['hero_table'] == 'group_04_22') {?>
	 		<div class="contBox"><?=$next_command;?></div>
	 	<? } else { ?>
			<img src="<?=$board_list['hero_thumb']?>" alt=""><br/>
		<? } ?>
		
		<? if($board_list['hero_table'] != 'group_04_22') {?>
		<form action="../">
			<select  name="blogDestination" onchange="blogChange();" style="margin: 20px 0;padding: 10px;font-weight: 800;font-size: 1.2em;width: 80%;max-width: 195px;  color: #f78429;border: 1px solid #f78429;-webkit-appearance: none;background-color:white;">
			<?
			    /* 2023.01.25.WED 수정*/
    			$gubun_arr = array("naver"=>"네이버 블로그","insta"=>"인스타그램","movie"=>"영상(후기)","cafe"=>"까페","etc"=>"기타");
    			while($list = mysql_fetch_assoc($mission_res)) {
    			    echo "<option value='".$list["url"]."'>".$gubun_arr[$list["gubun"]];
    			    echo "</option>";
    			}
			?>
			</select>
			<img src="/image2/etc/arrow.gif" style="position: relative;left: -27px;">		 
			<input type="button" id="blogChangeButton" value="이동" style="padding: 12px;background-color: #F68529;color: white;font-size: 1.2em;font-weight: 800;" onclick="ob=this.form.blogDestination;window.open(ob.options[ob.selectedIndex].value)">
		</form>
		<? } ?>
		  
	</div>

	<div class='btn_recommand_report'>

	</div>
	
<?php 
	$mission_after = "select hero_old_idx from mission_after where hero_idx=".$_GET['idx']."";
	$mission_after_res = new_sql($mission_after,$error);
	if($mission_after_res==$error){
		error_historyBack("");
		exit;
	}
	$hero_old_idx = mysql_result($mission_after_res,0,"hero_old_idx");
	$where = "hero_idx in (".$hero_old_idx.") "; 
	
$sql = 'select hero_idx, hero_title from board where hero_table=\'group_04_05\' and '.$where.' and hero_idx > '.$_GET['hero_idx'].' order by hero_idx asc limit 0,1;';
//echo $sql;
$out_sql = @mysql_query($sql);
$Prev = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
$Prev['hero_idx'];

$sql = 'select hero_idx, hero_title from board where hero_table=\'group_04_05\' and '.$where.' and hero_idx < '.$_GET['hero_idx'].' order by hero_idx desc limit 0,1;';
$out_sql = @mysql_query($sql);
$Next = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
$Next['hero_idx'];

if(strcmp($Prev['hero_idx'], '')){
?>
<div id="list_previous" style="width:90%; margin:auto">
        <a href="<?=PATH_END;?>meeting_detail.php?<?=get("hero_idx","hero_idx=".$Prev['hero_idx'])?>">
        <ul style="width:100%">
        <li style="width:19%; padding-left:2%">이전글&nbsp;&nbsp;<img src="img/review/arrow1.png" alt=""/></li>
        <li style="width:79%"><?=cut($Prev['hero_title'],26);?></li>
        </ul>
        </a>
</div>
<?
}
if(strcmp($Next['hero_idx'], '')){
?>
<div id="list_next" style="width:90%; margin:auto">
        <a href="<?=PATH_END;?>meeting_detail.php?<?=get("hero_idx","hero_idx=".$Next['hero_idx'])?>">
        <ul style="width:100%">
        <li style="width:19%; padding-left:2%">다음글&nbsp;&nbsp;<img src="img/review/arrow2.png" alt=""/></li>
        <li style="width:79%"><?=cut($Next['hero_title'],26);?></li>
        </ul>
        </a>
</div>
<?
}
?>
<div class="clear"></div> 
     
     
<div id="list_btn" style="width:90%; margin:auto; margin-top:20px; margin-bottom:20px">
        <ul style="width:100%">

        	<li style="width:40%; float:left">
            	<a href="<?=DOMAIN_END?>m/meeting_view.php?board=<?=$_GET['board']?>&idx=<?=$_GET['idx']?>"><img src="img/review/list_btn.jpg" alt="목록" width="70px"/></a>
        	</li>
        
        	<li style="width:60%; float:right; text-align:right">
				<?if( ($_SESSION['temp_level']>='9999') or (!strcmp($board_list['hero_code'],$_SESSION['temp_code'])) ){?>
		            <a href="/m/write.php?board=<?=$_GET['board']?>&idx=<?=$_GET['hero_idx']?>&page=<?=$_GET['page']?>">
            			<img src="img/review/modify_btn.jpg" alt="수정" width="70px"/>
            		</a>
            		&nbsp;
            		<a href="/m/action.php?board=<?=$_GET['board']?>&action=delete&idx=<?=$_GET['hero_idx']?>">
            			<img src="img/review/delete_btn.jpg" alt="삭제" width="70px"/>
            		</a>
				<?}?>
            </li>
  		</ul>
        <div class="clear"></div>
</div>


<?
## review
########################################################################################################################################################################

?>
<div id="reply">
	<ul style="width:100%">
		<?
		if($my_rev>='9999' or $right_list['hero_rev']<=$my_rev){
		?>
       		<li style="width:70%; float:left">
       			<form id="review_form">
				   	<input type="hidden" name="mode" value="review_write"> 
				   	<input type="hidden" name="board" value="<?=$_GET['board']?>">
				   	<input type="hidden" name="board_idx" value="<?=$board_list['hero_idx']?>">
				</form>
       			<textarea id="hero_command" name="hero_command" cols="" rows="" class="reply_box"></textarea>
       		</li>
       		<li style="text-align:right;">
       			<input type="button" value="댓글 입력" class='btn-warning today_btn' style='height:70px;width: 26%;' onClick="hero_review_submit('review_form', 'hero_command', 'pc');" alt="댓글입력">
       		</li>
		<?
		}
		?>
    </ul>
    <div class="clear"></div> 
</div>

<?
$review_sql = "select A.*,B.hero_level,B.hero_nick,C.hero_img_new from review as A ";
$review_sql .= "left outer join member as B on A.hero_code=B.hero_code ";
$review_sql .= "left outer join level as C on B.hero_level=C.hero_level ";
$review_sql .= "where hero_old_idx='".$board_list['hero_idx']."' ";
$review_sql .= "order by hero_depth_idx_old asc,hero_depth asc,hero_today asc";
//echo $review_sql;


$review_res = new_sql($review_sql, $error);
if ((string)$review_res==$error){
	echo 0;
	exit;
}

$review_data = mysql_num_rows ( $review_res );
$review_i = $review_data-1;

while($review_row                             = @mysql_fetch_assoc($review_res)){
	if(!strcmp($review_i, '0'))      $last_class = ' last';
    else						     $last_class = '';
    
?>

	<div class="reply_view">
		<?
			if(strcmp($review_row['hero_use'], '1')){
		?>
			<div>
				<div class="nickname">
			    	<?if($review_row['hero_depth']>=1){?>
		        			<img src="img/review/reply_arrow.png" alt="" style="width:10px;"/>
			        <?}?>
		        	<img src="<?=str($review_row['hero_img_new'])?>"/>
			        <?=mb_substr($review_row['hero_nick'],0,5,"EUC-KR")?>
			   	</div>
				
				<div class="command"><?=htmlspecialchars($review_row['hero_command'])?></div>
				<div class='date'>
					<?=date( "m-d", strtotime($review_row['hero_today']));?>
				</div>
			</div>
				<div class="button_area">
					<?if($level){?>
				        <input type='button' value="댓글" onclick="reply_area(<?=$board_list['hero_idx']?>,'review_write',<?=$review_row['hero_idx']?>,<?=$review_row['hero_depth_idx_old']?>,this);" class="btn-warning today_btn"/>
				   	<?}
				   	if( $my_rev>=9999 or $review_row['hero_code']==$_SESSION['temp_code']){?>
	       				<input type='button' value="수정" onclick="reply_area(<?=$board_list['hero_idx']?>,'review_edit',<?=$review_row['hero_idx']?>,<?=$review_row['hero_depth_idx_old']?>,this);" class="btn-info today_btn"/>
	       				<input type='button' value="삭제" onclick="check_review_del(<?=$review_row['hero_idx']?>)" class="btn-danger today_btn"/>
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
}
?>

<div class="clear"></div>
  

<script>
function reply_area(board_idx,mode,depth_idx,depth_idx_old,obj){

	cancle_reply();

	var reply_area_top = $(obj).parent('.button_area').siblings('.reply_area_top');
	var command = '';
	if(mode=="review_edit"){
		command = trim($(obj).parent('.button_area').parent('.reply_view').find('.command').html());
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
	reply_view += "<textarea id='hero_command_02' class='reply_box'>"+command+"</textarea>";
	reply_view += "</form>";
	reply_view += "</li>";
	reply_view += "<li style='text-align:right;'>";
	reply_view += "<input type='button' value='확인' class='btn-warning today_btn' style='height:70px;' onclick='hero_review_submit(\"review_form_02\", \"hero_command_02\",\"pc\")' alt='댓글 입력'>";
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
	
</script>
  
  
     
<!--컨텐츠 종료-->
