<? 
include_once "head.php";

if($_SESSION['temp_code']){
	error_historyBack("�α����� �Ǿ� �ֽ��ϴ�. �α� �ƿ� �Ŀ� �ٽ� �õ��� �ּ���.");
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
        <h2 class="fz48 fw500 main_c">ȸ������</h2>
		<p class="subtit fz12">AK Lover�� �پ��� ������� �����ϼ���!</p>
		<div class="bread">
			<ul class="f_c">
				<li class="on">��������</li>
				<li class="arr on"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
				<li>�̿��� ����</li>
				<li class="arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
				<li>���� ����(�ʼ�)</li>
				<!-- <li class="arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li><br /> -->
			</ul>
			<ul class="f_c">				
				<!-- <li>���� ����(����)</li> -->
				<li class="arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
				<li>ȸ������ �Ϸ�</li>
			</ul>
		</div>
    </div>
	<div class="contents">
		<div class="signup_wrap">
			<div id="signup_confirm">
				<p class="fz16 fw600">��������</p>
				<p class="fz14 fw500 subtit gray07">�� �ݵ�� ���� ���Ƿ� ���������� ���ֽñ� �ٶ��ϴ�.</p>
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
                            <a href="javascript:;" class="btn_lover" onClick="hp_Popup()"><img src="/img/front/member/mobile.webp" alt="�޴��� ����"></a>
						</form>	
						<span class="bar"></span>		
						<a href="javascript:;" onClick="loginKakao('idcheck')" class="btn_kakao"><img src="/img/front/member/kakaolog.webp" alt="īī�� �α���"></a>				
						<span class="bar"></span>
						<div id="naver_id_login" class="btn_naver rel">���̹��α���</div>
						<span class="bar"></span>
						<a href="javascript:;" id="btn_google" class="btn_google"><img src="/img/front/member/googlelog.webp" alt="���� �α���"></a>
					</div>
					<form name="idcheckForm" id="idcheckForm" method="post" action="/m/agreement.php?board=agreement">
						<input type="hidden" name="snsType">
						<input type="hidden" name="snsId">
						<input type="hidden" name="snsEmail">
					</form> 
				</div>
			</div>
			<div class="kakaplus">
				<p class="fz16 fw600">AK Lover īī���� �÷��� ģ�� �ȳ�</p>
				<p class="fz14 fw500 subtit gray07">AKLover������ ü��� �ű� ���ε�, ��÷��, ���, �ı⸶��, �����, ������û ��
				��� Ŀ�´����̼��� īī���� �÷��� ģ���� �����մϴ�.
				ȸ������ �� īī���忡�� ���ְ漭����� �˻� �� ä���� �߰��� ������! </p>
				<div class="imgbx">
					<img src="/img/front/member/kakaofriends.jpg" alt="īī���� �÷��� ģ�� �ȳ�">
					<ul class="f_c">
						<li>1.īī���� ����</li>
						<li>2.ģ�� �˻� '�ְ漭������'</li>
						<li>3.ģ���߰�</li>
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
    // naver_id_login.setDomain("https://aklover.co.kr"); //�
    naver_id_login.setDomain("http://aklover-test.musign.kr"); //musign �׽�Ʈ
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

//(s)210203 google ����
var googleUser = {};
var startApp = function() {
    gapi.load('auth2', function(){
        // Retrieve the singleton for the GoogleAuth library and set up the client.
        auth2 = gapi.auth2.init({
            // client_id: '7087940352-ce573qthsm2s4s806bp9c82k3fnoid1n.apps.googleusercontent.com', //�
            client_id: '866723235573-9n1vf056cqtccefdpn1a23mj5e8a9se0.apps.googleusercontent.com', //musign �׽�Ʈ
            // cookiepolicy: 'http://localhost', //����
            // cookiepolicy: '//www.aklover.co.kr', //�
            cookiepolicy: '//www.aklover-test.musign.kr', //musign �׽�Ʈ
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