<?
if(!defined('_HEROBOARD_'))exit;

$search = "";


// 250708 �˻� musign jnr
if( !empty($_GET["hero_board"]) ) {
    $search .= " AND hero_board like '%".$_GET["hero_board"]."%' ";
}


//if($_GET["kewyword"]) { // �˻��� �� ��������� ����?...
//    $search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
//}

// Ȱ���Ⱓ
if($_GET["startDt"] && $_GET["endDt"]) {
    // ������ ��ȿ�� �˻� y-m-d �������� �Ѿ�� �� y-m-d H:i:s �������� ����
    if (!empty($_GET["startDt"]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET["startDt"])) {
        $_GET["startDt"] = $_GET["startDt"]." 00:00:00";
    }
    if (!empty($_GET["endDt"]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET["endDt"])) {
        $_GET["endDt"] = $_GET["endDt"]." 23:59:59";
    }

    $startDt = $_GET["startDt"];
    $endDt = $_GET["endDt"];
    // Ȱ�� �������� �˻� �����Ϻ��� �۰ų� ����, Ȱ�� �������� �˻� �����Ϻ��� ũ�ų� ���� ��� ��ȸ
    $search .= " AND startDt <= '".$endDt."' AND endDt >= '".$startDt."'";
}

// ��ü������
$total_all_sql = " SELECT count(*) as cnt FROM supporters WHERE 1=1 ";
$total_all_result = sql($total_all_sql);
$total_all_res = mysql_fetch_assoc($total_all_result);
$total_cnt = $total_all_res['cnt'];

//������ �ѹ���
$total_sql = " SELECT count(*) as cnt FROM supporters WHERE 1=1 ".$search;
sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];

$i=$total_data;

$list_page=20;
$page_per_list=10;

