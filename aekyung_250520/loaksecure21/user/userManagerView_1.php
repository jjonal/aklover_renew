<form name="searchForm" id="searchForm" method="GET">
<? 
unset($_GET["hero_code"]);
unset($_GET["view"]);
foreach($_GET as $key=>$val) {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } ?>
</form>

<div class="btnGroupFunction">
    <div class="leftWrap">
        <h2 class="tit_section">기본정보</h2>
    </div>
    <div class="rightWrap">
        <!-- <a href="javascript:;" onClick="fnPopPoint()" class="btnFunc">포인트 확인</a>
        <a href="javascript:;" onClick="fnPopWrite()" class="btnFunc">작성글 확인</a> -->


        <!-- <a href="javascript:;" onClick="fnPopSuperpass()" class="btnAdd4">슈퍼패스 확인/부여</a> -->
        <a href="javascript:;" class="btnAdd4 popup_btn" data-popup="01">슈퍼패스 부여</a>


        <!-- <a href="javascript:;" onClick="fnPopPenalty()" class="btnFunc">패널티 관리</a>
        <a href="javascript:;" onClick="fnWithdrawal('<?=$view["hero_nick"]?>')" class="btnFormCancel">회원탈퇴</a> -->
    </div>
</div>

<form name="viewForm" id="viewForm">
<input type="hidden" name="mode" />
<input type="hidden" name="hero_code" value="<?=$view["hero_code"]?>"/>

<table class="searchBox mu_form">
    <colgroup>
        <col width="200px">
        <col width=*>
        <col width="200px">
        <col width=*>
    </colgroup>
    <tbody>
        <tr>
            <th>아이디</th>
            <td><?=$view["hero_id"]?> (LV : <?=$view["hero_level"]?>)</td>
            <th>닉네임</th>
            <td><?=$view["hero_nick"]?></td>
        </tr>
        <tr>
            <th>이름</th>
            <td><?=$view["hero_name"]?></td>
            <th>나이</th>
            <td><?=$view["hero_age"]?></td>
        </tr>
        <tr>
            <th>생년월일</th>
            <td><?=$view["hero_jumin"]?></td>
            <th>서포터즈</th>
            <td><?=$hero_group?></td>
        </tr>
        <tr>
            <th>보유포인트</th>
            <td>
                <?=number_format($view["hero_point"])?> p
                <a href="javascript:;" class="btnAdd4 popup_btn" data-popup="02">포인트 내역/지급</a>
                <a href="javascript:;" class="btnAdd4 popup_btn" data-popup="03">패널티 내역/지급</a>
            </td>
            <th>서포터즈 팀</th>
            <td><?=$hero_board_group?></td>
        </tr>
        <tr>
            <th>휴대폰번호</th>
            <td>
                <div class="fl alc">
                    <div class="fl alc g5">
                        <input type="text" name="hero_hp_01" value="<?=$hero_hp[0]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly/>
                        <div class="inner_between">-</div>
                        <input type="text" name="hero_hp_02" value="<?=$hero_hp[1]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly />
                        <div class="inner_between">-</div>
                        <input type="text" name="hero_hp_03" value="<?=$hero_hp[2]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly />
                    </div>

                    <label class="akContainer">수정 활성화
                        <input type="checkbox" name="hero_hp_check" id="hero_hp_check">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
            <th>이메일</th>
            <td>
                <div class="fl alc g5">
                    <input type="text" name="hero_mail_01" value="<?=$hero_mail[0]?>" class="w150 input_hero_mail" readonly/>
                    <div class="inner_between">@</div>
                    <input type="text" name="hero_mail_02" value="<?=$hero_mail[1]?>" class="w150 input_hero_mail" readonly />
                    
                    <label class="akContainer">수정 활성화
                        <input type="checkbox" name="hero_mail_check" id="hero_mail_check">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>휴대폰 수신동의</th>
            <td>
                <div class="search_inner">
                    <label class="akContainer">동의
                        <input type="radio"name="hero_chk_phone" id="hero_chk_phone_1" value="1" <?=$view["hero_chk_phone"] == "1" ? "checked":""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">미동의
                        <input type="radio" name="hero_chk_phone" id="hero_chk_phone_0" value="0" <?=$view["hero_chk_phone"] != "1" ? "checked":""?>/>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
            <th>이메일 수신동의</th>
            <td>
                <div class="search_inner">
                    <label class="akContainer">동의
                        <input type="radio" name="hero_chk_email" id="hero_chk_email_1" value="1" <?=$view["hero_chk_email"] == "1" ? "checked":""?>>
                        <span class="checkmark"></span>
                    </label>
                    <label class="akContainer">미동의
                        <input type="radio" name="hero_chk_email" id="hero_chk_email_0" value="0" <?=$view["hero_chk_email"] != "1" ? "checked":""?>/>
                        <span class="checkmark"></span>
                    </label>
                </div>
            </td>
        </tr>
        <tr>
            <th>주소</th>
            <td>
                [<?=$view["hero_address_01"]?>] <?=$view["hero_address_02"]?> <?=$view["hero_address_03"]?>
            </td>
            <th>회원가입 인증</th>
            <td><?=$handphone?><?=$kakaoTalk?><?=$naver?><?=$google?><?=$facebook?></td>
        </tr>
        <tr>
            <th>가입일</th>
            <td><?=$view["hero_oldday"]?></td>
            <th>최종 로그인 날짜</th>
            <td><?=$view["hero_today"]?>&nbsp;&nbsp;&nbsp;<a href="javascript:;" class="btnAdd4 popup_btn" data-popup="04">로그인 이력</a></td>
        </tr>
        <tr>
            <th>회원탈퇴처리</th>
            <td>
                <a href="javascript:;" onClick="fnWithdrawal('<?=$view["hero_nick"]?>')" class="btnAdd4">회원탈퇴</a>
            </td>
            <th>비밀번호 초기화 날짜</th>
            <td id="pw_initialized_datetime"><?=$pw_init["hero_today"]?>
            <? if(isset($pw_init["hero_today"]) && !empty($pw_init["hero_today"])) {?>
            &nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="fnPopResetPwHist()" class="btnFunc">초기화 이력</a>
            <? }?>
            </td>
        </tr>
    </tbody>
