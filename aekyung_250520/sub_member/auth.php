<?php 
if(!defined('_HEROBOARD_'))exit;

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
	$_SERVER['HTTP_REFERER'] = "/main/index.php";
}
$_SESSION["auth_returnUrl"] = $_SERVER['HTTP_REFERER'];

//���� �� �̵��� ������
$wheretogo = "authAct";
include_once $_SERVER['DOCUMENT_ROOT']."/combined/authInit.php";

?>
<link rel="stylesheet" type="text/css" href="/css/front/cscenter.css" />
<div id="subpage" class="cscenter mobile_auth">
	<div class="sub_title">
		<div class="sub_wrap">
			<div class="f_b">
                <div>
                    <h1 class="fz68 main_c fw500 ko">						
						��������
					</h1>                    
                </div>
            </div>
		</div>
	</div>
	<div class="sub_cont">
		<div class="sub_wrap board_wrap">
			<div class="contents_area">
				<div id="misson_confirm">		
					<div class="explainAuthWrap bgAuth">
						<p class="txt_check">SNS ����(���̹�, īī����, ����)�� ���� ȸ������ �Ͻ� �е��� ü��� ��û �� ����������(�޴�������)�� ������ �ʼ��� ����˴ϴ�.<br />
						���������� ü��� ��û ���� 1ȸ�� ����˴ϴ�. ���� ���� SNS �������� ȸ�������� ��� �������� �� �ϳ��� �������θ� ü��� ������ �����մϴ�.<br /><br />
						ü��� ��������� 'AK Lover �̿�鼭 > �������� ��'���� Ȯ���� �ּ���.
						</p>
					</div>										
					<form name="form_chk" method="post">
						<input type="hidden" name="m" value="checkplusSerivce">
						<input type="hidden" name="EncodeData" value="<?= $enc_data ?>">
						<input type="hidden" name="m" value="pubmain">
						<input type="hidden" name="enc_data" value="<?= $sEncData ?>">
						<input type="hidden" name="param_r1" value="">
						<input type="hidden" name="param_r2" value="">
						<input type="hidden" name="param_r3" value="">
						<input type="hidden" name="param_r4" value="">
						<input type="hidden" name="param_r5" value="">
						<input type="hidden" name="param_r6" value="">		
						<input type="hidden" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>">
						<input type="hidden" name="wheretogo" value="<?=$wheretogo?>">		
						<a href="javascript:hp_Popup()" class="btn_black btn_submit">�޴��� �����ϱ�</a>
					</form>
				</div>        
			</div>
		</div>
	</div>
</div>