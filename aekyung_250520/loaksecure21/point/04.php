<?
if(!defined('_HEROBOARD_'))exit;

$total_sql  = " SELECT count(*) as cnt FROM (";
$total_sql .= " SELECT m.hero_idx FROM mission_point_upload m ";
$total_sql .= " INNER JOIN point p on m.hero_idx = p.hero_old_idx AND p.hero_type='mission_excel' ";
$total_sql .= " GROUP BY m.hero_idx ) m ";

sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];

$i=$total_data;

$list_page = 20;
$page_per_list = 10;

if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];

$i = $i-($page-1)*$list_page;


$start = ($page-1)*$list_page;
$next_path=get("page");

$sql =  " SELECT m.hero_today,m.hero_idx, p.hero_point, p.hero_title, count(m.hero_idx) cnt FROM mission_point_upload m ";
$sql .= " inner join point p on m.hero_idx = p.hero_old_idx and p.hero_type='mission_excel' ";
$sql .= " group by m.hero_idx order by m.hero_idx DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql);
?>
<form name="searchForm" id="searchForm" action="<?=PATH_HOME.'?'.get('page');?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>" />
<input type="hidden" name="hero_idx" value="" />
<input type="hidden" name="board" value="<?=$_GET["board"]?>" />
<input type="hidden" name="view" value="" />
<input type="hidden" name="page" value="<?=$page?>" />
</form>
<div class="view_title_box">
	<p>�� ��ۺ� ���� ����� �̿��Ͻ� �� �����ϴ�. ��ۺ� ���� ����� �ı���� > ü���(��û��)���� �̿밡���մϴ�</p>
</div>

<div class="listExplainWrap">
<label>�� </label> : <strong><?=$total_data?></strong>��
</div>

<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFunc" onClick="fnPoint();">����Ʈ ���� ���ε�</a>
	</div>
</div>

<table class="t_list">
<colgroup>
	<col width="20%" />
	<col width="*" />
	<col width="20%" />
	<col width="20%" />
	<col width="10%" />
</colgroup>
<thead>
	<tr>
		<th>������</th>
		<th>ü��� ��</th>
		<th>����Ʈ</th>
		<th>����Ʈ ���� �ο� ��</th>
		<th>����Ȯ��</th>
	</tr>
</thead>
<?  while($list = @mysql_fetch_assoc($list_res)){  ?>
<tr>
	<td><?=$list["hero_today"];?></td>
	<td class="title"><?=$list["hero_title"];?></td>
	<td><?=$list["hero_point"];?>P</td>
	<td><?=$list["cnt"];?>��</td>
	<td><a href="javascript:;" onClick="fnView('<?=$list["hero_idx"];?>');" class="btnForm">Ȯ��</a></td>
</tr>
<? } ?>
</table>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){
	fnView = function(hero_idx){
		$("input[name='hero_idx']").val(hero_idx);
		$("input[name='view']").val("04_01");
		$("#searchForm").submit();
		//location.href = "<?=ADMIN_DEFAULT?>/index.php?board=nail&idx=91&view=04_01&hero_old_idx="+hero_idx;
	}

	fnPoint = function(){
		var popPoint = window.open("/loaksecure21/point/pop04.php","popPoint","width=660, height=500");
		focus();
	}
})
</script>

	

                        