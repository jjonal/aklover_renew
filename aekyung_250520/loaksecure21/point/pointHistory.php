<? 
if(!defined('_HEROBOARD_'))exit;

$search = "";
$search_order = "";

if($_GET["hero_today_start"]) {
	$search .= " AND date_format(hero_today,'%Y-%m-%d') >= '".$_GET["hero_today_start"]."' ";
	$search_order .= " AND date_format(hero_today,'%Y-%m-%d') >= '".$_GET["hero_today_start"]."' ";
}

if($_GET["hero_today_end"]) {
	$search .= " AND date_format(hero_today,'%Y-%m-%d') <= '".$_GET["hero_today_end"]."' ";
	$search_order .= " AND date_format(hero_today,'%Y-%m-%d') <= '".$_GET["hero_today_end"]."' ";
}

if($_GET["pointType"]){
	if($_GET["pointType"] == 'Plus') {
		$search .=" AND hero_point > 0 ";
		$search_order .=" AND hero_point < 0 ";
	}
	else if($_GET["pointType"] == 'Minus') {
		$search .=" AND hero_point < 0 ";
		$search_order .=" AND hero_point > 0 ";
	}
}

if($_GET["pointLimit"]) {
	$search .= " AND hero_include_maxpoint = '".$_GET["pointLimit"]."' ";
	$search_order .= " AND hero_include_maxpoint = '".$_GET["pointLimit"]."' ";
}

if($_GET["kewyword"]){
	if($_GET["select"] == "hero_title" || $_GET["select"] == "hero_top_title") {
		$search .= " AND ".$_GET["select"]."  like '%".$_GET["kewyword"]."%' ";
	} else {
		$search .= " AND ".$_GET["select"]." ='".$_GET["kewyword"]."' ";
	}
	
	if($_GET["select"] == "hero_title" || $_GET["select"] == "hero_top_title") {
		$search_order .= "";
		if($_GET["select"] == "hero_title") {
			$search_order .= " AND ".$_GET["select"]."  like '%".$_GET["kewyword"]."%' ";
		}
	} else {
		$search_order .= " AND ".$_GET["select"]." ='".$_GET["kewyword"]."' ";
	}
}

$total_sql = " SELECT SUM(cnt) as cnt, SUM(hero_point) hero_point, SUM(hero_order_point) as hero_order_point FROM (";
$total_sql .= " SELECT count(*) AS cnt, ifnull(sum(hero_point),0) as hero_point, 0 hero_order_point FROM point WHERE 1=1 ".$search;
$total_sql .= " UNION ALL ";
$total_sql .= " SELECT count(*) AS cnt, 0 as hero_point , ifnull(sum(hero_point),0) as hero_order_point from ";
$total_sql .= " ( SELECT hero_id, hero_name, hero_nick, hero_order_point as hero_point, hero_regdate as hero_today ";
$total_sql .= " , case when hero_process = 'DE' then '��۷�' when hero_process = 'M' then '����Ʈ�Ҹ�' when hero_process = 'O' then '��ǰ����' ELSE hero_process end AS hero_title ";
$total_sql .= " , 'N' hero_include_maxpoint FROM order_main WHERE hero_process != 'C') a WHERE 1=1 ".$search_order;
$total_sql .= " ) a ";

sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];


$total_point = $out_res['hero_point'];
$total_use_point = $out_res['hero_order_point'];
$total_possible_point = $total_point-$total_use_point;

$i=$total_data;

$list_page=20;
$page_per_list=10;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];

$i = $i-($page-1)*$list_page;

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql = " SELECT * FROM  (";
$sql .= " SELECT hero_type, hero_id, hero_top_title, hero_title ";
$sql .= " , hero_name, hero_nick, hero_point, hero_today, hero_include_maxpoint, edit_hero_code ";
$sql .= " FROM point p ";
$sql .= " WHERE 1=1 ".$search." ";
$sql .= " UNION ALL ";
$sql .= " SELECT hero_type, hero_id, hero_top_title,  hero_title, hero_name ";
$sql .= " , hero_nick, hero_point*-1 as hero_point, hero_today, hero_include_maxpoint, hero_code FROM ( ";
$sql .= " SELECT  '' hero_type, hero_id, '' hero_top_title ";
$sql .= " , case when hero_process = 'DE' then '��۷�' when hero_process = 'M' then '����Ʈ�Ҹ�' when hero_process = 'O' then '��ǰ����' ELSE hero_process end AS hero_title ";
$sql .= " , hero_name , hero_nick, hero_order_point as hero_point, hero_regdate as hero_today, 'N' hero_include_maxpoint ";
$sql .= " , hero_code ";
$sql .= "  FROM order_main WHERE hero_process != 'C') a WHERE 1=1 ".$search_order;
$sql .= " ) a ";
$sql .= " ORDER BY hero_today DESC ";
$sql .= " LIMIT ".$start.",".$list_page."";

