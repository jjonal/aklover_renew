<?
// ####################################################################################################################################################
// HERO BOARD ���� (������ : ������)2013�� 08�� 07��
// ####################################################################################################################################################
if (! defined ( '_HEROBOARD_' ))	exit ();
	// ####################################################################################################################################################
if (! strcmp ( $_SESSION ['temp_level'], '' )) {
	$my_level = '0';
	$my_write = '0';
	$my_view = '0';
	$my_update = '0';
	$my_rev = '0';
} else {
	$my_level = $_SESSION ['temp_level'];
	$my_write = $_SESSION ['temp_write'];
	$my_view = $_SESSION ['temp_view'];
	$my_update = $_SESSION ['temp_update'];
	$my_rev = $_SESSION ['temp_rev'];
}

if($_GET["idx"] == "361962") { //2021-12-14 �ӽ÷� ��� ����
	exit;
}

function auto_link_text($text) {
    $pattern = '#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#';
    $callback = create_function('$matches',
        '$url = array_shift($matches); return "<a href=\'$url\'>$url</a>";' );
    return preg_replace_callback($pattern, $callback, $text);
}

// ####################################################################################################################################################
$sql =  ' SELECT * FROM  (SELECT hero_code, hero_depth, hero_idx, hero_use, hero_today, hero_command,hero_depth_idx_old ';
$sql .= ' ,(select case when ifnull(hero_topfix,\'N\') != \'Y\' then \'N\' else \'Y\' end hero_topfix from review where hero_idx = r.hero_depth_idx_old) as hero_topfix ';
$sql .= ' from review r where r.hero_old_idx=\''.$_GET["idx"].'\' ) r ';
$sql .= ' order by hero_topfix desc ,case when hero_topfix = \'Y\' then hero_depth_idx_old end desc ,case when hero_topfix != \'Y\' then hero_depth_idx_old end asc ';
//musign S ������ �������� �ʰ� ���� ������ �ƴ� ���� ��¥ ������� ���� ����
//$sql .= ' ,hero_depth asc,hero_today asc '; // hero_depth_idx_old desc,hero_depth asc
//musign E
$sql .= ' ,hero_today asc '; // hero_depth_idx_old desc,hero_depth asc

// Echo $sql . '</br>';
sql ( $sql, 'on' );
$review_data = @mysql_num_rows ( $out_sql );
?>

<div id="abcd"></div>
<div class="comment_cnt">
	<p class="fz20 fw700">��� <span class="main_c"><?=$review_data?></span></p>
