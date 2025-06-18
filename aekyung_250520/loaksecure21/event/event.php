<?php 
if(!defined('_HEROBOARD_'))exit;
?>
<link rel="stylesheet" type="text/css" href="<?=CSS_END;?>general.css"/>
<link rel="stylesheet" type="text/css" href="<?=PATH_END?>css/admin_login.css" />
<link rel="stylesheet" href="<?=PATH_END?>css/admin.css" type="text/css" />
<script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_END;?>head.js"></script>
<link type='text/css' href='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.css' rel='stylesheet' />
<script type="text/javascript" src="<?=DOMAIN_END?>cal/jquery.min.js"></script>
<script type='text/javascript' src='<?=DOMAIN_END?>cal/jquery-ui-1.8.17.custom.min.js'></script> 
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
		$("#frm1").attr("action","./event/event_excel.php").submit();
		
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
		$("#frm2").attr("action","./event/event_excel.php").submit();
		
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
		$("#frm3").attr("action","./event/event_excel.php").submit();
		
	})
	
})

</script>
<h2>9개월 미로그인 이벤트</h2>
<div id="eventSerachArea">
	<form name="frm" id="frm1">
    	<input type="hidden" name="type" value="9month" >
    	<span>기간</span>
    	<input type="text"  id="sdate1" name="hero_today_start"  value="<?=$_GET['hero_today_start']?>" style="text-align: center"  readonly/> ~ 
        <input type="text"  id="edate1" name="hero_today_end"  value="<?=$_GET['hero_today_end']?>" style="text-align: center"  readonly/>
        <label><input type="checkbox" name="join" value="Y"  />기간동안 로그인한 사람</label>
        <script>
			$(function() {      // window.onload 대신 쓰는 스크립트
				dateclick2();
			});
			function dateclick2(){
				var dates = $("#sdate1, #edate1").datepicker({
					monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
					dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
					defaultDate: null,
					showMonthAfterYear:true,
					dateFormat: 'yy-mm-dd',
					onSelect: function( selectedDate ) {
						var option = this.id == "sdate1" ? "minDate" : "maxDate",
						instance = $( this ).data( "datepicker" ),
						date = $.datepicker.parseDate(
							instance.settings.dateFormat ||
							$.datepicker._defaults.dateFormat,
							selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
					}
				});
			};
		</script>
        <a href="#" class="eventBtn" id="9month">엑셀다운로드</a>
    </form>
    

    	<dl style="margin-top:20px;">
    		<dt style="float:left; width:240px;"><a href="/image/9month_event_img_181031.png"><img src="/image/9month_event_img_181031.png" width="200" /></a></dt>
    		<dd style="float:left; width:500px;">
    			<p>발송시점 : 매월 5일 2시 </p>
    			<p style="margin-top:10px;">대상 : 메일 발송시점에 마지막 로그인 한 날짜가 10개월~9개월 이전날짜 기간에 포함되어 있는 회원이고 이메일 수신여부 체크된 회원에게 9개월 이벤트 메일 발송함 </p>
    			<p style="margin-top:10px;">혜택 : 대상자 중 해당월 5일~마지막날짜 기간동안 로그인 시 100포인트 지급</p>
    		</dd>
    	</dl>
    	<div style="clear:both;"></div>

    
</div>

<h2>휴면회원 이벤트</h2>
<div id="eventSerachArea">
	<form name="frm" id="frm2">
    	<input type="hidden" name="type" value="rest" >
    	<span>기간</span>
    	<input type="text"  id="sdate2" name="hero_today_start2"  value="<?=$_GET['hero_today_start2']?>" style="text-align: center"  readonly/> ~ 
        <input type="text"  id="edate2" name="hero_today_end2"  value="<?=$_GET['hero_today_end2']?>" style="text-align: center"  readonly/>
        <label><input type="checkbox" name="join" value="Y"  />기간동안 로그인한 사람</label>
        <script>
			$(function() {      // window.onload 대신 쓰는 스크립트
				dateclick3();
			});
			function dateclick3(){
				var dates = $("#sdate2, #edate2").datepicker({
					monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
					dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
					defaultDate: null,
					showMonthAfterYear:true,
					dateFormat: 'yy-mm-dd',
					onSelect: function( selectedDate ) {
						var option = this.id == "sdate2" ? "minDate" : "maxDate",
						instance = $( this ).data( "datepicker" ),
						date = $.datepicker.parseDate(
							instance.settings.dateFormat ||
							$.datepicker._defaults.dateFormat,
							selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
					}
				});
			};
		</script>
        <a href="#" class="eventBtn" id="rest">엑셀다운로드</a>
    </form>
    
    	<dl style="margin-top:20px;">
    		<dt style="float:left; width:240px;"><a href="/image/no_login_181031.png"><img src="/image/no_login_181031.png" width="200" /></a></dt>
    		<dd style="float:left; width:500px;">
    			<p>발송시점 : 매일  2시 </p>
    			<p style="margin-top:10px;">대상 : 메일발송시점 마지막 로그인 날짜가 11개월 이전 회원에게 메일 발송 </p>
    			<p style="margin-top:10px;">혜택 : 휴먼회원에서 회원 전환 시 포인트(100p), 슈퍼패스 지급</p>
    		</dd>
    	</dl>
    	<div style="clear:both;"></div>
    
   
</div>

<h2>50레벨 달성이벤트</h2>
<div id="eventSerachArea">
	<form name="frm" id="frm3">
    	<input type="hidden" name="type" value="50level" >
    	<span>기간</span>
    	<input type="text"  id="sdate3" name="hero_today_start3"  value="<?=$_GET['hero_today_start3']?>" style="text-align: center"  readonly/> ~ 
        <input type="text"  id="edate3" name="hero_today_end3"  value="<?=$_GET['hero_today_end3']?>" style="text-align: center"  readonly/>
        <script>
			$(function() {      // window.onload 대신 쓰는 스크립트
				dateclick4();
			});
			function dateclick4(){
				var dates = $("#sdate3, #edate3").datepicker({
					monthNames: ['년 1월','년 2월','년 3월','년 4월','년 5월','년 6월','년 7월','년 8월','년 9월','년 10월','년 11월','년 12월'],
					dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
					defaultDate: null,
					showMonthAfterYear:true,
					dateFormat: 'yy-mm-dd',
					onSelect: function( selectedDate ) {
						var option = this.id == "sdate3" ? "minDate" : "maxDate",
						instance = $( this ).data( "datepicker" ),
						date = $.datepicker.parseDate(
							instance.settings.dateFormat ||
							$.datepicker._defaults.dateFormat,
							selectedDate, instance.settings );
						dates.not( this ).datepicker( "option", option, date );
					}
				});
			};
		</script>
        <a href="#" class="eventBtn" id="50level">엑셀다운로드</a>
        
        <p style="margin-top:20px;">대상 : 49레벨에서 50레벨 달성</p>
        <p style="margin-top:10px">혜택 : 500포인트 지급</p>
    </form>
</div>
<br/><br/>



    
    