<?php
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                                        '../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';
?>

<?php 

$idx = $_GET['id'];

$sql = "select * from order_notice where hero_idx=".$idx;
sql($sql,"on");
$rs = mysql_fetch_array($out_sql);
?>


<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>♡AK LOVER 애경 서포터즈</title>
		<link href="css/main.css" rel="stylesheet" type="text/css">
		
	</head>
	<body>
		<table id="order_notice">
			<tr style='height: 25px;'>
				<th style="text-align:right;"><?=substr($rs['hero_regdate'],0,10);?>
				</th>
			</tr>
			<tr>
				<td><?=iconv('euc-kr','utf-8',nl2br($rs['hero_content']));?>
				</td>
			</tr>
		</table>
	</body>

</html>