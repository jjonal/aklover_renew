<link rel="stylesheet" type="text/css" href="/css/front/member.css">
<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION['temp_code']){
	error_location("�߸��� �����Դϴ�.","/main/index.php?board=idcheck");
	exit;
}

if($_GET["sns"] != "snsAuth") {//20201207 sns ���������� �߰�
	if(!strpos($_SERVER["HTTP_REFERER"],'/main/index.php?board=infoauth_check') && !strpos($_SERVER["HTTP_REFERER"],'/main/index.php?board=update')) {
		
		location("/main/index.php?board=infoauth");
		exit;
	}
}

$board = $_GET['board'];

$error = "INFOEDIT_01";
$right_sql = "select * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$board."'";//desc
$right_res = new_sql($right_sql,$error,"on");
if((string)$right_res==$error){
	error_historyBack("");
	exit;
}

$right_list = mysql_fetch_assoc($right_res);

$error = "INFOEDIT_02";
$member_sql  = " SELECT m.hero_idx, m.hero_code, m.hero_id, m.hero_name, m.hero_nick ";
$member_sql .= " , m.hero_kakaoTalk, m.hero_naver, m.hero_google, m.hero_jumin , m.hero_hp ";
$member_sql .= " , m.hero_mail ,m.hero_address_01, m.hero_address_02, m.hero_address_03, m.area ";
$member_sql .= " , m.area_etc_text, m.hero_activity, m.hero_chk_phone, m.hero_chk_email ";
$member_sql .= " , m.hero_blog_00, m.hero_blog_04, m.hero_blog_03, m.hero_blog_05 ";
$member_sql .= " , m.hero_blog_06, m.hero_blog_07, m.hero_blog_08, m.hero_naver_influencer, m.hero_naver_influencer_name, m.hero_naver_influencer_category, m.hero_profile ";
$member_sql .= " , q.hero_code AS qs_hero_code , q.hero_qs_01, q.hero_qs_02, q.hero_qs_03, q.hero_qs_04  ";
$member_sql .= " , q.hero_qs_05, q.hero_qs_06, q.hero_qs_07, q.hero_qs_08, q.hero_give_point_today, q.hero_gift_point  ";
$member_sql .= " , q.hero_qs_18, q.hero_qs_19, q.hero_qs_20, q.hero_qs_21, q.hero_qs_22, q.hero_qs_23  ";
$member_sql .= " FROM member m LEFT JOIN member_question q ON m.hero_code = q.hero_code AND q.hero_pid = '4' ";
$member_sql .= " WHERE m.hero_code='".$_SESSION['temp_code']."' AND m.hero_use = 0 ";

$member_res = new_sql($member_sql,$error);
if((string)$member_res==$error){
	error_historyBack("");
	exit;
}

$member_list = mysql_fetch_assoc($member_res);
//������
if(empty($member_list['hero_profile'])){
    $hero_profile = "/img/front/mypage/defalt.webp";
}else {
    $hero_profile = $member_list['hero_profile'];
}

$hero_mail = explode('@', $member_list['hero_mail']);
$today = date("Y");

$alertScriptAll = "<script>alert('�߰������� ��� �Է��Ͻø� 30����Ʈ�� �帳�ϴ�.');</script>";
$alertScriptModi = "<script>alert('�߰������� ����(��α���)�Ͻø� 30����Ʈ�� �帳�ϴ�.');</script>";

if($member_list['qs_hero_code'] == ""){//�߰������ִ��� Ȯ��
	echo $alertScriptAll;
	$question_point_yn ="Y";
} else if($member_list["hero_gift_point"] == 0) {//�߰� ������ ������ �Ϻ��ϰ� �ۼ��� �ȵǼ� ����Ʈ ������ �ȵǴ� ���
	echo $alertScriptAll;
	$question_point_yn ="Y";
} else if(substr($member_list['hero_give_point_today'],0,4) != $today){ //1�� �ֱ� üũ
	echo $alertScriptModi;
	$question_point_yn ="Y";
}

$area_disabled = "disabled";
$area_etc_text = "";
if($member_list["area"] == "��Ÿ") {
	$area_disabled = "";
	$area_etc_text = $member_list["area_etc_text"];
}

$hero_qs_01_disabled = "disabled";
$hero_blog_00 = ""; //���̹� ��α�
$hero_blog_04 = ""; //�ν�Ÿ
$hero_blog_03 = "";
$hero_blog_05 = "";
$hero_blog_06 = "";
$hero_blog_07 = "";
$hero_blog_08 = "";
$hero_naver_influencer = "";
$hero_naver_influencer_name = "";
$hero_naver_influencer_category = "";
if($member_list["hero_qs_01"] == "Y") { //����  SNS URL
	$hero_qs_01_disabled = "";
	$hero_blog_00 = str_replace("https://blog.naver.com/", "", $member_list["hero_blog_00"]);
	$hero_blog_04 = str_replace("https://www.instagram.com/", "", $member_list["hero_blog_04"]);
	$hero_blog_03 = $member_list["hero_blog_03"];
	$hero_blog_05 = $member_list["hero_blog_05"];
	$hero_blog_06 = $member_list["hero_blog_06"];
	$hero_blog_07 = $member_list["hero_blog_07"];
	$hero_blog_08 = $member_list["hero_blog_08"];
	$hero_naver_influencer = str_replace("https://in.naver.com/", "", $member_list["hero_naver_influencer"]);
	$hero_naver_influencer_name = $member_list["hero_naver_influencer_name"];
	$hero_naver_influencer_category = $member_list["hero_naver_influencer_category"];
}

$hero_qs_03_block = "style='display:none';";
$hero_qs_04 = "";
$hero_qs_05_arr = "";
if($member_list["hero_qs_03"] == "Y") { //�ڳ�����/�¾ �⵵
	$hero_qs_03_block = "style='display:block';";
	$hero_qs_04 = $member_list["hero_qs_04"];
	$hero_qs_05_arr = explode(",",$member_list["hero_qs_05"]);
}

