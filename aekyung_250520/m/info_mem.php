<?
define('_HEROBOARD_', TRUE);//HEROBOARD����
header("Content-Type: text/html; charset=euc-kr");
include_once                                                        $_SERVER['DOCUMENT_ROOT'].'/freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

if(!strcmp($_SESSION['temp_level'], '')){
	$my_level = '0';
}else{
	$my_level = $_SESSION['temp_level'];
}
if(!strcmp($my_level,'0')){msg('�α��� �� �̿밡���մϴ�.');exit;}

$sql  =  " SELECT A.hero_code, A.hero_nick, A.hero_id, A.hero_address_02, A.hero_blog_00 , A.hero_blog_04 , A.hero_blog_03, B.hero_img_new FROM ";
$sql .= " ( SELECT * FROM member WHERE hero_idx='".decrypt($_GET['idx'])."') as A inner join level as B on A.hero_level=B.hero_level ";
sql($sql,'on');
$sql_member = @mysql_fetch_assoc($out_sql);//mysql_fetch_row

$sql_other = "SELECT *, COUNT( * ) AS count FROM (select hero_idx, hero_03, hero_title from board WHERE hero_board_three =  '1' AND hero_code='".$sql_member['hero_code']."' order by hero_idx desc) as A";
$sql_other_res = @mysql_query($sql_other);
$sql_other_rs = mysql_fetch_assoc($sql_other_res);

?>
<div class="profileBox">
	<div class="header">
		<img src="<?=str($sql_member["hero_img_new"])?>" /> <?=$sql_member['hero_nick']?>
		<a href="javascript:;" onClick="fnProfileClose()" class="btn_close_profile">X</a>
	</div>
	<div class="profile">
		<div class="profileColumn">
			<label>����ı� ��</label>
			<? if($sql_other_rs['count'] > 0) { ?>
				<a href="/m/board_02.php?board=group_04_10&statusSearch=&select=hero_id&kewyword=<?=$sql_member['hero_id'];?>"><?=$sql_other_rs['count'];?></a>
			<? } else { ?>
				<?=$sql_other_rs['count'];?>
			<? } ?>
			��
		</div>
		
		<div class="btnGroup">
			<a href="javascript:;" onclick="fnProfileSendForm()">���� ������</a>
		</div>
	</div>
	
	<form name="form_mail_next" method="POST">
	<input type="hidden" name="hero_code" value="<?=encrypt($_SESSION['temp_code'])?>">
	<input type="hidden" name="hero_table" value="<?=encrypt('mail')?>">
	<input type="hidden" name="hero_today" value="<?=encrypt(date('Y-m-d H:i:s'))?>">
	<input type="hidden" name="hero_name" value="<?=encrypt($_SESSION['temp_name'])?>">
	<input type="hidden" name="hero_user" value="<?=encrypt($sql_member["hero_id"])?>">
	<input type="hidden" name="hero_nick" value="<?=encrypt($_SESSION['temp_nick'])?>">
	<div class="message">
		<div class="profileColumn">
			<label>����</label>
			<input type="text" id="hero_title_mail" placeholder="�ִ� 40�ڱ��� ���� �� �ֽ��ϴ�." maxlength="40" />
		</div>
		<div class="profileColumn">
			<label>����</label>
			<textarea id="editor_mail" placeholder="�ִ� 300�ڱ��� ���� �� �ֽ��ϴ�."></textarea>
		</div>
		
		<div class="btnGroup">
			<a href="javascript:;" onClick="submits_mail('mobile')">������</a>
		</div>
	</div>
	</form>
</div>