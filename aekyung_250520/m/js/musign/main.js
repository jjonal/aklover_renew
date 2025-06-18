$(document).ready(function(){
     // main visual slide
     var mainSwiper = new Swiper('.slider', {
        autoplay: {
            delay: 3000,
            disableOnInteraction: false
        },
        // effect  : 'fade',
        speed : 1000,
        watchOverflow: false,
        loop:true,
        loopedSlides: 1,       
        pagination: {
            el: ".swbtn_wrap .swiper-pagination",  
            type: 'fraction'
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
        const tabtit = $(this).find('.tabtit .tit');
        const tabHash = $(this).find('.tabtit .hash_box');
        const tabCont = $(this).find('.tabbox');
        const tabBg = $('.tit_bg img');
        const depth1 = $(this).find('.depth1');
        $.each(tabtit, function(idx, item){
            // when category click
            $(this).click(function(){
                tabtit.removeClass('on');
                $(this).addClass('on');
                // categoty hash change
                tabHash.hide();
                tabHash.eq(idx).show();
            });
        });
        $.each(depth1, function(idx, item){
            $(this).click(function(){ 
                depth1.removeClass('act');
                $(this).addClass('act');
                $('.depth1_s').addClass('act');
                // categoty tabBg change
                tabBg.hide();
                tabBg.eq(idx).show();
                // categoty content change
                tabCont.removeClass('on');
                tabCont.eq(idx).addClass('on');
            });
        });
        _thisDisplay.find('.depth1_c').click(function(){
            _thisDisplay.find('.depth1_s, .depth1').removeClass('act');
            _thisDisplay.find('.depth1_cs').addClass('act');
            tabCont.removeClass('on');
            _thisDisplay.find('.tab_beauty').addClass('on');
        });
    });

    //서포터즈 슬라이드
    const supportSlide = ()=>{
        let sect2Slide = document.querySelectorAll('.sec_suppoter .tabbox')
        sect2Slide.forEach((slider, index)=>{
        // this bit checks if there's more than 1 slide, if there's only 1 it won't loop
            let sliderLength = slider.children[0].children.length
            let result = (sliderLength > 1) ? true : false
            const swiper = new Swiper(slider, {
                slidesPerView: 1.6,
                speed : 800,
                loopAdditionalSlides: 1,
                spaceBetween: 0,
                // loopedSlides: 40,
                // loop:false,
                a11y: { // 웹접근성 
                    enabled: true,
                    prevSlideMessage: '이전 슬라이드',
                    nextSlideMessage: '다음 슬라이드',   
                    slideLabelMessage: '총 {{slidesLength}}장의 슬라이드 중 {{index}}번 슬라이드 입니다.',
                },
            });	
        })
    }
    window.addEventListener('load', supportSlide);

    //우수 후기 슬라이드
    const bestSlide = ()=>{
        let bestSlide = document.querySelectorAll('.sec_reivew .tabbox')
        // let prevArrow = document.querySelectorAll('.prev')
        // let nextArrow = document.querySelectorAll('.next')
        bestSlide.forEach((slider, index)=>{
        // this bit checks if there's more than 1 slide, if there's only 1 it won't loop
            let sliderLength = slider.children[0].children.length
            let result = (sliderLength > 1) ? true : false
            const swiper = new Swiper(slider, {
                slidesPerView: 1,
                speed : 1000,
                loop: true,
                loopAdditionalSlides: 1,
                spaceBetween: 0,
                // loopedSlides: 40,
                // loop:false,
                a11y: { // 웹접근성 
                    enabled: true,
                    prevSlideMessage: '이전 슬라이드',
                    nextSlideMessage: '다음 슬라이드',   
                    slideLabelMessage: '총 {{slidesLength}}장의 슬라이드 중 {{index}}번 슬라이드 입니다.',
                },
            });	
        })
    }
    window.addEventListener('load', bestSlide);

    // 메인 팝업 슬라이드
    var mainSwiper2 = new Swiper('.mainpopup .slider2', {
        autoplay: {
            delay: 5000,
            disableOnInteraction: false
        },
        effect: 'fade',
        speed : 1000,
        watchOverflow: false,
        loop:true,
        loopedSlides: 1,
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