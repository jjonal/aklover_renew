<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD����
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
		<title>AK LOVER</title>
		<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
		<script language="javascript">
		<!--
			//������ ��¥��ŭ ��Ű�� �����ǰ�. expiredays�� 1 �̸� �Ϸ絿�� ����
			function setCookie(name, value, expiredays) 
			{
				var expire_date = new Date();
				expire_date.setDate(expire_date.getDate() + expiredays );
				document.cookie = name + "=" + escape( value ) + "; expires=" + expire_date.toGMTString() + "; path=/";
			} 
			//��Ű �Ҹ� �Լ�
			function clearCookie(name) 
			{
				var expire_date = new Date();
				//���� ��¥�� ��Ű �Ҹ� ��¥�� �����Ѵ�.
				expire_date.setDate(expire_date.getDate() - 1)
				document.cookie = name + "= " + "; expires=" + expire_date.toGMTString() + "; path=/"
			}
			//üũ ���¿� ���� ��Ű ������ �Ҹ��� �����ϴ� �Լ�
			function controlCookie(elemnt,ckeName) 
			{
				if (elemnt.checked) {
					//üũ �ڽ��� �������� ��� ��Ű ���� �Լ� ȣ��
					setCookie(ckeName,"true", 1);
				} else {
					//üũ �ڽ��� �������� ��� ��Ű �Ҹ� �Լ� ȣ��
					clearCookie(ckeName);
				}
				window.open('about:blank','_self').close();
				return;
			}
			function rpurl(v){
				if(v) {
					opener.location.href = v;
                	window.open('about:blank','_self').close();
				}
			}
		//-->
//                window.resizeTo(<?=$popup_list['hero_width']?>px,<?=$popup_list['hero_height']?>px);
		</script>
    <style>
        html, body,div {width:100%; margin:0; padding:0; }
        p{margin:0;padding:0;}
    </style>
	</head>
	<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" border="0">
        <div style="background-color:#000000;" width="100%">
        	<span style="color: #FFFFFF;font-size:12px;"><input type="checkbox" name="closeEvent" id="popup_ch" onclick="controlCookie(this,'popup_id_<?=$popup_list['hero_idx']?>');">&nbsp;�Ϸ絿�� ��â�� ����� ����&nbsp;&nbsp;</span>
        </div>
        <div style="cursor:pointer;word-wrap:break-word; word-break:break-all;" onclick="javascript:rpurl('<?=$popup_list['hero_href']?>');"><?=htmlspecialchars_decode($popup_list['hero_command']);?></div>
    </body>
</html>