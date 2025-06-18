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
$member_sql = "select * from member where hero_code='".$_SESSION['temp_code']."' ;";
$member_res = new_sql($member_sql,$error);
if((string)$member_res==$error){
	error_historyBack("");
	exit;
}

$member_list                             = mysql_fetch_assoc($member_res);

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

/* 
$question_sql = "select * from member_question where left(hero_period,8)<='".date('Ymd')."' and right(hero_period,8)>='".date('Ymd')."'";
//echo $question_sql;
$question_res = mysql_query($question_sql) or die("시스템에러입니다. 다시 시도해 주세요.");
$question_rs = mysql_fetch_assoc($question_res);
 */
 
//추가입력사항 포인트 받았는지 여부
$point_sql = "select * from point where hero_title like '회원가입추가입력' and hero_code='".$member_list['hero_code']."' and hero_old_idx='2' ";
//echo $point_sql;
$point_sql = mysql_query($point_sql) or die();
$point_sql = mysql_fetch_assoc($point_sql); 
                       	
if($point_sql['hero_idx']=="")		$addpoint_check = 'N';//안 받았다 
else								$addpoint_check = 'Y';//받았다 
?>
    <div class="contents">
    	
    	<form name="form_next" action="<?=PATH_HOME?>?board=update" enctype="multipart/form-data" method="post" onsubmit="return go_submit(this);">
            <input type="hidden" name="hero_idx" value="<?=$member_list['hero_idx']?>">
            <input type="hidden" name="hero_today_plus" value="<?=Ymdhis?>">
            <input type="hidden" name="hero_login_ip" value="<?=$_SERVER['REMOTE_ADDR']?>">
			
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
 <?php
