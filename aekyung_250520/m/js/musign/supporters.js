$(document).ready(function() {
    // content  
    const contHeight = $('.more_view_cont').innerHeight();   
    $('.more_btn_view').hide();        
    if( contHeight > 280 ){
        $('.more_view_cont').addClass('on');
        $('.more_btn_view').show();
        $('.more_btn_view').click(function(){
            $('.more_view_cont').removeClass('on');
            $('.more_btn_view').hide();
            floatDiv();
        });
    }

    // 서포터즈 상세 - 버튼 dockbar 
    const footerTop = $('#footer').offset().top; 
    const footerHeight = $('#footer').innerHeight(); 
    $(window).scroll(function(){
        const st = $(window).scrollTop();            
        if ( footerTop < st + footerHeight  ) {
            $('.mission_view_btn').addClass('hide');
        } else {             
            $('.mission_view_btn').removeClass('hide');
        }
    });

    //가이드 확인 팝업 닫기
    $('#guideline .btn_x').click(function(){
        $('#guideline').hide();
    });
    //가이드 팝업 활성화 버튼
	$('.guide_btn_bx .download_btn').click(function(e){
		e.preventDefault();
		$('#guideline').show();
	});
    // //선정자 팝업 활성화 버튼
    // $('.guide_btn_bx .pick_support').click(function(e){
	// 	e.preventDefault();
	// 	$('#supperpass').show();
	// });
	//배너 이미지 a코드 막음
	$('.banner_img > a').click(function(e){
		e.preventDefault();
	});
   
    //clipboard https 필요    
    var clipboard_naver = new Clipboard('.btn_clip_naver');
    clipboard_naver.on('success', function(e) {
        alert("네이버블로그 공정위문구가 복사 되었습니다.");
    });

    clipboard_naver.on('error', function(e) {
        console.log(e);
    });

    var clipboard_insta = new Clipboard('.btn_clip_insta');
    clipboard_insta.on('success', function(e) {
        alert("인스타그램 공정위문구가 복사 되었습니다.");
    });

    clipboard_insta.on('error', function(e) {
        console.log(e);
    });

    // 선정자 확인하기 버튼 
    $('.pick_support').click(function(e){
		// e.preventDefault();
		// $('#pick_popup').show();
	});
    $('#pick_popup .btn_x').click(function(){
        $('#pick_popup').hide();
    });

    //슈퍼패스 사용 안내
    $('.superpass_use').click(function(e){
		e.preventDefault();
		$('#supperpass').show();
	});
    $('#supperpass .btn_x').click(function(){
        $('#supperpass').hide();
    });
});
