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

$right_list                             = mysql_fetch_assoc($right_res);

######################################################################################################################################################
$error = "INFOEDIT_02";
$member_sql = " select m.*, q.* ";
$member_sql .= " FROM member m left join ";
$member_sql .= " (SELECT hero_code, hero_qs_01, hero_qs_02, hero_qs_03, hero_qs_04, hero_qs_05, hero_qs_06, hero_qs_07, hero_qs_08 ,hero_qs_09, hero_qs_10, hero_qs_11, hero_qs_12 FROM member_question WHERE hero_pid = '3' and hero_code = '".$_SESSION['temp_code']."') q ";
$member_sql .= " ON m.hero_code = q.hero_code where m.hero_code='".$_SESSION['temp_code']."'";
//echo $member_sql;
$member_res = new_sql($member_sql,$error);
if((string)$member_res==$error){
	error_historyBack("");
	exit;
}

$member_list                             = mysql_fetch_assoc($member_res);

if($member_list["hero_qs_01"] || $member_list["hero_qs_02"] || $member_list["hero_qs_03"]) {
	$member_list["hero_qs_10"] = "�ִ�";
}

$hero_mail = explode('@', $member_list['hero_mail']);

$ch_facebook = "notEndrolled";
$ch_kakao = "notEndrolled";
$ch_naver = "notEndrolled";
$ch_facebook_onclick = "loginFB('infoedit');";
$ch_kakako_onclick = "loginKakao('infoedit');";
$ch_naver_onclick = "loginNaver('infoedit');";

if($member_list['hero_facebook']){
	$ch_facebook = "";
	$ch_facebook_class = "_grey";
	$ch_facebook_onclick = "";
}
if($member_list['hero_kakaoTalk']){
	$ch_kakao = "";
	$ch_kakao_class = "_grey";
	$ch_kakako_onclick = "";
	
}
if($member_list['hero_naver']){
	$ch_naver = "";
	$ch_naver_class = "_grey";
	$ch_naver_onclick = "";
}

// 160701 ���Ʒ� �߰��������� �̺�Ʈ (s)
$memberQuestion_sql = "SELECT hero_idx, hero_pid, hero_code, hero_qs_01, hero_qs_02, hero_qs_03, hero_qs_04, hero_qs_05, hero_qs_06, hero_qs_07, hero_qs_08, ";
$memberQuestion_sql .= "hero_qs_09, hero_qs_10, hero_qs_11, hero_qs_12, hero_qs_13, hero_qs_14, hero_qs_15, hero_qs_16, hero_qs_17, hero_qs_18, hero_qs_19, hero_qs_20, ";
$memberQuestion_sql .= "hero_qs_21, hero_qs_22, hero_qs_23, hero_qs_24, hero_qs_25, hero_qs_26, hero_qs_27, hero_qs_28, hero_qs_29, hero_qs_30, hero_today, "; 
$memberQuestion_sql .= "left(hero_modi_today,4) as hero_modi_today, left(hero_give_point_today,4) as hero_give_point_today ";
$memberQuestion_sql .= "FROM member_question WHERE hero_code='".$_SESSION['temp_code']."' and hero_pid='3'";
$memberQuestion_res = new_sql($memberQuestion_sql,"on");
$memberQuestion_list = mysql_fetch_assoc($memberQuestion_res);

$today = date("Y");

