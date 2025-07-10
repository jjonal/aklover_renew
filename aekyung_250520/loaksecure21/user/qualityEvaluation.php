<!-- ȸ�� ���� ����Ƽ ��-->
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/user.css?v=250617" type="text/css" />

<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />

    <!-- ȸ�� ���� ����Ƽ �� �˻� ���� -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>���Ƽ Ÿ��</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">��ü
                        <input type="checkbox" name="quality_chk" value="0">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">�ֻ�
                        <input type="checkbox" name="quality_chk" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="checkbox" name="quality_chk" value="2">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="checkbox" name="quality_chk" value="3">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="checkbox" name="quality_chk" value="4">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                �˻�
            </th>
            <td>
                <div class="search_inner">
                    <div class="select-wrap">
                        <select name="select">
                            <option value="none" <?=!isset($_GET["select"]) || $_GET["select"] == "none" ? "selected" : ""?>>����</option>
                            <option value="hero_memo" <?=$_GET["select"] == "m.memo" ? "selected" : ""?>>����</option>
                            <option value="hero_nick" <?=$_GET["select"] == "m.hero_nick" ? "selected" : ""?>>�г���</option>
                            <option value="hero_id" <?=$_GET["select"] == "m.hero_id" ? "selected" : ""?>>���̵�</option>
                            <option value="hero_name" <?=$_GET["select"] == "m.hero_name" ? "selected" : ""?>>�̸�</option>
                        </select>
                    </div>
                    <input class="search_txt" type="text" name="kewyword" value="<?=$_GET["kewyword"]?>"/>
                </div>
            </td>
        </tr>
    </table>
    <div class="btnGroupSearch_box">
        <div class="btnGroupSearch">
            <a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
        </div>
    </div>
</form>

<div class="evalutation_wrap mgt27">
    <ul class="evalutation_info">
        <li class="point">�򰡴ܰ� : 4�ܰ�</li>
        <li>�� (0��~29��)</li>
        <li>�� (30��~69��)</li>
        <li>�� (70��~100��)</li>
        <li>�ֻ� (70�� �̻� + �ȷο� 10K�̻�)</li>
    </ul>
    <table cellspacing="0" class="evalutation_table mgt15">
        <colgroup>
            <col width="40">
            <col width="40">
            <col width="140">
            <col width="120">
            <col width="120">
            <col width="120">
            <col width="120">
            <col width="130">
            <col width="130">
            <col width="130">
        </colgroup>
        <thead>
        <tr>
            <th colspan="2">�� �׸�</th>
            <th>�̹��� (30%)</th>
            <th colspan="2">�ؽ�Ʈ (25%)</th>
            <th colspan="2">���̵� (25%)</th>
            <th>�ΰ�������Ʈ (20%)</th>
            <th>�ȷο� ��</th>
            <th>���� ����</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="2">����</td>
            <td class="left">
                [���־�]<br>
                1) ����, ��Ⱑ �����Ѱ�?<br>
                2) ����� ��濡�� ��ǰ�� ������<br>
                ���� �Կ� �Ǿ��°�?
            </td>
            <td class="left">
                [������]<br>
                ����, ����, ����, ��Ʈ ũ��� �÷��� �����Ѱ�?
            </td>
            <td class="left">
                [������]<br>
                ���̵�'����'�� �ƴ� ������ ���� ���䰡<br>
                �ݿ��Ǿ��°�?
            </td>
            <td class="left">
                [�̹���]<br>
                �Կ� �� ���̵带 ��� �ؼ��Ͽ��°�?<br>
                (��ǰ ��, B&A �� ���� ���� ��)
            </td>
            <td class="left">
                [�ؽ�Ʈ]<br>
                �ʼ� Ű����, Ű�޼���, ������<br>
                ��� �ݿ��Ǿ��°�?
            </td>
            <td class="left">
                ���ƿ�+��� �� ������ 10�� �̻��ΰ�?
            </td>
            <td class="left">
                ������ ��, �ȷο� ���� 10K �̻��ΰ�?
            </td>
            <td class="left">
                ���� ����� �������� �ִ°�?
            </td>
        </tr>
        <tr>
            <td rowspan="3">����</td>
            <td>��</td>
            <td>100</td>
            <td>50</td>
            <td>50</td>
            <td>50</td>
            <td>50</td>
            <td>100</td>
            <td rowspan="3" colspan="2">�� ���� 70�� �̻��̸鼭 �� �� O �� ���, �ֻ� ���</td>
        </tr>
        <tr>
            <td>��</td>
            <td>50</td>
            <td>25</td>
            <td>25</td>
            <td>25</td>
            <td>25</td>
            <td>50</td>
        </tr>
        <tr>
            <td>��</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
        </tr>
        </tbody>
    </table>
</div>

<div class="tableSection mgt30">
    <div class="table_top">
        <h2 class="table_tit">�˻� ���</h2>
        <p class="postNum"><span class="line"><?=number_format($search_total)?>��</span><span class="op_5">��ü <?=number_format($total_data)?>��</span></p>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container">
        <table class="searchResultBox">
            <colgroup>
                <col width="45px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="75px" />
                <col width="75px" />
                <col width="75px" />
                <col width="75px" />
                <col width="75px" />
                <col width="75px" />
                <col width="75px" />
            </colgroup>
            <thead>
            <th>
                <div class="">
                    NO
                </div>
            </th>
            <th>
                <div class="">
                    �̸�
                </div>
            </th>
            <th>
                <div class="">
                    ���̵�
                </div>
            </th>
            <th>
                <div class="">
                    �г���
                </div>
            </th>
            <th>
                <div class="">
                    �̹�������Ƽ
                </div>
            </th>
            <th>
                <div class="">
                    �ؽ�Ʈ����Ƽ
                </div>
            </th>
            <th>
                <div class="">
                    ���̵� �ؼ�
                </div>
            </th>
            <th>
                <div class="">
                    �ΰ�������Ʈ
                </div>
            </th>
            <th>
                <div class="">
                    �ȷο� ��
                </div>
            </th>
            <th>
                <div class="">
                    ���� ����
                </div>
            </th>
            <th>
                <div class="">
                    �հ� ����
                </div>
            </th>
            <th>
                <div class="">
                    �򰡴ܰ�
                </div>
            </th>
            <th>
                <div class="">
                    ����
                </div>
            </th>
            </thead>
            <tbody>
            <tr>
                <td>
                    <div class="table_result_no">
                        17
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        ������
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        aklover2024
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        aklover1234
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        -
                    </div>
                </td>
                <td class="title">
                    <div class="table_result_contents pop_btn_01">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <a href="" class="btnAdd5">����</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="table_result_no">
                        16
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        �����̳�
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        aklover2024
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        �г����ִ�8����
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        ��
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        ��
                    </div>
                </td>
                <td class="title">
                    <div class="table_result_contents pop_btn_01">
                        ��
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        ��
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        ��
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        ��
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        ��
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        ��
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <a href="" class="btnAdd5">����</a>
                    </div>
                </td>
            </tr>

            <!-- �����Ͱ� ���� �� �߰����ּ���. -->
            <!-- <tr>
                <td colspan="13" class="no_data">��ϵ� �����Ͱ� �����ϴ�.</td>
            </tr> -->
            </tbody>
        </table>
    </div>
</div>