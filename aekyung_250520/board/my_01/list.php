<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '34';
######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}
######################################################################################################################################################
$sql = 'select * from board where hero_code=\''.$_SESSION['temp_code'].'\''.$search.' order by hero_notice desc, hero_idx desc;';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=8;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
?>

        <div class="contents">
            <table border="0" cellpadding="0" cellspacing="0" class="bbs_list">
                <colgroup>
                    <col width="90px" />
                    <col width="*" />
                    <col width="90px" />
                    <col width="70px" />
                    <col width="60px" />
                </colgroup>
                <tr class="bbshead">
                    <th class="first"><img src="../image/bbs/bbs_t_no.gif" alt="날짜" /></th>
                    <th><img src="../image/bbs/bbs_t_subject.gif" alt="제목" /></th>
                    <th><img src="../image/bbs/bbs_t_writer.gif" alt="작성자" /></th>
                    <th><img src="../image/bbs/bbs_t_date.gif" alt="날짜" /></th>
                    <th class="last"><img src="../image/bbs/bbs_t_view.gif" alt="조회" /></th>
                </tr>
<?
$sql = 'select * from board where hero_code=\''.$_SESSION['temp_code'].'\''.$search.' order by hero_notice desc, hero_idx desc limit '.$start.','.$list_page.';';
sql($sql);
$i=0;
while($list                             = @mysql_fetch_assoc($out_sql)){
$num=$total_data - $start-$i;
$i++;

$title_sql = 'select hero_title from hero_group where hero_board=\''.$list['hero_table'].'\';';
$out_title_sql = mysql_query($title_sql);
$title_list                             = @mysql_fetch_assoc($out_title_sql);
?>
                <tr<?if(!strcmp($list['hero_notice'], '1')){?> class="notice"<?}?> onclick="location.href='<?=PATH_HOME;?>?board=<?=$list['hero_table']?>&page=<?=$page?>&view=view&idx=<?=$list['hero_idx'];?>'" style="cursor:pointer;">
                    <td><?if(!strcmp($list['hero_notice'], '1')){?><img src="../image/bbs/icon_notice.gif" alt="공지" /><?}else{echo $num;}?></td>
                    <td><?=$title_list['hero_title'];?></td>
                    <td><?if(!strcmp($list['hero_notice'], '1')){?><strong><?=cut($list['hero_nick'], $cut_count_name);?></strong><?}else{echo cut($list['hero_nick'], $cut_count_name);}?></td>
                    <td><?=date( "y-m-d", strtotime($list['hero_today']));?></td>
                    <td><?=$list['hero_hit'];?></td>
                </tr>
<?}?>
            </table>
<? include_once BOARD_INC_END.'button.php';?>
<? include_once BOARD_INC_END.'search.php';?>
        </div>
    </div>
