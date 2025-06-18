<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 문수영)2018년 11월 22일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################

$hero_old_idx = $_GET["hero_old_idx"];

?>
<style>
.tbForm th{background:#eee; border:1px solid #cdcdcd; height:30px;}
.tbForm td{border:1px solid #cdcdcd; height:30px; padding:0 10px;}
.tbForm td input[type="text"]{width:100%;}
.tbForm td.c{text-align:center;}
</style>


<?php 

	$list_sql =  " SELECT hero_id, hero_title, hero_name, hero_nick, hero_point, hero_today FROM point  ";
	$list_sql .= " WHERE hero_old_idx = '".$hero_old_idx."' AND hero_type='mission_excel' "; 
	$list_sql .= " ORDER BY hero_idx ASC ";
	
	$out_sql = mysql_query($list_sql);	
?>
<form id="searchForm" name="searchForm" method="get" >
<input type="hidden" name="hero_old_idx" value="<?=$_GET["hero_old_idx"]?>" />
</form>
<div style="margin:30px 0 0 0;">
	<h2 style="font-size:18px;">체험단 포인트 지급 내역</h2>
	<div class="btnGroupR">
		 <a href="javascript:;" onclick="excel()" class="btn_blue2">엑셀다운로드</a>
	</div>
	<table class="tbForm" style="width:100%; margin:20px 0 0 0;">
		<colgroup>
			<col width="15%" />
			<col width="*" />
			<col width="15%" />
			<col width="15%" />
			<col width="15%" />
			<col width="15%" />
		</colgroup>
		<tr>
			<th>지급일</th>
			<th>체험단 명</th>
			<th>아이디</th>
			<th>이름</th>
			<th>닉네임</th>
			<th>포인트</th>
		</tr>
		<? while($list = @mysql_fetch_assoc($out_sql)){ ?>
		<tr>
			<td class="c"><?=$list["hero_today"];?></td>
			<td><?=$list["hero_title"];?></td>
			<td class="c"><?=$list["hero_id"];?></td>
			<td class="c"><?=$list["hero_name"];?></td>
			<td class="c"><?=$list["hero_nick"];?></td>
			<td class="c"><?=$list["hero_point"];?>P</td>
		</tr>
		<? } ?>
	</table>
</div>

<div style="text-align:right; margin:20px 0 0 0;"><a href="<?=ADMIN_DEFAULT?>/index.php?board=nail&idx=91" class="btn_blue2">목록</a></div>
<script>
function excel() {
	$('#searchForm').attr('action','nail/excel_04_01.php').submit();
	$('#searchForm').attr('action', '<?=PATH_HOME.'?'.get('page');?>');
}
</script>
	

                        