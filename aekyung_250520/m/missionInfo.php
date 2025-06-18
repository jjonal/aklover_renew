<?
	$title_02 = str_replace("\r\n","<br/>",$out_row['hero_title_02']);
	if($out_row['hero_thumb'])	$img_new = $out_row['hero_thumb'];
	else							$img_new = $out_row['hero_img_new'];
?>
    
    <script src="https://t1.kakaocdn.net/kakao_js_sdk/2.7.2/kakao.min.js" integrity="sha384-TiCUE00h649CAMonG018J2ujOgDKW/kVWlChEuu4jK2vxfAAD0eZxzCKakxg55G4" crossorigin="anonymous"></script>
	<script>
		 // 카카오 aklover JavaScript 키
		Kakao.init('86b5b004678408418bea38987129ee5a');
	</script>

    <div class="content_img_title">
        <div class="content_img rel">
            <img src="<?=$img_new?>"/>
            <? if(strlen($type_check) > 0) {?>
                <span class="type_check"><?=$type_check?></span>
            <? } ?>
        </div>
    </div>
    <div class="content_title">
        <div class="rel content_in">
            <div class="snsbox abs">
                <div class="rel">
                    <div class="btn_share"><img src="/img/front/board/share.webp" alt="aklover-share"></div>
                    <div class="share_inner abs">
                        <div class="rel">
                            <div class="btn_close abs"><img src="/img/front/board/share_x.webp" alt="aklover-close"></div>
                            <p class="title fz18 fw600">공유하기</p>
                            <ul>
                                <li>
                                    <a id="kakaotalk-sharing-btn" href="javascript:;">
                                        <img src="/img/front/board/share_kakao.webp" alt="카카오 공유하기">
                                    </a>
                                    <p class="fz14">카카오톡</p>
                                </li>
                                <li id="copyLinkBtn">
                                    <img src="/img/front/board/share_link.webp" alt="링크복사">
                                    <p class="fz14">링크복사</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="title_wrap">
                <div class="statusbox f_cs">
                    <?
                    // /board/thumbnail_02/list.php 274-415L 참고
                    // 나머지 변수들은 view에서 선언
                    $today_05_01 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_05_01'] ) );
                    $today_05_02 = date ( "Y-m-d", strtotime ( $out_row ['hero_today_05_02'] ) );

                    if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28'){

                        $ribbon_text = $out_row['hero_kind'];
                        if($out_row['hero_type'] == "4" || $out_row['hero_type'] == "7") {
                            $ribbon_text = $out_row['hero_kind'];
                        }

                        if($out_row['hero_type'] == "7" || $out_row['hero_type'] == "9") { //자율미션, 정기미션(선택)
                            if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                $status_txt = "체험단 신청";
                                $status = "1";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_01_02']));
                                $period_day =  intval((strtotime($out_row['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                            }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                $status_txt = "선정자 발표";
                                $status = "2";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_02_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_02_02']));
                                $period_day =  intval((strtotime($out_row['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                            }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                $status_txt = "후기등록";
                                $status = "3";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_03_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_03_02']));
                                $period_day =  intval((strtotime($out_row['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                            }else if( ($today_04_01<=$check_day) and ($today_04_02>=$check_day) ){
                                $status_txt = "우수후기발표";
                                $status = "4";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_04_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_04_02']));
                                $period_day =  intval((strtotime($out_row['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                            }else if($today_04_02<$check_day){
                                $status_txt = "체험단 마감";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_04_02']));
                            }else if($today_05_01>$check_day){
                                $status_txt = "체험단 노출예정";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_04_02']));
                            }
                        } else {
                            if( ($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                $status_txt = "후기등록";
                                $status = "3";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_01_02']));
                                $period_day =  intval((strtotime($out_row['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                            }else if($today_01_02<$check_day){
                                $status_txt = "체험단 마감";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_01_02']));
                            }else if($today_05_01>$check_day){
                                $status_txt = "체험단 노출예정";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_01_02']));
                            }
                        }
                    } else {
                        $ribbon_text = $out_row['hero_kind'];

                        if($mission_board_type) {
                            $txt1 = "";
                            $txt2 = "";
                            if($out_row["hero_type"] == "2") {
                                $txt1 = "소문내기 ";
                                $txt2 = "소문내기 신청";
                            } else if($out_row["hero_type"] == "10") {
                                $txt1 = "체험단";
                                $txt2 = "체험단 참여";
                            }

                            if(($today_01_01<=$check_day) and ($today_01_02>=$check_day)){
                                $status_txt = $txt2;
                                $status = "1";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_01_02']));
                                $period_day =  intval((strtotime($out_row['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                            }else if(($today_02_02 == $today_03_02) and ($today_02_02 == $today_04_02) and ($today_03_02 == $today_04_02) and ($today_02_02 >= $check_day)){
                                $status_txt = "당첨자 발표";
                                $status = "2";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_02_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_04_02']));
                                $period_day =  intval((strtotime($out_row['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                            }else if(($today_04_02 < $check_day)){
                                $status_txt = $txt1." 마감";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_04_02']));
                            }
                        } else {
                            if(($today_01_01<=$check_day) and ($today_01_02>=$check_day) ){
                                if($out_row['hero_idx'] == "1288") {
                                    $status_txt = "이벤트 신청";
                                } else {
                                    $status_txt = "체험단 신청";
                                }
                                $status = "1";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_01_02']));
                                $period_day =  intval((strtotime($out_row['hero_today_01_02'])-strtotime(date("Ymd")))/86400);
                            }else if( ($today_02_01<=$check_day) and ($today_02_02>=$check_day) ){
                                $status_txt = "선정자 발표";
                                $status = "2";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_02_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_02_02']));
                                $period_day =  intval((strtotime($out_row['hero_today_02_02'])-strtotime(date("Ymd")))/86400);
                            }else if( ($today_03_01<=$check_day) and ($today_03_02>=$check_day) ){
                                $status_txt = "후기등록";
                                $status = "3";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_03_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_03_02']));
                                $period_day =  intval((strtotime($out_row['hero_today_03_02'])-strtotime(date("Ymd")))/86400);
                            }else if(($today_04_01<=$check_day) and ($today_04_02>=$check_day)){
                                $status_txt = "우수후기발표";
                                $status = "4";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_04_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_04_02']));
                                $period_day =  intval((strtotime($out_row['hero_today_04_02'])-strtotime(date("Ymd")))/86400);
                            }else if($today_04_02<$check_day){
                                $status_txt = "체험단 마감";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_04_02']));
                            }else if($today_05_01>$check_day){
                                $status_txt = "체험단 노출예정";
                                $status = "5";
                                $one_day = date( "Y.m.d", strtotime($out_row['hero_today_01_01']));
                                $two_day = date( "Y.m.d", strtotime($out_row['hero_today_04_02']));
                            }
                        }
                    }

                    ?>
                    <!-- <span class="status"><?=$status_txt?></span> -->
                    <span class="status status_txt"><?=$ribbon_text?></span>
                    <!--!!!!!!!! end !!!!!!!!  --> 
                </div>                
                <p class="top_title bold"><?=$out_row['hero_title']?></p>
                <p class="top_title2 fz28 fw500"><?=$title_02?></p>
            </div>  
            <div class="cont_info">
                <p class="fz36 bold">모집정보</p>
                <!-- 일반체험단 (s)-->
                <? if($_GET['board'] == 'group_04_05' && $mission_board_type == false){?> 
                    <table>
                        <tbody>
                            <tr>
                            <th><img src="/img/front/board/icon01.webp" alt="모집 정보">신청대상</th>
                                <td><?=$out_row['hero_target']?></td>
                            </tr>
                        <? if($out_row['hero_select_count']!=0){?>
                            <tr>
                                <th><img src="/img/front/board/icon02.webp" alt="모집 정보">선정인원</th>
                                <td><?=$out_row['hero_select_count']?> 명</td>
                            </tr>
                        <? }?>
                        <? if($out_row['hero_benefit']){ ?>
                            <tr>
                                <th><img src="/img/front/board/icon04.webp" alt="모집 정보">선정혜택</th>
                                <td><?=$out_row['hero_benefit']?></td>
                            </tr>
                        <? }?>
                        <? if($out_row['hero_benefit_02']){ ?>
                            <tr>
                                <th><img src="/img/front/board/icon05.webp" alt="모집 정보">우수자 혜택</th>
                                <td><?=$out_row['hero_benefit_02']?></td>
                            </tr>
                        <? }?>            
                            <tr>
                                <th><img src="/img/front/board/icon03.webp" alt="모집 정보">슈퍼패스<a href="" class="superpass_use use_info">사용안내<img src="/img/front/board/superpass.webp" alt="슈퍼패스 사용안내"></a></th>
                                <? if($out_row['hero_superpass']=='Y'){?>
                                <td><?=$out_row['superpass']?>명<span>(현재인원)</span> / <?=countSuperpass($out_row['hero_select_count'])?>명<span>(총인원)</span></td>
                                <? }else{?>
                                <td>사용 불가능</td>
                                <? }?>
                            </tr>
                        
                        </tbody>
                    </table>
                <? }?>
                <!-- 일반미션 (e) -->            
                <!-- 일반미션 중에 소문내기(s)-->
                <? if($_GET['board'] == 'group_04_05' && $mission_board_type) {
                    $txt_type_1 = "";
                    if($out_row["hero_type"] == "2") {
                        $txt_type_1 = "소문내기";
                    } else if($out_row["hero_type"] == "10") {
                        $txt_type_1 = "체험단";
                    }
                ?> 
                <table>
                    <tbody>
                        <tr>
                            <th><img src="/img/front/board/icon01.webp" alt="모집 정보"> 참여대상</th>
                            <td><?=$out_row['hero_target']?></td>
                        </tr>
                    <? if($out_row['hero_select_count']!=0){?>
                        <tr>
                            <th><img src="/img/front/board/icon02.webp" alt="모집 정보"> 선정인원</th>
                            <td><?=$out_row['hero_select_count']?> 명</td>
                        </tr>
                    <? }?>
                    <? if($out_row['hero_benefit']){ ?>
                        <tr>
                            <th><img src="/img/front/board/icon04.webp" alt="모집 정보"> <?=$txt_type_1?> 혜택</th>
                            <td><?=$out_row['hero_benefit']?></td>
                        </tr>
                    <? }?>
                    <? if($out_row['hero_select_best']){ ?>
                        <tr>
                            <th><img src="/img/front/board/icon06.webp" alt="모집 정보"> 우수자 선정</th>
                            <td><?=$out_row['hero_select_best']?>명</td>
                        </tr>
                    <? }?>
                    <? if($out_row['hero_benefit_02']){ ?>
                        <tr>
                            <th><img src="/img/front/board/icon05.webp" alt="모집 정보"> 우수자 혜택</th>
                            <td><?=$out_row['hero_benefit_02']?></td>
                        </tr>
                    <? }?>
                    <tr>
                        <th><img src="/img/front/board/icon03.webp" alt="모집 정보">슈퍼패스</th>
                        <? if($out_row['hero_superpass']=='Y'){?>
                        <td><?=$out_row['superpass']?>명<span>(현재인원)</span> / <?=countSuperpass($out_row['hero_select_count'])?>명<span>(총인원)</span></td>
                        <? }else{?>
                        <td>사용 불가능</td>
                        <? }?>
                    </tr>
                    </tbody>
                </table>
                <? } ?>
                <!-- 일반미션 중에 소문내기 (e) -->
                <!-- 뷰티/유튜버/라이프 (s)-->
                <? if($_GET['board'] == 'group_04_06' || $_GET['board'] == 'group_04_27' || $_GET['board'] == 'group_04_28' ){?>
                    <? if($out_row['hero_type'] == "7") { ?> 
                    <table>
                        <tbody>
                            <tr>
                                <th><img src="/img/front/board/icon01.webp" alt="모집 정보"> 선정대상</th>
                                <td><?=$out_row['hero_target']?></td>
                            </tr>
                            <tr>
                                <th><img src="/img/front/board/icon02.webp" alt="모집 정보"> 선정인원</th>
                                <td><?=$out_row['hero_select_count']?></td>
                            </tr>
                            <tr>
                                <th><img src="/img/front/board/icon03.webp" alt="모집 정보"> 선정혜택</th>
                                <td><?=$out_row['hero_benefit']?></td>
                            </tr>
                        </tbody>
                    </table>
                    <? } else { ?>
                    <table>
                        <tbody>
                            <tr>
                                <th><img src="/img/front/board/icon01.webp" alt="모집 정보"> 미션대상</th>
                                <td><?=$out_row['hero_target']?></td>
                            </tr>
                        <? if($out_row['hero_benefit']){ ?>
                            <tr>
                                <th><img src="/img/front/board/icon02.webp" alt="모집 정보"> 미션제품</th>
                                <td><?=$out_row['hero_benefit']?></td>
                            </tr>
                        <? }?>
                        <? if($out_row['hero_benefit_02']){ ?>
                            <tr>
                                <th><img src="/img/front/board/icon03.webp" alt="모집 정보"> 자율미션 혜택</th>
                                <td><?=$out_row['hero_benefit_02']?></td>
                            </tr>
                        <? }?>
                        </tbody>
                    </table>
                    <? } ?>
                <? }?>
                <!-- AK기자단/루나체험단/휘슬클럽 (e) -->
            </div>  
            <div class="cont_info">
                <p class="fz36 bold">안내사항</p>
                <div class="desc_info fz26">
                    <?=htmlspecialchars_decode($out_row['hero_guide'])?>
                </div>
            </div>	              
        </div>
    </div>           

    
    <!-- superpass popup -->
    <? include_once BOARD_INC_END.'superpass.php';?>

    <script>
        const currentUrl = window.location.href;

        Kakao.Share.createDefaultButton({
            container: '#kakaotalk-sharing-btn',
            objectType: 'feed',
            content: {
                title: '<?=$out_row['hero_title']?>',
                description: 'AK Lover 체험단에 참여해 보세요!',
                imageUrl: 'http://aklover.co.kr<?=$img_new?>',
                link: {
                    mobileWebUrl: currentUrl,
                    webUrl: currentUrl,
                },
            },
            buttons: [
            {
                title: '웹으로 보기',
                link: {
                    mobileWebUrl: currentUrl,
                    webUrl: currentUrl,
                },
            },
            ],
        }); 
    </script>