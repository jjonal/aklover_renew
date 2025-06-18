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
$popup_sql = 'select * from popup where hero_idx=\''.$_REQUEST['hero_idx'].'\';';//desc<=
$out_popup_sql = mysql_query($popup_sql);
$popup_list                             = @mysql_fetch_assoc($out_popup_sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
		<style>body{font:12px dotum,sans-serif;color:#000;}table{border-collapse:collapse;font-size:12px;}a:link, a:visited, a:hover, a:active {color: #000;text-decoration: none;}</style>
		<script type="text/javascript" src="/js/mouse.js"></script>
		<script language="javascript">
		<!--
			//설정한 날짜만큼 쿠키가 유지되게. expiredays가 1 이면 하루동안 유지
			function setCookie(name, value, expiredays) 
			{
				var expire_date = new Date();
				expire_date.setDate(expire_date.getDate() + expiredays );
				document.cookie = name + "=" + escape( value ) + "; expires=" + expire_date.toGMTString() + "; path=/";
			} 
			//쿠키 소멸 함수
			function clearCookie(name) 
			{
				var expire_date = new Date();
				//어제 날짜를 쿠키 소멸 날짜로 설정한다.
				expire_date.setDate(expire_date.getDate() - 1)
				document.cookie = name + "= " + "; expires=" + expire_date.toGMTString() + "; path=/"
			}
			//체크 상태에 따라 쿠키 생성과 소멸을 제어하는 함수
			function controlCookie(elemnt,ckeName) 
			{
				if (elemnt.checked) {
					//체크 박스를 선택했을 경우 쿠키 생성 함수 호출
					setCookie(ckeName,"true", 1);
				} else {
					//체크 박스를 해제했을 경우 쿠키 소멸 함수 호출
					clearCookie(ckeName);
				}
				window.close();		
				return;
			}
			function rpurl(v){
                if(v.indexOf("<?=DOMAIN?>", 0) > -1){
				    opener.location.href = v;
                    window.close();
			    }else{
                    link = window.open("", "_blank");
				    link.location.href = v;
                    window.close();
                }
            }
		//-->
//                window.resizeTo(<?=$popup_list['hero_width']?>px,<?=$popup_list['hero_height']?>px);
		</script>
	</head>
<?
if(!strcmp($popup_list['hero_href'],"")){
    $onclick_href=$popup_list['hero_href'];
}else{
    $onclick_href=$popup_list['hero_href'];
}
?>
    <style>
        html, body,div {width:100%; margin:0; padding:0; }
        p{margin:0;padding:0;}
    </style>
	<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" border="0">
        <div style="position:relative;background-color:#000000;" width="100%">
        <span style="color: #FFFFFF;font-size:12px;"><input type="checkbox" name="closeEvent" id="popup_ch" onclick="controlCookie(this,'popup_id_<?=$popup_list['hero_idx']?>');">&nbsp;하루동안 이창의 띄우지 않음&nbsp;&nbsp;</span>
        </div>
        <div style="vertical-align:top;position:relative;word-wrap:break-word; word-break:break-all;white-space: pre-wrap;white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;line-height: normal;white-space:normal;" onclick="javascript:rpurl('<?=$onclick_href?>');"><?=htmlspecialchars_decode($popup_list['hero_command']);?></div>
    </body>
</html>