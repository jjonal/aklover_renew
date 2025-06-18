jQuery(function ($) {
    /* ======================================================================
    *
    * Powered by MUSIGN  
    * Version 1.0
    * js/sub/media.js 
    * 
    ====================================================================== */
    /* ======================================================================
    *
    *  RUN 
    * 
    ====================================================================== */


    init(true);


    /* ======================================================================
    *
    *  INIT 
    * 
    ====================================================================== */

    function init(loadonce) {

        // Every load    
        if (typeof loadonce !== 'undefined' && loadonce === true) {
        }

        // !!!! functions !!!! 
        vidPlay();
        mediaTab();
        youtubeApi();

        // First load
        if (typeof loadonce !== 'undefined' && loadonce === true) {
            // >=2nd load
        } else {
            initOnload();
        }

        $(window).trigger('resize');

    }



    /* ======================================================================
     *
     *  ON LOAD
     * 
     ====================================================================== */


    // INITIALIZE LOAD
    function initOnload() {

    }

    $(window).on('load', function () {
        
    });



    /* ======================================================================
     *
     *  ON RESIZE
     * 
     ====================================================================== */


    // INITIALIZE RESIZE
    function init_resize() {

        // setTimeout to fix IOS animation on rotate issue
        setTimeout(function () {

            //

        }, 400);

    }

    // Init resize on reisize
    $(window).on('resize', init_resize);



    /* ======================================================================
    *
    *  Default Functions
    * 
    ====================================================================== */
    function mediaTab() {
        const subCont = $('.mediapage .sub_cont');
        $.each(subCont, function () {
            // 탭
            const media_Tab = $(this).find('.content_info ul li');
            const media_Cont = $(this).find('.tab_cont');            
            $.each(media_Tab, function (index, item) {
                $(this).click(function () {
                    media_Tab.removeClass('on');
                    $(this).addClass('on');
                    media_Cont.removeClass('on');
                    media_Cont.eq(index).addClass('on');
                });
            });
        });
    }

    function vidPlay() {

        function preventScroll(event) {
            event.preventDefault();
            event.stopPropagation();
            return false;
        }

        $(document).on("click", ".vid_box", function () {
            var data = $(this).attr("data-id");
            // console.log(data)
            $('.video_pop').attr("src", 'https://www.youtube.com/embed/' + data)

            var wid = $(".iframe_wrap").width();

            $(".iframe_wrap").css("display", "block");
            $(".iframe_wrap .close_bg").show();
            document.getElementsByTagName('html')[0].classList.add("fixed");
            // $('html, body').css({'overflow': 'auto', 'height': '100%'});
        });

        $(".close_btn").on("click", function () {
            close();
        })
    }

    function close() {
        $(".iframe_wrap, .close_bg").hide();
        $(".video_pop").attr("src", "");
        document.getElementsByTagName('html')[0].classList.remove("fixed");
        // $('html, body').css({'overflow': 'visible', 'height': '100%'});
    };

    function youtubeApi() {
        let cntYoutube;

        // for (cntYoutube = 0; cntYoutube <= $('.media_cont').length; cntYoutube++) {

        //advertisement TV CF
        $(".media_cont.tv_cf").each(function () {

            var $this = $(this),
                ytid = $(this).attr("data-id");

            //maxResults = 가져올 개수

            $.ajax({
                type : "POST",
                url : "/youtubePlayList",
                dataType : "text",
                data :
                    {
                        playlistId : ytid
                    },
                error : function()
                {
                    console.log("AJAX ERROR");
                },
                success : function(data) {
                    var result = JSON.parse(data);

                    for (i = 0; i < result.items.length; i++){
                        let item = result.items[i];

                        var id = item.snippet.resourceId.videoId,
                            title = item.snippet.title,
                            url = 'https://www.youtube.com/watch?v=' + item.id,
                            thumb = item.snippet.thumbnails.maxres,
                            thumb2 = item.snippet.thumbnails,
                            date = item.snippet.publishedAt.substr(0, 10);

                        console.log(item.snippet.thumbnails)

                        if (i == 0) {
                            firstVideoId = id;
                        }
                        const tag =
                            '<div class="media_box"><div class="vid_box ad" data-id="' + id + '">' +
                                '<div class="img_box"><p class="media_tag ad"></p>' +
                                    '<div class="btn_play"><img src="/img/front/button/btn_play.png" alt="재생버튼"></div>' +
                                        '<div class="vid_img"><img src="' + thumb2.high.url + '" alt="' + title + '" loading="lazy"></div>' +
                                        '</div>' +
                                        '<div class="txt_box"><p class="vid_date">' + date + '</p>' +
                                        '<div class="vid_tit_box"><p class="vid_tit">' + title + '</p><img src="/img/front/icon/diagonal_arrow_mini.png" alt="재생버튼"></div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

                        $this.find(".v_list").append(tag);
                        //썸네일 화질 high시 이미지 높이 높아지지만 화질 좋아짐 medium
                    }

                }
            });

        });

        //advertisement 온라인 CF
        $(".media_cont.online_cf").each(function () {

            var $this = $(this),
                ytid = $(this).attr("data-id");

            //maxResults = 가져올 개수

            $.ajax({
                type : "POST",
                url : "/youtubePlayList",
                dataType : "text",
                data :
                    {
                        playlistId : ytid
                    },
                error : function()
                {
                    console.log("AJAX ERROR");
                },
                success : function(data) {
                    var result = JSON.parse(data);

                    for (i = 0; i < result.items.length; i++){
                        let item = result.items[i];

                        var id = item.snippet.resourceId.videoId,
                            title = item.snippet.title,
                            url = 'https://www.youtube.com/watch?v=' + item.id,
                            thumb = item.snippet.thumbnails.maxres,
                            thumb2 = item.snippet.thumbnails,
                            date = item.snippet.publishedAt.substr(0, 10);

                        console.log(item.snippet.thumbnails)

                        if (i == 0) {
                            firstVideoId = id;
                        }
                        const tag =
                            '<div class="media_box"><div class="vid_box ad" data-id="' + id + '">' +
                                '<div class="img_box"><p class="media_tag ad"></p>' +
                                    '<div class="btn_play"><img src="/img/front/button/btn_play.png" alt="재생버튼"></div>' +
                                        '<div class="vid_img"><img src="' + thumb2.high.url + '" alt="' + title + '" loading="lazy"></div>' +
                                        '</div>' +
                                        '<div class="txt_box"><p class="vid_date">' + date + '</p>' +
                                        '<div class="vid_tit_box"><p class="vid_tit">' + title + '</p><img src="/img/front/icon/diagonal_arrow_mini.png" alt="재생버튼"></div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

                        $this.find(".v_list").append(tag);
                        //썸네일 화질 high시 이미지 높이 높아지지만 화질 좋아짐 medium
                    }

                }
            });

        });

        //advertisement 기업광고
        $(".media_cont.corpor_cf").each(function () {

            var $this = $(this),
                ytid = $(this).attr("data-id");

            //maxResults = 가져올 개수

            $.ajax({
                type : "POST",
                url : "/youtubePlayList",
                dataType : "text",
                data :
                    {
                        playlistId : ytid
                    },
                error : function()
                {
                    console.log("AJAX ERROR");
                },
                success : function(data) {
                    var result = JSON.parse(data);

                    for (i = 0; i < result.items.length; i++){
                        let item = result.items[i];

                        var id = item.snippet.resourceId.videoId,
                            title = item.snippet.title,
                            url = 'https://www.youtube.com/watch?v=' + item.id,
                            thumb = item.snippet.thumbnails.maxres,
                            thumb2 = item.snippet.thumbnails,
                            date = item.snippet.publishedAt.substr(0, 10);

                        const tag =
                            '<div class="media_box"><div class="vid_box ad" data-id="' + id + '">' +
                                '<div class="img_box"><p class="media_tag ad"></p>' +
                                    '<div class="btn_play"><img src="/img/front/button/btn_play.png" alt="재생버튼"></div>' +
                                        '<div class="vid_img"><img src="' + thumb2.high.url + '" alt="' + title + '" loading="lazy"></div>' +
                                        '</div>' +
                                        '<div class="txt_box"><p class="vid_date">' + date + '</p>' +
                                        '<div class="vid_tit_box"><p class="vid_tit">' + title + '</p><img src="/img/front/icon/diagonal_arrow_mini.png" alt="재생버튼"></div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

                        $this.find(".v_list").append(tag);
                        //썸네일 화질 high시 이미지 높이 높아지지만 화질 좋아짐 medium
                    }

                }
            });

        });

        //youtube TV CF | 미디어 > 유튜브 : 슬라이드(애경)
        $(".media_cont.media_slide.you_ak").each(function () {

            var $this = $(this),
                ytid = $(this).attr("data-id");

            var firstVideoId;
            //API 백단 시작
            $.ajax({
                type : "POST",
                url : "/youtubePlayList",
                dataType : "text",
                data :
                    {
                        playlistId : ytid
                    },
                error : function()
                {
                    console.log("AJAX ERROR");
                },
                success : function(data) {
                    // console.log(data);
                    var result = JSON.parse(data);

                    for (i = 0; i < result.items.length; i++){
                         let item = result.items[i];

                        var id = item.snippet.resourceId.videoId,
                            title = item.snippet.title,
                            url = 'https://www.youtube.com/watch?v=' + item.id,
                            thumb = item.snippet.thumbnails.maxres,
                            thumb2 = item.snippet.thumbnails,
                            date = item.snippet.publishedAt.substr(0, 10);

                        if (i == 0) {
                            firstVideoId = id;
                        }

                        const tag =
                            '<div class="media_box slide_cont">' +
                                '<div class="vid_box ad" data-id="' + id + '">' +
                                    '<div class="img_box"><p class="media_tag ad"></p>' +
                                        '<div class="btn_play"><img src="/img/front/button/btn_play.png" alt="재생버튼"></div>' +
                                        '<div class="vid_img"><img src="' + thumb2.high.url + '" alt="' + title + '" loading="lazy"></div>' +
                                        '</div>' +
                                        '<div class="txt_box"><p class="vid_date">' + date + '</p>' +
                                        '<div class="vid_tit_box"><p class="vid_tit">' + title + '</p><img src="/img/front/icon/diagonal_arrow_mini.png" alt="재생버튼"></div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

                        $this.find(".v_list").append(tag);
                        //썸네일 화질 high시 이미지 높이 높아지지만 화질 좋아짐 medium
                    }

                    $this.find('.sub_slide_wr').slick({
                        slide: 'div',
                        infinite: false,
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        arrows: true,
                        prevArrow: $this.find(".slide_btn_wr").find('.slide_btn_prev'),
                        nextArrow: $this.find(".slide_btn_wr").find('.slide_btn_next'),
                        responsive: [
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 1,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });

                }
            });

        });
    }


    
    function mediaSlide02(){
        if ($('.media').hasClass('youtube')) {
            $('.sub_slide_wr').each(function() {
                var $this = $(this);        
                $this.slick({
                    slide: 'div',
                    infinite: false,
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    arrows: true,
                    prevArrow: $this.siblings(".slide_btn_wr").find('.slide_btn_prev'),
                    nextArrow: $this.siblings(".slide_btn_wr").find('.slide_btn_next'),
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 1
                            }
                        }
                    ]
                });
            });
          
        }
    }

    if ( $('.video_slide').length > 0 ) {
        var video_slide = new Swiper('.video_slide', {
            slidesPerView: 1.2,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            },
            spaceBetween: 10,
            // effect  : 'fade',
            speed : 1000,
            watchOverflow: false,
            loop:true,
            loopedSlides: 1,
        });
    } 
    
}); // End jQuery



