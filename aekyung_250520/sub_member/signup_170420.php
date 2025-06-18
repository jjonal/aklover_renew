<?
####################################################################################################################################################
//HERO BOARD ½ÃÀÛ (°³¹ßÀÚ : ÀÌÁø¿µ)2013³â 08¿ù 07ÀÏ
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
if(!$_SESSION['temp_level'] || $_SESSION['temp_level']<9999){

	if((!$_POST['param_r6'] || !$_POST['param_r5']) && (!$_POST['snsId'] || !$_POST['snsType'])){
		error_historyBack("Àß ¸øµÈ Á¢±ÙÀÔ´Ï´Ù.");
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
		error_location("ÀÌ¹Ì °¡ÀÔÇÏ¼Ì½À´Ï´Ù.","/main/index.php?board=findpw");
		exit;
	}
	
	//########### ÈÞ¸éÁ¤º¸ Ã¼Å© ##############
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
		error_location("ÇØ´ç È¸¿øÀº ÈÞ¸é »óÅÂÀÔ´Ï´Ù.ID/PWÃ£±â¸¦ ÅëÇØ ·Î±×ÀÎ ÇÏ¿© ÁÖ½Ê½Ã¿À.","/main/index.php?board=findpw");
		exit;
	}
}

####################################################################################################################################################
//ÀÎÁõ °¡ÀÔ½Ã
if($_POST['param_r5'] && $_POST['param_r6'] && $_POST['param_r2']){
	$di = $_POST['param_r5'];
	$ci = $_POST['param_r6'];
	
	$param_r2_01 = substr($_POST['param_r2'], '0', '4');//³â
	$param_r2_02 = substr($_POST['param_r2'], '4', '2');//¿ù
	$param_r2_03 = substr($_POST['param_r2'], '6', '2');//ÀÏ
	
	if(!$param_r2_01 || !$param_r2_02 || !$param_r2_03){
		error_location("½Ã½ºÅÛ ¿À·ùÀÔ´Ï´Ù. ´Ù½Ã ½ÃµµÇØÁÖ¼¼¿ä","/main/index.php?board=idcheck");
		exit;
	}
	
	include_once $_SERVER['DOCUMENT_ROOT']."/classGathered/chAgeClass.php";
	$chAgeClass = new chAgeClass($param_r2_01,$param_r2_02,$param_r2_03);
	$age = $chAgeClass->countUniversalAge();
	if((int)$age<15){
		error_location("¸¸14¼¼ ¹Ì¸¸Àº °¡ÀÔÇÏ½Ç ¼ö ¾ø½À´Ï´Ù.","/main/index.php");
		exit;
	}
	
	$readonly_auth = "readonly";
	$disabled_auth = "disabled='disabled'";
	$displaynone_auth = "style='display:none'";
//sns °¡ÀÔ½Ã
}else{
	
	$snsId = $_POST['snsId'];
	$snsEmail = explode("@",$_POST['snsEmail']);
	$snsType = $_POST['snsType'];
	
	switch($snsType){
		case "facebook" : $snsText = "<img src='/image2/etc/snsBig01.jpg' alt='".$snsType."'> È¸¿ø´ÔÀÇ ÆäÀÌ½ººÏÀÌ ¿¬µ¿µÇ¾ú½À´Ï´Ù";break;
		case "kakaoTalk" : $snsText = "<img src='/image2/etc/snsBig02.jpg' alt='".$snsType."'> È¸¿ø´ÔÀÇ Ä«Ä«¿ÀÅåÀÌ ¿¬µ¿µÇ¾ú½À´Ï´Ù";break;
		case "naver" : $snsText = "<img src='/image2/etc/snsBig03.jpg' alt='".$snsType."'> È¸¿ø´ÔÀÇ ³×ÀÌ¹ö ¾ÆÀÌµð°¡ ¿¬µ¿µÇ¾ú½À´Ï´Ù";break;
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
		$(document).on("keyup", "input:text[textOnly]", function() {$(this).val( $(this).val().replace(/[^¤¡-¤¾¤¿-¤Ó°¡-ÆRa-zA-Z]/gi,"") );});
	});
	</script>
    <div class="contents_area">
        <div class="layer_zip">
            <form name="login_form" action="<?=PATH_HOME_HTTPS?>?board=result" onsubmit="return false;">
            <dl>
                <dt><img src="../image/member/zip1.gif" alt="¿ìÆí¹øÈ£ Ã£±â" /></dt>
                <dd>
                <input id="addr" type="text" class="addr" /><input type="image" src="../image/member/btn_findzip.gif" alt="ÁÖ¼ÒÃ£±â" onclick="hero_ajax('zip.php', 'view_list', 'addr', 'zip'); return false;"/>
                </dd>
                <dd class="list">
                    <div id="view_list"></div>
                </dd>
                <dd class="tc"><a href="javascript:inputzip();"><img src="../image/member/btn_cancel.gif" alt="ÀÔ·Â" /></a></dd>
            </dl>
            </form>
        </div>
        <div class="page_title">
            <h2><img src="../image/title/title_7_1.gif" alt="È¸¿ø°¡ÀÔ" /></h2>
            <ul class="nav">
                <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
                <li>&gt;</li>
                <li class="current">È¸¿ø°¡ÀÔ</li>
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
			<!-- 160701 ³ª¾Æ·Ð Ãß°¡Á¤º¸±âÀÔ ÀÌº¥Æ®(s) -->
			<input type="hidden" name="question_null_yn" value="N">
			<!-- 160701 ³ª¾Æ·Ð Ãß°¡Á¤º¸±âÀÔ ÀÌº¥Æ®(e) -->
			
            <p style="padding-bottom: 20px;"><?=$snsText?></p>
            
            <div class="signup_term">
	            <div class="signup_term_title">¡á (ÇÊ¼ö) ÀÌ¿ë ¾à°ü</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term1.php";?>
	            </div>
	            <div>¡Øµ¿ÀÇÇÏÁö ¾ÊÀ» °æ¿ì È¸¿ø°¡ÀÔÀÌ µÇÁö ¾Ê½À´Ï´Ù.<div class="signup_term_agree"><input type="radio" name="hero_terms_01" class="partAgree_btn" value='0'/>µ¿ÀÇ<input type="radio" class="partAgree_btn" name="hero_terms_01" value='1'/>µ¿ÀÇ¾ÈÇÔ</div></div>
	            
	            <div class="signup_term_title">¡á (ÇÊ¼ö) °³ÀÎÁ¤º¸ Ãë±Þ¹æÄ§</div>
	            <div class="signup_term_title ">¼öÁýÇÏ´Â °³ÀÎÁ¤º¸ Ç×¸ñ ¹× ¼öÁý¹æ¹ý</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term4.html";?>
	            </div>
	            <div>¡Øµ¿ÀÇÇÏÁö ¾ÊÀ» °æ¿ì È¸¿ø°¡ÀÔÀÌ µÇÁö ¾Ê½À´Ï´Ù.<div class="signup_term_agree"><input type="radio" name="hero_terms_02" class="partAgree_btn" value='0'/>µ¿ÀÇ<input type="radio" class="partAgree_btn" name="hero_terms_02" value='1'/>µ¿ÀÇ¾ÈÇÔ</div></div>
	            
	            <div class="signup_term_title">(ÇÊ¼ö) °³ÀÎÁ¤º¸ÀÇ ¼öÁý ¹× ÀÌ¿ë ¸ñÀû</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term5.html";?>
	            </div>
				<div>¡Øµ¿ÀÇÇÏÁö ¾ÊÀ» °æ¿ì È¸¿ø°¡ÀÔÀÌ µÇÁö ¾Ê½À´Ï´Ù.<div class="signup_term_agree"><input type="radio" name="hero_terms_03" class="partAgree_btn" value='0'/>µ¿ÀÇ<input type="radio" class="partAgree_btn" name="hero_terms_03" value='1'/>µ¿ÀÇ¾ÈÇÔ</div></div>
				
	            <div class="signup_term_title">(ÇÊ¼ö) °³ÀÎÁ¤º¸ÀÇ º¸À¯ ¹× ÀÌ¿ë±â°£</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term6.html";?>
	            	</div>
				<div>¡Øµ¿ÀÇÇÏÁö ¾ÊÀ» °æ¿ì È¸¿ø°¡ÀÔÀÌ µÇÁö ¾Ê½À´Ï´Ù.<div class="signup_term_agree"><input type="radio" name="hero_terms_04" class="partAgree_btn" value='0'/>µ¿ÀÇ<input type="radio" class="partAgree_btn" name="hero_terms_04" value='1'/>µ¿ÀÇ¾ÈÇÔ</div></div>
                <div class="signup_term_title">(ÇÊ¼ö) °³ÀÎÁ¤º¸ Ãë±ÞÀ§Å¹µ¿ÀÇ</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term7.html";?>
	            	</div>
				<div>¡Øµ¿ÀÇÇÏÁö ¾ÊÀ» °æ¿ì È¸¿ø°¡ÀÔÀÌ µÇÁö ¾Ê½À´Ï´Ù.<div class="signup_term_agree"><input type="radio" name="hero_terms_05" class="partAgree_btn" value='0'/>µ¿ÀÇ<input type="radio" class="partAgree_btn" name="hero_terms_05" value='1'/>µ¿ÀÇ¾ÈÇÔ</div></div>
            </div>
            
            
            <p class="member_alert"><span>*</span>´Â ÇÊ¼ö °¡ÀÔ Ç×¸ñÀÔ´Ï´Ù!!!</p>
            
            <table class="member">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr>
                    <th><span>*</span> ¾ÆÀÌµð</th>
                    <td>
                        <input type="text" name="hero_id" id="hero_id" style="ime-mode:disabled;" onfocusout="ch_id(this);" value=""/>
                        <span id="ch_id_text">4~20ÀÚ °¡´É, Æ¯¼ö¹®ÀÚ(!@#$%) »ç¿ëºÒ°¡</span>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> ºñ¹Ð¹øÈ£</th>
                    <td><input type="password" name="hero_pw_01" id="hero_pw_01" onkeyup="chPwdTF(this);"/>&nbsp;&nbsp;<span id="ch_hero_pw_01">¿µ¹®, ¼ýÀÚ, Æ¯¼ö±âÈ£¸¦ Á¶ÇÕÇÏ¿© 8ÀÚ¸® ÀÌ»ó ÀÔ·ÂÇØÁÖ¼¼¿ä</span></td>
                </tr>
                <tr>
                    <th><span>*</span> ºñ¹Ð¹øÈ£ È®ÀÎ</th>
                    <td><input type="password" name="hero_pw_02" id="hero_pw_02" onkeyup="chPwdTF(this);"/>&nbsp;&nbsp;<span id="ch_hero_pw_02"></span></td>
                </tr>
                <tr>
                    <th><span>*</span> ÀÌ¸§</th>
                    <td><input type="text" name="hero_name" value="<?=$_POST['param_r1']?>" <?=$readonly_auth?> /></td>
                </tr>
                <tr>
                    <th><span>*</span> ´Ð³×ÀÓ</th>
                    <td>
                        <input type="text" name="hero_nick" id="hero_nick_02" onkeyup="ch_nick(this);"/>
                        <span id="ch_nick_text"></span>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> »ý³â¿ùÀÏ</th>
                    <td>
                        <select id="year" title="Ãâ»ý³âµµ ¼±ÅÃ" class="mr12" <?=$disabled_auth?>></select>
                        <select id="month" title="Ãâ»ý¿ù ¼±ÅÃ" class="mr12" <?=$disabled_auth?>></select>
                        <select id="date" title="Ãâ»ýÀÏ ¼±ÅÃ" class="mr12" <?=$disabled_auth?>></select><br/>
                        <p>¸¸ 14¼¼ ¹Ì¸¸Àº È¸¿ø°¡ÀÔÀÌ ºÒ°¡ÇÕ´Ï´Ù.<p>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> ÀÌ¸ÞÀÏ</th>
                    <td>
                        <input type="text" name="hero_mail_01" value="<?=$snsEmail[0]?>" style="ime-mode:disabled;" > @<br/>
                        <input type="text" id="hero_mail_02" name="hero_mail_02" value="<?=$snsEmail[1]?>" style="ime-mode:disabled;" >
                        <select id="email_select" onchange='emailChg();' class="short" >
                            <option value="">Á÷Á¢ÀÔ·Â</option>
                            <option value="naver.com"<?if(!strcmp($hero_mail['1'], 'naver.com')){echo ' selected';}else{echo '';}?>>naver.com</option>
                            <option value="hanmail.net"<?if(!strcmp($hero_mail['1'], 'hanmail.net')){echo ' selected';}else{echo '';}?>>hanmail.net</option>
                            <option value="daum.net"<?if(!strcmp($hero_mail['1'], 'daum.net')){echo ' selected';}else{echo '';}?>>daum.net</option>
                            <option value="gmail.com"<?if(!strcmp($hero_mail['1'], 'gmail.com')){echo ' selected';}else{echo '';}?>>gmail.com</option>
                            <option value="hotmail.com"<?if(!strcmp($hero_mail['1'], 'hotmail.com')){echo ' selected';}else{echo '';}?>>hotmail.com</option>
                            <option value="paran.com"<?if(!strcmp($hero_mail['1'], 'paran.com')){echo ' selected';}else{echo '';}?>>paran.com</option>
                            <option value="nate.com"<?if(!strcmp($hero_mail['1'], 'nate.com')){echo ' selected';}else{echo '';}?>>nate.com</option>
                         </select>

                         <p style="height:25px;">ÀÌ¸ÞÀÏ ¼ö½Å&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="hero_chk_email" value='1' style='width:13px;' checked="checked">µ¿ÀÇ
							<input type="radio" name="hero_chk_email" value='0' style='width:13px;'>µ¿ÀÇ¾ÈÇÔ
						</p>
						<p>¼ö½Å¿¡ µ¿ÀÇÇÏ½Ã¸é °¢Á¾ ¹Ì¼Ç/ÀÌº¥Æ®¸¦ È®ÀÎÇÏ½Ç ¼ö ÀÖ½À´Ï´Ù.</p>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> ÈÞ´ëÆù</th>
                    <td>
                        <input type="text" name="hero_hp_01" id="hero_hp_01" style="width:125px;" onkeyup="if(this.value.length > 2)hero_hp_02.focus();" maxlength="3" suOnly="true"/>
                        <input type="text" name="hero_hp_02" id="hero_hp_02" style="width:125px;" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" suOnly="true"/>
                        <input type="text" name="hero_hp_03" id="hero_hp_03" style="width:125px;" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" suOnly="true"/>
						
						<p style="height:25px;">
							<span>SMS ¼ö½Å&nbsp;&nbsp;&nbsp;&nbsp;</span>
							<input type="radio" name="hero_chk_phone" value='1' style='width:13px;' checked="checked">µ¿ÀÇ
							<input type="radio" name="hero_chk_phone" value='0' style='width:13px;'>µ¿ÀÇ¾ÈÇÔ<br>
						</p>
						<p>¼ö½Å¿¡ µ¿ÀÇÇÏ½Ã¸é °¢Á¾ ¹Ì¼Ç/ÀÌº¥Æ®Á¤º¸¸¦ ¹Þ¾Æ º¸½Ç ¼ö ÀÖ½À´Ï´Ù.</p>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> ÁÖ¼Ò</th>
                    <td>
                        <input type="text" name="hero_address_01" id="hero_address_01" onclick="javascript:btnAddressGet();" class="w190" />
                        <a href="javascript:btnAddressGet()"><img src="../image/member/btn_zipcode.gif" alt="¿ìÆí¹øÈ£Ã£±â" /></a><br />
                        <input type="text" name="hero_address_02" id="hero_address_02" onclick="javascript:btnAddressGet();" class="w390" style="margin-top:5px;" /><br />
                        <input type="text" name="hero_address_03" id="hero_address_03" class="w390" style="margin-top:5px;" />
                    </td>
                </tr>
             
             
                <tr>
                    <th><span>*</span> AK Lover¸¦<br/>¾Ë°ÔµÈ °æ·Î´Â?</th>
                    <td>
                    	<p>
                        <input type="radio" name="area" value="¾øÀ½" checked="checked"/> &nbsp;¾øÀ½
                        <input type="radio" name="area" value="½Å¹®"/> &nbsp;½Å¹® 
                        <input type="radio" name="area" value="ÀâÁö"/> &nbsp;ÀâÁö 
                        <input type="radio" name="area" value="ºí·Î±×"/>&nbsp; ºí·Î±× 
                        <br/>
                        <input type="radio" name="area" value="±îÆä"/> &nbsp;Ä«Æä 
                        <input type="radio" name="area" value="ÆäÀÌ½ººÏ"/> &nbsp;ÆäÀÌ½ººÏ
                        <input type="radio" name="area" value="ÀÎ½ºÅ¸±×·¥"/> &nbsp;ÀÎ½ºÅ¸±×·¥ 
                        <input type="radio" name="area" value="ÁöÀÎ"/> &nbsp;ÁöÀÎ 
                        <br/>
                        <input type="radio" name="area" value="ÂÊÁö"/> &nbsp;ÂÊÁö 
                        <input type="radio" name="area" value="±âÅ¸"/> &nbsp;±âÅ¸ 
                        </p>
                        <p>±âÅ¸ <input type="text" name="area_etc_text" class="w390" maxlength="50" disabled="disabled"/></p>
                    </td>
                </tr>
                <tr>
                    <th class='notneed'>ÃßÃµÀÎ</th>
                    <td>
                        	ÃßÃµÀÎÀÇ ID ¶Ç´Â ´Ð³×ÀÓÀ» ³Ö¾îÁÖ¼¼¿ä.<br> * ¾ÆÀÌµð ¶Ç´Â ´Ð³×ÀÓÀ» Á¤È®ÇÏ°Ô ÀÌ·ÂÇØ¾ß ÃßÃµÀÎ¿¡°Ô Æ÷ÀÎÆ®°¡ Àû¸³µË´Ï´Ù.<br>
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
                    <th>°³ÀÎURL</th>
                    <td class='notneed'>
                    	<p>
                        <input type="radio" name="hero_qs_09" value="ÀÖ´Ù"/>ÀÖ´Ù 
			            <input type="radio" name="hero_qs_09" value="¾ø´Ù"  checked="checked"/>¾ø´Ù
                        </p>
                        <table class="tb_blog">
                        <col width="130" />
						<col width="*" />
                        	<tr style="border:none;">
                        		<td style="border:none; height:30px;">ºí·Î±× URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_00" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">ÆäÀÌ½ººÏ URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_01" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">Æ®À§ÅÍ URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_02" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">ÀÎ½ºÅ¸±×·¥ URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_04" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">Ä«Ä«¿À½ºÅä¸® URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_03" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">±×¿Ü SNS &nbsp;&nbsp; SNS ÀÌ¸§</td>
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
                	<th>ºí·Î±×¿î¿µ</th>
                    <td>
                    	<span class="tname" style="font-weight:bold;">¿î¿µÁßÀÎ ºí·Î±×°¡ ÀÖ³ª¿ä?</span>
                    	<p>
                        <input type="radio" name="hero_qs_10" value="ÀÖ´Ù"/>ÀÖ´Ù 
			            <input type="radio" name="hero_qs_10" value="¾ø´Ù"  checked="checked"/>¾ø´Ù
                        </p>
                        <br/>
                   	    <span class="tname" style="font-weight:bold;">ÀÏÁÖÀÏ¿¡ ÄÁÅÙÃ÷¸¦ Æò±Õ ¸î °³ ¾÷·Îµå ÇÏ½Ã³ª¿ä?</span>
                        <br/>
                        <input type="text" name="hero_qs_01" suOnly="true" style="width:200px;" class="blog_type"  maxlength="30" disabled="disabled"/>
                        <br/><br/>
                    	<span class="tname" style="font-weight:bold;">¿î¿µ ÁßÀÎ ºí·Î±×ÀÇ Æò±Õ ÀÏ ¹æ¹®ÀÚ´Â ¸î ¸íÀÎ°¡¿ä?</span>
			                        <br/>
			                        <input type="radio" name="hero_qs_02" value="200¸í" class="blog blog_type" disabled="disabled"/>200¸í ÀÌÇÏ
			                        <input type="radio" name="hero_qs_02" value="200~800¸í" class="blog blog_type" disabled="disabled"/>200~800¸í
			                        <input type="radio" name="hero_qs_02" value="801~1,500¸í" class="blog blog_type" disabled="disabled"/>801~1,500¸í
			                        <br/>
			                        <input type="radio" name="hero_qs_02" value="1,501~3,000¸í" class="blog blog_type" disabled="disabled"/>1,501~3,000¸í
			                        <input type="radio" name="hero_qs_02" value="3,001~4,000¸í" class="blog blog_type" disabled="disabled"/>3,001~4,000¸í
			                        <input type="radio" name="hero_qs_02" value="4,001~5,000¸í" class="blog blog_type" disabled="disabled"/>4,001~5,000¸í
                                    <br/>
			                        <input type="radio" name="hero_qs_02" value="5,001~10,000¸í" class="blog blog_type" disabled="disabled"/>5,001~10,000¸í
			                        <input type="radio" name="hero_qs_02" value="10,000¸í ÀÌ»ó" class="blog blog_type" disabled="disabled"/>10,000¸í ÀÌ»ó
			                        <br/><br/>
			                        <span class="tname" style="font-weight:bold;">ºí·Î±× Å¸ÀÔ(¡Ø Áßº¹ ¼±ÅÃ °¡´É)</span>
			                        <br>
			                        <input type="checkbox" name="hero_qs_03[]" value="ÆÐ¼Ç" class="blog blog_type2" disabled="disabled"/>ÆÐ¼Ç
			                        <input type="checkbox" name="hero_qs_03[]" value="ºäÆ¼" class="blog blog_type2" disabled="disabled"/>ºäÆ¼
			                        <input type="checkbox" name="hero_qs_03[]" value="¸ÀÁý" class="blog blog_type2" disabled="disabled"/>¸ÀÁý 
			                        <input type="checkbox" name="hero_qs_03[]" value="¸®ºä" class="blog blog_type2" disabled="disabled"/>¸®ºä 
			                        <input type="checkbox" name="hero_qs_03[]" value="ÀÏ»ó" class="blog blog_type2" disabled="disabled"/>ÀÏ»ó
                                    <br/>
			                        <input type="checkbox" name="hero_qs_03[]" value="À°¾Æ" class="blog blog_type2" disabled="disabled"/>À°¾Æ
                                    <input type="checkbox" name="hero_qs_03[]" value="¾Ö¿Ï" class="blog blog_type2" disabled="disabled"/>¾Ö¿Ï
                                    <input type="checkbox" name="hero_qs_03[]" value="°ø¿¬" class="blog blog_type2" disabled="disabled"/>°ø¿¬
                                    <input type="checkbox" name="hero_qs_03[]" value="Àü½Ã" class="blog blog_type2" disabled="disabled"/>Àü½Ã
                                    <input type="checkbox" name="hero_qs_03[]" value="À½¾Ç" class="blog blog_type2" disabled="disabled"/>À½¾Ç
			                        <br/>
			                        <input type="checkbox" name="hero_qs_03[]" value="¹æ¼Û" class="blog blog_type2" disabled="disabled"/>¹æ¼Û
                                    <input type="checkbox" name="hero_qs_03[]" value="¿¬¿¹" class="blog blog_type2" disabled="disabled"/>¿¬¿¹
                                    <input type="checkbox" name="hero_qs_03[]" value="°Ç°­" class="blog blog_type2" disabled="disabled"/>°Ç°­
                                    <input type="checkbox" name="hero_qs_03[]" value="IT" class="blog blog_type2" disabled="disabled"/>IT
                                    <input type="checkbox" name="hero_qs_03[]" value="±³À°" class="blog blog_type2" disabled="disabled"/>±³À°
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
                	<th>°áÈ¥À¯¹«</th>
                    <td>
                    	<input type="radio" name="hero_qs_04" value="¹ÌÈ¥" checked="checked"/>¹ÌÈ¥
                    	<input type="radio" name="hero_qs_04" value="±âÈ¥"/>±âÈ¥ 
			        </td>
                </tr>
                </table>
                <table class="member" style="margin-top:10px;">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr>
                	<th>ÀÚ³à¿¬·É</th>
                    <td>
                        <input type="radio" name="hero_qs_05" value="¾øÀ½" <?=$member_list["hero_qs_05"]=="¾øÀ½" ? "checked":"";?> checked="checked"/> ¾øÀ½
                   	 	<input type="radio" name="hero_qs_05" value="ÀÖÀ½" <?=$member_list["hero_qs_05"]=="ÀÖÀ½" ? "checked":"";?>/> ÀÖÀ½
                   	 	<script>
                   			$("input[name=hero_qs_05]").change(function() {
                       			
	                   	 		var hero_qs_05 = $(this).val();
	                   	 		if(hero_qs_05 == "¾øÀ½"){
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
                   	 	<div id="hero_qs_11_div" <?=$member_list["hero_qs_05"]=="¾øÀ½" ? "style='display:none;'":"";?> style='display:none';>
	                   	 	<input type="radio"  name="hero_qs_11" value="1¸í"  <?=$member_list["hero_qs_11"]=="1¸í" ? "checked":"";?>/> 1¸í
	                   	 	<input type="radio"  name="hero_qs_11" value="2¸í"  <?=$member_list["hero_qs_11"]=="2¸í" ? "checked":"";?>/> 2¸í
	                   	 	<input type="radio"  name="hero_qs_11" value="3¸í"  <?=$member_list["hero_qs_11"]=="3¸í" ? "checked":"";?>/> 3¸í
	                   	 	<input type="radio"  name="hero_qs_11" value="4¸í"  <?=$member_list["hero_qs_11"]=="4¸í" ? "checked":"";?>/> 4¸í
	                   	 	<input type="radio"  name="hero_qs_11" value="5¸í"  <?=$member_list["hero_qs_11"]=="5¸í" ? "checked":"";?>/> 5¸í
                   	 	</div>
                   	 	<script>
                   	 	$("input[name=hero_qs_11]").change(function() {
            				var hero_qs_11 = $(this).val();
            				var res = "";
            				var year = <?=date(Y)?>;
            				
            				hero_qs_11 = hero_qs_11.substring(0,1);
            				for(var i=0; i<hero_qs_11; i++){
                				res += "<select name='select_birth"+i+"' id='hero_qs_12_"+i+"'>";
                				res += "<option value=''>¼±ÅÃ</option>";
                				for(var j=year; j>=1900; j--){
                					res += "<option value='"+j+"'>"+j+"</option>";
                				}
                				res += "</select>";
                			}
            				$('#hero_qs_12_div').html(res); 
                		});
                   	 	</script>
                   	 	<div id="hero_qs_12_div" <?=$member_list["hero_qs_05"]=="¾øÀ½" ? "style='display:none;'":"";?>>
                   	 		<? 
                   	 		$res = "";
                   	 		$qs_11 = substr($member_list["hero_qs_11"],0,1);
                   	 		$qs_12 = explode(",", $member_list['hero_qs_12']);
                   	 		$year = date("Y");
                   	 		for($i=0; $i<$qs_11; $i++){
                   	 			$res .= "<select name='select_birth".$i."'>";
                   	 			$res .= "<option value=''>¼±ÅÃ</option>";
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
                	<th>AK¿¡ °¡ÀÔÇÑ ÀÌÀ¯</th>
                    <td><input type="text" name="hero_qs_06" class="w390" maxlength="100"/></td>
                </tr>
                <tr>
                	<th>¾Ö°æ ¿Ü È°µ¿ÇÏ´Â<br />¼­Æ÷ÅÍÁî</th>
                    <td><input type="radio" name="hero_qs_07" value="À¯" />À¯ <input type="radio" name="hero_qs_07" value="¹«" checked="checked"/>¹«<br/>
                    	<input type="text"  name="hero_qs_08" class="w390" maxlength="100" disabled="disabled"/>
                    </td>
                </tr>


            </table>
            
            <div class="btngroup tc">
                <input type="image" src="../image/member/btn_signup.gif" alt="È¸¿ø°¡ÀÔÇÏ±â" onclick="go_submit(document.form_next)"/>
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
			//alert("ÆäÀÌÁö ¼öÁ¤ ÁßÀÔ´Ï´Ù.");
			
			
			$("input[name=area]").on("click",function(){
				if($(this).val()=="±âÅ¸") {
					$("input[name=area_etc_text").attr("disabled",false);
				} else {
					$("input[name=area_etc_text").val("");
					$("input[name=area_etc_text").attr("disabled",true);
				}
			})
			
			//ºí·Î±×ÀÖ´Ù/¾ø´Ù
			$("input[name=hero_qs_09]").on("click",function(){
				if($(this).val()=="ÀÖ´Ù") {
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
			
			//ºí·Î±× ¿î¿µ
			$("input[name=hero_qs_10]").on("click",function(){
				if($(this).val()=="ÀÖ´Ù") {
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
				if($(this).val()=="À¯") {
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
					alert("ÇÊ¼ö µ¿ÀÇ »çÇ×ÀÔ´Ï´Ù");
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
				id_alert_area.html("4~20ÀÚ »ç¿ë°¡´É");
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
				nick_alert_area.html("´Ð³×ÀÓÀ» ÀÔ·ÂÇØ ÁÖ¼¼¿ä.");
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
				ch_hero_pw_01.innerHTML ="¿µ¹®, ¼ýÀÚ, Æ¯¼ö±âÈ£¸¦ Á¶ÇÕÇÏ¿© 8ÀÚ¸® ÀÌ»ó ÀÔ·ÂÇØÁÖ¼¼¿ä";
				obj.focus();
	        }else if(!chTextType.isEnNumOther(hero_pw_01.value)){
	        	ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
	        	ch_hero_pw_01.innerHTML ="¿µ¹®, ¼ýÀÚ, Æ¯¼ö±âÈ£¸¦ Á¶ÇÕÇÏ¿© ÁÖ¼¼¿ä";
	        	obj.focus();
	        }else{
	        	ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[1]?>";
	        	ch_hero_pw_01.innerHTML ="»ç¿ë °¡´ÉÇÑ ºñ¹Ð¹øÈ£ÀÔ´Ï´Ù";
	        }
	        if(hero_pw_02.value!=''){
				if(hero_pw_02.value!=hero_pw_01.value){
					ch_hero_pw_02.style.color="<?=$_MAIN_COLOR[0]?>";
		        	ch_hero_pw_02.innerHTML ="ºñ¹Ð¹øÈ£°¡ °°Áö ¾Ê½À´Ï´Ù";
		        	obj.focus();
				}else{
					ch_hero_pw_02.style.color="<?=$_MAIN_COLOR[1]?>";
		        	ch_hero_pw_02.innerHTML ="ºñ¹Ð¹øÈ£°¡ °°½À´Ï´Ù.";
				}
	        }
	        if(hero_hp_02.value!='' || hero_hp_03!=''){
		        if(hero_pw_01.value.indexOf(hero_hp_02.value)>0 || hero_pw_01.value.indexOf(hero_hp_03.value)>0){
		        	ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
		        	alert("ºñ¹Ð¹øÈ£¿¡´Â ÈÞ´ëÆù¹øÈ£¸¦ »ç¿ëÇÏ½Ç ¼ö ¾ø½À´Ï´Ù");
					ch_hero_pw_01.innerHTML ="ºñ¹Ð¹øÈ£¿¡´Â ÈÞ´ëÆù¹øÈ£¸¦ »ç¿ëÇÏ½Ç ¼ö ¾ø½À´Ï´Ù";
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
	            alert("ÀÌ¿ë¾à°ü¿¡ µ¿ÀÇÇÏ¼Å¾ß ÇÕ´Ï´Ù.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
            if(terms_02[0].checked==false){
            	var position = $(".signup_term_title").eq(2).offset();
                alert("¼öÁýÇÏ´Â °³ÀÎÁ¤º¸Ç×¸ñ ¹× ¼öÁý¹æ¹ý¿¡ µ¿ÀÇÇÏ¼Å¾ß ÇÕ´Ï´Ù.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
            if(terms_03[0].checked==false){
            	var position = $(".signup_term_title").eq(3).offset();
                alert("°³ÀÎÁ¤º¸ÀÇ ¼öÁý ¹× ÀÌ¿ë ¸ñÀû¿¡ µ¿ÀÇÇÏ¼Å¾ß ÇÕ´Ï´Ù.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
            if(terms_04[0].checked==false){
            	var position = $(".signup_term_title").eq(4).offset();
                alert("°³ÀÎÁ¤º¸ÀÇ º¸À¯ ¹× ÀÌ¿ë±â°£¿¡ µ¿ÀÇÇÏ¼Å¾ß ÇÕ´Ï´Ù.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
			if(terms_05[0].checked==false){
            	var position = $(".signup_term_title").eq(5).offset();
                alert("°³ÀÎÁ¤º¸ Ãë±ÞÀ§Å¹µ¿ÀÇ¿¡ µ¿ÀÇÇÏ¼Å¾ß ÇÕ´Ï´Ù.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
            
            
//##################################################################################################################################################//
            if(trim(id.value)==''){
                alert("¾ÆÀÌµð¸¦ ÀÔ·ÂÇØÁÖ¼¼¿ä");id.style.border = '1px solid red';id.focus();
                return false;
            }
            if(id_action.value == "hero_down"){
                alert("¾ÆÀÌµð¸¦ È®ÀÎÇØÁÖ¼¼¿ä");id.focus();
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

	            alert("ºñ¹Ð¹øÈ£¸¦ ÀÔ·ÂÇÏ¼¼¿ä");noText.style.border = '1px solid red';noText.focus();
    	        return false;
            }

            if(pw_01.value != pw_02.value){
                alert("ºñ¹Ð¹øÈ£°¡ °°Áö ¾Ê½À´Ï´Ù");pw_01.style.border = '1px solid red';pw_02.style.border = '1px solid red';pw_01.focus();
                return false;
            }
            
        	if (pw_01.value.length < 8) {
        		alert("ºñ¹Ð¹øÈ£´Â 8ÀÚ¸® ÀÌ»ó ÀÔ·ÂÇØÁÖ¼¼¿ä");
        		pw_01.style.border = '1px solid red';pw_01.focus();
        		return false;
        	}

        	if(!chTextType.isEnNumOther(pw_01.value)){
        		alert("ºñ¹Ð¹øÈ£´Â ¹®ÀÚ, ¼ýÀÚ, Æ¯¼ö¹®ÀÚÀÇ Á¶ÇÕÀ¸·Î ÀÔ·ÂÇØÁÖ¼¼¿ä");
        		pw_01.style.border = '1px solid red';pw_01.focus();
        	    return false;
        	}
            
//##################################################################################################################################################//
			if(trim(irum.value)==''){
                alert("ÀÌ¸§À» ÀÔ·ÂÇØÁÖ¼¼¿ä.");irum.style.border = '1px solid red';irum.focus();
                return false;
            }

            if(trim(nick.value)==''){
                alert("´Ð³×ÀÓÀ» ÀÔ·ÂÇØÁÖ¼¼¿ä");nick.style.border = '1px solid red';nick.focus();
                return false;
            }

            if(nick_action.value == "hero_down"){
                alert("´Ð³×ÀÓÀ» È®ÀÎÇØÁÖ¼¼¿ä");nick.focus();
                return false;
            } 
			
            if(ch_year=='<?=date("Y")?>'){
            	 alert("»ý³â¿ùÀÏÀ» ¼±ÅÃÇØÁÖ¼¼¿ä"); $("#year").focus();
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
                alert("ÀÌ¸ÞÀÏÀ» ÀÔ·ÂÇÏ¼¼¿ä.");noText.style.border = '1px solid red';noText.focus();
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
                alert("ÈÞ´ëÆù¹øÈ£¸¦ ÀÔ·ÂÇÏ¼¼¿ä.");noText.style.border = '1px solid red';mail_01;noText.focus();
                return false;
            }

            if(pw_01.value.indexOf(hp_02.value)>0 || pw_01.value.indexOf(hp_03.value)>0){
            	alert("ºñ¹Ð¹øÈ£¿¡´Â ÈÞ´ëÆù ¹øÈ£°¡ Æ÷ÇÔµÉ ¼ö ¾ø½À´Ï´Ù");
        		pw_01.style.border = '1px solid red';pw_01.focus();
        	    return false;
            }
//##################################################################################################################################################//
            if(address_01.value == ""){
                alert("¿ìÆí¹øÈ£¸¦ ÀÔ·ÂÇÏ¼¼¿ä.");address_01.style.border = '1px solid red';address_01.focus();
                return false;
            }
            if(address_02.value == ""){
                alert("ÁÖ¼Ò¸¦ ÀÔ·ÂÇÏ¼¼¿ä.");address_02.style.border = '1px solid red';address_02.focus();
                return false;
            }
            if(address_03.value == ""){
                alert("³ª¸ÓÁöÁÖ¼Ò¸¦ ÀÔ·ÂÇÏ¼¼¿ä.");address_03.style.border = '1px solid red';address_03.focus();
                return false;
            }
			
			if($("input[name=area]:checked").val() == "±âÅ¸") {
				if(!$("input[name=area_etc_text]").val()) {
					alert("Ak Lover¸¦ ¾Ë°ÔµÈ °æ·Î ±âÅ¸³»¿ëÀ» ÀÔ·ÂÇØ ÁÖ¼¼¿ä.");
					$("input[name=area_etc_text]").css("border","1px solid red");
					$("input[name=area_etc_text]").focus();
					return false;
				}
			}

//##################################################################################################################################################//
			chAge.setDate(ch_year,ch_month,ch_date);
			var age = chAge.countUniversalAge();
			if(age<15){
				alert("ÁË¼ÛÇÕ´Ï´Ù. ¸¸ 14¼¼ ¹Ì¸¸Àº °¡ÀÔÇÏ½Ç ¼ö ¾ø½À´Ï´Ù.");
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
				alert("º»ÀÎÀ» ÃßÃµÀÎÀ¸·Î ÃßÃµÇÒ ¼ö ¾ø½À´Ï´Ù.");
				return false;
			}
			
			jumin.value=ch_year+""+ch_month+""+ch_date;			




			//160701 ³ª¾Æ·Ð Ãß°¡Á¤º¸ÀÔ·Â ÀÌº¥Æ® (s)
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
			if(hero_qs_11 == "1¸í") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val());
				hero_qs_12 = form.hero_qs_12.value;
			} else if(hero_qs_11 == "2¸í") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val());
				hero_qs_12 = form.hero_qs_12.value;
			} else if(hero_qs_11 == "3¸í") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val()); 
				hero_qs_12 = form.hero_qs_12.value;
			} else if(hero_qs_11 == "4¸í") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val()+","+$("select[name=select_birth3]").val());
				hero_qs_12 = form.hero_qs_12.value;
			} else if(hero_qs_11 == "5¸í") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val()+","+$("select[name=select_birth3]").val()+","+$("select[name=select_birth4]").val());
				hero_qs_12 = form.hero_qs_12.value;
			}
			
			// ¸ðµç Á¤º¸ ÀÔ·ÂÇØ¾ß Æ÷ÀÎÆ® Áö±Þ Ã¼Å©
			if(hero_qs_10 == "ÀÖ´Ù"){
				if(hero_qs_05 == "ÀÖÀ½"){
					if(hero_qs_07 == "À¯"){
						if(hero_qs_09 != "" && hero_qs_01 != "" && hero_qs_02 != "" && hero_qs_03 > 0 && hero_qs_04 != "" && hero_qs_06 != "" && hero_qs_08 != "" && hero_qs_11 != "" && hero_qs_12 != ""){
							form.question_null_yn.value = "Y";
						}
					}else if(hero_qs_07 == "¹«"){
						if(hero_qs_09 != "" && hero_qs_01 != "" && hero_qs_02 != "" && hero_qs_03 > 0 && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != "" && hero_qs_11 != "" && hero_qs_12 != ""){
							form.question_null_yn.value = "Y";
						}
					}
				}else if(hero_qs_05 == "¾øÀ½"){
					if(hero_qs_07 == "À¯"){
						if(hero_qs_09 != "" && hero_qs_01 != "" && hero_qs_02 != "" && hero_qs_03 > 0 && hero_qs_04 != "" && hero_qs_06 != "" && hero_qs_08 != ""){
							form.question_null_yn.value = "Y";
						}
					}else if(hero_qs_07 == "¹«"){
						if(hero_qs_09 != "" && hero_qs_01 != "" && hero_qs_02 != "" && hero_qs_03 > 0 && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != ""){
							form.question_null_yn.value = "Y";
						}
					}
				}
			}else if(hero_qs_10 == "¾ø´Ù"){
				if(hero_qs_05 == "ÀÖÀ½"){
					if(hero_qs_07 == "À¯"){
						if(hero_qs_09 != "" && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != "" && hero_qs_08 != "" && hero_qs_11 != "" && hero_qs_12 != ""){
							form.question_null_yn.value = "Y";
						}
					}else if(hero_qs_07 == "¹«"){
						if(hero_qs_09 != "" && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != ""  && hero_qs_11 != "" && hero_qs_12 != ""){
							form.question_null_yn.value = "Y";
						}
					}
				}else if(hero_qs_05 == "¾øÀ½"){
					if(hero_qs_07 == "À¯"){
						if(hero_qs_09 != "" && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != "" && hero_qs_08 != ""){
							form.question_null_yn.value = "Y";
						}
					}else if(hero_qs_07 == "¹«"){
						if(hero_qs_09 != "" && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != ""){
							form.question_null_yn.value = "Y";
						}
					}
				}
				
			}
			//160701 ³ª¾Æ·Ð Ãß°¡Á¤º¸ÀÔ·Â ÀÌº¥Æ® (e)




            form.submit();
//##################################################################################################################################################//
            return true;
        }
    </script>
    