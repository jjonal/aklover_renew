<link rel="stylesheet" type="text/css" href="/css/front/cscenter.css" />
<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)2013년 08월 07일
######################################################################################################################################################
if(!defined('_HEROBOARD_'))exit;
######################################################################################################################################################
$view_check = false;
$view_new = false;

if(!strcmp($_SESSION['temp_level'], '')){
    $my_level = '0';
}else{
    $my_level = $_SESSION['temp_level'];
}

if($_GET['view_type'] == "list") $view_check = true;
if($_GET['view'] == "view_new") $view_new = true;

if(!strcmp($my_level,'0') && $view_check){
    msg('로그인해주시기 바랍니다.','location.href="'.PATH_HOME.'?board=login"');
    exit;
}
$cut_count_name = '6';
$cut_title_name = '34';
$board = 'cus_3';

$gubun_arr = array("1"=>"체험단 문의","2"=>"체험단 후기수정","3"=>"홈페이지 문의",
    "111"=>"선정 취소 요청", "112"=>"체험 제품 변경 요청",
    "121"=>"[배송] 배송 확인 요청", "122"=>"[배송] 제품 확인 요청", "123"=>"[배송] 제품 회수 요청", "124"=>"[배송] 제품 파손 신고",
    "131"=>"홈페이지 후기 등록 방법 문의", "132"=>"후기 등록 기간 연장 문의", "133"=>"수정후기 전달", "134"=>"가이드라인 관련 문의", "135"=>"공정위배너/문구 문의",
    "141"=>"슈퍼패스 문의",
    "151"=>"패널티 문",
    "211"=>"이벤트 당첨 문의", "212"=>"이벤트 당첨 제품 문의",
    "221"=>"[배송] 배송 확인 요청", "222"=>"[배송] 제품 확인 요청", "223"=>"[배송] 제품 회수 요청", "224"=>"[배송] 제품 파손 신고","225"=>"[누락] 제품 누락 신고",
    "311"=>"서비스 개선/오류 문의", "312"=>"개인정보/이용방법 문의", "313"=>"부정회원 신고", "314"=>"기타 문의",
    "4"=>"기타");

######################################################################################################################################################
if(strcmp($_POST['kewyword'], '')){
    $search = ' and '.$_POST['select'].' like \'%'.$_POST['kewyword'].'%\'';
    $search_next = '&select='.$_POST['select'].'&kewyword='.$_POST['kewyword'];
}else if(strcmp($_GET['kewyword'], '')){
    $search = ' and '.$_GET['select'].' like \'%'.$_GET['kewyword'].'%\'';
    $search_next = '&select='.$_GET['select'].'&kewyword='.$_GET['kewyword'];
}

if($_GET["gubun"]) {
    $search .= " AND gubun = '".$_GET["gubun"]."' ";
    $search_next .= "&gubun=".$_GET["gubun"];
}

######################################################################################################################################################
$sql = 'select * from board where hero_code=\''.$_SESSION['temp_code'].'\' and hero_table=\''.$board.'\''.$search.' order by hero_notice desc, hero_idx desc;';
sql($sql);
$total_data = @mysql_num_rows($out_sql);
######################################################################################################################################################
$list_page=8;
$page_per_list=10;
if(!strcmp($_GET['page'], '')){$page = '1';}else{$page = $_GET['page'];}
$start = ($page-1)*$list_page;
$next_path="board=".$_GET['board']."&view_type=list".$search_next;
######################################################################################################################################################
$sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';
sql($sql);
$right_list                             = @mysql_fetch_assoc($out_sql);
?>

