<?
if(!defined('_HEROBOARD_'))exit;

if($_POST["mode"]){
	$mode				= $_POST["mode"];
	$hero_old_idx		= $_POST["hero_old_idx"];
	$startDate			= $_POST["startDate"];
	$endDate			= $_POST["endDate"];
	$coreMember			= $_POST["coreMember"] == "" ? "N" : "Y";
	$adminSelectJoin	= $_POST["adminSelectJoin"] == "" ? "N" : "Y";
	$group_num			= $_POST["group_num"];


	if($adminSelectJoin != "Y") {
        //20240318 musign S group_num = ''가 되면 업데이트 오류로 수정이 안됨 임시 주석
		//$group_num = "";
        //20240318 musign E
	}


	if($mode=="modify"){
		//$arrStart = explode("-", $startDate);
		//$startDate = mktime(0, 0, 0, $arrStart[1], $arrStart[2], $arrStart[0]);
		$startDate = strtotime($startDate);
		//$arrEnd = explode("-", $endDate);
		//$endDate = mktime(23, 59, 59, $arrEnd[1], $arrEnd[2], $arrEnd[0]);
		$endDate = strtotime($endDate);
		$sql = "select idx from order_period";
		$res = mysql_query($sql) or die(mysql_error());
		$rs = mysql_fetch_array($res);

		if($rs["idx"]){
			$update =  " update order_period set hero_old_idx = ".$hero_old_idx." ,startDate=".$startDate.", endDate=".$endDate.", coreMember='".$coreMember."' ";
			$update .= " , adminSelectJoin = '".$adminSelectJoin."' , group_num = '".$group_num."' ";
			$update .= " where idx=".$rs["idx"];
			mysql_query($update) or die(mysql_error());
		}else{
			$insert = "insert into order_period(hero_old_idx, startDate, endDate, coreMember,adminSelectJoin, group_num) values(".$hero_old_idx.",".$startDate.", ".$endDate.", '".$coreMember."', '".$adminSelectJoin."', '".$group_num."')";
			mysql_query($insert) or die(mysql_error());
		}

		msg('수정 되었습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
		exit;
	}else if($mode=="del"){
		mysql_query("delete from order_period") or die(mysql_error());

		msg('기간을 해제했습니다.','location.href="'.PATH_HOME.'?'.get('type','').'"');
		exit;
	}
}

$sql = "select * from order_period";
$sql = out($sql);
sql($sql);
$rs = @mysql_fetch_assoc($out_sql);
if($rs["idx"]){
	$hero_old_idx = $rs["hero_old_idx"];
	$startDate = date("Y-m-d H:i",$rs["startDate"]);
	$endDate = date("Y-m-d H:i",$rs["endDate"]);
	$coreMember = $rs["coreMember"];
	$adminSelectJoin = $rs["adminSelectJoin"];
	$group_num = $rs["group_num"];
}else{
	$startDate = "";
	$endDate = "";
}

//상품관리명
$goods_sql = " SELECT hero_idx, hero_title FROM goods_manager WHERE hero_use = 0 ORDER BY hero_idx DESC ";
$goods_out_sql = mysql_query($goods_sql);
?>
<!--<link rel="stylesheet" href="//cdn.rawgit.com/xdan/datetimepicker/master/jquery.datetimepicker.css">-->
<!--<script src="//cdn.rawgit.com/xdan/datetimepicker/master/jquery.datetimepicker.js"></script>-->
<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/anytime.5.1.2.css">
<script src="<?=ADMIN_DEFAULT?>/js/anytime.5.1.2.js"></script>

<link rel="stylesheet" href="<?=ADMIN_DEFAULT?>/css/daterangepicker.css" />
<script src="<?=ADMIN_DEFAULT?>/js/moment.min.js"></script>
<script src="<?=ADMIN_DEFAULT?>/js/jquery.daterangepicker.js"></script>
<script>



function goNext(){
	var form = document.frm;

	if(form.hero_old_idx.value==""){
		alert("상품관리명을 선택해 주세요.");
		return false;
	}

	if(form.startDate.value==""){
		alert("시작일을 입력하세요");
		return false;
	}

	if(form.endDate.value==""){
		alert("종료일을 입력하세요");
		return false;
	}

	if($(":checkbox[name='adminSelectJoin']").is(":checked")) {
		if($("input[name='group_num']").val() < 1) {
			alert("관리자 선택 그룹 번호를 입력해 주세요.");
			$("input[name='group_num']").focus();
			return;
		}
	}

	form.mode.value = "modify";
	form.submit();
}

function noPeriod(){
	if(confirm("정말로 기간을 해제 하시겠습니까?")){
		var form = document.frm;
		form.mode.value = "del";
		form.submit();
	}
}
</script>
<div class="view_title_box">
	<p><label>1.로얄회원</label> : 로얄회원 항목 선택 시 회원등급이 [loyal AK LOVER]이고 회원포인트 300p 이상만 이용 가능</p>	
	<p><label>2.관리자 회원 선택 여부</label><br/>
		- 관리자가 선택한 회원정보를 [pointMallTempMember] 테이블(대소문자 체크)에 수동으로 등록하여 관리자 선택 그룹 번호로 관리<br/>
		- 등록된 데이터는 관리자 회원 선택 메뉴에서 확인 가능<br/>
		- 포인트, 레벨에 따른 이용제한은 없다.<br/>
	</p>
	<p><label>3.시작일, 종료일만 선택</label><br/>
	- AK LOVER 회원 전원
	</p>
	<p><label>4.관리자 설정방법</label><br/>
	- 일반회원 포인트 축제 (정기) :  상품관리명, 기간 2가지만 설정합니다.<br/>
	- 관리자 별도 회원유 -> 회원 그룹 생성(비정기) : 상품관리명, 기간, 관리자 회원선택여부(체크함), 관리자 선택그룹번호(생성번호) 4가지 모두 설정합니다.
	</p>
</div>

<form name="frm" method="post" action="<?=$_SERVER["REQUEST_URI"]?>">
<input type="hidden" name="mode" value="">
<table class="t_view">
<colgroup>
	<col width="150px">
	<col width="*">
</colgroup>
<tr>
	<th>상품관리명</th>
	<td>
		<select name="hero_old_idx" style="width:100%;">
			<option value="">선택해주세요.</option>
			<? while ($row = @mysql_fetch_assoc($goods_out_sql)){ ?>
				<option value="<?=$row["hero_idx"]?>" <?=$hero_old_idx == $row["hero_idx"] ? "selected":""?>><?=$row["hero_title"]?></option>
			<? } ?>
		</select>
		<p class="txt_emphasis mgt10">* 포인트 축제 오픈 시 새로운 상품관리명을 등록해서 이용해 주세요. 이전에 이용한 상품관리명 사용 시 구매한 상품이 취소될 수 있습니다.</p>
	</td>
</tr>
<tr>
	<th>기간</th>
	<td><input style="width:120px" name="startDate" id="startDate" value="<?=$startDate?>" type="text" class="input10" readonly>
		~ <input style="width:120px;" name="endDate" id="endDate" value="<?=$endDate?>" type="text" class="input10" readonly>
	</td>
</tr>
<tr>
	<th>관리자 회원선택 여부</th>
	<td><input type="checkbox" name="adminSelectJoin" value="Y" <? if($adminSelectJoin=="Y"){?> checked <? }?>/></td>
</tr>
<tr>
	<th>관리자 선택 그룹 번호</th>
	<td><input type="text" name="group_num" style="width:40px;" numberOnly maxlength="2" value="<?=$group_num?>"/></td>
</tr>
</table>
<div class="btnGroup">
	<a href="javascript:goNext();" class="btnAdd">저장</a>
	<a href="javascript:noPeriod();" class="btnAdd">기간해제(clear)</a>
</div>
</form>

<script>
$(function(){
	$("#startDate").AnyTime_picker( {
    format: "%Y-%m-%d %H:%i:00"
 	}); 
	$("#endDate").AnyTime_picker( {
    format: "%Y-%m-%d %H:%i:00"
 	});  
});
/*$(function(){
  $('#startDate').datetimepicker({
	  lang:'ko',
	  format:'Y-m-d H:i'
  });
  $('#endDate').datetimepicker({
	  lang:'ko',
	  format:'Y-m-d H:i'
  });  
});*/
</script>