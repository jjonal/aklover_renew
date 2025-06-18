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
		<h1>체험단 후기 당첨자 선정 </h1>
	</div>
	<div class="popContents">
		<div class="exWrap">
			- 후기 당첨자로  일괄 변경됩니다. (양식 : <a href="./sample_01_01_01.xls">다운로드</a>)
		</div>
		<div class="upload_wrap">
			<form id="form_excel" name="form_excel" method="post" enctype="multipart/form-data">
			<input type="hidden" name="hero_old_idx" value="<?=$_GET["hero_old_idx"]?>" />
				<input type="file" id="upload_excel" name="upload_excel">
				<a href="javascript:;" onClick="fnUpload()" class="btnFunc">업로드하기</a>
			</form>
		</div>
		
		<div class="resultWrap">
			<p class="txt" id="resultMsg"></p>
			<div class="btnWrap">
				<a href="javascript:;" onClick="location.reload();" style="display: inline-block;padding:5px 10px; background-color: #6799FF; color:#fff;">새로고침</a>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){

	fnUpload = function() {
		if(!$("#upload_excel").val()) {
			alert("파일을 업로드 해주세요.");
			return;
		}
		
		if(!confirm("엑셀파일을 업로드 하시겠습니까?")) return;

		var frm = $("form[name=form_excel]");

		var options = {
	            url : "popup_01_01_01_action.php",
	            dataType : 'json',
	            async:false,
	            success :function(d) {
		           if(d.totalCount > 0) {
			           	var msg = "총 <strong>"+d.totalCount+"건</strong> 중 <strong>"+d.successCount+"건</strong>이 후기 당첨자로 변경되었습니다.";

			           	$(".resultWrap").show();
			           	$("#resultMsg").html(msg);
			       }
	            }, 
	            error: function(data, result, resultMsg) {
	            	alert("데이터 전송 중 오류가 발생하였습니다.");  
	            }            
	        };
		frm.ajaxSubmit(options);
	}
})
</script>
</body>
</html>

