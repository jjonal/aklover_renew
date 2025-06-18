<?php
$hero_name = "엄재민";
$hero_pw = "비밀";
//define the receiver of the email
//$to = 'youraddress@example.com';
//$to = '<heroboard2@naver.com>';
//$to = 'samul25@hanmail.net';
//$to = '<samul30@hanmail.net>';
$to = '<heroboard2@gmail.com>';
//$to = 'samul25@hanmail.net';
//define the subject of the email
$subject = 'Test HTML email'; 
//create a boundary string. It must be unique 
//so we use the MD5 algorithm to generate a random hash
$random_hash = md5(date('r', time())); 
//define the headers we want passed. Note that they are separated with \r\n
$frommail = '<admin@aklover.co.kr>'; 

$headers = "From: ".$frommail."\r\nReply-To: ".$frommail;
//add boundary string and mime type specification
$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\""; 
//define the body of the message.


//Content-Type: text/html; charset="iso-8859-1" 
ob_start(); //Turn on output buffering

?>

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="euc-kr" 
Content-Transfer-Encoding: 7bit

Hello World!!! 
This is simple text email message. 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="euc-kr" 
Content-Transfer-Encoding: 7bit


    <table>
        <tr>
            <td>
                <a href="http://www.aklover.co.kr/" target="_blank">
                    <img src="http://www.aklover.co.kr/code/image/member/mail_top.gif" alt="애경서포터즈" style="border:0;" />
                </a>
            </td>
        </tr>
        <tr>
            <td valign="middle" style="padding:25px; height:200px; font-size:12px; font-weight:bold;">
                <span style=" color:#F90;"><?=$hero_name?></span> 회원님, 회원가입완료되였습니다!<br><br><br>
                <span style=" color:#F90;"><?=$hero_name?></span> 회원님, 아이디는 <span style="color:#09C"><?=$hero_pw?></span>입니다!<br><br>
                <span style=" color:#F90;"><?=$hero_name?></span> 회원님, 비밀번호는 <span style="color:#09C"><?=$hero_pw?></span>입니다!
            </td>
        </tr>
        <tr>
            <td><img src="http://www.aklover.co.kr/code/image/member/mail_footer.gif" alt="애경산업(주) 서울시 구로구 구로동 83번지" /></td>
        </tr>
    </table>
<h2>Hello World!</h2>
<p>This is something with <b>HTML</b> formatting.</p> 
<?
    $IN_FILE_VAL = "mailform.php";
    include SUB_MEMBER_INC_END.$IN_FILE_VAL;
echo        $html = ob_get_contents();

?>
--PHP-alt-<?php echo $random_hash; ?>--
<?
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email

//$mail_sent = @mail( $to, $subject, $message, $headers );
$mail_sent = mail($to, $subject, $message, $headers, "-f".$frommail);
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent" : "Mail failed";
exit;
?>

<?php
if(strcmp($_POST['subject'],'')){

//define the receiver of the email
//$to = '<samul30@hanmail.net>';
$to = 'heroboard2@naver.com';
//define the subject of the email
$subject = Trim(stripslashes($_POST['subject']));;
//define the sender of the email
$from = Trim(stripslashes($_POST['from']));;
//create a boundary string. It must be unique
//so we use the MD5 algorithm to generate a random hash
$random_hash = md5(date('r', time()));
//define the headers we want passed. Note that they are separated with 
$frommail = $from;
$headers = "From: <$from>
Reply-To: <$from>";
//add boundary string and mime type specification
//$headers .= "Content-Type: multipart/mixed; boundary=\"PHP-mixed-\".$random_hash.""";
//Userfile information
$filename = $_FILES["userfile"]["name"][0]; // gives you the name of the file they uploaded

$filetype = $_FILES["userfile"]["type"][0]; // gives you the size of the upload in bytes
$filetemp = $_FILES["userfile"]["tmp_name"][0]; // gives you the temporary name of the file on the server until it is renamed
//read the atachment file contents into a string,
//encode it with MIME base64,
//and split it into smaller chunks
$data = base64_encode($filename);
//define the body of the message.
ob_start(); //Turn on output buffering
?>
--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>"

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/plain; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit

Hello World!!!
This is simple text email message.

Address is: <?php echo $_POST["address"]; ?>
Phone Number is: <?php echo $_POST["phone"]; ?>
Birthdate is: <?php echo $_POST["bdate"]; ?>

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/html; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit

<h2>Hello World!</h2>
<p>This is something with <b>HTML</b> formatting.</p>

<h1>Address is: <?php echo $_POST["address"]; ?></h1>
<p>Phone Number is: <?php echo $_POST["phone"]; ?><br />
Birthdate is: <?php echo $_POST["bdate"]; ?></p>

--PHP-alt-<?php echo $random_hash; ?>--

--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: $filetype; name=$filename
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

<?php echo $data; ?>
--PHP-mixed-<?php echo $random_hash; ?>--

<?php
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email
//$mail_sent = @mail( $to, $subject, $message, $headers );
$mail_sent = mail($to, $subject, $message, $headers, "-f".$frommail);
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed"
echo $mail_sent ? "Mail sent" : "Mail failed";
}
?>
<form action="<?=PATH_HOME?>?path=freebest/mail" method="post" enctype="multipart/form-data">
  <input name="from" type="text" VALUE="admin@aklover.co.kr"><br>
  <input name="subject" type="text"><br>
  <input name="userfile[]" type="file"><br>
  <input type="submit" value="Send files">
