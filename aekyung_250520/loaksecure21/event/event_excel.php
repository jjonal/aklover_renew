<?php
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

$type = $_GET['type'];
$join = $_GET['join'];

if($type == "9month") $title="9���� �̷α���";
else if($type == "rest") $title="�޸�ȸ��";
else if($type == "50level") $title="50����";


header( "Content-type: application/vnd.ms-excel;charset=iso-8859-1" ); 
header( "Content-Disposition: attachment; filename=".$title."_�̺�Ʈ���_".date("Ymd",time()).".xls" ); 
header("Content-charset=euc-kr");

?>
<strong><?=date("Y-m-d")?></strong>
<table width="100%" border="1" cellpadding="1" cellspacing="0">
<?
	$where = "";
	if($join=="Y") $where = " AND login_date IS NOT NULL";
	
	if($type == "9month") {
		$sql = "SELECT hero_code, in_date, login_date FROM member_login_event_9month WHERE date_format(`in_date`,'%Y-%m-%d') BETWEEN '".$_GET['hero_today_start']."' AND '".$_GET['hero_today_end']."' ".$where."";
	}else if($type == "rest") {
		$sql = "SELECT hero_code, hero_today as in_date, login_date FROM member_login_event WHERE date_format(`hero_today`,'%Y-%m-%d') BETWEEN '".$_GET['hero_today_start2']."' AND '".$_GET['hero_today_end2']."' ".$where."";
	}else if($type == "50level") {
		$sql = "SELECT A.hero_id, A.hero_nick, A.hero_name, A.hero_hp, A.hero_address_01, A.hero_address_02, A.hero_address_03, B.hero_level, B.hero_today 
				FROM member A LEFT JOIN level_log B ON A.hero_code = B.hero_code WHERE date_format(B.hero_today,'%Y-%m-%d') BETWEEN '".$_GET['hero_today_start3']."' AND '".$_GET['hero_today_end3']."' ";
	}
	
	sql($sql,'on');
	$numb=1;
	
	if($type == "50level") {
		
?>
          <tr align="center">
           <td align="center" valign="middle"><strong>��ȣ</strong></td>
           <td valign="middle"><strong>���̵�</strong></td>
           <td valign="middle"><strong>�̸�</strong></td>
           <td valign="middle"><strong>�г���</strong></td>
           <td valign="middle"><strong>�޴�����ȣ</strong></td>
           <td valign="middle"><strong>�����ȣ</strong></td>
           <td valign="middle"><strong>�ּ�</strong></td>
           <td valign="middle"><strong>���ּ�</strong></td>
           <td valign="middle"><strong>50�����޼���¥</strong></td>
          </tr>
     <? 
	 	while($list = @mysql_fetch_array($out_sql)){
			?>
               <tr align="left">
                   <td align="center" valign="middle"><?=$numb?></td>
                   <td align="center" valign="middle"><?=$list['hero_id']?></td>
                   <td align="center" valign="middle"><?=$list['hero_name'];?></td>
                   <td align="center" valign="middle"><?=$list['hero_nick'];?></td>
                   <td align="center" valign="middle"><?=nl2br($list['hero_hp']);?></td>
                   <td align="center" valign="middle"><?=nl2br($list['hero_address_01']);?></td>
                   <td align="center" valign="middle"><?=nl2br($list['hero_address_02']);?></td>
                   <td align="center" valign="middle"><?=nl2br($list['hero_address_03']);?></td>
                   <td align="center" valign="middle"><?=$list['hero_today'];?></td>
               </tr>
       		<? 
		  $numb++;
	 	  } 
	 ?>
     
    
<? }else { ?>
  <tr align="center">
   <td align="center" valign="middle"><strong>��ȣ</strong></td>
   <td valign="middle"><strong>���̵�</strong></td>
   <td valign="middle"><strong>�̸�</strong></td>
   <td valign="middle"><strong>�г���</strong></td>
   <td valign="middle"><strong>�޴�����ȣ</strong></td>
   <td valign="middle"><strong>�̸���</strong></td>
   <td valign="middle"><strong>�����ȣ</strong></td>
   <td valign="middle"><strong>�ּ�</strong></td>
   <td valign="middle"><strong>���ּ�</strong></td>
   <td valign="middle"><strong>�̺�Ʈ����� �� ��¥</strong></td>
   <td valign="middle"><strong>�̺�Ʈ ������</strong></td>
   <td valign="middle"><strong>�޸�ȸ�� ����</strong></td>
  </tr>
<?
	while($list = @mysql_fetch_array($out_sql)){
		$member_list = "";
		$restCheck = "";
		$sql = "SELECT hero_id, hero_name, hero_nick, hero_hp, hero_address_01, hero_address_02, hero_address_03, hero_mail FROM member WHERE hero_code = '".$list['hero_code']."'";
		$member_sql = mysql_query($sql);
		$member_list = @mysql_fetch_array($member_sql);
		
		if($member_list['hero_id'] == "") {
			$sql = "SELECT hero_id, hero_name, hero_nick, hero_hp, hero_address_01, hero_address_02, hero_address_03, hero_mail FROM member_backup WHERE hero_code = '".$list['hero_code']."'";
			$member_sql = mysql_query($sql);
			$member_list = @mysql_fetch_array($member_sql);
			$restCheck = "Y";
		}

		 
?>
  <tr align="left">
   <td align="center" valign="middle"><?=$numb?></td>
   <td align="center" valign="middle"><?=$member_list['hero_id'];?></td>
   <td align="center" valign="middle"><?=$member_list['hero_name'];?></td>
   <td align="center" valign="middle"><?=$member_list['hero_nick'];?></td>
   <td align="center" valign="middle"><?=nl2br($member_list['hero_hp']);?></td>
   <td align="center" valign="middle"><?=nl2br($member_list['hero_mail']);?></td>
   <td align="center" valign="middle"><?=nl2br($member_list['hero_address_01']);?></td>
   <td align="center" valign="middle"><?=nl2br($member_list['hero_address_02']);?></td>
   <td align="center" valign="middle"><?=nl2br($member_list['hero_address_03']);?></td>
   <td align="center" valign="middle"><?=$list['in_date'];?></td>
   <td align="center" valign="middle"><?=$list['login_date'];?></td>
   <td align="center" valign="middle"><?=$restCheck;?></td>
  
   
  </tr>
<?php
		
		$numb++;
	}//end while
}
?>
</table>
