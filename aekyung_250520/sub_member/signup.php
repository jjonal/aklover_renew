<?
if(!defined('_HEROBOARD_'))exit;

//20240416 최해성 musign 주석 시작 개발2팀 요청
if(!$_SESSION['temp_level'] || $_SESSION['temp_level']<9999){

	if((!$_POST['param_r6'] || !$_POST['param_r5']) && (!$_POST['snsId'] || !$_POST['snsType'])){

		if($_GET["tempNoAuth"] != "Y") {
			error_historyBack("잘못된 접근입니다.");
			exit;
		} else {
			$_POST['param_r6'] = "tempNoAuth".date("YmdHis");
			$_POST['param_r5'] = "tempNoAuth".date("YmdHis");
			$di = $_POST['param_r6'];
			$ci = $_POST['param_r5'];
			$_POST["param_r1"] = "테스트이름명";
		}
	}

	$error = "SIGNUP_01";

	if($_POST['param_r5'] && $_POST['param_r6']){
		//보안수정 200819
		$_SESSION["auth"]["hero_name"]   = $_POST["param_r1"];
		$_SESSION["auth"]["hero_jumin"]  = $_POST["param_r2"];
		$_SESSION["auth"]["hero_sex"]    = $_POST["param_r3"];
		$_SESSION["auth"]["hero_info_type"]   = $_POST["param_r4"];
		$_SESSION["auth"]["hero_info_di"]   = $_POST["param_r5"];
		$_SESSION["auth"]["hero_info_ci"]   = $_POST["param_r6"];

		$sql = "select count(*) from member where hero_info_di='".$_POST['param_r5']."' and hero_info_ci='".$_POST['param_r6']."' and hero_use=0";
	}elseif($_POST['snsId'] && $_POST['snsType']){
		//보안수정 200819
		$_SESSION["auth"]["snsId"]   = $_POST["snsId"];
		$_SESSION["auth"]["snsType"]  = $_POST["snsType"];

		$sql = "select count(*) from member where hero_".$_POST['snsType']."= md5('".$_POST['snsId']."') and hero_use=0";
	}

	$res = new_sql($sql,$error,"on");
	if((string)$res==$error){
		error_historyBack("");
		exit;
	}
	$check_member = mysql_result($res,0,0);

	if($check_member>0){
		error_location("이미 가입하셨습니다.","/main/index.php?board=findpw");
		exit;
	}

	//########### 휴면정보 체크 ##############
	if($_POST['param_r5'] && $_POST['param_r6']){
		$sql1 = "select count(*) from member_backup where hero_info_di='".$_POST['param_r5']."' and hero_info_ci='".$_POST['param_r6']."'";
	}elseif($_POST['snsId'] && $_POST['snsType']){
		$sql1 = "select count(*) from member_backup where hero_".$_POST['snsType']."=MD5('".$_POST['snsId']."')";
	}
	$out_sql1 = new_sql($sql1,$error);
	if((string)$out_sql1==$error){
		error_historyBack("");
		exit;
	}
	$count1 = mysql_result($out_sql1,0,0);
	if($count1>0){
		error_location("해당 회원은 휴면 상태입니다.ID/PW찾기를 통해 로그인 하여 주십시오.","/main/index.php?board=findpw");
		exit;
	}

}
//20240416 최해성 musign 주석 끝 //

//인증 가입시
$birthYear = substr($_POST['param_r2'], '0', '4');//년
$birthMonth = substr($_POST['param_r2'], '4', '2');//월
$birthDay = substr($_POST['param_r2'], '6', '2');//일

