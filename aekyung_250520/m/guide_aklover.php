<? include_once "head.php";?> 
<link rel="stylesheet" type="text/css" href="/m/css/musign/guide_aklover.css" />
<div id="subpage" class="aklove_page use_aklover">
    <div class="sub_title">
        <div class="sub_wrap">
            <div>
                <h1 class="fz74 main_c fw500 ko">AK Lover 이용백서</h1>
                <p class="fz28 fw600 desc">AK Lover 홈페이지 이용방법 A to Z 까지 배워보세요!</p>
            </div>
            <div class="tab_wrap">
                <ul class="tab f_cs">
                    <li><a href="/m/guide_aklover.php" class="fz24 fw500 on">홈페이지 편</a></li>
                    <li class="rel">
                        <a class="fz24 fw500 tab_btn">서포터즈 편 <img src="/img/front/intro/arrow_white.webp" alt="화살표" class="black"/></a>
                        <ul class="tab_list">
                            <li><a href="/m/beauty_life_aklover.php" class="fz28 fw600">프리미어 서포터즈</a></li>
                            <li><a href="/m/basic_aklover.php" class="fz28 fw600">베이직 서포터즈</a></li>
                            <li><a href="/m/use_aklover.php" class="fz28 fw600">공정위 표시 및 위젯</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>        
    </div>
    <div class="sub_cont">
        <div class="sub_wrap">
            <div class="left">
                <div class="content_info">
                    <h3><span class="step">Step.1</span>회원가입하기</h3>
                    <p>
                        AK Lover 홈페이지에 가입하시면 다양한 활동과 혜택을 즐길 수 있습니다.
                    </p>
                </div>
            </div>
            <div class="right">
                <ul class="image_content grid_2">
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/guide_step1_1.png" alt="회원가입 버튼 클릭" />
                        </div>
                        <p class="con_tit"><span class="number">1</span>AK Lover 홈페이지 상단의 회원가입 버튼 클릭!</p>
                    </li>
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/guide_step1_2.png" alt="회원가입 완료" />
                        </div>
                        <p class="con_tit"><span class="number">2</span>각종 정보를 작성하면 회원가입 완료!</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="sub_cont">
        <div class="sub_wrap">
            <div class="left">
                <div class="content_info">
                    <h3><span class="step">Step.2</span>마이페이지 완성하기</h3>
                    <p>
                        나만의 프로필을 완성해보세요. 프로필 완성 시 추가 포인트가 제공됩니다.
                    </p>
                </div>
            </div>
            <div class="right">
                <ul class="image_content grid_2">
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/guide_step2_1.png" alt="프로필 사진 변경" />
                        </div>
                        <p class="con_tit"><span class="number">1</span>프로필 사진을 변경해 보세요.</p>
                        <p class="cont_des">‘마이페이지 > 나의 정보 변경‘을 통해 프로필 사진 변경이 가능합니다.</p>
                    </li>
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/guide_step2_2.png" alt="sns 기재" />
                        </div>
                        <p class="con_tit"><span class="number">2</span>활동하는 미디어(SNS)를 기재해 주세요.</p>
                        <p class="cont_des">
                            숏폼, 블로그, 인스타 등 활동하고 있는 나의 SNS 계정 연결 시 체험단 신청이 가능합니다.
                        </p>
                    </li>
                    <li>
                        <div class="con_image">
                            <img src="/img/front/intro/guide_step2_3.png" alt="선택 정보 입력" />
                        </div>
                        <p class="con_tit"><span class="number">3</span>선택 정보를 입력해 보세요.</p>
                        <p class="cont_des">
                            나만의 정보를 입력하여 프로필 완성 시 AK Lover 포인트가 추가 제공됩니다. (+30P)
                        </p>
                    </li>
                    <li class="profile">
                        <img src="/img/front/intro/plus_profile.webp" alt="프로필 완성하기 아이콘" />
                        <p class="con_tit">프로필을 완성하러 가볼까요?</p>
                        <div class="btn_moreview">
                            <? if($_SESSION['temp_code']=='' && !$_SESSION["global_code"]){?>   <!-- 비로그인 -->
                                <a href="/m/login.php">프로필 완성하러 가기</a>
                            <? }else{ ?>
                                <a href="/m/infoauth.php?board=infoauth">프로필 완성하러 가기</a>
                                <!-- <a href="/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=443487&hero_gisu=&select=hero_title&kewyword=&date-from=2024.08.29&date-to=2024-08.29">프로필 완성하러 가기</a> -->
                            <? } ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="sub_cont">
        <div class="sub_wrap">
            <div class="left">
                <div class="content_info">
                    <h3><span class="step">Step.3</span>홈페이지 둘러보기</h3>
                    <p>
                        서포터즈 활동 외에도 이벤트 및 커뮤니티 공간이 마련되어있습니다.<br />
                        다양한 AK Lover 홈페이지를 둘러보세요.
                    </p>
                </div>
            </div>
            <div class="right">
                <ul class="look_content">
                    <li>
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_1_1.webp" alt="이달의 이벤트" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/m/board_00.php?board=group_02_03">    
                                    이달의 이벤트<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="화살표"/></span>
                                </a>
                            </h3>
                            <p>
                                AK Lover라면 누구나 참여 가능한 간단한 이벤트가 매월 진행됩니다.<br />
                                AK Lover 공식 인스타그램을 팔로우하시면 이벤트 소식을<br /> 더욱 빠르게 받아보실 수 있습니다.
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_2.jpg" alt="포인트 축제" class="border_round" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/m/order.php?board=group_04_21">    
                                    포인트 페스티벌<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="화살표" /></span>
                                </a>
                            </h3>
                            <p>
                                AK Lover 활동으로 적립된 포인트로 애경의 다양한 인기 제품을<br/>
                                직접 선택 후 교환할 수 있는 이벤트입니다.<br />
                                연 2회(상반기/하반기) 진행되며, 페스티벌 일정은 깜짝 공개됩니다.<br />
                                <span class="fz20 gray">(상반기 : 이달의 AK Lover 및 프리미어 대상 / 하반기 : 전체 회원 대상)</span>
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_4.webp" alt="출석체크" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/m/check.php?board=group_04_04">    
                                    출석체크<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="화살표" /></span>
                                </a>
                            </h3>
                            <p>
                                AK Lover 홈페이지 출석 체크 시 포인트가 제공되며,<br />
                                월 개근을 한 Lover에게는 더 큰 혜택이 제공됩니다.
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_3.webp" alt="미디어" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/m/media.php">
                                    미디어 소식<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="화살표" /></span>
                                </a>
                            </h3>
                            <p>
                                AK Lover의 SNS 소식 및 애경과 브랜드의 다양한 소식을<br />
                                한 눈에 모아볼 수 있는 공간입니다.
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="lc_image">
                            <img src="/img/front/intro/browse_page_5.webp" alt="러버톡" />
                        </div>
                        <div class="lc_des">
                            <h3>
                                <a href="/m/today.php?board=group_02_02">    
                                    Lover 톡<span class="arrow"><img src="/img/front/intro/diagonal_arrow.webp" alt="화살표" /></span>
                                </a>
                            </h3>
                            <p>
                                여러분들의 소중한 아이디어와 체험단 및 일상 이야기를<br />
                                공유하는 소통 공간입니다.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?include_once "tail.php";?>