<?
if(!defined('_HEROBOARD_'))exit;
?>

<!-- 
<p class="tit_section mgt10">9개월 미로그인 이벤트</p>
<div class="view_title_box mgt10">
	<p><label>발송시점</label> : 매월 5일 2시 </p>
	<p><label>대상</label> : 메일 발송시점에 마지막 로그인 한 날짜가 10개월~9개월 이전날짜 기간에 포함되어 있는 회원이고 이메일 수신여부 체크된 회원에게 9개월 이벤트 메일 발송함 </p>
	<p><label>혜택</label> : 대상자 중 해당월 5일~마지막날짜 기간동안 로그인 시 100포인트 지급</p>
</div>
<form name="frm" id="frm1">
<input type="hidden" name="type" value="9month" >
<table class="t_list">
<colgroup>
	<col width="20%" />
	<col width="*" />
</colgroup>
<thead>
<tr>
	<th>이미지</th>
	<th>관리</th>
</tr>
</thead>
<tr>
	<td><a href="/image/9month_event_img_181031.png"><img src="/image/9month_event_img_181031.png" width="100" /></a></td>
	<td>
		<input type="text" id="sdate1" name="hero_today_start" class="dateMode" value="<?=$_GET['hero_today_start']?>" style="width:120px;"/> ~ 
        <input type="text" id="edate1" name="hero_today_end" class="dateMode" value="<?=$_GET['hero_today_end']?>" style="width:120px;"/>
        <input type="checkbox" name="join" id="join" value="Y"  /><label for="join">기간동안 로그인한 사람</label>
        <a href="#" class="btnFormExcel" id="9month">엑셀다운로드</a>
	</td>
</tr>
</table>
</form>
 -->

<p class="tit_section mgt30">휴면회원 이벤트</p>
<div class="view_title_box mgt10">
	<p><label>발송시점</label> : 매일  2시 </p>
	<p><label>대상</label> : 메일발송시점 마지막 로그인 날짜가 11개월 이전 회원에게 메일 발송 </p>
	<p><label>혜택</label> : 휴면회원에서 회원 전환 시 포인트(100p), 슈퍼패스 지급</p>
</div>
<form name="frm" id="frm2">
<input type="hidden" name="type" value="rest" >
<table class="t_list">
<colgroup>
	<col width="20%" />
	<col width="*" />
</colgroup>
<thead>
<tr>
	<th>이미지</th>
	<th>관리</th>
</tr>
</thead>
<tr>
	<td><a href="/image/no_login_220215.png"><img src="/image/no_login_220215.png" width="100" /></a></td>
	<td>
		<input type="text" id="sdate2" name="hero_today_start2" class="dateMode" value="<?=$_GET['hero_today_start2']?>" style="width:120px" /> ~ 
        <input type="text" id="edate2" name="hero_today_end2" class="dateMode" value="<?=$_GET['hero_today_end2']?>" style="width:120px;" />
        <input type="checkbox" name="join" id="join" value="Y"  /><label for="join">기간동안 로그인한 사람</label>
        <a href="#" class="btnFormExcel" id="rest">엑셀다운로드</a>
	</td>
</tr>
</table>
</form>

<!-- 
<p class="tit_section mgt30">50레벨 달성이벤트</p>
<div class="view_title_box mgt10">
	<p><label>대상</label> : 49레벨에서 50레벨 달성 </p>
	<p><label>혜택</label> : 500포인트 지급</p>
</div>
<form name="frm" id="frm3">
<input type="hidden" name="type" value="50level" >
<table class="t_list">
<colgroup>
	<col width="*" />
</colgroup>
<thead>
<tr>
	<th>관리</th>
</tr>
</thead>
<tr>
	<td>
		<input type="text" id="sdate3" name="hero_today_start3" class="dateMode" value="<?=$_GET['hero_today_start3']?>" style="width:120px" /> ~ 
        <input type="text" id="edate3" name="hero_today_end3" class="dateMode" value="<?=$_GET['hero_today_end3']?>" style="width:120px;" />
        <a href="#" class="btnFormExcel" id="50level">엑셀다운로드</a>
	</td>
</tr>
</table>
</form>
 -->
<script>
$(document).ready(function(){
	$("#9month").click(function(){
		if($("#sdate1").val() == "") {
			alert("기간을 설정하세요.");
			return;
		}
		if($("#edate1").val() == "") {
			alert("기간을 설정하세요.");
			return;
		}
		$("#frm1").attr("action","./user/event_excel.php").submit();
		
	})
	
	$("#rest").click(function(){
		if($("#sdate2").val() == "") {
			alert("기간을 설정하세요.");
			return;
		}
		if($("#edate2").val() == "") {
			alert("기간을 설정하세요.");
			return;
		}
		$("#frm2").attr("action","./user/event_excel.php").submit();
		
	})
	
	$("#50level").click(function(){
		if($("#sdate3").val() == "") {
			alert("기간을 설정하세요.");
			return;
		}
		if($("#edate3").val() == "") {
			alert("기간을 설정하세요.");
			return;
		}
		$("#frm3").attr("action","./user/event_excel.php").submit();
		
	})
	
})
</script>