$alertScriptAll = "<script>alert('�߰������� ��� �Է��Ͻø� 30����Ʈ�� �帳�ϴ�.');</script>";
$alertScriptModi = "<script>alert('�߰������� �����Ͻø� 30����Ʈ�� �帳�ϴ�.');</script>";
if($memberQuestion_list['hero_code'] == ""){ //�߰������ִ��� Ȯ��
	echo $alertScriptAll;
	$question_point_yn ="Y";
}else if($memberQuestion_list['hero_give_point_today'] != $today && ($memberQuestion_list['hero_give_point_today'] == "" || $memberQuestion_list['hero_give_point_today'] == "0000")){ //1�� �ֱ� üũ
	//if($memberQuestion_list['hero_modi_today'] != $today){
		echo $alertScriptModi;
		$question_point_yn ="Y";
	//}
}else{
	if($memberQuestion_list['hero_give_point_today'] != $today){ //�ǿ븷������ �ѹ� �� ��¥ üũ
		if($memberQuestion_list['hero_qs_10'] == "�ִ�"){
			if($memberQuestion_list['hero_qs_01'] == "" || $memberQuestion_list['hero_qs_02'] == "" || $memberQuestion_list['hero_qs_03'] == ""){
				echo $alertScriptAll;
				$question_point_yn = "Y";
			}
		}else if($memberQuestion_list['hero_qs_10'] == ""){
			echo $alertScriptAll;
			$question_point_yn = "Y";
			
		}else if($memberQuestion_list['hero_qs_05'] == "����"){
			if($memberQuestion_list['hero_qs_11'] == "" || $memberQuestion_list['hero_qs_12'] == ""){
				echo $alertScriptAll;
				$question_point_yn = "Y";
			}
		}else if($memberQuestion_list['hero_qs_05'] == ""){
			echo $alertScriptAll;
			$question_point_yn = "Y";
			
		}else if($memberQuestion_list['hero_qs_07'] == "��"){
			if($memberQuestion_list['hero_qs_08'] == ""){
				echo $alertScriptAll;
				$question_point_yn = "Y";
			}
		}else if($memberQuestion_list['hero_qs_07'] == ""){
			echo $alertScriptAll;
			$question_point_yn = "Y";
		}else if($memberQuestion_list['hero_qs_04'] == "" || $memberQuestion_list['hero_qs_06'] == "" || $memberQuestion_list['hero_qs_09'] == ""){
			echo $alertScriptAll;
			$question_point_yn = "Y";
		}
	}
}
// 160701 ���Ʒ� �߰��������� �̺�Ʈ (e)

