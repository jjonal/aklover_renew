<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

if($_GET["admin_check"]) {
	$search .= " AND  u.admin_check = '".$_GET["admin_check"]."' ";
}

//�� ����
$sql  = " SELECT count(*) cnt ";
$sql .= " FROM board b ";
$sql .= " INNER JOIN member m ON b.hero_code = m.hero_code ";
$sql .= " LEFT JOIN mission_url u ON b.hero_idx = u.board_hero_idx ";
$sql .= " WHERE m.hero_use=0 AND b.hero_01='".$_GET['hero_idx']."' ".$search;

sql($sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];

$i=$total_data;

$list_page=$_REQUEST['list_count']==""?20:$_REQUEST['list_count'];
$page_per_list=10;
  
if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];
	
$i = $i-($page-1)*$list_page;


$start = ($page-1)*$list_page;
$next_path=get("page");

//����Ʈ
$sql  = " SELECT b.hero_idx, b.hero_today ";
$sql .= " , m.hero_id, m.hero_name, m.hero_nick, m.hero_jumin, m.hero_hp ";
$sql .= " , u.hero_idx as mission_url_idx, u.gubun, u.url, u.member_check, u.admin_check ";
$sql .= " FROM board b ";
$sql .= " INNER JOIN member m ON b.hero_code = m.hero_code ";
$sql .= " LEFT JOIN mission_url u ON b.hero_idx = u.board_hero_idx ";
$sql .= " WHERE m.hero_use=0 AND b.hero_01='".$_GET['hero_idx']."' ".$search;
$sql .= " ORDER BY b.hero_idx DESC, FIELD(u.gubun,'naver','insta','cafe','etc') DESC, u.hero_idx ASC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql);

//�̼�����
$mission_sql = " SELECT hero_type, hero_title, hero_superpass, delivery_point_yn FROM mission WHERE hero_idx = '".$_GET["hero_idx"]."' ";
$mission_res = sql($mission_sql);
$mission_rs = mysql_fetch_assoc($mission_res);
?>

<div class="view_title_box">
	<h4>���������� ����</h4>
	<p><label>����</label> : <?=$mission_rs["hero_title"]?></p>
	<p><label>ü��� Ÿ��</label> : <?=$type_arr[$mission_rs["hero_type"]]?>, <label>�����н�</label> : <?=$mission_rs["hero_superpass"]=="Y" ? "���":"�̻��"?>, <label>�������Ʈ����</label> : <?=$mission_rs["delivery_point_yn"]=="Y" ? "����":"������"?></p>
</div>

