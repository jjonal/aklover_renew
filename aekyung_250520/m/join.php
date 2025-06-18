<? 
include_once "head.php";
	
	$selectAgreePrivacy = $_POST["selectAgreePrivacy"];
	$selectAgreePhone = $_POST["selectAgreePhone"];
	$selectAgreeEmail = $_POST["selectAgreeEmail"];
	
	$param_r1 = $_SESSION["auth"]["hero_name"];
	$param_r2 = $_SESSION["auth"]["hero_jumin"];
	$param_r3 = $_SESSION["auth"]["hero_sex"];
	$param_r4 = $_SESSION["auth"]["hero_info_type"];
	$param_r5 = $_SESSION["auth"]["hero_info_di"];
	$param_r6 = $_SESSION["auth"]["hero_info_ci"];
	$snsId = $_SESSION["auth"]["snsId"];
	$snsType = $_SESSION["auth"]["snsType"];
	$snsEmail = $snsEmail = explode("@",$_SESSION["auth"]["snsEmail"]);
	
	$hero_terms_01 = $_POST["agree_service"]=="Y" ? "0":"1"; //약관
	$hero_terms_02 = $_POST["agree_privacy"]=="Y" ? "0":"1";
	$hero_terms_03 = $_POST["selectAgreePrivacy"]=="Y" ? "0":"1";
	$hero_terms_04 = $_POST["selectAgreePhone"]=="Y" ? "0":"1";
	$hero_terms_05 = $_POST["selectAgreeEmail"]=="Y" ? "0":"1";

	
	$birthYear = substr($param_r2,0,4);
	$birthMonth = substr($param_r2,4,2);
	$birthDay= substr($param_r2,6,2);

    //musign S
    //오픈 전에 주석 제거
	if((!$param_r5 || !$param_r6) && (!$snsId || !$snsType)) {
		if($_GET["tempNoAuth"] != "Y") {
			error_historyBack("잘못된 접근입니다.");
			exit;
		} else {
			$param_r5 = "tempNoAuth".date("YmdHis");
			$param_r6 = "tempNoAuth".date("YmdHis");
			$di = $param_r5;
			$ci =$param_r6;
			$param_r1 = "테스트이름명";
		}
	}
	//musign E

	if($param_r1) { //인증가입 시
		
	} else if($snsId) { //SNS 가입 시
		switch($snsType){
			case "facebook" : $snsText = "<img src='/image2/etc/snsBig01.jpg' alt='".$snsType."'> 회원님의 페이스북이 연동되었습니다";break;
			case "kakaoTalk" : $snsText = "<img src='/image2/etc/snsBig02.jpg' alt='".$snsType."'> 회원님의 카카오톡이 연동되었습니다";break;
			case "naver" : $snsText = "<img src='/image2/etc/snsBig03.jpg' alt='".$snsType."'> 회원님의 네이버 아이디가 연동되었습니다";break;
			case "google" : $snsText = "<img src='/image/member/btn_google_small.png' alt='".$snsType."'> 회원님의 구글 아이디가 연동되었습니다";break;
		}
	}
	
	$hero_qs_01_disabled = "disabled";
	if($selectAgreePrivacy == "Y") {
		$hero_qs_01_disabled = "";
	}
	
$group_sql = " SELECT * from hero_group WHERE hero_use='1' and hero_board ='".$_GET['board']."' "; // desc

