<? include_once "head.php";?>
<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">

<!-- [개발요청] 메인에서 분리해옴. 기능 확인 필요 -->
<?
if($_SESSION['temp_level']>0)	error_location("이미 로그인 되었습니다.","/m/main.php");

if(!defined('_HEROBOARD_'))exit;
if($_COOKIE['cookie_hero_id'])		$check = "checked";
else								$check = '';
?>
<script type="text/javascript">
$(function(){
setCookie("pcMobile","mobile",-1200);
$("#extruderBottom").buildMbExtruder({
		position:"bottom",
		sensibility : 800,
		width:'100%',
		positionFixed:true,
		extruderOpacity:0.7,
		flapDim:100,
		textOrientation:"bt",
		onExtOpen:function(){},
		onExtContentLoad:function(){},
		onExtClose:function(){},
		slideTimer:300
});
$.fn.changeLabel=function(text){
		$(this).find(".flapLabel").html(text);
		$(this).find(".flapLabel").mbFlipText();
};
<?php
		//로그인 버튼 오픈
		if($_GET['board']=='login'){
			echo "$('.flap').click();";
		}
?>
});
</script>
<?
	if(!strcmp($_SESSION['temp_code'],'') && !$_SESSION["global_code"]){
?>
<div id="extruderBottom" class="{title:'로그인 & 회원가입'}">
<script type="text/javascript">
function go_submit(form) {
	var form = document.loginForm
	var id = form.hero_id;
	var pw_01 = form.hero_pw;
    if(id.value.length < 4){
        alert("아이디를 입력하세요");
        id.style.border = '1px solid red';
        id.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
        return false;
    }else if(id.value.length > 20){
        alert("아이디를 입력하세요");
        id.style.border = '1px solid red';
        id.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
        return false;
    }else{
        id.style.border = '';
    }
//##################################################################################################################################################//
    if(pw_01.value == ""){
        alert("비밀번호를 입력하세요.");
        pw_01.style.border = '1px solid red';
        pw_01.focus();
        return false;
    }else{
        pw_01.style.border = '';
    }
        form.submit();
//##################################################################################################################################################//
    return true;
}

function pw_submit(e){
    //엔터일때만 로그인
    if(event.keyCode == 13) go_submit();
}
</script>
<div class="contents_area login_wrap mu_member">
	<div class="page_title t_c">
		<h2 class="fz48 fw500 main_c">로그인 / 회원가입</h2>
	</div>
	<div class="contents">
		<form name="loginForm" id="loginForm" action="/m/login_check.php" method="post" onsubmit="return false;" autocomplete="off">
		<input type="hidden" name="hero_page" id="hero_page" value="<?=$_SERVER['REQUEST_URI'] ?>">
		<input type="hidden" name="snsId">
		<input type="hidden" name="snsType">
		<div class="loginbox">
			<div class="loginForm">
                <dl class="inputBox">
                    <dd>
                        <!-- <div class="fz36 bold tit">로그인</div> -->
                        <div class="id_input_wrap">
                            <div>
                                <p class="fz16 fw500">아이디</p>
                                <input type="text" autocomplete="off" class="form-control" name="hero_id" id="hero_id" placeholder="아이디를 입력해 주세요." value="<?=$_COOKIE['cookie_hero_id']?>">
                            </div>
                            <div>
                                <p class="fz16 fw500">비밀번호</p>
                                <input type="password" onkeyup="pw_submit(this)" autocomplete="off" class="form-control" name="hero_pw" id="hero_pw" placeholder="비밀번호를 입력해 주세요.">
                            </div>
                        </div>
                    </dd>
                </dl>
                <div class="f_b">
                    <div class="idSaveBox input_chk">
                        <input type="checkbox" name="hero_save" id="hero_save" value="true" <?=$check;?>>
                        <label for="hero_save" class="input_chk_label fz14 fw500">아이디 저장</label>
                    </div>
                    <p class="menuBox">
                        <button type="button" class="fz14 fw600" onClick="location.href='/m/searchIdPw.php?board=findpw'">아이디/비밀번호 찾기</button>
                    </p>
                </div>
				<!-- 240904 로그인 제한 하단 코드 주석 해제 후 정상 작동 가능 -->
                <a href="javascript:;" onClick="go_submit()" class="btn_login btn_submit btn_color wid">로그인</a>
				<!-- <a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29" class="btn_login btn_submit btn_color wid">로그인</a> -->
                <div class="snsLoginForm t_c">
                    <p class="fz13 bold">SNS 계정으로 로그인</p>
                    <div class="snsBox f_c">
                        <a href="javascript:;" onclick="loginKakao('login');"  class="btn_kakao"><img src="/img/front/member/kakaolog.webp" alt="카카오 로그인"></a>
                        <span class="bar"></span>
                        <div id="naver_id_login" class="btn_naver rel">네이버로그인</div>
                        <span class="bar"></span>
                        <a href="javascript:;" id="btn_google" class="btn_google"><img src="/img/front/member/googlelog.webp" alt="구글 로그인"></a>
                    </div>
                </div>
				<!-- <div class="snsLoginForm t_c">
                    <p class="fz13 bold">SNS 계정으로 로그인</p>
                    <div class="snsBox f_c">
                        <a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29" class="btn_kakao"><img src="/img/front/member/kakaolog.webp" alt="카카오 로그인"></a>
                        <span class="bar"></span>
                        <div class="btn_naver rel"><a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29"></a></div>
                        <div id="naver_id_login" class="btn_naver rel dis-no">네이버로그인</div>
						<span class="bar"></span>
                        <a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29" class="btn_google"><img src="/img/front/member/googlelog.webp" alt="구글 로그인"></a>
                    </div>
                </div> -->
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
				<a href="/m/guide_1.php" class="btn_submit btn_line wid">AK Lover 알아보기</a>
<!--				<button type="button" class="btn_submit btn_black wid" onClick="location.href='/m/.php'">회원가입</button>-->
				<button type="button" class="btn_submit btn_black wid" onClick="location.href='/m/joinCheck.php?board=idcheck'">회원가입</button>
				<!-- <button type="button" class="btn_submit btn_black wid" onClick="location.href='/m/joinCheck.php?board=idcheck'">회원가입</button> -->
				<p class="benefit fz12 bold">* 회원가입을 하시면 1,000p가 지급됩니다!</p>
			</div>
		</div>
		</form>
	</div>
</div>
<!-- sns -->
<? } ?>
<? if(!$_SESSION['temp_code'] && $_GET["board"] != "idcheck") {?>
<script src="https://apis.google.com/js/api:client.js"></script>
<? } ?>
<script type="text/javascript">
	<? if(!$_SESSION['temp_code'] && $_GET["board"] != "idcheck" && !$_SESSION["global_code"]) {?>
		//var naver_id_login = new naver_id_login(naver.client_id,"<?=getSnsDomain()?>/main/index.php?board=login&");
		var naver_id_login = new naver_id_login(naver.client_id,"<?=getSnsDomain()?>/m/login.php");
		var state = naver_id_login.getUniqState();


		if(!naver_id_login.oauthParams.access_token) {
			naver_id_login.setButton("green", 1, 32);
			//naver_id_login.setButton("green", 1,38);
			naver_id_login.setDomain("https://aklover.co.kr");
			naver_id_login.setState(state);
			//naver_id_login.setPopup();
			naver_id_login.init_naver_id_login();
		}

		if(naver_id_login.oauthParams.access_token) {
			console.log("access_token o22k");
			//alert(naver_id_login.oauthParams.access_token);
			naver_id_login.get_naver_userprofile("naverCallback()");
			/*
			setTimeout(function() {
				alert("naver login");
				naver_id_login.get_naver_userprofile("naverSignInCallback()");
			}, 2000);
			*/
		}
		function naverCallback() {
			var response = {"id":naver_id_login.getProfileData('id')};
			//alert("naverSignInCallback");
			//alert(naver_id_login.getProfileData('id'));
			console.log(naver_id_login);
			where = "login";
			snsType = "naver";


			afterLogin.login(response);

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
	          	console.log(googleUser.getBasicProfile().getId());
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
	<? } ?>

	function KakaoDirect(snsLabel, snsDes, snsImg, snsUrl) {
		var UserAgent = navigator.userAgent;
	    var isMobile = UserAgent.match(/iPhone|iPod|Android|iPad/i);

		snsLabel = snsLabel.replace("</br>", " ");
		snsDes 	 = snsDes.replace("</br>", " ");

		snsLabel = snsLabel.replace("<br/>", " ");
		snsDes 	 = snsDes.replace("<br/>", " ");

	    Kakao.Link.sendDefault({
	        objectType: 'feed',
	        content: {
	          title: snsLabel,
	          description: snsDes,
	          imageUrl: snsImg,
	          link: {
	            mobileWebUrl: snsUrl,
	            webUrl: snsUrl
	          },
	          imageWidth: 800,
			  imageHeight: 500
	        },
	        buttons: [
	          {
	            title: "자세히 보기",
	            link: {
	              mobileWebUrl: snsUrl,
	              webUrl: snsUrl
	            }
	          }
	        ]
	      });
	}

    function fnSnsInfo(){
		 if(confirm('본인인증 화면에서 SNS 로그인은 이용할 수 없습니다.\n메인페이지 이동 후 SNS 로그인 이용 가능합니다.\n메인페이지로 이동하시겠습니까?')) {
		 		location.href = "/m/main.php";
		 }
    }
</script>
<?include_once "tail.php";?>