<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="hero_idx" value="<?=$_GET["hero_idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="view" value="<?=$_GET["view"]?>" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>������ ���� Ȯ��</th>
		<td>
			<input type="radio" name="admin_check" id="admin_check_all" value="" <?=!$_GET["admin_check"] ? "checked":""?> /><label for="admin_check_all">��ü</label>
			<input type="radio" name="admin_check" id="admin_check_Y" value="Y" <?=$_GET["admin_check"]=="Y" ? "checked":""?>/><label for="admin_check_Y">Ȯ��</label>
			<input type="radio" name="admin_check" id="admin_check_N" value="N" <?=$_GET["admin_check"]=="N" ? "checked":""?>/><label for="admin_check_N">��Ȯ��</label>
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
		    	<option value="m.hero_nick" <?if(!strcmp($_REQUEST['select'], 'm.hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
		    	<option value="m.hero_name" <?if(!strcmp($_REQUEST['select'], 'm.hero_name')){echo ' selected';}else{echo '';}?>>�̸�</option>
		    	<option value="m.hero_id" <?if(!strcmp($_REQUEST['select'], 'm.hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">		
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div>


<div class="listExplainWrap">
<label>�� </label> : <strong><?=$total_data?></strong>��
</div>
<div class="btnGroupFunction">
	<div class="leftWrap">
		<a href="javascript:;" class="btnFunc" onClick="fnUrlAdminCheck()">���������� Ȯ��</a>
		<a href="javascript:;" class="btnFormCancel" onClick="fnUrlAdminCheckCancel()">���������� ��Ȯ��</a>
	</div>
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">�ٿ�ε�</a>
		<select name="list_count" onchange="fnListCount()">
        	<option value="">��� ��</option>
            <option value="20"<?if(!strcmp($_REQUEST['list_count'], '20')){echo ' selected';}else{echo '';}?>>20��</option>
        	<option value="30"<?if(!strcmp($_REQUEST['list_count'], '30')){echo ' selected';}else{echo '';}?>>30��</option>
	        <option value="50"<?if(!strcmp($_REQUEST['list_count'], '50')){echo ' selected';}else{echo '';}?>>50��</option>
            <option value="100"<?if(!strcmp($_REQUEST['list_count'], '100')){echo ' selected';}else{echo '';}?>>100��</option>
            <option value="250"<?if(!strcmp($_REQUEST['list_count'], '250')){echo ' selected';}else{echo '';}?>>250��</option>
		</select>
	</div>
</div>
</form>
<form name="listForm" id="listForm" method="POST">
<input type="hidden" name="mode" />
<table class="t_list">
<colgroup>
	<col width="4%" />
	<col width="8%" />
	<col width="8%" />
	<col width="8%" />
	<col width="10%" />
	<col width="6%" />
	<col width="*" />
	<col width="5%" />
	<col width="5%" />
	<col width="8%" />
</colgroup>
<thead>
	<tr>
		<th><input type="checkbox" id="allCheck"></th>
		<th>���̵�</th>
		<th>�г���</th>
		<th>�̸�</th>
		<th>�޴���</th>
		<th>SNS</th>
		<th>�ı��� URL</th>
		<th>����� ������ ���� ����</th>
		<th>������ ������ ���� Ȯ��</th>
		<th>�����</th>
	</tr>
</thead>
	<? if($total_data > 0) {
	   while($list = mysql_fetch_assoc($list_res)) {
	?>
	<tr>
		<td><input type="checkbox" name="mission_url_idx[]" value="<?=$list["mission_url_idx"]?>" /></td>
		<td><?=$list["hero_id"]?></td>
		<td><?=$list["hero_nick"]?></td>
		<td><?=$list["hero_name"]?></td>
		<td><?=$list["hero_hp"]?></td>
		<td><?=$list["gubun"]?></td>
		<td class="title"><?=$list["url"]?></td>
		<td><?=$list["member_check"]=="Y" ? "����":"�̵���"?></td>
		<td><?=$list["admin_check"]=="Y" ? "Ȯ��":"��Ȯ��"?></td>
		<td><?=substr($list["hero_today"],0,10)?></td>
	</tr>
	<? }
   } else {?>
   <tr>
   		<td colspan="10">��ϵ� �����Ͱ� �����ϴ�.</td>
   </tr>
   <? } ?>
</table>
</form>

<div class="btnGroupL">
	<a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&page=<?=$_GET['page']?>&idx=<?=$_GET["idx"]?>" class="btnList">���</a>
</div>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){

	$("#allCheck").on("click",function(){
		if($(this).is(":checked")) {
			$("input:checkbox[name='mission_url_idx[]']").prop("checked",true);
		} else {
			$("input:checkbox[name='mission_url_idx[]']").prop("checked",false);
		}
	})
	
	fnUrlAdminCheck = function() {
		if($("input:checkbox[name='mission_url_idx[]']:checked").length == 0) {
			alert("������ ȸ���� �����ϴ�.");
			return;
		}

		if(confirm("���������� Ȯ���� �����Ͻðڽ��ϱ�?")) {
			$("#listForm input[name='mode']").val("adminCheck");
			$.ajax({
					url:"/loaksecure21/nail/01_03_action.php"
					,type:"POST"
					,data:$("#listForm").serialize()
					,dataType:"json"
					,success:function(data){
						if(data.total > 0) {
							alert("������ ����:"+data.total+", ����:"+data.success+", ����:"+data.fail+"\n����Ǿ����ϴ�.");
							location.reload();
						} else {
							alert("���� �� ���� �߽��ϴ�.");
							return;
						}
					},error:function(error){
						console.log(error);
					}
				})
		}
	}

	fnUrlAdminCheckCancel = function() {
		if($("input:checkbox[name='mission_url_idx[]']:checked").length == 0) {
			alert("������ ȸ���� �����ϴ�.");
			return;
		}

		if(confirm("���������� ��Ȯ�� �����Ͻðڽ��ϱ�?")) {
			$("#listForm input[name='mode']").val("adminCheckCancel");
			$.ajax({
					url:"/loaksecure21/nail/01_03_action.php"
					,type:"POST"
					,data:$("#listForm").serialize()
					,dataType:"json"
					,success:function(data){
						if(data.total > 0) {
							alert("������ ����:"+data.total+", ����:"+data.success+", ����:"+data.fail+"\n����Ǿ����ϴ�.");
							location.reload();
						} else {
							alert("���� �� ���� �߽��ϴ�.");
							return;
						}
					},error:function(error){
						console.log(error);
					}
				})
		}
	}
	
	fnListCount = function() {
		$("#searchForm").attr("action","").submit();
	}

	fnSearch = function() {
		$("#searchForm").attr("action","").submit();
	}

	fnExcel = function() {
		$("#searchForm").attr("action","/loaksecure21/nail/02_03_excel.php").submit();
	}
})
</script>
                        	
                        