<? 
	include_once "head.php";
	
	
	if(!strcmp($_SESSION['temp_code'],'')){error_location('로그인이 필요합니다.',"/m/main.php");exit;}
	
	$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//타이틀
	$out_group = @mysql_query($group_sql);
	$right_list                             = @mysql_fetch_assoc($out_group);
	
	$member_sql =  " select * from member where hero_id= '".$_SESSION['temp_id']."' ";
	$out_member_sql = mysql_query($member_sql);
	$member_list                             = @mysql_fetch_assoc($out_member_sql);
	
?>

<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">
<link href="/m/css/musign/cscenter.css" rel="stylesheet" type="text/css">

<div class="memberWrap mu_member">
	<div id="subpage" class="mypage mypoint">	
		<div class="my_top off">    
			<div class="sub_title">       
				<div class="sub_wrap">  
					<div class="btn_back f_cs" onclick="goBack()"><img src="/m/img/musign/main/hd_back.webp" alt="뒤로 가기"></div>   
					<h1 class="fz36">나의 정보 변경</h1>       
				</div>
			</div>  
			<? include_once "mypage_top.php";?> 
		</div>    		
		<div class="boardTabMenuWrap">
			<a href="/m/infoedit.php?board=infoedit">정보 변경</a>
			<a href="/m/pwedit.php?board=pwedit" class="on">비밀번호 변경</a>
			<a href="/m/without.php?board=without">회원탈퇴</a>
		</div>
	</div>
	<div class="info_wrap join_input">			
		<div class="info_box">
			<div id="chPwEdit" class="cont">
				<form name="updatePwForm" id="updatePwForm" method="post">
				<input type="hidden" name="mode" value="pwedit">
				<input type="hidden" id="pwTF" value="false">
				<div class="joinColumnWrap">
					<div class="box_line">
					<p class="tit fz26 fw500">현재 비밀번호</p>
						<input type="password" name="pastPw" id="pastPw" maxlength="20"  placeholder="현재 비밀번호를 입력해주세요."/>
					</div>
					<div class="box_line">
						<p class="tit fz26 fw500">새 비밀번호</p>
						<input type="password" name="newPw" id="newPw" maxlength="16" onkeyup="chPwdTF(this);" placeholder="새 비밀번호를 입력해 주세요." />
						<span id="newPwText" class="fz24"></span>
					</div>
					<div class="box_line">
						<p class="tit fz26 fw500">새 비밀번호 확인</p>
						<input type="password" id="chNewPw" maxlength="16" onkeyup="chPwdTF(this);" placeholder="새 비밀번호를 한번 더 입력해 주세요." />
						<span id="chNewPwText" class="fz24"></span>
					</div>
				</div>
				</form>	
				<div class="btngroup f_c">
					<a href="javascript:;" onClick="updatePwFormSubmit()" class="btn_submit btn_black">비밀번호 변경</a>
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

	var hp = "<?=$member_list['hero_hp']?>";
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

	if(!$("input[name='pastPw']").val()){
		alert("현재 비밀번호를 입력해 주세요.");
		$("input[name='pastPw']").focus();
		return;
	}

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
	
	$("#updatePwForm").attr("action","pweditAction.php").submit();
	//document.updatePwForm.submit();
	
}
</script>
<?include_once "tail.php";?>