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
.break {page-break-before: always;}
-->
</style>
<table border=1 cellspacing=0 cellpadding=2 bordercolordark=#CCCCCC bordercolorlight=#FFFFFF align=center class=text>
<?
if(!strcmp($_GET['order'], '')){
    $view_order = '';
}else{
    $view_order = ' order by '.$_GET['order'];
}
######################################################################################################################################################
$sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\' '.$search.' ';
sql($sql,'on');
$total_data = @mysql_num_rows($out_sql);
$list_page=27;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'].'&order='.$_GET['order'];
######################################################################################################################################################

$sql = 'select * from member where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.$view_order.' limit '.$start.','.$list_page.';';
sql($sql);
?>
    <tr>
<!--

        <td width='80' align=center class=color2><a href="<?=PATH_END.'print.php?'.get('order','order=hero_id asc');?>">▼</a> 아이디 <a href="<?=PATH_END.'print.php?'.get('order','order=hero_id desc');?>">▲</a></td>
        <td width='40' align=center class=color2><a href="<?=PATH_END.'print.php?'.get('order','order=hero_nick asc');?>">▼</a> 닉네임 <a href="<?=PATH_END.'print.php?'.get('order','order=hero_nick desc');?>">▲</a></td>
        <td width='50' align=center class=color2><a href="<?=PATH_END.'print.php?'.get('order','order=hero_hp asc');?>">▼</a> 연락처 <a href="<?=PATH_END.'print.php?'.get('order','order=hero_hp desc');?>">▲</a></td>
        <td width='40' align=center class=color2><a href="<?=PATH_END.'print.php?'.get('order','order=hero_name asc');?>">▼</a> 이름 <a href="<?=PATH_END.'print.php?'.get('order','order=hero_name desc');?>">▲</a></td>
        <td width='*' align=center class=color2><a href="<?=PATH_END.'print.php?'.get('order','order=hero_address_01 asc,hero_address_02 asc,hero_address_03 asc');?>">▼</a> 주소 <a href="<?=PATH_END.'print.php?'.get('order','order=hero_address_01 desc,hero_address_02 desc,hero_address_03 desc');?>">▲</a></td>
        <td width='120' align=center class=color2><a href="<?=PATH_END.'print.php?'.get('order','order=hero_blog_00 asc');?>">▼</a> 블로그 <a href="<?=PATH_END.'print.php?'.get('order','order=hero_blog_00 desc');?>">▲</a></td>
-->

        <td width='<?=$width_01?>' align=center class=color2>아이디</td>
        <td width='<?=$width_04?>' align=center class=color2>이름</td>
        <td width='<?=$width_02?>' align=center class=color2>닉네임</td>
        <td width='<?=$width_03?>' align=center class=color2>연락처</td>
        <td width='<?=$width_05?>' align=center class=color2>블로그</td>
    </tr>
<?
while($list_top                             = @mysql_fetch_assoc($out_sql)){
// CLASS="break"
?>
    <tr>
        <td width='<?=$width_01?>' align=center><?=$list_top['hero_id']?></td>
        <td width='<?=$width_04?>' align=center><?=$list_top['hero_name']?></td>
        <td width='<?=$width_02?>' align=center><?=$list_top['hero_nick']?></td>
        <td width='<?=$width_03?>' align=center><?=$list_top['hero_hp']?></td>
        <td width='<?=$width_05?>' align=center><?=$list_top['hero_blog_00']?></td>
    </tr>
    <tr>
        <td>주소</td>
        <td colspan="4" width='<?=$width_06?>' align=left><?=$list_top['hero_address_01']?> <?=$list_top['hero_address_02']?> <?=$list_top['hero_address_03']?></td>
    </tr>
<?}?>
</table>
<div style="width:100%; text-align:center; margin-top:20px;">
<? include_once BOARD_INC_END.'page.php';?>
</div>
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
