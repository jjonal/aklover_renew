<?php
// 퀄리티평가 insert, delete, update 액션
define('_HEROBOARD_', TRUE);
include_once   '../../freebest/head.php';
include  FREEBEST_INC_END.'hero.php';
include  FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] < 9999) exit; //레벨제한

$mode = $_POST["mode"];

$result = 0;
$data = array();
if($mode == "update") {
    // quality_evaluation 테이블에 기존 정보가 있다면 update, 없다면 insert
    $count_sql = sql("SELECT count(*) FROM quality_evaluation WHERE hero_code = '".$_POST["hero_code"]."'","on");
    $out_res = mysql_fetch_assoc($out_sql);
    $total_data = $out_res["count(*)"];

    if ($total_data == 1) {
        // 기존 정보가 있으면 update
     $sql = " UPDATE quality_evaluation SET 
            grade='".$_POST["grade"]."', 
            image_quality=".$_POST["image_quality"].", 
            text_quality=".$_POST["text_quality"].", 
            guide_compliance=".$_POST["guide_compliance"].", 
            engagement_score=".$_POST["engagement_score"].", 
            engagement_likes=".$_POST["engagement_likes"].", 
            engagement_comments=".$_POST["engagement_comments"].", 
            follower_score=".$_POST["follower_score"].", 
            follower_count=".$_POST["follower_count"].", 
            top_exposure=".$_POST["top_exposure"].", 
            total_score=".$_POST["total_score"].",
            modDt = now() WHERE hero_code = '".$_POST["hero_code"]."'";
    } else {
    $sql  = " INSERT INTO quality_evaluation (hero_code, grade, image_quality, text_quality,guide_compliance,
            engagement_score,engagement_likes,engagement_comments,follower_score,follower_count,top_exposure,total_score,regDt) VALUES ";
    $sql .= " ('".$_POST["hero_code"]."',".$_POST["grade"].",".$_POST["image_quality"].",".$_POST["text_quality"].",".$_POST["guide_compliance"]."
    ,".$_POST["engagement_score"].",".$_POST["engagement_likes"].",".$_POST["engagement_comments"].",".$_POST["follower_score"]."
    ,".$_POST["follower_count"].",".$_POST["top_exposure"].",".$_POST["total_score"].",now()) ";
    }

    $result = sql($sql,"on");
    if($result) {
        $data["result"] = 1;
    } else {
        $data["result"] = -1;
    }
} elseif ($mode == "delete") {
    $sql  = " DELETE FROM quality_evaluation WHERE hero_code = '".$_POST["hero_code"]."' ";
    $result = sql($sql,"on");

    if($result) {
        $data["result"] = 1;
    } else {
        $data["result"] = -1;
    }
} else {
    $data["result"] = -2; //잘못된 요청
}
echo json_encode($data);
exit;
?>