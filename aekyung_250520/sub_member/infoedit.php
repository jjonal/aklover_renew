<link rel="stylesheet" type="text/css" href="/css/front/member.css">
<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION['temp_code']){
	error_location("잘못된 접근입니다.","/main/index.php?board=idcheck");
	exit;
}

if($_GET["sns"] != "snsAuth") {//20201207 sns 연동때문에 추가
	if(!strpos($_SERVER["HTTP_REFERER"],'/main/index.php?board=infoauth_check') && !strpos($_SERVER["HTTP_REFERER"],'/main/index.php?board=update')) {
		
		location("/main/index.php?board=infoauth");
		exit;
	}
}

$board = $_GET['board'];

$error = "INFOEDIT_01";
$right_sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$board."'";//desc
$right_res = new_sql($right_sql,$error,"on");
if((string)$right_res==$error){
	error_historyBack("");
	exit;
}

$right_list = mysql_fetch_assoc($right_res);

$error = "INFOEDIT_02";
$member_sql  = " SELECT m.hero_idx, m.hero_code, m.hero_id, m.hero_name, m.hero_nick ";
$member_sql .= " , m.hero_kakaoTalk, m.hero_naver, m.hero_google, m.hero_jumin , m.hero_hp ";
$member_sql .= " , m.hero_mail ,m.hero_address_01, m.hero_address_02, m.hero_address_03, m.area ";
$member_sql .= " , m.area_etc_text, m.hero_activity, m.hero_chk_phone, m.hero_chk_email ";
$member_sql .= " , m.hero_blog_00, m.hero_blog_04, m.hero_blog_03, m.hero_blog_05 ";
$member_sql .= " , m.hero_blog_06, m.hero_blog_07, m.hero_blog_08, m.hero_naver_influencer, m.hero_naver_influencer_name, m.hero_naver_influencer_category, m.hero_profile ";
$member_sql .= " , q.hero_code AS qs_hero_code , q.hero_qs_01, q.hero_qs_02, q.hero_qs_03, q.hero_qs_04  ";
$member_sql .= " , q.hero_qs_05, q.hero_qs_06, q.hero_qs_07, q.hero_qs_08, q.hero_give_point_today, q.hero_gift_point  ";
$member_sql .= " , q.hero_qs_18, q.hero_qs_19, q.hero_qs_20, q.hero_qs_21, q.hero_qs_22, q.hero_qs_23  ";
$member_sql .= " FROM member m LEFT JOIN member_question q ON m.hero_code = q.hero_code AND q.hero_pid = '4' ";
$member_sql .= " WHERE m.hero_code='".$_SESSION['temp_code']."' AND m.hero_use = 0 ";

$member_res = new_sql($member_sql,$error);
if((string)$member_res==$error){
	error_historyBack("");
	exit;
}

$member_list = mysql_fetch_assoc($member_res);
//프로필
if(empty($member_list['hero_profile'])){
    $hero_profile = "/img/front/mypage/defalt.webp";
}else {
    $hero_profile = $member_list['hero_profile'];
}

$hero_mail = explode('@', $member_list['hero_mail']);
$today = date("Y");

$alertScriptAll = "<script>alert('추가정보를 모두 입력하시면 30포인트를 드립니다.');</script>";
$alertScriptModi = "<script>alert('추가정보를 수정(모두기입)하시면 30포인트를 드립니다.');</script>";

if($member_list['qs_hero_code'] == ""){//추가기입있는지 확인
	echo $alertScriptAll;
	$question_point_yn ="Y";
} else if($member_list["hero_gift_point"] == 0) {//추가 기입은 했지만 완벽하게 작성이 안되서 포인트 지급이 안되는 경우
	echo $alertScriptAll;
	$question_point_yn ="Y";
} else if(substr($member_list['hero_give_point_today'],0,4) != $today){ //1년 주기 체크
	echo $alertScriptModi;
	$question_point_yn ="Y";
}

$area_disabled = "disabled";
$area_etc_text = "";
if($member_list["area"] == "기타") {
	$area_disabled = "";
	$area_etc_text = $member_list["area_etc_text"];
}

$hero_qs_01_disabled = "disabled";
$hero_blog_00 = ""; //네이버 블로그
$hero_blog_04 = ""; //인스타
$hero_blog_03 = "";
$hero_blog_05 = "";
$hero_blog_06 = "";
$hero_blog_07 = "";
$hero_blog_08 = "";
$hero_naver_influencer = "";
$hero_naver_influencer_name = "";
$hero_naver_influencer_category = "";
if($member_list["hero_qs_01"] == "Y") { //개인  SNS URL
	$hero_qs_01_disabled = "";
	$hero_blog_00 = str_replace("https://blog.naver.com/", "", $member_list["hero_blog_00"]);
	$hero_blog_04 = str_replace("https://www.instagram.com/", "", $member_list["hero_blog_04"]);
	$hero_blog_03 = $member_list["hero_blog_03"];
	$hero_blog_05 = $member_list["hero_blog_05"];
	$hero_blog_06 = $member_list["hero_blog_06"];
	$hero_blog_07 = $member_list["hero_blog_07"];
	$hero_blog_08 = $member_list["hero_blog_08"];
	$hero_naver_influencer = str_replace("https://in.naver.com/", "", $member_list["hero_naver_influencer"]);
	$hero_naver_influencer_name = $member_list["hero_naver_influencer_name"];
	$hero_naver_influencer_category = $member_list["hero_naver_influencer_category"];
}

$hero_qs_03_block = "style='display:none';";
$hero_qs_04 = "";
$hero_qs_05_arr = "";
if($member_list["hero_qs_03"] == "Y") { //자녀유무/태어난 년도
	$hero_qs_03_block = "style='display:block';";
	$hero_qs_04 = $member_list["hero_qs_04"];
	$hero_qs_05_arr = explode(",",$member_list["hero_qs_05"]);
}

