$(document).ready(function(){
    if ( $('.best_qna_slide').length > 0 ) {
        const swiper = new Swiper('.best_qna_slide', {
            slidesPerView: 1.12,
            speed : 1000,
            loopAdditionalSlides: 1,
            spaceBetween: 10,
            loop: true,
            a11y: { // �����ټ� 
                enabled: true,
                prevSlideMessage: '���� �����̵�',
                nextSlideMessage: '���� �����̵�',   
                slideLabelMessage: '�� {{slidesLength}}���� �����̵� �� {{index}}�� �����̵� �Դϴ�.',
            },
            pagination: {
                el: ".swiper-pagination",
            },
            navigation: {
                nextEl: '.best_qna_slide .swiper-button-next',
                prevEl: '.best_qna_slide .swiper-button-prev',
            },
            breakpoints: {        
                768: {
                  slidesPerView: 2, 
                  spaceBetween: 16,
                }
            },
        });	
    }    
    if ( $('.best_review_slide').length > 0 ) {
        const swiper = new Swiper('.best_review_slide', {
            slidesPerView: 1.2,
            speed : 1000,
            loopAdditionalSlides: 1,
            spaceBetween: 18,
            loop: true,
            a11y: { // �����ټ� 
                enabled: true,
                prevSlideMessage: '���� �����̵�',
                nextSlideMessage: '���� �����̵�',   
                slideLabelMessage: '�� {{slidesLength}}���� �����̵� �� {{index}}�� �����̵� �Դϴ�.',
            },
            navigation: {
                nextEl: '.best_review .swiper-button-next',
                prevEl: '.best_review .swiper-button-prev',
            },
            breakpoints: {        
                1260: {
                  slidesPerView: 3, 
                  spaceBetween: 16,
                }
              },
        });	
    }    
});