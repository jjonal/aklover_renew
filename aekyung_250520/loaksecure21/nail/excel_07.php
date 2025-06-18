<?php
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_POST["mode"] == "excel") {
		
	header( "Content-type: application/vnd.ms-excel;charset=euc-kr" );
	header( "Content-Disposition: attachment; filename=휘슬클럽_".date("Ymd",time()).".xls" );
	header("Content-charset=euc-kr");
	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");
	
	$hero_use = $_REQUEST["hero_use"];
	$hero_chk_phone = $_REQUEST["hero_chk_phone"];
	$hero_chk_email = $_REQUEST["hero_chk_email"];
	
	if(strlen($hero_use) > 0) {
		if($hero_use == 0) {
			$where .= " AND m.hero_use = '0' ";
		} else {
			$where .= " AND (m.hero_use != '0' or m.hero_use is null) ";
		}
	}
	
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
	
	$list_sql  =  " SELECT  m.hero_code , m.hero_id, w.hero_nick , m.hero_use, m.hero_name, m.hero_hp, m.hero_mail ";
	$list_sql .=  " , case when m.hero_chk_phone = 1 then '동의' else '미동의' end as hero_chk_phone_name ";
	$list_sql .=  " , case when m.hero_chk_email = 1 then '동의' else '미동의' end as hero_chk_email_name ";
	$list_sql .=  " FROM mission_winner_list w LEFT JOIN member m ON w.hero_nick = m.hero_nick AND w.hero_name = m.hero_name  ";
	$list_sql .=  " WHERE w.level = '9997' ".$where;
	
	sql($list_sql,'on');
	
	$out_sql = mysql_query($list_sql);
?>	
	
	<table width="100%" border="1" cellpadding="1" cellspacing="0">
		<tr>
			<th>번호</th>
			<th>고유번호</th>
			<th>아이디</th>
			<th>이름</th>
			<th>닉네임</th>
			<th>휴대폰번호</th>
			<th>이메일</th>
			<th>회원상태</th>
			<th>SMS수신동의</th>
			<th>이메일수신동의</th>
		</tr>
		<? 
			$i=1;
			$member_status = array("0"=>"회원","1"=>"탈퇴","2"=>"휴먼회원");
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
				<td class="c"><?=$member_status[$list["hero_use"]] == "회원" ? "회원":"정보없음";?></td>
				<td class="c"><?=$list["hero_chk_phone_name"];?></td>
				<td class="c"><?=$list["hero_chk_email_name"];?></td>
			</tr>
		<? 
			$i++;
			}
		?>
	</table>
<? } ?>
