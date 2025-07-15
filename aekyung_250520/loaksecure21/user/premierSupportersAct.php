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

    case "delete":
        $sql  = " DELETE FROM supporters WHERE idx = '".$_POST["idx"]."' ";
        $result = sql($sql,"on");

        if($result) {
            $data["result"] = 1;
        } else {
            $data["result"] = -1;
        }
        break;

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

        // 1. ���� �ߺ� ������ üũ
        $sql = "SELECT COUNT(*) as cnt FROM supporters_mem_info WHERE supporters_idx = '".$_POST["sno"]."' AND hero_code = '".$_POST["hero_code"]."'";
        $check_result = sql($sql, "on");
        $total_rs = mysql_fetch_assoc($check_result);
        $total_data = $total_rs['cnt'];

        if($total_data > 0) {
            // �̹� �����ϴ� ������
            $data["result"] = -3;
            $data["error"] = "already exists member!";
        } else {
            // �ߺ� �����Ͱ� ������ Ʈ����� ����
            $sql = "BEGIN";
            $result1 = sql($sql, "on");

            $transaction_success = true;
            $error_message = "";

            // 2. supporters_mem_info ���̺� ������ ����
            if($transaction_success) {
                $sql = "INSERT INTO supporters_mem_info (supporters_idx, hero_code, hero_supports_group) VALUES ";
                $sql .= "('".$_POST["sno"]."', '".$_POST["hero_code"]."', '".$_POST["hero_supports_group"]."')";
                $result2 = sql($sql, "on");

                if(!$result2) {
                    $transaction_success = false;
                    $error_message = "already exists!";
                }
            }

            // 3. hero_board ���� ���� hero_level ���� �� ������Ʈ
            if($transaction_success) {
                $hero_level = '';
                if($_POST["hero_board"] == "group_04_06") {
                    $hero_level = "9996";  // �����̾��Ƽ
                } elseif($_POST["hero_board"] == "group_04_28") {
                    $hero_level = "9994";  // �����̾� ������
                } else {
                    $transaction_success = false;
                    $error_message = "wrong hero_board value!";
                }

                // 4. member ���̺��� hero_level ������Ʈ
                if($transaction_success) {
                    $sql = "UPDATE member SET hero_level = '".$hero_level."' WHERE hero_code = '".$_POST["hero_code"]."'";
                    $result3 = sql($sql, "on");

                    if(!$result3) {
                        $transaction_success = false;
                        $error_message = "member level update failed!";
                    }
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
        // supporters_mem_info ���̺��� �ش� hero_code ����
        $sql = "DELETE FROM supporters_mem_info WHERE supporters_idx = '".$_POST["sno"]."' AND hero_code = '".$_POST["hero_code"]."'";
        $result = sql($sql, "on");

        if($result) {
            // member ���̺��� hero_level�� ������� �ǵ�����
            $sql = "UPDATE member SET hero_level = '9999' WHERE hero_code = '".$_POST["hero_code"]."'"; // 9999�� �Ϲ� ����� ����
            $result2 = sql($sql, "on");

            if($result2) {
                $data["result"] = 1;
            } else {
                $data["result"] = -1;
                $data["error"] = "member level update failed!";
            }
        } else {
            $data["result"] = -1;
            $data["error"] = "supporters_mem_info delete failed!";
        }
        break;
    default:
        $data["result"] = -2; // �߸��� ��û
        break;
}
echo json_encode($data);
exit;
?>