<?
if(!defined('_HEROBOARD_'))exit;

if($_POST["mode"]){
	$mode				= $_POST["mode"];
	$hero_old_idx		= $_POST["hero_old_idx"];
	$startDate			= $_POST["startDate"];
	$endDate			= $_POST["endDate"];
	$coreMember			= $_POST["coreMember"] == "" ? "N" : "Y";
	$adminSelectJoin	= $_POST["adminSelectJoin"] == "" ? "N" : "Y";
	$group_num			= $_POST["group_num"];


	if($adminSelectJoin != "Y") {
        //20240318 musign S group_num = ''�� �Ǹ� ������Ʈ ������ ������ �ȵ� �ӽ� �ּ�
		//$group_num = "";
        //20240318 musign E
	}


	if($mode=="modify"){
		//$arrStart = explode("-", $startDate);
		//$startDate = mktime(0, 0, 0, $arrStart[1], $arrStart[2], $arrStart[0]);
		$startDate = strtotime($startDate);
		//$arrEnd = explode("-", $endDate);
		//$endDate = mktime(23, 59, 59, $arrEnd[1], $arrEnd[2], $arrEnd[0]);
		$endDate = strtotime($endDate);
		$sql = "select idx from order_period";
		$res = mysql_query($sql) or die(mysql_error());
		$rs = mysql_fetch_array($res);

		if($rs["idx"]){
			$update =  " update order_period set hero_old_idx = ".$hero_old_idx." ,startDate=".$startDate.", endDate=".$endDate.", coreMember='".$coreMember."' ";
			$update .= " , adminSelectJoin = '".$adminSelectJoin."' , group_num = '".$group_num."' ";
			$update .= " where idx=".$rs["idx"];
			mysql_query($update) or die(mysql_error());
		}else{
			$insert = "insert into order_period(hero_old_idx, startDate, endDate, coreMember,adminSelectJoin, group_num) values(".$hero_old_idx.",".$startDate.", ".$endDate.", '".$coreMember."', '".$adminSelectJoin."', '".$group_num."')";
			mysql_query($insert) or die(mysql_error());
		}

		msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type','').'"');
		exit;
	}else if($mode=="del"){
		mysql_query("delete from order_period") or die(mysql_error());

		msg('�Ⱓ�� �����߽��ϴ�.','location.href="'.PATH_HOME.'?'.get('type','').'"');
		exit;
	}
}

$sql = "select * from order_period";
$sql = out($sql);
sql($sql);
$rs = @mysql_fetch_assoc($out_sql);
if($rs["idx"]){
	$hero_old_idx = $rs["hero_old_idx"];
	$startDate = date("Y-m-d H:i",$rs["startDate"]);
	$endDate = date("Y-m-d H:i",$rs["endDate"]);
	$coreMember = $rs["coreMember"];
	$adminSelectJoin = $rs["adminSelectJoin"];
	$group_num = $rs["group_num"];
}else{
	$startDate = "";
	$endDate = "";
}

//��ǰ������
$goods_sql = " SELECT hero_idx, hero_title FROM goods_manager WHERE hero_use = 0 ORDER BY hero_idx DESC ";
$goods_out_sql = mysql_query($goods_sql);
?>
<!--<link rel="stylesheet" href="//cdn.rawgit.com/xdan/datetimepicker/master/jquery.datetimepicker.css">-->
<!--<script src="//cdn.rawgit.com/xdan/datetimepicker/master/jquery.datetimepicker.js"></script>-->
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>

<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/daterangepicker.css" />
<script src="<?=ADMIN_DEFAULT?>/js/moment.min.js"></script>
<script src="<?=ADMIN_DEFAULT?>/js/jquery.daterangepicker.js"></script>
<script>



function goNext(){
	var form = document.frm;

	if(form.hero_old_idx.value==""){
		alert("��ǰ�������� ������ �ּ���.");
		return false;
	}

	if(form.startDate.value==""){
		alert("�������� �Է��ϼ���");
		return false;
	}

	if(form.endDate.value==""){
		alert("�������� �Է��ϼ���");
		return false;
	}

	if($(":checkbox[name='adminSelectJoin']").is(":checked")) {
		if($("input[name='group_num']").val() < 1) {
			alert("������ ���� �׷� ��ȣ�� �Է��� �ּ���.");
			$("input[name='group_num']").focus();
			return;
		}
	}

	form.mode.value = "modify";
	form.submit();
}

