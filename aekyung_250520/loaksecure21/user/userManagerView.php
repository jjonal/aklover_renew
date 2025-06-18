<?
if(!defined('_HEROBOARD_'))exit;

$hero_code = $_GET["hero_code"];

$member_sql  = " SELECT m.hero_code, hero_id, hero_name, hero_nick, hero_level ";
$member_sql .= " , hero_hp, hero_mail, hero_chk_phone, hero_chk_email, hero_address_01 ";
$member_sql .= " , hero_info_ci, hero_facebook, hero_kakaoTalk, hero_naver, hero_google ";
$member_sql .= " , hero_address_02, hero_address_03, area, area_etc_text, hero_user_type ";
$member_sql .= " , hero_user, hero_oldday , hero_blog_00, hero_memo ";
$member_sql .= " , hero_memo_01, hero_memo_01_image, hero_blog_04, hero_insta_cnt, hero_insta_grade  ";
$member_sql .= " , hero_insta_image_grade, hero_blog_03, hero_youtube_cnt, hero_youtube_grade, hero_youtube_view ";
$member_sql .= " , hero_blog_05, hero_blog_06, hero_blog_07, hero_blog_08, hero_sns_update_date, m.hero_today, hero_jumin ";
$member_sql .= " , hero_naver_influencer, hero_naver_influencer_name, hero_naver_influencer_category ";
$member_sql .= " , q.hero_qs_01, q.hero_qs_02, q.hero_qs_03, q.hero_qs_04, q.hero_qs_05";
$member_sql .= " , q.hero_qs_06, q.hero_qs_07, q.hero_qs_08 ";
$member_sql .= " , q.hero_qs_18, q.hero_qs_19, q.hero_qs_20, q.hero_qs_21, q.hero_qs_22, q.hero_qs_23 ";
$member_sql .= " , (SELECT ifnull(sum(hero_point),0) FROM point WHERE hero_code = m.hero_code) as hero_point ";
$member_sql .= " , (SELECT ifnull(sum(hero_order_point),0) FROM order_main WHERE hero_code = m.hero_code AND hero_process!='".$_PROCESS_CANCEL."') hero_order_point ";
$member_sql .= " , (date_format(now(),'%Y') - substr(hero_jumin,1,4) + 1) as hero_age ";
$member_sql .= " FROM member m ";
$member_sql .= " LEFT JOIN member_question q ON m.hero_code = q.hero_code AND q.hero_pid = 4 ";
$member_sql .= " WHERE m.hero_use = 0 AND m.hero_code = '".$hero_code."' ";

$member_res = sql($member_sql,"on");
$view = mysql_fetch_assoc($member_res);

$pw_init_sql  = " SELECT hero_today FROM member_pw_initialize WHERE hero_code = '".$hero_code."' ORDER BY hero_today DESC LIMIT 1";
$pw_init_res = sql($pw_init_sql,"on");
$pw_init = mysql_fetch_assoc($pw_init_res);


$hero_hp = explode("-",$view["hero_hp"]);
$hero_mail = explode("@",$view["hero_mail"]);

$hero_naver_blog = str_replace("https://blog.naver.com/", "", $view["hero_blog_00"]);
$hero_naver_blog = str_replace("http://blog.naver.com/", "", $hero_naver_blog);
$hero_naver_blog = str_replace("https://m.blog.naver.com/", "", $hero_naver_blog);
$hero_naver_blog = str_replace("http://m.blog.naver.com/", "", $hero_naver_blog);
$hero_naver_blog = str_replace("blog.naver.com/", "", $hero_naver_blog);

$hero_instagram = str_replace("https://www.instagram.com/", "", $view["hero_blog_04"]);
$hero_instagram = str_replace("http://www.instagram.com/", "", $hero_instagram);
$hero_instagram = str_replace("https://instagram.com/", "", $hero_instagram);
$hero_instagram = str_replace("http://instagram.com/", "", $hero_instagram);
$hero_instagram = str_replace("instagram.com/", "", $hero_instagram);


$hero_naver_influencer = str_replace("https://in.naver.com/", "", $view["hero_naver_influencer"]);

