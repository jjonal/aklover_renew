<script type="text/javascript" src="/js/musign/board.js"></script>
<link rel="stylesheet" type="text/css" href="/m/css/musign/faq.css" />

<div class="slide_top cont_top">
    <ul class="f_cs">
        <li class="<? if($_GET["board"] == "group_04_03") { ?>on<? } ?>">
            <a href="/m/today.php?board=group_04_03">공지사항</a>
        </li>
        <li class="<? if($_GET["board"] == "cus_2") { ?>on<? } ?>">
            <a href="/m/faq.php?board=cus_2">FAQ</a>
        </li>
        <li class="<? if($_GET["board"] == "cus_3" || $_GET["board"] == "mail"|| $_GET["board"] == "group_02_02" ) { ?>on<? } ?>">
            <a href="/m/customer.php?board=cus_3&view_type=list">1:1 문의</a>
        </li>
    </ul>
    <div class="caution">
        <h3 class="fz28 fw600 conttop_tit">안내/유의사항</h3>
        <div>
            <div class="">
                <? if($_GET["board"] == "group_04_03") { ?>
                    <div class="f_fs">
                        <img src="/img/front/icon/caution.webp" alt="안내/유의사항">
                        <p class="fz24">
                            AK Lover 활동 및 운영에 대해서는 공지사항을 확인해주세요!<br />
                            그 외 궁금하신 사항은 FAQ를 확인하거나, 1:1 문의를 남겨주세요!                            
                        </p>
                    </div>
                <? } else if($_GET["board"] == "cus_2") { ?>
                    <div class="f_fs">
                        <img src="/img/front/icon/caution.webp" alt="안내/유의사항">
                        <p class="fz24">
                            AK Lover 활동 및 운영에 대해서는 공지사항을 확인해주세요!<br />
                            그 외 궁금하신 사항은 FAQ를 확인하거나, 1:1 문의를 남겨주세요!                            
                        </p>
                    </div>
                    <span class="fz24 info">
                        문의전화 : 080-024-1357 (수신자부담)<br>
                        상담시간 : 평일 9시~18시 (토, 일, 법정 공휴일 제외)
                    </span>
                <? } else { ?>
                    <div class="f_fs">
                        <img src="/img/front/icon/caution.webp" alt="안내/유의사항">
                        <p class="fz24">
                            AK Lover 활동 및 운영에 대해서는 공지사항을 확인해주세요!<br />
                            그 외 궁금하신 사항은 FAQ를 확인하거나, 1:1 문의를 남겨주세요!                            
                        </p>
                    </div>
                        <span class="fz24 info">
                            문의전화 : 080-024-1357 (수신자부담)<br>
                            상담시간 : 평일 9시~18시 (토, 일, 법정 공휴일 제외)
                        </span>
                <? } ?>

            </div>
        </div>
    </div>
</div>
<div class="best_qna">
    <h3 class="fz28 fw600 conttop_tit">TOP5 질문</h3>
    <div class="swiper-container best_qna_slide">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="f_cs">
                    <img src="/img/front/board/faq01.png"alt="아이콘" class="icon">
                    <div class="quest">
                        <span>FAQ 1.</span>
                        <p class="fz20 fw600">
                            AK Lover가 되려면 어떻게 해야 하나요? <img src="/img/front/main/tab_arr_right_w.webp" alt="질문 보기" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="f_cs">
                    <img src="/img/front/board/faq02.png"alt="아이콘" class="icon">
                    <div class="quest">
                        <span>FAQ 2.</span>
                        <p class="fz20 fw600">
                        체험단에 참여하고 싶은데 어떻게 해야 하나요? <img src="/img/front/main/tab_arr_right_w.webp" alt="질문 보기" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="f_cs">
                    <img src="/img/front/board/faq01.png"alt="아이콘" class="icon">
                    <div class="quest">
                        <span>FAQ 3.</span>
                        <p class="fz20 fw600">
                        체험단 가이드라인을 다운받고 싶어요! <img src="/img/front/main/tab_arr_right_w.webp" alt="질문 보기" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="f_cs">
                    <img src="/img/front/board/faq02.png"alt="아이콘" class="icon">
                    <div class="quest">
                        <span>FAQ 4.</span>
                        <p class="fz20 fw600">
                            포인트 페스티벌이란 무엇인가요? <img src="/img/front/main/tab_arr_right_w.webp" alt="질문 보기" class="arr">
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="f_cs">
                    <img src="/img/front/board/faq01.png"alt="아이콘" class="icon">
                    <div class="quest">
                        <span>FAQ 5.</span>
                        <p class="fz20 fw600">
                            슈퍼패스란 무엇인가요? <img src="/img/front/main/tab_arr_right_w.webp" alt="질문 보기" class="arr">
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
<div class="page_tit">
    <? if($_GET["board"] == "group_04_03") { ?>
        <p class="fz44 fw600">공지사항</p>
    <? } else if($_GET["board"] == "cus_2") { ?>
        <p class="fz44 fw600">FAQ</p>
    <? } else { ?>
        <p class="fz44 fw600">1:1 문의</p>
    <? } ?>
</div>
<!-- FAQ 팝업 제작 -->
<div id="faq_popup_1" class="guide_popup faq_popups" style="display: none;">
    <div class="inner rel">
        <div class="btn_x"><img src="/img/front/main/hd_search_close.webp" alt="닫기"></div>
        <div class="faq_popup_con t_c">
            <div class="q_num">FAQ1</div>
            <div class="faq_qes">AK Lover가 되려면 어떻게 해야 하나요?</div>
            <div class="faq_ans">
                AK Lover 홈페이지 가입 시 SNS 계정을 1개 이상 연결해주시면 AK Lover 베이직 뷰티&라이프 클럽으로 활동이 가능하십니다.
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
                원하시는 체험단 배너를 클릭하신 뒤 순서대로 내용을 기입하시면 됩니다.
                당첨 여부는 홈페이지 우측 상단 프로필 클릭 후 [마이페이지] - [나의 체험단] - [선정된 체험단]에서 확인 가능합니다.
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
                체험단에 선정되시면, 홈페이지 우측상단 프로필 클릭 후
                [마이페이지] - [나의 체험단] - [선정된 체험단]에서 선정된 체험단을 확인하실 수 있습니다.
                그리고 선정된 체험단을 클릭하시면 우측
                [가이드라인 확인하기]를 통해 가이드라인을 다운로드 받을 수 있습니다.
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
                AK Lover 활동으로 적립된 포인트로
                애경의 다양한 인기 제품을 직접 선택 후 교환할 수 있는 이벤트입니다
                연 2회(상반기/하반기) 진행되며, 페스티벌 일정은 깜짝 공개됩니다. 많은 기대 부탁드립니다.
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
                슈퍼패스는 원하는 제품 체험단에 우선적으로 선정 가능한 티켓으로 선정 기준에 따라
                매월 첫 번째 로그인 시 부여되며, 매월 마지막날 소멸됩니다.
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        const faqBtn = $('.best_qna .swiper-slide'), faqPop = $('.faq_popups');
            $.each(faqBtn, function(){
                $(this).click(function(e){
                    e.preventDefault();
                    const thisIdx = $(this).attr('data-swiper-slide-index');
                    faqPop.eq(thisIdx).show();
                })
            })
            $('.faq_popups .btn_x').click(function(){
            faqPop.hide();
        });
    });
</script>