<?php
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_GET["mode"] == "allGisuExcel") {
	
	$filename = "";
	if($_GET["idx"] == "109") {
		$hero_board = "group_04_06";
		$filename = "��ü���_��ƼŬ��ȸ��";
	} else if($_GET["idx"] == "110") {
		$hero_board = "group_04_28";
		$filename = "��ü���_������Ŭ��ȸ��";
	} else if($_GET["idx"] == "111") {
		$hero_board = "group_04_27";
		$filename = "��ü���_BeautyClub������";
	} else if($_GET["idx"] == "135") {
		$hero_board = "group_04_31";
		$filename = "��ü���_LifeClub������";
	}

	header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
	header( "Content-Disposition: attachment; filename=".$filename."_".date("Ymd",time()).".xls" );
	header("Content-charset=euc-kr");
	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");
	
	$gisu = $_REQUEST["gisu"];
	$hero_use = $_REQUEST["hero_use"];
	$hero_chk_phone = $_REQUEST["hero_chk_phone"];
	$hero_chk_email = $_REQUEST["hero_chk_email"];
	
	if(strlen($hero_use) > 0) $where .= " AND m.hero_use = '".$hero_use."' ";
	if(strlen($hero_chk_phone) > 0) {
		if($hero_chk_phone == "1") {
			$where .= " AND m.hero_chk_phone = '".$hero_chk_phone."' ";
		} else {
			$where .= " AND m.hero_chk_phone != '1' ";
		}
	} 
	
	if(strlen($hero_chk_email) > 0) {
		if($hero_chk_email == "1") {
			$where .= " AND m.hero_chk_email = '".$hero_chk_email."' ";
		} else {
			$where .= " AND m.hero_chk_email != '1' ";
		}
	}
	
	$list_sql =  " SELECT g.* ";
	$list_sql .= ", m.hero_id, m.hero_nick , m.hero_use, m.hero_name, m.hero_hp, m.hero_mail ";
	$list_sql .= ", m.hero_address_01, m.hero_address_02, m.hero_address_03, m.hero_level ";
	$list_sql .= ", case when m.hero_chk_phone = 1 then '����' else '�̵���' end as hero_chk_phone_name ";
	$list_sql .= ", case when m.hero_chk_email = 1 then '����' else '�̵���' end as hero_chk_email_name ";
	$list_sql .= "from ";
	$list_sql .= "(SELECT ";
	$list_sql .= "g.hero_code, g.gisu, g.review_cnt ,g.review_select_cnt, ";
	$list_sql .= "b.hero_code AS board_hero_code ,b.hero_board_three, ";
	$list_sql .= "COUNT(b.hero_code) great_cnt, ";
	$list_sql .= "SUM(hero_board_three) great_select_cnt ";
	$list_sql .= "from ";
	$list_sql .= "(SELECT ";
	$list_sql .= "g.hero_code, g.gisu, ";
	$list_sql .= "r.hero_code AS review_hero_code, ";
	$list_sql .= "COUNT(r.hero_code) review_cnt, ";
	$list_sql .= "ifnull(SUM(lot_01),0) AS review_select_cnt ";
	$list_sql .= "FROM ";
	$list_sql .= "(SELECT hero_code, GROUP_CONCAT(gisu) AS gisu FROM member_gisu WHERE hero_board = '".$hero_board."' GROUP BY hero_code) AS g ";
	$list_sql .= "LEFT JOIN mission_review r ON g.hero_code = r.hero_code AND r.hero_table = 'group_04_05' GROUP BY g.hero_code) g ";
	$list_sql .= "LEFT JOIN board b ON b.hero_code = g.review_hero_code AND b.hero_table = 'group_04_05' GROUP BY g.hero_code) g ";
	$list_sql .= "LEFT JOIN member m ON g.hero_code = m.hero_code WHERE 1=1 ".$where;
	
	sql($list_sql,'on');
	
	$out_sql = mysql_query($list_sql);
?>	
	
	<table width="100%" border="1" cellpadding="1" cellspacing="0">
		<tr>
			<th>��ȣ</th>
			<th>������ȣ</th>
			<th>���̵�</th>
			<th>�̸�</th>
			<th>�г���</th>
			<th>����</th>
			<th>���</th>
			<th>�޴�����ȣ</th>
			<th>�̸���</th>
			<th>ȸ������</th>
			<th>�����ȣ</th>
			<th>�ּ�1</th>
			<th>�ּ�2</th>
			<th>ü��� ��û ��</th>
			<th>ü��� �ı� ��� ���� ��</th>
			<th>ü��� �ı� ��� ��</th>
			<th>ü��� ��� �ı� ��</th>
			<th>SMS���ŵ���</th>
			<th>�̸��ϼ��ŵ���</th>
		</tr>
		<? 
			$i=1;
			$member_status = array("0"=>"ȸ��","1"=>"Ż��","2"=>"�޸�ȸ��");
			while($list = @mysql_fetch_assoc($out_sql)){ 
				/*
				$all_gisu_sql = " SELECT gisu FROM member_gisu WHERE hero_board = '".$hero_board."' AND hero_code = '".$list["hero_code"]."' ORDER BY gisu DESC ";
				$all_gisu_res = sql($all_gisu_sql);
				
				$gisu_txt = "";
				while($all_gisu_list = mysql_fetch_assoc($all_gisu_res)) {
					if($gisu_txt) $gisu_txt .=", ";
					$gisu_txt .= $all_gisu_list["gisu"];
				}
				*/
		?>
			<tr>
				<td class="c"><?=$i?></td>
				<td class="c"><?=$list["hero_code"];?></td>
				<td class="c"><?=$list["hero_id"];?></td>
				<td class="c"><?=$list["hero_name"];?></td>
				<td class="c"><?=$list["hero_nick"];?></td>
				<td class="c"><?=$list["hero_level"];?></td>
				<td class="c"><?=$list["gisu"];?></td>
				<td class="c"><?=$list["hero_hp"];?></td>
				<td class="c"><?=$list["hero_mail"];?></td>
				<td class="c"><?=$member_status[$list["hero_use"]];?></td>
				<td class="c"><?=$list["hero_address_01"];?></td>
				<td class="c"><?=$list["hero_address_02"];?></td>
				<td class="c"><?=$list["hero_address_03"];?></td>
				<td class="c"><?=$list["review_cnt"];?></td>
				<td class="c"><?=$list["review_select_cnt"];?></td>
				<td class="c"><?=$list["great_cnt"];?></td>
				<td class="c"><?=$list["great_select_cnt"];?></td>
				<td class="c"><?=$list["hero_chk_phone_name"];?></td>
				<td class="c"><?=$list["hero_chk_email_name"];?></td>
			</tr>
		<? 
			$i++;
			}
		?>
	</table>
<? } ?>
