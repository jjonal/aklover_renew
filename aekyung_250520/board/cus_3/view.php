<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
//border:1px solid #000000;
######################################################################################################################################################
$_GET['board'];
$sql = 'select * from board where hero_table = \''.$_GET['board'].'\' and hero_idx=\''.$_GET['idx'].'\';';
sql($sql, 'on');
    $out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row
?>

        <div class="contents">
            <table border="0" cellpadding="0" cellspacing="0" class="bbs_view">
                <colgroup>
                    <col width="90px" />
                    <col width="400px" />
                    <col width="100px" />
                    <col width="*" />
                </colgroup>
                <tr class="bbshead">
                    <th><img src="../image/bbs/tit_subject.gif" alt="����" /></th>
                    <td>
                        <?=$out_row['hero_title'];?>
                    </td>
                    <th><img src="../image/bbs/tit_view.gif" alt="��ȸ��" /></th>
                    <td>
                        <?=$out_row['hero_hit'];?>
                    </td>
                </tr>
                <tr>
                    <th><img src="../image/bbs/tit_writer.gif" alt="�ۼ���" /></th>
                    <td><?=$out_row['hero_nick'];?></td>
                    <th><img src="../image/bbs/tit_date.gif" alt="��¥" /></th>
                    <td><?=$out_row['hero_today'];?></td>
                </tr>
                <tr>
                    <td colspan="4" valign="top" class="h180"><?=$out_row['hero_command'];?></td>
                </tr>
                <tr>
                    <th><img src="../image/bbs/tit_prev.gif" alt="������" /></th>
                    <td colspan="3"><a href="#">asdf</a></td>
                </tr>
                <tr class="last">
                    <th><img src="../image/bbs/tit_next.gif" alt="������" /></th>
                    <td colspan="3"><a href="#">asdf</a></td>
                </tr>
            </table>
<? include_once BOARD_INC_END.'button.php';?>
<? include_once BOARD_INC_END.'review.php';?>
        </div>
    </div>
