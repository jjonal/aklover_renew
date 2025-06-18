<?  if(!defined('_HEROBOARD_'))exit;

$hero_idx = $_GET["hero_idx"];

if($hero_idx) {
	$mode = "edit";
	$sql  = " SELECT l.hero_idx, l.gubun , l.gisu_year, l.gisu_month, m.hero_nick FROM member_loyal l";
	$sql .= " LEFT JOIN member m ON l.hero_code = m.hero_code  WHERE l.hero_idx = '".$hero_idx."' ";
	sql($sql);
	
	$view = mysql_fetch_assoc($out_sql);
} else {
	$mode = "write";
}

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
<input type="hidden" name="mode" id="mode" value="<?=$mode?>"/>
<input type="hidden" name="checkNick" id="checkNick" />
<input type="hidden" name="hero_idx" id="hero_idx" value="<?=$view["hero_idx"]?>" />
<table class="t_view">
<colgroup>
	<col width="150px">
	<col width="*">
</colgroup>
<tbody>
	<tr>
		<th>�г���</th>
		<td>
			<? if($view["hero_idx"]) {?>
				<?=$view["hero_nick"]?>
			<? } else { ?>
				<input type="text" name="hero_nick" value="<?=$view["hero_nick"]?>" style="width:150px">
				<a href="javascript:;" onClick="fnCheckNick()" class="btnForm">ȸ��Ȯ��</a>
				<span id="txt_check_nick"></span>
				<p class="txt_emphasis mgt10">�� 3���� �� �缱�� �Ұ��մϴ�.</p>
			<? } ?>
		</td>
	</tr>
	<tr>
		<th>��¥����(���)</th>
		<td>
			<select name="gisu_year">
				<option value="">�⵵</option>
				<? for($i = date("Y")+1; $i > 1921; $i--) { ?>
					<option value="<?=$i;?>" <?=$view["gisu_year"]==$i ? "selected":""?>><?=$i;?></option>
				<? } ?>
			</select>
			<select name="gisu_month">
				<option value="">����</option>
				<? for($i = 1; $i <= 12; $i++) { ?>	
					<option value="<?=sprintf("%02d", $i);?>" <?=$view["gisu_month"]==sprintf("%02d", $i) ? "selected":""?>><?=sprintf("%02d", $i);?></option>
				<? } ?>
			</select>
		</td>
	</tr>
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

	$("input[name='hero_nick']").on("keyup",function(){
		$("#checkNick").val("");
		$("#txt_check_nick").html("");
	})

	fnCheckNick = function() {
		$("#mode").val("checkNick");
		$.ajax({
			url:"<?=ADMIN_DEFAULT?>/user/loyalAction.php"
			,data:$("#form_next").serialize()
			,dataType:"json"
			,type:"POST"
			,success:function(d){
				console.log(d);
				if(d.result==1) {
					$("#txt_check_nick").html("���ѵ�� �����մϴ�.");
					$("#checkNick").val("Y");
				} else if(d.result==-2) {
					$("#txt_check_nick").html("�Է��Ͻ� �г����� ȸ���� �ƴմϴ�.");
					$("#checkNick").val("");	
				} else if(d.result==-3) {
					$("#txt_check_nick").html("3���� �� ������ �� ȸ���Դϴ�.");
					$("#checkNick").val("");	
				}
			},error:function(e) {
				console.log(e);
				alert("�����߽��ϴ�.")
			}
		})
	}
	
	fnDelAction = function() {
		if(confirm("�����Ͻðڽ��ϱ�?")) {
			$("#mode").val("del");
			console.log($("#form_next").serialize());
			$.ajax({
				url:"<?=ADMIN_DEFAULT?>/user/loyalAction.php"
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
		<? if($mode=="write") {?>
			if(!$("input[name='hero_nick']").val()) {
				alert("�г����� �Է��ϼ���");
				$("input[name='hero_nick']").focus();
				return;
			}
	
			if(!$("#checkNick").val()) {
				alert("ȸ��Ȯ���� ���ּ���");
				$("input[name='hero_nick']").focus();
				return;
			}
		<? } ?>

		if(!$("select[name='gisu_year']").val()) {
			alert("��¥����(��) ���ּ���.");
			$("select[name='gisu_year']").focus();
			return;
		}

		if(!$("select[name='gisu_month']").val()) {
			alert("��¥����(��) ���ּ���.");
			$("select[name='gisu_month']").focus();
			return;
		}

		<? if($mode=="write") {?>
			$("#mode").val("write");
		<? } else if($mode=="edit") { ?>
			$("#mode").val("edit");
		<? } ?>

		$.ajax({
				url:"<?=ADMIN_DEFAULT?>/user/loyalAction.php"
				,data:$("#form_next").serialize()
				,dataType:"json"
				,type:"POST"
				,success:function(d){
					if(d.result == "1") {
						<? if($mode=="write") {?>
							alert("��ϵǾ����ϴ�.");
							fnList();
						<? } else if($mode=="edit") { ?>
							alert("�����Ǿ����ϴ�.");
							location.reload();
						<? } ?>
						return;
					} else {
						alert("���� �� �����߽��ϴ�.");
						return;
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