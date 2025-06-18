<link rel="stylesheet" type="text/css" href="/css/front/member.css">
<?
if(!defined('_HEROBOARD_'))exit;

if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
}else{
    $my_level = $_SESSION['temp_level'];
}
if(!strcmp($my_level,'0')){msg('로그인이 필요합니다','location.href="'.PATH_HOME.'?board=login"');exit;}

$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);

$member_sql = 'select * from member where hero_id=\''.$_SESSION['temp_id'].'\';';
$out_member_sql = mysql_query($member_sql);
$member_list = @mysql_fetch_assoc($out_member_sql);
?>



<div id="subpage" class="mypage mu_member">
	<div class="sub_title">
		<div class="sub_wrap">
			<div class="f_b">
				<h1 class="fz68 main_c fw600">마이페이지</h1>			
			</div>		
			<? include_once BOARD_INC_END.'mypage_top.php';?>
		</div>
	</div>
	<div class="sub_cont without">
		<div class="sub_wrap board_wrap f_sb">
			<div class="left">
				<? include_once BOARD_INC_END.'mypage_nav.php';?>
			</div>
			<div class="contents right">
				<div class="page_title">
					<div class="page_tit fz32 fw600">나의 정보 변경</div>	
					<ul class="boardTabMenuWrap">
						<a href="/main/index.php?board=infoedit">정보 변경</a>
						<a href="/main/index.php?board=pwedit">비밀번호 변경</a>
						<a href="/main/index.php?board=without" class="on">회원탈퇴</a>
					</ul>     	       
				</div>
				<form name="form_next" action="<?=PATH_HOME_HTTPS?>?path=sub_member/without_del" enctype="multipart/form-data" method="post" onsubmit="return false;">
				<input type="hidden" name="hero_idx" value="<?=$member_list['hero_idx']?>">
				<input type="hidden" name="hero_id" value="<?=$member_list['hero_id']?>">
					<div class="info_wrap join_input">
						<div class="info_box">
							<div class="cont">
								<div class="box_line">
									<p class="tit fz15 fw500">*아이디</p>
									<div class="fz15 fw500"><?=$member_list['hero_id']?></div>
								</div>
								<div class="box_line">
									<p class="tit fz15 fw500">*비밀번호</p>
									<div class="fz15 fw500"><input type="password" name="hero_pw" id="hero_pw" value="" title="비밀번호" /></div>
								</div>
								<div class="choice">
									<p class="tit fz15 fw500" style="margin-bottom: 1.3rem;">*탈퇴사유</p>
									<div class="div_tr">
										<div class="div_td">
											<ul>
												<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_1" value="1"><label for="hero_out_reason_1">정보가 별로 없어서</label></li>
												<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_2" value="2"><label for="hero_out_reason_2">사이트 이용이 불편해서</label></li>
												<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_3" value="3"><label for="hero_out_reason_3">서비스 장애 및 지연이 자주 발생되어</label></li>
												<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_4" value="4"><label for="hero_out_reason_4">개인정보 유출이 두려워서</label></li>
												<li><p class="input_radio"><input type="radio" name="hero_out_reason" id="hero_out_reason_9" value="9"><label for="hero_out_reason_9">기타</label></li>
												<textarea cols="89" rows="10" name="hero_out" id="hero_out" placeholder="불편사항을 입력해 주세요." class="w535 mgt10"></textarea>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="btngroup t_c">
							<div class="btn_submit btn_black btn_pop" onClick="chk_submit(form_next)">회원탈퇴 하기</div>
						</div>
					</div>				         
				</form>
				</div>
			</div>	
		</div>
	</div>
</div>
<!-- 회원탈퇴 팝업 -->
<div id="without_pop" class="guide_popup" style="display: none;">
    <div class="inner rel t_c">
		<p class="fz32 bold">회원 탈퇴를 진행하시겠어요?</p>
		<p class="fz20 500 desc">탈퇴하시면 모든 활동 기록이 삭제됩니다.<br>
		그래도 탈퇴하시겠어요?</p>
		<div class="f_b btngroup">
			<div class="btn_submit btn_gray btn_cancel">취소</div>
			<button class="btn_submit btn_black" onClick="go_submit(form_next)">회원탈퇴 하기</button>
    	</div>
    </div>	
</div>



<script>
$(document).ready(function(){
	$("input[type='password']").keydown(function(e){
		if(e.keyCode === 13) event.preventDefault();
	})	
	$('#without_pop .btn_cancel').click(function(){
		$('#without_pop').hide();
	});
})

function chk_submit(form) {
	if(!$("#hero_pw").val()) {
		alert("비밀번호를 입력해 주세요.");
		$("#hero_pw").focus();
		return;
	}
	if(!$("input:radio[name='hero_out_reason']").is(":checked")) {
		alert("탈퇴 사유를 선택해 주세요.");
		return;
	}
	if($("input:radio[name='hero_out_reason']:checked").val() == "9") {
		if(!$("#hero_out").val()) {
			alert("기타 선택 시 불편사항을 입력해 주세요.");
			$("#hero_out").focus();
			return;
		}
	}
	
	$('#without_pop').show();
}

function go_submit(form) {
	
	
	form.submit();
}	
</script>