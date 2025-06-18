<?
$table = 'goods';
if (! strcmp ( $_GET ['type'], 'edit' )) {
	hero_file ( AKLOVER_PHOTO_INC_END, AKLOVER_PHOTO_END );
	$post_count = @count ( $_POST ['hero_idx'] );

	//echo $post_count;
	for($i = 0; $i < $post_count; $i++) {
		reset ( $_POST );
		unset ( $sql_one_update );
		$idx = $_POST ['hero_idx'] [$i];
		$data_i = '1';
		$count = @count ( $_POST );

		$hero_display_count = count($_POST ['hero_display']);

		while ( list ( $post_key, $post_val ) = each ( $_POST ) ) {
			if (! strcmp ( $post_key, 'hero_idx' )) {
				$data_i ++;
				continue;
			}

			if (! strcmp ( $post_key, 'hero_serial_number' )) {
				//상품번호 확인
			}

			if (! strcmp ( $count, $data_i )) {
				$comma = '';
			} else {
				$comma = ', ';
			}
			if (( strcmp ( $out_hero_file [$idx], '' )) and ( !strcmp ( $post_key, 'hero_image' ))) {
				$img_two = @explode ( '/', $_POST [$post_key] [$i] );
				$img_count = @sizeof ( $img_two ) - 1;
				$last_img = $img_two [$img_count];
				@unlink ( AKLOVER_PHOTO_INC_END . $last_img );
				$_POST [$post_key] [$i] = $out_hero_file [$idx];
			}
			if($post_key=='hero_display' && $post_val[$i]==null){
				$_POST[$post_key][$i]="N";
			}
            if($post_key=='hero_sold_out_quantity' && $post_key == ''){
                $_POST[$post_key][$i] = 0;
            }
			$sql_one_update .= $post_key . '=\'' . $_POST[$post_key][$i] . '\'' . $comma;
			$data_i ++;
		}

		if($hero_display_count == 0) { //한개도 없는 경우  쿼리추가가 안되는 오류가 있어 내용 추가함
			$sql_one_update .= " , hero_display = 'N' ";
		}

		$sql = 'UPDATE ' . $table . ' SET ' . $sql_one_update . ' WHERE hero_idx = \'' . $idx . '\';' . PHP_EOL;

		mysql_query($sql);
		//echo "<br>".$sql;
	}
	// echo '<script>location.href="'.PATH_HOME.'?'.get('type','').'"</script>';
	msg ( '수정 되었습니다.', 'location.href="' . PATH_HOME . '?' . get ( 'type', '' ) . '"' );

	exit ();
} else if (! strcmp ( $_GET ['type'], 'write' )) {
	$sql_one_write = 'hero_display, hero_regdate, hero_old_idx';
	$sql_two_write = "'N','".date('Y-m-d H:i:s')."','".$_GET["hero_old_idx"]."'";
	$sql = 'INSERT INTO ' . $table . ' (' . $sql_one_write . ') VALUES (' . $sql_two_write . ');';
	mysql_query ( $sql );
	// echo '<script>location.href="'.PATH_HOME.'?'.get('type','').'"</script>';
	msg ( '추가 되었습니다.', 'location.href="' . PATH_HOME . '?' . get ( 'type', '' ) . '"' );
	exit ();
} else if (! strcmp ( $_GET ['type'], 'drop' )) {
	$sql = 'select * from ' . $table . ' where hero_idx=\'' . $_GET ['hero_idx'] . '\';'; // desc//asc

	sql ( $sql );
	$drop_list = @mysql_fetch_assoc ( $out_sql );
	if (! strcmp ( $drop_list ['hero_main'], '' )) {
		$sql = 'DELETE FROM ' . $table . ' WHERE hero_idx = \'' . $_GET ['hero_idx'] . '\';';
	} else {
		$img_two = @explode ( '/', $drop_list ['hero_main'] );
		$img_count = @sizeof ( $img_two ) - 1;
		$last_img = $img_two [$img_count];
		@unlink ( AKLOVER_PHOTO_INC_END . $last_img );
		$sql = 'DELETE FROM ' . $table . ' WHERE hero_idx = \'' . $_GET ['hero_idx'] . '\';';
	}
	sql ( $sql );
	msg ( '삭제 되었습니다.', 'location.href="' . PATH_HOME . '?' . get ( 'type||hero_idx', '' ) . '"' );
	exit ();
}
?>

