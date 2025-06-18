<?
include_once "head.php";
#####################################################################################################################################################
if($_SESSION['temp_level']=='' || !is_numeric($_SESSION['temp_level']) || !$_GET['action']){
	error_historyBack("잘못된 접근입니다.");
}

$focus_group = false;
if($_GET["board"] == "group_04_06" || $_GET["board"] == "group_04_27" || $_GET["board"] == "group_04_28") {
	$focus_group = true;
}

$group_sql = " SELECT * from hero_group WHERE hero_order!='0' AND hero_use='1' AND hero_board ='".$_GET['board']."'"; // desc
$out_group = new_sql( $group_sql,$error );
$right_list = mysql_fetch_assoc ($out_group);

$member_sql = " SELECT hero_info_ci FROM member WHERE hero_use = 0  AND hero_code = '".$_SESSION["temp_code"]."' ";
$member_res = sql($member_sql);
$member_rs = mysql_fetch_assoc($member_res);

if(!$member_rs["hero_info_ci"]){
	message("체험단에 참여하기 위해서는 본인인증이 필요합니다");
	location("/m/auth.php?board=auth");
	exit;
}

if($_GET['action']=='update'){
	
	$hero_idx 		= 	 $_GET['hero_idx'];
	$board 			= 	 $_GET['board'];
	$next_board		=	 $_GET['next_board'];
	$action			=	 $_GET['action'];
    $page			=	 $_GET['page'];
    $pre_board		=	 $_GET['pre_board'];
	
	$sql = " SELECT * FROM board where hero_idx='".$hero_idx."' ";
	$sql_res = mysql_query($sql);
	if(!$sql_res){
		error_historyBack("게시물이 없습니다.");
		exit;
	}
	
	$out_row = mysql_fetch_assoc($sql_res);//mysql_fetch_row
	
	$mission_idx			=	 $out_row['hero_01'];
	$code 					=	 $out_row['hero_code'];
	$name 					=	 $out_row['hero_name'];
	$nick					=	 $out_row['hero_nick'];
	$totay 					=	 $out_row['hero_today'];
	$review_count 			=	 $out_row['hero_review_count'];
	$hero_thumb 			=	 $out_row['hero_thumb'];
	$hero_product_review 	=	 $out_row['hero_product_review'];
	$agree					=	 $out_row['hero_agree'];
	
	$new_table 	= $out_row['hero_table'];
	$hero_03 	= $out_row['hero_03'];
	
	//네이버
	$naver_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$hero_idx."' AND gubun='naver' ";
	$naver_res = sql($naver_sql);
	$naver_rs = mysql_fetch_assoc($naver_res);
	
	//인스타
	$insta_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$hero_idx."' AND gubun='insta' ";
	$insta_res = sql($insta_sql);
	$insta_rs = mysql_fetch_assoc($insta_res);
		
	//영상 채널
	if($out_row["hero_table"] == "group_04_27") {
		$movie_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$hero_idx."' AND gubun='movie' ORDER BY hero_idx ASC ";
		$movie_res = sql($movie_sql);
	}
	
	//카페
	$cafe_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$hero_idx."' AND gubun='cafe' ORDER BY hero_idx ASC ";
	$cafe_res = sql($cafe_sql);
	
	//기타
	$etc_sql = " SELECT url, member_check, admin_check FROM mission_url WHERE board_hero_idx = '".$hero_idx."' AND gubun='etc' ORDER BY hero_idx ASC ";
	$etc_res = sql($etc_sql);
	
	if($code!=$_SESSION['temp_code'] && $_SESSION['temp_level']<9999){
		echo '<script>location.href="./out.php"</script>';
		exit;
	}
	
} else if(!strcmp($_GET['action'], 'write')) {
	$mission_idx	=	 $_GET['idx'];
	$board 			= 	 $_GET['board'];
	$action			=	 $_GET['action'];
	$page			=	 $_GET['page'];
	
	$code 			= 	$_SESSION['temp_code'];
	$name 			= 	$_SESSION['temp_name'];
	$nick 			= 	$_SESSION['temp_nick'];
	$level 			= 	$_SESSION['temp_level'];
	
	$totay 			= 	Ymdhis;
	$review_count	=	'0';
	$hero_thumb 	=	"";
	
	$new_table 		=	$_GET['board'];
	$hero_03 		=	$_GET['board'];
}

//20181116 추가 개선점 관리 기능
$mission_sql  =  " SELECT hero_idx, hero_type, hero_ftc, hero_ftc_naver, hero_ftc_insta, hero_question_url_list, hero_product_review_yn, hero_question_url_check ";
$mission_sql .= " , hero_table ,hero_movie_group,  hero_movie_gisu ";
$mission_sql .= " FROM mission WHERE hero_idx = '".$mission_idx."' ";
$mission_sql_res = mysql_query($mission_sql);

$mission_row = mysql_fetch_assoc($mission_sql_res);