$hero_qs_07_disabled = "disabled";
$hero_qs_08 = "";
if($member_list["hero_qs_07"] == "Y") { //활동하는 서포터즈/체험단 까페
	$hero_qs_07_disabled = "";
	$hero_qs_08 = $member_list["hero_qs_08"];
}

$hero_qs_22 = $member_list["hero_qs_22"];
$hero_qs_23 = $member_list["hero_qs_23"];
?>

<div id="subpage" class="mypage mu_member">
	<div class="sub_title">
		<div class="sub_wrap">
			<div class="f_b">
				<h1 class="fz68 main_c fw600">마이페이지</h1>			
			</div>		
			<? include_once BOARD_INC_END.'mypage_top.php';?>
		</div>
	</div>
	<div class="sub_cont replypage">
		<div class="sub_wrap board_wrap f_sb">
			<div class="left">
				<? include_once BOARD_INC_END.'mypage_nav.php';?>
			</div>
			<div class="contents right">
				<div class="page_title">
					<div class="page_tit fz32 fw600">나의 정보 변경</div>	
					<ul class="boardTabMenuWrap">
						<a href="/main/index.php?board=infoedit" class="on">정보 변경</a>
						<a href="/main/index.php?board=pwedit">비밀번호 변경</a>
						<a href="/main/index.php?board=without">회원탈퇴</a>
					</ul>     	       
				</div>
				<div id="infoEditSns">
					<form name="form_next" action="<?=PATH_HOME_HTTPS?>?board=update" enctype="multipart/form-data" method="post" onsubmit="return go_submit(this);">
						<input type="hidden" name="hero_idx" value="<?=$member_list['hero_idx']?>">
						<input type="hidden" name="hero_today_plus" value="<?=Ymdhis?>">
						<input type="hidden" name="hero_login_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
						<div class="info_wrap join_input sns_wrap">
							<div class="info_box default_info flex">
								<div class="box_tit fz15 op05">로그인 연동하기</div>
								<div class="cont f_cs">								
									<? if(!$member_list["hero_kakaoTalk"]) {?>
										<div class="info_sns fz16 fw600"><img src="/img/front/icon/edit_kakao.png" alt="카카오톡" onClick="loginKakao('infoedit')">카카오톡 로그인</div>
									<? } else { ?>
										<div class="info_sns fz16 fw600" style="opacity: .5;"><img src="/img/front/icon/edit_kakao.png"  alt="카카오톡" onClick="alert('카카오톡 계정과 이미 연동되었습니다.')"></div>
									<? } ?>
									<? if(!$member_list["hero_naver"]) {?>
										<div class="info_sns fz16 fw600 mu_bar f_c naver_wrap"><div id="naver_id_login"></div>네이버 로그인</div>
									<? } else { ?>
										<div class="info_sns fz16 fw600 mu_bar" style="opacity: .5;"><img src="/img/front/icon/edit_naver.png" alt="네이버" onClick="alert('네이버 계정과 이미 연동되었습니다.')"></div>
									<? } ?>
									<? if(!$member_list["hero_google"]) {?>
										<div class="info_sns mu_bar fz16 fw600" id="btn_google"><img src="/img/front/icon/edit_google.png" alt="구글 로그인">구글 로그인</div>
									<? } else { ?>
										<div class="info_sns fz16 fw600 mu_bar" style="opacity: .5;"><img src="/img/front/icon/edit_google.png" alt="구글" onClick="alert('구글 계정과 이미 연동되었습니다.')"></div>
									<? } ?>
								</div>			
							</div>			
						</div>
						<? if(!$member_list['hero_naver']) { ?>
						<script>
							var naver_id_login = new naver_id_login(naver.client_id,"<?=getSnsDomain()?>/main/index.php?sns=snsAuth&board=infoedit");
							var edit_access_token = naver_id_login.oauthParams.board.split("infoedit#access_token=");

							var naver_access_token = edit_access_token[1];

							naver_id_login.oauthParams.access_token = naver_access_token;

							if(!naver_access_token) {
							var state = naver_id_login.getUniqState();
								naver_id_login.setButton("green", 1,46);
								naver_id_login.setDomain("https://aklover.co.kr");
								naver_id_login.setState(state);
								naver_id_login.init_naver_id_login();
							}
							
							if(naver_access_token) {
								naver_id_login.get_naver_userprofile("naverSignInCallback()");
							}
							
							function naverSignInCallback() {
								where = "infoedit";
								snsType = "naver";
								//alert(naver_id_login.getProfileData('id'));
								var response = {"id":naver_id_login.getProfileData('id')};
								afterLogin.login(response);
								/*
								alert(naver_id_login.getProfileData('email'));
								alert(naver_id_login.getProfileData('nickname'));
								alert(naver_id_login.getProfileData('age'));
								*/
							}
						</script>
						<? } ?>
						<!-- <p class="member_alert"><span style="color:#f68428">*</span>는 필수 입력 항목입니다!!!</p> -->
						<div class="info_wrap join_input">
							<div class="info_box default_info flex">
								<div class="box_tit fz15 op05">기본 입력 정보</div>
								<div class="cont">
									<div class="box_line my_profile">
										<p class="tit fz15">*프로필 이미지</p>
										<div class="profile_img_wrap">
											<div class="profile_img rel">
												<input type="file" name="hero_profile" id="hero_profile" class="real-upload" accept="image/*">
												<div class="upload btn_upload"><img src="/img/front/mypage/upload_real.png" alt="프로필 업로드"></div>
												<div class="image-preview real-image-preview"><img src="<?=$hero_profile?>" alt="프로필"></div>
											</div>
										</div>
									</div>
									<div class="box_line">
										<p class="tit fz15">*아이디</p>
										<div class="fz15 fw500"><?=$member_list['hero_id']?></div>
									</div>
									<div class="box_line">
										<p class="tit fz15">*이름</p>
										<div class="fz15 fw500"><?=$member_list['hero_name']?></div>
									</div>
									<div class="box_line">
										<p class="tit fz15">*닉네임</p>
										<div class="fz15 fw500"><?=$member_list['hero_nick']?></div>
									</div>
									<div class="box_line">
										<p class="tit fz15">*생년월일</p>
										<div class="fz15 fw500"><?=substr($member_list['hero_jumin'], '0', '4');?>년 <?=substr($member_list['hero_jumin'], '4', '2');?>월 <?=substr($member_list['hero_jumin'], '6', '2');?>일</div>
									</div>								
									<div class="box_line">
										<p class="tit fz15">*이메일</p>
										<div class="fz15 fw500 f_cs mail_select">
											<input type="text" name="hero_mail_01" value="<?=$hero_mail['0'];?>" style="ime-mode:disabled; width: 17rem;"/> @
											<input type="text" name="hero_mail_02" id="hero_mail_02" value="<?=$hero_mail['1'];?>" style="ime-mode:disabled; width:17rem;"/>
											<select id="email_select" onchange='javascript:emailChg();' class="short">
												<option value="">직접입력</option>
												<option value="naver.com"<?if(!strcmp($hero_mail['1'], 'naver.com')){echo ' selected';}else{echo '';}?>>naver.com</option>
												<option value="hanmail.net"<?if(!strcmp($hero_mail['1'], 'hanmail.net')){echo ' selected';}else{echo '';}?>>hanmail.net</option>
												<option value="daum.net"<?if(!strcmp($hero_mail['1'], 'daum.net')){echo ' selected';}else{echo '';}?>>daum.net</option>
												<option value="gmail.com"<?if(!strcmp($hero_mail['1'], 'gmail.com')){echo ' selected';}else{echo '';}?>>gmail.com</option>
												<option value="hotmail.com"<?if(!strcmp($hero_mail['1'], 'hotmail.com')){echo ' selected';}else{echo '';}?>>hotmail.com</option>
												<option value="paran.com"<?if(!strcmp($hero_mail['1'], 'paran.com')){echo ' selected';}else{echo '';}?>>paran.com</option>
												<option value="nate.com"<?if(!strcmp($hero_mail['1'], 'nate.com')){echo ' selected';}else{echo '';}?>>nate.com</option>
											</select>
										</div>
									</div>		
									<?
										$next = str_ireplace('-', '', $member_list['hero_hp']);
										$next = str_ireplace('~', '', $next);
										$next = str_ireplace('_', '', $next);
										$next = str_ireplace('/', '', $next);
									?> 						
									<div class="box_line">
										<p class="tit fz15">*휴대폰번호</p>
										<div class="fz15 fw500 f_cs mail_select">
											<input type="text" name="hero_hp_01" id="hero_hp_01" value="<?=substr($next, '0', '3');?>" onKeyUp="if(this.value.length >= 3)hero_hp_02.focus();" maxlength="3" suOnly="true" class="short" />-
											<input type="text" name="hero_hp_02" id="hero_hp_02" value="<?=substr($next, '3', '4');?>" onKeyUp="if(this.value.length >= 4)hero_hp_03.focus();" maxlength="4" suOnly="true" class="short" />-
											<input type="text" name="hero_hp_03" id="hero_hp_03" value="<?=substr($next, '7', '4');?>" maxlength="4" suOnly="true" class="short" style="width:125px"/>
										</div>
									</div>									
									<div class="box_line">
										<p class="tit fz15">*주소</p>
										<div class="fz15 fw500">
											<div class="f_sc" style="align-items: flex-end;">
                                                <?
                                                $address01Readonly = '';
                                                $address02Readonly = '';
                                                $address03Readonly = '';
                                                if($member_list['hero_address_01'] != '') $address01Readonly = 'readonly';
                                                if($member_list['hero_address_02'] != '') $address02Readonly = 'readonly';
