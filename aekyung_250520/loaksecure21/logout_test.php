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
?>
<html>
    <head>
        <title>ADMINISTRATOR</title>
        <link>
        <meta http-equiv="Content-Type" content="text/html; charset=<?=OLDSET?>">
        <script type="text/javascript" src="<?=JS_END?>head.js"></script>
    </head>
<?=BODY;?>
<style>
#install_01{padding-top:20px;height:30;width:216;text-align:right;}
</style>
<body topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" border="0" onLoad="login_form.login_id.focus()">
<!--<div style="height:100%;text-align:center;background:url('<?=PATH_IMG_END?>bg_login.gif');">-->
<div style="height:100%;text-align:center;background:url('<?=PATH_IMAGE_END?>bg_login.gif');">
    <div style="height:130px;">
        <div style="padding-top:100px;text-align:center;background:#FFF;"><?=img('PATH_IMAGE_END||admin_logo.png');?></div>
    </div>
    <div style="padding-top:30px;"></div>
    <div style="text-align:center;font-size:12px;padding:5px;color:#000;font-weight:bold; padding-top:170px;" valign="bottom">
        <span style="background:#FFF;vertical-align:bottom;padding:4px;padding-top:6px;">
            <?=img('PATH_IMAGE_END||ico_login.gif', '', '', '', 'style="vertical-align:bottom"');?> 관리자 페이지 입니다. 아이디와 패스워드를 입력해주세요.
        </span>
    </div>
    <div >
    <form name="login_form" onsubmit="return false;">
        <div> 
          <ul >
			  <li >
			  <?=input('login_id', '', 'style="width:152px;ime-mode:disabled;" onkeydown="if(event.keyCode==13) getData(\'logout_check.php\', \'view_list\');" ', 'login_pw', '20', '1').PHP_EOL;//=input('login_id', '아이디', 'style="width:152px;ime-mode:disabled;" onMouseOver="this.value=\'\'" ', 'login_pw', '20', '1').PHP_EOL;?> 
			  </li>
			  <li style="vertical-align:bottom; font-size:12px;">
				 <?=input('login_pw', '', 'style="width:152px;ime-mode:disabled;" maxlength="20" onkeydown="if(event.keyCode==13) getData(\'logout_check.php\', \'view_list\');" ', '', '', '2', '', 'password').PHP_EOL;?>
				<?=input('logout_check', 'logout_check', '', '', '', '', '', 'hidden').PHP_EOL;?>
			  </li>
		  </ul>
        </div>
       
        <div >
          <?=img('PATH_IMAGE_END||btn_login.gif', '', 'getData(\'logout_check.php\', \'view_list\'); return false;', '', '', '3').PHP_EOL;?>
        </div>
        <div id="view_list"></div>
    </form>
    </div>
</div>
