<?
if(!defined('_HEROBOARD_'))exit;

$search = "";

if(strcmp($_GET['kewyword'], '')){
    if($_GET['select']=='hero_all'){
		$search = ' and ( m.hero_id like \'%'.$_GET['kewyword'].'%\' or s.hero_title like \'%'.$_GET['kewyword'].'%\' or b.hero_command like \'%'.$_GET['kewyword'].'%\')';    	
	}else{
		$search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
	}
}

if($_REQUEST['category_select']) {
	$search_category = "in('".$_REQUEST['category_select']."')";
}else {
	$search_category = "in('group_04_05', 'group_04_06', 'group_04_07', 'group_04_08', 'group_04_23')";
}
$search_next.="&list_count=".$_REQUEST['list_count']."";

$total_sql  = " SELECT count(*) cnt ";
$total_sql .= " FROM board b ";
$total_sql .= " LEFT JOIN hero_group g ON b.hero_table = g.hero_board ";
$total_sql .= " LEFT JOIN member m ON b.hero_code = m.hero_code ";
$total_sql .= " LEFT JOIN mission s ON b.hero_01 = s.hero_idx ";
$total_sql .= " WHERE b.hero_table ".$search_category." AND (hero_board_three='1' or b.hero_table='group_04_10') ".$search;
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

$sql  = " SELECT b.hero_idx, b.hero_title, b.hero_today, b.hero_order , g.hero_title as menu, m.hero_id, m.hero_name ";
$sql .= " , m.hero_nick";
$sql .= " , s.hero_title as mission_title ";
$sql .= " FROM board b ";
$sql .= " LEFT JOIN hero_group g ON b.hero_table = g.hero_board ";
$sql .= " LEFT JOIN member m ON b.hero_code = m.hero_code ";
$sql .= " LEFT JOIN mission s ON b.hero_01 = s.hero_idx ";
$sql .= " WHERE b.hero_table ".$search_category." AND (hero_board_three='1' or b.hero_table='group_04_10') ".$search;
$sql .= " ORDER BY hero_idx DESC LIMIT ".$start.",".$list_page;