//21-06-01 접근 권한 추가
$mission_write_auth = true;
if($focus_group) {
	if($mission_row["hero_type"] == "7") {
		$review_auth_sql  = " SELECT count(*) cnt FROM mission_review WHERE hero_old_idx = '".$mission_idx."'  ";
		$review_auth_sql .= " AND hero_code = '".$_SESSION["temp_code"]."' AND lot_01 = '1' ";
		$review_auth_res = sql($review_auth_sql);
		$review_auth_rs = mysql_fetch_assoc($review_auth_res);

		if($review_auth_rs["cnt"] == 0) $mission_write_auth = false;
	} else { //TODO 220317 정기미션  접근권한 추가
		if($_SESSION["temp_level"] != "9999") {
			if($mission_row["hero_table"] == "group_04_06") {//뷰티체험단
				if($_SESSION["temp_level"] != "9996") $mission_write_auth = false;
			} else if($mission_row["hero_table"] == "group_04_28") { //라이프체험단
				if($_SESSION["temp_level"] != "9994") $mission_write_auth = false;
			} else if($mission_row["hero_table"] == "group_04_27") { //영상 체험단
				if($mission_row["hero_movie_group"] == "group_04_27") {
					if($_SESSION["temp_level"] != "9995") $mission_write_auth = false;
				} else if($mission_row["hero_movie_group"] == "group_04_31") {
					if($_SESSION["temp_level"] != "9993") $mission_write_auth = false;
				}
			}
		}
	}
} else {
	$review_auth_sql  = " SELECT count(*) cnt FROM mission_review WHERE hero_old_idx = '".$mission_idx."'  ";
	$review_auth_sql .= " AND hero_code = '".$_SESSION["temp_code"]."' AND lot_01 = '1' ";
	$review_auth_res = sql($review_auth_sql);
	$review_auth_rs = mysql_fetch_assoc($review_auth_res);

	if($review_auth_rs["cnt"] == 0) $mission_write_auth = false;
}

//musign 추가 콘텐츠 등록기간에만 수정 S
$review_period_sql = " SELECT count(*) cnt FROM mission WHERE hero_idx = '" . $mission_idx . "'  ";
//$review_period_sql .= " AND NOW() BETWEEN hero_today_03_01 AND hero_today_03_02 ";
// 250318 musign 조건 추가
if($mission_row["hero_type"] == "2"){ // 소문내기
	$review_period_sql .= " AND NOW() BETWEEN hero_today_01_01 AND hero_today_01_02 ";
}
else {
	$review_period_sql .= " AND NOW() BETWEEN hero_today_03_01 AND hero_today_03_02 ";
}
$review_period_res = sql($review_period_sql);
$review_period_rs = mysql_fetch_assoc($review_period_res);

if ($review_period_rs["cnt"] == 0) {
    error_historyBack("콘텐츠 등록 기간이 아닙니다.");
    exit;
}
//musign 추가 콘텐츠 등록기간에만 수정 E

if($_SESSION['temp_level'] < 9998){
    if(!$mission_write_auth) {
        error_historyBack("체험단에 당첨된 회원만 이용 가능합니다.");
        exit;
    }
}

//공정위문구
$search_ftc_naver = $mission_row["hero_ftc_naver"];
$search_ftc_naver = preg_replace("/\s+/","",$search_ftc_naver);
$search_ftc_naver = strtolower($search_ftc_naver);
$search_ftc_naver = urlEncode($search_ftc_naver);

$search_ftc_insta = $mission_row["hero_ftc_insta"];
$search_ftc_insta = preg_replace("/\s+/","",$search_ftc_insta);
$search_ftc_insta = strtolower($search_ftc_insta);
$search_ftc_insta = urlEncode($search_ftc_insta);

$hero_question_url_list = $mission_row["hero_question_url_list"]; //후기쓰기 네이버 블로그, 인스타 필수값 체크