$out_group = new_sql( $group_sql,$error );
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}
$right_list = mysql_fetch_assoc ( $out_group );	
include_once "boardIntroduce.php";
?>
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">
<div class="contents_area mu_member join_wrap">
	<div class="page_title t_c">
        <h2 class="fz48 fw500 main_c">회원가입</h2>
		<p class="subtit fz12">AK Lover의 다양한 서포터즈를 경험하세요!</p>
		<div class="bread">
			<ul class="f_c">
				<li>본인인증</li>
				<li class="arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<li class="joinstep">이용약관 동의</li>
				<li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<li class="joinstep on">계정 생성(필수)</li>
				<!-- <li class="join_arr arr on"><img src="/img/front/icon/bread.webp" alt="화살표"></li><br /> -->
			</ul>
			<ul class="f_c">				
				<!-- <li class="joinstep">계정 생성(선택)</li> -->
				<li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<li class="joinstep">회원가입 완료</li>
			</ul>
		</div>
    </div>
	<div class="signup_wrap">
		<div class="contents">
			<form name="form_next" id="form_next" method="post">
			<input type="hidden" name="hero_login_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
			<input type="hidden" name="hero_user_point_check" />
			<input type="hidden" name="hero_terms_01" value="<?=$hero_terms_01?>"/>
			<input type="hidden" name="hero_terms_02" value="<?=$hero_terms_02?>"/>
			<input type="hidden" name="hero_terms_03" value="<?=$hero_terms_03?>"/>
			<input type="hidden" name="hero_terms_04" value="<?=$hero_terms_04?>"/>
			<input type="hidden" name="hero_terms_05" value="<?=$hero_terms_05?>"/>
			<input type="hidden" name="tempNoAuth" value="<?=$_POST["tempNoAuth"]?>" /><!-- 회원가입 테스트 용도 인증 무시 -->
			<!-- 회원가입 입력 필수 s -->		
			<div class="step require">
				<div class="member">
					<h2 class="fz15 fw600">필수 정보입력</h2>
					<div class="join_input">
						<div class="div_tr">
							<p class="tit"><span>*</span>아이디</p>
							<div class="div_td">
								<input type="text" name="hero_id" id="hero_id" maxlength="20" style="ime-mode:disabled;" onkeyup="ch_id(this);" value="" placeholder="4~20자 가능, 특수문자(!@#$%) 사용불가"/>
								<span id="ch_id_text" class="chk_txt"></span>
							</div>
						</div>
						<div class="div_tr">
							<p class="tit"><span>*</span>비밀번호</p>
							<div class="div_td"><input type="password" name="hero_pw_01" id="hero_pw_01" onkeyup="chPwdTF(this);" placeholder="영문, 숫자, 특수기호를 조합하여 8자리 이상 입력해주세요"/><span id="ch_hero_pw_01" class="chk_txt"></span></div>
						</div>
						<div class="div_tr">
							<p class="tit"><span>*</span>비밀번호 확인</p>
							<div class="div_td"><input type="password" name="hero_pw_02" id="hero_pw_02" onkeyup="chPwdTF(this);" placeholder="영문, 숫자, 특수기호를 조합하여 8자리 이상 입력해주세요"/><span id="ch_hero_pw_02" class="chk_txt"></span></div>
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
										<select name="year" id="year" title="출생년도 선택">
											<? for($i = date("Y"); $i > 1921; $i--) { ?>
											<option value="<?=$i;?>" <?=$birthYear==$i ? "selected":"";?>><?=$i;?></option>
											<? } ?>
										</select>
										<select name="month" id="month" title="출생월 선택">
											<? for($i = 1; $i <= 12; $i++) { ?>
											<option value="<?=sprintf("%02d", $i);?>" <?=$birthMonth==$i ? "selected":"";?>><?=sprintf("%02d", $i);?></option>
											<? } ?>	
										</select>
										<select  name="date" id="date" title="출생일 선택">
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
						<div class="div_tr">
							<p class="tit"><span>*</span> 이메일</p>
							<div class="div_td">
								<div class="mail_select f_c">
									<div class="mail_select f_c">
										<input type="text" name="hero_mail_01" id="hero_mail_01" value="<?=$snsEmail[0]?>" style="ime-mode:disabled; width:90px;" placeholder="이메일"> @
										<input type="text" name="hero_mail_02" id="hero_mail_02" value="<?=$snsEmail[1]?>"  value="<?=$snsEmail[1]?>" style="ime-mode:disabled; width:70px;">
									</div>
									<select class="short" name="hero_mail_02_select" onchange="$('#hero_mail_02').val(this.value); $('#hero_mail_02').focus();">
										<option value="">직접선택</option>
										<option value="naver.com">naver.com</option>
										<option value="hanmail.net">hanmail.net</option>
										<option value="daum.net">daum.net</option>
										<option value="gmail.com">gmail.com</option>
										<option value="hotmail.com">hotmail.com</option>
										<option value="paran.com">paran.com</option>
										<option value="nate.com">nate.com</option>
									</select>
								</div>
							</div>
						</div>
						<div class="div_tr">
							<p class="tit"><span>*</span> 휴대폰번호</p>
							<div class="div_td f_c mail_select">	
								<input type="text" name="hero_hp_01" id="hero_hp_01" onkeyup="if(this.value.length > 2)hero_hp_02.focus();" maxlength="3" numberOnly/>
								-
								<input type="text" name="hero_hp_02" id="hero_hp_02" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" numberOnly/>
								-
								<input type="text" name="hero_hp_03" id="hero_hp_03" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" numberOnly/>
							</div>
						</div>
						<!-- <div class="div_tr">
							<p class="tit"><span>*</span> 주소</p>
							<div class="div_td post rel">
								<input type="text" name="hero_address_01" id="hero_address_01" class="w190" readonly placeholder="우편번호"/>
								<a href="javascript:;" onClick="btnAddressGet()">우편번호 찾기</a>	
								<input type="text" name="hero_address_02" id="hero_address_02" readonly/>
								<input type="text" name="hero_address_03" id="hero_address_03" />
							</div>
						</div>  -->
					</div>
					<div class="btn_bx f_c">
						<a class="btn_submit btn_gray" href="/m/agreement.php">이전으로</a>
						<div class="btn_submit btn_black" onClick="requireJoin(document.form_next)">다음으로</div>
					</div>
				</div>	
			</div>
			<!--// 회원가입 입력 필수 e -->				
			<!-- 회원가입 입력 선택 s -->
			<div class="step choice" style="display: none;">
				<div class="member">			
					<h2 class="fz15 fw600">필수 정보입력<br/><span class="fz12 fw500 gray">*입력하지 않으셔도 회원가입이 가능합니다.</span></h2>
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
									<input type="text" name="hero_user_r_nick" id="hero_user_r_nick" onkeyup="ch_hero_user(this);" disabled />
								</li>
								<span id="ch_hero_user_text" class="chk_txt"></span>
							</ul>
							<p class="txt_default fz13 fw500">※ 신규회원을 추천해준 기존 AK Lover 회원에게는 애경 제품으로 교환해 갈 수 있는 
							AK Lover 포인트 1,000점이 지급됩니다.</p>
						</div>
					</div>								
					<div class="joinColumnWrap dis-no">					
						<div class="joinColumnGroup bottomLine">
							<label>개인 SNS URL</label>
							<div class="sns">
								<p class="mgb10">※ AK Lover는 체험단 활동을 위해서는 개인 SNS URL 입력이 필요합니다.</p>
								<input type="radio" name="hero_qs_01" id="hero_qs_01_N" value="N" <?=$selectAgreePrivacy!="Y" ? "checked":""?>/><label for="hero_qs_01_N">없다</label>
								<input type="radio" name="hero_qs_01" id="hero_qs_01_Y" value="Y" <?=$selectAgreePrivacy=="Y" ? "checked":""?>/><label for="hero_qs_01_Y">있다</label>
							</div>
							<div class="snsUrl">
								<dl>
									<dd>
										<label for="hero_blog_00">네이버 블로그</label><br/>
										<label for="hero_blog_00" style="margin-left:8px;">https://blog.naver.com/</label>
										<input type="text" maxlength="25" name="hero_blog_00" id="hero_blog_00" class="hero_sns_url" placeholder="네이버 ID 또는 블로그 ID" style="width:calc(100% - 178px); margin-left:75px;" <?=$hero_qs_01_disabled?>/>
									</dd>
									<dd>
										<label for="hero_blog_04">인스타그램</label><br/>
										<label for="hero_blog_04" style="margin-left:8px;">https://www.instagram.com/</label>
										<input type="text" maxlength="25" name="hero_blog_04" id="hero_blog_04" class="hero_sns_url" placeholder="인스타그램 ID" style="width:calc(100% - 178px); margin-left:75px;" <?=$hero_qs_01_disabled?>/>
									</dd>
									<dd>
										<label for="hero_naver_influencer" style="width:100%;">네이버 인플루언서 홈</label><br/>
										<label for="hero_naver_influencer" style="margin-left:8px;">https://in.naver.com/</label>
										<input type="text" maxlength="25" name="hero_naver_influencer" id="hero_naver_influencer" class="hero_sns_url" placeholder="네이버 인플루언서 ID" style="width:calc(100% - 178px); margin-left:75px;" <?=$hero_qs_01_disabled?>/>
									</dd>
									<dd><label for="hero_naver_influencer_name">인플루언서 명</label><input type="text" id="hero_naver_influencer_name" name="hero_naver_influencer_name" class="hero_sns_url" placeholder="인플루언서 닉네임" <?=$hero_qs_01_disabled?>/></dd>
									<dd><label for="hero_naver_influencer_category">활동 카테고리</label><select id="hero_naver_influencer_category" name="hero_naver_influencer_category" class="hero_sns_url" <?=$hero_qs_01_disabled?>>
											<option value="">선택</option>
											<option value="여행">여행</option>
											<option value="패션">패션</option>
											<option value="뷰티">뷰티</option>
											<option value="푸드">푸드</option>
											<option value="IT테크">IT테크</option>
											<option value="자동차">자동차</option>
											<option value="리빙">리빙</option>
											<option value="육아">육아</option>
											<option value="생활건강">생활건강</option>
											<option value="게임">게임</option>
											<option value="동물/펫">동물/펫</option>
											<option value="운동/레저">운동/레저</option>
											<option value="프로스포츠">프로스포츠</option>
											<option value="방송/연예">방송/연예</option>
											<option value="대중음악">대중음악</option>
											<option value="영화">영화</option>
											<option value="공연/전시/예술">공연/전시/예술</option>
											<option value="도서">도서</option>
											<option value="경제/비즈니스">경제/비즈니스</option>
											<option value="어학/교육">어학/교육</option>
										</select>
									</dd>
									<dd><label for="hero_blog_05">그 외  SNS URL</label><input type="text" name="hero_blog_05" id="hero_blog_05" class="hero_sns_url" placeholder="페이스북, 트위터 등" <?=$hero_qs_01_disabled?>/></dd>
								</dl>
								
								<p class="mgb10" style="font-size:14px; color:#000;">| 영상 채널</p>
								<dl>
									<dd><label for="hero_blog_03">유튜브</label><input type="text" name="hero_blog_03" id="hero_blog_03" class="hero_sns_url" <?=$hero_qs_01_disabled?>/></dd>
									<dd><label for="hero_blog_06">네이버 TV</label><input type="text" name="hero_blog_06" id="hero_blog_06" class="hero_sns_url" <?=$hero_qs_01_disabled?>/></dd>
									<dd><label for="hero_blog_07">틱톡</label><input type="text" name="hero_blog_07" id="hero_blog_07" class="hero_sns_url" <?=$hero_qs_01_disabled?>/></dd>
									<dd><label for="hero_blog_08">기타</label><input type="text" name="hero_blog_08" id="hero_blog_08" class="hero_sns_url" <?=$hero_qs_01_disabled?>/></dd>
								</dl>
								
							</div>
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>결혼 유무</label>
							<div class="default">
								<input type="radio" name="hero_qs_02" id="hero_qs_02_N" value="N" checked/><label for="hero_qs_02_N">미혼</label>
								<input type="radio" name="hero_qs_02" id="hero_qs_02_Y" value="Y" /><label for="hero_qs_02_Y">기혼</label>
							</div>
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>자녀 유무/태어난 년도</label>
							<div class="default">
								<input type="radio" name="hero_qs_03" id="hero_qs_03_N" value="N" checked/><label for="hero_qs_03_N">없음</label>
								<input type="radio" name="hero_qs_03" id="hero_qs_03_Y" value="Y"/><label for="hero_qs_03_Y">있음</label>
							</div>
							<div class="children">
								<dl>
									<dd><input type="radio" name="hero_qs_04" id="hero_qs_04_1" value="1"/><label for="hero_qs_04_1">1명</label>
										<select name="hero_qs_05[]">
											<option value="">선택</option>
											<? for($i=date("Y"); $i > 1921; $i--) {?>
											<option value="<?=$i?>"><?=$i?></option>
											<? } ?>
										</select>
									</dd>
									<dd><input type="radio" value="2" name="hero_qs_04" id="hero_qs_04_2"/><label for="hero_qs_04_2">2명</label>
										<select name="hero_qs_05[]">
											<option value="">선택</option>
											<? for($i=date("Y"); $i > 1921; $i--) {?>
											<option value="<?=$i?>"><?=$i?></option>
											<? } ?>
										</select>
									</dd>
									<dd><input type="radio" name="hero_qs_04"  id="hero_qs_04_3" value="3"/><label for="hero_qs_04_3">3명</label>
										<select name="hero_qs_05[]">
											<option value="">선택</option>
											<? for($i=date("Y"); $i > 1921; $i--) {?>
											<option value="<?=$i?>"><?=$i?></option>
											<? } ?>
										</select>
									</dd>
									<dd><input type="radio" name="hero_qs_04" id="hero_qs_04_4" value="4"/><label for="hero_qs_04_4">4명</label>
										<select name="hero_qs_05[]">
											<option value="">선택</option>
											<? for($i=date("Y"); $i > 1921; $i--) {?>
											<option value="<?=$i?>"><?=$i?></option>
											<? } ?>
										</select>
									</dd>
									<dd><input type="radio" name="hero_qs_04" id="hero_qs_04_5" value="5"/><label for="hero_qs_04_5">5명</label>
										<select name="hero_qs_05[]">
											<option value="">선택</option>
											<? for($i=date("Y"); $i > 1921; $i--) {?>
											<option value="<?=$i?>"><?=$i?></option>
											<? } ?>
										</select>
									</dd>
								</dl>
							</div>
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>반려동물 유무</label>
							<div class="default">
								<input type="radio" name="hero_qs_19" id="hero_qs_19_N" value="N" checked/><label for="hero_qs_19_N">없음</label>
								<input type="radio" name="hero_qs_19" id="hero_qs_19_Y" value="Y"/><label for="hero_qs_19_Y">있음</label>
							</div>
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>건조기 유무</label>
							<div class="default">
								<input type="radio" name="hero_qs_20" id="hero_qs_20_N" value="N" checked/><label for="hero_qs_20_N">없음</label>
								<input type="radio" name="hero_qs_20" id="hero_qs_20_Y" value="Y"/><label for="hero_qs_20_Y">있음</label>
							</div>
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>식기세척기 유무</label>
							<div class="default">
								<input type="radio" name="hero_qs_21" id="hero_qs_21_N" value="N" checked/><label for="hero_qs_21_N">없음</label>
								<input type="radio" name="hero_qs_21" id="hero_qs_21_Y" value="Y"/><label for="hero_qs_21_Y">있음</label>
							</div>
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>AK Lover에 가입한 이유</label>
							<input type="text" name="hero_qs_06" />
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>AK Lover 외 활동하는 서포터즈/체험단 카페 또는 홈페이지</label>
							<div class="default">
								<input type="radio" name="hero_qs_07" id="hero_qs_07_N" value="N" checked/><label for="hero_qs_07_N">없음</label>
								<input type="radio" name="hero_qs_07" id="hero_qs_07_Y" value="Y"/><label for="hero_qs_07_Y">있음</label>
							</div>
							<input type="text" name="hero_qs_08" disabled />
						</div>					
					</div>
					<div class="btn_bx f_c">
						<div class="btn_submit btn_gray" onclick="prevStep(1)">이전으로</div>
						<!--!!!!!!!! [개발요청] 회원가입완료시 가입완료페이지 랜딩 http://aklover-test.musign.kr/m/join_ok.php [완]!!!!!!!!  -->
						<a href="javascript:;" class="btn_submit btn_black" onClick="go_submit(document.form_next)">가입완료</a>
					</div>						
				</div>
			</div>		
			<!-- // 회원가입 입력 선택 e -->
			</form>
		</div>
	</div>
