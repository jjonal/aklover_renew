<?
if(!defined('_HEROBOARD_'))exit;

$search = " and (SUBSTRING_INDEX(m.hero_code,'_',1)='admin' or SUBSTRING_INDEX(m.hero_code,'_',1)='aekyung') ";

if(strcmp($_GET['kewyword'], '')){
    if($_GET['select']=='hero_all'){
		$search .= ' and ( m.hero_user like \'%'.$_GET['kewyword'].'%\' or m.hero_title like \'%'.$_GET['kewyword'].'%\' or m.hero_command like \'%'.$_GET['kewyword'].'%\' or u.hero_nick like \'%'.$_POST['kewyword'].'%\')';
    } else if($_GET['select']=='m.hero_command'){
        $search .= ' and (m.hero_command like \'%'.$_GET['kewyword'].'%\' or m.hero_command2 like \'%'.$_GET['kewyword'].'%\')';
    } else {
		$search .= ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
	}
}

if(strcmp($_REQUEST['alrimtalk_type'], '')){	
	if($_REQUEST['alrimtalk_type'] == "4") {
		$search .= " and (alrimtalk_type = '4' || alrimtalk_type = '' || alrimtalk_type is null) ";
	} else {	
		$search .= " and alrimtalk_type = '".$_REQUEST['alrimtalk_type']."' ";
	}
}

if(strcmp($_REQUEST['send_result_code1'], '')){
	if($_REQUEST['send_result_code1'] == "Y") {
		$search .= " AND a.send_result_code1 = 'OK' ";
	} else {
		$search .= " AND a.send_result_code1 != 'OK' ";
	}
}

if(strcmp($_REQUEST['send_result_code2'], '')){
	if($_REQUEST['send_result_code2'] == "Y") {
		$search .= " AND a.send_result_code2 = 'OK' ";
	} else {
		$search .= " AND a.send_result_code2 != 'OK' ";
	}
}

if(strcmp($_REQUEST['start_day'], '') && strcmp($_REQUEST['end_day'], '')){
	$search .= " AND (date_format(m.hero_today,'%Y-%m-%d') >= '".$_REQUEST['start_day']."' AND date_format(m.hero_today,'%Y-%m-%d') <= '".$_REQUEST['end_day']."') ";
}

$sql  = " SELECT count(*) AS cnt FROM mail m  ";
$sql .= " LEFT JOIN member u ON m.hero_user = u.hero_id ";
$sql .= " where 1=1 ".$search;
//m.hero_use=1 //���Ͽ����� �ǹ̰� ����

sql($sql);
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

// 210309 �˸��� ���� ��� ���Ϸ� ����
//$sql =  'select m.*,a.send_result_code1, a.send_result_code2, u.hero_nick as receive_nick from mail m LEFT JOIN TSMS_AGENT_MESSAGE_LOG a';
$sql  = ' SELECT m.*, u.hero_nick AS receive_nick FROM mail m ';
//$sql .= ' ON m.hero_idx = a.subject AND m.hero_user = a.register_by ';
$sql .= ' LEFT JOIN member u ON m.hero_user = u.hero_id ';
$sql .= ' WHERE 1=1 '.$search.' order by m.hero_idx desc limit '.$start.','.$list_page;
sql($sql);