</form>


<?php 
exit;
//define the receiver of the email 
//$to = 'youraddress@example.com'; 
$to = 'heroboard2@naver.com';
//$to = '<samul30@hanmail.net>';
//define the subject of the email 
$subject = 'Test email with attachment'; 
//create a boundary string. It must be unique 
//so we use the MD5 algorithm to generate a random hash 
$random_hash = md5(date('r', time())); 
//define the headers we want passed. Note that they are separated with \r\n 
$frommail = '<admin@aklover.co.kr>'; 

$headers = "From: ".$frommail."\r\nReply-To: ".$frommail; 
//add boundary string and mime type specification 
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
//read the atachment file contents into a string,
//encode it with MIME base64,
//and split it into smaller chunks
//$attachment = chunk_split(base64_encode(file_get_contents('text.txt'))); 
$attachment = (file_get_contents('text.txt')); 
//define the body of the message. 
ob_start(); //Turn on output buffering 
?> 
--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>" 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

Hello World!!! 
This is simple text email message. 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<h2>Hello World!</h2> 
<p>This is something with <b>HTML</b> formatting.</p> 

--PHP-alt-<?php echo $random_hash; ?>-- 

--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: application/txt; name="text.txt"  
Content-Transfer-Encoding: base64  
Content-Disposition: text  

<?php echo $attachment; ?> 
--PHP-mixed-<?php echo $random_hash; ?>-- 

<?php 
//copy current buffer contents into $message variable and delete current output buffer 
$message = ob_get_clean(); 
//send the email 
//$mail_sent = @mail( $to, $subject, $message, $headers ); 
$mail_sent = mail($to, $subject, $message, $headers, "-f".$frommail);
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent" : "Mail failed"; 
exit;
?> 

<?php
//define the receiver of the email
//$to = 'youraddress@example.com';
//$to = 'heroboard2@naver.com';
//$to = 'samul25@hanmail.net';
$to = '<samul30@hanmail.net>';
//$to = 'samul25@hanmail.net';
//define the subject of the email
$subject = 'Test HTML email'; 
//create a boundary string. It must be unique 
//so we use the MD5 algorithm to generate a random hash
$random_hash = md5(date('r', time())); 
//define the headers we want passed. Note that they are separated with \r\n
$frommail = '<admin@aklover.co.kr>'; 

$headers = "From: ".$frommail."\r\nReply-To: ".$frommail;
//add boundary string and mime type specification
$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\""; 
//define the body of the message.
ob_start(); //Turn on output buffering
?>
--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

Hello World!!! 
This is simple text email message. 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<h2>Hello World!</h2>
<p>This is something with <b>HTML</b> formatting.</p> 

--PHP-alt-<?php echo $random_hash; ?>--
<?
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email

//$mail_sent = @mail( $to, $subject, $message, $headers );
$mail_sent = mail($to, $subject, $message, $headers, "-f".$frommail);
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent" : "Mail failed";
exit;
?>


<?php
//define the receiver of the email
//$to = 'samul30@hanmail.net';
$to = 'heroboard2@naver.com';

//define the subject of the email
$subject = 'Test email'; 
$message = 'Test email'; 
//define the message to be sent. Each line should be separated with \n
$message = "Hello World!\n\nThis is my first mail."; 
//define the headers we want passed. Note that they are separated with \r\n
$headers = "From: admin@aklover.co.kr\r\nReply-To: admin@aklover.co.kr";
//send the email
$frommail = 'admin@aklover.co.kr'; 
//$mail_sent = @mail( $to, $subject, $message, $headers );
$mail_sent = mail($to, $subject, $message, $headers, "-f".$frommail);
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent" : "Mail failed";
exit;
?>
<?

