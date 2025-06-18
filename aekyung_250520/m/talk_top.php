<?
$board 			=	$_GET['board'];
$gubun_arr = array("1"=>"일상","2"=>"체험단","3"=>"제안");
$cut_count_name = 	'6';				//최대 이름 글자수
$cut_title_name = 	'120';				//최대 제목 글자수

if($board == "group_02_02") { //메뉴별 공지
    $sql_notice = " SELECT hero_idx, hero_title, gubun, hero_nick, hero_today, hero_03, hero_keywords, hero_use FROM board ";
    $sql_notice .= " WHERE hero_notice_use = 1 AND hero_table='" . $_GET['board'] . "' " . $hero_use . " ORDER BY hero_idx DESC ";
    $sql_notice_res = mysql_query($sql_notice);
}
?>

<script type="text/javascript" src="/js/musign/board.js"></script>
<div class="slide_top cont_top lover_top">   
    <div class="caution">
        <h3 class="fz28 fw600 conttop_tit">안내/유의사항</h3>
        <div>
            <div class="">
                <div class="f_fs">
                    <img src="/img/front/icon/caution.webp" alt="안내/유의사항">
                    <div>
                        <p class="fz24">
                            AK Lover 회원분들의 소중한 의견과 서포터즈 및 일상 이야기를 자유롭게 나누는 공간입니다.
                            서로를 배려하고 존중하는 Lover 분들의 협조 부탁드립니다.                    
                        </p>
                        <p class="fz24">
                            - 종교/정치 관련 글/댓글 금지<br />
                            - 연속적이고 성의없는(5자 이내) 글/댓글 도배 금지<br />
                            - 본문과 상관없는 댓글 금지<br />
                            - 욕설, 폭언 등 타인에게 피해를 주는 글/댓글 금지
                        </p>                    
                        <p class="fz24 main_c">
                            ※Lover톡 유의사항을 미준수 하시는 경우, 무통보 삭제 또는
                            불이익(포인트 미지급, 강제 탈퇴 등)이 있을 수 있으니 반드시 유의사항을 준수해주세요.
                        </p>
                    </div>
                </div>
            </div>      
        </div>
    </div>
</div>
<div class="best_qna">    
    <div class="swiper-container best_qna_slide">
        <div class="swiper-wrapper">
            <?if($board == "group_02_02") {
                while($hero_notice_list = mysql_fetch_assoc($sql_notice_res)){ ?>
                    <div class="swiper-slide">
                        <div>
                            <a href="https://www.aklover.co.kr/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=439908&hero_gisu=&select=hero_title&kewyword=&date-from=2024.07.11&date-to=2024-07.11" class="f_cs">
                                <!--!!!!!!!! [개발요청] 아이콘 관리자 연동 필요 !!!!!!!!  -->
                                <img src="/img/front/board/faq01.png"alt="아이콘" class="icon">
                                <div class="quest">
                                    <!-- <span><?=$gubun_arr[$hero_notice_list['gubun']]?></span> -->
                                    <span>필독</span>
                                    <p class="fz22 fw600 ellipsis_1line">
                                        AK Lover 신규 홈페이지 변경 내용 안내(24.07.11)
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div>
                            <a href="https://www.aklover.co.kr/m/today_view.php?board=group_04_03&statusSearch=&hero_idx=431253&hero_gisu=&select=hero_title&kewyword=&date-from=2024.07.11&date-to=2024-07.11" class="f_cs">
                                <!--!!!!!!!! [개발요청] 아이콘 관리자 연동 필요 !!!!!!!!  -->
                                <img src="/img/front/board/faq01.png"alt="아이콘" class="icon">
                                <div class="quest">
                                    <!-- <span><?=$gubun_arr[$hero_notice_list['gubun']]?></span> -->
                                    <span>필독</span>
                                    <p class="fz22 fw600 ellipsis_1line">
                                        2024년 AK Lover 운영 변경사항 안내
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                <? }
            }?>
        </div>                                    
        <div class="swiper-pagination"></div>
    </div>
</div>
<div class="page_tit">
    <p class="fz44 fw600">Lover 톡</p> 
</div>
<!-- 팝업창 노출 시안 대기중 -->
<table class="dis-no">
    <tr class="answer">
        <td valign="top" ><img src="../image/bbs/icon_a.png" alt="답변" class="mt10" /></td>
        <td colspan="2" class="tl">
            <div>AK Lover 홈페이지 가입과 동시에 AK Lover로 활동이 가능하시며, 활동 임기 없이 지속적으로 활동 가능합니다.</div>
        </td>
    </tr>

    <tr class="answer">
        <td valign="top" ><img src="../image/bbs/icon_a.png" alt="답변" class="mt10" /></td>
        <td colspan="2" class="tl">
            <div>페이지 상단 - [마이페이지] - [회원정보 수정]에서 가능합니다.</div>
        </td>
    </tr>

    <tr class="answer">
        <td valign="top" ><img src="../image/bbs/icon_a.png" alt="답변" class="mt10" /></td>
        <td colspan="2" class="tl">
            <div>슈퍼패스는 원하는 제품 체험단에 우선적으로 선정 가능한 티켓으로 선정 기준에 따라 매 월 첫 번째 로그인 시 부여되며, 매월 마지막날 소멸됩니다.</div>
        </td>
    </tr>

    <tr class="q" style="background: #f5f5f5;">
        <td><img src="../image/bbs/icon_q.png" alt="질문" /></td>
        <td class="tl"><a href="#"></a></td>
        <td></td>
    </tr>
    <tr class="answer">
        <td valign="top" ><img src="../image/bbs/icon_a.png" alt="답변" class="mt10" /></td>
        <td colspan="2" class="tl">
            <div>체험단에 선정되시면, 아래 경로로 가이드라인을 다운 받아보실 수 있습니다. <br/>체험단 - [콘텐츠 가이드] - [가이드라인 다운로드]</div>
        </td>
    </tr>                        
    <tr class="q" style="background: #f5f5f5;">
        <td><img src="../image/bbs/icon_q.png" alt="질문" /></td>
        <td class="tl"><a href="#"></a></td>
        <td></td>
    </tr>
    <tr class="answer">
        <td valign="top" ><img src="../image/bbs/icon_a.png" alt="답변" class="mt10" /></td>
        <td colspan="2" class="tl">
            <div>애경 서포터즈 AK LOVER 활동을 통해 적립된 포인트로 애경 제품을 교환 할 수 있는 축제입니다. 포인트 축제는 게릴라 성으로 불시에 진행될 예정입니다. 많은 기대 부탁드립니다.</div>
        </td>
    </tr>
    <!-- 필독 영역 끝 -->
</table>