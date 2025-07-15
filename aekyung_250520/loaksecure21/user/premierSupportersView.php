<!-- /loaksecure21/index.php?idx=147&board=user&page=1&view=premierSupportersView -->
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/user.css?v=250617" type="text/css" />

<?
if(!defined('_HEROBOARD_'))exit;

// �ش� �������� ���� ����
$supporters_sql  = " SELECT * FROM supporters WHERE idx = '".$_GET["sno"]."' ";
$supporters_res = sql($supporters_sql,"on");
$view = mysql_fetch_assoc($supporters_res);

$startDt = substr($view["startDt"], 0, 10);
$endDt = substr($view["endDt"], 0, 10);  // YYYY-MM-DD �κи� ����


// �������� �׷� ȸ�� ����Ʈ
$search = "";

// �׷�(��) �˻�
if( !empty($_GET["hero_supports_group"]) && is_array($_GET["hero_supports_group"]) ) {
    $group_conditions = array(); // array() ���

    foreach($_GET["hero_supports_group"] as $hero_supports_group) {
        switch($hero_supports_group) {
            case "b": // ��α�
                $group_conditions[] = "(sm.hero_supports_group not like '' and sm.hero_supports_group = 'b')";
                break;
            case "i": // �ν�Ÿ
                $group_conditions[] = "(sm.hero_supports_group not like '' and sm.hero_supports_group = 'i')";
                break;
            case "s": // ����
                $group_conditions[] = "(sm.hero_supports_group not like '' and sm.hero_supports_group = 's')";
                break;
        }
    }
    if(!empty($group_conditions)) {
        $search .= " AND (" . implode(" OR ", $group_conditions) . ")";
    }
}

// ��ü������
$total_all_sql = " SELECT count(sm.idx) as cnt FROM supporters_mem_info sm 
                  LEFT JOIN member m on sm.hero_code = m.hero_code 
                  LEFT JOIN quality_evaluation qe on sm.hero_code = qe.hero_code
                  WHERE supporters_idx = ".$_GET["sno"];
$total_all_result = sql($total_all_sql);
$total_all_res = mysql_fetch_assoc($total_all_result);
$total_cnt = $total_all_res['cnt'];

//������ �ѹ���
$total_sql = " SELECT count(sm.idx) as cnt FROM supporters_mem_info sm
               LEFT JOIN member m on sm.hero_code = m.hero_code 
               LEFT JOIN quality_evaluation qe on sm.hero_code = qe.hero_code
               WHERE sm.supporters_idx = ".$_GET["sno"]."".$search;
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


$sql  = " SELECT sm.*, m.hero_id, m.hero_name,m.hero_nick,m.hero_jumin,m.hero_sex,m.hero_oldday,qe.grade";
$sql .= " FROM supporters_mem_info sm
          LEFT JOIN member m ON sm.hero_code = m.hero_code
          LEFT JOIN quality_evaluation qe ON sm.hero_code = qe.hero_code";
$sql .= " WHERE sm.supporters_idx = ".$_GET["sno"]."".$search;
$sql .= " ORDER BY sm.idx DESC LIMIT ".$start.",".$list_page;

$list_res = sql($sql);

?>

