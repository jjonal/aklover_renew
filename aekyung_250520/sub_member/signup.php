<?
if(!defined('_HEROBOARD_'))exit;

//20240416 ���ؼ� musign �ּ� ���� ����2�� ��û
if(!$_SESSION['temp_level'] || $_SESSION['temp_level']<9999){

	if((!$_POST['param_r6'] || !$_POST['param_r5']) && (!$_POST['snsId'] || !$_POST['snsType'])){

		if($_GET["tempNoAuth"] != "Y") {
			error_historyBack("�߸��� �����Դϴ�.");
			exit;
		} else {
			$_POST['param_r6'] = "tempNoAuth".date("YmdHis");
			$_POST['param_r5'] = "tempNoAuth".date("YmdHis");
			$di = $_POST['param_r6'];
			$ci = $_POST['param_r5'];
			$_POST["param_r1"] = "�׽�Ʈ�̸���";
		}
	}

	$error = "SIGNUP_01";

	if($_POST['param_r5'] && $_POST['param_r6']){
		//���ȼ��� 200819
		$_SESSION["auth"]["hero_name"]   = $_POST["param_r1"];
		$_SESSION["auth"]["hero_jumin"]  = $_POST["param_r2"];
		$_SESSION["auth"]["hero_sex"]    = $_POST["param_r3"];
		$_SESSION["auth"]["hero_info_type"]   = $_POST["param_r4"];
		$_SESSION["auth"]["hero_info_di"]   = $_POST["param_r5"];
		$_SESSION["auth"]["hero_info_ci"]   = $_POST["param_r6"];

		$sql = "select count(*) from member where hero_info_di='".$_POST['param_r5']."' and hero_info_ci='".$_POST['param_r6']."' and hero_use=0";
	}elseif($_POST['snsId'] && $_POST['snsType']){
		//���ȼ��� 200819
		$_SESSION["auth"]["snsId"]   = $_POST["snsId"];
		$_SESSION["auth"]["snsType"]  = $_POST["snsType"];

		$sql = "select count(*) from member where hero_".$_POST['snsType']."= md5('".$_POST['snsId']."') and hero_use=0";
	}

	$res = new_sql($sql,$error,"on");
	if((string)$res==$error){
		error_historyBack("");
		exit;
	}
	$check_member = mysql_result($res,0,0);

	if($check_member>0){
		error_location("�̹� �����ϼ̽��ϴ�.","/main/index.php?board=findpw");
		exit;
	}

	//########### �޸����� üũ ##############
	if($_POST['param_r5'] && $_POST['param_r6']){
		$sql1 = "select count(*) from member_backup where hero_info_di='".$_POST['param_r5']."' and hero_info_ci='".$_POST['param_r6']."'";
	}elseif($_POST['snsId'] && $_POST['snsType']){
		$sql1 = "select count(*) from member_backup where hero_".$_POST['snsType']."=MD5('".$_POST['snsId']."')";
	}
	$out_sql1 = new_sql($sql1,$error);
	if((string)$out_sql1==$error){
		error_historyBack("");
		exit;
	}
	$count1 = mysql_result($out_sql1,0,0);
	if($count1>0){
		error_location("�ش� ȸ���� �޸� �����Դϴ�.ID/PWã�⸦ ���� �α��� �Ͽ� �ֽʽÿ�.","/main/index.php?board=findpw");
		exit;
	}

}
//20240416 ���ؼ� musign �ּ� �� //

//���� ���Խ�
$birthYear = substr($_POST['param_r2'], '0', '4');//��
$birthMonth = substr($_POST['param_r2'], '4', '2');//��
$birthDay = substr($_POST['param_r2'], '6', '2');//��

