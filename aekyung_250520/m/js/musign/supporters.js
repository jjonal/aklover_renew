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

    // �������� �� - ��ư dockbar 
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

    //���̵� Ȯ�� �˾� �ݱ�
    $('#guideline .btn_x').click(function(){
        $('#guideline').hide();
    });
    //���̵� �˾� Ȱ��ȭ ��ư
	$('.guide_btn_bx .download_btn').click(function(e){
		e.preventDefault();
		$('#guideline').show();
	});
    // //������ �˾� Ȱ��ȭ ��ư
    // $('.guide_btn_bx .pick_support').click(function(e){
	// 	e.preventDefault();
	// 	$('#supperpass').show();
	// });
	//��� �̹��� a�ڵ� ����
	$('.banner_img > a').click(function(e){
		e.preventDefault();
	});
   
    //clipboard https �ʿ�    
    var clipboard_naver = new Clipboard('.btn_clip_naver');
    clipboard_naver.on('success', function(e) {
        alert("���̹���α� ������������ ���� �Ǿ����ϴ�.");
    });

    clipboard_naver.on('error', function(e) {
        console.log(e);
    });

    var clipboard_insta = new Clipboard('.btn_clip_insta');
    clipboard_insta.on('success', function(e) {
        alert("�ν�Ÿ�׷� ������������ ���� �Ǿ����ϴ�.");
    });

    clipboard_insta.on('error', function(e) {
        console.log(e);
    });

    // ������ Ȯ���ϱ� ��ư 
    $('.pick_support').click(function(e){
		// e.preventDefault();
		// $('#pick_popup').show();
	});
    $('#pick_popup .btn_x').click(function(){
        $('#pick_popup').hide();
    });

    //�����н� ��� �ȳ�
    $('.superpass_use').click(function(e){
		e.preventDefault();
		$('#supperpass').show();
	});
    $('#supperpass .btn_x').click(function(){
        $('#supperpass').hide();
    });
});
