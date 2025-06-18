<?php
session_start(); 
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once   '../../freebest/head.php';
include_once  '../../freebest/function.php';

header( "Content-type: application/vnd.ms-excel;charset=iso-8859-1" );
header( "Content-Disposition: attachment; filename=제품별_주문정보_".date("Ymd",time()).".xls" );
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


        //$sql = "select * from member where hero_memo_01 like '%상%' and hero_use=0 order by hero_oldday desc";
        $sql = "select A.*, B.hero_name as goods_name, C.hero_hp,C.hero_address_01,C.hero_address_02,C.hero_address_03, B.hero_serial_number ";
        $sql .= "from order_main A inner join goods B on A.goods_idx=B.hero_idx inner join member C on C.hero_id=A.hero_id where A.hero_process!='M' ".$search." order by hero_id asc, hero_regdate desc;";
        echo $sql;
        sql($sql,'on');
        $numb=1;
        ?>
        <tr align="center">
            <td align="center" valign="middle"><strong>번호</strong></td>
            <td valign="middle"><strong>제품명</strong></td>
            <td valign="middle"><strong>제품고유번호</strong></td>
            <td valign="middle"><strong>아이디</strong></td>
            <td valign="middle"><strong>닉네임</strong></td>
            <td valign="middle"><strong>이름</strong></td>
            <td valign="middle"><strong>구매일</strong></td>
            <td valign="middle"><strong>주문번호</strong></td>
            <td valign="middle"><strong>상태</strong></td>
            <td valign="middle"><strong>전화번호</strong></td>
            <td valign="middle"><strong>우편번호</strong></td>
            <td valign="middle"><strong>주소</strong></td>
        </tr>
        <?
	    while($list = @mysql_fetch_array($out_sql)){
		
            if($list["hero_process"]=='O')	$status="배송준비";
            else if($list["hero_process"]=='D')	$status="배송중";
            else if($list["hero_process"]=='E') $status="수령완료";
            else if($list["hero_process"]=='C') $status="주문취소";
            else if($list["hero_process"]=='R') $status="환불";

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