<?php
session_start();
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once   '../../freebest/head.php';
include_once  '../../freebest/function.php';

header( "Content-type: application/vnd.ms-excel;charset=iso-8859-1" );
header( "Content-Disposition: attachment; filename=회원별_주문정보_".date("Ymd",time()).".xls" );
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
        $sql  = "SELECT hero_id, hero_name, hero_nick,  hero_process, hero_hp, hero_address_01, hero_address_02, hero_address_03, group_concat(goods_name,' ',goods_eq,'개' order by goods_name) goods_name ";
        $sql .= "FROM ";
        $sql .= "(SELECT A.hero_id, A.hero_name, A.hero_nick, A.hero_process, C.hero_hp,C.hero_address_01,C.hero_address_02,C.hero_address_03, B.hero_name AS goods_name, count(B.hero_name) AS goods_eq ";
        $sql .= "FROM order_main A INNER JOIN goods B ON A.goods_idx=B.hero_idx INNER JOIN member C ON C.hero_id=A.hero_id ";
        $sql .= "WHERE A.hero_process = 'O'".$search." ";
        $sql .= "GROUP BY A.hero_id, A.hero_name, A.hero_nick, A.hero_process, B.hero_name, C.hero_hp,C.hero_address_01,C.hero_address_02,C.hero_address_03 ";
        $sql .= ") mu_buylist ";
        $sql .= "GROUP BY hero_id, hero_name, hero_nick, hero_process, hero_hp, hero_address_01, hero_address_02, hero_address_03 ";
        $sql .= "ORDER BY hero_id ASC";
//        echo $sql;

        sql($sql,'on');
        $numb=1;
        ?>
        <tr align="center">
            <td align="center" valign="middle"><strong>번호</strong></td>
            <td valign="middle"><strong>닉네임</strong></td>
            <td valign="middle"><strong>아이디</strong></td>
            <td valign="middle"><strong>이름</strong></td>
            <td valign="middle"><strong>전화번호</strong></td>
            <td valign="middle"><strong>우편번호</strong></td>
            <td valign="middle"><strong>주소</strong></td>
            <td valign="middle"><strong>제품정보</strong></td>
        </tr>
        <?
        while($list = @mysql_fetch_array($out_sql)){
        ?>
            <tr align="left">
                <td align="center" valign="middle"><?=$numb?></td>
                <td align="center" valign="middle" ><?=$list["hero_nick"]?></td>
                <td align="center" valign="middle" ><?=$list["hero_id"]?></td>
                <td align="center" valign="middle" ><?=$list["hero_name"]?></td>
                <td align="center" valign="middle"><?=$list["hero_hp"]?></td>
                <td align="center" valign="middle"><?=$list["hero_address_01"]?></td>
                <td align="center" valign="middle"><?=$list["hero_address_02"]." ".$list["hero_address_03"]?></td>
                <td align="center" valign="middle"><?=$list["goods_name"]?></td>
            </tr>
            <?php
            $numb++;
        }//end while
            ?>
    </table>
    <?
}//end if
?>