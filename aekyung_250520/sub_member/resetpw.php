<?
####################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
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
		error_historyBack("��ȿ�� ��й�ȣ ã�� ��û�� �ƴմϴ�.");
		exit;
	}
}

?>
		
		<div id="chPwEdit">
			<div class="password_img"><img src="/image2/main/01_chInfoImg.jpg" width="172px" height="136px" alt="��й�ȣ ã�� �̹���">
			</div>
			<p class="password1"><span style="float:left; margin:0 7px 4px 6px; color:#ff6633;font-size:20px; font-weight:bold">l</span>��й�ȣ ���� �����ϱ�</p>
			<p class="cmt">���̵� ��<?=$list2['hero_id']?>���� ���� ����Ͻ� ��й�ȣ�� �Է��Ͽ� �ּ���. ��й�ȣ ���� �Ŀ��� �ڵ� �α׾ƿ� �˴ϴ�.</p>
			<form name="Frm" method="post" onSubmit="return updatePwFormSubmit()">
				<input type="hidden" name="id" value="<?=$id?>" />
				<input type="hidden" name="auth" value="<?=$auth?>" />
				<input type="hidden" id="pwTF" value="false">
				<table width="726px" class="member" summary="��й�ȣ ���� ��û"  >
				<colgroup>
                    <col width="160px">
                    <col width="*">
            </colgroup>
					<tr>
						<th class="title1_2">�� ��й�ȣ �Է�</th>
						<td class="input_tit"><input type="password" name="newPw" onkeyup="chPwdTF(this);" class="editPwInputArea" maxlength="16"><span id="newPwText"></span>
							<p class="cmt2">������ �н����� ����� ���� 8~16�ڸ��� ������ҹ���, ����, Ư�����ڸ� �����Ͽ� �ֽñ� �ٶ��,<br/> ����, �޴��� ��ȣ �� ���������� ���Ե��� �ʵ��� �������ּ���</p>
						</td>
					</tr>
					<tr>
						<th class="title1_3" >��й�ȣ Ȯ��</th>
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

		alert("��й�ȣ�� �� �� �ԷµǾ����ϴ�");
		newPw.focus();
		return false;
		
	}

	if (confirm("��й�ȣ�� ���� �Ͻðڽ��ϱ�?")) {

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
		newPwText.innerHTML ="����, ����, Ư����ȣ�� �����Ͽ� 8�ڸ� �̻� �Է����ּ���";
		pwTF.value="false";
		obj.focus();
    }else if(!chTextType.isEnNumOther(newPw.value)){
    	newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
    	newPwText.innerHTML ="����, ����, Ư����ȣ�� �����Ͽ� �ּ���";
		pwTF.value="false";
    	obj.focus();
    }else if((typeof hpNumber[1] != 'undefined' && typeof hpNumber[2] != 'undefined') && (newPw.value.indexOf(hpNumber[1])>0 || newPw.value.indexOf(hpNumber[2])>0)){
    	newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
    	newPwText.innerHTML ="�ڵ��� ��ȣ�� ��й�ȣ�� ������ �� �����ϴ�.";
		pwTF.value="false";
    	obj.focus();
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
		}else{
			chNewPwText.style.color="<?=$_MAIN_COLOR[1];?>";
			chNewPwText.innerHTML ="��й�ȣ�� �����ϴ�.";
			pwTF.value="true";
		}
    }
    
}

//]]>
</script>