<? 
include_once "head.php";

// ȸ������ �ӽ��۾� s 
 if(!$_SESSION['temp_level'] || $_SESSION['temp_level']<9999){
 	if((!$_POST['param_r5'] || !$_POST['param_r6']) && (!$_POST['snsId'] || !$_POST['snsType'])){
	
 		if($_GET["tempNoAuth"] != "Y") {
 			error_historyBack("�� ���� �����Դϴ�.");
 			exit;
 		} else {
 			$_POST['param_r5'] = "tempNoAuth".date("YmdHis");
 			$_POST['param_r6'] = "tempNoAuth".date("YmdHis");
 			$di = $_POST['param_r5'];
 			$ci = $_POST['param_r6'];
 			$_POST["param_r1"] = "�׽�Ʈ�̸���";
 		}
 	}
	
 	if($_POST['param_r5'] && $_POST['param_r6']){ //�������� di,ci
 		$_SESSION["auth"]["hero_name"]   = $_POST["param_r1"];
 		$_SESSION["auth"]["hero_jumin"]  = $_POST["param_r2"];
 		$_SESSION["auth"]["hero_sex"]    = $_POST["param_r3"];
 		$_SESSION["auth"]["hero_info_type"]   = $_POST["param_r4"];
 		$_SESSION["auth"]["hero_info_di"]   = $_POST["param_r5"];
 		$_SESSION["auth"]["hero_info_ci"]   = $_POST["param_r6"];
		
 		$sql = " SELECT count(*) FROM member WHERE hero_info_di='".$_POST['param_r5']."' AND hero_info_ci='".$_POST['param_r6']."' and hero_use=0";
 	} else if($_POST['snsId'] && $_POST['snsType']) {  //sns ����
 		$_SESSION["auth"]["snsId"]   = $_POST["snsId"];
 		$_SESSION["auth"]["snsType"]  = $_POST["snsType"];
 		$_SESSION["auth"]["snsEmail"]  = $_POST["snsEmail"];
		
 		$snsType = $_POST["snsType"];
		
 		switch($snsType){
 			case "kakaoTalk" : $snsText = "<p style='padding-bottom: 2rem; font-size: 12px;'><img src='/img/front/member/kakaolog.webp' alt='".$snsType."' style='width: 33px; margin-right: .5rem'> ȸ������ īī������ �����Ǿ����ϴ�</p>";break;
 			case "naver" : $snsText = "<p style='padding-bottom: 2rem; font-size: 12px;'><img src='/img/front/member/naverlog.webp' alt='".$snsType."' style='width: 33px; margin-right: .5rem'> ȸ������ ���̹� ���̵� �����Ǿ����ϴ�</p>";break;
 			case "google" : $snsText = "<p style='padding-bottom: 2rem; font-size: 12px;'><img src='/img/front/member/googlelog.webp' alt='".$snsType."' style='width: 33px; margin-right: .5rem'> ȸ������ ���� ���̵� �����Ǿ����ϴ�</p>";break;
 		}
		
 		$sql = "SELECT count(*) from member WHERE hero_".$_POST['snsType']."= md5('".$_POST['snsId']."') and hero_use=0";
 	}

 	$res = new_sql($sql,$error,"on");
 	$check_member = mysql_result($res,0,0);
	
 	if($check_member>0){
 		error_location("�̹� �����ϼ̽��ϴ�.","/m/searchIdPw.php?board=findpw");
 		exit;
 	}
	
 	//�޸����� üũ
 	if($_POST['param_r5'] && $_POST['param_r6']){
 		$sql1 = "SELECT count(*) FROM member_backup WHERE hero_info_di='".$_POST['param_r5']."' and hero_info_ci='".$_POST['param_r6']."'";
 	}else if($_POST['snsId'] && $_POST['snsType']){
 		$sql1 = "SELECT count(*) FROM member_backup WHERE hero_".$_POST['snsType']."=MD5('".$_POST['snsId']."')";
 	}
	
 	$out_sql1 = new_sql($sql1,$error);
	
 	$count1 = mysql_result($out_sql1,0,0);
 	if($count1>0){
 		error_location("�ش� ȸ���� �޸� �����Դϴ�.ID/PWã�⸦ ���� �α��� �Ͽ� �ֽʽÿ�.","/m/searchIdPw.php?board=findpw");
 		exit;
 	}
	
 	//�������� üũ
 	if($_POST['param_r5'] && $_POST['param_r6'] && $_POST['param_r2']){
 		$param_r2_01 = substr($_POST['param_r2'], '0', '4');//��
 		$param_r2_02 = substr($_POST['param_r2'], '4', '2');//��
 		$param_r2_03 = substr($_POST['param_r2'], '6', '2');//��
		
 		if(!$param_r2_01 || !$param_r2_02 || !$param_r2_03){
 			error_location("�ý��� �����Դϴ�. �ٽ� �õ����ּ���","/m/joinCheck.php");
 			exit;
 		}
		
 		include_once $_SERVER['DOCUMENT_ROOT']."/classGathered/chAgeClass.php";
 		$chAgeClass = new chAgeClass($param_r2_01,$param_r2_02,$param_r2_03);
 		$age = $chAgeClass->countUniversalAge();
 		if((int)$age<15){
 			error_location("��14�� �̸��� �����Ͻ� �� �����ϴ�.","/m/main.php");
 			exit;
 		}
 	}
 }
