<?php
define('_HEROBOARD_', TRUE);//HEROBOARD����
include                                '../../freebest/head.php';
include                                '../../freebest/function.php';


header( "Content-type: application/vnd.ms-excel;charset=euc-kr" ); 
header( "Content-Disposition: attachment; filename=ȸ������������_".date("Ymd",time()).".xls" ); 
header("Content-charset=euc-kr");
print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=euc-kr\">");

//�˻����

$mission_gubun = $_REQUEST["mission_gubun"];
$mission_title = $_REQUEST["mission_title"];
$mission_sel_option = $_REQUEST["mission_sel_option"];

if(strcmp($_REQUEST['keyword'], '')){
	$search1 .= ' and '.$_REQUEST['select'].'=\''.$_REQUEST['keyword'].'\' ';
}

if(strcmp($_REQUEST['hero_sex'], '')){
	$search1 .= ' and hero_sex=\''.$_REQUEST['hero_sex'].'\' ';
}

if(strcmp($_REQUEST['hero_blog_00'], '')){
	$search1 .= ' AND (hero_blog_00 is not null  and  length(hero_blog_00) > 0) ';
}

if(strcmp($_REQUEST['hero_blog_04'], '')){
	$search1 .= ' AND (hero_blog_04 is not null  and  length(hero_blog_04) > 0) ';
}

if(strcmp($_REQUEST['hero_chk_phone'], '')){
	if($_REQUEST['hero_chk_phone'] == "1") {
		$search1 .= ' AND hero_chk_phone = 1 ';
	} else if($_REQUEST['hero_chk_phone'] == "0") {
		$search1 .= ' AND hero_chk_phone != 1 ';
	}
	$search_next .= '&hero_chk_phone='.$_REQUEST['hero_chk_phone'];
}

if(strcmp($_REQUEST['hero_chk_email'], '')){
	if($_REQUEST['hero_chk_email'] == "1") {
		$search1 .= ' AND hero_chk_email = 1 ';
	} else if($_REQUEST['hero_chk_email'] == "0") {
		$search1 .= ' AND hero_chk_email != 1 ';
	}
	$search_next .= '&hero_chk_email='.$_REQUEST['hero_chk_email'];
}

if(strcmp($_REQUEST['hero_oldday_start'], '')){
	$search1 .= " AND date_format(hero_oldday,'%Y%m%d') >= ".$_REQUEST['hero_oldday_start'];
	$search_next .= '&hero_oldday_start='.$_REQUEST['hero_oldday_start'];
}

if(strcmp($_REQUEST['hero_oldday_end'], '')){
	$search1 .= " AND date_format(hero_oldday,'%Y%m%d') <= ".$_REQUEST['hero_oldday_end'];
	$search_next .= '&hero_oldday_end='.$_REQUEST['hero_oldday_end'];
}

if(strcmp($_REQUEST['hero_age_start'], '')){
	$search2 .= ' AND hero_age >= '.$_REQUEST['hero_age_start'];
}

if(strcmp($_REQUEST['hero_age_end'], '')){
	$search2 .= ' AND hero_age <= '.$_REQUEST['hero_age_end'];
}

if($mission_sel_option < 3 && $mission_sel_option) {
	$sql_join_search .= " INNER JOIN mission_review r ON m.hero_code = r.hero_code   ";
	$search2 .= " AND r.hero_use = 0 AND r.hero_old_idx = '".$mission_title."' ";
	if($mission_sel_option > 1) $search2 .= " AND r.lot_01 = 1 ";

} else if($mission_sel_option > 2 && $mission_sel_option){ //3���� �ı���, ����ı� �Խ��� Ȯ��
	$sql_join_search .= " INNER JOIN board b ON m.hero_code = b.hero_code   ";
	$search2 .= " AND  b.hero_01 = '".$mission_title."' ";

	if($mission_sel_option > 3) $search2 .= " AND b.hero_board_three = 1 ";
}

