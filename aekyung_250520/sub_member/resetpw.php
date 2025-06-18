<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
####################################################################################################################################################

$id = $_REQUEST["id"];
$auth = $_REQUEST["auth"];
if($id != "" && $auth != "" && $_SESSION['temp_level']<9999){
	$error = "RESETPW_01";
	$sql = "SELECT target_idx FROM reset_pw WHERE hero_id='".$id."' and  auth_code='".$auth."' and DATEDIFF(hero_date, now()) > -3";
	$res = new_sql($sql, $error, "on");
	if((string)$res==$error){
		error_historyBack("");
		exit;
	}
	$list = mysql_fetch_assoc($res);
		
	if((int)$list["target_idx"] > 0){
		
		$error = "RESETPW_02";
		$sql2 = "select hero_hp, hero_id from member where hero_idx='".$list["target_idx"]."'";
		$res2 = new_sql($sql2,$error);
		if((string)$res==$error){
			error_historyback("");
			exit;
		}
		$list2 = mysql_fetch_assoc($res2);
		$hero_hp = $list2["hero_hp"];
	}else{
		error_historyBack("유효한 비밀번호 찾기 요청이 아닙니다.");
		exit;
	}
}

?>
		
		<div id="chPwEdit">
			<div class="password_img"><img src="/image2/main/01_chInfoImg.jpg" width="172px" height="136px" alt="비밀번호 찾기 이미지">
			</div>
			<p class="password1"><span style="float:left; margin:0 7px 4px 6px; color:#ff6633;font-size:20px; font-weight:bold">l</span>비밀번호 지금 변경하기</p>
			<p class="cmt">아이디 “<?=$list2['hero_id']?>”에 새로 사용하실 비밀번호를 입력하여 주세요. 비밀번호 변경 후에는 자동 로그아웃 됩니다.</p>
			<form name="Frm" method="post" onSubmit="return updatePwFormSubmit()">
				<input type="hidden" name="id" value="<?=$id?>" />
				<input type="hidden" name="auth" value="<?=$auth?>" />
				<input type="hidden" id="pwTF" value="false">
				<table width="726px" class="member" summary="비밀번호 변경 요청"  >
				<colgroup>
                    <col width="160px">
                    <col width="*">
            </colgroup>
					<tr>
						<th class="title1_2">새 비밀번호 입력</th>
						<td class="input_tit"><input type="password" name="newPw" onkeyup="chPwdTF(this);" class="editPwInputArea" maxlength="16"><span id="newPwText"></span>
							<p class="cmt2">안전한 패스워드 사용을 위해 8~16자리의 영문대소문자, 숫자, 특수문자를 조합하여 주시기 바라며,<br/> 생일, 휴대폰 번호 등 개인정보가 포함되지 않도록 주의해주세요</p>
						</td>
					</tr>
					<tr>
						<th class="title1_3" >비밀번호 확인</th>
						<td class="input_tit3">
							<input type="password" id="chNewPw" name="chNewPw" onkeyup="chPwdTF(this);" class="editPwInputArea" maxlength="16">
							<span id="chNewPwText"></span>
						</td>
					</tr>
				</table>
			</form>
			<div class="Btn">
				<input type="image" src="/image2/main/01_chPwSubmitBtn.jpg" onclick="updatePwFormSubmit();" alt="send" onclick="" class="lgnBtn">
				<input type="image" src="/image2/main/01_cancleBtn.jpg" alt="cancel" onclick="location.href='/main/index.php';" class="cancelBtn">
			</div>
		</div>
    </div>
  
<script type="text/javascript"> 
//<![CDATA[ 
function updatePwFormSubmit(){

	var f = document.Frm;

	var pwTF = document.getElementById("pwTF");
	var newPw = document.Frm.newPw;

	if(pwTF.value=="false"){

		alert("비밀번호가 잘 못 입력되었습니다");
		newPw.focus();
		return false;
		
	}

	if (confirm("비밀번호를 변경 하시겠습니까?")) {

		f.action = "/main/index.php?board=pwresetact";
		f.submit();
				
	}
	return false;
	
}

function chPwdTF(obj){

	var newPw = document.Frm.newPw;
	var chNewPw = document.getElementById("chNewPw");
	
	var newPwText = document.getElementById("newPwText");
	var chNewPwText = document.getElementById("chNewPwText");

	var hp = "<?=$hero_hp?>";
	var hpNumber = hp.split("-");
	var pwTF = document.getElementById("pwTF");
	if (newPw.value.length < 8) {
		newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
		newPwText.innerHTML ="영문, 숫자, 특수기호를 조합하여 8자리 이상 입력해주세요";
		pwTF.value="false";
		obj.focus();
    }else if(!chTextType.isEnNumOther(newPw.value)){
    	newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
    	newPwText.innerHTML ="영문, 숫자, 특수기호를 조합하여 주세요";
		pwTF.value="false";
    	obj.focus();
    }else if((typeof hpNumber[1] != 'undefined' && typeof hpNumber[2] != 'undefined') && (newPw.value.indexOf(hpNumber[1])>0 || newPw.value.indexOf(hpNumber[2])>0)){
    	newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
    	newPwText.innerHTML ="핸드폰 번호는 비밀번호에 포함할 수 없습니다.";
		pwTF.value="false";
    	obj.focus();
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
		}else{
			chNewPwText.style.color="<?=$_MAIN_COLOR[1];?>";
			chNewPwText.innerHTML ="비밀번호가 같습니다.";
			pwTF.value="true";
		}
    }
    
}

//]]>
</script>