<?php 
if(!defined('_HEROBOARD_'))exit;

$startdate = "";
$enddate = "";
if($_POST["startdate"]) $startdate  = strtotime($_POST["startdate"]);
if($_POST["enddate"]) $enddate = strtotime($_POST["enddate"]);


if($_GET["type"] == "edit") {
	$sql_view = " SELECT hero_idx, hero_title, startdate, enddate FROM goods_manager WHERE hero_idx = '".$_GET["hero_idx"]."' ";
	$view_out_sql  = @mysql_query($sql_view);
	
	$view = mysql_fetch_assoc($view_out_sql);
	$view["startdate"] = date("Y-m-d H:i",$view["startdate"]);
	$view["enddate"] = date("Y-m-d H:i",$view["enddate"]);
}

$sql = "";
if($_POST["type"] == "write") {
	$sql =  " INSERT INTO goods_manager (hero_code, hero_title, startdate, enddate, hero_today, hero_use) VALUES ";
	$sql .= " ('".$_SESSION["temp_code"]."','".$_POST["hero_title"]."','".$startdate."','".$enddate."',now(), '0') ";
	mysql_query ( $sql );
	
	msg ( '등록 되었습니다.', 'location.href="' . PATH_HOME . '?' . get ( 'type||view', '' ) . '"' );
	exit ();
} else if($_POST["type"] == "update") {
	$sql =   " UPDATE goods_manager SET hero_code = '".$_SESSION["temp_code"]."' ";
	$sql .= " , hero_title = '".$_POST["hero_title"]."' ";
	$sql .= " , startdate = '".$startdate."' ";
	$sql .= " , enddate = '".$enddate."' ";
	$sql .= " WHERE hero_idx = '".$_POST["hero_idx"]."' ";
	
	mysql_query ( $sql );
	
	msg ( '수정 되었습니다.', 'location.href="' . PATH_HOME . '?' . get ( 'type||view', '' ) . '"' );
	exit ();

} else if($_POST["type"] == "drop") {
	$sql =  " UPDATE  goods_manager SET hero_use = '1' WHERE hero_idx = '".$_POST["hero_idx"]."' ";
	mysql_query ( $sql );
	
	msg ( '삭제 되었습니다.', 'location.href="' . PATH_HOME . '?' . get ( 'type||view', '' ) . '"' );
	exit ();
}

?>
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/daterangepicker.css" />
<script src="<?=ADMIN_DEFAULT?>/js/moment.min.js"></script>
<script src="<?=ADMIN_DEFAULT?>/js/jquery.daterangepicker.js"></script>
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>
<form name="form_next" id="form_next" action="<?=PATH_HOME.'?'.get('','type=edit');?>" method="post">
<input type="hidden" name="type" id="type" value="" />
<input type="hidden" name="hero_idx" value="<?=$view["hero_idx"]?>" />

<table class="t_view">
	<colgroup>
		<col width="20%">
		<col width="80%">
	</colgroup>
	<tbody>
	<tr>
		<th>상품관리명</th>
		<td><input type="text" name="hero_title" value="<?=$view["hero_title"]?>" /></td>
	</tr>
	<tr>
		<th>축제 기간</th>
		<td><input type="text" name="startdate" id="startdate" value="<?=$view["startdate"]?>" style="width:140px" /> ~ 
			<input type="text" name="enddate" id="enddate" value="<?=$view["enddate"]?>" style="width:140px"/></td>
	</tr>
	</tbody>
</table>
</form>

<div class="btnGroup">
	<div class="l">
		<a href="javascript:;" onClick="goList();" class="btnList">목록</a>
	</div>
	<div class="r">
		<? if($view["hero_idx"]) { ?>
			<a href="javascript:;" onClick="goDrop();" class="btnDel">삭제</a>
			<a href="javascript:;" onClick="goUpdate();" class="btnAdd">수정</a>
		<? } else { ?>
			<a href="javascript:;" onClick="goWrite();" class="btnAdd">등록</a>
		<? } ?>
	</div>
</div>

<script>
$(function(){
	$("#startdate").AnyTime_picker( {
    	format: "%Y-%m-%d %H:%i:00"
 	}); 
	$("#enddate").AnyTime_picker( {
    	format: "%Y-%m-%d %H:%i:00"
 	});  

	goWrite = function() {
		$("#type").val("write");
		$("#form_next").submit();
	}

	goDrop =function() {
		if(confirm("삭제하시겠습니까?")) {
			$("#type").val("drop");
			$("#form_next").submit();
		}
	}

	goUpdate = function(){
		$("#type").val("update");
		$("#form_next").submit();
	}

	goList = function() {
		location.href="<?=PATH_HOME?>?<?=get ( 'type||view', '' )?>";
	}
});
</script>
                             