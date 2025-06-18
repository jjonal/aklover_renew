<?php
session_start(); 
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
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
	//$sql = "select * from member where hero_memo_01 like '%상%' and hero_use=0 order by hero_oldday desc";
	$sql = "select * from member where hero_use=0 order by hero_oldday desc";
	sql($sql,'on');
	$numb=1;
?>
  <tr align="center">
   <td align="center" valign="middle"><strong>번호</strong></td>
   <td valign="middle"><strong>성명</strong></td>
   <td valign="middle"><strong>아이디</strong></td>
   <td valign="middle"><strong>닉네임</strong></td>
   <td valign="middle"><strong>등급</strong></td>
	 <td valign="middle"><strong>이메일</strong></td>
	 <td valign="middle"><strong>이메일수신동의</strong></td>
	 <td valign="middle"><strong>휴대폰</strong></td>
	<td valign="middle"><strong>문자수신동의</strong></td>
	
   <td valign="middle"><strong>주소</strong></td>
   <td valign="middle"><strong>블로그</strong></td>
   <td valign="middle"><strong>페이스북</strong></td>
   <td valign="middle"><strong>트위터</strong></td>
   <td valign="middle"><strong>카카오스토리</strong></td>

	<td valign="middle"><strong>블로그 방문자수</strong></td>
	 <td valign="middle"><strong>활동지수</strong></td>
	 <td valign="middle"><strong>타입</strong></td>
    <td valign="middle"><strong>가입일</strong></td>

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
   	if($list["hero_chk_email"]==0)		echo "수신안함";
   	elseif($list["hero_chk_email"]==1)	echo "수신함";
	elseif($list["hero_chk_email"]==2)	echo "수신함";
   ?>
   </td>
   
   <td align="center" valign="middle" style="mso-number-format:'\@';"><?=$list["hero_hp"]?></td>
   
   <td align="center" valign="middle">
   	<?php 
   	if($list["hero_chk_phone"]==0)		echo "수신안함";
   	elseif($list["hero_chk_phone"]==1)	echo "수신함";
	elseif($list["hero_chk_phone"]==2)	echo "수신함";
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
			case 200 : $hero_memo = "200명 이하";break;
			case 800 : $hero_memo = "201~800명";break;
			case 1500 : $hero_memo = "801~1500명";break;
			case 3000 : $hero_memo = "1501~3000명";break;
			case 4000 : $hero_memo = "3001~4000명";break;
			case 5000 : $hero_memo = "4001~5000명";break;
			case 10000 : $hero_memo = "5001~10000명";break;
			case 10001 : $hero_memo = "10001명 이상";break;
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