$hero_qs_07_disabled = "disabled";
$hero_qs_08 = "";
if($member_list["hero_qs_07"] == "Y") { //Ȱ���ϴ� ��������/ü��� ����
	$hero_qs_07_disabled = "";
	$hero_qs_08 = $member_list["hero_qs_08"];
}

$hero_qs_22 = $member_list["hero_qs_22"];
$hero_qs_23 = $member_list["hero_qs_23"];
?>

<div id="subpage" class="mypage mu_member">
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
				<div class="page_title">
					<div class="page_tit fz32 fw600">���� ���� ����</div>	
					<ul class="boardTabMenuWrap">
						<a href="/main/index.php?board=infoedit" class="on">���� ����</a>
						<a href="/main/index.php?board=pwedit">��й�ȣ ����</a>
						<a href="/main/index.php?board=without">ȸ��Ż��</a>
					</ul>     	       
				</div>
				<div id="infoEditSns">
					<form name="form_next" action="<?=PATH_HOME_HTTPS?>?board=update" enctype="multipart/form-data" method="post" onsubmit="return go_submit(this);">
						<input type="hidden" name="hero_idx" value="<?=$member_list['hero_idx']?>">
						<input type="hidden" name="hero_today_plus" value="<?=Ymdhis?>">
						<input type="hidden" name="hero_login_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
						<div class="info_wrap join_input sns_wrap">
							<div class="info_box default_info flex">
								<div class="box_tit fz15 op05">�α��� �����ϱ�</div>
								<div class="cont f_cs">								
									<? if(!$member_list["hero_kakaoTalk"]) {?>
										<div class="info_sns fz16 fw600"><img src="/img/front/icon/edit_kakao.png" alt="īī����" onClick="loginKakao('infoedit')">īī���� �α���</div>
									<? } else { ?>
										<div class="info_sns fz16 fw600" style="opacity: .5;"><img src="/img/front/icon/edit_kakao.png"  alt="īī����" onClick="alert('īī���� ������ �̹� �����Ǿ����ϴ�.')"></div>
									<? } ?>
									<? if(!$member_list["hero_naver"]) {?>
										<div class="info_sns fz16 fw600 mu_bar f_c naver_wrap"><div id="naver_id_login"></div>���̹� �α���</div>
									<? } else { ?>
										<div class="info_sns fz16 fw600 mu_bar" style="opacity: .5;"><img src="/img/front/icon/edit_naver.png" alt="���̹�" onClick="alert('���̹� ������ �̹� �����Ǿ����ϴ�.')"></div>
									<? } ?>
									<? if(!$member_list["hero_google"]) {?>
										<div class="info_sns mu_bar fz16 fw600" id="btn_google"><img src="/img/front/icon/edit_google.png" alt="���� �α���">���� �α���</div>
									<? } else { ?>
										<div class="info_sns fz16 fw600 mu_bar" style="opacity: .5;"><img src="/img/front/icon/edit_google.png" alt="����" onClick="alert('���� ������ �̹� �����Ǿ����ϴ�.')"></div>
									<? } ?>
								</div>			
							</div>			
						</div>
						<? if(!$member_list['hero_naver']) { ?>
						<script>
							var naver_id_login = new naver_id_login(naver.client_id,"<?=getSnsDomain()?>/main/index.php?sns=snsAuth&board=infoedit");
							var edit_access_token = naver_id_login.oauthParams.board.split("infoedit#access_token=");

							var naver_access_token = edit_access_token[1];

							naver_id_login.oauthParams.access_token = naver_access_token;

							if(!naver_access_token) {
							var state = naver_id_login.getUniqState();
								naver_id_login.setButton("green", 1,46);
								naver_id_login.setDomain("https://aklover.co.kr");
								naver_id_login.setState(state);
								naver_id_login.init_naver_id_login();
							}
							
							if(naver_access_token) {
								naver_id_login.get_naver_userprofile("naverSignInCallback()");
							}
							
							function naverSignInCallback() {
								where = "infoedit";
								snsType = "naver";
								//alert(naver_id_login.getProfileData('id'));
								var response = {"id":naver_id_login.getProfileData('id')};
								afterLogin.login(response);
								/*
								alert(naver_id_login.getProfileData('email'));
								alert(naver_id_login.getProfileData('nickname'));
								alert(naver_id_login.getProfileData('age'));
								*/
							}
						</script>
						<? } ?>
						<!-- <p class="member_alert"><span style="color:#f68428">*</span>�� �ʼ� �Է� �׸��Դϴ�!!!</p> -->
						<div class="info_wrap join_input">
							<div class="info_box default_info flex">
								<div class="box_tit fz15 op05">�⺻ �Է� ����</div>
								<div class="cont">
									<div class="box_line my_profile">
										<p class="tit fz15">*������ �̹���</p>
										<div class="profile_img_wrap">
											<div class="profile_img rel">
												<input type="file" name="hero_profile" id="hero_profile" class="real-upload" accept="image/*">
												<div class="upload btn_upload"><img src="/img/front/mypage/upload_real.png" alt="������ ���ε�"></div>
												<div class="image-preview real-image-preview"><img src="<?=$hero_profile?>" alt="������"></div>
											</div>
										</div>
									</div>
									<div class="box_line">
										<p class="tit fz15">*���̵�</p>
										<div class="fz15 fw500"><?=$member_list['hero_id']?></div>
									</div>
									<div class="box_line">
										<p class="tit fz15">*�̸�</p>
										<div class="fz15 fw500"><?=$member_list['hero_name']?></div>
									</div>
									<div class="box_line">
										<p class="tit fz15">*�г���</p>
										<div class="fz15 fw500"><?=$member_list['hero_nick']?></div>
									</div>
									<div class="box_line">
										<p class="tit fz15">*�������</p>
										<div class="fz15 fw500"><?=substr($member_list['hero_jumin'], '0', '4');?>�� <?=substr($member_list['hero_jumin'], '4', '2');?>�� <?=substr($member_list['hero_jumin'], '6', '2');?>��</div>
									</div>								
									<div class="box_line">
										<p class="tit fz15">*�̸���</p>
										<div class="fz15 fw500 f_cs mail_select">
											<input type="text" name="hero_mail_01" value="<?=$hero_mail['0'];?>" style="ime-mode:disabled; width: 17rem;"/> @
											<input type="text" name="hero_mail_02" id="hero_mail_02" value="<?=$hero_mail['1'];?>" style="ime-mode:disabled; width:17rem;"/>
											<select id="email_select" onchange='javascript:emailChg();' class="short">
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
									<?
										$next = str_ireplace('-', '', $member_list['hero_hp']);
										$next = str_ireplace('~', '', $next);
										$next = str_ireplace('_', '', $next);
										$next = str_ireplace('/', '', $next);
									?> 						
									<div class="box_line">
										<p class="tit fz15">*�޴�����ȣ</p>
										<div class="fz15 fw500 f_cs mail_select">
											<input type="text" name="hero_hp_01" id="hero_hp_01" value="<?=substr($next, '0', '3');?>" onKeyUp="if(this.value.length >= 3)hero_hp_02.focus();" maxlength="3" suOnly="true" class="short" />-
											<input type="text" name="hero_hp_02" id="hero_hp_02" value="<?=substr($next, '3', '4');?>" onKeyUp="if(this.value.length >= 4)hero_hp_03.focus();" maxlength="4" suOnly="true" class="short" />-
											<input type="text" name="hero_hp_03" id="hero_hp_03" value="<?=substr($next, '7', '4');?>" maxlength="4" suOnly="true" class="short" style="width:125px"/>
										</div>
									</div>									
									<div class="box_line">
										<p class="tit fz15">*�ּ�</p>
										<div class="fz15 fw500">
											<div class="f_sc" style="align-items: flex-end;">
                                                <?
                                                $address01Readonly = '';
                                                $address02Readonly = '';
                                                $address03Readonly = '';
                                                if($member_list['hero_address_01'] != '') $address01Readonly = 'readonly';
                                                if($member_list['hero_address_02'] != '') $address02Readonly = 'readonly';
