<?
if(!defined('_HEROBOARD_'))exit;

if($_SESSION["temp_code"]) {
	error_location("로그인 상태입니다.\\n올바른 경로로 이용해 주세요.","/main/index.php");
}
?>

<link rel="stylesheet" type="text/css" href="/css/front/member.css" />
	<div class="contents_area findpw_wrap mu_member"> 
		<div class="notice">
			<div class="f_cs">
				<img src="/img/front/member/findicon.png" alt="말풍선">
				<p class="noti_txt">
					아이디를 잊으셨나요?<br>
					아래의 인증방법을 선택하시고 정보를 입력해주세요.
				</p>
				<p class="noti_txt" style="display: none;">
					비밀번호를 잊으셨나요?<br>
					아래의 인증방법을 선택하시고 정보를 입력해주세요.
				</p>
			</div>
		</div>
		<div class="id_tit f_b">
			<p class="fz36 bold on">아이디 찾기</p>
			<span></span>
			<p class="fz36 bold rel">비밀번호 찾기</p>
		</div>       
        <div id="id_serch">   
			<div class="findbx findid on">
				<div class="input_wrap">
					<p class="fz16 fw500">이름</p>
					<input type="text" name="uid" id="uid" class="c2" placeholder="이름을 입력해 주세요.">
				</div>
				<div class="input_wrap">
					<p class="fz16 fw500">생년 월일(예_19980203)</p>
					<input type="text" name="jumin" id="jumin" onKeyUp="if(this.value.length >= 8)email.focus();" maxlength="8" numberOnly style="ime-mode:disabled;" placeholder="생일을 입력해 주세요.">
				</div>
				<div class="input_wrap">
					<p class="fz16 fw500">이메일</p>
					<input type="text" name="email" id="email" placeholder="이메일을 입력해 주세요.">
				</div>
				<!--!!!!!!!! [개발요청] 기존방식이 alert방식으로 아이디가 노출되는게 아니라 팝업형식으로 개발해야합니다[완] !!!!!!!!  -->
				<div class="Btn f_c">
					<div type="text" alt="send" onclick="find_IdPw('zip3.php', '', 'uid', 'jumin', 'email', 'id'); return false;" class="btn_submit btn_black">아이디 찾기</div>
				</div>
				<!--//////////// end ////////////  -->	
				<div class="term dis-no find_IdPw">
					<div class="inner rel">
						<h2 class="t_c fz24 bold">아이디 찾기</h2>
						<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>							
						<!--!!!!!!!! [개발요청] 확인된 아이디 [완]////////////  -->
						<div class="cont t_c find_id dis-no">
							<p class="fz18 fw500 gray08 t_c">고객님의 아이디를 알려드립니다.</p>
							<p class="idinfo t_c fz20 fw600">
								[고객ID]
							</p>
						</div>
						<!--!!!!!!!! [개발요청] or 회원정보 불일치시 [완]////////////  -->
						<div class="cont t_c no_find_id dis-no">
							<p class="idinfo t_c fz17 fw600">
								<img src="/img/front/icon/warning.webp" alt="경고"><br>
								일치하는 회원 정보가 없습니다.<br>
								입력하신 정보를 확인하여 주세요.
							</p>
						</div>
					</div>	
				</div>
			</div>  
			<div class="findbx findpw"> 					
				<div class="input_wrap">
					<p class="fz16 fw500">아이디</p>
					<input type="text" name="uid2" id="uid2" placeholder="아이디를 입력해 주세요.">
				</div>
				<!--!!!!!!!! [개발요청] 기존에 없던 이름란이 생겼습니다  [완]////////////  -->
				<div class="input_wrap">
					<p class="fz16 fw500">이름</p>
					<input type="text" name="hero_name" id="hero_name" placeholder="이름을 입력해 주세요.">
				</div>
				<div class="input_wrap">
					<p class="fz16 fw500">본인인증 방법</p>
					<ul class="certify_icon f_cs">
						<li><p class="input_radio"><input type="radio" name="" id="" value="" checked/><label for="" class="input_chk_label">휴대폰 번호</label></p></li>
					</ul>
				</div>
                <div class="input_wrap certify">
                    <p class="fz16 fw500">휴대폰번호</p>
                    <div class="number_bx">
                        <input type="text" name="hero_hp1" id="hero_hp1" maxlength="4" numberOnly>
                        - <input type="text" name="hero_hp2" id="hero_hp2" maxlength="4" numberOnly>
                        - <input type="text" name="hero_hp3" id="hero_hp3" maxlength="4" numberOnly>
                    </div>
                </div>
                <div class="Btn f_c">
                    <a href="javascript:;" onClick="sencAuthCode()" class="btn_submit btn_black">인증코드 받기</a>
                </div>
                <div class="input_wrap">
                    <p class="fz16 fw500">인증코드</p>
                    <div class="number_bx">
                        <input type="text" name="authCode" id="authCode" maxlength="6">
                    </div>
                </div>
				<!--!!!!!!!! [개발요청] 전화번호 인증 개발 [완]!!!!!!!!  -->
				<div class="Btn f_c">
					<a href="javascript:;" onClick="searchPassword()" class="btn_submit btn_black">비밀번호 찾기</a>
				</div>
				<!--//////////// end ////////////  -->	
				<div class="term pw_popup dis-no">
					<div class="inner rel">
                        <div class="find_pw dis-no">
                            <!--!!!!!!!! [개발요청] 비밀번호 변경 -- 하단 유효성 검사 포함 마이페이지에서 가져왔습니다 같이 수정 부탁드립니다 [완]////////////  -->
                            <input type="hidden" id="pwTF" value="false">
                            <h2 class="t_c fz24 bold">비밀번호 변경</h2>
                            <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
                            <div class="cont">
                                <div class="input_wrap">
                                    <p class="fz16 fw500">새 비밀번호</p>
                                    <input type="password" name="newPw" id="newPw" onkeyup="chPwdTF(this);" class="editPwInputArea" maxlength="16"  placeholder="영문, 숫자, 특수기호를 조합하여 8자리 이상 입력해주세요">
                                    <span id="newPwText"></span>
                                </div>
                                <div class="input_wrap">
                                    <p class="fz16 fw500">새 비밀번호 확인</p>
                                    <input type="password" name="chNewPw" id="chNewPw" onkeyup="chPwdTF(this);" class="editPwInputArea" maxlength="16" placeholder="영문, 숫자, 특수기호를 조합하여 8자리 이상 입력해주세요">
                                    <span id="chNewPwText"></span>
                                </div>
                            </div>
                            <div class="Btn f_c">
                                <a href="javascript:;" onClick="changePassword()" class="btn_submit btn_black">비밀번호 변경</a>
                            </div>
                        </div>
						<!--!!!!!!!! end ////////////  -->	
						<!--!!!!!!!! [개발요청] or 회원정보 불일치시 [완]////////////  -->
                        <div class="no_find_pw dis-no">
                            <h2 class="t_c fz24 bold">비밀번호 찾기</h2>
                            <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
                            <div class="cont t_c">
                                <p class="idinfo t_c fz17 fw600">
                                    <img src="/img/front/icon/warning.webp" alt="경고"><br>
                                    일치하는 회원 정보가 없습니다.<br>
                                    입력하신 정보를 확인하여 주세요.
                                </p>
                            </div>
                        </div>
						<!--!!!!!!!! end ////////////  -->			
					</div>	
				</div>	
			</div>  
			</br>
		</div>
    </div>
