<?php
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';


if($_POST["mode"] == "excel") {
	
	$club_type = !$_REQUEST["club_type"] ? "9996":$_REQUEST["club_type"];
	
	header( "Content-type: application/vnd.ms-excel;charset=euc-kr" ); 
	header( "Content-Disposition: attachment; filename=당첨자관리_".date("Ymd",time()).".xls" ); 
	header("Content-charset=euc-kr");
	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");
	
	$sql  =  " SELECT m.hero_nick, m.hero_name, m.hero_hp, m.hero_use, w.level ";
	$sql .=  " FROM mission_winner_list w INNER JOIN member m ON w.hero_nick = m.hero_nick AND w.hero_name = m.hero_name ";
	$sql .=  " WHERE m.hero_use = 0 AND w.level = '".$club_type."' ";
	$sql .=  " ORDER BY m.hero_name ASC ";
	
	sql($sql,'on');
	
	$out_sql = mysql_query($sql);
?>	
	
	<table width="100%" border="1" cellpadding="1" cellspacing="0">
		<colgroup>
			<col width="25%" />
			<col width="25$" />
			<col width="25%" />
			<col width="25%" />
		</colgroup>
		<tr>
			<th>뷰티/휘슬</th>
			<th>이름</th>
			<th>휴대폰번호</th>
			<th>닉네임</th>
		</tr>
		<? 
			while($list = @mysql_fetch_assoc($out_sql)){ 
				
				$str_level = "뷰티클럽";
				if($list["level"] == "9997") $str_level = "휘슬클럽";
		?>
			<tr>
				<td class="c"><?=$str_level;?></td>
				<td class="c"><?=$list["hero_name"];?></td>
				<td class="c"><?=$list["hero_hp"];?></td>
				<td class="c"><?=$list["hero_nick"];?></td>
			</tr>
		<? 
			$i--;
			}
		?>
	
	</table>
<? } ?>