</table>


<!-- <table class="t_view">
<colgroup>
    <col width="150px">
    <col width=*>
    <col width="150px">
    <col width=*>
</colgroup>
<tbody>
    <tr>
        <th>아이디</th>
        <td><?=$view["hero_id"]?> (LV : <?=$view["hero_level"]?>)</td>
        <th>닉네임</th>
        <td><?=$view["hero_nick"]?></td>
    </tr>
    <tr>
        <th>이름</th>
        <td><?=$view["hero_name"]?></td>
        <th>나이</th>
        <td><?=$view["hero_age"]?></td>
    </tr>
    <tr>
        <th>생년월일</th>
        <td colspan="3"><?=$view["hero_jumin"]?></td>
    </tr>
    <tr>
        <th>전체포인트</th>
        <td><?=number_format($view["hero_point"])?> p</td>
        <th>가용포인트</th>
        <td><?=number_format($view["hero_point"]-$view["hero_order_point"])?> p</td>
    </tr>
    <tr>
        <th>휴대폰번호</th>
        <td>
            <input type="text" name="hero_hp_01" value="<?=$hero_hp[0]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly />
            - <input type="text" name="hero_hp_02" value="<?=$hero_hp[1]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly/>
            - <input type="text" name="hero_hp_03" value="<?=$hero_hp[2]?>" class="w100 input_hero_hp" maxlength="4" numberOnly readonly/>
            
            <input type="checkbox" name="hero_hp_check" id="hero_hp_check"/><label>수정 활성화</label>
        </td>
        <th>이메일</th>
        <td>
            <input type="text" name="hero_mail_01" value="<?=$hero_mail[0]?>" class="w200 input_hero_mail" readonly/>
            @ <input type="text" name="hero_mail_02" value="<?=$hero_mail[1]?>" class="w200 input_hero_mail" readonly/>
            
            <input type="checkbox" name="hero_mail_check" id="hero_mail_check"/><label>수정 활성화</label>
        </td>
    </tr>
    <tr>
        <th>휴대폰 수신동의</th>
        <td>
            <input type="radio" name="hero_chk_phone" id="hero_chk_phone_1" value="1" <?=$view["hero_chk_phone"] == "1" ? "checked":""?>/><label for="hero_chk_phone_1">동의</label>
            <input type="radio" name="hero_chk_phone" id="hero_chk_phone_0" value="0" <?=$view["hero_chk_phone"] != "1" ? "checked":""?>/><label for="hero_chk_phone_0">미동의</label>
        </td>
        <th>이메일 수신동의</th>
        <td>
            <input type="radio" name="hero_chk_email" id="hero_chk_email_1" value="1" <?=$view["hero_chk_email"] == "1" ? "checked":""?>/><label for="hero_chk_email_1">동의</label>
            <input type="radio" name="hero_chk_email" id="hero_chk_email_0" value="0" <?=$view["hero_chk_email"] != "1" ? "checked":""?>/><label for="hero_chk_email_0">미동의</label>
        </td>
    </tr>
    <tr>
        <th>주소</th>
        <td colspan="3">
            [<?=$view["hero_address_01"]?>] <?=$view["hero_address_02"]?> <?=$view["hero_address_03"]?>
        </td>
    </tr>
    <tr>
        <th>가입경로</th>
        <td>
            <?=$view["area"]?>
            <? if($view["area"]=="기타") {?> 
                (<?=$view["area_etc_text"]?>)
            <? } ?>
        </td>
        <th>회원가입 인증</th>
        <td><?=$handphone?><?=$kakaoTalk?><?=$naver?><?=$google?><?=$facebook?></td>
    </tr>
    <tr>
        <th>추천인</th>
        <td colspan="3">
            <? if($view["hero_user_type"] == "hero_id") {?>
                아이디 추천 : 
            <? } else if($view["hero_user_type"] == "hero_nick") { ?>
                닉네임 추천 :
            <? } ?>
            <?=$view["hero_user"]?>
        </td>
    </tr>
    <tr>
        <th>가입일</th>
        <td><?=$view["hero_oldday"]?></td>
        <th>최종 로그인 날짜</th>
        <td><?=$view["hero_today"]?>&nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="fnPopLoginHist()" class="btnFunc">로그인 이력</a></td>
    </tr>
    <tr>
        <th>비밀번호 초기화</th>
        <td>
            <a href="javascript:;" onClick="fnPWInitialize('<?=$view["hero_id"]?>')" class="btnFunc2">초기화</a>
            <input type="text" name="pw_initialized" value="" style="width:150px; outline:none; border:none;border-right:0px; border-top:0px; boder-left:0px; boder-bottom:0px;" readonly />
        </td>
        <th>최종 비밀번호 초기화<br/>날짜</th>
        <td id="pw_initialized_datetime"><?=$pw_init["hero_today"]?>
        <? if(isset($pw_init["hero_today"]) && !empty($pw_init["hero_today"])) {?>
        &nbsp;&nbsp;&nbsp;<a href="javascript:;" onClick="fnPopResetPwHist()" class="btnFunc">초기화 이력</a>
        <? }?>
        </td>
    </tr>