<form name="infoForm" id="infoForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="sno" value="<?=$_GET["sno"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />
    <input type="hidden" name="view" value="<?=$_GET["view"]?>" />
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
                    <a class="btnAdd5 mgl20">�Ⱓ ����</a>
                </div>
            </td>
        </tr>
    </table>
</form>

<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="sno" value="<?=$_GET["sno"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />
    <input type="hidden" name="page" value="<?=$page?>" />
    <input type="hidden" name="view" value="<?=$_GET["view"]?>" />

    <input type="hidden" name="mode" value="" />

    <!-- �������� �׷�˻� ���� -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>
                �׷� ����
            </th>
            <td>
                <?php
                $hero_supports_group = (isset($_GET['hero_supports_group']) && is_array($_GET['hero_supports_group'])) ? $_GET['hero_supports_group'] : array();
                ?>
                <div class="search_inner">
                    <label class="akContainer">��α�
                        <input type="checkbox" name="hero_supports_group[]" value="b" <?php echo (is_array($hero_supports_group) && in_array('b', $hero_supports_group)) ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">�ν�Ÿ
                        <input type="checkbox" name="hero_supports_group[]" value="i" <?php echo (is_array($hero_supports_group) && in_array('i', $hero_supports_group)) ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">����
                        <input type="checkbox" name="hero_supports_group[]" value="s" <?php echo (is_array($hero_supports_group) && in_array('s', $hero_supports_group)) ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>
                    <a class="btnAdd5 mgl20" onClick="fnSearch()">�׷� �˻�</a>
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
                <span class="line"><?=number_format($total_data)?>��</span><span class="op_5">��ü <?=number_format($total_cnt)?>��</span>
            </div>
        </div>
        <div class="table_btn bottom">
            <a class="btnAdd3 popup_btn" data-popup="01">������ �߰��ϱ�</a>
            <a class="btnAdd3">ȸ�� ��� �ٿ�ε�</a>
            <a class="btnAdd3" onclick="fnDel();">���� ����</a>
            <a class="btnAdd3" onclick="fnMemo();">��� �ۼ� ����</a>
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
            <?
            if($total_data > 0) {
            while($list = mysql_fetch_assoc($list_res)) {
            $age = (date("Y")-substr($list["hero_jumin"],0,4))+1;
            $hero_sex_txt = "";
            if($list["hero_sex"] == 1) {
                $hero_sex_txt = "��";
            } else if(strlen($list["hero_sex"]) > 0 && $list["hero_sex"] == 0) {
                $hero_sex_txt = "��";
            }
            if($list["hero_supports_group"] == 'b') {
                $hero_supports_group = "��α�";
            } else if($list["hero_supports_group"] == 'i') {
                $hero_supports_group = "�ν�Ÿ�׷�";
            } else if($list["hero_supports_group"] == 's') {
                $hero_supports_group = "����";
            } else {
                $hero_supports_group = "";
            }
            ?>
            <tr>
                <td>
                    <div class="table_checkbox" style="position:relative">
                        <label class="akContainer">
                            <input type="checkbox" name="hero_code" value="<?=$list['hero_code']?>" class="rowCheck">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </td>
                <td>
                    <div class="table_result_no">
                        <?=$i?>
                    </div>
                </td>
                <td>
                    <div class="table_result_id">
                        <?=$list['hero_id']?>
                    </div>
                </td>
                <td>
                    <div class="">
                        <?=$list['hero_nick']?>
                    </div>
                </td>
                <td>
                    <div class="table_result_name">
                        <?=$list['hero_name']?>
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        <?=$age?>
                    </div>
                </td>
                <td>
                    <div class="table_result_nick">
                        <?=$hero_sex_txt?>
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        <?=$hero_supports_group?>
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        <?=$list['grade']?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$list['hero_oldday']?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <input type="text" name="memo" value="<?=$list['memo']?>"/>
                    </div>
                </td>
            </tr>

            <?
                $i--;
            }
            } else {?>
                <tr>
                    <td colspan="11">�˻��� �����Ͱ� �����ϴ�.</td>
                </tr>
            <? } ?>

            <!-- �����Ͱ� ���� �� �߰����ּ���. -->
            <!-- <tr>
                <td colspan="11" class="no_data">��ϵ� �����Ͱ� �����ϴ�.</td>
            </tr> -->
            </tbody>
        </table>
    </div>
</div>

<div class="pagingWrap">
    <?
    // üũ�ڽ� �׸� array ó���Ͽ� ����
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

<!--������ �߰� �˾� iframe ȣ��� ���� 25.07.14 musign jnr-->
<div class="popup_url_box popup_supporters_selected" id="pop_01">
    <div class="popup_url_cont height_typeA">
        <div class="popup_url_head">
            <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"></path>
            </svg>
        </div>
        <div class="popup_url_body mu_form" id="popupContent">
            <iframe src="/loaksecure21/user/popPremierSupportersMem.php?sno=<?=$_GET["sno"]?>&hero_board=<?=$view["hero_board"]?>" width="660" height="720" frameborder="0" class="iframe_popup"></iframe>
        </div>
    </div>
</div>

<script>
    // ���� ���� ����
    const subTittle = document.querySelector("#content .sub_tit");
    subTittle.innerText = "�����̾� �������� ��� ����";

    $(document).ready(function(){
        // �׷� �˻�
        fnSearch = function() {
            $("#searchForm").attr("action","").submit();
        }

        // ����ۼ� ����
        fnMemo = function() {
            // üũ�� hero_code ���� �׷��� �迭�� ����
            var selectedCodes = [];
            var selectedMemos = [];

            $(".rowCheck:checked").each(function() {
                var heroCode = $(this).val();
                // �ش� row�� ����Է� �� ã��
                var heroMemo = $(this).closest('tr').find('input[name="memo"]').val()
                selectedCodes.push(heroCode);
                selectedMemos.push(heroMemo);
            });

            if(selectedCodes.length === 0) {
                alert("���õ� ȸ���� �����ϴ�.");
                return;
            }

            if(confirm("�����ڿ��� �����ϰڽ��ϱ�?")) {
                var formData =[];

                // �迭 �����͵��� formData�� �߰�
                for(var i = 0; i < selectedCodes.length; i++) {
                    formData.push({
                        name: 'hero_codes[]',
                        value: selectedCodes[i]
                    });
                    formData.push({
                        name: 'memos[]',
                        value: selectedMemos[i]
                    });
                    formData.push({
                        name: 'supporters_idx',
                        value: '<?=$_GET["sno"]?>'
                    });
                    formData.push({
                        name: 'mode',
                        value: 'insert_memo'
                    });
                }

                var param = $.param(formData);

                $.ajax({
                    url:"/loaksecure21/user/premierSupportersAct.php"
                    ,type:"POST"
                    ,data:param
                    ,dataType:"json"
                    ,success:function(d){
                        console.log(d);
                        if(d.result == 1) {
                            alert("�����Ͽ����ϴ�.");
                            location.reload();
                        } else {
                            alert("���� �� �����߽��ϴ�: " + d.error);
                        }
                    },error:function(e){
                        console.log(e);
                        alert("�����߽��ϴ�.");
                    }
                })
            }

        }

        // ���û���
        fnDel = function() {
            // üũ�� hero_code ���� �׷��� �迭�� ����
            var selectedCodes = [];

            $(".rowCheck:checked").each(function() {
                var heroCode = $(this).val();
                selectedCodes.push(heroCode);
            });
            if(selectedCodes.length === 0) {
                alert("���õ� ȸ���� �����ϴ�.");
                return;
            }

            if(confirm("�����ڿ��� �����ϰڽ��ϱ�?")) {
                var formData =[];

                // �迭 �����͵��� formData�� �߰�
                for(var i = 0; i < selectedCodes.length; i++) {
                    formData.push({
                        name: 'hero_codes[]',
                        value: selectedCodes[i]
                    });
                    formData.push({
                        name: 'supporters_idx',
                        value: '<?=$_GET["sno"]?>'
                    });
                    formData.push({
                        name: 'mode',
                        value: 'delete_mem'
                    });
                }

                var param = $.param(formData);

                $.ajax({
                    url:"/loaksecure21/user/premierSupportersAct.php"
                    ,type:"POST"
                    ,data:param
                    ,dataType:"json"
                    ,success:function(d){
                        console.log(d);
                        if(d.result == 1) {
                            alert("�����Ͽ����ϴ�.");
                            location.reload();
                        } else {
                            alert("���� �� �����߽��ϴ�: " + d.error);
                        }
                    },error:function(e){
                        console.log(e);
                        alert("�����߽��ϴ�.");
                    }
                })
            }

        }

        // ȸ����� �ٿ�ε�
        fnExcel = function() {
            var form = document.getElementById('searchForm');
            form.action = '/loaksecure21/user/userManger_excel.php';
            form.submit();
            //$("#searchForm").attr("action","/loaksecure21/user/userManger_excel.php").submit();
        }
    })
</script>