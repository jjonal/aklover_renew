<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2013�� 08�� 07��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
######################################################################################################################################################
?>

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
            <th class="first"><img src="../image/bbs/bbs_t_no.gif" alt="��¥" /></th>
            <th><img src="../image/bbs/bbs_t_subject.gif" alt="����" /></th>
            <th><img src="../image/bbs/bbs_t_writer.gif" alt="�ۼ���" /></th>
            <th><img src="../image/bbs/bbs_t_date.gif" alt="��¥" /></th>
            <th><img src="../image/bbs/bbs_t_view.gif" alt="��ȸ" /></th>
            <th class="last"><img src="../image/bbs/bbs_t_recom.gif" alt="��õ" /></th>
        </tr>
        <tr class="notice">
            <td><img src="../image/bbs/icon_notice.gif" alt="����" /></td>
            <td class="tl"><a href="#">�����Ƕ����� ����� ���Ҿ��.</a> <strong>[20]</strong></td>
            <td>ȫ�浿</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr class="notice">
            <td><img src="../image/bbs/icon_notice.gif" alt="����" /></td>
            <td class="tl"><a href="#">�����Ƕ����� ����� ���Ҿ��.</a> <strong>[20]</strong></td>
            <td>ȫ�浿</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr>
            <td>001</td>
            <td class="tl"><a href="#">�����Ƕ����� ����� ���Ҿ��.</a> <strong>[6]</strong></td>
            <td>ȫ�浿</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr>
            <td>001</td>
            <td class="tl"><a href="#">�����Ƕ����� ����� ���Ҿ��.</a> <strong>[6]</strong></td>
            <td>ȫ�浿</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr>
            <td>001</td>
            <td class="tl"><a href="#">�����Ƕ����� ����� ���Ҿ��.</a> <strong>[6]</strong></td>
            <td>ȫ�浿</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr>
            <td>001</td>
            <td class="tl"><a href="#">�����Ƕ����� ����� ���Ҿ��.</a> <strong>[6]</strong></td>
            <td>ȫ�浿</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr>
            <td>001</td>
            <td class="tl"><a href="#">�����Ƕ����� ����� ���Ҿ��.</a> <strong>[6]</strong></td>
            <td>ȫ�浿</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr>
            <td>001</td>
            <td class="tl"><a href="#">�����Ƕ����� ����� ���Ҿ��.</a> <strong>[6]</strong></td>
            <td>ȫ�浿</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
        <tr class="last">
            <td>001</td>
            <td class="tl"><a href="#">�����Ƕ����� ����� ���Ҿ��.</a> <strong>[6]</strong></td>
            <td>ȫ�浿</td>
            <td>13-08-16</td>
            <td>20</td>
            <td>16</td>
        </tr>
    </table>
    <div class="btngroup">
        <div class="btn_l">
            <a href=""><img src="../image/bbs/btn_write.gif" alt="�۾���" /></a>
        </div>
        <div class="paging">
            <a href="" class="img"><img src="../image/bbs/page_ppre.gif" alt="ù������" /></a>
            <a href="" class="img"><img src="../image/bbs/page_pre.gif" alt="����������" /></a>
            <a href="">1</a>
            <a href="">2</a>
            <a href="" class="current">3</a>
            <a href="">4</a>
            <a href="">5</a>
            <a href="" class="img"><img src="../image/bbs/page_next.gif" alt="����������" /></a>
            <a href="" class="img"><img src="../image/bbs/page_nnext.gif" alt="������������" /></a>
        </div>
        <div class="btn_r">
            <a href=""><img src="../image/bbs/btn_list.gif" alt="���" /></a>
            <!--<a href=""><img src="../image/bbs/btn_del.gif" alt="����" /></a>
            <a href=""><img src="../image/bbs/btn_edit.gif" alt="����" /></a>
            <a href=""><img src="../image/bbs/btn_cancle.gif" alt="���" /></a>
            <a href=""><img src="../image/bbs/btn_confrim.gif" alt="Ȯ��" /></a>-->
        </div>
    </div>
    <div class="searchbox">
        <div class="wrap_1">
            <form action="" method="" >
                <select name="" id="">
                    <option value="����">����</option>
                    <option value="����">����</option>
                    <option value="�ۼ���">�ۼ���</option>
                </select>
                <input type="text" class="kewyword">
                <input type="image" src="../image/bbs/btn_search.gif" alt="�˻�" class="bd0">
            </form>
        </div>
    </div>
</div>
</div>
