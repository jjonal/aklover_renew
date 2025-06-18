<? 
include_once "head.php";

// 회원가입 임시작업 s 
 if(!$_SESSION['temp_level'] || $_SESSION['temp_level']<9999){
 	if((!$_POST['param_r5'] || !$_POST['param_r6']) && (!$_POST['snsId'] || !$_POST['snsType'])){
	
 		if($_GET["tempNoAuth"] != "Y") {
 			error_historyBack("잘 못된 접근입니다.");
 			exit;
 		} else {
 			$_POST['param_r5'] = "tempNoAuth".date("YmdHis");
 			$_POST['param_r6'] = "tempNoAuth".date("YmdHis");
 			$di = $_POST['param_r5'];
 			$ci = $_POST['param_r6'];
 			$_POST["param_r1"] = "테스트이름명";
 		}
 	}
	
 	if($_POST['param_r5'] && $_POST['param_r6']){ //본인인증 di,ci
 		$_SESSION["auth"]["hero_name"]   = $_POST["param_r1"];
 		$_SESSION["auth"]["hero_jumin"]  = $_POST["param_r2"];
 		$_SESSION["auth"]["hero_sex"]    = $_POST["param_r3"];
 		$_SESSION["auth"]["hero_info_type"]   = $_POST["param_r4"];
 		$_SESSION["auth"]["hero_info_di"]   = $_POST["param_r5"];
 		$_SESSION["auth"]["hero_info_ci"]   = $_POST["param_r6"];
		
 		$sql = " SELECT count(*) FROM member WHERE hero_info_di='".$_POST['param_r5']."' AND hero_info_ci='".$_POST['param_r6']."' and hero_use=0";
 	} else if($_POST['snsId'] && $_POST['snsType']) {  //sns 가입
 		$_SESSION["auth"]["snsId"]   = $_POST["snsId"];
 		$_SESSION["auth"]["snsType"]  = $_POST["snsType"];
 		$_SESSION["auth"]["snsEmail"]  = $_POST["snsEmail"];
		
 		$snsType = $_POST["snsType"];
		
 		switch($snsType){
 			case "kakaoTalk" : $snsText = "<p style='padding-bottom: 2rem; font-size: 12px;'><img src='/img/front/member/kakaolog.webp' alt='".$snsType."' style='width: 33px; margin-right: .5rem'> 회원님의 카카오톡이 연동되었습니다</p>";break;
 			case "naver" : $snsText = "<p style='padding-bottom: 2rem; font-size: 12px;'><img src='/img/front/member/naverlog.webp' alt='".$snsType."' style='width: 33px; margin-right: .5rem'> 회원님의 네이버 아이디가 연동되었습니다</p>";break;
 			case "google" : $snsText = "<p style='padding-bottom: 2rem; font-size: 12px;'><img src='/img/front/member/googlelog.webp' alt='".$snsType."' style='width: 33px; margin-right: .5rem'> 회원님의 구글 아이디가 연동되었습니다</p>";break;
 		}
		
 		$sql = "SELECT count(*) from member WHERE hero_".$_POST['snsType']."= md5('".$_POST['snsId']."') and hero_use=0";
 	}

 	$res = new_sql($sql,$error,"on");
 	$check_member = mysql_result($res,0,0);
	
 	if($check_member>0){
 		error_location("이미 가입하셨습니다.","/m/searchIdPw.php?board=findpw");
 		exit;
 	}
	
 	//휴먼정보 체크
 	if($_POST['param_r5'] && $_POST['param_r6']){
 		$sql1 = "SELECT count(*) FROM member_backup WHERE hero_info_di='".$_POST['param_r5']."' and hero_info_ci='".$_POST['param_r6']."'";
 	}else if($_POST['snsId'] && $_POST['snsType']){
 		$sql1 = "SELECT count(*) FROM member_backup WHERE hero_".$_POST['snsType']."=MD5('".$_POST['snsId']."')";
 	}
	
 	$out_sql1 = new_sql($sql1,$error);
	
 	$count1 = mysql_result($out_sql1,0,0);
 	if($count1>0){
 		error_location("해당 회원은 휴면 상태입니다.ID/PW찾기를 통해 로그인 하여 주십시오.","/m/searchIdPw.php?board=findpw");
 		exit;
 	}
	
 	//나이제한 체크
 	if($_POST['param_r5'] && $_POST['param_r6'] && $_POST['param_r2']){
 		$param_r2_01 = substr($_POST['param_r2'], '0', '4');//년
 		$param_r2_02 = substr($_POST['param_r2'], '4', '2');//월
 		$param_r2_03 = substr($_POST['param_r2'], '6', '2');//일
		
 		if(!$param_r2_01 || !$param_r2_02 || !$param_r2_03){
 			error_location("시스템 오류입니다. 다시 시도해주세요","/m/joinCheck.php");
 			exit;
 		}
		
 		include_once $_SERVER['DOCUMENT_ROOT']."/classGathered/chAgeClass.php";
 		$chAgeClass = new chAgeClass($param_r2_01,$param_r2_02,$param_r2_03);
 		$age = $chAgeClass->countUniversalAge();
 		if((int)$age<15){
 			error_location("만14세 미만은 가입하실 수 없습니다.","/m/main.php");
 			exit;
 		}
 	}
 }