if($_POST['param_r5'] && $_POST['param_r6'] && $_POST['param_r2']){
	$di = $_POST['param_r5'];
	$ci = $_POST['param_r6'];

	if(!$birthYear || !$birthMonth || !$birthDay){
		error_location("�ý��� �����Դϴ�. �ٽ� �õ����ּ���","/main/index.php?board=idcheck");
		exit;
	}

	include_once $_SERVER['DOCUMENT_ROOT']."/classGathered/chAgeClass.php";
	$chAgeClass = new chAgeClass($birthYear,$birthMonth,$birthDay);
	$age = $chAgeClass->countUniversalAge();
	if((int)$age<15){
		error_location("��14�� �̸��� �����Ͻ� �� �����ϴ�.","/main/index.php");
		exit;
	}

	$readonly_auth = "readonly";
	$displaynone_auth = "style='display:none'";
//sns ���Խ�
}else{
	$snsId = $_POST['snsId'];
	$snsEmail = explode("@",$_POST['snsEmail']);
	$snsType = $_POST['snsType'];

	switch($snsType){
		case "facebook" : $snsText = "<p style='padding-bottom: 4rem;'><img src='/image2/etc/snsBig01.jpg' alt='".$snsType."' style='margin-right: 1rem'> ȸ������ ���̽����� �����Ǿ����ϴ�</p>";break;
		case "kakaoTalk" : $snsText = "<p style='padding-bottom: 4rem;'><img src='/img/front/member/kakaolog.webp' alt='".$snsType."' style='margin-right: 1rem'> ȸ������ īī������ �����Ǿ����ϴ�.</p>";break;
		case "naver" : $snsText = "<p style='padding-bottom: 4rem;'><img src='/img/front/member/naverlog.webp' alt='".$snsType."' style='margin-right: 1rem'> ȸ������ ���̹� ���̵� �����Ǿ����ϴ�.</p>";break;
		case "google" : $snsText = "<p style='padding-bottom: 4rem;'><img src='/img/front/member/googlelog.webp' alt='".$snsType."' style='margin-right: 1rem'> ȸ������ ���� ���̵� �����Ǿ����ϴ�.</p>";break;
	}

	$readonly_sns = "readonly";
	$disabled_sns = "disabled='disabled'";
	$displaynone_sns = "style='display:none'";
}
?>
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<script>
$(document).ready(function(){
	$(document).on("keyup", "input:text[suOnly]", function() {$(this).val( $(this).val().replace(/[^0-9]/gi,"") );});

});
</script>
<link rel="stylesheet" type="text/css" href="/css/front/member.css" />
<div class="contents_area mu_member join_wrap">
	<div class="page_title t_c">
        <h2 class="fz48 fw500 main_c">ȸ������</h2>
		<p class="subtit fz12">AK Lover�� �پ��� ������� �����ϼ���!</p>
		<div class="bread">
			<ul class="f_b">
				<li >1. ��������</li>
				<li class="arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
				<li class="joinstep on">2.�̿��� ����</li>
				<li class="join_arr arr on"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
				<li class="joinstep ">3.���� ����(�ʼ�)</li>
				<li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
				<!-- <li class="joinstep ">4.���� ����(����)</li>
				<li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li> -->
				<li>4.ȸ������ �Ϸ�</li>
			</ul>
		</div>
    </div>
	<div class="signup_wrap">
		<div class="contents">
			<form name="form_next" action="<?=PATH_HOME_HTTPS?>?board=result" enctype="multipart/form-data" method="post" onsubmit="return false;">
				<input type="hidden" name="hero_jumin" value="">
				<input type="hidden" name="hero_login_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
				<input type="hidden" id="ch_term_01" value="false">
				<input type="hidden" id="ch_term_02" value="false">
				<input type="hidden" id="ch_term_03" value="false">
				<input type="hidden" id="ch_term_04" value="false">
				<input type="hidden" id="ch_term_05" value="false">
				<input type="hidden" name="hero_user_point_check" />
				<input type="hidden" name="tempNoAuth" value="<?=$_GET["tempNoAuth"]?>" /><!-- ȸ������ �׽�Ʈ �뵵 ���� ���� -->

				<?=$snsText?>				
				<!--// ȸ������ ���� -->
				<div class="step signup_term">
					<div class="signup_term_title fz18 fw600">�ְ��� ���� ȸ�� ���</div>
					<div class="all_agree agree_list input_chk">
						<input type="checkbox" name="all_terms" id="allAgree" />
						<label for="allAgree"class="input_chk_label">�ְ����� ��� ����� Ȯ���ϰ� ��ü �����մϴ�.</label>
						<p class="desc">
							��ü���Ǵ� �ʼ� �� ���������� ���� ���ǵ� ���ԵǾ� ������,<br />
							���������ε� ���Ǹ� �����Ͻ� �� �ֽ��ϴ�.<br />
							�����׸� ���� ���Ǹ� �ź��ϴ� ��쿡�� ȸ������ ���񽺴� �̿� �����մϴ�.
						</p>
					</div>
					<div class="agree_list input_chk">
						<input type="checkbox" id="hero_terms_01" name="hero_terms_01" class="partAgree_btn" value='0'/>
						<label for="hero_terms_01" class="input_chk_label"><span class="fz15 bold main_c">�ʼ�*</span>�̿����� �����մϴ�.</label>
						<!-- <input type="radio" class="partAgree_btn" name="hero_terms_01" value='1'/>���Ǿ��� -->
						<div class="term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">���� �̿��� (�ʼ�)</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
								<div class="scrollbx"><?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term1_2.php";?></div>
								<script>
									$(document).ready(function(){
										$('#term1').addClass('scroll');
									})
								</script>
							</div>	
						</div>
						<div class="all_view">��ü����</div>
					</div>
					<div class="agree_list input_chk">
						<input type="checkbox" id="hero_terms_02" name="hero_terms_02" class="partAgree_btn" value='0'/>						
						<label for="hero_terms_02" class="input_chk_label"><span class="fz15 bold main_c">�ʼ�*</span>�������� ����<b></b>�̿뵿�� �ʼ� �׸�</label>
						<!-- <input type="radio" class="partAgree_btn" name="hero_terms_02" value='1'/>���Ǿ��� -->
						<div class="term table_term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">�������� ���� ���� (�ʼ�)
									<p class="fz14">* �ش� �������� ���� �� �̿뿡 �������� ���� �Ǹ��� ������, �������� ���� ��� ȸ�������� �Ұ��մϴ�.<br />
									*��, 3�Ⱓ �α����� ���� ��� �ڵ� Ż��Ǹ�, 5�� ���Ŀ��� �絿�ǰ� �ʿ��մϴ�.
								</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>							
								<div id="term4">
									<table border="1" cellspacing="0" cellpadding="2">
										<tr>
											<td>�����׸�</td>
											<td>���̵�, ��й�ȣ, �̸�, �г���, �������, �̸���, �޴�����ȣ, �ּ�,
											�������� ��(�޴�������), <br>
											SNS �α��� ������ <br>
											- īī���� : īī���忡�� �����ϴ� �������̵�<br/>
											- ���̹� : ���̹����� �����ϴ� �������̵�, �̸���<br/>
											- ���� : ���ۿ��� �����ϴ� �������̵�, �̸���</td>
											<td>�̸�, �г���, �޴�����ȣ</td>
										</tr>
										<tr>
											<td>���� �� �̿� ����</td>
											<td>���� �̿뿡 ���� ���νĺ�, ���Կ��� Ȯ��, ȸ���� �����̿� ����,<br/>
											�� ���ǿ� ���� �亯, �����ǻ�Ȯ��, �Ҹ�ó�� ���� ���� �ǻ���� ��� Ȯ��,<br/>
											��� �� ��å �ȳ�, ȸ���� ������ ü��� Ȱ���� ���� ���� ���� �� �׿� ���� ��ǰ ���</td>
											<td>ȸ�� Ż�� �� �����ǿ� ���� �亯,<br/>
												�Ҹ� ó���� ���� �ǻ���� ��� Ȯ��,<br/>
												���� ���� �̿����
											</td>
										</tr>
										<tr>
											<td>�̿� �� �����Ⱓ</td>
											<td>���� öȸ �� Ȥ�� ȸ�� Ż�� �ñ���</td>
											<td>ȸ��Ż�� �� 1�Ⱓ ����</td>
										</tr>
									</table>
								</div>								
							</div>	
						</div>						
						<div class="all_view">��ü����</div>
					</div>
					<!-- 240930 ��� ���� ���� -->
					<!-- <div class="agree_list input_chk">
						<input type="checkbox" id="hero_terms_03" name="hero_terms_03" class="selectAgree_btn" value='0'/>		
						<label for="hero_terms_03" class="input_chk_label">�������� ����<b></b>�̿뵿�� �����׸� (����)</label>
						<input type="radio" name="hero_terms_03" class="selectAgree_btn"  value='1'/>���Ǿ���
						<div class="term table_term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">�������� ���� ���� (����)
									<p class="fz14">�ش� �������� ���� �� �̿뿡 ���ؼ� �������� ���� �Ǹ��� ������ �������� ������ ��쿡�� ȸ�������� �����մϴ�.<br />
									��, Ư�� ������ �̿��� ���ѵ� �� �ֽ��ϴ�.</p>
								</h2>								
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>							
								<div id="term4">
									<table border="1" cellspacing="0" cellpadding="2">
										<tr>
											<td>�����׸�</td>
											<td>
											�� �Ʒ� �׸� �� ȸ���� �����ϴ� �׸�<br/>
											AK Lover�� �˰Ե� ��δ�?, ��õ�� ���̵� �Ǵ� �г���,<br/> 
											���� SNS URL
											, ���̹� ��α� URL
											, �ν�Ÿ�׷� URL
											, ���̹� ���÷�� Ȩ
											, ���÷�� ��
											, Ȱ�� ī�װ�
											, �׿� SNS URL(���̽��� URL, Ʈ���� URL, īī�����丮 URL ��)
											, ��Ʃ�� URL
											, ���̹� TV URL 
											, ƽ�� URL
											, ��Ÿ URL <br/> 
											��ȥ����, �ڳ� ����/�¾ �⵵, �ݷ����� ����, ������ ����, �ı⼼ô�� ����,
											AK Lover�� ������ ����, AK Lover �� Ȱ���ϴ� ��������/ü��� ī�� �Ǵ� Ȩ������
											</td>
											<td>�޴�����ȣ</td>
											<td>�̸���</td>
										</tr>
										<tr>
											<td>���� �� �̿� ����</td>
											<td>��Ȱ�� ü��� Ȱ�� ����͸�/���� Ư���� ���� ü��� Ȱ�� ����<br />
											�ű� ���� ����,, �̺�Ʈ �� ���� ���� ���� �� ������ȸ ����,<br />
											�α�������� Ư���� ���� ���� ���� �� ���� ����, ������ ��ȿ�� Ȯ��,<br />
											���Ӻ� �ľ� �Ǵ� ȸ���� ���� �̿뿡 ���� ��� Ȯ���� ����</td>
											<td colspan="2">���� �̺�Ʈ, ��� ���� �����ȳ� �� ���� ������ Ȱ��,<br/> 
											��� ��ǰ/���� �ȳ� �� ����</td>
										</tr>
										<tr>
											<td>�̿� �� �����Ⱓ</td>
											<td colspan="3">ȸ��Ż�� �� ���ǰźνñ���</td>
										</tr>
									</table>
								</div>				
							</div>	
						</div>	
						<div class="all_view">��ü����</div>
					</div> -->
					<div class="agree_list agree_depth2 input_chk">
						<input type="checkbox" id="event_agree" name="event_agree" class="" value=''/>
						<label for="event_agree" class="input_chk_label">���� �̺�Ʈ, ü���, ��� ���� ���� �ȳ� �� ���� ������ Ȱ��, ��� ��ǰ/���� �ȳ� �� ����(����)</label>
						<div>
							<input type="checkbox" id="hero_terms_04" name="hero_terms_04" class="selectAgree_btn" value='0'/>
							<label for="hero_terms_04" class="input_chk_label">SMS ���� ���� (����)</label>
							<!-- <input type="radio" name="hero_terms_04" class="selectAgree_btn"  value='1'/>���Ǿ��� -->
						</div>	
						<div>
							<input type="checkbox" id="hero_terms_05" name="hero_terms_05" class="selectAgree_btn" value='0'/>
							<label for="hero_terms_05" class="input_chk_label">�̸��� ���� ���� (����)</label>
							<!-- <input type="radio" name="hero_terms_05" class="selectAgree_btn"  value='1'/>���Ǿ��� -->
						</div>
					</div>

					<div class="agree_list">
						<p class="fz14 fw500 gray07">�ʼ� ��Ź����</p>	
						<div class="term table_term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">�ʼ� ��Ź����</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>							
								<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term7.php";?>
							</div>	
						</div>	
						<div class="all_view">��ü����</div>
					</div>
					<div class="btn_bx f_c">
						<!-- <a class="btn_submit btn_gray" href="<?=PATH_HOME_HTTPS?>?board=idcheck">��������</a> -->
						<div class="btn_submit btn_black" onClick="chk_agree(document.form_next)">��������</div>
					</div>
				</div>
				<!--// ȸ������ ���� -->
				<!-- ȸ������ �Է� �ʼ� -->
				<div class="step require" style="display: none;">
					<div class="member">
						<h2 class="fz19 fw600">�ʼ� �����Է�</h2>
						<div class="join_input">
							<div class="div_tr">
								<p class="tit"><span>*</span>���̵�</p>
								<div class="div_td">
									<input type="text" name="hero_id" id="hero_id" style="ime-mode:disabled;" onfocusout="ch_id(this);" value="" placeholder="4~20�� ����, Ư������(!@#$%) ���Ұ�"/>
									<br /><span id="ch_id_text" class="chk_txt"></span>
								</div>
							</div>
							<div class="div_tr">
								<p class="tit"><span>*</span>��й�ȣ</p>
								<div class="div_td"><input type="password" name="hero_pw_01" id="hero_pw_01" onkeyup="chPwdTF(this);" placeholder="����, ����, Ư����ȣ�� �����Ͽ� 8�ڸ� �̻� �Է����ּ���"/>
								<br /><span id="ch_hero_pw_01" class="chk_txt"></span></div>
							</div>
							<div class="div_tr">
								<p class="tit"><span>*</span>��й�ȣ Ȯ��</p>
								<div class="div_td"><input type="password" name="hero_pw_02" id="hero_pw_02" onkeyup="chPwdTF(this);" placeholder="����, ����, Ư����ȣ�� �����Ͽ� 8�ڸ� �̻� �Է����ּ���"/>
								<br /><span id="ch_hero_pw_02" class="chk_txt"></span></div>
							</div>
							<div class="div_tr">
								<p class="tit"><span>*</span>�̸�</p>
								<div class="div_td">
									<? if($_SESSION["auth"]["hero_name"]) {?>
										<?=$_SESSION["auth"]["hero_name"]?>
									<? } else { ?>
										<input type="text" name="hero_name" placeholder="�̸�"/>
									<? } ?>
								</div>
							</div>
							<div class="div_tr">
								<p class="tit"><span>*</span>�г���</p>
								<div class="div_td">
									<input type="text" name="hero_nick" id="hero_nick_02" onkeyup="ch_nick(this);" placeholder="�г���"/>
									<span id="ch_nick_text" class="chk_txt"></span>
									<p class="txt_emphasis mgt5">
										�� AK Lover Ȩ���������� �г������� Ȱ���մϴ�.<br/>
										�� �г����� �� �� ������ �Ұ��Ͽ���, �����ϰ� �ۼ��� �ּ���.
									</p>
								</div>
							</div>
							<? 
								if (isset($snsType)) {
									// musign sns ����ȸ���� ������� ���Զ� ����ǥ�� 25.04.17 ���� ���û��.
									?>
									<div class="div_tr">
								<p class="tit"><span>*</span> �������</p>
								<div class="div_td">
									<? if($birthYear && $birthMonth && $birthDay) {?>
										<?=$birthYear?>�� <?=sprintf("%02d",$birthMonth)?>�� <?=sprintf("%02d",$birthDay)?>��
									<? } else { ?>
										<div class="yaer_select f_c">
											<select name="year" id="year" title="����⵵ ����" class="mr12">
												<? for($i = date("Y"); $i > 1921; $i--) { ?>
												<option value="<?=$i;?>" <?=$birthYear==$i ? "selected":"";?>><?=$i;?></option>
												<? } ?>
											</select>
											<select name="month" id="month" title="����� ����" class="mr12">
												<? for($i = 1; $i <= 12; $i++) { ?>
												<option value="<?=sprintf("%02d", $i);?>" <?=$birthMonth==$i ? "selected":"";?>><?=sprintf("%02d", $i);?></option>
												<? } ?>
											</select>
											<select name="date" id="date" title="����� ����" class="mr12">
												<? for($i = 1; $i <= 31; $i++) { ?>
												<option value="<?=sprintf("%02d", $i);?>" <?=$birthDay==$i ? "selected":"";?>><?=sprintf("%02d", $i);?></option>
												<? } ?>
											</select>
										</div>
									<? } ?>
									<span class="txt_emphasis dis-no">�� 14�� �̸��� ȸ�������� �Ұ��մϴ�.</span>
								</div>
							</div>
							<?	}
							?>
							<!-- <div class="div_tr">
								<p class="tit"><span>*</span> �������</p>
								<div class="div_td">
									<? if($birthYear && $birthMonth && $birthDay) {?>
										<?=$birthYear?>�� <?=sprintf("%02d",$birthMonth)?>�� <?=sprintf("%02d",$birthDay)?>��
									<? } else { ?>
										<div class="yaer_select f_c">
											<select name="year" id="year" title="����⵵ ����" class="mr12">
												<? for($i = date("Y"); $i > 1921; $i--) { ?>
												<option value="<?=$i;?>" <?=$birthYear==$i ? "selected":"";?>><?=$i;?></option>
												<? } ?>
											</select>
											<select name="month" id="month" title="����� ����" class="mr12">
												<? for($i = 1; $i <= 12; $i++) { ?>
												<option value="<?=sprintf("%02d", $i);?>" <?=$birthMonth==$i ? "selected":"";?>><?=sprintf("%02d", $i);?></option>
												<? } ?>
											</select>
											<select name="date" id="date" title="����� ����" class="mr12">
												<? for($i = 1; $i <= 31; $i++) { ?>
												<option value="<?=sprintf("%02d", $i);?>" <?=$birthDay==$i ? "selected":"";?>><?=sprintf("%02d", $i);?></option>
												<? } ?>
											</select>
										</div>
									<? } ?>
									<span class="txt_emphasis dis-no">�� 14�� �̸��� ȸ�������� �Ұ��մϴ�.</span>
								</div>
							</div> -->
							<div class="div_tr">
								<p class="tit"><span>*</span> �̸���</p>
								<div class="div_td">
									<div class="mail_select f_c">
										<div class="mail_select f_c">
											<input type="text" name="hero_mail_01" value="<?=$snsEmail[0]?>" style="ime-mode:disabled; width:150px;" placeholder="�̸���"> @
											<input type="text" id="hero_mail_02" name="hero_mail_02" value="<?=$snsEmail[1]?>" style="ime-mode:disabled; width:150px;">
										</div>
										<select id="email_select" onchange='emailChg();' class="short" >
											<option value="">�����Է�</option>
											<option value="naver.com"<?if(!strcmp($hero_mail['1'], 'naver.com')){echo ' selected';}else{echo '';}?>>naver.com</option>
											<option value="hanmail.net"<?if(!strcmp($hero_mail['1'], 'hanmail.net')){echo ' selected';}else{echo '';}?>>hanmail.net</option>
											<option value="daum.net"<?if(!strcmp($hero_mail['1'], 'daum.net')){echo ' selected';}else{echo '';}?>>daum.net</option>
											<option value="gmail.com"<?if(!strcmp($hero_mail['1'], 'gmail.com')){echo ' selected';}else{echo '';}?>>gmail.com</option>
											<option value="hotmail.com"<?if(!strcmp($hero_mail['1'], 'hotmail.com')){echo ' selected';}else{echo '';}?>>hotmail.com</option>
											<option value="paran.com"<?if(!strcmp($hero_mail['1'], 'paran.com')){echo ' selected';}else{echo '';}?>>paran.com</option>
											<option value="nate.com"<?if(!strcmp($hero_mail['1'], 'nate.com')){echo ' selected';}else{echo '';}?>>nate.com</option>
										</select>
									</div>
								</div>
							</div>
							<div class="div_tr">
								<p class="tit"><span>*</span> �޴�����ȣ</p>
								<div class="div_td f_c mail_select">	
									<input type="text" name="hero_hp_01" id="hero_hp_01" onkeyup="if(this.value.length > 2)hero_hp_02.focus();" maxlength="3" suOnly="true"/>
									-
									<input type="text" name="hero_hp_02" id="hero_hp_02" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" suOnly="true"/>
									-
									<input type="text" name="hero_hp_03" id="hero_hp_03" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" suOnly="true"/>
								</div>
							</div>
						</div>
						<div class="btn_bx f_c">
							<div class="btn_submit btn_gray" onclick="prevStep(0)">��������</div>
							<div class="btn_submit btn_black" onClick="requireJoin(document.form_next)">��������</div>
						</div>
					</div>
				</div>				
				<!--// ȸ������ �Է� �ʼ� -->				
				<!-- ȸ������ �Է� ���� -->
				<div class="step choice" style="display: none;">
					<div class="member">
						<h2 class="fz19 fw600">���� �����Է� <span class="fz12 fw500 gray">*�Է����� �����ŵ� ȸ�������� �����մϴ�.</span></h2>
						<div class="div_tr">
							<p class="tit">AK Lover�� �˰Ե� ��δ�?</p>
							<div class="div_td">
								<ul>
									<li><p class="input_radio"><input type="radio" name="area" id="area1" value="��α�"/><label for="area1" class="input_chk_label">���̹� ��α�</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area2" value="�ν�Ÿ�׷�"/><label for="area2" class="input_chk_label">�ν�Ÿ�׷� (�ı� �Խñ�, �ν�Ÿ�׷� ������ ���� ��)</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area3" value="����"/><label for="area3" class="input_chk_label">��Ʃ�� (�ı� ����, ���󱤰� ��)</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area4" value="����������"/><label for="area4" class="input_chk_label">���� ������ (����, ����, ƽ�� ��)</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area5" value="ī��"/><label for="area5" class="input_chk_label">ī�� (ī�� ���, �Խñ�, �̺�Ʈ ��)</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area6" value="���Ȱ��Ȩ������"/><label for="area6" class="input_chk_label">���Ȱ�� Ȩ������ (���긮Ÿ��, ķ�۽��� ��)</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area7" value="����/����/DM"/><label for="area7">���̹� ����/�ν�Ÿ DM/����</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area8" value="īī�������ä�ù�"/><label for="area8" class="input_chk_label">īī���� ���� ä�ù�</label></p></li>
									<li><p class="input_radio"><input type="radio" name="area" id="area9" value="������õ"/><label for="area9" class="input_chk_label">������õ</label></p></li>
									<li><p class="input_radio wid100"><input type="radio" name="area" id="area10" value="��Ÿ"/><label for="area10" class="input_chk_label">��Ÿ</label><input type="text" name="area_etc_text"maxlength="50" disabled="disabled"/></p></li>
								</ul>
							</div>
						</div>
						<!--!!!!!!!! [���߿�û] ������ ���� �׸��Դϴ� [��]!!!!!!!!  -->
						<div class="div_tr">
							<p class="tit">�����ִ� Ȱ��</p>
							<div class="div_td">
								<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity2" value="HUT �� ��������"/><label for="activity2" class="input_chk_label">HUT �� ��������</label></p></li>
								<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity3" value="�����̾� ��������"/><label for="activity3" class="input_chk_label">�����̾� ��������</label></p></li>
								<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity4" value="����Ʈ ����"/><label for="activity4" class="input_chk_label">����Ʈ ����</label></p></li>
								<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity1" value="��ǰ ü����"/><label for="activity1" class="input_chk_label">��ǰ ü���</label></p></li>
								<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity5" value="�̺�Ʈ"/><label for="activity5" class="input_chk_label">�̺�Ʈ</label></p></li>
							</div>
						</div>
						<!--!!!!!!!! ///////////END///////// !!!!!!!!  -->
						<div class="div_tr repeople">
							<p class="tit">��õ��</p>
							<div class="div_td">
								<ul">
									<li>
										<div class="input_radio">
											<input type="radio" name="hero_user_type" id="hero_user_type_1" value="hero_id" placeholder="��õ���� ���̵� ��Ȯ�ϰ� �Է����ּ���."/><label for="hero_user_type_1">���̵�</label>
										</div>
										<input type="text" name="hero_user_r_id" id="hero_user_r_id" class="w190" onfocusout="ch_hero_user(this);" disabled/>
									</li>
									<li class="last">
										<div class="input_radio">
											<input type="radio" name="hero_user_type" id="hero_user_type_2" value="hero_nick" placeholder="��õ���� �г����� ��Ȯ�ϰ� �Է����ּ���."/><label for="hero_user_type_2">�г���</label>
										</div>
										<input type="text" name="hero_user_r_nick" id="hero_user_r_nick" class="w190" onfocusout="ch_hero_user(this);" disabled/>
									</li>
									<span id="ch_hero_user_text" class="chk_txt"></span>
								</ul>
								<p class="txt_default fz14 fw500">�� �ű�ȸ���� ��õ���� ���� AK Lover ȸ�����Դ� �ְ� ��ǰ���� ��ȯ�� �� �� �ִ� 
								AK Lover ����Ʈ 1,000���� ���޵˴ϴ�.</p>
							</div>
						</div>
					</div>					
					<div class="btn_bx f_c">
						<div class="btn_submit btn_gray" onclick="prevStep(1)">��������</div>
						<!--!!!!!!!! [���߿�û] ȸ�����ԿϷ�� ���ԿϷ������� ���� http://aklover-test.musign.kr/main/index.php?board=join_ok [��] !!!!!!!!  -->
						<a href="javascript:;" class="btn_submit btn_black" onClick="go_submit(document.form_next)">���ԿϷ�</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="/js/birthdate.js"></script>