sql($sql);
######################################################################################################################################################
if(!strcmp($_GET['type'], 'edit')){
    $post_count = @count($_POST['hero_idx']);
    for($i=0;$i<$post_count;$i++){
        reset($_POST);
        unset($sql_one_update);
        $idx = $_POST['hero_idx'][$i];
        $data_i = '1';
        $count = @count($_POST);
        while(list($post_key, $post_val) = each($_POST)){
           if(!strcmp($post_key, 'hero_idx')){
                $data_i++;
                continue;
            }
            if(!strcmp($count, $data_i)){
                $comma = '';
            }else{
                $comma = ', ';
            }
            $sql_one_update .= $post_key.'=\''.$_POST[$post_key][$i].'\''.$comma;
        $data_i++;
        }
        $sql = 'UPDATE board SET '.$sql_one_update.' WHERE hero_idx = \''.$idx.'\';'.PHP_EOL;
        mysql_query($sql);
    }
    echo '<script>location.href="'.PATH_HOME.'?'.get('type','').'"</script>';
    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type','').'"');
    exit;
}
if(!strcmp($_GET['action'], 'ok')){
    $sql = 'UPDATE board SET hero_02=\'1\' WHERE hero_idx = \''.$_GET['new_idx'].'\';'.PHP_EOL;
    @mysql_query($sql);
    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('action||new_idx','').'"');
    exit;
}else if(!strcmp($_GET['action'], 'no')){
    $sql = 'UPDATE board SET hero_order="0", hero_02=null, hero_board_three=\'0\' WHERE hero_idx = \''.$_GET['new_idx'].'\';'.PHP_EOL;
    @mysql_query($sql);
    msg('��� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('action||new_idx','').'"');
    exit;
}
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
		<th>ü���</th>
		<td>
			<select name="category_select">
				<option value="">����</option>
		    	<option value="group_04_05" <?=$_GET["category_select"]=="group_04_05" ? "selected":""?>>ü���</option>
				<option value="group_04_06" <?=$_GET["category_select"]=="group_04_06" ? "selected":""?>>��ƼŬ��</option>
				<option value="group_04_28" <?=$_GET["category_select"]=="group_04_28" ? "selected":""?>>������Ŭ��</option>
				<option value="group_04_27" <?=$_GET["category_select"]=="group_04_27" ? "selected":""?>>��Ʃ��</option>
				<option value="group_04_07" <?=$_GET["category_select"]=="group_04_07" ? "selected":""?>>�ְ�ڽ�</option>
				<option value="group_04_08" <?=$_GET["category_select"]=="group_04_08" ? "selected":""?>>���ڴ�</option>
				<option value="group_04_23" <?=$_GET["category_select"]=="group_04_23" ? "selected":""?>>�ֽ�Ŭ��</option>
		    </select>
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td>
			<select name="select">
		    	<option value="m.hero_id" <?=$_GET["select"]=="m.hero_code" ? "selected":""?>>���̵�</option>
				<option value="m.hero_nick" <?=$_GET["select"]=="m.hero_nick" ? "selected":""?>>�г���</option>
				<option value="s.hero_title" <?=$_GET["select"]=="s.hero_title" ? "selected":""?>>ü��ܸ�</option>
				<option value="b.hero_command" <?=$_GET["select"]=="b.hero_command" ? "selected":""?>>����</option>
				<option value="hero_all" <?=$_GET["select"]=="hero_all" ? "selected":""?>>���̵�+ü��ܸ�+����</option>
	    	</select>
	    	<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">		
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div>

<div class="listExplainWrap">
	<label>�� </label> : <strong><?=number_format($total_data)?></strong>��
</div>

<div class="btnGroupFunction">
	<div class="leftWrap">
		<a href="javascript:;" class="btnFunc" onClick="fnOrder()">��������</a>
	</div>
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">����ı� �ٿ�ε�</a>
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
<!-- 21-04-29 ����(���, ����) ��������� ��� ���ϴ� ����ΰ� ���� ���� ó���� -->
<form name="listForm" id="listForm" method="POST">
<input type="hidden" name="mode" value="order" />
<table class="t_list">
<colgroup>
	<col width="4%" />
	<col width="10%" />
	<col width="*" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="15%" />
	<col width="5%" />
</colgroup>
<thead>
	<tr>
		<th>NO</th>
		<th>ī�װ�</th>
		<th>ü��ܸ�</th>
		<th>���̵�</th>
		<th>�г���</th>
		<th>�̸�</th>
		<th>����ı� �����</th>
		<th>����</th>
	</tr>
</thead>
<? 
if($total_data > 0) {
while($list = @mysql_fetch_assoc($out_sql)){ ?>
<tr>
	<td><?=$i?></td>
	<td><?=$list["menu"]?></td>
	<td class="title"><?=$list["mission_title"]?></td>
	<td><?=$list["hero_id"]?></td>
	<td><?=$list["hero_nick"]?></td>
	<td><?=name_masking($list["hero_name"])?></td>
	<td><?=$list["hero_today"]?></td>
	<td><input type="text" name="hero_order[]" value="<?=$list["hero_order"]?>" style="text-align:center;" numberOnly />
		<input type="hidden" name="hero_idx[]" value="<?=$list["hero_idx"]?>" />
	</td>
</tr>
<? 
$i--;
}
} else {
?>
<tr>
	<td colspan="8">��ϵ� �����Ͱ� �����ϴ�.</td>
</tr>
<? } ?>
</table>
</form>

<div class="pagingWrap">
<? include_once PATH_INC_END.'page.php';?>
</div>
<script>
$(document).ready(function(){
	fnExcel = function() {
		$("#searchForm").attr("action","/loaksecure21/nail/03_excel.php").submit();
	}
	
	fnListCount = function() {
		$("#searchForm").attr("action","").submit();
	}

	fnSearch = function() {
		$("#searchForm").attr("action","").submit();
	}

	fnOrder = function() {
		if(confirm("������ �����Ͻðڽ��ϱ�?")) {
			$.ajax({
				url:"/loaksecure21/nail/03_action.php"
				,type:"POST"
				,data:$("#listForm").serialize()
				,dataType:"json"
				,success:function(data){
					if(data.result) {
						alert("���� ����Ǿ����ϴ�.");
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
});
</script>



