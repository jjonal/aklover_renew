window.onload = function(){  
    // 최상단에서 스크롤 바텀 버튼 동작
    let topBtn = document.querySelector('.top_btn_wrap');
    topBtn.addEventListener('click', toBot);
    
    // ******************************************************************************
    // scroll
    // ******************************************************************************
    window.addEventListener('scroll', function(){
        const sct = window.scrollY,
            scrollBtnWrap = document.querySelector('.scroll_btn_wrap'),
            headerActive = document.getElementById('header');
        // scroll top button 스크롤 탑 버튼 show 클래스 추가
        if (sct > 300) {
            scrollBtnWrap.classList.add('b_ver');
        } else {
            scrollBtnWrap.classList.remove('b_ver');
        }

        // scroll top button 스크롤 탑 버튼 stop 클래스 추가
        let viewportHeight = window.innerHeight,
            containerBtm = sct + viewportHeight,
            container = document.querySelector('.front_container'),
            contHeight = container.offsetHeight;

        if (containerBtm >= contHeight) {
            scrollBtnWrap.classList.add('stop');
        } else {
            scrollBtnWrap.classList.remove('stop');
        }

        if (sct > 0) {
            //햄버거 열려있는 상태로 스크롤 했을 때 on class 유지
            if($('.hamberger_menu').hasClass('on')){
                headerActive.classList.add('on');
            }
        }

         // 스크롤 시 헤더에 active 클래스 추가
         if (sct > 80) {
            headerActive.classList.add('active');
        } else {
            headerActive.classList.remove('active');
        }
        if (sct == 0) {
            headerActive.classList.add('top');
            //햄버거 열려있는 상태로 스크롤 했을 때 on class 유지(최상단)
             if($('.hamberger_menu').hasClass('on')){
                headerActive.classList.add('on');
            }
        } else {
            headerActive.classList.remove('top');
        }
        // 스크롤 위치에 따라 클릭 이벤트 리스너 업데이트
        updateClickListener();
    });

     // 스크롤 위치에 따라 클릭 이벤트 리스너 설정
     function updateClickListener() {
        const sct = window.scrollY;
        if (sct > 300) {
            topBtn.removeEventListener('click', toBot);
            topBtn.addEventListener('click', toTop);
        } else {
            topBtn.removeEventListener('click', toTop);
            topBtn.addEventListener('click', toBot);
        }
    }

    // 초기 상태에서도 클릭 이벤트 리스너 설정
    updateClickListener();
    
    // 스크롤 탑 함수
    function toTop(){
        window.scrollTo({ top: 0, behavior: 'smooth'})
    }
    // 스크롤 바텀 함수
    function toBot(){
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth'})
    }
           
    // 메인/서브 클래스 구분
    if (document.getElementsByClassName('main_index').length) {
        document.querySelector('body').classList.remove('sub');
        document.querySelector('body').classList.add('main');

        if(document.getElementsByClassName('main_slide').length == 0 ){
            document.querySelector('body').classList.add('sub');
        }
    }else {
        document.querySelector('body').classList.add('sub');
    }
    
    // 나이스 셀렉트 커스텀
    $('.brand .nice-select').each(function() {

        var select = $(this),
            name = select.attr('name');
        
        select.hide();
        
        select.wrap('<div class="nice-select-wrap"></div>');
        
        var parent = select.parent('.nice-select-wrap');
        
        parent.append('<ul id=' + name + ' style="display:none"></ul>');
        
        select.find('option').each(function() {

            var option = $(this),
                value = option.attr('value'),
                label = option.text();
            
            if (option.is(":first-child")) {
            
            $('<a href="#" class="drop">' + label + '</a>').insertBefore(parent.find('ul'));
            parent.find('ul').append('<li><a href="#" id="' + value + '">' + label + '</a></li>');
            
            } else {
            
            parent.find('ul').append('<li><a href="#" id="' + value + '">' + label + '</a></li>');
            
            }
            
        });
        
        parent.find('a').on('click', function(e) {
            
            parent.toggleClass('down').find('ul').slideToggle(300);
            
            e.preventDefault();
        
        });
        
        parent.find('ul a').on('click', function(e) {
            
            var niceOption = $(this),
                    value = niceOption.attr('id'),
                text = niceOption.text();
            
            select.val(value);
            
            parent.find('.drop').text(text);
            
            e.preventDefault();
        
        });
        
    });
   
    //폼 > 이메일 자동 입력
    let emailInput = document.querySelector('form .email_wr .direct_input');
    let emailNiceSelects = document.querySelectorAll('form .email_wr .nice-select-wrap li');
    emailNiceSelects.forEach(function(emailNiceSelect){
        emailNiceSelect.addEventListener('click', function(){
            let value = emailNiceSelect.innerText;
            if(value != '직접입력'){
                emailInput.value = value;
            } else {
                emailInput.value = '';
                setTimeout(() => {emailInput.focus();},10)
            }
        })
    })


   
}


