<? 
include_once "head.php";
	
	$selectAgreePrivacy = $_POST["selectAgreePrivacy"];
	$selectAgreePhone = $_POST["selectAgreePhone"];
	$selectAgreeEmail = $_POST["selectAgreeEmail"];
	
	$param_r1 = $_SESSION["auth"]["hero_name"];
	$param_r2 = $_SESSION["auth"]["hero_jumin"];
	$param_r3 = $_SESSION["auth"]["hero_sex"];
	$param_r4 = $_SESSION["auth"]["hero_info_type"];
	$param_r5 = $_SESSION["auth"]["hero_info_di"];
	$param_r6 = $_SESSION["auth"]["hero_info_ci"];
	$snsId = $_SESSION["auth"]["snsId"];
	$snsType = $_SESSION["auth"]["snsType"];
	$snsEmail = $snsEmail = explode("@",$_SESSION["auth"]["snsEmail"]);
	
	$hero_terms_01 = $_POST["agree_service"]=="Y" ? "0":"1"; //���
	$hero_terms_02 = $_POST["agree_privacy"]=="Y" ? "0":"1";
	$hero_terms_03 = $_POST["selectAgreePrivacy"]=="Y" ? "0":"1";
	$hero_terms_04 = $_POST["selectAgreePhone"]=="Y" ? "0":"1";
	$hero_terms_05 = $_POST["selectAgreeEmail"]=="Y" ? "0":"1";

	
	$birthYear = substr($param_r2,0,4);
	$birthMonth = substr($param_r2,4,2);
	$birthDay= substr($param_r2,6,2);

    //musign S
    //���� ���� �ּ� ����
	if((!$param_r5 || !$param_r6) && (!$snsId || !$snsType)) {
		if($_GET["tempNoAuth"] != "Y") {
			error_historyBack("�߸��� �����Դϴ�.");
			exit;
		} else {
			$param_r5 = "tempNoAuth".date("YmdHis");
			$param_r6 = "tempNoAuth".date("YmdHis");
			$di = $param_r5;
			$ci =$param_r6;
			$param_r1 = "�׽�Ʈ�̸���";
		}
	}
	//musign E

	if($param_r1) { //�������� ��
		
	} else if($snsId) { //SNS ���� ��
		switch($snsType){
			case "facebook" : $snsText = "<img src='/image2/etc/snsBig01.jpg' alt='".$snsType."'> ȸ������ ���̽����� �����Ǿ����ϴ�";break;
			case "kakaoTalk" : $snsText = "<img src='/image2/etc/snsBig02.jpg' alt='".$snsType."'> ȸ������ īī������ �����Ǿ����ϴ�";break;
			case "naver" : $snsText = "<img src='/image2/etc/snsBig03.jpg' alt='".$snsType."'> ȸ������ ���̹� ���̵� �����Ǿ����ϴ�";break;
			case "google" : $snsText = "<img src='/image/member/btn_google_small.png' alt='".$snsType."'> ȸ������ ���� ���̵� �����Ǿ����ϴ�";break;
		}
	}
	
	$hero_qs_01_disabled = "disabled";
	if($selectAgreePrivacy == "Y") {
		$hero_qs_01_disabled = "";
	}
	
$group_sql = " SELECT * from hero_group WHERE hero_use='1' and hero_board ='".$_GET['board']."' "; // desc

