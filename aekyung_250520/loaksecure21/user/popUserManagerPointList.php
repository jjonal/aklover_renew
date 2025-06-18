<!DOCTYPE html>
<?
define('_HEROBOARD_', TRUE);
include_once '../../freebest/head.php';
include                                    '../popupSessionCheck.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';
include 									'../page02.php';

$hero_code = $_GET["hero_code"];

$search = "";

if($_GET["hero_point"]) {
	$search .= "AND hero_point = '".$_GET["hero_point"]."' ";
}

if($_GET["hero_title"]) {
	$search .= "AND hero_title like '%".$_GET["hero_title"]."%' ";
}

$total_sql = " SELECT count(*) cnt FROM point WHERE hero_code=  '".$hero_code."' ".$search;
$total_res = sql($total_sql,"on");
$total_rs = mysql_fetch_assoc($total_res);

$total_data = $total_rs['cnt'];

$i=$total_data;

$list_page=5;
$page_per_list=10;

if(!strcmp($_GET['page'], '')) {
	$page = '1';
} else {
	$page = $_GET['page'];
	$i = $i-($page-1)*$list_page;
}

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql  = " SELECT * FROM point WHERE hero_code=  '".$hero_code."' ".$search." ORDER BY hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql, "on");
?>
<meta charset="euc-kr" />
<head>
<link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/admin.css" />
<script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_END;?>jquery.form.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
</head>
<body style="background:none;">
<div class="popupWrap">
	<div class="popHeader">
		<h1>����Ʈ Ȯ��</h1>
	</div>
	<div class="popContents">
		<form name="searchForm" id="searchForm">
			<input type="hidden" name="page" value="<?=$page?>" />
			<input type="hidden" name="hero_code" value="<?=$hero_code?>" />
			
			<table class="tbSearch">
				<colgroup>
					<col width="120px" />
					<col width="*" />
				</colgroup>
				<tbody>
				<tr>
					<th>����Ʈ</th>
					<td><input type="text" name="hero_point" value="<?=$_GET["hero_point"]?>" /></td>
				</tr>
				<tr>
					<th>����</th>
					<td><input type="text" name="hero_title" value="<?=$_GET["hero_title"]?>"/></td>
				</tr>
				</tbody>
			</table>
			<div class="btnGroupSearch">
				<a href="javascript:;" onclick="fnSearch()" class="btnSearch">�˻�</a>
			</div>
		</form>

		<table class=t_list>
		<colgroup>
			<col width="20%" />
			<col width="*%" />
			<col width="15%" />
			<col width="10%" />
		</colgroup>
		<thead>
			<tr>
				<th>������</th>
				<th>����</th>
				<th>����Ʈ ����</th>
				<th>����Ʈ</th>
			</tr>
		</thead>
		<tbody>
			<?
			if($total_data > 0) {
			while($list = mysql_fetch_assoc($list_res)) {?>
			<tr>
				<td><?=$list["hero_today"]?></td>
				<td class="title"><?=$list["hero_title"]?></td>
				<td><?=$list["hero_include_maxpoint"]=="Y" ? "����":""?></td>
				<td><?=$list["hero_point"]?></td>
			</tr>
			<? }
			} else {?>
			<tr>
				<td colspan="4">��ϵ� �����Ͱ� �����ϴ�.</td>
			</tr>
			<? } ?>
		</tbody>
		</table>
		
		<div class="paginate">
			<?=page2($total_data,$list_page,$page_per_list,$page,$next_path);?>
        </div>
        
        <p class="tit_section mgt10">����Ʈ ����</p>
        <form name="writeForm" id="writeForm" method="POST">
        <input type="hidden" name="hero_code" value="<?=$hero_code?>" />
        <input type="hidden" name="board" value="user" />
        <input type="hidden" name="mode" value="point" />
	        <table class="t_list mgt10">
	        <colgroup>
				<col width="*">
				<col width="100">
				<col width="100">
			</colgroup>
			<thead>
				<tr>
					<th>����</th>
					<th>����Ʈ</th>
					<th>����</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input type="text" name="hero_title" /></td>
					<td><input type="text" name="hero_point" /></td>
					<td><a href="javascript:;" onClick="fnPoint();" class="btnForm">����Ʈ ����</a></td>
				<tr>
			</tbody>	
	        </table>
        </form>
	</div>
</div>
</body>
<html>
<script>
$(document).ready(function(){

	fnSearch = function() {
		$("input[name='page']").val(1);
		$("#searchForm").attr("action","").submit();
	}
	
	fnPoint = function() {
		if(!$("#writeForm input[name='hero_title']").val()) {
			alert("������ ����Ʈ ������ �Է��� �ּ���.");
			$("#writeForm input[name='hero_title']").focus();
			return;
		}

		if(!$("#writeForm  input[name='hero_point']").val()) {
			alert("����Ʈ�� �Է��� �ּ���.");
			$("#writeForm  input[name='hero_point']").focus();
			return;
		}

		if(confirm("����Ʈ�� �����Ͻðڽ��ϱ�?")) {			
			var param = $("#writeForm").serialize();

			$.ajax({
				url:"/loaksecure21/user/popUserManagerPointListAction.php"
				,type:"POST"
				,data:param
				,dataType:"json"
				,success:function(d){
					console.log(d);
					if(d.result==1) {
						alert("����Ʈ�� ���޵Ǿ����ϴ�.");
						location.reload();
					} else {
						alert("���� �� �����߽��ϴ�.")
					}
				},error:function(e){
					console.log(e);
					alert("�����߽��ϴ�.");
				}
			})
		}
		
	}
	
	ch_page = function(page) {
		$("input[name='page']").val(page);
		$("#searchForm").submit();
	}
})
</script>  