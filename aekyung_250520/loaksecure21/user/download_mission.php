<?php
session_start(); 
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once   '../../freebest/head.php';
header( "Content-type: application/vnd.ms-excel;charset=iso-8859-1" ); 
header( "Content-Disposition: attachment; filename=hero_users_".date("Ymd",time()).".xls" ); 
header("Content-charset=euc-kr");
if(!$_SESSION['temp_id']){echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;}

if(($_SESSION['temp_level']==99 || $_SESSION['temp_level']==100) && is_numeric($_SESSION['temp_level'])){
	
	include  FREEBEST_INC_END.'hero.php';
	include  FREEBEST_INC_END.'function.php';
	
	db($dbname_old);
	
	$oneMonthAgo = date("Y-m-d",strtotime("-1 month"));
	
$this_year = date('Y',time());
$list_page=50;
$page_per_list=10;
$total_data = 0;
$page = 0;
$start = 0;
$next_path ='';
$order ="";
$NO = 0;
$board = $_POST['board'];


if($_POST['order']){
	$order = $_POST['order'];
	$order = explode('-',$order);
	$order = "hero_".$order[0]." ".$order[1];
}else{
	$order = "E.hero_old_idx desc";
}

if($_POST['mode']=='search'){
	
	$user_id	 			= $_POST['user_id'];
	$user_nick 				= $_POST['user_nick'];
	$user_name 				= $_POST['user_name'];
	$user_level 			= $_POST['user_level'];
	$user_region 			= $_POST['user_region'];
	$user_age 				= $_POST['user_age'];
	$user_penalty 			= $_POST['user_penalty'];
	$user_phone_agree 		= $_POST['user_phone_agree'];
	$user_email_agree 		= $_POST['user_email_agree'];
	
	$keyword		 		= $_POST['keyword'];
	$content_grade	 		= $_POST['content_grade'];
	$visit_count		 		= $_POST['visit_count'];
	$blog_type		 		= $_POST['blog_type'];
	
	$mission_register 		= $_POST['mission_register'];
	$mission_win	 		= $_POST['mission_win'];
	$mission_lover	 		= $_POST['mission_lover'];
	$mission_sns	 		= $_POST['mission_sns'];
	$mission_type	 		= $_POST['mission_type'];
	$mission_name	 		= $_POST['mission_name'];
	
	$user_power_blog	 	= $_POST['user_power_blog'];
	$user_vip_user			= $_POST['user_vip_user'];
	
	$search_condition = '';
	$search_condition = '';
	
	if($user_id)														$search_condition .= "and A.hero_id like '%".$user_id."%' ";
	if($user_nick)														$search_condition .= "and A.hero_nick like '%".$user_nick."%' ";
	if($user_name)														$search_condition .= "and A.hero_name like '%".$user_name."%' ";

	if(is_numeric($user_level[0]) and is_numeric($user_level[1]))								$search_condition .= "and hero_level >= ".$user_level[0]." and hero_level <= ".$user_level[1]." ";
	elseif(is_numeric($user_level[0]) and !is_numeric($user_level[1]))							$search_condition .= "and hero_level = ".$user_level." ";
	
	if($user_region)													$search_condition .= "and (hero_address_02 like '%".$user_region."%' or hero_address_03 like '%".$user_region."%') ";
	
	if($user_age){
		switch($user_age){
			case 1 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) < 11 ";break;
			case 10 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 11 and (".$this_year."-left(hero_jumin,4)+1) <= 15 ";break;
			case 15 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 16 and (".$this_year."-left(hero_jumin,4)+1) <= 20 ";break;
			case 20 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 21 and (".$this_year."-left(hero_jumin,4)+1) <= 25 ";break;
			case 25 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 26 and (".$this_year."-left(hero_jumin,4)+1) <= 30 ";break;
			case 30 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 31 and (".$this_year."-left(hero_jumin,4)+1) <= 35 ";break;
			case 35 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 36 and (".$this_year."-left(hero_jumin,4)+1) <= 40 ";break;
			case 40 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 41 and (".$this_year."-left(hero_jumin,4)+1) <= 45 ";break;
			case 45 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 46 and (".$this_year."-left(hero_jumin,4)+1) <= 50 ";break;
			case 50 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 51 and (".$this_year."-left(hero_jumin,4)+1) <= 55 ";break;
			case 55 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) >= 56 and (".$this_year."-left(hero_jumin,4)+1) <= 60 ";break;
			case 60 : $search_condition .= "and (".$this_year."-left(hero_jumin,4)+1) <= 61";break;
		}		
	}
	
	if($content_grade)													$search_condition .= "and hero_memo_01='".$content_grade."' ";
	if($visit_count)													$search_condition .= "and hero_memo='".$visit_count."' ";
	if($blog_type)														$search_condition .= "and (hero_blog_00 like '%".$blog_type."%' or hero_blog_01 like '%".$blog_type."%' or hero_blog_02 like '%".$blog_type."%' or hero_blog_03 like '%".$blog_type."%' or hero_blog_04 like '%".$blog_type."%' or hero_blog_05 like '%".$blog_type."%') ";
	
	if($user_penalty)													$search_condition .= "and (hero_memo_02 like '%".$user_penalty."%' or hero_memo_03 like '%".$user_penalty."%' or hero_memo_04 like '%".$user_penalty."%') ";
	if(is_numeric($user_phone_agree))									$search_condition .= "and hero_chk_phone=".$user_phone_agree." ";
	if(is_numeric($user_email_agree))									$search_condition .= "and hero_chk_email=".$user_email_agree." ";
	
	if(is_numeric($mission_register[0]) and is_numeric($mission_register[1]))					$search_condition .= "and lot_01>='".$mission_register[0]."' and lot_01<='".$mission_register[1]."' ";
	elseif(is_numeric($mission_register[0]) and !is_numeric($mission_register[1]))				$search_condition .= "and lot_01='".$mission_register[0]."' ";
	
	if(is_numeric($mission_win[0]) and is_numeric($mission_win[1]))								$search_condition .= "and lot>='".$mission_win[0]."' and lot<='".$mission_win[1]."' ";
	elseif(is_numeric($mission_win[0]) and !is_numeric($mission_win[1]))						$search_condition .= "and lot='".$mission_win[0]."' ";

	if(is_numeric($mission_lover[0]) and is_numeric($mission_lover[1]))							$search_condition .= "and hero_board_three>='".$mission_lover[0]."' and hero_board_three<='".$mission_lover[1]."' ";
	elseif(is_numeric($mission_lover[0]) and !is_numeric($mission_lover[1]))					$search_condition .= "and hero_board_three='".$mission_lover[0]."' ";
	
	if($mission_sns)													$search_condition .= "and (hero_blog_00 like '%".$mission_sns."%' or hero_blog_01 like '%".$mission_sns."%' or hero_blog_02 like '%".$mission_sns."%' or hero_blog_03 like '%".$mission_sns."%' or hero_blog_04 like '%".$mission_sns."%' or hero_blog_05 like '%".$mission_sns."%') ";
	if(is_numeric($mission_type))										$search_condition .= "and hero_mission_type = '".$mission_type."' ";
	
	if($mission_name)													$search_condition .= "and BINARY(C.hero_title) like BINARY('%".$mission_name."%') ";
	
	if($user_power_blog==1)												$search_condition .= "and A.hero_memo>2000 and A.hero_memo_01='상' ";
	if($user_vip_user==1)												$search_condition .= "and D.hero_vip>0 and A.hero_today>='".$oneMonthAgo."' and (hero_blog_01!='' or hero_blog_02!='' or hero_blog_03!='' or hero_blog_04!='' or hero_blog_05!='') ";
	