$hero_qs_18 = "";
if($view["hero_qs_18"] == "Y") {
    $hero_qs_18 = "����";
} else if($view["hero_qs_18"] == "N") {
    $hero_qs_18 = "����";
}

$hero_qs_19 = "";
if($view["hero_qs_19"] == "Y") {
    $hero_qs_19 = "����";
} else if($view["hero_qs_19"] == "N") {
    $hero_qs_19 = "����";
}

$hero_qs_20 = "";
if($view["hero_qs_20"] == "Y") {
    $hero_qs_20 = "����";
} else if($view["hero_qs_20"] == "N") {
    $hero_qs_20 = "����";
}

$hero_qs_21 = "";
if($view["hero_qs_21"] == "Y") {
    $hero_qs_21 = "����";
} else if($view["hero_qs_21"] == "N") {
    $hero_qs_21 = "����";
}

$handphone = "";
if(isset($view["hero_info_ci"]) && !empty($view["hero_info_ci"])) {
    $handphone = "�޴��� ";
}

$facebook = "";
if(isset($view["hero_facebook"]) && !empty($view["hero_facebook"])) {
    $facebook = "���̽��� ";
}

$kakaoTalk = "";
if(isset($view["hero_kakaoTalk"]) && !empty($view["hero_kakaoTalk"])) {
    $kakaoTalk = "īī���� ";
}

$naver = "";
if(isset($view["hero_naver"]) && !empty($view["hero_naver"])) {
    $naver = "���̹� ";
}

$google = "";
if(isset($view["hero_google"]) && !empty($view["hero_google"])) {
    $google = "���� ";
}
?>
<form name="searchForm" id="searchForm" method="GET">
<? 
unset($_GET["hero_code"]);
unset($_GET["view"]);
foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>
<div class="btnGroupFunction">
	<div class="leftWrap">
		<p class="tit_section">�⺻����</p>
	</div>
	<div class="rightWrap">
		<a href="javascript:;" onClick="fnPopPoint()" class="btnFunc">����Ʈ Ȯ��</a>
		<a href="javascript:;" onClick="fnPopWrite()" class="btnFunc">�ۼ��� Ȯ��</a>
		<a href="javascript:;" onClick="fnPopSuperpass()" class="btnFunc">�����н� Ȯ��/�ο�</a>
		<a href="javascript:;" onClick="fnPopPenalty()" class="btnFunc">�г�Ƽ ����</a>
		<a href="javascript:;" onClick="fnWithdrawal('<?=$view["hero_nick"]?>')" class="btnFormCancel">ȸ��Ż��</a>
	</div>
</div>

<form name="viewForm" id="viewForm">
<input type="hidden" name="mode" />
<input type="hidden" name="hero_code" value="<?=$view["hero_code"]?>"/>
<table class="t_view">
<colgroup>
	<col width="150px">
	<col width=*>
	<col width="150px">
	<col width=*>