//������ ����Ʈ
$sql  = " SELECT m.hero_code, m.hero_id, m.hero_nick, m.hero_name, m.hero_hp, m.hero_oldday ";
$sql .= " , m.hero_chk_phone , m.hero_chk_email, m.hero_sex, m.hero_age ";
$sql .= " , m.hero_blog_00 , m.hero_blog_01 , m.hero_blog_02 , m.hero_blog_03 , m.hero_blog_04 , m.hero_blog_05, m.hero_blog_05_name ";
$sql .= " , m.hero_facebook, m.hero_kakaoTalk, m.hero_naver, m.hero_jumin, m.hero_mail, m.hero_address_01, m.hero_address_02, m.hero_address_03 ";
$sql .= " , m.hero_today, m.hero_vip, m.hero_level, m.hero_point, m.hero_insta_cnt, m.hero_memo, m.hero_memo_01, m.hero_memo_02 , m.hero_memo_03";
$sql .= " , m.hero_memo_04, m.hero_user, m.hero_superpass, m.area, m.area_etc_text, m.hero_chk_email_update, m.hero_terms_05";
$sql .= " , m.hero_pid, m.hero_qs_01, m.hero_qs_02, m.hero_qs_03, m.hero_qs_04, m.hero_qs_05, m.hero_qs_06, m.hero_qs_07, m.hero_qs_08";
$sql .= " , m.hero_qs_09, m.hero_qs_10, m.hero_qs_11, m.hero_qs_12, m.hero_gift_point, m.hero_today as qs_hero_today, m.hero_modi_today, m.hero_give_point_today ";
$sql .= " FROM ";
$sql .= " (SELECT m.hero_code, m.hero_id, m.hero_nick, m.hero_name, m.hero_hp , m.hero_oldday ";
$sql .= " , m.hero_blog_00 , m.hero_blog_01 , m.hero_blog_02 , m.hero_blog_03 , m.hero_blog_04 , m.hero_blog_05, m.hero_blog_05_name ";
$sql .= " , if(m.hero_facebook,'����','������') as hero_facebook,  if(m.hero_kakaoTalk,'����','������') as hero_kakaoTalk ,  if(m.hero_naver,'����','������') as hero_naver ";
$sql .= " , m.hero_jumin ,m.hero_mail, m.hero_address_01, m.hero_address_02, m.hero_address_03 ";
$sql .= " , (case when m.hero_chk_phone = 1 then '����' else '�̼���' end) hero_chk_phone ";
$sql .= " , (case when m.hero_chk_email = 1 then '����' else '�̼���' end) hero_chk_email ";
$sql .= " , (case when m.hero_sex = 0 then '����' else '����' end) hero_sex ";
$sql .= " , (date_format(now(),'%Y') - left(m.hero_jumin,4) + 1) hero_age ";
$sql .= " , m.hero_today, if(m.hero_vip = 'Y','vipȸ��','') as hero_vip, m.hero_level, m.hero_point, m.hero_insta_cnt, m.hero_memo, m.hero_memo_01, m.hero_memo_02 , m.hero_memo_03 ";
$sql .= " , m.hero_memo_04, m.hero_user, m.hero_superpass, m.area, m.area_etc_text, m.hero_chk_email_update, m.hero_terms_05 ";
$sql .= " , q.hero_pid, q.hero_qs_01, q.hero_qs_02, q.hero_qs_03, q.hero_qs_04, q.hero_qs_05, q.hero_qs_06, q.hero_qs_07, q.hero_qs_08";
$sql .= " , q.hero_qs_09, q.hero_qs_10, q.hero_qs_11, q.hero_qs_12, q.hero_gift_point, q.hero_today as qs_hero_today, q.hero_modi_today, hero_give_point_today ";
$sql .= " FROM member m LEFT JOIN member_question q ON m.hero_code = q.hero_code AND q.hero_pid = '3' where m.hero_use=0 ".$search1.") m ";
$sql .= $sql_join_search;
$sql .= " WHERE 1=1 ".$search2. " order by hero_oldday desc ";

sql($sql,"on");

//�̷³����
$histroy_sql = " INSERT INTO member_excel_history (hero_id, hero_oldday) values ('".$_SESSION["temp_id"]."',now()) ";
mysql_query($histroy_sql);

