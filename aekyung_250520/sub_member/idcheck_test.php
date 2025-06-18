<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

if($_SESSION['temp_code']){
	error_historyBack("로그인이 되어 있습니다. 로그 아웃 후에 다시 시도해 주세요.");
	exit;
}

//인증 후 이동할 페이지
$authWhere = "signup";
include_once $_SERVER['DOCUMENT_ROOT']."/combined/authInit_test.php";
?>
	
    <div class="contents_area">
        <div class="page_title">
            <h2>회원가입</h2>
            <ul class="nav">
                <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
                <li>&gt;</li>
                <li class="current">회원가입</li>
            </ul>
        </div>
        <div class="contents">
        	<div id="signup_confirm">
        	
        		<p class="confirm"><span>l</span>본인인증</p>
        		<form name="form_chk" method="post">
	                <input type="hidden" name="m" value="checkplusSerivce">
	                <input type="hidden" name="EncodeData" value="<?= $enc_data ?>">
	                <input type="hidden" name="m" value="pubmain">
	                <input type="hidden" name="enc_data" value="<?= $sEncData ?>">
	                <input type="hidden" name="wheretogo" value="signup">
	                <input type="hidden" name="param_r1" value="">
	                <input type="hidden" name="param_r2" value="">
	                <input type="hidden" name="param_r3" value="">
	                <input type="hidden" name="param_r4" value="">
	                <input type="hidden" name="param_r5" value="">
	                <input type="hidden" name="param_r6" value="">
					<table class="confirm_table1" width="725px" height="178px" >
				 		<tr>
				  			<td colspan="2" class="tb_title"><p class="name">본인 인증</p></td>
				 		</tr>
				 		<tr>
				  			<td class="tb_content" align="center">
				  				<a href="javascript:auth.hp_Popup(this.form_chk);">
				  					<img src="/image2/main/01_signup_confirm01.jpg" alt="핸드폰 인증" border="0" >
				  				</a>
				  			</td>
				  			<td class="tb_content" align="center">
				  				<a href="javascript:auth.ip_Popup(this.form_chk);">
				  					<img src="/image2/main/01_signup_confirm02.jpg"  alt="I-PIN 인증" border="0" >
				  				</a>
				  			</td>
				 		</tr>
					</table>
				</form>
				<br>
				<p class="confirm"><span>l</span>SNS 인증</p>
				<form name="idcheckForm" method="post" action="/main/index.php?board=signup">
					<input type="hidden" name="snsType">
                	<input type="hidden" name="snsId">
                	<input type="hidden" name="snsEmail">
				</form> 
				<table  class="confirm_table1" width="725px" height="178px">
					 <tr>
						  <td colspan="3" class="tb_title"><p class="name">SNS 인증</p></td>
			 		</tr>
			 		<tr>
			 			<td class="tb_content" align="center">
			  				<a href="javascript:loginFB('idcheck');">
			  					<img src="/image2/etc/snsBig01.jpg" alt="페이스 북 아이콘" border="0" ></a>
			  					<br><p class="sns_name">페이스북</p>
			  				</a>
			  			</td>
			  			<td class="tb_content" align="center">
			  				<p class="line"><img src="/image2/etc/line.png"></p>
						  	<a href="javascript:loginKakao('idcheck');">
						  		<img src="/image2/etc/snsBig02.jpg" alt="카카오톡 아이콘" border="0" >
						  	</a>
			  				<p class="sns_name">카카오톡</p>
			  			</td>
			  			<td class="tb_content" align="center">
					  	  <p class="line"><img src="/image2/etc/line.png"></p>
			  				<a id="naver_id_login"></a>
			  				<br>
			  				<p class="sns_name">네이버</p></td>
			 		</tr>
				</table>
        	</div>
    </div>
    </div>
    
    <div id="naver_id_login"></div>
    <script>
		var naver_id_login = new naver_id_login(naver.client_id,"https://aklover.co.kr/main/index.php?board=idcheck&");
		var edit_access_token = naver_id_login.oauthParams.board.split("idcheck#access_token=");
		var naver_access_token = edit_access_token[1];
		naver_id_login.oauthParams.access_token = naver_access_token;
		
		if(!naver_id_login.oauthParams.access_token) {
		var state = naver_id_login.getUniqState();
			naver_id_login.setButton("green", 1,45);
			naver_id_login.setDomain("https://aklover.co.kr");
			naver_id_login.setState(state);
			//naver_id_login.setPopup();
			naver_id_login.init_naver_id_login();
		}
		
		
		
		if(naver_id_login.oauthParams.access_token) {
			naver_id_login.get_naver_userprofile("naverSignInCallback()");
		}
		
		function naverSignInCallback() {
			where = "idcheck";
			snsType = "naver";
			var response = {"id":naver_id_login.getProfileData('id'),"email":naver_id_login.getProfileData('email')};
			afterLogin.login(response);
			/*
			alert(naver_id_login.getProfileData('email'));
			alert(naver_id_login.getProfileData('nickname'));
			alert(naver_id_login.getProfileData('age'));
			*/	
		}
	
  		//sns를 위한 전역객체
	    board = "<?=$_GET['board'];?>";
	    window.name ="Parent_window";
		
		
		
	</script>
	
	
    