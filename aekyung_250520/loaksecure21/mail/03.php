<?
if(!defined('_HEROBOARD_'))exit;

$search = " and (SUBSTRING_INDEX(hero_code,'_',1)!='admin' and SUBSTRING_INDEX(hero_code,'_',1)!='aekyung') ";

if(strcmp($_GET['kewyword'], '')){
    if($_GET['select']=='hero_all'){
		$search .= ' and ( hero_user like \'%'.$_GET['kewyword'].'%\' or hero_title like \'%'.$_GET['kewyword'].'%\' or hero_command like \'%'.$_GET['kewyword'].'%\')';
	}else{
		$search .= ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
	}
}

$total_sql =  " SELECT count(*) AS cnt FROM mail WHERE hero_use=1 ".$search;
sql($total_sql);
$out_res = mysql_fetch_assoc($out_sql);
$total_data = $out_res['cnt'];

$i=$total_data;

$list_page=5;
$page_per_list=10;
  
if(!strcmp($_GET['page'], ''))		$page = '1';
else								$page = $_GET['page'];
	
$i = $i-($page-1)*$list_page;

$start = ($page-1)*$list_page;
$next_path=get("page");

$sql = " SELECT * FROM mail WHERE hero_use= 1 ".$search." ORDER BY hero_today DESC LIMIT ".$start.",".$list_page;

sql($sql);

if(!strcmp($_GET['type'], 'drop')){
    $sql = 'DELETE FROM mail WHERE hero_idx = \''.$_GET['hero_idx'].'\';';
    sql($sql);
    msg('삭제 되었습니다.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
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
		<th>검색어</th>
		<td>
			<select name="select">
				<option value="hero_user"<?if(!strcmp($_REQUEST['select'], 'hero_user')){echo ' selected';}else{echo '';}?>>아이디</option>
				<option value="hero_title"<?if(!strcmp($_REQUEST['select'], 'hero_title')){echo ' selected';}else{echo '';}?>>제목</option>
			  	<option value="hero_command"<?if(!strcmp($_REQUEST['select'], 'hero_command')){echo ' selected';}else{echo '';}?>>내용</option>
			  	<option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>아이디+제목+내용</option>
			</select>
			<input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];;?>" class="kewyword">
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">검색</a>
</div>
</form>

<div class="listExplainWrap mgb10">
<label>총 </label> : <strong><?=number_format($total_data)?></strong>건</span>
</div>

<table class="t_list">
<colgroup>
	<col width="3%" />
	<col width="8%" />
	<col width="10%" />
	<col width="20%" />
	<col width="*" />
	<col width="8%" />
	<col width="6%" />
	<col width="10%" />
	<col width="5%" />
</colgroup>
<thead>
<tr>
	<th>NO</th>
	<th>보낸사람</th>
    <th>받는사람</th>
    <th>제목</th>
    <th>내용(알림톡)</th>
    <th>내용(쪽지함)</th>
    <th>등록일</th>
	<th>수신확인</th>
    <th>설정</th>
</tr>
</thead>                                
<tbody>
<?
if($total_data > 0) {
while($list = @mysql_fetch_assoc($out_sql)){
	$level_sql = 'select * from level where hero_use=\'0\' and hero_level='.$list['hero_level'].' order by hero_level desc;';//desc<=
	$out_level_sql = mysql_query($level_sql);
	$level_list = @mysql_fetch_assoc($out_level_sql);
?>
<tr>
	<td><?=$i?></td>
	<td><?=$list['hero_nick']." <br> (".substr($list['hero_code'],0,-11).")"?></td>
	<td><textarea name="hero_user" style="width:120px;height:100px;"><?=$list['hero_user'];?></textarea></td>
	<td><textarea name="hero_title" style="width:90%;height:100px"><?=$list['hero_title'];?></textarea></td>
	<td><textarea name="hero_command" style="width:90%;height:100px"><?=$list['hero_command'];?></textarea></td>
	<td><? if(!empty($list["hero_command2"])) {?><a href="javascript:;" onClick="fnPopCommand2('<?=$list["hero_idx"]?>')" class="btnFunc">확인</a><? }?></td>
	<td><?=substr($list['hero_today'],0,10);?></td>
	<td><? if(strcmp($list['hero_user_check'],'')){echo "확인<br><textarea name='hero_user_check' style='height:80px;color:blue;'>".str_replace("||","\r\n",$list['hero_user_check'])."</textarea>";}else{echo "미확인";} ?></td>
	<td><a href="javascript:location.href='<?=PATH_HOME.'?'.get('','type=drop&hero_idx='.$list['hero_idx']);?>'" class="btnForm">삭제</a></td>
</tr>
<?
	$i--;
	}
} else { ?>
<tr>
	<td colspan="8">등록된 데이터가 없습니다.</td>
</tr>
<? } ?>
</tbody>
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

fnPopCommand2 = function(hero_idx) {
	var popWrite = window.open("/loaksecure21/mail/popCommand2.php?hero_idx="+hero_idx,"popWrite","width=760, height=500");
	popWrite.focus();
}
</script>