</tbody>
</table> -->

<!-- <div class="align_c margin_t20">
    <a href="javascript:;" onclick="fnEdit()" class="btnAdd">수정</a>
</div> -->

<ul class="splitContent">
    <li>
        <p class="sub_tit">추가정보</p>
        <table class="searchBox">
            <colgroup>
                <col width="200px">
                <col width=*>
            </colgroup>
            <tbody>
                <tr>
                    <th>알게된 경로</th>
                    <td>
                        <?=$view["area"]?>
                        <? if($view["area"]=="기타") {?>
                            (<?=$view["area_etc_text"]?>)
                        <? } ?>
                    </td>
                </tr>
                <tr>
                    <th>관심있는 활동</th>
                    <td><?=$view["hero_activity"]?></td>
                </tr>
                <tr>
                    <th>결혼 유무</th>
                    <td><?=$view["hero_qs_02"] == "Y" ? "기혼":"미혼"?></td>
                </tr>
                <tr>
                    <th>자녀유무 /태어난 연도</th>
                    <td>
                    <? if($view["hero_qs_04"]) {
                        $hero_qs_05_arr = explode(",",$view["hero_qs_05"]);
                        $hero_qs_05_txt = "";
                        foreach($hero_qs_05_arr as $val) {
                            if($hero_qs_05_txt) $hero_qs_05_txt .= ", ";
                            $hero_qs_05_txt .= $val;
                        }
                        
                    ?>
                        <?=$view["hero_qs_03"] == "Y" ? "있음":"없음"?> / <?=$view["hero_qs_04"]?>명 / <?=$hero_qs_05_txt?> 
                    <? } ?>
                    </td>
                </tr>
                <tr>
                    <th>반려동물 유무</th>
                    <td><?=$hero_qs_19?></td>
                </tr>
                <tr>
                    <th>건조기 유무</th>
                    <td><?=$hero_qs_20?></td>
                </tr>
                <tr>
                    <th>식기세척기 유무</th>
                    <td><?=$hero_qs_21?></td>
                </tr>
                <tr>
                    <th>AK Lover에 가입한 이유</th>
                    <td><?=$view["hero_qs_06"]?></td>
                </tr>
                <tr>
                    <th>AK Lover 외 활동</th>
                    <td>
                        <?=$view["hero_qs_07"] == "Y" ? "있음":"없음"?>
                        <? if($view["hero_qs_07"] == "Y") {?>
                            (<?=$view["hero_qs_08"]?>)
                        <? } ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </li>
    <li>
        <p class="sub_tit">SNS 관리</p>
        <table class="searchBox">
            <colgroup>
                <col width="200px">
                <col width=*>
            </colgroup>
            <tbody class="mu_form">
                <tr>
                    <th>SNS 퀄리티</th>
                    <td><?=$view["hero_id"]?> (LV : <?=$view["hero_level"]?>)</td>
                </tr>
                <tr>
                    <th>퀄리티 업데이트 날짜</th>
                    <td><input type="text" name="hero_sns_update_date" value="<?=$view["hero_sns_update_date"]?>" placeholder="양식 ex) yyyymm" numberOnly maxlength="6"></td>
                </tr>
                <tr>
                    <th>네이버 블로그</th>
                    <td>https://blog.naver.com/<input type="text" style="width:200px;margin-left: 5px;" name="hero_blog_00" value="<?=$hero_naver_blog?>" /></td>
                </tr>
                <tr>
                    <th>인스타그램</th>
                    <td>https://www.instagram.com/<input type="text" style="width:200px;margin-left: 5px;" name="hero_blog_04" value="<?=$hero_instagram?>" /></td>
                </tr>
                <tr>
                    <th>숏폼</th>
                    <!-- 유튜브 -->
                    <td>
                        <div class="textLink">
                            <input type="text" name="hero_blog_03" value="<?=$view["hero_blog_03"]?>" class="w100p"/>
                            <span><a href=""><img src="<?=PATH_IMAGE_END?>common/icon_link.svg" alt="연결" /></a></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th rowspan="3">기타</th>
                    <td>
                        <div class="textLink">
                            <input type="text" name="hero_blog_08" value="<?=$view["hero_blog_08"]?>" class="w100p"/>
                            <span><a href=""><img src="<?=PATH_IMAGE_END?>common/icon_link.svg" alt="연결" /></a></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="textLink">
                            <input type="text" name="hero_blog_08" value="<?=$view["hero_blog_08"]?>" class="w100p"/>
                            <span><a href=""><img src="<?=PATH_IMAGE_END?>common/icon_link.svg" alt="연결" /></a></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="textLink">
                            <input type="text" name="hero_blog_08" value="<?=$view["hero_blog_08"]?>" class="w100p"/>
                            <span><a href=""><img src="<?=PATH_IMAGE_END?>common/icon_link.svg" alt="연결" /></a></span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </li>
