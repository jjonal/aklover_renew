<?
//######################## ���� ����, �� �α��� 1���� ���� ��� ����ڸ� �޸����� ó�� #######################
define('_HEROBOARD_', TRUE);

//�׽�Ʈ
//$test_mode = "ok";
//include_once '/home/www_php/aklover/freebest/head.php';
//include_once '/home/www_php/aklover/freebest/hero.php';
//include_once '/home/www_php/aklover/freebest/function.php';

echo "heoolo";
$test_mode = "no";
include_once '/home/users/aekyung/freebest/head.php';
include_once '/home/users/aekyung/freebest/hero.php';
include_once '/home/users/aekyung/freebest/function.php';
db("aekyung");

$num = 0;
$upCnt = 1;
$today = date("Ymd");

//���� ����, �� �α��� 1���� ���� ��� ����ڸ� �޸����� ó��,
$sql1 = " SELECT hero_code,hero_id, hero_today FROM `member` WHERE hero_id='heyou0307' ";


//2019�� 6�� 20�� 1�� ���� ������ ���� �ʿ�
//$sql1 = " SELECT hero_code,hero_id, hero_today FROM `member` WHERE dateDIFF(now(),hero_today) = 365  and hero_use=0 order by hero_idx asc ";

//$sql1 = "SELECT hero_code,hero_id FROM `member` WHERE hero_id in ('server')";
$res = mysql_query($sql1) or die(mysql_error());
$cnt = mysql_num_rows($res);

var_dump($res);
$num = 0;
while($rs = mysql_fetch_array($res)){


    //$sql_check = " SELECT count(*) FROM member_login_event WHERE DATE_ADD(hero_today, INTERVAL 1 MONTH) <= now() AND hero_code = '".$rs["hero_code"]."' AND member_hero_today = '".$rs["hero_today"]."' ";

    //���� ����ȭ 190620 ������
    $sql_check = " SELECT count(*) FROM member_login_event WHERE hero_code = '".$rs["hero_code"]."' AND member_hero_today = '".$rs["hero_today"]."' ";
    $row_check = mysql_fetch_array(mysql_query($sql_check));
    $send_check = $row_check[0];

    var_dump($rs);
    if(/*$send_check == 1 &&*/ $test_mode == "no") {  //2019�� 6�� 20�� 1�� ���� ������ ���� �ʿ�


        //1. ������ member_backup ���� ����
        $sql2 = "insert into member_backup select * from member where hero_code='".$rs["hero_code"]."'";
        var_dump($sql2);
        mysql_query($sql2) or die(mysql_error());



        //2. ������̺� Null ó��
        $sql3 = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS  WHERE table_name = 'member' and table_schema='aekyung' ";//�÷���ȸ
        $res3 = mysql_query($sql3) or die(mysql_error());
        $sql4 = "update member set ";
        while($rs3 = mysql_fetch_array($res3)){//hero_code, hero_nick, hero_use, hero_out, hero_out_date
            if($rs3["COLUMN_NAME"] == "hero_code" || $rs3["COLUMN_NAME"] == "hero_idx" || $rs3["COLUMN_NAME"] == "hero_id" || $rs3["COLUMN_NAME"] == "hero_nick"){
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
        $sql_backup = "insert into member_backup_history (hero_code,hero_type,hero_today) values ('".$rs["hero_code"]."','out',now())";
        $res_backup = mysql_query($sql_backup) or die(mysql_error());

        $num++;

    } //2019�� 6�� 20�� 1�� ���� ������ ���� �ʿ�


}//end while

//��ġ�α�
//$sql_log = "insert into batch_log (type, count, today) values('update',".$num.",now())";
//$res_log = mysql_query($sql_log) or die(mysql_error());
?>