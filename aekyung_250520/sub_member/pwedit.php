<link rel="stylesheet" type="text/css" href="/css/front/member.css">
<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION['temp_code']){
	error_historyBack("�߸��� �����Դϴ�.");
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
				<h1 class="fz68 main_c fw600">����������</h1>			
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
					<div class="page_tit fz32 fw600">���� ���� ����</div>	
					<ul class="boardTabMenuWrap">						
						<a href="/main/index.php?board=infoedit">���� ����</a>
						<a href="/main/index.php?board=pwedit" class="on">��й�ȣ ����</a>
						<a href="/main/index.php?board=without">ȸ��Ż��</a>
					</ul>     	       
				</div>
				<div class="info_wrap join_input">					
					<div class="info_box">
						<div id="chPwEdit" class="cont mu_member">
							<div>
								<form action="/main/index.php?board=update" method="post" name="updatePwForm">
									<input type="hidden" id="pwTF" value="false">
									<p class="cont_tit fz24 bold">��й�ȣ ����</p>
									<div class="box_line">
										<p class="tit fz15 fw500">���� ��й�ȣ</p>
										<div class="fz15 fw500"><input name="pastPw" type="password" class="editPwInputArea" maxlength="20" placeholder="���� ��й�ȣ�� �Է����ּ���."></div>
									</div>
									<div class="box_line">
										<p class="tit fz15 fw500">�� ��й�ȣ</p>
										<div class="fz15 fw500"><input type="password" name="newPw" onkeyup="chPwdTF(this);" class="editPwInputArea" maxlength="16" placeholder="�� ��й�ȣ�� �Է��� �ּ���."><span id="newPwText"></div>
									</div>
									<div class="box_line">
										<p class="tit fz15 fw500">�� ��й�ȣ Ȯ��</p>
										<div class="fz15 fw500"><input type="password" id="chNewPw" onkeyup="chPwdTF(this);" class="editPwInputArea" maxlength="16" placeholder="�� ��й�ȣ�� �ѹ� �� �Է��� �ּ���."></div>
										<span id="chNewPwText"></span>
									</div>
								</form>
								<div class="btngroup f_c">
									<a href="javascript:;" onclick="updatePwFormSubmit();" class="btn_submit btn_black">��й�ȣ ����</a>
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
		newPwText.innerHTML ="����, ����, Ư����ȣ�� �����Ͽ� 8�ڸ� �̻� �Է����ּ���";
		pwTF.value="false";
		obj.focus();
		return false;
    }else if(!chTextType.isEnNumOther(newPw.value)){
    	newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
    	newPwText.innerHTML ="����, ����, Ư����ȣ�� �����Ͽ� �ּ���";
		pwTF.value="false";
    	obj.focus();
    	return false;
    }else if(pastPw.value==newPw.value){
    	newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
    	newPwText.innerHTML ="���� ��й�ȣ�� �ٸ��� �Է����ּ���";
		pwTF.value="false";
    	obj.focus();
    	return false;
    }else if((typeof hpNumber[1] != 'undefined' && typeof hpNumber[2] != 'undefined') && (newPw.value.indexOf(hpNumber[1])>0 || newPw.value.indexOf(hpNumber[2])>0)){
    	newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
    	newPwText.innerHTML ="�ڵ��� ��ȣ�� ��й�ȣ�� ������ �� �����ϴ�.";
		pwTF.value="false";
    	obj.focus();
    	return false;
    }else{
    	newPwText.style.color="<?=$_MAIN_COLOR[1];?>";
    	newPwText.innerHTML ="��� ������ ��й�ȣ�Դϴ�";
    }
    if(chNewPw.value!=''){
		if(chNewPw.value!=newPw.value){
			chNewPwText.style.color="<?=$_MAIN_COLOR[0];?>";
			chNewPwText.innerHTML ="��й�ȣ�� ���� �ʽ��ϴ�";
			pwTF.value="false";
			obj.focus();
			return false;
		}else{
			chNewPwText.style.color="<?=$_MAIN_COLOR[1];?>";
			chNewPwText.innerHTML ="��й�ȣ�� �����ϴ�.";
			pwTF.value="true";
		}
    }
    
}  

function updatePwFormSubmit(){

	var pwTF = document.getElementById("pwTF");
	var newPw = document.updatePwForm.newPw;

	if(pwTF.value=="false"){

		alert("��й�ȣ�� �߸� �ԷµǾ����ϴ�");
		newPw.focus();
		return false;
		
	}

	document.updatePwForm.submit();
	
}

</script>