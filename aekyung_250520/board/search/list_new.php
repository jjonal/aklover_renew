<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$cut_count_name = '6';
$cut_title_name = '23';
######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}
######################################################################################################################################################
$power_sql = 'select * from hero_group where hero_menu=\'0\' and hero_type!=\'html\' and hero_type!=\'guide_4\' and hero_use=\'1\';';
$out_power_sql = mysql_query($power_sql);
$power_count = @mysql_num_rows($out_power_sql);
$i='1';
while($power_list                             = @mysql_fetch_assoc($out_power_sql)){
    if(!strcmp($power_count,$i)){
        $comma = '';
    }else{
        $comma = ', ';
    }
    if(!strcmp($_SESSION['temp_level'], '')){
        $my_level = '0';
    }else{
        $my_level = $_SESSION['temp_level'];
    }
echo     $power_list['hero_title']. '========';
echo     $power_list['hero_search'].'========';

    if($my_level>=$power_list['hero_search']){
echo     '<font color=orange>'.$my_level.'</font>';
        echo '����';
//echo     $power_list['hero_board'].'-';
//        $power_search .= $comma.' hero_table=\''.$power_list['hero_board'].'\' ';
        $power_search .= '\''.$power_list['hero_board'].'\''.$comma;
    }
    $i++;
//hero_table=
    echo '<br>';
}
$new_power_search = substr(trim($power_search), '-1');
if(!strcmp($new_power_search, ',')){
    $orange = substr(trim($power_search), '0', '-1');
}else{
    $orange = $power_search;
}
echo $power_search = 'new_board.hero_table in('.$orange.')';
$power_search = 'hero_table in('.$power_search.')';
/*
select hero_table,hero_title from board
UNION ALL
select hero_table,hero_title from mission

*/
//$power_search = '('.$power_search.')';
######################################################################################################################################################
$sql = 'select * from board where '.$power_search.$search.' and hero_use=\'1\';';
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
    <div class="contents_area">
        <div class="page_title">
            <h2><img src="<?=str($right_list['hero_right']);?>" alt="<?=$right_list['hero_title'];?>" /></h2>
            <ul class="nav">
                <li><img src="../image/common/icon_nav_home.gif" alt="home" /></li>
                <li>&gt;</li>
                <li><?=$right_list['hero_top_title']?></li>
                <li>&gt;</li>
                <li class="current"><?=$right_list['hero_title']?></li>
            </ul>
        </div>
        <div class="contents">
            <table border="0" cellpadding="0" cellspacing="0" class="bbs_list">
                <colgroup>
                    <col width="90px" />
                    <col width="*" />
                    <col width="90px" />
                    <col width="70px" />
                </colgroup>
                <tr class="bbshead">
                    <th class="first"><img src="../image/bbs/bbs_t_no.gif" alt="��¥" /></th>
                    <th><img src="../image/bbs/bbs_t_subject.gif" alt="����" /></th>
                    <th><img src="../image/bbs/bbs_t_writer.gif" alt="�ۼ���" /></th>
                    <th class="last"><img src="../image/bbs/bbs_t_date.gif" alt="��¥" /></th>
                </tr>
<?
$sql = 'select * from board where '.$power_search.$search.' and hero_use=\'1\' order by hero_table asc, hero_today desc limit '.$start.','.$list_page.';';
sql($sql);
$i=0;
while($list                             = @mysql_fetch_assoc($out_sql)){
$num=$total_data - $start-$i;
$i++;
    $info_sql = 'select * from hero_group where hero_board=\''.$list['hero_table'].'\';';
    $out_info_sql = mysql_query($info_sql);
    $info_list                             = @mysql_fetch_assoc($out_info_sql);
    $link_sql ='select * from (select *, (@rownum:=@rownum+1) as rownum from board , (select @rownum:=0) tmp where board.hero_table=\''.$list['hero_table'].'\' and board.hero_use=\'1\' order by hero_today desc) A where hero_idx=\''.$list['hero_idx'].'\'';
    $out_link_sql = mysql_query($link_sql);
    $link_list                             = @mysql_fetch_assoc($out_link_sql);
    $new_page_total = $link_list['rownum'];
    $new_page = ceil($new_page_total/8);
?>
                <tr onclick="location.href='<?=PATH_HOME;?>?board=<?=$list['hero_table']?>&page=<?=$new_page?>&view=view&idx=<?=$list['hero_idx'];?>'" style="cursor:pointer;">
                    <td><?=$num;?></td>
                    <td class="tl">
                    <font color="orange">[<?=$info_list['hero_title']?>]</font>
                    <?=cut($list['hero_title'], $cut_title_name);?> <strong>[<?=$list['hero_review_count'];?>]</strong>
                    </td>
                    <td><?=$list['hero_idx']?><?=cut($list['hero_name'], $cut_count_name);?></td>
                    <td><?=date( "y-m-d", strtotime($list['hero_today']));?></td>
                </tr>
<?}?>
            </table>
<? include_once BOARD_INC_END.'button.php';?>
<? include_once BOARD_INC_END.'search.php';?>
        </div>
    </div>
