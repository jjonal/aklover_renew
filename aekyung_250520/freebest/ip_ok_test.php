<?php 
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        './head.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
        <meta name="Keywords" content="AK LOVER" />
        <meta name="Description" content="" />
        <title>AK LOVER</title>
    </head>
<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
//if(!defined('_HEROBOARD_'))exit;
$sResponseData = $_REQUEST['enc_data'];
$sReservedParam1  = $_REQUEST['param_r1'];
$sReservedParam2  = $_REQUEST['param_r2'];
$sReservedParam3  = $_REQUEST['param_r3'];

//http로 변경 후 160622
$sendUrl = "https://www.aklover.co.kr/freebest/ip_no_test.php";

//////////////////////////////////////////////// 문자열 점검///////////////////////////////////////////////
if(preg_match("/[#\&\\-%@\\\:;,\.\'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", $sResponseData, $match)) {echo "문자열 점검 : ".$match[0]; exit;}

if(preg_match('~[^0-9a-zA-Z+/=]~', $sResponseData, $match)) {echo "입력 값 확인이 필요합니다"; exit;}
if(base64_encode(base64_decode($sResponseData))!= $sResponseData) {echo " 입력 값 확인이 필요합니다"; exit;}

if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReservedParam1, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReservedParam2, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReservedParam3, $match)) {echo "문자열 점검 : ".$match[0]; exit;}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
// 암호화된 사용자 정보가 존재하는 경우
if ($sResponseData != "") {
?>
<script language='javascript'>
function fnLoad(){
    parent.opener.parent.document.form_chk.enc_data.value = "<?= $sResponseData ?>";
    parent.opener.parent.document.form_chk.param_r1.value = "<?= $sReservedParam1 ?>";
    parent.opener.parent.document.form_chk.param_r2.value = "<?= $sReservedParam2 ?>";
    parent.opener.parent.document.form_chk.param_r3.value = "<?= $sReservedParam3 ?>";
    //parent.opener.parent.document.form_chk.target = "Parent_window";
    parent.opener.parent.document.form_chk.action = "<?=$sendUrl;?>";
    parent.opener.parent.document.form_chk.submit();
    //self.close();
}
</script>
</head>
<body onLoad="fnLoad()">
<?
}else{
?>
<body onLoad="self.close()">
<?
}
?>
