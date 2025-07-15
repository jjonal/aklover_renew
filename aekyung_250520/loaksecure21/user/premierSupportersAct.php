<?php
// 서포터즈 생성 및 삭제 관련.
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mode = $_POST["mode"];

// 데이터 유효성 검사 y-m-d 형식으로 넘어올 시 y-m-d H:i:s 형식으로 변경
if (!empty($_POST["new_startDt"]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["new_startDt"])) {
    $_POST["new_startDt"] = $_POST["new_startDt"]." 00:00:00";
}
if (!empty($_POST["new_endDt"]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST["new_endDt"])) {
    $_POST["new_endDt"] = $_POST["new_endDt"]." 23:59:59";
}

// recruit 필드가 UTF-8로 넘어오면 EUC-KR로 변환 (왜 깨져 넘어오지..?)
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

    case "insert_mem":   // 서포터즈 멤버 선정
        /*
         * 넘겨받은 정보를 토대로  supporters_mem_info 에 supporters_idx,hero_code,hero_supports_group 등록 및
         * member 테이블의 level 을  hero_supports_group 별로 변경.  sql 트랜젝션 처리 하기.
         * 기존 supporters_mem_info 테이블에 hero_code 가 존재하는지 확인 후 존재하면 삽입하지 않음.
         * insert into supporters_mem_info (supporters_idx, hero_code, hero_supports_group) values (?,?,?)
         * hero_level 을 변경하는 쿼리 hero_board 값에 따라 다르게 level 값을 변경
         * hero_board 값이 group_04_06(프리미어뷰티) 경우 9996
         * hero_board값이 group_04_28 (프리미어 라이프) 경우 9994
         * update member set hero_level = ? where hero_code = ?
         * */

        // 1. 먼저 중복 데이터 체크
        $sql = "SELECT COUNT(*) as cnt FROM supporters_mem_info WHERE supporters_idx = '".$_POST["sno"]."' AND hero_code = '".$_POST["hero_code"]."'";
        $check_result = sql($sql, "on");
        $total_rs = mysql_fetch_assoc($check_result);
        $total_data = $total_rs['cnt'];

        if($total_data > 0) {
            // 이미 존재하는 데이터
            $data["result"] = -3;
            $data["error"] = "already exists member!";
        } else {
            // 중복 데이터가 없으면 트랜잭션 시작
            $sql = "BEGIN";
            $result1 = sql($sql, "on");

            $transaction_success = true;
            $error_message = "";

            // 2. supporters_mem_info 테이블에 데이터 삽입
            if($transaction_success) {
                $sql = "INSERT INTO supporters_mem_info (supporters_idx, hero_code, hero_supports_group) VALUES ";
                $sql .= "('".$_POST["sno"]."', '".$_POST["hero_code"]."', '".$_POST["hero_supports_group"]."')";
                $result2 = sql($sql, "on");

                if(!$result2) {
                    $transaction_success = false;
                    $error_message = "already exists!";
                }
            }

            // 3. hero_board 값에 따라 hero_level 결정 및 업데이트
            if($transaction_success) {
                $hero_level = '';
                if($_POST["hero_board"] == "group_04_06") {
                    $hero_level = "9996";  // 프리미어뷰티
                } elseif($_POST["hero_board"] == "group_04_28") {
                    $hero_level = "9994";  // 프리미어 라이프
                } else {
                    $transaction_success = false;
                    $error_message = "wrong hero_board value!";
                }

                // 4. member 테이블의 hero_level 업데이트
                if($transaction_success) {
                    $sql = "UPDATE member SET hero_level = '".$hero_level."' WHERE hero_code = '".$_POST["hero_code"]."'";
                    $result3 = sql($sql, "on");

                    if(!$result3) {
                        $transaction_success = false;
                        $error_message = "member level update failed!";
                    }
                }
            }
            // 트랜잭션 완료 처리
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
                // 롤백 처리
                $sql = "ROLLBACK";
                sql($sql, "on");
                $data["result"] = -1;
                $data["error"] = !empty($error_message) ? $error_message : "Transaction failed!";
            }
        }

        break;
    case "delete_mem": // 서포터즈 멤버 삭제
        // supporters_mem_info 테이블에서 해당 hero_code 삭제
        $sql = "DELETE FROM supporters_mem_info WHERE supporters_idx = '".$_POST["sno"]."' AND hero_code = '".$_POST["hero_code"]."'";
        $result = sql($sql, "on");

        if($result) {
            // member 테이블의 hero_level을 원래대로 되돌리기
            $sql = "UPDATE member SET hero_level = '9999' WHERE hero_code = '".$_POST["hero_code"]."'"; // 9999는 일반 사용자 레벨
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
        $data["result"] = -2; // 잘못된 요청
        break;
}
echo json_encode($data);
exit;
?>