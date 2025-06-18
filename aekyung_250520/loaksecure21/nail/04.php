<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 문수영)2018년 11월 22일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

$hero_id = $_POST["hero_id"];
$hero_point = $_POST["hero_point"];
$hero_title = $_POST["hero_title"];
$mode = $_POST["mode"];
$ins_type = $_POST["ins_type"];
$hero_top_title = "체험단일괄포인트지급";

if ($_FILES["file"]['name'] && $mode == "upload"){
	
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
		echo "<script>alert('포인트 지급인원과 엑셀업로드 수치가 일치하지 않습니다.\\n다시 확인해 주세요.'); location.href='".ADMIN_DEFAULT."/index.php?board=nail&idx=91'</script>";
	} else {
		echo "<script>alert('".$cnt."명 포인트 지급되었습니다.'); location.href='".ADMIN_DEFAULT."/index.php?board=nail&idx=91'</script>";
	}
	
	
	
}

?>
<style>
.tbForm th{background:#eee; border:1px solid #cdcdcd; height:30px;}
.tbForm td{border:1px solid #cdcdcd; height:30px; padding:0 10px;}
.tbForm td input[type="text"]{width:100%;}
.tbForm td.c{text-align:center;}
</style>
<script>
$(document).ready(function(){
	$(".onlynum").keyup(function(){$(this).val( $(this).val().replace(/[^0-9\-]/g,"") );} );
})
function upload() {
	
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

function fnPopList(n) {
	location.href = "<?=ADMIN_DEFAULT?>/index.php?board=nail&idx=91&view=04_01&hero_old_idx="+n;
}
</script>
<form name="form0" id="form0" method="post" enctype="multipart/form-data">
<div>
<input type="hidden" name="mode" id="mode" />
<input type="hidden" name="hero_id" id="hero_id" value="<?=$_SESSION["temp_id"]?>" />
<table class="tbForm" style="margin:0 auto;">
	<colgroup>
	<col width="120px" />
	<col width="400px" />
	</colgroup>
	<tr>
		<th>체험단 명</th>
		<td><input type="text" name="hero_title" id="hero_title" /></td>
	</tr>
	<tr>
		<th>포인트</th>
		<td><input type="text" name="hero_point" id="hero_point" class="onlynum" style="width:60px;" /> P</td>
	</tr>
	<tr>
		<th>A열 선택</th>
		<td><input type="radio" id="ins_type_1" name="ins_type" value="hero_nick" checked/><label for="ins_type_1"/>닉네임</label>
			<input type="radio" id="ins_type_2" name="ins_type" value="hero_id"/><label for="ins_type_2"/>아이디</label>
		</td>
	</tr>
	<tr>
		<th>엑셀업로드</th>
		<td><input type="file" name="file" id="file" /> (* A열 입력 필요)</td>
	</tr>
</table>

	<div style="margin:20px 0 0 0; text-align:center;">
	<a href="javascript:;" onClick="upload();" style="display: inline-block;padding:5px 10px; background-color: #6799FF; color:#fff;">업로드하기</a>
	</div>
</div>
</form>

<?php 

	$list_sql =  " SELECT m.hero_today,m.hero_idx, p.hero_point, p.hero_title, count(m.hero_idx) cnt FROM mission_point_upload m ";
	$list_sql .= " inner join point p on m.hero_idx = p.hero_old_idx and p.hero_type='mission_excel' "; 
	$list_sql .= " group by m.hero_idx order by m.hero_idx DESC ";
	$out_sql = mysql_query($list_sql);
	
?>
<div style="margin:30px 0 0 0;">
	<h2 style="font-size:18px;">업로드 내역</h2>
	<p style="color:#f00; font-size:14px; margin:20px 0 0 0;">※ 배송비 차감 기능은 이용하실 수 없습니다. 배송비 차감 기능은 후기관리 > 체험단(체험단 신청->신청자 확인 )에서 이용가능합니다. </p>
	<table class="tbForm" style="width:100%; margin:20px 0 0 0;">
		<colgroup>
			<col width="20%" />
			<col width="*" />
			<col width="20%" />
			<col width="20%" />
			<col width="10%" />
		</colgroup>
		<tr>
			<th>지급일</th>
			<th>체험단 명</th>
			<th>포인트</th>
			<th>포인트 지급 인원 수</th>
			<th>지급확인</th>
		</tr>
		<? 
			while($list = @mysql_fetch_assoc($out_sql)){ 
		?>
			<tr>
				<td class="c"><?=$list["hero_today"];?></td>
				<td><?=$list["hero_title"];?></td>
				<td class="c"><?=$list["hero_point"];?>P</td>
				<td class="c"><?=$list["cnt"];?>명</td>
				<td class="c"><a href="javascript:;" onClick="fnPopList('<?=$list["hero_idx"];?>');" class="btn_blue2" style="height:20px; margin:1px 0 0 0;">확인</a></td>
			</tr>
		<? 
			}
		?>
	</table>
</div>
	

                        