</ul>

<div class="btnConainer_typeA">
    <a href="javascript:;" onclick="fnEditSns()" class="btnAdd3 center">수정</a>
    <a href="javascript:;" onclick="fnList();" class="btnAdd3 right">목록</a>
</div>

<!-- 
<p class="tit_section mgt30">SNS 관리</p>
<table class="t_view mgt10">
<colgroup>
    <col width="150px">
    <col width=*>
    <col width="100">
    <col width="120">
    <col width="100">
    <col width="120">
    <col width="100">
    <col width="120">
</colgroup>
<tbody>
    <tr>
        <th>퀄리티 업데이트 날짜</th>
        <td colspan="7"><input type="text" name="hero_sns_update_date" value="<?=$view["hero_sns_update_date"]?>" placeholder="양식 ex) yyyymm" numberOnly maxlength="6"></td>
    </tr>
    <tr>
        <th>네이버 블로그</th>
        <td>https://blog.naver.com/<input type="text" style="width:200px;margin-left: 5px;" name="hero_blog_00" value="<?=$hero_naver_blog?>" /></td>
        <th>방문자 수</th>
        <td><input type="text" name="hero_memo" value="<?=$view["hero_memo"]?>" numberOnly/></td>
        <th>이미지 퀄리티</th>
        <td><select name="hero_memo_01_image">
                <option value="">선택</option>
                <option value="상" <?=$view["hero_memo_01_image"]=="상" ? "selected":""?>>상</option>
                <option value="중상" <?=$view["hero_memo_01_image"]=="중상" ? "selected":""?>>중상</option>
                <option value="중" <?=$view["hero_memo_01_image"]=="중" ? "selected":""?>>중</option>
                <option value="중하" <?=$view["hero_memo_01_image"]=="중하" ? "selected":""?>>중하</option>
                <option value="하" <?=$view["hero_memo_01_image"]=="하" ? "selected":""?>>하</option>
            </select>
        </td>
        <th>텍스트 퀄리티</th>
        <td><select name="hero_memo_01">
                <option value="">선택</option>
                <option value="상" <?=$view["hero_memo_01"]=="상" ? "selected":""?>>상</option>
                <option value="중상" <?=$view["hero_memo_01"]=="중상" ? "selected":""?>>중상</option>
                <option value="중" <?=$view["hero_memo_01"]=="중" ? "selected":""?>>중</option>
                <option value="중하" <?=$view["hero_memo_01"]=="중하" ? "selected":""?>>중하</option>
                <option value="하" <?=$view["hero_memo_01"]=="하" ? "selected":""?>>하</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>인스타그램</th>
        <td>https://www.instagram.com/<input type="text" style="width:200px;margin-left: 5px;" name="hero_blog_04" value="<?=$hero_instagram?>" /></td>
        <th>팔로워 수</th>
        <td><input type="text" name="hero_insta_cnt" value="<?=$view["hero_insta_cnt"]?>" numberOnly/></td>
        <th>이미지 퀄리티</th>
        <td><select name="hero_insta_image_grade">
                <option value="">선택</option>
                <option value="상" <?=$view["hero_insta_image_grade"]=="상" ? "selected":""?>>상</option>
                <option value="중상" <?=$view["hero_insta_image_grade"]=="중상" ? "selected":""?>>중상</option>
                <option value="중" <?=$view["hero_insta_image_grade"]=="중" ? "selected":""?>>중</option>
                <option value="중하" <?=$view["hero_insta_image_grade"]=="중하" ? "selected":""?>>중하</option>
                <option value="하" <?=$view["hero_insta_image_grade"]=="하" ? "selected":""?>>하</option>
            </select>
        </td>
        <th>텍스트 퀄리티</th>
        <td><select name="hero_insta_grade">
                <option value="">선택</option>
                <option value="상" <?=$view["hero_insta_grade"]=="상" ? "selected":""?>>상</option>
                <option value="중상" <?=$view["hero_insta_grade"]=="중상" ? "selected":""?>>중상</option>
                <option value="중" <?=$view["hero_insta_grade"]=="중" ? "selected":""?>>중</option>
                <option value="중하" <?=$view["hero_insta_grade"]=="중하" ? "selected":""?>>중하</option>
                <option value="하" <?=$view["hero_insta_grade"]=="하" ? "selected":""?>>하</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>그 외  SNS</th>
        <td colspan="7"><input type="text" name="hero_blog_05" value="<?=$view["hero_blog_05"]?>" /></td>
    </tr>
    <tr>
        <th>네이버 인플루언서 홈</th>
        <td>https://in.naver.com/<input type="text" style="width:200px;margin-left: 5px;" name="hero_naver_influencer" value="<?=$hero_naver_influencer?>" /></td>
        <th colspan="2">네이버 인플루언서 명</th>
        <td colspan="2"><input type="text" name="hero_naver_influencer_name" value="<?=$view["hero_naver_influencer_name"]?>"/></td>
        <th>활동 카테고리</th>
        <td><select id="hero_naver_influencer_category" name="hero_naver_influencer_category">
                <option value=""<?if(!strcmp($view["hero_naver_influencer_category"], '')){echo ' selected';}else{echo '';}?>>선택</option>
                <option value="여행"<?if(!strcmp($view["hero_naver_influencer_category"], '여행')){echo ' selected';}else{echo '';}?>>여행</option>
                <option value="패션"<?if(!strcmp($view["hero_naver_influencer_category"], '패션')){echo ' selected';}else{echo '';}?>>패션</option>
                <option value="뷰티"<?if(!strcmp($view["hero_naver_influencer_category"], '뷰티')){echo ' selected';}else{echo '';}?>>뷰티</option>
                <option value="푸드"<?if(!strcmp($view["hero_naver_influencer_category"], '푸드')){echo ' selected';}else{echo '';}?>>푸드</option>
                <option value="IT테크"<?if(!strcmp($view["hero_naver_influencer_category"], 'IT테크')){echo ' selected';}else{echo '';}?>>IT테크</option>
                <option value="자동차"<?if(!strcmp($view["hero_naver_influencer_category"], '자동차')){echo ' selected';}else{echo '';}?>>자동차</option>
                <option value="리빙"<?if(!strcmp($view["hero_naver_influencer_category"], '리빙')){echo ' selected';}else{echo '';}?>>리빙</option>
                <option value="육아"<?if(!strcmp($view["hero_naver_influencer_category"], '육아')){echo ' selected';}else{echo '';}?>>육아</option>
                <option value="생활건강"<?if(!strcmp($view["hero_naver_influencer_category"], '생활건강')){echo ' selected';}else{echo '';}?>>생활건강</option>
                <option value="게임"<?if(!strcmp($view["hero_naver_influencer_category"], '게임')){echo ' selected';}else{echo '';}?>>게임</option>
                <option value="동물/펫"<?if(!strcmp($view["hero_naver_influencer_category"], '동물/펫')){echo ' selected';}else{echo '';}?>>동물/펫</option>
                <option value="운동/레저"<?if(!strcmp($view["hero_naver_influencer_category"], '운동/레저')){echo ' selected';}else{echo '';}?>>운동/레저</option>
                <option value="프로스포츠"<?if(!strcmp($view["hero_naver_influencer_category"], '프로스포츠')){echo ' selected';}else{echo '';}?>>프로스포츠</option>
                <option value="방송/연예"<?if(!strcmp($view["hero_naver_influencer_category"], '방송/연예')){echo ' selected';}else{echo '';}?>>방송/연예</option>
                <option value="대중음악"<?if(!strcmp($view["hero_naver_influencer_category"], '대중음악')){echo ' selected';}else{echo '';}?>>대중음악</option>
                <option value="영화"<?if(!strcmp($view["hero_naver_influencer_category"], '영화')){echo ' selected';}else{echo '';}?>>영화</option>
                <option value="공연/전시/예술"<?if(!strcmp($view["hero_naver_influencer_category"], '공연/전시/예술')){echo ' selected';}else{echo '';}?>>공연/전시/예술</option>
                <option value="도서"<?if(!strcmp($view["hero_naver_influencer_category"], '도서')){echo ' selected';}else{echo '';}?>>도서</option>
                <option value="경제/비즈니스"<?if(!strcmp($view["hero_naver_influencer_category"], '경제/비즈니스')){echo ' selected';}else{echo '';}?>>경제/비즈니스</option>
                <option value="어학/교육"<?if(!strcmp($view["hero_naver_influencer_category"], '어학/교육')){echo ' selected';}else{echo '';}?>>어학/교육</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>유튜브</th>
        <td><input type="text" name="hero_blog_03" value="<?=$view["hero_blog_03"]?>" /></td>
        <th>구독자 수</th>
        <td><input type="text" name="hero_youtube_cnt" value="<?=$view["hero_youtube_cnt"]?>" numberOnly/></td>
        <th>조회수 수</th>
        <td><input type="text" name="hero_youtube_view" value="<?=$view["hero_youtube_view"]?>" numberOnly/></td>
        <th>콘텐츠 등급</th>
        <td><select name="hero_youtube_grade">
                <option value="">선택</option>
                <option value="상" <?=$view["hero_youtube_grade"]=="상" ? "selected":""?>>상</option>
                <option value="중상" <?=$view["hero_youtube_grade"]=="중상" ? "selected":""?>>중상</option>
                <option value="중" <?=$view["hero_youtube_grade"]=="중" ? "selected":""?>>중</option>
                <option value="중하" <?=$view["hero_youtube_grade"]=="중하" ? "selected":""?>>중하</option>
                <option value="하" <?=$view["hero_youtube_grade"]=="하" ? "selected":""?>>하</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>네이버TV</th>
        <td colspan="7"><input type="text" name="hero_blog_06" value="<?=$view["hero_blog_06"]?>" /></td>
    </tr>
    <tr>
        <th>틱톡</th>
        <td colspan="7"><input type="text" name="hero_blog_07" value="<?=$view["hero_blog_07"]?>" /></td>
    </tr>
    <tr>
        <th>기타(영상)</th>
        <td colspan="7"><input type="text" name="hero_blog_08" value="<?=$view["hero_blog_08"]?>" /></td>
    </tr>