<script type="text/javascript">
$(document).ready(function(){

	$("input:radio[name='hero_user_type']").on("click",function(){
		var id = $('input:radio[name="hero_user_type"]:checked').attr('id');

		if(id == "hero_user_type_1") {
    		$("#hero_user_r_id").attr("disabled",false);
    		$("#hero_user_r_id").focus();
    		$("#hero_user_r_id").val("");

    		$("#hero_user_r_nick").attr("disabled",true);
    		$("#hero_user_r_nick").val("");
		} else if(id == "hero_user_type_2") {
			$("#hero_user_r_nick").attr("disabled",false);
    		$("#hero_user_r_nick").focus();
    		$("#hero_user_r_nick").val("");

    		$("#hero_user_r_id").attr("disabled",true);
    		$("#hero_user_r_id").val("");
		}

		$("input[name='hero_user_point_check']").val("");
		$("#ch_hero_user_text").html("");
	})


	$("input[name=area]").on("click",function(){
		if($(this).val()=="��Ÿ") {
			$("input[name=area_etc_text").attr("disabled",false);
			$("input[name=area_etc_text").focus();
		} else {
			$("input[name=area_etc_text").val("");
			$("input[name=area_etc_text").attr("disabled",true);
		}
	})

	$("input:radio[name='hero_qs_01']").on("click",function(){ //��α� �ִ�,����
		if($(this).val() == "Y") {
			$(".hero_sns_url").attr("disabled",false);
			$(".hero_sns_type").attr("disabled",false);
		} else {
			$(".hero_sns_url").val("");
			$(".hero_sns_url").attr("disabled",true);
			$(".hero_sns_type").val("");
			$(".hero_sns_type").attr("disabled",true);
		}
	})

	$("input:radio[name='hero_qs_03']").on("click",function(){
		if($(this).val() == "Y") {
			$(".children").show();
		} else {
			$(".children").hide();
		}
	})

	$("input:radio[name='hero_qs_07']").on("click",function(){
		if($(this).val() == "Y") {
			$("input[name=hero_qs_08]").attr("disabled",false);
		} else {
			$("input[name=hero_qs_08]").val("");
			$("input[name=hero_qs_08]").attr("disabled",true);
		}
	})

});