if(!strcmp($_GET['type'], 'drop')){
    $sql = " DELETE FROM mail WHERE hero_idx = '".$_GET['hero_idx']."' ";
    sql($sql);
    msg('���� �Ǿ����ϴ�.','location.href="'.PATH_HOME.'?'.get('type||hero_idx','').'"');
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
		<th>�߼���</th>
		<td><input type="text" name="start_day" class="dateMode" value="<?=$_REQUEST['start_day']?>"> ~ <input type="text" name="end_day" class="dateMode" value="<?=$_REQUEST['end_day']?>"></td>
	</tr>
	<tr>
		<th>�˸��� ����</th>
		<td>
			<input type="radio" name="alrimtalk_type" id="alrimtalk_type_all" value="" <?=!$_REQUEST['alrimtalk_type'] ? "checked":"";?>><label for="alrimtalk_type_all">��ü</label>
			<input type="radio" name="alrimtalk_type" id="alrimtalk_type_1" value="1" <?=$_REQUEST['alrimtalk_type']=="1" ? "checked":"";?>><label for="alrimtalk_type_1">���̵���� ���ؼ�</label>
			<input type="radio" name="alrimtalk_type" id="alrimtalk_type_2" value="2" <?=$_REQUEST['alrimtalk_type']=="2" ? "checked":"";?>><label for="alrimtalk_type_2">�ı� �̵��</label>
		    <input type="radio" name="alrimtalk_type" id="alrimtalk_type_3" value="3" <?=$_REQUEST['alrimtalk_type']=="3" ? "checked":"";?>><label for="alrimtalk_type_3">���� ����Ʈ ����</label>
		    <input type="radio" name="alrimtalk_type" id="alrimtalk_type_5" value="5" <?=$_REQUEST['alrimtalk_type']=="5" ? "checked":"";?>><label for="alrimtalk_type_5">����Ȯ��</label>
		    <input type="radio" name="alrimtalk_type" id="alrimtalk_type_6" value="6" <?=$_REQUEST['alrimtalk_type']=="6" ? "checked":"";?>><label for="alrimtalk_type_6">ü��� ��÷</label>
		    <input type="radio" name="alrimtalk_type" id="alrimtalk_type_7" value="7" <?=$_REQUEST['alrimtalk_type']=="7" ? "checked":"";?>><label for="alrimtalk_type_7">��������</label>
		    <input type="radio" name="alrimtalk_type" id="alrimtalk_type_4" value="4" <?=$_REQUEST['alrimtalk_type']=="4" ? "checked":"";?>><label for="alrimtalk_type_4">�˸��� ������</label>
		</td>
	</tr>
	<tr>
		<th>�˻���</th>
		<td><select name="select" >
		    	<option value="u.hero_nick" <?if(!strcmp($_REQUEST['select'], 'u.hero_nick')){echo ' selected';}else{echo '';}?>>�г���</option>
                <option value="m.hero_user" <?if(!strcmp($_REQUEST['select'], 'm.hero_user')){echo ' selected';}else{echo '';}?>>���̵�</option>
                <option value="m.hero_title" <?if(!strcmp($_REQUEST['select'], 'm.hero_title')){echo ' selected';}else{echo '';}?>>����</option>
		 		<option value="m.hero_command"<?if(!strcmp($_REQUEST['select'], 'm.hero_command')){echo ' selected';}else{echo '';}?>>����</option>
		  		<!-- ���϶����� ���� 
		  		<option value="hero_all"<?if(!strcmp($_REQUEST['select'], 'hero_all')){echo ' selected';}else{echo '';}?>>�г���+���̵�+����+����</option>
		   		-->
            </select>
	        <input name="kewyword" type="text" value="<?echo $_REQUEST['kewyword'];?>" class="kewyword">
	    </td>
</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div>
</form>
<div class="listExplainWrap mgb10">
<label>�� </label> : <strong><?=number_format($total_data)?></strong>��</span>
</div>

<table class="t_list">
<colgroup>
	<col width="4%" />
	<col width="6%" />
	<col width="6%" />
	<col width="6%" />
	<col width="14%" />
	<col width="22%" />
	<col width="9%" />
	<col width="7%" />
	<col width="8%" />
	<col width="8%" />
	<col width="5%" />
</colgroup>
<thead>
 	<tr>
		<th>NO</th>
        <th>�������</th>
        <th>�޴»��</th>
        <th>�޴»�� �г���</th>
        <th>����</th>
        <th>����(�˸���)</th>
        <th>����(������)</th>
        <th>�߼���</th>
		<th>����Ȯ��</th>
		<th>�˸���<br/>�߼ۿ���</th>
        <th>����</th>
     </tr>
</thead>
<tbody>
<?
	$arr_alrimtalk_type = array("1"=>"���̵���� ���ؼ�","2"=>"�ı� �̵��","3"=>"���� ����Ʈ ����","4"=>"�˸��� ������","5"=>"���� Ȯ��","6"=>"ü��� ��÷","7"=>"��������");
	if($total_data > 0) {
	while($list = @mysql_fetch_assoc($out_sql)){
	if($list["alrimtalk_type"] == "1" || $list["alrimtalk_type"] == "2" || $list["alrimtalk_type"] == "3") {
		$sql_result_1 = " SELECT send_result_code1 FROM TSMS_AGENT_MESSAGE_LOG WHERE subject  = '".$list["hero_idx"]."' AND register_by = '".$list["hero_user"]."' ";
		$result_1_sql = mysql_query($sql_result_1);
        $alrimTalk_list = @mysql_fetch_assoc($result_1_sql);
                        	
        $sql_result_2 = " SELECT send_result_code2 FROM TSMS_AGENT_MESSAGE_LOG WHERE subject  = '".$list["hero_idx"]."' AND register_by = '".$list["hero_user"]."' ";
       	$result_2_sql = mysql_query($sql_result_2);
      	$sms_list = @mysql_fetch_assoc($result_2_sql);
	}
?>
<tr>
	<td><?=$i?></td>
	<td><?=$list['hero_nick']." <br> (".substr($list['hero_code'],0,-11).")"?></td>
    <td><textarea name="hero_user" style="height:100px;"><?=$list['hero_user'];?></textarea></td>
   	<td><?=$list["receive_nick"]?></td>
    <td><textarea name="hero_title" style="height:100px"><?=$list['hero_title'];?></textarea></td>
    <td><textarea name="hero_command" style="width:90%;height:100px"><?=$list['hero_command'];?></textarea></td>
    <td><? if(!empty($list["hero_command2"])) {?><a href="javascript:;" onClick="fnPopCommand2('<?=$list["hero_idx"]?>')" class="btnFunc">Ȯ��</a><? }?></td>
    <td><?=date( "y-m-d", strtotime($list['hero_today']));?></td>
	<td><? if(strcmp($list['hero_user_check'],'')){echo "Ȯ��<br><textarea name='hero_user_check' style='width:90%;height:80px;color:blue;'>".str_replace("||","\r\n",$list['hero_user_check'])."</textarea>";}else{echo "��Ȯ��";} ?></td>
	<td><?=$arr_alrimtalk_type[$list["alrimtalk_type"]] ? "[".$arr_alrimtalk_type[$list["alrimtalk_type"]]."]":"[������]" ;?><br/>
	<? if($arr_alrimtalk_type[$list["alrimtalk_type"]]) {?>
	�˸��� ��� :
	<? if($alrimTalk_list['send_result_code1']) {?>
		<? if($alrimTalk_list['send_result_code1']=="OK") { ?>
		����
		<? } else { ?>
		����
		<? } ?>
	<? } ?>
	<br/>
	���� ��� :
	<? if($sms_list['send_result_code2']) {?>
		<? if($sms_list['send_result_code2']=="OK") { ?>
		����
		<? } else { ?>
		����
		<? } ?>
	<? } ?>
	<br/>
	<? } ?>
	</td>
    <td><a href="javascript:location.href='<?=PATH_HOME.'?'.get('','type=drop&hero_idx='.$list['hero_idx']);?>'" class="btnForm">����</a></td>
</tr>
<?
$i--;
}
} else {
?>
<tr>
	<td colspan="10">��ϵ� �����Ͱ� �����ϴ�.</td>
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
});


fnPopCommand2 = function(hero_idx) {
	var popWrite = window.open("/loaksecure21/mail/popCommand2.php?hero_idx="+hero_idx,"popWrite","width=760, height=500");
	popWrite.focus();
}
</script>