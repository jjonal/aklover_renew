<? include_once "head.php";?>
<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">

<!-- [���߿�û] ���ο��� �и��ؿ�. ��� Ȯ�� �ʿ� -->
<?
if($_SESSION['temp_level']>0)	error_location("�̹� �α��� �Ǿ����ϴ�.","/m/main.php");

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
		//�α��� ��ư ����
		if($_GET['board']=='login'){
			echo "$('.flap').click();";
		}
?>
});
</script>
<?
	if(!strcmp($_SESSION['temp_code'],'') && !$_SESSION["global_code"]){
?>
<div id="extruderBottom" class="{title:'�α��� & ȸ������'}">
<script type="text/javascript">
function go_submit(form) {
	var form = document.loginForm
	var id = form.hero_id;
	var pw_01 = form.hero_pw;
    if(id.value.length < 4){
        alert("���̵� �Է��ϼ���");
        id.style.border = '1px solid red';
        id.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
        return false;
    }else if(id.value.length > 20){
        alert("���̵� �Է��ϼ���");
        id.style.border = '1px solid red';
        id.focus();//    document.getElementById("input_chat").focus();//    login_form.login_id.focus()
        return false;
    }else{
        id.style.border = '';
    }
//##################################################################################################################################################//
    if(pw_01.value == ""){
        alert("��й�ȣ�� �Է��ϼ���.");
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
    //�����϶��� �α���
    if(event.keyCode == 13) go_submit();
}
</script>
<div class="contents_area login_wrap mu_member">
	<div class="page_title t_c">
		<h2 class="fz48 fw500 main_c">�α��� / ȸ������</h2>
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
                        <!-- <div class="fz36 bold tit">�α���</div> -->
                        <div class="id_input_wrap">
                            <div>
                                <p class="fz16 fw500">���̵�</p>
                                <input type="text" autocomplete="off" class="form-control" name="hero_id" id="hero_id" placeholder="���̵� �Է��� �ּ���." value="<?=$_COOKIE['cookie_hero_id']?>">
                            </div>
                            <div>
                                <p class="fz16 fw500">��й�ȣ</p>
                                <input type="password" onkeyup="pw_submit(this)" autocomplete="off" class="form-control" name="hero_pw" id="hero_pw" placeholder="��й�ȣ�� �Է��� �ּ���.">
                            </div>
                        </div>
                    </dd>
                </dl>
                <div class="f_b">
                    <div class="idSaveBox input_chk">
                        <input type="checkbox" name="hero_save" id="hero_save" value="true" <?=$check;?>>
                        <label for="hero_save" class="input_chk_label fz14 fw500">���̵� ����</label>
                    </div>
                    <p class="menuBox">
                        <button type="button" class="fz14 fw600" onClick="location.href='/m/searchIdPw.php?board=findpw'">���̵�/��й�ȣ ã��</button>
                    </p>
                </div>
				<!-- 240904 �α��� ���� �ϴ� �ڵ� �ּ� ���� �� ���� �۵� ���� -->
                <a href="javascript:;" onClick="go_submit()" class="btn_login btn_submit btn_color wid">�α���</a>
				<!-- <a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29" class="btn_login btn_submit btn_color wid">�α���</a> -->
                <div class="snsLoginForm t_c">
                    <p class="fz13 bold">SNS �������� �α���</p>
                    <div class="snsBox f_c">
                        <a href="javascript:;" onclick="loginKakao('login');"  class="btn_kakao"><img src="/img/front/member/kakaolog.webp" alt="īī�� �α���"></a>
                        <span class="bar"></span>
                        <div id="naver_id_login" class="btn_naver rel">���̹��α���</div>
                        <span class="bar"></span>
                        <a href="javascript:;" id="btn_google" class="btn_google"><img src="/img/front/member/googlelog.webp" alt="���� �α���"></a>
                    </div>
                </div>
				<!-- <div class="snsLoginForm t_c">
                    <p class="fz13 bold">SNS �������� �α���</p>
                    <div class="snsBox f_c">
                        <a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29" class="btn_kakao"><img src="/img/front/member/kakaolog.webp" alt="īī�� �α���"></a>
                        <span class="bar"></span>
                        <div class="btn_naver rel"><a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29"></a></div>
                        <div id="naver_id_login" class="btn_naver rel dis-no">���̹��α���</div>
						<span class="bar"></span>
                        <a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29" class="btn_google"><img src="/img/front/member/googlelog.webp" alt="���� �α���"></a>
                    </div>
                </div> -->
			</div>
			<div class="joinbox">
				<div class="fz36 bold tit">ȸ������</div>
				<div class="info">
					<p class="fz14 fw300">ȸ�������� �Ͻø� AK Lover�� �پ��� ������ ������ �� �ֽ��ϴ�.<br>���� �ٷ� �������ּ���!</p>
					<div class="join_benefit">
						<ul class="grid_2">
							<li><img src="/img/front/member/join1.png" alt="������" style="width: 10px;">��ǰ ü��</li>
							<li><img src="/img/front/member/join7.png" alt="������" style="width: 12px;">�Һ��� ����</li>
							<li><img src="/img/front/member/join6.png" alt="������" style="width: 12px;">�̴��� AK Lover</li>
							<li><img src="/img/front/member/join3.png" alt="������" style="width: 11px;">�̴��� �̺�Ʈ</li>
							<li><img src="/img/front/member/join2.png" alt="������" style="width: 12px;">����Ʈ �佺Ƽ��</li>
							<li><img src="/img/front/member/join5.png" alt="������" style="width: 10px;">�����н� �̿��</li>
							<li><img src="/img/front/member/join8.png" alt="������" style="width: 13px;">AK Lover ����Ʈ ����</li>
							<li><img src="/img/front/member/join4.png" alt="������" style="width: 11px;">AK Lover`s Day</li>
						</ul>
					</div>
				</div>
				<a href="/m/guide_1.php" class="btn_submit btn_line wid">AK Lover �˾ƺ���</a>
<!--				<button type="button" class="btn_submit btn_black wid" onClick="location.href='/m/.php'">ȸ������</button>-->
				<button type="button" class="btn_submit btn_black wid" onClick="location.href='/m/joinCheck.php?board=idcheck'">ȸ������</button>
				<!-- <button type="button" class="btn_submit btn_black wid" onClick="location.href='/m/joinCheck.php?board=idcheck'">ȸ������</button> -->
				<p class="benefit fz12 bold">* ȸ�������� �Ͻø� 1,000p�� ���޵˴ϴ�!</p>
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

		// (s)210203 google ����
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
	    // (e)210203 google ����
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
	            title: "�ڼ��� ����",
	            link: {
	              mobileWebUrl: snsUrl,
	              webUrl: snsUrl
	            }
	          }
	        ]
	      });
	}

    function fnSnsInfo(){
		 if(confirm('�������� ȭ�鿡�� SNS �α����� �̿��� �� �����ϴ�.\n���������� �̵� �� SNS �α��� �̿� �����մϴ�.\n������������ �̵��Ͻðڽ��ϱ�?')) {
		 		location.href = "/m/main.php";
		 }
    }
</script>
<?include_once "tail.php";?>