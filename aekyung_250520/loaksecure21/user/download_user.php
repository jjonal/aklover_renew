<?php
session_start(); 
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once   '../../freebest/head.php';
header( "Content-type: application/vnd.ms-excel;charset=iso-8859-1" ); 
header( "Content-Disposition: attachment; filename=hero_users_".date("Ymd",time()).".xls" ); 
header("Content-charset=euc-kr");
if(!$_SESSION['temp_id']){
	echo '<script>location.href="'.PATH_END.'out.php"</script>';
	exit;
}

if($_SESSION['temp_level']<99 || !is_numeric($_SESSION['temp_level'])) exit;
	
	include  FREEBEST_INC_END.'hero.php';
	include  FREEBEST_INC_END.'function.php';
	
	db($dbname_old);
	
	include_once '../../combined/admin_user_manager.php';
	
		
?>
<strong><?=date("Y-m-d")?>  <span style="color:blue;">�Ŀ���ΰ�  </span><span style="color:green;">�ٽ��η�  </span><span style="color:red;">�Ŀ���ΰ�+�ٽ��η�</span></strong>
<table width="100%" border="1" cellpadding="3" cellspacing="0">
<?
	//$sql = "select * from member where hero_memo_01 like '%��%' and hero_use=0 order by hero_oldday desc";
				$user_data_sql = "select A.hero_idx, A.hero_id, A.hero_nick, A.hero_name, (".$this_year."-left(A.hero_jumin,4)+1) as hero_age, A.hero_level, A.hero_mail, A.hero_hp,A.hero_address_02,A.hero_address_03, A.hero_blog_00, A.hero_blog_01, A.hero_blog_02, A.hero_blog_03, A.hero_blog_04, A.hero_blog_05, A.hero_memo, A.hero_today, if(A.hero_memo_01='��' or A.hero_memo_01='��' or A.hero_memo_01='��', A.hero_memo_01, '��') as hero_memo_01, A.hero_memo_02, A.hero_memo_03, A.hero_memo_04, A.hero_user, A.hero_chk_phone, A.hero_chk_email, A.hero_oldday, B.hero_possible, C.hero_total, D.hero_code from member as A ";
    			$user_data_sql .= "left outer join (select hero_code, sum(hero_point) as hero_possible from point where hero_today > '2014-09-10 22:23:32' ".$search_condition_02." group by hero_code) as B on A.hero_code=B.hero_code ";
    			$user_data_sql .= "left outer join (select hero_code, sum(hero_point) as hero_total from point where 1=1 ".$search_condition_02." group by hero_code) as C on A.hero_code=C.hero_code ";
    			$user_data_sql .= "left outer join (select hero_code from board WHERE hero_today>='".$oneMonthAgo."' group by hero_code) as D on D.hero_code = A.hero_code ";
    			$user_data_sql .= "where A.hero_use=0 ".$search_condition." order by ".$order;
    //echo $user_data_sql;
    //exit;
    $user_data_res = mysql_query($user_data_sql) or die(mysql_error());

    
	
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
		    <td valign="middle"><strong>������</strong></td>
		
		   </tr>
<?
	$NO=1;
while($user_data_rs = mysql_fetch_assoc($user_data_res)){
	
	if($user_data_rs['hero_memo']>2000 && $user_data_rs['hero_memo_01']=='��')	$power_blog = 1;
	else																		$power_blog = 0;
	
	
	if($user_data_rs['hero_today']>=$oneMonthAgo && $user_data_rs['hero_blog_00'] && $user_data_rs['hero_code'])	$vip = 1;
	else																											$vip = 0;
	
	if($power_blog==1 && $vip==0)		$emphasis = "style='color:blue;'";
	elseif($power_blog==0 && $vip==1)	$emphasis = "style='color:green;'";
	elseif($vip==1 && $power_blog==1)	$emphasis = "style='color:red;'";
	else								$emphasis = "";
	
?>
		  <tr align="left" <?=$emphasis?>>
			   <td align="center" valign="middle"><?=$NO?></td>
			   <td align="center" valign="middle" ><?=$user_data_rs["hero_name"]?></td>
			   <td align="center" valign="middle" ><?=$user_data_rs["hero_id"]?></td>
			   <td align="center" valign="middle" ><?=$user_data_rs["hero_nick"]?></td>
			   <td align="center" valign="middle" ><?=$user_data_rs["hero_level"]?></td>
			   <td align="center" valign="middle"><?=$user_data_rs["hero_mail"]?></td>
			  
			   <td align="center" valign="middle">
			   <?php 
			   	if($user_data_rs["hero_chk_email"]==0)		echo "���ž���";
			   	else										echo "������";
			   ?>
			   </td>
			   
			   <td align="center" valign="middle" style="mso-number-format:'\@';"><?=$user_data_rs["hero_hp"]?></td>
			   
			   <td align="center" valign="middle">
			   	<?php 
			   	if($user_data_rs["hero_chk_phone"]==0)		echo "���ž���";
				else										echo "������";
			   ?>
			   </td>
			
			   <td align="center" valign="middle"><?=$user_data_rs["hero_address_02"]?> <?=$user_data_rs["hero_address_03"]?></td>
			   <td align="center" valign="middle"><?=$user_data_rs["hero_blog_00"]?></td>
			   <td align="center" valign="middle"><?=$user_data_rs["hero_blog_01"]?></td>
			   <td align="center" valign="middle"><?=$user_data_rs["hero_blog_02"]?></td>
			   <td align="center" valign="middle"><?=$user_data_rs["hero_blog_03"]?></td>
   
			   <?
					switch ($user_data_rs["hero_memo"]){
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
				<td align="center" valign="middle"><?=($user_data_rs["hero_memo_01"]=='��')? "" : $user_data_rs["hero_memo_01"];?></td>
				<td align="center" valign="middle"><?=$user_data_rs["hero_oldday"]?></td>
  		</tr>
<?php
	$NO++;
}//end while
?>
</table>
