<? 
	include_once "head.php";
	
	
	if(!strcmp($_SESSION['temp_code'],'')){error_location('�α����� �ʿ��մϴ�.',"/m/main.php");exit;}
	
	$group_sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_REQUEST['board'].'\';';//Ÿ��Ʋ
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
					<div class="btn_back f_cs" onclick="goBack()"><img src="/m/img/musign/main/hd_back.webp" alt="�ڷ� ����"></div>   
					<h1 class="fz36">���� ���� ����</h1>       
				</div>
			</div>  
			<? include_once "mypage_top.php";?> 
		</div>    		
		<div class="boardTabMenuWrap">
			<a href="/m/infoedit.php?board=infoedit">���� ����</a>
			<a href="/m/pwedit.php?board=pwedit" class="on">��й�ȣ ����</a>
			<a href="/m/without.php?board=without">ȸ��Ż��</a>
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
					<p class="tit fz26 fw500">���� ��й�ȣ</p>
						<input type="password" name="pastPw" id="pastPw" maxlength="20"  placeholder="���� ��й�ȣ�� �Է����ּ���."/>
					</div>
					<div class="box_line">
						<p class="tit fz26 fw500">�� ��й�ȣ</p>
						<input type="password" name="newPw" id="newPw" maxlength="16" onkeyup="chPwdTF(this);" placeholder="�� ��й�ȣ�� �Է��� �ּ���." />
						<span id="newPwText" class="fz24"></span>
					</div>
					<div class="box_line">
						<p class="tit fz26 fw500">�� ��й�ȣ Ȯ��</p>
						<input type="password" id="chNewPw" maxlength="16" onkeyup="chPwdTF(this);" placeholder="�� ��й�ȣ�� �ѹ� �� �Է��� �ּ���." />
						<span id="chNewPwText" class="fz24"></span>
					</div>
				</div>
				</form>	
				<div class="btngroup f_c">
					<a href="javascript:;" onClick="updatePwFormSubmit()" class="btn_submit btn_black">��й�ȣ ����</a>
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

	if(!$("input[name='pastPw']").val()){
		alert("���� ��й�ȣ�� �Է��� �ּ���.");
		$("input[name='pastPw']").focus();
		return;
	}

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
	
	$("#updatePwForm").attr("action","pweditAction.php").submit();
	//document.updatePwForm.submit();
	
}
</script>
<?include_once "tail.php";?>