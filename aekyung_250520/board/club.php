<link rel="stylesheet" href="../css/front/club.css">
<link rel="stylesheet" href="../css/front/animation.css">
<script type="text/javascript" src="/js/musign/animation.js"></script>
<?
$benefit_str = "Benefit";

?>
<div class="beauty_container">
    <div class="beauty_top">
        <div class="bg">
            <? if ($_GET ['board'] == 'group_04_06') { ?>
                <img src="/img/front/supporters/beautyclub_bg.webp" alt="뷰티클럽 배경" />
            <? } else if ($_GET ['board'] == 'group_04_28') { ?>
                <img src="/img/front/supporters/lifeclub_bg.webp" alt="라이프클럽 배경" />
            <? } ?>
        </div>
        <div class="txt_box t_c">
            <p>
                <?php if($_GET ['board'] === 'group_04_06'){?> 
                    다양한 혜택이 쏟아지는 ‘뷰티 클럽’에 도전하세요!
                <? } else if($_GET ['board'] == 'group_04_28') { ?>
                    다양한 혜택이 쏟아지는 ‘프리미어 라이프 클럽’에 도전하세요!
                <? } ?>       
            </p>
            <p class="en">
                <?php if($_GET ['board'] === 'group_04_06'){?> 
                    Beauty
                <? } else if($_GET ['board'] == 'group_04_28') { ?>
                    Life
                <? } ?>   
                Club
            </p>
        </div>
        <div class="obj_box">
            <? if ($_GET ['board'] == 'group_04_06') { ?>
                <div class="box t_c"><img src="/img/front/supporters/box_pink.webp" alt="핑트 박스" /></div>
                <div class="box_cap t_c"><img src="/img/front/supporters/box_cap_pink.webp" alt="핑트 박스 캡" /></div>
                <div class="products rel">
                    <div class="item item_01">
                        <img src="/img/front/supporters/pink_obj_1.webp" alt="오브젝트" />
                    </div>
                    <div class="item item_02">
                        <img src="/img/front/supporters/pink_obj_2.webp" alt="오브젝트" />
                    </div>
                    <div class="item item_03">
                        <img src="/img/front/supporters/pink_obj_3.webp" alt="오브젝트" />
                    </div>
                    <div class="item item_04">
                        <img src="/img/front/supporters/pink_obj_4.webp" alt="오브젝트" />
                    </div>
                    <div class="item item_05">
                        <img src="/img/front/supporters/pink_obj_5.webp" alt="오브젝트" />
                    </div>
                    <div class="item item_06">
                        <img src="/img/front/supporters/pink_obj_6.webp" alt="오브젝트" />
                    </div>
                    <div class="item item_07">
                        <img src="/img/front/supporters/pink_obj_7.webp" alt="wow" />
                    </div>
                </div>
            <? } else if ($_GET ['board'] == 'group_04_28') { ?>
                <div class="box t_c"><img src="/img/front/supporters/box_blue.webp" alt="블루 박스" /></div>
                <div class="box_cap t_c"><img src="/img/front/supporters/box_cap_blue.webp" alt="블루 박스 캡" /></div>
                <div class="products rel">
                    <div class="item item_01">
                        <img src="/img/front/supporters/blue_obj_1.webp" alt="오브젝트" />
                    </div>
                    <div class="item item_02">
                        <img src="/img/front/supporters/blue_obj_2.webp" alt="오브젝트" />
                    </div>
                    <div class="item item_03">
                        <img src="/img/front/supporters/blue_obj_3.webp" alt="오브젝트" />
                    </div>
                    <div class="item item_04">
                        <img src="/img/front/supporters/blue_obj_4.webp" alt="오브젝트" />
                    </div>
                    <div class="item item_05">
                        <img src="/img/front/supporters/blue_obj_5.webp" alt="오브젝트" />
                    </div>
                    <div class="item item_06">
                        <img src="/img/front/supporters/blue_obj_6.webp" alt="오브젝트" />
                    </div>
                    <div class="item item_07">
                        <img src="/img/front/supporters/blue_obj_7.webp" alt="wow" />
                    </div>
                </div>
            <? } ?>
        </div>
    </div>
    <div class="beaauty_bottom">
        <div class="bottom_inner">
            <ul class="info flex img-ani bottom-top">
                <li class="f_cs bold">
                    <span class="info_txt <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">모집 대상</span><?php if($_GET ['board'] === 'group_04_06'){?> 
                        뷰티제품에 관심있는 SNS 운영자 (숏폼/블로그/인스타그램)
                    <? } else if($_GET ['board'] == 'group_04_28') { ?>
                        생활용품에 관심있는 SNS 운영자 (숏폼/블로그/인스타그램)
                    <? } ?>
                </li>
                <li class="f_cs bold">
                    <span class="info_txt <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">지원 방법</span>별도 모집 기간에 공고 (연 2회 모집)
                </li>
                <li class="f_cs bold">
                    <span class="info_txt <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">주요 활동</span>애경에서 새롭게 출시되는 신제품을 직접 체험/사용 후 컨텐츠 작성,<br/> 신제품 공동 개발, 제품 품평회 등
                </li>
            </ul>
            <ul class="gift_list">
                <li class="img-ani bottom-top">
                    <div class="count">
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?></p>
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">1</p>
                    </div>
                    <div class="description">
                        <p class="bold">최종 우수자 시상(30만원)</p>
                        <p>활동 기간 종료 후, 최종 우수자를 선정하여 최대 30만원 혜택을 제공합니다. <span class="additional_des">*혜택은 1등~3등에게 차등 제공하며, 숏폼팀은 별도 활동비를 지급합니다.</span></p>
                    </div>
                    <div class="gift_icon">
                        <img src="/img/front/supporters/gift_icon_1.webp" alt="혜택1 아이콘" />
                    </div>
                </li>
                <li class="img-ani bottom-top">
                    <div class="count">
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?></p>
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">2</p>
                    </div>
                    <div class="description">
                        <p class="bold">월 우수자 선정(최대 10만원)</p>
                        <p>매월 우수한 컨텐츠를 작성해주신 ‘이달의 AK Lover‘를 선정하여 최대 10만원 상당의 상품권을 드립니다. <span class="additional_des">(최대 30명)</span></p>
                    </div>
                    <div class="gift_icon">
                        <img src="/img/front/supporters/gift_icon_2.webp" alt="혜택2 아이콘" />
                    </div>
                </li>
                <li class="img-ani bottom-top">
                    <div class="count">
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?></p>
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">3</p>
                    </div>
                    <div class="description">
                        <p class="bold">선정자 전원 웰컴박스 증정 (10만원 상당)</p>
                        <p>
                        <?php if($_GET ['board'] === 'group_04_06'){?> 
                            뷰티 클럽에
                        <? } else if($_GET ['board'] == 'group_04_28') { ?>
                            프리미어 라이프 클럽에
                        <? } ?>
                        선정된 모든 분들을 환영하는 마음을 담아<br /> 10만원 상당의 애경 제품을 제공합니다.  <span class="additional_des">(1회)</span></p>
                    </div>
                    <div class="gift_icon">
                        <img src="/img/front/supporters/gift_icon_3.webp" alt="혜택3 아이콘" />
                    </div>
                </li>
                <li class="img-ani bottom-top">
                    <div class="count">
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?></p>
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">4</p>
                    </div>
                    <div class="description">
                        <p class="bold">수료자 전원 땡큐 박스 증정 및 수료증 제공 (10만원 상당)</p>
                        <p>
                        <?php if($_GET ['board'] === 'group_04_06'){?> 
                            뷰티 클럽의
                        <? } else if($_GET ['board'] == 'group_04_28') { ?>
                            프리미어 라이프 클럽의
                        <? } ?> 
                        필수 활동 조건을 충족한 분들에게<br /> 감사의 마음을 담아 10만원 상당의 애경 제품과 수료증을 제공합니다. <span class="additional_des">(1회)</span></p>
                    </div>
                    <div class="gift_icon">
                        <img src="/img/front/supporters/gift_icon_4.webp" alt="혜택4 아이콘" />
                    </div>
                </li>
                <li class="img-ani bottom-top">
                    <div class="count">
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?></p>
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">5</p>
                    </div>
                    <div class="description">
                        <p class="bold">포인트 페스티벌 참여 기회 제공(연 2회)</p>
                        <p>다양한 활동으로 적립된 포인트로 애경의 인기 제품을<br /> 직접 선택 후 교환할 수 있는 이벤트입니다.<br />
                        <span class="additional_des">(상반기 : 이달의 AK Lover 및 프리미어 대상 / 하반기 : 전체 회원 대상)</span>
                        </p>
                    </div>
                    <div class="gift_icon">
                        <img src="/img/front/supporters/gift_icon_5.webp" alt="혜택5 아이콘" />
                    </div>
                </li>
                <li class="img-ani bottom-top">
                    <div class="count">
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?></p>
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">6</p>
                    </div>
                    <div class="description">
                        <p class="bold">애경 제품 제공 (3만원 상당)</p>
                        <p>리뷰 콘텐츠 작성을 위하여 각 콘텐츠 별 3만원 상당의 애경 신제품을 제공합니다.<br />
                        <span class="additional_des">(활동 기간 내 평균 20회 이상)</span>
                        </p>
                    </div>
                    <div class="gift_icon">
                        <img src="/img/front/supporters/gift_icon_6.webp" alt="혜택5 아이콘" />
                    </div>
                </li>
                <li class="img-ani bottom-top">
                    <div class="count">
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>"><?=($benefit_str)?></p>
                        <p class="en t_c <?php if($_GET ['board'] === 'group_04_28'){?> blue <? } ?>">7</p>
                    </div>
                    <div class="description">
                        <p class="bold">AK Lover 포인트 제공 및 활용</p>
                        <p>리뷰 콘텐츠 작성 시마다 AK Lover 포인트를 제공하며,<br />
                        키워드 챌린지 등 우수 콘텐츠로 선정될 시 별도 추가 포인트를 드립니다.<br />
                        <span class="additional_des">(적립 포인트는 제품 배송비(약 3,400원)로 대체 및 포인트 페스티벌 시 사용 가능)</span>
                        </p>
                    </div>
                    <div class="gift_icon">
                        <img src="/img/front/supporters/gift_icon_7.webp" alt="혜택5 아이콘" />
                    </div>
                </li>
            </ul>
            <div class="notice f_c">
                ※ 활동 혜택은 추후 변동될 수 있습니다.
            </div>
            <div class="more_view f_c">
                <div class="btn f_cs">
                    <a href="/">
                        <?php if($_GET ['board'] === 'group_04_06'){?> 
                            뷰티클럽
                        <? } else if($_GET ['board'] == 'group_04_28') { ?>
                            라이프클럽
                        <? } ?>    
                        알아보기 <img src="/img/front/member/arr.webp" alt="알아보기">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="club_cont">
        <?php if($_GET['board'] === 'group_04_06') {
            $club_name = '뷰티';
        }else if($_GET['board'] === 'group_04_28') {
            $club_name = '라이프';
        } ?>
        <p class="tit fz32 fw600"><?=$club_name?> 클럽 활동 내역</p>
        <p class="sub_tit fz18"><?=$club_name?> 클럽에 도전하여 즐거운 체험을 함께해요.</p>
        <? if(!strcmp($total_data,"0")){?>
            <div id="blankList">검색결과가 없습니다.</div>
        <? } else { ?>
        <div class="club_list blog_box2">
            <ul class="guerrilla_event grid_3">
                <?
                $list_sql = "SELECT * FROM mission WHERE hero_kind != '구매체험' AND hero_table='".$_GET['board']."' ".$search;
                if($_SESSION['temp_level'] < 9999 ){
                    $list_sql .=" AND hero_use = 1 AND ((hero_today_05_01 is null or hero_today_05_01='') or (hero_today_05_01 is not null and hero_today_05_01 != '' AND '".date("Y-m-d H:i")."' >= hero_today_05_01)) ";
                    $list_sql .=" AND ((hero_today_05_02 is null or hero_today_05_02 ='') OR (hero_today_05_02 is not null and hero_today_05_02 != '' AND '".date("Y-m-d H:i")."' <= hero_today_05_02)) ";
                }

                //20250409 musign 윤동희 수정 체험단 신청 시작일 기준으로 정렬
                $list_sql .=" ORDER BY hero_priority DESC, hero_today_01_01 desc ";
//                $list_sql .=" ORDER BY hero_priority DESC,
//								CASE WHEN (hero_today_01_01<='".date('Y-m-d 00:00:00')."' and hero_today_01_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_01_01 END DESC,
//								CASE WHEN (hero_today_02_01<='".date('Y-m-d 00:00:00')."' and hero_today_02_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_02_01 END DESC,
//								CASE WHEN (hero_today_03_01<='".date('Y-m-d 00:00:00')."' and hero_today_03_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_03_01 END DESC,
//								CASE WHEN (hero_today_04_01<='".date('Y-m-d 00:00:00')."' and hero_today_04_02>='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END DESC,
//								CASE WHEN (hero_today_04_02<='".date('Y-m-d 00:00:00')."') THEN hero_today_04_01 END desc ";

                if($_GET['board'] == "group_04_06" || $_GET['board'] == "group_04_27" || $_GET['board'] == "group_04_28") { //뷰티,유튜버,라이프
                    $list_sql .= " , hero_today_01_01 DESC ";
                } else {
                    $list_sql .= " , hero_idx DESC ";
                }
                $list_sql .= " LIMIT ".$start.",".$list_page;

                sql($list_sql, 'on');
                while($list = @mysql_fetch_assoc($out_sql)){
                    $img_parser_url = @parse_url($list['hero_img_new']);
                    $img_host = $img_parser_url['host'];

                    if(!strcmp($list['hero_img_new'],'')){
                        $view_img = IMAGE_END.'hero.jpg';
                    }else if(!strcmp($img_host,'')){
                        $view_img = IMAGE_END.'hero.jpg';
                    }else if(!strcmp($img_host,$HTTP_SERVER_VARS['HTTP_HOST'])){
                        $view_img = $list['hero_img_new'];
                    }else if(!strcmp(eregi('naver',$img_host),'1')){
                        $view_img = IMAGE_END.'hero.jpg';
                    }else{
                        $view_img = $list['hero_img_new'];
                    }

                    if($list["hero_thumb"]) $view_img = $list['hero_thumb'];

                    $check_day = date( "Y-m-d", time());
                    $today_01_01 = date( "Y-m-d", strtotime($list['hero_today_01_01']));
                    $today_01_02 = date( "Y-m-d", strtotime($list['hero_today_01_02']));
                    $today_02_01 = date( "Y-m-d", strtotime($list['hero_today_02_01']));
                    $today_02_02 = date( "Y-m-d", strtotime($list['hero_today_02_02']));
                    $today_03_01 = date( "Y-m-d", strtotime($list['hero_today_03_01']));
                    $today_03_02 = date( "Y-m-d", strtotime($list['hero_today_03_02']));
                    $today_04_01 = date( "Y-m-d", strtotime($list['hero_today_04_01']));
                    $today_04_02 = date( "Y-m-d", strtotime($list['hero_today_04_02']));
                    $today_05_01 = date( "Y-m-d", strtotime($list['hero_today_05_01']));
                    $today_05_02 = date( "Y-m-d", strtotime($list['hero_today_05_02']));

                    $status_txt = "";
                    $status = "";
                    $period_day = "";
                    $ribbon_text = "";
                    $type_check = "";

                    $mission_board_type = false;
                    if($list["hero_type"] == "2" || $list["hero_type"] == "10") {
                        $mission_board_type = true;
                    }

                    if($_GET ['board'] == 'group_04_05') {
                        if($list["hero_question_url_check"] == "1") {
                            $type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='네이버 블로그'>";
                        } else if($list["hero_question_url_check"] == "2") {
                            $type_check = "<img src='/img/front/main/ic_insta.webp' alt='인스타그램'>";
                        } else if($list["hero_question_url_check"] == "3") {
                            $type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='블로그'><img src='/img/front/main/ic_insta.webp' alt='인스타그램'>";
                        } else if($list["hero_question_url_check"] == "4") {
                            $type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='블로그'><img src='/img/front/main/ic_insta.webp' alt='인스타그램'>";
                        } else if($list["hero_question_url_check"] == "5") {
                            $type_check =  "<img src='/img/front/main/ic_youtube.webp' alt='유튜브'>";
                        } else if($list["hero_question_url_check"] == "6") {
                            $type_check = "<img src='/img/front/main/ic_naver_blog.webp' alt='블로그'><img src='/img/front/main/ic_insta.webp' alt='인스타그램'><img src='/img/front/main/ic_youtube.webp' alt='유튜브'>";
                        } else {
                            // if($list["hero_type"] == "1") {
                            // 	$type_check = "이벤트";
                            // } else if($list["hero_type"] == "2") {
                            // 	$type_check = "소문내기";
                            // } else if($list["hero_type"] == "3") {
                            // 	$type_check = "설문참여";
                            // } else if($list["hero_type"] == "5") {
                            // 	$type_check = "품평참여";
                            // } else if($list["hero_type"] == "8") {
                            // 	$type_check = "포인트체험";
                            // } else {
                            // 	$type_check = "체험단";
                            // }
                        }
                    }

                    if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){

                        $ribbon_text = $list['hero_kind'];
                        if($list['hero_type'] == "4" || $list['hero_type'] == "7") {
                            $ribbon_text = $list['hero_kind'];
                        }

                        if($list['hero_type'] == "7" || $list['hero_type'] == "9") { //자율미션, 정기미션(선택)
                            if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                $status_txt = "체험단 신청";
                                $status = "1";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                            }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                $status_txt = "선정자 발표";
                                $status = "2";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
                                $period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                            }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                $status_txt = "후기등록";
                                $status = "3";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
                                $period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                            }else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
                                $status_txt = "우수후기발표";
                                $status = "4";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                            }else if($today_04_02<$check_day){
                                $status_txt = "체험단 마감";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                // $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                $two_day = "";
                            }else if($today_05_01>$check_day){
                                $status_txt = "체험단 노출예정";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                            }
                        } else {
                            if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                $status_txt = "후기등록";
                                $status = "3";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                            }else if($today_01_02<$check_day){
                                $status_txt = "체험단 마감";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                // $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                $two_day = "";
                            }else if($today_05_01>$check_day){
                                $status_txt = "체험단 노출예정";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                            }
                        }
                    } else {
                        /* 2021-03-25 타입 설문조사, 제품풍평만 리본 노출 요청있었는데 검색 때문에 삭제
                        if($list['hero_type'] == "3" ||  $list['hero_type'] == "5") {
                            $ribbon_text = "<div class='mission_ribbon bg_hero_type_".$list['hero_type']."'>".$list['hero_kind']."</div>";
                        }
                        */
                        $ribbon_text = $list['hero_kind'];

                        if($mission_board_type) {
                            $txt1 = "";
                            $txt2 = "";
                            if($list["hero_type"] == "2") {
                                $txt1 = "소문내기 ";
                                $txt2 = "소문내기 신청";
                            } else if($list["hero_type"] == "10") {
                                $txt1 = "체험단";
                                $txt2 = "체험단 참여";
                            }

                            if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                $status_txt = $txt2;
                                $status = "1";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                            }else if(($today_02_02 == $today_03_02) and ($today_02_02 == $today_04_02) and ($today_03_02 == $today_04_02) and ($today_02_02 >= $check_day)){
                                $status_txt = "당첨자 발표";
                                $status = "2";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                            }else if(($today_04_02 < $check_day)){
                                $status_txt = $txt1." 마감";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                            }
                        } else {
                            if(($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                //20180831 임시로 추가
                                if($list['hero_idx'] == "1288") {
                                    $status_txt = "이벤트 신청";
                                } else {
                                    $status_txt = "체험단 신청";
                                }
                                $status = "1";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_01_02']));
                                $period_day =  intval((strtotime($list['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                            }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                $status_txt = "선정자 발표";
                                $status = "2";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_02_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_02_02']));
                                $period_day =  intval((strtotime($list['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                            }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                $status_txt = "후기등록";
                                $status = "3";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_03_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_03_02']));
                                $period_day =  intval((strtotime($list['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                            }else if(($today_04_01<=$check_day) and ($today_04_02>=$check_day)){
                                $status_txt = "우수후기발표";
                                $status = "4";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_04_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                $period_day =  intval((strtotime($list['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                            }else if($today_04_02<$check_day){
                                $status_txt = "체험단 마감";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                // $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                                $two_day = "";
                            }else if($today_05_01>$check_day){
                                $status_txt = "체험단 노출예정";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($list['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($list['hero_today_04_02']));
                            }
                        }
                    }
                    ?>
                    <li class="event_list <? if($period_day || ($period_day == 0 && strlen($period_day) > 0)) {?>cursor_cont<? } ?>">
                        <a href="<?=PATH_HOME?>?board=<?=$_GET['board']?>&page=<?=$page?>&view=view&idx=<?=$list['hero_idx']?>" class="rel">
                            <div class="event_img rel">
                                <div class="status_wrap">
                                    <span class="status"><?=$status_txt?></span>
                                    <span class="status status_txt"><?=$ribbon_text?></span>
                                </div>
                                <img class="mission_image" onerror="this.src='<?=IMAGE_END?>hero.jpg'" src="<?=$view_img?>" alt="">
                                <? if($list["hero_use"] == 0) { ?>
                                    <div class="mission_com fz17 bold">비공개</div>
                                <? } ?>
                                <? if($status == 5) {?>
                                    <div class="mission_com fz17 bold">종료된 체험단</div>
                                <? } ?>
                                <? if(strlen($type_check) > 0) {?>
                                    <span class="type_check"><?=$type_check?></span>
                                <? } ?>
                            </div>
                            <div class="title fz18 fw600 ellipsis_100"><?=cut($list['hero_title'],"70");?></div>
                            <div class="day">
                                <? if($period_day) {?>
                                    <span class="period fz14">
											D-<?=$period_day?>
										</span>
                                <? } else if($period_day == 0 && strlen($period_day) > 0) { ?>
                                    <span class="period fz14">
											D-day
										</span>
                                <? } ?>
                                <? if($status == 5) {?>
                                    <span class="period fz14">
											END
										</span>
                                <? } ?>

                                <p class="date_02 fz15 fw600 op05">
                                    <?=$one_day?>
                                    <span>-</span>
                                    <?=$two_day?>
                                </p>

                                <!-- <span class="date_02 fz15 fw600 op05"><?=$one_day?>-<?=$two_day?></span> -->
                                <!-- <div class=""><?=mb_substr($list['hero_title_02'], 0, 18, 'EUC-KR');?></div> -->
                            </div>
                        </a>
                    </li>
                <? } ?>
            </ul>
        </div>
        <? } ?>
        <div class="paging"><?=page($total_data,$list_page,$page_per_list,$_GET[page],$next_path);?></div>
    </div>
</div>


<script>
    // Event - 특정 위치에 도착했을 때 상자 애니메이션
    const conHeight = document.querySelector(".beauty_container").offsetTop;
    const txt1 = document.querySelector(".txt_box > p:first-child");
    const txt2 = document.querySelector(".txt_box > p:last-child");

    function scrollEvent(){
        if(window.scrollY > conHeight){
            document.querySelector(".box_cap").classList.add("up");

            setTimeout(() => {
                txt1.classList.add("appear");
                txt2.classList.add("appear2");
            }, 1200);

            window.removeEventListener("scroll", scrollEvent);
        }
    }

    window.addEventListener("scroll", scrollEvent);

</script>