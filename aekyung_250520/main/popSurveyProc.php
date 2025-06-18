<?
define('_HEROBOARD_', TRUE);

include_once                                                        '../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] != "9999") {
	message("이용 권한이 없습니다..","");
	exit;
}

$mode = $_POST["mode"];
$mission_idx = $_POST["mission_idx"];
$result = 0;

if($mode == "insert") { //등록,수정
	for($i=0; $i<count($_POST["title"]); $i++) {
		$hero_idx = $_POST["hero_idx"][$i];
		$temp_hero_idx = $_POST["temp_hero_idx"][$i];
		$order_num = $i+1;
		$title = $_POST["title"][$i];
		$questionType = $_POST["questionType"][$i];
		$cont = $_POST["cont"][$i];
		$necessary = $_POST["necessary"][$i];
		$hero_code = $_SESSION["temp_code"];
		
		$image_cont = "";
		if($_FILES["image_cont"]["tmp_name"][$i]) {
			$sourcePath = $_FILES["image_cont"]["tmp_name"][$i];
			$filePath = $_SERVER["DOCUMENT_ROOT"]."/user/survey/".$mission_idx."/";
			
			if (!file_exists($filePath)) {
				mkdir($filePath, 0777, true);
			}
			
			$fileName = $_FILES['image_cont']['name'][$i];
			$ext = end(explode('.', $fileName));
			$fileNewName= date('YmdHis').sprintf('%05d',mt_rand(0,99999)).$order_num.".".$ext;
	
			if(@move_uploaded_file($sourcePath,($filePath.$fileNewName))) {
				$image_cont = $fileNewName;
			}
		}
		
		if($hero_idx) { //수정
			$sql  = " UPDATE mission_survey SET ";
			$sql .= " order_num = '".$order_num."' ";
			$sql .= " , questionType = '".$questionType."' ";
			$sql .= " , title = '".$title."' ";
			$sql .= " , cont = '".$cont."' ";
			if($image_cont) {
				$sql .= " , image_cont = '".$image_cont."' ";
			}
			$sql .= " , necessary = '".$necessary."' ";
			$sql .= " , op1 = '".$_POST["op_".$hero_idx][0]."' , op2 = '".$_POST["op_".$hero_idx][1]."', op3 = '".$_POST["op_".$hero_idx][2]."' , op4 = '".$_POST["op_".$hero_idx][3]."' , op5 = '".$_POST["op_".$hero_idx][4]."' ";
			$sql .= " , op6 = '".$_POST["op_".$hero_idx][5]."' , op7 = '".$_POST["op_".$hero_idx][6]."', op8 = '".$_POST["op_".$hero_idx][7]."' , op9 = '".$_POST["op_".$hero_idx][8]."' , op10 = '".$_POST["op_".$hero_idx][9]."' ";
			$sql .= " , op11 = '".$_POST["op_".$hero_idx][10]."' , op12 = '".$_POST["op_".$hero_idx][11]."', op13 = '".$_POST["op_".$hero_idx][12]."' , op14 = '".$_POST["op_".$hero_idx][13]."' , op15 = '".$_POST["op_".$hero_idx][14]."' ";
			$sql .= " , op16 = '".$_POST["op_".$hero_idx][15]."' , op17 = '".$_POST["op_".$hero_idx][16]."', op18 = '".$_POST["op_".$hero_idx][17]."' , op19 = '".$_POST["op_".$hero_idx][18]."' , op20 = '".$_POST["op_".$hero_idx][19]."' ";
			$sql .= " , hero_code = '".$hero_code."' ";
			$sql .= " WHERE hero_idx = '".$hero_idx."' ";
		} else { //등록
			$sql  = " INSERT INTO mission_survey ( ";
			$sql .= " mission_idx, order_num, questionType, title, cont, image_cont ";
			$sql .= " , necessary, op1, op2, op3, op4 ";
			$sql .= " , op5, op6, op7, op8, op9, op10 ";
			$sql .= " , op11, op12, op13, op14, op15 ";
			$sql .= " , op16, op17, op18, op19, op20 ";
			$sql .= " , hero_code, hero_today ";
			$sql .= " ) values ";
			$sql .= "(";
			$sql .= " '".$mission_idx."', '".$order_num."','".$questionType."','".$title."', '".$cont."', '".$image_cont."' ";
			$sql .= " ,'".$necessary."', '".$_POST["op_".$temp_hero_idx][0]."', '".$_POST["op_".$temp_hero_idx][1]."', '".$_POST["op_".$temp_hero_idx][2]."', '".$_POST["op_".$temp_hero_idx][3]."' ";
			$sql .= " ,'".$_POST["op_".$temp_hero_idx][4]."', '".$_POST["op_".$temp_hero_idx][5]."', '".$_POST["op_".$temp_hero_idx][6]."', '".$_POST["op_".$temp_hero_idx][7]."', '".$_POST["op_".$temp_hero_idx][8]."', '".$_POST["op_".$temp_hero_idx][9]."' ";
			$sql .= " ,'".$_POST["op_".$temp_hero_idx][10]."', '".$_POST["op_".$temp_hero_idx][11]."', '".$_POST["op_".$temp_hero_idx][12]."', '".$_POST["op_".$temp_hero_idx][13]."', '".$_POST["op_".$temp_hero_idx][14]."' ";
			$sql .= " ,'".$_POST["op_".$temp_hero_idx][15]."', '".$_POST["op_".$temp_hero_idx][16]."', '".$_POST["op_".$temp_hero_idx][17]."', '".$_POST["op_".$temp_hero_idx][18]."', '".$_POST["op_".$temp_hero_idx][19]."' ";
			$sql .= " ,'".$hero_code."',now() ";
			$sql .= ")";
		}
	
		$result = sql($sql,"on");
		
		if($result < 1) echo "<script>alert('실행중 실패했습니다.다시 시도해 주세요.'); history.go(-1);</script>";
		
	}
	
	if($result > 0) echo "<script>alert('등록되었습니다.'); history.go(-1);</script>";
} else if($mode == "del") {
	$hero_idx = $_POST["hero_idx"];
	
	$sql = " DELETE FROM mission_survey WHERE hero_idx = '".$hero_idx."' ";
	$result = sql($sql,"on");
	
	echo "{\"result\":".$result."}";
} else if($mode == "delFile") {
	$hero_idx = $_POST["hero_idx"];
	
	$sql = " SELECT image_cont, mission_idx FROM mission_survey WHERE hero_idx = '".$hero_idx."' ";
	sql($sql,"on");
	
	$row = mysql_fetch_array($out_sql);
	
	if(unlink($_SERVER["DOCUMENT_ROOT"]."/user/survey/".$row["mission_idx"]."/".$row["image_cont"])) {
		$sql = " UPDATE mission_survey SET image_cont = '' WHERE hero_idx = '".$hero_idx."' ";
		$result = sql($sql);
	}
	
	echo "{\"result\":".$result."}";
}
?>