//                                                if($member_list['hero_address_03'] != '') $address03Readonly = 'readonly';
                                                ?>
												<input type="text" name="hero_address_01" id="hero_address_01" value="<?=$member_list['hero_address_01']?>" class="short" <?=$address01Readonly?>/>
												<a href="javascript:btnAddressGet()" class="btn_post fz16 fw500">�����ȣ</a>
											</div>
											<input type="text" name="hero_address_02" id="hero_address_02" value="<?=$member_list['hero_address_02']?>" class="" <?=$address02Readonly?> style="width: 37rem; margin-top:1px;"/><br />
											<input type="text" name="hero_address_03" id="hero_address_03" value="<?=$member_list['hero_address_03']?>" class="" <?=$address03Readonly?> style="width: 37rem; margin-top:1px;" />
										</div>
									</div>	
								</div>
							</div>	
						</div>						
						<div class="info_wrap join_input">
							<div class="info_box choice_info">
								<div class="box_tit fz15 op05">���� �Է� ����</div>
								<div class="choice">
									<div class="div_tr">
										<p class="tit">AK Lover�� �˰Ե� ��δ�?</p>
										<div class="div_td">
											<ul>
												<li><p class="input_radio"><input type="radio" name="area" id="area1" value="��α�" <?=$member_list["area"]=="��α�" ? "checked":"";?>/><label for="area1" class="input_chk_label">���̹� ��α�</label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area2" value="�ν�Ÿ�׷�" <?=$member_list["area"]=="�ν�Ÿ�׷�" ? "checked":"";?>/><label for="area2" class="input_chk_label">�ν�Ÿ�׷� (�ı� �Խñ�, �ν�Ÿ�׷� ������ ���� ��)</label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area3" value="����" <?=$member_list["area"]=="����" ? "checked":"";?>/><label for="area3" class="input_chk_label">��Ʃ�� (�ı� ����, ���󱤰� ��)</label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area4" value="����������" <?=$member_list["area"]=="����������" ? "checked":"";?>/><label for="area4" class="input_chk_label">���� ������ (����, ����, ƽ�� ��) </label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area5" value="����" <?=$member_list["area"]=="����" ? "checked":"";?>/><label for="area5" class="input_chk_label">ī�� (ī�� ���, �Խñ� �̺�Ʈ ��) </label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area6" value="���Ȱ��Ȩ������" <?=$member_list["area"]=="���Ȱ��Ȩ������" ? "checked":"";?>/><label for="area6" class="input_chk_label">���Ȱ�� Ȩ������ (���긮Ÿ��, ķ�۽��� ��) </label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area7" value="����/����/DM" <?=$member_list["area"]=="����/����/DM" || $member_list["area"]=="����/����" || $member_list["area"]=="����" ? "checked":"";?>/><label for="area7" class="input_chk_label">���̹� ����/�ν�Ÿ DM/����</label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area8" value="īī�������ä�ù�" <?=$member_list["area"]=="īī�������ä�ù�" ? "checked":"";?>/><label for="area8" class="input_chk_label">īī���� ���� ä�ù�</label></li>
												<li><p class="input_radio"><input type="radio" name="area" id="area9" value="������õ" <?=$member_list["area"]=="����" || $member_list["area"]=="������õ" ? "checked":"";?>/><label for="area9" class="input_chk_label">������õ</label></li>
												<li><p class="input_radio wid100"><input type="radio" name="area" id="area10" value="��Ÿ" <?=$member_list["area"]=="��Ÿ" ? "checked":"";?>/><label for="area10" class="input_chk_label">��Ÿ</label><input type="text" name="area_etc_text" class="w390" maxlength="50" style="margin-left:5px;" value="<?=$area_etc_text;?>" <?=$area_disabled?>/></li>
											</ul>
										</div>
									</div>
									<!--!!!!!!!! [���߿�û] ������ ���� �׸��Դϴ� [��]!!!!!!!!  -->
									<div class="div_tr">
										<p class="tit">�����ִ� Ȱ��</p>
										<div class="div_td">
											<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity2" value="HUT �� ��������" <?=$member_list["hero_activity"]=="HUT �� ��������" ? "checked":"";?>/><label for="activity2" class="input_chk_label">HUT �� ��������</label></p></li>
											<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity3" value="�����̾� ��������" <?=$member_list["hero_activity"]=="�����̾� ��������" ? "checked":"";?>/><label for="activity3" class="input_chk_label">�����̾� ��������</label></p></li>
											<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity4" value="����Ʈ ����" <?=$member_list["hero_activity"]=="����Ʈ ����" ? "checked":"";?>/><label for="activity4" class="input_chk_label">����Ʈ �佺Ƽ��</label></p></li>
											<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity1" value="��ǰ ü����" <?=$member_list["hero_activity"]=="��ǰ ü����" ? "checked":"";?>/><label for="activity1" class="input_chk_label">��ǰ ü���</label></p></li>
											<li><p class="input_radio"><input type="radio" name="hero_activity" id="activity5" value="�̺�Ʈ" <?=$member_list["hero_activity"]=="�̺�Ʈ" ? "checked":"";?>/><label for="activity5" class="input_chk_label">�̺�Ʈ</label></p></li>
										</div>
									</div>
									<!--!!!!!!!! ///////////END///////// !!!!!!!!  -->
									<div class="div_tr">
										<p class="tit">���ŵ���</p>
										<div class="div_td">
											<div class="input_chk"><input type="checkbox" name="hero_chk_phone" id="hero_chk_phone" value="1" <?=$member_list["hero_chk_phone"]=="1" ? "checked":"";?>/> <label for="hero_chk_phone" class="input_chk_label">�޴�����ȣ</label></div>
											<div class="input_chk" style="margin-top: 1.8rem;"><input type="checkbox" name="hero_chk_email" id="hero_chk_email" value="1" <?=$member_list["hero_chk_email"]=="1" ? "checked":"";?>/> <label for="hero_chk_email" class="input_chk_label">�̸���</label></div>
											<span class="txt_emphasis">�� üũ�ڽ� ���� �� �����ŵ��ǣ��Դϴ�.</span>
										</div>
									</div>
									<p class="txt_default">���� �̺�Ʈ, ü���, ��� ���� ���� �ȳ� �� ���� ������ Ȱ��, ��� ��ǰ/���� �ȳ� �� ����</p>
									<div class="div_tr">
										<p class="tit">���� SNS URL</p>
										<div class="div_td">
											<div>
												<p class="input_radio"><input type="radio" name="hero_qs_01" id="hero_qs_01_Y" value="Y" <?=$member_list["hero_qs_01"]=="Y" ? "checked":"";?>/><label for="hero_qs_01_Y">����</label></p>
											</div>
											<div style="margin-top: 2rem">
												<p class="input_radio"><input type="radio" name="hero_qs_01" id="hero_qs_01_N" value="N" <?=$member_list["hero_qs_01"]=="N" ? "checked":"";?>/><label for="hero_qs_01_N">����</label></p>
											</div>
											<div class="snsUrl etc_info">
												<dl>
													<dd>
														<label for="hero_blog_00">���̹� ��α�</label>
														<label for="hero_blog_00">https://blog.naver.com/</label>
														<input type="text" maxlength="25" name="hero_blog_00" id="hero_blog_00" class="hero_sns_url" placeholder="���̹� ID �Ǵ� ��α� ID" value="<?=$hero_blog_00;?>" <?=$hero_qs_01_disabled?>/>
													</dd>
													<dd>
														<label for="hero_blog_04">�ν�Ÿ�׷�</label>
														<label for="hero_blog_04">https://www.instagram.com/</label>
														<input type="text" maxlength="25" name="hero_blog_04" id="hero_blog_04" class="hero_sns_url" placeholder="�ν�Ÿ�׷� ID" value="<?=$hero_blog_04;?>" <?=$hero_qs_01_disabled?>/>
													</dd>
													<dd>
														<label for="hero_naver_influencer">���̹� ���÷�� Ȩ</label>
														<label for="hero_naver_influencer">https://in.naver.com/</label>
														<input type="text" maxlength="25" name="hero_naver_influencer" id="hero_naver_influencer" class="hero_sns_url" placeholder="���̹� ���÷�� ID" value="<?=$hero_naver_influencer;?>" <?=$hero_qs_01_disabled?>/>
													</dd>
													<dd>
														<label for="hero_naver_influencer_name">���̹� ���÷�� ��</label>
														<div class="f_b" style="gap: 1.1rem;">
															<input type="text" id="hero_naver_influencer_name" name="hero_naver_influencer_name" placeholder="���÷�� �г���" class="hero_sns_url" style="flex: 1;" value="<?=$hero_naver_influencer_name;?>" <?=$hero_qs_01_disabled?>/>
															<label for="hero_naver_influencer_category" class="dis-no">Ȱ�� ī�װ�</label>
															<select id="hero_naver_influencer_category" name="hero_naver_influencer_category" class="hero_sns_url select" style="flex: 1;" <?=$hero_qs_01_disabled?>>
																<option value=""<?if(!strcmp($hero_naver_influencer_category, '')){echo ' selected';}else{echo '';}?>>Ȱ�� ī�װ�</option>
																<option value="����"<?if(!strcmp($hero_naver_influencer_category, '����')){echo ' selected';}else{echo '';}?>>����</option>
																<option value="�м�"<?if(!strcmp($hero_naver_influencer_category, '�м�')){echo ' selected';}else{echo '';}?>>�м�</option>
																<option value="��Ƽ"<?if(!strcmp($hero_naver_influencer_category, '��Ƽ')){echo ' selected';}else{echo '';}?>>��Ƽ</option>
																<option value="Ǫ��"<?if(!strcmp($hero_naver_influencer_category, 'Ǫ��')){echo ' selected';}else{echo '';}?>>Ǫ��</option>
																<option value="IT��ũ"<?if(!strcmp($hero_naver_influencer_category, 'IT��ũ')){echo ' selected';}else{echo '';}?>>IT��ũ</option>
																<option value="�ڵ���"<?if(!strcmp($hero_naver_influencer_category, '�ڵ���')){echo ' selected';}else{echo '';}?>>�ڵ���</option>
																<option value="����"<?if(!strcmp($hero_naver_influencer_category, '����')){echo ' selected';}else{echo '';}?>>����</option>
																<option value="����"<?if(!strcmp($hero_naver_influencer_category, '����')){echo ' selected';}else{echo '';}?>>����</option>
																<option value="��Ȱ�ǰ�"<?if(!strcmp($hero_naver_influencer_category, '��Ȱ�ǰ�')){echo ' selected';}else{echo '';}?>>��Ȱ�ǰ�</option>
																<option value="����"<?if(!strcmp($hero_naver_influencer_category, '����')){echo ' selected';}else{echo '';}?>>����</option>
																<option value="����/��"<?if(!strcmp($hero_naver_influencer_category, '����/��')){echo ' selected';}else{echo '';}?>>����/��</option>
																<option value="�/����"<?if(!strcmp($hero_naver_influencer_category, '�/����')){echo ' selected';}else{echo '';}?>>�/����</option>
																<option value="���ν�����"<?if(!strcmp($hero_naver_influencer_category, '���ν�����')){echo ' selected';}else{echo '';}?>>���ν�����</option>
																<option value="���/����"<?if(!strcmp($hero_naver_influencer_category, '���/����')){echo ' selected';}else{echo '';}?>>���/����</option>
																<option value="��������"<?if(!strcmp($hero_naver_influencer_category, '��������')){echo ' selected';}else{echo '';}?>>��������</option>
																<option value="��ȭ"<?if(!strcmp($hero_naver_influencer_category, '��ȭ')){echo ' selected';}else{echo '';}?>>��ȭ</option>
																<option value="����/����/����"<?if(!strcmp($hero_naver_influencer_category, '����/����/����')){echo ' selected';}else{echo '';}?>>����/����/����</option>
																<option value="����"<?if(!strcmp($hero_influencer_category, '����')){echo ' selected';}else{echo '';}?>>����</option>
																<option value="����/����Ͻ�"<?if(!strcmp($hero_naver_influencer_category, '����/����Ͻ�')){echo ' selected';}else{echo '';}?>>����/����Ͻ�</option>
																<option value="����/����"<?if(!strcmp($hero_naver_influencer_category, '����/����')){echo ' selected';}else{echo '';}?>>����/����</option>
														</select>
														</div>
													</dd>
												</dl>												
												<dl>
													<dd><label for="hero_blog_03">��Ʃ��</label><input type="text" name="hero_blog_03" id="hero_blog_03" placeholder="URL�� �Է����ּ���" class="hero_sns_url" value="<?=$hero_blog_03;?>" <?=$hero_qs_01_disabled?>/></dd>
													<dd><label for="hero_blog_06">���̹� TV</label><input type="text" name="hero_blog_06" id="hero_blog_06" placeholder="URL�� �Է����ּ���" class="hero_sns_url" value="<?=$hero_blog_06;?>" <?=$hero_qs_01_disabled?>/></dd>
													<dd><label for="hero_blog_07">ƽ��</label><input type="text" name="hero_blog_07" id="hero_blog_07" placeholder="URL�� �Է����ּ���" class="hero_sns_url" value="<?=$hero_blog_07;?>" <?=$hero_qs_01_disabled?>/></dd>
													<dd style="margin-bottom: 0;">
														<label for="hero_blog_05">�� �� SNS URL</label>
														<input type="text" name="hero_blog_05" id="hero_blog_05" class="hero_sns_url" placeholder="URL�� �Է����ּ���" value="<?=$hero_blog_05;?>" <?=$hero_qs_01_disabled?>/>
													</dd>
												</dl>
											</div>
										</div>
									</div>
									<p class="txt_default">AK Lover�� ü��� Ȱ���� ���ؼ��� ���� SNS URL �Է��� �ʿ��մϴ�.</p>
									<div class="div_tr">
										<p class="tit">���� ����</p>
										<div class="div_td etc_info">
											<!-- <dl>
												<dd>
													<label for="hero_qs_22">�Ǻ�Ÿ��</label>
													<select id="hero_qs_22" name="hero_qs_22" class="hero_sns_url select">
														<option value=""<?if(!strcmp($hero_qs_22, '')){echo ' selected';}else{echo '';}?>>����</option>
														<option value="�Ǽ�"<?if(!strcmp($hero_qs_22, '�Ǽ�')){echo ' selected';}else{echo '';}?>>�Ǽ�</option>
														<option value="�߼�"<?if(!strcmp($hero_qs_22, '�߼�')){echo ' selected';}else{echo '';}?>>�߼�</option>
														<option value="����"<?if(!strcmp($hero_qs_22, '����')){echo ' selected';}else{echo '';}?>>����</option>
														<option value="���ռ�"<?if(!strcmp($hero_qs_22, '���ռ�')){echo ' selected';}else{echo '';}?>>���ռ�</option>
														<option value="�ΰ���"<?if(!strcmp($hero_qs_22, '�ΰ���')){echo ' selected';}else{echo '';}?>>�ΰ���</option>
													</select>	
												</dd>
											</dl>
											<dl>
												<dd>
													<label for="hero_qs_23">����Ÿ��</label>
													<select id="hero_qs_23" name="hero_qs_23" class="hero_sns_url select">
														<option value=""<?if(!strcmp($hero_qs_23, '')){echo ' selected';}else{echo '';}?>>����</option>
														<option value="�Ǽ�"<?if(!strcmp($hero_qs_23, '�Ǽ�')){echo ' selected';}else{echo '';}?>>�Ǽ�</option>
														<option value="�߼�"<?if(!strcmp($hero_qs_23, '�߼�')){echo ' selected';}else{echo '';}?>>�߼�</option>
														<option value="����"<?if(!strcmp($hero_qs_23, '����')){echo ' selected';}else{echo '';}?>>����</option>
														<option value="�ΰ���"<?if(!strcmp($hero_qs_23, '�ΰ���')){echo ' selected';}else{echo '';}?>>�ΰ���</option>
													</select>
												</dd>
											</dl> -->
											<dl>
												<dd>
													<label for="hero_qs_02">��ȥ ����</label>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_02" id="hero_qs_02_N" value="N" <?=$member_list["hero_qs_02"]=="N" ? "checked":"";?>/><label for="hero_qs_02_N">��ȥ</label></div>
													</div>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_02" id="hero_qs_02_Y" value="Y" <?=$member_list["hero_qs_02"]=="Y" ? "checked":"";?>/><label for="hero_qs_02_Y">��ȥ</label></div>						
													</div>
												</dd>
											</dl>	
											<dl>
												<dd>
													<label for="hero_qs_03">�ڳ� ����/�¾ �⵵</label>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_03" id="hero_qs_03_N" value="N" <?=$member_list["hero_qs_03"]=="N" ? "checked":"";?>/><label for="hero_qs_03_N">����</label></div>
													</div>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_03" id="hero_qs_03_Y" value="Y" <?=$member_list["hero_qs_03"]=="Y" ? "checked":"";?>/><label for="hero_qs_03_Y">����</label></div>
													</div>
													<div class="children" <?=$hero_qs_03_block?>>
														<ul>
															<li>
																<div class="input_radio"><input type="radio" name="hero_qs_04" id="hero_qs_04_1" value="1" <?=$hero_qs_04=="1" ? "checked":""?>/><label for="hero_qs_04_1">1��</label></div>
																<select name="hero_qs_05[]" class="hero_sns_url select">
																	<option value="">����</option>
																	<? for($i=date("Y"); $i > 1921; $i--) {?>
																	<option value="<?=$i?>" <?=$hero_qs_05_arr[0]==$i ? "selected":""?>><?=$i?></option>
																	<? } ?>
																</select>
															</li>
															<li>
																<div class="input_radio"><input type="radio" value="2" name="hero_qs_04" id="hero_qs_04_2" <?=$hero_qs_04=="2" ? "checked":""?>/><label for="hero_qs_04_2">2��</label></div>
																<select name="hero_qs_05[]" class="hero_sns_url select">
																	<option value="">����</option>
																	<? for($i=date("Y"); $i > 1921; $i--) {?>
																	<option value="<?=$i?>" <?=$hero_qs_05_arr[1]==$i ? "selected":""?>><?=$i?></option>
																	<? } ?>
																</select>
															</li>
															<li>
																<div class="input_radio"><input type="radio" name="hero_qs_04"  id="hero_qs_04_3" value="3" <?=$hero_qs_04=="3" ? "checked":""?>/><label for="hero_qs_04_3">3��</label></div>
																<select name="hero_qs_05[]" class="hero_sns_url select">
																	<option value="">����</option>
																	<? for($i=date("Y"); $i > 1921; $i--) {?>
																	<option value="<?=$i?>" <?=$hero_qs_05_arr[2]==$i ? "selected":""?>><?=$i?></option>
																	<? } ?>
																</select>
															</li>
															<li>
																<div class="input_radio"><input type="radio" name="hero_qs_04" id="hero_qs_04_4" value="4" <?=$hero_qs_04=="4" ? "checked":""?>/><label for="hero_qs_04_4">4��</label></div>
																<select name="hero_qs_05[]" class="hero_sns_url select">
																	<option value="">����</option>
																	<? for($i=date("Y"); $i > 1921; $i--) {?>
																	<option value="<?=$i?>" <?=$hero_qs_05_arr[3]==$i ? "selected":""?>><?=$i?></option>
																	<? } ?>
																</select>
															</li>
															<li>
																<div class="input_radio"><input type="radio" name="hero_qs_04" id="hero_qs_04_5" value="5" <?=$hero_qs_04=="5" ? "checked":""?>/><label for="hero_qs_04_5">5��</label></div>
																<select name="hero_qs_05[]" class="hero_sns_url select">
																	<option value="">����</option>
																	<? for($i=date("Y"); $i > 1921; $i--) {?>
																	<option value="<?=$i?>" <?=$hero_qs_05_arr[4]==$i ? "selected":""?>><?=$i?></option>
																	<? } ?>
																</select>
															</li>
														</ul>
													</div>
												</dd>
											</dl>	
											<dl>
												<dd>
													<label for="hero_qs_19">�ݷ����� ����</label>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_19" id="hero_qs_19_N" value="N" <?=$member_list["hero_qs_19"]=="N" ? "checked":"";?>/><label for="hero_qs_19_N">����</label></div>
													</div>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_19" id="hero_qs_19_Y" value="Y" <?=$member_list["hero_qs_19"]=="Y" ? "checked":"";?>/><label for="hero_qs_19_Y">����</label></div>						
													</div>
												</dd>
											</dl>	
											<dl>
												<dd>
													<label for="hero_qs_20">������ ����</label>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_20" id="hero_qs_20_N" value="N" <?=$member_list["hero_qs_20"]=="N" ? "checked":"";?>/><label for="hero_qs_20_N">����</label></div>
													</div>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_20" id="hero_qs_20_Y" value="Y" <?=$member_list["hero_qs_20"]=="Y" ? "checked":"";?>/><label for="hero_qs_20_Y">����</label></div>						
													</div>
												</dd>
											</dl>	
											<dl>
												<dd>
													<label for="hero_qs_21">�ı⼼ô�� ����</label>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_21" id="hero_qs_21_N" value="N" <?=$member_list["hero_qs_21"]=="N" ? "checked":"";?>/><label for="hero_qs_21_N">����</label></div>
													</div>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_21" id="hero_qs_21_Y" value="Y" <?=$member_list["hero_qs_21"]=="Y" ? "checked":"";?>/><label for="hero_qs_21_Y">����</label></div>						
													</div>
												</dd>
											</dl>	
											<dl>
												<dd>
													<label for="hero_qs_21">AK Lover�� ������ ����</label>
													<input type="text" name="hero_qs_06" class="w550" value="<?=$member_list["hero_qs_06"]?>" />
												</dd>
											</dl>
											<dl>
												<dd style="margin-bottom: 0;">
													<label for="hero_qs_21">AK Lover �� Ȱ��</label>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_07" id="hero_qs_07_N" value="N" <?=$member_list["hero_qs_07"]=="N" ? "checked":"";?>/><label for="hero_qs_07_N">����</label></div>
													</div>
													<div>
														<div class="input_radio"><input type="radio" name="hero_qs_07" id="hero_qs_07_Y" value="Y" <?=$member_list["hero_qs_07"]=="Y" ? "checked":"";?>/><label for="hero_qs_07_Y">����</label></div>			
													</div>
													<input type="text" name="hero_qs_08" class="w390" value="<?=$hero_qs_08?>" <?=$hero_qs_07_disabled?>/>			
												</dd>
											</dl>															
										</div>										
									</div>
									<div class="input_chk txt_default agree_chk_box">
										<input type="checkbox" id="agree_chk" name="agree">
										<label for="agree_chk" class="input_chk_label">�������� �������̿뵿�� �����׸�</label>
									</div>										
									<p class="txt_default">AK Lover�� ü��� Ȱ���� ���ؼ��� �������� �Է��� �ʿ��մϴ�.</p>		
								</div>	
							</div>						
							<div class="btngroup tc" >
								<a href="javascript:;" class="btn_submit btn_black" onClick="go_submit(document.form_next)">���� ���� �ϱ�</a>
							</div>
						</div>						
					</form>
				</div>
				<!-- //TODO �뵵 Ȯ�� �ʿ� 210414 -->
				<form id="infoEditForm" >
					<input type="hidden" name="snsId">
					<input type="hidden" name="snsType">
				</form>    
			</div>
		</div>
	</div>