//                                                if($member_list['hero_address_03'] != '') $address03Readonly = 'readonly';
                                                ?>
												<input type="text" name="hero_address_01" id="hero_address_01" value="<?=$member_list['hero_address_01']?>" class="short" <?=$address01Readonly?>/>
												<a href="javascript:btnAddressGet()" class="btn_post fz16 fw500">우편번호</a>
											</div>
											<input type="text" name="hero_address_02" id="hero_address_02" value="<?=$member_list['hero_address_02']?>" class="" <?=$address02Readonly?> style="width: 37rem; margin-top:1px;"/><br />
											<input type="text" name="hero_address_03" id="hero_address_03" value="<?=$member_list['hero_address_03']?>" class="" <?=$address03Readonly?> style="width: 37rem; margin-top:1px;" />
										</div>
									</div>	
								</div>
							</div>	
						</div>						
						<div class="info_wrap join_input">
							<div class="info_box choice_info">
								<div class="box_tit fz15 op05">선택 입력 정보</div>
								<div class="choice">
									<div class="div_tr">
										<p class="tit">AK Lover를 알게된 경로는?</p>
										<div class="div_td">
											<ul>
												<li><p class="input_radio"><input type="radio" name="area" id="area1" value="블로그" <?=$member_list["area"]=="블로그" ? "checked":"";?>/><label for="area1" class="input_chk_label">네이버 블로그</label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area2" value="인스타그램" <?=$member_list["area"]=="인스타그램" ? "checked":"";?>/><label for="area2" class="input_chk_label">인스타그램 (후기 게시글, 인스타그램 스폰서 광고 등)</label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area3" value="영상" <?=$member_list["area"]=="영상" ? "checked":"";?>/><label for="area3" class="input_chk_label">유튜브 (후기 영상, 영상광고 등)</label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area4" value="숏폼콘텐츠" <?=$member_list["area"]=="숏폼콘텐츠" ? "checked":"";?>/><label for="area4" class="input_chk_label">숏폼 콘텐츠 (릴스, 숏츠, 틱톡 등) </label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area5" value="까페" <?=$member_list["area"]=="까페" ? "checked":"";?>/><label for="area5" class="input_chk_label">카페 (카페 배너, 게시글 이벤트 등) </label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area6" value="대외활동홈페이지" <?=$member_list["area"]=="대외활동홈페이지" ? "checked":"";?>/><label for="area6" class="input_chk_label">대외활동 홈페이지 (에브리타임, 캠퍼스픽 등) </label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area7" value="쪽지/메일/DM" <?=$member_list["area"]=="쪽지/메일/DM" || $member_list["area"]=="쪽지/메일" || $member_list["area"]=="쪽지" ? "checked":"";?>/><label for="area7" class="input_chk_label">네이버 쪽지/인스타 DM/메일</label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area8" value="카카오톡오픈채팅방" <?=$member_list["area"]=="카카오톡오픈채팅방" ? "checked":"";?>/><label for="area8" class="input_chk_label">카카오톡 오픈 채팅방</label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area9" value="지인추천" <?=$member_list["area"]=="지인" || $member_list["area"]=="지인추천" ? "checked":"";?>/><label for="area9" class="input_chk_label">지인추천</label></li>
												<li><p class="input_radio wid100"><input type="radio" name="area" id="area10" value="기타" <?=$member_list["area"]=="기타" ? "checked":"";?>/><label for="area10" class="input_chk_label">기타</label><input type="text" name="area_etc_text" class="w390" maxlength="50" style="margin-left:5px;" value="<?=$area_etc_text;?>" <?=$area_disabled?>/></li>
											</ul>
										</div>
									</div>
									<!--!!!!!!!! [개발요청] 기존에 없던 항목입니다 [완]!!!!!!!!  -->
									<div class="div_tr">
										<p class="tit">관심있는 활동</p>
										<div class="div_td">
											<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity2" value="HUT 및 설문조사" <?=$member_list["hero_activity"]=="HUT 및 설문조사" ? "checked":"";?>/><label for="activity2" class="input_chk_label">HUT 및 설문조사</label></p></li>
											<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity3" value="프리미어 서포터즈" <?=$member_list["hero_activity"]=="프리미어 서포터즈" ? "checked":"";?>/><label for="activity3" class="input_chk_label">프리미어 서포터즈</label></p></li>
											<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity4" value="포인트 축제" <?=$member_list["hero_activity"]=="포인트 축제" ? "checked":"";?>/><label for="activity4" class="input_chk_label">포인트 페스티벌</label></p></li>
											<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity1" value="제품 체혐단" <?=$member_list["hero_activity"]=="제품 체혐단" ? "checked":"";?>/><label for="activity1" class="input_chk_label">제품 체험단</label></p></li>
											<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity5" value="이벤트" <?=$member_list["hero_activity"]=="이벤트" ? "checked":"";?>/><label for="activity5" class="input_chk_label">이벤트</label></p></li>
										</div>
									</div>
									<!--!!!!!!!! ///////////END///////// !!!!!!!!  -->
									<div class="div_tr">
										<p class="tit">수신동의</p>
										<div class="div_td">
											<div class="input_chk"><input type="checkbox" name="hero_chk_phone" id="hero_chk_phone" value="1" <?=$member_list["hero_chk_phone"]=="1" ? "checked":"";?>/> <label for="hero_chk_phone" class="input_chk_label">휴대폰번호</label></div>
											<div class="input_chk" style="margin-top: 1.8rem;"><input type="checkbox" name="hero_chk_email" id="hero_chk_email" value="1" <?=$member_list["hero_chk_email"]=="1" ? "checked":"";?>/> <label for="hero_chk_email" class="input_chk_label">이메일</label></div>
											<span class="txt_emphasis">※ 체크박스 선택 시 ‘수신동의＇입니다.</span>
										</div>
									</div>
									<p class="txt_default">각종 이벤트, 체험단, 행사 관련 정보 안내 및 제반 마케팅 활동, 당사 상품/서비스 안내 및 권유</p>
									<div class="div_tr">
										<p class="tit">개인 SNS URL</p>
										<div class="div_td">
											<div>
												<p class="input_radio"><input type="radio" name="hero_qs_01" id="hero_qs_01_Y" value="Y" <?=$member_list["hero_qs_01"]=="Y" ? "checked":"";?>/><label for="hero_qs_01_Y">있음</label></p>
											</div>
											<div style="margin-top: 2rem">
												<p class="input_radio"><input type="radio" name="hero_qs_01" id="hero_qs_01_N" value="N" <?=$member_list["hero_qs_01"]=="N" ? "checked":"";?>/><label for="hero_qs_01_N">없음</label></p>
											</div>
											<div class="snsUrl etc_info">
												<dl>
													<dd>
														<label for="hero_blog_00">네이버 블로그</label>
														<label for="hero_blog_00">https://blog.naver.com/</label>
														<input type="text" maxlength="25" name="hero_blog_00" id="hero_blog_00" class="hero_sns_url" placeholder="네이버 ID 또는 블로그 ID" value="<?=$hero_blog_00;?>" <?=$hero_qs_01_disabled?>/>
													</dd>
													<dd>
														<label for="hero_blog_04">인스타그램</label>
														<label for="hero_blog_04">https://www.instagram.com/</label>
														<input type="text" maxlength="25" name="hero_blog_04" id="hero_blog_04" class="hero_sns_url" placeholder="인스타그램 ID" value="<?=$hero_blog_04;?>" <?=$hero_qs_01_disabled?>/>
													</dd>
													<dd>
														<label for="hero_naver_influencer">네이버 인플루언서 홈</label>
														<label for="hero_naver_influencer">https://in.naver.com/</label>
														<input type="text" maxlength="25" name="hero_naver_influencer" id="hero_naver_influencer" class="hero_sns_url" placeholder="네이버 인플루언서 ID" value="<?=$hero_naver_influencer;?>" <?=$hero_qs_01_disabled?>/>
													</dd>
													<dd>
														<label for="hero_naver_influencer_name">네이버 인플루언서 명</label>
														<div class="f_b" style="gap: 1.1rem;">
															<input type="text" id="hero_naver_influencer_name" name="hero_naver_influencer_name" placeholder="인플루언서 닉네임" class="hero_sns_url" style="flex: 1;" value="<?=$hero_naver_influencer_name;?>" <?=$hero_qs_01_disabled?>/>
															<label for="hero_naver_influencer_category" class="dis-no">활동 카테고리</label>
															<select id="hero_naver_influencer_category" name="hero_naver_influencer_category" class="hero_sns_url select" style="flex: 1;" <?=$hero_qs_01_disabled?>>
																<option value=""<?if(!strcmp($hero_naver_influencer_category, '')){echo ' selected';}else{echo '';}?>>활동 카테고리</option>
																<option value="여행"<?if(!strcmp($hero_naver_influencer_category, '여행')){echo ' selected';}else{echo '';}?>>여행</option>
																<option value="패션"<?if(!strcmp($hero_naver_influencer_category, '패션')){echo ' selected';}else{echo '';}?>>패션</option>
																<option value="뷰티"<?if(!strcmp($hero_naver_influencer_category, '뷰티')){echo ' selected';}else{echo '';}?>>뷰티</option>
																<option value="푸드"<?if(!strcmp($hero_naver_influencer_category, '푸드')){echo ' selected';}else{echo '';}?>>푸드</option>
																<option value="IT테크"<?if(!strcmp($hero_naver_influencer_category, 'IT테크')){echo ' selected';}else{echo '';}?>>IT테크</option>
																<option value="자동차"<?if(!strcmp($hero_naver_influencer_category, '자동차')){echo ' selected';}else{echo '';}?>>자동차</option>
																<option value="리빙"<?if(!strcmp($hero_naver_influencer_category, '리빙')){echo ' selected';}else{echo '';}?>>리빙</option>
																<option value="육아"<?if(!strcmp($hero_naver_influencer_category, '육아')){echo ' selected';}else{echo '';}?>>육아</option>
																<option value="생활건강"<?if(!strcmp($hero_naver_influencer_category, '생활건강')){echo ' selected';}else{echo '';}?>>생활건강</option>
																<option value="게임"<?if(!strcmp($hero_naver_influencer_category, '게임')){echo ' selected';}else{echo '';}?>>게임</option>
																<option value="동물/펫"<?if(!strcmp($hero_naver_influencer_category, '동물/펫')){echo ' selected';}else{echo '';}?>>동물/펫</option>
																<option value="운동/레저"<?if(!strcmp($hero_naver_influencer_category, '운동/레저')){echo ' selected';}else{echo '';}?>>운동/레저</option>
																<option value="프로스포츠"<?if(!strcmp($hero_naver_influencer_category, '프로스포츠')){echo ' selected';}else{echo '';}?>>프로스포츠</option>
																<option value="방송/연예"<?if(!strcmp($hero_naver_influencer_category, '방송/연예')){echo ' selected';}else{echo '';}?>>방송/연예</option>
																<option value="대중음악"<?if(!strcmp($hero_naver_influencer_category, '대중음악')){echo ' selected';}else{echo '';}?>>대중음악</option>
																<option value="영화"<?if(!strcmp($hero_naver_influencer_category, '영화')){echo ' selected';}else{echo '';}?>>영화</option>
																<option value="공연/전시/예술"<?if(!strcmp($hero_naver_influencer_category, '공연/전시/예술')){echo ' selected';}else{echo '';}?>>공연/전시/예술</option>
																<option value="도서"<?if(!strcmp($hero_influencer_category, '도서')){echo ' selected';}else{echo '';}?>>도서</option>
																<option value="경제/비즈니스"<?if(!strcmp($hero_naver_influencer_category, '경제/비즈니스')){echo ' selected';}else{echo '';}?>>경제/비즈니스</option>
																<option value="어학/교육"<?if(!strcmp($hero_naver_influencer_category, '어학/교육')){echo ' selected';}else{echo '';}?>>어학/교육</option>
														</select>
														</div>
													</dd>
												</dl>												
												<dl>
													<dd><label for="hero_blog_03">유튜브</label><input type="text" name="hero_blog_03" id="hero_blog_03" placeholder="URL을 입력해주세요" class="hero_sns_url" value="<?=$hero_blog_03;?>" <?=$hero_qs_01_disabled?>/></dd>
													<dd><label for="hero_blog_06">네이버 TV</label><input type="text" name="hero_blog_06" id="hero_blog_06" placeholder="URL을 입력해주세요" class="hero_sns_url" value="<?=$hero_blog_06;?>" <?=$hero_qs_01_disabled?>/></dd>
													<dd><label for="hero_blog_07">틱톡</label><input type="text" name="hero_blog_07" id="hero_blog_07" placeholder="URL을 입력해주세요" class="hero_sns_url" value="<?=$hero_blog_07;?>" <?=$hero_qs_01_disabled?>/></dd>
													<dd style="margin-bottom: 0;">
														<label for="hero_blog_05">그 외 SNS URL</label>
														<input type="text" name="hero_blog_05" id="hero_blog_05" class="hero_sns_url" placeholder="URL을 입력해주세요" value="<?=$hero_blog_05;?>" <?=$hero_qs_01_disabled?>/>
													</dd>
												</dl>
											</div>
										</div>
									</div>
									<p class="txt_default">AK Lover는 체험단 활동을 위해서는 개인 SNS URL 입력이 필요합니다.</p>
									<div class="div_tr">
										<p class="tit">개인 정보</p>
										<div class="div_td etc_info">
											<!-- <dl>
												<dd>
													<label for="hero_qs_22">피부타입</label>
													<select id="hero_qs_22" name="hero_qs_22" class="hero_sns_url select">
														<option value=""<?if(!strcmp($hero_qs_22, '')){echo ' selected';}else{echo '';}?>>선택</option>
														<option value="건성"<?if(!strcmp($hero_qs_22, '건성')){echo ' selected';}else{echo '';}?>>건성</option>
														<option value="중성"<?if(!strcmp($hero_qs_22, '중성')){echo ' selected';}else{echo '';}?>>중성</option>
														<option value="지성"<?if(!strcmp($hero_qs_22, '지성')){echo ' selected';}else{echo '';}?>>지성</option>
														<option value="복합성"<?if(!strcmp($hero_qs_22, '복합성')){echo ' selected';}else{echo '';}?>>복합성</option>
														<option value="민감성"<?if(!strcmp($hero_qs_22, '민감성')){echo ' selected';}else{echo '';}?>>민감성</option>
													</select>	
												</dd>
											</dl>
											<dl>
												<dd>
													<label for="hero_qs_23">두피타입</label>
													<select id="hero_qs_23" name="hero_qs_23" class="hero_sns_url select">
														<option value=""<?if(!strcmp($hero_qs_23, '')){echo ' selected';}else{echo '';}?>>선택</option>
														<option value="건성"<?if(!strcmp($hero_qs_23, '건성')){echo ' selected';}else{echo '';}?>>건성</option>
														<option value="중성"<?if(!strcmp($hero_qs_23, '중성')){echo ' selected';}else{echo '';}?>>중성</option>
														<option value="지성"<?if(!strcmp($hero_qs_23, '지성')){echo ' selected';}else{echo '';}?>>지성</option>
														<option value="민감성"<?if(!strcmp($hero_qs_23, '민감성')){echo ' selected';}else{echo '';}?>>민감성</option>
													</select>
												</dd>
											</dl> -->
											<dl>
												<dd>
													<label for="hero_qs_02">결혼 유무</label>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_02" id="hero_qs_02_N" value="N" <?=$member_list["hero_qs_02"]=="N" ? "checked":"";?>/><label for="hero_qs_02_N">미혼</label></div>
													</div>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_02" id="hero_qs_02_Y" value="Y" <?=$member_list["hero_qs_02"]=="Y" ? "checked":"";?>/><label for="hero_qs_02_Y">기혼</label></div>						
													</div>
												</dd>
											</dl>	
											<dl>
												<dd>
													<label for="hero_qs_03">자녀 유무/태어난 년도</label>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_03" id="hero_qs_03_N" value="N" <?=$member_list["hero_qs_03"]=="N" ? "checked":"";?>/><label for="hero_qs_03_N">없음</label></div>
													</div>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_03" id="hero_qs_03_Y" value="Y" <?=$member_list["hero_qs_03"]=="Y" ? "checked":"";?>/><label for="hero_qs_03_Y">있음</label></div>
													</div>
													<div class="children" <?=$hero_qs_03_block?>>
														<ul>
															<li>
																<div class="input_radio"><input type="radio" name="hero_qs_04" id="hero_qs_04_1" value="1" <?=$hero_qs_04=="1" ? "checked":""?>/><label for="hero_qs_04_1">1명</label></div>
																<select name="hero_qs_05[]" class="hero_sns_url select">
																	<option value="">선택</option>
																	<? for($i=date("Y"); $i > 1921; $i--) {?>
																	<option value="<?=$i?>" <?=$hero_qs_05_arr[0]==$i ? "selected":""?>><?=$i?></option>
																	<? } ?>
																</select>
															</li>
															<li>
																<div class="input_radio"><input type="radio" value="2" name="hero_qs_04" id="hero_qs_04_2" <?=$hero_qs_04=="2" ? "checked":""?>/><label for="hero_qs_04_2">2명</label></div>
																<select name="hero_qs_05[]" class="hero_sns_url select">
																	<option value="">선택</option>
																	<? for($i=date("Y"); $i > 1921; $i--) {?>
																	<option value="<?=$i?>" <?=$hero_qs_05_arr[1]==$i ? "selected":""?>><?=$i?></option>
																	<? } ?>
																</select>
															</li>
															<li>
																<div class="input_radio"><input type="radio" name="hero_qs_04"  id="hero_qs_04_3" value="3" <?=$hero_qs_04=="3" ? "checked":""?>/><label for="hero_qs_04_3">3명</label></div>
																<select name="hero_qs_05[]" class="hero_sns_url select">
																	<option value="">선택</option>
																	<? for($i=date("Y"); $i > 1921; $i--) {?>
																	<option value="<?=$i?>" <?=$hero_qs_05_arr[2]==$i ? "selected":""?>><?=$i?></option>
																	<? } ?>
																</select>
															</li>
															<li>
																<div class="input_radio"><input type="radio" name="hero_qs_04" id="hero_qs_04_4" value="4" <?=$hero_qs_04=="4" ? "checked":""?>/><label for="hero_qs_04_4">4명</label></div>
																<select name="hero_qs_05[]" class="hero_sns_url select">
																	<option value="">선택</option>
																	<? for($i=date("Y"); $i > 1921; $i--) {?>
																	<option value="<?=$i?>" <?=$hero_qs_05_arr[3]==$i ? "selected":""?>><?=$i?></option>
																	<? } ?>
																</select>
															</li>
															<li>
																<div class="input_radio"><input type="radio" name="hero_qs_04" id="hero_qs_04_5" value="5" <?=$hero_qs_04=="5" ? "checked":""?>/><label for="hero_qs_04_5">5명</label></div>
																<select name="hero_qs_05[]" class="hero_sns_url select">
																	<option value="">선택</option>
																	<? for($i=date("Y"); $i > 1921; $i--) {?>
																	<option value="<?=$i?>" <?=$hero_qs_05_arr[4]==$i ? "selected":""?>><?=$i?></option>
																	<? } ?>
																</select>
															</li>
														</ul>
													</div>
												</dd>
											</dl>	
											<dl>
												<dd>
													<label for="hero_qs_19">반려동물 유무</label>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_19" id="hero_qs_19_N" value="N" <?=$member_list["hero_qs_19"]=="N" ? "checked":"";?>/><label for="hero_qs_19_N">없음</label></div>
													</div>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_19" id="hero_qs_19_Y" value="Y" <?=$member_list["hero_qs_19"]=="Y" ? "checked":"";?>/><label for="hero_qs_19_Y">있음</label></div>						
													</div>
												</dd>
											</dl>	
											<dl>
												<dd>
													<label for="hero_qs_20">건조기 유무</label>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_20" id="hero_qs_20_N" value="N" <?=$member_list["hero_qs_20"]=="N" ? "checked":"";?>/><label for="hero_qs_20_N">없음</label></div>
													</div>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_20" id="hero_qs_20_Y" value="Y" <?=$member_list["hero_qs_20"]=="Y" ? "checked":"";?>/><label for="hero_qs_20_Y">있음</label></div>						
													</div>
												</dd>
											</dl>	
											<dl>
												<dd>
													<label for="hero_qs_21">식기세척기 유무</label>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_21" id="hero_qs_21_N" value="N" <?=$member_list["hero_qs_21"]=="N" ? "checked":"";?>/><label for="hero_qs_21_N">없음</label></div>
													</div>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_21" id="hero_qs_21_Y" value="Y" <?=$member_list["hero_qs_21"]=="Y" ? "checked":"";?>/><label for="hero_qs_21_Y">있음</label></div>						
													</div>
												</dd>
											</dl>	
											<dl>
												<dd>
													<label for="hero_qs_21">AK Lover에 가입한 이유</label>
													<input type="text" name="hero_qs_06" class="w550" value="<?=$member_list["hero_qs_06"]?>" />
												</dd>
											</dl>
											<dl>
												<dd style="margin-bottom: 0;">
													<label for="hero_qs_21">AK Lover 외 활동</label>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_07" id="hero_qs_07_N" value="N" <?=$member_list["hero_qs_07"]=="N" ? "checked":"";?>/><label for="hero_qs_07_N">없음</label></div>
													</div>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_07" id="hero_qs_07_Y" value="Y" <?=$member_list["hero_qs_07"]=="Y" ? "checked":"";?>/><label for="hero_qs_07_Y">있음</label></div>			
													</div>
													<input type="text" name="hero_qs_08" class="w390" value="<?=$hero_qs_08?>" <?=$hero_qs_07_disabled?>/>			
												</dd>
											</dl>															
										</div>										
									</div>
									<div class="input_chk txt_default agree_chk_box">
										<input type="checkbox" id="agree_chk" name="agree">
										<label for="agree_chk" class="input_chk_label">개인정보 수집·이용동의 선택항목</label>
									</div>										
									<p class="txt_default">AK Lover는 체험단 활동을 위해서는 개인정보 입력이 필요합니다.</p>		
								</div>	
							</div>						
							<div class="btngroup tc" >
								<a href="javascript:;" class="btn_submit btn_black" onClick="go_submit(document.form_next)">정보 수정 하기</a>
							</div>
						</div>						
					</form>
				</div>
				<!-- //TODO 용도 확인 필요 210414 -->
				<form id="infoEditForm" >
					<input type="hidden" name="snsId">
					<input type="hidden" name="snsType">
				</form>    
			</div>
		</div>
	</div>