$list_res = sql($sql);
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>�Ⱓ</th>
		<td>
			<input type="text" name="hero_today_start"  value="<?=$_GET['hero_today_start']?>" class="dateMode" /> ~ 
			<input type="text" name="hero_today_end"  value="<?=$_GET['hero_today_end']?>" class="dateMode" />
		</td>
	</tr>
	<tr>
		<th>����Ʈ ȹ��/����</th>                
		<td><input type="radio" name="pointType"  id="pointAll" value="All"  <?if($_GET['pointType']=="" || $_GET['pointType']=="All" ) echo checked;?>/><label for="pointAll">��ü</label> 
		 	<input type="radio" name="pointType"  id="pointPlus" value="Plus"  <?if($_GET['pointType']=="Plus" ) echo checked;?>/><label for="pointPlus">ȹ��</label> 
			<input type="radio" name="pointType"  id="pointMinus" value="Minus"  <?if($_GET['pointType']=="Minus" ) echo checked;?>/><label for="pointMinus">����</label>
		</td>
	</tr>
	<tr>
		<th>���ѵ� ����Ʈ</th>                
		<td><input type="radio" name="pointLimit"  id="pointLimitAll" value=""  <?if($_GET['pointLimit']=="") echo checked;?>/><label for="pointAll">��ü</label> 
		 	<input type="radio" name="pointLimit"  id="pointLimitY" value="Y"  <?if($_GET['pointLimit']=="Y" ) echo checked;?>/><label for="pointLimitY">����</label> 
			<input type="radio" name="pointLimit"  id="pointLimitN" value="N"  <?if($_GET['pointLimit']=="N" ) echo checked;?>/><label for="pointLimitN">���Ѿ���</label>
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
		    	<option value="hero_name" <?if(!strcmp($_REQUEST['select'], 'hero_name')){echo ' selected';}else{echo '';}?>>�̸�</option>
		    	<option value="hero_top_title" <?if(!strcmp($_REQUEST['select'], 'hero_top_title')){echo ' selected';}else{echo '';}?>>����Ʈ ȹ�� �޴�</option>
		    	<option value="hero_title" <?if(!strcmp($_REQUEST['select'], 'hero_title')){echo ' selected';}else{echo '';}?>>����Ʈ ����</option>
		    	<option value="hero_point" <?if(!strcmp($_REQUEST['select'], 'hero_point')){echo ' selected';}else{echo '';}?>>����Ʈ</option>
		    	
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">		
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div>
</form>
<div class="listExplainWrap">
<label>�� </label> : <strong><?=number_format($total_data)?></strong>��, <label>�� ����Ʈ</label> : <strong><?=number_format($total_point)?></strong> P (���� ȹ�� ����Ʈ ���� 20��)
, <label>�� ����� ����Ʈ</label> : <strong><?=number_format($total_use_point)?></strong> P
, <label>�� ���� ����Ʈ</label> : <strong><?=number_format($total_possible_point > 0 ? $total_possible_point:0)?></strong> P
</div>
<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">�ٿ�ε�</a>
	</div>
</div>

<table class="t_list">
<colgroup>
	<col width="10%" />
	<col width="8%" />
	<col width="8%" />
	<col width="8%" />
	<col width="10%" />
	<col width="6%" />
	<col width="10%" />
	<col width="*" />
	<col width="6%" />
</colgroup>
<thead>
<tr>
	<th>������</th>
	<th>���̵�</th>
	<th>�̸�</th>
	<th>�г���</th>
	<th>����Ʈ ���� ����</th>
	<th>ȹ��/����</th>
	<th>����Ʈ ȹ�� �޴�</th>
	<th>����</th>
	<th>����Ʈ</th>
</tr>
</thead>
<? if($total_data > 0) {
	while($list = mysql_fetch_assoc($list_res)) {	
		$hero_include_maxpoint_txt = "���Ѿ���";
		if($list["hero_include_maxpoint"] == "Y") $hero_include_maxpoint_txt = "����";
		$point_gubun_txt = "";
		if($list['hero_point']  > 0) {
			$point_gubun_txt = "ȹ��";
		} else if($list['hero_point']  < 0) {
			$point_gubun_txt = "����";
		}
?>
<tr>
	<td><?=$list['hero_today']?></td>
	<td><?=$list['hero_id']?></td>
	<td><?=name_masking($list['hero_name'])?></td>
	<td><?=$list['hero_nick']?></td>
	<td><?=$hero_include_maxpoint_txt?></td>
	<td><?=$point_gubun_txt?></td>
	<td><?=$list["hero_top_title"]?></td>
	<td class="title"><?=$list["hero_title"]?></td>
	<td><?=$list["hero_point"]?> P</td>
</tr>
<? }
} else {?>
<tr>
	<td colspan="9">��ϵ� �����Ͱ� �����ϴ�.</td>
</tr>
<? } ?>
</table>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){
	fnSearch = function() {
		$("#searchForm").attr("action","").submit();
	}	

	fnExcel = function() {
		if(!$("select[name='select']").val()) {
			alert("�˻��� �׸��� ������ �ּ���.\n������ ���� ���� �˻��� �Է� �� �ش��ϴ� �����͸� �ٿ�ε� �����մϴ�.");
			$("select[name='select']").focus();
			return;
		}

		if(!$("input[name='kewyword']").val()) {
			alert("�˻����� �Է����ּ���.\n������ ���� ���� �˻��� �Է� �� �ش��ϴ� �����͸� �ٿ�ε� �����մϴ�.");
			$("input[name='kewyword']").focus();
			return;
		}

		$("#searchForm").attr("action","/loaksecure21/point/excel_pointHistory.php").submit();
	}
})
</script>
    