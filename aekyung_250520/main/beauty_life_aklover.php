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
<link rel="stylesheet" type="text/css" href="/css/front/club_aklover.css" />

<!-- 수정버전 -->
<div id="subpage" class="aklove_page">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <div>
                    <h1 class="fz68 main_c fw500 ko">AK Lover 이용백서</h1>
                    <p class="fz18 fw600">AK Lover 홈페이지 이용방법 A to Z 까지 배워보세요!</p>
                </div>
                <ul class="tab f_c">
                    <li><a href="/main/guide_aklover.php" class="fz18 fw600">홈페이지 편</a></li>
                    <li class="rel">
                        <a class="fz18 fw600 tab_btn on">서포터즈 편 <img src="/img/front/intro/arrow_white.webp" alt="화살표" /></a>
                        <ul class="tab_list">
                            <li><a href="/main/beauty_life_aklover.php" class="fz18 fw600 select">프리미어 서포터즈</a></li>
                            <li><a href="/main/basic_aklover.php" class="fz18 fw600">베이직 서포터즈</a></li>
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
                    <a href="/main/beauty_life_aklover.php" class="fz18 fw600 f_cs mission_guide_btn">참여방법 보러가기<img src="/img/front/member/arr.webp" alt="참여방법 보러가기"></a>
                </div>
            </div>
            <div class="contents right">
                <ul class="image_content grid_2">
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/beautyclub.webp" alt="뷰티 클럽" />
                        </div>
                        <p class="con_tit">Premier Beauty Club</p>
                        <p class="cont_des">뷰티 신제품 사용 후 <b class="bold">전문적으로</b> 콘텐츠를 발행하는 서포터즈</p>
                        <div class="btn_moreview">
                            <a href="/main/index.php?board=group_04_06">프리미어 뷰티 클럽 자세히 보기</a>
                        </div>
                    </li>
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/lifeclub.webp" alt="라이프 클럽" />
                        </div>
                        <p class="con_tit">Premier Life Club</p>
                        <p class="cont_des">
                            생활용품 신제품 사용 후 <b class="bold">전문적으로</b> 콘텐츠를 발행하는 서포터즈
                        </p>
                        <div class="btn_moreview">
                            <a href="/main/index.php?board=group_04_28">프리미어 라이프 클럽 자세히 보기</a>
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
                            <div class="gift_info_tit">최우수자 시상(최대 30만원 + AK Lover 포인트 20만점)</div>
                            <p class="gift_info_des">
                                활동 기간 종료 후, 최종 우수자를 선정하여 최대 30만원 + AK Lover 포인트 20만점 혜택을 제공합니다.<br />
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
                                매월 우수한 콘텐츠를 작성해주신 ‘이달의 AK Lover’를 선정하여<br />
                                최대 10만원 상당의 상품권을 드립니다. <span class="gray">(최대 20명)</span>
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
                                프리미어 서포터즈에 선정된 모든 분들을 환영하는 마음을 담아<br />
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
                                프리미어 서포터즈의 필수 활동 조건을 충족한 분들에게<br />
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
                                다양한 활동으로 적립된 포인트로 애경의 인기 제품을<br />
                                직접 선택 후 교환할 수 있는 이벤트입니다.<br />
                                <span class="gray">(상반기 : 이달의 AK Lover 및 프리미어 서포터즈 대상 / 하반기 : 전체 회원 대상)</span>
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
                            <div class="gift_info_tit">애경 신제품/스테디 셀러 제품 제공</div>
                            <p class="gift_info_des">
                                콘텐츠 작성을 위하여 애경 신제품/스테디 셀러 제품을 제공합니다.<br />
                                <span class="gray">(활동 기간 내 평균 20회)</span>
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
                        ‘프리미어 뷰티/라이프 클럽’는 연 2회(상반기/하반기) 별도 모집하오니 많은 관심 부탁드립니다.<br />
                        위 활동 혜택은 상황에 따라 변경될 수 있습니다. 
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
                    <li>
                        <div class="point_info">
                            <p><span class="number">1</span>포인트 지급</p>
                            <ul>
                                <li>숏폼은 릴스/숏츠/틱톡/네이버모먼트 등에 해당합니다.</li>
                                <li>게시물/댓글 작성을 통한 포인트 획득은 일 최대 20P까지 가능합니다.</li>
                                <li>포인트 지급 기준은 상황에 따라 변동될 수 있습니다.</li>
                            </ul>
                        </div>
                        <div class="table_container t_c club_tb">
                            <div class="table_head grid_custom">
                                <div>활동 구분</div>
                                <div>활동 내용</div>
                                <div>포인트</div>
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
                                            <div class="no_line">+ 50</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>생일 축하</div>
                                            <div class="no_line">+ 10</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>게시글 작성</div>
                                            <div class="no_line">+ 2</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>댓글 작성</div>
                                            <div class="no_line">+ 1</div>
                                        </div>
                                        <div class="grid_custom g2_1">
                                            <div>일 출석 체크</div>
                                            <div class="no_line">+ 1</div>
                                        </div>
                                    </div>
                                </li>
                                <li class="grid_custom g2">
                                    <div class="division">서포터즈</div>
                                    <div class="tb_inner">
                                        <div class="grid_custom g2_2 padd_1b">
                                            <div class="division color_orange no_line">콘텐츠 작성</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>블로그 <span class="fz14 gray">(해당 팀/해당 팀 外)</span></div>
                                                    <div class="no_line">+ 2,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>인스타그램 <span class="fz14 gray">(해당 팀/해당 팀 外)</span></div>
                                                    <div class="no_line">+ 2,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>숏폼 영상(릴스/숏츠/틱톡 등) <span class="fz14 gray">(해당 팀)</span></div>
                                                    <div class="no_line">+ 2,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>숏폼 영상(릴스/숏츠/틱톡 등) <span class="fz14 gray">(해당 팀 外)</span></div>
                                                    <div class="no_line">+ 1,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>*상위 노출<span class="fz14 gray">(*키워드 챌린지 外)</span></div>
                                                    <div class="no_line">+ 5,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>인스타그램 *바이오 內<br /> 이벤트/판매처 링크 적용 <span class="fz14 gray">(일부 미션 해당)</span></div>
                                                    <div class="no_line">+ 1,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>인스타그램 스토리 업로드 <span class="fz14 gray">(1개 계정 / 20시간 이상 노출 인증 필수)</span></div>
                                                    <div class="no_line">+ 500</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange no_line">키워드 챌린지</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>*상위 노출 <span class="fz14 gray">(~ 5위 / 각 키워드 별)</span></div>
                                                    <div class="no_line">+ 1,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>참여 <span class="fz14 gray">(최대 3개 제한 / 각 키워드 별)</span></div>
                                                    <div class="no_line">+ 1,000</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange no_line">기타 SNS</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>필수 채널 外 <span class="fz14 gray">(최대 3개 제한 / 각 미션 별)</span></div>
                                                    <div class="no_line">+ 1,000</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange no_line">소비자 조사</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>설문조사 <span class="fz14 gray">(각 미션 별)</span></div>
                                                    <div class="no_line">+ 500 ~ 1,000</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="grid_custom g2">
                                    <div class="division">활용</div>
                                    <div class="tb_inner">
                                        <div class="grid_custom g2_2 padd_0">
                                            <div class="division color_orange no_line">콘텐츠<br /> 2차 활용</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>단순 활용 <span class="fz14 gray">(리그램, 이미지 캡쳐 등)</span></div>
                                                    <div class="no_line">+ 3,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>원본 활용 <span class="fz14 gray">(콘텐츠 원본, 신규 촬영 등)</span></div>
                                                    <div class="no_line">5만원 상당<br /> 애경 제품 제공</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="point_info">
                            <p><span class="number">2</span>포인트 차감</p>
                            <ul>
                                <li>
                                    서포터즈 신청 후 콘텐츠 미작성 시 포인트 차감 및 이후 서포터즈 선정에서 제외됩니다.
                                </li>
                            </ul>
                        </div>
                        <div class="table_container t_c club_tb">
                            <div class="table_head grid_custom">
                                <div>활동 구분</div>
                                <div>활동 내용</div>
                                <div>포인트</div>
                            </div>
                            <ul class="table_body">
                                <li class="grid_custom g2">
                                    <div class="division">서포터즈</div>
                                    <div class="tb_inner">
                                        <div class="grid_custom g2_2 padd_1b">
                                            <div class="division color_orange no_line">콘텐츠 미작성</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>블로그</div>
                                                    <div class="no_line">- 5,000</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>숏폼/인스타그램</div>
                                                    <div class="no_line">- 4,000</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange no_line">콘텐츠 미준수</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>작성 기간</div>
                                                    <div class="no_line">- 2,500</div>
                                                </div>
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>가이드라인</div>
                                                    <div class="no_line">- 2,500</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid_custom g2_2 padd_1">
                                            <div class="division color_orange no_line">제품 배송비</div>
                                            <div class="tb_inner no_line">
                                                <div class="grid_custom g2_3 ti no_line">
                                                    <div>착불 지급 or 포인트 차감 中 선택 가능 <span class="fz14 gray">(베이직 미션에 한 함)</span></div>
                                                    <div class="no_line">- 1,000</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="point_left">
                            <div class="point_info">
                                <p><span class="number">3</span>포인트 적립 기준</p>
                            </div>
                        </div>                                             
                        <!-- <div class="point_right">
                            <div class="point_notice">
                                <div class="pn_top">
                                    Beauty, Life Club 활동 포인트 적립 기준 안내
                                </div>
                                <ul class="pn_content">
                                    <li>                                        
                                        블로그, 인스타그램, 숏폼(릴스/틱톡/쇼츠/네이버모먼트) 각 매체별로 컨텐츠 1건씩만 인정됩니다.
                                        <p class="pn_des">
                                            ex. A회원이 본인 소유 블로그a, 블로그b에 컨텐츠 작성 → 블로그 1건만 적립<br />
                                            B회원이 본인 소유 블로그a, 인스타그램a, b에 컨텐츠 작성 → 블로그 1건, 인스타 1건 적립<br />
                                            C회원이 본인 소유 블로그a, 인스타그램a(이미지 1건, 릴스 1건) 컨텐츠 작성
                                            → 블로그 1건, 인스타 1건, 릴스 1건 적립 (단, 이 경우 숏폼팀 여부에 따라 적립 포인트가 상이함)
                                        </p>
                                    </li>
                                    <li>
                                        키워드챌린지 포인트 적립은 하기 기준에 따라 진행됩니다.
                                        <p class="pn_des">
                                            - 키워드챌린지 참여 포인트: 홈페이지에 후기 등록된 URL 한정<br />
                                            - 키워드챌린지 상위노출 포인트: 카카오톡으로 전달된 이미지 캡쳐 건에 한함
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div> -->
                        <div class="point_right">
                            <div class="point_notice">
                                <ul class="pn_content">
                                    <li>                                        
                                        콘텐츠 별 적립 기준<br /> 
                                        <span class="fz15">숏폼, 인스타그램, 블로그 각 매체별로 1건 씩만 인정됩니다.</span>
                                        <p class="pn_des">
                                            ex. A회원이 본인 소유 블로그a, 블로그b에 콘텐츠 작성 → 블로그 1건만 적립<br />
                                            B회원이 본인 소유 블로그a, 인스타그램a, b에 콘텐츠 작성 → 블로그 1건, 인스타 1건 적립<br />
                                            C회원이 본인 소유 블로그a, 인스타그램a, 릴스a 콘텐츠 작성<br />
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
                                    <li>
                                        인스타그램 바이오/스토리 포인트 적립 기준
                                        <p class="pn_des">
                                            - 인스타그램 바이오/스토리에 대한 포인트 적립은 일부 미션에 해당되며, 해당 여부는 가이드라인 내 상세 안내드릴 예정입니다.<br />
                                            - 미션을 수행한 화면을 캡처해 전송하는 인원에 한해 포인트 지급 (베이직 - 애경 공식 인스타그램 DM / 프리미어 - 카카오톡)
                                        </p>
                                    </li>
                                    <li>
                                        상위노출 포인트 지급 기준
                                        <p class="pn_des">
                                        - 가이드라인 내 제공된 '상위노출 인정 키워드'로 블로그 탭 상위 10개/인스타 피드 9개 이내 노출된 경우에 한해 포인트 지급<br />
                                        - 콘텐츠 등록 마감 +3 영업일 오전 10시 기준으로 상위 노출된 콘텐츠만 인정 (콘텐츠 등록 마감일 이후 업로드된 콘텐츠 제외)<br />
                                        - 각 콘텐츠 기준 채널별 최대 1회 지급<br />
                                        ex. A회원이 본인 소유 블로그에서 a키워드, b키워드 상위 노출 > 블로그 1건 적립<br />
                                        B회원이 본인 소유 블로그에서 a키워드, 인스타그램에서 b키워드 상위 노출 > 블로그, 인스타그램 2건 적립
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?
//서포터즈 신청자 확인은 푸터X
include_once  PATH_INC_END.'tail2.php';
?>