</div>


<script src="https://apis.google.com/js/api:client.js"></script>
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(document).on("keyup", "input:text[suOnly]", function() {$(this).val( $(this).val().replace(/[^0-9]/gi,"") );});
});

// 개인정부 수집, 이용둉의 선택항목 체크
const chkbox = document.querySelector("#agree_chk");
let status = false;

chkbox.addEventListener("change",function(){
	if(chkbox.checked){
		status = true;
	} else {
		status = false;
	}
});

//(s)210203 google 연동
var googleUser = {};
var startApp = function() {
  gapi.load('auth2', function(){
    // Retrieve the singleton for the GoogleAuth library and set up the client.
    auth2 = gapi.auth2.init({
      client_id: '7087940352-ce573qthsm2s4s806bp9c82k3fnoid1n.apps.googleusercontent.com',
      //cookiepolicy: 'http://localhost',
      cookiepolicy: '//www.aklover.co.kr',
    });
    attachSignin(document.getElementById('btn_google'));
  });
};

function attachSignin(element) {
  auth2.attachClickHandler(element, {},
      function(googleUser) {
		var where = "infoedit";
      	var url="zip_sns.php";
		var params = "snsId="+googleUser.getBasicProfile().getId()+"&snsType=google&snsWhere="+where;
  	    $.ajax({      
  	        type:"POST",  
  	        url:url,      
  	        data:params,
  	        async : false,
  	        success:function(args){
  	        	snsResult = args;
  	        	$(".img-loading").css("display","none");
  	        },complete:function(){
      	       	$('.img-loading').css('display','none'); 
		    },error:function(e){  
  	            alert("SNS 연동 에러입니다. 다시 시도해주세요");
  	            location.reload();  
  	        }
  	    });

  	    if(snsResult==1){
  	    	location.href="/main/index.php?sns=snsAuth&board="+where;
		}else if(snsResult.substring(0,7)=='message'){
			alert(snsResult.substring(8));
			location.href="/main/index.php?sns=snsAuth&board="+where;
		}else{
			alert("시스템 오류입니다. 다시 시도해주세요.");
			location.href="/main/index.php?sns=snsAuth&board="+where;
		}
	    
      }, function(error) {
        //alert(JSON.stringify(error, undefined, 2));
        console.log(JSON.stringify(error, undefined, 2));
      });
}

