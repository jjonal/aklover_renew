<?php
session_start(); 
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once   '../../freebest/head.php';
header( "Content-type: application/vnd.ms-excel;charset=iso-8859-1" ); 
header( "Content-Disposition: attachment; filename=hero_users_".date("Ymd",time()).".xls" ); 
header("Content-charset=euc-kr");
if(!$_SESSION['temp_code']){
	echo '<script>location.href="'.PATH_END.'out.php"</script>';
	exit;
}
if($_SESSION['temp_level']>='9999'){
	include  FREEBEST_INC_END.'hero.php';
	include  FREEBEST_INC_END.'function.php';
?>
<strong><?=date("Y-m-d")?></strong>
<table width="100%" border="1" cellpadding="3" cellspacing="0">
<?
	//$sql = "select * from member where hero_memo_01 like '%��%' and hero_use=0 order by hero_oldday desc";
	$sql = "select * from member where hero_use=0 order by hero_oldday desc";
	sql($sql,'on');
	$numb=1;
?>
  <tr align="center">
   <td align="center" valign="middle"><strong>��ȣ</strong></td>
   <td valign="middle"><strong>����</strong></td>
   <td valign="middle"><strong>���̵�</strong></td>
   <td valign="middle"><strong>�г���</strong></td>
   <td valign="middle"><strong>���</strong></td>
	 <td valign="middle"><strong>�̸���</strong></td>
	 <td valign="middle"><strong>�̸��ϼ��ŵ���</strong></td>
	 <td valign="middle"><strong>�޴���</strong></td>
	<td valign="middle"><strong>���ڼ��ŵ���</strong></td>
	
   <td valign="middle"><strong>�ּ�</strong></td>
   <td valign="middle"><strong>��α�</strong></td>
   <td valign="middle"><strong>���̽���</strong></td>
   <td valign="middle"><strong>Ʈ����</strong></td>
   <td valign="middle"><strong>īī�����丮</strong></td>

	<td valign="middle"><strong>��α� �湮�ڼ�</strong></td>
	 <td valign="middle"><strong>Ȱ������</strong></td>
	 <td valign="middle"><strong>Ÿ��</strong></td>
    <td valign="middle"><strong>������</strong></td>

    </tr>
<?
	while($list = @mysql_fetch_array($out_sql)){
?>
  <tr align="left">
   <td align="center" valign="middle"><?=$numb?></td>
   <td align="center" valign="middle" ><?=$list["hero_name"]?></td>
   <td align="center" valign="middle" ><?=$list["hero_id"]?></td>
   <td align="center" valign="middle" ><?=$list["hero_nick"]?></td>
   <td align="center" valign="middle" ><?=$list["hero_level"]?></td>
   <td align="center" valign="middle"><?=$list["hero_mail"]?></td>
  
   <td align="center" valign="middle">
   <?php 
   	if($list["hero_chk_email"]==0)		echo "���ž���";
   	elseif($list["hero_chk_email"]==1)	echo "������";
	elseif($list["hero_chk_email"]==2)	echo "������";
   ?>
   </td>
   
   <td align="center" valign="middle" style="mso-number-format:'\@';"><?=$list["hero_hp"]?></td>
   
   <td align="center" valign="middle">
   	<?php 
   	if($list["hero_chk_phone"]==0)		echo "���ž���";
   	elseif($list["hero_chk_phone"]==1)	echo "������";
	elseif($list["hero_chk_phone"]==2)	echo "������";
   ?>
   </td>

   <td align="center" valign="middle" ><?=$list["hero_address_02"]?> <?=$list["hero_address_03"]?></td>
   <td align="center" valign="middle"><?=$list["hero_blog_00"]?></td>
   <td align="center" valign="middle"><?=$list["hero_blog_01"]?></td>
   <td align="center" valign="middle"><?=$list["hero_blog_02"]?></td>
   <td align="center" valign="middle"><?=$list["hero_blog_03"]?></td>
   
   <?
		switch ($list["hero_memo"]){
			case "" : $hero_memo = "";break;
			case 200 : $hero_memo = "200�� ����";break;
			case 800 : $hero_memo = "201~800��";break;
			case 1500 : $hero_memo = "801~1500��";break;
			case 3000 : $hero_memo = "1501~3000��";break;
			case 4000 : $hero_memo = "3001~4000��";break;
			case 5000 : $hero_memo = "4001~5000��";break;
			case 10000 : $hero_memo = "5001~10000��";break;
			case 10001 : $hero_memo = "10001�� �̻�";break;
		}
	?>
   <td align="center" valign="middle"><?=$hero_memo?></td>
	 <td align="center" valign="middle"><?=$list["hero_memo_01"]?></td>
	 <td align="center" valign="middle"><?=$list["hero_blog_type"]?></td>
   <td align="center" valign="middle"><?=$list["hero_oldday"]?></td>
  </tr>
<?php
		$numb++;
	}//end while
?>
</table>
<?
}//end if
?>