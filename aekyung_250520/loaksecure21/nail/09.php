<?
######################################################################################################################################################
//HERO BOARD ���� (������ : ������)2020�� 04�� 09��
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$gisu = !$_REQUEST["gisu"] ? "1":$_REQUEST["gisu"];

$sql_gisu = " SELECT hero_youtube_gisu FROM mission_gisu "; //���� ���
sql($sql_gisu);
$rs_gisu = mysql_fetch_assoc($out_sql);

$gisu = !$_REQUEST["gisu"] ? $rs_gisu["hero_youtube_gisu"]:$_REQUEST["gisu"];
$hero_use = $_REQUEST["hero_use"];
$hero_chk_phone = $_REQUEST["hero_chk_phone"];
$hero_chk_email = $_REQUEST["hero_chk_email"];

if(strlen($hero_use) > 0) $where .= " AND m.hero_use = '".$hero_use."' ";
if(strlen($hero_chk_phone) > 0) {
	if($hero_chk_phone == "1") {
		$where .= " AND m.hero_chk_phone = '".$hero_chk_phone."' ";
	} else {
		$where .= " AND m.hero_chk_phone != '1' ";
	}
} 
if(strlen($hero_chk_email) > 0) {
	if($hero_chk_email == "1") {
		$where .= " AND m.hero_chk_email = '".$hero_chk_email."' ";
	} else {
		$where .= " AND m.hero_chk_email != '1' ";
	}
}
	
$list_sql  =  " SELECT g.gisu ,g.hero_code , g.hero_id, g.hero_nick , m.hero_use, m.hero_name ";
$list_sql .=  " , case when m.hero_chk_phone = 1 then '����' else '�̵���' end as hero_chk_phone_name ";
$list_sql .=  " , case when m.hero_chk_email = 1 then '����' else '�̵���' end as hero_chk_email_name ";
$list_sql .=  " FROM member_gisu g LEFT JOIN member m ON g.hero_code = m.hero_code  ";
$list_sql .=  " WHERE g.gisu = '".$gisu."' AND g.hero_board = 'group_04_27' ".$where;

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
	$('#form0').attr('action','nail/excel_09.php').submit();

	return;
}

function excelAll() {
	$('#form0 #mode').val("excelAll");
	$('#form0').attr('action','nail/excel_09_all.php').submit();

	return;
}