</tbody>
</table>
<div class="align_c margin_t20">
    <a href="javascript:;" onclick="fnEditSns()" class="btnAdd">수정</a>
</div>

<p class="tit_section mgt10">추가 기입 정보</p>
<table class="t_view mgt10">
<colgroup>
    <col width="150px">
    <col width="">
    <col width="150px">
    <col width="">
</colgroup>
<tbody>
    <tr>
        <th>개인 SNS URL(유/무)</th>
        <td><?=$view["hero_qs_01"] == "Y" ? "있음":"없음"?></td>
        <th>결혼 유무</th>
        <td><?=$view["hero_qs_02"] == "Y" ? "기혼":"미혼"?></td>
    </tr>
    <tr>
        <th>자녀유무</th>
        <td><?=$view["hero_qs_03"] == "Y" ? "있음":"없음"?></td>
        <th>자녀 수/태어난 년도</th>
        <td>
            <? if($view["hero_qs_04"]) {
                $hero_qs_05_arr = explode(",",$view["hero_qs_05"]);
                $hero_qs_05_txt = "";
                foreach($hero_qs_05_arr as $val) {
                    if($hero_qs_05_txt) $hero_qs_05_txt .= ", ";
                    $hero_qs_05_txt .= $val;
                }
                
            ?>
                <?=$view["hero_qs_04"]?>명/<?=$hero_qs_05_txt?>
                
            <? } ?>
        </td>
    </tr>
    <tr>
        <th>피부타입</th>
        <td><?=$view["hero_qs_22"]?></td>
        <th>두피타입</th>
        <td><?=$view["hero_qs_23"]?></td>
    </tr>
    <tr>
        <th>탈모 유무</th>
        <td><?=$hero_qs_18?></td>
        <th>반려동물 유무</th>
        <td><?=$hero_qs_19?></td>
    </tr>
    <tr>
        <th>건조기 유무</th>
        <td><?=$hero_qs_20?></td>
        <th>식기세척기 유무</th>
        <td><?=$hero_qs_21?></td>
    </tr>
    <tr>
        <th>AK LOVER에 가입한 이유</th>
        <td colspan="3"><?=$view["hero_qs_06"]?></td>
    </tr>
    <tr>
        <th>AK LOVER외 활동하는 서포터즈/체험단 카페 또는 홈페이지</th>
        <td colspan="3">
            <?=$view["hero_qs_07"] == "Y" ? "있음":"없음"?>
            <? if($view["hero_qs_07"] == "Y") {?>
                (<?=$view["hero_qs_08"]?>)
            <? } ?>
        </td>
    </tr>