/*	
	musign start
*/
// ��ü ���ǽ� 
$('#allAgree').change(function () {
    const $target = $(this),
        $checkbox = $('.agree_list input:checkbox');

    if ($target.prop('checked') === true) {
        $checkbox.prop('checked', true);
    } else {
        $checkbox.prop('checked', false);
    }
});
// �̺�Ʈ ���� ���� (��ü)��
$('.agree_depth2 #event_agree').change(function () {
    const $target2 = $(this),
        $checkbox2 = $('.agree_depth2 input:checkbox');

    if ($target2.prop('checked') === true) {
        $checkbox2.prop('checked', true);
    } else {
        $checkbox2.prop('checked', false);
    }
});
// ��ü���� �˾� ����
const allView = $('.agree_list .all_view');
const termCont = $('.agree_list .term');
$.each(allView, function(idx, item){
	$(this).click(function(){
		termCont.eq(idx).removeClass('dis-no');
	});
});
// ��ü���� �˾� �ݱ�
$('.term .btn_x').click(function(){
	$(this).parents('.term').addClass('dis-no');
});
//step�ڽ� - ȸ������ �ܰ躰 ���� ��ư ����
const stepDiv = $('.step');
const breadLi = $('.bread li');
const breadStep = $('.bread .joinstep');
const breadArr = $('.bread .join_arr');
function nextStep(index){
	stepDiv.hide();
	stepDiv.eq(index).show();	
	breadLi.removeClass('on');
	breadStep.eq(index).addClass('on');
	breadArr.eq(index).addClass('on');
}
//step�ڽ� - ȸ������ �ܰ躰 ���� ��ư ����
function prevStep(index){	
	stepDiv.hide();
	stepDiv.eq(index).show();
	breadLi.removeClass('on');
	breadStep.eq(index).addClass('on');
	breadArr.eq(index).addClass('on');
}
//�̿��� ���� ��ȿ�� �˻� 
function chk_agree(form){
    const terms_01 = form.hero_terms_01;
    const terms_02 = form.hero_terms_02;
	if(terms_01.checked==false){
        alert("���� �̿����� �����ϼž� �մϴ�.");
        return false;
    }
    if(terms_02.checked==false){
        alert("�������� ���� �� �̿�(�ʼ�)�� �����ϼž� �մϴ�.");
        return false;
    }
	nextStep(1);
	return true;
}
//�������� �ʼ� ��ȿ���˻�
function requireJoin(form){
	//���̵�üũ 
	var id = form.hero_id;
	var id_action = document.getElementById("id_action");
	if(trim(id.value)==''){
        alert("���̵� �Է����ּ���");
		id.focus();
        return false;
    }
    if(id.value.length < 4){
    	alert("���̵�� 4�ڸ� �̻� �Է��� �ּ���.");
		id.focus();
        return false;
    }
    if(id_action.value == "hero_down"){
        alert("���̵� Ȯ�����ּ���");id.focus();
        return false;
    }
	//�н�����üũ
	var pw_01 = form.hero_pw_01;
	var pw_02 = form.hero_pw_02;
	if(trim(pw_01.value) == "" || trim(pw_02.value) == ""){
		var noText;
    	if(trim(pw_01.value)==''){
        	noText = pw_01;
        }else if(trim(pw_02.value)==''){
        	noText = pw_02;
        }
        alert("��й�ȣ�� �Է��ϼ���");
		noText.focus();
        return false;
    }
    if(pw_01.value != pw_02.value){
        alert("��й�ȣ�� ���� �ʽ��ϴ�");
		pw_01.focus();
        return false;
    }
	if (pw_01.value.length < 8) {
		alert("��й�ȣ�� 8�ڸ� �̻� �Է����ּ���");
		pw_01.focus();
		return false;
	}
	if(!chTextType.isEnNumOther(pw_01.value)){
		alert("��й�ȣ�� ����, ����, Ư�������� �������� �Է����ּ���");
		pw_01.focus();
	    return false;
	}

	// �̸�üũ
	<? if(!$_SESSION["auth"]["hero_name"]) {?>
		var irum = form.hero_name;
		irum.style.border = '1px solid #ccc';
	<? } ?>
	
	<? if(!$_SESSION["auth"]["hero_name"]) {?>
		if(trim(irum.value)==''){
	        alert("�̸��� �Է����ּ���.");
	        irum.focus();
	        return false;
	    }
    <? } ?>


	//�г��� üũ
	var nick = form.hero_nick;
    var nick_action = document.getElementById("nick_action");
	if(trim(nick.value)==''){
        alert("�г����� �Է����ּ���");
		nick.focus();
        return false;
    }
    if(nick_action == null) {
    	alert("�г����� Ȯ�����ּ���");
		nick.focus();
        return false;
    }
    if(nick_action.value == "hero_down"){
        alert("�г����� Ȯ�����ּ���");
		nick.focus();
        return false;
    }
	//�̸��� üũ 
    var mail_01 = form.hero_mail_01;
    var mail_02 = form.hero_mail_02;
	if(trim(mail_01.value) == "" || trim(mail_02.value) == ""){
		var noText;
    	if(trim(mail_01.value)==''){
        	noText = mail_01;
        }else if(trim(mail_02.value)==''){
        	noText = mail_02;
        }
        alert("�̸����� �Է��ϼ���.");
        noText.focus();
        return false;
    }
	//�޴���üũ
	var hp_01 = form.hero_hp_01;
    var hp_02 = form.hero_hp_02;
    var hp_03 = form.hero_hp_03;
	if(trim(hp_01.value) == "" || trim(hp_02.value) == "" || trim(hp_03.value)==''){
		var noText;
    	if(trim(hp_01.value)==''){
        	noText = hp_01;
        }else if(trim(hp_02.value)==''){
        	noText = hp_02;
        }else{
        	noText = hp_03;
        }
        alert("�޴�����ȣ�� �Է��ϼ���.");
        noText.focus();
        return false;
    }
    if(pw_01.value.indexOf(hp_02.value)>0 || pw_01.value.indexOf(hp_03.value)>0){
    	alert("��й�ȣ���� �޴��� ��ȣ�� ���Ե� �� �����ϴ�");
		pw_01.focus();
	    return false;
    }
	//nextStep(2);
	form.submit();
	return true;
}
//�������� ���� ��ȿ���˻� - ���� ���� submit
function go_submit(form) {
    // var address_01 = form.hero_address_01;
    // var address_02 = form.hero_address_02;
    // var address_03 = form.hero_address_03;

	var memid = form.hero_id;
	//���� ���� ��ȿ�� üũ
	var hero_qs_06 = form.hero_qs_06; //����

	//Ȯ���ʿ�
	var jumin = form.hero_jumin;

    var ch_term_01 = document.getElementById("ch_term_01").value;
    var ch_term_02 = document.getElementById("ch_term_02").value;
    var ch_term_03 = document.getElementById("ch_term_03").value;
    var ch_term_04 = document.getElementById("ch_term_04").value;
	var ch_term_05 = document.getElementById("ch_term_05").value;

	memid.style.border = '1px solid #ccc';
	<? if(!$_SESSION["auth"]["hero_name"]) {?>
		var irum = form.hero_name;
		irum.style.border = '1px solid #ccc';
	<? } ?>
	// nick.style.border = '1px solid #ccc';
    // pw_01.style.border = '1px solid #ccc';
    // pw_02.style.border = '1px solid #ccc';
    // mail_01.style.border = '1px solid #ccc';
    // mail_02.style.border = '1px solid #ccc';
  	// hp_01.style.border = '1px solid #ccc';
   	// hp_02.style.border = '1px solid #ccc';
   	// hp_03.style.border = '1px solid #ccc';
    // address_01.style.border = '1px solid #ccc';
    // address_02.style.border = '1px solid #ccc';
    // address_03.style.border = '1px solid #ccc';
    // address_03.style.border = '1px solid #ccc';
	
	if($("input:radio[name='area']:checked").val() == "��Ÿ") {
		if(!$("input[name='area_etc_text']").val()) {
			alert("AK Lover�� �˰Ե� ��� ��Ÿ ���� �� ������ �Է��� �ּ���.");
			$("input[name='area_etc_text']").focus();
			return;
		}
	}

	if($('#hero_id').val() == $('#hero_user_r_id').val() || $('#hero_nick_02').val() == $('#hero_user_r_nick').val()){
		alert("������ ��õ������ ��õ�� �� �����ϴ�.");
		return false;
	}

	<? if(!$_SESSION["auth"]["hero_name"]) {?>
		if(trim(irum.value)==''){
	        alert("�̸��� �Է����ּ���.");
	        irum.focus();
	        return false;
	    }
    <? } ?>

	// <?  if(!$birthYear || !$birthMonth || !$birthDay) {?>
	// 	var ch_year = document.getElementById("year").value;
	// 	var ch_month = document.getElementById("month").value;
	// 	var ch_date = document.getElementById("date").value;

	//     if(ch_year=='<?=date("Y")?>'){
	//     	 alert("��������� �������ּ���"); $("#year").focus();
	//     	 return false;
	//     }

	//     chAge.setDate(ch_year,ch_month,ch_date);
	// 	var age = chAge.countUniversalAge();
	// 	if(age<15){
	// 		alert("�˼��մϴ�. �� 14�� �̸��� �����Ͻ� �� �����ϴ�.");
	// 		return false;
	// 	}
	// <? } ?>
     
    // if(address_01.value == ""){
    //     alert("�����ȣ�� �Է��ϼ���.");address_01.style.border = '1px solid red';address_01.focus();
    //     return false;
    // }
    // if(address_02.value == ""){
    //     alert("�ּҸ� �Է��ϼ���.");address_02.style.border = '1px solid red';address_02.focus();
    //     return false;
    // }
    // if(address_03.value == ""){
    //     alert("�������ּҸ� �Է��ϼ���.");address_03.style.border = '1px solid red';address_03.focus();
    //     return false;
    // }
  
	// var hero_sns_url_check = true;
	// if($("input:radio[name='hero_qs_01']:checked").val() == "Y") {
	// 	hero_sns_url_check = false;
	// 	$(".hero_sns_url").each(function(i){
	// 		if($(this).val()) {
	// 			hero_sns_url_check = true;
	// 		}
	// 	})

	// 	if(form.hero_naver_influencer.value!='') {
    // 		if(form.hero_naver_influencer_name.value=='') {
    // 			alert("���÷�𽺸� �Է��� �ʿ��մϴ�.");
    // 			$("#hero_naver_influencer_name").css("border","1px solid #f00");
	// 			$("#hero_naver_influencer_name").focus();
    // 			return false;
    // 		} else {
    // 			if(form.hero_naver_influencer_category.value=='') {
    // 				alert("���÷�� ī�װ� ������ �ʿ��մϴ�.");
    // 				return false;
    // 			}
    // 		}
    // 	} else {
    // 		form.hero_naver_influencer_name.value = '';
    // 		form.hero_naver_influencer_category.value = '';

    // 		hero_sns_url_check = false;
    // 		$(".hero_sns_url").each(function(i){
    // 			if($(this).val()) {
    // 				hero_sns_url_check = true;
    // 			}
    // 		})
    // 	}
	// }

	// if(!hero_sns_url_check) {
	// 	alert("���� SNS URL �ִ� ��� ���� �� �ּ� 1���� ���� SNS URL �Է��� �ʿ��մϴ�.");
	// 	$("#hero_blog_00").css("border","1px solid #f00");
	// 	$("#hero_blog_00").focus();
	// 	return false;
	// }

	// if($("input:radio[name='hero_qs_03']:checked").val() == "Y") {
	// 	if(!$("input:radio[name='hero_qs_04']").is(":checked")) {
	// 		alert("�ڳ���� ������ �ּ���.");
	// 		return false;
	// 	}
	// 	var hero_qs_05_check = 0;
	// 	var k = 0;
	// 	$("select[name='hero_qs_05[]']").each(function(i){
	// 		if($(this).val()) {
	// 			k++;
	// 		}
	// 	})

	// 	if($("input:radio[name='hero_qs_04']:checked").val() != k) {
	// 		alert("������ �ڳ��� �¾ �⵵�� ������ �ּ���.");
	// 		return false;
	// 	}
	// }

	// if($("input:radio[name='hero_qs_07']:checked").val() == "Y") {
	// 	if(!$("input[name='hero_qs_08']").val()) {
	// 		alert("AK LOVER�� Ȱ���ϴ� ��������/ü��� ī�� �Ǵ� Ȩ�������� �Է����ּ���.");
	// 		$("input[name='hero_qs_08']").focus();
	// 		$("input[name='hero_qs_08']").css("border","1px solid #f00");
	// 		return false;
	// 	}
	// }
	form.submit();
	return true;
}
/*
	musign end
*/


