<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
if(!$_SESSION['temp_level'] || $_SESSION['temp_level']<9999){

	if((!$_POST['param_r6'] || !$_POST['param_r5']) && (!$_POST['snsId'] || !$_POST['snsType'])){
		error_historyBack("잘 못된 접근입니다.");
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
		error_location("이미 가입하셨습니다.","/main/index.php?board=findpw");
		exit;
	}
	
	//########### 휴면정보 체크 ##############
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
		error_location("해당 회원은 휴면 상태입니다.ID/PW찾기를 통해 로그인 하여 주십시오.","/main/index.php?board=findpw");
		exit;
	}
}

####################################################################################################################################################
//인증 가입시
if($_POST['param_r5'] && $_POST['param_r6'] && $_POST['param_r2']){
	$di = $_POST['param_r5'];
	$ci = $_POST['param_r6'];
	
	$param_r2_01 = substr($_POST['param_r2'], '0', '4');//년
	$param_r2_02 = substr($_POST['param_r2'], '4', '2');//월
	$param_r2_03 = substr($_POST['param_r2'], '6', '2');//일
	
	if(!$param_r2_01 || !$param_r2_02 || !$param_r2_03){
		error_location("시스템 오류입니다. 다시 시도해주세요","/main/index.php?board=idcheck");
		exit;
	}
	
	include_once $_SERVER['DOCUMENT_ROOT']."/classGathered/chAgeClass.php";
	$chAgeClass = new chAgeClass($param_r2_01,$param_r2_02,$param_r2_03);
	$age = $chAgeClass->countUniversalAge();
	if((int)$age<15){
		error_location("만14세 미만은 가입하실 수 없습니다.","/main/index.php");
		exit;
	}
	
	$readonly_auth = "readonly";
	$disabled_auth = "disabled='disabled'";
	$displaynone_auth = "style='display:none'";
//sns 가입시
}else{
	
	$snsId = $_POST['snsId'];
	$snsEmail = explode("@",$_POST['snsEmail']);
	$snsType = $_POST['snsType'];
	
	switch($snsType){
		case "facebook" : $snsText = "<img src='/image2/etc/snsBig01.jpg' alt='".$snsType."'> 회원님의 페이스북이 연동되었습니다";break;
		case "kakaoTalk" : $snsText = "<img src='/image2/etc/snsBig02.jpg' alt='".$snsType."'> 회원님의 카카오톡이 연동되었습니다";break;
		case "naver" : $snsText = "<img src='/image2/etc/snsBig03.jpg' alt='".$snsType."'> 회원님의 네이버 아이디가 연동되었습니다";break;
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
		$(document).on("keyup", "input:text[textOnly]", function() {$(this).val( $(this).val().replace(/[^ㄱ-ㅎㅏ-ㅣ가-힣a-zA-Z]/gi,"") );});
	});
	</script>
    <div class="contents_area">
        <div class="layer_zip">
            <form name="login_form" action="<?=PATH_HOME_HTTPS?>?board=result" onsubmit="return false;">
            <dl>
                <dt><img src="../image/member/zip1.gif" alt="우편번호 찾기" /></dt>
                <dd>
                <input id="addr" type="text" class="addr" /><input type="image" src="../image/member/btn_findzip.gif" alt="주소찾기" onclick="hero_ajax('zip.php', 'view_list', 'addr', 'zip'); return false;"/>
                </dd>
                <dd class="list">
                    <div id="view_list"></div>
                </dd>
                <dd class="tc"><a href="javascript:inputzip();"><img src="../image/member/btn_cancel.gif" alt="입력" /></a></dd>
            </dl>
            </form>
        </div>
        <div class="page_title">
            <h2><img src="../image/title/title_7_1.gif" alt="회원가입" /></h2>
            <ul class="nav">
                <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
                <li>&gt;</li>
                <li class="current">회원가입</li>
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
			<!-- 160701 나아론 추가정보기입 이벤트(s) -->
			<input type="hidden" name="question_null_yn" value="N">
			<!-- 160701 나아론 추가정보기입 이벤트(e) -->
			
            <p style="padding-bottom: 20px;"><?=$snsText?></p>
            
            <div class="signup_term">
	            <div class="signup_term_title">■ (필수) 이용 약관</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term1.php";?>
	            </div>
	            <div>※동의하지 않을 경우 회원가입이 되지 않습니다.<div class="signup_term_agree"><input type="radio" name="hero_terms_01" class="partAgree_btn" value='0'/>동의<input type="radio" class="partAgree_btn" name="hero_terms_01" value='1'/>동의안함</div></div>
	            
	            <div class="signup_term_title">■ (필수) 개인정보 취급방침</div>
	            <div class="signup_term_title ">수집하는 개인정보 항목 및 수집방법</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term4.html";?>
	            </div>
	            <div>※동의하지 않을 경우 회원가입이 되지 않습니다.<div class="signup_term_agree"><input type="radio" name="hero_terms_02" class="partAgree_btn" value='0'/>동의<input type="radio" class="partAgree_btn" name="hero_terms_02" value='1'/>동의안함</div></div>
	            
	            <div class="signup_term_title">(필수) 개인정보의 수집 및 이용 목적</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term5.html";?>
	            </div>
				<div>※동의하지 않을 경우 회원가입이 되지 않습니다.<div class="signup_term_agree"><input type="radio" name="hero_terms_03" class="partAgree_btn" value='0'/>동의<input type="radio" class="partAgree_btn" name="hero_terms_03" value='1'/>동의안함</div></div>
				
	            <div class="signup_term_title">(필수) 개인정보의 보유 및 이용기간</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term6.html";?>
	            	</div>
				<div>※동의하지 않을 경우 회원가입이 되지 않습니다.<div class="signup_term_agree"><input type="radio" name="hero_terms_04" class="partAgree_btn" value='0'/>동의<input type="radio" class="partAgree_btn" name="hero_terms_04" value='1'/>동의안함</div></div>
                <div class="signup_term_title">(필수) 개인정보 취급위탁동의</div>
	            <div style="border:2px solid #FDF1E1;margin-bottom:8px;overflow-x: hidden;overflow-y: auto;height: 150px;padding:20px;">
	            	<?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term7.html";?>
	            	</div>
				<div>※동의하지 않을 경우 회원가입이 되지 않습니다.<div class="signup_term_agree"><input type="radio" name="hero_terms_05" class="partAgree_btn" value='0'/>동의<input type="radio" class="partAgree_btn" name="hero_terms_05" value='1'/>동의안함</div></div>
            </div>
            
            
            <p class="member_alert"><span>*</span>는 필수 가입 항목입니다!!!</p>
            
            <table class="member">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr>
                    <th><span>*</span> 아이디</th>
                    <td>
                        <input type="text" name="hero_id" id="hero_id" style="ime-mode:disabled;" onfocusout="ch_id(this);" value=""/>
                        <span id="ch_id_text">4~20자 가능, 특수문자(!@#$%) 사용불가</span>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> 비밀번호</th>
                    <td><input type="password" name="hero_pw_01" id="hero_pw_01" onkeyup="chPwdTF(this);"/>&nbsp;&nbsp;<span id="ch_hero_pw_01">영문, 숫자, 특수기호를 조합하여 8자리 이상 입력해주세요</span></td>
                </tr>
                <tr>
                    <th><span>*</span> 비밀번호 확인</th>
                    <td><input type="password" name="hero_pw_02" id="hero_pw_02" onkeyup="chPwdTF(this);"/>&nbsp;&nbsp;<span id="ch_hero_pw_02"></span></td>
                </tr>
                <tr>
                    <th><span>*</span> 이름</th>
                    <td><input type="text" name="hero_name" value="<?=$_POST['param_r1']?>" <?=$readonly_auth?> /></td>
                </tr>
                <tr>
                    <th><span>*</span> 닉네임</th>
                    <td>
                        <input type="text" name="hero_nick" id="hero_nick_02" onkeyup="ch_nick(this);"/>
                        <span id="ch_nick_text"></span>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> 생년월일</th>
                    <td>
                        <select id="year" title="출생년도 선택" class="mr12" <?=$disabled_auth?>></select>
                        <select id="month" title="출생월 선택" class="mr12" <?=$disabled_auth?>></select>
                        <select id="date" title="출생일 선택" class="mr12" <?=$disabled_auth?>></select><br/>
                        <p>만 14세 미만은 회원가입이 불가합니다.<p>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> 이메일</th>
                    <td>
                        <input type="text" name="hero_mail_01" value="<?=$snsEmail[0]?>" style="ime-mode:disabled;" > @<br/>
                        <input type="text" id="hero_mail_02" name="hero_mail_02" value="<?=$snsEmail[1]?>" style="ime-mode:disabled;" >
                        <select id="email_select" onchange='emailChg();' class="short" >
                            <option value="">직접입력</option>
                            <option value="naver.com"<?if(!strcmp($hero_mail['1'], 'naver.com')){echo ' selected';}else{echo '';}?>>naver.com</option>
                            <option value="hanmail.net"<?if(!strcmp($hero_mail['1'], 'hanmail.net')){echo ' selected';}else{echo '';}?>>hanmail.net</option>
                            <option value="daum.net"<?if(!strcmp($hero_mail['1'], 'daum.net')){echo ' selected';}else{echo '';}?>>daum.net</option>
                            <option value="gmail.com"<?if(!strcmp($hero_mail['1'], 'gmail.com')){echo ' selected';}else{echo '';}?>>gmail.com</option>
                            <option value="hotmail.com"<?if(!strcmp($hero_mail['1'], 'hotmail.com')){echo ' selected';}else{echo '';}?>>hotmail.com</option>
                            <option value="paran.com"<?if(!strcmp($hero_mail['1'], 'paran.com')){echo ' selected';}else{echo '';}?>>paran.com</option>
                            <option value="nate.com"<?if(!strcmp($hero_mail['1'], 'nate.com')){echo ' selected';}else{echo '';}?>>nate.com</option>
                         </select>

                         <p style="height:25px;">이메일 수신&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="hero_chk_email" value='1' style='width:13px;' checked="checked">동의
							<input type="radio" name="hero_chk_email" value='0' style='width:13px;'>동의안함
						</p>
						<p>수신에 동의하시면 각종 미션/이벤트를 확인하실 수 있습니다.</p>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> 휴대폰</th>
                    <td>
                        <input type="text" name="hero_hp_01" id="hero_hp_01" style="width:125px;" onkeyup="if(this.value.length > 2)hero_hp_02.focus();" maxlength="3" suOnly="true"/>
                        <input type="text" name="hero_hp_02" id="hero_hp_02" style="width:125px;" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" suOnly="true"/>
                        <input type="text" name="hero_hp_03" id="hero_hp_03" style="width:125px;" onkeyup="if(this.value.length > 3)chPwdTF(this);" maxlength="4" suOnly="true"/>
						
						<p style="height:25px;">
							<span>SMS 수신&nbsp;&nbsp;&nbsp;&nbsp;</span>
							<input type="radio" name="hero_chk_phone" value='1' style='width:13px;' checked="checked">동의
							<input type="radio" name="hero_chk_phone" value='0' style='width:13px;'>동의안함<br>
						</p>
						<p>수신에 동의하시면 각종 미션/이벤트정보를 받아 보실 수 있습니다.</p>
                    </td>
                </tr>
                <tr>
                    <th><span>*</span> 주소</th>
                    <td>
                        <input type="text" name="hero_address_01" id="hero_address_01" onclick="javascript:btnAddressGet();" class="w190" />
                        <a href="javascript:btnAddressGet()"><img src="../image/member/btn_zipcode.gif" alt="우편번호찾기" /></a><br />
                        <input type="text" name="hero_address_02" id="hero_address_02" onclick="javascript:btnAddressGet();" class="w390" style="margin-top:5px;" /><br />
                        <input type="text" name="hero_address_03" id="hero_address_03" class="w390" style="margin-top:5px;" />
                    </td>
                </tr>
             
             
                <tr>
                    <th><span>*</span> AK Lover를<br/>알게된 경로는?</th>
                    <td>
                    	<p>
                        <input type="radio" name="area" value="없음" checked="checked"/> &nbsp;없음
                        <input type="radio" name="area" value="신문"/> &nbsp;신문 
                        <input type="radio" name="area" value="잡지"/> &nbsp;잡지 
                        <input type="radio" name="area" value="블로그"/>&nbsp; 블로그 
                        <br/>
                        <input type="radio" name="area" value="까페"/> &nbsp;카페 
                        <input type="radio" name="area" value="페이스북"/> &nbsp;페이스북
                        <input type="radio" name="area" value="인스타그램"/> &nbsp;인스타그램 
                        <input type="radio" name="area" value="지인"/> &nbsp;지인 
                        <br/>
                        <input type="radio" name="area" value="쪽지"/> &nbsp;쪽지 
                        <input type="radio" name="area" value="기타"/> &nbsp;기타 
                        </p>
                        <p>기타 <input type="text" name="area_etc_text" class="w390" maxlength="50" disabled="disabled"/></p>
                    </td>
                </tr>
                <tr>
                    <th class='notneed'>추천인</th>
                    <td>
                        	추천인의 ID 또는 닉네임을 넣어주세요.<br> * 아이디 또는 닉네임을 정확하게 이력해야 추천인에게 포인트가 적립됩니다.<br>
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
                    <th>개인URL</th>
                    <td class='notneed'>
                    	<p>
                        <input type="radio" name="hero_qs_09" value="있다"/>있다 
			            <input type="radio" name="hero_qs_09" value="없다"  checked="checked"/>없다
                        </p>
                        <table class="tb_blog">
                        <col width="130" />
						<col width="*" />
                        	<tr style="border:none;">
                        		<td style="border:none; height:30px;">블로그 URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_00" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">페이스북 URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_01" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">트위터 URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_02" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">인스타그램 URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_04" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">카카오스토리 URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_03" class="w390" disabled="disabled"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">그외 SNS &nbsp;&nbsp; SNS 이름</td>
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
                	<th>블로그운영</th>
                    <td>
                    	<span class="tname" style="font-weight:bold;">운영중인 블로그가 있나요?</span>
                    	<p>
                        <input type="radio" name="hero_qs_10" value="있다"/>있다 
			            <input type="radio" name="hero_qs_10" value="없다"  checked="checked"/>없다
                        </p>
                        <br/>
                   	    <span class="tname" style="font-weight:bold;">일주일에 컨텐츠를 평균 몇 개 업로드 하시나요?</span>
                        <br/>
                        <input type="text" name="hero_qs_01" suOnly="true" style="width:200px;" class="blog_type"  maxlength="30" disabled="disabled"/>
                        <br/><br/>
                    	<span class="tname" style="font-weight:bold;">운영 중인 블로그의 평균 일 방문자는 몇 명인가요?</span>
			                        <br/>
			                        <input type="radio" name="hero_qs_02" value="200명" class="blog blog_type" disabled="disabled"/>200명 이하
			                        <input type="radio" name="hero_qs_02" value="200~800명" class="blog blog_type" disabled="disabled"/>200~800명
			                        <input type="radio" name="hero_qs_02" value="801~1,500명" class="blog blog_type" disabled="disabled"/>801~1,500명
			                        <br/>
			                        <input type="radio" name="hero_qs_02" value="1,501~3,000명" class="blog blog_type" disabled="disabled"/>1,501~3,000명
			                        <input type="radio" name="hero_qs_02" value="3,001~4,000명" class="blog blog_type" disabled="disabled"/>3,001~4,000명
			                        <input type="radio" name="hero_qs_02" value="4,001~5,000명" class="blog blog_type" disabled="disabled"/>4,001~5,000명
                                    <br/>
			                        <input type="radio" name="hero_qs_02" value="5,001~10,000명" class="blog blog_type" disabled="disabled"/>5,001~10,000명
			                        <input type="radio" name="hero_qs_02" value="10,000명 이상" class="blog blog_type" disabled="disabled"/>10,000명 이상
			                        <br/><br/>
			                        <span class="tname" style="font-weight:bold;">블로그 타입(※ 중복 선택 가능)</span>
			                        <br>
			                        <input type="checkbox" name="hero_qs_03[]" value="패션" class="blog blog_type2" disabled="disabled"/>패션
			                        <input type="checkbox" name="hero_qs_03[]" value="뷰티" class="blog blog_type2" disabled="disabled"/>뷰티
			                        <input type="checkbox" name="hero_qs_03[]" value="맛집" class="blog blog_type2" disabled="disabled"/>맛집 
			                        <input type="checkbox" name="hero_qs_03[]" value="리뷰" class="blog blog_type2" disabled="disabled"/>리뷰 
			                        <input type="checkbox" name="hero_qs_03[]" value="일상" class="blog blog_type2" disabled="disabled"/>일상
                                    <br/>
			                        <input type="checkbox" name="hero_qs_03[]" value="육아" class="blog blog_type2" disabled="disabled"/>육아
                                    <input type="checkbox" name="hero_qs_03[]" value="애완" class="blog blog_type2" disabled="disabled"/>애완
                                    <input type="checkbox" name="hero_qs_03[]" value="공연" class="blog blog_type2" disabled="disabled"/>공연
                                    <input type="checkbox" name="hero_qs_03[]" value="전시" class="blog blog_type2" disabled="disabled"/>전시
                                    <input type="checkbox" name="hero_qs_03[]" value="음악" class="blog blog_type2" disabled="disabled"/>음악
			                        <br/>
			                        <input type="checkbox" name="hero_qs_03[]" value="방송" class="blog blog_type2" disabled="disabled"/>방송
                                    <input type="checkbox" name="hero_qs_03[]" value="연예" class="blog blog_type2" disabled="disabled"/>연예
                                    <input type="checkbox" name="hero_qs_03[]" value="건강" class="blog blog_type2" disabled="disabled"/>건강
                                    <input type="checkbox" name="hero_qs_03[]" value="IT" class="blog blog_type2" disabled="disabled"/>IT
                                    <input type="checkbox" name="hero_qs_03[]" value="교육" class="blog blog_type2" disabled="disabled"/>교육
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
                	<th>결혼유무</th>
                    <td>
                    	<input type="radio" name="hero_qs_04" value="미혼" checked="checked"/>미혼
                    	<input type="radio" name="hero_qs_04" value="기혼"/>기혼 
			        </td>
                </tr>
                </table>
                <table class="member" style="margin-top:10px;">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr>
                	<th>자녀연령</th>
                    <td>
                        <input type="radio" name="hero_qs_05" value="없음" <?=$member_list["hero_qs_05"]=="없음" ? "checked":"";?> checked="checked"/> 없음
                   	 	<input type="radio" name="hero_qs_05" value="있음" <?=$member_list["hero_qs_05"]=="있음" ? "checked":"";?>/> 있음
                   	 	<script>
                   			$("input[name=hero_qs_05]").change(function() {
                       			
	                   	 		var hero_qs_05 = $(this).val();
	                   	 		if(hero_qs_05 == "없음"){
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
                   	 	<div id="hero_qs_11_div" <?=$member_list["hero_qs_05"]=="없음" ? "style='display:none;'":"";?> style='display:none';>
	                   	 	<input type="radio"  name="hero_qs_11" value="1명"  <?=$member_list["hero_qs_11"]=="1명" ? "checked":"";?>/> 1명
	                   	 	<input type="radio"  name="hero_qs_11" value="2명"  <?=$member_list["hero_qs_11"]=="2명" ? "checked":"";?>/> 2명
	                   	 	<input type="radio"  name="hero_qs_11" value="3명"  <?=$member_list["hero_qs_11"]=="3명" ? "checked":"";?>/> 3명
	                   	 	<input type="radio"  name="hero_qs_11" value="4명"  <?=$member_list["hero_qs_11"]=="4명" ? "checked":"";?>/> 4명
	                   	 	<input type="radio"  name="hero_qs_11" value="5명"  <?=$member_list["hero_qs_11"]=="5명" ? "checked":"";?>/> 5명
                   	 	</div>
                   	 	<script>
                   	 	$("input[name=hero_qs_11]").change(function() {
            				var hero_qs_11 = $(this).val();
            				var res = "";
            				var year = <?=date(Y)?>;
            				
            				hero_qs_11 = hero_qs_11.substring(0,1);
            				for(var i=0; i<hero_qs_11; i++){
                				res += "<select name='select_birth"+i+"' id='hero_qs_12_"+i+"'>";
                				res += "<option value=''>선택</option>";
                				for(var j=year; j>=1900; j--){
                					res += "<option value='"+j+"'>"+j+"</option>";
                				}
                				res += "</select>";
                			}
            				$('#hero_qs_12_div').html(res); 
                		});
                   	 	</script>
                   	 	<div id="hero_qs_12_div" <?=$member_list["hero_qs_05"]=="없음" ? "style='display:none;'":"";?>>
                   	 		<? 
                   	 		$res = "";
                   	 		$qs_11 = substr($member_list["hero_qs_11"],0,1);
                   	 		$qs_12 = explode(",", $member_list['hero_qs_12']);
                   	 		$year = date("Y");
                   	 		for($i=0; $i<$qs_11; $i++){
                   	 			$res .= "<select name='select_birth".$i."'>";
                   	 			$res .= "<option value=''>선택</option>";
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
                	<th>AK에 가입한 이유</th>
                    <td><input type="text" name="hero_qs_06" class="w390" maxlength="100"/></td>
                </tr>
                <tr>
                	<th>애경 외 활동하는<br />서포터즈</th>
                    <td><input type="radio" name="hero_qs_07" value="유" />유 <input type="radio" name="hero_qs_07" value="무" checked="checked"/>무<br/>
                    	<input type="text"  name="hero_qs_08" class="w390" maxlength="100" disabled="disabled"/>
                    </td>
                </tr>


            </table>
            
            <div class="btngroup tc">
                <input type="image" src="../image/member/btn_signup.gif" alt="회원가입하기" onclick="go_submit(document.form_next)"/>
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
			//alert("페이지 수정 중입니다.");
			
			
			$("input[name=area]").on("click",function(){
				if($(this).val()=="기타") {
					$("input[name=area_etc_text").attr("disabled",false);
				} else {
					$("input[name=area_etc_text").val("");
					$("input[name=area_etc_text").attr("disabled",true);
				}
			})
			
			//블로그있다/없다
			$("input[name=hero_qs_09]").on("click",function(){
				if($(this).val()=="있다") {
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
			
			//블로그 운영
			$("input[name=hero_qs_10]").on("click",function(){
				if($(this).val()=="있다") {
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
				if($(this).val()=="유") {
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
					alert("필수 동의 사항입니다");
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
				id_alert_area.html("4~20자 사용가능");
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
				nick_alert_area.html("닉네임을 입력해 주세요.");
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
				ch_hero_pw_01.innerHTML ="영문, 숫자, 특수기호를 조합하여 8자리 이상 입력해주세요";
				obj.focus();
	        }else if(!chTextType.isEnNumOther(hero_pw_01.value)){
	        	ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
	        	ch_hero_pw_01.innerHTML ="영문, 숫자, 특수기호를 조합하여 주세요";
	        	obj.focus();
	        }else{
	        	ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[1]?>";
	        	ch_hero_pw_01.innerHTML ="사용 가능한 비밀번호입니다";
	        }
	        if(hero_pw_02.value!=''){
				if(hero_pw_02.value!=hero_pw_01.value){
					ch_hero_pw_02.style.color="<?=$_MAIN_COLOR[0]?>";
		        	ch_hero_pw_02.innerHTML ="비밀번호가 같지 않습니다";
		        	obj.focus();
				}else{
					ch_hero_pw_02.style.color="<?=$_MAIN_COLOR[1]?>";
		        	ch_hero_pw_02.innerHTML ="비밀번호가 같습니다.";
				}
	        }
	        if(hero_hp_02.value!='' || hero_hp_03!=''){
		        if(hero_pw_01.value.indexOf(hero_hp_02.value)>0 || hero_pw_01.value.indexOf(hero_hp_03.value)>0){
		        	ch_hero_pw_01.style.color="<?=$_MAIN_COLOR[0]?>";
		        	alert("비밀번호에는 휴대폰번호를 사용하실 수 없습니다");
					ch_hero_pw_01.innerHTML ="비밀번호에는 휴대폰번호를 사용하실 수 없습니다";
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
	            alert("이용약관에 동의하셔야 합니다.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
            if(terms_02[0].checked==false){
            	var position = $(".signup_term_title").eq(2).offset();
                alert("수집하는 개인정보항목 및 수집방법에 동의하셔야 합니다.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
            if(terms_03[0].checked==false){
            	var position = $(".signup_term_title").eq(3).offset();
                alert("개인정보의 수집 및 이용 목적에 동의하셔야 합니다.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
            if(terms_04[0].checked==false){
            	var position = $(".signup_term_title").eq(4).offset();
                alert("개인정보의 보유 및 이용기간에 동의하셔야 합니다.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
			if(terms_05[0].checked==false){
            	var position = $(".signup_term_title").eq(5).offset();
                alert("개인정보 취급위탁동의에 동의하셔야 합니다.");
                $('html, body').animate({scrollTop : position.top}, 100);
                return false;
            }
            
            
//##################################################################################################################################################//
            if(trim(id.value)==''){
                alert("아이디를 입력해주세요");id.style.border = '1px solid red';id.focus();
                return false;
            }
            if(id_action.value == "hero_down"){
                alert("아이디를 확인해주세요");id.focus();
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

	            alert("비밀번호를 입력하세요");noText.style.border = '1px solid red';noText.focus();
    	        return false;
            }

            if(pw_01.value != pw_02.value){
                alert("비밀번호가 같지 않습니다");pw_01.style.border = '1px solid red';pw_02.style.border = '1px solid red';pw_01.focus();
                return false;
            }
            
        	if (pw_01.value.length < 8) {
        		alert("비밀번호는 8자리 이상 입력해주세요");
        		pw_01.style.border = '1px solid red';pw_01.focus();
        		return false;
        	}

        	if(!chTextType.isEnNumOther(pw_01.value)){
        		alert("비밀번호는 문자, 숫자, 특수문자의 조합으로 입력해주세요");
        		pw_01.style.border = '1px solid red';pw_01.focus();
        	    return false;
        	}
            
//##################################################################################################################################################//
			if(trim(irum.value)==''){
                alert("이름을 입력해주세요.");irum.style.border = '1px solid red';irum.focus();
                return false;
            }

            if(trim(nick.value)==''){
                alert("닉네임을 입력해주세요");nick.style.border = '1px solid red';nick.focus();
                return false;
            }

            if(nick_action.value == "hero_down"){
                alert("닉네임을 확인해주세요");nick.focus();
                return false;
            } 
			
            if(ch_year=='<?=date("Y")?>'){
            	 alert("생년월일을 선택해주세요"); $("#year").focus();
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
                alert("이메일을 입력하세요.");noText.style.border = '1px solid red';noText.focus();
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
                alert("휴대폰번호를 입력하세요.");noText.style.border = '1px solid red';mail_01;noText.focus();
                return false;
            }

            if(pw_01.value.indexOf(hp_02.value)>0 || pw_01.value.indexOf(hp_03.value)>0){
            	alert("비밀번호에는 휴대폰 번호가 포함될 수 없습니다");
        		pw_01.style.border = '1px solid red';pw_01.focus();
        	    return false;
            }
//##################################################################################################################################################//
            if(address_01.value == ""){
                alert("우편번호를 입력하세요.");address_01.style.border = '1px solid red';address_01.focus();
                return false;
            }
            if(address_02.value == ""){
                alert("주소를 입력하세요.");address_02.style.border = '1px solid red';address_02.focus();
                return false;
            }
            if(address_03.value == ""){
                alert("나머지주소를 입력하세요.");address_03.style.border = '1px solid red';address_03.focus();
                return false;
            }
			
			if($("input[name=area]:checked").val() == "기타") {
				if(!$("input[name=area_etc_text]").val()) {
					alert("Ak Lover를 알게된 경로 기타내용을 입력해 주세요.");
					$("input[name=area_etc_text]").css("border","1px solid red");
					$("input[name=area_etc_text]").focus();
					return false;
				}
			}

//##################################################################################################################################################//
			chAge.setDate(ch_year,ch_month,ch_date);
			var age = chAge.countUniversalAge();
			if(age<15){
				alert("죄송합니다. 만 14세 미만은 가입하실 수 없습니다.");
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
				alert("본인을 추천인으로 추천할 수 없습니다.");
				return false;
			}
			
			jumin.value=ch_year+""+ch_month+""+ch_date;			




			//160701 나아론 추가정보입력 이벤트 (s)
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
			if(hero_qs_11 == "1명") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val());
				hero_qs_12 = form.hero_qs_12.value;
			} else if(hero_qs_11 == "2명") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val());
				hero_qs_12 = form.hero_qs_12.value;
			} else if(hero_qs_11 == "3명") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val()); 
				hero_qs_12 = form.hero_qs_12.value;
			} else if(hero_qs_11 == "4명") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val()+","+$("select[name=select_birth3]").val());
				hero_qs_12 = form.hero_qs_12.value;
			} else if(hero_qs_11 == "5명") {
				$('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val()+","+$("select[name=select_birth3]").val()+","+$("select[name=select_birth4]").val());
				hero_qs_12 = form.hero_qs_12.value;
			}
			
			// 모든 정보 입력해야 포인트 지급 체크
			if(hero_qs_10 == "있다"){
				if(hero_qs_05 == "있음"){
					if(hero_qs_07 == "유"){
						if(hero_qs_09 != "" && hero_qs_01 != "" && hero_qs_02 != "" && hero_qs_03 > 0 && hero_qs_04 != "" && hero_qs_06 != "" && hero_qs_08 != "" && hero_qs_11 != "" && hero_qs_12 != ""){
							form.question_null_yn.value = "Y";
						}
					}else if(hero_qs_07 == "무"){
						if(hero_qs_09 != "" && hero_qs_01 != "" && hero_qs_02 != "" && hero_qs_03 > 0 && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != "" && hero_qs_11 != "" && hero_qs_12 != ""){
							form.question_null_yn.value = "Y";
						}
					}
				}else if(hero_qs_05 == "없음"){
					if(hero_qs_07 == "유"){
						if(hero_qs_09 != "" && hero_qs_01 != "" && hero_qs_02 != "" && hero_qs_03 > 0 && hero_qs_04 != "" && hero_qs_06 != "" && hero_qs_08 != ""){
							form.question_null_yn.value = "Y";
						}
					}else if(hero_qs_07 == "무"){
						if(hero_qs_09 != "" && hero_qs_01 != "" && hero_qs_02 != "" && hero_qs_03 > 0 && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != ""){
							form.question_null_yn.value = "Y";
						}
					}
				}
			}else if(hero_qs_10 == "없다"){
				if(hero_qs_05 == "있음"){
					if(hero_qs_07 == "유"){
						if(hero_qs_09 != "" && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != "" && hero_qs_08 != "" && hero_qs_11 != "" && hero_qs_12 != ""){
							form.question_null_yn.value = "Y";
						}
					}else if(hero_qs_07 == "무"){
						if(hero_qs_09 != "" && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != ""  && hero_qs_11 != "" && hero_qs_12 != ""){
							form.question_null_yn.value = "Y";
						}
					}
				}else if(hero_qs_05 == "없음"){
					if(hero_qs_07 == "유"){
						if(hero_qs_09 != "" && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != "" && hero_qs_08 != ""){
							form.question_null_yn.value = "Y";
						}
					}else if(hero_qs_07 == "무"){
						if(hero_qs_09 != "" && hero_qs_04 != "" && hero_qs_05 != "" && hero_qs_06 != ""){
							form.question_null_yn.value = "Y";
						}
					}
				}
				
			}
			//160701 나아론 추가정보입력 이벤트 (e)




            form.submit();
//##################################################################################################################################################//
            return true;
        }
    </script>
    