?>
    <div class="contents">
    	
    	<form name="form_next" action="<?=PATH_HOME_HTTPS?>?board=update" enctype="multipart/form-data" method="post" onsubmit="return go_submit(this);">
            <input type="hidden" name="hero_idx" value="<?=$member_list['hero_idx']?>">
            <input type="hidden" name="hero_today_plus" value="<?=Ymdhis?>">
            <input type="hidden" name="hero_login_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
            <!-- 160701 ���Ʒ� �߰��������� �̺�Ʈ(s) -->
			<input type="hidden" name="question_null_yn" value="N">
			<input type="hidden" name="question_point_yn" value="<?=$question_point_yn?>">
			<!-- 160701 ���Ʒ� �߰��������� �̺�Ʈ(e) -->
			

			<div id="infoEditSns">
							<div style="padding-top: 16px;">�α��� �����ϱ�</div>
							<img src="/image2/etc/line.png"/>
							<div class="info_sns <?=$ch_facebook?>" onclick="<?=$ch_facebook_onclick?>"><img src="/image2/etc/sns01<?=$ch_facebook_class?>.jpg" alt="���̽���" border="0" style="vertical-align:middle;">���̽���</div>
							<div class="info_sns <?=$ch_kakao?>" onclick="<?=$ch_kakako_onclick?>"><img src="/image2/etc/sns02<?=$ch_kakao_class?>.jpg" alt="īī����" border="0" style="vertical-align:middle;" >īī����</div>
							<div class="info_sns <?=$ch_naver?>" onclick="<?=$ch_naver_onclick?>;"><img src="/image2/etc/sns03<?=$ch_naver_class?>.jpg" alt="���̹�" border="0" style="vertical-align:middle;">���̹�</div>
						</div>
			
			<p class="member_alert"><span style="color:#f68428">*</span>�� �ʼ� �Է� �׸��Դϴ�!!!</p>
			
            <table class="member">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr class="first">
                    <th><span>*</span> ���̵�</th>
                    <td><span class="c_brown bold"><?=$member_list['hero_id']?></span></td>
                </tr>
                <tr>
                    <th><span>*</span> �̸�</th>
                    <td><span class="c_brown bold"><?=$member_list['hero_name']?></span></td>
                </tr>
                <tr>
                    <th><span>*</span> �г���</th>
                    <td><span class="c_brown bold"><?=$member_list['hero_nick']?></span> <span class="notification">* �г��� ����� �����ڿ��� 1:1���Ƿ� ��û�ϼ���</span></td>
                </tr>
                <tr>
                    <th><span>*</span> �������</th>
                    <td><span class="c_brown bold"><?=substr($member_list['hero_jumin'], '0', '4');?>�� <?=substr($member_list['hero_jumin'], '4', '2');?>�� <?=substr($member_list['hero_jumin'], '6', '2');?>��</span><!-- (�� <span class="c_brown bold">17</span>��)--></td>
                </tr>
                <tr>
                    <th><span>*</span> �̸���</th>
                    <td>
                        <input type="text" name="hero_mail_01" value="<?=$hero_mail['0'];?>" style="ime-mode:disabled;"/> @<br/>
                        <input type="text" name="hero_mail_02" value="<?=$hero_mail['1'];?>" style="ime-mode:disabled;"/>
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
                         <p style="height:25px;">�̸��� ����&nbsp;&nbsp;&nbsp;&nbsp;
                         	
							<input type="radio" name="hero_chk_email" value='1' <?php echo ($member_list['hero_chk_email']==1 || $member_list['hero_chk_email']==2)? "checked='checked'" : "";?> style='width:13px;' checked="checked">����
							<input type="radio" name="hero_chk_email" value='0' <?php echo ($member_list['hero_chk_email']==0)? "checked='checked'" : "";?> style='width:13px;'>���Ǿ���
						 </p>
                    </td>
                </tr>
    			
    			<?php
				$next = str_ireplace('-', '', $member_list['hero_hp']);
				$next = str_ireplace('~', '', $next);
				$next = str_ireplace('_', '', $next);
				$next = str_ireplace('/', '', $next);
				//substr($site_list['hero_hp'], '0', '3');
				?> 
				
				<tr>
                    <th><span>*</span> �ڵ���</th>
                    <td>
                        <input type="text" name="hero_hp_01" id="hero_hp_01" value="<?=substr($next, '0', '3');?>" onKeyUp="if(this.value.length >= 3)hero_hp_02.focus();" maxlength="3" style="ime-mode:disabled;" class="short"/>
                        <input type="text" name="hero_hp_02" id="hero_hp_02" value="<?=substr($next, '3', '4');?>" onKeyUp="if(this.value.length >= 4)hero_hp_03.focus();" maxlength="4" style="ime-mode:disabled;" class="short"/>
                        <input type="text" name="hero_hp_03" id="hero_hp_03" value="<?=substr($next, '7', '4');?>" maxlength="4" style="ime-mode:disabled;" class="short"/>
                        <p style="height:25px;">
							<span>SMS ����&nbsp;&nbsp;&nbsp;&nbsp;</span>
							<input type="radio" name="hero_chk_phone" value='1' <?php echo ($member_list['hero_chk_phone']==1)? "checked='checked'" : "";?> style='width:13px;' checked="checked">����
							<input type="radio" name="hero_chk_phone" value='0' <?php echo ($member_list['hero_chk_phone']==0)? "checked='checked'" : "";?> style='width:13px;'>���Ǿ���<br>
						</p>
                    </td>
                </tr>

                <tr>
                    <th><span>*</span> �ּ�</th>
                    <td>
                        <input type="text" name="hero_address_01" id="hero_address_01" value="<?=$member_list['hero_address_01']?>" class="short"/>
                        <a href="javascript:showzip()"><img src="../image/member/btn_zipcode.gif" alt="�����ȣã��" /></a><br />
                        <input type="text" name="hero_address_02" id="hero_address_02" value="<?=$member_list['hero_address_02']?>" class="w390" style="margin-top:1px;"/><br />
                        <input type="text" name="hero_address_03" id="hero_address_03" value="<?=$member_list['hero_address_03']?>" class="w390" style="margin-top:1px;" />
                    </td>
                </tr>
  
                <tr>
                    <th><span>*</span> AK Lover��<br/>�˰Ե� ��δ�?</th>
                    <td>
                    	<p>
                        <input type="radio" name="area" value="�Ź�" <?=$member_list["area"]=="�Ź�" ? "checked":"";?>/> &nbsp;�Ź� <input type="radio" name="area" value="����" <?=$member_list["area"]=="����" ? "checked":"";?>/> &nbsp;���� <input type="radio" name="area" value="��α�" <?=$member_list["area"]=="��α�" ? "checked":"";?>/>&nbsp; ��α� 
                        <input type="radio" name="area" value="����" <?=$member_list["area"]=="����" ? "checked":"";?>/> &nbsp;���� <input type="radio" name="area" value="����" <?=$member_list["area"]=="����" ? "checked":"";?>/> &nbsp;���� <input type="radio" name="area" value="����" <?=$member_list["area"]=="����" ? "checked":"";?>/> &nbsp;���� 
                        <input type="radio" name="area" value="��Ÿ" <?=$member_list["area"]=="��Ÿ" ? "checked":"";?>/> &nbsp;��Ÿ 
                        </p>
                        <p>��Ÿ <input type="text" name="area_etc_text" class="w390" maxlength="50" value="<?=$member_list["area_etc_text"];?>"/></p>
                    </td>
                </tr>
                </table>
                <div style="margin-top:30px;"><img src="/image2/intro/aklover/updateInfoEvent.png" /></div>
                <table class="member">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                 <tr>
                    <th>����URL</th>
                    <td class='notneed'>
                    	<p>
                        <input type="radio" name="hero_qs_09" value="�ִ�" <?=$member_list["hero_qs_09"]=="�ִ�" ? "checked":"";?>/>�ִ� 
			            <input type="radio" name="hero_qs_09" value="����" <?=$member_list["hero_qs_09"]=="����" ? "checked":"";?>/>����
                        </p>
                        <table class="tb_blog">
                        <col width="130" />
						<col width="*" />
                        	<tr style="border:none;">
                        		<td style="border:none; height:30px;">��α� URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_00" class="w390" value="<?=$member_list["hero_blog_00"];?>"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">���̽��� URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_01" class="w390" value="<?=$member_list["hero_blog_01"];?>"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">Ʈ���� URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_02" class="w390" value="<?=$member_list["hero_blog_02"];?>"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">�ν�Ÿ�׷� URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_04" class="w390" value="<?=$member_list["hero_blog_04"];?>"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">īī�����丮 URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_03" class="w390" value="<?=$member_list["hero_blog_03"];?>"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">�׿� SNS &nbsp;&nbsp; SNS �̸�</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_05_name" class="w390" value="<?=$member_list["hero_blog_05_name"];?>"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SNS URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_05" class="w390" value="<?=$member_list["hero_blog_05"];?>"/></td>
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
                    	<p>
                        <input type="radio" name="hero_qs_10" value="�ִ�" <?=$member_list["hero_qs_10"]=="�ִ�" ? "checked":"";?>/>�ִ� 
			            <input type="radio" name="hero_qs_10" value="����" <?=$member_list["hero_qs_10"]=="����" ? "checked":"";?>/>����
                        </p>
                    	<span class="tname">�����Ͽ� �������� ��� �� �� ���ε� �Ͻó���?</span>
                        <br/>
                        <input type="text" name="hero_qs_01" style="width:200px;" class="blog_type"  maxlength="30" value="<?=$member_list["hero_qs_01"];?>"/><br/>
                        
                    	<span class="tname">� ���� ��α��� ��� �� �湮�ڴ� �� ���ΰ���?</span>
			                        <br>
			                        <input type="radio" name="hero_qs_02" value="200��" class="blog blog_type" <?=$member_list["hero_qs_02"]=="200��" ? "checked":"";?>/>200�� ����
			                        <input type="radio" name="hero_qs_02" value="200~800��" class="blog blog_type" <?=$member_list["hero_qs_02"]=="200~800��" ? "checked":"";?>/>200~800��
			                        <input type="radio" name="hero_qs_02" value="801~1,500��" class="blog blog_type" <?=$member_list["hero_qs_02"]=="801~1,500��" ? "checked":"";?>/>801~1,500��
			                        <br>
			                        <input type="radio" name="hero_qs_02" value="1,501~3,000��" class="blog blog_type" <?=$member_list["hero_qs_02"]=="1,501~3,000��" ? "checked":"";?>/>1,501~3,000��
			                        <input type="radio" name="hero_qs_02" value="3,001~4,000��" class="blog blog_type" <?=$member_list["hero_qs_02"]=="3,001~4,000��" ? "checked":"";?>/>3,001~4,000��
			                        <input type="radio" name="hero_qs_02" value="4,001~5,000��" class="blog blog_type" <?=$member_list["hero_qs_02"]=="4,001~5,000��" ? "checked":"";?>/>4,001~5,000��
			                        <input type="radio" name="hero_qs_02" value="5,001~10,000��" class="blog blog_type" <?=$member_list["hero_qs_02"]=="5,001~10,000��" ? "checked":"";?>/>5,001~10,000��
			                        <input type="radio" name="hero_qs_02" value="10,000�� �̻�" class="blog blog_type" <?=$member_list["hero_qs_02"]=="10,000�� �̻�" ? "checked":"";?>/>10,000�� �̻�
			                        <br>
			                        <span class="tname">��α� Ÿ��(�� �ߺ� ���� ����)</span>
			                        <br>
                                    <? 
										$hero_qs_03 = explode(",",$member_list["hero_qs_03"]);
									?>
			                        <input type="checkbox" name="hero_qs_03[]" value="�м�" class="blog blog_type2"/>�м�
			                        <input type="checkbox" name="hero_qs_03[]" value="��Ƽ" class="blog blog_type2"/>��Ƽ
			                        <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2"/>���� 
			                        <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2"/>���� 
			                        <input type="checkbox" name="hero_qs_03[]" value="�ϻ�" class="blog blog_type2"/>�ϻ�
			                        <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2"/>����
                                    <input type="checkbox" name="hero_qs_03[]" value="�ֿ�" class="blog blog_type2"/>�ֿ�
                                    <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2"/>����
                                    <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2"/>����
                                    <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2"/>����
			                        </br>
			                        <input type="checkbox" name="hero_qs_03[]" value="���" class="blog blog_type2"/>���
                                    <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2"/>����
                                    <input type="checkbox" name="hero_qs_03[]" value="�ǰ�" class="blog blog_type2"/>�ǰ�
                                    <input type="checkbox" name="hero_qs_03[]" value="IT" class="blog blog_type2"/>IT
                                    <input type="checkbox" name="hero_qs_03[]" value="����" class="blog blog_type2"/>����
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
                    <td><input type="radio" name="hero_qs_04" value="��ȥ" <?=$member_list["hero_qs_04"]=="��ȥ" ? "checked":"";?>/>��ȥ 
			            <input type="radio" name="hero_qs_04" value="��ȥ" <?=$member_list["hero_qs_04"]=="��ȥ" ? "checked":"";?>/>��ȥ</td>
                </tr>
                </table>
                <table class="member" style="margin-top:10px;">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr>
                	<th>�ڳ�� �� ����</th>
                    <td>
                    	<input type="radio" name="hero_qs_05" value="����" <?=$member_list["hero_qs_05"]=="����" ? "checked":"";?>/> ����
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
                   	 	<div id="hero_qs_11_div" <?=$member_list["hero_qs_05"]=="����" ? "style='display:none;'":"";?>>
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
                    <td><input type="text" name="hero_qs_06" class="w390" maxlength="100" value="<?=$member_list["hero_qs_06"];?>"/></td>
                </tr>
                </table>
                <table class="member" style="margin-top:10px;">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr>
                	<th>�ְ� �� Ȱ���ϴ�<br />��������</th>
                    <td><input type="radio" name="hero_qs_07" value="��" <?=$member_list["hero_qs_07"]=="��" ? "checked":"";?> />�� <input type="radio" name="hero_qs_07" value="��" <?=$member_list["hero_qs_07"]=="��" ? "checked":"";?>/>��<br/>
                    	<input type="text"  name="hero_qs_08" class="w390" maxlength="100" value="<?=$member_list["hero_qs_08"];?>"/>
                    </td>
                </tr>

            </table>
 
            
            <div class="btngroup tc" >
                <input type="image" src="../image/member/btn_infoedit.gif" alt="ȸ����������" />
            </div>
            
        </form>
       
        </div>
        
        <div class="layer_zip" style="top:700px;">   
            <dl>
            <form name="login_form" action="<?=PATH_HOME?>?board=result" onsubmit="return false;">
                <dt><img src="../image/member/zip1.gif" alt="�����ȣ ã��" /></dt>
                <dd>
                <input id="addr" type="text" class="addr" /><input type="image" src="../image/member/btn_findzip.gif" alt="�ּ�ã��" onclick="hero_ajax('zip.php', 'view_list', 'addr', 'zip'); return false;"/>
                </dd>
                <dd class="list">
                    <div id="view_list"></div>
                </dd>
                <dd class="tc"><a href="javascript:inputzip();"><img src="../image/member/btn_cancel.gif" alt="�Է�" /></a></dd>
            </form>
            </dl>
    	</div>
    	<form id="infoEditForm" >
        	<input type="hidden" name="snsId">
	       	<input type="hidden" name="snsType">
        </form>
    </div>

        <!-- sns -->