function fnSeach() {
	$('#form0 #mode').val("");
	$("#form0").attr("action","").submit();
}
</script>
<form name="form0" id="form0" method="post" enctype="multipart/form-data">
<div>
<input type="hidden" name="mode" id="mode" />
<input type="hidden" name="hero_id" id="hero_id" value="<?=$_SESSION["temp_id"]?>" />
<table class="tbForm" style="margin:0 auto;">
	<colgroup>
	<col width="120px" />
	<col width="300px" />
	<col width="120px" />
	<col width="300px" />
	</colgroup>
	<tr>
		<th><label>��Ʃ�� ���</label></th>
		<td>
			<select name="gisu">
				<? for($k=$rs_gisu["hero_youtube_gisu"]; $k>0; $k--) {?>
				<option value="<?=$k?>" <?=$k==$gisu ? "selected":"";?>><?=$k?></option>
				<? } ?>
			</select>
		</td>
		<th><label>ȸ������</label></th>
		<td><input type="radio" name="hero_use" id="hero_use_all" value="" style="margin-left:10px;" <?=!$hero_use ? "checked":"";?>/>
			<label for="hero_use_all" style="margin-left:5px;">��ü</label>
		
			<input type="radio" name="hero_use" id="hero_use_0" value="0" style="margin-left:10px;" <?=$hero_use=="0" ? "checked":"";?>/>
			<label for="hero_use_0" style="margin-left:5px;">ȸ��</label>
			
			<input type="radio" name="hero_use" id="hero_use_2" value="2" style="margin-left:10px;" <?=$hero_use=="2" ? "checked":"";?>/>
			<label for="hero_use_2" style="margin-left:5px;">�޸�ȸ��</label>
			
			<input type="radio" name="hero_use" id="hero_use_1" value="1" style="margin-left:10px;" <?=$hero_use=="1" ? "checked":"";?>/>
			<label for="hero_use_1" style="margin-left:5px;">Ż��</label>
		</td>
	</tr>
	<tr>
		<th><label>SMS���ŵ���</label></th>
		<td>
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_all" value="" style="margin-left:10px;" <?=!$hero_chk_phone ? "checked":"";?>/>
			<label for="hero_chk_phone_all" style="margin-left:5px;">��ü</label>
			
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_1" value="1" style="margin-left:10px;" <?=$hero_chk_phone == "1" ? "checked":"";?>/>
			<label for="hero_chk_phone_1" style="margin-left:5px;">����</label>
			
			<input type="radio" name="hero_chk_phone" id="hero_chk_phone_2" value="2" style="margin-left:10px;" <?=$hero_chk_phone == "2" ? "checked":"";?>/>
			<label for="hero_chk_phone_2" style="margin-left:5px;">�̵���</label>
		</td>
		<th><label>�̸��ϼ��ŵ���</label></th>
		<td>
			<input type="radio" name="hero_chk_email" id="hero_chk_email_all" value="" style="margin-left:10px;" <?=!$hero_chk_email ? "checked":"";?>/>
			<label for="hero_chk_email_all" style="margin-left:5px;">��ü</label>
			
			<input type="radio" name="hero_chk_email" id="hero_chk_email_1" value="1" style="margin-left:10px;" <?=$hero_chk_email == "1" ? "checked":"";?>/>
			<label for="hero_chk_email_1" style="margin-left:5px;">����</label>
			
			<input type="radio" name="hero_chk_email" id="hero_chk_email_2" value="2" style="margin-left:10px;" <?=$hero_chk_email == "2" ? "checked":"";?>/>
			<label for="hero_chk_email_2" style="margin-left:5px;">�̵���</label>
		</td>
	</tr>
</table>

	<div style="margin:20px 0 0 0; text-align:center;">
		<a href="#" onClick="fnSeach();"><img src="../image/bbs/btn_search.gif" class="bd0"></a>
	</div>
</div>
</form>

<div style="text-align:right">
	<a href="javascript:;" onclick="excel()" class="btn_blue2">�����ٿ�ε�</a>
	<a href="javascript:;" onclick="excelAll()" class="btn_blue2">���� ��ü���</a>
</div>

<div style="margin:30px 0 0 0;">
	<table class="tbForm" style="width:100%; margin:20px 0 0 0;">
		<colgroup>
			<col width="6%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="*" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
		</colgroup>
		<tr>
			<th>��ȣ</th>
			<th>������ȣ</th>
			<th>���̵�</th>
			<th>�̸�</th>
			<th>�г���</th>
			<th>���</th>
			<th>ȸ������</th>
			<th>SMS���ŵ���</th>
			<th>�̸��ϼ��ŵ���</th>
		</tr>
		<? 
			$i=1;
			$member_status = array("0"=>"ȸ��","1"=>"Ż��","2"=>"�޸�ȸ��");
			
			$count = mysql_num_rows($out_sql);
			
			if($count > 0) {
				while($list = @mysql_fetch_assoc($out_sql)){ 
		?>
				<tr>
					<td class="c"><?=$i?></td>
					<td class="c"><?=$list["hero_code"];?></td>
					<td class="c"><?=$list["hero_id"];?></td>
					<td class="c"><?=$list["hero_name"];?></td>
					<td class="c"><?=$list["hero_nick"];?></td>
					<td class="c"><?=$list["gisu"];?></td>
					<td class="c"><?=$member_status[$list["hero_use"]];?></td>
					<td class="c"><?=$list["hero_chk_phone_name"];?></td>
					<td class="c"><?=$list["hero_chk_email_name"];?></td>
				</tr>
		<? 
				$i++;
				}
			} else {
		?>
			<tr>
					<td class="c" colspan="9">��ϵ� �����Ͱ� �����ϴ�.</td>
			</tr>	
		<? } ?>
	</table>
	
	 <div style="width:100%; text-align:center; margin-top:20px;">
		<? include_once PATH_INC_END.'page.php';?>
     </div>
</div>
	

                        