$out_group = new_sql( $group_sql,$error );
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}
$right_list = mysql_fetch_assoc ( $out_group );	
include_once "boardIntroduce.php";
?>
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">
<div class="contents_area mu_member join_wrap">
	<div class="page_title t_c">
        <h2 class="fz48 fw500 main_c">ȸ������</h2>
		<p class="subtit fz12">AK Lover�� �پ��� ������� �����ϼ���!</p>
		<div class="bread">
			<ul class="f_c">
				<li>��������</li>
				<li class="arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
				<li class="joinstep">�̿��� ����</li>
				<li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
				<li class="joinstep on">���� ����(�ʼ�)</li>
				<!-- <li class="join_arr arr on"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li><br /> -->
			</ul>
			<ul class="f_c">				
				<!-- <li class="joinstep">���� ����(����)</li> -->
				<li class="join_arr arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
				<li class="joinstep">ȸ������ �Ϸ�</li>
			</ul>
		</div>
    </div>
	<div class="signup_wrap">
		<div class="contents">
			<form name="form_next" id="form_next" method="post">
			<input type="hidden" name="hero_login_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
			<input type="hidden" name="hero_user_point_check" />
			<input type="hidden" name="hero_terms_01" value="<?=$hero_terms_01?>"/>
			<input type="hidden" name="hero_terms_02" value="<?=$hero_terms_02?>"/>
			<input type="hidden" name="hero_terms_03" value="<?=$hero_terms_03?>"/>
			<input type="hidden" name="hero_terms_04" value="<?=$hero_terms_04?>"/>
			<input type="hidden" name="hero_terms_05" value="<?=$hero_terms_05?>"/>
			<input type="hidden" name="tempNoAuth" value="<?=$_POST["tempNoAuth"]?>" /><!-- ȸ������ �׽�Ʈ �뵵 ���� ���� -->
			<!-- ȸ������ �Է� �ʼ� s -->		
			<div class="step require">
				<div class="member">
					<h2 class="fz15 fw600">�ʼ� �����Է�</h2>
					<div class="join_input">
						<div class="div_tr">
							<p class="tit"><span>*</span>���̵�</p>
							<div class="div_td">
								<input type="text" name="hero_id" id="hero_id" maxlength="20" style="ime-mode:disabled;" onkeyup="ch_id(this);" value="" placeholder="4~20�� ����, Ư������(!@#$%) ���Ұ�"/>
								<span id="ch_id_text" class="chk_txt"></span>
							</div>
						</div>
						<div class="div_tr">
							<p class="tit"><span>*</span>��й�ȣ</p>
							<div class="div_td"><input type="password" name="hero_pw_01" id="hero_pw_01" onkeyup="chPwdTF(this);" placeholder="����, ����, Ư����ȣ�� �����Ͽ� 8�ڸ� �̻� �Է����ּ���"/><span id="ch_hero_pw_01" class="chk_txt"></span></div>
						</div>
						<div class="div_tr">
							<p class="tit"><span>*</span>��й�ȣ Ȯ��</p>
							<div class="div_td"><input type="password" name="hero_pw_02" id="hero_pw_02" onkeyup="chPwdTF(this);" placeholder="����, ����, Ư����ȣ�� �����Ͽ� 8�ڸ� �̻� �Է����ּ���"/><span id="ch_hero_pw_02" class="chk_txt"></span></div>
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
										<select name="year" id="year" title="����⵵ ����">
											<? for($i = date("Y"); $i > 1921; $i--) { ?>
											<option value="<?=$i;?>" <?=$birthYear==$i ? "selected":"";?>><?=$i;?></option>
											<? } ?>
										</select>
										<select name="month" id="month" title="����� ����">
											<? for($i = 1; $i <= 12; $i++) { ?>
											<option value="<?=sprintf("%02d", $i);?>" <?=$birthMonth==$i ? "selected":"";?>><?=sprintf("%02d", $i);?></option>
											<? } ?>	
										</select>
										<select  name="date" id="date" title="����� ����">
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
						<div class="div_tr">
							<p class="tit"><span>*</span> �̸���</p>
							<div class="div_td">
								<div class="mail_select f_c">
									<div class="mail_select f_c">
										<input type="text" name="hero_mail_01" id="hero_mail_01" value="<?=$snsEmail[0]?>" style="ime-mode:disabled; width:90px;" placeholder="�̸���"> @
										<input type="text" name="hero_mail_02" id="hero_mail_02" value="<?=$snsEmail[1]?>"  value="<?=$snsEmail[1]?>" style="ime-mode:disabled; width:70px;">
									</div>
									<select class="short" name="hero_mail_02_select" onchange="$('#hero_mail_02').val(this.value); $('#hero_mail_02').focus();">
										<option value="">��������</option>
										<option value="naver.com">naver.com</option>
										<option value="hanmail.net">hanmail.net</option>
										<option value="daum.net">daum.net</option>
										<option value="gmail.com">gmail.com</option>
										<option value="hotmail.com">hotmail.com</option>
										<option value="paran.com">paran.com</option>
										<option value="nate.com">nate.com</option>
									</select>
								</div>
							</div>
						</div>
						<div class="div_tr">
							<p class="tit"><span>*</span> �޴�����ȣ</p>
							<div class="div_td f_c mail_select">	
								<input type="text" name="hero_hp_01" id="hero_hp_01" onkeyup="if(this.value.length > 2)hero_hp_02.focus();" maxlength="3" numberOnly/>
								-
								<input type="text" name="hero_hp_02" id="hero_hp_02" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" numberOnly/>
								-
								<input type="text" name="hero_hp_03" id="hero_hp_03" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" numberOnly/>
							</div>
						</div>
						<!-- <div class="div_tr">
							<p class="tit"><span>*</span> �ּ�</p>
							<div class="div_td post rel">
								<input type="text" name="hero_address_01" id="hero_address_01" class="w190" readonly placeholder="�����ȣ"/>
								<a href="javascript:;" onClick="btnAddressGet()">�����ȣ ã��</a>	
								<input type="text" name="hero_address_02" id="hero_address_02" readonly/>
								<input type="text" name="hero_address_03" id="hero_address_03" />
							</div>
						</div>  -->
					</div>
					<div class="btn_bx f_c">
						<a class="btn_submit btn_gray" href="/m/agreement.php">��������</a>
						<div class="btn_submit btn_black" onClick="requireJoin(document.form_next)">��������</div>
					</div>
				</div>	
			</div>
			<!--// ȸ������ �Է� �ʼ� e -->				
			<!-- ȸ������ �Է� ���� s -->
			<div class="step choice" style="display: none;">
				<div class="member">			
					<h2 class="fz15 fw600">�ʼ� �����Է�<br/><span class="fz12 fw500 gray">*�Է����� �����ŵ� ȸ�������� �����մϴ�.</span></h2>
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
									<input type="text" name="hero_user_r_nick" id="hero_user_r_nick" onkeyup="ch_hero_user(this);" disabled />
								</li>
								<span id="ch_hero_user_text" class="chk_txt"></span>
							</ul>
							<p class="txt_default fz13 fw500">�� �ű�ȸ���� ��õ���� ���� AK Lover ȸ�����Դ� �ְ� ��ǰ���� ��ȯ�� �� �� �ִ� 
							AK Lover ����Ʈ 1,000���� ���޵˴ϴ�.</p>
						</div>
					</div>								
					<div class="joinColumnWrap dis-no">					
						<div class="joinColumnGroup bottomLine">
							<label>���� SNS URL</label>
							<div class="sns">
								<p class="mgb10">�� AK Lover�� ü��� Ȱ���� ���ؼ��� ���� SNS URL �Է��� �ʿ��մϴ�.</p>
								<input type="radio" name="hero_qs_01" id="hero_qs_01_N" value="N" <?=$selectAgreePrivacy!="Y" ? "checked":""?>/><label for="hero_qs_01_N">����</label>
								<input type="radio" name="hero_qs_01" id="hero_qs_01_Y" value="Y" <?=$selectAgreePrivacy=="Y" ? "checked":""?>/><label for="hero_qs_01_Y">�ִ�</label>
							</div>
							<div class="snsUrl">
								<dl>
									<dd>
										<label for="hero_blog_00">���̹� ��α�</label><br/>
										<label for="hero_blog_00" style="margin-left:8px;">https://blog.naver.com/</label>
										<input type="text" maxlength="25" name="hero_blog_00" id="hero_blog_00" class="hero_sns_url" placeholder="���̹� ID �Ǵ� ��α� ID" style="width:calc(100% - 178px); margin-left:75px;" <?=$hero_qs_01_disabled?>/>
									</dd>
									<dd>
										<label for="hero_blog_04">�ν�Ÿ�׷�</label><br/>
										<label for="hero_blog_04" style="margin-left:8px;">https://www.instagram.com/</label>
										<input type="text" maxlength="25" name="hero_blog_04" id="hero_blog_04" class="hero_sns_url" placeholder="�ν�Ÿ�׷� ID" style="width:calc(100% - 178px); margin-left:75px;" <?=$hero_qs_01_disabled?>/>
									</dd>
									<dd>
										<label for="hero_naver_influencer" style="width:100%;">���̹� ���÷�� Ȩ</label><br/>
										<label for="hero_naver_influencer" style="margin-left:8px;">https://in.naver.com/</label>
										<input type="text" maxlength="25" name="hero_naver_influencer" id="hero_naver_influencer" class="hero_sns_url" placeholder="���̹� ���÷�� ID" style="width:calc(100% - 178px); margin-left:75px;" <?=$hero_qs_01_disabled?>/>
									</dd>
									<dd><label for="hero_naver_influencer_name">���÷�� ��</label><input type="text" id="hero_naver_influencer_name" name="hero_naver_influencer_name" class="hero_sns_url" placeholder="���÷�� �г���" <?=$hero_qs_01_disabled?>/></dd>
									<dd><label for="hero_naver_influencer_category">Ȱ�� ī�װ�</label><select id="hero_naver_influencer_category" name="hero_naver_influencer_category" class="hero_sns_url" <?=$hero_qs_01_disabled?>>
											<option value="">����</option>
											<option value="����">����</option>
											<option value="�м�">�м�</option>
											<option value="��Ƽ">��Ƽ</option>
											<option value="Ǫ��">Ǫ��</option>
											<option value="IT��ũ">IT��ũ</option>
											<option value="�ڵ���">�ڵ���</option>
											<option value="����">����</option>
											<option value="����">����</option>
											<option value="��Ȱ�ǰ�">��Ȱ�ǰ�</option>
											<option value="����">����</option>
											<option value="����/��">����/��</option>
											<option value="�/����">�/����</option>
											<option value="���ν�����">���ν�����</option>
											<option value="���/����">���/����</option>
											<option value="��������">��������</option>
											<option value="��ȭ">��ȭ</option>
											<option value="����/����/����">����/����/����</option>
											<option value="����">����</option>
											<option value="����/����Ͻ�">����/����Ͻ�</option>
											<option value="����/����">����/����</option>
										</select>
									</dd>
									<dd><label for="hero_blog_05">�� ��  SNS URL</label><input type="text" name="hero_blog_05" id="hero_blog_05" class="hero_sns_url" placeholder="���̽���, Ʈ���� ��" <?=$hero_qs_01_disabled?>/></dd>
								</dl>
								
								<p class="mgb10" style="font-size:14px; color:#000;">| ���� ä��</p>
								<dl>
									<dd><label for="hero_blog_03">��Ʃ��</label><input type="text" name="hero_blog_03" id="hero_blog_03" class="hero_sns_url" <?=$hero_qs_01_disabled?>/></dd>
									<dd><label for="hero_blog_06">���̹� TV</label><input type="text" name="hero_blog_06" id="hero_blog_06" class="hero_sns_url" <?=$hero_qs_01_disabled?>/></dd>
									<dd><label for="hero_blog_07">ƽ��</label><input type="text" name="hero_blog_07" id="hero_blog_07" class="hero_sns_url" <?=$hero_qs_01_disabled?>/></dd>
									<dd><label for="hero_blog_08">��Ÿ</label><input type="text" name="hero_blog_08" id="hero_blog_08" class="hero_sns_url" <?=$hero_qs_01_disabled?>/></dd>
								</dl>
								
							</div>
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>��ȥ ����</label>
							<div class="default">
								<input type="radio" name="hero_qs_02" id="hero_qs_02_N" value="N" checked/><label for="hero_qs_02_N">��ȥ</label>
								<input type="radio" name="hero_qs_02" id="hero_qs_02_Y" value="Y" /><label for="hero_qs_02_Y">��ȥ</label>
							</div>
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>�ڳ� ����/�¾ �⵵</label>
							<div class="default">
								<input type="radio" name="hero_qs_03" id="hero_qs_03_N" value="N" checked/><label for="hero_qs_03_N">����</label>
								<input type="radio" name="hero_qs_03" id="hero_qs_03_Y" value="Y"/><label for="hero_qs_03_Y">����</label>
							</div>
							<div class="children">
								<dl>
									<dd><input type="radio" name="hero_qs_04" id="hero_qs_04_1" value="1"/><label for="hero_qs_04_1">1��</label>
										<select name="hero_qs_05[]">
											<option value="">����</option>
											<? for($i=date("Y"); $i > 1921; $i--) {?>
											<option value="<?=$i?>"><?=$i?></option>
											<? } ?>
										</select>
									</dd>
									<dd><input type="radio" value="2" name="hero_qs_04" id="hero_qs_04_2"/><label for="hero_qs_04_2">2��</label>
										<select name="hero_qs_05[]">
											<option value="">����</option>
											<? for($i=date("Y"); $i > 1921; $i--) {?>
											<option value="<?=$i?>"><?=$i?></option>
											<? } ?>
										</select>
									</dd>
									<dd><input type="radio" name="hero_qs_04"  id="hero_qs_04_3" value="3"/><label for="hero_qs_04_3">3��</label>
										<select name="hero_qs_05[]">
											<option value="">����</option>
											<? for($i=date("Y"); $i > 1921; $i--) {?>
											<option value="<?=$i?>"><?=$i?></option>
											<? } ?>
										</select>
									</dd>
									<dd><input type="radio" name="hero_qs_04" id="hero_qs_04_4" value="4"/><label for="hero_qs_04_4">4��</label>
										<select name="hero_qs_05[]">
											<option value="">����</option>
											<? for($i=date("Y"); $i > 1921; $i--) {?>
											<option value="<?=$i?>"><?=$i?></option>
											<? } ?>
										</select>
									</dd>
									<dd><input type="radio" name="hero_qs_04" id="hero_qs_04_5" value="5"/><label for="hero_qs_04_5">5��</label>
										<select name="hero_qs_05[]">
											<option value="">����</option>
											<? for($i=date("Y"); $i > 1921; $i--) {?>
											<option value="<?=$i?>"><?=$i?></option>
											<? } ?>
										</select>
									</dd>
								</dl>
							</div>
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>�ݷ����� ����</label>
							<div class="default">
								<input type="radio" name="hero_qs_19" id="hero_qs_19_N" value="N" checked/><label for="hero_qs_19_N">����</label>
								<input type="radio" name="hero_qs_19" id="hero_qs_19_Y" value="Y"/><label for="hero_qs_19_Y">����</label>
							</div>
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>������ ����</label>
							<div class="default">
								<input type="radio" name="hero_qs_20" id="hero_qs_20_N" value="N" checked/><label for="hero_qs_20_N">����</label>
								<input type="radio" name="hero_qs_20" id="hero_qs_20_Y" value="Y"/><label for="hero_qs_20_Y">����</label>
							</div>
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>�ı⼼ô�� ����</label>
							<div class="default">
								<input type="radio" name="hero_qs_21" id="hero_qs_21_N" value="N" checked/><label for="hero_qs_21_N">����</label>
								<input type="radio" name="hero_qs_21" id="hero_qs_21_Y" value="Y"/><label for="hero_qs_21_Y">����</label>
							</div>
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>AK Lover�� ������ ����</label>
							<input type="text" name="hero_qs_06" />
						</div>
						<div class="joinColumnGroup bottomLine">
							<label>AK Lover �� Ȱ���ϴ� ��������/ü��� ī�� �Ǵ� Ȩ������</label>
							<div class="default">
								<input type="radio" name="hero_qs_07" id="hero_qs_07_N" value="N" checked/><label for="hero_qs_07_N">����</label>
								<input type="radio" name="hero_qs_07" id="hero_qs_07_Y" value="Y"/><label for="hero_qs_07_Y">����</label>
							</div>
							<input type="text" name="hero_qs_08" disabled />
						</div>					
					</div>
					<div class="btn_bx f_c">
						<div class="btn_submit btn_gray" onclick="prevStep(1)">��������</div>
						<!--!!!!!!!! [���߿�û] ȸ�����ԿϷ�� ���ԿϷ������� ���� http://aklover-test.musign.kr/m/join_ok.php [��]!!!!!!!!  -->
						<a href="javascript:;" class="btn_submit btn_black" onClick="go_submit(document.form_next)">���ԿϷ�</a>
					</div>						
				</div>
			</div>		
			<!-- // ȸ������ �Է� ���� e -->
			</form>
		</div>
	</div>
