$(function(){
	$(".dateMode").datepicker({
		dateFormat : "yy-mm-dd"
		,showOn:"button"
        ,buttonImage:"/image2/icon_calendar.png"
        ,buttonImageOnly:true
    });
	
	$(document).on("keyup", "input:text[numberOnly]", function() {$(this).val( $(this).val().replace(/[^0-9]/gi,"") );});
	
	//레프트 height 설정
	var document_h = $(document).height();
	var content_h = $("#content").height()+50;
	
	if(document_h > content_h) {
		$("#content").css("height",document_h-50);
	}
	
	//레프트 열기/숨기기
	$("#btn_left_manage").on("click",function(){
		if($("aside").css("display") != "none") {
			$("aside").hide();
			$("#btn_left_manage").css({"left":"0","background-image":"url(image/btn_left_show.png)","border":"none"});
		} else {
			$("aside").show();
			$("#btn_left_manage").css({"left":"163px","background-image":"url(image/btn_left_hide.png)","border":"1px solid #ccc"});
		}
	})
})