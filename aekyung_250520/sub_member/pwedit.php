<link rel="stylesheet" type="text/css" href="/css/front/member.css">
<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION['temp_code']){
	error_historyBack("잘못된 접근입니다.");
	exit;
}

######################################################################################################################################################
unset($_SESSION['logging_pw']);
$board = $_GET['board'];
$code  = 	$_SESSION['temp_code'];

$error = "PWEDIT_01";
$selectMember_sql = "select * from member where hero_code='".$code."'";
$selectMember_res = new_sql($selectMember_sql,$error,"on");

if((string)$selectMember_res==$error){
	error_historyBack("");
	exit;
}

//unset($_COOKIE['ch_password']);
//setcookie('ch_password', '', time() - 3600, '/');

unset($_SESSION['ch_password']);

$selectMember_rs = mysql_fetch_assoc($selectMember_res);
?>

<div id="subpage" class="mypage pwedit">
	<div class="sub_title">
		<div class="sub_wrap">
			<div class="f_b">
				<h1 class="fz68 main_c fw600">마이페이지</h1>			
			</div>		
			<? include_once BOARD_INC_END.'mypage_top.php';?>
		</div>
	</div>
	<div class="sub_cont">
		<div class="sub_wrap board_wrap f_sb">
			<div class="left">
				<? include_once BOARD_INC_END.'mypage_nav.php';?>
			</div>
			<div class="contents right">
				<div class="page_title">
					<div class="page_tit fz32 fw600">나의 정보 변경</div>	
					<ul class="boardTabMenuWrap">						
						<a href="/main/index.php?board=infoedit">정보 변경</a>
						<a href="/main/index.php?board=pwedit" class="on">비밀번호 변경</a>
						<a href="/main/index.php?board=without">회원탈퇴</a>
					</ul>     	       
				</div>
				<div class="info_wrap join_input">					
					<div class="info_box">
						<div id="chPwEdit" class="cont mu_member">
							<div>
								<form action="/main/index.php?board=update" method="post" name="updatePwForm">
									<input type="hidden" id="pwTF" value="false">
									<p class="cont_tit fz24 bold">비밀번호 변경</p>
									<div class="box_line">
										<p class="tit fz15 fw500">현재 비밀번호</p>
										<div class="fz15 fw500"><input name="pastPw" type="password" class="editPwInputArea" maxlength="20" placeholder="현재 비밀번호를 입력해주세요."></div>
									</div>
									<div class="box_line">
										<p class="tit fz15 fw500">새 비밀번호</p>
										<div class="fz15 fw500"><input type="password" name="newPw" onkeyup="chPwdTF(this);" class="editPwInputArea" maxlength="16" placeholder="새 비밀번호를 입력해 주세요."><span id="newPwText"></div>
									</div>
									<div class="box_line">
										<p class="tit fz15 fw500">새 비밀번호 확인</p>
										<div class="fz15 fw500"><input type="password" id="chNewPw" onkeyup="chPwdTF(this);" class="editPwInputArea" maxlength="16" placeholder="새 비밀번호를 한번 더 입력해 주세요."></div>
										<span id="chNewPwText"></span>
									</div>
								</form>
								<div class="btngroup f_c">
									<a href="javascript:;" onclick="updatePwFormSubmit();" class="btn_submit btn_black">비밀번호 변경</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>		
		</div>
	</div>
</div>

 
<script>

function chPwdTF(obj){

	var pastPw = document.updatePwForm.pastPw;
	var newPw = document.updatePwForm.newPw;
	var chNewPw = document.getElementById("chNewPw");

	var newPwText = document.getElementById("newPwText");
	var chNewPwText = document.getElementById("chNewPwText");

	var hp = "<?=$selectMember_rs['hero_hp']?>";
	var hpNumber = hp.split("-");

	var pwTF = document.getElementById("pwTF");
	if (newPw.value.length < 8) {
		newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
		newPwText.innerHTML ="영문, 숫자, 특수기호를 조합하여 8자리 이상 입력해주세요";
		pwTF.value="false";
		obj.focus();
		return false;
    }else if(!chTextType.isEnNumOther(newPw.value)){
    	newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
    	newPwText.innerHTML ="영문, 숫자, 특수기호를 조합하여 주세요";
		pwTF.value="false";
    	obj.focus();
    	return false;
    }else if(pastPw.value==newPw.value){
    	newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
    	newPwText.innerHTML ="기존 비밀번호와 다르게 입력해주세요";
		pwTF.value="false";
    	obj.focus();
    	return false;
    }else if((typeof hpNumber[1] != 'undefined' && typeof hpNumber[2] != 'undefined') && (newPw.value.indexOf(hpNumber[1])>0 || newPw.value.indexOf(hpNumber[2])>0)){
    	newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
    	newPwText.innerHTML ="핸드폰 번호는 비밀번호에 포함할 수 없습니다.";
		pwTF.value="false";
    	obj.focus();
    	return false;
    }else{
    	newPwText.style.color="<?=$_MAIN_COLOR[1];?>";
    	newPwText.innerHTML ="사용 가능한 비밀번호입니다";
    }
    if(chNewPw.value!=''){
		if(chNewPw.value!=newPw.value){
			chNewPwText.style.color="<?=$_MAIN_COLOR[0];?>";
			chNewPwText.innerHTML ="비밀번호가 같지 않습니다";
			pwTF.value="false";
			obj.focus();
			return false;
		}else{
			chNewPwText.style.color="<?=$_MAIN_COLOR[1];?>";
			chNewPwText.innerHTML ="비밀번호가 같습니다.";
			pwTF.value="true";
		}
    }
    
}  

function updatePwFormSubmit(){

	var pwTF = document.getElementById("pwTF");
	var newPw = document.updatePwForm.newPw;

	if(pwTF.value=="false"){

		alert("비밀번호가 잘못 입력되었습니다");
		newPw.focus();
		return false;
		
	}

	document.updatePwForm.submit();
	
}

</script>