</tbody>
</table> -->

</form>
<!-- 
<div class="align_l margin_t20">
    <a href="javascript:;" onclick="fnList();" class="btnList">목록</a>
</div> -->


<!-- 슈퍼패스 확인 부여 -->
<!-- /loaksecure21/user/popUserManagerSuperpassList.php -->
<div class="popup_url_box" id="pop_01">
	<div class="popup_url_cont">
		<div class="popup_url_head">
			<svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
			</svg>
		</div>
		<div class="popup_url_body mu_form" id="popupContent">
            <iframe src="/loaksecure21/user/popUserManagerSuperpassList.php?hero_code=<?= $view['hero_code'] ?>" width="660" height="720" frameborder="0" class="iframe_popup"></iframe>
		</div>
	</div>
</div>

<!-- 포인트 지급 내역 -->
<!-- /loaksecure21/user/popUserManagerPointList.php -->
<div class="popup_url_box" id="pop_02">
	<div class="popup_url_cont">
		<div class="popup_url_head">
			<svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
			</svg>
		</div>
		<div class="popup_url_body mu_form" id="popupContent">
            <iframe src="/loaksecure21/user/popUserManagerPointList.php?hero_code=<?=$view["hero_code"]?>" width="660" height="720" frameborder="0" class="iframe_popup">
            </iframe>
		</div>
	</div>
