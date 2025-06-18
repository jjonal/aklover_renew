window.onload = function(){ 
    window.addEventListener('scroll', function(){
        const sct = window.scrollY,
        headerActive = document.getElementById('m_header');
        if (sct > 0) {
            headerActive.classList.add('active');
        } else {
            headerActive.classList.remove('active');
        }
    });
}


$(document).ready(function(){
    // ******************************************************************************
    // common
    // ******************************************************************************
    
    /* ------------- 스크롤 동작(하단 스크롤 중 멈추면 헤더 노출) -------------- */
    let scrolling; // setTimeout() 메서드를 할당하는 전역 변수
    var header = document.getElementById('m_header');
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
            $('.search').removeClass('on');
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

    $('.search').click(function(){
        if (!$(this).hasClass('on')) {
            $(this).addClass('on');
            $(this).parents('#m_header').find('.search_wrap').addClass('on');
            $(this).parents('#m_header').addClass('downheader');
            $(this).parents('#m_header').addClass('active');
 
            // 햄버거 열려있으면 닫기
            $('.dim').removeClass('on');
 
        } else if($(this).parents('#m_header').hasClass('top')){
            //헤더 최상단에 있으면 지우기
            $(this).parents('#m_header').removeClass('downheader');
            $(this).parents('#m_header').removeClass('active');
            $(this).removeClass('on');
            $(this).parents('#m_header').find('.search_wrap').removeClass('on');   
        } else {
            $(this).removeClass('on');
            $(this).parents('#m_header').find('.search_wrap').removeClass('on');
        }
    })

    // ******************************************************************************
    // popup
    // ******************************************************************************

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
    // header
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


    // rolling banner 
    function rollingBanner () {      
        const mq_l = (el,duration,moblie)=>{
            const mqItem = gsap.to(el,{
                xPercent: -100,
                repeat : -1,
                duration : duration,
                ease: "linear"
            });     
        }
        mq_l('.sec_rollbanner .list', 70);
    }
    
    if ( $('.sec_rollbanner').length > 0 ) {
        rollingBanner ();
    }

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