//���̵� ��ȿ�� �˻�
function ch_id(obj){
	var id_alert_area = $(obj).next("span");
	var blank_pattern = /[\s]/g;
	if( blank_pattern.test($(obj).val()) == true){
	    alert('������ ����� �� �����ϴ�.');
	    $(obj).val("");
	    $(obj).focus();
	    return false;
	}
	if(trim($(obj).val())==''){
		id_alert_area.html("4~20�� ����, Ư������(!@#$%)���Ұ�");
		return false;
	}else{
		//setCookie('cookie_hero_id', obj.value);
		hero_ajax('zip.php', 'ch_id_text', 'hero_id', 'id');
		return false;
	}
}

function ch_nick(obj){
	var nick_alert_area = $(obj).next("span");
	var blank_pattern = /[\s]/g;
	if( blank_pattern.test($(obj).val()) == true){
	    alert('������ ����� �� �����ϴ�.');
	    $(obj).val("");
	    $(obj).focus();
	    return false;
	}
	if(trim($(obj).val())==''){
		nick_alert_area.html("�г����� �Է��� �ּ���.");
		return false;
	}else{
		hero_ajax('zip.php', 'ch_nick_text', 'hero_nick_02', 'nick');
		return false;
	}
}
function emailChg(){
	if(form_next.email_select.value != "")  $('#hero_mail_02').attr('readonly', true);
	else $('#hero_mail_02').attr('readonly', false);
    form_next.hero_mail_02.value = form_next.email_select.value;
}
function checkNumber(e) {
	var eventCode =(window.netscape)? e.which : e.keyCode;

	if ( ( (96<=eventCode) && (eventCode<=105) ) || ( (48<=eventCode) && (eventCode<=57) ) || (eventCode==8) || (eventCode==37) || (eventCode==39) || (eventCode==9)|| (eventCode==46)){
		e.returnValue=true;
	}else{
		e.preventDefault();
		e.returnValue=false;
	}
}