?>
<strong><?=date("Y-m-d")?>  <span style="color:blue;">파워블로거  </span><span style="color:green;">핵심인력  </span><span style="color:red;">파워블로거+핵심인력</span></strong>
<table width="100%" border="1" cellpadding="3" cellspacing="0">
<?
	$user_data_sql = "select A.hero_idx, A.hero_id, A.hero_nick, A.hero_name, A.hero_blog_01, A.hero_blog_02, A.hero_blog_03, A.hero_blog_04, A.hero_blog_05, A.hero_today, (".$this_year."-left(A.hero_jumin,4)+1) as hero_age, A.hero_hp, A.hero_address_01, concat(A.hero_address_02,' ',A.hero_address_03) as hero_addr, A.hero_memo, A.hero_level, A.hero_blog_00, if(A.hero_memo_01='상' or A.hero_memo_01='중' or A.hero_memo_01='하', A.hero_memo_01, '히') as hero_memo_01, A.hero_memo_02, A.hero_memo_03, A.hero_memo_04, D.hero_vip,C.hero_title ";
    $user_data_sql .= "from member as A ";
    $user_data_sql .= "right outer join (select hero_code, hero_old_idx, lot_01 from mission_review order by hero_code desc) as E on A.hero_code=E.hero_code ";
    $user_data_sql .= "left outer join (select hero_code, hero_old_idx, sum(lot_01) as lot, count(lot_01) as lot_01 from mission_review group by hero_code order by hero_code) as B on A.hero_code=B.hero_code ";
    $user_data_sql .= "left outer join mission as C on C.hero_idx=E.hero_old_idx ";
    $user_data_sql .= "left outer join (select hero_code, sum(hero_board_three) as hero_board_three, sum(if(hero_today>='".$oneMonthAgo."',1,0)) as hero_vip from board group by hero_code) as D on D.hero_code=A.hero_code ";
    $user_data_sql .= "where A.hero_use=0 ".$search_condition." order by ".$order;
    			//echo $user_data_sql;
    //exit;
    $user_data_res = mysql_query($user_data_sql) or die(mysql_error());

    
	
