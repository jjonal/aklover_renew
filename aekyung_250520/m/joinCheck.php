<? 
include_once "head.php";

if($_SESSION['temp_code']){
	error_historyBack("로그인이 되어 있습니다. 로그 아웃 후에 다시 시도해 주세요.");
	exit;
}

$group_sql = " SELECT * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."' "; // desc
$out_group = new_sql( $group_sql,$error );

if((string)$out_group==$error){
	error_historyBack("");
	exit;
}

$right_list = mysql_fetch_assoc ( $out_group );

include_once "boardIntroduce.php";

include_once $_SERVER['DOCUMENT_ROOT']."/combined/mobile_authInit.php";
?>
<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">
<div class="contents_area mu_member join_wrap">
	<div class="page_title t_c">
        <h2 class="fz48 fw500 main_c">회원가입</h2>
		<p class="subtit fz12">AK Lover의 다양한 서포터즈를 경험하세요!</p>
		<div class="bread">
			<ul class="f_c">
				<li class="on">본인인증</li>
				<li class="arr on"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<li>이용약관 동의</li>
				<li class="arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<li>계정 생성(필수)</li>
				<!-- <li class="arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li><br /> -->
			</ul>
			<ul class="f_c">				
				<!-- <li>계정 생성(선택)</li> -->
				<li class="arr"><img src="/img/front/icon/bread.webp" alt="화살표"></li>
				<li>회원가입 완료</li>
			</ul>
		</div>
    </div>
	<div class="contents">
		<div class="signup_wrap">
			<div id="signup_confirm">
				<p class="fz16 fw600">본인인증</p>
				<p class="fz14 fw500 subtit gray07">※ 반드시 본인 명의로 본인인증을 해주시길 바랍니다.</p>
				<div class="snsLoginForm t_c">
					<div class="snsBox f_c">
						<form name="form_chk" method="post">
                            <input type="hidden" name="m" value="checkplusSerivce">
                            <input type="hidden" name="EncodeData" value="<?= $enc_data ?>">
                            <input type="hidden" name="m" value="pubmain">
                            <input type="hidden" name="enc_data" value="<?= $sEncData ?>">
                            <input type="hidden" name="wheretogo" value="/m/agreement.php?board=agreement">
                            <input type="hidden" name="param_r1" value="">
                            <input type="hidden" name="param_r2" value="">
                            <input type="hidden" name="param_r3" value="">
                            <input type="hidden" name="param_r4" value="">
                            <input type="hidden" name="param_r5" value="">
                            <input type="hidden" name="param_r6" value="">
                            <a href="javascript:;" class="btn_lover" onClick="hp_Popup()"><img src="/img/front/member/mobile.webp" alt="휴대폰 인증"></a>
						</form>	
						<span class="bar"></span>		
						<a href="javascript:;" onClick="loginKakao('idcheck')" class="btn_kakao"><img src="/img/front/member/kakaolog.webp" alt="카카오 로그인"></a>				
						<span class="bar"></span>
						<div id="naver_id_login" class="btn_naver rel">네이버로그인</div>
						<span class="bar"></span>
						<a href="javascript:;" id="btn_google" class="btn_google"><img src="/img/front/member/googlelog.webp" alt="구글 로그인"></a>
					</div>
					<form name="idcheckForm" id="idcheckForm" method="post" action="/m/agreement.php?board=agreement">
						<input type="hidden" name="snsType">
						<input type="hidden" name="snsId">
						<input type="hidden" name="snsEmail">
					</form> 
				</div>
			</div>
			<div class="kakaplus">
				<p class="fz16 fw600">AK Lover 카카오톡 플러스 친구 안내</p>
				<p class="fz14 fw500 subtit gray07">AKLover에서는 체험단 신규 업로드, 당첨자, 배송, 후기마감, 우수자, 수정요청 등
				모든 커뮤니케이션을 카카오톡 플러스 친구로 진행합니다.
				회원가입 후 카카오톡에서 ‘애경서포터즈’ 검색 후 채널을 추가해 보세요! </p>
				<div class="imgbx">
					<img src="/img/front/member/kakaofriends.jpg" alt="카카오톡 플러스 친구 안내">
					<ul class="f_c">
						<li>1.카카오톡 실행</li>
						<li>2.친구 검색 '애경서포터즈'</li>
						<li>3.친구추가</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://apis.google.com/js/api:client.js"></script>
<script>
var naver_id_login = new naver_id_login(naver.client_id,"<?=getSnsDomain()?>/m/joinCheck.php?board=idcheck"); 
var edit_access_token = naver_id_login.oauthParams.board.split("idcheck#access_token=");
var naver_access_token = edit_access_token[1];
naver_id_login.oauthParams.access_token = naver_access_token;

if(!naver_id_login.oauthParams.access_token) {
	var state = naver_id_login.getUniqState();
	naver_id_login.setButton("green", 1,45);
    // naver_id_login.setDomain("https://aklover.co.kr"); //운영
    naver_id_login.setDomain("http://aklover-test.musign.kr"); //musign 테스트
	naver_id_login.setState(state);
	//naver_id_login.setPopup();
	naver_id_login.init_naver_id_login();
}

if(naver_id_login.oauthParams.access_token) {
	naver_id_login.get_naver_userprofile("naverSignInCallback()");
}

function naverSignInCallback() {
	where = "idcheck";
	snsType = "naver";
	var response = {"id":naver_id_login.getProfileData('id'),"email":naver_id_login.getProfileData('email')};
	afterLogin.login(response);
}

//(s)210203 google 연동
var googleUser = {};
var startApp = function() {
    gapi.load('auth2', function(){
        // Retrieve the singleton for the GoogleAuth library and set up the client.
        auth2 = gapi.auth2.init({
            // client_id: '7087940352-ce573qthsm2s4s806bp9c82k3fnoid1n.apps.googleusercontent.com', //운영
            client_id: '866723235573-9n1vf056cqtccefdpn1a23mj5e8a9se0.apps.googleusercontent.com', //musign 테스트
            // cookiepolicy: 'http://localhost', //로컬
            // cookiepolicy: '//www.aklover.co.kr', //운영
            cookiepolicy: '//www.aklover-test.musign.kr', //musign 테스트
        });
        attachSignin(document.getElementById('btn_google'));
    });
};

function attachSignin(element) {
    auth2.attachClickHandler(element, {},
        function(googleUser) {
            $("#idcheckForm input[name='snsId']").val(googleUser.getBasicProfile().getId());
            $("#idcheckForm input[name='snsType']").val("google");
            $("#idcheckForm input[name='snsEmail']").val(googleUser.getBasicProfile().getEmail());
            $("#idcheckForm").submit();
        }, function(error) {
            //alert(JSON.stringify(error, undefined, 2));
            console.log(JSON.stringify(error, undefined, 2));
        }
    );
}

startApp();
</script>
<?include_once "tail.php";?>