<?php
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';


if($_POST["mode"] == "excel") {
	
	$club_type = !$_REQUEST["club_type"] ? "9996":$_REQUEST["club_type"];
	
	header( "Content-type: application/vnd.ms-excel;charset=euc-kr" ); 
	header( "Content-Disposition: attachment; filename=��÷�ڰ���_".date("Ymd",time()).".xls" ); 
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
			<th>��Ƽ/�ֽ�</th>
			<th>�̸�</th>
			<th>�޴�����ȣ</th>
			<th>�г���</th>
		</tr>
		<? 
			while($list = @mysql_fetch_assoc($out_sql)){ 
				
				$str_level = "��ƼŬ��";
				if($list["level"] == "9997") $str_level = "�ֽ�Ŭ��";
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