startApp();
// (e)210203 google 연동

$("input[name=area]").on("click",function(){
	if($(this).val()=="기타") {
		$("input[name=area_etc_text").attr("disabled",false);
		$("input[name=area_etc_text").focus();
	} else {
		$("input[name=area_etc_text").val("");
		$("input[name=area_etc_text").attr("disabled",true);
	}
})

$("input:radio[name='hero_qs_01']").on("click",function(){ //블로그 있다,없다
	if($(this).val() == "Y") {
		$(".hero_sns_url").attr("disabled",false);
		$(".hero_sns_type").attr("disabled",false);
	} else {
		$(".hero_sns_url").val("");
		$(".hero_sns_url").attr("disabled",true);
		$(".hero_sns_type").val("");
		$(".hero_sns_type").attr("disabled",true);
	}
})

$("input:radio[name='hero_qs_03']").on("click",function(){
	if($(this).val() == "Y") {
		$(".children").show();
	} else {
		$(".children").hide();
		$("input:radio[name='hero_qs_04']").attr("checked",false);
		$("select[name='hero_qs_05[]']").val("");
	}
})

$("input:radio[name='hero_qs_07']").on("click",function(){
	if($(this).val() == "Y") {
		$("input[name='hero_qs_08']").attr("disabled",false);
	} else {
		$("input[name='hero_qs_08']").val("");
		$("input[name='hero_qs_08']").attr("disabled",true);
	}
})

