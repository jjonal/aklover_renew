<?php
/**********************/
/*2017�� 04�� 03��
/*���Ʒ�(hide305@naver.com)
/*������� ���� �߼�
/**********************/


define('_HEROBOARD_', TRUE);
include_once '/home/users/aekyung/freebest/head.php';
include_once '/home/users/aekyung/freebest/hero.php';
include_once '/home/users/aekyung/freebest/function.php';

db("aekyung");


/******************** �������� ********************/
// �뷮���� ���� ����
$sendmail_url = "http://aekyungmktg.sendmail.cafe24.com/sendmail_api.php"; // ���ۿ�û URL
$secureKey = "182255305d10acc41a7949d4bf8bbd29"; // ����Ű
$userId = "aekyungmktg"; // �߼���ID

/******************** ��û���� ó�� ********************/
// ���Ϲ߼� ����
$sender = "�ְ� �������� AK LOVER"; // �߼��� �̸�
$email = "ak-cs@aekyung.kr"; // �߼��� �̸��� 
$receiverlistUrl= ($_POST['receiverlistUrl']) ? $_POST['receiverlistUrl'] : ''; // ������ ����Ʈ URL

$num = 1;



/** � **/ 
/*
$sql = "select hero_name, hero_mail from member where hero_use=0";
$res = mysql_query($sql) or die(mysql_error()); 
$cnt = mysql_num_rows($res);

$receiverlist .= "�����������,hychoi@aekyung.kr";
while($rs = mysql_fetch_array($res)){

	$receiverlist .= "
	".$rs["hero_name"].",".$rs["hero_mail"]."
	";

	$num++;	
}//end while
*/
/************************/

/******** �׽�Ʈ **********/
	
	$receiverlist .= "�����������,hychoi@aekyung.kr
					���Ʒд�, hide304@nate.com
					�����������, ouy72030@nate.com
					���Ʒд�, hide305@naver.com";

/************************/

if($num == 0){
	exit;
}elseif($num > 0 && $num < 10){
	$receiverlist .=
	"�׽�Ʈ,no-reply-ak-cs1@aekyung.kr
	�׽�Ʈ,no-reply-ak-cs2@aekyung.kr
	�׽�Ʈ,no-reply-ak-cs3@aekyung.kr
	�׽�Ʈ,no-reply-ak-cs4@aekyung.kr
	�׽�Ʈ,no-reply-ak-cs5@aekyung.kr
	�׽�Ʈ,no-reply-ak-cs6@aekyung.kr
	�׽�Ʈ,no-reply-ak-cs7@aekyung.kr
	�׽�Ʈ,no-reply-ak-cs8@aekyung.kr
	�׽�Ʈ,no-reply-ak-cs9@aekyung.kr
	�׽�Ʈ,no-reply-ak-cs10@aekyung.kr";
	
}


// ���ϳ��� ���� 
$subject = "AK LOVER ����������޹�ħ �� ��������ó����ħ ���� �ȳ�"; // ���� ����
$content ="
<!doctype html>
<html lang='ko'>
<head>
</head>
<body>
<table align='center' width='655' border='0' cellspacing='0' cellpadding='0'>
<tr>
	<td><img src='http://aklover.co.kr/image/mail/mail170403_top.png' width='655'/></td>
</tr>
<tr>
	<td style='text-align:center;border-top:1px solid #ff9900; border-bottom:1px solid #ff9900;'>
    	<p style='font-weight:bold;padding:10px 20px;font-size:22px;font-family:Malgun Gothic,dotum;'>�ְ� �������� AK LOVER ��� ���� �ȳ�</p>
    </td>
</tr>
<tr>
	<td>
    	<p style='font-size:12px;font-family:Malgun Gothic,dotum;'>
        	<br/>
			�ȳ��ϼ���.<br/><br/>
            �ְ� �������� AK LOVER<a href='http://aklover.co.kr'>(www.aklover.co.kr)</a> ����� ���Ӱ� �����Ǿ� �ȳ����� �帳�ϴ�.<br/><br/>
            
            �� �ֿ� �������<br/>
            &nbsp;&nbsp;- ����������޹�ħ(���)<br/>
            &nbsp;&nbsp;- ��������ó����ħ(���� ����)<br/>
            &nbsp;&nbsp;- <font color='#f00'>�̿��� ����</font><br/><br/>
            
            �� ������ ������ : 2017�� 4�� 07��<br/>
            �� ������ ������ : 2017�� 4�� 20�� ����       
        </p>
        <br/>
    </td>
</tr>

<tr>
    <td height='710'><img src='http://aklover.co.kr/image/mail/notice_170403.jpg'  width='655' border='0' /></td>
</tr>
<tr>
	<td style='text-align:center;' height='50'>
    	<a href='#' style='text-decoration:none;color:#000;background:#f2f2f2;border:1px solid #000; padding:10px 15px; border-radius:10px;font-family:Malgun Gothic,dotum;'>��� ���� �󼼺���</a>
    </td>
