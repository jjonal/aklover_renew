<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION['temp_code']){
	error_location("�� ���� �����Դϴ�.","/main/index.php?board=idcheck");
	exit;
}

######################################################################################################################################################
$board = $_GET['board'];

######################################################################################################################################################
$error = "INFOEDIT_01";
$right_sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$board."'";//desc
$right_res = new_sql($right_sql,$error,"on");
if((string)$right_res==$error){
	error_historyBack("");
	exit;
}

$right_list = mysql_fetch_assoc($right_res);
?>

<div id="subpage" class="mypage alrampage">
	<div class="sub_title">
		<div class="sub_wrap">
			<div class="f_b">
				<h1 class="fz68 main_c fw600">����������</h1>			
			</div>		
			<? include_once BOARD_INC_END.'mypage_top.php';?>
		</div>
	</div>
	<div class="sub_cont replypage">
		<div class="sub_wrap board_wrap f_sb">
			<div class="left">
				<? include_once BOARD_INC_END.'mypage_nav.php';?>
			</div>
			<div class="contents right">
				<div class="page_tit fz32 fw600">���� ���� ����</div>	
				<p class="fz15 today_point">
					ȸ������ ������ �� �����ϰ� ��ȣ�ϱ� ���� �� �� �� ��й�ȣ�� �Է��� �ּ���.
				</p>				
				<form name="form_next" action="<?=PATH_HOME_HTTPS?>?board=infoauth_check" method="post" onsubmit="return go_submit(this);">
					<div class="member_wrap">
						<div class="inner">
							<p class="fz24 bold t_c">��й�ȣ �Է�</p>
							<div>
								<p class="fz16">���� ��й�ȣ</p>
								<input type="password" name="auth_password" placeholder="���� ��й�ȣ�� �Է����ּ���."/>
							</div>							
							<a href="javascript:;" onClick="go_submit(document.form_next)" class="btn_black btn_submit">Ȯ��</a>    
						</div>
					</div>	
				</form>        
			</div>
		</div>
	</div>
</div>


	
<script type="text/javascript">	
function go_submit(form) {
	if(!$("input[name='auth_password'").val()) {
		alert('��й�ȣ�� �Է��� �ּ���.');
		$("input[name='auth_password'").focus();
		return false;
	}
	
	form.submit();
	return true;
}
</script>
				
    