<!DOCTYPE html>
<?
define('_HEROBOARD_', TRUE);
include_once '../../freebest/head.php';
include                                    '../popupSessionCheck.php';
include                                     FREEBEST_INC_END.'hero.php';
include                                     FREEBEST_INC_END.'function.php';

?>
<meta charset="euc-kr" />
<head>
<link rel="stylesheet" type="text/css" href="<?=ADMIN_DEFAULT?>/css/admin.css" />
<script type="text/javascript" src="<?=JS_END;?>jquery.min.js"></script>
<script type="text/javascript" src="<?=JS_END;?>jquery.form.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
</head>
<body style="background:none;">
<div class="popupWrap">
	<div class="popHeader">
		<h1>ü��� �ı� ��÷�� ���� </h1>
	</div>
	<div class="popContents">
		<div class="exWrap">
			- �ı� ��÷�ڷ�  �ϰ� ����˴ϴ�. (��� : <a href="./sample_01_01_01.xls">�ٿ�ε�</a>)
		</div>
		<div class="upload_wrap">
			<form id="form_excel" name="form_excel" method="post" enctype="multipart/form-data">
			<input type="hidden" name="hero_old_idx" value="<?=$_GET["hero_old_idx"]?>" />
				<input type="file" id="upload_excel" name="upload_excel">
				<a href="javascript:;" onClick="fnUpload()" class="btnFunc">���ε��ϱ�</a>
			</form>
		</div>
		
		<div class="resultWrap">
			<p class="txt" id="resultMsg"></p>
			<div class="btnWrap">
				<a href="javascript:;" onClick="location.reload();" style="display: inline-block;padding:5px 10px; background-color: #6799FF; color:#fff;">���ΰ�ħ</a>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){

	fnUpload = function() {
		if(!$("#upload_excel").val()) {
			alert("������ ���ε� ���ּ���.");
			return;
		}
		
		if(!confirm("���������� ���ε� �Ͻðڽ��ϱ�?")) return;

		var frm = $("form[name=form_excel]");

		var options = {
	            url : "popup_01_01_01_action.php",
	            dataType : 'json',
	            async:false,
	            success :function(d) {
		           if(d.totalCount > 0) {
			           	var msg = "�� <strong>"+d.totalCount+"��</strong> �� <strong>"+d.successCount+"��</strong>�� �ı� ��÷�ڷ� ����Ǿ����ϴ�.";

			           	$(".resultWrap").show();
			           	$("#resultMsg").html(msg);
			       }
	            }, 
	            error: function(data, result, resultMsg) {
	            	alert("������ ���� �� ������ �߻��Ͽ����ϴ�.");  
	            }            
	        };
		frm.ajaxSubmit(options);
	}
})
</script>
</body>
</html>