</div>


<script src="https://apis.google.com/js/api:client.js"></script>
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(document).on("keyup", "input:text[suOnly]", function() {$(this).val( $(this).val().replace(/[^0-9]/gi,"") );});
});

// �������� ����, �̿�E�� �����׸� üũ
const chkbox = document.querySelector("#agree_chk");
let status = false;

chkbox.addEventListener("change",function(){
	if(chkbox.checked){
		status = true;
	} else {
		status = false;
	}
});

//(s)210203 google ����
var googleUser = {};
var startApp = function() {
  gapi.load('auth2', function(){
    // Retrieve the singleton for the GoogleAuth library and set up the client.
    auth2 = gapi.auth2.init({
      client_id: '7087940352-ce573qthsm2s4s806bp9c82k3fnoid1n.apps.googleusercontent.com',
      //cookiepolicy: 'http://localhost',
      cookiepolicy: '//www.aklover.co.kr',
    });
    attachSignin(document.getElementById('btn_google'));
  });
};

function attachSignin(element) {
  auth2.attachClickHandler(element, {},
      function(googleUser) {
		var where = "infoedit";
      	var url="zip_sns.php";
		var params = "snsId="+googleUser.getBasicProfile().getId()+"&snsType=google&snsWhere="+where;
  	    $.ajax({      
  	        type:"POST",  
  	        url:url,      
  	        data:params,
  	        async : false,
  	        success:function(args){
  	        	snsResult = args;
  	        	$(".img-loading").css("display","none");
  	        },complete:function(){
      	       	$('.img-loading').css('display','none'); 
		    },error:function(e){  
  	            alert("SNS ���� �����Դϴ�. �ٽ� �õ����ּ���");
  	            location.reload();  
  	        }
  	    });

  	    if(snsResult==1){
  	    	location.href="/main/index.php?sns=snsAuth&board="+where;
		}else if(snsResult.substring(0,7)=='message'){
			alert(snsResult.substring(8));
			location.href="/main/index.php?sns=snsAuth&board="+where;
		}else{
			alert("�ý��� �����Դϴ�. �ٽ� �õ����ּ���.");
			location.href="/main/index.php?sns=snsAuth&board="+where;
		}
	    
      }, function(error) {
        //alert(JSON.stringify(error, undefined, 2));
        console.log(JSON.stringify(error, undefined, 2));
      });
}