if($_POST['param_r5'] && $_POST['param_r6'] && $_POST['param_r2']){
	$di = $_POST['param_r5'];
	$ci = $_POST['param_r6'];

	if(!$birthYear || !$birthMonth || !$birthDay){
		error_location("시스템 오류입니다. 다시 시도해주세요","/main/index.php?board=idcheck");
		exit;
	}

	include_once $_SERVER['DOCUMENT_ROOT']."/classGathered/chAgeClass.php";
	$chAgeClass = new chAgeClass($birthYear,$birthMonth,$birthDay);
	$age = $chAgeClass->countUniversalAge();
	if((int)$age<15){
		error_location("만14세 미만은 가입하실 수 없습니다.","/main/index.php");
		exit;
	}

	$readonly_auth = "readonly";
	$displaynone_auth = "style='display:none'";
//sns 가입시
}else{
	$snsId = $_POST['snsId'];
	$snsEmail = explode("@",$_POST['snsEmail']);
	$snsType = $_POST['snsType'];

	switch($snsType){
		case "facebook" : $snsText = "<p style='padding-bottom: 4rem;'><img src='/image2/etc/snsBig01.jpg' alt='".$snsType."' style='margin-right: 1rem'> 회원님의 페이스북이 연동되었습니다</p>";break;
		case "kakaoTalk" : $snsText = "<p style='padding-bottom: 4rem;'><img src='/img/front/member/kakaolog.webp' alt='".$snsType."' style='margin-right: 1rem'> 회원님의 카카오톡이 연동되었습니다.</p>";break;
		case "naver" : $snsText = "<p style='padding-bottom: 4rem;'><img src='/img/front/member/naverlog.webp' alt='".$snsType."' style='margin-right: 1rem'> 회원님의 네이버 아이디가 연동되었습니다.</p>";break;
		case "google" : $snsText = "<p style='padding-bottom: 4rem;'><img src='/img/front/member/googlelog.webp' alt='".$snsType."' style='margin-right: 1rem'> 회원님의 구글 아이디가 연동되었습니다.</p>";break;
	}

	$readonly_sns = "readonly";
	$disabled_sns = "disabled='disabled'";
	$displaynone_sns = "style='display:none'";
}
?>
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<script>
$(document).ready(function(){
	$(document).on("keyup", "input:text[suOnly]", function() {$(this).val( $(this).val().replace(/[^0-9]/gi,"") );});

});
</script>
<link rel="stylesheet" type="text/css" href="/css/front/member.css" />
<div class="contents_area mu_member join_wrap">
	<div class="page_title t_c">
        <h2 class="fz48 fw500 main_c">회원가입</h2>
		<p class="subtit fz12">AK Lover의 다양한 서포터즈를 경험하세요!</p>
		<div class="bread">
			<ul class="f_b">
				<li >1. 본인인증</li>
				<li class="arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<li class="joinstep on">2.이용약관 동의</li>
				<li class="join_arr arr on"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<li class="joinstep ">3.계정 생성(필수)</li>
				<li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<!-- <li class="joinstep ">4.계정 생성(선택)</li>
				<li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li> -->
				<li>4.회원가입 완료</li>
			</ul>
		</div>
    </div>
	<div class="signup_wrap">
		<div class="contents">
			<form name="form_next" action="<?=PATH_HOME_HTTPS?>?board=result" enctype="multipart/form-data" method="post" onsubmit="return false;">
				<input type="hidden" name="hero_jumin" value="">
				<input type="hidden" name="hero_login_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
				<input type="hidden" id="ch_term_01" value="false">
				<input type="hidden" id="ch_term_02" value="false">
				<input type="hidden" id="ch_term_03" value="false">
				<input type="hidden" id="ch_term_04" value="false">
				<input type="hidden" id="ch_term_05" value="false">
				<input type="hidden" name="hero_user_point_check" />
				<input type="hidden" name="tempNoAuth" value="<?=$_GET["tempNoAuth"]?>" /><!-- 회원가입 테스트 용도 인증 무시 -->

				<?=$snsText?>				
				<!--// 회원가입 동의 -->
				<div class="step signup_term">
					<div class="signup_term_title fz18 fw600">애경산업 서비스 회원 약관</div>
					<div class="all_agree agree_list input_chk">
						<input type="checkbox" name="all_terms" id="allAgree" />
						<label for="allAgree"class="input_chk_label">애경산업의 모든 약관을 확인하고 전체 동의합니다.</label>
						<p class="desc">
							전체동의는 필수 및 선택정보에 대한 동의도 포함되어 있으며,<br />
							개별적으로도 동의를 선택하실 수 있습니다.<br />
							선택항목에 대한 동의를 거부하는 경우에도 회원가입 서비스는 이용 가능합니다.
						</p>
					</div>
					<div class="agree_list input_chk">
						<input type="checkbox" id="hero_terms_01" name="hero_terms_01" class="partAgree_btn" value='0'/>
						<label for="hero_terms_01" class="input_chk_label"><span class="fz15 bold main_c">필수*</span>이용약관에 동의합니다.</label>
						<!-- <input type="radio" class="partAgree_btn" name="hero_terms_01" value='1'/>동의안함 -->
						<div class="term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">서비스 이용약관 (필수)</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
								<div class="scrollbx"><?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term1_2.php";?></div>
								<script>
									$(document).ready(function(){
										$('#term1').addClass('scroll');
									})
								</script>
							</div>	
						</div>
						<div class="all_view">전체보기</div>
					</div>
					<div class="agree_list input_chk">
						<input type="checkbox" id="hero_terms_02" name="hero_terms_02" class="partAgree_btn" value='0'/>						
						<label for="hero_terms_02" class="input_chk_label"><span class="fz15 bold main_c">필수*</span>개인정보 수집<b></b>이용동의 필수 항목</label>
						<!-- <input type="radio" class="partAgree_btn" name="hero_terms_02" value='1'/>동의안함 -->
						<div class="term table_term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">개인정보 수집 동의 (필수)
									<p class="fz14">* 해당 개인정보 수집 및 이용에 동의하지 않을 권리가 있으며, 동의하지 않을 경우 회원가입이 불가합니다.<br />
									*단, 3년간 로그인이 없을 경우 자동 탈퇴되며, 5년 이후에는 재동의가 필요합니다.
								</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>							
								<div id="term4">
									<table border="1" cellspacing="0" cellpadding="2">
										<tr>
											<td>수집항목</td>
											<td>아이디, 비밀번호, 이름, 닉네임, 생년월일, 이메일, 휴대폰번호, 주소,
											본인인증 값(휴대폰인증), <br>
											SNS 로그인 인증시 <br>
											- 카카오톡 : 카카오톡에서 제공하는 고유아이디<br/>
											- 네이버 : 네이버에서 제공하는 고유아이디, 이메일<br/>
											- 구글 : 구글에서 제공하는 고유아이디, 이메일</td>
											<td>이름, 닉네임, 휴대폰번호</td>
										</tr>
										<tr>
											<td>수집 및 이용 목적</td>
											<td>서비스 이용에 따른 본인식별, 가입연령 확인, 회원의 부정이용 방지,<br/>
											고객 문의에 대한 답변, 본인의사확인, 불만처리 등을 위한 의사소통 경로 확보,<br/>
											사업 및 정책 안내, 회원이 참여한 체험단 활동에 관한 정보 제공 및 그에 따른 경품 배송</td>
											<td>회원 탈퇴 후 고객문의에 대한 답변,<br/>
												불만 처리를 위한 의사소통 경로 확보,<br/>
												서비스 부정 이용방지
											</td>
										</tr>
										<tr>
											<td>이용 및 보유기간</td>
											<td>동의 철회 시 혹은 회원 탈퇴 시까지</td>
											<td>회원탈퇴 후 1년간 보관</td>
										</tr>
									</table>
								</div>								
							</div>	
						</div>						
						<div class="all_view">전체보기</div>
					</div>
					<!-- 240930 백업 파일 저장 -->
					<!-- <div class="agree_list input_chk">
						<input type="checkbox" id="hero_terms_03" name="hero_terms_03" class="selectAgree_btn" value='0'/>		
						<label for="hero_terms_03" class="input_chk_label">개인정보 수집<b></b>이용동의 선택항목 (선택)</label>
						<input type="radio" name="hero_terms_03" class="selectAgree_btn"  value='1'/>동의안함
						<div class="term table_term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">개인정보 수집 동의 (선택)
									<p class="fz14">해당 개인정보 수집 및 이용에 대해서 동의하지 않을 권리가 있으며 동의하지 않으실 경우에도 회원가입은 가능합니다.<br />
									단, 특정 서비스의 이용이 제한될 수 있습니다.</p>
								</h2>								
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>							
								<div id="term4">
									<table border="1" cellspacing="0" cellpadding="2">
										<tr>
											<td>수집항목</td>
											<td>
											※ 아래 항목 중 회원이 기입하는 항목<br/>
											AK Lover를 알게된 경로는?, 추천인 아이디 또는 닉네임,<br/> 
											개인 SNS URL
											, 네이버 블로그 URL
											, 인스타그램 URL
											, 네이버 인플루언서 홈
											, 인플루언서 명
											, 활동 카테고리
											, 그외 SNS URL(페이스북 URL, 트위터 URL, 카카오스토리 URL 등)
											, 유튜브 URL
											, 네이버 TV URL 
											, 틱톡 URL
											, 기타 URL <br/> 
											결혼유무, 자녀 유무/태어난 년도, 반려동물 유무, 건조기 유무, 식기세척기 유무,
											AK Lover에 가입한 이유, AK Lover 외 활동하는 서포터즈/체험단 카페 또는 홈페이지
											</td>
											<td>휴대폰번호</td>
											<td>이메일</td>
										</tr>
										<tr>
											<td>수집 및 이용 목적</td>
											<td>원활한 체험단 활동 모니터링/개인 특성에 따른 체험단 활동 지원<br />
											신규 서비스 개발,, 이벤트 및 광고성 정보 제공 및 참여기회 제공,<br />
											인구통계학적 특성에 따른 서비스 제공 및 광고 게재, 서비스의 유효성 확인,<br />
											접속빈도 파악 또는 회원의 서비스 이용에 대한 통계 확인의 목적</td>
											<td colspan="2">각종 이벤트, 행사 관련 정보안내 및 제반 마케팅 활동,<br/> 
											당사 상품/서비스 안내 및 권유</td>
										</tr>
										<tr>
											<td>이용 및 보유기간</td>
											<td colspan="3">회원탈퇴 및 동의거부시까지</td>
										</tr>
									</table>
								</div>				
							</div>	
						</div>	
						<div class="all_view">전체보기</div>
					</div> -->
					<div class="agree_list agree_depth2 input_chk">
						<input type="checkbox" id="event_agree" name="event_agree" class="" value=''/>
						<label for="event_agree" class="input_chk_label">각종 이벤트, 체험단, 행사 관련 정보 안내 및 제반 마케팅 활동, 당사 상품/서비스 안내 및 권유(선택)</label>
						<div>
							<input type="checkbox" id="hero_terms_04" name="hero_terms_04" class="selectAgree_btn" value='0'/>
							<label for="hero_terms_04" class="input_chk_label">SMS 수신 동의 (선택)</label>
							<!-- <input type="radio" name="hero_terms_04" class="selectAgree_btn"  value='1'/>동의안함 -->
						</div>	
						<div>
							<input type="checkbox" id="hero_terms_05" name="hero_terms_05" class="selectAgree_btn" value='0'/>
							<label for="hero_terms_05" class="input_chk_label">이메일 수신 동의 (선택)</label>
							<!-- <input type="radio" name="hero_terms_05" class="selectAgree_btn"  value='1'/>동의안함 -->
						</div>
					</div>

					<div class="agree_list">
						<p class="fz14 fw500 gray07">필수 위탁업무</p>	
						<div class="term table_term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">필수 위탁업무</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>							
								<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term7.php";?>
							</div>	
						</div>	
						<div class="all_view">전체보기</div>
					</div>
					<div class="btn_bx f_c">
						<!-- <a class="btn_submit btn_gray" href="<?=PATH_HOME_HTTPS?>?board=idcheck">이전으로</a> -->
						<div class="btn_submit btn_black" onClick="chk_agree(document.form_next)">다음으로</div>
					</div>
				</div>
				<!--// 회원가입 동의 -->
				<!-- 회원가입 입력 필수 -->
				<div class="step require" style="display: none;">
					<div class="member">
						<h2 class="fz19 fw600">필수 정보입력</h2>
						<div class="join_input">
							<div class="div_tr">
								<p class="tit"><span>*</span>아이디</p>
								<div class="div_td">
									<input type="text" name="hero_id" id="hero_id" style="ime-mode:disabled;" onfocusout="ch_id(this);" value="" placeholder="4~20자 가능, 특수문자(!@#$%) 사용불가"/>
									<br /><span id="ch_id_text" class="chk_txt"></span>
								</div>
							</div>
							<div class="div_tr">
								<p class="tit"><span>*</span>비밀번호</p>
								<div class="div_td"><input type="password" name="hero_pw_01" id="hero_pw_01" onkeyup="chPwdTF(this);" placeholder="영문, 숫자, 특수기호를 조합하여 8자리 이상 입력해주세요"/>
								<br /><span id="ch_hero_pw_01" class="chk_txt"></span></div>
							</div>
							<div class="div_tr">
								<p class="tit"><span>*</span>비밀번호 확인</p>
								<div class="div_td"><input type="password" name="hero_pw_02" id="hero_pw_02" onkeyup="chPwdTF(this);" placeholder="영문, 숫자, 특수기호를 조합하여 8자리 이상 입력해주세요"/>
								<br /><span id="ch_hero_pw_02" class="chk_txt"></span></div>
							</div>
							<div class="div_tr">
								<p class="tit"><span>*</span>이름</p>
								<div class="div_td">
									<? if($_SESSION["auth"]["hero_name"]) {?>
										<?=$_SESSION["auth"]["hero_name"]?>
									<? } else { ?>
										<input type="text" name="hero_name" placeholder="이름"/>
									<? } ?>
								</div>
							</div>
							<div class="div_tr">
								<p class="tit"><span>*</span>닉네임</p>
								<div class="div_td">
									<input type="text" name="hero_nick" id="hero_nick_02" onkeyup="ch_nick(this);" placeholder="닉네임"/>
									<span id="ch_nick_text" class="chk_txt"></span>
									<p class="txt_emphasis mgt5">
										※ AK Lover 홈페이지에서 닉네임으로 활동합니다.<br/>
										※ 닉네임은 추 후 수정이 불가하오니, 신중하게 작성해 주세요.
									</p>
								</div>
							</div>
							<? 
								if (isset($snsType)) {
									// musign sns 인증회원만 생년월일 기입란 노출표기 25.04.17 고객사 재요청건.
									?>
									<div class="div_tr">
								<p class="tit"><span>*</span> 생년월일</p>
								<div class="div_td">
									<? if($birthYear && $birthMonth && $birthDay) {?>
										<?=$birthYear?>년 <?=sprintf("%02d",$birthMonth)?>월 <?=sprintf("%02d",$birthDay)?>일
									<? } else { ?>
										<div class="yaer_select f_c">
											<select name="year" id="year" title="출생년도 선택" class="mr12">
												<? for($i = date("Y"); $i > 1921; $i--) { ?>
												<option value="<?=$i;?>" <?=$birthYear==$i ? "selected":"";?>><?=$i;?></option>
												<? } ?>
											</select>
											<select name="month" id="month" title="출생월 선택" class="mr12">
												<? for($i = 1; $i <= 12; $i++) { ?>
												<option value="<?=sprintf("%02d", $i);?>" <?=$birthMonth==$i ? "selected":"";?>><?=sprintf("%02d", $i);?></option>
												<? } ?>
											</select>
											<select name="date" id="date" title="출생일 선택" class="mr12">
												<? for($i = 1; $i <= 31; $i++) { ?>
												<option value="<?=sprintf("%02d", $i);?>" <?=$birthDay==$i ? "selected":"";?>><?=sprintf("%02d", $i);?></option>
												<? } ?>
											</select>
										</div>
									<? } ?>
									<span class="txt_emphasis dis-no">만 14세 미만은 회원가입이 불가합니다.</span>
								</div>
							</div>
							<?	}
							?>
							<!-- <div class="div_tr">
								<p class="tit"><span>*</span> 생년월일</p>
								<div class="div_td">
									<? if($birthYear && $birthMonth && $birthDay) {?>
										<?=$birthYear?>년 <?=sprintf("%02d",$birthMonth)?>월 <?=sprintf("%02d",$birthDay)?>일
									<? } else { ?>
										<div class="yaer_select f_c">
											<select name="year" id="year" title="출생년도 선택" class="mr12">
												<? for($i = date("Y"); $i > 1921; $i--) { ?>
												<option value="<?=$i;?>" <?=$birthYear==$i ? "selected":"";?>><?=$i;?></option>
												<? } ?>
											</select>
											<select name="month" id="month" title="출생월 선택" class="mr12">
												<? for($i = 1; $i <= 12; $i++) { ?>
												<option value="<?=sprintf("%02d", $i);?>" <?=$birthMonth==$i ? "selected":"";?>><?=sprintf("%02d", $i);?></option>
												<? } ?>
											</select>
											<select name="date" id="date" title="출생일 선택" class="mr12">
												<? for($i = 1; $i <= 31; $i++) { ?>
												<option value="<?=sprintf("%02d", $i);?>" <?=$birthDay==$i ? "selected":"";?>><?=sprintf("%02d", $i);?></option>
												<? } ?>
											</select>
										</div>
									<? } ?>
									<span class="txt_emphasis dis-no">만 14세 미만은 회원가입이 불가합니다.</span>
								</div>
							</div> -->
							<div class="div_tr">
								<p class="tit"><span>*</span> 이메일</p>
								<div class="div_td">
									<div class="mail_select f_c">
										<div class="mail_select f_c">
											<input type="text" name="hero_mail_01" value="<?=$snsEmail[0]?>" style="ime-mode:disabled; width:150px;" placeholder="이메일"> @
											<input type="text" id="hero_mail_02" name="hero_mail_02" value="<?=$snsEmail[1]?>" style="ime-mode:disabled; width:150px;">
										</div>
										<select id="email_select" onchange='emailChg();' class="short" >
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
							</div>
							<div class="div_tr">
								<p class="tit"><span>*</span> 휴대폰번호</p>
								<div class="div_td f_c mail_select">	
									<input type="text" name="hero_hp_01" id="hero_hp_01" onkeyup="if(this.value.length > 2)hero_hp_02.focus();" maxlength="3" suOnly="true"/>
									-
									<input type="text" name="hero_hp_02" id="hero_hp_02" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" suOnly="true"/>
									-
									<input type="text" name="hero_hp_03" id="hero_hp_03" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" suOnly="true"/>
								</div>
							</div>
						</div>
						<div class="btn_bx f_c">
							<div class="btn_submit btn_gray" onclick="prevStep(0)">이전으로</div>
							<div class="btn_submit btn_black" onClick="requireJoin(document.form_next)">다음으로</div>
						</div>
					</div>
				</div>				
				<!--// 회원가입 입력 필수 -->				
				<!-- 회원가입 입력 선택 -->
				<div class="step choice" style="display: none;">
					<div class="member">
						<h2 class="fz19 fw600">선택 정보입력 <span class="fz12 fw500 gray">*입력하지 않으셔도 회원가입이 가능합니다.</span></h2>
						<div class="div_tr">
							<p class="tit">AK Lover를 알게된 경로는?</p>
							<div class="div_td">
								<ul>
									<li><p class="input_radio"><input type="radio" name="area" id="area1" value="블로그"/><label for="area1" class="input_chk_label">네이버 블로그</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area2" value="인스타그램"/><label for="area2" class="input_chk_label">인스타그램 (후기 게시글, 인스타그램 스폰서 광고 등)</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area3" value="영상"/><label for="area3" class="input_chk_label">유튜브 (후기 영상, 영상광고 등)</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area4" value="숏폼콘텐츠"/><label for="area4" class="input_chk_label">숏폼 콘텐츠 (릴스, 숏츠, 틱톡 등)</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area5" value="카페"/><label for="area5" class="input_chk_label">카페 (카페 배너, 게시글, 이벤트 등)</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area6" value="대외활동홈페이지"/><label for="area6" class="input_chk_label">대외활동 홈페이지 (에브리타임, 캠퍼스픽 등)</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area7" value="쪽지/메일/DM"/><label for="area7">네이버 쪽지/인스타 DM/메일</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area8" value="카카오톡오픈채팅방"/><label for="area8" class="input_chk_label">카카오톡 오픈 채팅방</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area9" value="지인추천"/><label for="area9" class="input_chk_label">지인추천</label></p></li>
									<li><p class="input_radio wid100"><input type="radio" name="area" id="area10" value="기타"/><label for="area10" class="input_chk_label">기타</label><input type="text" name="area_etc_text"maxlength="50" disabled="disabled"/></p></li>
								</ul>
							</div>
						</div>
						<!--!!!!!!!! [개발요청] 기존에 없던 항목입니다 [완]!!!!!!!!  -->
						<div class="div_tr">
							<p class="tit">관심있는 활동</p>
							<div class="div_td">
								<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity2" value="HUT 및 설문조사"/><label for="activity2" class="input_chk_label">HUT 및 설문조사</label></p></li>
								<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity3" value="프리미어 서포터즈"/><label for="activity3" class="input_chk_label">프리미어 서포터즈</label></p></li>
								<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity4" value="포인트 축제"/><label for="activity4" class="input_chk_label">포인트 축제</label></p></li>
								<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity1" value="제품 체혐단"/><label for="activity1" class="input_chk_label">제품 체험단</label></p></li>
								<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity5" value="이벤트"/><label for="activity5" class="input_chk_label">이벤트</label></p></li>
							</div>
						</div>
						<!--!!!!!!!! ///////////END///////// !!!!!!!!  -->
						<div class="div_tr repeople">
							<p class="tit">추천인</p>
							<div class="div_td">
								<ul">
									<li>
										<div class="input_radio">
											<input type="radio" name="hero_user_type" id="hero_user_type_1" value="hero_id" placeholder="추천인의 아이디를 정확하게 입력해주세요."/><label for="hero_user_type_1">아이디</label>
										</div>
										<input type="text" name="hero_user_r_id" id="hero_user_r_id" class="w190" onfocusout="ch_hero_user(this);" disabled/>
									</li>
									<li class="last">
										<div class="input_radio">
											<input type="radio" name="hero_user_type" id="hero_user_type_2" value="hero_nick" placeholder="추천인의 닉네임을 정확하게 입력해주세요."/><label for="hero_user_type_2">닉네임</label>
										</div>
										<input type="text" name="hero_user_r_nick" id="hero_user_r_nick" class="w190" onfocusout="ch_hero_user(this);" disabled/>
									</li>
									<span id="ch_hero_user_text" class="chk_txt"></span>
								</ul>
								<p class="txt_default fz14 fw500">※ 신규회원을 추천해준 기존 AK Lover 회원에게는 애경 제품으로 교환해 갈 수 있는 
								AK Lover 포인트 1,000점이 지급됩니다.</p>
							</div>
						</div>
					</div>					
					<div class="btn_bx f_c">
						<div class="btn_submit btn_gray" onclick="prevStep(1)">이전으로</div>
						<!--!!!!!!!! [개발요청] 회원가입완료시 가입완료페이지 랜딩 http://aklover-test.musign.kr/main/index.php?board=join_ok [완] !!!!!!!!  -->
						<a href="javascript:;" class="btn_submit btn_black" onClick="go_submit(document.form_next)">가입완료</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="/js/birthdate.js"></script>
