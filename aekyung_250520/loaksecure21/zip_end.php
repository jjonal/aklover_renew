<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈
include_once '../freebest/head.php';
######################################################################################################################################################
include_once FREEBEST_INC_END.'function.php';
######################################################################################################################################################
if(!strcmp($_POST['type'],'admin')){
    $sql = 'select hero_idx, hero_id, hero_name from member';
    sql($sql, 'end');
    $count = @mysql_num_rows($out_sql);
?>

                            <table width="100%" style="text-align:center">
                                <colgroup>
                                    <col width="20px">
                                    <col width="20px">
                                    <col width="150px">
                                    <col>
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th>idx</th>
                                    <th>idx</th>
                                    <th><?=iconv('EUC-KR', 'UTF-8', '아이디');?></th>
                                    <th><?=iconv('EUC-KR', 'UTF-8', '이름');?></th>
                                </tr>
                                <form name="frm" id="frm" method="post">
<?
$check_i = '1';
    while($list  = @mysql_fetch_assoc($out_sql)){ 
?>

                                <tr id="list" onClick="if(document.getElementById('chk<?=$check_i?>').checked == false){this.bgColor='#B9DEFF';}else{this.bgColor='';};change('chk<?=$check_i?>');">
                                    <td>
                                        <?=$list['hero_idx'];?>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="hero_checkbox" id="<?='chk'.$check_i?>" name="<?='chk'.$check_i?>" value="<?=$list['hero_id'];?>">
                                    </td>
                                    <td>
                                        <?=$list['hero_id'];?>
                                    </td>
                                    <td>
                                        <?=iconv('EUC-KR', 'UTF-8', $list['hero_name']);?>
                                    </td>
                                </tr>

<?
$check_i++;
    }
}
?>
                                </form>
                            </tbody>
                        </table>