function noPeriod(){
	if(confirm("������ �Ⱓ�� ���� �Ͻðڽ��ϱ�?")){
		var form = document.frm;
		form.mode.value = "del";
		form.submit();
	}
}
</script>
<div class="view_title_box">
	<p><label>1.�ξ�ȸ��</label> : �ξ�ȸ�� �׸� ���� �� ȸ������� [loyal AK LOVER]�̰� ȸ������Ʈ 300p �̻� �̿� ����</p>	
	<p><label>2.������ ȸ�� ���� ����</label><br/>
		- �����ڰ� ������ ȸ�������� [pointMallTempMember] ���̺�(��ҹ��� üũ)�� �������� ����Ͽ� ������ ���� �׷� ��ȣ�� ����<br/>
		- ��ϵ� �����ʹ� ������ ȸ�� ���� �޴����� Ȯ�� ����<br/>
		- ����Ʈ, ������ ���� �̿������� ����.<br/>
	</p>
	<p><label>3.������, �����ϸ� ����</label><br/>
	- AK LOVER ȸ�� ����
	</p>
	<p><label>4.������ �������</label><br/>
	- �Ϲ�ȸ�� ����Ʈ ���� (����) :  ��ǰ������, �Ⱓ 2������ �����մϴ�.<br/>
	- ������ ���� ȸ���� -> ȸ�� �׷� ����(������) : ��ǰ������, �Ⱓ, ������ ȸ�����ÿ���(üũ��), ������ ���ñ׷��ȣ(������ȣ) 4���� ��� �����մϴ�.
	</p>
</div>

<form name="frm" method="post" action="<?=$_SERVER["REQUEST_URI"]?>">
<input type="hidden" name="mode" value="">
<table class="t_view">
<colgroup>
	<col width="150px">
	<col width="*">
</colgroup>
<tr>
	<th>��ǰ������</th>
	<td>
		<select name="hero_old_idx" style="width:100%;">
			<option value="">�������ּ���.</option>
			<? while ($row = @mysql_fetch_assoc($goods_out_sql)){ ?>
				<option value="<?=$row["hero_idx"]?>" <?=$hero_old_idx == $row["hero_idx"] ? "selected":""?>><?=$row["hero_title"]?></option>
			<? } ?>
		</select>
		<p class="txt_emphasis mgt10">* ����Ʈ ���� ���� �� ���ο� ��ǰ�������� ����ؼ� �̿��� �ּ���. ������ �̿��� ��ǰ������ ��� �� ������ ��ǰ�� ��ҵ� �� �ֽ��ϴ�.</p>
	</td>
</tr>
<tr>
	<th>�Ⱓ</th>
	<td><input style="width:120px" name="startDate" id="startDate" value="<?=$startDate?>" type="text" class="input10" readonly>
		~ <input style="width:120px;" name="endDate" id="endDate" value="<?=$endDate?>" type="text" class="input10" readonly>
	</td>
</tr>
<tr>
	<th>������ ȸ������ ����</th>
	<td><input type="checkbox" name="adminSelectJoin" value="Y" <? if($adminSelectJoin=="Y"){?> checked <? }?>/></td>
</tr>
<tr>
	<th>������ ���� �׷� ��ȣ</th>
	<td><input type="text" name="group_num" style="width:40px;" numberOnly maxlength="2" value="<?=$group_num?>"/></td>
</tr>
</table>
<div class="btnGroup">
	<a href="javascript:goNext();" class="btnAdd">����</a>
	<a href="javascript:noPeriod();" class="btnAdd">�Ⱓ����(clear)</a>
</div>
</form>

<script>
$(function(){
	$("#startDate").AnyTime_picker( {
    format: "%Y-%m-%d %H:%i:00"
 	}); 
	$("#endDate").AnyTime_picker( {
    format: "%Y-%m-%d %H:%i:00"
 	});  
});
/*$(function(){
  $('#startDate').datetimepicker({
	  lang:'ko',
	  format:'Y-m-d H:i'
  });
  $('#endDate').datetimepicker({
	  lang:'ko',
	  format:'Y-m-d H:i'
  });  
});*/
</script>