//타이틀
if($_GET['hero_idx']) $page_title = "후기수정";
else $page_title = "후기등록";
?>
<link href="/m/css/musign/board.css" rel="stylesheet" type="text/css">
<link href="/m/css/musign/cscenter.css" rel="stylesheet" type="text/css">	
<link href="/m/css/musign/suppoters.css" rel="stylesheet" type="text/css">
<div id="content" class="write_cont reviewcont">
	<div class="page_tit">
		<p class="fz44 fw600">체험단 <?=$page_title;?></p> 
	</div>	
    <form action="zip_thumb.php" id="write2_file_upload" enctype="multipart/form-data" method="post" >
    	<input type="file" name="thumbImage" id="write_hero_thumb" title="이미지" style="position: absolute; left: -9999em;"/>
   	</form>
   	
   	<form action="zip_thumb.php" id="write3_file_upload" enctype="multipart/form-data" method="post" >
    	<input type="file" name="thumbImage" id="write_hero_product_review" title="이미지" style="position: absolute; left: -9999em;"/>
   	</form>
    <form name="form_next" action="<?=DOMAIN_END.'m/mission_write.php?'.get('','type=edit');?>" method="post" enctype="multipart/form-data" onSubmit="return false;">
        <input type="hidden" name="hero_drop" value="hero_drop||x||y" />   
        <input type="hidden" name="hero_code" value="<?=$_SESSION['temp_code'];?>">
		<input type="hidden" name="hero_review" value="<?=$_SESSION['temp_code'];?>">
		<input type="hidden" name="hero_today" value="<?=$totay;?>">
		<input type="hidden" name="hero_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
        <input type="hidden" name="hero_review_count" value="<?=$review_count?>">
        <input type="hidden" name="hero_name" value="<?=$name;?>">
        <input type="hidden" name="hero_01" value="<?=$mission_idx;?>">
        <input type="hidden" name="hero_notice" value="1">
        <input type="hidden" name="hero_03" value="<?=$hero_03?>">
        <input type="hidden" name="hero_table" value="<?=$new_table?>">
        <input type="hidden" name="hero_nick" value="<?=$nick?>">
    <div class="talk_write">
		<div class="form-group">
			<div class="tit">		
				<input type="text" name="hero_title" id="hero_title" title="제목" value="<?=$out_row['hero_title'];?>" class="fz28" autocomplete="off" placeholder="제목을 입력하세요."/>
			</div>
		</div>
		<div class="form-group">
			<!-- <label class="col-sm-2 control-label" for="hero_nick">작성자</label> -->
			<div class="col-sm-10">		
				<!-- <input type="text" name="hero_nick" id="hero_nick" title="작성자" value="<?=$nick;?>" readonly class="form-control"/> -->
				<?if($_SESSION['temp_level']>=9999){?>
					<?if($board=="group_02_02"){?>
						<div class="input_chk"><input type="checkbox" name="hero_notice_use" id="hero_notice_use" value="1" <?=$sql_rs['hero_notice_use'] == "1" ? "checked":"";?> />
						<label for="hero_notice_use" class="input_chk_label">Lover 톡 공지</label></div>
					<?}?>
				<?}?>
			</div>
		</div>
		<div class="form-group f_cs">
			<label class="list_tit fz28 bold">작성자</label>
			<div><?=$nick;?></div>
		</div>					
		<div class="upfile f_cs">
			<p class="list_tit fz28 bold">대표이미지</p>			
			<div id="present_image_area">		
			<? if($hero_thumb){ ?>
				<img src="<?=$hero_thumb?>" style="width:200px; margin-right: 1rem;">
			<? }?>
			</div>
			<div class="upfile_inner rel" style="min-height: 32px;">	
				<input type="hidden" id="hero_thumb" name="hero_thumb" value="<?=$hero_thumb?>"/>
				<label for="write_hero_thumb" id="link" class="custom-file-upload">파일선택<img src="/img/front/icon/fileup.webp" alt="첨부파일 업로드"></label>
			</div>	
		</div>
		<div class="warn">                                        
			<p class="fz24 op05">* 10MB 이하로 업로드해 주세요.</p>
		</div> 
		<? if($mission_row["hero_product_review_yn"]=="Y") {?>
		<div class="upfile f_cs">
			<p class="list_tit fz28 bold">상품평 이미지</p>
			<div id="product_review_image_area">						
				<? if($hero_product_review){ ?>					
					<img src="<?=$hero_product_review?>" style="width:200px; margin-right: 1rem;">
				<? }?>
			</div>
			<div class="upfile_inner rel"  style="min-height: 32px;">	
				<input type="hidden" id="hero_product_review" name="hero_product_review" value="<?=$hero_product_review?>"/>
				<label for="write_hero_product_review" id="link" class="custom-file-upload">파일선택<img src="/img/front/icon/fileup.webp" alt="첨부파일 업로드"></label>
			</div>	
		</div>
		<div class="warn">    
			<span class="fz24" style="color:#ff0000"></span>                                    
			<p class="fz24 op05">* 상품평 작성은 권유미션입니다.</p>
			<p class="fz24 op05">* 포인트 체험단 ‘권유미션＇으로 구매한 제품 상품평을 작성하신 경우 캡쳐본을 첨부해주세요.</p>
		</div> 
		<? } ?>
		<div class="dis-no">
			<? if($mission_row['hero_question_url_check'] && $mission_row['hero_question_url_check'] != "9") {?>
				<? if($mission_row['hero_question_url_check'] == "1") {?>
					<p class="emphasis">* 네이버 블로그 URL은 필수로 입력하셔야 합니다.</p>
				<? } else if($mission_row['hero_question_url_check'] == "2") {?>
					<p class="emphasis">* 인스타그램 URL은 필수로 입력하셔야 합니다.</p>
				<? } else if($mission_row['hero_question_url_check'] == "3") {?>
					<p class="emphasis">* 네이버 블로그/인스타그램 URL 중  한개의 URL은 필수로 입력하셔야 합니다.</p>
				<? } else if($mission_row['hero_question_url_check'] == "4") {?>
					<p class="emphasis">* 네이버 블로그, 인스타그램 URL은 필수로 입력하셔야 합니다.</p>
				<? } else if($mission_row['hero_question_url_check'] == "6") {?>
					<p class="emphasis">* 네이버 블로그, 인스타그램 URL, 후기(영상) URL 은 필수로 입력하셔야 합니다.</p>
				<? } else if($mission_row['hero_question_url_check'] == "5" && $_GET["board"] == "group_04_27") {?>
					<p class="emphasis">* 후기(영상) URL은 필수로 입력하셔야 합니다.</p>
				<? } ?>
			<? } ?>
		</div>
		<div class="info_banner_wrap">
			<p class="list_tit fz28 bold">공정위 배너 안내</p>
			<div class="info_banner">
				<p class="fz26 fw500 main_c"><img src="/img/front/icon/caution.webp" alt="안내/유의사항" style="margin-right: .5rem;">Notice</p>
				<span class="fz24 fw600">
					공정거래위원회 ‘표시 광고법’ 지침에 따라,<br/> 모든 제품 리뷰에는 공정위 배너가 반드시 기재되어야 합니다.<br/>
					리뷰 컨텐츠 작성 시 AK Lover 공정위 문구를 꼭 기재해주세요!
				</span>
			</div>
		</div>
		<div class="sns_wirte">
			<div>
				<div class="fz26 bold" style="margin-bottom: 1.4rem;">
					네이버 블로그 URL
				</div>
				<div>
					<div class="f_b">
						<div class="blog_input_wrap">
							<input type="text" name="naver_url" placeholder="반드시 포스팅 URL을 입력해주세요.(http:// 또는 https://필수 입력)" class="inputUrl" value="<?=$naver_rs["url"]?>"/>
							<input type="hidden" name="naver_admin_check" id="naver_admin_check" value="<?=$naver_rs["admin_check"]?>" />
						</div>
						<? if($mission_row["hero_ftc"] == "1") { ?>
							<div><a href="javascript:;" onClick="fnAdminCheck('naver')" class="btnUrlCheck fz24 fw600">공정위 배너 확인</a></div>
						<? } ?>
					</div>
					<? if($mission_row["hero_ftc"] == "1") { ?>	<p class="txt_url_check" id="txt_naver_url_check"></p><? } ?>
					<p class="main_c fz24 fw500 desc">네이버 블로그의 경우 공정위 배너가 정상적으로 포함이 되었는지 반드시 확인을 받으셔야 합니다.
					확인하기 버튼을 클릭하시고 후기 등록을 완료해주시기 바랍니다.</p>
				</div>
			</div>
			<div>
				<div class="fz26 bold" style="margin-bottom: 1.4rem;">
					<? if(strpos($hero_question_url_list,"인스타그램") !== false) { ?><? } ?>
					인스타그램
				</div>
				<div>
					<div class="f_b">
						<div class="blog_input_wrap">
							<input type="text" name="insta_url" placeholder="반드시 포스팅 URL을 입력해주세요." class="inputUrl" value="<?=$insta_rs["url"]?>"/>
							<input type="hidden" name="insta_admin_check" id="insta_admin_check" value="<?=$insta_rs["admin_check"]?>"/>
						</div>
						<? if($mission_row["hero_ftc"] == "1") { ?>
							<!-- <div><a href="javascript:;" onClick="fnAdminCheck('insta')" class="btnUrlCheck fz24 fw600">공정위문구확인</a></div> 	 -->
						<? } ?>
					</div>
					<? if($mission_row["hero_ftc"] == "1") {?><p class="txt_url_check" id="txt_insta_url_check"></p><? } ?>
					<dl class="urlAgreeBox">
						<dt>※ 공정거래위원회 문구를 작성하였습니까?</dt>
						<dd>
							<div class="input_radio"><input type="radio" name="insta_member_check" id="insta_member_check_Y" value="Y" <?=$insta_rs["member_check"] == "Y" ? "checked":"";?>/><label for="insta_member_check_Y" class="input_radio_label">예</label></div>
							<div class="input_radio"><input type="radio" name="insta_member_check" id="insta_member_check_N" value="N" <?=$insta_rs["member_check"] == "N" ? "checked":"";?>/><label for="insta_member_check_N" class="input_radio_label">아니오</label></div>
						</dd>
						<p class="txt_agree_info mgb10">
							※ 공정거래위원회의 ‘추천보증 등에 관한 표시광고 심사지침’ 또는 ‘전자상거래 등에서의 소비자보호에 관한 법률’에 의한 필수 기재사항으로, 작성되지 않을 경우 AK LOVER 활동에 불이익이 있을 수 있습니다.
						</p>
					</dl>
				</div>
			</div>
			<? if($mission_row['hero_question_url_check'] == "6" || $_GET['board'] == 'group_04_27' || $out_row["hero_table"] == "group_04_27"){ ?>
			<div>
				<div class="fz26 bold" style="margin-bottom: 1.4rem;">유튜브 URL</div>
				<div>
					<div class="ui_urlBox">
						<div class="ui_url rel">
							<input type="text" name="movie_url[]" placeholder="반드시 포스팅 URL을 입력해주세요.(http:// 또는 https://필수 입력)" class="inputUrl3"/>
							<a href="javascript:;" onClick="fnUrl(this,'add')" class="btn_url_add">+</a>
							<dl class="urlAgreeBox">
								<dt>※ 공정거래위원회 문구를 작성하였습니까?</dt>
								<dd>
									<div class="input_radio"><input type="radio" name="movie_member_check1" id="movie_member_check1_Y" value="Y"/><label for="movie_member_check1_Y">예</label></div>
									<div class="input_radio"><input type="radio" name="movie_member_check1" id="movie_member_check1_N" value="N"/><label for="movie_member_check1_N">아니오</label></div>
								</dd>
							</dl>
							<p class="txt_agree_info mgb10">
								※ 공정거래위원회의 ‘추천보증 등에 관한 표시광고 심사지침’ 또는 ‘전자상거래 등에서의 소비자보호에 관한 법률’에 의한 필수 기재사항으로, 작성되지 않을 경우 AK LOVER 활동에 불이익이 있을 수 있습니다.
							</p>
						</div>
						<? if($_GET["action"] == "update" && ($mission_row['hero_question_url_check'] == "6" || $_GET["board"] == "group_04_27" || $out_row["hero_table"] == "group_04_27")) {
							$k = 2;
							while($movie_list = mysql_fetch_assoc($movie_res)) {
						?>
							<div class="ui_url rel">
								<input type="text" name="movie_url[]" placeholder="반드시 포스팅 URL을 입력해주세요.(http:// 또는 https://필수 입력)" class="inputUrl3" value="<?=$movie_list["url"]?>"/>
								<a href="javascript:;" onClick="fnUrl(this,'minus')" class="btn_url_minus">-</a>
								<dl class="urlAgreeBox">
									<dt>※ 공정거래위원회 문구를 작성하였습니까?</dt>
									<dd>
										<div class="input_radio"><input type="radio" name="movie_member_check<?=$k?>" id="movie_member_check<?=$k?>_Y" value="Y" <?=$movie_list["member_check"] == "Y" ? "checked":"";?>/><label for="movie_member_check<?=$k?>_Y">예</label></div>
										<div class="input_radio"><input type="radio" name="movie_member_check<?=$k?>" id="movie_member_check<?=$k?>_N" value="N" <?=$movie_list["member_check"] == "N" ? "checked":"";?>/><label for="movie_member_check<?=$k?>_N">아니오</label></div>
									</dd>
								</dl>
								<p class="txt_agree_info mgb10">
									※ 공정거래위원회의 ‘추천보증 등에 관한 표시광고 심사지침’ 또는 ‘전자상거래 등에서의 소비자보호에 관한 법률’에 의한 필수 기재사항으로, 작성되지 않을 경우 AK LOVER 활동에 불이익이 있을 수 있습니다.
								</p>
							</div>
						<?
							$k++;
							}
						}?>
					</div>
				</div>
			</div>			
			<? } ?>
			<div>
				<div class="fz26 bold" style="margin-bottom: 1.4rem;">기타</div>
				<div>
					<div class="ui_urlBox">
						<div class="ui_url rel">
							<input type="text" name="etc_url[]" placeholder="반드시 포스팅 URL을 입력해주세요.(http:// 또는 https://필수 입력)" class="inputUrl3"/>
							<a href="javascript:;" onClick="fnUrl(this,'add')" class="btn_url_add">+</a>
							<dl class="urlAgreeBox">
								<dt>※ 공정거래위원회 문구를 작성하였습니까?</dt>
								<dd>
									<div class="input_radio"><input type="radio" name="etc_member_check1" id="etc_member_check1_Y" value="Y"/><label for="etc_member_check1_Y">예</label></div>
									<div class="input_radio"><input type="radio" name="etc_member_check1" id="etc_member_check1_N" value="N"/><label for="etc_member_check1_N">아니오</label></div>
								</dd>
							</dl>
							<p class="txt_agree_info mgb10">
								※ 공정거래위원회의 ‘추천보증 등에 관한 표시광고 심사지침’ 또는 ‘전자상거래 등에서의 소비자보호에 관한 법률’에 의한 필수 기재사항으로, 작성되지 않을 경우 AK LOVER 활동에 불이익이 있을 수 있습니다.
							</p>
						</div>
						<? if($_GET["action"] == "update") {
							$k = 2;
							while($etc_list = mysql_fetch_assoc($etc_res)) {
						?>
							<div class="ui_url">
								<input type="text" name="etc_url[]" placeholder="반드시 포스팅 URL을 입력해주세요.(http:// 또는 https://필수 입력)" class="inputUrl3" value="<?=$etc_list["url"]?>"/>
								<a href="javascript:;" onClick="fnUrl(this,'minus')" class="btn_url_minus">-</a>
								<dl class="urlAgreeBox">
									<dt>※ 공정거래위원회 문구를 작성하였습니까?</dt>
									<dd>
										<div class="input_radio"><input type="radio" name="etc_member_check<?=$k?>" id="etc_member_check<?=$k?>_Y" value="Y" <?=$etc_list["member_check"] == "Y" ? "checked":"";?>/><label for="cafe_member_check<?=$k?>_Y">예</label></div>
										<div class="input_radio"><input type="radio" name="etc_member_check<?=$k?>" id="etc_member_check<?=$k?>_N" value="N" <?=$etc_list["member_check"] == "N" ? "checked":"";?>/><label for="cafe_member_check<?=$k?>_N">아니오</label></div>
									</dd>
								</dl>
								<p class="txt_agree_info mgb10">
									※ 공정거래위원회의 ‘추천보증 등에 관한 표시광고 심사지침’ 또는 ‘전자상거래 등에서의 소비자보호에 관한 법률’에 의한 필수 기재사항으로, 작성되지 않을 경우 AK LOVER 활동에 불이익이 있을 수 있습니다.
								</p>
							</div>
						<?
							$k++;
							}
						}?>
					</div>
				</div>
			</div>		
			<div class="dis-no">
				<div class="infoBox">
					<p>
						※ AK LOVER에서 진행되는 모든 체험단은 공정거래위원회 표시광고법 지침에 따라 제품을 제공받아 후기를 작성하실 경우, 대가성 여부를 표시하는 것을 규정상 원칙으로 하고 있습니다.<Br/>
						<span>
						※ 네이버 블로그, 인스타그램 URL은 1개만 등록 가능하며, 후기(영상), 카페, 기타 URL만 최대 5개까지 등록을 제공합니다.<br/>
						※ 기타란은  트위터, 카카오스토리, 페이스북 등 URL을 입력합니다.
						</span>
					</p>
				</div>
			</div>
			<? if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_08' || $_GET['board'] == 'group_04_23' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){ ?>
				<div class="answerWrap">
					<p class="tit">콘텐츠 활용 동의</p>
					<p class="txt_tit_ex fz26" style="line-height: 1.3;">AK LOVER 활동의 일환으로 작성한 모든 콘텐츠(저작물)와 관련된 권리(저작권, 초상권 등)를 AK LOVER 활동으로 진행한 국/내외 관련제품 및 브랜드 웹사이트,
					홈쇼핑 방송, 온라인/오프라인 광고, 기타 광고, 홍보 및 마케팅 자료로 AK LOVER 활동 중,
					활동이 종료된 후에도 본인이 동의 철회 의사를 밝히기 전까지 무상으로 자유롭게 이용할 권리 및 2차적 저작물 작성권을 애경산업㈜에 허락하며 이에 동의합니다. </p>
					<dl class="answer_dl_vertical" style="margin: 2rem 0 1rem;">
						<dd><div class="input_chk"><input type="checkbox" name="hero_agree" id="hero_agree" value='Y' <? echo $agree=='Y' ? 'checked' : '' ?>> <label for="hero_agree" class="input_chk_label">콘텐츠 활용 동의</label></div></dd>
					</dl>
					<p class="txt_ex_orange fz26">* 콘텐츠 활용 미 동의 시 체험단 신청이 불가합니다.</p>
				</div>
			<? } ?>
		</div>   	
    </div>
    </form>
    <div class="write_btn_wrap">
		<input type="button" class="btn btn_cancle" onClick="javascript:location.href='mission.php?<?=get('page||hero_idx||mission_idx')?>'" value="취소하기"/>
		<? if($_GET["action"] == "update") {?>
			<input type="button" class="btn btn_submit" onClick="doSubmit(form_next);" value="수정하기"/>
		<? } else { ?>
			<input type="button" class="btn btn_submit" onClick="doSubmit(form_next);" value="등록하기"/>
		<? } ?>
    </div>