</div>
<div class="commentbox">
	<?
	$check_review_sql = "select * from hero_group where hero_board='" . $_GET ['board'] . "'";
	$out_check_review_sql = mysql_query ( $check_review_sql );
	$check_review_list = @mysql_fetch_assoc ( $out_check_review_sql );
	$check_review_list ['hero_rev'];

	// 2014-03-26 ��ȸ�� �α��ν� ��� �ۼ� �Ұ�
	if ($my_view != "0" && $check_review_list['hero_rev']<=$my_rev) { ?>

		<form id="review_form">
		   	<input type="hidden" name="mode" value="review_write">
		   	<input type="hidden" name="board" value="<?=$_GET['board']?>">
		   	<input type="hidden" name="board_idx" value="<?=$_GET['idx']?>">
		   	<?
		   	if($my_rev == "9999") {?>
		   	<p style="margin:0 0 8px 0; text-align:right;" class="dis-no"><label for="hero_topFix">��� ����</label><input type="checkbox" id="hero_topFix" name="hero_topFix" checked value="Y" /></p>
		   	<? } ?>
		</form>
		<div class="comment_wrap rel textarea_wrap">
			<textarea id="hero_command" name="hero_command" <?if($my_rev != "9999") {?>oncontextmenu="return false" <?}?> class="ment_txt scroll_hide" title="���۳���"></textarea>
			<button onclick="hero_review_submit('review_form', 'hero_command','pc')" class="btn_ment label_button fz15 fw600">��� �ޱ�</button>
		</div>


	<?
	} else { ?>

		<div class="comment_wrap rel textarea_wrap non_log">
			<div class="ment_txt scroll_hide" title="���۳���">����� �ۼ��Ͻ÷��� <a href="/main/index.php?board=login"><span class="main_c">�α���</span></a> ���ּ���.</div>
			<div class="btn_ment label_button fz15 fw600">��� �ޱ�</div>
		</div>

	<? }



	$review_i = $review_data - 1;
	$p_i = "0";

	while ( $review_row = @mysql_fetch_assoc ( $out_sql ) ) {

		if (! strcmp ( $review_i, '0' )) 	$last_class = 'last';
		else 								$last_class = '';

		$pk_sql = 'select a.hero_level,a.hero_nick,b.hero_img_new from member as a, level as b  where b.hero_level = a.hero_level and a.hero_code = \'' . $review_row ['hero_code'] . '\'';
//		echo $pk_sql;
		$out_pk_sql = mysql_query ( $pk_sql );
		$pk_row = @mysql_fetch_assoc ( $out_pk_sql );

		if (! strcmp ( $review_row ['hero_depth'], '0' )) {
			$temp_check_count_i = 0;
			$check_sql = 'select * from review where hero_depth_idx_old= \'' . $review_row ['hero_idx'] . '\'';
//            echo $check_sql;
			$out_check_sql = mysql_query ( $check_sql );
			$check_count = @mysql_num_rows ( $out_check_sql );
		}

		$temp_check_count = $check_count - $temp_check_count_i;



		if(strcmp ( $review_row ['hero_depth'], '0' ))														        $class = "rpment ";

		if(strcmp ( $review_row ['hero_depth'], '0' ) && !strcmp (  $temp_check_count, '1' )) 				$class .= "depth2_last ";

		if(!strcmp ( $review_row ['hero_depth'], '1' ) and !strcmp ( $temp_check_count, '1' ))	 			$class .= "last ";

		if(!strcmp($review_row['hero_depth'], '0') and strcmp($check_count, '1') )							$class .= "rp ";

        $commandArray = explode('SS$$SS', $review_row['hero_command']);
        if($commandArray[1]) {
            $parentName = $commandArray[1];
            $review_row['hero_command'] = $commandArray[2];
        }
        else{
            $parentName = '';
            $review_row['hero_command'] = $commandArray[0];
        }
	?>


	    <div class="<?=$class.$last_class?> clearfix replybx ">
			<div class="txt_id fz16 fw700 rel">
				<?=$pk_row['hero_nick']?>
					<?
					if ($my_rev >= '9999' || ! strcmp ( $review_row ['hero_code'], $_SESSION ['temp_code'] )) {
                    ?>
					<div class="editbox">
						<div class="rel editinner">
							<ul>
								<li onclick="javascript:check_review_edit(<?=$p_i?>);">����</li>
								<li>
									<a herf="javascript:;" onClick="check_review_del('<?=$review_row['hero_idx']?>')">����</a>
								</li>
							</ul>
						</div>
					</div>
						<?
					}
					?>
			</div>
			<div>
				<ul>
					<?
						if (strcmp ( $review_row ['hero_use'], '1' )) {
					?>
						<li class="review_command fz16"
							<?php
							//170405 ũ�� ������� ����
							if(strlen(nl2br($review_row['hero_command'])) != strlen($review_row['hero_command'])){
								echo " style='word-break: break-all; white-space:pre-line; ' ";
							}
							// 160601 white-space:pre ����� ũ�ҿ��� ���� ����� �� ����������, �������� ����ó���� �ȵ�
							/*if(strlen(nl2br($review_row['hero_command'])) != strlen($review_row['hero_command'])){
								echo " style='word-wrap: break-word; word-break: break-all; white-space: -moz-pre-wrap; white-space: -pre-wrap; white-space: -o-pre-wrap;' ";
							}else{
							}*/
							?>
                            >
                            <?if($parentName != ''){?>
                                <!-- ���� �Է½� ����� �ۼ����� �г��� ���� ����  -->
                                <b class="bold" style="color: #FF4C05"><?='@'.$parentName?></b>
                                <!-- //���� �Է½� ����� �ۼ����� �г��� ���� ����  -->
                            <?}?>
                            <?=auto_link_text(htmlspecialchars_decode(htmlspecialchars($review_row['hero_command'],ENT_COMPAT,"ISO-8859-1")))?>
						</li>
					<?}else{?>
						������ �� �Դϴ�.
					<?}?>
	                <li class="gray">
						<span class="txt_date fz14 fw500 gray"><?=date( "Y.m.d H:i", strtotime($review_row['hero_today']))//.$review_row['hero_depth'];?></span>
						<?
						if ($_SESSION ['temp_view'] != "0" && $check_review_list['hero_rev']<=$my_rev) {
							?>
							<div onclick="javascript:check_review_all(<?=$p_i?>);" class="btngrp">���</div>
							<?
						}
						?>
					</li>
					<li class="rel">
						<div class="review_area" style="display: none;">
							<form id="review_form_<?=$p_i?>">
								<input type="hidden" class="review_mode" name="mode" value="review_write">
								<input type="hidden" name="board" value="<?=$_GET['board']?>">
								<input type="hidden" name="board_idx" value="<?=$_GET['idx']?>">
								<input type="hidden" name="depth_idx" value="<?=$review_row['hero_idx']?>">
								<input type="hidden" name="depth_idx_old" value="<?=$review_row['hero_depth_idx_old']?>">
								<div class="textarea_wrap rel">
									<textarea id="hero_command_<?=$p_i?>" name="hero_command" <?if($my_rev != "9999") {?>oncontextmenu="return false" <?}?> class="ment_txt scroll_hide" title="���۳���"></textarea>
									<button type='button' onclick="javascript:hero_review_submit('review_form_<?=$p_i?>','hero_command_<?=$p_i?>','pc')" class="btn_ment label_button fz15 fw600" title="���۴ޱ�">��� �ޱ�</button>
								</div>
							</form>
						</div>
					</li>
	          	</ul>
			</div>
		</div>

<?
		$class='';
		$temp_check_count_i ++;
		$review_i --;
		$p_i ++;
	}