function emailChg(){
	if(form_next.email_select.value != "")  $('#hero_mail_02').attr('readonly', true);
	else $('#hero_mail_02').attr('readonly', false);
    form_next.hero_mail_02.value = form_next.email_select.value;

}
        
function onlyNumber(event) {
    var key = window.event ? event.keyCode : event.which;    

    if ((event.shiftKey == false) && ((key  > 47 && key  < 58) || (key  > 95 && key  < 106)
    || key  == 35 || key  == 36 || key  == 37 || key  == 39  // 방향키 좌우,home,end  
    || key  == 8  || key  == 46 ) // del, back space
    ) {
        return true;
    }else {
        return false;
    }    
};


// 기본정보 수정
function default_submit(form) {
    var mail_01 = form.hero_mail_01;
    var mail_02 = form.hero_mail_02;
    var hp_01 = form.hero_hp_01;
    var hp_02 = form.hero_hp_02;
    var hp_03 = form.hero_hp_03;
    var address_01 = form.hero_address_01;
    var address_02 = form.hero_address_02;
    var address_03 = form.hero_address_03;
            
    if(mail_01.value == ""){
        alert("이메일(1)을 입력하세요.");
        mail_01.style.borderBottom = '1px solid red';
        mail_01.focus();
        return false;
    }
    if(mail_02.value == ""){
        alert("이메일(2)을 선택하세요.");
        mail_02.style.borderBottom = '1px solid red';
        mail_02.focus();
        return false;
    }

    if(hp_01.value == ""){
        alert("휴대폰번호(1)를 입력하세요.");
        hp_01.style.borderBottom = '1px solid red';
        hp_01.focus();
        return false;
    }
    if(hp_02.value == ""){
        alert("휴대폰번호(2)를 입력하세요.");
        hp_02.style.borderBottom = '1px solid red';
        hp_02.focus();
        return false;
    }
    if(hp_03.value == ""){
        alert("휴대폰번호(3)를 입력하세요.");
        hp_03.style.borderBottom = '1px solid red';
        hp_03.focus();
        return false;
    }

    if(address_01.value == ""){
        alert("우편번호를 입력하세요.");
        address_01.style.borderBottom = '1px solid red';
        address_01.focus();
        return false;
    }
    if(address_02.value == ""){
        alert("주소를 입력하세요.");
        address_02.style.borderBottom = '1px solid red';
        address_02.focus();
        return false;
    }
    if(address_03.value == ""){
        alert("나머지주소를 입력하세요.");
        address_03.style.borderBottom = '1px solid red';
        address_03.focus();
        return false;
    }

    form.submit();
    return true;
}		

