<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$cut_title_name = '26';
$_GET['board'];
$sql = 'select * from board where hero_table = \''.$_GET['board'].'\' and hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
    $out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row

$sql = 'select * from board where hero_notice=\'0\' and hero_table = \''.$_GET['board'].'\' and hero_idx > \''.$_GET['idx'].'\' order by hero_idx asc limit 0,1;';
sql($sql, 'on');
    $Prev = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
    $Prev['hero_idx'];

$sql = 'select * from board where hero_notice=\'0\' and hero_table = \''.$_GET['board'].'\' and hero_idx < \''.$_GET['idx'].'\' order by hero_idx desc limit 0,1;';
sql($sql, 'on');
    $Next = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
    $Next['hero_idx'];
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
?>

        <div class="contents">
            <table border="0" cellpadding="0" cellspacing="0" class="bbs_view">
                <colgroup>
                    <col width="90px" />
                    <col width="400px" />
                    <col width="100px" />
                    <col width="115px" />
                </colgroup>
                <tr class="bbshead">
                    <th><img src="../image/bbs/tit_subject.gif" alt="����" /></th>
                    <td>
                        <?=cut($out_row['hero_title'],$cut_title_name);?>
                    </td>
                    <th><img src="../image/bbs/tit_view.gif" alt="��ȸ��" /></th>
                    <td>
                        <?=$out_row['hero_hit'];?>
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/bbs/tit_writer.gif" alt="�ۼ���" /></th>
                    <td><?=$out_row['hero_name'];?></td>
                    <th><img src="../image/bbs/tit_date.gif" alt="��¥" /></th>
                    <td><?=date( "y-m-d", strtotime($out_row['hero_today']));?></td>
                </tr>
                <tr>
                    <td colspan="4" valign="top" width="705px" style="padding:10px;line-height:48px; word-break:break-all;"><?=htmlspecialchars_decode($out_row['hero_command']);?></td>
                </tr>
<?
if(strcmp($Prev['hero_idx'], '')){
?>
                <tr>
                    <th><img src="../image/bbs/tit_prev.gif" alt="������" /></th>
                    <td colspan="3"><a href="<?=PATH_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>&view=view&idx=<?=$Prev['hero_idx'];?>"><?=cut($Prev['hero_title'],$cut_title_name);?></a></td>
                </tr>
<?
}
if(strcmp($Next['hero_idx'], '')){
?>
                <tr class="last">
                    <th><img src="../image/bbs/tit_next.gif" alt="������" /></th>
                    <td colspan="3"><a href="<?=PATH_HOME;?>?board=<?=$_GET['board'];?>&page=<?=$_GET['page'];?>&view=view&idx=<?=$Next['hero_idx'];?>"><?=cut($Next['hero_title'],$cut_title_name);?></a></td>
                </tr>
<?
}
?>
            </table>
<? include_once BOARD_INC_END.'button.php';?>
<? include_once BOARD_INC_END.'review.php';?>
        </div>
    </div>
