<?php 
if(!defined('_HEROBOARD_'))exit;

$sitecode = "G4959";
$sitepasswd = "1T70U3BZYQGZ";
$cb_encode_path = FREEBEST_INC_END."CPClient_64bit"; //�
//$cb_encode_path = FREEBEST_INC_END."CPClient"; //�׽�Ʈ
//$cb_encode_path = FREEBEST_INC_END."CPClient.exe"; //����

$authtype = "M";
$popgubun 	= "N";
$customize 	= "";
$reqseq = `$cb_encode_path SEQ $sitecode`;
//TODO �
$returnurl = "https://www.aklover.co.kr/freebest/hp_ok.php";
$errorurl = "https://www.aklover.co.kr/freebest/hp_no.php";

//�׽�Ʈ 
//$returnurl = "http://www.aklover.co.kr/freebest/hp_ok.php";
//$errorurl = "http://www.aklover.co.kr/freebest/hp_no.php";


//����
//$returnurl = "http://localhost/freebest/hp_ok.php";
//$errorurl = "http://localhost/freebest/hp_no.php";

$_SESSION["REQ_SEQ"] = $reqseq;
$plaindata =    "7:REQ_SEQ".strlen($reqseq).":".$reqseq ."8:SITECODE" . strlen($sitecode).":".$sitecode.
"9:AUTH_TYPE".strlen($authtype).":".$authtype."7:RTN_URL".strlen($returnurl).":".$returnurl.
"7:ERR_URL".strlen($errorurl).":".$errorurl."11:POPUP_GUBUN".strlen($popgubun).":".$popgubun.
"9:CUSTOMIZE".strlen($customize).":".$customize;
$enc_data = `$cb_encode_path ENC $sitecode $sitepasswd $plaindata`;
if($enc_data==-1){$returnMsg="��/��ȣȭ �ý��� �����Դϴ�.";$enc_data="";
}else if($enc_data==-2){$returnMsg="��ȣȭ ó�� �����Դϴ�.";$enc_data="";
}else if($enc_data==-3){$returnMsg="��ȣȭ ������ ���� �Դϴ�.";$enc_data="";
}else if($enc_data==-9){$returnMsg = "�Է°� ���� �Դϴ�.";$enc_data = "";}
####################################################################################################################################################
$sSiteCode = "H505";
$sSitePw = "ak6458*lover";
$sModulePath = FREEBEST_INC_END."IPIN2Client";
$sReturnURL = "https://www.aklover.co.kr/freebest/ip_ok.php"; //�
//$sReturnURL = "http://localhost/freebest/ip_ok.php";//����


$sCPRequest = `$sModulePath SEQ $sSiteCode`;
$_SESSION['CPREQUEST'] = $sCPRequest;
$sEncData = `$sModulePath REQ $sSiteCode $sSitePw $sCPRequest $sReturnURL`;

if($sEncData==-9){
	$sRtnMsg = "�Է°� ���� : ��ȣȭ ó����, �ʿ��� �Ķ���Ͱ��� ������ ��Ȯ�ϰ� �Է��� �ֽñ� �ٶ��ϴ�.";
}else{
	$sRtnMsg = "$sEncData ������ ��ȣȭ ����Ÿ�� Ȯ�εǸ� ����, ������ �ƴ� ��� �����ڵ� Ȯ�� �� NICE�ſ������� ���� ����ڿ��� ������ �ּ���.";
}
?>
<script language='javascript'>
    window.name ="Parent_window";
    function hp_Popup(){
        window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
        document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
        document.form_chk.target = "popupChk";
        document.form_chk.submit();
    }
    function ip_Popup(){
        window.open('', 'popupIPIN2', 'width=450, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
        document.form_chk.target = "popupIPIN2";
        document.form_chk.action = "https://cert.vno.co.kr/ipin.cb";
        document.form_chk.submit();
    }
</script>