<?
if(!defined('_HEROBOARD_'))exit;

$sql = 'select * from hero_group where hero_idx=\'1\';';//desc
$sql = out($sql); 
sql($sql);
$list = @mysql_fetch_assoc($out_sql);
$data = explode('||', $list['hero_title']);
?>
<table class="t_list">
<thead>
<tr>
	<th width="20%">����Ʈ Ÿ��Ʋ</th>
	<th width="50%">��Ÿ�˻� Ű����</th>
	<th width="20%">������ ������</th>
	<th width="10%">�����ϱ�</th>
</tr>
</thead>
<tbody>
<form name="form_next" method="post" onsubmit="return false;"  action="<?=url('PATH_HOME||board||'.$_GET['board'].'||&view=02_action&idx='.$_GET['idx']);?>">
<input name="hero_idx" value="<?=$list['hero_idx'];?>" type="hidden">
<input name="hero_table" value="hero_group" type="hidden">
<input name="action" value="update" type="hidden">
<tr>
	<td><input style="width:90%;" name="hero_alt[]" required="yes" message="����ƮŸ��Ʋ" value="<?=$data['0'];?>" type="text"></td>
	<td><input style="width:90%;" name="hero_alt[]" required="yes" message="�˻�Ű����" value="<?=$data['1'];?>" type="text"></td>
	<td><?=$data['2'];?></td>
	<td><a href="javascript:form_next.submit();" class="btnForm">����</a></td>
</tr>
</form>
</tbody>
</table>                                
