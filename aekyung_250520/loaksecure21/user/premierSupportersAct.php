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
    // 서포터즈 생성
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

    // 서포터즈 삭제
    case "delete":
        $sql  = " DELETE FROM supporters WHERE idx = '".$_POST["idx"]."' ";
        $result = sql($sql,"on");

        if($result) {
            $data["result"] = 1;
        } else {
            $data["result"] = -1;
        }
        break;
    // 서포터즈 수정 (활동기간 만 수정 가능.)
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
        // 배열 데이터 확인
        $hero_codes = $_POST["hero_codes"];
        $hero_groups = $_POST["hero_groups"];

        if(!is_array($hero_codes) || !is_array($hero_groups) || count($hero_codes) != count($hero_groups)) {
            $data["result"] = -1;
            $data["error"] = "Invalid data format!";
            break;
        }

        // hero_level 값 미리 결정
        $hero_level = '';
        if($_POST["hero_board"] == "group_04_06") {
            $hero_level = "9996";  // 프리미어뷰티
        } elseif($_POST["hero_board"] == "group_04_28") {
            $hero_level = "9994";  // 프리미어 라이프
        } else {
            $data["result"] = -1;
            $data["error"] = "wrong hero_board value!";
            break;
        }

        // 1. 먼저 모든 데이터에 대해 중복 체크하여 기등록 데이터가 있다면 return
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
            // 중복 데이터가 있는 경우
            $data["result"] = -3;
            $data["error"] = "already exists member: " . implode(", ", $duplicate_members);
        } else {
            // 중복 데이터가 없으면 트랜잭션 시작
            $sql = "BEGIN";
            $result1 = sql($sql, "on");

            $transaction_success = true;
            $error_message = "";

            // 2. 모든 hero_code에 대해 처리
            for($i = 0; $i < count($hero_codes) && $transaction_success; $i++) {
                $current_hero_code = $hero_codes[$i];
                $current_hero_group = $hero_groups[$i];

                // 2-1. supporters_mem_info 테이블에 데이터 삽입
                $sql = "INSERT INTO supporters_mem_info (supporters_idx, hero_code, hero_supports_group) VALUES ";
                $sql .= "('".$_POST["sno"]."', '".$current_hero_code."', '".$current_hero_group."')";
                $result2 = sql($sql, "on");

                if(!$result2) {
                    $transaction_success = false;
                    $error_message = "supporters_mem_info insert failed for hero_code: " . $current_hero_code;
                    break;
                }

                // 2-2. member 테이블의 hero_level 업데이트
                $sql = "UPDATE member SET hero_level = '".$hero_level."' WHERE hero_code = '".$current_hero_code."'";
                $result3 = sql($sql, "on");

                if(!$result3) {
                    $transaction_success = false;
                    $error_message = "member level update failed for hero_code: " . $current_hero_code;
                    break;
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
        /*
         * 넘겨받은 정보를 토대로  supporters_mem_info  의 hero_code 값을 조회해서
         * 결과값이 있다면 하기 로직을 sql tranjection으로 실행
         * 1. 해당 row delete 처리
         * 2. member 테이블의 hero_level 을 1로 변경
         * */

        $hero_codes = $_POST["hero_codes"];
        $supporters_idx = $_POST["supporters_idx"];

        // hero_codes 배열을 SQL에서 사용할 수 있도록 처리
        $hero_codes_escaped = array();
        foreach($hero_codes as $code) {
            $hero_codes_escaped[] = "'" . addslashes($code) . "'";
        }
        $hero_codes_str = implode(',', $hero_codes_escaped);

        // 트랜잭션 시작
        $sql = "BEGIN";
        $result1 = sql($sql, "on");

        $transaction_success = true;
        $error_message = "";
        $processed_count = count($hero_codes);

        // 1. supporters_mem_info 테이블에서 데이터 삭제
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

        // 2. member 테이블의 hero_level을 1로 변경 (여러 개)
        if($transaction_success) {
            $sql = "UPDATE member SET hero_level = '1' 
            WHERE hero_code IN (" . $hero_codes_str . ")";
            $result3 = sql($sql, "on");

            if(!$result3) {
                $transaction_success = false;
                $error_message = "change hero_level to 1 failed";
            }
        }

        // 트랜잭션 완료 처리
        if($transaction_success) {
            $sql = "COMMIT";
            $result4 = sql($sql, "on");

            if($result4) {
                $data["result"] = 1;
//                $data["processed_count"] = $processed_count;
//                $data["message"] = "{$processed_count}개의 서포터즈 멤버가 성공적으로 처리되었습니다.";
            } else {
                $data["result"] = -1;
                $data["error"] = "failed to commit transaction";
            }
        } else {
            // 롤백 처리
            $sql = "ROLLBACK";
            sql($sql, "on");
            $data["result"] = -1;
            $data["error"] = !empty($error_message) ? $error_message : "Transaction failed!";
        }

        break;

    case "insert_memo": // 비고작성
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
    case "get_excel": // 서포터즈 멤버 엑셀 다운로드
        break;
    default:
        $data["result"] = -2; // 잘못된 요청
        break;
}
echo json_encode($data);
exit;
?>