<?
if(!defined('_HEROBOARD_'))exit;

$search = "";


// 250707 �����н� ���޳��� �˻� musign jnr
if( !empty($_GET["superpass_check"]) && is_array($_GET["superpass_check"]) ) {

    $superpass_conditions = array(); // array() ���

    foreach($_GET["superpass_check"] as $superpass_type) {
        switch($superpass_type) {
            case "Y": // ����
                $superpass_conditions[] = "(s.superpass_check = 'Y')";
                break;
            case "N": // ������
                $superpass_conditions[] = "(s.superpass_check = 'N')";
                break;
        }
    }

    if(!empty($superpass_conditions)) {
        $search .= " AND (" . implode(" OR ", $superpass_conditions) . ")";
    }
}


if($_GET["kewyword"] && $_GET["select"] != 'none') { //
    if($_GET["select"] == 'hero_nick') { // �г��� �˻�
        $_GET["select"] = "m.".$_GET["select"];
    } elseif ($_GET["select"] == 'hero_name') { // �̸�
        $_GET["select"] = "m.".$_GET["select"];
    } elseif ($_GET["select"] == 'hero_id') { // ���̵�
        $_GET["select"] = "m.".$_GET["select"];
    }
    $search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}

// ��ü������
$total_all_sql = " SELECT count(*) as cnt FROM superpass_history s INNER JOIN member m ON s.hero_code = m.hero_code WHERE 1=1";
$total_all_result = sql($total_all_sql);
$total_all_res = mysql_fetch_assoc($total_all_result);
$total_cnt = $total_all_res['cnt'];

//������ �ѹ���
$total_sql = " SELECT count(*) as cnt FROM superpass_history s INNER JOIN member m ON s.hero_code = m.hero_code WHERE 1=1 ".$search;
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

$sql  = " SELECT ";
$sql .= " m.hero_code,m.hero_nick, m.hero_id, m.hero_name, s.panelty_check, s.login_a_month_ago_check  ";
$sql .= " , s.blog_check, s.write_check, s.superpass_check, s.hero_today  ";
$sql .= " FROM superpass_history s INNER JOIN member m ON s.hero_code = m.hero_code ";
$sql .= " WHERE 1=1 ".$search;
$sql .= " ORDER BY s.hero_idx DESC LIMIT ".$start.",".$list_page;


$list_res = sql($sql);
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />


    <!-- 250625 �����н� ���޳��� �˻� ���� -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>����/������</th>
            <td>
                <div class="search_inner sup">
                    <?php
                    $superpass_check = (isset($_GET['superpass_check']) && is_array($_GET['superpass_check'])) ? $_GET['superpass_check'] : array();
                    ?>
                    <label class="akContainer">��ü
                        <input type="checkbox" <?php echo (!isset($_GET['superpass_check']) || empty($superpass_check)) ? 'checked' : ''; ?> name="superpass_check[]" value="">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">����
                        <input type="checkbox" <?php echo (is_array($superpass_check) && in_array('Y', $superpass_check)) ? 'checked' : ''; ?> name="superpass_check[]" value="Y">
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">������
                        <input type="checkbox" <?php echo (is_array($superpass_check) && in_array('N', $superpass_check)) ? 'checked' : ''; ?> name="superpass_check[]" value="N">
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

    <!-- 250625 �˻����� ���� �ּ�ó�� -->
    <!-- <table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>����/������</th>
		<td>
			<input type="radio" name="superpass_check" id="superpass_check" <?=!$_GET["superpass_check"] ? "checked":""; ?> value=""><label for="superpass_check">��ü</label>
			<input type="radio" name="superpass_check" id="superpass_check_y" <?=$_GET["superpass_check"]=="Y" ? "checked":""; ?> value="Y"><label for="superpass_check_y">����</label>
			<input type="radio" name="superpass_check" id="superpass_check_n" <?=$_GET["superpass_check"]=="N" ? "checked":""; ?> value="N"><label for="superpass_check_n">������</label>
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
		    	<option value="hero_name" <?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>�̸�</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div> -->
</form>

<div class="descWrap mgt30">
    <p class="dw_tit"><label>�����н� ����</label></p>
    <p class="dw_desc">
        1. �Ŵ� ó�� �α����� �� ���� ����</br>
        2. �α��� ������ 3���� ������ �г�Ƽ�� ����� ��</br>
        3. �α��� ������ �Ѵ� ���� �α����� ����� �־���� </br>
        4. ��α�+���� url ����</br>
        5. �Ѵ������� ����� �� �Ǵ� ��� ����</br></br>
        ex) 1�� ������ �������� ������ �����丮�� ����
    </p>
</div>

