<? 
define('_HEROBOARD_', TRUE);//HEROBOARD오픈

$img = iconv("UTF-8","EUC-KR", $_GET['img']);
$url = iconv("UTF-8","EUC-KR", $_GET['url']);
$nick = iconv("UTF-8","EUC-KR", $_GET['nick']);
$sns = iconv("UTF-8","EUC-KR", $_GET['sns']);
?>
<!DOCTYPE HTML>
<html lang="ko">

<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />                                                                                          
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
</head>                                                                                                                
<body>                                                                                                                 
<div name='sns_url' style='text-align:center;padding-top:100px;cursor:pointer;'>                                       
<img name='sns_img' src='<?=$img?>' style='margin-bottom: 10px;'/ onclick="window.open('<?=$url?>')"><br/>               
<img src='http://aklover.co.kr/image2/etc/new_window.gif' style='margin-right:10px;' onClick="window.open('<?=$url?>')"/>
<span name='sns_contents' onclick="window.open('<?=$url?>')"><?=$nick?> 님의 <?=$sns?></span>                                   
</div>                                                                                                                 
</body>                                                                                                                
</html>                                                                                                                   