<script>

$(document).ready(function(){
	// 아이디, 비밀번호 tab 
	const notiTxt = $('.noti_txt');
	const idTit = $('.id_tit > p');
	const idCont = $('.findbx');
	$.each(idTit, function(idx, item){
		$(this).click(function(){
			idTit.removeClass('on');
			$(this).addClass('on');
			idCont.removeClass('on');
			idCont.eq(idx).addClass('on');
			notiTxt.hide();
			notiTxt.eq(idx).show();
		});
	});
	// 전체동의 팝업 닫기
	$('.term .btn_x').click(function(){
		$(this).parents('.term').addClass('dis-no');

        //아이디 찾기
        $(".find_id").addClass("dis-no");
        $(".no_find_id").addClass("dis-no");
        //비밀번호 찾기
        $(".find_pw").addClass("dis-no");
        $(".no_find_pw").addClass("dis-no");
	});	
	// 인증방법 tab 
	const cerDiv = $('.certify');
	const cerTab = $('.certify_icon > li');
	const cerInput = $('.certify_icon > li input');
	// const idCont = $('.findbx');
	$.each(cerTab, function(idx, item){
		$(this).click(function(){
			cerInput.prop('checked', false);
			cerInput.eq(idx).prop('checked', true);
			cerDiv.hide();
			cerDiv.eq(idx).show();
		});
	});
	// 이메일 직접입력
	emailChg =function(){
		if(email_select.value != "")  $('#hero_mail_02').attr('readonly', true);
		else $('#hero_mail_02').attr('readonly', false);
		hero_mail_02.value = email_select.value;
	}
    //인증코드 받기
    sencAuthCode = function(){
        if(!$("#uid2").val()) {
            alert("아이디를 입력해 주세요.");
            $("#uid2").focus();
            return;
        }

        if(!$("#hero_hp1").val() || !$("#hero_hp2").val() || !$("#hero_hp3").val()) {
            alert("휴대폰번호를 입력해 주세요.");
            $("#hero_hp1").focus();
            return;
        }

        var hero_hp = $("#hero_hp1").val()+"-"+$("#hero_hp2").val()+"-"+$("#hero_hp3").val();

        var param = "type=sendAuth&hero_id="+$("#uid2").val()+"&hero_name="+$("#hero_name").val()+"&hero_hp="+hero_hp;

        $.ajax({
            url:"/main/zip3.php"
            ,data:param
            ,type:"post"
            ,dataType:"html"
            ,success:function(d){
                if(d == $("#uid2").val()){
                    alert('인증코드가 발송되었습니다.');
                }else {
                    alert(d);
                }
            },error:function(e){
                console.log(e);
                alert("오류가 발생했습니다.\n관리자에게 문의해 주세요.");
            }
        })
    }
    //유효성검사
    searchPassword = function(){

        if(!$("#uid2").val()) {
            alert("아이디를 입력해 주세요.");
            $("#uid2").focus();
            return;
        }

        if(!$("#hero_hp1").val() || !$("#hero_hp2").val() || !$("#hero_hp3").val()) {
            alert("휴대폰번호를 입력해 주세요.");
            $("#hero_hp1").focus();
            return;
        }

        if(!$("#authCode").val()) {
            alert("인증코드를 입력해 주세요.");
            $("#authCode").focus();
            return;
        }

        var hero_hp = $("#hero_hp1").val()+"-"+$("#hero_hp2").val()+"-"+$("#hero_hp3").val();

        var param = "type=pw2&hero_id="+$("#uid2").val()+"&hero_name="+$("#hero_name").val()+"&hero_hp="+hero_hp+"&auth="+$("#authCode").val();

        $.ajax({
            url:"/main/zip3.php"
            ,data:param
            ,type:"post"
            ,dataType:"html"
            ,success:function(d){
                $(".pw_popup").removeClass("dis-no");
                if(d == $("#uid2").val()){
                    $(".find_pw").removeClass("dis-no");
                }else {
                    $(".no_find_pw").removeClass("dis-no");
                }
            },error:function(e){
                console.log(e);
                alert("오류가 발생했습니다.\n관리자에게 문의해 주세요.");
            }
        })
    }
    //비밀번호 변경
    changePassword = function(){
        var param = "type=chgpw&hero_id="+$("#uid2").val()+"&newPw="+$("#newPw").val()+"&chNewPw="+$("#chNewPw").val();

        if(pwTF.value == 'false') {
            return;
        }

        $.ajax({
            url:"/main/zip3.php"
            ,data:param
            ,type:"post"
            ,dataType:"html"
            ,success:function(d){
                if(d == $("#uid2").val()){
                    alert('비밀번호가 변경되었습니다.');
                    location.reload(); // /main/index.php?board=login 여기로 가야되지 않을까?
                }else {
                    alert(d);
                }
            },error:function(e){
                console.log(e);
                alert("오류가 발생했습니다.\n관리자에게 문의해 주세요.");
            }
        })
    }
})