</colgroup>
<tbody>
	<tr>
		<th>���̵�</th>
		<td><?=$view["hero_id"]?> (LV : <?=$view["hero_level"]?>)</td>
		<th>�г���</th>
		<td><?=$view["hero_nick"]?></td>
	</tr>
	<tr>
		<th>�̸�</th>
		<td><?=$view["hero_name"]?></td>
		<th>����</th>
		<td><?=$view["hero_age"]?></td>
	</tr>
	<tr>
		<th>�������</th>
		<td colspan="3"><?=$view["hero_jumin"]?></td>
	</tr>
	<tr>
		<th>��ü����Ʈ</th>
		<td><?=number_format($view["hero_point"])?> p</td>
		<th>��������Ʈ</th>
		<td><?=number_format($view["hero_point"]-$view["hero_order_point"])?> p</td>
	</tr>
	<tr>
		<th>�޴�����ȣ</th>
		<td>
			<input type="text" name="hero_hp_01" value="<?=$hero_hp[0]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly />
			- <input type="text" name="hero_hp_02" value="<?=$hero_hp[1]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly/>
			- <input type="text" name="hero_hp_03" value="<?=$hero_hp[2]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly/>
			
			<input type="checkbox" name="hero_hp_check" id="hero_hp_check"/><label>���� Ȱ��ȭ</label>
		</td>
		<th>�̸���</th>
		<td>
			<input type="text" name="hero_mail_01" value="<?=$hero_mail[0]?>" class="w200 input_hero_mail" readonly/>
			@ <input type="text" name="hero_mail_02" value="<?=$hero_mail[1]?>" class="w200 input_hero_mail" readonly/>
			
			<input type="checkbox" name="hero_mail_check" id="hero_mail_check"/><label>���� Ȱ��ȭ</label>
		</td>
	</tr>
	<tr>
		<th>�޴��� ���ŵ���</th>
		<td>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_1" value="1" <?=$view["hero_chk_phone"] == "1" ? "checked":""?>/><label for="hero_chk_phone_1">����</label>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_0" value="0" <?=$view["hero_chk_phone"] != "1" ? "checked":""?>/><label for="hero_chk_phone_0">�̵���</label>
		</td>
		<th>�̸��� ���ŵ���</th>
		<td>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_1" value="1" <?=$view["hero_chk_email"] == "1" ? "checked":""?>/><label for="hero_chk_email_1">����</label>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_0" value="0" <?=$view["hero_chk_email"] != "1" ? "checked":""?>/><label for="hero_chk_email_0">�̵���</label>
		</td>
	</tr>
	<tr>
		<th>�ּ�</th>
		<td colspan="3">
			[<?=$view["hero_address_01"]?>] <?=$view["hero_address_02"]?> <?=$view["hero_address_03"]?>
		</td>
	</tr>
	<tr>
		<th>���԰��</th>
		<td>
			<?=$view["area"]?>
			<? if($view["area"]=="��Ÿ") {?> 
				(<?=$view["area_etc_text"]?>)
			<? } ?>
		</td>
		<th>ȸ������ ����</th>
		<td><?=$handphone?><?=$kakaoTalk?><?=$naver?><?=$google?><?=$facebook?></td>
	</tr>
	<tr>
		<th>��õ��</th>
		<td colspan="3">
			<? if($view["hero_user_type"] == "hero_id") {?>
				���̵� ��õ : 
			<? } else if($view["hero_user_type"] == "hero_nick") { ?>
			   	�г��� ��õ :
			<? } ?>
			<?=$view["hero_user"]?>
		</td>
	</tr>
	<tr>
		<th>������</th>
		<td><?=$view["hero_oldday"]?></td>
		<th>���� �α��� ��¥</th>
		<td><?=$view["hero_today"]?>&nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="fnPopLoginHist()" class="btnFunc">�α��� �̷�</a></td>
	</tr>
	<tr>
		<th>��й�ȣ �ʱ�ȭ</th>
		<td>
			<a href="javascript:;" onClick="fnPWInitialize('<?=$view["hero_id"]?>')" class="btnFunc2">�ʱ�ȭ</a>
			<input type="text" name="pw_initialized" value="" style="width:150px; outline:none; border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly />
		</td>
		<th>���� ��й�ȣ �ʱ�ȭ<br/>��¥</th>
		<td id="pw_initialized_datetime"><?=$pw_init["hero_today"]?>
		<? if(isset($pw_init["hero_today"]) && !empty($pw_init["hero_today"])) {?>
		&nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="fnPopResetPwHist()" class="btnFunc">�ʱ�ȭ �̷�</a>
		<? }?>
		</td>
	</tr>
</tbody>
</table>

<div class="align_c margin_t20">
	<a href="javascript:;" onclick="fnEdit()" class="btnAdd">����</a>
</div>

<p class="tit_section mgt30">SNS ����</p>
<table class="t_view mgt10">
<colgroup>
	<col width="150px">
	<col width=*>
	<col width="100">
	<col width="120">
	<col width="100">
	<col width="120">
	<col width="100">
	<col width="120">
