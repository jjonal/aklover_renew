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
				//��ǰ��ȣ Ȯ��
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

		if($hero_display_count == 0) { //�Ѱ��� ���� ���  �����߰��� �ȵǴ� ������ �־� ���� �߰���
			$sql_one_update .= " , hero_display = 'N' ";
		}

		$sql = 'UPDATE ' . $table . ' SET ' . $sql_one_update . ' WHERE hero_idx = \'' . $idx . '\';' . PHP_EOL;

		mysql_query($sql);
		//echo "<br>".$sql;
	}
	// echo '<script>location.href="'.PATH_HOME.'?'.get('type','').'"</script>';
	msg ( '���� �Ǿ����ϴ�.', 'location.href="' . PATH_HOME . '?' . get ( 'type', '' ) . '"' );

	exit ();
} else if (! strcmp ( $_GET ['type'], 'write' )) {
	$sql_one_write = 'hero_display, hero_regdate, hero_old_idx';
	$sql_two_write = "'N','".date('Y-m-d H:i:s')."','".$_GET["hero_old_idx"]."'";
	$sql = 'INSERT INTO ' . $table . ' (' . $sql_one_write . ') VALUES (' . $sql_two_write . ');';
	mysql_query ( $sql );
	// echo '<script>location.href="'.PATH_HOME.'?'.get('type','').'"</script>';
	msg ( '�߰� �Ǿ����ϴ�.', 'location.href="' . PATH_HOME . '?' . get ( 'type', '' ) . '"' );
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
	msg ( '���� �Ǿ����ϴ�.', 'location.href="' . PATH_HOME . '?' . get ( 'type||hero_idx', '' ) . '"' );
	exit ();
}
?>

<div id="layer" style="text-align: center; position: absolute; display: none; margin: 0; padding: 0; z-index: 1; border: solid 5px red"></div>
<p style="color:#f00; margin-bottom:10px">*�̹��� ������ : 224 * 174</p>
<form name="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post" enctype="multipart/form-data">
<table class="t_list">
<thead>
<tr>
	<th width="5%">����</th>
	<th width="10%">��ǰ������ȣ</th>
    <th width="5%">��ǰ�������</th>
    <th width="5%">��ǰSCM�ڵ�</th>
	<th width="10%">��ǰ�̹���</th>
	<th width="15%">��ǰī�װ�</th>
	<th width="25%">��ǰ����</th>
	<th width="8%">���� ����Ʈ</th>
	<th width="8%">������</th>
	<th width="10%">����</th>
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
	<td><!--����-->
        <input type="checkbox" name="hero_display[<?=$i?>]" value="Y"<?=$hero_checked;?>>
    </td>
	<td><!--��ǰ������ȣ-->
        <input type="text" name="hero_serial_number[<?=$i?>]" value="<?=$roll_list['hero_serial_number']?>">
    </td>
    <td><!--��ǰ�������-->
        <input type="text" name="hero_order_num[]" value="<?=$roll_list['hero_order_num']?>" numberOnly style="text-align:center;">
    </td>
    <td><!--��ǰSCM�ڵ�-->
        <input type="text" name="hero_scm[]" value="<?=$roll_list['hero_scm']?>" style="text-align:center;">
    </td>
	<td><!--��ǰ�̹���-->
        <?if(strcmp($roll_list['hero_image'],"")){?><img class="group1" src="<?=str($roll_list['hero_image']);?>" alt="" height="71" onclick="hero_layer('layer',this.src);" /><?}?>
        <input type="file" name="hero_file[]">
    </td>
    <td><!--��ǰī�װ�-->
        <select name="hero_cate2[]">
            <option value="BT" <? if($roll_list['hero_cate2'] == 'BT') echo 'selected';?>>��Ƽ</option>
            <option value="PC" <? if($roll_list['hero_cate2'] == 'PC') echo 'selected';?>>�۽����ɾ�</option>
            <option value="HC" <? if($roll_list['hero_cate2'] == 'HC') echo 'selected';?>>Ȩ�ɾ�</option>
        </select>
    </td>
	<td><!--��ǰ����-->
        ��ǰ��<input type="text" name="hero_name[]" value="<?=$roll_list['hero_name']?>"><br>
        ��ǰ ����<input type="text" name="hero_info[]" value="<?=$roll_list['hero_info']?>"><br>
        ��ǰ ���� ������ ��ũ<input type="text" name="hero_info_href[]" value="<?=$roll_list['hero_info_href']?>">
    </td>
	<td><!--��������Ʈ-->
        <input type="text" name="hero_point[]" value="<?=$roll_list['hero_point']?>" numberonly>
    </td>
	<td><!--������-->
        ��ü ���<input type="text" name="hero_quantity[]" value="<?=$roll_list['hero_quantity']?>" numberonly><br>
        ǰ���ӹ� ǥ�� ���<input type="text" name="hero_sold_out_quantity[]" value="<?=$roll_list['hero_sold_out_quantity']?>" numberonly>
    </td>
	<td><!--����-->
        <a href="javascript:location.href='<?=PATH_HOME.'?'.get('','type=drop&hero_idx='.$roll_list['hero_idx']);?>'" class="btnForm">����</a>
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
<a href="javascript:form_next.submit();" class="btnAdd">��������</a>
<a href="javascript:location.href='<?=PATH_HOME.'?'.get('','type=write');?>'" class="btnAdd">�߰�</a>
</div>