startApp();
// (e)210203 google ����

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
		$("input:radio[name='hero_qs_04']").attr("checked",false);
		$("select[name='hero_qs_05[]']").val("");
	}
})

$("input:radio[name='hero_qs_07']").on("click",function(){
	if($(this).val() == "Y") {
		$("input[name='hero_qs_08']").attr("disabled",false);
	} else {
		$("input[name='hero_qs_08']").val("");
		$("input[name='hero_qs_08']").attr("disabled",true);
	}
})

function emailChg(){
	if(form_next.email_select.value != "")  $('#hero_mail_02').attr('readonly', true);
	else $('#hero_mail_02').attr('readonly', false);
    form_next.hero_mail_02.value = form_next.email_select.value;

}
        
function onlyNumber(event) {
    var key = window.event ? event.keyCode : event.which;    

    if ((event.shiftKey == false) && ((key  > 47 && key  < 58) || (key  > 95 && key  < 106)
    || key  == 35 || key  == 36 || key  == 37 || key  == 39  // ����Ű �¿�,home,end  
    || key  == 8  || key  == 46 ) // del, back space
    ) {
        return true;
    }else {
        return false;
    }    
};


// �⺻���� ����
function default_submit(form) {
    var mail_01 = form.hero_mail_01;
    var mail_02 = form.hero_mail_02;
    var hp_01 = form.hero_hp_01;
    var hp_02 = form.hero_hp_02;
    var hp_03 = form.hero_hp_03;
    var address_01 = form.hero_address_01;
    var address_02 = form.hero_address_02;
    var address_03 = form.hero_address_03;
            
    if(mail_01.value == ""){
        alert("�̸���(1)�� �Է��ϼ���.");
        mail_01.style.borderBottom = '1px solid red';
        mail_01.focus();
        return false;
    }
    if(mail_02.value == ""){
        alert("�̸���(2)�� �����ϼ���.");
        mail_02.style.borderBottom = '1px solid red';
        mail_02.focus();
        return false;
    }

    if(hp_01.value == ""){
        alert("�޴�����ȣ(1)�� �Է��ϼ���.");
        hp_01.style.borderBottom = '1px solid red';
        hp_01.focus();
        return false;
    }
    if(hp_02.value == ""){
        alert("�޴�����ȣ(2)�� �Է��ϼ���.");
        hp_02.style.borderBottom = '1px solid red';
        hp_02.focus();
        return false;
    }
    if(hp_03.value == ""){
        alert("�޴�����ȣ(3)�� �Է��ϼ���.");
        hp_03.style.borderBottom = '1px solid red';
        hp_03.focus();
        return false;
    }

    if(address_01.value == ""){
        alert("�����ȣ�� �Է��ϼ���.");
        address_01.style.borderBottom = '1px solid red';
        address_01.focus();
        return false;
    }
    if(address_02.value == ""){
        alert("�ּҸ� �Է��ϼ���.");
        address_02.style.borderBottom = '1px solid red';
        address_02.focus();
        return false;
    }
    if(address_03.value == ""){
        alert("�������ּҸ� �Է��ϼ���.");
        address_03.style.borderBottom = '1px solid red';
        address_03.focus();
        return false;
    }

    form.submit();
    return true;
}		

