<!-- /loaksecure21/index.php?idx=147&board=user&page=1&view=premierSupportersView -->
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/user.css?v=250617" type="text/css" />


<?
if(!defined('_HEROBOARD_'))exit;
// 25.06.24 �ټ����� ���� include �̱� ������ �ش� ���� �������� ���� ������ ����!

$sno = $_GET["sno"];

$supporters_sql  = " SELECT * FROM supporters WHERE idx = '".$sno."' ";
$supporters_res = sql($supporters_sql,"on");
$view = mysql_fetch_assoc($supporters_res);


$startDt = substr($view["startDt"], 0, 10);
$endDt = substr($view["endDt"], 0, 10);  // YYYY-MM-DD �κи� ����

?>

<!-- ���� Ÿ��Ʋ ���� ��ư �߰� Wrap -->
<div class="topButtonWrap">
    <a href="javascript:;" class="btnAdd3">����</a>
</div>

<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="sno" value="<?=$_GET["sno"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />

    <!-- ȸ�� ���� ����Ƽ �� �˻� ���� -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>
                ���� �Ⱓ
            </th>
            <td>
                <div class="search_inner">
                    <input class="search_txt" type="text" name="recruit" value="<?=$view["recruit"]?>"/>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                ���������
            </th>
            <td>
                <div class="search_inner">
                    <div class="search_inner">
                        <select class="search_txt" name="hero_board">
                            <option value="group_04_06" <?=$view["hero_board"] == "group_04_06" ? "selected" : ""?>>�����̾� ��Ƽ Ŭ��</option>
                            <option value="group_04_28" <?=$view["hero_board"] == "group_04_28" ? "selected" : ""?>>�����̾� ������ Ŭ��</option>
                        </select>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                Ȱ�� �Ⱓ
            </th>
            <td>
                <div class="search_inner">
                    <div class="dateMode_box">
                        <input type="text" name="startDate" class="dateMode" value="<?=$startDt?>">
                    </div>
                    <div class="inner_between">~</div>
                    <div class="dateMode_box">
                        <input type="text" name="endDate" class="dateMode" value="<?=$endDt?>">
                    </div>
                    <a class="btnAdd5 mgl20">����</a>
                </div>
            </td>
        </tr>
    </table>
</form>


<div class="tableSection mgt30">
    <div class="table_top">
        <div>
            <h2 class="table_tit">�˻� ���</h2>
            <div class="postNum">
                <span class="line"><?=number_format($search_total)?>��</span><span class="op_5">��ü <?=number_format($total_data)?>��</span>
                <div class="mu_form mgl10">
                    <div class="chkBox_wrap">
                        <p class="chkBox_tit mgr10">�׷� ����</p>
                        <label class="chkItem" for="chk1">��ü
                            <input type="checkbox" id="chk1" name="chk_group">
                            <span class="checkmark"></span>
                        </label>
                        <label class="chkItem" for="chk2">�����̾� ��Ƽ Ŭ��
                            <input type="checkbox" id="chk2" name="chk_group">
                            <span class="checkmark"></span>
                        </label>

                        <label class="chkItem" for="chk3">�����̾� ������ Ŭ��
                            <input type="checkbox" id="chk3" name="chk_group">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="table_btn bottom">
            <a class="btnAdd3 popup_btn" data-popup="01">������ �߰��ϱ�</a>
            <a class="btnAdd3">ȸ�� ��� �ٿ�ε�</a>
            <a class="btnAdd3">���� ����</a>
        </div>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container mu_form">
        <table class="searchResultBox">
            <colgroup>
                <col width="45px" />
                <col width="45px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="50px" />
                <col width="50px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="140px" />
            </colgroup>
            <thead>
            <th>
                <div class="">
                    <label class="akContainer">
                        <input type="checkbox" name="all">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </th>
            <th>
                <div class="">
                    NO
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
                    �̸�
                </div>
            </th>
            <th>
                <div class="">
                    ����
                </div>
            </th>
            <th>
                <div class="">
                    ����
                </div>
            </th>
            <th>
                <div class="">
                    �׷�
                </div>
            </th>
            <th>
                <div class="">
                    SNS ����Ƽ���
                </div>
            </th>
            <th>
                <div class="">
                    ������
                </div>
            </th>
            <th>
                <div class="">
                    ���
                </div>
            </th>
            </thead>
            <tbody>
            <tr>
                <td>
                    <div class="table_checkbox" style="position:relative">
                        <label class="akContainer">
                            <input type="checkbox" name="hero_idx" value="<?=$list['hero_idx']?>">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="table_result_no">
                        1
                    </div>
                </td>
                <td>
                    <div class="table_result_name">
                        aaaaaaaaaaaaaaaaaaaa
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        �г����ִ�8����
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        AK Lover
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        ��α���
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        -
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        2024-00-00
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <input type="text" />
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="table_checkbox" style="position:relative">
                        <label class="akContainer">
                            <input type="checkbox" name="hero_idx" value="<?=$list['hero_idx']?>">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="table_result_no">
                        2
                    </div>
                </td>
                <td>
                    <div class="table_result_name">
                        ���̵� 20�� ���� ��ϰ���
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        �г����ִ�8����
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        AK Lover
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        24
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        ��
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        �ν�Ÿ�׷���
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        ��
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        2024-00-00
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <input type="text"/>
                    </div>
                </td>
            </tr>

            <!-- �����Ͱ� ���� �� �߰����ּ���. -->
            <!-- <tr>
                <td colspan="11" class="no_data">��ϵ� �����Ͱ� �����ϴ�.</td>
            </tr> -->
            </tbody>
        </table>
    </div>
</div>


<!--�ı� URL �˾�-->
<div class="popup_url_box popup_supporters_selected" id="pop_01">
    <div class="popup_url_cont height_typeB">
        <div class="popup_url_head">
            <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"></path>
            </svg>
        </div>
        <div class="popup_url_body mu_form">
            <div class="tit">�����̾� �������� ���� �� ����</div>
            <div class="popup_content mgt30">
                <div class="cont_item">
                    <p>���� �Ⱓ</p>
                    <input type="text"/>
                </div>
                <div class="cont_item">
                    <p>���������</p>
                    <input type="text"/>
                </div>
                <div class="cont_item">
                    <p>�׷� ����</p>
                    <div class="select_wrap">
                        <select>
                            <option>��α���</option>
                            <option>�ν�Ÿ�׷���</option>
                            <option>������</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="btnContainer mgt150 line">
                <a href="javascript:;" class="btnAdd3">�������� �����ϱ�</a>
            </div>
        </div>
    </div>
</div>

<script>
    // ���� ���� ����
    const subTittle = document.querySelector("#content .sub_tit");
    subTittle.innerText = "�����̾� �������� ��� ����";

</script>