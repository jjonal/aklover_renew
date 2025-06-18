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

$right_list = mysql_fetch_assoc($right_res);
?>

<div id="subpage" class="mypage alrampage">
	<div class="sub_title">
		<div class="sub_wrap">
			<div class="f_b">
				<h1 class="fz68 main_c fw600">마이페이지</h1>			
			</div>		
			<? include_once BOARD_INC_END.'mypage_top.php';?>
		</div>
	</div>
	<div class="sub_cont replypage">
		<div class="sub_wrap board_wrap f_sb">
			<div class="left">
				<? include_once BOARD_INC_END.'mypage_nav.php';?>
			</div>
			<div class="contents right">
				<div class="page_tit fz32 fw600">나의 정보 변경</div>	
				<p class="fz15 today_point">
					회원님의 정보를 더 안전하게 보호하기 위해 한 번 더 비밀번호를 입력해 주세요.
				</p>				
				<form name="form_next" action="<?=PATH_HOME_HTTPS?>?board=infoauth_check" method="post" onsubmit="return go_submit(this);">
					<div class="member_wrap">
						<div class="inner">
							<p class="fz24 bold t_c">비밀번호 입력</p>
							<div>
								<p class="fz16">현재 비밀번호</p>
								<input type="password" name="auth_password" placeholder="현재 비밀번호를 입력해주세요."/>
							</div>							
							<a href="javascript:;" onClick="go_submit(document.form_next)" class="btn_black btn_submit">확인</a>    
						</div>
					</div>	
				</form>        
			</div>
		</div>
	</div>
</div>


	
<script type="text/javascript">	
function go_submit(form) {
	if(!$("input[name='auth_password'").val()) {
		alert('비밀번호를 입력해 주세요.');
		$("input[name='auth_password'").focus();
		return false;
	}
	
	form.submit();
	return true;
}
</script>
				
    