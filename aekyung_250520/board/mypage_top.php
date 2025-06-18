<?
######################################################################################################################################################
#회원 정보
$sql = "SELECT a.hero_oldday, b.hero_name, a.hero_nick, a.hero_profile, a.hero_blog_00, a.hero_blog_03, a.hero_blog_04, a.hero_level FROM member a, level b WHERE a.hero_level = b.hero_level and hero_code ='".$_SESSION['temp_code']."'";
sql($sql);
$member = @mysql_fetch_assoc($out_sql);
$hero_nick = $member['hero_nick'];
$level = $member['hero_level'];
if(empty($member['hero_profile'])){
    $hero_profile = "/img/front/mypage/defalt.webp";
}else {
    $hero_profile = $member['hero_profile'];
}
#회원등급
$hero_level = "";
$hero_icon = "";
if ($level == "9996"){
    $hero_level = "프리미어 뷰티";
    $hero_icon = '<img src="/img/front/icon/my_icon_beauty.png" style="width: 1.3rem;" alt="프리미어 뷰티 등급">';
}else if ($level == "9994"){
    $hero_level = "프리미어 라이프";
    $hero_icon = '<img src="/img/front/icon/my_icon_life.png" style="width: 1.3rem;" alt="프리미어 라이프 등급">';
}else {
    $hero_level = "베이직 서포터즈";
    $hero_icon = '<img src="/img/front/icon/my_icon.png" style="width: 2.5rem;" alt="베이직 등급">';
}
######################################################################################################################################################
#가용포인트
$user_total_sql = "select total_user_point, total_use_point, C.superpass_use, D.superpass_sum from ";
$user_total_sql .= "(select hero_code, sum(hero_point) as total_user_point from point where hero_code='".$_SESSION['temp_code']."') as A, ";
$user_total_sql .= "(select SUM(hero_order_point) as total_use_point from order_main where hero_code='".$_SESSION['temp_code']."' and hero_process!='".$_PROCESS_CANCEL."') as B, ";
$user_total_sql .= "(select count(*) as superpass_use from mission_review where hero_superpass='Y' and hero_code='".$_SESSION['temp_code']."' and hero_today <= '".date("Y-m-t")."' and hero_today >= '".date("Y-m-01")."') as C, ";
$user_total_sql .= "(select count(*) as superpass_sum from superpass where hero_code='".$_SESSION['temp_code']."' and hero_use_yn = 'N' and hero_endday > date_format(now(),'%Y-%m-%d 00:00:00')) as D"; //12월7일 시행

$out_user_total_sql = @mysql_query($user_total_sql);
$today_total_list   = @mysql_fetch_assoc($out_user_total_sql);
$today_total = $today_total_list['total_user_point'];
if($today_total=='') $today_total = 0;
$today_use_total = $today_total_list['total_user_point']-$today_total_list['total_use_point'];
######################################################################################################################################################
#안읽은 알림
$sql = 'select * from mail where hero_table= \'mail\' and ((hero_user=\'all\' and hero_today > \''.$member['hero_oldday'].'\') or CONCAT(\'||\', hero_user, \'||\') LIKE \'%||'.$_SESSION['temp_id'].'||%\') and IFNULL(hero_user_check,\'\') = \'\' order by hero_today desc;';
sql($sql);
$noReadMail = @mysql_num_rows($out_sql);
######################################################################################################################################################
#출석체크 확인
$regdate = date("Y-m-d"); //등록일 시간

$attend_sql = 'select max(hero_today) hero_today from point where hero_type = \'attendance\' and hero_code = \''.$_SESSION['temp_code'].'\' ';
$out_attend_sql = mysql_query($attend_sql);
$attend_list                             = @mysql_fetch_assoc($out_attend_sql);
######################################################################################################################################################
?>

