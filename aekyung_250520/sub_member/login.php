<?
if(!defined('_HEROBOARD_'))exit;

if($_SESSION['temp_level']>0)	error_location("이미 로그인 되었습니다.","/main/index.php");

if($_COOKIE['cookie_hero_id']) {
	$check = "checked";
} else {
	$check = "";
}
?>

<link rel="stylesheet" type="text/css" href="/css/front/member.css" />

<div class="contents_area login_wrap mu_member">
    <div class="page_title t_c">
        <h2 class="fz48 fw500 main_c">로그인 / 회원가입</h2>
    </div>

    <div class="contents">
    	<form name="loginForm" id="loginForm" action="<?=PATH_HOME_HTTPS?>?board=login_check" enctype="multipart/form-data" method="post" onsubmit="return false;">
		<input type="hidden" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>">
		<input type="hidden" name="snsId">
		<input type="hidden" name="snsType">
        <div class="cont_wrap f_sc">
			<div class="loginbox">
				<div class="loginForm">
					<dl class="inputBox">
						<dd>
							<div class="fz36 bold tit">로그인</div>
							<div class="id_input_wrap">
								<div>
									<p class="fz16 fw500">아이디</p>
									<input type="text" name="hero_id" id="hero_id" class="c2 enterArea" style="ime-mode:disabled;" maxlength="20" value="<?=$_COOKIE['cookie_hero_id']?>" placeholder="아이디를 입력해 주세요.">
								</div>
								<div>
									<p class="fz16 fw500">비밀번호</p>
									<input type="password" name="hero_pw" id="hero_pw" class="c4 enterArea" placeholder="비밀번호를 입력해 주세요.">
								</div>
							</div>
						</dd>
					</dl>
					<div class="f_b">
						<div class="idSaveBox input_chk">
							<input type="checkbox" name="chk_id_cookie" id="chk_id_cookie" value="true" <?=$check?> />
							<label for="chk_id_cookie" class="input_chk_label fz14 fw500">아이디 저장</label>
						</div>
						<p class="menuBox">
							<a href="<?=PATH_HOME_HTTPS?>?board=findpw" class="fz14 fw600">아이디 찾기/비밀번호 찾기</a>
							<!-- <a href="<?=PATH_HOME_HTTPS?>?board=findpw" class="fz14 fw600 rel"></a> -->
						</p>
					</div>
					<!-- 240904 로그인 제한 하단 주석, 하단 네이버 로그인 스크립트 주석 해제 후 정상 작동 가능 -->
					<a href="javascript:;" onClick="go_submit()" class="btn_login btn_submit btn_color wid">로그인</a>
					<div class="snsLoginForm t_c">
						<p class="fz13 bold">SNS 계정으로 로그인</p>
						<div class="snsBox f_c">
							<a href="javascript:loginKakao('login')" class="btn_kakao"><img src="/img/front/member/kakaolog.webp" alt="카카오 로그인"></a>
							<span class="bar"></span>
							<div id="naver_id_login" class="btn_naver rel">네이버로그인</div>
							<span class="bar"></span>
							<a href="javascript:;" id="btn_google" class="btn_google"><img src="/img/front/member/googlelog.webp" alt="구글 로그인"></a>
						</div>
					</div>
				</div>
        	</div>
			<div class="joinbox">				
				<div class="fz36 bold tit">회원가입</div>			
				<div class="info">
					<p class="fz14 fw300">회원가입을 하시면 AK Lover의 다양한 혜택을 받으실 수 있습니다.<br>지금 바로 가입해주세요!</p>
					<div class="join_benefit">
						<ul class="grid_2">
							<li><img src="/img/front/member/join1.png" alt="아이콘" style="width: 10px;">제품 체험</li>
							<li><img src="/img/front/member/join7.png" alt="아이콘" style="width: 12px;">소비자 조사</li>
							<li><img src="/img/front/member/join6.png" alt="아이콘" style="width: 12px;">이달의 AK Lover</li>
							<li><img src="/img/front/member/join3.png" alt="아이콘" style="width: 11px;">이달의 이벤트</li>
							<li><img src="/img/front/member/join2.png" alt="아이콘" style="width: 12px;">포인트 페스티벌</li>
							<li><img src="/img/front/member/join5.png" alt="아이콘" style="width: 10px;">슈퍼패스 이용권</li>
							<li><img src="/img/front/member/join8.png" alt="아이콘" style="width: 13px;">AK Lover 포인트 제공</li>
							<li><img src="/img/front/member/join4.png" alt="아이콘" style="width: 11px;">AK Lover`s Day</li>
						</ul>
					</div>
				</div>
				<a href="/main/index.php?board=group_04_01" class="btn_submit btn_line wid">AK Lover 알아보기</a>
<!--				<a id="loginHightlight" href="--><?php //=PATH_HOME_HTTPS?><!--?board=signup" class="btn_submit btn_black wid">회원가입</a>-->
                <!-- musign 최해성 20240416 임시소스 인증 제외하고 href 원래대로 해놔야 함-->
                <a id="loginHightlight" href="<?=PATH_HOME_HTTPS?>?board=idcheck" class="btn_submit btn_black wid">회원가입</a>
				<p class="benefit fz12 bold">* 회원가입을 하시면 1,000p가 지급됩니다!</p>
			</div>
        </div>
        </form>
    </div>
</div>

<!-- sns -->
<!--<script type="text/javascript" src="<?=JS_END;?>jquery.cookie.js" ></script>-->
<!--<script type="text/javascript" src="/js/jquery.cookie.js" ></script>-->
<!--<script type="text/javascript" charset="utf-8" src="https://static.nid.naver.com/js/naverLogin.js" ></script>-->
<!--<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>-->
<!-- <script type="text/javascript" src="<?=JS_END;?>snsInit.js"></script> -->
<!--<script type="text/javascript" src="/js/snsInit.js"></script>-->
<script src="https://apis.google.com/js/api:client.js"></script>
<script type="text/javascript">
<? if(!$_SESSION['temp_code']) {?>
	var naver_id_login = new naver_id_login(naver.client_id,"<?=getSnsDomain()?>/main/index.php?board=login&");
    var edit_access_token = naver_id_login.oauthParams.board.split("login#access_token=");

	var naver_access_token = edit_access_token[1];

	naver_id_login.oauthParams.access_token = naver_access_token;

	var state = naver_id_login.getUniqState();

	if(!naver_id_login.oauthParams.access_token) {
		naver_id_login.setButton("green", 3, 40);
		naver_id_login.setDomain("https://aklover.co.kr");
		naver_id_login.setState(state);
		//naver_id_login.setPopup();
		naver_id_login.init_naver_id_login();
	}

	if(naver_id_login.oauthParams.access_token) {
		console.log("access_token ok");
        console.log("access_tttt");
		naver_id_login.get_naver_userprofile("naverSignInCallback()");
	}

	function naverSignInCallback() {
		console.log("naverSignInCallback");
		where = "login";
		snsType = "naver";
		var response = {"id":naver_id_login.getProfileData('id')};
		afterLogin.login(response);
	}
<? } ?>


	$(document).ready(function(){
		var focus_chk = '<?=$_GET['focus']?>';
		if(focus_chk == "pw") {
			$('#hero_pw').focus();
		}else {
			$('#hero_id').focus();
		}

		$('#hero_pw').keypress(function(e){
			  if(event.keyCode == 13){
				  e.preventDefault();
				  go_submit();
			  }
		});

	});

	function go_submit() {
	    var id = document.loginForm.hero_id;
	    var pw_01 = document.loginForm.hero_pw;

	    if(id.value.length < 4){
	        alert("아이디를 입력하세요");
	        id.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
	        return false;

	    }else if(id.value.length > 20){
	        alert("아이디를 입력하세요");
	        id.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
	        return false;

	    }else{
	        id.style.border = '';
	    }


	    if(pw_01.value == ""){
	        alert("비밀번호를 입력하세요.");
	        pw_01.focus();
	        return false;

	    }else{
	        pw_01.style.border = '';
	    }

	    document.loginForm.submit();
	    return true;
	}

	// (s)210203 google 연동
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
          	$("#loginForm input[name='snsId']").val(googleUser.getBasicProfile().getId());
          	$("#loginForm input[name='snsType']").val("google");
          	//$("#loginForm").submit();
          	document.loginForm.submit();
    	    return true;
          }, function(error) {
        	//alert(JSON.stringify(error, undefined, 2));
              console.log(JSON.stringify(error, undefined, 2));
          });
    }

    startApp();
    // (e)210203 google 연동
</script>
