<!DOCTYPE html>
<?
define('_HEROBOARD_', TRUE);
include_once '../../freebest/head.php';
include                                    '../popupSessionCheck.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';
include 									'../page02.php';

$mode = $_POST["mode"];

if ($_FILES["file"]['name'] && $mode == "upload"){
	
	$hero_id = $_POST["hero_id"];
	$hero_point = $_POST["hero_point"];
	$hero_title = $_POST["hero_title"];
	$mode = $_POST["mode"];
	$ins_type = $_POST["ins_type"];
	$hero_top_title = "체험단일괄포인트지급";
	
	$UPLOAD_DIR 	=  $_SERVER["DOCUMENT_ROOT"]."/PHPExcel/upload/";
	$filename 		= date('YmdHis').$_FILES["file"]["name"];
	$uploadFileName = $UPLOAD_DIR.$filename;
	
	move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFileName);
	
	require_once $_SERVER["DOCUMENT_ROOT"]."/PHPExcel/PHPExcel.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/PHPExcel/PHPExcel/IOFactory.php";
	
	
	$objReader = PHPExcel_IOFactory::createReaderForFile($uploadFileName);
	
	$objReader->setReadDataOnly(false);
	$objExcel = $objReader->load($uploadFileName);
	$objExcel->setActiveSheetIndex(0);
	$objWorksheet = $objExcel->getActiveSheet();
	
	$list = array();
	
	foreach ($objWorksheet->getRowIterator() as $row) {
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
	
		$one = array();
		foreach ($cellIterator as $cell) {
			if(PHPExcel_Shared_Date::isDateTime($cell)) {
				$one[] = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));
			}else{
				$one[] = $cell->getValue();
			}
		}
	
		if($one[0]) $list[] = $one;
	
	}
	
	$m_point_upload_sql  = " INSERT INTO mission_point_upload (hero_id, hero_today, excel_name) values ('".$hero_id."',now(),'".$filename."') ";
	sql($m_point_upload_sql,"on");
	
	$m_idx_sql = "SELECT LAST_INSERT_ID() as idx ";
	$m_out_sql    = mysql_query($m_idx_sql);
	$rs  = mysql_fetch_assoc($m_out_sql);
	
	$m_hero_idx = $rs["idx"];
	
	$all_cnt = 0;
	$cnt = 0;
	
	for($i=0; $i<count($list); $i++) {
	
		$key = $list[$i][0];
		if($ins_type == "hero_nick") $key = iconv("utf-8", "euc-kr", $key);
	
		$sql = " SELECT hero_code, hero_nick, hero_name, hero_id FROM member WHERE hero_use = 0 ";
		$sql .= " AND ".$ins_type." = '".$key."' ";
	
	
		$out_sql = mysql_query($sql);
		$rs  = mysql_fetch_assoc($out_sql);
	
		if(!empty($rs)) {
			$point_sql  = " INSERT INTO point (hero_code, hero_table, hero_type, hero_old_idx, hero_mission_idx, hero_review_idx, hero_id, hero_top_title, hero_title, hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, hero_use, point_change_chk, hero_ori_today) ";
			$point_sql .= " VALUES ";
			$point_sql .= " ('{$rs["hero_code"]}', 'nail', 'mission_excel', '".$m_hero_idx."', 0, 0, '".$rs["hero_id"]."', '".$hero_top_title."', '".addslashes($hero_title)."', '".$rs["hero_name"]."', '".$rs["hero_nick"]."', '".$hero_point."',now(), 'N', 0, 'Y', now()) ";
	
			$result = mysql_query($point_sql);
			$cnt++;
		}
	
		$all_cnt++;
	}
	
	if($all_cnt != $cnt) {
		echo "<script>alert('포인트 지급인원과 엑셀업로드 수치가 일치하지 않습니다.\\n다시 확인해 주세요.');</script>";
	} else {
		echo "<script>alert('".$cnt."명 포인트 지급되었습니다.'); opener.location.reload(); self.close();</script>";
	}
}
?>
<meta charset="euc-kr" />
<head>
<link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/admin.css" />
<script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_END;?>jquery.form.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
</head>
<body style="background:none;">

<div class="popupWrap">
	<div class="popHeader">
		<h1>포인트 엑셀 업로드</h1>
	</div>
	<div class="popContents">
		<form name="form0" id="form0" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="mode" id="mode" />
		<input type="hidden" name="hero_id" id="hero_id" value="<?=$_SESSION["temp_id"]?>" />
		<table class=t_view>
		<colgroup>
			<col width="150px" />
			<col width="*" />
		</colgroup>
		<tr>
			<th>체험단 명</th>
			<td><input type="text" name="hero_title" id="hero_title" /></td>
		</tr>
		<tr>
			<th>포인트</th>
			<td><input type="text" name="hero_point" id="hero_point" /></td>
		</tr>
		<tr>
			<th>A열 선택</th>
			<td>
				<input type="radio" id="ins_type_1" name="ins_type" value="hero_nick" checked/><label for="ins_type_1"/>닉네임</label>
				<input type="radio" id="ins_type_2" name="ins_type" value="hero_id"/><label for="ins_type_2"/>아이디</label>
			</td>
		</tr>
		<tr>
			<th>엑셀업로드</th>
			<td>
				<input type="file" name="file" id="file" /> (* A열 입력 필요)
			</td>
		</tr>
		</table>
		</form>
		
		<div class="align_c margin_t20">
			<a href="javascript:;" onclick="fnUpload()" class="btnAdd">업로드</a>
		</div>
	</div>
</div>
</body>
<html>
<script>
$(document).ready(function(){
	fnUpload = function() {
		if(!$("#hero_title").val()) {
			alert("체험단 명을 입력해 주세요.");
			$("#hero_title").focus();
			return;
		}

		if(!$("#hero_point").val()) {
			alert("포인트를 입력해 주세요.");
			$("#hero_point").focus();
			return;
		}

		if(!$("#file").val()) {
			alert("엑셀업로드를 해주세요.");
			$("#file").focus();
			return;
		}

		$("#mode").val("upload");
		$("#form0").submit();
	}
});
</script>