</div>

<div class="clear"></div>
<script src="/js/jquery.form.js"></script>
<script>
var clipboard_naver = new Clipboard('.btn_clip_naver');
clipboard_naver.on('success', function(e) {
	alert("네이버블로그 공정위문구가 복사 되었습니다.");
});

clipboard_naver.on('error', function(e) {
    console.log(e);
});

var clipboard_insta = new Clipboard('.btn_clip_insta');
clipboard_insta.on('success', function(e) {
	alert("인스타그램 공정위문구가 복사 되었습니다.");
});

clipboard_insta.on('error', function(e) {
    console.log(e);
});

$(document).ready(function(){

	<? if($mission_row["hero_ftc"]=="1") {?>
		$("input[name='naver_url']").on("keyup",function(){
			fnAdminCheckCancel("naver");
		})
		
		$("input[name='insta_url']").on("keyup",function(){
			fnAdminCheckCancel("insta");
		})
	<? } ?>

	fnAdminCheckCancel = function(gubun) {
		if(gubun == "naver") {
			$("#naver_admin_check").val("N");
			$("#txt_naver_url_check").html("");
		} else if(gubun == "insta") {
			$("#insta_admin_check").val("N");
			$("#txt_insta_url_check").html("");
		}
	}

	fnAdminCheck = function(gubun) {
		var search_keyword = "";
		
		if(gubun == "naver") {
			var param = "mode=naver_url_check&naver_url="+$("input[name='naver_url']").val()+"&search_keyword=<?=$search_ftc_naver?>";
			if(!$("input[name='naver_url']").val()) {
				alert("네이버 블로그를 입력해주세요.");
				$("input[name='naver_url']").focus();
				return;
			}
		} else if(gubun == "insta") {
			var param = "mode=insta_url_check&insta_url="+$("input[name='insta_url']").val()+"&search_keyword=<?=$search_ftc_insta?>";
			if(!$("input[name='insta_url']").val()) {
				alert("인스타그램  URL을 입력해주세요.");
				$("input[name='insta_url']").focus();
				return;
			}
		}

		$.ajax({
				url:"/main/sns_url_check.php"
				,data:param
				,type:"POST"
				,dataType:"html"
				,success:function(d){
					if(d=="success") {
						if(gubun == "naver") {
							$("#naver_admin_check").val("Y");
							$("#txt_naver_url_check").addClass("txt_success");
							$("#txt_naver_url_check").html("공정위문구가 확인되었습니다.");
						} else if(gubun == "insta") {
							$("#insta_admin_check").val("Y");
							$("#txt_insta_url_check").addClass("txt_success");
							$("#txt_insta_url_check").html("공정위문구가 확인되었습니다.");
						}
					} else {
						if(gubun == "naver") {
							var html  = "공정위 배너 이미지에 '공정위 링크 복사하기' 버튼을 눌러 복사 된 링크를 적용한 후 후기 등록이 가능합니다.";
							html += "<br/>배너 삽입 방법은 AK Lover 이용백서 서포터즈편의 공정위 배너 문구 가이드를 참고해주시기 바랍니다.<br/>";
							html += '<span class="txt_fail_copy"><?=$mission_row["hero_ftc_naver"]?> <a href="javascript:;" class="btn_copy btn_clip_naver" data-clipboard-text="<?=$mission_row['hero_ftc_naver']?>">공정위링크 복사하기</a></span>';
							
							$("#naver_admin_check").val("N");
							$("#txt_naver_url_check").removeClass("txt_success");
							$("#txt_naver_url_check").html(html);
						} else if(gubun == "insta") {
							var html  = "공정위 문구 미작성시 후기 등록이 불가합니다.";
								html += "<br/>반드시, 아래 문구 그대로 콘텐츠 상단에 기입 부탁드립니다.<br/>";
								html += '<span class="txt_fail_copy"><?=$mission_row["hero_ftc_insta"]?> <a href="javascript:;" class="btn_copy btn_clip_insta" data-clipboard-text="<?=$mission_row['hero_ftc_insta']?>">공정위문구 복사하기</a></span>';
							
							$("#insta_admin_check").val("N");
							$("#txt_insta_url_check").removeClass("txt_success");
							$("#txt_insta_url_check").html(html);
						}
					}
				},error:function(e) {
					console.log(e);
				}
			})
	}
	
	fnUrl = function(t,type) {
		if(type == "add"){
			var html = "<div class='ui_url rel'>"+$(t).parents(".ui_url").html()+"</div>";
			var ui_urlBox = $(t).parents(".ui_urlBox");
			var idx = ui_urlBox.children("div").length+1;
			html = html.replace("+","-");
			html = html.replace(/add/gi,"minus");
			html = html.replace(/member_check1/gi,"member_check"+idx);
			var ui_url_limit_ea = 5;
			if(ui_urlBox.children("div").length < ui_url_limit_ea) {
				ui_urlBox.append(html);
			} else {
				alert("최대 5개까지 등록 가능합니다.");
				return;
			}
		} else if(type == "minus"){
			var ui_urlBox = $(t).parents(".ui_url");
			ui_urlBox.remove();
		}
	}

	$("#write_hero_thumb").change(function(){
		var file = this;
		var filename = $(this).val();
		var maxSize  = 10 * 1024 * 1024    //2MB
		var fileSize = 0;
		var browser=navigator.appName;

		var tf_extension = extension_check(filename,"image");

		if(tf_extension==false){
			$(this).val("");
			return false;
		}

		// 익스플로러일 경우
		if (browser=="Microsoft Internet Explorer") {
			var oas = new ActiveXObject("Scripting.FileSystemObject");
			fileSize = oas.getFile( filename ).size;
		} else {
			fileSize = file.files[0].size;
		}

		if(maxSize < fileSize) {
			alert("이미지 용량초과입니다.\n2MB이하로 업로드를 진행해 주세요.");
			return false;
		}

		var options=
        {
        		success: function(data){
					if(data=='0'){
						alert("죄송합니다. 이미지 업로드 오류입니다. 다시 시도해주세요. 같은 현상이 반복될 경우 고객센터에 문의해주세요.");
						return false;
					}else{
						$("#present_image_area").html("<img src='"+data+"' style='width: 100px; margin-right: 1rem;'/>");
						data = trim(data);
						$("#hero_thumb").val(data);
					}
				},beforeSend:function(){
		            $('.img-loading').css('display','block');
		        }
		        ,complete:function(){
		            $('.img-loading').css('display','none');
		     
		        },error:function(e){  
					alert("죄송합니다. 이미지 업로드 오류입니다. 다시 시도해주세요. 같은 현상이 반복될 경우 고객센터에 문의해주세요.");
					return false;
		        } 
        };
        $('#write2_file_upload').ajaxForm(options).submit();
					
	});

	$("#write_hero_product_review").change(function(){
		var file = this;
		var filename = $(this).val();
		var maxSize  = 10 * 1024 * 1024    //2MB
		var fileSize = 0;
		var browser=navigator.appName;

		var tf_extension = extension_check(filename,"image");

		if(tf_extension==false){
			$(this).val("");
			return false;
		}

		// 익스플로러일 경우
		if (browser=="Microsoft Internet Explorer") {
			var oas = new ActiveXObject("Scripting.FileSystemObject");
			fileSize = oas.getFile( filename ).size;
		} else {
			fileSize = file.files[0].size;
		}

		if(maxSize < fileSize) {
			alert("이미지 용량초과입니다.\n2MB이하로 업로드를 진행해 주세요.");
			return false;
		}

		var options=
        {
        		success: function(data){
					if(data=='0'){
						alert("죄송합니다. 이미지 업로드 오류입니다. 다시 시도해주세요. 같은 현상이 반복될 경우 고객센터에 문의해주세요.");
						return false;
					}else{
						$("#product_review_image_area").html("<img src='"+data+"' style='width: 100px; margin-right: 1rem;'/>");
						data = trim(data);
						$("#hero_product_review").val(data);
					}
				},beforeSend:function(){
		            $('.img-loading').css('display','block');
		        }
		        ,complete:function(){
		            $('.img-loading').css('display','none');
		     
		        },error:function(e){  
					alert("죄송합니다. 이미지 업로드 오류입니다. 다시 시도해주세요. 같은 현상이 반복될 경우 고객센터에 문의해주세요.");
					return false;
		        } 
        };
        $('#write3_file_upload').ajaxForm(options).submit();
					
	});
	
});

