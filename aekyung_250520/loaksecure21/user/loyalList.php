<?  if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET["gubun"]) {
	if($_GET["gubun"] == "sum") {
		$search .= " AND (l.gubun is null or l.gubun = '')  ";
	} else {
		$search .= " AND l.gubun = '".$_GET["gubun"]."' ";
	}
}

if($_GET["gisu_year"]) {
	$search .= " AND l.gisu_year = '".$_GET["gisu_year"]."' ";
}

if($_GET["gisu_month"]) {
	$search .= " AND l.gisu_month = '".$_GET["gisu_month"]."' ";
}

if(strcmp($_GET["kewyword"], "")){
	$search .= " AND  ".$_GET["select"]." LIKE '%".$_GET["kewyword"]."%' ";
}

$total_sql  = " SELECT count(*) cnt FROM member_loyal l ";
$total_sql .= " LEFT JOIN member m ON l.hero_code = m.hero_code ";
$total_sql .= " WHERE 1=1 ".$search;

sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];

$i=$total_data;

$list_page=20;
$page_per_list=10;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];

$i = $i-($page-1)*$list_page;


$start = ($page-1)*$list_page;
$next_path=get("page");

//����Ʈ
$sql  = " SELECT l.hero_idx, l.gisu_year, l.gisu_month, l.hero_today, l.gubun ";
$sql .= " , m.hero_name, m.hero_nick, m.hero_id ";
$sql .= " FROM member_loyal l ";
$sql .= " LEFT JOIN member m ON l.hero_code = m.hero_code ";
$sql .= " WHERE 1=1 ".$search;
$sql .= " ORDER BY l.gisu_year DESC, l.gisu_month DESC, l.hero_today DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql);

//���� ���� �Ⱓ
$period_sql  = " SELECT startdate, enddate ";
$period_sql .= " , if(startdate <= date_format(now(),'%Y-%m-%d') AND enddate >= date_format(now(),'%Y-%m-%d'),1,0) as status FROM member_loyal_period ";
$period_res = sql($period_sql);
$period_rs = mysql_fetch_assoc($period_res);
?>
<div class="view_title_box">
	<p>���� ����Ⱓ : <strong>(<?=$period_rs["status"]==1 ? "����":"�����"?>)</strong> <?=$period_rs["startdate"]?> ~ <?=$period_rs["enddate"]?></p>
	<p>��� : �� �� ����� ����(ex : ���� 6���̶�� �����ϸ� 5�� ����ڸ� ����, 2021��5�� ����� 6������ �ξ� ������ �ο��˴ϴ�.)</p>
</div>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="page" value="<?=$_GET["page"]?>" />
<input type="hidden" name="hero_idx" value="" />
<input type="hidden" name="view" value="" />
<table class="tbSearch">
	<colgroup>
		<col width="150px" />
		<col width="*" />
	</colgroup>
	<tr>
		<th>����</th>
		<td>
			<input type="radio" name="gubun" id="gubun_all" value="" <?=strlen($_GET["gubun"])==0 ? "checked":""?> /><label for="gubun_all">��ü</label>
			<input type="radio" name="gubun" id="gubun_sum" value="sum" <?=$_GET["gubun"]=="sum" ? "checked":""?>/><label for="gubun_sum">Loyal AK LOVER(����)</label>
			<input type="radio" name="gubun" id="gubun_r" value="r" <?=$_GET["gubun"]=="r" ? "checked":""?>/><label for="gubun_r">���� Loyal AK LOVER</label>
			<input type="radio" name="gubun" id="gubun_j" value="j" <?=$_GET["gubun"]=="j" ? "checked":""?>/><label for="gubun_j">���� Loyal AK LOVER</label>
		</td>
	</tr>
	<tr>
		<th>���(��, ��)</th>
		<td>
			<select name="gisu_year">
				<option value="">�⵵</option>
				<? for($z = date("Y")+1; $z > 1921; $z--) { ?>
					<option value="<?=$z;?>" <?=$z==$_GET["gisu_year"] ? "selected":""?>><?=$z;?></option>
				<? } ?>
			</select>
			<select name="gisu_month">
				<option value="">����</option>
				<? for($z = 1; $z <= 12; $z++) { ?>	
					<option value="<?=sprintf("%02d", $z);?>" <?=sprintf("%02d", $z)==$_GET["gisu_month"] ? "selected":""?>><?=sprintf("%02d", $z);?></option>
				<? } ?>
			</select>
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
				<option value="m.hero_nick" <?if(!strcmp($_REQUEST['select'], 'm.hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
		    	<option value="m.hero_id" <?if(!strcmp($_REQUEST['select'], 'm.hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
		    	<option value="m.hero_name" <?if(!strcmp($_REQUEST['select'], 'm.hero_name')){echo ' selected';}else{echo '';}?>>�̸�</option>	    	
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
	<label>�� </label> : <strong><?=$total_data?></strong>��</span>
</div>

<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">�ٿ�ε�</a>
		<a href="javascript:;" class="btnFunc" onClick="fnPopPeriod()">���� ���� �Ⱓ ����</a>
	</div>
</div>

<table class="t_list">
<colgroup>
	<col width="5%" />
	<col width="10%" />
	<col width="*" />
	<col width="20%" />
	<col width="20%" />
	<col width="20%" />
	<col width="15%" />
</colgroup>
<thead>
	<tr>
		<th>no</th>
		<th>����</th>
		<th>���</th>
		<th>���̵�</th>
		<th>�г���</th>
		<th>����</th>
		<th>�����</th>
	</tr>
</thead>
<? if($total_data > 0) {
	while($list = mysql_fetch_assoc($list_res)) {	
		$gubun_txt= "";
		if($list["gubun"]=="r") {
			$gubun_txt = "����";
		} else if($list["gubun"]=="j") {
			$gubun_txt = "����";
		} else {
			$gubun_txt = "����";
		}
?>
<tr onClick="fnView('<?=$list["hero_idx"]?>')" style="cursor:pointer">
	<td><?=$i?></td>
	<td><?=$gubun_txt?></td>
	<td><?=$list["gisu_year"]?>�� <?=$list["gisu_month"]?>��</td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=$list["hero_name"]?></td>
	<td><?=substr($list["hero_today"],0,10)?></td>
</tr>
<? 
	$i--;
	}
} else {?>
<tr>
	<td colspan="7">��ϵ� �����Ͱ� �����ϴ�.</td>
</tr>
<? } ?>
</table>

<div class="btnGroup">
	<div class="r">
		<a href="javascript:;" onClick="fnWrite()" class="btnAdd">���</a>
	</div>
</div>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){
	fnWrite = function(){
		$("input[name='view']").val("loyalWrite");
		$("#searchForm").attr("action","").submit();
	}
	
	fnView = function(hero_idx) {
		$("input[name='hero_idx']").val(hero_idx);
		$("input[name='view']").val("loyalWrite");
		$("#searchForm").attr("action","").submit();
	}

	fnExcel = function(){
		$("#searchForm").attr("action","<?=ADMIN_DEFAULT?>/user/loyalExcel.php").submit();
	}

	fnSearch = function() {
		$("input[name='page']").val("1");
		$("#searchForm").attr("action","").submit();
	}

	fnPopPeriod = function(){
		var popPeriod = window.open("<?=ADMIN_DEFAULT?>/user/popLoyalMainPeriod.php","popPoint","width=660, height=500");
		popPeriod.focus();
	}
})
</script>