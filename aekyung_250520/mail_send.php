<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
ob_start();
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
header("Content-Type: text/html; charset=euc-kr");
if(!defined('_HEROBOARD_'))exit;
include_once                                                        'freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';
?>

<?
if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
}else{
    $my_level = $_SESSION['temp_level'];
}
if(!strcmp($my_level,'0')){msg('로그인 후 이용가능합니다.','location.href="'.PATH_HOME.'?board=login"');exit;}
######################################################################################################################################################
 
 if(strcmp($_GET['idx'], '')){
	 $idx = " and hero_idx='".decrypt ($_GET['idx'])."'" ;
 }
######################################################################################################################################################
$sql = "select hero_id,hero_nick from member where 1=1".$idx;
//echo $sql;
sql($sql, 'on');
$sql_receiver = @mysql_fetch_assoc($out_sql);//mysql_fetch_row

?>
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
		<!--쪽지+개인정보 page load css-->
		<link rel="stylesheet" type="text/css" href="/css/general2.css"/>
		<script type="text/javascript" src="/js/jquery.min.js"></script>
		<script type="text/javascript" src="/js/head.js"></script>
	

		
                       
		</head>
						<div id="mail">
							<!--<body oncontextmenu="return false">새로고침방지-->
							<form name="form_mail_next" action="" method="post" enctype="multipart/form-data"> 
								<input type="hidden" name="hero_code" value="<?=encrypt ($_SESSION['temp_code'])?>">
								<input type="hidden" name="hero_table" value="<?=encrypt ('mail')?>">
								<input type="hidden" name="hero_today" value="<?=encrypt (date('Y-m-d H:i:s'))?>">
								<input type="hidden" name="hero_name" value="<?=encrypt ($_SESSION['temp_name'])?>">
								<input type="hidden" name="hero_user" value="<?=encrypt ($sql_receiver['hero_id'])?>">
								<input type="hidden" name="hero_nick" value="<?=encrypt ($_SESSION['temp_nick'])?>">
								<div>쪽지 보내기</div>
								<table class="t_view">
								<colgroup>
									<col width="100px">
									<col width="300px">
								</colgroup>
								<tbody>
									<tr>
										<th class="first">보내는 사람</th>
										<td class="first"><?=$_SESSION['temp_nick'];?></td>
									</tr>
									<tr>
										<th>받는 사람</th>
										<td >
										   <?=$sql_receiver['hero_nick']?>
										</td>
									</tr>
									<tr>
										<th>제목</th>
										<td><input type="text" id="hero_title_mail" placeholder="최대 40자까지 쓰실 수 있습니다."></td>
									</tr>
									<tr>
										<th>내용</th>
										<td><textarea id="editor_mail" class="textarea" placeholder="최대 300자까지 쓰실 수 있습니다."></textarea></td>
									</tr>
								</tbody>
								</table>
								<p>
									<a onclick="submits_mail();" class="btn_blue2">보내기</a>
									<a onclick="close_mail();">닫기</a>
								</p>
							</form>
						</div>
          </html>             

