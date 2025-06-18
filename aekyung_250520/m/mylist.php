<?
include_once "head.php";
if(!defined('_HEROBOARD_'))exit;

if ($_SESSION ['temp_level']=='0' or $_SESSION ['temp_level']=='' ) {
	echo "<script>alert('권한이 없습니다.');</script>";
	echo "<script>location.href='/m/main.php?board=login';</script>";
	exit;
}

// 총 갯수
$sql =  " SELECT * FROM board WHERE hero_table not like 'group%' and hero_code='".$_SESSION['temp_code']."' ".$search." ORDER BY hero_today DESC ";
sql($sql);
$total_data = @mysql_num_rows ( $out_sql );

$list_page = 5; //한 페이지당 노출 게시물 수
$page_per_list = 5; //5페이지씩 노출

//페이지 설정
if (! strcmp ( $_GET ['page'], '' )) {
	$page = '1';
} else {
	$page = $_GET ['page'];
}

$start = ($page - 1) * $list_page;
$next_path = get ( "page||hero_i_count" );
?>
<script type="text/javascript" src="<?=JS_END;?>head.js"></script>
<script>
	$(document).ready(function(){
        //클래스 없어서 일단 주석
		// $('.reply_first').click(function(){
		//
		// 	var temp_idx = $(this).parent('li').siblings('#temp_idx').val();
		// 	$(this).parent('li').siblings('li').children('textarea').prop('id','hero_command');
		//
		// 	hero_review_end_m('zip_new.php?board_idx='+temp_idx+'', 'abcd', 'hero_command', 'review', 'action', 'temp_save_id', 'temp_save_id_old');
        //
		// });
		//
		// $('.click_reply').click(function(){
        //
		// 	cancle_reply();
		// 		var reply_view ='';
		// 		var reply_command ='';
		// 		var mode = $(this).prop('alt');
		// 		var reply_area_top = $(this).parent('div').siblings('.reply_area_top');
		// 		var temp_idx = $(this).siblings('#temp_idx').val();
		// 		var temp_id = $(this).siblings('#temp_id').val();
		// 		var temp_id_old = $(this).siblings('#temp_id_old').val();
        //
		// 		if(mode!='review_depth')	 reply_command = mode;
        //
		// 		reply_view += "<div id='reply_area_02'>";
		// 		reply_view += "		<ul>";
		// 		reply_view += "		<input type='hidden' id='action_02' name='action' value='"+mode+"'>";
		// 		reply_view += "		<input type='hidden' id='temp_save_id_02' name='temp_save_id' value='"+temp_id+"'>";
		// 		reply_view += "		<input type='hidden' id='temp_save_id_old_02' name='temp_save_id_old' value='"+temp_id_old+"'>";
		// 		reply_view += "		<input type='hidden' id='temp_idx_02' value='"+temp_idx+"'>";
		// 		reply_view += "			<li style='width:70%;'>";
		// 		reply_view += "				<textarea id='hero_command_02' name='hero_command' cols='' rows='' class='reply_box'>"+reply_command+"</textarea>";
		// 		reply_view += "			</li>";
		// 		reply_view += "			<li style='width:30%;'>";
		// 		reply_view += "				<input type='button' value='댓글 입력' class='btn-warning' onclick='save_reply("+temp_idx+")' alt='댓글 입력'>";
		// 		reply_view += "				<input type='button' value='취소' class='btn-info' onclick='cancle_reply();' alt='취소'>";
		// 		reply_view += "			</li>";
		// 		reply_view += "		</ul>";
		// 		reply_view += "		<div class='clear'></div> ";
		// 		reply_view += "</div>";
        //
		// 		reply_area_top.html(reply_view);
        //
		// 		$('#reply_area_02').slideToggle();
		// });
        //
		// $('.delete_reply').click(function(){
		// 	var temp_id = $(this).siblings('#temp_id').val();
		// 	var temp_id_old = $(this).siblings('#temp_id_old').val();
		// 	hero_ajax_m('zip_new.php?hero_idx='+temp_id+'&depth_idx_old='+temp_id_old+'', 'abcd', 'hero_command', 'review_drop');
		// 	alert('삭제 되었습니다.');
		// 	return false;
		// });
	});

	// function cancle_reply(){
	// 	$('.reply_area_top').html('');
	// 	/* $('.button_area').slideDown(); */
	// }
    //
	// function save_reply(val){
	// 	var mode=$("#action_02").val();
	// 	if(mode=='review_depth'){
	// 		hero_review_end_m('zip_new.php?board_idx='+val+'', 'abcd', 'hero_command_02', 'review', 'action_02', 'temp_save_id_02', 'temp_save_id_old_02');
	// 	}else{
	// 		var save_id=$("#temp_save_id_02").val();
	// 		hero_ajax('zip_new.php?hero_idx='+save_id+'', 'hero_command_02', 'hero_command_02', 'review_edit');
	// 	}
	// }