//��й�ȣ ��ȿ�� �˻�
function chPwdTF(obj){
	var hero_pw_01 = document.form_next.hero_pw_01;
	var hero_pw_02 = document.form_next.hero_pw_02;
	var hero_hp_02 = document.form_next.hero_hp_02;
	var hero_hp_03 = document.form_next.hero_hp_03;
	var ch_hero_pw_01 = document.getElementById("ch_hero_pw_01");
	var ch_hero_pw_02 = document.getElementById("ch_hero_pw_02");

	if (hero_pw_01.value.length < 8) {
		ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
		ch_hero_pw_01.innerHTML ="����, ����, Ư����ȣ�� �����Ͽ� 8�ڸ� �̻� �Է����ּ���";
		obj.focus();
	} else if(!chTextType.isEnNumOther(hero_pw_01.value)){
		ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
		ch_hero_pw_01.innerHTML ="����, ����, Ư����ȣ�� �����Ͽ� �ּ���";
		obj.focus();
	} else{
		ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[1]?>";
		ch_hero_pw_01.innerHTML ="��� ������ ��й�ȣ�Դϴ�";
	}

	if(hero_pw_02.value!=''){
		if(hero_pw_02.value!=hero_pw_01.value){
			ch_hero_pw_02.style.color="<?=$_MAIN_COLOR[0]?>";
		ch_hero_pw_02.innerHTML ="��й�ȣ�� ���� �ʽ��ϴ�";
		obj.focus();
	}else{
		ch_hero_pw_02.style.color="<?=$_MAIN_COLOR[1]?>";
	    	ch_hero_pw_02.innerHTML ="��й�ȣ�� �����ϴ�.";
		}
	}
	// if(hero_hp_02.value!='' || hero_hp_03!=''){
	//     if(hero_pw_01.value.indexOf(hero_hp_02.value)>0 || hero_pw_01.value.indexOf(hero_hp_03.value)>0){
	//     	ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
    //     	alert("��й�ȣ���� �޴�����ȣ�� ����Ͻ� �� �����ϴ�");
	// 		ch_hero_pw_01.innerHTML ="��й�ȣ���� �޴�����ȣ�� ����Ͻ� �� �����ϴ�";
	// 		ch_hero_pw_02.style.color="";
	// 		ch_hero_pw_02.innerHTML ="";
	// 		hero_pw_01.focus();
    //     } else {
	// 		if(obj.name=="hero_hp_02"){
	// 			hero_hp_03.focus();
	// 		}
	//     }
    // }
}

