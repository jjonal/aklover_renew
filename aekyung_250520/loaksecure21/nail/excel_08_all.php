<?php
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_POST["mode"] == "excelAll") {
		
	header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
	header( "Content-Disposition: attachment; filename=��ü���������Ŭ��_".date("Ymd",time()).".xls" );
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
	
	$list_sql  =  " SELECT g.* ";
	$list_sql .=  " , sum(if(review_cnt!='',1,0)) review_cnt";
	$list_sql .=  " , ifnull(SUM(lot_01),0) AS review_select_cnt";
	$list_sql .=  " , (SELECT COUNT(*) FROM board WHERE hero_code=g.review_cnt AND hero_table = 'group_04_05') AS great_cnt ";
	$list_sql .=  " , (SELECT COUNT(*) FROM board WHERE hero_code=g.review_cnt AND hero_table = 'group_04_05' AND hero_board_three = '1') AS great_select_cnt ";
	$list_sql .=  " FROM ";
	$list_sql .=  " ( SELECT m.hero_code , m.hero_id, m.hero_nick , m.hero_use, m.hero_name, m.hero_hp, m.hero_mail ";
	$list_sql .=  " , m.hero_address_01, m.hero_address_02, m.hero_address_03 ";
	$list_sql .=  " , case when m.hero_chk_phone = 1 then '����' else '�̵���' end as hero_chk_phone_name ";
	$list_sql .=  " , case when m.hero_chk_email = 1 then '����' else '�̵���' end as hero_chk_email_name ";
	$list_sql .=  " , r.hero_code AS review_cnt, r.lot_01";
	$list_sql .=  " FROM (SELECT hero_code FROM member_gisu WHERE hero_board = 'group_04_28' GROUP BY hero_code) g ";
	$list_sql .=  " LEFT JOIN member m ON g.hero_code = m.hero_code  ";
	$list_sql .=  " LEFT JOIN mission_review r ON g.hero_code = r.hero_code AND r.hero_table = 'group_04_05' ";
	$list_sql .=  " WHERE 1=1 ".$where;
	$list_sql .=  "  ) g GROUP BY hero_code ";
	
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
		?>
			<tr>
				<td class="c"><?=$i?></td>
				<td class="c"><?=$list["hero_code"];?></td>
				<td class="c"><?=$list["hero_id"];?></td>
				<td class="c"><?=$list["hero_name"];?></td>
				<td class="c"><?=$list["hero_nick"];?></td>
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
