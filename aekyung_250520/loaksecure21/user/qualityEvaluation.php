<!-- ȸ�� ���� ����Ƽ ��-->
<?  if(!defined('_HEROBOARD_'))exit;

$search = "";

// ����Ƽ �� �˻� ����
if( !empty($_GET["grade"]) && is_array($_GET["grade"]) ) {
    $grade_conditions = array(); // array() ���

    foreach($_GET["grade"] as $grade_type) {
        switch($grade_type) {
            case "4": // �ֻ�
                $grade_conditions[] = "(qe.grade not like '' and qe.grade = 4)"; // �ֻ�
                break;
            case "3": // ��
                $grade_conditions[] = "(qe.grade not like '' and qe.grade = 3)"; // �ֻ�
                break;
            case "2": // ��
                $grade_conditions[] = "(qe.grade not like '' and qe.grade = 2)"; // �ֻ�
                break;
            case "1": // ��
                $grade_conditions[] = "(qe.grade not like '' and qe.grade = 1)"; // �ֻ�
                break;
        }
    }
    if(!empty($grade_conditions)) {
        $search .= " AND (" . implode(" OR ", $grade_conditions) . ")";
    }
}

// �˻�� ���� ��
if($_GET["kewyword"] && $_GET["select"] != 'none') { //
    if($_GET["select"] == 'hero_nick') { // �г��� �˻�
        $_GET["select"] = 'm.'.$_GET["select"];
    } elseif ($_GET["select"] == 'hero_name') { // �̸�
        $_GET["select"] = 'm.'.$_GET["select"];
    } elseif ($_GET["select"] == 'hero_id') { // ���̵�
        $_GET["select"] = 'm.'.$_GET["select"];
    } elseif ($_GET["select"] == 'hero_hp') { // ��ȭ��ȣ
        $_GET["select"] = 'm.hero_hp';
        // �˻���� ������ ���� �� ������
        $phone = preg_replace("/[^0-9]/", "", $_GET["kewyword"]); // ���ڸ� ����
        $_GET["kewyword"] = substr($phone, 0, 3) . '-' . substr($phone, 3, 4) . '-' . substr($phone, 7);
    }
    $search .= " AND ".$_GET["select"]." like '%".$_GET["kewyword"]."%' ";
}

// �� ������ ��
//$total_sql = " SELECT count(*) cnt FROM member WHERE hero_use = 0 ".$search;
// ��ü ������ �� (�˻� ���� ����)
$total_all_sql = " SELECT count(DISTINCT m.hero_code) as cnt";
$total_all_sql .= " FROM member m ";
$total_all_sql .= " LEFT JOIN quality_evaluation qe ON m.hero_code = qe.hero_code ";
$total_all_sql .= " WHERE m.hero_use = 0";

$total_all_result = sql($total_all_sql);
$total_all_res = mysql_fetch_assoc($total_all_result);
$total_all = $total_all_res['cnt'];

// �˻� ��� ������ ��
$total_sql = " SELECT count(DISTINCT m.hero_code) as cnt";
$total_sql .= " FROM member m ";
$total_sql .= " LEFT JOIN quality_evaluation qe ON m.hero_code = qe.hero_code ";
$total_sql .= " WHERE m.hero_use = 0" . $search;

$total_result = sql($total_sql);
$out_res = mysql_fetch_assoc($total_result);
$total_data = $out_res['cnt'];
$i = $total_data;

$list_page=$_REQUEST['list_count']==""?20:$_REQUEST['list_count'];
$page_per_list=10;

