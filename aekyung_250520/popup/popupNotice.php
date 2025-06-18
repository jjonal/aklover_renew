<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        '../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';
#####################################################################################################################################################
db();

if($_GET['hero_idx']){
	$sql = 'select * from order_notice where hero_idx='.$_GET['hero_idx'];
	$res = mysql_query($sql) or die(mysql_error());
	$rs = mysql_fetch_assoc($res);

	$title = $rs["hero_title"];
	$content = nl2br($rs["hero_content"]);
	$regdate = substr($rs["hero_regdate"],0,10);
}else{
	msg("필수값 누락","window.close();");
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>AK LOVER</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" type="text/css" href="/css/general2.css"/>

<style>
	html, body,div {width:100%; margin:0; padding:0; }
	p{margin:0;padding:0;}
	body {background:white;padding:30px;}
</style>
</head>
<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" border="0">
	<div id="content">
		<div class="contents_area">
			<div class="contents">
				<table border="0" cellpadding="0" cellspacing="0" class="bbs_view">
                <colgroup>
                    <col width="90px" />
                    <col width="400px" />
                    <col width="100px" />
                    <col width="105px" />
                </colgroup>
                <tr class="bbshead">
                    <th><img src="../image/bbs/tit_subject.gif" alt="제목" /></th>
                    <td colspan="3">
                        <?=$title?>
					</td>
                </tr>
                <tr>
					
                    <th><img src="../image/bbs/tit_writer.gif" alt="작성자" /></th>
                    <td>
						관리자						
					</td>

                    <th><img src="../image/bbs/tit_date.gif" alt="날짜" /></th>
                    <td><?=$regdate?></td>
                </tr>
                <tr>
                    <td colspan="4" valign="top" width="705px"  class="bbs_view" style="padding:25px;line-height:normal;word-break:break-all;">
					<?=$content?>
					</td>
				</tr>
				</table>
			</div><!--class="contents"-->
		</div><!--class="contents_area"-->
	</div><!--id="content"-->
</body>
</html>