<div id="layer" style="text-align: center; position: absolute; display: none; margin: 0; padding: 0; z-index: 1; border: solid 5px red"></div>
<p style="color:#f00; margin-bottom:10px">*이미지 사이즈 : 224 * 174</p>
<form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data">
<table class="t_list">
<thead>
<tr>
	<th width="5%">선택</th>
	<th width="10%">제품고유번호</th>
    <th width="5%">제품노출순서</th>
    <th width="5%">제품SCM코드</th>
	<th width="10%">제품이미지</th>
	<th width="15%">제품카테고리</th>
	<th width="25%">제품정보</th>
	<th width="8%">구매 포인트</th>
	<th width="8%">재고관리</th>
	<th width="10%">관리</th>
</tr>
</thead>
<tbody>
<?
$sql = " SELECT * FROM " . $table . " where hero_old_idx = '".$_GET["hero_old_idx"]." ' order by hero_order_num ASC,  hero_idx desc "; // desc//asc
$sql = out($sql);
 //echo $sql;
sql ( $sql );
$i = '0';
while ( $roll_list = @mysql_fetch_assoc ( $out_sql ) ) {
    if (! strcmp ( $roll_list ['hero_display'], "Y" )) {
        $hero_checked = ' checked';
    } else {
        $hero_checked = '';
    }
?>
<input type="hidden" name="hero_old_idx[]" value="<?=$_GET["hero_old_idx"]?>" />
<input type="hidden" name="hero_idx[]" value="<?=$roll_list['hero_idx']?>">
<input type="hidden" name="hero_image[]" value="<?=$roll_list['hero_image']?>">
<tr>
	<td><!--선택-->
        <input type="checkbox" name="hero_display[<?=$i?>]" value="Y"<?=$hero_checked;?>>
    </td>
	<td><!--제품고유번호-->
        <input type="text" name="hero_serial_number[<?=$i?>]" value="<?=$roll_list['hero_serial_number']?>">
    </td>
    <td><!--제품노출순서-->
        <input type="text" name="hero_order_num[]" value="<?=$roll_list['hero_order_num']?>" numberOnly style="text-align:center;">
    </td>
    <td><!--제품SCM코드-->
        <input type="text" name="hero_scm[]" value="<?=$roll_list['hero_scm']?>" style="text-align:center;">
    </td>
	<td><!--제품이미지-->
        <?if(strcmp($roll_list['hero_image'],"")){?><img class="group1" src="<?=str($roll_list['hero_image']);?>" alt="" height="71" onclick="hero_layer('layer',this.src);" /><?}?>
        <input type="file" name="hero_file[]">
    </td>
    <td><!--제품카테고리-->
        <select name="hero_cate2[]">
            <option value="BT" <? if($roll_list['hero_cate2'] == 'BT') echo 'selected';?>>뷰티</option>
            <option value="PC" <? if($roll_list['hero_cate2'] == 'PC') echo 'selected';?>>퍼스널케어</option>
            <option value="HC" <? if($roll_list['hero_cate2'] == 'HC') echo 'selected';?>>홈케어</option>
        </select>
    </td>
	<td><!--제품정보-->
        제품명<input type="text" name="hero_name[]" value="<?=$roll_list['hero_name']?>"><br>
        제품 정보<input type="text" name="hero_info[]" value="<?=$roll_list['hero_info']?>"><br>
        제품 정보 페이지 링크<input type="text" name="hero_info_href[]" value="<?=$roll_list['hero_info_href']?>">
    </td>
	<td><!--구매포인트-->
        <input type="text" name="hero_point[]" value="<?=$roll_list['hero_point']?>" numberonly>
    </td>
	<td><!--재고관리-->
        전체 재고<input type="text" name="hero_quantity[]" value="<?=$roll_list['hero_quantity']?>" numberonly><br>
        품절임박 표시 재고<input type="text" name="hero_sold_out_quantity[]" value="<?=$roll_list['hero_sold_out_quantity']?>" numberonly>
    </td>
	<td><!--관리-->
        <a href="javascript:location.href='<?=PATH_HOME.'?'.get('','type=drop&hero_idx='.$roll_list['hero_idx']);?>'" class="btnForm">삭제</a>
    </td>
</tr>
<?
	$i ++;
}
?>
</tbody>
</table>
</form>
<div class="btnGroup">
<a href="javascript:form_next.submit();" class="btnAdd">설정수정</a>
<a href="javascript:location.href='<?=PATH_HOME.'?'.get('','type=write');?>'" class="btnAdd">추가</a>
</div>