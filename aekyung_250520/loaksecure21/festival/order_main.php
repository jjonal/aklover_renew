<?
if($_POST["mode"]){
	$mode						= $_POST["mode"];

	if($mode=="each"){
		$hero_idx					= $_POST["hero_idx"];
		$status						= $_POST["status"];
		$delivery_enterprise		= $_POST["delivery_enterprise"];
		$transport_number			= $_POST["transport_number"];
		if($status=="A") $delivery_enterprise = $transport_number = "";

		$sql = "UPDATE order_main SET hero_process='".$status."', hero_delivery_enterprise='".$delivery_enterprise."', hero_transport_number='".$transport_number."' where hero_idx=".$hero_idx;
		mysql_query($sql) or die(mysql_error());
	}else if($mode=="all"){
		$idx						= $_POST["hero_idx"];
		if(is_array($idx)){
			while(list($k,$v)=each($idx)){
				$status						= $_POST["status".$v];
				$delivery_enterprise		= $_POST["delivery_enterprise".$v];
				$transport_number			= $_POST["transport_number".$v];
				if($status=="A") $delivery_enterprise = $transport_number = "";

				$sql = "UPDATE order_main SET hero_process='".$status."', hero_delivery_enterprise='".$delivery_enterprise."', hero_transport_number='".$transport_number."' where hero_idx=".$v;
				mysql_query($sql) or die(mysql_error());
			}
		}
	}

	msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}

$search = "";
$search_next = "";
if (strcmp ( $_REQUEST ['kewyword'], '' )) {
	if ($_REQUEST ['select'] == 'hero_all') {
		$search .= ' and ( A.hero_nick like \'%' . $_REQUEST ['kewyword'] . '%\' or A.hero_name like \'%' . $_REQUEST ['kewyword'] . '%\' or B.hero_name like \'%' . $_REQUEST ['kewyword'] . '%\' )';
		$search_next .= '&select=' . $_REQUEST ['select'] . '&kewyword=' . $_REQUEST ['kewyword'];
	} else {
		$search .= ' and ' . $_REQUEST ['select'] . ' like \'%' . $_REQUEST ['kewyword'] . '%\'';
		$search_next .= '&select=' . $_REQUEST ['select'] . '&kewyword=' . $_REQUEST ['kewyword'];
	}
}

$startDate			= $_REQUEST["startDate"];
$endDate			= $_REQUEST["endDate"];

if (strcmp ( $startDate, '' )) {
	$search .= " and A.hero_regdate >='".$startDate." 00:00:00'";
	$search_next .= "&startDate=".$startDate;
}

if (strcmp ( $endDate, '' )) {
	$search .= " and A.hero_regdate <='".$endDate." 23:59:59'";
	$search_next .= "&endDate=".$endDate;
}


$sql  = " select count(A.hero_idx) as count from order_main A inner join goods B on A.goods_idx=B.hero_idx where 1=1 ";
//$sql .= " AND A.hero_process != '".$_PROCESS_CANCEL."' ";
$sql .= $search.$view_order;
sql ( $sql );
//echo $sql;
$out_sql = @mysql_fetch_assoc ( $out_sql );
$total_data = $out_sql ['count'];

//���� ����
if (! strcmp ( $_GET ['list_page'], '' )) {
    $list_page = 20;
} else {
    $list_page = $_GET ['list_page'];
}

$page_per_list = 10;

if (! strcmp ( $_GET ['page'], '' )) {
	$page = '1';
} else {
	$page = $_GET ['page'];
}

$j = $total_data;
if ($_GET ['page']) {
	$j = $total_data - (($_GET ['page'] - 1) * $list_page);
}

$start = ($page - 1) * $list_page;
$next_path = "board=".$_GET ['board'].$search_next."&idx=" . $_GET ['idx'].'&list_page='.$list_page;
// #####################################################################################################################################################

?>
<script>
function status_res(idx, val){
	msg = "��� �����Ȱ�� �����Ͻðڽ��ϱ�?";

	if(val!="A"){
		if($("#delivery_enterprise"+idx).val()==""){
			alert("��۾�ü�� �����ϼ���");
			return false;
		}else if($("#transport_number"+idx).val().split(" ").join("")==""){
			alert("������ȣ�� �Է��ϼ���");
			return false;
		}
	}

	if (confirm(msg)!=0) {
		var status = $('#status_'+idx).val();
		location.href="<?=$_SERVER['PHP_SELF']?>?board=festival&idx=68&id="+val+"&status="+status+"";
	}
}

