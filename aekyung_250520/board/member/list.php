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
$sql = 'select * from board where hero_table=\''.$_GET['board'].'\''.$search.' order by hero_notice desc, hero_idx desc;';
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
//$sql = 'select * from board where hero_table=\'hero\' and hero_order !=\'0\' and hero_notice_use = \'0\' order by hero_order asc limit 0,5;';
$sql = 'select * from board where hero_table=\'hero\' and hero_order !=\'0\' and hero_notice_use = \'1\' order by hero_order asc;';
sql($sql);//echo $cc = mysql_num_rows($out_sql);//    $out_row = @mysql_fetch_row($out_sql);//mysql_fetch_assoc//mysql_fetch_array//
while($hero_list                             = @mysql_fetch_assoc($out_sql)){
?>
                <tr class="notice">
                    <td><img src="../image/bbs/icon_notice.gif" alt="공지" /></td>
                    <td class="tl"><img src="<?=$hero_list['hero_img_path'].$hero_list['hero_img_new'];?>" width="53" height="36">
                    <a href="<?=MAIN_HOME;?>?board=<?=$_GET['board']?>&page=<?=$page?>&view=view&idx=<?=$hero_list['hero_idx'];?>"><?=cut($hero_list['hero_title'], $cut_title_name);?></a> <strong></strong>
                    </td>
                    <td><?if(!strcmp($hero_list['hero_notice'], '1')){?><strong><?=cut($hero_list['hero_nick'], $cut_count_name);?></strong><?}else{echo cut($hero_list['hero_nick'], $cut_count_name);}?></td>
                    <td><?=date( "y-m-d", strtotime($hero_list['hero_today']));?></td>
                    <td><?=$hero_list['hero_hit'];?></td>
                </tr>
<?
}
$sql = 'select * from board where hero_table=\''.$_GET['board'].'\''.$search.' order by hero_notice desc, hero_idx desc limit '.$start.','.$list_page.';';
sql($sql);//echo $cc = mysql_num_rows($out_sql);//    $out_row = @mysql_fetch_row($out_sql);//mysql_fetch_assoc//mysql_fetch_array//
$i=0;
while($list                             = @mysql_fetch_assoc($out_sql)){
$num=$total_data - $start-$i;
$i++;
?>
                <tr<?if(!strcmp($list['hero_notice'], '1')){?> class="notice"<?}?>>
                    <td><?if(!strcmp($list['hero_notice'], '1')){?><img src="../image/bbs/icon_notice.gif" alt="공지" /><?}else{echo $num;}?></td>
                    <td class="tl">
                    <?if( (!strcmp($list_top['hero_type'], 'type_02')) and (!strcmp($list['hero_notice'], '0')) and (strcmp($list['hero_img_new'], '')) ){?><img src="<?=$list['hero_img_path'].$list['hero_img_new'];?>" width="53" height="36"><?}?>
                    <a href="<?=PATH_HOME;?>?board=<?=$_GET['board']?>&page=<?=$page?>&view=view&idx=<?=$list['hero_idx'];?>"><?=cut($list['hero_title'], $cut_title_name);?></a> <strong></strong>
                    </td>
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