if(!strcmp($_GET['page'], '')) {
    $page = '1';
} else {
    $page = $_GET['page'];
    $i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page");

//����Ʈ
$sql = " SELECT m.hero_code as member_code, m.hero_id, m.hero_nick, m.hero_name ";
$sql .= " , qe.* ";
$sql .= " FROM member m ";
$sql .= " LEFT JOIN quality_evaluation qe ON m.hero_code = qe.hero_code ";
$sql .= " WHERE m.hero_use = 0 " . $search;
$sql .= " GROUP BY m.hero_code ";
$sql .= " ORDER BY m.hero_idx DESC ";
$sql .= " LIMIT " . $start . "," . $list_page;

$list_res = sql($sql);
?>
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/user.css?v=250617" type="text/css" />

<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
    <input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
    <input type="hidden" name="board" value="<?=$_GET["board"]?>" />
    <input type="hidden" name="page" value="<?=$page?>" />
    <input type="hidden" name="member_code" value="" />
    <input type="hidden" name="view" value="" />

    <!-- ȸ�� ���� ����Ƽ �� �˻� ���� -->
    <table class="searchBox">
        <colgroup>
            <col width="171px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th>����Ƽ</th>
            <td>
                <?php
                $grade = (isset($_GET['grade']) && is_array($_GET['grade'])) ? $_GET['grade'] : array();
                ?>
                <div class="search_inner sup">
                    <label class="akContainer">��ü
                        <input type="checkbox" name="grade[]" value="" <?php echo (!isset($_GET['grade']) || empty($grade) || in_array('', $grade)) ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">�ֻ�
                        <input type="checkbox" name="grade[]" value="4" <?php echo (is_array($grade) && in_array('4', $grade)) ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="checkbox" name="grade[]" value="3" <?php echo (is_array($grade) && in_array('3', $grade)) ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="checkbox" name="grade[]" value="2" <?php echo (is_array($grade) && in_array('2', $grade)) ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">��
                        <input type="checkbox" name="grade[]" value="1" <?php echo (is_array($grade) && in_array('1', $grade)) ? 'checked' : ''; ?>>
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
<!--                            <option value="hero_memo" --><?php //=$_GET["select"] == "m.memo" ? "selected" : ""?><!-->����</option>-->
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
            <td colspan="2">50</td>
<!--            <td>50</td>-->
<!--            <td>50</td>-->
            <td colspan="2">50</td>
            <td>100</td>
            <td rowspan="3" colspan="2">�� ���� 70�� �̻��̸鼭 �� �� O �� ���, �ֻ� ���</td>
        </tr>
        <tr>
            <td>��</td>
            <td>50</td>
            <td colspan="2">25</td>
<!--            <td>25</td>-->
            <td colspan="2">25</td>
<!--            <td>25</td>-->
            <td>50</td>
        </tr>
        <tr>
            <td>��</td>
            <td>0</td>
            <td colspan="2">0</td>
<!--            <td>0</td>-->
            <td colspan="2">0</td>
<!--            <td>0</td>-->
            <td>0</td>
        </tr>
        </tbody>
    </table>
</div>

<div class="tableSection mgt30">
    <div class="table_top">
        <h2 class="table_tit">�˻� ���</h2>
        <p class="postNum"><span class="line"><?=number_format($total_data)?>��</span><span class="op_5">��ü <?=number_format($total_all)?>��</span></p>
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
                    SNS ����Ƽ
                </div>
            </th>
            <th>
                <div class="">
                    ����
                </div>
            </th>
            </thead>
            <tbody>
            <?
            if($total_data > 0) {
            while($list = mysql_fetch_assoc($list_res)) {
                //$list["image_quality"] �̹�������Ƽ
                if ($list["image_quality"] == 100) {
                    $list["image_quality"] = "��";
                } elseif ($list["image_quality"] == 50) {
                    $list["image_quality"] = "��";
                } else {
                    $list["image_quality"] = "��";
                }
                //$list["text_quality"] �ؽ�Ʈ����Ƽ
                if ($list["text_quality"] == 50) {
                    $list["text_quality"] = "��";
                } elseif ($list["text_quality"] == 25) {
                    $list["text_quality"] = "��";
                } else {
                    $list["text_quality"] = "��";
                }
                //$list["guide_compliance"] ���̵��ؼ�
                if ($list["guide_compliance"] == 50) {
                    $list["guide_compliance"] = "��";
                } elseif ($list["guide_compliance"] == 25) {
                    $list["guide_compliance"] = "��";
                } else {
                    $list["guide_compliance"] = "��";
                }
                //$list["engagement_score"] �ΰ�������Ʈ
                if ($list["engagement_score"] == 100) {
                    $list["engagement_score"] = "��";
                } elseif ($list["engagement_score"] == 50) {
                    $list["engagement_score"] = "��";
                } else {
                    $list["engagement_score"] = "��";
                }
                //$list["follower_score"] �ȷο�
                if ($list["follower_score"] == 3) {
                    $list["follower_score"] = "��";
                } elseif ($list["follower_score"] == 2) {
                    $list["follower_score"] = "��";
                } else {
                    $list["follower_score"] = "��";
                }

                //$list["top_exposure"] ��������
                if ($list["top_exposure"] == 3) {
                    $list["top_exposure"] = "��";
                } elseif ($list["follower_score"] == 2) {
                    $list["follower_score"] = "��";
                } else {
                    $list["top_exposure"] = "��";
                }
                //$list["grade"] ����Ƽ ���
                if ($list["grade"] == 4) {
                    $list["grade"] = "�ֻ�";
                } elseif ($list["grade"] == 3) {
                    $list["grade"] = "��";
                } elseif ($list["grade"] == 2) {
                    $list["grade"] = "��";
                } elseif ($list["grade"] == 1) {
                    $list["grade"] = "��";
                }else {
                    $list["grade"] = "��";
                }

            ?>
            <tr>
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
                        <?=$list["image_quality"] // �̹��� ����Ƽ?>
                    </div>
                </td>
                <td>
                    <div class="table_result_types">
                        <?=$list["text_quality"] // �ؽ�Ʈ ����Ƽ?>
                    </div>
                </td>
                <td class="title">
                    <div class="table_result_contents pop_btn_01">
                        <?=$list["guide_compliance"] // ���̵��ؼ�?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$list["engagement_score"] // �ΰ�������Ʈ?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$list["follower_score"] // �ȷο�?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$list["top_exposure"] // ��������?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=isset($list["total_score"]) ? $list["total_score"] : '0'  // �հ�����?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <?=$list["grade"] // ����Ƽ���?>
                    </div>
                </td>
                <td>
                    <div class="table_result_create">
                        <a href="<?=PATH_HOME.'?'.get('page');?>&view=qualityEvaluationView&hero_code=<?=$list["member_code"]?>" class="btnAdd5">����</a>
                    </div>
                </td>
            </tr>
                <?
                --$i;
            }
            } else {
            ?>
            <!-- �����Ͱ� ���� �� �߰����ּ���. -->
            <tr>
                <td colspan="13" class="no_data">��ϵ� �����Ͱ� �����ϴ�.</td>
            </tr>
                <?
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<div class="pagingWrap">
    <?php
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
        fnSearch = function() {
            $("#searchForm").attr("action","").submit();
        }
        //fnView = function(member_code) {
        //    $("input[name='member_code']").val(member_code);
        //    $("input[name='view']").val("qualityEvaluationView");
        //    $("#searchForm").attr("action","<?php //=PATH_HOME?>//").submit();
        //    console.log(member_code);
        //}
    })
</script>
