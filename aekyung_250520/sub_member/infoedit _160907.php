<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION['temp_code']){
	error_location("잘 못된 접근입니다.","/main/index.php?board=idcheck");
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
	$member_list["hero_qs_10"] = "있다";
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

// 160701 나아론 추가정보기입 이벤트 (s)
$memberQuestion_sql = "SELECT hero_idx, hero_pid, hero_code, hero_qs_01, hero_qs_02, hero_qs_03, hero_qs_04, hero_qs_05, hero_qs_06, hero_qs_07, hero_qs_08, ";
$memberQuestion_sql .= "hero_qs_09, hero_qs_10, hero_qs_11, hero_qs_12, hero_qs_13, hero_qs_14, hero_qs_15, hero_qs_16, hero_qs_17, hero_qs_18, hero_qs_19, hero_qs_20, ";
$memberQuestion_sql .= "hero_qs_21, hero_qs_22, hero_qs_23, hero_qs_24, hero_qs_25, hero_qs_26, hero_qs_27, hero_qs_28, hero_qs_29, hero_qs_30, hero_today, "; 
$memberQuestion_sql .= "left(hero_modi_today,4) as hero_modi_today, left(hero_give_point_today,4) as hero_give_point_today ";
$memberQuestion_sql .= "FROM member_question WHERE hero_code='".$_SESSION['temp_code']."' and hero_pid='3'";
$memberQuestion_res = new_sql($memberQuestion_sql,"on");
$memberQuestion_list = mysql_fetch_assoc($memberQuestion_res);

$today = date("Y");

$alertScriptAll = "<script>alert('추가정보를 모두 입력하시면 30포인트를 드립니다.');</script>";
$alertScriptModi = "<script>alert('추가정보를 수정하시면 30포인트를 드립니다.');</script>";
if($memberQuestion_list['hero_code'] == ""){ //추가기입있는지 확인
	echo $alertScriptAll;
	$question_point_yn ="Y";
}else if($memberQuestion_list['hero_give_point_today'] != $today && ($memberQuestion_list['hero_give_point_today'] == "" || $memberQuestion_list['hero_give_point_today'] == "0000")){ //1년 주기 체크
	//if($memberQuestion_list['hero_modi_today'] != $today){
		echo $alertScriptModi;
		$question_point_yn ="Y";
	//}
}else{
	if($memberQuestion_list['hero_give_point_today'] != $today){ //악용막기위해 한번 더 날짜 체크
		if($memberQuestion_list['hero_qs_10'] == "있다"){
			if($memberQuestion_list['hero_qs_01'] == "" || $memberQuestion_list['hero_qs_02'] == "" || $memberQuestion_list['hero_qs_03'] == ""){
				echo $alertScriptAll;
				$question_point_yn = "Y";
			}
		}else if($memberQuestion_list['hero_qs_10'] == ""){
			echo $alertScriptAll;
			$question_point_yn = "Y";
			
		}else if($memberQuestion_list['hero_qs_05'] == "있음"){
			if($memberQuestion_list['hero_qs_11'] == "" || $memberQuestion_list['hero_qs_12'] == ""){
				echo $alertScriptAll;
				$question_point_yn = "Y";
			}
		}else if($memberQuestion_list['hero_qs_05'] == ""){
			echo $alertScriptAll;
			$question_point_yn = "Y";
			
		}else if($memberQuestion_list['hero_qs_07'] == "유"){
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
// 160701 나아론 추가정보기입 이벤트 (e)

?>
    <div class="contents">
    	
    	<form name="form_next" action="<?=PATH_HOME_HTTPS?>?board=update" enctype="multipart/form-data" method="post" onsubmit="return go_submit(this);">
            <input type="hidden" name="hero_idx" value="<?=$member_list['hero_idx']?>">
            <input type="hidden" name="hero_today_plus" value="<?=Ymdhis?>">
            <input type="hidden" name="hero_login_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
            <!-- 160701 나아론 추가정보기입 이벤트(s) -->
			<input type="hidden" name="question_null_yn" value="N">
			<input type="hidden" name="question_point_yn" value="<?=$question_point_yn?>">
			<!-- 160701 나아론 추가정보기입 이벤트(e) -->
			

			<div id="infoEditSns">
							<div style="padding-top: 16px;">로그인 연동하기</div>
							<img src="/image2/etc/line.png"/>
							<div class="info_sns <?=$ch_facebook?>" onclick="<?=$ch_facebook_onclick?>"><img src="/image2/etc/sns01<?=$ch_facebook_class?>.jpg" alt="페이스북" border="0" style="vertical-align:middle;">페이스북</div>
							<div class="info_sns <?=$ch_kakao?>" onclick="<?=$ch_kakako_onclick?>"><img src="/image2/etc/sns02<?=$ch_kakao_class?>.jpg" alt="카카오톡" border="0" style="vertical-align:middle;" >카카오톡</div>
							<div class="info_sns <?=$ch_naver?>" onclick="<?=$ch_naver_onclick?>;"><img src="/image2/etc/sns03<?=$ch_naver_class?>.jpg" alt="네이버" border="0" style="vertical-align:middle;">네이버</div>
						</div>
			
			<p class="member_alert"><span style="color:#f68428">*</span>는 필수 입력 항목입니다!!!</p>
			
            <table class="member">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr class="first">
                    <th><span>*</span> 아이디</th>
                    <td><span class="c_brown bold"><?=$member_list['hero_id']?></span></td>
                </tr>
                <tr>
                    <th><span>*</span> 이름</th>
                    <td><span class="c_brown bold"><?=$member_list['hero_name']?></span></td>
                </tr>
                <tr>
                    <th><span>*</span> 닉네임</th>
                    <td><span class="c_brown bold"><?=$member_list['hero_nick']?></span> <span class="notification">* 닉네임 변경시 관리자에게 1:1문의로 요청하세요</span></td>
                </tr>
                <tr>
                    <th><span>*</span> 생년월일</th>
                    <td><span class="c_brown bold"><?=substr($member_list['hero_jumin'], '0', '4');?>년 <?=substr($member_list['hero_jumin'], '4', '2');?>월 <?=substr($member_list['hero_jumin'], '6', '2');?>일</span><!-- (만 <span class="c_brown bold">17</span>세)--></td>
                </tr>
                <tr>
                    <th><span>*</span> 이메일</th>
                    <td>
                        <input type="text" name="hero_mail_01" value="<?=$hero_mail['0'];?>" style="ime-mode:disabled;"/> @<br/>
                        <input type="text" name="hero_mail_02" value="<?=$hero_mail['1'];?>" style="ime-mode:disabled;"/>
                        <select id="email_select" onchange='javascript:emailChg();' class="short">
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
                         	
							<input type="radio" name="hero_chk_email" value='1' <?php echo ($member_list['hero_chk_email']==1 || $member_list['hero_chk_email']==2)? "checked='checked'" : "";?> style='width:13px;' checked="checked">동의
							<input type="radio" name="hero_chk_email" value='0' <?php echo ($member_list['hero_chk_email']==0)? "checked='checked'" : "";?> style='width:13px;'>동의안함
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
                    <th><span>*</span> 핸드폰</th>
                    <td>
                        <input type="text" name="hero_hp_01" id="hero_hp_01" value="<?=substr($next, '0', '3');?>" onKeyUp="if(this.value.length >= 3)hero_hp_02.focus();" maxlength="3" style="ime-mode:disabled;" class="short"/>
                        <input type="text" name="hero_hp_02" id="hero_hp_02" value="<?=substr($next, '3', '4');?>" onKeyUp="if(this.value.length >= 4)hero_hp_03.focus();" maxlength="4" style="ime-mode:disabled;" class="short"/>
                        <input type="text" name="hero_hp_03" id="hero_hp_03" value="<?=substr($next, '7', '4');?>" maxlength="4" style="ime-mode:disabled;" class="short"/>
                        <p style="height:25px;">
							<span>SMS 수신&nbsp;&nbsp;&nbsp;&nbsp;</span>
							<input type="radio" name="hero_chk_phone" value='1' <?php echo ($member_list['hero_chk_phone']==1)? "checked='checked'" : "";?> style='width:13px;' checked="checked">동의
							<input type="radio" name="hero_chk_phone" value='0' <?php echo ($member_list['hero_chk_phone']==0)? "checked='checked'" : "";?> style='width:13px;'>동의안함<br>
						</p>
                    </td>
                </tr>

                <tr>
                    <th><span>*</span> 주소</th>
                    <td>
                        <input type="text" name="hero_address_01" id="hero_address_01" value="<?=$member_list['hero_address_01']?>" class="short"/>
                        <a href="javascript:showzip()"><img src="../image/member/btn_zipcode.gif" alt="우편번호찾기" /></a><br />
                        <input type="text" name="hero_address_02" id="hero_address_02" value="<?=$member_list['hero_address_02']?>" class="w390" style="margin-top:1px;"/><br />
                        <input type="text" name="hero_address_03" id="hero_address_03" value="<?=$member_list['hero_address_03']?>" class="w390" style="margin-top:1px;" />
                    </td>
                </tr>
  
                <tr>
                    <th><span>*</span> AK Lover를<br/>알게된 경로는?</th>
                    <td>
                    	<p>
                        <input type="radio" name="area" value="신문" <?=$member_list["area"]=="신문" ? "checked":"";?>/> &nbsp;신문 <input type="radio" name="area" value="잡지" <?=$member_list["area"]=="잡지" ? "checked":"";?>/> &nbsp;잡지 <input type="radio" name="area" value="블로그" <?=$member_list["area"]=="블로그" ? "checked":"";?>/>&nbsp; 블로그 
                        <input type="radio" name="area" value="까페" <?=$member_list["area"]=="까페" ? "checked":"";?>/> &nbsp;까페 <input type="radio" name="area" value="지인" <?=$member_list["area"]=="지인" ? "checked":"";?>/> &nbsp;지인 <input type="radio" name="area" value="쪽지" <?=$member_list["area"]=="쪽지" ? "checked":"";?>/> &nbsp;쪽지 
                        <input type="radio" name="area" value="기타" <?=$member_list["area"]=="기타" ? "checked":"";?>/> &nbsp;기타 
                        </p>
                        <p>기타 <input type="text" name="area_etc_text" class="w390" maxlength="50" value="<?=$member_list["area_etc_text"];?>"/></p>
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
                    <th>개인URL</th>
                    <td class='notneed'>
                    	<p>
                        <input type="radio" name="hero_qs_09" value="있다" <?=$member_list["hero_qs_09"]=="있다" ? "checked":"";?>/>있다 
			            <input type="radio" name="hero_qs_09" value="없다" <?=$member_list["hero_qs_09"]=="없다" ? "checked":"";?>/>없다
                        </p>
                        <table class="tb_blog">
                        <col width="130" />
						<col width="*" />
                        	<tr style="border:none;">
                        		<td style="border:none; height:30px;">블로그 URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_00" class="w390" value="<?=$member_list["hero_blog_00"];?>"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">페이스북 URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_01" class="w390" value="<?=$member_list["hero_blog_01"];?>"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">트위터 URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_02" class="w390" value="<?=$member_list["hero_blog_02"];?>"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">인스타그램 URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_04" class="w390" value="<?=$member_list["hero_blog_04"];?>"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">카카오스토리 URL</td>
                            	<td style="border:none;"><input type="text" name="hero_blog_03" class="w390" value="<?=$member_list["hero_blog_03"];?>"/></td>
                            </tr>
                            <tr style="border:none;">
                        		<td style="border:none;">그외 SNS &nbsp;&nbsp; SNS 이름</td>
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
                	<th>블로그운영</th>
                    <td>
                    	<p>
                        <input type="radio" name="hero_qs_10" value="있다" <?=$member_list["hero_qs_10"]=="있다" ? "checked":"";?>/>있다 
			            <input type="radio" name="hero_qs_10" value="없다" <?=$member_list["hero_qs_10"]=="없다" ? "checked":"";?>/>없다
                        </p>
                    	<span class="tname">일주일에 컨텐츠를 평균 몇 개 업로드 하시나요?</span>
                        <br/>
                        <input type="text" name="hero_qs_01" style="width:200px;" class="blog_type"  maxlength="30" value="<?=$member_list["hero_qs_01"];?>"/><br/>
                        
                    	<span class="tname">운영 중인 블로그의 평균 일 방문자는 몇 명인가요?</span>
			                        <br>
			                        <input type="radio" name="hero_qs_02" value="200명" class="blog blog_type" <?=$member_list["hero_qs_02"]=="200명" ? "checked":"";?>/>200명 이하
			                        <input type="radio" name="hero_qs_02" value="200~800명" class="blog blog_type" <?=$member_list["hero_qs_02"]=="200~800명" ? "checked":"";?>/>200~800명
			                        <input type="radio" name="hero_qs_02" value="801~1,500명" class="blog blog_type" <?=$member_list["hero_qs_02"]=="801~1,500명" ? "checked":"";?>/>801~1,500명
			                        <br>
			                        <input type="radio" name="hero_qs_02" value="1,501~3,000명" class="blog blog_type" <?=$member_list["hero_qs_02"]=="1,501~3,000명" ? "checked":"";?>/>1,501~3,000명
			                        <input type="radio" name="hero_qs_02" value="3,001~4,000명" class="blog blog_type" <?=$member_list["hero_qs_02"]=="3,001~4,000명" ? "checked":"";?>/>3,001~4,000명
			                        <input type="radio" name="hero_qs_02" value="4,001~5,000명" class="blog blog_type" <?=$member_list["hero_qs_02"]=="4,001~5,000명" ? "checked":"";?>/>4,001~5,000명
			                        <input type="radio" name="hero_qs_02" value="5,001~10,000명" class="blog blog_type" <?=$member_list["hero_qs_02"]=="5,001~10,000명" ? "checked":"";?>/>5,001~10,000명
			                        <input type="radio" name="hero_qs_02" value="10,000명 이상" class="blog blog_type" <?=$member_list["hero_qs_02"]=="10,000명 이상" ? "checked":"";?>/>10,000명 이상
			                        <br>
			                        <span class="tname">블로그 타입(※ 중복 선택 가능)</span>
			                        <br>
                                    <? 
										$hero_qs_03 = explode(",",$member_list["hero_qs_03"]);
									?>
			                        <input type="checkbox" name="hero_qs_03[]" value="패션" class="blog blog_type2"/>패션
			                        <input type="checkbox" name="hero_qs_03[]" value="뷰티" class="blog blog_type2"/>뷰티
			                        <input type="checkbox" name="hero_qs_03[]" value="맛집" class="blog blog_type2"/>맛집 
			                        <input type="checkbox" name="hero_qs_03[]" value="리뷰" class="blog blog_type2"/>리뷰 
			                        <input type="checkbox" name="hero_qs_03[]" value="일상" class="blog blog_type2"/>일상
			                        <input type="checkbox" name="hero_qs_03[]" value="육아" class="blog blog_type2"/>육아
                                    <input type="checkbox" name="hero_qs_03[]" value="애완" class="blog blog_type2"/>애완
                                    <input type="checkbox" name="hero_qs_03[]" value="공연" class="blog blog_type2"/>공연
                                    <input type="checkbox" name="hero_qs_03[]" value="전시" class="blog blog_type2"/>전시
                                    <input type="checkbox" name="hero_qs_03[]" value="음악" class="blog blog_type2"/>음악
			                        </br>
			                        <input type="checkbox" name="hero_qs_03[]" value="방송" class="blog blog_type2"/>방송
                                    <input type="checkbox" name="hero_qs_03[]" value="연예" class="blog blog_type2"/>연예
                                    <input type="checkbox" name="hero_qs_03[]" value="건강" class="blog blog_type2"/>건강
                                    <input type="checkbox" name="hero_qs_03[]" value="IT" class="blog blog_type2"/>IT
                                    <input type="checkbox" name="hero_qs_03[]" value="교육" class="blog blog_type2"/>교육
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
                    <td><input type="radio" name="hero_qs_04" value="기혼" <?=$member_list["hero_qs_04"]=="기혼" ? "checked":"";?>/>기혼 
			            <input type="radio" name="hero_qs_04" value="미혼" <?=$member_list["hero_qs_04"]=="미혼" ? "checked":"";?>/>미혼</td>
                </tr>
                </table>
                <table class="member" style="margin-top:10px;">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr>
                	<th>자녀수 및 연령</th>
                    <td>
                    	<input type="radio" name="hero_qs_05" value="없음" <?=$member_list["hero_qs_05"]=="없음" ? "checked":"";?>/> 없음
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
                   	 	<div id="hero_qs_11_div" <?=$member_list["hero_qs_05"]=="없음" ? "style='display:none;'":"";?>>
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
                    <td><input type="text" name="hero_qs_06" class="w390" maxlength="100" value="<?=$member_list["hero_qs_06"];?>"/></td>
                </tr>
                </table>
                <table class="member" style="margin-top:10px;">
                <colgroup>
                    <col width="160px" />
                    <col width="*" />
                </colgroup>
                <tr>
                	<th>애경 외 활동하는<br />서포터즈</th>
                    <td><input type="radio" name="hero_qs_07" value="유" <?=$member_list["hero_qs_07"]=="유" ? "checked":"";?> />유 <input type="radio" name="hero_qs_07" value="무" <?=$member_list["hero_qs_07"]=="무" ? "checked":"";?>/>무<br/>
                    	<input type="text"  name="hero_qs_08" class="w390" maxlength="100" value="<?=$member_list["hero_qs_08"];?>"/>
                    </td>
                </tr>

            </table>
 
            
            <div class="btngroup tc" >
                <input type="image" src="../image/member/btn_infoedit.gif" alt="회원정보수정" />
            </div>
            
        </form>
       
        </div>
        
        <div class="layer_zip" style="top:700px;">   
            <dl>
            <form name="login_form" action="<?=PATH_HOME?>?board=result" onsubmit="return false;">
                <dt><img src="../image/member/zip1.gif" alt="우편번호 찾기" /></dt>
                <dd>
                <input id="addr" type="text" class="addr" /><input type="image" src="../image/member/btn_findzip.gif" alt="주소찾기" onclick="hero_ajax('zip.php', 'view_list', 'addr', 'zip'); return false;"/>
                </dd>
                <dd class="list">
                    <div id="view_list"></div>
                </dd>
                <dd class="tc"><a href="javascript:inputzip();"><img src="../image/member/btn_cancel.gif" alt="입력" /></a></dd>
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
	 		<? if($member_list["area"]!="기타") {?>
				$("input[name=area_etc_text]").val("");
				$("input[name=area_etc_text]").attr("disabled",true);
			<? } ?>
			
			<? if($member_list["hero_qs_09"]!="있다") {
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
			
			<? if($member_list["hero_qs_10"]!="있다") {?>
				$("input[name=hero_qs_01]").val("");
				$("input[name=hero_qs_02]").prop("checked",false);
				$(".blog_type2").prop("checked",false);
				$(".blog_type").attr("disabled",true);
				$(".blog_type2").attr("disabled",true);
			<? } ?>
			
			<? if($member_list["hero_qs_07"]!="유") {?>
				$("input[name=hero_qs_08]").val("");
				$("input[name=hero_qs_08]").attr("disabled",true);
			<? } ?>
	 	
	 		
			$("input[name=area]").on("click",function(){
				if($(this).val()=="기타") {
					$("input[name=area_etc_text]").attr("disabled",false);
				} else {
					$("input[name=area_etc_text]").val("");
					$("input[name=area_etc_text]").attr("disabled",true);
				}
			})
			
			//블로그있다/없다
			$("input[name=hero_qs_09]").on("click",function(){
				if($(this).val()=="있다") {
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
		    || key  == 35 || key  == 36 || key  == 37 || key  == 39  // 방향키 좌우,home,end  
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
                alert("이메일을 입력하세요.");mail_01.style.border = '1px solid red';mail_01.focus();
                return false;
            }
            if(mail_02.value == ""){
                alert("이메일을 선택하세요.");mail_02.style.border = '1px solid red';mail_02.focus();
                return false;
            }
//##################################################################################################################################################//
            if(hp_01.value == ""){
                alert("핸드폰번호를 입력하세요.");hp_01.style.border = '1px solid red';hp_01.focus();
                return false;
            }
            if(hp_02.value == ""){
                alert("핸드폰번호를 입력하세요.");hp_02.style.border = '1px solid red';hp_02.focus();
                return false;
            }
            if(hp_03.value == ""){
                alert("핸드폰번호를 입력하세요.");hp_03.style.border = '1px solid red';hp_03.focus();
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
            
//##################################################################################################################################################//
			if($("input[name=area]:checked").val() == "기타") {
				if(!$("input[name=area_etc_text]").val()) {
					alert("Ak Lover를 알게된 경로 기타내용을 입력해 주세요.");
					$("input[name=area_etc_text]").css("border","1px solid red");
					$("input[name=area_etc_text]").focus();
					return false;
				}
			}
//##################################################################################################################################################//
			//160701 나아론 추가정보입력 이벤트 (s)
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

			if(hero_qs_11 == "1명") $('#hero_qs_12').val($("select[name=select_birth0]").val());
			else if(hero_qs_11 == "2명") $('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val());
			else if(hero_qs_11 == "3명") $('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val());
			else if(hero_qs_11 == "4명") $('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val()+","+$("select[name=select_birth3]").val());
			else if(hero_qs_11 == "5명") $('#hero_qs_12').val($("select[name=select_birth0]").val()+","+$("select[name=select_birth1]").val()+","+$("select[name=select_birth2]").val()+","+$("select[name=select_birth3]").val()+","+$("select[name=select_birth4]").val());
			var hero_qs_12 = $('#hero_qs_12').val();
			
			// 모든 정보 입력해야 포인트 지급 
			if(hero_qs_10 == "있다"){
				if(hero_qs_05 == "있음")
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

//##################################################################################################################################################//
            form.submit();
//##################################################################################################################################################//
            return true;
        }
        
    </script>
				
    