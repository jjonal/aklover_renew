<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
######################################################################################################################################################
include_once                                '../freebest/head.php';
if($_SESSION['temp_id']){echo '<script>location.href="'.PATH_HOME.'"</script>';exit;}
@session_destroy();
//if($_SESSION['temp_id']){header('LOCATION:'.PATH_HOME);exit;}else{@session_destroy();)
include_once                                FREEBEST_INC_END.'function.php';
######################################################################################################################################################
if(!$_SERVER["HTTPS"]) {
	if(strpos($_SERVER["HTTP_HOST"], "aklover.co.kr")) {
		header('Location: https://www.aklover.co.kr'.$_SERVER["PHP_SELF"]);
	}
}
?>
<html>
    <head>
        <title>ADMINISTRATOR</title>
        <link>
        <meta http-equiv="Content-Type" content="text/html; charset=<?=OLDSET?>">
        <script type="text/javascript" src="<?=JS_END?>head.js"></script>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
    </head>
<?=BODY;?>
<style>
#install_01{padding-top:20px;height:30;width:216;text-align:right;}
body{font-family:'돋움',Dotum,arial,sans-serif; font-size:0.75em; color:#333;}
</style>
<script>
function reqLogin() {
	if($("#login_id").val() == "") {
		alert("아이디를 입력해주세요.");
		$("#login_id").focus();
		return;
	}
	if($("#login_pw").val() == "") {
		alert("비밀번호를 입력해주세요.");
		$("#login_pw").focus();
		return;
	}
	$("#form1").submit();
}

</script>
<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" border="0" onLoad="login_form.login_id.focus()">
<form name="login_form" method="POST" action="logout_check.php" id="form1">
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="middle"><table width="575" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="image/ak_login_real.jpg" alt="AKLOVER 관리자 로그인"></td>
          </tr>
          <tr>
            <td height="66" align="right" valign="top" style="padding-top:30px"><table width="620" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="6"><img src="image/bullet.gif"></td>
                  <td width="50" class="bbs_head">아이디</td>
                  <td width="155"><span style="padding-top:1px;">
                    <input type="text" name="login_id" id="login_id" value="<?=$_COOKIE['cookie_login_id']?>" style="width:150px;">
                  </span></td>
                  <td width="6"><img src="image/bullet.gif" width="3" height="5"></td>
                  <td width="65" class="bbs_head">비밀번호</td>
                  <td width="150"><span style="padding-top:1px;">
                    <input type="password" name="login_pw" id="login_pw" value="" style="width:150px;" onKeyDown="if (event.keyCode == 13) reqLogin();">
                    <input type="hidden" name="logout_check" value="logout_check">
                  </span></td>
                  <td width="50">
                    <img src="image/btn_login2.gif" alt="로그인" border="0" style="cursor:pointer" onClick="reqLogin()">
                  </td>
                  <td width="100">
                  <?
				  if($_COOKIE['cookie_login_id'])		$check = "checked";
   				  else								    $check = '';
				  ?>
                  <input type="checkbox" name="chk_id_cookie" value="true" checked='<?=$check?>' style="border:1px #E0E0E0;background-color:#FAFAFA;">아이디저장
                  </td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="1" background="image/dotline.gif"></td>
          </tr>
          
        </table></td>
      </tr>
    </table>
</form>




