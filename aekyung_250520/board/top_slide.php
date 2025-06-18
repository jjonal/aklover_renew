<script type="text/javascript" src="/js/musign/board.js"></script>
<script type="text/javascript" src="/js/musign/suppoters.js"></script>
<link rel="stylesheet" type="text/css" href="/css/front/faq.css" />

<div class="slide_top cont_top f_sb">
    <? if($_GET["board"] == "group_04_03") { ?>
        <h2 class="fz32 fw600">공지사항</h2>
        <a href="/main/index.php?board=group_04_35&view_type=list" class="fz17 fw600">1:1 문의 하기</a>
        <!-- <a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487" class="fz17 fw600">1:1 문의 하기</a> -->
    <? } else if($_GET["board"] == "group_04_33") { ?>
        <h2 class="fz32 fw600">FAQ</h2>
        <a href="/main/index.php?board=group_04_35&view_type=list" class="fz17 fw600">1:1 문의 하기</a>
        <!-- <a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487" class="fz17 fw600">1:1 문의 하기</a> -->
    <? } else { ?>
        <h2 class="fz32 fw600">1:1 문의</h2>
    <? } ?>
</div>
<div class="best_qna">
    <p class="fz20 fw600" style="margin-bottom: 1rem;">TOP 5 질문</p>
    <div class="swiper-container best_qna_slide">
        <div class="swiper-wrapper">
            <div class="swiper-slide faq_btn_1">
                <div class="f_cs">
                    <!--!!!!!!!! [개발요청] 아이콘 관리자 연동 !!!!!!!!  -->
                    <img src="/img/front/board/faq01.png"alt="아이콘" class="icon">
                    <div class="quest" style="width: 80%;">
                        <span>FAQ 1.</span>
                        <p class="fz20 fw600 ellipsis_100">
                            AK Lover가 되려면 어떻게 해야 하나요? <img src="/img/front/main/tab_arr_right_w.webp" alt="질문 보기" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide faq_btn_2">
                <div class="f_cs">
                    <img src="/img/front/board/faq02.png"alt="아이콘" class="icon">
                    <div class="quest" style="width: 80%;">
                        <span>FAQ 2.</span>
                        <p class="fz20 fw600 ellipsis_100">
                            체험단에 참여하고 싶은데 어떻게 해야 하나요? <img src="/img/front/main/tab_arr_right_w.webp" alt="질문 보기" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide faq_btn_3">
                <div class="f_cs">
                    <img src="/img/front/board/faq01.png"alt="아이콘" class="icon">
                    <div class="quest" style="width: 80%;">
                        <span>FAQ 3.</span>
                        <p class="fz20 fw600 ellipsis_100">
                            체험단 가이드라인을 다운받고 싶어요! <img src="/img/front/main/tab_arr_right_w.webp" alt="질문 보기" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide faq_btn_4">
                <div class="f_cs">
                    <img src="/img/front/board/faq02.png"alt="아이콘" class="icon">
                    <div class="quest" style="width: 80%;">
                        <span>FAQ 4.</span>
                        <p class="fz20 fw600 ellipsis_100">
                            포인트 페스티벌이란 무엇인가요? <img src="/img/front/main/tab_arr_right_w.webp" alt="질문 보기" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide faq_btn_5">
                <div class="f_cs">
                    <img src="/img/front/board/faq01.png"alt="아이콘" class="icon">
                    <div class="quest" style="width: 80%;">
                        <span>FAQ 5.</span>
                        <p class="fz20 fw600 ellipsis_100">
                            슈퍼패스란 무엇인가요? <img src="/img/front/main/tab_arr_right_w.webp" alt="질문 보기" class="arr">
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="rel swbtn_wrap">
            <div class="swbtn swiper-button-prev"></div>
            <div class="swbtn swiper-button-next"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>

