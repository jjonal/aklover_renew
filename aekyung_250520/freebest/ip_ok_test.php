<?php 
define('_HEROBOARD_', TRUE);//HEROBOARD����
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
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
//if(!defined('_HEROBOARD_'))exit;
$sResponseData = $_REQUEST['enc_data'];
$sReservedParam1  = $_REQUEST['param_r1'];
$sReservedParam2  = $_REQUEST['param_r2'];
$sReservedParam3  = $_REQUEST['param_r3'];

//http�� ���� �� 160622
$sendUrl = "https://www.aklover.co.kr/freebest/ip_no_test.php";

//////////////////////////////////////////////// ���ڿ� ����///////////////////////////////////////////////
if(preg_match("/[#\&\\-%@\\\:;,\.\'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", $sResponseData, $match)) {echo "���ڿ� ���� : ".$match[0]; exit;}

if(preg_match('~[^0-9a-zA-Z+/=]~', $sResponseData, $match)) {echo "�Է� �� Ȯ���� �ʿ��մϴ�"; exit;}
if(base64_encode(base64_decode($sResponseData))!= $sResponseData) {echo " �Է� �� Ȯ���� �ʿ��մϴ�"; exit;}

if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReservedParam1, $match)) {echo "���ڿ� ���� : ".$match[0]; exit;}
if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReservedParam2, $match)) {echo "���ڿ� ���� : ".$match[0]; exit;}
if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReservedParam3, $match)) {echo "���ڿ� ���� : ".$match[0]; exit;}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
// ��ȣȭ�� ����� ������ �����ϴ� ���
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