<div id="subpage" class="cscenter">
    <div class="sub_title">
        <div class="sub_wrap">
            <div class="f_b">
                <h1 class="fz68 fw600 main_c">고객센터</h1>
            </div>
        </div>
    </div>
    <div class="sub_cont inquiry">
        <div class="sub_wrap board_wrap f_sb">
            <div class="left">
                <ul class="sub_menu">
                    <li><a href="/main/index.php?board=group_04_03">공지사항 <img src="/img/front/icon/bread.webp" alt="공지사항 바로가기"></a></li>
                    <li><a href="/main/index.php?board=group_04_33">FAQ <img src="/img/front/icon/bread.webp" alt="FAQ 바로가기"></a></li>
                    <li class="on"><a href="/main/index.php?board=group_04_35&view_type=list">1:1 문의 <img src="/img/front/icon/bread.webp" alt="1:1 문의 바로가기"></a></li>
                </ul>
                <div class="caution">
                    <h3 class="fz20 fw600">안내/유의사항</h3>
                    <div>
                        <div class="f_fs">
                            <img src="/img/front/icon/caution.webp" alt="안내/유의사항">
                            <p class="fz14">
                                AK Lover 활동 및 운영에 대해서는 공지사항을 확인해주세요!<br />
                                그 외 궁금하신 사항은 FAQ를 확인하거나, 1:1 문의를 남겨주세요!                            
                            </p>
                        </div>
                        <span class="info">
                            문의전화 : 080-024-1357 (수신자부담)<br>
                            상담시간 : 평일 9시~18시 (토, 일, 법정 공휴일 제외)
                        </span>
                    </div>
                </div>
            </div>
            <!--1:1문의의 팝업창-->
            <? if($view_check) { ?>
                <div class="contents right">
                    <div class="cont_top">
                        <h2 class="fz32 fw600">1:1 문의</h2>
                    </div>
                    <table>
                        <colgroup>
                            <col width="120px" />
                            <col width="150px" />
                            <col width="*" />
                            <col width="120px" />
                            <col width="160px" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="first">번호</th>
                                <th>카테고리</th>
                                <th>제목</th>
                                <!--!!!!!!!! [개발요청] 답변여부 기존에 없던 내용이라 개발 필요합니다[완] !!!!!!!!  -->
                                <th>답변여부</th>
                                <th class="last">문의 일자</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                                $sql = 'SELECT A.*, B.hero_nick AS nick 
                                        FROM board A
                                        LEFT JOIN member B
                                        ON A.hero_code = B.hero_code
                                        WHERE A.hero_code=\''.$_SESSION['temp_code'].'\' AND A.hero_table=\''.$board.'\''.$search.' 
                                        ORDER BY A.hero_idx DESC 
                                        LIMIT '.$start.','.$list_page.';';
                                sql($sql);
                                $i=0;
                                if($total_data > 0) {
                                while($list                             = @mysql_fetch_assoc($out_sql)){
                                $num=$total_data - $start-$i;
                                $i++;
                            ?>
                            <tr<?if(!strcmp($list['hero_notice'], '1')){?> class="notice"<?}?>>
                                <td><?=$num?></td>
                                <td class="color_<?=$list['gubun'];?>"><?=$gubun_arr[$list['gubun']]?></td>
                                <td class="t_l">
                                    <a href="<?=PATH_HOME;?>?board=<?=$_GET['board']?>&page=<?=$page?>&view=view_new&idx=<?=$list['hero_idx'];?>"><?=cut($list['hero_title'], $cut_title_name);?></a> <strong></strong>
                                </td>
                                <!--!!!!!!!! [개발요청] 답변여부 기존에 없던 내용이라 개발 필요합니다 [완]!!!!!!!!  -->
                                <!--!!!!!!!! 완료!!!!!!!!  -->
                                <td>
                                    <?if(!$list['hero_10']) {?>
                                        <img src="/img/front/board/no.webp" alt="답변대기">
                                    <?}
                                    else
                                    { ?>
                                        <img src="/img/front/board/yes.webp" alt="답변완료">
                                    <?}?>
                                </td>
                                <td>
                                    <?=date( "Y.m.d", strtotime($list['hero_today']));?><br />
                                    <?=date( "H:i:s", strtotime($list['hero_today']));?>
                                </td>
                            </tr>
                                <?}
                                } else {?>
                                <tr>
                                    <td colspan="5">등록된 데이터가 없습니다.</td>
                                </tr>
                            <?}?>
                        </tbody>
                    </table>
                    <div class="admin_btn">
                        <? include_once BOARD_INC_END.'button.php';?>
                    </div>
                </div>
                <!-- </div> -->

            <? } else { ?>

                <? if($view_new) { ?>

                <?
                        $today = date( "Y-m-d", time());
                        ######################################################################################################################################################
                        if(!strcmp($_SESSION['temp_level'], '')){
                            $my_level = '0';
                            $my_write = '0';
                            $my_view = '0';
                            $my_update = '0';
                            $my_rev = '0';
                        }else{
                            $my_level = $_SESSION['temp_level'];
                            $my_write = $_SESSION['temp_write'];
                            $my_view = $_SESSION['temp_view'];
                            $my_update = $_SESSION['temp_update'];
                            $my_rev = $_SESSION['temp_rev'];
                        }
                        ######################################################################################################################################################
                        $cut_title_name = '26';
                        if(!strcmp($_GET['next_board'],"hero")){
                            $hero_table = 'hero';
                        }else{
                            $hero_table = $_GET['board'];
                            if($hero_table == 'group_04_35') {
                                $hero_table = 'cus_3';
                            }
                        }
                        ######################################################################################################################################################
                        $sql = 'select * from hero_group where hero_order!=\'0\' and hero_use=\'1\' and hero_board =\''.$_GET['board'].'\';';//desc
                        sql($sql);
                        $right_list                             = @mysql_fetch_assoc($out_sql);
                        //권한
                        //if( ( ($right_list['hero_view'] >= $_SESSION['temp_level']) and (strcmp($_SESSION['temp_level'], '')) ) or (!strcmp($right_list['hero_view'], '99')) ){
                        if($right_list['hero_view'] <= $my_view){
                        ######################################################################################################################################################
                        $temp_id = $_SESSION['temp_id'];
                        $temp_code = $_SESSION['temp_code'];
                        $temp_top_title = $right_list['hero_title'];
                        $temp_title = $out_row['hero_title'];
                        $temp_point = $right_list['hero_view_point'];
                        $temp_idx = $_GET['idx'];

                        ######################################################################################################################################################
                        $sql = 'select a.*,b.hero_nick as nick, b.hero_profile, (select hero_nick from member where hero_code = a.hero_review) review_nick, (select hero_profile from member where hero_code = a.hero_review) review_profile from board a left join member b on a.hero_code = b.hero_code where a.hero_table = \''.$hero_table.'\' and a.hero_idx=\''.$_GET['idx'].'\';';
                        sql($sql, 'on');

                        $out_row = @mysql_fetch_assoc($out_sql);//mysql_fetch_row

                        if(empty($out_row['hero_profile'])){
                            $hero_profile = "/img/front/mypage/defalt.webp";
                        }else {
                            $hero_profile = $out_row['hero_profile'];
                        }

                        if(empty($out_row['review_profile'])){
                            $review_profile = "/img/front/mypage/defalt.webp";
                        }else {
                            $review_profile = $out_row['review_profile'];
                        }

                        $del_use_check = -1; //답변이 존재유무
                        if($out_row["hero_10"]) $del_use_check = 1;

                        if($out_row['hero_code'] != $_SESSION['temp_code']) {
                            msg('본인의 글만 확인 가능합니다.','location.href="'.PATH_HOME.'?board=group_04_35&view_type=list"');
                            exit;
                        }

//                        $gubun_arr = array("1"=>"체험단 문의","2"=>"체험단 후기수정","3"=>"홈페이지 문의",
//                            "111"=>"선정 취소 요청", "112"=>"체험 제품 변경 요청",
//                            "121"=>"[배송] 배송 확인 요청", "122"=>"[배송] 제품 확인 요청", "123"=>"[배송] 제품 회수 요청", "124"=>"[배송] 제품 파손 신고",
//                            "131"=>"홈페이지 후기 등록 방법 문의", "132"=>"후기 등록 기간 연장 문의", "133"=>"수정후기 전달", "134"=>"가이드라인 관련 문의", "135"=>"공정위배너/문구 문의",
//                            "141"=>"슈퍼패스 문의",
//                            "151"=>"패널티 문",
//                            "211"=>"이벤트 당첨 문의", "212"=>"이벤트 당첨 제품 문의",
//                            "221"=>"[배송] 배송 확인 요청", "222"=>"[배송] 제품 확인 요청", "223"=>"[배송] 제품 회수 요청", "224"=>"[배송] 제품 파손 신고","225"=>"[누락] 제품 누락 신고",
//                            "311"=>"서비스 개선/오류 문의", "312"=>"개인정보/이용방법 문의", "313"=>"부정회원 신고", "314"=>"기타 문의",
//                            "4"=>"기타");
                        ?>
                                <div class="contents right">
                                    <div class="cont_top">
                                        <h2 class="fz32 fw600">1:1문의</h2>
                                    </div>
                                    <div class="viewbox">
                                        <!-- 제목 -->
                                        <div class="t_l fz34 fw600 tit"><!--<?=$out_row['hero_title']?>-->
                                            <?=cut($out_row['hero_title'],48);?>
                                        </div>
                                        <div class="f_b writer">
                                            <div class="f_cs">
                                                <!--!!!!!!!! [개발요청] 질문자 프로필 이미지 노출[완]!!!!!!!!  -->
                                                <img src="<?=$hero_profile?>" alt="aklover" class="profile">
                                                <span class="fz16 gray07 nick"><?=$out_row['nick'];?></span>
                                                <span class="fz16 gray07"><?=$gubun_arr[$out_row['gubun']]?></span>
                                            </div>
                                            <div class="op05"><?=date( "Y.m.d h:i:s", strtotime($out_row['hero_today']));?></div>
                                        </div>
                                        <!-- 내용 -->
                                        <div class="cont">
                                            <div class="cont_inner textstyle">
                                                <?=htmlspecialchars_decode($out_row['hero_command']);?>
                                            </div>
                                            <!-- 첨부파일 -->
                                            <?if(strcmp($out_row['hero_board_two'], '')){?>
                                                <div class="file f_cs"><span class="fz18 fw500">첨부파일</span><a href="<?=FREEBEST_END?>download.php?hero=<?=$out_row['hero_board_one']?>&download=<?=$out_row['hero_board_two']?>" ><?=$out_row['hero_board_two'];?></a></div>
                                            <?}?>
                                        </div>
                                        <!-- 답변 -->
                                        <?if(strcmp($out_row['hero_10'], '')){?>
                                            <div class="replybox">
                                                <div class="cont_tit">
                                                    <!--!!!!!!!! [개발요청] 답변 제목 노출!!!!!!!!  -->
                                                    <!--!!!!!!!! 제목이 없습니다.!!!!!!!!  -->
                                                    <div class="t_l fz34 fw600 tit"><!--<?=$out_row['hero_title']?>-->
                                                        Re:"문의하신 내용에 대한 답변드립니다."
                                                    </div>
                                                    <div class="f_b writer">
                                                        <div class="f_cs">
                                                            <!--!!!!!!!! [개발요청] 답변자 프로필 이미지 노출[완]!!!!!!!!  -->
                                                            <img src="<?=$review_profile?>" alt="aklover" class="profile">
                                                            <!--!!!!!!!! [개발요청] 답변자 닉네임 노출[완]!!!!!!!!  -->
                                                            <span class="fz16 gray07 nick"><?=$out_row['review_nick']?></span>
                                                            <span class="fz16 gray07"><?=$gubun_arr[$out_row['gubun']]?></span>
                                                    </div>
                                                        <!--!!!!!!!! [개발요청] 답변 시간 노출[완]!!!!!!!!  -->
                                                        <div  class="op05"><?=$out_row['hero_review_day']?></div>
                                                    </div>
                                                </div>
                                                <div class="textstyle">
                                                    <?=nl2br($out_row['hero_10']);?>
                                                </div>
                                            </div>
                                        <?}?>
                                        <?
                                            include_once BOARD_INC_END.'button.php';
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?
                        }else{
                            if(!strcmp($my_level, '0')){
                                $msg = '권한이';
                                $action_href = PATH_HOME.'?board=login';
                            }else{
                                $msg = '권한이';
                                $action_href = PATH_HOME.'?'.get('view');
                            }
                            msg($msg.' 없습니다.','location.href="'.$action_href.'"');
                            exit;
                        }
                        ?>


                <? } else { ?>

                            <div class="contents right">
                                <!-- 탑 슬라이드 -->
                                <? include_once BOARD_INC_END.'top_slide.php';?>
                                <h1>고객센터</h1>
                                <div class="cs">
                                    <p class="titleBig">
                                        AK LOVER 회원분들의<br/>
                                        작은 목소리에도 귀 기울이겠습니다.
                                    </p>
                                    <div class="description">
                                        AK LOVER 활동 문의 및 제안사항은 1:1 문의를 통해 접수해 주시고,<br/>
                                        통화를 원하시는 경우, <em>고객센터(080-024-1357)</em>로 전화주시면 친절하게 상담해 드리겠습니다.
                                    </div>

                                    <div class="csInfo">
                                        <dl>
                                            <dt>문의전화</dt>
                                            <dd>080-024-1357 <span>(수신자부담)</span></dd>
                                        </dl>
                                        <dl>
                                            <dt>상담시간</dt>
                                            <dd>평일 9시~18시 <span>(토, 일, 법정 공휴일 제외)</span></dd>
                                        </dl>
                                        <div class="btnSection btngroup">
                                            <a href="/main/index.php?board=group_04_35&view_type=list" class="a_btn">1:1문의</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?} ?>
            <?} ?>
        </div>
    </div>
</div>