if($addpoint_check == "N"){//안 받은 경우 
   if(mktime(0,0,0,2,1,2016) <= time() && mktime(23,59,59,2,28,2016) >= time()) { //이벤트 기간
 ?>          
 			<input type="hidden" name="addPoint_check" value="N">
			<input type="hidden" name="question_idx" value="2">
			<input type="hidden" name="question_validation" value="F">
              <tr>
                	<!--############################ 추가 입력 이벤트 시작 ################################-->
                	<style>
			          .tname{color:#f68428;font-weight:bold;}
			        </style>
                	<td colspan="2" style="padding:0">
                		<table border="0" cellpadding="0" cellspacing="0" width="100%">
                			<tr>
			                    <th class='notneed' colspan="2" style="background-color:#F5F5F5;width:100%;text-align:center;font-weight: bold;font-size: 14px;">추가입력 이벤트</th>
			                </tr>    
                			<tr>
			                    <th class='notneed' style="width:116px;background-color:#F5F5F5;">블로그/개인SNS</th>
			                    <td style="width:*;">
			                    	<script>
			                    		function blog_check(obj){
			                    			if(obj.value == "있다"){
			                    				if(obj.checked){
				                    				$(".blog").attr("disabled",false);
			                    				}else{
					                    			$(".blog").attr("disabled",true);              					
			                    				}
			                    			}else{//없다 
			                    				if(obj.checked){
				                    				$(".blog").attr("disabled",true);
			                    				}else{
					                    			$(".blog").attr("disabled",false);	                    					
			                    				}
			                    			}
			                    		}
			                    	</script>			                    	
			                    	<span style="font-weight:bold;background-color:#FFF5BB;font-size: 13px;">블로그 운영 여부
			                    	<input type="radio" name="hero_qs_01" value="있다" onclick="blog_check(this);"/>있다 
			                    	<input type="radio" name="hero_qs_01" value="없다" onclick="blog_check(this);"/>없다</span>
			                    	<br>
			                        <span class="tname">블로그 URL </span>
			                        <br>
			                        <input type="text" name="hero_blog_00" class='w390 blog' style="ime-mode:disabled;" disabled="disabled"/><br/>
			                        <p style="font-size:11px;color:#aaaaaa;">※ 블로그를 등록하시면 AKLOVER에서 활동 시에 다양한 혜택을 받을 수 있습니다.</p>
			                        <span class="tname">블로그 일 방문자 수</span>
			                        <br>
			                        <input type="radio" name="hero_qs_02" value="200명" class="blog"/>200명 이하
			                        <input type="radio" name="hero_qs_02" value="200~800명" class="blog"/>200~800명
			                        <input type="radio" name="hero_qs_02" value="801~1,500명" class="blog"/>801~1,500명
			                        <br>
			                        <input type="radio" name="hero_qs_02" value="1,501~3,000명" class="blog"/>1,501~3,000명
			                        <input type="radio" name="hero_qs_02" value="3,001~4,000명" class="blog"/>3,001~4,000명
			                        <input type="radio" name="hero_qs_02" value="4,001~5,000명" class="blog"/>4,001~5,000명
			                        <input type="radio" name="hero_qs_02" value="5,001~10,000명" class="blog"/>5,001~10,000명
			                        <input type="radio" name="hero_qs_02" value="10,000명 이상" class="blog"/>10,000명 이상
			                        <br>
			                        <span class="tname">블로그 타입(※ 중복 선택 가능)</span>
			                        <br>
			                        <input type="checkbox" name="hero_qs_03" value="패션" class="blog"/>패션
			                        <input type="checkbox" name="hero_qs_03" value="맛집" class="blog"/>맛집
			                        <input type="checkbox" name="hero_qs_03" value="리뷰" class="blog"/>리뷰 
			                        <input type="checkbox" name="hero_qs_03" value="일상" class="blog"/>일상 
			                        <input type="checkbox" name="hero_qs_03" value="육아" class="blog"/>육아
			                        <input type="checkbox" name="hero_qs_03" value="애완" class="blog"/>애완
			                        </br>
			                        <input type="checkbox" name="hero_qs_03" value="공연,전시" class="blog"/>공연,전시 
			                        <input type="checkbox" name="hero_qs_03" value="음악,방송" class="blog"/>음악,방송
			                        <input type="checkbox" name="hero_qs_03" value="연예" class="blog"/>연예
			                        <input type="checkbox" name="hero_qs_03" value="건강" class="blog"/>건강
			                        <input type="checkbox" name="hero_qs_03" value="IT" class="blog"/>IT
			                        <input type="checkbox" name="hero_qs_03" value="교육" class="blog"/>교육
			                        <input type="checkbox" name="hero_qs_03" value="상업" class="blog"/>상업
			                        <br>
			                        <span class="tname">페이스북 URL </span>
			                        <br>
			                        <input type="text" name="hero_blog_01" class='w390 blog' style="ime-mode:disabled;" disabled="disabled"/><br/>
			                        <span class="tname">인스타그램 URL </span>
			                        <br>
			                        <input type="text" name="hero_blog_04" class='w390 blog' style="ime-mode:disabled;" disabled="disabled"/><br/>
			                        <span class="tname">카카오스토리 URL </span>
			                        <br>
			                        <input type="text" name="hero_blog_03" class='w390 blog' style="ime-mode:disabled;" disabled="disabled"/><br/>
			                        <span class="tname">트위터 URL </span>
			                        <br>
			                        <input type="text" name="hero_blog_02" class='w390 blog' style="ime-mode:disabled;" disabled="disabled"/><br/>
			                    </td>
			                </tr> 

			                <tr>
			                    <th class='notneed' style="width:116px;background-color:#F5F5F5;">가족 구성원 관련</th>
			                    <td style="width:*;">
			                    	<span class="tname">결혼 여부</span>
			                    	<br>
			                    	<input type="radio" name="hero_qs_04" value="기혼"/>기혼 
			                    	<input type="radio" name="hero_qs_04" value="미혼"/>미혼
			                    	<br>
			                    	<span class="tname">가족 구성원</span>
			                        <br>
			                        <input type="radio" name="hero_qs_09" value="2명"/>2명
			                        <input type="radio" name="hero_qs_09" value="3명"/>3명 
			                        <input type="radio" name="hero_qs_09" value="4명"/>4명
			                        <input type="radio" name="hero_qs_09" value="5명"/>5명
			                        <input type="radio" name="hero_qs_09" value="6명 이상"/>6명 이상
			                        <br>
		                    		<script>
			                    		function child_check(obj){
			                    			if(obj.value == "있다"){
			                    				if(obj.checked){
				                    				$(".child").attr("disabled",false);
			                    				}else{
					                    			$(".child").attr("disabled",true);              					
			                    				}
			                    			}else{//없다 
			                    				if(obj.checked){
				                    				$(".child").attr("disabled",true);
			                    				}else{
					                    			$(".child").attr("disabled",false);	                    					
			                    				}
			                    			}
			                    		}
			                    	</script>				                        
			                        <span style="font-weight:bold;background-color:#FFF5BB;font-size: 13px;">자녀 유무
			                    	<input type="radio" name="hero_qs_10" value="있다" onclick="child_check(this);"/>있다 
			                    	<input type="radio" name="hero_qs_10" value="없다" onclick="child_check(this);"/>없다</span>
									<br>
			                        <span class="tname">자녀의 출생 연도</span>
			                        <br>
			                        <input type="text" name="hero_qs_05" class='w390 child' style="ime-mode:disabled;" disabled="disabled"/>
			                        <br/>
			                        <span class="tname">자녀의 성별</span>
			                        <br>
			                        <input type="text" name="hero_qs_11" class='w390 child' style="ime-mode:disabled;" disabled="disabled"/>			                        
			                    </td>
			                </tr> 
			                <tr>
			                    <th class='notneed' style="width:116px;background-color:#F5F5F5;">소비 형태 관련</th>
			                    <td style="width:*;">
			                    	<span class="tname">생활용품 및 뷰티제품을 구매할 때 주로 사용하는 구매처</span>
			                    	<br>
			                    	<input type="radio" name="hero_qs_12" value="홈쇼핑"/>홈쇼핑 
			                    	<input type="radio" name="hero_qs_12" value="대형마트"/>대형마트
			                    	<input type="radio" name="hero_qs_12" value="소형마트"/>소형마트
			                    	<input type="radio" name="hero_qs_12" value="편의점"/>편의점
			                    	<input type="radio" name="hero_qs_12" value="드러그스토어"/>드럭스토어
			                    	<br>
			                    	<span class="tname">그 구매처에서 주로 구매하는 이유는?</span>
			                    	<br>
			                    	<input type="radio" name="hero_qs_13" value="할인율"/>할인율 
			                    	<input type="radio" name="hero_qs_13" value="접근성"/>접근성
			                    	<input type="radio" name="hero_qs_13" value="가격"/>가격
			                    	<input type="radio" name="hero_qs_13" value="프로모션"/>프로모션	
			                    	<br>
			                    	<span class="tname">홈쇼핑에서 제품을 구매한 경험</span>
			                    	<br>
			                    	<input type="radio" name="hero_qs_14" value="있다"/>있다 
			                    	<input type="radio" name="hero_qs_14" value="없다"/>없다  
			                    	<br>
			                    	<span class="tname">드럭스토어(왓슨스, 분스, 올리브영 등)에서 제품을 구매한 경험</span>
			                    	<br>
			                    	<input type="radio" name="hero_qs_15" value="있다"/>있다 
			                    	<input type="radio" name="hero_qs_15" value="없다"/>없다
			                    	<br>
			                    	<span class="tname">온라인 쇼핑몰에서 제품을 구매한 경험</span>
			                    	<br>
			                    	<input type="radio" name="hero_qs_06" value="있다"/>있다 
			                    	<input type="radio" name="hero_qs_06" value="없다"/>없다                      	
			                    </td>
			               </tr>  
			                <tr>
			                    <th class='notneed' style="width:116px;background-color:#F5F5F5;">관심사/애경 관련</th>
			                    <td style="width:*;">
		                    		<script>
			                    		function ak_check(obj){
			                    			if(obj.value == "했다"){
			                    				if(obj.checked){
				                    				$(".ak").attr("disabled",false);
			                    				}else{
					                    			$(".ak").attr("disabled",true);              					
			                    				}
			                    			}else{//안 했다
			                    				if(obj.checked){
				                    				$(".ak").attr("disabled",true);
			                    				}else{
					                    			$(".ak").attr("disabled",false);	                    					
			                    				}
			                    			}
			                    		}
			                    	</script>	
			                        <span style="font-weight:bold;background-color:#FFF5BB;font-size: 13px;">AK 뷰티몰에 가입
			                    	<input type="radio" name="hero_qs_16" value="했다" onclick="ak_check(this);"/>했다 
			                    	<input type="radio" name="hero_qs_16" value="안 했다" onclick="ak_check(this);"/>안 했다</span>
			                    	<br>
			                    	<span class="tname">가입되어 있다면 AK 뷰티몰 아이디를 기재</span>
			                    	<br>
			                    	<input type="text" name="hero_qs_17" class='w390 ak' style="ime-mode:disabled;" disabled="disabled"/>                  	
			                    </td>
			               </tr>  			                   
                		</table>
                	</td>
				 	<!--############################ 추가 입력 이벤트 끝 ################################-->
                </tr>
<?php
	}//이벤트 기간 중인 경우 
}//안 받은 경우   
?> 
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
<script type="text/javascript" src="<?=JS_END;?>jquery.cookie.js" ></script>
<script type="text/javascript" charset="utf-8" src="https://static.nid.naver.com/js/naverLogin.js" ></script>
<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
<script type="text/javascript" src="<?=JS_END;?>snsInit.js"></script>
    
     <script type="text/javascript">

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
//##################################################################################################################################################//

<?php
if($addpoint_check == "N"){//안 받은 경우 
  if(mktime(0,0,0,2,1,2016) <= time() && mktime(23,59,59,2,28,2016) >= time()) { //이벤트 기간
?>
         	//############################ 추가 입력 이벤트 검증 ################################
        	var tmpMsg="\n\n추가 입력 사항을 다 입력하시면 20포인트를 받으실 수 있습니다.\n추가 입력 없이 가입 하시겠습니까?";
         	if($('input[name=hero_qs_01]:checked').length == 0){
        		if(confirm("블로그 운영 여부가 선택되지 않았습니다."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_01]').eq(0).focus();
        			return false;
        		}
        	}else{
         		if($('input[name=hero_qs_01]').eq(0).prop("checked")){
		        	if($('input[name=hero_blog_00]').val() == ""){
		        		if(confirm("블로그 URL이 입력 되지 않았습니다."+tmpMsg)){
		        			form.question_validation.value="F";
		        			form.submit();
		        			return false;
		        		}else{
		        			$('input[name=hero_blog_00]').focus();
		        			return false;
		        		}
		        	}
		        	if($('input[name=hero_qs_02]:checked').length == 0){
		        		if(confirm("블로그 일 방문자 수가 선택되지 않았습니다."+tmpMsg)){
		        			form.question_validation.value="F";
		        			form.submit();
		        			return false;
		        		}else{
		        			$('input[name=hero_qs_02]').eq(0).focus();
		        			return false;
		        		}
		        	}   
		        	if($('input[name=hero_qs_03]:checked').length == 0){
		        		if(confirm("블로그 타입이 선택되지 않았습니다."+tmpMsg)){
		        			form.question_validation.value="F";
		        			form.submit();
		        			return false;
		        		}else{
		        			$('input[name=hero_qs_03]').eq(0).focus();
		        			return false;
		        		}
		        	} 
		        }	
	        }	
        	if($('input[name=hero_qs_04]:checked').length == 0){
        		if(confirm("결혼 여부가 선택되지 않았습니다."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_04]').eq(0).focus();
        			return false;
        		}
        	}                
        	if($('input[name=hero_qs_09]:checked').length == 0){
        		if(confirm("가족 구성원 수가 선택되지 않았습니다."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_09]').eq(0).focus();
        			return false;
        		}
        	}   
        	
        	if($('input[name=hero_qs_10]:checked').length == 0){
        		if(confirm("자녀 유무가 선택되지 않았습니다."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_10]').eq(0).focus();
        			return false;
        		}
        	}else{
        		if($('input[name=hero_qs_10]').eq(0).prop("checked")){
		        	if($('input[name=hero_qs_05]').val() == ""){
		        		if(confirm("자녀의 출생연도가 입력 되지 않았습니다."+tmpMsg)){
		        			form.question_validation.value="F";
		        			form.submit();
		        			return false;
		        		}else{
		        			$('input[name=hero_qs_05]').focus();
		        			return false;
		        		}
		        	}
		        	if($('input[name=hero_qs_11]').val() == ""){
		        		if(confirm("자녀의 성별이 입력 되지 않았습니다."+tmpMsg)){
		        			form.question_validation.value="F";
		        			form.submit();
		        			return false;
		        		}else{
		        			$('input[name=hero_qs_11]').focus();
		        			return false;
		        		}
		        	}
		        }	
	        } 

        	if($('input[name=hero_qs_12]:checked').length == 0){
        		if(confirm("주요 구매처가 선택되지 않았습니다."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_12]').eq(0).focus();
        			return false;
        		}
        	} 
        	if($('input[name=hero_qs_13]:checked').length == 0){
        		if(confirm("주요 구매처 구매 이유가 선택되지 않았습니다."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_13]').eq(0).focus();
        			return false;
        		}
        	} 
         	if($('input[name=hero_qs_14]:checked').length == 0){
        		if(confirm("홍쇼핑 제품 구매 경험 여부가 선택되지 않았습니다."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_14]').eq(0).focus();
        			return false;
        		}
        	} 
         	if($('input[name=hero_qs_15]:checked').length == 0){
        		if(confirm("드럭스토어 제품 구매 경험 여부가 선택되지 않았습니다."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_15]').eq(0).focus();
        			return false;
        		}
        	}     
         	if($('input[name=hero_qs_06]:checked').length == 0){
        		if(confirm("온라인 쇼핑몰 제품 구매 경험 여부가 선택되지 않았습니다."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_06]').eq(0).focus();
        			return false;
        		}
        	}     	       	        		        
        	if($('input[name=hero_qs_16]:checked').length == 0){
        		if(confirm("AK 뷰티몰 가입 여부가 선택되지 않았습니다."+tmpMsg)){
        			form.question_validation.value="F";
        			form.submit();
        			return false;
        		}else{
        			$('input[name=hero_qs_16]').eq(0).focus(); 
        			return false;
        		}
        	}else{
        		if($('input[name=hero_qs_16]').eq(0).prop("checked")){
		        	if($('input[name=hero_qs_17]').val() == ""){
		        		if(confirm("AK 뷰티몰 아이디가 입력 되지 않았습니다."+tmpMsg)){
		        			form.question_validation.value="F";
		        			form.submit();
		        			return false;
		        		}else{
		        			$('input[name=hero_qs_17]').focus();
		        			return false;
		        		}
		        	}
		        }	
	        }		      	      
	        //############################ 추가 입력 이벤트 검증 ################################
	        form.question_validation.value="T";
<?php 
	}//이벤트 기간 중인 경우 
}//안 받은 경우
?>

//##################################################################################################################################################//
            form.submit();
//##################################################################################################################################################//
            return true;
        }
        
    </script>
				
    