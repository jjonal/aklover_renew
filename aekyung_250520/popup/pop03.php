<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div style="position:relative;background-color:#000000;">
<span style="color: #FFFFFF;font-size:12px;"><input type="checkbox" name="closeEvent" id="popup_ch" onclick="controlCookie(this,'popup_id_<?=$popup_list['hero_idx']?>');">
<label for="popup_ch">&nbsp;하루동안 이창의 띄우지 않음&nbsp;&nbsp;</label></span>
</div>
<div style="position:relative;word-wrap:break-word; word-break:break-all;white-space: pre-wrap;white-space: -moz-pre-wrap;white-space: -pre-wrap;white-space: -o-pre-wrap;" onclick="javascript:rpurl('<?=$popup_list['hero_href']?>');"><?=htmlspecialchars_decode($popup_list['hero_command']);?>
</div>