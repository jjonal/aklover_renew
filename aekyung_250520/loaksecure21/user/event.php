<?
if(!defined('_HEROBOARD_'))exit;
?>

<!-- 
<p class="tit_section mgt10">9���� �̷α��� �̺�Ʈ</p>
<div class="view_title_box mgt10">
	<p><label>�߼۽���</label> : �ſ� 5�� 2�� </p>
	<p><label>���</label> : ���� �߼۽����� ������ �α��� �� ��¥�� 10����~9���� ������¥ �Ⱓ�� ���ԵǾ� �ִ� ȸ���̰� �̸��� ���ſ��� üũ�� ȸ������ 9���� �̺�Ʈ ���� �߼��� </p>
	<p><label>����</label> : ����� �� �ش�� 5��~��������¥ �Ⱓ���� �α��� �� 100����Ʈ ����</p>
</div>
<form name="frm" id="frm1">
<input type="hidden" name="type" value="9month" >
<table class="t_list">
<colgroup>
	<col width="20%" />
	<col width="*" />
</colgroup>
<thead>
<tr>
	<th>�̹���</th>
	<th>����</th>
</tr>
</thead>
<tr>
	<td><a href="/image/9month_event_img_181031.png"><img src="/image/9month_event_img_181031.png" width="100" /></a></td>
	<td>
		<input type="text" id="sdate1" name="hero_today_start" class="dateMode" value="<?=$_GET['hero_today_start']?>" style="width:120px;"/> ~ 
        <input type="text" id="edate1" name="hero_today_end" class="dateMode" value="<?=$_GET['hero_today_end']?>" style="width:120px;"/>
        <input type="checkbox" name="join" id="join" value="Y"  /><label for="join">�Ⱓ���� �α����� ���</label>
        <a href="#" class="btnFormExcel" id="9month">�����ٿ�ε�</a>
	</td>
</tr>
</table>
</form>
 -->

<p class="tit_section mgt30">�޸�ȸ�� �̺�Ʈ</p>
<div class="view_title_box mgt10">
	<p><label>�߼۽���</label> : ����  2�� </p>
	<p><label>���</label> : ���Ϲ߼۽��� ������ �α��� ��¥�� 11���� ���� ȸ������ ���� �߼� </p>
	<p><label>����</label> : �޸�ȸ������ ȸ�� ��ȯ �� ����Ʈ(100p), �����н� ����</p>
</div>
<form name="frm" id="frm2">
<input type="hidden" name="type" value="rest" >
<table class="t_list">
<colgroup>
	<col width="20%" />
	<col width="*" />
</colgroup>
<thead>
<tr>
	<th>�̹���</th>
	<th>����</th>
</tr>
</thead>
<tr>
	<td><a href="/image/no_login_220215.png"><img src="/image/no_login_220215.png" width="100" /></a></td>
	<td>
		<input type="text" id="sdate2" name="hero_today_start2" class="dateMode" value="<?=$_GET['hero_today_start2']?>" style="width:120px" /> ~ 
        <input type="text" id="edate2" name="hero_today_end2" class="dateMode" value="<?=$_GET['hero_today_end2']?>" style="width:120px;" />
        <input type="checkbox" name="join" id="join" value="Y"  /><label for="join">�Ⱓ���� �α����� ���</label>
        <a href="#" class="btnFormExcel" id="rest">�����ٿ�ε�</a>
	</td>
</tr>
</table>
</form>

<!-- 
<p class="tit_section mgt30">50���� �޼��̺�Ʈ</p>
<div class="view_title_box mgt10">
	<p><label>���</label> : 49�������� 50���� �޼� </p>
	<p><label>����</label> : 500����Ʈ ����</p>
</div>
<form name="frm" id="frm3">
<input type="hidden" name="type" value="50level" >
<table class="t_list">
<colgroup>
	<col width="*" />
</colgroup>
<thead>
<tr>
	<th>����</th>
</tr>
</thead>
<tr>
	<td>
		<input type="text" id="sdate3" name="hero_today_start3" class="dateMode" value="<?=$_GET['hero_today_start3']?>" style="width:120px" /> ~ 
        <input type="text" id="edate3" name="hero_today_end3" class="dateMode" value="<?=$_GET['hero_today_end3']?>" style="width:120px;" />
        <a href="#" class="btnFormExcel" id="50level">�����ٿ�ε�</a>
	</td>
</tr>
</table>
</form>
 -->
<script>
$(document).ready(function(){
	$("#9month").click(function(){
		if($("#sdate1").val() == "") {
			alert("�Ⱓ�� �����ϼ���.");
			return;
		}
		if($("#edate1").val() == "") {
			alert("�Ⱓ�� �����ϼ���.");
			return;
		}
		$("#frm1").attr("action","./user/event_excel.php").submit();
		
	})
	
	$("#rest").click(function(){
		if($("#sdate2").val() == "") {
			alert("�Ⱓ�� �����ϼ���.");
			return;
		}
		if($("#edate2").val() == "") {
			alert("�Ⱓ�� �����ϼ���.");
			return;
		}
		$("#frm2").attr("action","./user/event_excel.php").submit();
		
	})
	
	$("#50level").click(function(){
		if($("#sdate3").val() == "") {
			alert("�Ⱓ�� �����ϼ���.");
			return;
		}
		if($("#edate3").val() == "") {
			alert("�Ⱓ�� �����ϼ���.");
			return;
		}
		$("#frm3").attr("action","./user/event_excel.php").submit();
		
	})
	
})
</script>