</colgroup>
<tbody>
	<tr>
		<th>����Ƽ ������Ʈ ��¥</th>
		<td colspan="7"><input type="text" name="hero_sns_update_date" value="<?=$view["hero_sns_update_date"]?>" placeholder="��� ex) yyyymm" numberOnly maxlength="6"></td>
	</tr>
	<tr>
		<th>���̹� ��α�</th>
		<td>https://blog.naver.com/<input type="text" style="width:200px;margin-left: 5px;" name="hero_blog_00" value="<?=$hero_naver_blog?>" /></td>
		<th>�湮�� ��</th>
		<td><input type="text" name="hero_memo" value="<?=$view["hero_memo"]?>" numberOnly/></td>
		<th>�̹��� ����Ƽ</th>
		<td><select name="hero_memo_01_image">
				<option value="">����</option>
				<option value="��" <?=$view["hero_memo_01_image"]=="��" ? "selected":""?>>��</option>
				<option value="�߻�" <?=$view["hero_memo_01_image"]=="�߻�" ? "selected":""?>>�߻�</option>
				<option value="��" <?=$view["hero_memo_01_image"]=="��" ? "selected":""?>>��</option>
				<option value="����" <?=$view["hero_memo_01_image"]=="����" ? "selected":""?>>����</option>
				<option value="��" <?=$view["hero_memo_01_image"]=="��" ? "selected":""?>>��</option>
		    </select>
		</td>
		<th>�ؽ�Ʈ ����Ƽ</th>
		<td><select name="hero_memo_01">
				<option value="">����</option>
				<option value="��" <?=$view["hero_memo_01"]=="��" ? "selected":""?>>��</option>
				<option value="�߻�" <?=$view["hero_memo_01"]=="�߻�" ? "selected":""?>>�߻�</option>
				<option value="��" <?=$view["hero_memo_01"]=="��" ? "selected":""?>>��</option>
				<option value="����" <?=$view["hero_memo_01"]=="����" ? "selected":""?>>����</option>
				<option value="��" <?=$view["hero_memo_01"]=="��" ? "selected":""?>>��</option>
		    </select>
		</td>
	</tr>
	<tr>
		<th>�ν�Ÿ�׷�</th>
		<td>https://www.instagram.com/<input type="text" style="width:200px;margin-left: 5px;" name="hero_blog_04" value="<?=$hero_instagram?>" /></td>
		<th>�ȷο� ��</th>
		<td><input type="text" name="hero_insta_cnt" value="<?=$view["hero_insta_cnt"]?>" numberOnly/></td>
		<th>�̹��� ����Ƽ</th>
		<td><select name="hero_insta_image_grade">
				<option value="">����</option>
				<option value="��" <?=$view["hero_insta_image_grade"]=="��" ? "selected":""?>>��</option>
				<option value="�߻�" <?=$view["hero_insta_image_grade"]=="�߻�" ? "selected":""?>>�߻�</option>
				<option value="��" <?=$view["hero_insta_image_grade"]=="��" ? "selected":""?>>��</option>
				<option value="����" <?=$view["hero_insta_image_grade"]=="����" ? "selected":""?>>����</option>
				<option value="��" <?=$view["hero_insta_image_grade"]=="��" ? "selected":""?>>��</option>
		    </select>
		</td>
		<th>�ؽ�Ʈ ����Ƽ</th>
		<td><select name="hero_insta_grade">
				<option value="">����</option>
				<option value="��" <?=$view["hero_insta_grade"]=="��" ? "selected":""?>>��</option>
				<option value="�߻�" <?=$view["hero_insta_grade"]=="�߻�" ? "selected":""?>>�߻�</option>
				<option value="��" <?=$view["hero_insta_grade"]=="��" ? "selected":""?>>��</option>
				<option value="����" <?=$view["hero_insta_grade"]=="����" ? "selected":""?>>����</option>
				<option value="��" <?=$view["hero_insta_grade"]=="��" ? "selected":""?>>��</option>
		    </select>
		</td>
	</tr>
	<tr>
		<th>�� ��  SNS</th>
		<td colspan="7"><input type="text" name="hero_blog_05" value="<?=$view["hero_blog_05"]?>" /></td>
	</tr>
	<tr>
		<th>���̹� ���÷�� Ȩ</th>
		<td>https://in.naver.com/<input type="text" style="width:200px;margin-left: 5px;" name="hero_naver_influencer" value="<?=$hero_naver_influencer?>" /></td>
		<th colspan="2">���̹� ���÷�� ��</th>
		<td colspan="2"><input type="text" name="hero_naver_influencer_name" value="<?=$view["hero_naver_influencer_name"]?>"/></td>
		<th>Ȱ�� ī�װ�</th>
		<td><select id="hero_naver_influencer_category" name="hero_naver_influencer_category">
				<option value=""<?if(!strcmp($view["hero_naver_influencer_category"], '')){echo ' selected';}else{echo '';}?>>����</option>
                <option value="����"<?if(!strcmp($view["hero_naver_influencer_category"], '����')){echo ' selected';}else{echo '';}?>>����</option>
                <option value="�м�"<?if(!strcmp($view["hero_naver_influencer_category"], '�м�')){echo ' selected';}else{echo '';}?>>�м�</option>
                <option value="��Ƽ"<?if(!strcmp($view["hero_naver_influencer_category"], '��Ƽ')){echo ' selected';}else{echo '';}?>>��Ƽ</option>
                <option value="Ǫ��"<?if(!strcmp($view["hero_naver_influencer_category"], 'Ǫ��')){echo ' selected';}else{echo '';}?>>Ǫ��</option>
                <option value="IT��ũ"<?if(!strcmp($view["hero_naver_influencer_category"], 'IT��ũ')){echo ' selected';}else{echo '';}?>>IT��ũ</option>
                <option value="�ڵ���"<?if(!strcmp($view["hero_naver_influencer_category"], '�ڵ���')){echo ' selected';}else{echo '';}?>>�ڵ���</option>
                <option value="����"<?if(!strcmp($view["hero_naver_influencer_category"], '����')){echo ' selected';}else{echo '';}?>>����</option>
                <option value="����"<?if(!strcmp($view["hero_naver_influencer_category"], '����')){echo ' selected';}else{echo '';}?>>����</option>
                <option value="��Ȱ�ǰ�"<?if(!strcmp($view["hero_naver_influencer_category"], '��Ȱ�ǰ�')){echo ' selected';}else{echo '';}?>>��Ȱ�ǰ�</option>
                <option value="����"<?if(!strcmp($view["hero_naver_influencer_category"], '����')){echo ' selected';}else{echo '';}?>>����</option>
                <option value="����/��"<?if(!strcmp($view["hero_naver_influencer_category"], '����/��')){echo ' selected';}else{echo '';}?>>����/��</option>
                <option value="�/����"<?if(!strcmp($view["hero_naver_influencer_category"], '�/����')){echo ' selected';}else{echo '';}?>>�/����</option>
                <option value="���ν�����"<?if(!strcmp($view["hero_naver_influencer_category"], '���ν�����')){echo ' selected';}else{echo '';}?>>���ν�����</option>
                <option value="���/����"<?if(!strcmp($view["hero_naver_influencer_category"], '���/����')){echo ' selected';}else{echo '';}?>>���/����</option>
                <option value="��������"<?if(!strcmp($view["hero_naver_influencer_category"], '��������')){echo ' selected';}else{echo '';}?>>��������</option>
                <option value="��ȭ"<?if(!strcmp($view["hero_naver_influencer_category"], '��ȭ')){echo ' selected';}else{echo '';}?>>��ȭ</option>
                <option value="����/����/����"<?if(!strcmp($view["hero_naver_influencer_category"], '����/����/����')){echo ' selected';}else{echo '';}?>>����/����/����</option>
                <option value="����"<?if(!strcmp($view["hero_naver_influencer_category"], '����')){echo ' selected';}else{echo '';}?>>����</option>
                <option value="����/����Ͻ�"<?if(!strcmp($view["hero_naver_influencer_category"], '����/����Ͻ�')){echo ' selected';}else{echo '';}?>>����/����Ͻ�</option>
                <option value="����/����"<?if(!strcmp($view["hero_naver_influencer_category"], '����/����')){echo ' selected';}else{echo '';}?>>����/����</option>
		    </select>
		</td>
	</tr>
	<tr>
		<th>��Ʃ��</th>
		<td><input type="text" name="hero_blog_03" value="<?=$view["hero_blog_03"]?>" /></td>
		<th>������ ��</th>
		<td><input type="text" name="hero_youtube_cnt" value="<?=$view["hero_youtube_cnt"]?>" numberOnly/></td>
		<th>��ȸ�� ��</th>
		<td><input type="text" name="hero_youtube_view" value="<?=$view["hero_youtube_view"]?>" numberOnly/></td>
		<th>������ ���</th>
		<td><select name="hero_youtube_grade">
				<option value="">����</option>
				<option value="��" <?=$view["hero_youtube_grade"]=="��" ? "selected":""?>>��</option>
				<option value="�߻�" <?=$view["hero_youtube_grade"]=="�߻�" ? "selected":""?>>�߻�</option>
				<option value="��" <?=$view["hero_youtube_grade"]=="��" ? "selected":""?>>��</option>
				<option value="����" <?=$view["hero_youtube_grade"]=="����" ? "selected":""?>>����</option>
				<option value="��" <?=$view["hero_youtube_grade"]=="��" ? "selected":""?>>��</option>
		    </select>
		</td>
	</tr>
	<tr>
		<th>���̹�TV</th>
		<td colspan="7"><input type="text" name="hero_blog_06" value="<?=$view["hero_blog_06"]?>" /></td>
	</tr>
	<tr>
		<th>ƽ��</th>
		<td colspan="7"><input type="text" name="hero_blog_07" value="<?=$view["hero_blog_07"]?>" /></td>
	</tr>
	<tr>
		<th>��Ÿ(����)</th>
		<td colspan="7"><input type="text" name="hero_blog_08" value="<?=$view["hero_blog_08"]?>" /></td>
	</tr>
