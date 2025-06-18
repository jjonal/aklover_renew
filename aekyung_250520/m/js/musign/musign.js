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
    
    /* ------------- ��ũ�� ����(�ϴ� ��ũ�� �� ���߸� ��� ����) -------------- */
    let scrolling; // setTimeout() �޼��带 �Ҵ��ϴ� ���� ����
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

        // ��ũ�� ���� ����
        if (!scrolling) {
            // console.log('start scrolling!');
            header.classList.remove('downheader');

            //����Ʈ �ڽ� �����ִٸ� �ݱ�
            $(".hds_ul").hide();
            $('.hd_select_wrap').removeClass('down');
            $('.hds_ul').removeClass('down');
            $('.select_shadow').removeClass('active');
        
            // �˻�â �����ִٸ� �ݱ�
            $('.search_wrap').removeClass('on');
            $('.search').removeClass('on');
            $('.sh_dim').removeClass('on');

            if (window.innerWidth < 990) {
                $('.ham_btn').show();
            }
        }

        // �����ð�(250ms) �ڿ� ��ũ�� ���� ������ ����
        clearTimeout(scrolling);
        scrolling = setTimeout(() => {
            // console.log('stop scrolling!');
            header.classList.add('downheader');           
            scrolling = undefined;
        }, 400);

    });
    

    /* ------------- �˻�â ���� -------------- */

    /* �˻�â ���� �ݱ� ���
       - �ֻ�ܿ��� ���� ���� �� Ŭ���� ���� (header�� top)
       - �߰����� ���� ���� �� Ŭ���� ����
       - �ֻ�ܿ��� �˻�â ���� ���·� ��ũ�� �� ��ü �ݱ�
       - �߰����� �˻�â ���� ���·� ��ũ�� �� ��ü �ݱ�
       - �� ���� �ݱ�
       - �� Ŭ���� �ݱ�
       - �ֻ�ܿ��� �� Ŭ������ �ݾ��� ��
       - �ܹ��� ���� �ִ� ���·� �˻�â ���� ���� �� �ܹ��� �ݱ�
    */

    $('.search').click(function(){
        if (!$(this).hasClass('on')) {
            $(this).addClass('on');
            $(this).parents('#m_header').find('.search_wrap').addClass('on');
            $(this).parents('#m_header').addClass('downheader');
            $(this).parents('#m_header').addClass('active');
 
            // �ܹ��� ���������� �ݱ�
            $('.dim').removeClass('on');
 
        } else if($(this).parents('#m_header').hasClass('top')){
            //��� �ֻ�ܿ� ������ �����
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

    //�������� ������� �������� ��ư
    $('.mission_guide_btn').click(function(e){
        e.preventDefault();
        $('#mission_popup').show();
    });
    //���̵� �˾� Ȱ��ȭ ��ư
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

    //���� ��Ӵٿ� (��� > ���� / Ǫ�� > �йи� ����Ʈ)
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

    // ���������� tab list
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