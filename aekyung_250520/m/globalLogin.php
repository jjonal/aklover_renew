<? 
include_once "head.php";

if($_SESSION["global_code"]) error_location("�̹� �α��� �Ǿ����ϴ�.","/m/main.php");

if($_COOKIE['cookie_global_hero_id']) {
	$check = "checked";
} else {
	$check = "";
}
?>
<div class="globalLoginWrap">
	<p class="txt_tit">AK LOVER Global Club �α���</p>
	<form name="globalForm" id="globalForm" action="/m/global_login_check.php?board=<?=$_GET["board"]?>&action=login" method="post" onsubmit="return false;">
	<input type="hidden" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>">
	<div class="loginBox">
		<div class="inputBox">
			<div>
				<label>���̵�</label>
				<input type="text" name="hero_id" id="hero_id" autocomplete="off" maxlength="20" value="<?=$_COOKIE['cookie_global_hero_id']?>"/>
			</div>
			<div class="mgt10">
				<label>��й�ȣ</label>
				<input type="password" name="hero_pw" id="hero_pw" />
			</div>
		</div>
		<div class="btnBox">
			<a href="javascript:;" onClick="fnGlobalLogin()" class="btn_login">�α���</a>
		</div>
	</div>
	
	<div class="idSaveBox">	
		<input style="width:20px;height:20px;" type="checkbox" name="chk_global_id_cookie" id="chk_global_id_cookie" value="true" <?=$check?>>
		<label for="chk_global_id_cookie">���̵� �����ϱ�</label>
	</div>
	</form>
	
	<p class="globalLoginInfo">AK LOVER Global Club �α��� �� �Ϲݹ��Ǵ�<br/>
	   AK LOVER Global Club īī���� ��<br/>
	   Global Club > 1:1���Ǹ� ���� ������ �ּ���
	</p>
</div>
<?include_once "tail.php";?>
<script type="text/javascript">
function fnGlobalLogin() {
    var id = document.globalForm.hero_id;
    var pw_01 = document.globalForm.hero_pw;
    
    if(id.value.length < 4){
        alert("���̵� �Է��ϼ���");
        id.style.border = '1px solid red';
        id.focus();
        return false;
        
    }else if(id.value.length > 20){
        alert("���̵� �Է��ϼ���");
        id.style.border = '1px solid red';
        id.focus();
        return false;
        
    }else{
        id.style.border = '';
    }
    

    if(pw_01.value == ""){
        alert("��й�ȣ�� �Է��ϼ���.");
        pw_01.style.border = '1px solid red';
        pw_01.focus();
        return false;
        
    }else{
        pw_01.style.border = '';
    }
    
    document.globalForm.submit();
    return true;
}
</script>