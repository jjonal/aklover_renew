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
	<th width="20%">사이트 타이틀</th>
	<th width="50%">메타검색 키워드</th>
	<th width="20%">마지막 설정일</th>
	<th width="10%">설정하기</th>
</tr>
</thead>
<tbody>
<form name="form_next" method="post" onsubmit="return false;"  action="<?=url('PATH_HOME||board||'.$_GET['board'].'||&view=02_action&idx='.$_GET['idx']);?>">
<input name="hero_idx" value="<?=$list['hero_idx'];?>" type="hidden">
<input name="hero_table" value="hero_group" type="hidden">
<input name="action" value="update" type="hidden">
<tr>
	<td><input style="width:90%;" name="hero_alt[]" required="yes" message="사이트타이틀" value="<?=$data['0'];?>" type="text"></td>
	<td><input style="width:90%;" name="hero_alt[]" required="yes" message="검색키워드" value="<?=$data['1'];?>" type="text"></td>
	<td><?=$data['2'];?></td>
	<td><a href="javascript:form_next.submit();" class="btnForm">설정</a></td>
</tr>
</form>
</tbody>
</table>                                
