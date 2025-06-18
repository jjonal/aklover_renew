<?
ob_start();
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
header("Content-Type: text/html; charset=euc-kr");
include_once                                                        'freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
}else{
    $my_level = $_SESSION['temp_level'];
}
if(!strcmp($my_level,'0')){msg('로그인 후 이용가능합니다.','location.href="'.PATH_HOME.'?board=login"');exit;}

//echo decrypt($_GET['idx']);
$sql = "select A.hero_code, A.hero_nick, A.hero_id, A.hero_address_02, A.hero_blog_00 , A.hero_blog_04 , A.hero_blog_03, B.hero_img_new from (select * from member where hero_idx='".decrypt($_GET['idx'])."') as A inner join level as B on A.hero_level=B.hero_level";
sql($sql,'on');
$sql_member = @mysql_fetch_assoc($out_sql);//mysql_fetch_row

$sql_other = "SELECT *, COUNT( * ) AS count FROM (select hero_idx, hero_03, hero_title from board WHERE hero_board_three =  '1' AND hero_code='".$sql_member['hero_code']."' order by hero_idx desc) as A";
$sql_other_res = @mysql_query($sql_other);
$sql_other_rs = mysql_fetch_assoc($sql_other_res);

//$sql_board = "select A.hero_title from board A inner join member B on A.hero_code=B.hero_code and B.hero_board_three='1' where A.hero_idx = '".decrypt($_GET['idx'])."' order by B.hero_today desc limit 0,3";

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
<!--쪽지+개인정보 page load css-->
<link rel="stylesheet" href="/css/main2.css" type="text/css" />
<script type="text/javascript" src="<?=JS_END;?>head.js"></script>
</head>
<table id="info_02">
	<colgroup>
		<col width="100px" />
		<col width="*" />
    </colgroup>
	<tr>
		<td>우수후기 수</td>
		<td>
			<? if($sql_other_rs['count'] > 0) { ?>
				<a href="/main/index.php?board=group_04_10&statusSearch=&select=hero_id&kewyword=<?=$sql_member['hero_id'];?>"><?=$sql_other_rs['count'];?></a>
			<? } else { ?>
				<?=$sql_other_rs['count'];?>
			<? } ?>
			건
		</td>
	</tr>
	<tr>
		<td colspan=2 align=center height=50><span onclick="mail_send('<?=$_GET['idx'];?>')">쪽지 보내기</span></td>
	</tr>
</table>
</html>
