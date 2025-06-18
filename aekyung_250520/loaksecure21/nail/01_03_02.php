<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
if(strcmp($_REQUEST['kewyword'], '')){
    $search = ' '.$_REQUEST['select'].' like \'%'.$_REQUEST['kewyword'].'%\' and ';
    $search_next = '&select='.$_REQUEST['select'].'&kewyword='.$_REQUEST['kewyword'];
}
######################################################################################################################################################
$sql = '
    select * from board where
'.$search.'  hero_01=\''.$_GET['hero_idx'].'\'';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=10;
$page_per_list=5;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'].'&view='.$_GET['view'].'&hero_idx='.$_GET['hero_idx'].'&table_type='.$_GET['table_type'].'&table_name='.$_GET['table_name'];
######################################################################################################################################################
$level_old_sql = $sql.' order by hero_table,hero_today desc limit '.$start.','.$list_page.';';
$out_level_old_sql = mysql_query($level_old_sql);
$level_old_list                             = @mysql_fetch_assoc($out_level_old_sql);

$level_sql = 'select * from hero_group where hero_board=\''.$level_old_list['hero_table'].'\';';//desc<=
$out_level_sql = mysql_query($level_sql);
$level_list                             = @mysql_fetch_assoc($out_level_sql);

$mission_sql = 'select * from mission where hero_table=\''.$level_old_list['hero_table'].'\' and hero_idx=\''.$_GET['hero_idx'].'\';';//desc<=
$out_mission_sql = mysql_query($mission_sql);
$mission_list                             = @mysql_fetch_assoc($out_mission_sql);

?>
                        <center>
                            <a href="<?=PATH_HOME.'?'.get("view||table_type||table_name","view=01_03_01")?>" class="btn_blue2">이전목록</a><br><br>
                            <font color="red"><b>[ 리뷰어 신청자 ]</b></font><br><br>
                        </center>
<style>
/*
.t_list{white-space:nowrap;}
.t_list td,tr,th{white-space:nowrap;}
*/
</style>
                            <table class="t_list" style="table-layout:fixed">
                                <thead>
                                    <tr>
                                        <th width="100px"><?=$_REQUEST['table_name']?></th>
                                    </tr>
                                </thead>
                                <tbody>
<?
                        $sql = $sql.' order by hero_table,hero_today desc limit '.$start.','.$list_page.';';
                        sql($sql);
                        while($list                             = @mysql_fetch_assoc($out_sql)){

                        $mission_review_sql = 'select * from mission_review where hero_code=\''.$list['hero_code'].'\';';//desc<=
                        $out_mission_review_sql = mysql_query($mission_review_sql);
                        $mission_review_list                             = @mysql_fetch_assoc($out_mission_review_sql);

                        $member_sql = 'select * from member where hero_code=\''.$list['hero_code'].'\';';//desc<=
                        $out_member_sql = mysql_query($member_sql);
                        $member_list                             = @mysql_fetch_assoc($out_member_sql);

                        if(!strcmp($_REQUEST['table_type'], 'hero_address')){
                            $view_list_end = nl2br($mission_review_list['hero_address_01'])." ".nl2br($mission_review_list['hero_address_02'])." ".nl2br($mission_review_list['hero_address_03']);
                        }else if(!strcmp($_REQUEST['table_type'], 'hero_hp')){
                            $view_list_end = nl2br($mission_review_list['hero_hp_01'])."-".nl2br($mission_review_list['hero_hp_02'])."-".nl2br($mission_review_list['hero_hp_03']);
                        }else if( (!strcmp($_REQUEST['table_type'], 'hero_new_name')) or (!strcmp($_REQUEST['table_type'], 'hero_03')) or (!strcmp($_REQUEST['table_type'], 'hero_01')) or (!strcmp($_REQUEST['table_type'], 'hero_02')) ){
                            $search_table_type = $_REQUEST['table_type'];
                            $view_list_end = nl2br($mission_review_list[$search_table_type]);
                        }else{
                            $search_table_type = $_REQUEST['table_type'];
                            $view_list_end = nl2br($member_list[$search_table_type]);
                        }

                        ?>
                                <tr onmouseover="this.style.background='#B9DEFF'" onmouseout="this.style.background='white'">
                                    <td><?=$view_list_end;?></td>
                                </tr>
                        <?
                        }
                        ?>
                            </tbody>
                        </table>

                        <div style="width:100%; text-align:center; margin-top:20px;">
<? include_once PATH_INC_END.'page.php';?>
                        </div>
<? //include_once BOARD_INC_END.'search.php';?>
