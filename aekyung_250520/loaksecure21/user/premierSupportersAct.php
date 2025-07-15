<?php
// �������� ���� �� ���� ����.
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //��������

$mode = $_POST["mode"];

// ������ ��ȿ�� �˻� y-m-d �������� �Ѿ�� �� y-m-d H:i:s �������� ����
if (!empty($_POST["new_startDt"]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["new_startDt"])) {
    $_POST["new_startDt"] = $_POST["new_startDt"]." 00:00:00";
}
if (!empty($_POST["new_endDt"]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["new_endDt"])) {
    $_POST["new_endDt"] = $_POST["new_endDt"]." 23:59:59";
}

// recruit �ʵ尡 UTF-8�� �Ѿ���� EUC-KR�� ��ȯ (�� ���� �Ѿ����..?)
$recruit = iconv("UTF-8", "EUC-KR", $_POST["new_recruit"]);

$result = 0;
$data = array();
switch($mode) {
    // �������� ����
    case "insert":
        $sql  = " INSERT INTO supporters (recruit, hero_board, startDt, endDt) VALUES ";
        $sql .= " ('".$recruit."','".$_POST["new_hero_board"]."','".$_POST["new_startDt"]."','".$_POST["new_endDt"]."') ";
        $result = sql($sql,"on");

        if($result) {
            $data["result"] = 1;
        } else {
            $data["result"] = -1;
        }
        break;

    // �������� ����
    case "delete":
        $sql  = " DELETE FROM supporters WHERE idx = '".$_POST["idx"]."' ";
        $result = sql($sql,"on");

        if($result) {
            $data["result"] = 1;
        } else {
            $data["result"] = -1;
        }
        break;
    // �������� ���� (Ȱ���Ⱓ �� ���� ����.)
    case "update":
        $result = sql($sql,"on");

        if($result) {
            $data["result"] = 1;
        } else {
            $data["result"] = -1;
        }
        break;

    case "insert_mem":   // �������� ��� ����
        /*
         * �Ѱܹ��� ������ ����  supporters_mem_info �� supporters_idx,hero_code,hero_supports_group ��� ��
         * member ���̺��� level ��  hero_supports_group ���� ����.  sql Ʈ������ ó�� �ϱ�.
         * ���� supporters_mem_info ���̺� hero_code �� �����ϴ��� Ȯ�� �� �����ϸ� �������� ����.
         * insert into supporters_mem_info (supporters_idx, hero_code, hero_supports_group) values (?,?,?)
         * hero_level �� �����ϴ� ���� hero_board ���� ���� �ٸ��� level ���� ����
         * hero_board ���� group_04_06(�����̾��Ƽ) ��� 9996
         * hero_board���� group_04_28 (�����̾� ������) ��� 9994
         * update member set hero_level = ? where hero_code = ?
         * */
        // �迭 ������ Ȯ��
        $hero_codes = $_POST["hero_codes"];
        $hero_groups = $_POST["hero_groups"];

        if(!is_array($hero_codes) || !is_array($hero_groups) || count($hero_codes) != count($hero_groups)) {
            $data["result"] = -1;
            $data["error"] = "Invalid data format!";
            break;
        }

        // hero_level �� �̸� ����
        $hero_level = '';
        if($_POST["hero_board"] == "group_04_06") {
            $hero_level = "9996";  // �����̾��Ƽ
        } elseif($_POST["hero_board"] == "group_04_28") {
            $hero_level = "9994";  // �����̾� ������
        } else {
            $data["result"] = -1;
            $data["error"] = "wrong hero_board value!";
            break;
        }

        // 1. ���� ��� �����Ϳ� ���� �ߺ� üũ�Ͽ� ���� �����Ͱ� �ִٸ� return
        $duplicate_members = array();
        for($i = 0; $i < count($hero_codes); $i++) {
            $sql = "SELECT COUNT(*) as cnt FROM supporters_mem_info WHERE supporters_idx = '".$_POST["sno"]."' AND hero_code = '".$hero_codes[$i]."'";
            $check_result = sql($sql, "on");
            $total_rs = mysql_fetch_assoc($check_result);
            $total_data = $total_rs['cnt'];

            if($total_data > 0) {
                $duplicate_members[] = $hero_codes[$i];
            }
        }

        if(count($duplicate_members) > 0) {
            // �ߺ� �����Ͱ� �ִ� ���
            $data["result"] = -3;
            $data["error"] = "already exists member: " . implode(", ", $duplicate_members);
        } else {
            // �ߺ� �����Ͱ� ������ Ʈ����� ����
            $sql = "BEGIN";
            $result1 = sql($sql, "on");

            $transaction_success = true;
            $error_message = "";

            // 2. ��� hero_code�� ���� ó��
            for($i = 0; $i < count($hero_codes) && $transaction_success; $i++) {
                $current_hero_code = $hero_codes[$i];
                $current_hero_group = $hero_groups[$i];

                // 2-1. supporters_mem_info ���̺� ������ ����
                $sql = "INSERT INTO supporters_mem_info (supporters_idx, hero_code, hero_supports_group) VALUES ";
                $sql .= "('".$_POST["sno"]."', '".$current_hero_code."', '".$current_hero_group."')";
                $result2 = sql($sql, "on");

                if(!$result2) {
                    $transaction_success = false;
                    $error_message = "supporters_mem_info insert failed for hero_code: " . $current_hero_code;
                    break;
                }

                // 2-2. member ���̺��� hero_level ������Ʈ
                $sql = "UPDATE member SET hero_level = '".$hero_level."' WHERE hero_code = '".$current_hero_code."'";
                $result3 = sql($sql, "on");

                if(!$result3) {
                    $transaction_success = false;
                    $error_message = "member level update failed for hero_code: " . $current_hero_code;
                    break;
                }
            }

            // Ʈ����� �Ϸ� ó��
            if($transaction_success) {
                $sql = "COMMIT";
                $result4 = sql($sql, "on");

                if($result4) {
                    $data["result"] = 1;
                } else {
                    $data["result"] = -1;
                    $data["error"] = "commit failed!";
                }
            } else {
                // �ѹ� ó��
                $sql = "ROLLBACK";
                sql($sql, "on");
                $data["result"] = -1;
                $data["error"] = !empty($error_message) ? $error_message : "Transaction failed!";
            }
        }

        break;
    case "delete_mem": // �������� ��� ����
        /*
         * �Ѱܹ��� ������ ����  supporters_mem_info  �� hero_code ���� ��ȸ�ؼ�
         * ������� �ִٸ� �ϱ� ������ sql tranjection���� ����
         * 1. �ش� row delete ó��
         * 2. member ���̺��� hero_level �� 1�� ����
         * */

        $hero_codes = $_POST["hero_codes"];
        $supporters_idx = $_POST["supporters_idx"];

        // hero_codes �迭�� SQL���� ����� �� �ֵ��� ó��
        $hero_codes_escaped = array();
        foreach($hero_codes as $code) {
            $hero_codes_escaped[] = "'" . addslashes($code) . "'";
        }
        $hero_codes_str = implode(',', $hero_codes_escaped);

        // Ʈ����� ����
        $sql = "BEGIN";
        $result1 = sql($sql, "on");

        $transaction_success = true;
        $error_message = "";
        $processed_count = count($hero_codes);

        // 1. supporters_mem_info ���̺��� ������ ����
        if($transaction_success) {
            $sql = "DELETE FROM supporters_mem_info 
            WHERE supporters_idx = '" . addslashes($supporters_idx) . "' 
            AND hero_code IN (" . $hero_codes_str . ")";
            $result2 = sql($sql, "on");

            if(!$result2) {
                $transaction_success = false;
                $error_message = "failed to delete from supporters_mem_info";
            }
        }

        // 2. member ���̺��� hero_level�� 1�� ���� (���� ��)
        if($transaction_success) {
            $sql = "UPDATE member SET hero_level = '1' 
            WHERE hero_code IN (" . $hero_codes_str . ")";
            $result3 = sql($sql, "on");

            if(!$result3) {
                $transaction_success = false;
                $error_message = "change hero_level to 1 failed";
            }
        }

        // Ʈ����� �Ϸ� ó��
        if($transaction_success) {
            $sql = "COMMIT";
            $result4 = sql($sql, "on");

            if($result4) {
                $data["result"] = 1;
//                $data["processed_count"] = $processed_count;
//                $data["message"] = "{$processed_count}���� �������� ����� ���������� ó���Ǿ����ϴ�.";
            } else {
                $data["result"] = -1;
                $data["error"] = "failed to commit transaction";
            }
        } else {
            // �ѹ� ó��
            $sql = "ROLLBACK";
            sql($sql, "on");
            $data["result"] = -1;
            $data["error"] = !empty($error_message) ? $error_message : "Transaction failed!";
        }

        break;

    case "insert_memo": // ����ۼ�
        $hero_codes = $_POST["hero_codes"];
        $memos = $_POST["memos"];
        $supporters_idx = $_POST["supporters_idx"];

        $i = 0;
        foreach($hero_codes as $hero_code) {
            $sql = "UPDATE supporters_mem_info 
                SET memo = '" . addslashes($memos[$i]) . "' 
                WHERE supporters_idx = '" . $supporters_idx . "' 
                AND hero_code = '" . $hero_code . "'";
            $result = sql($sql, "on");
            $i++;
        }

        if($result) {
            $data["result"] = 1;
        } else {
            $data["result"] = -1;
        }
        break;
    case "get_excel": // �������� ��� ���� �ٿ�ε�
        break;
    default:
        $data["result"] = -2; // �߸��� ��û
        break;
}
echo json_encode($data);
exit;
?>