?>
		  <tr align="center">
		   	<td align="center" valign="middle"><strong>번호</strong></td>
		   	<td valign="middle"><strong>미션명</strong></td>
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
		    <td valign="middle"><strong>가입일</strong></td>
		
		   </tr>
<?
	$NO=1;
while($user_data_rs = mysql_fetch_assoc($user_data_res)){

	if($user_data_rs['hero_memo']>2000 && $user_data_rs['hero_memo_01']=='상')	$power_blog = 1;
	else																		$power_blog = 0;
	
	
	if($user_data_rs['hero_today']>=$oneMonthAgo && ($user_data_rs['hero_blog_01'] || $user_data_rs['hero_blog_02'] || $user_data_rs['hero_blog_03'] || $user_data_rs['hero_blog_04'] || $user_data_rs['hero_blog_05']) && $user_data_rs['hero_vip']>0)	$vip = 1;
	else																																																													$vip = 0;
	
	if($power_blog==1 && $vip==0)		$emphasis = "style='color:blue;'";
	elseif($power_blog==0 && $vip==1)	$emphasis = "style='color:green;'";
	elseif($vip==1 && $power_blog==1)	$emphasis = "style='color:red;'";
	else								$emphasis = "";
	
?>
		  <tr align="left" <?=$emphasis?>>
			   <td align="center" valign="middle"><?=$NO?></td>
			   <td align="center" valign="middle" ><?=$user_data_rs["hero_title"]?></td>
			   <td align="center" valign="middle" ><?=$user_data_rs["hero_name"]?></td>
			   <td align="center" valign="middle" ><?=$user_data_rs["hero_id"]?></td>
			   <td align="center" valign="middle" ><?=$user_data_rs["hero_nick"]?></td>
			   <td align="center" valign="middle" ><?=$user_data_rs["hero_level"]?></td>
			   <td align="center" valign="middle"><?=$user_data_rs["hero_mail"]?></td>
			  
			   <td align="center" valign="middle">
			   <?php 
			   	if($user_data_rs["hero_chk_email"]==0)		echo "수신안함";
			   	elseif($user_data_rs["hero_chk_email"]==1)	echo "수신함";
				elseif($user_data_rs["hero_chk_email"]==2)	echo "수신함";
			   ?>
			   </td>
			   
			   <td align="center" valign="middle" style="mso-number-format:'\@';"><?=$user_data_rs["hero_hp"]?></td>
			   
			   <td align="center" valign="middle">
			   	<?php 
			   	if($user_data_rs["hero_chk_phone"]==0)		echo "수신안함";
			   	elseif($user_data_rs["hero_chk_phone"]==1)	echo "수신함";
				elseif($user_data_rs["hero_chk_phone"]==2)	echo "수신함";
			   ?>
			   </td>
			
			   <td align="center" valign="middle" ><?=$user_data_rs["hero_addr"]?></td>
			   <td align="center" valign="middle"><?=$user_data_rs["hero_blog_00"]?></td>
			   <td align="center" valign="middle"><?=$user_data_rs["hero_blog_01"]?></td>
			   <td align="center" valign="middle"><?=$user_data_rs["hero_blog_02"]?></td>
			   <td align="center" valign="middle"><?=$user_data_rs["hero_blog_03"]?></td>
   
			   <?
					switch ($user_data_rs["hero_memo"]){
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
				<td align="center" valign="middle"><?=($user_data_rs["hero_memo_01"]=='히')? "" : $user_data_rs["hero_memo_01"];?></td>
				<td align="center" valign="middle"><?=$user_data_rs["hero_oldday"]?></td>
  		</tr>
	<?php
			$NO++;
		}//end while
	?>
</table>
<?
    }}//end if
?>