// ȸ������ �ӽ��۾� e


$group_sql = " SELECT * from hero_group where hero_order!='0' and hero_use='1' and hero_board ='".$_GET['board']."' "; // desc
$out_group = new_sql( $group_sql,$error );
if((string)$out_group==$error){
	error_historyBack("");
	exit;
}
$right_list = mysql_fetch_assoc ( $out_group );
?>
<link href="/m/css/musign/member.css" rel="stylesheet" type="text/css">
<div class="contents_area mu_member join_wrap">	
	<div class="page_title t_c">
        <h2 class="fz48 fw500 main_c">ȸ������</h2>
		<p class="subtit fz12">AK Lover�� �پ��� ������� �����ϼ���!</p>
		<div class="bread">
			<ul class="f_c">
				<li>��������</li>
				<li class="arr"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
				<li class="on">�̿��� ����</li>
				<li class="arr on"><img src="/img/front/icon/bread.webp" alt="ȭ��ǥ"></li>
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
	<div class="signup_wrap">
		<div class="contents">
			<form name="form0" id="form0" method="post">
				<input type="hidden" name="tempNoAuth" value="<?=$_GET["tempNoAuth"]?>" /><!-- ȸ������ �׽�Ʈ �뵵 ���� ���� -->
				<?=$snsText?>
				<div class="signup_term line_input">
					<div class="signup_term_title fz16 fw600">�ְ��� ���� ȸ�� ���</div>
					<div class="all_agree agree_list input_chk">
					<input type="checkbox" id="necessary"> 
					<label for="necessary" class="input_chk_label">�ְ����� ��� ����� Ȯ���ϰ� ��ü �����մϴ�.</label>
					<p class="desc">
							��ü���Ǵ� �ʼ� �� ���������� ���� ���ǵ� ���ԵǾ� ������, 
							���������ε� ���Ǹ� �����Ͻ� �� �ֽ��ϴ�.
							�����׸� ���� ���Ǹ� �ź��ϴ� ��쿡�� ȸ������ ���񽺴� �̿� �����մϴ�.
						</p>
					</div>
					<div class="agree_list input_chk">
						<input type="checkbox" name="agree_service" id="agree_service_y" value="Y" />
						<label for="agree_service_y" class="input_chk_label"><span class="fz14 bold main_c">�ʼ�*</span>�̿����� �����մϴ�.</label>
						<!-- <input type="radio" name="agree_service" id="agree_service_n" value="N" /><label for="agree_service_n">���Ǿ��� -->
						<div class="term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">���� �̿��� (�ʼ�)</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>
								<div class="scrollbx"><?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term1_2.php";?></div>
							</div>	
						</div>
						<div class="all_view">��ü����</div>
					</div>
					<div class="agree_list input_chk">
					<input type="checkbox" name="agree_privacy" id="agree_privacy_y" value="Y" />					
						<label for="agree_privacy_y" class="input_chk_label"><span class="fz14 bold main_c">�ʼ�*</span>�������� ����<b></b>�̿뵿�� �ʼ� �׸�</label>
						<!-- <input type="radio" name="agree_privacy" id="agree_privacy_n" value="N" />���Ǿ��� -->
						<div class="term table_term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">�������� ���� ���� (�ʼ�)
								<p class="fz24">* �ش� �������� ���� �� �̿뿡 �������� ���� �Ǹ��� ������,<br /> �������� ���� ��� ȸ�������� �Ұ��մϴ�.
								</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>							
								<div id="term4" class="scrollbx">
									<table border="1" cellspacing="0" cellpadding="2">
										<tr>
											<td>����<br />�׸�</td>
											<td>���̵�, ��й�ȣ, �̸�, �г���, �������, �̸���, �޴�����ȣ, �ּ�,
											�������� ��(�޴�������), <br>
											SNS �α��� ������ <br>
											- īī���� : īī���忡�� �����ϴ� �������̵�<br/>
											- ���̹� : ���̹����� �����ϴ� �������̵�, �̸���<br/>
											- ���� : ���ۿ��� �����ϴ� �������̵�, �̸���</td>
											<td>�̸�, �г���, �޴�����ȣ</td>
										</tr>
										<tr>
											<td>���� ��<br /> �̿�<br />����</td>
											<td>���� �̿뿡 ���� ���νĺ�, ���Կ��� Ȯ��, ȸ���� �����̿� ����,<br/>
											�� ���ǿ� ���� �亯, �����ǻ�Ȯ��, �Ҹ�ó�� ���� ���� �ǻ���� ��� Ȯ��,<br/>
											��� �� ��å �ȳ�, ȸ���� ������ ü��� Ȱ���� ���� ���� ���� �� �׿� ���� ��ǰ ���</td>
											<td>ȸ�� Ż�� �� �����ǿ� ���� �亯,<br/>
												�Ҹ� ó���� ���� �ǻ���� ��� Ȯ��,<br/>
												���� ���� �̿����</td>
										</tr>
										<tr>
											<td>�̿� ��<br /> ����<br /> �Ⱓ</td>
											<td>���� öȸ �� Ȥ�� ȸ�� Ż�� �ñ���</td>
											<td>ȸ��Ż�� �� 1�Ⱓ ����</td>
										</tr>
									</table>
								</div>								
							</div>	
						</div>						
						<div class="all_view">��ü����</div>
					</div>
					<!-- <div class="agree_list input_chk">
					<input type="checkbox" name="selectAgreePrivacy" id="selectAgreePrivacy_y" value="Y" />		
						<label for="selectAgreePrivacy_y" class="input_chk_label">�������� ����<b></b>�̿뵿�� �����׸� (����)</label>
						<div class="term table_term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">�������� ���� ���� (����)
									<p class="fz24">�ش� �������� ���� �� �̿뿡 ���ؼ� �������� ���� �Ǹ��� ������ �������� ������ ��쿡�� ȸ�������� �����մϴ�.<br />
									��, Ư�� ������ �̿��� ���ѵ� �� �ֽ��ϴ�.</p>
								</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>							
								<div id="term4" class="scrollbx">
									<table border="1" cellspacing="0" cellpadding="2">
										<tr>
											<td>����<br />�׸�</td>
											<td>
											�� �Ʒ� �׸� �� ȸ���� �����ϴ� �׸�<br/>
											AK LOVER�� �˰Ե� ��δ�?, ��õ�� ���̵� �Ǵ� �г���,<br/> 
											���� SNS URL
											, ���̹� ��α� URL
											, �ν�Ÿ�׷� URL
											, ���̹� ���÷�� Ȩ
											, ���÷�� ��
											, Ȱ�� ī�װ�
											, �׿� SNS URL(���̽��� URL, Ʈ���� URL, īī�����丮 URL ��)
											, ��Ʃ�� URL
											, ���̹� TV URL 
											, ƽ�� URL
											, ��Ÿ URL 
											��ȥ����, �ڳ� ����/�¾ �⵵,<br/> 
											Ż�� ����, �ݷ����� ����, ������ ����, �ı⼼ô�� ����,<br/> 
											AK LOVER �� ������ ����, AK LOVER�� Ȱ���ϴ� ��������/ü��� ī�� �Ǵ� Ȩ������
											</td>
											<td>�޴�����ȣ</td>
											<td>�̸���</td>
										</tr>
										<tr>
											<td>���� ��<br /> �̿�<br /> ����</td>
											<td>��Ȱ�� ü��� Ȱ�� ����͸�/���� Ư���� ���� ü��� Ȱ�� ����<br />
											�ű� ���� ����,, �̺�Ʈ �� ���� ���� ���� �� ������ȸ ����,<br />
											�α�������� Ư���� ���� ���� ���� �� ���� ����, ������ ��ȿ�� Ȯ��,<br />
											���Ӻ� �ľ� �Ǵ� ȸ���� ���� �̿뿡 ���� ��� Ȯ���� ����</td>
											<td colspan="2">���� �̺�Ʈ, ��� ���� �����ȳ� �� ���� ������ Ȱ��,<br/> 
											��� ��ǰ/���� �ȳ� �� ����</td>
										</tr>
										<tr>
											<td>�̿� ��<br /> ����<br />�Ⱓ</td>
											<td colspan="3">ȸ��Ż�� �� ���ǰźνñ���</td>
										</tr>
									</table>
								</div>				
							</div>	
						</div>	
						<div class="all_view">��ü����</div>
					</div> -->
					<div class="agree_list agree_depth2 line_input input_chk">
						<input type="checkbox" id="event_agree" name="event_agree" class="" value=''/>
						<label for="event_agree" class="input_chk_label">���� �̺�Ʈ, ü���, ��� ���� ���� �ȳ� �� ���� ������ Ȱ��, ��� ��ǰ/���� �ȳ� �� ����(����)</label>
						<div>
							<input type="checkbox" name="selectAgreePhone" id="selectAgreePhone_y" value="Y" />
							<label for="selectAgreePhone_y" class="input_chk_label">SMS ���� ���� (����)</label>
							<!-- <input type="radio" name="selectAgreePhone" id="selectAgreePhone_n" value="N" />���Ǿ��� -->
						</div>	
						<div>
							<input type="checkbox" name="selectAgreeEmail" id="selectAgreeEmail_y" value="Y" />
							<label for="selectAgreeEmail_y" class="input_chk_label">�̸��� ���� ���� (����)</label>
							<!-- <input type="radio" name="selectAgreeEmail" id="selectAgreeEmail_n" value="N" />���Ǿ��� -->
						</div>
					</div>				
					<div class="agree_list">
						<p class="fz14 fw500 gray07">�ʼ� ��Ź����</p>	
						<div class="term table_term dis-no">
							<div class="inner rel">
								<h2 class="t_c fz24 bold">�ʼ� ��Ź����</h2>
								<div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="�ݱ�"></div>							
								<div class="scrollbx"><?php include_once $_SERVER['DOCUMENT_ROOT']."/popup/term7.php";?></div>
							</div>	
						</div>	
						<div class="all_view">��ü����</div>
					</div>					
					<div class="btn_bx f_c">
						<a href="javascript:;" onClick="fnJoin();" class="btn_submit btn_black">��������</a>
					</div>	
				</div>
			</form>
		</div>
	</div>	