<div class="tableSection mgt30">
    <div class="table_top">
        <div>
            <h2 class="table_tit">�˻� ���</h2>
            <p class="postNum"><span class="line"><?=number_format($total_data)?>��</span><span class="op_5">��ü <?=number_format($total_cnt)?>��</span></p>
        </div>
        <a class="table_btn bottom btnAdd3 popup_btn" data-popup="01">�����н� ����</a>
    </div>
    <p class="table_desc"></p>
    <div class="searchResultBox_container">
        <table class="searchResultBox">
            <colgroup>
                <col width="30px" />
                <col width="45px" />
                <col width="70px" />
                <col width="70px" />
                <col width="70px" />
                <col width="60px" />
                <col width="60px" />
                <col width="60px" />
                <col width="75px" />
                <col width="75px" />
                <col width="75px" />
            </colgroup>
            <thead>
            <th>
                <input type="checkbox" id="checkAll" />
            </th>
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
                    �г�Ƽ
                </div>
            </th>
            <th>
                <div class="">
                    �Ѵ� �� �α���
                </div>
            </th>
            <th>
                <div class="">
                    ��α�/����
                </div>
            </th>
            <th>
                <div class="">
                    �ۼ���
                </div>
            </th>
            <th>
                <div class="">
                    ���޿��
                </div>
            </th>
            <th>
                <div class="">
                    �α��γ�¥
                </div>
            </th>
            </thead>
            <tbody>
            <?
            if($total_data > 0) {
                while($list = mysql_fetch_assoc($list_res)) {
                    $superpass_txt = "";
                    if($list["superpass_check"] == "Y") {
                        $superpass_txt = "����";
                    } else {
                        $superpass_txt = "������";
                    }

                    // �г�Ƽ
                    if($list['panelty_check'] == 'Y') $panelty_check = '��';
                    else $panelty_check = '��';

                    // �Ѵ� �� �α���
                    if($list['login_a_month_ago_check'] == 'Y') $monthAgo_check = '��';
                    else $monthAgo_check = '��';

                    // ��α�/����
                    if($list['blog_check'] == 'Y') $blog_check = '��';
                    else $blog_check = '��';

                    // �ۼ���
                    if($list['write_check'] == 'Y') $write_check = '��';
                    else $write_check = '��';

                    ?>
                    <tr>
                        <td>
                            <div class="table_result_no">
                            <input type="checkbox" name="hero_codes[]" value="<?=$list['hero_code']?>" class="rowCheck" />
                            </div>
                        </td>
                        <td>
                            <div class="table_result_no">
                                <?=$i?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$list["hero_name"]?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$list["hero_id"]?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$list["hero_nick"]?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$panelty_check?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$monthAgo_check?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$blog_check?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$write_check?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_nick">
                                <?=$superpass_txt?>
                            </div>
                        </td>
                        <td>
                            <div class="table_result_create">
                                <?=$list["hero_today"]?>
                            </div>
                        </td>
                    </tr>
                    <?
                    $i--;
                }
            } else {
                ?>
                <tr>
                    <td colspan="11" class="no_data">��ϵ� �����Ͱ� �����ϴ�.</td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
</div>


<!--�����̾� �������� ���� �� ���� �˾�-->
<div class="popup_url_box" id="pop_01">
    <div class="popup_url_cont height_type_A">
        <div class="popup_url_head">
            <svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"></path>
            </svg>
        </div>
        <div class="popup_url_body ori">
            <div class="tit">�����н� ����</div>
            <div class="popup_url_link_item_v3">
                <form name="writeForm" id="writeForm" method="POST">
                    <input type="hidden" name="hero_code" value="<?=$hero_code?>" />
                    <input type="hidden" name="mode" value="chkSuperpass" />
                    <table class="mgt10 mu_table mu_form">
                        <colgroup>
                            <col width="*">
                            <col width="150">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>Ÿ��</th>
                            <th>������</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" name="hero_kind" /></td>
                            <td>
                                <div class="calendar">
                                    <input type="text" name="hero_endday" class="dateMode w100p" style="vertical-align:bottom" />
                                </div>
                            </td>
                        <tr>
                        </tbody>
                    </table>
                    <div class="btnContainer mgt20 mgb20">
                        <a href="javascript:;" onClick="fnSuperpass();" class="btnAdd3">�����н� ����</a>
                    </div>
                </form>
            </div>
        </div>
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
<script>
    $(document).ready(function(){

        // üũ�ڽ� ��ü ����/����
        $("#checkAll").change(function() {
            $(".rowCheck").prop('checked', $(this).prop("checked"));
        });

        fnSearch = function() {
            $("#searchForm").attr("action","").submit();
        }

        fnSuperpass = function() {
            // üũ�� hero_code ������ �迭�� ����
            var selectedCodes = [];
            $(".rowCheck:checked").each(function() {
                selectedCodes.push($(this).val());
            });

            if(selectedCodes.length === 0) {
                alert("���õ� ȸ���� �����ϴ�.");
                return;
            }
            if(!$("input[name='hero_kind']").val()) {
                alert("������ Ÿ���� �Է��� �ּ���.");
                $("input[name='hero_kind']").focus();
                return;
            }

            if(!$("input[name='hero_endday']").val()) {
                alert("����Ⱓ�� �Է��� �ּ���.");
                $("input[name='hero_endday']").focus();
                return;
            }

            if(confirm("������ " + selectedCodes.length + "���� ȸ������ �����н��� �����Ͻðڽ��ϱ�?")) {
                var formData = $("#writeForm").serializeArray();

                // hero_code array �߰�
                formData.push({
                    name: 'hero_codes',
                    value: selectedCodes
                });
                var param = $.param(formData);
                $.ajax({
                    url:"/loaksecure21/user/popUserManagerSuperpassListAction.php"
                    ,type:"POST"
                    ,data:param
                    ,dataType:"json"
                    ,success:function(d){
                        console.log(d);
                        if(d.result==1) {
                            alert("�����н��� ���޵Ǿ����ϴ�.");
                            location.reload();
                        } else {
                            alert("���� �� �����߽��ϴ�.")
                        }
                    },error:function(e){
                        console.log(e);
                        alert("�����߽��ϴ�.");
                    }
                });
            }
        }
    })
</script>