</tr>
<tr>
    <td>
    	<p style='margin:0 0 0 0; padding:10px 20px; font-size:12px;line-height:16px; font-family:Malgun Gothic,dotum;'>
        	<span style='font-weight:bold;'>
            �غ� ������ ���� �̿뿡 �� �ʿ��� �ȳ� ���Ϸ�, ���� ���� ���ǿ� ������� �߼۵Ǵ� �����Դϴ�.
            </span><br/>
            �غ� ������ �ڵ� �߼۵Ǵ� �߽� ���� �����̹Ƿ� ȸ�ŵ��� �ʽ��ϴ�.<br/>
            �ع����Ͻ� ������ ������ ���, 1:1 ��� �Ǵ� ������������ �����ֽñ� �ٶ��ϴ�.<br/>
        </p>
    </td>
</tr>	
<tr bgcolor='#ffc000'>
    <td align='center' style='border-top:1px solid #d4d4d4;'>
        <p style='font-size:11px; margin:10px 0;width:640px; font-family:Malgun Gothic,dotum;'>
        	�ְ���(��)�������� 080-024-1357 ���� ���α� ������� 242<br/>
            Copyright(c) 2017 AEKYUNG CO., LTD. All Rights Reserved.
        </p>
      </td>
 </tr>
</table>
</body>
</html>";


// ������ ó�� ����
$rejectType = ($_POST['rejectType']) ? $_POST['rejectType'] : 2; // ���Űź��� �߼ۿ���(2: ���ܹ߼�, 3:���Թ߼�)
$overlapType = 2;

// ����߼� ����
$sendType = ($_POST['sendType']) ? $_POST['sendType'] : 0; // ����߼� ����(0:��ù߼�, 1:����߼�)
$sendDate = ($_POST['sendDate']) ? $_POST['sendDate'] : ''; // ����߼� �ð�(��-��-�� ��:��:��)

// ����÷�� ����
$file_name = $_FILES['addfile']['name'];
$tmp_name = $_FILES['addfile']['tmp_name'];
$content_type = $_FILES['addfile']['type'];

// ���Űź� ��� ����
$useRejectMemo = ($_POST['useRejectMemo']) ? $_POST['useRejectMemo'] : 1; // ���Űź� ��뿩��(0: ������, 1: ���)

// ��û �׽�Ʈ
$testFlag = ($_POST['testFlag']) ? $_POST['testFlag'] : 0; // ��û �׽�Ʈ ��뿩��(0: ������, 1: ���)

/******************** ��û���� ó�� ********************/
$mail['secureKey'] = $secureKey;
$mail['userId'] = $userId;
$mail['sender'] = base64_encode($sender);
$mail['email'] = base64_encode($email);
$mail['receiverlist'] = base64_encode($receiverlist);
$mail['receiverlistUrl'] = base64_encode($receiverlistUrl);
$mail['subject'] = base64_encode($subject);
$mail['content'] = base64_encode($content);
$mail['rejectType'] = $rejectType;
$mail['overlapType'] = $overlapType;
$mail['sendType'] = $sendType;
$mail['sendDate'] = $sendDate;
$mail['useRejectMemo'] = $useRejectMemo;
$mail['testFlag'] = $testFlag;

$host_info = explode("/", $sendmail_url);
$host = $host_info[2];
$path = $host_info[3]."/".$host_info[4];

srand((double)microtime()*1000000);
$boundary = "---------------------".substr(md5(rand(0,32000)),0,10);

// ��� ����
$header = "POST /".$path ." HTTP/1.0\r\n";
$header .= "Host: ".$host."\r\n";
$header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";

// ���� ����
foreach($mail AS $index => $value){
	$data .="--$boundary\r\n";
	$data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
	$data .= "\r\n".$value."\r\n";
	$data .="--$boundary\r\n";
}

// ÷������
if (is_uploaded_file($_FILES['addfile']['tmp_name'])) { 
	$data .= "--$boundary\r\n";
	$content_file = join("", file($tmp_name));
	$data .="Content-Disposition: form-data; name=\"addfile\"; filename=\"".$file_name."\"\r\n";
	$data .= "Content-Type: $content_type\r\n\r\n";
	$data .= "".$content_file."\r\n";
	$data .="--$boundary--\r\n";
}
$header .= "Content-length: " . strlen($data) . "\r\n\r\n";

$fp = fsockopen($host, 80);

if ($fp) { 
	fputs($fp, $header.$data);

	$rsp = '';
    while(!feof($fp)) { 
		$rsp .= fgets($fp,8192); 
	}	

	fclose($fp);

	$msg = explode("\r\n\r\n",trim($rsp));
	echo $msg[1];
}
else {
	echo "Connection Failed";
}


?>