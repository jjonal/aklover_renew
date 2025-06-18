$(document).ready(function(){
    // main visual slide
    var mainSwiper = new Swiper('.main_slide .slider', {
        autoplay: {
            delay: 3000,
            disableOnInteraction: false
        },
        effect  : 'fade',
        speed : 1000,
        watchOverflow: false,
        loop:true,
        loopedSlides: 1,
        navigation: {
            nextEl: '.buttonsd .swiper-button-next',
            prevEl: '.buttonsd .swiper-button-prev',
        },
        pagination: {
            el: ".swbtn_wrap .swiper-pagination",
            type: 'fraction',
        },
    });
    // play stop button
    $(".swiper-button-play").hide();
    $(".swiper-button-pause").click(function(){
        mainSwiper.autoplay.stop();
        $(this).hide();
        $(".swiper-button-play").show();
    });    
    $(".swiper-button-play").click(function(){
        mainSwiper.autoplay.start();
        $(this).hide();
        $(".swiper-button-pause").show();
    });

    // main tab funciton 
    const mainDisplay = $('.main_display');
    $.each(mainDisplay, function(){
        const _thisDisplay = $(this);
        const tabHash = $(this).find('.tabtit .hash_box');
        const tabTitleLi = $(this).find('.tabtit li');
        const tabBg = $('.tit_bg img');
        const tabCont = $(this).find('.tabbox');
        const depth1 = $(this).find('.depth1');
        $.each(tabTitleLi, function(idx, item){
            // when category click 
            const _this = $(this);
            $(this).find('.tit').click(function(){
                const chk = _this.hasClass('on');
                tabTitleLi.removeClass('on');                 
                tabHash.hide();
                if ( chk == true ) {
                    _this.addClass('on');   
                    tabHash.eq(idx).show();
                } else {
                    _this.addClass('on');   
                    tabHash.eq(idx).slideDown();
                }
            });
        });
        $.each(depth1, function(idx, item){            
            $(this).click(function(){
                depth1.removeClass('act');
                $(this).addClass('act');
                $(this).next('.hash_box').addClass('act');
                // categoty content change
                tabCont.removeClass('on');
                tabCont.eq(idx).addClass('on');
                // categoty tabBg change
                tabBg.hide();
                tabBg.eq(idx).show();
            });
        });
        _thisDisplay.find('.depth1_c').click(function(){
            _thisDisplay.find('.depth1_s, .depth1').removeClass('act');
            _thisDisplay.find('.depth1_cs').addClass('act');
            tabCont.removeClass('on');
            _thisDisplay.find('.tabbox:first-child').addClass('on');
        });
    });  

    const bestSlide = ()=>{
    let bestSlide = document.querySelectorAll('.sec_reivew .tabbox');
    bestSlide.forEach((slider, index)=>{
        let sliderLength = slider.children[0].children.length
        let result = (sliderLength > 1) ? true : false
        const swiper = new Swiper(slider, {
            slidesPerView: 1.8,
            speed : 1000,
            loopAdditionalSlides: 5,
            spaceBetween: 0,
            loop: true,
            a11y: { // 웹접근성 
                enabled: true,
                prevSlideMessage: '이전 슬라이드',
                nextSlideMessage: '다음 슬라이드',   
                slideLabelMessage: '총 {{slidesLength}}장의 슬라이드 중 {{index}}번 슬라이드 입니다.',
            },
            breakpoints:{
                1680: {
                    slidesPerView: 2.24,
                    loopedSlides: 4,
                    spaceBetween: 0,
                },
            },
            });	
        })
    }
    bestSlide(); 
    
    // 메인 팝업 슬라이드
    var mainSwiper2 = new Swiper('.mainpopup .slider', {
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        effect  : "fade",
        speed : 1000,
        watchOverflow: false,
        loop:true,
        loopedSlides: 2,
        navigation: {
            nextEl: '.mainpopup .swiper-button-next',
            prevEl: '.mainpopup .swiper-button-prev',
        },
        pagination: {
            el: ".mainpopup .swbtn_wrap .swiper-pagination",
            type: 'fraction',
        },
    });
});
   