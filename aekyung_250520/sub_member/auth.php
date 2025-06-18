<?php 
if(!defined('_HEROBOARD_'))exit;

if(!$_SESSION['temp_code']){
	error_historyBack("");
	exit;
}

$sql = " SELECT hero_info_ci FROM member WHERE hero_code = '".$_SESSION['temp_code']."' ";
$res = sql($sql);
$rs = mysql_fetch_assoc($res);

if($rs["hero_info_ci"]) {
	error_historyBack("올바른 경로를 이용해 주세요.");
	exit;
}


if ($_GET['returnUrl'] == 'y'){  // 24.07.16 musign 추가 로그인후 본인인증일시 메인으로 이동
	$_SERVER['HTTP_REFERER'] = "/main/index.php";
}
$_SESSION["auth_returnUrl"] = $_SERVER['HTTP_REFERER'];

//인증 후 이동할 페이지
$wheretogo = "authAct";
include_once $_SERVER['DOCUMENT_ROOT']."/combined/authInit.php";

?>
<link rel="stylesheet" type="text/css" href="/css/front/cscenter.css" />
<div id="subpage" class="cscenter mobile_auth">
	<div class="sub_title">
		<div class="sub_wrap">
			<div class="f_b">
                <div>
                    <h1 class="fz68 main_c fw500 ko">						
						본인인증
					</h1>                    
                </div>
            </div>
		</div>
	</div>
	<div class="sub_cont">
		<div class="sub_wrap board_wrap">
			<div class="contents_area">
				<div id="misson_confirm">		
					<div class="explainAuthWrap bgAuth">
						<p class="txt_check">SNS 인증(네이버, 카카오톡, 구글)을 통해 회원가입 하신 분들은 체험단 신청 시 ‘본인인증(휴대폰인증)’ 절차가 필수로 진행됩니다.<br />
						본인인증은 체험단 신청 최초 1회만 진행됩니다. 만약 여러 SNS 계정으로 회원가입한 경우 본인인증 된 하나의 계정으로만 체험단 참여가 가능합니다.<br /><br />
						체험단 참여방법은 'AK Lover 이용백서 > 서포터즈 편'에서 확인해 주세요.
						</p>
					</div>										
					<form name="form_chk" method="post">
						<input type="hidden" name="m" value="checkplusSerivce">
						<input type="hidden" name="EncodeData" value="<?= $enc_data ?>">
						<input type="hidden" name="m" value="pubmain">
						<input type="hidden" name="enc_data" value="<?= $sEncData ?>">
						<input type="hidden" name="param_r1" value="">
						<input type="hidden" name="param_r2" value="">
						<input type="hidden" name="param_r3" value="">
						<input type="hidden" name="param_r4" value="">
						<input type="hidden" name="param_r5" value="">
						<input type="hidden" name="param_r6" value="">		
						<input type="hidden" name="referer" value="<?=$_SERVER['HTTP_REFERER']?>">
						<input type="hidden" name="wheretogo" value="<?=$wheretogo?>">		
						<a href="javascript:hp_Popup()" class="btn_black btn_submit">휴대폰 인증하기</a>
					</form>
				</div>        
			</div>
		</div>
	</div>
</div>