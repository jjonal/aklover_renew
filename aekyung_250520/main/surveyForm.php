<?
define('_HEROBOARD_', TRUE);
include_once                                                        '../freebest/head.php';
include_once                                                        FREEBEST_INC_END.'hero.php';
include_once                                                        FREEBEST_INC_END.'function.php';

if($_SESSION["temp_level"] != "9999") {
	message("이용 권한이 없습니다..","");
	exit;
}

$mission_idx = $_GET["mission_idx"];
$temp_hero_idx = $_GET["temp_hero_idx"];
//$mission_idx = "1195";

$sql  = " SELECT hero_idx, questionType, title, cont, image_cont, necessary ";
$sql .= ", op1, op2, op3, op4, op5 ";
$sql .= ", op6, op7, op8, op9, op10 ";
$sql .= ", op11, op12, op13, op14, op15 ";
$sql .= ", op16, op17, op18, op19, op20 ";
$sql .= " FROM mission_survey WHERE mission_idx = '".$mission_idx."' ORDER BY order_num ASC ";
sql($sql,"on");
?>
<?
if($mission_idx) {
	while($row = mysql_fetch_assoc($out_sql)){
	?>
	<table>
	<colgroup>
		<col width="120" />
		<col width="*" />
	</colgroup>
	<tr>
		<td colspan="2"><a href="javascript:;" class="btnDefault btnDeleteType" onClick="fnDelete(this,'<?=$row["hero_idx"]?>')">문항 삭제</a>
						<input type="hidden" name="hero_idx[]" value="<?=$row["hero_idx"]?>" />
						<input type="hidden" name="temp_hero_idx[]" value="" />
		</td>
	</tr>
	<tr>
		<th>제목</th>
		<td><input type="text" name="title[]" title="제목" value="<?=getIconv($row["title"])?>" /></td>
	</tr>
	<tr>
		<th>설명</th>
		<td><textarea name="cont[]" title="설명"><?=getIconv($row["cont"])?></textarea></td>
	</tr>
	<tr>
		<th>이미지 설명</th>
		<td>
			<? if($row["image_cont"]) {?>
				<img src="/user/survey/<?=$mission_idx?>/<?=$row["image_cont"]?>" width="100" /> <a href="javascript:;" onClick="fnDelFile('<?=$row["hero_idx"]?>')" class="btnDefault">파일 삭제</a>
				<input type="file" name="image_cont[]" style="display:none;" />
			<? } else { ?>
				<input type="file" name="image_cont[]" /> (가로사이즈 550px 미만)
			<? } ?>
		</td>
	</tr>
	<tr>
		<th>유형</th>
		<td><select name="questionType[]" onChange="fnEditOPtion(this)">
				<option value="1" <?=$row["questionType"] == "1" ? "selected":"";?>>주관식형</option>
				<option value="2" <?=$row["questionType"] == "2" ? "selected":"";?>>단일 선택형(객관식)</option>
				<option value="3" <?=$row["questionType"] == "3" ? "selected":"";?>>복수 선택형(객관식)</option>
			</select>
			<input type="checkbox" name="necessary[]" value="Y" <?=$row["necessary"]=="Y" ? "checked":"";?>> <lable>필수선택</lable>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div class="ui_questionType">
				<? if($row["questionType"] == "1") {?>
				<textarea readonly disabled></textarea>
				<? } else if($row["questionType"] == "2"){ ?>
					<div class="optionWrap"><a href="javascript:;" onClick="fnOptionAddType2(this)" class="btnDefault">추가</a> <span class="txt_ex">(최대 20개까지 추가 가능합니다.)<span></div>
					<? if(getIconv($row["op1"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op1"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op2"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op2"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op3"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op3"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op4"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op4"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op5"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op5"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op6"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op6"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op7"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op7"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op8"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op8"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op9"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op9"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op10"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op10"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op11"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op11"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op12"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op12"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op13"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op13"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op14"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op14"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op15"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op15"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op16"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op16"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op17"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op17"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op18"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op18"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op19"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op19"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op20"])) {?><div><input type="radio"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op20"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
				<? } else if($row["questionType"] == "3"){ ?>
					<div class="optionWrap"><a href="javascript:;" onClick="fnOptionAddType3(this)" class="btnDefault">추가</a> <span class="txt_ex">(최대 20개까지 추가 가능합니다.)<span></div>
					<? if(getIconv($row["op1"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op1"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op2"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op2"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op3"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op3"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op4"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op4"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op5"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op5"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op6"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op6"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op7"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션"  value="<?=getIconv($row["op7"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op8"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op8"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op9"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op9"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op10"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op10"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op11"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op11"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op12"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op12"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op13"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op13"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op14"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op14"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op15"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op15"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op16"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op16"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op17"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op17"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op18"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op18"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op19"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op19"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
					<? if(getIconv($row["op20"])) {?><div><input type="checkbox"> <input type="text" name="op_<?=$row["hero_idx"]?>[]" title="옵션" placeholder="옵션" value="<?=getIconv($row["op20"])?>" class="wP90"><a href="javascript:;" onClick="fnOptionDel(this)" class="btnOptionDel">X</a></div><? } ?>
				<? } ?>
			</div>
		</td>
	</tr>
	</table>
<? } 
} else {?>
<table>
<colgroup>
	<col width="120" />
	<col width="*" />
</colgroup>
<tr>
	<td colspan="2"><a href="javascript:;" class="btnDefault btnDeleteType" onClick="fnDelete(this)">문항 삭제</a>
					<input type="hidden" name="hero_idx[]" value="" />
					<input type="hidden" name="temp_hero_idx[]" value="<?=$temp_hero_idx?>" />
	</td>
</tr>
<tr>
	<th>제목</th>
	<td><input type="text" name="title[]" title="제목" /></td>
</tr>
<tr>
	<th>설명</th>
	<td><textarea name="cont[]" title="설명" /></textarea></td>
</tr>
<tr>
	<th>이미지 설명</th>
	<td><input type="file" name="image_cont[]" /> (가로사이즈 550px 미만)</td>
</tr>
<tr>
	<th>유형</th>
	<td><select name="questionType[]" onChange="fnEditOPtion(this)">
			<option value="1">주관식형</option>
			<option value="2">단일 선택형(객관식)</option>
			<option value="3">복수 선택형(객관식)</option>
		</select>
		<input type="checkbox" name="necessary[]" value="Y"> <lable>필수선택</lable>
	</td>
</tr>
<tr>
	<td colspan="2">
		<div class="ui_questionType">
			<textarea readonly disabled></textarea>
			<!-- 
			<input type="hidden" name="op_<?=$temp_hero_idx?>[]" value="" />
			<input type="hidden" name="op_<?=$temp_hero_idx?>[]" value="" />
			<input type="hidden" name="op_<?=$temp_hero_idx?>[]" value="" />
			<input type="hidden" name="op_<?=$temp_hero_idx?>[]" value="" />
			<input type="hidden" name="op_<?=$temp_hero_idx?>[]" value="" />
			<input type="hidden" name="op_<?=$temp_hero_idx?>[]" value="" />
			<input type="hidden" name="op_<?=$temp_hero_idx?>[]" value="" />
			<input type="hidden" name="op_<?=$temp_hero_idx?>[]" value="" />
			<input type="hidden" name="op_<?=$temp_hero_idx?>[]" value="" />
			<input type="hidden" name="op_<?=$temp_hero_idx?>[]" value="" />
			-->
		</div>
	</td>
</tr>
</table>
<? } ?>