<script type="text/javascript">
$(document).ready(function(){

	$("input:radio[name='hero_user_type']").on("click",function(){
		var id = $('input:radio[name="hero_user_type"]:checked').attr('id');

		if(id == "hero_user_type_1") {
    		$("#hero_user_r_id").attr("disabled",false);
    		$("#hero_user_r_id").focus();
    		$("#hero_user_r_id").val("");

    		$("#hero_user_r_nick").attr("disabled",true);
    		$("#hero_user_r_nick").val("");
		} else if(id == "hero_user_type_2") {
			$("#hero_user_r_nick").attr("disabled",false);
    		$("#hero_user_r_nick").focus();
    		$("#hero_user_r_nick").val("");

    		$("#hero_user_r_id").attr("disabled",true);
    		$("#hero_user_r_id").val("");
		}

		$("input[name='hero_user_point_check']").val("");
		$("#ch_hero_user_text").html("");
	})


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
		}
	})

	$("input:radio[name='hero_qs_07']").on("click",function(){
		if($(this).val() == "Y") {
			$("input[name=hero_qs_08]").attr("disabled",false);
		} else {
			$("input[name=hero_qs_08]").val("");
			$("input[name=hero_qs_08]").attr("disabled",true);
		}
	})

});

/*	
	musign start
*/
// 전체 동의시 
$('#allAgree').change(function () {
    const $target = $(this),
        $checkbox = $('.agree_list input:checkbox');

    if ($target.prop('checked') === true) {
        $checkbox.prop('checked', true);
    } else {
        $checkbox.prop('checked', false);
    }
});
// 이벤트 수신 동의 (전체)시
$('.agree_depth2 #event_agree').change(function () {
    const $target2 = $(this),
        $checkbox2 = $('.agree_depth2 input:checkbox');

    if ($target2.prop('checked') === true) {
        $checkbox2.prop('checked', true);
    } else {
        $checkbox2.prop('checked', false);
    }
});
// 전체동의 팝업 열기
const allView = $('.agree_list .all_view');
const termCont = $('.agree_list .term');
$.each(allView, function(idx, item){
	$(this).click(function(){
		termCont.eq(idx).removeClass('dis-no');
	});
});
// 전체동의 팝업 닫기
$('.term .btn_x').click(function(){
	$(this).parents('.term').addClass('dis-no');
});
//step박스 - 회원가입 단계별 다음 버튼 동작
const stepDiv = $('.step');
const breadLi = $('.bread li');
const breadStep = $('.bread .joinstep');
const breadArr = $('.bread .join_arr');
function nextStep(index){
	stepDiv.hide();
	stepDiv.eq(index).show();	
	breadLi.removeClass('on');
	breadStep.eq(index).addClass('on');
	breadArr.eq(index).addClass('on');
}
//step박스 - 회원가입 단계별 이전 버튼 동작
function prevStep(index){	
	stepDiv.hide();
	stepDiv.eq(index).show();
	breadLi.removeClass('on');
	breadStep.eq(index).addClass('on');
	breadArr.eq(index).addClass('on');
}
//이용약관 동의 유효성 검사 
function chk_agree(form){
    const terms_01 = form.hero_terms_01;
    const terms_02 = form.hero_terms_02;
	if(terms_01.checked==false){
        alert("서비스 이용약관에 동의하셔야 합니다.");
        return false;
    }
    if(terms_02.checked==false){
        alert("개인정보 수집 및 이용(필수)에 동의하셔야 합니다.");
        return false;
    }
	nextStep(1);
	return true;
}
//계정생성 필수 유효성검사
function requireJoin(form){
	//아이디체크 
	var id = form.hero_id;
	var id_action = document.getElementById("id_action");
	if(trim(id.value)==''){
        alert("아이디를 입력해주세요");
		id.focus();
        return false;
    }
    if(id.value.length < 4){
    	alert("아이디는 4자리 이상 입력해 주세요.");
		id.focus();
        return false;
    }
    if(id_action.value == "hero_down"){
        alert("아이디를 확인해주세요");id.focus();
        return false;
    }
	//패스워드체크
	var pw_01 = form.hero_pw_01;
	var pw_02 = form.hero_pw_02;
	if(trim(pw_01.value) == "" || trim(pw_02.value) == ""){
		var noText;
    	if(trim(pw_01.value)==''){
        	noText = pw_01;
        }else if(trim(pw_02.value)==''){
        	noText = pw_02;
        }
        alert("비밀번호를 입력하세요");
		noText.focus();
        return false;
    }
    if(pw_01.value != pw_02.value){
        alert("비밀번호가 같지 않습니다");
		pw_01.focus();
        return false;
    }
	if (pw_01.value.length < 8) {
		alert("비밀번호는 8자리 이상 입력해주세요");
		pw_01.focus();
		return false;
	}
	if(!chTextType.isEnNumOther(pw_01.value)){
		alert("비밀번호는 문자, 숫자, 특수문자의 조합으로 입력해주세요");
		pw_01.focus();
	    return false;
	}

	// 이름체크
	<? if(!$_SESSION["auth"]["hero_name"]) {?>
		var irum = form.hero_name;
		irum.style.border = '1px solid #ccc';
	<? } ?>
	
	<? if(!$_SESSION["auth"]["hero_name"]) {?>
		if(trim(irum.value)==''){
	        alert("이름을 입력해주세요.");
	        irum.focus();
	        return false;
	    }
    <? } ?>


	//닉네임 체크
	var nick = form.hero_nick;
    var nick_action = document.getElementById("nick_action");
	if(trim(nick.value)==''){
        alert("닉네임을 입력해주세요");
		nick.focus();
        return false;
    }
    if(nick_action == null) {
    	alert("닉네임을 확인해주세요");
		nick.focus();
        return false;
    }
    if(nick_action.value == "hero_down"){
        alert("닉네임을 확인해주세요");
		nick.focus();
        return false;
    }
	//이메일 체크 
    var mail_01 = form.hero_mail_01;
    var mail_02 = form.hero_mail_02;
	if(trim(mail_01.value) == "" || trim(mail_02.value) == ""){
		var noText;
    	if(trim(mail_01.value)==''){
        	noText = mail_01;
        }else if(trim(mail_02.value)==''){
        	noText = mail_02;
        }
        alert("이메일을 입력하세요.");
        noText.focus();
        return false;
    }
	//휴대폰체크
	var hp_01 = form.hero_hp_01;
    var hp_02 = form.hero_hp_02;
    var hp_03 = form.hero_hp_03;
	if(trim(hp_01.value) == "" || trim(hp_02.value) == "" || trim(hp_03.value)==''){
		var noText;
    	if(trim(hp_01.value)==''){
        	noText = hp_01;
        }else if(trim(hp_02.value)==''){
        	noText = hp_02;
        }else{
        	noText = hp_03;
        }
        alert("휴대폰번호를 입력하세요.");
        noText.focus();
        return false;
    }
    if(pw_01.value.indexOf(hp_02.value)>0 || pw_01.value.indexOf(hp_03.value)>0){
    	alert("비밀번호에는 휴대폰 번호가 포함될 수 없습니다");
		pw_01.focus();
	    return false;
    }
	//nextStep(2);
	form.submit();
	return true;
}
//계정생성 선택 유효성검사 - 최종 가입 submit
function go_submit(form) {
    // var address_01 = form.hero_address_01;
    // var address_02 = form.hero_address_02;
    // var address_03 = form.hero_address_03;

	var memid = form.hero_id;
	//가입 이유 유효성 체크
	var hero_qs_06 = form.hero_qs_06; //보류

	//확인필요
	var jumin = form.hero_jumin;

    var ch_term_01 = document.getElementById("ch_term_01").value;
    var ch_term_02 = document.getElementById("ch_term_02").value;
    var ch_term_03 = document.getElementById("ch_term_03").value;
    var ch_term_04 = document.getElementById("ch_term_04").value;
	var ch_term_05 = document.getElementById("ch_term_05").value;

	memid.style.border = '1px solid #ccc';
	<? if(!$_SESSION["auth"]["hero_name"]) {?>
		var irum = form.hero_name;
		irum.style.border = '1px solid #ccc';
	<? } ?>
	// nick.style.border = '1px solid #ccc';
    // pw_01.style.border = '1px solid #ccc';
    // pw_02.style.border = '1px solid #ccc';
    // mail_01.style.border = '1px solid #ccc';
    // mail_02.style.border = '1px solid #ccc';
  	// hp_01.style.border = '1px solid #ccc';
   	// hp_02.style.border = '1px solid #ccc';
   	// hp_03.style.border = '1px solid #ccc';
    // address_01.style.border = '1px solid #ccc';
    // address_02.style.border = '1px solid #ccc';
    // address_03.style.border = '1px solid #ccc';
    // address_03.style.border = '1px solid #ccc';
	
	if($("input:radio[name='area']:checked").val() == "기타") {
		if(!$("input[name='area_etc_text']").val()) {
			alert("AK Lover를 알게된 경로 기타 선택 시 내용을 입력해 주세요.");
			$("input[name='area_etc_text']").focus();
			return;
		}
	}

	if($('#hero_id').val() == $('#hero_user_r_id').val() || $('#hero_nick_02').val() == $('#hero_user_r_nick').val()){
		alert("본인을 추천인으로 추천할 수 없습니다.");
		return false;
	}

	<? if(!$_SESSION["auth"]["hero_name"]) {?>
		if(trim(irum.value)==''){
	        alert("이름을 입력해주세요.");
	        irum.focus();
	        return false;
	    }
    <? } ?>

	// <?  if(!$birthYear || !$birthMonth || !$birthDay) {?>
	// 	var ch_year = document.getElementById("year").value;
	// 	var ch_month = document.getElementById("month").value;
	// 	var ch_date = document.getElementById("date").value;

	//     if(ch_year=='<?=date("Y")?>'){
	//     	 alert("생년월일을 선택해주세요"); $("#year").focus();
	//     	 return false;
	//     }

	//     chAge.setDate(ch_year,ch_month,ch_date);
	// 	var age = chAge.countUniversalAge();
	// 	if(age<15){
	// 		alert("죄송합니다. 만 14세 미만은 가입하실 수 없습니다.");
	// 		return false;
	// 	}
	// <? } ?>
     
    // if(address_01.value == ""){
    //     alert("우편번호를 입력하세요.");address_01.style.border = '1px solid red';address_01.focus();
    //     return false;
    // }
    // if(address_02.value == ""){
    //     alert("주소를 입력하세요.");address_02.style.border = '1px solid red';address_02.focus();
    //     return false;
    // }
    // if(address_03.value == ""){
    //     alert("나머지주소를 입력하세요.");address_03.style.border = '1px solid red';address_03.focus();
    //     return false;
    // }
  
	// var hero_sns_url_check = true;
	// if($("input:radio[name='hero_qs_01']:checked").val() == "Y") {
	// 	hero_sns_url_check = false;
	// 	$(".hero_sns_url").each(function(i){
	// 		if($(this).val()) {
	// 			hero_sns_url_check = true;
	// 		}
	// 	})

	// 	if(form.hero_naver_influencer.value!='') {
    // 		if(form.hero_naver_influencer_name.value=='') {
    // 			alert("인플루언스명 입력이 필요합니다.");
    // 			$("#hero_naver_influencer_name").css("border","1px solid #f00");
	// 			$("#hero_naver_influencer_name").focus();
    // 			return false;
    // 		} else {
    // 			if(form.hero_naver_influencer_category.value=='') {
    // 				alert("인플루언스 카테고리 선택이 필요합니다.");
    // 				return false;
    // 			}
    // 		}
    // 	} else {
    // 		form.hero_naver_influencer_name.value = '';
    // 		form.hero_naver_influencer_category.value = '';

    // 		hero_sns_url_check = false;
    // 		$(".hero_sns_url").each(function(i){
    // 			if($(this).val()) {
    // 				hero_sns_url_check = true;
    // 			}
    // 		})
    // 	}
	// }

	// if(!hero_sns_url_check) {
	// 	alert("개인 SNS URL 있다 라고 선택 시 최소 1개의 개인 SNS URL 입력이 필요합니다.");
	// 	$("#hero_blog_00").css("border","1px solid #f00");
	// 	$("#hero_blog_00").focus();
	// 	return false;
	// }

	// if($("input:radio[name='hero_qs_03']:checked").val() == "Y") {
	// 	if(!$("input:radio[name='hero_qs_04']").is(":checked")) {
	// 		alert("자녀수를 선택해 주세요.");
	// 		return false;
	// 	}
	// 	var hero_qs_05_check = 0;
	// 	var k = 0;
	// 	$("select[name='hero_qs_05[]']").each(function(i){
	// 		if($(this).val()) {
	// 			k++;
	// 		}
	// 	})

	// 	if($("input:radio[name='hero_qs_04']:checked").val() != k) {
	// 		alert("선택한 자녀의 태어난 년도를 선택해 주세요.");
	// 		return false;
	// 	}
	// }

	// if($("input:radio[name='hero_qs_07']:checked").val() == "Y") {
	// 	if(!$("input[name='hero_qs_08']").val()) {
	// 		alert("AK LOVER외 활동하는 서포터즈/체험단 카페 또는 홈페이지를 입력해주세요.");
	// 		$("input[name='hero_qs_08']").focus();
	// 		$("input[name='hero_qs_08']").css("border","1px solid #f00");
	// 		return false;
	// 	}
	// }
	form.submit();
	return true;
}
/*
	musign end
*/


