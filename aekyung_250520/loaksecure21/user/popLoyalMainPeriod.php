<!DOCTYPE html>
<?
define('_HEROBOARD_', TRUE);
include_once '../../freebest/head.php';
include                                    '../popupSessionCheck.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';

$result = false;

$sql = " SELECT startdate , enddate FROM member_loyal_period ";
$res = sql($sql,"on");
$rs = mysql_fetch_assoc($res);

$mode = "write";
if($rs["startdate"]) {
	$mode = "edit";
}

if($_POST["mode"] == "write") {
	$ins_sql  = " INSERT INTO member_loyal_period (startdate, enddate, hero_month, hero_code, hero_today) VALUES ";
	$ins_sql .= " ('".$_POST["startdate"]."','".$_POST["enddate"]."','".$_POST["hero_month"]."','".$_SESSION["temp_code"]."',now()) ";
	
	$result = sql($ins_sql);
} else if($_POST["mode"] == "edit") {
	$update_sql  = " UPDATE member_loyal_period SET ";
	$update_sql .= " startdate = '".$_POST["startdate"]."' ";
	$update_sql .= " ,enddate = '".$_POST["enddate"]."' ";
	$update_sql .= " ,hero_month = '".$_POST["hero_month"]."' ";
	$update_sql .= " ,hero_code = '".$_SESSION["temp_code"]."' ";
	$update_sql .= " ,hero_today = now(); ";
	
	$result = sql($update_sql);
}

if($result) {
	msg("����Ǿ����ϴ�.");
	location(ADMIN_DEFAULT."/user/popLoyalMainPeriod.php");
}

?>
<meta charset="euc-kr" />
<head>
<link rel="stylesheet" type="text/css" href="/css/general.css"/>
<link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/admin_login.css?v=210517" />
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/admin.css?v=210517" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_END;?>jquery.form.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="<?=ADMIN_DEFAULT?>/js/admin.js"></script>
</head>
<body style="background:none;">
<div class="popupWrap">
	<div class="popHeader">
		<h1>���� ���� �Ⱓ ����</h1>
	</div>
	<div class="popContents">
		<form name="form0" id="form0" method="POST">
		<input type="hidden" name="mode" value="<?=$mode?>" />
		<table class="t_view">
			<colgroup>
				<col width="150px" />
				<col width="*" />
			</colgroup>
			<tbody>
			<tr>
				<th>���� ���� �Ⱓ</th>
				<td>
					<input type="text" name="startdate" class="dateMode" value="<?=$rs["startdate"]?>" style="width:120px;" />
					~
					<input type="text" name="enddate" class="dateMode" value="<?=$rs["enddate"]?>" style="width:120px;" />
				</td>			
			</tr>
			<tr>
				<th>��</th>
				<td>
					<select name="hero_month">
    					<option value="0">��</option>
    					<option value="1">1��</option>
    					<option value="2">2��</option>
    					<option value="3">3��</option>
    					<option value="4">4��</option>
    					<option value="5">5��</option>
    					<option value="6">6��</option>
    					<option value="7">7��</option>
    					<option value="8">8��</option>
    					<option value="9">9��</option>
    					<option value="10">10��</option>
    					<option value="11">11��</option>
    					<option value="12">12��</option>
    				</select>
				</td>
			</tr>
			</tbody>
		</table>
		</form>
		<div class="align_c margin_t20">
			<a href="javascript:;" onclick="fnAction()" class="btnAdd">����</a>
		</div>
	</div>
</div>
</body>
<html>
<script>
$(document).ready(function(){
	fnAction = function() {
		if(!$("input[name='startdate']").val()) {
			alert("�������� �Է��� �ּ���.");
			$("input[name='startdate']").focus();
			return;
		}

		if(!$("input[name='enddate']").val()) {
			alert("�������� �Է��� �ּ���.");
			$("input[name='enddate']").focus();
			return;
		}
		
		$("#form0").submit();
	}
})
</script>  