function each_modify(idx){
	if($("#status"+idx).val()!="A"){
		if($("#delivery_enterprise"+idx).val()==""){
			alert("��۾�ü�� �����ϼ���");
			$("#delivery_enterprise"+idx).focus();
			return false;

		}else if($("#transport_number"+idx).val().split(" ").join("")==""){
			alert("������ȣ�� �Է��ϼ���");
			$("#transport_number"+idx).focus();
			return false;
		}
	}

	var form = document.frm;
	form.mode.value = "each";
	form.hero_idx.value = idx;
	form.status.value = $("#status"+idx).val();
	form.delivery_enterprise.value = $("#delivery_enterprise"+idx).val();
	form.transport_number.value = $("#transport_number"+idx).val();
	form.submit();
}

function all_modify(){
	var form = document.frm, cFlag = false, sFlag = true, idx = "";

	form.mode.value = "all";

	$("input:checkbox[name='hero_idx[]']:checked").each(function(){
		cFlag = true;
		idx = $(this).val();

		if($("#status"+idx).val()!="A"){
			if($("#delivery_enterprise"+idx).val()==""){
				alert("��۾�ü�� �����ϼ���");
				$("#delivery_enterprise"+idx).focus();
				sFlag = false;
				return false;

			}else if($("#transport_number"+idx).val().split(" ").join("")==""){
				alert("������ȣ�� �Է��ϼ���");
				$("#transport_number"+idx).focus();
				sFlag = false;
				return false;
			}
		}
	});

	if(cFlag===false){
		alert("���� �� �׸��� üũ���ּ���");
		return false;

	}else{
		if(sFlag===false){
			return false;
		}else{
			form.submit();
		}
	}
}
</script>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="page" value="<?=$_GET["page"]?>" />
<input type="hidden" name="list_page" value="<?=$_GET["list_page"]?>" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>��¥ �˻�</th>
		<td>
			<input type="text" name="startDate" id="startDate" value="<?=$startDate?>" class="dateMode">
			~
			<input type="text" name="endDate" id="endDate" value="<?=$endDate?>" class="dateMode">
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
		    	<option value="A.hero_nick" <?if(!strcmp($_REQUEST['select'], 'A.hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
				<option value="A.hero_name" <?if(!strcmp($_REQUEST['select'], 'A.hero_name')){echo ' selected';}else{echo '';}?>>����</option>
				<option value="B.hero_name" <?if(!strcmp($_REQUEST['select'], 'B.hero_name')){echo ' selected';}else{echo '';}?>>��ǰ��</option>
				<option value="B.hero_serial_number" <?if(!strcmp($_REQUEST['select'], 'B.hero_serial_number')){echo ' selected';}else{echo '';}?>>��ǰ�����ڵ�</option>
				<option value="A.hero_order_number" <?if(!strcmp($_REQUEST['select'], 'A.hero_order_number')){echo ' selected';}else{echo '';}?>>�ֹ���ȣ</option>
				<option value="hero_all" <?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>�г���+����+��ǰ��</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div>
</form>
<div class="listExplainWrap mgb10">
	<label>�� </label> : <strong><?=number_format($total_data)?></strong>��
</div>

<div class="btnGroupFunction">
	<div class="leftWrap">
        <!--�ӽ� display none-->
		<a href="javascript:all_modify();" class="btnFunc" style="display: none;">�ϰ�����</a>
	</div>
	<div class="rightWrap">
        <!--musign �ֹ����� ����-->
        <select id="sel_list_page" name="sel_list_page">
            <option value="20"   <?=$_GET['list_page'] == 20   ? 'selected' : ''?>>20�� ����</option>
            <option value="50"   <?=$_GET['list_page'] == 50   ? 'selected' : ''?>>50�� ����</option>
            <option value="100"  <?=$_GET['list_page'] == 100  ? 'selected' : ''?>>100�� ����</option>
            <option value="200"  <?=$_GET['list_page'] == 200  ? 'selected' : ''?>>200�� ����</option>
            <option value="500"  <?=$_GET['list_page'] == 500  ? 'selected' : ''?>>500�� ����</option>
            <option value="1000" <?=$_GET['list_page'] == 1000 ? 'selected' : ''?>>1000�� ����</option>
        </select>
        <a href="javascript:;" class="btnFormExcel" onClick="window.open('festival/download_buylist.php?a=b<?=$search_next?>')">��ǰ�� �ֹ� ����</a>
        <a href="javascript:;" class="btnFormExcel" onClick="window.open('festival/mu_download_buylist.php?a=b<?=$search_next?>')">ȸ���� �ֹ�����</a>
	</div>
</div>
<table class="t_list">
<thead>
<tr>
	<th width="2%" style="display: none;"><input type="checkbox" onclick="Javascript:allCheck(this.checked, 'hero_idx[]');"></th><!--�ӽ� display none-->
	<th width="3%">NO</th>
    <th width="12%"><a href="<?=PATH_HOME.'?'.get('order','order=goods_name desc');?>">��</a>��ǰ��<a href="<?=PATH_HOME.'?'.get('order','order=goods_name asc');?>">��</a></th>
    <th width="8%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_serial_number desc');?>">��</a>��ǰ������ȣ<a href="<?=PATH_HOME.'?'.get('order','order=hero_serial_number asc');?>">��</a></th>
	<th width="8%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_id desc');?>">��</a>���̵�<a href="<?=PATH_HOME.'?'.get('order','order=hero_id asc');?>">��</a></th>
	<th width="8%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_nick desc');?>">��</a>�г���<a href="<?=PATH_HOME.'?'.get('order','order=hero_nick asc');?>">��</a></th>
	<th width="7%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_name desc');?>">��</a>�̸�<a href="<?=PATH_HOME.'?'.get('order','order=hero_name asc');?>">��</a></th>
	<th width="10%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_regdate desc');?>">��</a>������<a href="<?=PATH_HOME.'?'.get('order','order=hero_regdate asc');?>">��</a></th>
	<th width="7%">�ֹ���ȣ</th>
	<th width="10%"><a href="<?=PATH_HOME.'?'.get('order','order=hero_process desc');?>">��</a>����<a href="<?=PATH_HOME.'?'.get('order','order=hero_process asc');?>">��</a></th>
	<th width="8%">��۾�ü</th>
	<th width="11%">������ȣ</th>
	<th>����</th>
</tr>
</thead>
<tbody>
<form name="frm" method="post" action="<?=$_SERVER["REQUEST_URI"]?>">
<input type="hidden" name="mode" value="">
<input type="hidden" name="hero_idx" value="">
<input type="hidden" name="status" value="">
<input type="hidden" name="delivery_enterprise" value="">
<input type="hidden" name="transport_number" value="">
<?
if (! strcmp ( $_GET ['order'], '' )) {
	$view_order = ' order by hero_idx desc';
} else {
	$view_order = ' order by ' . $_GET ['order'];
}
// select a.*, (SELECT SUM(hero_point) FROM point where DATE_FORMAT(hero_today,'%Y-%m')='2013-12' where a.hero_code=hero_code GROUP BY hero_code) As hero_reid from member AS a
// echo $sql = 'select *, (SELECT hero_id,hero_code, SUM(hero_point) AS point_sum FROM point where DATE_FORMAT(hero_today,\'%Y-%m\')=\''.$new_today_check.'\' GROUP BY hero_code) As hero_reid, from member AS a where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.$view_order.' limit '.$start.','.$list_page.';';
// $sql = 'SELECT a.hero_id, a.hero_name, a.hero_nick, a.hero_point, b.point_sum FROM member AS a LEFT JOIN ( SELECT hero_id,hero_code, SUM(hero_point) AS point_sum FROM point where DATE_FORMAT(hero_today,\'%Y-%m\')=\''.$new_today_check.'\' GROUP BY hero_code ) AS b ON ( a.hero_code = b.hero_code ) where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.$view_order.' limit '.$start.','.$list_page.';';
// $sql = 'select a.*, (SELECT SUM(hero_point) FROM point where a.hero_code=hero_code GROUP BY hero_code) As point_total, (SELECT SUM(hero_point) FROM point where DATE_FORMAT(hero_today,\'%Y-%m\')=\''.$new_today_check.'\' and a.hero_code=hero_code GROUP BY hero_code) As point_sum from member AS a where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.$view_order.' limit '.$start.','.$list_page.';';
// $sql = 'select * from (select m.hero_idx,m.hero_id,m.hero_pw,m.hero_name,m.hero_nick,sum(p.hero_point) as point_total,sum(case when DATE_FORMAT(p.hero_today,\'%Y-%m\')=\''.$new_today_check.'\' then p.hero_point else 0 end) as point_sum FROM point as p,member as m where hero_level<=\''.$_SESSION['temp_level'].'\''.$search.' and p.hero_code=m.hero_code GROUP BY m.hero_code) as sub1 '.$view_order.limit '.$start.','.$list_page.';';

$sql  = "select A.*, B.hero_name as goods_name,B.hero_serial_number from order_main A inner join goods B on A.goods_idx=B.hero_idx where 1=1 ";
//$sql .= " AND A.hero_process != '".$_PROCESS_CANCEL."' ";
$sql .= $search.$view_order." limit ".$start.", ".$list_page.";";

sql ( $sql );
while ( $roll_list = @mysql_fetch_assoc ( $out_sql ) ) {
	?>
<tr>
	<td style="display: none;"><input type="checkbox" name="hero_idx[]" value="<?=$roll_list['hero_idx']?>"></td><!--�ӽ� display none-->
	<td><?=$j?></td>
	<td class="title"><?=$roll_list['goods_name']?></td>
    <td><?=$roll_list['hero_serial_number']?></td>
	<td><?=$roll_list['hero_id']?></td>
	<td><?=$roll_list['hero_nick']?></td>
	<td><?=name_masking($roll_list['hero_name'])?></td>
	<td><?=$roll_list['hero_regdate']?></td>
	<td><?=$roll_list['hero_order_number']?></td>
	<td>
        <select id="status<?=$roll_list['hero_idx']?>" name="status<?=$roll_list['hero_idx']?>">
            <option value="">����</option>
            <option value="<?=$_PROCESS_ORDER?>" <?php echo $roll_list['hero_process']==$_PROCESS_ORDER ? "selected" : ""?>><?=$_GOODS_PROCESS[$_PROCESS_ORDER]?></option>
            <option value="<?=$_PROCESS_DELIVERY?>" <?php echo $roll_list['hero_process']==$_PROCESS_DELIVERY ? "selected" : ""?>><?=$_GOODS_PROCESS[$_PROCESS_DELIVERY]?></option>
            <option value="<?=$_PROCESS_DECISION?>" <?php echo $roll_list['hero_process']==$_PROCESS_DECISION ? "selected" : ""?>><?=$_GOODS_PROCESS[$_PROCESS_DECISION]?></option>
            <option value="<?=$_PROCESS_CANCEL?>" <?php echo $roll_list['hero_process']==$_PROCESS_CANCEL ? "selected" : ""?>><?=$_GOODS_PROCESS[$_PROCESS_CANCEL]?></option>
        </select>
	</td>
	<td>
	<select id="delivery_enterprise<?=$roll_list['hero_idx']?>" name="delivery_enterprise<?=$roll_list['hero_idx']?>">
		<option value="">::��۾�ü ����::</option>
	<?
	reset($_DELIVERY_ENTERPRISE);
	while(list($k,$v)=each($_DELIVERY_ENTERPRISE)){
		if($roll_list['hero_delivery_enterprise']==$k){
			$selected = "selected='selected'";
		}else{
			$selected = "";
		}
		echo "<option value='".$k."' ".$selected.">".$k."</option>".PHP_EOL;
	}
	?>
	</select>
	</td>
	<td><input type="text" id="transport_number<?=$roll_list['hero_idx']?>" name="transport_number<?=$roll_list['hero_idx']?>" value="<?=$roll_list['hero_transport_number']?>"></td>
	<td style="border-right:1px solid #cdcdcd;">
		<a href="<?=ADMIN_DEFAULT?>/index.php?board=festival&idx=<?=$_GET["idx"]?>&view=02_01&hero_idx=<?=$roll_list['hero_idx']?>&page=<?=$_GET["page"]?>" class="btnForm">��������</a>
		<a href="Javascript:each_modify(<?=$roll_list['hero_idx']?>);" class="btnForm">����</a>
	</td>
</tr>
<?
	$j --;
}
?>
</form>
</tbody>
</table>
<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){
	fnSearch = function() {
		$("input[name='page']").val(1);
		$("#searchForm").submit();
	}

    $("#sel_list_page").change(function (){
        $("input[name='list_page']").val(this.value);
        $("#searchForm").submit();
    })

})
</script>