//아이디 유효성 검사
function ch_id(obj){
	var id_alert_area = $(obj).next("span");
	var blank_pattern = /[\s]/g;
	if( blank_pattern.test($(obj).val()) == true){
	    alert('공백은 사용할 수 없습니다.');
	    $(obj).val("");
	    $(obj).focus();
	    return false;
	}
	if(trim($(obj).val())==''){
		id_alert_area.html("4~20자 가능, 특수문자(!@#$%)사용불가");
		return false;
	}else{
		//setCookie('cookie_hero_id', obj.value);
		hero_ajax('zip.php', 'ch_id_text', 'hero_id', 'id');
		return false;
	}
}

function ch_nick(obj){
	var nick_alert_area = $(obj).next("span");
	var blank_pattern = /[\s]/g;
	if( blank_pattern.test($(obj).val()) == true){
	    alert('공백은 사용할 수 없습니다.');
	    $(obj).val("");
	    $(obj).focus();
	    return false;
	}
	if(trim($(obj).val())==''){
		nick_alert_area.html("닉네임을 입력해 주세요.");
		return false;
	}else{
		hero_ajax('zip.php', 'ch_nick_text', 'hero_nick_02', 'nick');
		return false;
	}
}
function emailChg(){
	if(form_next.email_select.value != "")  $('#hero_mail_02').attr('readonly', true);
	else $('#hero_mail_02').attr('readonly', false);
    form_next.hero_mail_02.value = form_next.email_select.value;
}
function checkNumber(e) {
	var eventCode =(window.netscape)? e.which : e.keyCode;

	if ( ( (96<=eventCode) && (eventCode<=105) ) || ( (48<=eventCode) && (eventCode<=57) ) || (eventCode==8) || (eventCode==37) || (eventCode==39) || (eventCode==9)|| (eventCode==46)){
		e.returnValue=true;
	}else{
		e.preventDefault();
		e.returnValue=false;
	}
}

