<?
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once                                '../../freebest/head.php';
if(!$_SESSION['temp_id']){echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;}
if( (!strcmp($_SESSION['temp_level'], '100')) or (!strcmp($_SESSION['temp_level'], '99')) ){
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';
?>
<style type="text/css">
<!--
.text{font-size:12px;line-height:10px;color:#000000;text-decoration:none}
/*th,td{white-space:nowrap;}*/
-->
</style>
<table border=1 cellspacing=0 cellpadding=2 bordercolordark=#CCCCCC bordercolorlight=#FFFFFF align=center class=text>
<?
$sql = 'select * from member where hero_level <= \''.$_SESSION['temp_level'].'\';';
sql($sql,'on');
?>
    <tr>
        <td width='80' align=center class=color2>아이디</td>
        <td width='40' align=center class=color2>닉네임</td>
        <td width='90' align=center class=color2>연락처</td>
        <td width='40' align=center class=color2>이름</td>
        <td width='*' align=center class=color2>블로그</td>
    </tr>
<?
while($list_top                             = @mysql_fetch_assoc($out_sql)){
?>
    <tr>
        <td rowspan="2" align=center><?=$list_top['hero_id']?></td>
        <td align=center><?=$list_top['hero_nick']?></td>
        <td align=center><?=$list_top['hero_hp']?></td>
        <td align=center><?=$list_top['hero_name']?></td>
        <td align=center><?=$list_top['hero_blog_00']?></td>
    </tr>
    <tr>
        <td colspan="4" align="left">(주소)<?=$list_top['hero_address_01']?> <?=$list_top['hero_address_02']?> <?=$list_top['hero_address_03']?></td>
    </tr>
<?}?>
</table>
<?
}else{
   echo '<script>alert("권한이 없습니다.")</script>';
   echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;
}
?>
<?exit;?>
<HTML>
<HEAD>
<TITLE>Page Break</TITLE> 
<STYLE TYPE="text/css"> 
<!-- .break {page-break-before: always;} --> 
</STYLE> 
</HEAD> 
<BODY> 
<DIV> 
When you print this page, there will be a page-break before the 
following <STRONG>H1</STRONG> title. 
</DIV> 
<H1 CLASS="break">Start New Section on New Page 1</H1> 
<H1 CLASS="break">Start New Section on New Page 2</H1> 
<H1 CLASS="break">Start New Section on New Page 3</H1> 
</BODY> 
</HTML> 