<!-- FAQ 팝업 제작 -->
<div id="faq_popup_1" class="guide_popup faq_popups" style="display: none;">
    <div class="inner rel">
        <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
        <div class="faq_popup_con t_c">
            <div class="q_num">FAQ1</div>
            <div class="faq_qes">AK Lover가 되려면 어떻게 해야 하나요?</div>
            <div class="faq_ans">
                AK Lover 홈페이지 가입 시 SNS 계정을 1개 이상 연결해주시면<br /> AK Lover 베이직 뷰티&라이프 클럽으로 활동이 가능하십니다.<br />
                또한 제한된 임기 없이 지속적으로 활동이 가능합니다.
            </div>
        </div>
    </div>
</div>

<div id="faq_popup_2" class="guide_popup faq_popups" style="display: none;">
    <div class="inner rel">
        <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
        <div class="faq_popup_con t_c">
            <div class="q_num">FAQ2</div>
            <div class="faq_qes">체험단에 참여하고 싶은데 어떻게 해야 하나요?</div>
            <div class="faq_ans">
                원하시는 체험단 배너를 클릭하신 뒤 순서대로 내용을 기입하시면 됩니다.<br />
                당첨 여부는 홈페이지 우측 상단 프로필 클릭 후<br /> [마이페이지] - [나의 체험단] - [선정된 체험단]에서 확인 가능합니다.<br />
                자세한 내용은 이용백서 서포터즈편을 참고하세요.
            </div>
        </div>
    </div>
</div>

<div id="faq_popup_3" class="guide_popup faq_popups" style="display: none;">
    <div class="inner rel">
        <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
        <div class="faq_popup_con t_c">
            <div class="q_num">FAQ3</div>
            <div class="faq_qes">체험단 가이드라인을 다운받고 싶어요!</div>
            <div class="faq_ans">
                체험단에 선정되시면, 홈페이지 우측상단 프로필 클릭 후<br />
                [마이페이지] - [나의 체험단] - [선정된 체험단]에서 선정된 체험단을 확인하실 수 있습니다.<br />
                그리고 선정된 체험단을 클릭하시면 우측<br /> [가이드라인 확인하기]를 통해 가이드라인을 다운로드 받을 수 있습니다.

            </div>
        </div>
    </div>
</div>

<div id="faq_popup_4" class="guide_popup faq_popups" style="display: none;">
    <div class="inner rel">
        <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
        <div class="faq_popup_con t_c">
            <div class="q_num">FAQ4</div>
            <div class="faq_qes">포인트 페스티벌이란 무엇인가요?</div>
            <div class="faq_ans">
                AK Lover 활동으로 적립된 포인트로<br /> 애경의 다양한 인기 제품을 직접 선택 후 교환할 수 있는 이벤트입니다<br />
                연 2회(상반기/하반기) 진행되며, 페스티벌 일정은 깜짝 공개됩니다. 많은 기대 부탁드립니다.<br />
                (상반기 : 이달의 AK Lover 및 프리미어 대상 / 하반기 : 전체 회원 대상)
            </div>
        </div>
    </div>
</div>

<div id="faq_popup_5" class="guide_popup faq_popups" style="display: none;">
    <div class="inner rel">
        <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
        <div class="faq_popup_con t_c">
            <div class="q_num">FAQ5</div>
            <div class="faq_qes">슈퍼패스란 무엇인가요?</div>
            <div class="faq_ans">
                슈퍼패스는 원하는 제품 체험단에 우선적으로 선정 가능한 티켓으로 선정 기준에 따라<br /> 매월 첫 번째 로그인 시 부여되며, 매월 마지막날 소멸됩니다.
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        const faqBtn = $('.best_qna .swiper-slide'),
              faqPop = $('.faq_popups');
        // faq 팝업
        $.each(faqBtn, function(){
            $(this).click(function(e){
                e.preventDefault();
                const thisIdx = $(this).attr('data-swiper-slide-index');
                faqPop.eq(thisIdx).show();
            });
        });
        $('.faq_popups .btn_x').click(function(){
            faqPop.hide();
        });
    });
</script>