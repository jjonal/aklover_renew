<?
if(!defined('_HEROBOARD_'))exit;

if($_GET["startDate"] && $_GET["endDate"]) {

	$startDate = substr($_GET["startDate"],0,7);
	$endDate = substr($_GET["endDate"],0,7); 
	
	$search = " AND date_format(hero_oldday,'%Y-%m') >= '".$startDate."' AND date_format(hero_oldday,'%Y-%m') <= '".$endDate."' ";
	
	$sql  = " SELECT * FROM ";
	$sql .= " ( SELECT month ";
	$sql .= " , count(*) as total_cnt "; 
 	$sql .= " , SUM(if((DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0,1,0)) AS viral_cnt "; 
 	$sql .= " , SUM(if(ifnull(length(hero_blog_00),0) > 0 && (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0 ,1,0)) AS naver "; 
 	$sql .= " , SUM(if(ifnull(length(hero_blog_04),0) > 0 && (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0,1,0)) AS insta ";
 	$sql .= " , SUM(if(ifnull(length(hero_blog_00),0) > 0 && ifnull(length(hero_blog_04),0) > 0 && (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0,1,0)) naver_and_insta "; 
	$sql .= " , SUM(if((ifnull(length(hero_blog_00),0) > 0 || ifnull(length(hero_blog_04),0) > 0) && (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) >= 20 AND (DATE_FORMAT(NOW(),'%Y') - substr(hero_jumin,1,4) + 1) <= 40 AND hero_sex = 0,1,0)) naver_or_insta ";
	$sql .= " FROM ( ";
	$sql .= " SELECT date_format(hero_oldday,'%Y%m') month, hero_jumin, hero_sex, hero_blog_00, hero_blog_04 ";
	$sql .= " FROM member WHERE hero_use = 0 ".$search;
	$sql .= " ) a GROUP BY month WITH rollup ) a ORDER BY month DESC ";

	$res = sql($sql,"on");
}
?>
<div class="view_title_box">
	<p>* ���̷� �����(���� 20~40, ����)</p>
</div>
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
			<input type="text" name="startDate" class="dateMode" value="<?=$startDate?>"> ~ 
			<input type="text" name="endDate" class="dateMode" value="<?=$endDate?>">
		</td>
	</tr>
</table>
<div class="btnGroupSearch">
	<a href="javascript:;" onClick="fnSearch()" class="btnSearch">�˻�</a>
</div>
</form>

<div class="btnGroupFunction">
	<div class="rightWrap">
		<a href="javascript:;" class="btnFormExcel" onClick="fnExcel();">�ٿ�ε�</a>
	</div>
</div>

<table class="t_list">
<colgroup>
	<col width="15%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
	<col width="10%" />
</colgroup>
<thead>
<tr>
	<th rowspan="2">����</th>
	<th colspan="4">(��) ���̷� �����</th>
	<th rowspan="2">�ű� �Ϲ�ȸ��</th>
	<th rowspan="2">�ű� ���̷� �����</th>
</tr>
<tr>
	<th>���̹� ��α�</th>
	<th>�ν�Ÿ</th>
	<th>��α� && �ν�Ÿ</th>
	<th>��α� or �ν�Ÿ</th>
</tr>
</thead>
<? 
$i = 0;
while($list = mysql_fetch_assoc($res)) {?>
<tr>
	<td>
		<? if($list["month"]) { ?>
		<?=substr($list["month"],0,4)?>�� <?=substr($list["month"],4,2)?>��
		<? } else { ?>
		�Ұ�
		<? } ?>
	</td>
	<td><?=number_format($list["naver"])?>��</td>
	<td><?=number_format($list["insta"])?>��</td>
	<td><?=number_format($list["naver_and_insta"])?>��</td>
	<td><?=number_format($list["naver_or_insta"])?>��</td>
	<td><?=number_format($list["total_cnt"])?>��</td>
	<td><?=number_format($list["viral_cnt"])?>��</td>
</tr>
<? $i++;} ?>
<? if($i==0) {?>
<tr>
	<td colspan="7">�Ⱓ �˻��� ������ �ּ���.</td>
</tr>
<? } ?>
</table>

<script>
$(document).ready(function(){
	fnSearch = function() {

		if(!$("input[name='startDate']").val()) {
			alert("�������� �Է��� �ּ���.");
			$("input[name='startDate']").focus();
			return;
		}

		if(!$("input[name='endDate']").val()) {
			alert("�������� �Է��� �ּ���.");
			$("input[name='endDate']").focus();
			return;
		}
		
		$("#searchForm").attr("action","").submit();
	}

	fnExcel = function() {
		$("#searchForm").attr("action","/loaksecure21/data/excel_viral.php").submit();
	}
})
</script>