</script>

<link rel="stylesheet" type="text/css" href="/m/css/musign/cscenter.css" />
<div id="subpage" class="mypage mypoint">	
	<div class="my_top off">    
		<div class="sub_title">       
			<div class="sub_wrap">  
				<div class="btn_back f_cs" onclick="goBack()"><img src="/m/img/musign/main/hd_back.webp" alt="뒤로 가기"></div>   
				<h1 class="fz36">나의 작성글</h1>       
			</div>
		</div>  
		<? include_once "mypage_top.php";?> 
	</div>   
</div>

<div id="today_list"> 
<?
$main_sql = 'select * from board where hero_table not like \'group%\' and hero_code=\''.$_SESSION['temp_code'].'\''.$search.' order by hero_today desc limit '.$start.','.$list_page.';';
$out_main = @mysql_query ( $main_sql );
$i = $main_count + 1;
while ( $board_list = @mysql_fetch_assoc ( $out_main ) ) {
	if (! strcmp ( $i, '0' )) {
		$ul_class = "gallery_left";
	} else if (! strcmp ( $i, '1' )) {
		$ul_class = "gallery_center";
	} else if (! strcmp ( $i, '2' )) {
		$ul_class = "gallery_right";
	} else if (! strcmp ( $i, '3' )) {
		$ul_class = "gallery_left1";
	} else if (! strcmp ( $i, '4' )) {
		$ul_class = "gallery_center1";
	} else if (! strcmp ( $i, '5' )) {
		$ul_class = "gallery_right1";
	}
	$img_parser_url = @parse_url ( $board_list ['hero_img_new'] );
	$img_host = $img_parser_url ['host'];
	$img_path = $img_parser_url ['path'];
	if (! strcmp ( $board_list ['hero_img_new'], '' )) {
		$view_img = IMAGE_END . 'hero.jpg';
	} else if (! strcmp ( $img_host, '' )) {
		$view_img = IMAGE_END . 'hero.jpg';
	} else if (! strcmp ( $img_host, $HTTP_SERVER_VARS ['HTTP_HOST'] )) {
		$view_img = $list ['hero_img_new'];
	} else if (! strcmp ( eregi ( 'naver', $img_host ), '1' )) {
		$view_img = IMAGE_END . 'hero.jpg';
	} else {
		$view_img = $board_list ['hero_img_new'];
	}
	
	$content = $board_list ['hero_command'];
	$content = TRIM ( str_ireplace ( '&nbsp;', '', strip_tags ( htmlspecialchars_decode ( $content ) ) ) );
	$content = str_replace ( "\r", "", $content );
	$content = str_replace ( "\n", "", $content );
	$content = str_replace ( "&#65279;", "", $content );
	$content_01 = cut ( $content, '50' );
	if (! strcmp ( $content_01, "" )) {
		$content_01 = "&nbsp;";
	}
	$title = $board_list ['hero_title'];
	$title = TRIM ( str_ireplace ( '&nbsp;', '', strip_tags ( htmlspecialchars_decode ( $title ) ) ) );
	$title = str_replace ( "\r", "", $title );
	$title = str_replace ( "\n", "", $title );
	$title = str_replace ( "&#65279;", "", $title );
	$title_01 = cut ( $title, '50' );
	if (! strcmp ( $title_01, "" )) {
		$title_01 = "&nbsp;";
	}
	if (! strcmp ( y . "-" . m . "-" . d, date ( "y-m-d", strtotime ( $board_list ['hero_today'] ) ) )) {
		$new_img_view = " <img src='" . DOMAIN_END . "image/main_new_bt.png'  width='13' alt='new' />";
	} else {
		$new_img_view = "";
	}
	$pk_sql = "select A.hero_level, A.hero_nick, B.hero_img_new, C.hero_idx as recommand_idx, D.hero_idx as report_idx from member as A ";
	$pk_sql .= "inner join level as B on B.hero_level = A.hero_level ";
	$pk_sql .= "LEFT OUTER JOIN hero_recommand as C on C.hero_board_idx=".$board_list['hero_idx']." and C.hero_recommand_code='".$_SESSION['temp_code']."' ";
	$pk_sql .= "LEFT OUTER JOIN hero_report as D on D.hero_board_idx=".$board_list['hero_idx']." and D.hero_report_code='".$_SESSION['temp_code']."' ";
	$pk_sql .= "where A.hero_code = '". $board_list ['hero_code']. "'";
	$out_pk_sql = mysql_query ( $pk_sql );
	$pk_row = @mysql_fetch_assoc ( $out_pk_sql );

	?>
		<div id="today_list1" onClick="openLayer1('<?=$main_count+5?>','./img/today/list_arrow1','<?=$i?>','_1');">
			<ul class="faq_list">		
				<li class="q">
					<div class="tit_wrap">
						<p class="cate fz28"><?=date( "Y.m.d", strtotime($board_list['hero_today']));?></p>
						<div class="f_cs q_tit">
							<p class="tit fz28 bold"><?=$title_01?></p>
						</div>
					</div>
                    <!--펼침메뉴 내용 시작-->
					<div class="answer">
						<?
							$next_command = htmlspecialchars_decode ( $board_list ['hero_command'] );
							$next_command = str_ireplace ( "<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n<P>&nbsp;</P>\r\n", "", $next_command );
							$next_command = str_ireplace ( "<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n<P style=\"TEXT-ALIGN: left\" align=left>&nbsp;</P>\r\n", "", $next_command );
							$next_command = str_ireplace ( '<img', '<img onerror="this.src=\'' . IMAGE_END . 'hero.jpg\';" ', $next_command );
							$next_command = preg_replace ( "/ width=(\"|\')?\d+(\"|\')?/", " width='100%'", $next_command );
							$next_command = preg_replace ( "/ height=(\"|\')?\d+(\"|\')?/", "", $next_command );
							$next_command = preg_replace ( "/width: \d+px/", "", $next_command );
							$temp_hero_04 = href ( nl2br ( $board_list ['hero_04'] ) );

							$temp_hero_04 = str_ireplace ( '<A', '<A target="_blank"', $temp_hero_04 );
							?>
						<!-- 본문 내용  -->
						<div class="fz28 cont_a"><?=$next_command;?></div>
						<!-- end 본문  -->
						</div>
                    <!--펼침메뉴 내용 종료-->
					</div>
					<!--펼침메뉴 리스트 종료-->
					<?
						$i ++;
					}
					?>
				</li>		
			</ul>
		</div>
		<?
		if (strcmp ( $_REQUEST ['hero_i_count'], "" )) {
		?>
		<script>
		openLayer1('<?=$main_count+5?>','./img/today/list_arrow1','<?=$_REQUEST[hero_i_count]?>','_1');
		</script>
	<?
	}
	?>
	<div id="page_number" class="paging">
		<?include_once "page.php"?>
	</div>
</div> <!-- todaylist wrap -->

<script type="text/javascript">
$(document).ready(function(){
		$('.answer').hide();
		$('.q .tit_wrap').click(function(e) {
			if($(this).next().css('display') == "none") {
				$('.q .tit_wrap').removeClass('active');
				$(this).addClass('active');
				$('.answer').hide();
				$(this).next().show();
			}else {
				$('.q .tit_wrap').removeClass('active');
				$('.answer').hide();
			}
		});
	});
</script>

<!--컨텐츠 종료-->
<?include_once "tail.php";?>