<link rel="stylesheet" type="text/css" href="/css/front/cscenter.css" />
<link rel="stylesheet" type="text/css" href="/css/front/mypage.css" />
<script type="text/javascript" src="/js/musign/mypage.js"></script>
<div class="my_nav f_b">
    <div class="my_info f_b">        
        <div class="my_profile f_sc"> 
            <!-- [개발] 프로필 이미지 생성, 이미지 미리보기는 mypage.js에 작업해두었습니다[완] -->
            <a href="/main/index.php?board=infoauth" class="profile_img rel">
                <div class="image-preview"><img src="<?=$hero_profile?>" alt="프로필"></div>
            </a>
            <div class="my_support_wrap">
                <div class="my_support">
                    <ul class="f_c">
                        <li class="f_c">
                            <!-- 등급, 아이콘 -->
                            <?=$hero_icon?>
                            <?=$hero_level?>
                        </li>
                    </ul>
                </div>
                <div class="my_id">
                    <p><span class="fz28 fw600"><?=$hero_nick?></span> 님은</p>                    
                    <p><span class="fz28 fw600"><?=$hero_level?></span> 입니다.</p>
                </div>
            </div>
        </div>
        <div class="f_b">
            <div class="card_bx">
                <ul>
                    <li>
                        <p>
                            <img src="/img/front/mypage/my_point.webp" alt="아이콘" class="card_icon">나의 포인트
                        </p>
                            <!-- today_use_total 값은mypoint.php 에 있습니다!! -->
                        <a href="/main/index.php?board=mypoint" class="point">
                            <span><?=number_format($today_use_total)?> 포인트</span>
                            <img src="/img/front/main/tab_arr_right.webp" alt="바로가기" class="click_arr">
                        </a>
                    </li>
                    <li>
                        <p><img src="/img/front/mypage/my_check.webp" alt="아이콘" class="card_icon">출석체크</p>
                        <?
                        if(strpos($attend_list['hero_today'] , $regdate)!==false){
                            echo '<a href="/main/index.php?board=group_04_04">완료 <img src="/img/front/main/tab_arr_right.webp" alt="바로가기" class="click_arr"></a>';
                            // echo '<a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487">완료 <img src="/img/front/main/tab_arr_right.webp" alt="바로가기" class="click_arr"></a>';
                        } else {
                            echo '<a href="/main/index.php?board=group_04_04">미완료 <img src="/img/front/main/tab_arr_right.webp" alt="바로가기" class="click_arr"></a>';
                            // echo '<a href="/main/index.php?board=group_04_03&page=1&view=view&idx=443487">미완료 <img src="/img/front/main/tab_arr_right.webp" alt="바로가기" class="click_arr"></a>';
                        }
                        ?>
                    </li>
                    <li>
                        <p><img src="/img/front/mypage/my_alram.webp" alt="아이콘" class="card_icon">알림</p>
                        <a href="/main/index.php?board=mail"><span><?=$noReadMail?>통</span><img src="/img/front/main/tab_arr_right.webp" alt="바로가기" class="click_arr"></a>
                    </li>
                </ul>
            </div>  
            <div class="card_bx sns_card" onclick="location.href='/main/index.php?board=infoauth'">
                <ul>
                    <li>
                        <p><img src="/img/front/mypage/my_naver.webp" alt="아이콘"></p>
                        <!-- 계정연결 안되어 있을 경우 p tag class "none_sns" -->
                        <p class="<?=$member['hero_blog_00'] ==  '' ? 'none_sns' : ''?>">
                            <?if($member['hero_blog_00'] !=  ''){?>
                                <span><?=$member['hero_blog_00']?></span>
                            <?}else {?>
                                <span>네이버 블로그 계정을 기재해 주세요.</span>
                            <?}?>
                            <img src="/img/front/main/tab_arr_right.webp" alt="바로가기"  class="click_arr">
                        </p>
                    </li>
                    <li>
                        <p><img src="/img/front/mypage/my_insta.webp" alt="아이콘"></p>                     
                        <p class="<?=$member['hero_blog_04'] ==  '' ? 'none_sns' : ''?>">
                            <?if($member['hero_blog_04'] !=  ''){?>
                                <span><?=$member['hero_blog_04']?></span>
                            <?}else {?>
                                <span>인스타그램 계정을 기재해 주세요.</span>
                            <?}?>
                            <img src="/img/front/main/tab_arr_right.webp" alt="바로가기" class="click_arr">
                        </p>
                    </li>
                    <!-- [개발] 계정 연결된 경우 아이디 노출 -->
                    <li>
                        <p><img src="/img/front/mypage/my_youtube.webp" alt="아이콘"></p>
                        <p class="<?=$member['hero_blog_03'] ==  '' ? 'none_sns' : ''?>">
                            <?if($member['hero_blog_03'] !=  ''){?>
                                <span><?=$member['hero_blog_03']?></span>
                            <?}else {?>
                                <span>유튜브 계정을 기재해 주세요.</span>
                            <?}?>
                            <img src="/img/front/main/tab_arr_right.webp" alt="바로가기"  class="click_arr">
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="rel">
        <img src="/img/front/member/mypass.webp" alt="슈퍼패스이용권" class="open_pop">
        <div class="super_info">            
            <!-- superpass_ea 값은mypoint.php 에 있습니다!! 따로 가져오려니 복잡해서 그냥 두었습니다;;; -->
            <?
            $user_total_sql = "select total_user_point, total_use_point, C.superpass_use, D.superpass_sum from ";
            $user_total_sql .= "(select hero_code, sum(hero_point) as total_user_point from point where hero_code='".$_SESSION['temp_code']."') as A, ";
            $user_total_sql .= "(select SUM(hero_order_point) as total_use_point from order_main where hero_code='".$_SESSION['temp_code']."' and hero_process!='".$_PROCESS_CANCEL."') as B, ";
            $user_total_sql .= "(select count(*) as superpass_use from mission_review where hero_superpass='Y' and hero_code='".$_SESSION['temp_code']."' and hero_today <= '".date("Y-m-t")."' and hero_today >= '".date("Y-m-01")."') as C, ";
            $user_total_sql .= "(select count(*) as superpass_sum from superpass where hero_code='".$_SESSION['temp_code']."' and hero_use_yn = 'N' and hero_endday > date_format(now(),'%Y-%m-%d 00:00:00')) as D"; //12월7일 시행
            //echo $user_total_sql;

            $out_user_total_sql = @mysql_query($user_total_sql);
            $today_total_list = @mysql_fetch_assoc($out_user_total_sql);
            $today_total = $today_total_list['total_user_point'];
            if($today_total=='') $today_total = 0;
            $today_use_total = $today_total_list['total_user_point']-$today_total_list['total_use_point'];//

            $superpass_ea = $today_total_list['superpass_sum'];
            if($superpass_ea>0){ ?>
                <img src="/img/front/mypage/use.png" alt="사용 가능">
            <? }else{?>
                <img src="/img/front/mypage/unuse.png" alt="사용 불가능">
            <? }?>
        </div>
    </div>
</div>
<? include_once BOARD_INC_END.'superpass.php';?>