####################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
####################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
####################################################################################################################################################
$hero_name = "엄재민";
$hero_pw = "비밀";
ob_start();
    $IN_FILE_VAL = "mailform.php";
    include SUB_MEMBER_INC_END.$IN_FILE_VAL;
echo        $html = ob_get_contents();
ob_end_clean();
$subject = '과연될까요안되는댕';

$content = '모가문제일까'.$html;
$toname = 'heroboard2@naver.com';
//$toname = 'samul30@hanmail.net';
$toname = '<'.$toname.'>';
$frommail = 'admin@aklover.co.kr';
$name = 'AK 서포터즈 관리자';
$mailheaders .= "Return-Path: $frommail\r\n";//Return-Path와 Reply-To는 myemail@domain.com으로 지정된다
$mailheaders .= "From: $name <$frommail>\r\n";//$mailheaders .= "X-Mailer: Crazy Dog\r\n";먼지는멀것다
$mailheaders .= "Content-Type:multipart/alternative;charset=euc-kr\r\n";//$content 내용을 html로 인식 
$mailheaders .= 'Content-Transfer-Encoding : base64\r\n';//$content 내용을 html로 인식 
$mailheaders .= 'MIME-Version : 1.0 \r\n';//$content 내용을 html로 인식 

mail($toname, $subject, $content, $mailheaders, "-f".$frommail);
exit;
?>
<?php
//define the receiver of the email
$to = 'youraddress@example.com';
//define the subject of the email
$subject = 'Test email'; 
//define the message to be sent. Each line should be separated with \n
$message = "Hello World!\n\nThis is my first mail."; 
//define the headers we want passed. Note that they are separated with \r\n
$headers = "From: webmaster@example.com\r\nReply-To: webmaster@example.com";
//send the email
$mail_sent = @mail( $to, $subject, $message, $headers );
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent" : "Mail failed";
?>
<?php
//define the receiver of the email
$to = 'youraddress@example.com';
//define the subject of the email
$subject = 'Test HTML email'; 
//create a boundary string. It must be unique 
//so we use the MD5 algorithm to generate a random hash
$random_hash = md5(date('r', time())); 
//define the headers we want passed. Note that they are separated with \r\n
$headers = "From: webmaster@example.com\r\nReply-To: webmaster@example.com";
//add boundary string and mime type specification
$headers .= "\r\nContent-Type: multipart/alternative; boundary=\"PHP-alt-".$random_hash."\""; 
//define the body of the message.
ob_start(); //Turn on output buffering
?>
--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

Hello World!!! 
This is simple text email message. 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<h2>Hello World!</h2>
<p>This is something with <b>HTML</b> formatting.</p> 

--PHP-alt-<?php echo $random_hash; ?>--
<?
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email
$mail_sent = @mail( $to, $subject, $message, $headers );
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent" : "Mail failed";
?>

<?php 
//define the receiver of the email 
$to = 'youraddress@example.com'; 
//define the subject of the email 
$subject = 'Test email with attachment'; 
//create a boundary string. It must be unique 
//so we use the MD5 algorithm to generate a random hash 
$random_hash = md5(date('r', time())); 
//define the headers we want passed. Note that they are separated with \r\n 
$headers = "From: webmaster@example.com\r\nReply-To: webmaster@example.com"; 
//add boundary string and mime type specification 
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\""; 
//read the atachment file contents into a string,
//encode it with MIME base64,
//and split it into smaller chunks
$attachment = chunk_split(base64_encode(file_get_contents('attachment.zip'))); 
//define the body of the message. 
ob_start(); //Turn on output buffering 
?> 
--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>" 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/plain; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

Hello World!!! 
This is simple text email message. 

--PHP-alt-<?php echo $random_hash; ?>  
Content-Type: text/html; charset="iso-8859-1" 
Content-Transfer-Encoding: 7bit

<h2>Hello World!</h2> 
<p>This is something with <b>HTML</b> formatting.</p> 

--PHP-alt-<?php echo $random_hash; ?>-- 

--PHP-mixed-<?php echo $random_hash; ?>  
Content-Type: application/zip; name="attachment.zip"  
Content-Transfer-Encoding: base64  
Content-Disposition: attachment  