</div>
<script>
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

	$("input:radio[name='hero_qs_01']").on("click",function(){
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
})

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
		hero_ajax('/main/zip.php', 'ch_id_text', 'hero_id', 'id');
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
		hero_ajax('/main/zip.php', 'ch_nick_text', 'hero_nick_02', 'nick'); 
		return false;
	}
}

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
    }else if(!chTextType.isEnNumOther(hero_pw_01.value)){
    	ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
    	ch_hero_pw_01.innerHTML ="영문, 숫자, 특수기호를 조합하여 주세요";
    	obj.focus();
    }else{
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
    if(hero_hp_02.value!='' || hero_hp_03!=''){
        if(hero_pw_01.value.indexOf(hero_hp_02.value)>0 || hero_pw_01.value.indexOf(hero_hp_03.value)>0){
        	ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
        	alert("비밀번호에는 휴대폰번호를 사용하실 수 없습니다");
			ch_hero_pw_01.innerHTML ="비밀번호에는 휴대폰번호를 사용하실 수 없습니다";
			ch_hero_pw_02.style.color="";
			ch_hero_pw_02.innerHTML ="";
			hero_pw_01.focus();
        }else{
			if(obj.name=="hero_hp_02"){
				hero_hp_03.focus();
			}
	    }
    }
}

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
				$("input[name='hero_user_point_check']").val("ok");
			} else {
				$("#ch_hero_user_text").html("입력하신 회원정보가 존재하지 않습니다.");	
				$("input[name='hero_user_point_check']").val("");
			}
		},error:function(e) {
			console.log(e);
		}
	})
}

	/*	
		musign start
	*/
	//step박스 - 회원가입 단계별 다음 버튼 동작	
	function nextStep(index){
		const stepDiv = $('.step');
		const breadLi = $('.bread li');
		const breadStep = $('.bread .joinstep');
		const breadArr = $('.bread .join_arr');
		stepDiv.hide();
		stepDiv.eq(index-1).show();	
		breadLi.removeClass('on');
		breadStep.eq(index).addClass('on');
		breadArr.eq(index).addClass('on');
		console.log(breadStep);       
		$(window).scrollTop(0);
	}
	//step박스 - 회원가입 단계별 이전 버튼 동작
	function prevStep(index){	
		const stepDiv = $('.step');
		const breadLi = $('.bread li');
		const breadStep = $('.bread .joinstep');
		const breadArr = $('.bread .join_arr');
		stepDiv.hide();
		stepDiv.eq(index-1).show();
		breadLi.removeClass('on');
		breadStep.eq(index).addClass('on');
		breadArr.eq(index).addClass('on');
		$(window).scrollTop(0);
	}
	// 회원가입 필수 유효성 검사
	function requireJoin(form){
		$("#hero_id").css("border-bottom","1px solid #ccc");
		$("#hero_pw_01").css("border-bottom","1px solid #ccc");
		$("#hero_pw_02").css("border-bottom","1px solid #ccc");
		$("#hero_nick_02").css("border-bottom","1px solid #ccc");
		$("input[type='hero_mail_01']").css("border-bottom","1px solid #ccc");
		$("input[type='hero_mail_02']").css("border-bottom","1px solid #ccc");
		$("#hero_hp_01").css("border-bottom","1px solid #ccc");
		$("#hero_hp_02").css("border-bottom","1px solid #ccc");
		$("#hero_hp_03").css("border-bottom","1px solid #ccc");
		// 주소
		// $("#hero_address_01").css("border-bottom","1px solid #ccc");
		// $("#hero_address_02").css("border-bottom","1px solid #ccc");
		// $("#hero_address_03").css("border-bottom","1px solid #ccc");
		if(!$("#hero_id").val()) {
			alert("아이디를 입력해 주세요.");
			$("#hero_id").css("border-bottom","1px solid #f00");
			$("#hero_id").focus();
			return;
		}

		if($("#hero_id").val().length < 4) {
			alert("아이디는 4자리 이상 입력해 주세요.");
			$("#hero_id").css("border-bottom","1px solid #f00");
			$("#hero_id").focus();
			return;
		}

		if($("#id_action").val()== "hero_down"){
			alert("아이디를 확인해주세요");
			$("#hero_id").css("border-bottom","1px solid #f00");
			$("#hero_id").focus();
			return;
		}

		if(!$("#hero_pw_01").val()) {
			alert("비밀번호를 입력하세요.");
			$("#hero_pw_01").css("border-bottom","1px solid #f00");
			$("#hero_pw_01").focus();
			return;
		}

		if($("#hero_pw_01").val().length < 8) {
			alert("비밀번호는 8자리 이상 입력해주세요");
			$("#hero_pw_01").css("border-bottom","1px solid #f00");
			$("#hero_pw_01").focus();
			return;
		}

		if(!chTextType.isEnNumOther($("#hero_pw_01").val())){
			alert("비밀번호는 문자, 숫자, 특수문자의 조합으로 입력해주세요");
			$("#hero_pw_01").css("border-bottom","1px solid #f00");
			$("#hero_pw_01").focus();
			return false;
		}

		if(!$("#hero_pw_02").val()) {
			alert("비밀번호 확인을 입력하세요.");
			$("#hero_pw_02").css("border-bottom","1px solid #f00");
			$("#hero_pw_02").focus();
			return;
		}

		if($("#hero_pw_01").val() != $("#hero_pw_02").val()) {
			alert("비밀번호가 동일하지 않습니다.");
			$("#hero_pw_01").css("border-bottom","1px solid #f00");
			$("#hero_pw_02").css("border-bottom","1px solid #f00");
			$("#hero_pw_01").focus();
			return;
		}

		<? if(!$_SESSION["auth"]["hero_name"]) {?>
		if(!$("input[name='hero_name']").val().trim()) {
			alert("이름을 입력해 주세요.");
			$("input[name='hero_name']").css("border-bottom","1px solid #f00");
			$("input[name='hero_name']").focus();
			return;
		}
		<? } ?>

		if($("#nick_action").length  < 1){
			alert("닉네임을 입력하세요.");
			$("#hero_nick_02").css("border-bottom","1px solid #f00");
			$("#hero_nick_02").focus();
			return;
		}

		if($("#nick_action").val() == "hero_down"){
			$("#hero_nick_02").css("border-bottom","1px solid #f00");
			$("#hero_nick_02").focus();
			return;
		} 

		if(!$("#hero_nick_02").val()) {
			alert("닉네임을 입력하세요.");
			$("#hero_nick_02").css("border-bottom","1px solid #f00");
			$("#hero_nick_02").focus();
			return;
		}

		if(!$("input[name='hero_mail_01']").val()) {
			alert("이메일(1)을 입력하세요.");
			$("input[name='hero_mail_01']").css("border-bottom","1px solid #f00");
			$("input[name='hero_mail_01']").focus();
			return;
		}

		if(!$("input[name='hero_mail_02']").val()) {
			alert("이메일(2)을 입력하세요.");
			$("input[name='hero_mail_02']").css("border-bottom","1px solid #f00");
			$("input[name='hero_mail_02']").focus();
			return;
		}

		if(!$("#hero_hp_01").val()) {
			alert("휴대폰번호(1)을 입력하세요.");
			$("#hero_hp_01").css("border-bottom","1px solid #f00");
			$("#hero_hp_01").focus();
			return;
		}

		if(!$("#hero_hp_02").val()) {
			alert("휴대폰번호(2)을 입력하세요.");
			$("#hero_hp_02").css("border-bottom","1px solid #f00");
			$("#hero_hp_02").focus();
			return;
		}

		if(!$("#hero_hp_03").val()) {
			alert("휴대폰번호(3)을 입력하세요.");
			$("#hero_hp_03").css("border-bottom","1px solid #f00");
			$("#hero_hp_03").focus();
			return;
		}

		// 생년월일
		// <?  if(!$birthYear || !$birthMonth || !$birthDay) {?>
		// 	if(!$("#year").val() || !$("#month").val() || !$("#date").val()) {
		// 		alert("생년월일을 입력하세요.");
		// 		$("#year").focus();
		// 		return;
		// 	}
		
		// 	chAge.setDate($("#year").val(),$("#month").val(),$("#date").val());
		// 	var age = chAge.countUniversalAge();
		// 	if(age < 15) {
		// 		alert("죄송합니다. 만 14세 미만은 가입하실 수 없습니다.");
		// 		return;
		// 	}
		// <? } ?>
		// 주소
		// if(!$("#hero_address_01").val()) {
		// 	alert("우편번호를 입력하세요.");
		// 	$("#hero_address_01").css("border-bottom","1px solid #f00");
		// 	$("#hero_address_01").focus();
		// 	return;
		// }

		// if(!$("#hero_address_02").val()) {
		// 	alert("주소를 입력하세요.");
		// 	$("#hero_address_02").css("border-bottom","1px solid #f00");
		// 	$("#hero_address_02").focus();
		// 	return;
		// }

		// if(!$("#hero_address_03").val()) {
		// 	alert("상세주소를 입력하세요.");
		// 	$("#hero_address_03").css("border-bottom","1px solid #f00");
		// 	$("#hero_address_03").focus();
		// 	return;
		// }	

		//nextStep(2);
		$("#form_next").attr("action","join_action.php").submit();
		return true;
	}
	//계정생성 선택 유효성검사 - 최종 가입 submit
	function go_submit (form) {
		$("#hero_blog_00").css("border-bottom","1px solid #ccc");
		$("input[name='hero_qs_08']").css("border-bottom","1px solid #ccc");
		<? if(!$_SESSION["auth"]["hero_name"]) {?>
			$("input[name='hero_name']").css("border-bottom","1px solid #ccc");
		<? } ?>


		if($("input:radio[name='area']:checked").val() == "기타") {
			if(!$("input[name='area_etc_text']").val()) {
				alert("AK Lover를 알게된 경로 기타 선택 시 내용을 입력해 주세요.");
				$("input[name='area_etc_text']").focus();
				$("input[name='area_etc_text']").css("border-bottom","1px solid #f00");
				return;
			}
		}

		if($("#hero_user_r_id").val() == $("#hero_id").val() || $("#hero_user_r_nick").val() == $("#hero_nick_02").val()) {
			alert("본인을 추천인으로 추천할 수 없습니다.");
			return;
		}

		// var hero_sns_url_check = true;
		// if($("input:radio[name='hero_qs_01']:checked").val() == "Y") {
		// 	hero_sns_url_check = false;
		// 	$(".hero_sns_url").each(function(i){
		// 		if($(this).val()) {
		// 			hero_sns_url_check = true;
		// 		}
		// 	})
			
		// 	if(form_next.hero_naver_influencer.value!='') {
		// 		if(form_next.hero_naver_influencer_name.value=='') {
		// 			alert("인플루언스명 입력이 필요합니다.");
		// 			$("#hero_naver_influencer_name").css("border-bottom","1px solid #f00");
		// 			$("#hero_naver_influencer_name").focus();
		// 			return false;
		// 		} else {
		// 			if(form_next.hero_naver_influencer_category.value=='') {
		// 				alert("인플루언스 카테고리 선택이 필요합니다.");
		// 				return false;
		// 			}
		// 		}
		// 	} else {
		// 		form_next.hero_naver_influencer_name.value = '';
		// 		form_next.hero_naver_influencer_category.value = '';
				
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
		// 	$("#hero_blog_00").css("border-bottom","1px solid #f00");
		// 	$("#hero_blog_00").focus();
		// 	return;
		// }

		// if($("input:radio[name='hero_qs_03']:checked").val() == "Y") {
		// 	if(!$("input:radio[name='hero_qs_04']").is(":checked")) {
		// 		alert("자녀수를 선택해 주세요.");
		// 		return;
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
		// 		return;
		// 	}
		// }

		// if($("input:radio[name='hero_qs_07']:checked").val() == "Y") {
		// 	if(!$("input[name='hero_qs_08']").val()) {
		// 		alert("AK LOVER외 활동하는 서포터즈/체험단 카페 또는 홈페이지를 입력해주세요.");
		// 		$("input[name='hero_qs_08']").focus();
		// 		$("input[name='hero_qs_08']").css("border-bottom","1px solid #f00");
		// 		return;
		// 	}	
		// }

		$("#form_next").attr("action","join_action.php").submit();

	}
	/*	
		musign end
	*/

</script>
<?include_once "tail.php";?>