</div>

<!-- 패널티 지급 내역 -->
<!-- /loaksecure21/user/popUserManagerPenaltyList.php -->
<div class="popup_url_box" id="pop_03">
	<div class="popup_url_cont">
		<div class="popup_url_head">
			<svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
			</svg>
		</div>
		<div class="popup_url_body mu_form" id="popupContent">
        <iframe src="/loaksecure21/user/popUserManagerPenaltyList.php?hero_code=<?=$view["hero_code"]?>" width="660" height="720" frameborder="0" class="iframe_popup">
        </iframe>
		</div>
	</div>
</div>

<!-- 로그인 이력 -->
<!-- /loaksecure21/user/popUserManagerLoginHist.php -->
<div class="popup_url_box" id="pop_04">
	<div class="popup_url_cont">
		<div class="popup_url_head">
			<svg class="close" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path fill-rule="evenodd" clip-rule="evenodd" d="M4.41073 4.41083C4.73617 4.08539 5.26381 4.08539 5.58925 4.41083L15.5892 14.4108C15.9147 14.7363 15.9147 15.2639 15.5892 15.5893C15.2638 15.9148 14.7362 15.9148 14.4107 15.5893L4.41073 5.58934C4.0853 5.2639 4.0853 4.73626 4.41073 4.41083Z" fill="black"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M15.5892 4.41083C15.2638 4.08539 14.7362 4.08539 14.4107 4.41083L4.41072 14.4108C4.08529 14.7363 4.08529 15.2639 4.41072 15.5893C4.73616 15.9148 5.2638 15.9148 5.58924 15.5893L15.5892 5.58934C15.9147 5.2639 15.9147 4.73626 15.5892 4.41083Z" fill="black"/>
			</svg>
		</div>
		<div class="popup_url_body mu_form" id="popupContent">
            <iframe src="/loaksecure21/user/popUserManagerLoginHist.php?hero_code=<?=$view["hero_code"]?>" width="660" height="720" frameborder="0" class="iframe_popup"></iframe>
		</div>
	</div>
