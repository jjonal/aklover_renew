<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
ob_start();
define('_HEROBOARD_', TRUE);//HEROBOARD����
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
if(!strcmp($my_level,'0')){msg('�α��� �� �̿밡���մϴ�.','location.href="'.PATH_HOME.'?board=login"');exit;}
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
		<!--����+�������� page load css-->
		<link rel="stylesheet" type="text/css" href="/css/general2.css"/>
		<script type="text/javascript" src="/js/jquery.min.js"></script>
		<script type="text/javascript" src="/js/head.js"></script>
	

		
                       
		</head>
						<div id="mail">
							<!--<body oncontextmenu="return false">���ΰ�ħ����-->
							<form name="form_mail_next" action="" method="post" enctype="multipart/form-data"> 
								<input type="hidden" name="hero_code" value="<?=encrypt ($_SESSION['temp_code'])?>">
								<input type="hidden" name="hero_table" value="<?=encrypt ('mail')?>">
								<input type="hidden" name="hero_today" value="<?=encrypt (date('Y-m-d H:i:s'))?>">
								<input type="hidden" name="hero_name" value="<?=encrypt ($_SESSION['temp_name'])?>">
								<input type="hidden" name="hero_user" value="<?=encrypt ($sql_receiver['hero_id'])?>">
								<input type="hidden" name="hero_nick" value="<?=encrypt ($_SESSION['temp_nick'])?>">
								<div>���� ������</div>
								<table class="t_view">
								<colgroup>
									<col width="100px">
									<col width="300px">
								</colgroup>
								<tbody>
									<tr>
										<th class="first">������ ���</th>
										<td class="first"><?=$_SESSION['temp_nick'];?></td>
									</tr>
									<tr>
										<th>�޴� ���</th>
										<td >
										   <?=$sql_receiver['hero_nick']?>
										</td>
									</tr>
									<tr>
										<th>����</th>
										<td><input type="text" id="hero_title_mail" placeholder="�ִ� 40�ڱ��� ���� �� �ֽ��ϴ�."></td>
									</tr>
									<tr>
										<th>����</th>
										<td><textarea id="editor_mail" class="textarea" placeholder="�ִ� 300�ڱ��� ���� �� �ֽ��ϴ�."></textarea></td>
									</tr>
								</tbody>
								</table>
								<p>
									<a onclick="submits_mail();" class="btn_blue2">������</a>
									<a onclick="close_mail();">�ݱ�</a>
								</p>
							</form>
						</div>
          </html>             