</tbody>
</table>
<div class="align_c margin_t20">
	<a href="javascript:;" onclick="fnEditSns()" class="btnAdd">����</a>
</div>

<p class="tit_section mgt10">�߰� ���� ����</p>
<table class="t_view mgt10">
<colgroup>
	<col width="150px">
	<col width="">
	<col width="150px">
	<col width="">
</colgroup>
<tbody>
	<tr>
		<th>���� SNS URL(��/��)</th>
		<td><?=$view["hero_qs_01"] == "Y" ? "����":"����"?></td>
		<th>��ȥ ����</th>
		<td><?=$view["hero_qs_02"] == "Y" ? "��ȥ":"��ȥ"?></td>
	</tr>
	<tr>
		<th>�ڳ�����</th>
		<td><?=$view["hero_qs_03"] == "Y" ? "����":"����"?></td>
		<th>�ڳ� ��/�¾ �⵵</th>
		<td>
			<? if($view["hero_qs_04"]) {
				$hero_qs_05_arr = explode(",",$view["hero_qs_05"]);
				$hero_qs_05_txt = "";
				foreach($hero_qs_05_arr as $val) {
					if($hero_qs_05_txt) $hero_qs_05_txt .= ", ";
					$hero_qs_05_txt .= $val;
				}
				
			?>
				<?=$view["hero_qs_04"]?>��/<?=$hero_qs_05_txt?>
				
			<? } ?>
		</td>
	</tr>
	<tr>
		<th>�Ǻ�Ÿ��</th>
		<td><?=$view["hero_qs_22"]?></td>
		<th>����Ÿ��</th>
		<td><?=$view["hero_qs_23"]?></td>
	</tr>
	<tr>
		<th>Ż�� ����</th>
		<td><?=$hero_qs_18?></td>
		<th>�ݷ����� ����</th>
		<td><?=$hero_qs_19?></td>
	</tr>
	<tr>
		<th>������ ����</th>
		<td><?=$hero_qs_20?></td>
		<th>�ı⼼ô�� ����</th>
		<td><?=$hero_qs_21?></td>
	</tr>
	<tr>
		<th>AK LOVER�� ������ ����</th>
		<td colspan="3"><?=$view["hero_qs_06"]?></td>
	</tr>
	<tr>
		<th>AK LOVER�� Ȱ���ϴ� ��������/ü��� ī�� �Ǵ� Ȩ������</th>
		<td colspan="3">
			<?=$view["hero_qs_07"] == "Y" ? "����":"����"?>
			<? if($view["hero_qs_07"] == "Y") {?>
				(<?=$view["hero_qs_08"]?>)
			<? } ?>
		</td>
	</tr>