?>
<style>
table td{mso-number-format:'\@'}
</style>
<table border="1" cellpadding="1" cellspacing="0">
<tr>
	<th>�����ڵ�</th>
	<th>���̵�</th>
	<th>�̸�</th>
	<th>�г���</th>
	<th>����</th>
	<th>����</th>
	<th>������</th>
    <th>�޴�����ȣ</th>
    <th>�̸���</th>
    <th>��α��ּ�</th>
    
    <th>���̽����ּ�</th>
    <th>Ʈ�����ּ�</th>
    <th>īī�����丮 �ּ�</th>
    <th>�ν�Ÿ�ּ�</th>
    <th>�� �� SNS �̸�</th>
    <th>�� �� SNS URL</th>
    <th>���ڼ��ſ���</th>
    <th>�̸��ϼ��ſ���</th>
    <th>�α��� ���̽��� ����</th>
    <th>�α��� īī�� ����</th>
    
    <th>�α��� ���̹� ����</th>
    <th>�������</th>
    <th>�����ȣ</th>
    <th>�ּ�1</th>
    <th>���ּ�</th>
    <th>�ֱ� �α��� �ð�</th>
    <th>vip</th>
    <th>����</th>
    <th>����Ʈ</th>
    <th>�ν�Ÿ�ȷο���</th>
    
    <th>��α� �湮�� ��</th>
    <th>��α� ������ ���</th>
    <th>�г�Ƽ ����1</th>
    <th>�г�Ƽ ����2</th>
    <th>�г�Ƽ ����3</th>
    <th>��õ��</th>
    <th>�˰Ե� ���</th>
    <th>�˰Ե� ��� ��Ÿ</th>
    <th>�̸��� ���� �ź��� ��¥</th>
    
    <th>�߰� �Է� ����Ʈ ����</th>
    <th>�߰� �Է� ȸ��</th>
    <th>�����Ͽ� �������� ��� �� �� ���ε� �Ͻó���?</th>
    <th>� ���� ��α��� ��� �� �湮�ڴ� �� ���ΰ���?</th>
    <th>��α� Ÿ��(�� �ߺ� ���� ����) </th>
    <th>��ȥ ����</th>
    <th>�ڳ� ����</th>
    <th>�ڳ�� �Է�</th>
    <th>�ڳ� ���ɴ� (, ����)</th>
    <th>AK�� ������ ����</th>
    
    <th>�ְ� �� Ȱ���ϴ� �������� ����</th>
    <th>�ְ� �� Ȱ���ϴ� �������� ��</th>
    <th>���� URL ����</th>
    <th>����� ��α� ����</th>
    <th>���� �� ���� ����Ʈ</th>
    <th>���� �Է���</th>
    <th>���� ������</th>
    <th>���� ����Ʈ ������</th>
</tr>
<? while($list = @mysql_fetch_assoc($out_sql)){?>
<tr>
	<td><?=$list['hero_code'];?></td>
	<td><?=$list['hero_id'];?></td>
	<td><?=$list['hero_name'];?></td>
	<td><?=$list['hero_nick'];?></td>
	<td><?=$list['hero_age'];?></td>
	<td><?=$list['hero_sex'];?></td>
	<td><?=$list['hero_oldday'];?></td>
	<td><?=$list['hero_hp'];?></td>
	<td><?=$list['hero_mail'];?></td>
	<td><?=$list['hero_blog_00'];?></td>
	
	<td><?=$list['hero_blog_01'];?></td>
	<td><?=$list['hero_blog_02'];?></td>
	<td><?=$list['hero_blog_03'];?></td>
	<td><?=$list['hero_blog_04'];?></td>
	<td><?=$list['hero_blog_05_name'];?></td>
	<td><?=$list['hero_blog_05'];?></td>
	<td><?=$list['hero_chk_phone'];?></td>
	<td><?=$list['hero_chk_email'];?></td>
	<td><?=$list['hero_facebook'];?></td>
	<td><?=$list['hero_kakaoTalk'];?></td>
	
	<td><?=$list['hero_naver'];?></td>
	<td><?=$list['hero_jumin'];?></td>
	<td><?=$list['hero_address_01'];?></td>
	<td><?=$list['hero_address_02'];?></td>
	<td><?=$list['hero_address_03'];?></td>
	<td><?=$list['hero_today'];?></td>
	<td><?=$list['hero_vip'];?></td>
	<td><?=$list['hero_level'];?></td>
	<td><?=$list['hero_point'];?></td>
	<td><?=$list['hero_insta_cnt'];?></td>
	
	<td><?=$list['hero_memo'];?></td>
	<td><?=$list['hero_memo_01'];?></td>
	<td><?=$list['hero_memo_02'];?></td>
	<td><?=$list['hero_memo_03'];?></td>
	<td><?=$list['hero_memo_04'];?></td>
	<td><?=$list['hero_user'];?></td>
	<td><?=$list['area'];?></td>
	<td><?=$list['area_etc_text'];?></td>
	<td><?=$list['hero_chk_email_update'];?></td>
	
	<td><?=$list['hero_terms_05'];?></td>
	<td><?=$list['hero_pid'];?></td>
	<td><?=$list['hero_qs_01'];?></td>
	<td><?=$list['hero_qs_02'];?></td>
	<td><?=$list['hero_qs_03'];?></td>
	<td><?=$list['hero_qs_04'];?></td>
	<td><?=$list['hero_qs_05'];?></td>
	<td><?=$list['hero_qs_11'];?></td>
	<td><?=$list['hero_qs_12'];?></td>
	<td><?=$list['hero_qs_06'];?></td>
	
	<td><?=$list['hero_qs_07'];?></td>
	<td><?=$list['hero_qs_08'];?></td>
	<td><?=$list['hero_qs_09'];?></td>
	<td><?=$list['hero_qs_10'];?></td>
	<td><?=$list['hero_gift_point'];?></td>
	<td><?=$list['qs_hero_today'];?></td>
	<td><?=$list['hero_modi_today'];?></td>
	<td><?=$list['hero_give_point_today'];?></td>
</tr>
<? } ?>
</table>