//��õ�� ��ȿ�� �˻�
function ch_hero_user(obj) {
	if(obj.value.length > 0) {
		if(!$("input:radio[name='hero_user_type']").is(":checked")) {
			$("#ch_hero_user_text").html("��õ�� ���̵� �Ǵ� �г����� ���� �� �Է��� �ּ���.");
			$("input[name='hero_user_point_check']").val("");
			return;
		}
	}

	var param = "type=hero_user";
	param += "&hero_user_type="+$("input:radio[name='hero_user_type']:checked").val();
	param += "&hero_user="+obj.value;

	$.ajax({
		url:"/main/zip.php"
		,type:"POST"
		,data:param
		,dataType:"json"
		,success:function(d){
			console.log(d);
			if(d.result == "1") {
				$("#ch_hero_user_text").html("�Է��Ͻ� ȸ������ ����Ʈ�� �����˴ϴ�.");
				$("#ch_hero_user_text").removeClass("txt_emphasis");
				$("input[name='hero_user_point_check']").val("ok");
			} else {
				$("#ch_hero_user_text").html("�Է��Ͻ� ȸ�������� �������� �ʽ��ϴ�.");
				$("#ch_hero_user_text").addClass("txt_emphasis");
				$("input[name='hero_user_point_check']").val("");
			}
		},error:function(e) {
			console.log(e);
		}
	})
}
</script>