<?php echo $attachment; ?> 
--PHP-mixed-<?php echo $random_hash; ?>-- 

<?php 
//copy current buffer contents into $message variable and delete current output buffer 
$message = ob_get_clean(); 
//send the email 
$mail_sent = @mail( $to, $subject, $message, $headers ); 
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
echo $mail_sent ? "Mail sent" : "Mail failed"; 
?> 











<?php
//define the receiver of the email
$to = 'brottmayer@gmail.com';
//define the subject of the email
$subject = Trim(stripslashes($_POST['subject']));;
//define the sender of the email
$from = Trim(stripslashes($_POST['from']));;
//create a boundary string. It must be unique
//so we use the MD5 algorithm to generate a random hash
$random_hash = md5(date('r', time()));
//define the headers we want passed. Note that they are separated with 

$headers = "From: $from
Reply-To: $from";
//add boundary string and mime type specification
//$headers .= "Content-Type: multipart/mixed; boundary=\"PHP-mixed-\".$random_hash.""";
//Userfile information
$filename = $_FILES["userfile"]["name"]; // gives you the name of the file they uploaded
$filetype = $_FILES["userfile"]["type"]; // gives you the size of the upload in bytes
$filetemp = $_FILES["userfile"]["tmp_name"]; // gives you the temporary name of the file on the server until it is renamed
//read the atachment file contents into a string,
//encode it with MIME base64,
//and split it into smaller chunks
$data = base64_encode($filename);
//define the body of the message.
ob_start(); //Turn on output buffering
?>
--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>"

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/plain; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit

Hello World!!!
This is simple text email message.

Address is: <?php echo $_POST["address"]; ?>
Phone Number is: <?php echo $_POST["phone"]; ?>
Birthdate is: <?php echo $_POST["bdate"]; ?>

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/html; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit

<h2>Hello World!</h2>
<p>This is something with <b>HTML</b> formatting.</p>

<h1>Address is: <?php echo $_POST["address"]; ?></h1>
<p>Phone Number is: <?php echo $_POST["phone"]; ?><br />
Birthdate is: <?php echo $_POST["bdate"]; ?></p>

--PHP-alt-<?php echo $random_hash; ?>--

--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: $filetype; name=$filename
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

<?php echo $data; ?>
--PHP-mixed-<?php echo $random_hash; ?>--

<?php
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email
$mail_sent = @mail( $to, $subject, $message, $headers );
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed"
echo $mail_sent ? "Mail sent" : "Mail failed";
?>








<?
function mail_attachment ($from , $to, $subject, $message, $attachment){
$fileatt = $attachment; // Path to the file 
$fileatt_type = "application/octet-stream"; // File Type 
$start= strrpos($attachment, '/') == -1 ? strrpos($attachment, '//') : strrpos($attachment, '/')+1;
$fileatt_name = substr($attachment, $start, strlen($attachment)); // Filename that will be used for the file as the attachment 

$email_from = $from; // Who the email is from 
$email_subject = $subject; // The Subject of the email 
$email_txt = $message; // Message that the email has in it 

$email_to = $to; // Who the email is to

$headers = "From: ".$email_from."
";
//$headers = "From: ".$email_from;

$file = fopen($fileatt,'rb'); 
$data = fread($file,filesize($fileatt)); 
fclose($file); 
$msg_txt="";

$semi_rand = md5(time()); 
$mime_boundary = "==Multipart_Boundary_x$semi_randx"; 
$headers .= "Bcc: try_test_abc@yahoo.com";
$headers .= "MIME-Version: 1.0"."Content-Type: multipart/mixed;"."boundary=".$mime_boundary."";
$email_txt .= $msg_txt;
$email_message .= "This is a multi-part message in MIME format."."--$mime_boundary"."Content-Type:text/html; charset=\"iso-8859-1\"".
    "Content-Transfer-Encoding: 7bit".$email_txt; 
$data = chunk_split(base64_encode($data)); 
//"Content-Disposition: attachment;" . 
//" filename="{$fileatt_name}"

$email_message .= "--$mime_boundary"."Content-Type:$fileatt_type;"." name=".$fileatt_name."Content-Transfer-Encoding: base64".$data."--$mime_boundary--";
$ok = mail($email_to, $email_subject, $email_message, $headers); 
if($ok) 
{ 
} 

else 
{ 
// print "<b>Sorry Could not send</b>";
} 
}

?>