function doSubmit (theform){
	var expUrl = /^http[s]?\:\/\//i; //url 체크

    var title		=	 theform.hero_title;
    var thumb 		=	 theform.hero_thumb;
    var link 		=	 theform.hero_04;
    var hero_table 	=	 theform.hero_table;
    var hero_03 	=	 theform.hero_03;
    var hero_product_review =	 theform.hero_product_review;

    var hero_question_url_check = "<?=$mission_row["hero_question_url_check"]?>"; //URL 필수 값 체크

    if(trim(title.value) == ""){
        alert("제목을 입력해 주세요.");
        title.style.borderBottom = '1px solid red';
        title.focus();
        return false;
    }else{
        title.style.border = '';
    }

	if(thumb.value == ""){
		alert("대표 이미지를 등록해주세요.");
		return false;
	}

	if(hero_question_url_check == "1") {	
		if(!$("input[name='naver_url']").val()) {
			alert("네이버 블로그 URL을 입력해 주세요.");
			$("input[name='naver_url']").focus();
			return;
		}	
	}

	if(hero_question_url_check == "3") {
		if(!$("input[name='naver_url']").val() && !$("input[name='insta_url']").val()) {
			alert("네이버 블로그/인스타그램 URL 중  한개의 URL은 필수로 입력하셔야 합니다.");
			$("input[name='naver_url']").focus();
			return false;
		}
	} else if(hero_question_url_check == "4") {
		if(!$("input[name='naver_url']").val() || !$("input[name='insta_url']").val()) {
			alert("네이버 블로그, 인스타그램 URL은 필수로 입력하셔야 합니다.");
			$("input[name='naver_url']").focus();
			return false;
		}
	}
  
    if($("input[name='naver_url']").val()) {
		if(!expUrl.test($("input[name='naver_url']").val())) {
			alert("네이버 블로그 URL http:// 또는 https:// 필수로 입력이 필요합니다.");
			$("input[name='naver_url']").focus();
			return;
		}

		// <? if($mission_row["hero_ftc"] == "1") {?>
		// if($("input[name='naver_admin_check']").val() != "Y") {
		// 	alert("네이버 블로그 공정위 문구 확인 후 진행해 주세요.");
		// 	return;
		// }
		// <? } ?>

		// if($("input:radio[name='naver_member_check']:checked").val() != "Y") {
		// 	alert("네이버 블로그 공정거래위원회 문구 작성에 동의해주세요.");
		// 	return;
		// }
	}

	if(hero_question_url_check == "2") {
		if(!$("input[name='insta_url']").val()) {
			alert("인스타그램  URL을 입력해 주세요.");
			$("input[name='insta_url']").focus();
			return;
		}	
	}

	if($("input[name='insta_url']").val()) {
		if(!expUrl.test($("input[name='insta_url']").val())) {
			alert("인스타그램 URL http:// 또는 https:// 필수로 입력이 필요합니다.");
			return;
		}

		<? if($mission_row["hero_ftc"] == "1") {?>
		if($("input[name='insta_admin_check']").val() != "Y") {
			alert("인스타그램 공정위 문구 확인 후 진행해 주세요.");
			return;
		}
		<? } ?>

		if($("input:radio[name='insta_member_check']:checked").val() != "Y") {
			alert("인스타그램 공정거래위원회 문구 작성에 동의해주세요.");
			return;
		}
	}

	<? if($_GET ['board'] == "group_04_27" || $out_row["hero_table"] == "group_04_27") { ?>
	var movie_check_val = false;
	$("input[name='movie_url[]']").each(function(i){
		if($(this).val()) movie_check_val = true;
	})

	if(hero_question_url_check == "5") {
		if(!movie_check_val) {
			alert("후기(영상) URL을 입력해 주세요.");
			return;
		}	
	}
	
	var movieUrlCheck = true;
	var movieMemberCheck = true;
   	$("input[name='movie_url[]']").each(function(i){
       	if($(this).val()) {
       		if(!expUrl.test($(this).val())) {
           		alert("후기(영상) URL http:// 또는 https:// 필수로 입력이 필요합니다.");
           		movieUrlCheck = false;
				return false;
       		}

       		if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
                alert("후기(영상) 공정거래위원회 문구 작성에 동의해주세요.")
         	   movieMemberCheck = false;
         	   return false;
            }
        }
    })
    if(!movieUrlCheck) return;
    if(!movieMemberCheck) return;
    <? } ?>

	var cafeUrlCheck = true;
	var cafeMemberCheck = true;
   	$("input[name='cafe_url[]']").each(function(i){
       	if($(this).val()) {
       		if(!expUrl.test($(this).val())) {
           		alert("카페 URL http:// 또는 https:// 필수로 입력이 필요합니다.");
           		cafeUrlCheck = false;
				return false;
       		}

       		if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
                alert("카페 공정거래위원회 문구 작성에 동의해주세요.")
         	   cafeMemberCheck = false;
         	   return false;
            }
        }
    })
    if(!cafeUrlCheck) return;
    if(!cafeMemberCheck) return;

    var etcUrlCheck = true;
	var etcMemberCheck = true;
   	$("input[name='etc_url[]']").each(function(i){
       	if($(this).val()) {
       		if(!expUrl.test($(this).val())) {
           		alert("기타 URL http:// 또는 https:// 필수로 입력이 필요합니다.");
           		etcUrlCheck = false;
				return false;
       		}

       		if($(this).parent(".ui_url").find("input[type=radio]:checked").val() != "Y") {
                alert("기타 공정거래위원회 문구 작성에 동의해주세요.")
         	   etcMemberCheck = false;
         	   return false;
            }
        }
    })
    if(!etcUrlCheck) return;
    if(!etcMemberCheck) return;

    var url_value_check = false; //포스팅 URL 1개는 반드시 등록이 필요함
	$(".inputUrl").each(function(i){
		if($(this).val()) url_value_check = true;
	})
	
	$(".inputUrl3").each(function(i){
		if($(this).val()) url_value_check = true;
	})
	
	if(!url_value_check) {
		alert("포스팅 URL은 1건 이상 등록이 필요합니다.");
		return;
	}
    
	<? if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){ ?>
	var check =	theform.hero_agree.checked;
	if(!check){
		alert("콘텐츠 활용에 동의해야 미션 신청이 가능합니다");
    	theform.hero_agree.focus();
        return false;				
	}
	<? }?>

    //선택된 카테고리를 hero_03에도 할당, 전체 공지를 선택했을 경우는 그대로 유지
    if(hero_table.value!='hero'){
    	hero_03.value=hero_table.value;
    }
   	hero_table.disabled =false;

   	if(!confirm('공정위문구를 필수로 기재 부탁드립니다.')) return false; 

   	theform.action = "mission_write_proc.php?action=<?=$action?>&board=<?=$board;?>&idx=<?=$mission_idx?>&hero_idx=<?=$hero_idx;?>&pre_board=<?=$pre_board?>";

    theform.submit();
    return false;
}
</script>
<!--컨텐츠 종료-->
<?
include_once "tail.php";
?>