<script type="text/javascript" src="/js/jquery.cookie.js" ></script>
<script type="text/javascript" charset="utf-8" src="https://static.nid.naver.com/js/naverLogin.js" ></script>
<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<script type="text/javascript" src="/js/snsInit.js"></script>
    
     <script type="text/javascript">
	 		<? if($member_list["area"]!="��Ÿ") {?>
				$("input[name=area_etc_text]").val("");
				$("input[name=area_etc_text]").attr("disabled",true);
			<? } ?>
			
			<? if($member_list["hero_qs_09"]!="�ִ�") {
					if($member_list["hero_qs_09"]!=""){?>
						$("input[name=c]").val("");
						$("input[name=hero_blog_01]").val("");
						$("input[name=hero_blog_02]").val("");
						$("input[name=hero_blog_03]").val("");
						$("input[name=hero_blog_04]").val("");
						$("input[name=hero_blog_05]").val("");
						$("input[name=hero_blog_05_name]").val("");
					<? }?>
			$("input[name=hero_blog_00]").attr("disabled",true);
			$("input[name=hero_blog_01]").attr("disabled",true);
			$("input[name=hero_blog_02]").attr("disabled",true);
			$("input[name=hero_blog_03]").attr("disabled",true);
			$("input[name=hero_blog_04]").attr("disabled",true);
			$("input[name=hero_blog_05]").attr("disabled",true);
			$("input[name=hero_blog_05_name]").attr("disabled",true);
		<? } ?>
			
			<? if($member_list["hero_qs_10"]!="�ִ�") {?>
				$("input[name=hero_qs_01]").val("");
				$("input[name=hero_qs_02]").prop("checked",false);
				$(".blog_type2").prop("checked",false);
				$(".blog_type").attr("disabled",true);
				$(".blog_type2").attr("disabled",true);
			<? } ?>
			
			<? if($member_list["hero_qs_07"]!="��") {?>
				$("input[name=hero_qs_08]").val("");
				$("input[name=hero_qs_08]").attr("disabled",true);
			<? } ?>
	 	
	 		
			$("input[name=area]").on("click",function(){
				if($(this).val()=="��Ÿ") {
					$("input[name=area_etc_text]").attr("disabled",false);
				} else {
					$("input[name=area_etc_text]").val("");
					$("input[name=area_etc_text]").attr("disabled",true);
				}
			})
			
			//��α��ִ�/����
			$("input[name=hero_qs_09]").on("click",function(){
				if($(this).val()=="�ִ�") {
					$("input[name=hero_blog_00]").attr("disabled",false);
					$("input[name=hero_blog_01]").attr("disabled",false);
					$("input[name=hero_blog_02]").attr("disabled",false);
					$("input[name=hero_blog_03]").attr("disabled",false);
					$("input[name=hero_blog_04]").attr("disabled",false);
					$("input[name=hero_blog_05]").attr("disabled",false);
					$("input[name=hero_blog_05_name]").attr("disabled",false);
				} else {
					$("input[name=hero_blog_00]").val("");
					$("input[name=hero_blog_01]").val("");
					$("input[name=hero_blog_02]").val("");
					$("input[name=hero_blog_03]").val("");
					$("input[name=hero_blog_04]").val("");
					$("input[name=hero_blog_05]").val("");
					$("input[name=hero_blog_05_name]").val("");
					$("input[name=hero_blog_00]").attr("disabled",true);
					$("input[name=hero_blog_01]").attr("disabled",true);
					$("input[name=hero_blog_02]").attr("disabled",true);
					$("input[name=hero_blog_03]").attr("disabled",true);
					$("input[name=hero_blog_04]").attr("disabled",true);
					$("input[name=hero_blog_05]").attr("disabled",true);
					$("input[name=hero_blog_05_name]").attr("disabled",true);
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
	 
	 	$(".blog_type2").each(function(i){
			<? for($c=0; $c<count($hero_qs_03); $c++) {?>
				if($(this).val() == "<?=$hero_qs_03[$c];?>") {
					$(this).prop("checked",true);
				}
			<? } ?>
		})

    	function showzip(){
            $('.layer_zip').show();
        }
        function inputzip(){
            $('.layer_zip').hide();
        }
        function emailChg(){
            form_next.hero_mail_02.value = form_next.email_select.value;
        }
        function fnLoad_01(a,b,c,d,e,f){
            document.getElementById("hero_address_01").value=a;
            document.getElementById("hero_address_02").value=b + ' ' + c + d + e;
            $('.layer_zip').hide();
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

        function go_submit(form) {
//##################################################################################################################################################//
            
            var mail_01 = form.hero_mail_01;
            var mail_02 = form.hero_mail_02;
            var hp_01 = form.hero_hp_01;
            var hp_02 = form.hero_hp_02;
            var hp_03 = form.hero_hp_03;
            var address_01 = form.hero_address_01;
            var address_02 = form.hero_address_02;
            var address_03 = form.hero_address_03;
            var blog_00 = form.hero_blog_00;

//##################################################################################################################################################//
            //pw_01.style.border = '1px solid #e4e4e4';
            //pw_02.style.border = '1px solid #e4e4e4';
            mail_01.style.border = '1px solid #e4e4e4';
            mail_02.style.border = '1px solid #e4e4e4';
            hp_01.style.border = '1px solid #e4e4e4';
            hp_02.style.border = '1px solid #e4e4e4';
            hp_03.style.border = '1px solid #e4e4e4';
            address_01.style.border = '1px solid #e4e4e4';
            address_02.style.border = '1px solid #e4e4e4';
            address_03.style.border = '1px solid #e4e4e4';
            
//##################################################################################################################################################//
            if(mail_01.value == ""){
                alert("�̸����� �Է��ϼ���.");mail_01.style.border = '1px solid red';mail_01.focus();
                return false;
            }
            if(mail_02.value == ""){
                alert("�̸����� �����ϼ���.");mail_02.style.border = '1px solid red';mail_02.focus();
                return false;
            }
//##################################################################################################################################################//
            if(hp_01.value == ""){
                alert("�ڵ�����ȣ�� �Է��ϼ���.");hp_01.style.border = '1px solid red';hp_01.focus();
                return false;
            }
            if(hp_02.value == ""){
                alert("�ڵ�����ȣ�� �Է��ϼ���.");hp_02.style.border = '1px solid red';hp_02.focus();
                return false;
            }
            if(hp_03.value == ""){
                alert("�ڵ�����ȣ�� �Է��ϼ���.");hp_03.style.border = '1px solid red';hp_03.focus();
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
            
//##################################################################################################################################################//
			if($("input[name=area]:checked").val() == "��Ÿ") {
				if(!$("input[name=area_etc_text]").val()) {
					alert("Ak Lover�� �˰Ե� ��� ��Ÿ������ �Է��� �ּ���.");
					$("input[name=area_etc_text]").css("border","1px solid red");
					$("input[name=area_etc_text]").focus();
					return false;
				}
			}
//##################################################################################################################################################//
			//160701 ���Ʒ� �߰������Է� �̺�Ʈ (s)
			/*var hero_qs_09 = $('input[type=radio][name=hero_qs_09]:checked').val();
			
			
			var hero_qs_10 = $('input[type=radio][name=hero_qs_10]:checked').val();
			var hero_qs_01 = form.hero_qs_01.value;
			var hero_qs_02 = $('input[name=hero_qs_02]:checked').val();
			var hero_qs_03 = $('input[type=checkbox][name=hero_qs_03[]]:checked').length;
			var hero_qs_04 = $('input[type=radio][name=hero_qs_04]:checked').val();
			var hero_qs_05 = $('input[type=radio][name=hero_qs_05]:checked').val();
			var hero_qs_06 = form.hero_qs_06.value;
			var hero_qs_07 = $('input[type=radio][name=hero_qs_07]:checked').val();
			var hero_qs_08 = form.hero_qs_08.value;
			var hero_qs_11 = $('input[name=hero_qs_11]:checked').val();*/
			var hero_qs_09 = $('input[name="hero_qs_09"]:checked').val();
			alert(hero_qs_09);
			var hero_qs_10 = form.hero_qs_10.value;
			var hero_qs_01 = form.hero_qs_01.value;
			var hero_qs_02 = $('input[name="hero_qs_02"]:checked').val();
			var hero_qs_03 = $('input[name="hero_qs_03[]"]:checked').length;
			var hero_qs_04 = $('input[name="hero_qs_04"]:checked').val();
			var hero_qs_05 = $('input[name="hero_qs_05"]:checked').val();
			var hero_qs_06 = form.hero_qs_06.value;
			var hero_qs_07 = $('input[name="hero_qs_07"]:checked').val();
			var hero_qs_08 = form.hero_qs_08.value;
			var hero_qs_11 = $('input[name="hero_qs_11"]:checked').val();

			if(hero_qs_11 == "1��") $('#hero_qs_12').val($("select[name=select_birth0]").val());
			else if(hero_qs_11 == "2��") $('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val());
			else if(hero_qs_11 == "3��") $('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val());
			else if(hero_qs_11 == "4��") $('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val()+","+$("select[name=select_birth3]").val());
			else if(hero_qs_11 == "5��") $('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val()+","+$("select[name=select_birth3]").val()+","+$("select[name=select_birth4]").val());
			var hero_qs_12 = $('#hero_qs_12').val();
			
			// ��� ���� �Է��ؾ� ����Ʈ ���� 
			if(hero_qs_10 == "�ִ�"){
				if(hero_qs_05 == "����")
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

//##################################################################################################################################################//
            form.submit();
//##################################################################################################################################################//
            return true;
        }
        
    </script>
				
    