</div>
<script>
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

	$("input:radio[name='hero_qs_01']").on("click",function(){
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
})

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
		hero_ajax('/main/zip.php', 'ch_id_text', 'hero_id', 'id');
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
		hero_ajax('/main/zip.php', 'ch_nick_text', 'hero_nick_02', 'nick'); 
		return false;
	}
}

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
    }else if(!chTextType.isEnNumOther(hero_pw_01.value)){
    	ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
    	ch_hero_pw_01.innerHTML ="����, ����, Ư����ȣ�� �����Ͽ� �ּ���";
    	obj.focus();
    }else{
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
    if(hero_hp_02.value!='' || hero_hp_03!=''){
        if(hero_pw_01.value.indexOf(hero_hp_02.value)>0 || hero_pw_01.value.indexOf(hero_hp_03.value)>0){
        	ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
        	alert("��й�ȣ���� �޴�����ȣ�� ����Ͻ� �� �����ϴ�");
			ch_hero_pw_01.innerHTML ="��й�ȣ���� �޴�����ȣ�� ����Ͻ� �� �����ϴ�";
			ch_hero_pw_02.style.color="";
			ch_hero_pw_02.innerHTML ="";
			hero_pw_01.focus();
        }else{
			if(obj.name=="hero_hp_02"){
				hero_hp_03.focus();
			}
	    }
    }
}

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
				$("input[name='hero_user_point_check']").val("ok");
			} else {
				$("#ch_hero_user_text").html("�Է��Ͻ� ȸ�������� �������� �ʽ��ϴ�.");	
				$("input[name='hero_user_point_check']").val("");
			}
		},error:function(e) {
			console.log(e);
		}
	})
}

	/*	
		musign start
	*/
	//step�ڽ� - ȸ������ �ܰ躰 ���� ��ư ����	
	function nextStep(index){
		const stepDiv = $('.step');
		const breadLi = $('.bread li');
		const breadStep = $('.bread .joinstep');
		const breadArr = $('.bread .join_arr');
		stepDiv.hide();
		stepDiv.eq(index-1).show();	
		breadLi.removeClass('on');
		breadStep.eq(index).addClass('on');
		breadArr.eq(index).addClass('on');
		console.log(breadStep);       
		$(window).scrollTop(0);
	}
	//step�ڽ� - ȸ������ �ܰ躰 ���� ��ư ����
	function prevStep(index){	
		const stepDiv = $('.step');
		const breadLi = $('.bread li');
		const breadStep = $('.bread .joinstep');
		const breadArr = $('.bread .join_arr');
		stepDiv.hide();
		stepDiv.eq(index-1).show();
		breadLi.removeClass('on');
		breadStep.eq(index).addClass('on');
		breadArr.eq(index).addClass('on');
		$(window).scrollTop(0);
	}
	// ȸ������ �ʼ� ��ȿ�� �˻�
	function requireJoin(form){
		$("#hero_id").css("border-bottom","1px solid #ccc");
		$("#hero_pw_01").css("border-bottom","1px solid #ccc");
		$("#hero_pw_02").css("border-bottom","1px solid #ccc");
		$("#hero_nick_02").css("border-bottom","1px solid #ccc");
		$("input[type='hero_mail_01']").css("border-bottom","1px solid #ccc");
		$("input[type='hero_mail_02']").css("border-bottom","1px solid #ccc");
		$("#hero_hp_01").css("border-bottom","1px solid #ccc");
		$("#hero_hp_02").css("border-bottom","1px solid #ccc");
		$("#hero_hp_03").css("border-bottom","1px solid #ccc");
		// �ּ�
		// $("#hero_address_01").css("border-bottom","1px solid #ccc");
		// $("#hero_address_02").css("border-bottom","1px solid #ccc");
		// $("#hero_address_03").css("border-bottom","1px solid #ccc");
		if(!$("#hero_id").val()) {
			alert("���̵� �Է��� �ּ���.");
			$("#hero_id").css("border-bottom","1px solid #f00");
			$("#hero_id").focus();
			return;
		}

		if($("#hero_id").val().length < 4) {
			alert("���̵�� 4�ڸ� �̻� �Է��� �ּ���.");
			$("#hero_id").css("border-bottom","1px solid #f00");
			$("#hero_id").focus();
			return;
		}

		if($("#id_action").val()== "hero_down"){
			alert("���̵� Ȯ�����ּ���");
			$("#hero_id").css("border-bottom","1px solid #f00");
			$("#hero_id").focus();
			return;
		}

		if(!$("#hero_pw_01").val()) {
			alert("��й�ȣ�� �Է��ϼ���.");
			$("#hero_pw_01").css("border-bottom","1px solid #f00");
			$("#hero_pw_01").focus();
			return;
		}

		if($("#hero_pw_01").val().length < 8) {
			alert("��й�ȣ�� 8�ڸ� �̻� �Է����ּ���");
			$("#hero_pw_01").css("border-bottom","1px solid #f00");
			$("#hero_pw_01").focus();
			return;
		}

		if(!chTextType.isEnNumOther($("#hero_pw_01").val())){
			alert("��й�ȣ�� ����, ����, Ư�������� �������� �Է����ּ���");
			$("#hero_pw_01").css("border-bottom","1px solid #f00");
			$("#hero_pw_01").focus();
			return false;
		}

		if(!$("#hero_pw_02").val()) {
			alert("��й�ȣ Ȯ���� �Է��ϼ���.");
			$("#hero_pw_02").css("border-bottom","1px solid #f00");
			$("#hero_pw_02").focus();
			return;
		}

		if($("#hero_pw_01").val() != $("#hero_pw_02").val()) {
			alert("��й�ȣ�� �������� �ʽ��ϴ�.");
			$("#hero_pw_01").css("border-bottom","1px solid #f00");
			$("#hero_pw_02").css("border-bottom","1px solid #f00");
			$("#hero_pw_01").focus();
			return;
		}

		<? if(!$_SESSION["auth"]["hero_name"]) {?>
		if(!$("input[name='hero_name']").val().trim()) {
			alert("�̸��� �Է��� �ּ���.");
			$("input[name='hero_name']").css("border-bottom","1px solid #f00");
			$("input[name='hero_name']").focus();
			return;
		}
		<? } ?>

		if($("#nick_action").length  < 1){
			alert("�г����� �Է��ϼ���.");
			$("#hero_nick_02").css("border-bottom","1px solid #f00");
			$("#hero_nick_02").focus();
			return;
		}

		if($("#nick_action").val() == "hero_down"){
			$("#hero_nick_02").css("border-bottom","1px solid #f00");
			$("#hero_nick_02").focus();
			return;
		} 

		if(!$("#hero_nick_02").val()) {
			alert("�г����� �Է��ϼ���.");
			$("#hero_nick_02").css("border-bottom","1px solid #f00");
			$("#hero_nick_02").focus();
			return;
		}

		if(!$("input[name='hero_mail_01']").val()) {
			alert("�̸���(1)�� �Է��ϼ���.");
			$("input[name='hero_mail_01']").css("border-bottom","1px solid #f00");
			$("input[name='hero_mail_01']").focus();
			return;
		}

		if(!$("input[name='hero_mail_02']").val()) {
			alert("�̸���(2)�� �Է��ϼ���.");
			$("input[name='hero_mail_02']").css("border-bottom","1px solid #f00");
			$("input[name='hero_mail_02']").focus();
			return;
		}

		if(!$("#hero_hp_01").val()) {
			alert("�޴�����ȣ(1)�� �Է��ϼ���.");
			$("#hero_hp_01").css("border-bottom","1px solid #f00");
			$("#hero_hp_01").focus();
			return;
		}

		if(!$("#hero_hp_02").val()) {
			alert("�޴�����ȣ(2)�� �Է��ϼ���.");
			$("#hero_hp_02").css("border-bottom","1px solid #f00");
			$("#hero_hp_02").focus();
			return;
		}

		if(!$("#hero_hp_03").val()) {
			alert("�޴�����ȣ(3)�� �Է��ϼ���.");
			$("#hero_hp_03").css("border-bottom","1px solid #f00");
			$("#hero_hp_03").focus();
			return;
		}

		// �������
		// <?  if(!$birthYear || !$birthMonth || !$birthDay) {?>
		// 	if(!$("#year").val() || !$("#month").val() || !$("#date").val()) {
		// 		alert("��������� �Է��ϼ���.");
		// 		$("#year").focus();
		// 		return;
		// 	}
		
		// 	chAge.setDate($("#year").val(),$("#month").val(),$("#date").val());
		// 	var age = chAge.countUniversalAge();
		// 	if(age < 15) {
		// 		alert("�˼��մϴ�. �� 14�� �̸��� �����Ͻ� �� �����ϴ�.");
		// 		return;
		// 	}
		// <? } ?>
		// �ּ�
		// if(!$("#hero_address_01").val()) {
		// 	alert("�����ȣ�� �Է��ϼ���.");
		// 	$("#hero_address_01").css("border-bottom","1px solid #f00");
		// 	$("#hero_address_01").focus();
		// 	return;
		// }

		// if(!$("#hero_address_02").val()) {
		// 	alert("�ּҸ� �Է��ϼ���.");
		// 	$("#hero_address_02").css("border-bottom","1px solid #f00");
		// 	$("#hero_address_02").focus();
		// 	return;
		// }

		// if(!$("#hero_address_03").val()) {
		// 	alert("���ּҸ� �Է��ϼ���.");
		// 	$("#hero_address_03").css("border-bottom","1px solid #f00");
		// 	$("#hero_address_03").focus();
		// 	return;
		// }	

		//nextStep(2);
		$("#form_next").attr("action","join_action.php").submit();
		return true;
	}
	//�������� ���� ��ȿ���˻� - ���� ���� submit
	function go_submit (form) {
		$("#hero_blog_00").css("border-bottom","1px solid #ccc");
		$("input[name='hero_qs_08']").css("border-bottom","1px solid #ccc");
		<? if(!$_SESSION["auth"]["hero_name"]) {?>
			$("input[name='hero_name']").css("border-bottom","1px solid #ccc");
		<? } ?>


		if($("input:radio[name='area']:checked").val() == "��Ÿ") {
			if(!$("input[name='area_etc_text']").val()) {
				alert("AK Lover�� �˰Ե� ��� ��Ÿ ���� �� ������ �Է��� �ּ���.");
				$("input[name='area_etc_text']").focus();
				$("input[name='area_etc_text']").css("border-bottom","1px solid #f00");
				return;
			}
		}

		if($("#hero_user_r_id").val() == $("#hero_id").val() || $("#hero_user_r_nick").val() == $("#hero_nick_02").val()) {
			alert("������ ��õ������ ��õ�� �� �����ϴ�.");
			return;
		}

		// var hero_sns_url_check = true;
		// if($("input:radio[name='hero_qs_01']:checked").val() == "Y") {
		// 	hero_sns_url_check = false;
		// 	$(".hero_sns_url").each(function(i){
		// 		if($(this).val()) {
		// 			hero_sns_url_check = true;
		// 		}
		// 	})
			
		// 	if(form_next.hero_naver_influencer.value!='') {
		// 		if(form_next.hero_naver_influencer_name.value=='') {
		// 			alert("���÷�𽺸� �Է��� �ʿ��մϴ�.");
		// 			$("#hero_naver_influencer_name").css("border-bottom","1px solid #f00");
		// 			$("#hero_naver_influencer_name").focus();
		// 			return false;
		// 		} else {
		// 			if(form_next.hero_naver_influencer_category.value=='') {
		// 				alert("���÷�� ī�װ� ������ �ʿ��մϴ�.");
		// 				return false;
		// 			}
		// 		}
		// 	} else {
		// 		form_next.hero_naver_influencer_name.value = '';
		// 		form_next.hero_naver_influencer_category.value = '';
				
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
		// 	$("#hero_blog_00").css("border-bottom","1px solid #f00");
		// 	$("#hero_blog_00").focus();
		// 	return;
		// }

		// if($("input:radio[name='hero_qs_03']:checked").val() == "Y") {
		// 	if(!$("input:radio[name='hero_qs_04']").is(":checked")) {
		// 		alert("�ڳ���� ������ �ּ���.");
		// 		return;
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
		// 		return;
		// 	}
		// }

		// if($("input:radio[name='hero_qs_07']:checked").val() == "Y") {
		// 	if(!$("input[name='hero_qs_08']").val()) {
		// 		alert("AK LOVER�� Ȱ���ϴ� ��������/ü��� ī�� �Ǵ� Ȩ�������� �Է����ּ���.");
		// 		$("input[name='hero_qs_08']").focus();
		// 		$("input[name='hero_qs_08']").css("border-bottom","1px solid #f00");
		// 		return;
		// 	}	
		// }

		$("#form_next").attr("action","join_action.php").submit();

	}
	/*	
		musign end
	*/

</script>
<?include_once "tail.php";?>