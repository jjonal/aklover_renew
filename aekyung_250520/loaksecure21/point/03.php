<? 
if(!defined('_HEROBOARD_'))exit;

$sql = " SELECT * FROM level WHERE hero_use = 0 AND hero_level <= '".$_SESSION['temp_level']."' ORDER BY hero_level ASC ";
$list_res = sql($sql);

if($_GET["type"]=="edit") {
	$update_sql  = " UPDATE level SET hero_point_01 = '".$_GET["hero_point_01"]."', hero_point_02 = '".$_GET["hero_point_02"]."' WHERE hero_idx = '".$_GET["hero_idx"]."' ";
	$result = sql($update_sql);
	
	if($result) {
		msg("�����Ǿ����ϴ�.");
		location(PATH_HOME.'?'.get('type'));
		exit;
	} else {
		error_historyBack("���� �����߽��ϴ�.");
		exit;
	}
}
?>
<table class="t_list">
<thead>
<tr>
	<th width="50%">����</th>
 	<th width="50%">������</th>
</tr>
</thead>
<? while($list = @mysql_fetch_assoc($list_res)){ ?>
<form name="form_next<?=$i?>" action="<?=PATH_HOME.'?'.get('');?>"> 
<input type="hidden" name="hero_idx" value="<?=$list['hero_idx'];?>">
<input type="hidden" name="idx" value="<?=$_GET["idx"]?>">
<input type="hidden" name="board" value="point">
<input type="hidden" name="type" value="edit">
<tr>
	<td><?=$list['hero_level'];?></td>
	<td><?=$list['hero_name'];?></td>
</tr>
</form>
<?
	$i++;
}
?>
</table>
