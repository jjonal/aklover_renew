<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if($_GET['hero_today_start']) {
	$search .= " AND FROM_UNIXTIME(hero_out_date,'%Y-%m-%d') >= '".$_GET['hero_today_start']."' ";
}

if($_GET['hero_today_end']) {
	$search .= " AND FROM_UNIXTIME(hero_out_date,'%Y-%m-%d') <= '".$_GET['hero_today_end']."' ";
}

if(strlen($_GET['hero_out_reason']) > 0) {
	$search .= " AND hero_out_reason = '".$_GET['hero_out_reason']."' ";
}

if($_GET['kewyword']) {
	$search .= " AND ".$_GET["select"]." LIKE '%".$_GET['kewyword']."%' ";
}

//������ �ѹ���
$total_sql = " SELECT count(*) AS cnt FROM member WHERE hero_use=1 ".$search;

sql($total_sql);
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
$sql  = " SELECT hero_nick, hero_id, hero_out_reason, hero_out, hero_out_date FROM member ";
$sql .= " WHERE hero_use = 1 ".$search." ORDER BY hero_out_date DESC ";
$sql .= " LIMIT ".$start.",".$list_page;

$list_res = sql($sql);

$hero_out_reason_arr = array("0"=>"������ Ż��","1"=>"������ ���� ���","2"=>"����Ʈ �̿��� �����ؼ�","3"=>"���� ��� �� ������ ���� �߻��Ǿ�","4"=>"�������� ������ �η�����","8"=>"�޸�ȸ�� 3���̻� �ڵ��ı�","9"=>"��Ÿ")
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
		<th>Ż�� �Ⱓ</th>
		<td>
			<input type="text" name="hero_today_start" class="dateMode" value="<?=$_GET["hero_today_start"]?>"/> ~ <input type="text" name="hero_today_end" class="dateMode" value="<?=$_GET["hero_today_end"]?>"/>
		</td>
	</tr>
	<tr>
		<th>Ż�� ����</th>
		<td>
			<select name="hero_out_reason">
				<option value="">����</option>
				<option value="1" <?=$_GET['hero_out_reason']=="1" ? "selected":""?>>������ ���� ���</option>
				<option value="2" <?=$_GET['hero_out_reason']=="2" ? "selected":""?>>����Ʈ �̿��� �����ؼ�</option>
				<option value="3" <?=$_GET['hero_out_reason']=="3" ? "selected":""?>>���� ��� �� ������ ���� �߻��Ǿ�</option>
				<option value="4" <?=$_GET['hero_out_reason']=="4" ? "selected":""?>>�������� ������ �η�����</option>
				<option value="9" <?=$_GET['hero_out_reason']=="9" ? "selected":""?>>��Ÿ</option>
				<option value="0" <?=$_GET['hero_out_reason']=="0" && strlen($_GET['hero_out_reason']) > 0 ? "selected":""?>>������ Ż��</option>
				<option value="8" <?=$_GET['hero_out_reason']=="8" ? "selected":""?>>�޸�ȸ�� 3���̻� �ڵ��ı�</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
		    	<option value="hero_nick" <?if(!strcmp($_REQUEST['select'], 'hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
		    	<option value="hero_id" <?if(!strcmp($_REQUEST['select'], 'hero_id')){echo ' selected';}else{echo '';}?>>���̵�</option>
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

<table class="t_list">
<thead>
<tr>
	<th width="5%">NO</th>
	<th width="10%">���̵�</th>
	<th width="10%">�г���</th>
	<th width="15%">Ż�����</th>
	<th width="*">�������</th>
	<th width="10%">Ż����</th>
</tr>
</thead>
<? 
if($total_data > 0) {
while($list = @mysql_fetch_assoc($list_res)){ ?>
<tr>
	<td><?=$i?></td>
	<td><?=$list['hero_id'];?></td>
	<td><?=$list['hero_nick'];?></td>
	<td><?=$hero_out_reason_arr[$list['hero_out_reason']];?></td>
	<td class="title"><?=$list['hero_out'];?></td>
	<td><?=date('Y-m-d H:i:s',$list['hero_out_date']);?></td>
</tr>
<?
	$i--;
	}
} else {
?>
<tr>
	<td colspan="5">��ϵ� �����Ͱ� �����ϴ�.</td>
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
})
</script>
						
