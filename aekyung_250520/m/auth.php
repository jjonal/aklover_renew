<? 
include_once "head.php";

if(!$_SESSION['temp_code']){
	error_historyBack("");
	exit;
}

$sql = " SELECT hero_info_ci FROM member WHERE hero_code = '".$_SESSION['temp_code']."' ";
$res = sql($sql);
$rs = mysql_fetch_assoc($res);

if($rs["hero_info_ci"]) {
	error_historyBack("�ùٸ� ��θ� �̿��� �ּ���.");
	exit;
}

if ($_GET['returnUrl'] == 'y'){  // 24.07.16 musign �߰� �α����� ���������Ͻ� �������� �̵�
	$_SERVER['HTTP_REFERER'] = "/m";
}
$_SESSION["auth_returnUrl"] = $_SERVER['HTTP_REFERER'];

include_once $_SERVER['DOCUMENT_ROOT']."/combined/mobile_authInit.php";
?>

<link href="/m/css/musign/cscenter.css" rel="stylesheet" type="text/css">
<div id="subpage" class="mobile_auth">
	<div class="sub_wrap">
		<div class="sub_title">
			<div class="">
				<h1 class="fz74 main_c fw500 ko">��������</h1>               
			</div>
		</div>
	</div>	
	<form name="form_chk" method="post">
		<input type="hidden" name="m" value="checkplusSerivce">
		<input type="hidden" name="EncodeData" value="<?= $enc_data ?>">
		<input type="hidden" name="m" value="pubmain">
		<input type="hidden" name="enc_data" value="<?= $sEncData ?>">
		<input type="hidden" name="wheretogo" value="/m/authAction.php">
		<input type="hidden" name="param_r1" value="">
		<input type="hidden" name="param_r2" value="">
		<input type="hidden" name="param_r3" value="">
		<input type="hidden" name="param_r4" value="">
		<input type="hidden" name="param_r5" value="">
		<input type="hidden" name="param_r6" value="">
	</form>
	<div class="memberWrap">	
		<div class="explainAuthWrap">
			<p class="txt_check">SNS ����(���̹�, īī����, ����)�� ���� ȸ������ �Ͻ� �е��� ü��� ��û �� ����������(�޴�������)�� ������ �ʼ��� ����˴ϴ�.
			���������� ü��� ��û ���� 1ȸ�� ����˴ϴ�.
			���� ���� SNS �������� ȸ�������� ��� �������� �� �ϳ��� �������θ� ü��� ������ �����մϴ�.<br /><br />
			ü��� ��������� 'AK Lover �̿�鼭 > �������� ��'���� Ȯ���� �ּ���</p>
		</div>
		<a href="javascript:;" onClick="hp_Popup()" class="btn_black btn_submit">�޴��� ����</a>
	</div>
</div>
<?include_once "tail.php";?>