</div>

            
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script src="/js/daumAddressApi.js"></script>
<script>
$(document).ready(function(){
	$("#hero_hp_check").on("click",function(){
		if($(this).is(":checked")) {
			$(".input_hero_hp").attr("readOnly",false);
		} else {
			$(".input_hero_hp").attr("readOnly",true);
		}
	})
	
	$("#hero_mail_check").on("click",function(){
		if($(this).is(":checked")) {
			$(".input_hero_mail").attr("readOnly",false);
		} else {
			$(".input_hero_mail").attr("readOnly",true);
		}
	})

	fnPopPoint = function() {
		var popPoint = window.open("/loaksecure21/user/popUserManagerPointList.php?hero_code=<?=$view["hero_code"]?>","popPoint","width=660, height=660");
		popPoint.focus();
	}

	fnPopWrite = function() {
		var popWrite = window.open("/loaksecure21/user/popUserManagerWriteList.php?hero_code=<?=$view["hero_code"]?>","popWrite","width=660, height=500");
		popWrite.focus();
	}
	
	fnPopLoginHist = function() {
		var popWrite = window.open("/loaksecure21/user/popUserManagerLoginHist.php?hero_code=<?=$view["hero_code"]?>","popWrite","width=660, height=500");
		popWrite.focus();
	}
	
	fnPopResetPwHist = function() {
		var popWrite = window.open("/loaksecure21/user/popUserManagerResetPwHist.php?hero_code=<?=$view["hero_code"]?>","popWrite","width=660, height=500");
		popWrite.focus();
	}

	fnPopSuperpass = function() {
		var popSuperpass = window.open("/loaksecure21/user/popUserManagerSuperpassList.php?hero_code=<?=$view["hero_code"]?>","popSuperpass","width=660, height=500");
		popSuperpass.focus();
	}

	fnPopPenalty = function() {
		var popPenalty = window.open("/loaksecure21/user/popUserManagerPenaltyList.php?hero_code=<?=$view["hero_code"]?>","popPenalty","width=660, height=500");
		popPenalty.focus();
	}
	
	fnEditSns = function() {
		if(confirm("SNS 관리 정보를 수정하시겠습니까?")) {
			$("#viewForm input[name='mode']").val("editSns");
			var param = $("#viewForm").serialize();
			$.ajax({
					url:"/loaksecure21/user/userManagerAction.php"
					,type:"POST"
					,data:param
					,dataType:"json"
					,success:function(d){
						console.log(d);
						if(d.result==1) {
							alert("SNS 관리 정보가 수정 되었습니다.");
							location.reload();
						} else {
							alert("실행 중 실패했습니다.")
						}
					},error:function(e){
						console.log(e);
						alert("실패했습니다.");
					}
				})
				
			$("#viewForm input[name='mode']").val("");//초기화
		}
	}
	
	
	fnEdit = function() {
		_frm = $("#viewForm");
		if(!_frm.find("input[name='hero_hp_01']").val()) {
			alert("휴대폰(1)을 입력해 주세요.");
			_frm.find("input[name='hero_hp_01']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_hp_02']").val()) {
			alert("휴대폰(2)을 입력해 주세요.");
			_frm.find("input[name='hero_hp_02']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_hp_03']").val()) {
			alert("휴대폰(3)을 입력해 주세요.");
			_frm.find("input[name='hero_hp_03']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_mail_01']").val()) {
			alert("이메일(1)을 입력해 주세요.");
			_frm.find("input[name='hero_mail_01']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_mail_02']").val()) {
			alert("이메일(2)을 입력해 주세요.");
			_frm.find("input[name='hero_mail_02']").focus();
			return;
		}
		/*
		if(!_frm.find("input[name='hero_address_01']").val()) {
			alert("우편번호를 입력해 주세요.");
			_frm.find("input[name='hero_address_01']").focus();
			return;
		}

		if(!_frm.find("input[name='hero_address_02']").val()) {
			alert("주소를 입력해 주세요.");
			_frm.find("input[name='hero_address_02']").focus();
			return;
		}
		*/

		_frm.find("input[name='mode']").val("edit");
		var param = _frm.serialize();
		$.ajax({
				url:"/loaksecure21/user/userManagerAction.php"
				,type:"POST"
				,data:param
				,dataType:"json"
				,success:function(d){
					console.log(d);
					if(d.result==1) {
						alert(" 수정 되었습니다.");
						location.reload();
					} else {
						alert("실행 중 실패했습니다.")
					}
				},error:function(e){
					console.log(e);
					alert("실패했습니다.");
				}
			})
			
			_frm.find("input[name='mode']").val(""); //초기화
	}
	
	
	fnPWInitialize = function(hero_id) { 
		alert("패스워드를 입력해주세요.");
        const name = prompt("패스워드 입력" + "");
        if (name=="") {
            return fnPwResetConfirm();
        }
        
        else if (name == null) {
            return;
        }
    
        if (name == '0104'){
            _frm = $("#viewForm");
        
            const characters ='8A0B1CD2EF7GH3IJKL4MN6OPQ5RS9TUV6WXYZa7b5cde8fghi9jkl4mn3opqr2stuvw1xyz0';
            let result = '';
            const charactersLength = characters.length;
            for (let i = 0; i < 8; i++) {
               result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
        
            result = hero_id + result;
            _frm.find("input[name='pw_initialized']").val(result);

    		_frm.find("input[name='mode']").val("pwInitialize");
    		var param = _frm.serialize();
    		$.ajax({
    				url:"/loaksecure21/user/userManagerAction.php"
    				,type:"POST"
    				,data:param
    				,dataType:"json"
    				,success:function(d){
    					console.log(d);
    					if(d.result==1) {
    						var today = new Date();
                            today.setHours(today.getHours() + 9);
                            var datestr = today.toISOString().replace('T', ' ').substring(0, 19);
                            $("#pw_initialized_datetime").text(datestr);
    						alert("초기화 되었습니다.");
    					} else {
    						alert("실행 중 실패했습니다.");
    					}
    				},error:function(e){
    					console.log(e);
    					alert("실패했습니다.");
    				}
    			})
			
			_frm.find("input[name='mode']").val("");
        } else {
            alert("패스워드가 틀렸습니다.")
        }
	}
	
	
	fnWithdrawal = function(hero_nick) {
		if(confirm(hero_nick+"님을 관리자 권한으로 탈퇴하시겠습니까?\n탈퇴 후 복구는 불가능합니다.")) {
			$("#viewForm input[name='mode']").val("withdrawal");
			var param = $("#viewForm").serialize();
			$.ajax({
					url:"/loaksecure21/user/userManagerAction.php"
					,type:"POST"
					,data:param
					,dataType:"json"
					,success:function(d){
						console.log(d);
						if(d.result==1) {
							alert("탈퇴되었습니다.");
							fnList();
						} else {
							alert("실행 중 실패했습니다.")
						}
					},error:function(e){
						console.log(e);
						alert("실패했습니다.");
					}
				})
				
			$("#viewForm input[name='mode']").val("");//초기화
		}
	}
	
	fnList = function() {
		$("#searchForm").submit();
	}
})

</script>