// 추가정보 수정
function go_submit(form) {
   
    var blog_00 = form.hero_blog_00;
    var qs_08 = form.hero_qs_08;
    var area_etc_text = form.area_etc_text;

    if($("input:radio[name='area']:checked").val() == "기타") {
		if(!$("input[name='area_etc_text']").val()) {
			alert("AK Lover를 알게된 경로 기타 선택 시 내용을 입력해 주세요.");
			$("input[name='area_etc_text']").focus();
			$("input[name='area_etc_text']").css("border","1px solid #f00");
			return;
		}
	}

    var hero_sns_url_check = true;
	if($("input:radio[name='hero_qs_01']:checked").val() == "Y") {
		hero_sns_url_check = false;
		$(".hero_sns_url").each(function(i){
			if($(this).val()) {
				hero_sns_url_check = true;
			}
		})
		
		if(form.hero_naver_influencer.value!='') {
    		if(form.hero_naver_influencer_name.value=='') {
    			alert("인플루언스명 입력이 필요합니다.");
    			$("#hero_naver_influencer_name").css("border","1px solid #f00");
				$("#hero_naver_influencer_name").focus();
    			return false;
    		} else {
    			if(form.hero_naver_influencer_category.value=='') {
    				alert("인플루언스 카테고리 선택이 필요합니다.");
    				return false;
    			}
    		}
    	} else {
    		form.hero_naver_influencer_name.value = '';
    		form.hero_naver_influencer_category.value = '';
    		
    		hero_sns_url_check = false;
    		$(".hero_sns_url").each(function(i){
    			if($(this).val()) {
    				hero_sns_url_check = true;
    			}
    		})
    	}
	}	

	if(!hero_sns_url_check) {
		alert("개인 SNS URL 있다 라고 선택 시 최소 1개의 개인 SNS URL 입력이 필요합니다.");
		$("#hero_blog_00").css("border","1px solid #f00");
		$("#hero_blog_00").focus();
		return false;
	}

	if($("input:radio[name='hero_qs_03']:checked").val() == "Y") {
		if(!$("input:radio[name='hero_qs_04']").is(":checked")) {
			alert("자녀수를 선택해 주세요.");
			return false;
		}
		var hero_qs_05_check = 0;
		var k = 0;
		$("select[name='hero_qs_05[]']").each(function(i){
			if($(this).val()) {
				k++;
			}
		})

		if($("input:radio[name='hero_qs_04']:checked").val() != k) {
			alert("선택한 자녀의 태어난 년도를 선택해 주세요.");
			return false;
		}
	}

	if($("input:radio[name='hero_qs_07']:checked").val() == "Y") {
		if(!$("input[name='hero_qs_08']").val()) {
			alert("AK Lover외 활동하는 서포터즈/체험단 카페 또는 홈페이지를 입력해주세요.");
			$("input[name='hero_qs_08']").focus();
			$("input[name='hero_qs_08']").css("border","1px solid #f00");
			return false;
		}	
	}

	if(!status) {
		alert("개인정보 수집 이용동의 항목 체크해주시기 바랍니다.");
		return false;
	}

    form.submit();
    return true;
}		
</script>
				
    