// 회원가입 임시작업 e


$group_sql = " SELECT * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."' "; // desc
$out_group = new_sql( $group_sql,$error );
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}
$right_list = mysql_fetch_assoc ( $out_group );
?>
<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">
<div class="contents_area mu_member join_wrap">	
	<div class="page_title t_c">
        <h2 class="fz48 fw500 main_c">회원가입</h2>
		<p class="subtit fz12">AK Lover의 다양한 서포터즈를 경험하세요!</p>
		<div class="bread">
			<ul class="f_c">
				<li>본인인증</li>
				<li class="arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<li class="on">이용약관 동의</li>
				<li class="arr on"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<li>계정 생성(필수)</li>
				<!-- <li class="arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li><br /> -->
			</ul>
			<ul class="f_c">				
				<!-- <li>계정 생성(선택)</li> -->
				<li class="arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li> 
				<li>회원가입 완료</li>
			</ul>
		</div>
    </div>
	<div class="signup_wrap">
		<div class="contents">
			<form name="form0" id="form0" method="post">
				<input type="hidden" name="tempNoAuth" value="<?=$_GET["tempNoAuth"]?>" /><!-- 회원가입 테스트 용도 인증 무시 -->
				<?=$snsText?>
				<div class="signup_term line_input">
					<div class="signup_term_title fz16 fw600">애경산업 서비스 회원 약관</div>
					<div class="all_agree agree_list input_chk">
					<input type="checkbox" id="necessary"> 
					<label for="necessary" class="input_chk_label">애경산업의 모든 약관을 확인하고 전체 동의합니다.</label>
					<p class="desc">
							전체동의는 필수 및 선택정보에 대한 동의도 포함되어 있으며, 
							개별적으로도 동의를 선택하실 수 있습니다.
							선택항목에 대한 동의를 거부하는 경우에도 회원가입 서비스는 이용 가능합니다.
						</p>
					</div>
					<div class="agree_list input_chk">
						<input type="checkbox" name="agree_service" id="agree_service_y" value="Y" />
						<label for="agree_service_y" class="input_chk_label"><span class="fz14 bold main_c">필수*</span>이용약관에 동의합니다.</label>
						<!-- <input type="radio" name="agree_service" id="agree_service_n" value="N" /><label for="agree_service_n">동의안함 -->
						<div class="term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">서비스 이용약관 (필수)</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
								<div class="scrollbx"><?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term1_2.php";?></div>
							</div>	
						</div>
						<div class="all_view">전체보기</div>
					</div>
					<div class="agree_list input_chk">
					<input type="checkbox" name="agree_privacy" id="agree_privacy_y" value="Y" />					
						<label for="agree_privacy_y" class="input_chk_label"><span class="fz14 bold main_c">필수*</span>개인정보 수집<b></b>이용동의 필수 항목</label>
						<!-- <input type="radio" name="agree_privacy" id="agree_privacy_n" value="N" />동의안함 -->
						<div class="term table_term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">개인정보 수집 동의 (필수)
								<p class="fz24">* 해당 개인정보 수집 및 이용에 동의하지 않을 권리가 있으며,<br /> 동의하지 않을 경우 회원가입이 불가합니다.
								</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>							
								<div id="term4" class="scrollbx">
									<table border="1" cellspacing="0" cellpadding="2">
										<tr>
											<td>수집<br />항목</td>
											<td>아이디, 비밀번호, 이름, 닉네임, 생년월일, 이메일, 휴대폰번호, 주소,
											본인인증 값(휴대폰인증), <br>
											SNS 로그인 인증시 <br>
											- 카카오톡 : 카카오톡에서 제공하는 고유아이디<br/>
											- 네이버 : 네이버에서 제공하는 고유아이디, 이메일<br/>
											- 구글 : 구글에서 제공하는 고유아이디, 이메일</td>
											<td>이름, 닉네임, 휴대폰번호</td>
										</tr>
										<tr>
											<td>수집 및<br /> 이용<br />목적</td>
											<td>서비스 이용에 따른 본인식별, 가입연령 확인, 회원의 부정이용 방지,<br/>
											고객 문의에 대한 답변, 본인의사확인, 불만처리 등을 위한 의사소통 경로 확보,<br/>
											사업 및 정책 안내, 회원이 참여한 체험단 활동에 관한 정보 제공 및 그에 따른 경품 배송</td>
											<td>회원 탈퇴 후 고객문의에 대한 답변,<br/>
												불만 처리를 위한 의사소통 경로 확보,<br/>
												서비스 부정 이용방지</td>
										</tr>
										<tr>
											<td>이용 및<br /> 보유<br /> 기간</td>
											<td>동의 철회 시 혹은 회원 탈퇴 시까지</td>
											<td>회원탈퇴 후 1년간 보관</td>
										</tr>
									</table>
								</div>								
							</div>	
						</div>						
						<div class="all_view">전체보기</div>
					</div>
					<!-- <div class="agree_list input_chk">
					<input type="checkbox" name="selectAgreePrivacy" id="selectAgreePrivacy_y" value="Y" />		
						<label for="selectAgreePrivacy_y" class="input_chk_label">개인정보 수집<b></b>이용동의 선택항목 (선택)</label>
						<div class="term table_term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">개인정보 수집 동의 (선택)
									<p class="fz24">해당 개인정보 수집 및 이용에 대해서 동의하지 않을 권리가 있으며 동의하지 않으실 경우에도 회원가입은 가능합니다.<br />
									단, 특정 서비스의 이용이 제한될 수 있습니다.</p>
								</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>							
								<div id="term4" class="scrollbx">
									<table border="1" cellspacing="0" cellpadding="2">
										<tr>
											<td>수집<br />항목</td>
											<td>
											※ 아래 항목 중 회원이 기입하는 항목<br/>
											AK LOVER를 알게된 경로는?, 추천인 아이디 또는 닉네임,<br/> 
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
											, 기타 URL 
											결혼유무, 자녀 유무/태어난 년도,<br/> 
											탈모 유무, 반려동물 유무, 건조기 유무, 식기세척기 유무,<br/> 
											AK LOVER 에 가입한 이유, AK LOVER외 활동하는 서포터즈/체험단 카페 또는 홈페이지
											</td>
											<td>휴대폰번호</td>
											<td>이메일</td>
										</tr>
										<tr>
											<td>수집 및<br /> 이용<br /> 목적</td>
											<td>원활한 체험단 활동 모니터링/개인 특성에 따른 체험단 활동 지원<br />
											신규 서비스 개발,, 이벤트 및 광고성 정보 제공 및 참여기회 제공,<br />
											인구통계학적 특성에 따른 서비스 제공 및 광고 게재, 서비스의 유효성 확인,<br />
											접속빈도 파악 또는 회원의 서비스 이용에 대한 통계 확인의 목적</td>
											<td colspan="2">각종 이벤트, 행사 관련 정보안내 및 제반 마케팅 활동,<br/> 
											당사 상품/서비스 안내 및 권유</td>
										</tr>
										<tr>
											<td>이용 및<br /> 보유<br />기간</td>
											<td colspan="3">회원탈퇴 및 동의거부시까지</td>
										</tr>
									</table>
								</div>				
							</div>	
						</div>	
						<div class="all_view">전체보기</div>
					</div> -->
					<div class="agree_list agree_depth2 line_input input_chk">
						<input type="checkbox" id="event_agree" name="event_agree" class="" value=''/>
						<label for="event_agree" class="input_chk_label">각종 이벤트, 체험단, 행사 관련 정보 안내 및 제반 마케팅 활동, 당사 상품/서비스 안내 및 권유(선택)</label>
						<div>
							<input type="checkbox" name="selectAgreePhone" id="selectAgreePhone_y" value="Y" />
							<label for="selectAgreePhone_y" class="input_chk_label">SMS 수신 동의 (선택)</label>
							<!-- <input type="radio" name="selectAgreePhone" id="selectAgreePhone_n" value="N" />동의안함 -->
						</div>	
						<div>
							<input type="checkbox" name="selectAgreeEmail" id="selectAgreeEmail_y" value="Y" />
							<label for="selectAgreeEmail_y" class="input_chk_label">이메일 수신 동의 (선택)</label>
							<!-- <input type="radio" name="selectAgreeEmail" id="selectAgreeEmail_n" value="N" />동의안함 -->
						</div>
					</div>				
					<div class="agree_list">
						<p class="fz14 fw500 gray07">필수 위탁업무</p>	
						<div class="term table_term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">필수 위탁업무</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>							
								<div class="scrollbx"><?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term7.php";?></div>
							</div>	
						</div>	
						<div class="all_view">전체보기</div>
					</div>					
					<div class="btn_bx f_c">
						<a href="javascript:;" onClick="fnJoin();" class="btn_submit btn_black">다음으로</a>
					</div>	
				</div>
			</form>
		</div>
	</div>	
</div>
<script>
$(document).ready(function(){
	// musign 
	// 전체 동의시 
	$('#necessary').change(function () {
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
			$('body').addClass('nonscroll');
		});
	});
	// 전체동의 팝업 닫기
	$('.term .btn_x').click(function(){
		$(this).parents('.term').addClass('dis-no');
        $('body').removeClass('nonscroll');
	});
})

function fnJoin() {
	if($("input:checkbox[name='agree_service']:checked").val() != 'Y') {
		alert("서비스 이용약관에 동의해주세요.");
		return;
	}
	if($("input:checkbox[name='agree_privacy']:checked").val() != 'Y') {
		alert("개인정보 수집·이용동의에 동의해주세요.");
		return;
	}
	$("#form0").attr("action","join.php?board=signup").submit();
}
</script>
<?include_once "tail.php";?>