<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
        <meta name="Keywords" content="AK LOVER" />
        <meta name="Description" content="" />
        <title>AK LOVER</title>
    </head>
<body>
<?php
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once                                                        '../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'function.php';
$sitecode="G4959";
$sitepasswd="1T70U3BZYQGZ";
$cb_encode_path = FREEBEST_INC_END."CPClient_64bit";
//$cb_encode_path = FREEBEST_INC_END."CPClient"; //�׽�Ʈ:84
//$cb_encode_path = FREEBEST_INC_END."CPClient.exe"; //����
$enc_data = $_REQUEST["EncodeData"];
$sReserved1 = $_REQUEST['param_r1'];
$sReserved2 = $_REQUEST['param_r2'];
$sReserved3 = $_REQUEST['param_r3'];
//���� url
$wheretogo = $_REQUEST['wheretogo'];
//////////////////////////////////////////////// ���ڿ� ����///////////////////////////////////////////////
if(preg_match("/[#\&\\-%@\\\:;,\.\'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", $enc_data, $match)) {echo "���ڿ� ���� : ".$match[0]; exit;}

if(preg_match('~[^0-9a-zA-Z+/=]~', $enc_data, $match)) {echo "�Է� �� Ȯ���� �ʿ��մϴ�"; exit;}
if(base64_encode(base64_decode($enc_data))!= $enc_data) {echo " �Է� �� Ȯ���� �ʿ��մϴ�"; exit;}

if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved1, $match)) {echo "���ڿ� ���� : ".$match[0]; exit;}
if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved2, $match)) {echo "���ڿ� ���� : ".$match[0]; exit;}
if(preg_match("/[#\&\\+\-%@=\/\\\:;,\.\'\"\^`~\_|\!\/\?\*$#<>()\[\]\{\}]/i", $sReserved3, $match)) {echo "���ڿ� ���� : ".$match[0]; exit;}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if($enc_data!= ""){
    $plaindata = `$cb_encode_path DEC $sitecode $sitepasswd $enc_data`;
    if ($plaindata == -1){
        $returnMsg  = "��/��ȣȭ �ý��� ����";
    }else if ($plaindata == -4){
        $returnMsg  = "��ȣȭ ó�� ����";
    }else if ($plaindata == -5){
        $returnMsg  = "HASH�� ����ġ - ��ȣȭ �����ʹ� ���ϵ�";
    }else if ($plaindata == -6){
        $returnMsg  = "��ȣȭ ������ ����";
    }else if ($plaindata == -9){
        $returnMsg  = "�Է°� ����";
    }else if ($plaindata == -12){
        $returnMsg  = "����Ʈ ��й�ȣ ����";
    }else{
        $ciphertime = `$cb_encode_path CTS $sitecode $sitepasswd $enc_data`;
        $requestnumber = GetValue($plaindata , "REQ_SEQ");
        $responsenumber = GetValue($plaindata , "RES_SEQ");
        $authtype = GetValue($plaindata , "AUTH_TYPE");
        $name = GetValue($plaindata , "NAME");
        $birthdate = GetValue($plaindata , "BIRTHDATE");
        $gender = GetValue($plaindata , "GENDER");
        $nationalinfo = GetValue($plaindata , "NATIONALINFO");
        $dupinfo = GetValue($plaindata , "DI");
        $conninfo = GetValue($plaindata , "CI");
        if(strcmp($_SESSION["REQ_SEQ"], $requestnumber) != 0){
//            echo "���ǰ��� �ٸ��ϴ�. �ùٸ� ��η� �����Ͻñ� �ٶ��ϴ�.<br>";
            $requestnumber = "";
            $responsenumber = "";
            $authtype = "";
            $name = "";
            $birthdate = "";
            $gender = "";
            $nationalinfo = "";
            $dupinfo = "";
            $conninfo = "";
            echo '<script>alert("���ǰ��� �ٸ��ϴ�. �ùٸ� ��η� �����Ͻñ� �ٶ��ϴ�.");window.open("about:blank","_self").close();</script>';exit;
            exit;
        }
    }
}
function GetValue($str,$name){
    $pos1 = 0;
    $pos2 = 0;
    while($pos1<=strlen($str)){
        $pos2 = strpos($str,":",$pos1);
        $len = substr($str,$pos1,$pos2-$pos1);
        $key = substr($str,$pos2+1,$len);
        $pos1 = $pos2+$len+1;
        if($key==$name){
            $pos2 = strpos($str,":",$pos1);
            $len = substr($str,$pos1,$pos2-$pos1);
            $value = substr($str,$pos2+1,$len);
            return $value;
        }else{
            $pos2 = strpos($str,":",$pos1);
            $len = substr($str,$pos1,$pos2-$pos1);
            $pos1 = $pos2+$len+1;
        }
    }
}
if(strcmp($name, "")){
?>
<script language='javascript'>
function fnLoad(){
var wheretogo = parent.opener.parent.document.form_chk.wheretogo.value;
parent.opener.parent.document.form_chk.param_r1.value = "<?= $name ?>";
parent.opener.parent.document.form_chk.param_r2.value = "<?= $birthdate ?>";
parent.opener.parent.document.form_chk.param_r3.value = "<?= $gender ?>";
parent.opener.parent.document.form_chk.param_r4.value = "<?= $authtype ?>";
parent.opener.parent.document.form_chk.param_r5.value = "<?= $dupinfo ?>";
parent.opener.parent.document.form_chk.param_r6.value = "<?= $conninfo ?>";
parent.opener.parent.document.form_chk.target = "Parent_window";
parent.opener.parent.document.form_chk.action = "<?=MAIN_HOME.'?board='?>"+wheretogo;
parent.opener.parent.document.form_chk.submit();
self.close();
}
</script>
</head>
<body onLoad="fnLoad()">
<?
}else{
?>
<body onLoad='window.open("about:blank","_self").close();'>
<body>
<center>
<br><br><br>
<p><p><p><p>
���������� �Ϸ� �Ǿ����ϴ�.<br><br>
<a href='javascript:window.open("about:blank","_self").close();' class="btn_blue2"><?=img2('IMAGE_END||member||btn_without.gif||�Ϸ�');?></a></td>
    </tr>
</form><!--fnLoad();window.open("about:blank","_self").close();-->
<?
}
?>