?>

</div>

<script>
//���
function check_review_all(no){
	$(".review_mode").eq(no).val("review_write");
    // musign �ּ� S - ��� Ŭ���� textarea�� �˸°� �������� �ʾƼ� ���� 240909 ydh
	// console.log( $(this) );
    // $(".review_area").each(function(idx) {
    // 	$(".review_area").hide();
	// 	$(".review_area").eq(idx).show();
    // });
    //musign �ּ� E
    $("#hero_command_"+no).val('');
    $(".review_area").eq(no).toggle();
    return false;
}
//��� ����
function check_review_edit(no){
    let review_command = $.trim($(".review_command").eq(no).html());
    // �����϶� �г��� ����
    if(review_command.indexOf('���� �Է½� ����� �ۼ����� �г��� ���� ����') == 5){
        review_command = review_command.substring(244)
    }
    //Ư������ ��ƼƼ ó��
    review_command = unescapeHtml(review_command);

    $("#hero_command_"+no).val(review_command);

	$(".review_mode").eq(no).val("review_edit");

	$(".review_area").each(function(idx) {
    	$(".review_area").eq(idx).hide('fast');
    });
    $(".review_area").eq(no).toggle();

	return false;
}

function check_review_del(idx, idx_old){

	if(confirm("�����Ͻðڽ��ϱ�?")==true)	hero_review_del(idx,"pc");
	else								return false;

}
//musign S HTML ���ڿ� �̽������� ó��
// �������� ���� ��ƼƼ ��
var reverseEntityMap = {
    '&amp;': '&',
    '&lt;': '<',
    '&gt;': '>',
    '&quot;': '"',
    '&#39;': "'",
    '&#x2F;': '/',
    '&#x60;': '`',
    '&#x3D;': '='
};
// �̽��������� HTML�� ���� ���ڿ��� �ǵ����� �Լ�
function unescapeHtml(string) {
    // ���Խ��� ����Ͽ� ��� ��ƼƼ�� ã�� ������
    return String(string).replace(/&amp;|&lt;|&gt;|&quot;|&#39;|&#x2F;|&#x60;|&#x3D;/g, function (s) {
        return reverseEntityMap[s];
    });
}
//musign E HTML ���ڿ� �̽������� ó��
$(document).ready(function(){
	const editbtn = $('.editbox');
	$.each(editbtn, function(){
		$(this).click(function(){
			$(this).find('.editinner').toggleClass('on');
		});
	});
});
</script>