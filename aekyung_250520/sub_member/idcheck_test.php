<?
####################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

if($_SESSION['temp_code']){
	error_historyBack("�α����� �Ǿ� �ֽ��ϴ�. �α� �ƿ� �Ŀ� �ٽ� �õ��� �ּ���.");
	exit;
}

//���� �� �̵��� ������
$authWhere = "signup";
include_once $_SERVER['DOCUMENT_ROOT']."/combined/authInit_test.php";
?>
	
    <div class="contents_area">
        <div class="page_title">
            <h2>ȸ������</h2>
            <ul class="nav">
                <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
                <li>&gt;</li>
                <li class="current">ȸ������</li>
            </ul>
        </div>
        <div class="contents">
        	<div id="signup_confirm">
        	
        		<p class="confirm"><span>l</span>��������</p>
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
				  			<td colspan="2" class="tb_title"><p class="name">���� ����</p></td>
				 		</tr>
				 		<tr>
				  			<td class="tb_content" align="center">
				  				<a href="javascript:auth.hp_Popup(this.form_chk);">
				  					<img src="/image2/main/01_signup_confirm01.jpg" alt="�ڵ��� ����" border="0" >
				  				</a>
				  			</td>
				  			<td class="tb_content" align="center">
				  				<a href="javascript:auth.ip_Popup(this.form_chk);">
				  					<img src="/image2/main/01_signup_confirm02.jpg"  alt="I-PIN ����" border="0" >
				  				</a>
				  			</td>
				 		</tr>
					</table>
				</form>
				<br>
				<p class="confirm"><span>l</span>SNS ����</p>
				<form name="idcheckForm" method="post" action="/main/index.php?board=signup">
					<input type="hidden" name="snsType">
                	<input type="hidden" name="snsId">
                	<input type="hidden" name="snsEmail">
				</form> 
				<table  class="confirm_table1" width="725px" height="178px">
					 <tr>
						  <td colspan="3" class="tb_title"><p class="name">SNS ����</p></td>
			 		</tr>
			 		<tr>
			 			<td class="tb_content" align="center">
			  				<a href="javascript:loginFB('idcheck');">
			  					<img src="/image2/etc/snsBig01.jpg" alt="���̽� �� ������" border="0" ></a>
			  					<br><p class="sns_name">���̽���</p>
			  				</a>
			  			</td>
			  			<td class="tb_content" align="center">
			  				<p class="line"><img src="/image2/etc/line.png"></p>
						  	<a href="javascript:loginKakao('idcheck');">
						  		<img src="/image2/etc/snsBig02.jpg" alt="īī���� ������" border="0" >
						  	</a>
			  				<p class="sns_name">īī����</p>
			  			</td>
			  			<td class="tb_content" align="center">
					  	  <p class="line"><img src="/image2/etc/line.png"></p>
			  				<a id="naver_id_login"></a>
			  				<br>
			  				<p class="sns_name">���̹�</p></td>
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
	
  		//sns�� ���� ������ü
	    board = "<?=$_GET['board'];?>";
	    window.name ="Parent_window";
		
		
		
	</script>
	
	
    