<? 
include_once "head.php";

$id = $_REQUEST["id"];
$auth = $_REQUEST["auth"];

if($id != "" && $auth != "" && $_SESSION['temp_level']<9999){
	$error = "RESETPW_01";
	$sql = "SELECT target_idx FROM reset_pw WHERE hero_id='".$id."' and  auth_code='".$auth."' and DATEDIFF(hero_date, now())>-3";
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

	
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//타이틀
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
	
include_once "boardIntroduce.php";
?>
<div class="clear"></div>
<div class="memberWrap">
	<p class="ex_txt"><span class="txt_emphasis">(*)</span>는 필수기입 항목입니다.</p>
	<form name="updatePwForm" id="updatePwForm" method="post">
	<input type="hidden" name="id" value="<?=$id?>" />
	<input type="hidden" name="auth" value="<?=$auth?>" />
	<input type="hidden" name="mode" value="pwreset">
	<input type="hidden" id="pwTF" value="false">
	<div class="joinColumnWrap">
		<div class="joinColumnGroup">
			<label><span>*</span>변경 비밀번호</label>
			<input type="password" name="newPw" id="newPw" maxlength="16" onkeyup="chPwdTF(this);"/>
			<span class="mgt5">영문, 숫자, 특수기호를 조합하여 8자리 이상 입력해주세요</span>
			<span id="newPwText"></span>
		</div>
		<div class="joinColumnGroup">
			<label><span>*</span>변경 비밀번호 확인</label>
			<input type="password" id="chNewPw" name="chNewPw"  maxlength="16" onkeyup="chPwdTF(this);"/>
			<span id="chNewPwText"></span>
		</div>
	</div>
	</form>
	
	<div class="btnGroup mgt20">
		<a href="javascript:;" onClick="updatePwFormSubmit()">수정하기</a>
	</div>	
</div>
<script>
function chPwdTF(obj){

	var newPw = document.updatePwForm.newPw;
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

function updatePwFormSubmit(){
	var pwTF = document.getElementById("pwTF");
	var newPw = document.updatePwForm.newPw;

	if(!$("input[name='newPw']").val()){
		alert("변경 비밀번호를 입력해 주세요.");
		$("input[name='newPw']").focus();
		return;
	}

	if(!$("#chNewPw").val()){
		alert("변경 비밀번호 확인을 입력해 주세요.");
		$("#chNewPw").focus();
		return;
	}
	

	if(pwTF.value=="false"){
		alert("비밀번호가 잘못 입력되었습니다");
		newPw.focus();
		return false;
	}

	if (confirm("비밀번호를 변경 하시겠습니까?")) {

		$("#updatePwForm").attr("action","pwresetAction.php").submit();
				
	}
	
}
</script>
<?include_once "tail.php";?>