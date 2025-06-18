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
			alert("�Ⱓ�� �����ϼ���.");
			return;
		}
		if($("#edate1").val() == "") {
			alert("�Ⱓ�� �����ϼ���.");
			return;
		}
		$("#frm1").attr("action","./event/event_excel.php").submit();
		
	})
	
	$("#rest").click(function(){
		if($("#sdate2").val() == "") {
			alert("�Ⱓ�� �����ϼ���.");
			return;
		}
		if($("#edate2").val() == "") {
			alert("�Ⱓ�� �����ϼ���.");
			return;
		}
		$("#frm2").attr("action","./event/event_excel.php").submit();
		
	})
	
	$("#50level").click(function(){
		if($("#sdate3").val() == "") {
			alert("�Ⱓ�� �����ϼ���.");
			return;
		}
		if($("#edate3").val() == "") {
			alert("�Ⱓ�� �����ϼ���.");
			return;
		}
		$("#frm3").attr("action","./event/event_excel.php").submit();
		
	})
	
})

</script>
<h2>9���� �̷α��� �̺�Ʈ</h2>
<div id="eventSerachArea">
	<form name="frm" id="frm1">
    	<input type="hidden" name="type" value="9month" >
    	<span>�Ⱓ</span>
    	<input type="text"  id="sdate1" name="hero_today_start"  value="<?=$_GET['hero_today_start']?>" style="text-align: center"  readonly/> ~ 
        <input type="text"  id="edate1" name="hero_today_end"  value="<?=$_GET['hero_today_end']?>" style="text-align: center"  readonly/>
        <label><input type="checkbox" name="join" value="Y"  />�Ⱓ���� �α����� ���</label>
        <script>
			$(function() {      // window.onload ��� ���� ��ũ��Ʈ
				dateclick2();
			});
			function dateclick2(){
				var dates = $("#sdate1, #edate1").datepicker({
					monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
					dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
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
        <a href="#" class="eventBtn" id="9month">�����ٿ�ε�</a>
    </form>
    

    	<dl style="margin-top:20px;">
    		<dt style="float:left; width:240px;"><a href="/image/9month_event_img_181031.png"><img src="/image/9month_event_img_181031.png" width="200" /></a></dt>
    		<dd style="float:left; width:500px;">
    			<p>�߼۽��� : �ſ� 5�� 2�� </p>
    			<p style="margin-top:10px;">��� : ���� �߼۽����� ������ �α��� �� ��¥�� 10����~9���� ������¥ �Ⱓ�� ���ԵǾ� �ִ� ȸ���̰� �̸��� ���ſ��� üũ�� ȸ������ 9���� �̺�Ʈ ���� �߼��� </p>
    			<p style="margin-top:10px;">���� : ����� �� �ش�� 5��~��������¥ �Ⱓ���� �α��� �� 100����Ʈ ����</p>
    		</dd>
    	</dl>
    	<div style="clear:both;"></div>

    
</div>

<h2>�޸�ȸ�� �̺�Ʈ</h2>
<div id="eventSerachArea">
	<form name="frm" id="frm2">
    	<input type="hidden" name="type" value="rest" >
    	<span>�Ⱓ</span>
    	<input type="text"  id="sdate2" name="hero_today_start2"  value="<?=$_GET['hero_today_start2']?>" style="text-align: center"  readonly/> ~ 
        <input type="text"  id="edate2" name="hero_today_end2"  value="<?=$_GET['hero_today_end2']?>" style="text-align: center"  readonly/>
        <label><input type="checkbox" name="join" value="Y"  />�Ⱓ���� �α����� ���</label>
        <script>
			$(function() {      // window.onload ��� ���� ��ũ��Ʈ
				dateclick3();
			});
			function dateclick3(){
				var dates = $("#sdate2, #edate2").datepicker({
					monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
					dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
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
        <a href="#" class="eventBtn" id="rest">�����ٿ�ε�</a>
    </form>
    
    	<dl style="margin-top:20px;">
    		<dt style="float:left; width:240px;"><a href="/image/no_login_181031.png"><img src="/image/no_login_181031.png" width="200" /></a></dt>
    		<dd style="float:left; width:500px;">
    			<p>�߼۽��� : ����  2�� </p>
    			<p style="margin-top:10px;">��� : ���Ϲ߼۽��� ������ �α��� ��¥�� 11���� ���� ȸ������ ���� �߼� </p>
    			<p style="margin-top:10px;">���� : �޸�ȸ������ ȸ�� ��ȯ �� ����Ʈ(100p), �����н� ����</p>
    		</dd>
    	</dl>
    	<div style="clear:both;"></div>
    
   
</div>

<h2>50���� �޼��̺�Ʈ</h2>
<div id="eventSerachArea">
	<form name="frm" id="frm3">
    	<input type="hidden" name="type" value="50level" >
    	<span>�Ⱓ</span>
    	<input type="text"  id="sdate3" name="hero_today_start3"  value="<?=$_GET['hero_today_start3']?>" style="text-align: center"  readonly/> ~ 
        <input type="text"  id="edate3" name="hero_today_end3"  value="<?=$_GET['hero_today_end3']?>" style="text-align: center"  readonly/>
        <script>
			$(function() {      // window.onload ��� ���� ��ũ��Ʈ
				dateclick4();
			});
			function dateclick4(){
				var dates = $("#sdate3, #edate3").datepicker({
					monthNames: ['�� 1��','�� 2��','�� 3��','�� 4��','�� 5��','�� 6��','�� 7��','�� 8��','�� 9��','�� 10��','�� 11��','�� 12��'],
					dayNamesMin: ['��', '��', 'ȭ', '��', '��', '��', '��'],
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
        <a href="#" class="eventBtn" id="50level">�����ٿ�ε�</a>
        
        <p style="margin-top:20px;">��� : 49�������� 50���� �޼�</p>
        <p style="margin-top:10px">���� : 500����Ʈ ����</p>
    </form>
</div>
<br/><br/>



    
    