<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2018�� 11�� 22��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

$hero_old_idx = $_GET["hero_old_idx"];

?>
<style>
.tbForm th{background:#eee; border:1px solid #cdcdcd; height:30px;}
.tbForm td{border:1px solid #cdcdcd; height:30px; padding:0 10px;}
.tbForm td input[type="text"]{width:100%;}
.tbForm td.c{text-align:center;}
</style>


<?php 

	$list_sql =  " SELECT hero_id, hero_title, hero_name, hero_nick, hero_point, hero_today FROM point  ";
	$list_sql .= " WHERE hero_old_idx = '".$hero_old_idx."' AND hero_type='mission_excel' "; 
	$list_sql .= " ORDER BY hero_idx ASC ";
	
	$out_sql = mysql_query($list_sql);	
?>
<form id="searchForm" name="searchForm" method="get" >
<input type="hidden" name="hero_old_idx" value="<?=$_GET["hero_old_idx"]?>" />
</form>
<div style="margin:30px 0 0 0;">
	<h2 style="font-size:18px;">ü��� ����Ʈ ���� ����</h2>
	<div class="btnGroupR">
		 <a href="javascript:;" onclick="excel()" class="btn_blue2">�����ٿ�ε�</a>
	</div>
	<table class="tbForm" style="width:100%; margin:20px 0 0 0;">
		<colgroup>
			<col width="15%" />
			<col width="*" />
			<col width="15%" />
			<col width="15%" />
			<col width="15%" />
			<col width="15%" />
		</colgroup>
		<tr>
			<th>������</th>
			<th>ü��� ��</th>
			<th>���̵�</th>
			<th>�̸�</th>
			<th>�г���</th>
			<th>����Ʈ</th>
		</tr>
		<? while($list = @mysql_fetch_assoc($out_sql)){ ?>
		<tr>
			<td class="c"><?=$list["hero_today"];?></td>
			<td><?=$list["hero_title"];?></td>
			<td class="c"><?=$list["hero_id"];?></td>
			<td class="c"><?=$list["hero_name"];?></td>
			<td class="c"><?=$list["hero_nick"];?></td>
			<td class="c"><?=$list["hero_point"];?>P</td>
		</tr>
		<? } ?>
	</table>
</div>

<div style="text-align:right; margin:20px 0 0 0;"><a href="<?=ADMIN_DEFAULT?>/index.php?board=nail&idx=91" class="btn_blue2">���</a></div>
<script>
function excel() {
	$('#searchForm').attr('action','nail/excel_04_01.php').submit();
	$('#searchForm').attr('action', '<?=PATH_HOME.'?'.get('page');?>');
}
</script>
	

                        