$(document).ready(function(){

    // ******************************************************************************
    // common
    // ******************************************************************************

    /* -------------  커스텀 커서 --------------- */
    var customCursor = document.getElementById('cursor');
    var cursorText  = $('#cursor span');
    document.addEventListener("pointermove", e => {
        customCursor.style.left = e.clientX + 'px';
        customCursor.style.top = e.clientY + 'px';
    });
    document.onmouseover = function (e) {
        if (e.target.matches('.cursor_cont') || e.target.closest('.cursor_cont')) {
            customCursor.classList.add('act');
            document.body.classList.add('hide-cursor');      
            cursorText.text("+ MORE"); 
            if (e.target.matches('.slick-arrow') || e.target.closest('.slick-arrow')) {
                customCursor.classList.remove('act');
                document.body.classList.remove('hide-cursor');
            }
            if (e.target.matches('.cursor_cont.color') || e.target.closest('.cursor_cont.color')) {                
                // cursorImage.src = "/img/front/main/more_w.webp";
                customCursor.classList.add('color');
            } else if (e.target.matches('.cursor_cont.kotext') || e.target.closest('.cursor_cont.kotext')) {
                cursorText.text("확인하기");
            } else {
                cursorText.text("+ MORE");
                customCursor.classList.remove('color');
            }
        }
    }
    document.onmouseout = function (e) {
        if (e.target.matches('.cursor_cont') || e.target.closest('.cursor_cont')) {
            customCursor.classList.remove('act');
            document.body.classList.remove('hide-cursor');
        }
    }

   
    // ******************************************************************************
    // header
    // ******************************************************************************

   /* -------------  메뉴 depth3 동작 --------------- */
   var depth3Tit = $('.header_wr .depth3_tit');
   $.each(depth3Tit, function(){
        $(this).click(function(){
            $(this).toggleClass('on');
            $(this).next('.depth3').toggleClass('on');
        });
    });

   /* -------------  마우스 오버 시 흰색 배경 추가 --------------- */   
   const haderMid = document.querySelector('.mid');
   haderMid.addEventListener('mouseover', (event) => {
       document.querySelector('header').classList.add('hov');
   });
   haderMid.addEventListener('mouseout', (event) => {
       document.querySelector('header').classList.remove('hov');
   });

   /* ------------- 스크롤 동작(하단 스크롤 중 멈추면 헤더 노출) -------------- */
   let scrolling; // setTimeout() 메서드를 할당하는 전역 변수
   var header = document.querySelector('header');
   var headerMoving = function(direction){
       if (direction === "up"){
           header.className = '';
       } else if (direction === "down"){
           header.className = 'scrollDown';
       }
   };
   var prevScrollTop = 0;

   document.addEventListener("scroll", function(){
       var nextScrollTop = window.pageYOffset || 0;

       if (nextScrollTop > prevScrollTop){
           headerMoving("down");
       } else if (nextScrollTop < prevScrollTop){
           headerMoving("up");
       }
       prevScrollTop = nextScrollTop;

       // 스크롤 멈춤 동작
       if (!scrolling) {
           // console.log('start scrolling!');
           header.classList.remove('downheader');

           //셀렉트 박스 열려있다면 닫기
           $(".hds_ul").hide();
           $('.hd_select_wrap').removeClass('down');
           $('.hds_ul').removeClass('down');
           $('.select_shadow').removeClass('active');
        
           // 검색창 열려있다면 닫기
           $('.search_wrap').removeClass('on');
           $('.searchBtn').removeClass('on');
           $('.sh_dim').removeClass('on');

           if (window.innerWidth < 990) {
               $('.ham_btn').show();
           }
       }

       // 일정시간(250ms) 뒤에 스크롤 동작 멈춤을 감지
       clearTimeout(scrolling);
       scrolling = setTimeout(() => {
           // console.log('stop scrolling!');
           header.classList.add('downheader');           
           scrolling = undefined;
       }, 400);

   });

    /* ------------- 검색창 열기 -------------- */

    /* 검색창 열고 닫기 경우
       - 최상단에서 열고 닫을 때 클래스 변동 (header에 top)
       - 중간에서 열고 닫을 때 클래스 변동
       - 최상단에서 검색창 열린 상태로 스크롤 시 전체 닫기
       - 중간에서 검색창 열린 상태로 스크롤 시 전체 닫기
       - 딤 열고 닫기
       - 딤 클릭시 닫기
       - 최상단에서 딤 클릭으로 닫았을 때
       - 햄버거 열려 있는 상태로 검색창 열기 했을 때 햄버거 닫기
    */

    $('.searchBtn').click(function(){
       if (!$(this).hasClass('on')) {
           $(this).addClass('on');
           $(this).parents('.front_header').find('.search_wrap').addClass('on');
           $(this).parents('header').addClass('downheader');
           $(this).parents('header').addClass('active');

           // 햄버거 열려있으면 닫기
           $('.hamberger_menu').removeClass('on');
           $('.dim').removeClass('on');
           $('header').removeClass('on');
           $('.ham_btn').removeClass('btn_ham_close');

       } else if($(this).parents('header').hasClass('top')){
           //헤더 최상단에 있으면 지우기
           $(this).parents('header').removeClass('downheader');
           $(this).parents('header').removeClass('active');
           $(this).removeClass('on');
           $(this).parents('.front_header').find('.search_wrap').removeClass('on');   
       } else {
           $(this).removeClass('on');
           $(this).parents('.front_header').find('.search_wrap').removeClass('on');
       }

    })

    /* ------------- 딤 클릭시 닫기 -------------- */

    $('.sh_dim').click(function(){
       $('.searchBtn').removeClass('on');
       $('.search_wrap').removeClass('on');
       $('.sh_dim').removeClass('on');
       $('.ham_btn').hide();

       if (window.innerWidth < 990) {
               $('.ham_btn').show();
       }

       //헤더 최상단에 있으면 지우기
       if($('header').hasClass('top')){
           $('header').removeClass('downheader');
           $('header').removeClass('active');

       }
   })

    // ******************************************************************************
    // footer
    // ******************************************************************************

    $('.front_footer .selectSite').mouseenter(function(){
        $(this).children('ul').show();
        }).mouseleave(function() { 
        $(this).children('ul').hide();
    });

    //간단 드롭다운 (헤더 > 언어선택 / 푸터 > 패밀리 사이트)
    let selectShadowList = document.querySelectorAll('.select_shadow');
    
    selectShadowList.forEach(selectShadow => {
        let selectTit = selectShadow.querySelector('.select_tit');
        
        selectTit.addEventListener('click', () => {
            selectShadow.classList.toggle('active');
        });
    });


    // ******************************************************************************
    // popup
    // ******************************************************************************
   
    //팝업 닫기
    $('.mu_pop .btn_x').click(function(){
        $('.mu_pop').hide();
    });
    $('#term_popup .btn_x').click(function(){
        $('#term_popup').hide();
    });

    //서포터즈 참여방법 보러가기 버튼
    $('.mission_guide_btn').click(function(e){
    e.preventDefault();
    $('#mission_popup').show();
	});
    //가이드 팝업 활성화 버튼
    $('#mission_popup .btn_x').click(function(e){
        $('#mission_popup').hide();
    });




    // ******************************************************************************
    // rollbanner
    // ******************************************************************************

    // rolling banner 
    function rollingBanner () {      
        const mq_l = (el,duration,moblie)=>{
            const mqItem = gsap.to(el,{
                xPercent: -100,
                repeat : -1,
                duration : duration,
                ease: "linear"
            });    
            const listOver = ()=>{    
                mqItem.pause();    
            }
            const listLeave = ()=>{    
                mqItem.play();    
            }    
            $(el).mouseover(listOver);
            $(el).mouseleave(listLeave);    
        }
        mq_l('.sec_rollbanner .list', 70);
    }
    
    if ( $('.sec_rollbanner').length > 0 ) {
        rollingBanner ();
    }

    // ******************************************************************************
    // hamberger
    // ******************************************************************************

    sideMenuOpen = function() {
        $('#sideMenu').show();
        $('.dim').show();
        $('body').addClass('nonscroll');
    }
    sideMenuClose = function() {
        $('#sideMenu').hide();
        $('.dim').hide();
        $('body').removeClass('nonscroll');
    }
    $('.m_menu').on("click", function(){
        sideMenuOpen();
    });
    $('.m_sideMenu_close').on("click", function(){
        sideMenuClose();
    });

    const depth1 = $('.menu_bx .depth1');
    $.each(depth1, function(item, idx){
        const _this = $(this);
        _this.find('> span').click(function(){
            const chk = _this.hasClass('on');
            if ( chk === true ) {
                depth1.removeClass('on');
            } else {
                depth1.removeClass('on');
                _this.addClass('on');
            }
       });
    });       

    // 서포터즈편 tab list
    $(".tab_btn").click(function(){
        const chk = $('.tab_list').hasClass('active');
        if(chk){
            $('.tab_list').removeClass("active");
            $('.tab a img').removeClass("rot");
        } else {
            $('.tab_list').addClass("active");
            $('.tab a img').addClass("rot");
        }
    })
});