</div>
<script>
$(document).ready(function(){
	// musign 
	// ��ü ���ǽ� 
	$('#necessary').change(function () {
		const $target = $(this),
			$checkbox = $('.agree_list input:checkbox');

		if ($target.prop('checked') === true) {
			$checkbox.prop('checked', true);
		} else {
			$checkbox.prop('checked', false);
		}
	});
	// �̺�Ʈ ���� ���� (��ü)��
	$('.agree_depth2 #event_agree').change(function () {
		const $target2 = $(this),
			$checkbox2 = $('.agree_depth2 input:checkbox');

		if ($target2.prop('checked') === true) {
			$checkbox2.prop('checked', true);
		} else {
			$checkbox2.prop('checked', false);
		}
	});
	// ��ü���� �˾� ����
	const allView = $('.agree_list .all_view');
	const termCont = $('.agree_list .term');
	$.each(allView, function(idx, item){
		$(this).click(function(){
			termCont.eq(idx).removeClass('dis-no');
			$('body').addClass('nonscroll');
		});
	});
	// ��ü���� �˾� �ݱ�
	$('.term .btn_x').click(function(){
		$(this).parents('.term').addClass('dis-no');
        $('body').removeClass('nonscroll');
	});
})

function fnJoin() {
	if($("input:checkbox[name='agree_service']:checked").val() != 'Y') {
		alert("���� �̿����� �������ּ���.");
		return;
	}
	if($("input:checkbox[name='agree_privacy']:checked").val() != 'Y') {
		alert("�������� �������̿뵿�ǿ� �������ּ���.");
		return;
	}
	$("#form0").attr("action","join.php?board=signup").submit();
}
</script>
<?include_once "tail.php";?>