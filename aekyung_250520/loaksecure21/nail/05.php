<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2018�� 11�� 22��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$club_type = !$_REQUEST["club_type"] ? "9996":$_REQUEST["club_type"];

$search_next = "&club_type=".$club_type;

$list_sql_cnt  = " SELECT count(*) FROM mission_winner_list w INNER JOIN member m ON w.hero_nick = m.hero_nick AND w.hero_name = m.hero_name ";
$list_sql_cnt .= "  WHERE m.hero_use = 0 AND w.level = '".$club_type."' ";
sql($list_sql_cnt);
$total_data = mysql_result($out_sql,0,0);

$list_page=20;
$page_per_list=5;

$i=$total_data;

///////////////////////////////no �� ���� 201400508
if(!strcmp($_GET['page'], '') || !strcmp($_GET['page'], '1')){$page = '1';
}else{
	$page = $_GET['page'];
	$i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board'].$search_next.'&idx='.$_GET['idx'];

$list_sql  =  " SELECT m.hero_nick, m.hero_name, m.hero_hp, m.hero_use, w.level ";
$list_sql .=  " FROM mission_winner_list w INNER JOIN member m ON w.hero_nick = m.hero_nick AND w.hero_name = m.hero_name ";
$list_sql .=  " WHERE m.hero_use = 0 AND w.level = '".$club_type."' ";
$list_sql .=  " ORDER BY m.hero_name ASC LIMIT ".$start.",".$list_page;
$out_sql = mysql_query($list_sql);

?>
<style>
.tbForm th{background:#eee; border:1px solid #cdcdcd; height:30px;}
.tbForm td{border:1px solid #cdcdcd; height:30px; padding:0 10px;}
.tbForm td input[type="text"]{width:100%;}
.tbForm td.c{text-align:center;}
</style>
<script>
function excel() {
	$('#form0 #mode').val("excel");
	$('#form0').attr('action','nail/excel_05.php').submit();
	$('#form0').attr('action', '<?=PATH_HOME.'?'.get('page');?>');
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
		<th><label>��Ƽ/�ֽ�Ŭ��</label></th>
		<td><label for="club_type_9996">��Ƽ&nbsp;</label><input type="radio" name="club_type" id="club_type_9996" value="9996" <?=$club_type=="9996" ? "checked":""?> />
		   &nbsp;&nbsp;&nbsp;
		    <label for="club_type_9997">�ֽ�&nbsp;</label><input type="radio" name="club_type" id="club_type_9997" value="9997" <?=$club_type=="9997" ? "checked":""?>/>
		</td>
	</tr>
</table>

	<div style="margin:20px 0 0 0; text-align:center;">
	<input type="image" src="../image/bbs/btn_search.gif" alt="�˻�" class="bd0">
	</div>
</div>
</form>

<div style="margin:30px 0 0 0;">
	<h2 style="font-size:18px;">��Ƽ/Ŭ�� ��÷�� ���� <a href="javascript:;" onclick="excel()" class="btn_blue2">�����ٿ�ε�</a></h2>
	<p style="color:#f00;">�� ���� ��� ����Ʈ�� �����޾� ���ε��� �ڷ� + ���ڼ��ŵ����� ȸ���� �ƴ�</p>
	<table class="tbForm" style="width:100%; margin:20px 0 0 0;">
		<colgroup>
			<col width="12%" />
			<col width="13%" />
			<col width="25" />
			<col width="25%" />
			<col width="25%" />
		</colgroup>
		<tr>
			<th>��ȣ</th>
			<th>��Ƽ/�ֽ�</th>
			<th>�̸�</th>
			<th>�޴�����ȣ</th>
			<th>�г���</th>
		</tr>
		<? 
			while($list = @mysql_fetch_assoc($out_sql)){ 
			$str_level = "��ƼŬ��";
			if($list["level"] == "9997") $str_level = "�ֽ�Ŭ��";
		?>
			<tr>
				<td class="c"><?=$i?></td>
				<td class="c"><?=$str_level;?></td>
				<td class="c"><?=$list["hero_name"];?></td>
				<td class="c"><?=$list["hero_hp"];?></td>
				<td class="c"><?=$list["hero_nick"];?></td>
			</tr>
		<? 
			$i--;
			}
		?>
	</table>
	
	 <div style="width:100%; text-align:center; margin-top:20px;">
		<? include_once PATH_INC_END.'page.php';?>
     </div>
</div>
	

                        