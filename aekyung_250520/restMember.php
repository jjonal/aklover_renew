<?

//------------------------------------------------------------------//
// 2016.09.23
// �����۽�Ʈ�� ���Ʒ�(hide305@naver.com)
//
// �� ������ �޸������ȯ ó�� ��ġ������ ������ ���Դϴ�.
// ��ġ������ �۵������� �� ���Ƿ� �޸����ó���� �ϴ� �����Դϴ�.
// ��ġ���ϰ� �������� �ణ �����մϴ�.
//------------------------------------------------------------------//


//######################## ���� ����, �� �α��� 1���� ���� ��� ����ڸ� �޸����� ó�� #######################
define('_HEROBOARD_', TRUE);
include_once '/home/users/aekyung/freebest/head.php';
include_once '/home/users/aekyung/freebest/hero.php';
include_once '/home/users/aekyung/freebest/function.php';
db("aekyung");

$num = 0;
$upCnt = 1;
$today = date("Ymd"); 

//���� ����, �� �α��� 1���� ���� ��� ����ڸ� �޸����� ó��, 

$sql1 = "select a.hero_code, a.hero_id, a.hero_today from member_backup_history b right outer join member a on 
		 b.hero_code = a.hero_code where b.hero_code is null and dateDIFF(now(),a.hero_today)>365 ";

//���� ���� 2019-05-20
//$sql1 = " SELECT hero_code, hero_id, hero_today from member m where m.hero_use = 0 and m.hero_today < '2018-05-20' ";


//$sql1 = "SELECT hero_code,hero_id FROM `member` WHERE hero_id in ('server')";
$res = mysql_query($sql1) or die(mysql_error());  
while($rs = mysql_fetch_array($res)){

	//1. ������ member_backup ���� ����
	$sql2 = "insert into member_backup select * from member where hero_code='".$rs["hero_code"]."'";
	mysql_query($sql2) or die(mysql_error()); 
	
	//2. ������̺� Null ó��
	$sql3 = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS  WHERE table_name = 'member' and table_schema='aekyung' ";//�÷���ȸ
	$res3 = mysql_query($sql3) or die(mysql_error());  
	$sql4 = "update member set ";
	while($rs3 = mysql_fetch_array($res3)){//hero_code, hero_nick, hero_use, hero_out, hero_out_date
		if($rs3["COLUMN_NAME"] == "hero_code" || $rs3["COLUMN_NAME"] == "hero_info_ci" || $rs3["COLUMN_NAME"] == "hero_info_di" || $rs3["COLUMN_NAME"] == "hero_idx"){
		}elseif($rs3["COLUMN_NAME"] == "hero_use"){
			$sql4 .= $rs3["COLUMN_NAME"]."=2,";
		}elseif($rs3["COLUMN_NAME"] == "hero_out"){
			$sql4 .= $rs3["COLUMN_NAME"]."='�޸����',";
		}elseif($rs3["COLUMN_NAME"] == "hero_out_date"){
			$sql4 .= $rs3["COLUMN_NAME"]."='".$today."',";		
		}else{
			$sql4 .= $rs3["COLUMN_NAME"]."=Null,";
		}	
	}
	$sql4.="hero_idx=hero_idx where hero_code='".$rs["hero_code"]."'";//���� �����Ϳ��� null ó�� ��Ŵ
	mysql_query($sql4) or die(mysql_error()); 
	
	//3. ��������Ʈ ����
	
	//�� ����Ʈ ���
	$sql_point = "select sum(hero_point) as point from point where hero_code='".$rs["hero_code"]."' ";
	$res_point = mysql_query($sql_point) or die(mysql_error());
	$rs_point = mysql_fetch_array($res_point);
	$totalPoint = intval($rs_point["point"]);
	
	//��� ����Ʈ ���
	$sql_order = "select sum(hero_order_point) as point from order_main where hero_code='".$rs["hero_code"]."' and hero_process!='".$_PROCESS_CANCEL."' ";
	$res_order = mysql_query($sql_order) or die(mysql_error());
	$rs_order = mysql_fetch_array($res_order);
	$usePoint = intval($rs_order["point"]);
	
	//���� ����Ʈ ���
	$possiblePoint = $totalPoint - $usePoint;
	$usePoint_02 = $possiblePoint;/* possiblePoint($rs["hero_id"], $rs["hero_code"]); */
	
	if(intval($usePoint_02) > 0){
		$remove = "insert into order_main(hero_id,hero_code, hero_process, hero_order_point, hero_regdate) values('".$rs["hero_id"]."','".$rs["hero_code"]."', '".$_PROCESS_REMOVE."', ".$usePoint_02.", now())";
		mysql_query($remove) or die($upCnt." | ".$cnt."<br>".$remove.": ".mysql_error()); 
	}
	
	//4. ȸ�� �����丮 ���̺� ����
	 //$sql_backup = "insert into member_backup_history (hero_code,hero_type,hero_today) values ('".$rs["hero_code"]."','out',now())";
		$sql_backup = "insert into member_backup_history (hero_code,hero_type,hero_today)";
		//$sql_backup .= "SELECT '".$rs["hero_code"]."', 'out', DATE_ADD(date_format(hero_today,'%Y-%m-%d'), INTERVAL 1 YEAR) FROM member_backup  WHERE hero_code='".$rs["hero_code"]."'";
		$sql_backup .= "SELECT '".$rs["hero_code"]."', 'out', hero_today FROM member_backup  WHERE hero_code='".$rs["hero_code"]."'";
        $res_backup = mysql_query($sql_backup) or die(mysql_error());
}//end while
echo "sussess";
?>