//비밀번호 유효성검사 -- 마이페이지 수정에서 가져와서 유효성 검사도 같이 수정 부탁드립니다
function chPwdTF(obj){
    var newPw = document.getElementById("newPw");
    var chNewPw = document.getElementById("chNewPw");

    var newPwText = document.getElementById("newPwText");
    var chNewPwText = document.getElementById("chNewPwText");

    var hp = $("#hero_hp1").val()+"-"+$("#hero_hp2").val()+"-"+$("#hero_hp3").val();
    var hpNumber = hp.split("-");

    var pwTF = document.getElementById("pwTF");
    if (newPw.value.length < 8) {
        newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
        newPwText.innerHTML ="영문, 숫자, 특수기호를 조합하여 8자리 이상 입력해주세요";
        pwTF.value="false";
        obj.focus();
        return false;
    }else if(!chTextType.isEnNumOther(newPw.value)){
        newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
        newPwText.innerHTML ="영문, 숫자, 특수기호를 조합하여 주세요";
        pwTF.value="false";
        obj.focus();
        return false;
    }
    else if((typeof hpNumber[1] != 'undefined' && typeof hpNumber[2] != 'undefined') && (newPw.value.indexOf(hpNumber[1])>0 || newPw.value.indexOf(hpNumber[2])>0)){
        newPwText.style.color="<?=$_MAIN_COLOR[0];?>";
        newPwText.innerHTML ="핸드폰 번호는 비밀번호에 포함할 수 없습니다.";
        pwTF.value="false";
        obj.focus();
        return false;
    }else{
        newPwText.style.color="<?=$_MAIN_COLOR[1];?>";
        newPwText.innerHTML ="사용 가능한 비밀번호입니다";
    }
    if(chNewPw.value!=''){
        if(chNewPw.value!=newPw.value){
            chNewPwText.style.color="<?=$_MAIN_COLOR[0];?>";
            chNewPwText.innerHTML ="비밀번호가 같지 않습니다";
            pwTF.value="false";
            obj.focus();
            return false;
        }else{
            chNewPwText.style.color="<?=$_MAIN_COLOR[1];?>";
            chNewPwText.innerHTML ="비밀번호가 같습니다.";
            pwTF.value="true";
        }
    }
}
</script>