//비밀번호 유효성 검사
function chPwdTF(obj){
	var hero_pw_01 = document.form_next.hero_pw_01;
	var hero_pw_02 = document.form_next.hero_pw_02;
	var hero_hp_02 = document.form_next.hero_hp_02;
	var hero_hp_03 = document.form_next.hero_hp_03;
	var ch_hero_pw_01 = document.getElementById("ch_hero_pw_01");
	var ch_hero_pw_02 = document.getElementById("ch_hero_pw_02");

	if (hero_pw_01.value.length < 8) {
		ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
		ch_hero_pw_01.innerHTML ="영문, 숫자, 특수기호를 조합하여 8자리 이상 입력해주세요";
		obj.focus();
	} else if(!chTextType.isEnNumOther(hero_pw_01.value)){
		ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
		ch_hero_pw_01.innerHTML ="영문, 숫자, 특수기호를 조합하여 주세요";
		obj.focus();
	} else{
		ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[1]?>";
		ch_hero_pw_01.innerHTML ="사용 가능한 비밀번호입니다";
	}

	if(hero_pw_02.value!=''){
		if(hero_pw_02.value!=hero_pw_01.value){
			ch_hero_pw_02.style.color="<?=$_MAIN_COLOR[0]?>";
		ch_hero_pw_02.innerHTML ="비밀번호가 같지 않습니다";
		obj.focus();
	}else{
		ch_hero_pw_02.style.color="<?=$_MAIN_COLOR[1]?>";
	    	ch_hero_pw_02.innerHTML ="비밀번호가 같습니다.";
		}
	}
	// if(hero_hp_02.value!='' || hero_hp_03!=''){
	//     if(hero_pw_01.value.indexOf(hero_hp_02.value)>0 || hero_pw_01.value.indexOf(hero_hp_03.value)>0){
	//     	ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
    //     	alert("비밀번호에는 휴대폰번호를 사용하실 수 없습니다");
	// 		ch_hero_pw_01.innerHTML ="비밀번호에는 휴대폰번호를 사용하실 수 없습니다";
	// 		ch_hero_pw_02.style.color="";
	// 		ch_hero_pw_02.innerHTML ="";
	// 		hero_pw_01.focus();
    //     } else {
	// 		if(obj.name=="hero_hp_02"){
	// 			hero_hp_03.focus();
	// 		}
	//     }
    // }
}

//추천인 유효성 검사
function ch_hero_user(obj) {
	if(obj.value.length > 0) {
		if(!$("input:radio[name='hero_user_type']").is(":checked")) {
			$("#ch_hero_user_text").html("추천인 아이디 또는 닉네임을 선택 후 입력해 주세요.");
			$("input[name='hero_user_point_check']").val("");
			return;
		}
	}

	var param = "type=hero_user";
	param += "&hero_user_type="+$("input:radio[name='hero_user_type']:checked").val();
	param += "&hero_user="+obj.value;

	$.ajax({
		url:"/main/zip.php"
		,type:"POST"
		,data:param
		,dataType:"json"
		,success:function(d){
			console.log(d);
			if(d.result == "1") {
				$("#ch_hero_user_text").html("입력하신 회원에게 포인트가 적립됩니다.");
				$("#ch_hero_user_text").removeClass("txt_emphasis");
				$("input[name='hero_user_point_check']").val("ok");
			} else {
				$("#ch_hero_user_text").html("입력하신 회원정보가 존재하지 않습니다.");
				$("#ch_hero_user_text").addClass("txt_emphasis");
				$("input[name='hero_user_point_check']").val("");
			}
		},error:function(e) {
			console.log(e);
		}
	})
}
</script>
