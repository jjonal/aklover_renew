<?
####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
####################################################################################################################################################
?>

	<div class="contents_area">
        <div class="page_title">
            <div>아이디 / 비밀번호 찾기</div>
            <ul class="nav">
                <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
                <li>&gt;</li>
                <li class="current">아이디 / 비밀번호 찾기</li>
            </ul>
        </div>
        
        <div id="id_serch">
        	<p class="id_serch">
        		<span style="float:left; margin:0 7px 4px 6px; color:#f68427;font-size:18px; font-weight:bold">l</span>아이디 찾기
        	</p>
			<table class="logintable" width="726px"  summary="아이디 찾기"  >
				<tr>
					<td class="title1">이름</td>
					<td class="input_tit1"><input type="text" name="uid" id="uid" class="c2"></td>
				</tr>
				<tr>
					<td class="title1">생년 월일</td>
					<td class="input_tit1">
						<input type="text" name="jumin" id="jumin" onKeyUp="if(this.value.length >= 8)email.focus();" maxlength="8" style="ime-mode:disabled;">
						예>19980203
					</td>
				</tr>
				<tr>
					<td class="title1_3">이메일</td>
					<td class="input_tit2"><input type="text" name="email" id="email"></td>
				</tr>
			</table>
			<div class="Btn">
				<input type="image" src="/image2/main/01_fdIdBtn.jpg" alt="send" onclick="find_IdPw('zip3.php', '', 'uid', 'jumin', 'email', 'id'); return false;" class="id_icon">
			</div>

			<p class="id_serch">
				<span style="float:left; margin:0 7px 4px 6px; color:#f68427;font-size:18px; font-weight:bold">l</span>비밀번호 찾기
			</p>
			<table class="logintable" width="726px"  summary="비밀번호 찾기" >
				<tr>
					<td class="title1">아이디</td>
					<td class="input_tit1"><input type="text" name="uid2" id="uid2"></td>
				</tr>
				<tr>
					<td class="title1">생년 월일</td>
					<td class="input_tit1">
						<input type="text" name="jumin2" id="jumin2" onKeyUp="if(this.value.length >= 8)email2.focus();" maxlength="8" style="ime-mode:disabled;">
						예>19980203
					</td>
				</tr>
				<tr>
					<td class="title1_3">이메일</td>
					<td class="input_tit2"><input type="text" name="email2" id="email2"></td>
				</tr>
			</table>
			<div class="Btn">
				<input type="image" src="/image2/main/01_fdPwBtn.jpg" alt="send" onclick="find_IdPw('zip3.php', '', 'uid2', 'jumin2', 'email2', 'pw');$('#view_list2').html('<p align=center>확인 진행 중 입니다. 잠시만 기다려 주세요...</p>');return false;" class="id_icon">
			</div>
			</br>
			<p class="notice">- 아이디·비밀번호 찾기 오류 시, <span style="color:#ff6633; font-weight:bold">고객센터</span>로 문의 부탁드립니다.</p>
        </div>
        
    </div>
