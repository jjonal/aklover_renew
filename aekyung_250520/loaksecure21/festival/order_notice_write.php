<?
if(!defined('_HEROBOARD_'))exit;

$hero_idx = $_GET["hero_idx"];

$sql = " SELECT * FROM order_notice  WHERE hero_idx = '".$hero_idx."' ";
sql($sql);

$view = mysql_fetch_assoc($out_sql);

?>
<form name="searchForm" id="searchForm" method="GET">
<? 
unset($_GET["hero_idx"]);
unset($_GET["view"]);
foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>
<form name="form_next" id="form_next">
<input type="hidden" name="mode" id="mode" />
<input type="hidden" name="hero_idx" id="hero_idx" value="<?=$view["hero_idx"]?>" />
<table class="t_view">
<colgroup>
	<col width="150px">
	<col width="*">
</colgroup>
<tbody>
	<tr>
		<th>����</th>
		<td><input type="text" name="hero_title" value="<?=$view["hero_title"]?>"></td>
	</tr>
	<tr>
		<th>����</th>
		<td><textarea name="hero_content" id="hero_content" class="textarea" style="height:200px;"><?=$view["hero_content"]?></textarea></td>
		</tr>
	</tbody>
</table>
</form>

<div class="btnGroup">
	<div class="l">
		<a href="javascript:;" onclick="fnList();" class="btnList">���</a>
	</div>
	<div class="r">
		<? if($view["hero_idx"]) {?>
			<a href="javascript:;" class="btnDel" onClick="fnDelAction()">����</a>
			<a href="javascript:;" class="btnAdd" onClick="fnWriteAction()">����</a>
		<? } else { ?>
			<a href="javascript:;" class="btnAdd" onClick="fnWriteAction()">���</a>
		<? } ?>
	</div>
</div>

<script>
$(document).ready(function(){
	fnDelAction = function() {
		if(confirm("�����Ͻðڽ��ϱ�?")) {
			$("#mode").val("del");
			$.ajax({
				url:"<?=ADMIN_DEFAULT?>/festival/order_notice_action.php"
				,data:$("#form_next").serialize()
				,dataType:"json"
				,type:"POST"
				,success:function(d){
					if(d.result == "1") {
						alert("���� �Ǿ����ϴ�.");
						fnList();
					} else {
						alert("���� �� �����߽��ϴ�.")
					}
				},error:function(e) {
					console.log(e);
					alert("�����߽��ϴ�.")
				}
			})
			
		}
	}
	
	fnWriteAction = function() {
		if(!$("input[name='hero_title']").val()) {
			alert("������ �Է����ּ���");
			$("input[name='hero_title']").focus();
			return;
		}

		if(!$("#hero_content").val()) {
			alert("������ �Է����ּ���");
			$("#hero_content").focus();
			return;
		}

		var txt = "";
		if($("input[name='hero_idx']").val()) {
			$("#mode").val("edit");
			txt = "�����Ǿ����ϴ�.";
		} else {
			$("#mode").val("write");
			txt = "��ϵǾ����ϴ�.";
		}
		
		//$("#form_next").attr("method","POST").attr("action","<?=ADMIN_DEFAULT?>/festival/order_notice_action.php").submit();
		$.ajax({
				url:"<?=ADMIN_DEFAULT?>/festival/order_notice_action.php"
				,data:$("#form_next").serialize()
				,dataType:"json"
				,type:"POST"
				,success:function(d){
					if(d.result == "1") {
						alert(txt);
						fnList();
					} else {
						alert("���� �� �����߽��ϴ�.")
					}
				},error:function(e) {
					console.log(e);
					alert("�����߽��ϴ�.")
				}
			})
		
	}

	fnList = function() {
		$("#searchForm").submit();
	}
})
</script>