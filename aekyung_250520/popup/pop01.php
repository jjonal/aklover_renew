<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<title>AK LOVER</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
				opener.location.href = v;
                window.close();
			}
		//-->
		</script>
	</head>
	<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
				<td align="center"><a href="javascript:rpurl('/main/index.php?board=group_04_03&page=1&view=view&idx=78');"><img src="../image/popup/open131011.jpg" /></a></td>
			</tr>
								</table>
		<div style="width:100%;background-color:#000000;bottom:0;position:absolute;"><table align="right" border="0" cellspacing="0" cellpadding="0"><tr><td><span style="color: #FFFFFF;font-size:12px;"><input type="checkbox" name="closeEvent" id="popup_ch" onclick="controlCookie(this,'popup_id_01');"><label for="popup_ch">&nbsp;하루동안 이창의 띄우지 않음&nbsp;&nbsp;</label></span></td></tr></table></div>	
	</body>
</html>