</tbody>
</table>
</form>

<div class="align_l margin_t20">
	<a href="javascript:;" onclick="fnList();" class="btnList">���</a>
</div>

<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<script>
$(document).ready(function(){
	$("#hero_hp_check").on("click",function(){
		if($(this).is(":checked")) {
			$(".input_hero_hp").attr("readOnly",false);
		} else {
			$(".input_hero_hp").attr("readOnly",true);
		}
	})
	
	$("#hero_mail_check").on("click",function(){
		if($(this).is(":checked")) {
			$(".input_hero_mail").attr("readOnly",false);
		} else {
			$(".input_hero_mail").attr("readOnly",true);
		}
	})

	fnPopPoint = function() {
		var popPoint = window.open("/loaksecure21/user/popUserManagerPointList.php?hero_code=<?=$view["hero_code"]?>","popPoint","width=660, height=660");
		popPoint.focus();
	}

	fnPopWrite = function() {
		var popWrite = window.open("/loaksecure21/user/popUserManagerWriteList.php?hero_code=<?=$view["hero_code"]?>","popWrite","width=660, height=500");
		popWrite.focus();
	}
	
	fnPopLoginHist = function() {
		var popWrite = window.open("/loaksecure21/user/popUserManagerLoginHist.php?hero_code=<?=$view["hero_code"]?>","popWrite","width=660, height=500");
		popWrite.focus();
	}
	
	fnPopResetPwHist = function() {
		var popWrite = window.open("/loaksecure21/user/popUserManagerResetPwHist.php?hero_code=<?=$view["hero_code"]?>","popWrite","width=660, height=500");
		popWrite.focus();
	}

	fnPopSuperpass = function() {
		var popSuperpass = window.open("/loaksecure21/user/popUserManagerSuperpassList.php?hero_code=<?=$view["hero_code"]?>","popSuperpass","width=660, height=500");
		popSuperpass.focus();
	}

	fnPopPenalty = function() {
		var popPenalty = window.open("/loaksecure21/user/popUserManagerPenaltyList.php?hero_code=<?=$view["hero_code"]?>","popPenalty","width=660, height=500");
		popPenalty.focus();
	}
	
	fnEditSns = function() {
		if(confirm("SNS ���� ������ �����Ͻðڽ��ϱ�?")) {
			$("#viewForm input[name='mode']").val("editSns");
			var param = $("#viewForm").serialize();
			$.ajax({
					url:"/loaksecure21/user/userManagerAction.php"
					,type:"POST"
					,data:param
					,dataType:"json"
					,success:function(d){
						console.log(d);
						if(d.result==1) {
							alert("SNS ���� ������ ���� �Ǿ����ϴ�.");
							location.reload();
						} else {
							alert("���� �� �����߽��ϴ�.")
						}
					},error:function(e){
						console.log(e);
						alert("�����߽��ϴ�.");
					}
				})
				
			$("#viewForm input[name='mode']").val("");//�ʱ�ȭ
		}
	}
	
	
	fnEdit = function() {
		_frm = $("#viewForm");
		if(!_frm.find("input[name='hero_hp_01']").val()) {
			alert("�޴���(1)�� �Է��� �ּ���.");
			_frm.find("input[name='hero_hp_01']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_hp_02']").val()) {
			alert("�޴���(2)�� �Է��� �ּ���.");
			_frm.find("input[name='hero_hp_02']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_hp_03']").val()) {
			alert("�޴���(3)�� �Է��� �ּ���.");
			_frm.find("input[name='hero_hp_03']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_mail_01']").val()) {
			alert("�̸���(1)�� �Է��� �ּ���.");
			_frm.find("input[name='hero_mail_01']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_mail_02']").val()) {
			alert("�̸���(2)�� �Է��� �ּ���.");
			_frm.find("input[name='hero_mail_02']").focus();
			return;
		}
		/*
		if(!_frm.find("input[name='hero_address_01']").val()) {
			alert("�����ȣ�� �Է��� �ּ���.");
			_frm.find("input[name='hero_address_01']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_address_02']").val()) {
			alert("�ּҸ� �Է��� �ּ���.");
			_frm.find("input[name='hero_address_02']").focus();
			return;
		}
		*/

		_frm.find("input[name='mode']").val("edit");
		var param = _frm.serialize();
		$.ajax({
				url:"/loaksecure21/user/userManagerAction.php"
				,type:"POST"
				,data:param
				,dataType:"json"
				,success:function(d){
					console.log(d);
					if(d.result==1) {
						alert(" ���� �Ǿ����ϴ�.");
						location.reload();
					} else {
						alert("���� �� �����߽��ϴ�.")
					}
				},error:function(e){
					console.log(e);
					alert("�����߽��ϴ�.");
				}
			})
			
			_frm.find("input[name='mode']").val(""); //�ʱ�ȭ
	}
	
	
	fnPWInitialize = function(hero_id) { 
		alert("�н����带 �Է����ּ���.");
        const name = prompt("�н����� �Է�" + "");
        if (name=="") {
            return fnPwResetConfirm();
        }
        
        else if (name == null) {
            return;
        }
    
        if (name == '0104'){
            _frm = $("#viewForm");
        
            const characters ='8A0B1CD2EF7GH3IJKL4MN6OPQ5RS9TUV6WXYZa7b5cde8fghi9jkl4mn3opqr2stuvw1xyz0';
            let result = '';
            const charactersLength = characters.length;
            for (let i = 0; i < 8; i++) {
               result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
        
            result = hero_id + result;
            _frm.find("input[name='pw_initialized']").val(result);

    		_frm.find("input[name='mode']").val("pwInitialize");
    		var param = _frm.serialize();
    		$.ajax({
    				url:"/loaksecure21/user/userManagerAction.php"
    				,type:"POST"
    				,data:param
    				,dataType:"json"
    				,success:function(d){
    					console.log(d);
    					if(d.result==1) {
    						var today = new Date();
                            today.setHours(today.getHours() + 9);
                            var datestr = today.toISOString().replace('T', ' ').substring(0, 19);
                            $("#pw_initialized_datetime").text(datestr);
    						alert("�ʱ�ȭ �Ǿ����ϴ�.");
    					} else {
    						alert("���� �� �����߽��ϴ�.");
    					}
    				},error:function(e){
    					console.log(e);
    					alert("�����߽��ϴ�.");
    				}
    			})
			
			_frm.find("input[name='mode']").val("");
        } else {
            alert("�н����尡 Ʋ�Ƚ��ϴ�.")
        }
	}
	
	
	fnWithdrawal = function(hero_nick) {
		if(confirm(hero_nick+"���� ������ �������� Ż���Ͻðڽ��ϱ�?\nŻ�� �� ������ �Ұ����մϴ�.")) {
			$("#viewForm input[name='mode']").val("withdrawal");
			var param = $("#viewForm").serialize();
			$.ajax({
					url:"/loaksecure21/user/userManagerAction.php"
					,type:"POST"
					,data:param
					,dataType:"json"
					,success:function(d){
						console.log(d);
						if(d.result==1) {
							alert("Ż��Ǿ����ϴ�.");
							fnList();
						} else {
							alert("���� �� �����߽��ϴ�.")
						}
					},error:function(e){
						console.log(e);
						alert("�����߽��ϴ�.");
					}
				})
				
			$("#viewForm input[name='mode']").val("");//�ʱ�ȭ
		}
	}
	
	fnList = function() {
		$("#searchForm").submit();
	}
})
</script>

