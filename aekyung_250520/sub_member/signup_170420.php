<?
####################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
if(!$_SESSION['temp_level'] || $_SESSION['temp_level']<9999){

	if((!$_POST['param_r6'] || !$_POST['param_r5']) && (!$_POST['snsId'] || !$_POST['snsType'])){
		error_historyBack("�� ���� �����Դϴ�.");
		exit;
	}
	####################################################################################################################################################
	$error = "SIGNUP_01";
	if($_POST['param_r5'] && $_POST['param_r6']){
		$sql = "select count(*) from member where hero_info_di='".$_POST['param_r5']."' and hero_info_ci='".$_POST['param_r6']."' and hero_use=0";
	}elseif($_POST['snsId'] && $_POST['snsType']){
		$sql = "select count(*) from member where hero_".$_POST['snsType']."='".$_POST['snsId']."' and hero_use=0";
	}
	
	//echo $sql;
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

####################################################################################################################################################
//���� ���Խ�
if($_POST['param_r5'] && $_POST['param_r6'] && $_POST['param_r2']){
	$di = $_POST['param_r5'];
	$ci = $_POST['param_r6'];
	
	$param_r2_01 = substr($_POST['param_r2'], '0', '4');//��
	$param_r2_02 = substr($_POST['param_r2'], '4', '2');//��
	$param_r2_03 = substr($_POST['param_r2'], '6', '2');//��
	
	if(!$param_r2_01 || !$param_r2_02 || !$param_r2_03){
		error_location("�ý��� �����Դϴ�. �ٽ� �õ����ּ���","/main/index.php?board=idcheck");
		exit;
	}
	
	include_once $_SERVER['DOCUMENT_ROOT']."/classGathered/chAgeClass.php";
	$chAgeClass = new chAgeClass($param_r2_01,$param_r2_02,$param_r2_03);
	$age = $chAgeClass->countUniversalAge();
	if((int)$age<15){
		error_location("��14�� �̸��� �����Ͻ� �� �����ϴ�.","/main/index.php");
		exit;
	}
	
	$readonly_auth = "readonly";
	$disabled_auth = "disabled='disabled'";
	$displaynone_auth = "style='display:none'";
//sns ���Խ�
}else{
	
	$snsId = $_POST['snsId'];
	$snsEmail = explode("@",$_POST['snsEmail']);
	$snsType = $_POST['snsType'];
	
	switch($snsType){
		case "facebook" : $snsText = "<img src='/image2/etc/snsBig01.jpg' alt='".$snsType."'> ȸ������ ���̽����� �����Ǿ����ϴ�";break;
		case "kakaoTalk" : $snsText = "<img src='/image2/etc/snsBig02.jpg' alt='".$snsType."'> ȸ������ īī������ �����Ǿ����ϴ�";break;
		case "naver" : $snsText = "<img src='/image2/etc/snsBig03.jpg' alt='".$snsType."'> ȸ������ ���̹� ���̵� �����Ǿ����ϴ�";break;
	}
	
	$readonly_sns = "readonly";
	$disabled_sns = "disabled='disabled'";
	$displaynone_sns = "style='display:none'";
	
	$param_r2_01 = Y;
	$param_r2_02 = m;
	$param_r2_03 = d;
}	
?>
	<style>
		table.member th{background-color:#fef4eb;}
	</style>
    <script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
	<script src="/js/daumAddressApi.js"></script>
    <script>
	$(document).ready(function(){
		$(document).on("keyup", "input:text[suOnly]", function() {$(this).val( $(this).val().replace(/[^0-9]/gi,"") );});
		$(document).on("keyup", "input:text[textOnly]", function() {$(this).val( $(this).val().replace(/[^��-����-�Ӱ�-�Ra-zA-Z]/gi,"") );});
	});
	</script>
    <div class="contents_area">
        <div class="layer_zip">
            <form name="login_form" action="<?=PATH_HOME_HTTPS?>?board=result" onsubmit="return false;">
            <dl>
                <dt><img src="../image/member/zip1.gif" alt="�����ȣ ã��" /></dt>
                <dd>
                <input id="addr" type="text" class="addr" /><input type="image" src="../image/member/btn_findzip.gif" alt="�ּ�ã��" onclick="hero_ajax('zip.php', 'view_list', 'addr', 'zip'); return false;"/>
                </dd>
                <dd class="list">
                    <div id="view_list"></div>
                </dd>
                <dd class="tc"><a href="javascript:inputzip();"><img src="../image/member/btn_cancel.gif" alt="�Է�" /></a></dd>
            </dl>
            </form>
        </div>
        <div class="page_title">
            <h2><img src="../image/title/title_7_1.gif" alt="ȸ������" /></h2>
            <ul class="nav">
                <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
                <li>&gt;</li>
                <li class="current">ȸ������</li>
            </ul>
        </div>
        <div class="contents">
        <form name="form_next" action="<?=PATH_HOME_HTTPS?>?board=result" enctype="multipart/form-data" method="post" onsubmit="return false;">
            <input type="hidden" name="hero_jumin" value="<?=$_POST['param_r2']?>">
            <input type="hidden" name="hero_sex" value="<?=$_POST['param_r3']?>">
            <input type="hidden" name="hero_login_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
            <input type="hidden" name="hero_info_type" value="<?=$_POST['param_r4']?>">
            <input type="hidden" name="hero_info_di" value="<?=$di?>">
            <input type="hidden" name="hero_info_ci" value="<?=$ci?>">
            <input type="hidden" name="snsType" value="<?=$snsType?>">
            <input type="hidden" name="snsId" value="<?=$snsId?>">
            <input type="hidden" id="ch_term_01" value="false">
            <input type="hidden" id="ch_term_02" value="false">
            <input type="hidden" id="ch_term_03" value="false">
            <input type="hidden" id="ch_term_04" value="false">
            <input type="hidden" id="ch_term_05" value="false">
			<!-- 160701 ���Ʒ� �߰��������� �̺�Ʈ(s) -->
			<input type="hidden" name="question_null_yn" value="N">
			<!-- 160701 ���Ʒ� �߰��������� �̺�Ʈ(e) -->
			
            <p style="padding-bottom: 20px;"><?=$snsText?></p>
            
            <div class="signup_term">
	            <div class="signup_term_title">�� (�ʼ�) �̿� ���</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term1.php";?>
	            </div>
	            <div>�ص������� ���� ��� ȸ�������� ���� �ʽ��ϴ�.<div class="signup_term_agree"><input type="radio" name="hero_terms_01" class="partAgree_btn" value='0'/>����<input type="radio" class="partAgree_btn" name="hero_terms_01" value='1'/>���Ǿ���</div></div>
	            
	            <div class="signup_term_title">�� (�ʼ�) �������� ��޹�ħ</div>
	            <div class="signup_term_title ">�����ϴ� �������� �׸� �� �������</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term4.html";?>
	            </div>
	            <div>�ص������� ���� ��� ȸ�������� ���� �ʽ��ϴ�.<div class="signup_term_agree"><input type="radio" name="hero_terms_02" class="partAgree_btn" value='0'/>����<input type="radio" class="partAgree_btn" name="hero_terms_02" value='1'/>���Ǿ���</div></div>
	            
	            <div class="signup_term_title">(�ʼ�) ���������� ���� �� �̿� ����</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term5.html";?>
	            </div>
				<div>�ص������� ���� ��� ȸ�������� ���� �ʽ��ϴ�.<div class="signup_term_agree"><input type="radio" name="hero_terms_03" class="partAgree_btn" value='0'/>����<input type="radio" class="partAgree_btn" name="hero_terms_03" value='1'/>���Ǿ���</div></div>
				
	            <div class="signup_term_title">(�ʼ�) ���������� ���� �� �̿�Ⱓ</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term6.html";?>
	            	</div>
				<div>�ص������� ���� ��� ȸ�������� ���� �ʽ��ϴ�.<div class="signup_term_agree"><input type="radio" name="hero_terms_04" class="partAgree_btn" value='0'/>����<input type="radio" class="partAgree_btn" name="hero_terms_04" value='1'/>���Ǿ���</div></div>
                <div class="signup_term_title">(�ʼ�) �������� �����Ź����</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term7.html";?>
	            	</div>
				<div>�ص������� ���� ��� ȸ�������� ���� �ʽ��ϴ�.<div class="signup_term_agree"><input type="radio" name="hero_terms_05" class="partAgree_btn" value='0'/>����<input type="radio" class="partAgree_btn" name="hero_terms_05" value='1'/>���Ǿ���</div></div>
            </div>
            
            
            <p class="member_alert"><span>*</span>�� �ʼ� ���� �׸��Դϴ�!!!</p>
            
            <table class="member">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr>
                    <th><span>*</span> ���̵�</th>
                    <td>
                        <input type="text" name="hero_id" id="hero_id" style="ime-mode:disabled;" onfocusout="ch_id(this);" value=""/>
                        <span id="ch_id_text">4~20�� ����, Ư������(!@#$%) ���Ұ�</span>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> ��й�ȣ</th>
                    <td><input type="password" name="hero_pw_01" id="hero_pw_01" onkeyup="chPwdTF(this);"/>&nbsp;&nbsp;<span id="ch_hero_pw_01">����, ����, Ư����ȣ�� �����Ͽ� 8�ڸ� �̻� �Է����ּ���</span></td>
                </tr>
                <tr>
                    <th><span>*</span> ��й�ȣ Ȯ��</th>
                    <td><input type="password" name="hero_pw_02" id="hero_pw_02" onkeyup="chPwdTF(this);"/>&nbsp;&nbsp;<span id="ch_hero_pw_02"></span></td>
                </tr>
                <tr>
                    <th><span>*</span> �̸�</th>
                    <td><input type="text" name="hero_name" value="<?=$_POST['param_r1']?>" <?=$readonly_auth?> /></td>
                </tr>
                <tr>
                    <th><span>*</span> �г���</th>
                    <td>
                        <input type="text" name="hero_nick" id="hero_nick_02" onkeyup="ch_nick(this);"/>
                        <span id="ch_nick_text"></span>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> �������</th>
                    <td>
                        <select id="year" title="����⵵ ����" class="mr12" <?=$disabled_auth?>></select>
                        <select id="month" title="����� ����" class="mr12" <?=$disabled_auth?>></select>
                        <select id="date" title="����� ����" class="mr12" <?=$disabled_auth?>></select><br/>
                        <p>�� 14�� �̸��� ȸ�������� �Ұ��մϴ�.<p>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> �̸���</th>
                    <td>
                        <input type="text" name="hero_mail_01" value="<?=$snsEmail[0]?>" style="ime-mode:disabled;" > @<br/>
                        <input type="text" id="hero_mail_02" name="hero_mail_02" value="<?=$snsEmail[1]?>" style="ime-mode:disabled;" >
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

                         <p style="height:25px;">�̸��� ����&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="hero_chk_email" value='1' style='width:13px;' checked="checked">����
							<input type="radio" name="hero_chk_email" value='0' style='width:13px;'>���Ǿ���
						</p>
						<p>���ſ� �����Ͻø� ���� �̼�/�̺�Ʈ�� Ȯ���Ͻ� �� �ֽ��ϴ�.</p>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> �޴���</th>
                    <td>
                        <input type="text" name="hero_hp_01" id="hero_hp_01" style="width:125px;" onkeyup="if(this.value.length > 2)hero_hp_02.focus();" maxlength="3" suOnly="true"/>
                        <input type="text" name="hero_hp_02" id="hero_hp_02" style="width:125px;" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" suOnly="true"/>
                        <input type="text" name="hero_hp_03" id="hero_hp_03" style="width:125px;" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" suOnly="true"/>
						
						<p style="height:25px;">
							<span>SMS ����&nbsp;&nbsp;&nbsp;&nbsp;</span>
							<input type="radio" name="hero_chk_phone" value='1' style='width:13px;' checked="checked">����
							<input type="radio" name="hero_chk_phone" value='0' style='width:13px;'>���Ǿ���<br>
						</p>
						<p>���ſ� �����Ͻø� ���� �̼�/�̺�Ʈ������ �޾� ���� �� �ֽ��ϴ�.</p>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> �ּ�</th>
                    <td>
                        <input type="text" name="hero_address_01" id="hero_address_01" onclick="javascript:btnAddressGet();" class="w190" />
                        <a href="javascript:btnAddressGet()"><img src="../image/member/btn_zipcode.gif" alt="�����ȣã��" /></a><br />
                        <input type="text" name="hero_address_02" id="hero_address_02" onclick="javascript:btnAddressGet();" class="w390" style="margin-top:5px;" /><br />
                        <input type="text" name="hero_address_03" id="hero_address_03" class="w390" style="margin-top:5px;" />
                    </td>
                </tr>
             
             
                <tr>
                    <th><span>*</span> AK Lover��<br/>�˰Ե� ��δ�?</th>
                    <td>
                    	<p>
                        <input type="radio" name="area" value="����" checked="checked"/> &nbsp;����
                        <input type="radio" name="area" value="�Ź�"/> &nbsp;�Ź� 
                        <input type="radio" name="area" value="����"/> &nbsp;���� 
                        <input type="radio" name="area" value="��α�"/>&nbsp; ��α� 
                        <br/>
                        <input type="radio" name="area" value="����"/> &nbsp;ī�� 
                        <input type="radio" name="area" value="���̽���"/> &nbsp;���̽���
                        <input type="radio" name="area" value="�ν�Ÿ�׷�"/> &nbsp;�ν�Ÿ�׷� 
                        <input type="radio" name="area" value="����"/> &nbsp;���� 
                        <br/>
                        <input type="radio" name="area" value="����"/> &nbsp;���� 
                        <input type="radio" name="area" value="��Ÿ"/> &nbsp;��Ÿ 
                        </p>
                        <p>��Ÿ <input type="text" name="area_etc_text" class="w390" maxlength="50" disabled="disabled"/></p>
                    </td>
                </tr>
                <tr>
                    <th class='notneed'>��õ��</th>
                    <td>
                        	��õ���� ID �Ǵ� �г����� �־��ּ���.<br> * ���̵� �Ǵ� �г����� ��Ȯ�ϰ� �̷��ؾ� ��õ�ο��� ����Ʈ�� �����˴ϴ�.<br>
                        <input type="text" name="hero_user" id="hero_user" class="w390" />
                    </td>
                </tr>
              </table>
              
              <div style="margin-top:30px;"><img src="/image2/intro/aklover/updateInfoEvent.png" /></div>
              <table class="member">
              <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup
                ><tr>
                    <th>����URL</th>
                    <td class='notneed'>
                    	<p>
                        <input type="radio" name="hero_qs_09" value="�ִ�"/>�ִ� 
			            <input type="radio" name="hero_qs_09" value="����"  checked="checked"/>����
                        </p>
                        <table class="tb_blog">
                        <col width="130" />
						<col width="*" />
                        	<tr style="border:none;">
                        		<td style="border:none; height:30px;">��α� URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_00" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">���̽��� URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_01" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">Ʈ���� URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_02" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">�ν�Ÿ�׷� URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_04" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">īī�����丮 URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_03" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">�׿� SNS &nbsp;&nbsp; SNS �̸�</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_05_name" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SNS URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_05" class="w390" disabled="disabled"/></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                </table>
                <table class="member" style="margin-top:10px;">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr>
                	<th>��α׿</th>
                    <td>
                    	<span class="tname" style="font-weight:bold;">����� ��αװ� �ֳ���?</span>
                    	<p>
                        <input type="radio" name="hero_qs_10" value="�ִ�"/>�ִ� 
			            <input type="radio" name="hero_qs_10" value="����"  checked="checked"/>����
                        </p>
                        <br/>
                   	    <span class="tname" style="font-weight:bold;">�����Ͽ� �������� ��� �� �� ���ε� �Ͻó���?</span>
                        <br/>
                        <input type="text" name="hero_qs_01" suOnly="true" style="width:200px;" class="blog_type"  maxlength="30" disabled="disabled"/>
                        <br/><br/>
                    	<span class="tname" style="font-weight:bold;">� ���� ��α��� ��� �� �湮�ڴ� �� ���ΰ���?</span>
			                        <br/>
			                        <input type="radio" name="hero_qs_02" value="200��" class="blog blog_type" disabled="disabled"/>200�� ����
			                        <input type="radio" name="hero_qs_02" value="200~800��" class="blog blog_type" disabled="disabled"/>200~800��
			                        <input type="radio" name="hero_qs_02" value="801~1,500��" class="blog blog_type" disabled="disabled"/>801~1,500��
			                        <br/>
			                        <input type="radio" name="hero_qs_02" value="1,501~3,000��" class="blog blog_type" disabled="disabled"/>1,501~3,000��
			                        <input type="radio" name="hero_qs_02" value="3,001~4,000��" class="blog blog_type" disabled="disabled"/>3,001~4,000��
			                        <input type="radio" name="hero_qs_02" value="4,001~5,000��" class="blog blog_type" disabled="disabled"/>4,001~5,000��
                                    <br/>
			                        <input type="radio" name="hero_qs_02" value="5,001~10,000��" class="blog blog_type" disabled="disabled"/>5,001~10,000��
			                        <input type="radio" name="hero_qs_02" value="10,000�� �̻�" class="blog blog_type" disabled="disabled"/>10,000�� �̻�
			                        <br/><br/>
			                        <span class="tname" style="font-weight:bold;">��α� Ÿ��(�� �ߺ� ���� ����)</span>
			                        <br>
			                        <input type="checkbox" name="hero_qs_03[]" value="�м�" class="blog blog_type2" disabled="disabled"/>�м�
			                        <input type="checkbox" name="hero_qs_03[]" value="��Ƽ" class="blog blog_type2" disabled="disabled"/>��Ƽ
			                        <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2" disabled="disabled"/>���� 
			                        <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2" disabled="disabled"/>���� 
			                        <input type="checkbox" name="hero_qs_03[]" value="�ϻ�" class="blog blog_type2" disabled="disabled"/>�ϻ�
                                    <br/>
			                        <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2" disabled="disabled"/>����
                                    <input type="checkbox" name="hero_qs_03[]" value="�ֿ�" class="blog blog_type2" disabled="disabled"/>�ֿ�
                                    <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2" disabled="disabled"/>����
                                    <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2" disabled="disabled"/>����
                                    <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2" disabled="disabled"/>����
			                        <br/>
			                        <input type="checkbox" name="hero_qs_03[]" value="���" class="blog blog_type2" disabled="disabled"/>���
                                    <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2" disabled="disabled"/>����
                                    <input type="checkbox" name="hero_qs_03[]" value="�ǰ�" class="blog blog_type2" disabled="disabled"/>�ǰ�
                                    <input type="checkbox" name="hero_qs_03[]" value="IT" class="blog blog_type2" disabled="disabled"/>IT
                                    <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2" disabled="disabled"/>����
			                        <br>
                    </td>
                </tr>
                </table>
                <table class="member" style="margin-top:10px;">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr>
                	<th>��ȥ����</th>
                    <td>
                    	<input type="radio" name="hero_qs_04" value="��ȥ" checked="checked"/>��ȥ
                    	<input type="radio" name="hero_qs_04" value="��ȥ"/>��ȥ 
			        </td>
                </tr>
                </table>
                <table class="member" style="margin-top:10px;">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr>
                	<th>�ڳ࿬��</th>
                    <td>
                        <input type="radio" name="hero_qs_05" value="����" <?=$member_list["hero_qs_05"]=="����" ? "checked":"";?> checked="checked"/> ����
                   	 	<input type="radio" name="hero_qs_05" value="����" <?=$member_list["hero_qs_05"]=="����" ? "checked":"";?>/> ����
                   	 	<script>
                   			$("input[name=hero_qs_05]").change(function() {
                       			
	                   	 		var hero_qs_05 = $(this).val();
	                   	 		if(hero_qs_05 == "����"){
									$('#hero_qs_11_div').css('display','none');
									$('#hero_qs_12_div').css('display','none');
									$("input[name=hero_qs_11]").attr("disabled",true);
									$("input[name=hero_qs_11]").prop("checked",false);
									$("select[name=select_birth0]").attr("disabled",true);
									$("select[name=select_birth0]").val("");
		                       	 	$("select[name=select_birth1]").attr("disabled",true);
		                       		$("select[name=select_birth1]").val("");
		                       	 	$("select[name=select_birth2]").attr("disabled",true);
		                       		$("select[name=select_birth2]").val("");
		                       		$("select[name=select_birth3]").attr("disabled",true);
		                       		$("select[name=select_birth3]").val("");
		                       		$("select[name=select_birth4]").attr("disabled",true);
		                       		$("select[name=select_birth4]").val("");
	                       	 	}else{
	                       	 		$('#hero_qs_11_div').css('display','block');
	                       	 		$('#hero_qs_12_div').css('display','block');
	                       	 		$("input[name=hero_qs_11]").attr("disabled",false);
	                       	 		$("select[name=select_birth0]").attr("disabled",false);
		                       	 	$("select[name=select_birth1]").attr("disabled",false);
		                       	 	$("select[name=select_birth2]").attr("disabled",false);
		                       		$("select[name=select_birth3]").attr("disabled",false);
		                       		$("select[name=select_birth4]").attr("disabled",false);
	                           	}
                   			});

                   	 	</script>
                   	 	<div id="hero_qs_11_div" <?=$member_list["hero_qs_05"]=="����" ? "style='display:none;'":"";?> style='display:none';>
	                   	 	<input type="radio"  name="hero_qs_11" value="1��"  <?=$member_list["hero_qs_11"]=="1��" ? "checked":"";?>/> 1��
	                   	 	<input type="radio"  name="hero_qs_11" value="2��"  <?=$member_list["hero_qs_11"]=="2��" ? "checked":"";?>/> 2��
	                   	 	<input type="radio"  name="hero_qs_11" value="3��"  <?=$member_list["hero_qs_11"]=="3��" ? "checked":"";?>/> 3��
	                   	 	<input type="radio"  name="hero_qs_11" value="4��"  <?=$member_list["hero_qs_11"]=="4��" ? "checked":"";?>/> 4��
	                   	 	<input type="radio"  name="hero_qs_11" value="5��"  <?=$member_list["hero_qs_11"]=="5��" ? "checked":"";?>/> 5��
                   	 	</div>
                   	 	<script>
                   	 	$("input[name=hero_qs_11]").change(function() {
            				var hero_qs_11 = $(this).val();
            				var res = "";
            				var year = <?=date(Y)?>;
            				
            				hero_qs_11 = hero_qs_11.substring(0,1);
            				for(var i=0; i<hero_qs_11; i++){
                				res += "<select name='select_birth"+i+"' id='hero_qs_12_"+i+"'>";
                				res += "<option value=''>����</option>";
                				for(var j=year; j>=1900; j--){
                					res += "<option value='"+j+"'>"+j+"</option>";
                				}
                				res += "</select>";
                			}
            				$('#hero_qs_12_div').html(res); 
                		});
                   	 	</script>
                   	 	<div id="hero_qs_12_div" <?=$member_list["hero_qs_05"]=="����" ? "style='display:none;'":"";?>>
                   	 		<? 
                   	 		$res = "";
                   	 		$qs_11 = substr($member_list["hero_qs_11"],0,1);
                   	 		$qs_12 = explode(",", $member_list['hero_qs_12']);
                   	 		$year = date("Y");
                   	 		for($i=0; $i<$qs_11; $i++){
                   	 			$res .= "<select name='select_birth".$i."'>";
                   	 			$res .= "<option value=''>����</option>";
                   	 			for($j=$year; $j>=1900; $j--){
                   	 				if($qs_12[$i] == $j){ 
                   	 					$res .= "<option value='".$j."' selected>".$j."</option>";
                   	 				}else{
                   	 					$res .= "<option value='".$j."' >".$j."</option>";
                   	 				}
                   	 			}
                   	 			$res .= "</select>";
                   	 		}
                   	 		echo $res;
                   	 		?>
                   	 	</div>
                   	 	<input type="hidden"  name="hero_qs_12" id="hero_qs_12" />
                    </td>
                </tr>
                </table>
                <table class="member" style="margin-top:10px;">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr>
                	<th>AK�� ������ ����</th>
                    <td><input type="text" name="hero_qs_06" class="w390" maxlength="100"/></td>
                </tr>
                <tr>
                	<th>�ְ� �� Ȱ���ϴ�<br />��������</th>
                    <td><input type="radio" name="hero_qs_07" value="��" />�� <input type="radio" name="hero_qs_07" value="��" checked="checked"/>��<br/>
                    	<input type="text"  name="hero_qs_08" class="w390" maxlength="100" disabled="disabled"/>
                    </td>
                </tr>


            </table>
            
            <div class="btngroup tc">
                <input type="image" src="../image/member/btn_signup.gif" alt="ȸ�������ϱ�" onclick="go_submit(document.form_next)"/>
            </div>
            
        </form>
        </div>
    </div>
    
    <script type="text/javascript" src="/js/birthdate.js"></script>
    <script type="text/javascript">

    	$(document).ready(function(){
	   		date_populate("date", "month", "year", "<?=$param_r2_01;?>", "<?=number_format($param_r2_02);?>", "<?=number_format($param_r2_03);?>");
			/* $(".viewSitePolicy").click(function(){
				var terms = $(this).prop("class").substring(15);
				if(typeof terms!='undefined' || terms!=''){
					window.open("/popup/.php?policy="+terms,"","width=600, height=700, left=100, top=20");
				}
			}); */
			//alert("������ ���� ���Դϴ�.");
			
			
			$("input[name=area]").on("click",function(){
				if($(this).val()=="��Ÿ") {
					$("input[name=area_etc_text").attr("disabled",false);
				} else {
					$("input[name=area_etc_text").val("");
					$("input[name=area_etc_text").attr("disabled",true);
				}
			})
			
			//��α��ִ�/����
			$("input[name=hero_qs_09]").on("click",function(){
				if($(this).val()=="�ִ�") {
					$("input[name=hero_blog_00").attr("disabled",false);
					$("input[name=hero_blog_01").attr("disabled",false);
					$("input[name=hero_blog_02").attr("disabled",false);
					$("input[name=hero_blog_03").attr("disabled",false);
					$("input[name=hero_blog_04").attr("disabled",false);
					$("input[name=hero_blog_05").attr("disabled",false);
					$("input[name=hero_blog_05_name").attr("disabled",false);
				} else {
					$("input[name=hero_blog_00").val("");
					$("input[name=hero_blog_01").val("");
					$("input[name=hero_blog_02").val("");
					$("input[name=hero_blog_03").val("");
					$("input[name=hero_blog_04").val("");
					$("input[name=hero_blog_05").val("");
					$("input[name=hero_blog_05_name").val("");
					$("input[name=hero_blog_00").attr("disabled",true);
					$("input[name=hero_blog_01").attr("disabled",true);
					$("input[name=hero_blog_02").attr("disabled",true);
					$("input[name=hero_blog_03").attr("disabled",true);
					$("input[name=hero_blog_04").attr("disabled",true);
					$("input[name=hero_blog_05").attr("disabled",true);
					$("input[name=hero_blog_05_name").attr("disabled",true);
				}
			})
			
			//��α� �
			$("input[name=hero_qs_10]").on("click",function(){
				if($(this).val()=="�ִ�") {
					$(".blog_type").attr("disabled",false);
					$(".blog_type2").attr("disabled",false);
				} else {
					$("input[name=hero_qs_01]").val("");
					$("input[name=hero_qs_02]").prop("checked",false);
					$(".blog_type2").prop("checked",false);
					$(".blog_type").attr("disabled",true);
					$(".blog_type2").attr("disabled",true);
				}
			})
			$("input[name=hero_qs_07]").on("click",function(){
				if($(this).val()=="��") {
					$("input[name=hero_qs_08]").attr("disabled",false);
				} else {
					$("input[name=hero_qs_08]").val("");
					$("input[name=hero_qs_08]").attr("disabled",true);
				}
			})
			
			
			
			$(".wholeAgree_btn").click(function(){
				var partAgree_btn = $(".partAgree_btn");
				if($(this).prop("checked")==true){
					partAgree_btn.prop("checked",true);	
				}else{
					partAgree_btn.prop("checked",false);
				}
			});

			$(".partAgree_btn").click(function(){
				var thisVal = $(this).val();
				var offset;
				if(thisVal==1){
					var thisName = $(this).prop("name");
					switch (thisName){
						case 'hero_terms_01' : offset = $(".signup_term_title").eq(0).offset();break;
						case 'hero_terms_02' : offset = $(".signup_term_title").eq(2).offset();break;
						case 'hero_terms_03' : offset = $(".signup_term_title").eq(3).offset();break;
						case 'hero_terms_04' : offset = $(".signup_term_title").eq(4).offset();break;
						case 'hero_terms_05' : offset = $(".signup_term_title").eq(5).offset();break;
					}
					alert("�ʼ� ���� �����Դϴ�");
					if(typeof offset != 'undefined'){
						$('html, body').animate({scrollTop : offset.top}, 100);
					}
				}else if(thisVal==0){
					var thisName = $(this).prop("name");
					switch (thisName){
						case 'hero_terms_01' : offset = $(".signup_term_title").eq(2).offset();break;
						case 'hero_terms_02' : offset = $(".signup_term_title").eq(3).offset();break;
						case 'hero_terms_03' : offset = $(".signup_term_title").eq(4).offset();break;
						case 'hero_terms_04' : offset = $(".signup_term_title").eq(5).offset();break;
					}
					if(typeof offset != 'undefined'){
						$('html, body').animate({scrollTop : offset.top}, 100);
					}
				}

			});
        });

        function ch_id(obj){
			var id_alert_area = $(obj).next("span");
			if(trim($(obj).val())==''){
				id_alert_area.html("4~20�� ��밡��");
				return false;
			}else{
				//setCookie('cookie_hero_id', obj.value);
				hero_ajax('zip.php', 'ch_id_text', 'hero_id', 'id');
				return false;
			}
        }

        function ch_nick(obj){
			var nick_alert_area = $(obj).next("span");
			if(trim($(obj).val())==''){
				nick_alert_area.html("�г����� �Է��� �ּ���.");
				return false;
			}else{
				hero_ajax('zip.php', 'ch_nick_text', 'hero_nick_02', 'nick'); 
				return false;
			}
        }
        function showzip(){
            $('.layer_zip').show();
        }
        function inputzip(){
            $('.layer_zip').hide();
        }
        function emailChg(){
			if(form_next.email_select.value != "")  $('#hero_mail_02').attr('readonly', true);
			else $('#hero_mail_02').attr('readonly', false);
            form_next.hero_mail_02.value = form_next.email_select.value;
        }
        function fnLoad_01(a,b,c,d,e,f){
            document.getElementById("hero_address_01").value=a;
            document.getElementById("hero_address_02").value=b + ' ' + c + ' ' + d + e;
            $('.layer_zip').hide();
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

        function go_submit(form) {
       	
//##################################################################################################################################################//
            var id = form.hero_id;
            var id_action = document.getElementById("id_action");
            var pw_01 = form.hero_pw_01;
            var pw_02 = form.hero_pw_02;
			var irum = form.hero_name;
            var nick = form.hero_nick;
            var nick_action = document.getElementById("nick_action");
            var mail_01 = form.hero_mail_01;
            var mail_02 = form.hero_mail_02;
            var hp_01 = form.hero_hp_01;
            var hp_02 = form.hero_hp_02;
            var hp_03 = form.hero_hp_03;
            var address_01 = form.hero_address_01;
            var address_02 = form.hero_address_02;
            var address_03 = form.hero_address_03;

            var ch_year = document.getElementById("year").value;
			var ch_month = document.getElementById("month").value;
			var ch_date = document.getElementById("date").value;

            var terms_01 = form.hero_terms_01;
            var terms_02 = form.hero_terms_02;
            var terms_03 = form.hero_terms_03;
            var terms_04 = form.hero_terms_04;
			var terms_05 = form.hero_terms_05;

            var ch_term_01 = document.getElementById("ch_term_01").value;
            var ch_term_02 = document.getElementById("ch_term_02").value;
            var ch_term_03 = document.getElementById("ch_term_03").value;
            var ch_term_04 = document.getElementById("ch_term_04").value;
			var ch_term_05 = document.getElementById("ch_term_05").value;

			var jumin = form.hero_jumin;

//##################################################################################################################################################//
            id.style.border = '1px solid #e4e4e4';
			irum.style.border = '1px solid #e4e4e4';
            nick.style.border = '1px solid #e4e4e4';
            pw_01.style.border = '1px solid #e4e4e4';
            pw_02.style.border = '1px solid #e4e4e4';
            mail_01.style.border = '1px solid #e4e4e4';
            mail_02.style.border = '1px solid #e4e4e4';
          	hp_01.style.border = '1px solid #e4e4e4';
           	hp_02.style.border = '1px solid #e4e4e4';
           	hp_03.style.border = '1px solid #e4e4e4';
            address_01.style.border = '1px solid #e4e4e4';
            address_02.style.border = '1px solid #e4e4e4';
            address_03.style.border = '1px solid #e4e4e4';

//##################################################################################################################################################//
            if(terms_01[0].checked==false){
                var position = $(".signup_term_title").eq(0).offset();
	            alert("�̿����� �����ϼž� �մϴ�.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
            if(terms_02[0].checked==false){
            	var position = $(".signup_term_title").eq(2).offset();
                alert("�����ϴ� ���������׸� �� ��������� �����ϼž� �մϴ�.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
            if(terms_03[0].checked==false){
            	var position = $(".signup_term_title").eq(3).offset();
                alert("���������� ���� �� �̿� ������ �����ϼž� �մϴ�.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
            if(terms_04[0].checked==false){
            	var position = $(".signup_term_title").eq(4).offset();
                alert("���������� ���� �� �̿�Ⱓ�� �����ϼž� �մϴ�.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
			if(terms_05[0].checked==false){
            	var position = $(".signup_term_title").eq(5).offset();
                alert("�������� �����Ź���ǿ� �����ϼž� �մϴ�.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
            
            
//##################################################################################################################################################//
            if(trim(id.value)==''){
                alert("���̵� �Է����ּ���");id.style.border = '1px solid red';id.focus();
                return false;
            }
            if(id_action.value == "hero_down"){
                alert("���̵� Ȯ�����ּ���");id.focus();
                return false;
            }
//##################################################################################################################################################//
            if(trim(pw_01.value) == "" || trim(pw_02.value) == ""){
				var noText;
            	if(trim(pw_01.value)==''){
                	noText = pw_01;
                }else if(trim(pw_02.value)==''){
                	noText = pw_02;
                }

	            alert("��й�ȣ�� �Է��ϼ���");noText.style.border = '1px solid red';noText.focus();
    	        return false;
            }

            if(pw_01.value != pw_02.value){
                alert("��й�ȣ�� ���� �ʽ��ϴ�");pw_01.style.border = '1px solid red';pw_02.style.border = '1px solid red';pw_01.focus();
                return false;
            }
            
        	if (pw_01.value.length < 8) {
        		alert("��й�ȣ�� 8�ڸ� �̻� �Է����ּ���");
        		pw_01.style.border = '1px solid red';pw_01.focus();
        		return false;
        	}

        	if(!chTextType.isEnNumOther(pw_01.value)){
        		alert("��й�ȣ�� ����, ����, Ư�������� �������� �Է����ּ���");
        		pw_01.style.border = '1px solid red';pw_01.focus();
        	    return false;
        	}
            
//##################################################################################################################################################//
			if(trim(irum.value)==''){
                alert("�̸��� �Է����ּ���.");irum.style.border = '1px solid red';irum.focus();
                return false;
            }

            if(trim(nick.value)==''){
                alert("�г����� �Է����ּ���");nick.style.border = '1px solid red';nick.focus();
                return false;
            }

            if(nick_action.value == "hero_down"){
                alert("�г����� Ȯ�����ּ���");nick.focus();
                return false;
            } 
			
            if(ch_year=='<?=date("Y")?>'){
            	 alert("��������� �������ּ���"); $("#year").focus();
            	 return false;
            }
                    
//##################################################################################################################################################//
            if(trim(mail_01.value) == "" || trim(mail_02.value) == ""){
				var noText;
            	if(trim(mail_01.value)==''){
                	noText = hp_01;
                }else if(trim(mail_02.value)==''){
                	noText = hp_02;
                }
                alert("�̸����� �Է��ϼ���.");noText.style.border = '1px solid red';noText.focus();
                return false;
            }

//##################################################################################################################################################//
            if(trim(hp_01.value) == "" || trim(hp_02.value) == "" || trim(hp_03.value)==''){
				var noText;
            	if(trim(hp_01.value)==''){
                	noText = hp_01;
                }else if(trim(hp_02.value)==''){
                	noText = hp_02;
                }else{
                	noText = hp_03;
                }
                alert("�޴�����ȣ�� �Է��ϼ���.");noText.style.border = '1px solid red';mail_01;noText.focus();
                return false;
            }

            if(pw_01.value.indexOf(hp_02.value)>0 || pw_01.value.indexOf(hp_03.value)>0){
            	alert("��й�ȣ���� �޴��� ��ȣ�� ���Ե� �� �����ϴ�");
        		pw_01.style.border = '1px solid red';pw_01.focus();
        	    return false;
            }
//##################################################################################################################################################//
            if(address_01.value == ""){
                alert("�����ȣ�� �Է��ϼ���.");address_01.style.border = '1px solid red';address_01.focus();
                return false;
            }
            if(address_02.value == ""){
                alert("�ּҸ� �Է��ϼ���.");address_02.style.border = '1px solid red';address_02.focus();
                return false;
            }
            if(address_03.value == ""){
                alert("�������ּҸ� �Է��ϼ���.");address_03.style.border = '1px solid red';address_03.focus();
                return false;
            }
			
			if($("input[name=area]:checked").val() == "��Ÿ") {
				if(!$("input[name=area_etc_text]").val()) {
					alert("Ak Lover�� �˰Ե� ��� ��Ÿ������ �Է��� �ּ���.");
					$("input[name=area_etc_text]").css("border","1px solid red");
					$("input[name=area_etc_text]").focus();
					return false;
				}
			}

//##################################################################################################################################################//
			chAge.setDate(ch_year,ch_month,ch_date);
			var age = chAge.countUniversalAge();
			if(age<15){
				alert("�˼��մϴ�. �� 14�� �̸��� �����Ͻ� �� �����ϴ�.");
				location.href="/main/index.php";
				return false;
			}
			if(ch_month<10){
				ch_month = "0"+String(ch_month);
			}
			if(ch_date<10){
				ch_date = "0"+String(ch_date);
			}
			
//##################################################################################################################################################//
			if($('#hero_id').val() == $('#hero_user').val() || $('#hero_nick_02').val() == $('#hero_user').val()){
				alert("������ ��õ������ ��õ�� �� �����ϴ�.");
				return false;
			}
			
			jumin.value=ch_year+""+ch_month+""+ch_date;			




			//160701 ���Ʒ� �߰������Է� �̺�Ʈ (s)
			var hero_qs_09 = $('input[name="hero_qs_09"]:checked').val();
			var hero_qs_10 = $('input[name="hero_qs_10"]:checked').val();
			var hero_qs_01 = form.hero_qs_01.value;
			var hero_qs_02 = $('input[name="hero_qs_02"]:checked').val();
			var hero_qs_03 = $('input[name="hero_qs_03[]"]:checked').length;
			var hero_qs_04 = $('input[name="hero_qs_04"]:checked').val();
			var hero_qs_05 = $('input[name="hero_qs_05"]:checked').val();
			var hero_qs_06 = form.hero_qs_06.value;
			var hero_qs_07 = $('input[name="hero_qs_07"]:checked').val();
			var hero_qs_08 = form.hero_qs_08.value;
			var hero_qs_11 = $('input[name="hero_qs_11"]:checked').val();
			var hero_qs_12 = "";
			if(hero_qs_11 == "1��") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val());
				hero_qs_12 = form.hero_qs_12.value;
			} else if(hero_qs_11 == "2��") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val());
				hero_qs_12 = form.hero_qs_12.value;
			} else if(hero_qs_11 == "3��") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val()); 
				hero_qs_12 = form.hero_qs_12.value;
			} else if(hero_qs_11 == "4��") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val()+","+$("select[name=select_birth3]").val());
				hero_qs_12 = form.hero_qs_12.value;
			} else if(hero_qs_11 == "5��") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val()+","+$("select[name=select_birth3]").val()+","+$("select[name=select_birth4]").val());
				hero_qs_12 = form.hero_qs_12.value;
			}
			
			// ��� ���� �Է��ؾ� ����Ʈ ���� üũ
			if(hero_qs_10 == "�ִ�"){
				if(hero_qs_05 == "����"){
					if(hero_qs_07 == "��"){
						if(hero_qs_09 != "" && hero_qs_01 != "" && hero_qs_02 != "" && hero_qs_03 > 0 && hero_qs_04 != "" && hero_qs_06 != "" && hero_qs_08 != "" && hero_qs_11 != "" && hero_qs_12 != ""){
							form.question_null_yn.value = "Y";
						}
					}else if(hero_qs_07 == "��"){
						if(hero_qs_09 != "" && hero_qs_01 != "" && hero_qs_02 != "" && hero_qs_03 > 0 && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != "" && hero_qs_11 != "" && hero_qs_12 != ""){
							form.question_null_yn.value = "Y";
						}
					}
				}else if(hero_qs_05 == "����"){
					if(hero_qs_07 == "��"){
						if(hero_qs_09 != "" && hero_qs_01 != "" && hero_qs_02 != "" && hero_qs_03 > 0 && hero_qs_04 != "" && hero_qs_06 != "" && hero_qs_08 != ""){
							form.question_null_yn.value = "Y";
						}
					}else if(hero_qs_07 == "��"){
						if(hero_qs_09 != "" && hero_qs_01 != "" && hero_qs_02 != "" && hero_qs_03 > 0 && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != ""){
							form.question_null_yn.value = "Y";
						}
					}
				}
			}else if(hero_qs_10 == "����"){
				if(hero_qs_05 == "����"){
					if(hero_qs_07 == "��"){
						if(hero_qs_09 != "" && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != "" && hero_qs_08 != "" && hero_qs_11 != "" && hero_qs_12 != ""){
							form.question_null_yn.value = "Y";
						}
					}else if(hero_qs_07 == "��"){
						if(hero_qs_09 != "" && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != ""  && hero_qs_11 != "" && hero_qs_12 != ""){
							form.question_null_yn.value = "Y";
						}
					}
				}else if(hero_qs_05 == "����"){
					if(hero_qs_07 == "��"){
						if(hero_qs_09 != "" && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != "" && hero_qs_08 != ""){
							form.question_null_yn.value = "Y";
						}
					}else if(hero_qs_07 == "��"){
						if(hero_qs_09 != "" && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != ""){
							form.question_null_yn.value = "Y";
						}
					}
				}
				
			}
			//160701 ���Ʒ� �߰������Է� �̺�Ʈ (e)




            form.submit();
//##################################################################################################################################################//
            return true;
        }
    </script>
    