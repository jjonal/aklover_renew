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
		error_historyBack("��ȿ�� ��й�ȣ ã�� ��û�� �ƴմϴ�.");
		exit;
	}
}

	
$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//Ÿ��Ʋ
$out_group = @mysql_query($group_sql);
$right_list                             = @mysql_fetch_assoc($out_group);
	
include_once "boardIntroduce.php";
?>
<div class="clear"></div>
<div class="memberWrap">
	<p class="ex_txt"><span class="txt_emphasis">(*)</span>�� �ʼ����� �׸��Դϴ�.</p>
	<form name="updatePwForm" id="updatePwForm" method="post">
	<input type="hidden" name="id" value="<?=$id?>" />
	<input type="hidden" name="auth" value="<?=$auth?>" />
	<input type="hidden" name="mode" value="pwreset">
	<input type="hidden" id="pwTF" value="false">
	<div class="joinColumnWrap">
		<div class="joinColumnGroup">
			<label><span>*</span>���� ��й�ȣ</label>
			<input type="password" name="newPw" id="newPw" maxlength="16" onkeyup="chPwdTF(this);"/>
			<span class="mgt5">����, ����, Ư����ȣ�� �����Ͽ� 8�ڸ� �̻� �Է����ּ���</span>
			<span id="newPwText"></span>
		</div>
		<div class="joinColumnGroup">
			<label><span>*</span>���� ��й�ȣ Ȯ��</label>
			<input type="password" id="chNewPw" name="chNewPw"  maxlength="16" onkeyup="chPwdTF(this);"/>
			<span id="chNewPwText"></span>
		</div>
	</div>
	</form>
	
	<div class="btnGroup mgt20">
		<a href="javascript:;" onClick="updatePwFormSubmit()">�����ϱ�</a>
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

function updatePwFormSubmit(){
	var pwTF = document.getElementById("pwTF");
	var newPw = document.updatePwForm.newPw;

	if(!$("input[name='newPw']").val()){
		alert("���� ��й�ȣ�� �Է��� �ּ���.");
		$("input[name='newPw']").focus();
		return;
	}

	if(!$("#chNewPw").val()){
		alert("���� ��й�ȣ Ȯ���� �Է��� �ּ���.");
		$("#chNewPw").focus();
		return;
	}
	

	if(pwTF.value=="false"){
		alert("��й�ȣ�� �߸� �ԷµǾ����ϴ�");
		newPw.focus();
		return false;
	}

	if (confirm("��й�ȣ�� ���� �Ͻðڽ��ϱ�?")) {

		$("#updatePwForm").attr("action","pwresetAction.php").submit();
				
	}
	
}
</script>
<?include_once "tail.php";?>