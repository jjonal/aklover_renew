<?php
session_start(); 
define('_HEROBOARD_', TRUE);//HEROBOARD����
include_once   '../../freebest/head.php';
include_once  '../../freebest/function.php';

header( "Content-type: application/vnd.ms-excel;charset=iso-8859-1" );
header( "Content-Disposition: attachment; filename=��ǰ��_�ֹ�����_".date("Ymd",time()).".xls" );
header("Content-charset=euc-kr");

if(!$_SESSION['temp_id']){echo '<script>location.href="'.PATH_END.'out.php"</script>';exit;}

if((int)$_SESSION['temp_level'] >= 9999){
	include_once   '../../freebest/hero.php';
?>
    <strong><?=date("Y-m-d")?></strong>
    <table width="100%" border="1" cellpadding="3" cellspacing="0">
        <?

        $search = "";
        $search_next = "";
        if (strcmp ( $_REQUEST ['kewyword'], '' )) {
            if ($_REQUEST ['select'] == 'hero_all') {
                $search .= ' and ( A.hero_nick like \'%' . $_REQUEST ['kewyword'] . '%\' or A.hero_name like \'%' . $_REQUEST ['kewyword'] . '%\' or B.hero_name like \'%' . $_REQUEST ['kewyword'] . '%\' )';
                $search_next .= '&select=' . $_REQUEST ['select'] . '&kewyword=' . $_REQUEST ['kewyword'];
            } else {
                $search .= ' and ' . $_REQUEST ['select'] . ' like \'%' . $_REQUEST ['kewyword'] . '%\'';
                $search_next .= '&select=' . $_REQUEST ['select'] . '&kewyword=' . $_REQUEST ['kewyword'];
            }
        }

        $startDate			= $_REQUEST["startDate"];
        $endDate			= $_REQUEST["endDate"];

        if (strcmp ( $startDate, '' )) {
            $search .= " and A.hero_regdate >='".$startDate." 00:00:00'";
            $search_next .= "&startDate=".$startDate;
        }

        if (strcmp ( $endDate, '' )) {
            $search .= " and A.hero_regdate <='".$endDate." 23:59:59'";
            $search_next .= "&endDate=".$endDate;
        }


        //$sql = "select * from member where hero_memo_01 like '%��%' and hero_use=0 order by hero_oldday desc";
        $sql = "select A.*, B.hero_name as goods_name, C.hero_hp,C.hero_address_01,C.hero_address_02,C.hero_address_03, B.hero_serial_number ";
        $sql .= "from order_main A inner join goods B on A.goods_idx=B.hero_idx inner join member C on C.hero_id=A.hero_id where A.hero_process!='M' ".$search." order by hero_id asc, hero_regdate desc;";
        echo $sql;
        sql($sql,'on');
        $numb=1;
        ?>
        <tr align="center">
            <td align="center" valign="middle"><strong>��ȣ</strong></td>
            <td valign="middle"><strong>��ǰ��</strong></td>
            <td valign="middle"><strong>��ǰ������ȣ</strong></td>
            <td valign="middle"><strong>���̵�</strong></td>
            <td valign="middle"><strong>�г���</strong></td>
            <td valign="middle"><strong>�̸�</strong></td>
            <td valign="middle"><strong>������</strong></td>
            <td valign="middle"><strong>�ֹ���ȣ</strong></td>
            <td valign="middle"><strong>����</strong></td>
            <td valign="middle"><strong>��ȭ��ȣ</strong></td>
            <td valign="middle"><strong>�����ȣ</strong></td>
            <td valign="middle"><strong>�ּ�</strong></td>
        </tr>
        <?
	    while($list = @mysql_fetch_array($out_sql)){
		
            if($list["hero_process"]=='O')	$status="����غ�";
            else if($list["hero_process"]=='D')	$status="�����";
            else if($list["hero_process"]=='E') $status="���ɿϷ�";
            else if($list["hero_process"]=='C') $status="�ֹ����";
            else if($list["hero_process"]=='R') $status="ȯ��";

        ?>
            <tr align="left">
                <td align="center" valign="middle"><?=$numb?></td>
                <td align="center" valign="middle" ><?=$list["goods_name"]?></td>
                <td align="center" valign="middle" ><?=$list["hero_serial_number"]?></td>
                <td align="center" valign="middle" ><?=$list["hero_id"]?></td>
                <td align="center" valign="middle" ><?=$list["hero_nick"]?></td>
                <td align="center" valign="middle" ><?=$list["hero_name"]?></td>
                <td align="center" valign="middle"><?=$list["hero_regdate"]?></td>
                <td align="center" valign="middle"><?=$list["hero_order_number"]?></td>
                <td align="center" valign="middle"><?=$status?></td>
                <td align="center" valign="middle"><?=$list["hero_hp"]?></td>
                <td align="center" valign="middle"><?=$list["hero_address_01"]?></td>
                <td align="center" valign="middle"><?=$list["hero_address_02"]." ".$list["hero_address_03"]?></td>
            </tr>
        <?php
            $numb++;
	    }//end while
        ?>
    </table>
    <?
}//end if
?>