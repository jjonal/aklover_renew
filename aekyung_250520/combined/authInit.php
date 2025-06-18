<?php 
if(!defined('_HEROBOARD_'))exit;

$sitecode = "G4959";
$sitepasswd = "1T70U3BZYQGZ";
$cb_encode_path = FREEBEST_INC_END."CPClient_64bit"; //운영
//$cb_encode_path = FREEBEST_INC_END."CPClient"; //테스트
//$cb_encode_path = FREEBEST_INC_END."CPClient.exe"; //로컬

$authtype = "M";
$popgubun 	= "N";
$customize 	= "";
$reqseq = `$cb_encode_path SEQ $sitecode`;
//TODO 운영
$returnurl = "https://www.aklover.co.kr/freebest/hp_ok.php";
$errorurl = "https://www.aklover.co.kr/freebest/hp_no.php";

//테스트 
//$returnurl = "http://www.aklover.co.kr/freebest/hp_ok.php";
//$errorurl = "http://www.aklover.co.kr/freebest/hp_no.php";


//로컬
//$returnurl = "http://localhost/freebest/hp_ok.php";
//$errorurl = "http://localhost/freebest/hp_no.php";

$_SESSION["REQ_SEQ"] = $reqseq;
$plaindata =    "7:REQ_SEQ".strlen($reqseq).":".$reqseq ."8:SITECODE" . strlen($sitecode).":".$sitecode.
"9:AUTH_TYPE".strlen($authtype).":".$authtype."7:RTN_URL".strlen($returnurl).":".$returnurl.
"7:ERR_URL".strlen($errorurl).":".$errorurl."11:POPUP_GUBUN".strlen($popgubun).":".$popgubun.
"9:CUSTOMIZE".strlen($customize).":".$customize;
$enc_data = `$cb_encode_path ENC $sitecode $sitepasswd $plaindata`;
if($enc_data==-1){$returnMsg="암/복호화 시스템 오류입니다.";$enc_data="";
}else if($enc_data==-2){$returnMsg="암호화 처리 오류입니다.";$enc_data="";
}else if($enc_data==-3){$returnMsg="암호화 데이터 오류 입니다.";$enc_data="";
}else if($enc_data==-9){$returnMsg = "입력값 오류 입니다.";$enc_data = "";}
####################################################################################################################################################
$sSiteCode = "H505";
$sSitePw = "ak6458*lover";
$sModulePath = FREEBEST_INC_END."IPIN2Client";
$sReturnURL = "https://www.aklover.co.kr/freebest/ip_ok.php"; //운영
//$sReturnURL = "http://localhost/freebest/ip_ok.php";//로컬


$sCPRequest = `$sModulePath SEQ $sSiteCode`;
$_SESSION['CPREQUEST'] = $sCPRequest;
$sEncData = `$sModulePath REQ $sSiteCode $sSitePw $sCPRequest $sReturnURL`;

if($sEncData==-9){
	$sRtnMsg = "입력값 오류 : 암호화 처리시, 필요한 파라미터값의 정보를 정확하게 입력해 주시기 바랍니다.";
}else{
	$sRtnMsg = "$sEncData 변수에 암호화 데이타가 확인되면 정상, 정상이 아닌 경우 리턴코드 확인 후 NICE신용평가정보 개발 담당자에게 문의해 주세요.";
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