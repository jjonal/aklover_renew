<?php
/**********************/
/*2017년 04월 03일
/*나아론(hide305@naver.com)
/*약관개정 메일 발송
/**********************/


define('_HEROBOARD_', TRUE);
include_once '/home/users/aekyung/freebest/head.php';
include_once '/home/users/aekyung/freebest/hero.php';
include_once '/home/users/aekyung/freebest/function.php';

db("aekyung");


/******************** 인증정보 ********************/
// 대량메일 인증 관련
$sendmail_url = "http://aekyungmktg.sendmail.cafe24.com/sendmail_api.php"; // 전송요청 URL
$secureKey = "182255305d10acc41a7949d4bf8bbd29"; // 인증키
$userId = "aekyungmktg"; // 발송자ID

/******************** 요청변수 처리 ********************/
// 메일발송 관련
$sender = "애경 서포터즈 AK LOVER"; // 발송자 이름
$email = "ak-cs@aekyung.kr"; // 발송자 이메일 
$receiverlistUrl= ($_POST['receiverlistUrl']) ? $_POST['receiverlistUrl'] : ''; // 수신자 리스트 URL

$num = 1;



/** 운영 **/ 
/*
$sql = "select hero_name, hero_mail from member where hero_use=0";
$res = mysql_query($sql) or die(mysql_error()); 
$cnt = mysql_num_rows($res);

$receiverlist .= "최혜윤차장님,hychoi@aekyung.kr";
while($rs = mysql_fetch_array($res)){

	$receiverlist .= "
	".$rs["hero_name"].",".$rs["hero_mail"]."
	";

	$num++;	
}//end while
*/
/************************/

/******** 테스트 **********/
	
	$receiverlist .= "최혜윤차장님,hychoi@aekyung.kr
					나아론님, hide304@nate.com
					최혜윤차장님, ouy72030@nate.com
					나아론님, hide305@naver.com";

/************************/

if($num == 0){
	exit;
}elseif($num > 0 && $num < 10){
	$receiverlist .=
	"테스트,no-reply-ak-cs1@aekyung.kr
	테스트,no-reply-ak-cs2@aekyung.kr
	테스트,no-reply-ak-cs3@aekyung.kr
	테스트,no-reply-ak-cs4@aekyung.kr
	테스트,no-reply-ak-cs5@aekyung.kr
	테스트,no-reply-ak-cs6@aekyung.kr
	테스트,no-reply-ak-cs7@aekyung.kr
	테스트,no-reply-ak-cs8@aekyung.kr
	테스트,no-reply-ak-cs9@aekyung.kr
	테스트,no-reply-ak-cs10@aekyung.kr";
	
}


// 메일내용 관련 
$subject = "AK LOVER 개인정보취급방침 및 개인정보처리방침 개정 안내"; // 메일 제목
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
    	<p style='font-weight:bold;padding:10px 20px;font-size:22px;font-family:Malgun Gothic,dotum;'>애경 서포터즈 AK LOVER 약관 개정 안내</p>
    </td>
</tr>
<tr>
	<td>
    	<p style='font-size:12px;font-family:Malgun Gothic,dotum;'>
        	<br/>
			안녕하세요.<br/><br/>
            애경 서포터즈 AK LOVER<a href='http://aklover.co.kr'>(www.aklover.co.kr)</a> 약관이 새롭게 개정되어 안내말씀 드립니다.<br/><br/>
            
            ● 주요 변경사항<br/>
            &nbsp;&nbsp;- 개인정보취급방침(폐기)<br/>
            &nbsp;&nbsp;- 개인정보처리방침(전면 개정)<br/>
            &nbsp;&nbsp;- <font color='#f00'>이용약관 변경</font><br/><br/>
            
            ● 변경약관 공고일 : 2017년 4월 07일<br/>
            ● 변경약관 시행일 : 2017년 4월 20일 예정       
        </p>
        <br/>
    </td>
</tr>

<tr>
    <td height='710'><img src='http://aklover.co.kr/image/mail/notice_170403.jpg'  width='655' border='0' /></td>
</tr>
<tr>
	<td style='text-align:center;' height='50'>
    	<a href='#' style='text-decoration:none;color:#000;background:#f2f2f2;border:1px solid #000; padding:10px 15px; border-radius:10px;font-family:Malgun Gothic,dotum;'>약관 개정 상세보기</a>
    </td>
</tr>
<tr>
    <td>
    	<p style='margin:0 0 0 0; padding:10px 20px; font-size:12px;line-height:16px; font-family:Malgun Gothic,dotum;'>
        	<span style='font-weight:bold;'>
            ※본 메일은 서비스 이용에 꼭 필요한 안내 메일로, 메일 수신 동의와 상관없이 발송되는 메일입니다.
            </span><br/>
            ※본 메일은 자동 발송되는 발신 전용 메일이므로 회신되지 않습니다.<br/>
            ※문의하실 내용이 있으실 경우, 1:1 상담 또는 고객만족팀으로 연락주시기 바랍니다.<br/>
        </p>
    </td>
</tr>	
<tr bgcolor='#ffc000'>
    <td align='center' style='border-top:1px solid #d4d4d4;'>
        <p style='font-size:11px; margin:10px 0;width:640px; font-family:Malgun Gothic,dotum;'>
        	애경산업(주)고객만족팀 080-024-1357 서울 구로구 가마산로 242<br/>
            Copyright(c) 2017 AEKYUNG CO., LTD. All Rights Reserved.
        </p>
      </td>
 </tr>
</table>
</body>
</html>";


// 수신자 처리 관련
$rejectType = ($_POST['rejectType']) ? $_POST['rejectType'] : 2; // 수신거부자 발송여부(2: 제외발송, 3:포함발송)
$overlapType = 2;

// 예약발송 관련
$sendType = ($_POST['sendType']) ? $_POST['sendType'] : 0; // 예약발송 여부(0:즉시발송, 1:예약발송)
$sendDate = ($_POST['sendDate']) ? $_POST['sendDate'] : ''; // 예약발송 시간(년-월-일 시:분:초)

// 파일첨부 관련
$file_name = $_FILES['addfile']['name'];
$tmp_name = $_FILES['addfile']['tmp_name'];
$content_type = $_FILES['addfile']['type'];

// 수신거부 기능 관련
$useRejectMemo = ($_POST['useRejectMemo']) ? $_POST['useRejectMemo'] : 1; // 수신거부 사용여부(0: 사용안함, 1: 사용)

// 요청 테스트
$testFlag = ($_POST['testFlag']) ? $_POST['testFlag'] : 0; // 요청 테스트 사용여부(0: 사용안함, 1: 사용)

/******************** 요청변수 처리 ********************/
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

// 헤더 생성
$header = "POST /".$path ." HTTP/1.0\r\n";
$header .= "Host: ".$host."\r\n";
$header .= "Content-type: multipart/form-data, boundary=".$boundary."\r\n";

// 본문 생성
foreach($mail AS $index => $value){
	$data .="--$boundary\r\n";
	$data .= "Content-Disposition: form-data; name=\"".$index."\"\r\n";
	$data .= "\r\n".$value."\r\n";
	$data .="--$boundary\r\n";
}

// 첨부파일
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