if(!strcmp($_GET['page'], '') || !strcmp($_GET['page'], '1')){
    $page = '1';
}else{
    $page = $_GET['page'];
    $i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql  = " SELECT *";
$sql .= " FROM supporters where 1=1 ".$search;
$sql .= " ORDER BY idx DESC LIMIT ".$start.",".$list_page;

$list_res = sql($sql);
?>


<!-- �����̾� �������� -->
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />
    <input type="hidden" name="page" value="<?=$page?>" />
    <input type="hidden" name="sno" value="" />
    <input type="hidden" name="view" value="" />
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
                        <input type="text" name="startDt" class="dateMode" value="<?=$_REQUEST['startDt']?>">
                    </div>
                    <div class="inner_between">~</div>
                    <div class="dateMode_box">
                        <input type="text" name="endDt" class="dateMode" value="<?=$_REQUEST['endDt']?>">
                    </div>
                </div>
            </td>
        </tr>
<!--        <tr>-->
<!--            <th>-->
<!--                �˻���-->
<!--            </th>-->
<!--            <td>-->
<!--                <div class="search_inner">-->
<!--                    <input class="search_txt" type="text" name="kewyword" value="--><?php //=$_GET["kewyword"]?><!--"/>-->
<!--                </div>-->
<!--            </td>-->
<!--        </tr>-->
        <tr>
            <th>�������� ����</th>
            <td>
                <div class="search_inner sup">
                    <label class="akContainer">��ü
                        <input type="radio" name="hero_board" value="" <?=!$_GET["hero_board"] ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">�����̾� ��Ƽ Ŭ��
                        <input type="radio" name="hero_board" value="group_04_06" <?=$_GET["hero_board"] == "group_04_06" ? "checked" : ""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">�����̾� ������ Ŭ��
                        <input type="radio" name="hero_board" value="group_04_28" <?=$_GET["hero_board"] == "group_04_28" ? "checked" : ""?>>
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
            <p class="postNum"><span class="line"><?=number_format($total_data)?>��</span><span class="op_5">��ü <?=number_format($total_cnt)?>��</span></p>
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
                    �������� ������
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
            <?
            if($total_data > 0) {
            while($list = mysql_fetch_assoc($list_res)) {
            // �������� ��
            if($list["hero_board"] == 'group_04_06') {
                $list["hero_board"] = "�����̾� ��Ƽ Ŭ��";
            } else if($list["hero_board"] == 'group_04_28') {
                $list["hero_board"] = "�����̾� ������ Ŭ��";
            } else {
                $list["hero_board"] = "";
            }
            ?>
            <tr>
                <td>
                    <div class="table_result_no">
                        <?=$i?>
                    </div>
                </td>
                <td>
                    <div class="">
                        <?=$list["recruit"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        <?=$list["hero_board"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$list["startDt"]?> ~ <?=$list["endDt"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$list["regDt"]?>
                    </div>
                </td>
                <td>
                    <div class="table_result_btn01">
                        <div class="table_result_btn_yn active" onClick="fnView('<?=$list["idx"]?>')">����</div>
                    </div>
                </td>
                <td class="title">
                    <div class="table_result_btn02 pop_btn_01 delSupport" data-idx="<?=$list["idx"]?>">
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

                <?
                $i--;
            }
            } else {
                ?>
                <tr>
                    <td colspan="7" class="no_data">��ϵ� �����Ͱ� �����ϴ�.</td>
                </tr>
            <?}?>

            </tbody>
        </table>
    </div>
</div>

<!-- ���������̼� -->
<div class="pagingWrap">
    <?     // üũ�ڽ� �׸� array ó���Ͽ� ����
    $params = $_GET;
    // page �Ķ���� ���� (���������̼ǿ��� ���� ó��)
    unset($params['page']);

    $query_string = '';
    foreach($params as $key => $value) {
        if(is_array($value)) {
            foreach($value as $v) {
                $query_string .= '&' . $key . '[]=' . urlencode($v);
            }
        } else {
            $query_string .= '&' . $key . '=' . urlencode($value);
        }
    }
    $next_path = $query_string;

    include_once PATH_INC_END.'page.php';
    ?>
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
        <form name="writeForm" id="writeForm" method="POST">
        <input type="hidden" name="mode" value="insert" />
        <div class="popup_url_body">
            <div class="tit">�����̾� �������� ����</div>
            <div class="popup_url_link_v2">
                <div class="popup_url_link_item_v2">
                    <div class="popup_url_link_top">
                        <p class="popup_url_link_item_tit">���� �Ⱓ</p>
                    </div>
                    <div class="popup_url_link_cont mgt10">
                        <input type="text" value="" name="new_recruit" placeholder="24�� ��ݱ�" />
                    </div>
                </div>

                <div class="popup_url_link_item_v2">
                    <div class="popup_url_link_top">
                        <p class="popup_url_link_item_tit">���������</p>
                    </div>
                    <div class="popup_url_link_cont mgt10">
                        <div class="search_inner">
                            <div class="select-wrap">
                                <select name="new_hero_board">
                                    <option value="group_04_06">�����̾� ��Ƽ Ŭ��</option>
                                    <option value="group_04_28">�����̾� ������ Ŭ��</option>
                                </select>
                            </div>
                        </div>
<!--                        <input type="text" value="" name="hero_board" placeholder="�����̾� ��Ƽ ��������" />-->
                    </div>
                </div>
                <div class="popup_url_link_item_v2 mu_form">
                    <div class="popup_url_link_top">
                        <p class="popup_url_link_item_tit">Ȱ�� �Ⱓ</p>
                    </div>
                    <div class="popup_url_link_cont mgt10 dateBox">
                        <div class="search_inner">
                            <div class="dateMode_box">
                                <input type="text" name="new_startDt" class="dateMode" value="">
                            </div>
                            <div class="inner_between">~</div>
                            <div class="dateMode_box">
                                <input type="text" name="new_endDt" class="dateMode" value="">
                            </div>
                        </div>
                    </div>
                    <p class="notice">* ������ �Ⱓ���� �����̾� ��������� Ȱ���մϴ�.</p>
                </div>

            </div>
            <div class="btnContainer mgt20 line">
                <a href="javascript:addSupport();" class="btnAdd3">�������� �����ϱ�</a>
            </div>
        </div>
        </form>
    </div>
</div>

<script>
    // ajax ���� �Լ��� ���� �������� �̵�
    function submitSupportersAction(param) {
        $.ajax({
            url: "/loaksecure21/user/premierSupportersAct.php",
            type: "POST",
            data: param,
            dataType: "json",
            success: function(d) {
                console.log(d)
                if(d.result == 1) {
                    let message;
                    // mode �Ķ���Ͱ� ����
                    let mode = typeof param === 'string' ?
                        param.split('mode=')[1]?.split('&')[0] :
                        param.mode;

                    switch(mode) {
                        case "insert":
                            message = "������� �����Ǿ����ϴ�.";
                            break;
                        case "delete":
                            message = "������� �����Ǿ����ϴ�.";
                            break;
                        case "update":
                            message = "������� �����Ǿ����ϴ�.";
                            break;
                        default:
                            message = "ó���� �Ϸ�Ǿ����ϴ�.";
                    }
                    alert(message);
                    location.reload();
                }
                else {
                    alert("���� �� �����߽��ϴ�.");
                }
            },
            error: function(e) {
                console.log(e);
                alert("�����߽��ϴ�.");
            }
        });
    }

    $(document).ready(function(){
        fnSearch = function() {
            $("#searchForm").attr("action","").submit();
        }

        fnView = function(idx) {
            $("input[name='sno']").val(idx);
            $("input[name='view']").val("premierSupportersView");
            $("#searchForm").attr("action","<?=PATH_HOME?>").submit();
        }

        // �������� ����
        addSupport = function() {
            if(!$("input[name='new_recruit']").val()) {
                alert("���� �Ⱓ�� �Է��� �ּ���");
                $("input[name='new_recruit']").focus();
                return;
            }

            if(!$("input[name='new_startDt']").val()) {
                alert("Ȱ���Ⱓ�� �Է��� �ּ���.");
                $("input[name='new_startDt']").focus();
                return;
            }

            if(!$("input[name='new_endDt']").val()) {
                alert("Ȱ���Ⱓ�� �Է��� �ּ���.");
                $("input[name='new_endDt']").focus();
                return;
            }

            var formData = $("#writeForm").serializeArray();
            var param = $.param(formData);
            console.log(param);
            submitSupportersAction(param);
        }

        // �������� ����
        $(document).on('click', '.delSupport', function() {
            if(confirm("���� �����Ͻðڽ��ϱ�?")) {
                const idx = $(this).data('idx');
                var param = {
                    mode: "delete",
                    idx: idx
                };
                submitSupportersAction(param);
            }
        });
    });
</script>