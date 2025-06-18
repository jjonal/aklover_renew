<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
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
//$power_count = @mysql_num_rows($out_power_sql);
$i='0';
while($power_list                             = @mysql_fetch_assoc($out_power_sql)){
    if(!strcmp($i,'0')){
        $comma = '';
    }else{
        $comma = ' or';
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
        echo '승인';
//echo     $power_list['hero_board'].'-';
        $power_search .= $comma.' hero_table=\''.$power_list['hero_board'].'\' ';
    $i++;
    }
    echo '<br>';
}
/*
select hero_table,hero_title from board
UNION ALL
select hero_table,hero_title from mission

*/
$power_search = '('.$power_search.')';
######################################################################################################################################################
$sql = 'select * from board where '.$power_search.$search.' and hero_use=\'1\' order by hero_notice desc, hero_idx desc;';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=10;
$page_per_list=5;
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
                    <col width="60px" />
                    <col width="60px" />
                </colgroup>
                <tr class="bbshead">
                    <th class="first"><img src="../image/bbs/bbs_t_no.gif" alt="날짜" /></th>
                    <th><img src="../image/bbs/bbs_t_subject.gif" alt="제목" /></th>
                    <th><img src="../image/bbs/bbs_t_writer.gif" alt="작성자" /></th>
                    <th><img src="../image/bbs/bbs_t_date.gif" alt="날짜" /></th>
                    <th><img src="../image/bbs/bbs_t_view.gif" alt="조회" /></th>
                    <th class="last"><img src="../image/bbs/bbs_t_recom.gif" alt="추천" /></th>
                </tr>
<?
echo $sql = 'select * from board where '.$power_search.$search.' and hero_use=\'1\' order by hero_table asc, hero_today desc limit '.$start.','.$list_page.';';
sql($sql);
$i=0;
while($list                             = @mysql_fetch_assoc($out_sql)){
$num=$total_data - $start-$i;
$i++;
    $info_sql = 'select * from hero_group where hero_board=\''.$list['hero_table'].'\';';
    $out_info_sql = mysql_query($info_sql);
    $info_list                             = @mysql_fetch_assoc($out_info_sql);
    
?>
                <tr onclick="location.href='<?=PATH_HOME;?>?board=<?=$list['hero_table']?>&page=<?=$page?>&view=view&idx=<?=$list['hero_idx'];?>'" style="cursor:pointer;">
                    <td><?=$num;?></td>
                    <td class="tl">
                    <font color="orange">[<?=$info_list['hero_title']?>]</font>
                    <?=cut($list['hero_title'], $cut_title_name);?> <strong>[<?=$list['hero_review_count'];?>]</strong>
                    </td>
                    <td><?if(!strcmp($list['hero_notice'], '1')){?><strong><?=cut($list['hero_name'], $cut_count_name);?></strong><?}else{echo cut($list['hero_name'], $cut_count_name);}?></td>
                    <td><?=date( "y-m-d", strtotime($list['hero_today']));?></td>
                    <td><?=$list['hero_hit'];?></td>
                    <td><?=$list['hero_rec'];?></td>
                </tr>
<?}?>
            </table>
<? include_once BOARD_INC_END.'button.php';?>
<? include_once BOARD_INC_END.'search.php';?>
        </div>
    </div>
