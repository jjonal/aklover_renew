<?
define('_HEROBOARD_', TRUE);
include_once '/home/users/aekyung/freebest/head.php';
include_once '/home/users/aekyung/freebest/hero.php';
include_once '/home/users/aekyung/freebest/function.php';
db("aekyung");


/**********************************
* ��¥: 20170126 
* �ۼ���: ���Ʒ�
* �ٽ��η� ���� Ȯ�� �� ������Ʈ
* ���� 
	(3�� ��� �����ϰ�)
	- ���ӱ�� ������ �̳� //170511 ��������
	- �Խñ� ������ �̳�
	- ��α� URL ��
	(�Ʒ� �ɼ� �� �ϳ� ����)
	- ��α� ������ '��'
	- ����ı� 1ȸ�̻� ���� ��� // 170510 ���� ����
	- �Ϲ湮�� 1500�̻�

* ������ �α����Ҷ� üũ������ 20170511 ���� �����췯�� ����
***********************************/
//2017.05.17 �Ѵ������� ����
//2017.06.29 ���������� ����
$oneWeekAgo = date("Y-m-d",strtotime("-3 month"));

/*
$sql1 = "select count(a.hero_name) cn from (
	select count(*) cnt, hero_name from board where hero_today  >= NOW() -  INTERVAL 3 MONTH  and
	hero_table in ('group_02_02','group_03_03','group_04_09','group_04_07','group_04_06','group_04_23','group_04_05','group_04_10')
	group by hero_code order by cnt desc
	) a";
*/
/*
$sql1 = "select count(b.hero_name) cn from(
			select sum(cnt) cnt, a.hero_name,a.hero_code from(
				
				select count(*) cnt, hero_name,hero_code from review where hero_today  >= NOW() -  INTERVAL 3 MONTH  and
				hero_table in ('group_02_03','group_04_03','group_02_02','group_03_03','group_03_05','group_04_24','group_01_01')
				group by hero_code 
				
				union all
				
				select count(*) cnt, hero_name,hero_code from board where hero_today  >= NOW() -  INTERVAL 3 MONTH  and
				hero_table in ('group_02_02','group_03_03','group_04_09','group_04_07','group_04_06','group_04_23','group_04_05','group_04_10')
				group by hero_code 
				
			) a
			group by hero_code order by cnt desc
		) b";
		
$res = new_sql($sql1,$error,"on");
$rs = @mysql_fetch_assoc($res);
$cnt = round($rs['cn'] * 1);
echo $cnt;
*/
/*
$sql2 = "select count(*) cnt, hero_name, hero_code from board where hero_today  >= NOW() -  INTERVAL 3 MONTH  
and hero_table in ('group_02_02','group_03_03','group_04_09','group_04_07','group_04_06','group_04_23','group_04_05','group_04_10')
group by hero_code order by cnt desc limit 0, {$cnt}";
*/
/*
$sql2 = "
			select sum(cnt) cnt, a.hero_name, a.hero_code from(
				
				select count(*) cnt, hero_name,hero_code from review where hero_today  >= NOW() -  INTERVAL 3 MONTH  and
				hero_table in ('group_02_03','group_04_03','group_02_02','group_03_03','group_03_05','group_04_24','group_01_01')
				group by hero_code 
				
				union all
				
				select count(*) cnt, hero_name,hero_code from board where hero_today  >= NOW() -  INTERVAL 3 MONTH  and
				hero_table in ('group_02_02','group_03_03','group_04_09','group_04_07','group_04_06','group_04_23','group_04_05','group_04_10')
				group by hero_code 
				
			) a
			group by hero_code order by cnt desc limit 0, {$cnt}
";
$res2 = mysql_query($sql2) or die(mysql_error());  
*/

$sql1 = "SELECT COUNT(*) cnt, hero_code FROM board WHERE hero_today  >= NOW() -  INTERVAL 3 MONTH 
		AND hero_table IN ('group_02_02','group_03_03','group_04_09','group_04_07','group_04_06','group_04_23','group_04_05','group_04_10')
		GROUP BY hero_code";
//$sql1 = "SELECT hero_code FROM `member` WHERE hero_use=0";
$res = mysql_query($sql1) or die(mysql_error());  
$i = 0;
$chechk = "";
while($rs = mysql_fetch_array($res)){
	$chk = false;
	
	// �Խñ� ������ �̳� Ȯ��
	/*
	$core_member_check = "SELECT COUNT(*) AS cnt FROM board WHERE hero_today>='".$oneWeekAgo."' AND hero_code = '".$rs["hero_code"]."' and hero_table in ('group_02_02','group_03_03','group_04_09','group_04_07','group_04_06','group_04_23','group_04_05','group_04_10')";
	$core_member_check_res = new_sql($core_member_check,$error,"on");
	$core_member_check_rs  = @mysql_fetch_assoc($core_member_check_res);
	*/
	/*
	$core_member_check2 = "SELECT COUNT(*) AS cnt FROM review WHERE hero_today>='".$oneWeekAgo."' AND hero_code = '".$rs["hero_code"]."' and hero_table in ('group_02_03','group_04_03','group_02_02','group_03_03','group_03_05','group_04_24','group_01_01')";
	$core_member_check_res2 = new_sql($core_member_check2,$error,"on");
	$core_member_check_rs2  = @mysql_fetch_assoc($core_member_check_res2);
	*/
	
	// �ν�Ÿ�׷� URL, �湮�ڼ�, ������ ���
	$core_member_login_check = "SELECT hero_code, hero_blog_04, hero_memo, hero_memo_01, hero_core_member, hero_nick FROM member WHERE hero_code = '".$rs["hero_code"]."'";
	$core_member_login_check_res = new_sql($core_member_login_check,$error,"on");
	$core_member_login_check_rs  = @mysql_fetch_assoc($core_member_login_check_res);
	
	// �ν�Ÿ�׷� Ȯ��
	if($core_member_login_check_rs['hero_blog_04']) {
		// ����ı� ����� �ִ��� Ȯ��
		// 170510 ��������
		//$core_member_best_check = "SELECT COUNT(*) AS cnt FROM BOARD WHERE hero_code = '".$_SESSION['temp_code']."' AND hero_board_three = 1 ";
		//$core_member_best_check_res = new_sql($core_member_best_check,$error,"on");
		//$core_member_best_check_rs  = @mysql_fetch_assoc($core_member_best_check_res);

		// �ٽ��η����� ������Ʈ
		if($core_member_login_check_rs['hero_memo'] >= 1500 || $core_member_login_check_rs['hero_memo_01'] == "��")  {
			// �ٽ��η��� N �̿��� ȸ���� update
			$i++;
			$chechk .= $core_member_login_check_rs['hero_nick']."<br/>";
			if($core_member_login_check_rs['hero_core_member'] == "N") {
				//$update_core_member = "UPDATE member SET hero_core_member = 'Y' WHERE hero_code = '".$rs["hero_code"]."'";
				//$update_core_member_res = new_sql($update_core_member,$error);
			}
			$chk = true;
		}
	}
	
	// �ٽ��η� ���� ������				   
	if(!$chk) {
		// �ٽ��η� Y �̿��� ȸ���� ������Ʈ
		if($core_member_login_check_rs['hero_core_member'] == "Y") {
			//$update_core_member2 = "UPDATE member SET hero_core_member = 'N' WHERE hero_code = '".$rs["hero_code"]."'";
			//$update_core_member2_res = new_sql($update_core_member2,$error);
		}
	}
}
echo "�Ϸ�".$i."</br>";
echo $chechk;

?>