// �߰����� ����
function go_submit(form) {
   
    var blog_00 = form.hero_blog_00;
    var qs_08 = form.hero_qs_08;
    var area_etc_text = form.area_etc_text;

    if($("input:radio[name='area']:checked").val() == "��Ÿ") {
		if(!$("input[name='area_etc_text']").val()) {
			alert("AK Lover�� �˰Ե� ��� ��Ÿ ���� �� ������ �Է��� �ּ���.");
			$("input[name='area_etc_text']").focus();
			$("input[name='area_etc_text']").css("border","1px solid #f00");
			return;
		}
	}

    var hero_sns_url_check = true;
	if($("input:radio[name='hero_qs_01']:checked").val() == "Y") {
		hero_sns_url_check = false;
		$(".hero_sns_url").each(function(i){
			if($(this).val()) {
				hero_sns_url_check = true;
			}
		})
		
		if(form.hero_naver_influencer.value!='') {
    		if(form.hero_naver_influencer_name.value=='') {
    			alert("���÷�𽺸� �Է��� �ʿ��մϴ�.");
    			$("#hero_naver_influencer_name").css("border","1px solid #f00");
				$("#hero_naver_influencer_name").focus();
    			return false;
    		} else {
    			if(form.hero_naver_influencer_category.value=='') {
    				alert("���÷�� ī�װ� ������ �ʿ��մϴ�.");
    				return false;
    			}
    		}
    	} else {
    		form.hero_naver_influencer_name.value = '';
    		form.hero_naver_influencer_category.value = '';
    		
    		hero_sns_url_check = false;
    		$(".hero_sns_url").each(function(i){
    			if($(this).val()) {
    				hero_sns_url_check = true;
    			}
    		})
    	}
	}	

	if(!hero_sns_url_check) {
		alert("���� SNS URL �ִ� ��� ���� �� �ּ� 1���� ���� SNS URL �Է��� �ʿ��մϴ�.");
		$("#hero_blog_00").css("border","1px solid #f00");
		$("#hero_blog_00").focus();
		return false;
	}

	if($("input:radio[name='hero_qs_03']:checked").val() == "Y") {
		if(!$("input:radio[name='hero_qs_04']").is(":checked")) {
			alert("�ڳ���� ������ �ּ���.");
			return false;
		}
		var hero_qs_05_check = 0;
		var k = 0;
		$("select[name='hero_qs_05[]']").each(function(i){
			if($(this).val()) {
				k++;
			}
		})

		if($("input:radio[name='hero_qs_04']:checked").val() != k) {
			alert("������ �ڳ��� �¾ �⵵�� ������ �ּ���.");
			return false;
		}
	}

	if($("input:radio[name='hero_qs_07']:checked").val() == "Y") {
		if(!$("input[name='hero_qs_08']").val()) {
			alert("AK Lover�� Ȱ���ϴ� ��������/ü��� ī�� �Ǵ� Ȩ�������� �Է����ּ���.");
			$("input[name='hero_qs_08']").focus();
			$("input[name='hero_qs_08']").css("border","1px solid #f00");
			return false;
		}	
	}

	if(!status) {
		alert("�������� ���� �̿뵿�� �׸� üũ���ֽñ� �ٶ��ϴ�.");
		return false;
	}

    form.submit();
    return true;
}		
</script>
				
    