<?
$pageCheck = $_GET["pageCheck"];
//musign s
$pageCheck = 'Y';//musign임시
//musign e
ob_start();
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
define('_HEROBOARD_', TRUE);//HEROBOARD오픈

include_once '../freebest/head.php';
include_once FREEBEST_INC_END.'hero.php';
include_once FREEBEST_INC_END.'function.php';

include_once PATH_INC_END.'top2.php';
#####################################################################################################################################################
?>
<!-- <link rel="stylesheet" type="text/css" href="/css/front/club_aklover.css" /> -->
<div id="subpage" class="aklove_page">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <div>
                    <h1 class="fz68 main_c fw500 ko">AK Lover 이용백서</h1>
                    <p class="fz18 fw600">AK Lover 서포터즈 이용방법 A to Z 까지 배워보세요!</p>
                </div>
                <!-- <ul class="tab f_c">
                    <li><a href="/main/beauty_life_aklover.php" class="fz18 fw600 on">Premium Club</a></li>
                    <li><a href="/main/multiclub_aklover.php" class="fz18 fw600">Basic Club</a></li>
                    <li><a href="/main/use_aklover.php" class="fz18 fw600">공정위 표시 및 위젯</a></li>
                </ul> -->
                <ul class="tab f_c">
                    <li><a href="/main/guide_aklover.php" class="fz18 fw600">홈페이지 편</a></li>
                    <li class="rel">
                        <a class="fz18 fw600 tab_btn on">서포터즈 편 <img src="/img/front/intro/arrow_white.webp" alt="화살표" /></a>
                        <ul class="tab_list">
                            <li><a href="/main/beauty_life_aklover.php" class="fz18 fw600 select">프리미어 클럽</a></li>
                            <li><a href="/main/multiclub_aklover.php" class="fz18 fw600">베이직 클럽</a></li>
                            <li><a href="/main/use_aklover.php" class="fz18 fw600">공정위 표시 및 위젯</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>        
    </div>
    <div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <div class="content_info">
                    <h3><span class="step">Step.1</span>프리미어 뷰티/라이프 클럽이란?</h3>
                    <p>
                        뷰티/생활용품 제품 리뷰에 전문성을 가진 서포터즈로<br />
                        연 2회 별도 모집하여 운영됩니다.
                    </p>
                </div>
            </div>
            <div class="contents right">
                <ul class="image_content grid_2">
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/beautyclub.webp" alt="뷰티 클럽" />
                        </div>
                        <p class="con_tit">Premier Beauty Club</p>
                        <p class="cont_des">애경의 뷰티 제품을 전문적으로 리뷰하는 서포터즈입니다.</p>
                        <div class="btn_moreview">
                            <a href="http://aklover-test.musign.kr/main/index.php?board=group_04_06">프리미어 뷰티 클럽 자세히 보기</a>
                        </div>
                    </li>
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/lifeclub.webp" alt="라이프 클럽" />
                        </div>
                        <p class="con_tit">Premier Life Club</p>
                        <p class="cont_des">
                            애경의 홈케어, 퍼스널케어 제품을 전문적으로 리뷰하는 서포터즈입니다.
                        </p>
                        <div class="btn_moreview">
                            <a href="http://aklover-test.musign.kr/main/index.php?board=group_04_28">프리미어 라이프 클럽 자세히 보기</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <div class="content_info">
                    <h3><span class="step">Step.2</span>프리미어 뷰티/라이프 클럽 혜택 확인하기</h3>
                    <p>
                        이 외 다양한 혜택은 서포터즈 선정 시 더욱 상세하게 안내드립니다.
                    </p>
                </div>
            </div>
            <div class="contents right">
                <ul class="gift_content">
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">1</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">최우수자 시상(최대 30만원)</div>
                            <p class="gift_info_des">
                                활동 기간 종료 후, 최종 우수자를 선정하여 최대 30만원 혜택을 제공합니다.<br />
                                <span class="gray">*혜택은 1등~3등에게 차등 제공하며, 숏폼팀은 별도 활동비를 지급합니다.</span>
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_1.webp" alt="혜택 1" />
                        </div>
                    </li>
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">2</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">월 우수자 시상 (최대 10만원)</div>
                            <p class="gift_info_des">
                                매월 우수한 컨텐츠를 작성해주신 ‘이달의 AK Lover’를 선정하여<br />
                                최대 10만원 상당의 상품권을 드립니다. <span class="gray">(최대 30명)</span>
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_2.webp" alt="혜택 2" />
                        </div>
                    </li>
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">3</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">선정자 전원 웰컴박스 증정 (10만원 상당)</div>
                            <p class="gift_info_des">
                                프리미어 클럽에 선정된 모든 분들을 환영하는 마음을 담아<br />
                                10만원 상당의 애경 제품을 제공합니다. <span class="gray">(1회)</span>
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_3.webp" alt="혜택 3" />
                        </div>
                    </li>
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">4</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">수료자 전원 땡큐 박스 증정 및 수료증 제공 (10만원 상당)</div>
                            <p class="gift_info_des">
                                프리미어 클럽의 필수 활동 조건을 충족한 분들에게<br />
                                감사의 마음을 담아 10만원 상당의 애경 제품 및 수료증을 제공합니다.
                                <span class="gray">(1회)</span>
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_4.webp" alt="혜택 4" />
                        </div>
                    </li>
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">5</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">포인트 페스티벌 참여 기회 제공(연 2회)</div>
                            <p class="gift_info_des">
                                다양한 활동으로 획득한 AK Lover 포인트를 애경 제품으로<br />
                                교환해 가실 수 있는 포인트 페스티벌 참여 기회를 제공합니다.
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_5.webp" alt="혜택 5" />
                        </div>
                    </li>
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">6</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">애경 제품 제공 (3만원 상당)</div>
                            <p class="gift_info_des">
                                리뷰 콘텐츠 작성을 위하여 각 콘텐츠 별 3만원 상당의 애경 신제품을 제공합니다.<br />
                                <span class="gray">(활동 기간 내 평균 20회 이상)</span>
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_6.webp" alt="혜택 5" />
                        </div>
                    </li>
                    <li>
                        <div class="gift_num">
                            <p class="en">benefit</p>
                            <p class="en">7</p>
                        </div>
                        <div class="gift_info">
                            <div class="gift_info_tit">AK Lover 포인트 제공 및 활용</div>
                            <p class="gift_info_des">
                                리뷰 콘텐츠 작성 시마다 AK Lover 포인트를 제공하며,<br />
                                키워드 챌린지 등 우수 콘텐츠로 선정될 시 별도 추가 포인트를 드립니다.<br />
                                <span class="gray">(적립 포인트는 제품 배송비(약 3,400원)로 대체 및 포인트 페스티벌 시 사용 가능)</span>
                            </p>
                        </div>
                        <div class="gift_icon">
                            <img src="/img/front/supporters/gift_icon_7.webp" alt="혜택 5" />
                        </div>
                    </li>
                </ul>
                <div class="gift_bottom">
                    <p>
                        그 외 프리미어 클럽을 위한 다양한 혜택은 선정될 시 더욱 상세하게 안내됩니다.<br />
                        프리미어 클럽 여러분의 많은 관심과 신청 부탁드립니다. <span class="gray">* 활동 혜택은 상황에 따라 변동될 수 있습니다.(프리미어/베이직 동일 적용)</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="sub_cont">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <div class="content_info">
                    <h3><span class="step">Step.3</span>프리미어 뷰티/라이프 클럽<br />포인트 제도 알아보기</h3>
                    <p>
                        나에게 맞는 서포터즈 활동하고 포인트를 적립할 수 있습니다.
                    </p>
                </div>
            </div>
            <div class="contents right">
                <ul class="point_contents">
                    <li class="">
                        <div class="point_info">
                            <p><span class="number">1</span>포인트 지급</p>
                            <ul>
                                <li>숏폼은 릴스/숏츠/틱톡/네이버모먼트 등에 해당합니다.</li>
                                <li>게시글/댓글을 통한 포인트 획득은 일 최대 20P까지 가능합니다.</li>
                                <li>포인트 지급 기준은 상황에 따라 변동될 수 있습니다.</li>
                            </ul>
                        </div>
                        <!-- <div style="margin-top: 2rem;">
                            <img src="/img/front/intro/point1.png" alt="포인트 지급">
                        </div> -->

                        <div class="table_container t_c club_tb">
                            <div class="table_head grid_custom">
                                <div>활동 구분</div>
                                <div>활동 내용</div>
                                <div>point</div>
                            </div>
                            <ul class="table_body">
                                <li class="grid_custom g2">
                                    <div class="division">홈페이지</div>
                                    <div class="tb_inner">
                                        <div class="grid_custom g2_1">
                                            <div>회원가입 후 첫 로그인</div>
                                            <div class="no_line">+ 1,000</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>신규회원 추천</div>
                                            <div class="no_line">+ 1,000</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>한 달 출석 완료</div>
                                            <div class="no_line">+ 1,000</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>생일 축하</div>
                                            <div class="no_line">+ 1,000</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>게시글 작성</div>
                                            <div class="no_line">+ 1,000</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>댓글 작성</div>
                                            <div class="no_line">+ 1,000</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>신규회원 추천</div>
                                            <div class="no_line">일 출석 체크</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="grid_custom g2">
                                    <div class="division">서포터즈</div>
                                    <div class="tb_inner">
                                        <div class="grid_custom g2_1">
                                            <div>회원가입 후 첫 로그인</div>
                                            <div class="no_line">+ 2,000</div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange">콘텐츠 작성</div>
                                            <div class="tb_inner">
                                                <div class="grid_custom g2_3 ti">
                                                    <div>숏폼 영상</div>
                                                    <div class="no_line">+ 1,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti">
                                                    <div>숏폼 영상</div>
                                                    <div class="no_line">+ 1,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti">
                                                    <div>인스타그램</div>
                                                    <div class="no_line">+ 1,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti">
                                                    <div>블로그</div>
                                                    <div class="no_line">+ 2,000</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange">콘텐츠 작성</div>
                                            <div class="tb_inner">
                                                <div class="grid_custom g2_3 ti">
                                                    <div>상위노출</div>
                                                    <div class="no_line">+ 1,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti">
                                                    <div>참여</div>
                                                    <div class="no_line">+ 1,000</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>필수 미션 외 기타 SNS</div>
                                            <div class="no_line">+ 500</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>설문조사</div>
                                            <div class="no_line">+ 300 ~ 500</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="grid_custom g2">
                                    <div class="division">활용</div>
                                    <div class="tb_inner">
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange">후기 2차 활용</div>
                                            <div class="tb_inner">
                                                <div class="grid_custom g2_3 ti">
                                                    <div>단순 활용</div>
                                                    <div class="no_line">+ 2,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti">
                                                    <div>원본 활용</div>
                                                    <div class="no_line">5만원 상당 제품 제공</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="">
                        <div class="point_left">
                            <div class="point_info">
                                <p><span class="number">2</span>포인트 차감</p>
                                <ul>
                                    <li>
                                        서포터즈 신청 후 콘텐츠 미작성 시 포인트 차감<br /> 
                                        및 이후 서포터즈 선정에서 제외됩니다.
                                    </li>
                                </ul>
                            </div>
                        </div>                        
                        <div style="margin-top: 2rem;">
                            <img src="/img/front/intro/point2.png" alt="포인트 차감">
                        </div>
                        <!-- <div class="point_right">
                            <div class="table_container t_c">
                                <div class="table_head grid_custom">
                                    <div>활동 내용</div>
                                    <div>point</div>
                                </div>
                                <ul class="table_body">
                                    <li class="grid_custom">
                                        <div>블로그팀 후기 미작성</div>
                                        <div>-3,000</div>
                                    </li>
                                    <li class="grid_custom">
                                        <div>인스타그램/숏폼팀 후기 미작성</div>
                                        <div>-2,500</div>
                                    </li>
                                    <li class="grid_custom">
                                        <div>후기 작성/숏폼 초안 전달 기간 미준수</div>
                                        <div>-1,500</div>
                                    </li>
                                    <li class="grid_custom">
                                        <div>가이드라인 미준수 (수정 안내 후 미수정)</div>
                                        <div>-1,500</div>
                                    </li>
                                </ul>
                            </div>
                        </div> -->
                    </li>
                    <li class="">
                        <div class="point_left">
                            <div class="point_info">
                                <p><span class="number">3</span>포인트 적립 기준</p>
                            </div>
                        </div>                                             
                        <div style="margin-top: 2rem;">
                            <img src="/img/front/intro/point3.png" alt="포인트 차감">
                        </div>
                        <!-- <div class="point_right">
                            <div class="point_notice">
                                <ul class="pn_content">
                                    <li>                                        
                                        콘텐츠 별 적립 기준<br /> 
                                        <span class="fz15">숏폼, 인스타그램, 블로그 각 매체별로 1건 씩만 인정됩니다.</span>
                                        <p class="pn_des">
                                            ex. A회원이 본인 소유 블로그a, 블로그b에 컨텐츠 작성 → 블로그 1건만 적립<br />
                                            B회원이 본인 소유 블로그a, 인스타그램a, b에 컨텐츠 작성 → 블로그 1건, 인스타 1건 적립<br />
                                            C회원이 본인 소유 블로그a, 인스타그램a, 릴스a 컨텐츠 작성<br />
                                            → 블로그 1건, 인스타 1건, 릴스 1건 적립
                                        </p>
                                    </li>
                                    <li>
                                        키워드 챌린지 적립 기준
                                        <p class="pn_des">
                                            - 키워드 챌린지란? 네이버에서 운영하는 인플루언서 관련 서비스입니다.
                                           <a href="https://help.naver.com/service/22665/contents/10765?lang=ko" target="_blank" class="bold more_view">자세히 보기 <b class="arr_img"></b></a><br />
                                            - 적립 기준<br />
                                            (1) 홈페이지 후기 작성 시 URL 등록 필수<br />
                                            (2) 상위 노출 시, 화면 캡쳐 후 AK Lover 뷰티/라이프 클럽 카카오톡 전송 필수
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div> -->
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    /* grid */
    .aklove_page {

    }
    .aklove_page .left {
        width: 42rem;
    }
    .aklove_page .right {
        width: calc(100% - 56.3rem);
        margin-bottom: 20rem;
    }
    @media(max-width: 1260px) {
        .aklove_page .left {
            width: 360px;
        }
        .aklove_page .right {
            width: calc(100% - 380px);
        }   
    }
    .aklove_page .pb_s {
        margin-bottom: 15.2rem;
    }

    .aklove_page .pb_m {
        margin-bottom: 20rem;
    }

    .content_info {
        border-top: 1px solid #000;
        padding-top: 2.8rem;
    }

    .content_info h3 {
        font-size: 2rem;
        font-weight: bold;
        line-height: 1.5;
        letter-spacing: -0.06rem;
        position: relative;
        padding-left: 7rem;
    }
    .about .content_info h3,
    .use_aklover .content_info h3 {
        padding-left: 0;
    }
    .content_info h3 .step {
        position: absolute;
        left: 0;
        top: 0;
        color: #ff4c05;
        text-decoration: underline;
        margin-right: 1.4rem;
    }

    .content_info p {
        margin-top: 3.2rem;
        font-size: 1.5rem;
        line-height: 1.5;
        letter-spacing: -0.045rem;
        font-weight: 500;
        opacity: 0.7;
    }
    .use_aklover .content_info p {
        margin-top: 2rem;
    }
    .method_list {
        margin-top: 4.9rem;
    }

    .method_list .method_item {
        margin-bottom: 3rem;
    }

    .method_list .item_word {
        background-color: #f8f8f8;
        width: fit-content;
        padding: 0.9rem 1rem;
        font-size: 1.65rem;
        font-weight: 500;
        line-height: 1.45;
        letter-spacing: -0.083rem;
    }

    .method_list .item_des {
        margin-top: 1.7rem;
        font-size: 1.5rem;
        font-weight: 500;
        line-height: 1.6;
        letter-spacing: -0.075rem;
        opacity: 0.7;
    }

    .caution {
        background-color: #f8f8f8;
        border-radius: 0.5rem;
        padding: 4.5rem 6rem;
        gap: 5rem;
    }

    .caution p {
        font-size: 1.95rem;
        line-height: 1.64;
        letter-spacing: -0.098rem;
    }

    .content {
        margin-bottom: 5rem;
    }

    .content .con_left {
        width: calc(100% - 50rem);
    }

    .content .con_right {    
        width: 48rem;
    }

    .con_info h3 {
        font-size: 2.2rem;
        font-weight: bold;
        line-height: 1.39;
        letter-spacing: -0.11rem;
    }

    .con_info .point {
        color: #ff4c05;    
        font-size: 1.65rem;
        font-weight: 600;
        margin-left: 1rem;
    }

    .con_info .description {
        font-size: 1.5rem;
        color: #373737;
        line-height: 1.6;
        letter-spacing: -0.075rem;
        margin: 1.2rem 0;
    }

    .con_info .method {
        margin: 3rem 0 1.6rem;
        background-color: #f8f8f8;
        border-radius: 0.5rem;
        width: fit-content;
        font-size: 1.65rem;
        font-weight: 600;
        letter-spacing: -0.083rem;
        padding: 0.8rem 1rem;
    }

    .con_info .method_banner_list li {
        font-size: 1.5rem;
        line-height: 1.55;
        font-weight: 500;
        letter-spacing: -0.045rem;
        margin-bottom: 0.8rem;
    }

    .content_info .btn_round {
        width: fit-content;
        border: 1px solid #e5e5e5;
        border-radius: 2.4rem;
        margin-top: 3.9rem;
    }

    .content_info .btn_round a {
        padding: 1.6rem 3rem;
        display: block;
        cursor: pointer;
        font-size: 1.7rem;
        font-weight: 600;
        letter-spacing: -0.085rem;
    }

    .con_info .btn_square {
        margin-top: 3.4rem;
        background-color: #000;
        width: fit-content;
        border-radius: 0.5rem;
    }

    .con_info .btn_square a {
        display: block;
        padding: 1.5rem 2.3rem;
        color: #fff;
        font-size: 1.8rem;
        line-height: 1.3;
        letter-spacing: -0.09rem;
        cursor: pointer;
    }

    .con_info .btn_square img {
        vertical-align: inherit;
        margin-left: 1rem
    }


    .con_info .number {
        display: inline-block;
        width: 2.1rem;
        height: 2.1rem;
        border-radius: 0.3rem;
        background-color: #ff4c05;
        color: #fff;
        font-size: 1.4rem;
        font-weight: 800;
        text-align: center;
        line-height: 2.1rem;
        margin-right: 1rem;
    }

    .content .banner {
        background-color: #f8f8f8;
        border-radius: 1rem;
        text-align: center;
        padding: 8rem 0;
    }

    .content .pad_short {
        padding: 4rem 0;
    }

    .banner .banner_image {
        margin: 0 auto;
    }

    .banner .text {
        font-size: 3.2rem;
        font-weight: bold;
        line-height: 2.5;
        letter-spacing: -0.16rem;
    }

    .banner .banner_info {
        margin-top: 2rem;
        font-size: 1.5rem;
        opacity: 0.7;
        font-weight: 500;
        line-height: 1.4;
        letter-spacing: -0.045rem;
    }

    .image_content {
        grid-row-gap: 4.9rem;
    }

    .image_content .con_tit {
        margin-top: 1.8rem;
        font-size: 2rem;
        font-weight: bold;
        letter-spacing: -0.1rem;
    }

    .image_content .con_tit a {
        font-size: 2rem;
        font-weight: bold;
        letter-spacing: -0.1rem;
    }

    .image_content .con_tit .arrow {
        margin-left: 0.7rem;
    }

    .image_content .con_tit .arrow img {
        vertical-align: top;
    }

    .image_content .cont_des {
        margin-top: 1.8rem;
        font-size: 1.65rem;
        letter-spacing: -0.083rem;
        line-height: 1.58;
        color: #373737;
    }
    .image_content .cont_des .mini {
        font-size: 1.2rem;
        display: inline-block;
        vertical-align: top;
    }
    .image_content .btn_moreview {
        margin-top: 4rem;
        width: fit-content;
        border: 1px solid #e5e5e5;
        border-radius: 4rem;
    }

    .image_content .btn_moreview a {
        display: block;
        padding: 1.6rem 3rem;
        font-size: 1.7rem;
        font-weight: 600;
        line-height: 1.71;
        letter-spacing: -0.085rem;
    }

    .gift_content li {
        background-color: #fafafa;
        display: grid;
        grid-template-columns: 1fr 3fr 1.5fr;
        grid-column-gap: 1rem;
        align-items: center;
        padding: 3rem 0rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .gift_content .gift_num {
        text-align: center;
    }

    .gift_content .gift_num p:first-child {
        color: #ff4c05;
        font-size: 1.5rem;
        letter-spacing: -0.045rem;
    }

    .gift_content .gift_num p:last-child {
        margin-top: 1.3rem;
        color: #ff4c05;
        font-size: 5rem;
    }

    .gift_content .gift_info_tit {
        font-size: 1.95rem;
        font-weight: bold;
        line-height: 1.33;
        letter-spacing: -0.117rem;
    }

    .gift_content .gift_info_des {
        font-size: 1.5rem;
        line-height: 1.5;
        letter-spacing: -0.09rem;
        opacity: 0.8;
        margin-top: 1rem;
    }

    .gift_content .gift_icon {
        margin: 0 auto;
    }

    .gift_bottom {
        position: relative;
        margin: 3rem 0;
    }

    .gift_bottom::before {
        content:"※";
        display: inline-block;
        position: absolute;
        top: 0.5rem;
        left: 0;
    }

    .gift_bottom p {
        font-size: 1.5rem;
        color: #373737;
        line-height: 1.6;
        letter-spacing: -0.075rem;
        margin-left: 2rem;
    }

    .point_contents > li {
        gap: 1rem;
        margin-bottom: 8rem;
    }

    /* .point_contents .point_left {
        width: calc(100% - clamp(40rem, 60%, 65rem));
    }

    .point_contents .point_right {
        width: clamp(45rem, 60%, 62.4rem);
    } */

    .point_contents .point_info p {
        font-size: 1.95rem;
        font-weight: bold;
        line-height: 1.33;
        letter-spacing: -0.098rem;
    }

    .point_contents .point_info .number {
        display: inline-block;
        width: 2.1rem;
        height: 2.1rem;
        border-radius: 0.3rem;
        background-color: #ff4c05;
        color: #fff;
        font-size: 1.4rem;
        font-weight: 800;
        text-align: center;
        line-height: 2.1rem;
        margin-right: 1rem;
        vertical-align: text-bottom;
    }

    .point_contents .point_info ul {
        margin-top: 2.6rem;
        padding-left: 1.3rem;
    }

    .point_contents .point_info ul li {
        font-size: 1.65rem;
        color: #373737;
        line-height: 1.58;
        letter-spacing: -0.083rem;
        list-style-type: '- ';
        list-style-position : outside;
    }

    /* 테이블 CSS ______________________________________________________________________________________________________________________*/
    .grid_custom {
        display: grid;
        grid-template-columns: 23fr 57.2fr 23.4fr;
        grid-column-gap: 0.4rem;
        align-items: center;
    }

    /* 추가 */
    .grid_custom.g2 {
        grid-template-columns: 23fr 80.6fr;
        grid-column-gap: 0.4rem;
    }
    /* 추가 */
    .grid_custom.g2_1 {
        grid-template-columns: 57.2fr 23.4fr;
        grid-column-gap: 0.4rem;
        padding: 1.9rem 0;
    }
    .grid_custom.g2_2 {
        grid-template-columns: 15fr 65.6fr;
        grid-column-gap: 0.4rem;
        padding: 1.9rem 0;
    }
    .grid_custom.g2_3 {
        grid-template-columns: 42fr 23.4fr;
        grid-column-gap: 0.4rem;
        padding: 1.9rem 0;
    }
    .padd_1 {
        padding: 1rem !important;
    }
    .grid_custom.ti > div:first-child {
        text-indent: -150px;
    }

    .table_container {
        border: 1px solid #e5e5e5;
        padding: 2rem 2rem 1rem;
        border-radius: 0.5rem;

    }
    .table_container .table_head > div {
        background-color: #f8f8f8;
        padding: 1.5rem 0;
        border-radius: 0.5rem;
        font-size: 1.65rem;
        font-weight: 500;
        letter-spacing: -0.083rem;
    }

    /* 추가 */
    .table_container .table_body .division {
        height: 100%;
        background-color: #f8f8f8;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .table_container .table_body .division.color_orange {
        background-color: rgba(255, 76, 5, 0.05);
    }

    .table_container .table_body li {
        padding: 1rem 0;
        border-bottom: 1px solid #e5e5e5;
    }

    .table_container .table_body li:last-child {
        border-bottom: 0;
    }

    .table_container .table_body li > div {
        font-size: 1.7rem;
        font-weight: 500;
        letter-spacing: -0.085rem;
        line-height: 1.53;
    }

    .table_container .table_body li > div:first-child {
        position: relative;
    }

    .table_container .table_body li > div:first-child::after {
        display: block;
        content: "";
        width: 1px;
        height: 2.6rem;
        background-color: #e5e5e5;
        position: absolute;
        top: 0; 
        right: -0.4rem;
    }

    .table_container .table_body .tb_inner > div {
        border-bottom: 1px solid #e5e5e5;
    }

    .table_container .table_body .tb_inner > div > div {
        position: relative;
    }

    .table_container .table_body .tb_inner div > div:not(.no_line)::after {
        display: block;
        content: "";
        width: 1px;
        height: 2.5rem;
        background-color: #e5e5e5;
        position: absolute;
        top: 50%;
        right: -0.5rem;
        transform: translate(-50%, -50%);
    }

    .table_container .table_body .tb_inner > div:last-child {
        border-bottom: 0;
    }

    .point_contents .point_image img {
        width: 100%;
    }

    .point_contents .point_notice {
        border: 1px solid #e5e5e5;
        padding: 2rem;
    }

    .point_contents .point_notice .pn_top {
        background-color: #f8f8f8;
        border-radius: 0.5rem;
        padding: 1.4rem 0;
        font-size: 1.65rem;
        text-align: center;
        font-weight: 500;
        letter-spacing: -0.083rem;
    }

    .point_contents .point_notice .pn_content {
        counter-reset: colorcircle 0;
    }

    .point_contents .point_notice .pn_content li {
        padding: 3rem 4rem;
        border-bottom: 1px solid #e5e5e5;
        counter-increment: colorcircle 1;
        list-style-position: inside;

        font-size: 1.65rem;
        font-weight: 500;
        line-height: 1.58;
        letter-spacing: -0.083rem;
    }

    .point_contents .point_notice .pn_content li::before {
        display: inline-block;
        content: counter(colorcircle) ". ";
    }

    .point_contents .point_notice .pn_content li:last-child {
        border-bottom: 0;
    }

    .point_contents .point_notice .pn_content .pn_des {
        margin-top: 1.9rem;
        color: rgba(55, 55, 55, 0.8);
        font-size: 1.5rem;
        line-height: 1.63;
        letter-spacing: -0.075rem;
    }

    .point_contents .point_notice .pn_content .pn_des span {
        display: inline-block;
        line-height: 1;
    }

    .point_contents .point_notice .pn_content .pn_des .arr_img {
        width: 0.6rem;
        height: .6rem;
        background: url(/img/front/intro/diagonal_arrow.webp) no-repeat center;
        background-size: contain;
        display: block;
        position: absolute;
        right: 1.1rem;
        top: .9rem;
    }
    .point_contents .point_notice .pn_content .more_view {
        display: inline-block;
        height: 3rem;
        line-height: 3rem;
        background-color: #f6f6f6;
        border-radius: 1.5rem;
        padding: 0 2.2rem 0 1.5rem;
        font-size: 1.2rem;
        margin-left: .2rem;
        transition: .4s;
        position: relative;
    }
    .point_contents .point_notice .pn_content .more_view:hover {
        background: #000;
        color: #fff;
    }
    .point_contents .point_notice .pn_content .more_view:hover .arr_img {
        background: url(/img/front/intro/diagonal_arrow_wh.png) no-repeat center;
        background-size: contain;
    }

    /* 팝업 */
    .popup .inner {
        height: 82vh;
    }


    /* pc 1290 */
    @media(max-width: 1680px) {
        .point_contents .point_notice .pn_content li {
            padding: 3rem 1rem;
        }
    }
</style>
<?
//서포터즈 신청자 확인은 푸터X
include_once  PATH_INC_END.'tail2.php';
?>
