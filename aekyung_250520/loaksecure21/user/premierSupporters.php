<!-- �����̾� �������� -->

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
            <th>
                Ȱ�� �Ⱓ
            </th>
            <td>
                <div class="search_inner">
                    <div class="dateMode_box">
                        <input type="text" name="startDate" class="dateMode" value="<?=$_REQUEST['startDate']?>">
                    </div>
                    <div class="inner_between">~</div>
                    <div class="dateMode_box">
                        <input type="text" name="endDate" class="dateMode" value="<?=$_REQUEST['endDate']?>">
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>
                �˻���
            </th>
            <td>
                <div class="search_inner">
                    <input class="search_txt" type="text" name="kewyword" value="<?=$_GET["kewyword"]?>"/>
                </div>
            </td>
        </tr>
        <tr>
            <th>�������� ����</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">��ü
                        <input type="checkbox" name="supporters_chk" value="0">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">�����̾� ��Ƽ Ŭ��
                        <input type="checkbox" name="supporters_chk" value="1">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">�����̾� ������ Ŭ��
                        <input type="checkbox" name="supporters_chk" value="2">
                        <span class="checkmark"></span>
                    </label>
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


<div class="tableSection mgt30">
    <div class="table_top">
        <div>
            <h2 class="table_tit">�˻� ���</h2>
            <p class="postNum"><span class="line"><?=number_format($search_total)?>��</span><span class="op_5">��ü <?=number_format($total_data)?>��</span></p>
        </div>
        <a class="table_btn bottom btnAdd3 popup_btn" data-popup="01">�������� ����</a>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container">
        <table class="searchResultBox">
            <colgroup>
                <col width="45px" />
                <col width="70px" />
                <col width="120px" />
                <col width="15px" />
                <col width="75px" />
                <col width="75px" />
                <col width="70px" />
            </colgroup>
            <thead>
            <th>
                <div class="">
                    NO
                </div>
            </th>
            <th>
                <div class="">
                    ���� �Ⱓ
                </div>
            </th>
            <th>
                <div class="">
                    ���������
                </div>
            </th>
            <th>
                <div class="">
                    Ȱ�� �Ⱓ
                </div>
            </th>
            <th>
                <div class="">
                    ������
                </div>
            </th>
            <th>
                <div class="">
                    ��ܰ���
                </div>
            </th>
            <th>
                <div class="">
                    ��������
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
                        24�� ��ݱ�
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        �����̾� ��Ƽ ��������
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        2024-07-01 00:00 ~ 2024-07-31 23:59
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        2024-06-28
                    </div>
                </td>
                <td>
                    <div class="table_result_btn01">
                        <div class="table_result_btn_yn active">����</div>
                    </div>
                </td>
                <td class="title">
                    <div class="table_result_btn02 pop_btn_01">
                        <p class="icon_box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                <g opacity="0.4">
                                    <path d="M5.5 4.58203V17.932C5.5 18.1529 5.67909 18.332 5.9 18.332H16.1C16.3209 18.332 16.5 18.1529 16.5 17.932V4.58203" stroke="black" stroke-width="1.5" stroke-linejoin="round"/>
                                    <path d="M3.6665 4.58203H18.3332" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M8.25 4.58333V3.15C8.25 2.92909 8.42909 2.75 8.65 2.75H13.35C13.5709 2.75 13.75 2.92909 13.75 3.15V4.58333" stroke="black" stroke-width="1.5" stroke-linejoin="round"/>
                                    <path d="M9.1665 8.25V14.6667" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M12.8335 8.25V14.6667" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                </g>
                            </svg>
                        </p>
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
                        24�� ��ݱ�
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        �����̾� ��Ƽ ��������
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        2024-07-01 00:00 ~ 2024-07-31 23:59
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        2024-06-28
                    </div>
                </td>
                <td>
                    <div class="table_result_btn01">
                        <div class="table_result_btn_yn active">����</div>
                    </div>
                </td>
                <td class="title">
                    <div class="table_result_btn02 pop_btn_01">
                        <p class="icon_box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                <g opacity="0.4">
                                    <path d="M5.5 4.58203V17.932C5.5 18.1529 5.67909 18.332 5.9 18.332H16.1C16.3209 18.332 16.5 18.1529 16.5 17.932V4.58203" stroke="black" stroke-width="1.5" stroke-linejoin="round"/>
                                    <path d="M3.6665 4.58203H18.3332" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M8.25 4.58333V3.15C8.25 2.92909 8.42909 2.75 8.65 2.75H13.35C13.5709 2.75 13.75 2.92909 13.75 3.15V4.58333" stroke="black" stroke-width="1.5" stroke-linejoin="round"/>
                                    <path d="M9.1665 8.25V14.6667" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M12.8335 8.25V14.6667" stroke="black" stroke-width="1.5" stroke-linecap="round"/>
                                </g>
                            </svg>
                        </p>
                    </div>
                </td>
            </tr>

            <!-- �����Ͱ� ���� �� �߰����ּ���. -->
            <!-- <tr>
                <td colspan="7" class="no_data">��ϵ� �����Ͱ� �����ϴ�.</td>
            </tr> -->
            </tbody>
        </table>
    </div>
</div>


<!--�����̾� �������� ���� �� ���� �˾�-->
<div class="popup_url_box" id="pop_01">
    <div class="popup_url_cont height_typeB">
        <div class="popup_url_head">
            <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"></path>
            </svg>
        </div>
        <div class="popup_url_body">
            <div class="tit">�����̾� �������� ����</div>
            <div class="popup_url_link_v2">
                <div class="popup_url_link_item_v2">
                    <div class="popup_url_link_top">
                        <p class="popup_url_link_item_tit">���� �Ⱓ</p>
                    </div>
                    <div class="popup_url_link_cont mgt10">
                        <input type="text" value="" placeholder="24�� ��ݱ�" />
                    </div>
                </div>

                <div class="popup_url_link_item_v2">
                    <div class="popup_url_link_top">
                        <p class="popup_url_link_item_tit">���������</p>
                    </div>
                    <div class="popup_url_link_cont mgt10">
                        <input type="text" value="" placeholder="�����̾� ��Ƽ ��������" />
                    </div>
                </div>

                <div class="popup_url_link_item_v2 mu_form">
                    <div class="popup_url_link_top">
                        <p class="popup_url_link_item_tit">Ȱ�� �Ⱓ</p>
                    </div>
                    <div class="popup_url_link_cont mgt10 dateBox">
                        <div class="search_inner">
                            <div class="dateMode_box">
                                <input type="text" name="startDate" class="dateMode" value="<?=$_REQUEST['startDate']?>">
                            </div>
                            <div class="inner_between">~</div>
                            <div class="dateMode_box">
                                <input type="text" name="endDate" class="dateMode" value="<?=$_REQUEST['endDate']?>">
                            </div>
                        </div>
                    </div>
                    <p class="notice">* ������ �Ⱓ���� �����̾� ��������� Ȱ���մϴ�.</p>
                </div>
            </div>
            <div class="btnContainer mgt20 line">
                <a href="javascript:;" class="btnAdd3">�������� �����ϱ�</a>
            </div>
        </div>
    </div>
</div>